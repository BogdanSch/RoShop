<?php

namespace kirillbdev\WCUkrShipping\Modules\Backend;

use kirillbdev\WCUkrShipping\Foundation\State;
use kirillbdev\WCUkrShipping\Http\Controllers\AddressBookController;
use kirillbdev\WCUkrShipping\Http\Controllers\OptionsController;
use kirillbdev\WCUkrShipping\States\WarehouseLoaderState;
use kirillbdev\WCUSCore\Contracts\ModuleInterface;
use kirillbdev\WCUSCore\Foundation\View;
use kirillbdev\WCUSCore\Http\Routing\Route;

if ( ! defined('ABSPATH')) {
    exit;
}

class OptionsPage implements ModuleInterface
{
    public function init()
    {
        add_action('admin_menu', [$this, 'registerOptionsPage'], 99);
        add_filter('wcus_load_admin_i18n', [$this, 'registerTranslates']);
    }

    public function routes()
    {
        return [
            new Route('wcus_save_options', OptionsController::class, 'save'),
            new Route('wcus_load_areas', AddressBookController::class, 'loadAreas'),
            new Route('wcus_load_cities', AddressBookController::class, 'loadCities'),
            new Route('wcus_load_warehouses', AddressBookController::class, 'loadWarehouses')
        ];
    }

    public function registerOptionsPage()
    {
        State::add('warehouse_loader', WarehouseLoaderState::class);

        add_menu_page(
            wcus_i18n('Settings'),
            'WC Ukr Shipping',
            'manage_options',
            'wc_ukr_shipping_options',
            [$this, 'html'],
            WC_UKR_SHIPPING_PLUGIN_URL . 'image/menu-icon.png',
            56.15
        );
    }

    public function registerTranslates($i18n): array
    {
        return array_merge($i18n, [
            'warehouse_loader' => [
                'title' => wcus_i18n('Warehouses data of Nova Poshta'),
                'last_update' => wcus_i18n('Last update date:'),
                'status' => wcus_i18n('Status:'),
                'status_not_completed' => wcus_i18n('Not completed'),
                'status_completed' => wcus_i18n('Completed'),
                'status_unknown' => wcus_i18n('Unknown'),
                'update' => wcus_i18n('Update warehouses'),
                'continue' => wcus_i18n('Continue update'),
                'load_areas' => wcus_i18n('Load areas...'),
                'load_cities' => wcus_i18n('Load cities...'),
                'load_warehouses' => wcus_i18n('Load warehouses...'),
                'success_updated' => wcus_i18n('Warehouses db updated successfully'),
            ]
        ]);
    }

    public function html()
    {
        echo View::render('settings');
    }

    public function premiumHtml()
    {
        wp_redirect('https://kirillbdev.pro/wc-ukr-shipping-pro/?ref=plugin_menu', 301);
        exit;
    }
}