<?php

declare(strict_types=1);

namespace kirillbdev\WCUkrShipping\NovaPoshta\Address\Domain;

if ( ! defined('ABSPATH')) {
    exit;
}

class Warehouse
{
    private string $ref;
    private string $name;
    private int $number;

    public function __construct(string $ref, string $name, int $number)
    {
        if ($number < 1) {
            throw new \DomainException("Param 'number' must be greater or equal 1");
        }

        $this->ref = $ref;
        $this->name = $name;
        $this->number = $number;
    }

    public function getRef(): string
    {
        return $this->ref;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNumber(): int
    {
        return $this->number;
    }
}