<?php

namespace kirillbdev\WCUkrShipping\Foundation;

use kirillbdev\WCUkrShipping\Services\TranslateService;

if ( ! defined('ABSPATH')) {
    exit;
}

class NovaPoshtaShipping extends \WC_Shipping_Method
{
    public function __construct($instance_id = 0)
    {
        parent::__construct($instance_id);

        $this->id = WC_UKR_SHIPPING_NP_SHIPPING_NAME;
        $this->method_title = WC_UKR_SHIPPING_NP_SHIPPING_TITLE;
        $this->method_description = '';

        $this->supports = array(
            'shipping-zones',
            'instance-settings',
            'instance-settings-modal',
        );

        $this->init();
    }

    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * Init your settings
     *
     * @access public
     * @return void
     */
    function init()
    {
        $this->init_settings();
        $this->init_form_fields();

        $translator = new TranslateService();
        $translates = $translator->getTranslates();

        $this->title = $translates['method_title'];

        // Save settings in admin if you have any defined
        add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
    }

    /**
     * calculate_shipping function.
     *
     * @access public
     *
     * @param array $package
     */
    public function calculate_shipping($package = array())
    {
        $rate = array(
            'label' => $this->title,
            'cost' => 0,
            'package' => $package,
        );
        $this->add_rate($rate);
    }

    /**
     * Is this method available?
     * @param array $package
     * @return bool
     */
    public function is_available($package)
    {
        return $this->is_enabled();
    }
}