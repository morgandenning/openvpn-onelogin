<?php

namespace OneVPN\Libraries;

/**
 * Undocumented class
 */
class Config {
    /**
     * 
     */
    protected const CONFIG_KEY = 'onelogin';

    /**
     * Undocumented variable
     *
     * @var boolean
     */
    protected $configPath = false;
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected static $configInstance;

    /**
     * Undocumented function
     *
     * @param string $configPath
     */
    public function __construct(string $configPath = null) {
        $this->config = parse_ini_file($configPath ?? $this->configPath, true)[self::CONFIG_KEY];
    }

    /**
     * Undocumented function
     *
     * @param string $configPath
     * @return Config
     */
    protected static function getInstance(string $configPath = null) {
        if (!self::$configInstance) {
            self::$configInstance = new self($configPath);
        }

        return self::$configInstance;
    }

    /**
     * Undocumented function
     *
     * @param string $opt
     * @return string|null
     */
    public static function getOpt(string $opt = null) : ?string {
        $configInstance = self::getInstance(dirname(__DIR__) . '/environment');

        if (array_key_exists($opt, $configInstance->config)) {
            return $configInstance->config[$opt];
        } else return false;
    }

}
