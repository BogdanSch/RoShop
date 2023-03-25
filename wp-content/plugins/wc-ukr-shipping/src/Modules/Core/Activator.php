<?php

namespace kirillbdev\WCUkrShipping\Modules\Core;

use kirillbdev\WCUkrShipping\DB\Migrations\AddColumnWarehouseType;
use kirillbdev\WCUkrShipping\DB\Migrations\AddWpPrefixLite;
use kirillbdev\WCUSCore\Contracts\ModuleInterface;
use kirillbdev\WCUSCore\DB\Migrator;
use kirillbdev\WCUkrShipping\DB\Migrations\CreateAreasTable;
use kirillbdev\WCUkrShipping\DB\Migrations\CreateCitiesTable;
use kirillbdev\WCUkrShipping\DB\Migrations\CreateIndexes;
use kirillbdev\WCUkrShipping\DB\Migrations\CreateWarehousesTable;

if ( ! defined('ABSPATH')) {
    exit;
}

class Activator implements ModuleInterface
{
    /**
     * @var Migrator
     */
    private $migrator;

    public function __construct(Migrator $migrator)
    {
        $this->migrator = $migrator;
    }

    public function init()
    {
        add_action('plugins_loaded', [$this, 'activate']);
        register_activation_hook(WC_UKR_SHIPPING_PLUGIN_ENTRY, [$this, 'activate']);
    }

    public function activate()
    {
        $this->migrator->addMigration(new CreateAreasTable());
        $this->migrator->addMigration(new CreateCitiesTable());
        $this->migrator->addMigration(new CreateWarehousesTable());
        $this->migrator->addMigration(new CreateIndexes());
        $this->migrator->addMigration(new AddColumnWarehouseType());
        $this->migrator->addMigration(new AddWpPrefixLite());
        $this->migrator->run();
    }
}