<?php

namespace kirillbdev\WCUkrShipping\DB\Repositories;

use kirillbdev\WCUkrShipping\Model\NovaPoshta\Area;
use kirillbdev\WCUSCore\Facades\DB;

if ( ! defined('ABSPATH')) {
    exit;
}

class AreaRepository
{
    public function clearAreas()
    {
        DB::table(DB::prefixedTable('wc_ukr_shipping_np_areas'))->truncate();
    }

    public function insertArea(Area $area)
    {
        DB::table(DB::prefixedTable('wc_ukr_shipping_np_areas'))->insert([
            'ref' => $area->getRef(),
            'description' => $area->getNameUa()
        ]);
    }
}