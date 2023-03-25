<?php

declare(strict_types=1);

namespace kirillbdev\WCUkrShipping\NovaPoshta;

use kirillbdev\WCUkrShipping\NovaPoshta\Address\AddressProviderInterface;
use kirillbdev\WCUkrShipping\NovaPoshta\Address\Domain\City;
use kirillbdev\WCUkrShipping\NovaPoshta\Address\Domain\SearchWarehousesResult;

if ( ! defined('ABSPATH')) {
    exit;
}

final class AddressModule
{
    private AddressProviderInterface $addressProvider;

    public function __construct()
    {
        $this->addressProvider = wcus_container()->make(AddressProviderInterface::class);
    }

    public function getDefaultCities(string $lang): array
    {
        return $this->addressProvider->getDefaultCities($lang);
    }

    /**
     * @return City[]
     */
    public function searchCities(string $query, string $lang): array
    {
        return $this->addressProvider->searchCities($query, $lang);
    }

    public function searchWarehouses(
        string $cityRef,
        string $query,
        string $lang,
        int $page
    ): ?SearchWarehousesResult {
        return $this->addressProvider->searchWarehouses($cityRef, $query, $lang, $page);
    }
}