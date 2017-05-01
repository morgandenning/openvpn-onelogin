<?php

namespace OneVPN\Libraries\OneLogin\Methods;

use GuzzleHttp\Client;
use OneVPN\Libraries\Config;
use OneVPN\Libraries\OneLogin\Interfaces\Method;
use OneVPN\Libraries\OneLogin\Response;
use OneVPN\Libraries\OneLogin\Exceptions\ApiException;

/**
 * Undocumented class
 */
class ApiToken implements Method {
    /**
     * 
     */
    protected const ENDPOINT_URL = 'https://api.us.onelogin.com/auth/oauth2/token';

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function request() {
        return self::handle(Response::fromGuzzle((new Client)->request('POST', self::ENDPOINT_URL, [
            'headers' => [
                'content-type' => 'application/json',
                'authorization' => 'client_id:' . Config::getOpt('client_id') . ',client_secret:' . Config::getOpt('client_secret')
            ],
            'json' => [
                'grant_type' => 'client_credentials'
            ],
            'http_errors' => false
        ])));
    }

    /**
     * Undocumented function
     *
     * @param Response $response
     * @return void
     */
    public static function handle(Response $response) {
        if (!$response->getJson()) {
            throw new ApiException('No response body received');
        }
        switch ($response->getStatusCode()) {
            case 200:
                return $response;
            default:
                throw new ApiException($response->getJson()->status->message, $response->getStatusCode());
        }
    }
}
