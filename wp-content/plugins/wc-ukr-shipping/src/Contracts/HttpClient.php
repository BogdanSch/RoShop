<?php

namespace kirillbdev\WCUkrShipping\Contracts;

use kirillbdev\WCUkrShipping\Exceptions\ApiServiceException;

if ( ! defined('ABSPATH')) {
    exit;
}

interface HttpClient
{
    /**
     * @param string $url
     * @param mixed $body
     * @param array $headers
     *
     * @return mixed
     */
    public function get($url, $body = null, $headers = []);

    /**
     * @param string $url
     * @param mixed $body
     * @param array $headers
     *
     * @return mixed
     *
     * @throws ApiServiceException
     */
    public function post($url, $body = null, $headers = []);
}