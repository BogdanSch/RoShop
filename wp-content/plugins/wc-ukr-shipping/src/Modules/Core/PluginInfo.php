<?php

namespace kirillbdev\WCUkrShipping\Modules\Core;

use kirillbdev\WCUSCore\Contracts\ModuleInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class PluginInfo implements ModuleInterface
{
    /**
     * Boot function
     *
     * @return void
     */
    public function init()
    {
        add_filter('plugin_action_links_' . WC_UKR_SHIPPING_PLUGIN_NAME, [ $this, 'actionLinks' ]);
    }

    /**
     * @param array $links
     *
     * @return array
     */
    public function actionLinks($links)
    {
        $settings_link = '<a href="' . home_url('wp-admin/admin.php?page=wc_ukr_shipping_options') . '">Настройки</a>';
        array_unshift($links, $settings_link);

        return $links;
    }
}