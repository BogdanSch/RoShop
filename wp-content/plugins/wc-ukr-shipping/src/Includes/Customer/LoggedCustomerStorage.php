<?php

namespace kirillbdev\WCUkrShipping\Includes\Customer;

use kirillbdev\WCUkrShipping\Contracts\Customer\CustomerStorageInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class LoggedCustomerStorage implements CustomerStorageInterface
{
    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return get_user_meta(wc()->customer->get_id(), $key, true) ?: null;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function add(string $key, $value)
    {
        update_user_meta(wc()->customer->get_id(), $key, $value);
    }

    /**
     * @param string $key
     */
    public function remove(string $key): void
    {
        delete_user_meta(wc()->customer->get_id(), $key);
    }
}