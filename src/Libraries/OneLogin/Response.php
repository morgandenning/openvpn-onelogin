<?php

namespace OneVPN\Libraries\OneLogin;

use GuzzleHttp\Psr7; 

class Response extends Psr7\Response {

    protected $json;

    public function __construct($status, array $headers, $body, $version, $reason) {
        parent::__construct($status, $headers, $body, $version, $reason);
        $this->json = json_decode($this->getBody());
    }

    public static function fromGuzzle(Psr7\Response $response) {
        return new self($response->getStatusCode(), $response->getHeaders(), $response->getBody(), $response->getProtocolVersion(), $response->getReasonPhrase());
    }

    public function getJson() {
        return $this->json ?? false;
    }

    public function getData() {
        return $this->json->data ?? null;
    }

}
