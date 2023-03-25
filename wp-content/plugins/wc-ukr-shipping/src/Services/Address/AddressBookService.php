<?php

namespace kirillbdev\WCUkrShipping\Services\Address;

use kirillbdev\WCUkrShipping\Contracts\NovaPoshtaAddressProviderInterface;
use kirillbdev\WCUkrShipping\DB\Repositories\AreaRepository;
use kirillbdev\WCUkrShipping\DB\Repositories\CityRepository;
use kirillbdev\WCUkrShipping\DB\Repositories\WarehouseRepository;
use kirillbdev\WCUkrShipping\DB\Repositories\WarehouseSyncRepository;
use kirillbdev\WCUkrShipping\Exceptions\NovaPoshtaAddressProviderException;
use kirillbdev\WCUkrShipping\Model\NovaPoshta\City;
use kirillbdev\WCUkrShipping\Model\NovaPoshta\Warehouse;

if ( ! defined('ABSPATH')) {
    exit;
}

class AddressBookService
{
    /**
     * @var NovaPoshtaAddressProviderInterface
     */
    private $addressProvider;

    /**
     * @var WarehouseSyncRepository
     */
    private $syncRepository;

    public function __construct(WarehouseSyncRepository $syncRepository)
    {
        $this->addressProvider = wcus_container()->make(NovaPoshtaAddressProviderInterface::class);
        $this->syncRepository = $syncRepository;
    }

    /**
     * @throws NovaPoshtaAddressProviderException
     */
    public function loadAreas()
    {
        /** @var AreaRepository $areaRepository */
        $areaRepository = wcus_container()->make(AreaRepository::class);
        $areas = $this->addressProvider->getAreas();
        $areaRepository->clearAreas();

        foreach ($areas as $area) {
            $areaRepository->insertArea($area);
        }
    }

    public function loadCities(int $page): int
    {
        // Hide error because Nova Poshta can send duplicate refs from api
        global $wpdb;
        $wpdb->hide_errors();

        /** @var CityRepository $cityRepository */
        $cityRepository = wcus_container()->make(CityRepository::class);
        $cities = $this->addressProvider->getCities($page, apply_filters('wcus_api_city_limit', 500));
        $this->syncRepository->updateStage(WarehouseSyncRepository::STAGE_CITY, $page);

        if ($page === 1) {
            $cityRepository->clearCities();
        }

        $cityRepository->deleteByRefs(array_map(function (City $city) {
            return $city->getRef();
        }, $cities));

        foreach ($cities as $city) {
            $cityRepository->insertCity($city);
        }

        return count($cities);
    }

    public function loadWarehouses(int $page): int
    {
        // Hide error because Nova Poshta can send duplicate refs from api
        global $wpdb;
        $wpdb->hide_errors();

        /** @var WarehouseRepository $warehouseRepository */
        $warehouseRepository = wcus_container()->make(WarehouseRepository::class);
        $warehouses = $this->addressProvider->getWarehouses($page, apply_filters('wcus_api_warehouse_limit', 500));
        $this->syncRepository->updateStage(WarehouseSyncRepository::STAGE_WAREHOUSE, $page);

        if ($page === 1) {
            $warehouseRepository->clearWarehouses();
        }

        $warehouseRepository->deleteByRefs(array_map(function (Warehouse $warehouse) {
            return $warehouse->getRef();
        }, $warehouses));

        foreach ($warehouses as $warehouse) {
            $warehouseRepository->insertWarehouse($warehouse);
        }

        if (count($warehouses) === 0) {
            $this->syncRepository->setCompleteSync();
        }

        return count($warehouses);
    }
}