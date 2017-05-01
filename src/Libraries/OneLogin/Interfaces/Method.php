<?php

namespace OneVPN\Libraries\OneLogin\Interfaces;

use OneVPN\Libraries\OneLogin\Response;

/**
 * Undocumented interface
 */
interface Method {
    /**
     * Undocumented function
     *
     * @return void
     */
    public static function request();

    /**
     * Undocumented function
     *
     * @param Response $response
     * @return void
     */
    public static function handle(Response $response);
}
