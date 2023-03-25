<?php

namespace kirillbdev\WCUkrShipping\Contracts;

use kirillbdev\WCUkrShipping\Exceptions\NovaPoshtaAddressProviderException;
use kirillbdev\WCUkrShipping\Model\NovaPoshta\Area;
use kirillbdev\WCUkrShipping\Model\NovaPoshta\City;

if ( ! defined('ABSPATH')) {
    exit;
}

interface NovaPoshtaAddressProviderInterface
{
    /**
     * @return Area[]
     * @throws NovaPoshtaAddressProviderException
     */
    public function getAreas(): array;

    /**
     * @return City[]
     * @throws NovaPoshtaAddressProviderException
     */
    public function getCities(int $page, int $limit): array;

    /**
     * @throws NovaPoshtaAddressProviderException
     */
    public function getWarehouses(int $page, int $limit): array;
}