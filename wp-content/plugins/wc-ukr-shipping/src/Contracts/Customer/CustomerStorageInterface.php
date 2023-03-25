<?php

namespace kirillbdev\WCUkrShipping\Contracts\Customer;

if ( ! defined('ABSPATH')) {
    exit;
}

interface CustomerStorageInterface
{
    const KEY_LAST_CITY_REF = 'wcus_last_city_ref';
    const KEY_LAST_WAREHOUSE_REF = 'wcus_last_warehouse_ref';

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key);

    /**
     * @param string $key
     * @param mixed $value
     */
    public function add(string $key, $value);

    /**
     * @param string $key
     */
    public function remove(string $key): void;
}