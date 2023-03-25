<?php

declare(strict_types=1);

namespace kirillbdev\WCUkrShipping\Http\Controllers;

use kirillbdev\WCUkrShipping\NovaPoshta\Address\Domain\City;
use kirillbdev\WCUkrShipping\NovaPoshta\Address\Domain\Warehouse;
use kirillbdev\WCUkrShipping\NovaPoshta\AddressModule;
use kirillbdev\WCUSCore\Http\Controller;
use kirillbdev\WCUSCore\Http\Request;

if ( ! defined('ABSPATH')) {
    exit;
}

class AddressController extends Controller
{
    private AddressModule $novaPoshtaAddressModule;

    public function __construct(AddressModule $novaPoshtaAddressModule)
    {
        $this->novaPoshtaAddressModule = $novaPoshtaAddressModule;
    }

    public function searchCities(Request $request)
    {
        if (!$request->get('query') || !$request->get('lang')) {
            return $this->jsonResponse([
                'success' => true,
                'data' => []
            ]);
        }

        return $this->jsonResponse([
            'success' => true,
            'data' => $this->mapCities(
                $this->novaPoshtaAddressModule->searchCities(
                    $request->get('query'),
                    $request->get('lang')
                )
            )
        ]);
    }

    public function searchWarehouses(Request $request)
    {
        if (
            !$request->get('city_ref')
            || (int)$request->get('page') < 1
            || !$request->get('lang')
        ) {
            return $this->jsonResponse([
                'success' => true,
                'data' => [
                    'items' => [],
                    'more' => false
                ]
            ]);
        }

        $result = $this->novaPoshtaAddressModule->searchWarehouses(
            $request->get('city_ref'),
            $request->get('query', ''),
            $request->get('lang'),
            (int)$request->get('page')
        );

        if ($result === null) {
            return $this->jsonResponse([
                'success' => true,
                'data' => [
                    'items' => [],
                    'more' => false
                ]
            ]);
        }

        $items = $this->mapWarehouses($result->getWarehouses());
        $offset = (int)$request->get('page') * 20;

        return $this->jsonResponse([
            'success' => true,
            'data' => [
                'items' => $items,
                'more' => $offset < $result->getTotal()
            ]
        ]);
    }

    /**
     * @param City[] $cities
     */
    private function mapCities(array $cities): array
    {
        return array_map(function (City $city) {
            return [
                'value' => $city->getRef(),
                'name' => $city->getName()
            ];
        }, $cities);
    }

    /**
     * @param Warehouse[] $warehouses
     */
    private function mapWarehouses(array $warehouses): array
    {
        return array_map(function (Warehouse $city) {
            return [
                'value' => $city->getRef(),
                'name' => $city->getName()
            ];
        }, $warehouses);
    }
}