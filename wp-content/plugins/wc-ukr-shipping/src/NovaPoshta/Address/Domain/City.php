<?php

declare(strict_types=1);

namespace kirillbdev\WCUkrShipping\NovaPoshta\Address\Domain;

if ( ! defined('ABSPATH')) {
    exit;
}

class City
{
    private string $ref;
    private string $name;

    public function __construct(string $ref, string $name)
    {
        $this->ref = $ref;
        $this->name = $name;
    }

    public function getRef(): string
    {
        return $this->ref;
    }

    public function getName(): string
    {
        return $this->name;
    }
}