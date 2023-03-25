<?php

namespace kirillbdev\WCUkrShipping\Contracts\Address;

use kirillbdev\WCUkrShipping\Dto\Address\WarehouseDto;

if ( ! defined('ABSPATH')) {
    exit;
}

interface WarehouseFinderInterface
{
    public function getWarehouse(): ?WarehouseDto;
}