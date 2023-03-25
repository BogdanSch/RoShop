<?php

namespace kirillbdev\WCUkrShipping\Modules\Frontend;

use kirillbdev\WCUkrShipping\Http\Controllers\AddressController;
use kirillbdev\WCUSCore\Contracts\ModuleInterface;
use kirillbdev\WCUSCore\Http\Routing\Route;

if ( ! defined('ABSPATH')) {
    exit;
}

class Address implements ModuleInterface
{
    public function init()
    {
        // TODO: Implement init() method.
    }

    public function routes()
    {
        return [
            new Route('wcus_search_cities', AddressController::class,'searchCities', [
                'public' => true
            ]),
            new Route('wcus_search_warehouses', AddressController::class,'searchWarehouses', [
                'public' => true
            ])
        ];
    }
}