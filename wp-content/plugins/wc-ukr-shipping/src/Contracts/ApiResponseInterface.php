<?php

namespace kirillbdev\WCUkrShipping\Contracts;

if ( ! defined('ABSPATH')) {
    exit;
}

interface ApiResponseInterface
{
    /**
     * @return bool
     */
    public function hasErrors();
}