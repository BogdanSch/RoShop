<?php

declare(strict_types=1);

namespace kirillbdev\WCUkrShipping\NovaPoshta\Address\Domain;

if ( ! defined('ABSPATH')) {
    exit;
}

final class SearchWarehousesResult
{
    /**
     * @var Warehouse[]
     */
    private array $warehouses;

    private int $total;

    /**
     * @param Warehouse[] $warehouses
     * @param int $total
     */
    public function __construct(array $warehouses, int $total)
    {
        foreach ($warehouses as $warehouse) {
            if (!($warehouse instanceof Warehouse)) {
                throw new \DomainException("Param 'warehouses' must be array of " . Warehouse::class);
            }
        }

        if ($total < 0) {
            throw new \DomainException("Param 'total' must be greater or equal 0");
        }

        $this->warehouses = $warehouses;
        $this->total = $total;
    }

    /**
     * @return Warehouse[]
     */
    public function getWarehouses(): array
    {
        return $this->warehouses;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}