<?php

namespace kirillbdev\WCUkrShipping\Includes\Address;

use kirillbdev\WCUkrShipping\Contracts\Address\WarehouseFinderInterface;
use kirillbdev\WCUkrShipping\DB\Repositories\WarehouseRepository;
use kirillbdev\WCUkrShipping\Dto\Address\WarehouseDto;
use kirillbdev\WCUkrShipping\Services\TranslateService;

if ( ! defined('ABSPATH')) {
    exit;
}

class RepositoryWarehouseFinder implements WarehouseFinderInterface
{
    /**
     * @var string|null
     */
    private $ref;

    public function __construct(?string $ref)
    {
        $this->ref = $ref;
    }

    public function getWarehouse(): ?WarehouseDto
    {
        /** @var WarehouseRepository $warehouseRepository */
        $warehouseRepository = wcus_container()->make(WarehouseRepository::class);
        /** @var TranslateService $translateService */
        $translateService = wcus_container()->make(TranslateService::class);

        if ( ! $this->ref) {
            return null;
        }

        $warehouse = $warehouseRepository->getWarehouseByRef($this->ref);

        if ( ! $warehouse) {
            return null;
        }

        $dto = new WarehouseDto();
        $dto->ref = $this->ref;
        $dto->name = $translateService->translateWarehouse((array)$warehouse);

        return $dto;
    }
}