<?php

namespace kirillbdev\WCUkrShipping\Modules\Frontend;

use kirillbdev\WCUSCore\Contracts\ModuleInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class Cart implements ModuleInterface
{
    /**
     * Boot function
     *
     * @return void
     */
    public function init()
    {
        add_filter('woocommerce_shipping_rate_cost', [ $this, 'shippingCost' ], 15, 2);
    }

    /**
     * @param float $cost
     * @param \WC_Shipping_Rate $rate
     *
     * @return float|int
     */
    public function shippingCost($cost, $rate)
    {
        if (WC_UKR_SHIPPING_NP_SHIPPING_NAME !== $rate->get_method_id()) {
            return $cost;
        }

        if ( ! is_cart()) {
            return $cost;
        }

        return (float)wc_ukr_shipping_get_option('wc_ukr_shipping_np_price');
    }
}