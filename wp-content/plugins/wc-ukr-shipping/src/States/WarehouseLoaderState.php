<?php

namespace kirillbdev\WCUkrShipping\States;

use kirillbdev\WCUkrShipping\DB\Repositories\WarehouseSyncRepository;
use kirillbdev\WCUkrShipping\Includes\AppState;

if ( ! defined('ABSPATH')) {
    exit;
}

class WarehouseLoaderState extends AppState
{
    /**
     * @var WarehouseSyncRepository
     */
    private $syncRepository;

    public function __construct(WarehouseSyncRepository $syncRepository)
    {
        $this->syncRepository = $syncRepository;
    }

    protected function getState(): array
    {
        return [
            'last_sync' => $this->syncRepository->getLastSync()
        ];
    }
}