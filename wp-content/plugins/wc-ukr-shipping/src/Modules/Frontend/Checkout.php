<?php

namespace kirillbdev\WCUkrShipping\Modules\Frontend;

use kirillbdev\WCUkrShipping\Foundation\State;
use kirillbdev\WCUkrShipping\Services\Checkout\CheckoutService;
use kirillbdev\WCUkrShipping\Services\Checkout\LegacyCheckoutService;
use kirillbdev\WCUkrShipping\States\CheckoutState;
use kirillbdev\WCUSCore\Contracts\ModuleInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class Checkout implements ModuleInterface
{
    /**
     * @var LegacyCheckoutService|CheckoutService
     */
    private $checkoutService;

    public function __construct()
    {
        $this->checkoutService = (int)get_option('wcus_checkout_new_ui')
            ? new CheckoutService()
            : new LegacyCheckoutService();
    }

    /**
     * Boot function
     *
     * @return void
     */
    public function init()
    {
        add_action($this->getInjectActionName(), [$this, 'injectBillingFields']);
        add_action('woocommerce_after_checkout_shipping_form', [$this, 'injectShippingFields']);
        add_filter('woocommerce_cart_shipping_method_full_label', [$this, 'wrapShippingCost'], 10, 2);
        add_filter('woocommerce_cart_totals_order_total_html', [$this, 'wrapOrderTotal']);
        add_action( 'woocommerce_after_shipping_rate', [ $this, 'injectShippingName' ], 10, 2);
        add_action('wcus_state_init', [ $this, 'initCheckoutState' ]);
    }

    public function injectBillingFields()
    {
        $this->injectFields('billing');
    }

    public function injectShippingFields()
    {
        $this->injectFields('shipping');
    }

    public function wrapShippingCost($label, $method)
    {
        if ($method->get_method_id() === WC_UKR_SHIPPING_NP_SHIPPING_NAME) {
            return '<span id="wcus-shipping-cost">' . $label . '</span>';
        }

        return $label;
    }

    public function wrapOrderTotal($value)
    {
        return '<span id="wcus-order-total">' . $value . '</span>';
    }

    public function injectShippingName($method, $index)
    {
        if ($method->get_method_id() === WC_UKR_SHIPPING_NP_SHIPPING_NAME) {
            echo '<input id="wcus-shipping-name" type="hidden" value="' . esc_attr($method->get_label()) . '">';
        }
    }

    public function initCheckoutState()
    {
        if (wc_ukr_shipping_is_checkout()) {
            State::add('checkout', CheckoutState::class);
        }
    }

    private function injectFields($type)
    {
        if (!wc_ukr_shipping_is_checkout()) {
            return;
        }

        $this->checkoutService->renderCheckoutFields($type);
    }

    private function getInjectActionName()
    {
        return 'additional' === wc_ukr_shipping_get_option('wc_ukr_shipping_np_block_pos')
            ? 'woocommerce_before_order_notes'
            : 'woocommerce_after_checkout_billing_form';
    }
}