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
class Users implements Method {
    /**
     * 
     */
    protected const ENDPOINT_URL = 'https://api.us.onelogin.com/api/1/users';

    /**
     * Undocumented function
     *
     * @param string $apiToken
     * @param int $userId
     * @return void
     */
    public static function getRoles(string $apiToken = null, int $userId = null) {
        return self::handle(self::request($apiToken, "/{$userId}/roles"));
    }

    /**
     * Undocumented function
     *
     * @param string $apiToken
     * @param string $path
     * @return void
     */
    public static function request(string $apiToken = null, string $path = null) {
        return Response::fromGuzzle((new Client)->request('GET', self::ENDPOINT_URL . $path, [
            'headers' => [
                'content-type' => 'application/json',
                'authorization' => "bearer:{$apiToken}"
            ],
            'http_errors' => false
        ]));
    }

    /**
     * Undocumented function
     *
     * @param Response $response
     * @return void
     */
    public static function handle(Response $response) {
        switch ($response->getStatusCode()) {
            case 200:
                return $response->getJson();
            default:
                throw new ApiException($response->getJson()->status->message, $response->getStatusCode());
        }
    }
}
