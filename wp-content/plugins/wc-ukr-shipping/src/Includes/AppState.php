<?php

namespace kirillbdev\WCUkrShipping\Includes;

if ( ! defined('ABSPATH')) {
    exit;
}

abstract class AppState implements \JsonSerializable
{
    /**
     * @var array
     */
    protected $params = [];

    /**
     * @return array
     */
    abstract protected function getState(): array;

    public function bindParams(array $params)
    {
        $this->params = $params;
    }

    public function jsonSerialize()
    {
        return $this->getState();
    }
}