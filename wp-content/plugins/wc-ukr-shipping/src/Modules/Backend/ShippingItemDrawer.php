<?php

namespace kirillbdev\WCUkrShipping\Modules\Backend;

use kirillbdev\WCUSCore\Contracts\ModuleInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class ShippingItemDrawer implements ModuleInterface
{
    /**
     * Boot function
     */
    public function init()
    {
        add_filter('woocommerce_hidden_order_itemmeta', [$this, 'hideShippingMeta']);
    }

    public function hideShippingMeta(array $keys): array
    {
        return array_merge($keys, [
            'wcus_area_ref',
            'wcus_city_ref',
            'wcus_warehouse_ref',
            'wcus_address'
        ]);
    }
}
