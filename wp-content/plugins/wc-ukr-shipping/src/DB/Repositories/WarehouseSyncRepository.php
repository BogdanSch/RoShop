<?php

namespace kirillbdev\WCUkrShipping\DB\Repositories;

if ( ! defined('ABSPATH')) {
    exit;
}

class WarehouseSyncRepository
{
    const STAGE_CITY = 'city';
    const STAGE_WAREHOUSE = 'warehouse';
    const STATUS_RUNNING = 'running';
    const STATUS_COMPLETE = 'complete';

    public function getLastSync(): array
    {
        return json_decode(get_option(WCUS_OPTION_LOADER_LAST_SYNC), true) ?: [
            'date' => '',
            'status' => '',
            'stage' => '',
            'page' => ''
        ];
    }

    public function updateStage(string $stage, int $page)
    {
        $lastSync = $this->getLastSync();
        $lastSync['status'] = self::STATUS_RUNNING;
        $lastSync['stage'] = $stage;
        $lastSync['page'] = $page;

        $this->updateLastSync($lastSync);
    }

    public function setCompleteSync()
    {
        $this->updateLastSync([
            'status' => self::STATUS_COMPLETE,
            'stage' => '',
            'page' => ''
        ]);
    }

    public function updateLastSync(array $data)
    {
        $data['date'] = date('d.m.Y H:i');
        update_option(WCUS_OPTION_LOADER_LAST_SYNC, json_encode($data));
    }
}