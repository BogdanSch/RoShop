<?php

namespace kirillbdev\WCUkrShipping\Services;

use kirillbdev\WCUkrShipping\Contracts\OrderDataInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class CalculationService
{
    /**
     * Cache result of calculation.
     *
     * @var float
     */
    private $cost;

    /**
     * @param OrderDataInterface $orderData
     *
     * @return float
     */
    public function calculateCost($orderData)
    {
        if (null !== $this->cost) {
            return $this->cost;
        }

        $cost = (float)get_option('wc_ukr_shipping_np_price', 0);
        $this->cost = apply_filters('wcus_calculate_shipping_cost', $cost, $orderData);

        return (float)$this->cost;
    }
}