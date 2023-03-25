<?php

namespace kirillbdev\WCUkrShipping\DB\Migrations;

use kirillbdev\WCUSCore\DB\Migration;

if ( ! defined('ABSPATH')) {
    exit;
}

/**
 * This migration is similar to pro version but has another name
 * Pro version will override current migration and apply prefix only for additional legacy tables
 */
class AddWpPrefixLite extends Migration
{
    /**
     * @return string
     */
    public function name()
    {
        return 'add_wp_prefix_lite';
    }

    /**
     * @param \wpdb $db
     *
     * @return void
     */
    public function up($db)
    {
        $tableMap = [
            'wc_ukr_shipping_np_areas' => "{$db->prefix}wc_ukr_shipping_np_areas",
            'wc_ukr_shipping_np_cities' => "{$db->prefix}wc_ukr_shipping_np_cities",
            'wc_ukr_shipping_np_warehouses' => "{$db->prefix}wc_ukr_shipping_np_warehouses",
        ];

        $showErrors = $db->show_errors;
        $db->hide_errors();
        $tables = $db->get_col("SHOW TABLES");
        $renameList = [];

        foreach ($tableMap as $from => $to) {
            if (in_array($from, $tables, true) && !in_array($to, $tables, true)) {
                $renameList[] = "$from TO $to";
            }
        }

        if (count($renameList) > 0) {
            $db->query('RENAME TABLE ' . implode(', ', $renameList));
        }

        $db->show_errors($showErrors);
    }
}