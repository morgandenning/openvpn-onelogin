<?php

namespace OneVPN;

use OneVPN\Libraries\OneLogin\ApiConnector;
use OneVPN\Libraries\OneLogin\Exceptions\{ApiException, AuthorizationException};

/**
 * Undocumented class
 */
class Authorize {
    /**
     * 
     */
    public const MFA_AUTH_REQUIRED = true;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected static $authArgs;

    /**
     * Undocumented function
     *
     * @param array $args
     */
    public function __construct(array $args = []) {
        try {
            $this->parseAuthArgs($args);

            (new ApiConnector)->login(self::$authArgs->getUsername(), self::$authArgs->getPassword());
            exit(0);
        } catch (AuthorizationException | ApiException $e) {
            error_log('auth exception');
            error_log($e->getMessage());
            exit(1);
        }
    }

    /**
     * Undocumented function
     *
     * @param array $args
     * @return void
     */
    private function validateArgs(array $args = []) : void {
        if (!isset($args[1]) || !file_exists($args[1])) {
            throw new AuthorizationException("Invalid Arguments Provided");
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function getAuthArgs() {
        return self::$authArgs;
    }

    /**
     * Undocumented function
     *
     * @param array $args
     * @return void
     */
    private function parseAuthArgs(array $args) : void {
        try {
            $authArgs = [
                getenv('username') ?? false,
                getenv('password') ?? false
            ];
            
            if ($authArgs[0] === false && $authArgs[1] === false) {
                $authArgs = file($args[1], FILE_IGNORE_NEW_LINES);
            }
        } catch (\Exception $e) {
            throw AuthorizationException($e->getMessage());
        }

        if (count($authArgs) <> 2) {
            throw new AuthorizationException("Unable to load login credentials from OpenVPN");
        }

        if (self::MFA_AUTH_REQUIRED === true) {
            if (preg_match('/(\-[0-9]+)$/', $authArgs[1], $matches)) {
                $this->setAuthArgs($authArgs, $matches);
            } else {
                throw new AuthorizationException("No MFA Token Provided");
            }
        } else {
            $this->setAuthArgs($authArgs, null);
        }
    }

    /**
     * Undocumented function
     *
     * @param array $authArgs
     * @param array|null $matches
     * @return void
     */
    private function setAuthArgs(array $authArgs, ?array $matches = null) : void {
        self::$authArgs = new class($authArgs, $matches) {
            protected $username = null;
            protected $password = null;
            protected $mfaCode = null;

            function __construct(array $authArgs, ?array $matches = null) {
                $this->username = $authArgs[0];

                if ($matches) {
                    $this->password = str_replace($matches[0], '', $authArgs[1]);
                    $this->mfaCode = ltrim($matches[0], '-');
                } else {
                    $this->password = $authArgs[1];
                }
            }

            public function getUsername() {
                return $this->username;
            }
            public function getPassword() {
                return $this->password;
            }
            public function getMFACode() {
                return $this->mfaCode;
            }
        };
    }
}
