<?php

namespace kirillbdev\WCUkrShipping\Foundation;

use kirillbdev\WCUkrShipping\Includes\AppState;

if ( ! defined('ABSPATH')) {
    exit;
}

final class State
{
    private static $state = [];

    public static function add(string $key, string $stateClass, array $params = []): void
    {
        /** @var AppState $state */
        $state = wcus_container()->make($stateClass);
        $state->bindParams($params);

        self::$state[$key] = $state;
    }

    public static function all(): array
    {
        return self::$state;
    }
}