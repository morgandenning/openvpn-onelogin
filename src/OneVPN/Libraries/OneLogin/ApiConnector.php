<?php

namespace OneVPN\Libraries\OneLogin;

/**
 * Undocumented class
 */
class ApiConnector {
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $apiToken;

    /**
     * Undocumented function
     */
    public function __construct() {
        $this->apiToken = Methods\ApiToken::request()->getData()[0]->access_token;
    }

    /**
     * Undocumented function
     *
     * @param string $username
     * @param string $password
     * @return void
     */
    public function login(string $username, string $password) {
        return Methods\SamlAssertion::handle(Methods\SamlAssertion::request($this->apiToken, $username, $password));
    }
}
