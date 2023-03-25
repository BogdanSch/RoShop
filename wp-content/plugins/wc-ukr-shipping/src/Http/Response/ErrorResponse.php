<?php

namespace kirillbdev\WCUkrShipping\Http\Response;

use kirillbdev\WCUkrShipping\Contracts\ApiResponseInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class ErrorResponse implements ApiResponseInterface, \JsonSerializable
{
    /**
     * @var array
     */
    private $errors;

    /**
     * @param array $response
     */
    public function __construct($response)
    {
        $this->errors = $response['errors'];
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return true;
    }

    public function jsonSerialize()
    {
        return [
            'success' => false,
            'data' => [
                'errors' => $this->errors
            ]
        ];
    }
}