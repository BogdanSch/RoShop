<?php

namespace kirillbdev\WCUkrShipping\Api;

use kirillbdev\WCUkrShipping\Contracts\HttpClient;
use kirillbdev\WCUkrShipping\Contracts\NovaPoshtaAddressProviderInterface;
use kirillbdev\WCUkrShipping\Exceptions\ApiServiceException;
use kirillbdev\WCUkrShipping\Exceptions\NovaPoshtaAddressProviderException;
use kirillbdev\WCUkrShipping\Http\WpHttpClient;
use kirillbdev\WCUkrShipping\Model\NovaPoshta\Area;
use kirillbdev\WCUkrShipping\Model\NovaPoshta\City;
use kirillbdev\WCUkrShipping\Model\NovaPoshta\Warehouse;

if ( ! defined('ABSPATH')) {
    exit;
}

class NovaPoshtaApi implements NovaPoshtaAddressProviderInterface
{
    /**
     * @var string
     */
    private $apiUrl = 'https://api.novaposhta.ua/v2.0/json/';

    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @var string
     */
    private $apiKey;

    public function __construct()
    {
        $this->client = wcus_container()->make(WpHttpClient::class);
        $this->apiKey = get_option('wc_ukr_shipping_np_api_key', '');
    }

    /**
     * @throws NovaPoshtaAddressProviderException
     */
    public function getAreas(): array
    {
        $data['modelName'] = 'Address';
        $data['calledMethod'] = 'getAreas';
        $data['apiKey'] = $this->apiKey;

        try {
            $response = $this->sendRequest($data);

            if ($response['success']) {
                return array_map(function (array $data) {
                    return new Area($data['Ref'], $data['DescriptionRu'], $data['Description']);
                }, $response['data']);
            }

            throw new NovaPoshtaAddressProviderException($response['errors'][0] ?? 'Unknown error');
        }
        catch (ApiServiceException $e) {
            throw new NovaPoshtaAddressProviderException($e->getMessage());
        }
    }

    /**
     * @throws NovaPoshtaAddressProviderException
     */
    public function getCities(int $page, int $limit): array
    {
        $data['modelName'] = 'Address';
        $data['calledMethod'] = 'getCities';
        $data['apiKey'] = $this->apiKey;
        $data['methodProperties'] = [
            'Page' => $page,
            'Limit' => $limit
        ];

        try {
            $response = $this->sendRequest($data);

            if ($response['success']) {
                return array_map(function (array $data) {
                    return new City(
                        $data['Ref'],
                        $data['Area'],
                        $data['DescriptionRu'],
                        $data['Description']
                    );
                }, $response['data']);
            }

            throw new NovaPoshtaAddressProviderException($response['errors'][0] ?? 'Unknown error');
        }
        catch (ApiServiceException $e) {
            throw new NovaPoshtaAddressProviderException($e->getMessage());
        }
    }

    /**
     * @throws NovaPoshtaAddressProviderException
     */
    public function getWarehouses(int $page, int $limit): array
    {
        $data['modelName'] = 'AddressGeneral';
        $data['calledMethod'] = 'getWarehouses';
        $data['apiKey'] = $this->apiKey;
        $data['methodProperties'] = [
            'Page' => $page,
            'Limit' => $limit
        ];

        try {
            $response = $this->sendRequest($data);

            if ($response['success']) {
                return array_map(function (array $data) {
                    return new Warehouse(
                        $data['Ref'],
                        $data['CityRef'],
                        $data['DescriptionRu'],
                        $data['Description'],
                        $data['Number'],
                        $this->getWarehouseType($data)
                    );
                }, $response['data']);
            }

            throw new NovaPoshtaAddressProviderException($response['errors'][0] ?? 'Unknown error');
        }
        catch (ApiServiceException $e) {
            throw new NovaPoshtaAddressProviderException($e->getMessage());
        }
    }

    /**
     * @param array $data
     * @return mixed
     *
     * @throws ApiServiceException
     */
    private function sendRequest($data)
    {
        $result = $this->client->post(
            $this->apiUrl,
            json_encode($data),
            [ 'Content-Type' => 'application/json' ]
        );

        return json_decode($result, true);
    }

    private function getWarehouseType(array $warehouse): int
    {
        if ($warehouse['TypeOfWarehouse'] === '9a68df70-0267-42a8-bb5c-37f427e36ee4') {
            return Warehouse::TYPE_CARGO;
        }

        if (strpos($warehouse['Description'], 'Поштомат') !== false) {
            return Warehouse::TYPE_POSHTOMAT;
        }

        return Warehouse::TYPE_REGULAR;
    }
}