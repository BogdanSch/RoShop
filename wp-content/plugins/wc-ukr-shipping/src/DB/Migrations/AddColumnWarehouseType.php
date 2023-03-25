<?php

namespace kirillbdev\WCUkrShipping\DB\Migrations;

use kirillbdev\WCUSCore\DB\Migration;

if ( ! defined('ABSPATH')) {
    exit;
}

class AddColumnWarehouseType extends Migration
{
    /**
     * @return string
     */
    public function name()
    {
        return 'add_column_warehouse_type';
    }

    /**
     * @param mixed $db
     *
     * @return void
     */
    public function up($db)
    {
        $db->query("
          ALTER TABLE wc_ukr_shipping_np_warehouses
          ADD COLUMN warehouse_type TINYINT UNSIGNED NOT NULL DEFAULT 0
        ");

        $db->query("
          CREATE INDEX warehouse_type_index
          ON wc_ukr_shipping_np_warehouses(warehouse_type)
        ");
    }
}