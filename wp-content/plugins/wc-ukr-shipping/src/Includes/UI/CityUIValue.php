<?php

namespace kirillbdev\WCUkrShipping\Includes\UI;

use kirillbdev\WCUkrShipping\Contracts\Address\CityFinderInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class CityUIValue
{
    public static function fromFinder(CityFinderInterface $finder): array
    {
        $city = $finder->getCity();

        if ($city) {
            return [
                'value' => $city->ref,
                'name' => $city->name
            ];
        }

        return [
            'value' => '',
            'name' => ''
        ];
    }
}