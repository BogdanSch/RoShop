<?php

namespace kirillbdev\WCUkrShipping\States;

use kirillbdev\WCUkrShipping\Includes\AppState;
use kirillbdev\WCUkrShipping\Includes\Address\CheckoutFinder;
use kirillbdev\WCUkrShipping\Includes\UI\CityUIValue;
use kirillbdev\WCUkrShipping\Includes\UI\WarehouseUIValue;

if ( ! defined('ABSPATH')) {
    exit;
}

class CheckoutState extends AppState
{
    protected function getState(): array
    {
        $finder = new CheckoutFinder();

        return [
            'city' => CityUIValue::fromFinder($finder),
            'warehouse' => WarehouseUIValue::fromFinder($finder)
        ];
    }
}