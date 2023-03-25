<?php

namespace kirillbdev\WCUkrShipping\DB\Repositories;

use kirillbdev\WCUkrShipping\DB\Dto\InsertCityDto;
use kirillbdev\WCUkrShipping\Model\NovaPoshta\City;
use kirillbdev\WCUSCore\Facades\DB;

if ( ! defined('ABSPATH')) {
    exit;
}

class CityRepository
{
    public function getCitiesByRefs($refs)
    {
        return DB::table(DB::prefixedTable('wc_ukr_shipping_np_cities'))
            ->whereIn('ref', $refs)
            ->get();
    }

    public function searchCitiesByQuery($query)
    {
        return DB::table(DB::prefixedTable('wc_ukr_shipping_np_cities'))
            ->whereLike('description', $query . '%')
            ->orWhereLike('description_ru', $query . '%')
            ->orderBy('description')
            ->get();
    }

    public function getCityByRef($ref)
    {
        return DB::table(DB::prefixedTable('wc_ukr_shipping_np_cities'))
            ->where('ref', $ref)
            ->first();
    }

    public function clearCities()
    {
        DB::table(DB::prefixedTable('wc_ukr_shipping_np_cities'))->truncate();
    }

    public function insertCity(City $city)
    {
        DB::table(DB::prefixedTable('wc_ukr_shipping_np_cities'))
            ->insert([
                'ref' => $city->getRef(),
                'description' => $city->getNameUa(),
                'description_ru' => $city->getNameRu(),
                'area_ref' => $city->getAreaRef()
            ]);
    }

    public function deleteByRefs(array $refs)
    {
        if ( ! $refs) {
            return;
        }

        global $wpdb;

        $inputs = '';

        for ($i = 0; $i < count($refs); $i++) {
            $inputs .= ($i > 0 ? ',' : '') . '%s';
        }

        $wpdb->query(
            $wpdb->prepare("delete from {$wpdb->prefix}wc_ukr_shipping_np_cities where ref in ($inputs)", $refs)
        );
    }
}