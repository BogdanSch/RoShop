<?php

namespace kirillbdev\WCUkrShipping\Contracts\Address;

use kirillbdev\WCUkrShipping\Dto\Address\CityDto;

if ( ! defined('ABSPATH')) {
    exit;
}

interface CityFinderInterface
{
    public function getCity(): ?CityDto;
}