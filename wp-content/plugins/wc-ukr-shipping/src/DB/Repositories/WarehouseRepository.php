<?php

namespace kirillbdev\WCUkrShipping\DB\Repositories;

use kirillbdev\WCUkrShipping\DB\Dto\InsertWarehouseDto;
use kirillbdev\WCUkrShipping\Model\NovaPoshta\Warehouse;
use kirillbdev\WCUSCore\Facades\DB;

if ( ! defined('ABSPATH')) {
    exit;
}

class WarehouseRepository
{
    /**
     * @param string $ref
     * @return \stdClass|null
     */
    public function getWarehouseByRef($ref)
    {
        return DB::table(DB::prefixedTable('wc_ukr_shipping_np_warehouses'))
            ->where('ref', $ref)
            ->first();
    }

    public function searchByQuery($query, $cityRef, $page = 1, $limit = 30)
    {
        $q = DB::table(DB::prefixedTable('wc_ukr_shipping_np_warehouses'))
            ->where('city_ref', $cityRef);

        if ($query) {
            $q->whereRaw('(description like %s or description_ru like %s)', [
                "%$query%",
                "%$query%"
            ]);
        }

        $q->orderBy('`number`');

        if ($page > 1) {
            $q->skip(($page - 1) * $limit);
        }

        return $q->limit($limit)->get();
    }

    /**
     * @param string $query
     * @param string $cityRef
     * @return int
     */
    public function countByQuery($query, $cityRef)
    {
        $q = DB::table(DB::prefixedTable('wc_ukr_shipping_np_warehouses'))
            ->where('city_ref', $cityRef);

        if ($query) {
            $q->whereRaw('(description like %s or description_ru like %s)', [
                "%$query%",
                "%$query%"
            ]);
        }

        return $q->count('ref');
    }

    public function clearWarehouses()
    {
        DB::table(DB::prefixedTable('wc_ukr_shipping_np_warehouses'))->truncate();
    }

    public function insertWarehouse(Warehouse $warehouse)
    {
        DB::table(DB::prefixedTable('wc_ukr_shipping_np_warehouses'))
            ->insert([
                'ref' => $warehouse->getRef(),
                'description' => $warehouse->getNameUa(),
                'description_ru' => $warehouse->getNameRu(),
                'city_ref' => $warehouse->getCityRef(),
                'number' => $warehouse->getNumber(),
                'warehouse_type' => $warehouse->getType()
            ], [
                'number' => '%d',
                'warehouse_type' => '%d'
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
            $wpdb->prepare("delete from {$wpdb->prefix}wc_ukr_shipping_np_warehouses where ref in ($inputs)", $refs)
        );
    }
}