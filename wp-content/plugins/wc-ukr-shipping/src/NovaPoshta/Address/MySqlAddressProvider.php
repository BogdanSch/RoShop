<?php

declare(strict_types=1);

namespace kirillbdev\WCUkrShipping\NovaPoshta\Address;

use kirillbdev\WCUkrShipping\DB\Repositories\CityRepository;
use kirillbdev\WCUkrShipping\DB\Repositories\WarehouseRepository;
use kirillbdev\WCUkrShipping\NovaPoshta\Address\Domain\City;
use kirillbdev\WCUkrShipping\NovaPoshta\Address\Domain\SearchWarehousesResult;
use kirillbdev\WCUkrShipping\NovaPoshta\Address\Domain\Warehouse;
use kirillbdev\WCUkrShipping\Services\AddressService;
use kirillbdev\WCUkrShipping\Services\TranslateService;

if ( ! defined('ABSPATH')) {
    exit;
}

class MySqlAddressProvider implements AddressProviderInterface
{
    private AddressService $addressService;
    private CityRepository $cityRepository;
    private WarehouseRepository $warehouseRepository;
    private TranslateService $translateService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
        $this->cityRepository = new CityRepository();
        $this->warehouseRepository = new WarehouseRepository();
        $this->translateService = new TranslateService();
    }

    /**
     * @return City[]
     */
    public function getDefaultCities(string $lang): array
    {
        return array_map(function (array $data) {
            return new City($data['value'], $data['name']);
        }, $this->addressService->getDefaultCities());
    }

    /**
     * @return City[]
     */
    public function searchCities(string $query, string $lang): array
    {
        $cities = $this->cityRepository->searchCitiesByQuery($query);

        return array_map(function($item) {
            $key = 'uk' === $this->translateService->getCurrentLanguage()
                ? 'description'
                : 'description_ru';

            return new City($item['ref'], $item[$key]);
        }, $cities);
    }

    public function searchWarehouses(
        string $cityRef,
        string $query,
        string $lang,
        int $page
    ): ?SearchWarehousesResult {
        $warehouses = $this->warehouseRepository->searchByQuery($query, $cityRef, $page, 20);
        $warehouses = array_map(function($item) {
            $key = 'uk' === $this->translateService->getCurrentLanguage()
                ? 'description'
                : 'description_ru';

            return new Warehouse($item['ref'], $item[$key], (int)$item['number']);
        }, $warehouses);
        $total = $this->warehouseRepository->countByQuery($query, $cityRef);

        return new SearchWarehousesResult($warehouses, $total);
    }
}