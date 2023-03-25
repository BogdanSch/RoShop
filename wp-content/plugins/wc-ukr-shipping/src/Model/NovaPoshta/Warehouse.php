<?php

namespace kirillbdev\WCUkrShipping\Model\NovaPoshta;

if ( ! defined('ABSPATH')) {
    exit;
}

class Warehouse
{
    public const TYPE_REGULAR = 1;
    public const TYPE_CARGO = 2;
    public const TYPE_POSHTOMAT = 3;

    /**
     * @var string
     */
    private $ref;

    /**
     * @var string
     */
    private $cityRef;

    /**
     * @var string
     */
    private $nameUa;

    /**
     * @var string
     */
    private $nameRu;

    /**
     * @var int
     */
    private $number;

    /**
     * @var int
     */
    private $type;

    public function __construct(
        string $ref,
        string $cityRef,
        string $nameRu,
        string $nameUa,
        int $number,
        int $type
    ) {
        $this->ref = $ref;
        $this->cityRef = $cityRef;
        $this->nameRu = $nameRu;
        $this->nameUa = $nameUa;
        $this->number = $number;
        $this->type = $type;
    }

    public function getRef(): string
    {
        return $this->ref;
    }

    public function getCityRef(): string
    {
        return $this->cityRef;
    }

    public function getNameUa(): string
    {
        return $this->nameUa;
    }

    public function getNameRu(): string
    {
        return $this->nameRu;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getType(): int
    {
        return $this->type;
    }
}