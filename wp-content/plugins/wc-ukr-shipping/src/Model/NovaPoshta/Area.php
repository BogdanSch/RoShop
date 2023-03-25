<?php

namespace kirillbdev\WCUkrShipping\Model\NovaPoshta;

if ( ! defined('ABSPATH')) {
    exit;
}

class Area
{
    /**
     * @var string
     */
    private $ref;

    /**
     * @var string
     */
    private $nameUa;

    /**
     * @var string
     */
    private $nameRu;

    public function __construct(string $ref, string $nameRu, string $nameUa)
    {
        $this->ref = $ref;
        $this->nameRu = $nameRu;
        $this->nameUa = $nameUa;
    }

    public function getRef(): string
    {
        return $this->ref;
    }

    public function getNameUa(): string
    {
        return $this->nameUa;
    }

    public function getNameRu(): string
    {
        return $this->nameRu;
    }
}