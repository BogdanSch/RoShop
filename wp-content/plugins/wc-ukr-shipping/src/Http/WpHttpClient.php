<?php

namespace kirillbdev\WCUkrShipping\Http;

if ( ! defined('ABSPATH')) {
    exit;
}

use kirillbdev\WCUkrShipping\Contracts\HttpClient;
use kirillbdev\WCUkrShipping\Exceptions\ApiServiceException;

class WpHttpClient implements HttpClient
{
    public function get($url, $body = null, $headers = [])
    {
        $response = wp_remote_get($url, [
            'headers' => $headers,
            'timeout' => 30,
            'body' => $body
        ]);

        if (200 === wp_remote_retrieve_response_code($response)) {
            return wp_remote_retrieve_body($response);
        }

        return null;
    }

    /**
     * @param string $url
     * @param null $body
     * @param array $headers
     *
     * @return mixed
     *
     * @throws ApiServiceException
     */
    public function post($url, $body = null, $headers = [])
    {
        $response = wp_remote_post($url, [
            'headers' => $headers,
            'timeout' => apply_filters('wcus_http_post_timeout', 15),
            'body' => $body
        ]);

        if (is_wp_error($response)) {
            throw new ApiServiceException($response->get_error_message());
        }

        return $response['body'];
    }
}