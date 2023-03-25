<?php

namespace kirillbdev\WCUkrShipping\Exceptions;

if ( ! defined('ABSPATH')) {
    exit;
}

class ApiErrorException extends \Exception
{
    private $errors;

    public function __construct(array $errors)
    {
        parent::__construct();
        $this->errors = $errors;
    }

    public function getApiErrors(): array
    {
        return $this->errors;
    }
}