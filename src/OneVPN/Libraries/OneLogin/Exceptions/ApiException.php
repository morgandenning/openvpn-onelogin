<?php

namespace OneVPN\Libraries\OneLogin\Exceptions;

use Exception;

/**
 * Undocumented class
 */
class ApiException extends Exception {
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $statusCode;

    /**
     * Undocumented function
     *
     * @param [type] $message
     * @param [type] $statusCode
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($message, $statusCode = null, $code = 0, Exception $previous = null) {
        $this->statusCode = $statusCode;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getStatusCode() {
        return $this->statusCode;
    }
}
