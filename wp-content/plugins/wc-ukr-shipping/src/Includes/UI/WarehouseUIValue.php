<?php

namespace kirillbdev\WCUkrShipping\Includes\UI;

use kirillbdev\WCUkrShipping\Contracts\Address\WarehouseFinderInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class WarehouseUIValue
{
    public static function fromFinder(WarehouseFinderInterface $finder): array
    {
        $warehouse = $finder->getWarehouse();

        if ($warehouse) {
            return [
                'value' => $warehouse->ref,
                'name' => $warehouse->name
            ];
        }

        return [
            'value' => '',
            'name' => ''
        ];
    }
}