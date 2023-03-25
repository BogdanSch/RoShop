<?php

namespace kirillbdev\WCUkrShipping\Includes\Address;

use kirillbdev\WCUkrShipping\Contracts\Address\CityFinderInterface;
use kirillbdev\WCUkrShipping\Contracts\Address\WarehouseFinderInterface;
use kirillbdev\WCUkrShipping\Contracts\Customer\CustomerStorageInterface;
use kirillbdev\WCUkrShipping\Dto\Address\CityDto;
use kirillbdev\WCUkrShipping\Dto\Address\WarehouseDto;

if ( ! defined('ABSPATH')) {
    exit;
}

class CheckoutFinder implements CityFinderInterface, WarehouseFinderInterface
{
    /**
     * @var int
     */
    private $saveEnable;

    /**
     * @var CustomerStorageInterface
     */
    private $customerStorage;

    public function __construct()
    {
        $this->saveEnable = (int)get_option(WCUS_OPTION_SAVE_CUSTOMER_ADDRESS);
        $this->customerStorage = wcus_container()->make(CustomerStorageInterface::class);
    }

    public function getCity(): ?CityDto
    {
        if ($this->saveEnable) {
            $finder = new RepositoryCityFinder($this->customerStorage->get(CustomerStorageInterface::KEY_LAST_CITY_REF));

            return $finder->getCity();
        }

        return null;
    }

    public function getWarehouse(): ?WarehouseDto
    {
        if ($this->saveEnable) {
            $finder = new RepositoryWarehouseFinder($this->customerStorage->get(CustomerStorageInterface::KEY_LAST_WAREHOUSE_REF));

            return $finder->getWarehouse();
        }

        return null;
    }
}