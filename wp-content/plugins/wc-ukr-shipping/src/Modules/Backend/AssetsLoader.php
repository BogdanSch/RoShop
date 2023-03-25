<?php

namespace kirillbdev\WCUkrShipping\Modules\Backend;

use kirillbdev\WCUkrShipping\Foundation\State;
use kirillbdev\WCUkrShipping\Services\TranslateService;
use kirillbdev\WCUkrShipping\Traits\StateInitiatorTrait;
use kirillbdev\WCUSCore\Contracts\ModuleInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class AssetsLoader implements ModuleInterface
{
    use StateInitiatorTrait;

    private $translateService;

    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function init()
    {
        add_action('admin_enqueue_scripts', [$this, 'loadAdminAssets']);
        add_action('admin_head', [ $this, 'initState' ]);
    }

    public function loadAdminAssets()
    {
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style('wp-color-picker');

        wp_enqueue_style(
            'wc_ukr_shipping_admin_css',
            WC_UKR_SHIPPING_PLUGIN_URL . 'assets/css/admin.min.css',
            [],
            filemtime(WC_UKR_SHIPPING_PLUGIN_DIR . 'assets/css/admin.min.css')
        );

        wp_enqueue_script(
            'wc_ukr_shipping_tabs_js',
            WC_UKR_SHIPPING_PLUGIN_URL . 'assets/js/tabs.js',
            [],
            filemtime(WC_UKR_SHIPPING_PLUGIN_DIR . 'assets/js/tabs.js')
        );

        wp_enqueue_script(
            'wcus_settings_js',
            WC_UKR_SHIPPING_PLUGIN_URL . 'assets/js/settings.min.js',
            [],
            filemtime(WC_UKR_SHIPPING_PLUGIN_DIR . 'assets/js/settings.min.js'),
            true
        );

        $this->injectGlobals('wcus_settings_js');
    }

    private function injectGlobals($scriptId)
    {
        $translator = $this->translateService;
        $translates = $translator->getTranslates();

        $globals = [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'homeUrl' => home_url(),
            'lang' => $translator->getCurrentLanguage(),
            'nonce' => wp_create_nonce('wc-ukr-shipping'),
            'disableDefaultBillingFields' => apply_filters('wc_ukr_shipping_prevent_disable_default_fields', false) === false ?
                'true' :
                'false',
            'i10n' => [
                'placeholder_area' => $translates['placeholder_area'],
                'placeholder_city' => $translates['placeholder_city'],
                'placeholder_warehouse' => $translates['placeholder_warehouse'],
                'not_found' => $translates['not_found']
            ]
        ];

        $i18n = [];
        $globals['i18n'] = apply_filters('wcus_load_admin_i18n', $i18n);
        wp_localize_script($scriptId, 'wc_ukr_shipping_globals', $globals);
    }
}