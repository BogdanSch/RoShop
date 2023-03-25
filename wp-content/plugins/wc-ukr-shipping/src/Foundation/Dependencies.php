<?php

namespace kirillbdev\WCUkrShipping\Foundation;

use kirillbdev\WCUkrShipping\Api\NovaPoshtaApi;
use kirillbdev\WCUkrShipping\Contracts\Customer\CustomerStorageInterface;
use kirillbdev\WCUkrShipping\Contracts\NovaPoshtaAddressProviderInterface;
use kirillbdev\WCUkrShipping\Includes\Customer\LoggedCustomerStorage;
use kirillbdev\WCUkrShipping\Includes\Customer\SessionCustomerStorage;
use kirillbdev\WCUkrShipping\Modules\Core\Activator;
use kirillbdev\WCUkrShipping\NovaPoshta\Address\MySqlAddressProvider;
use kirillbdev\WCUSCore\DB\Migrator;
use kirillbdev\WCUkrShipping\NovaPoshta\Address\AddressProviderInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

final class Dependencies
{
    public static function all()
    {
        return [
            // Contracts
            CustomerStorageInterface::class => function ($container) {
                $customerId = wc()->customer->get_id();

                return $container->make($customerId ? LoggedCustomerStorage::class : SessionCustomerStorage::class);
            },
            NovaPoshtaAddressProviderInterface::class => function ($container) {
                return $container->make(NovaPoshtaApi::class);
            },
            AddressProviderInterface::class => function ($container) {
                return $container->make(MySqlAddressProvider::class);
            },
            // Modules
            Activator::class => function ($container) {
                return new Activator($container->make(Migrator::class));
            }
        ];
    }
}