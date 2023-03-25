<?php

namespace kirillbdev\WCUkrShipping\Includes\Customer;

use kirillbdev\WCUkrShipping\Contracts\Customer\CustomerStorageInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class SessionCustomerStorage implements CustomerStorageInterface
{
    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return wc()->session->get($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function add(string $key, $value)
    {
        wc()->session->set($key, $value);
    }

    /**
     * @param string $key
     */
    public function remove(string $key): void
    {
        wc()->session->set($key, '');
    }
}