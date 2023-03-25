<?php

declare(strict_types=1);

namespace kirillbdev\WCUkrShipping\NovaPoshta\Address;

use kirillbdev\WCUkrShipping\NovaPoshta\Address\Domain\City;
use kirillbdev\WCUkrShipping\NovaPoshta\Address\Domain\SearchWarehousesResult;

if ( ! defined('ABSPATH')) {
    exit;
}

interface AddressProviderInterface
{
    /**
     * @param string $lang
     * @return City[]
     */
    public function getDefaultCities(string $lang): array;

    /**
     * @param string $query
     * @param string $lang
     * @return City[]
     */
    public function searchCities(string $query, string $lang): array;

    public function searchWarehouses(
        string $cityRef,
        string $query,
        string $lang,
        int $page
    ): ?SearchWarehousesResult;
}