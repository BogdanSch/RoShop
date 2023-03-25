<?php

namespace kirillbdev\WCUkrShipping\Includes\Address;

use kirillbdev\WCUkrShipping\Contracts\Address\CityFinderInterface;
use kirillbdev\WCUkrShipping\DB\Repositories\CityRepository;
use kirillbdev\WCUkrShipping\Dto\Address\CityDto;
use kirillbdev\WCUkrShipping\Services\TranslateService;

if ( ! defined('ABSPATH')) {
    exit;
}

class RepositoryCityFinder implements CityFinderInterface
{
    /**
     * @var string|null
     */
    private $ref;

    public function __construct(?string $ref)
    {
        $this->ref = $ref;
    }

    public function getCity(): ?CityDto
    {
        /** @var CityRepository $cityRepository */
        $cityRepository = wcus_container()->make(CityRepository::class);
        /** @var TranslateService $translateService */
        $translateService = wcus_container()->make(TranslateService::class);

        if ( ! $this->ref) {
            return null;
        }

        $city = $cityRepository->getCityByRef($this->ref);

        if ( ! $city) {
            return null;
        }

        $dto = new CityDto();
        $dto->ref = $this->ref;
        $dto->name = $translateService->translateCity((array)$city);

        return $dto;
    }
}