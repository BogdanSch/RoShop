<?php

namespace kirillbdev\WCUkrShipping\Modules\Frontend;

use kirillbdev\WCUkrShipping\Foundation\NovaPoshtaShipping;
use kirillbdev\WCUkrShipping\Model\CheckoutOrderData;
use kirillbdev\WCUkrShipping\Services\CalculationService;
use kirillbdev\WCUkrShipping\Services\TranslateService;
use kirillbdev\WCUSCore\Contracts\ModuleInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class ShippingMethod implements ModuleInterface
{
    /**
     * @var TranslateService
     */
    private $translateService;

    /**
     * @var CalculationService
     */
    private $calculationService;

    public function __construct(TranslateService $translateService, CalculationService $calculationService)
    {
        $this->translateService = $translateService;
        $this->calculationService = $calculationService;
    }

    /**
     * Boot function
     *
     * @return void
     */
    public function init()
    {
        add_filter('woocommerce_shipping_methods', [ $this, 'registerShippingMethod' ]);
        add_filter('woocommerce_shipping_rate_label', [ $this, 'getRateLabel' ], 10, 2);
        add_filter('woocommerce_shipping_rate_cost', [$this, 'calculateCost'], 10, 2);
    }

    public function registerShippingMethod($methods)
    {
        $methods[WC_UKR_SHIPPING_NP_SHIPPING_NAME] = NovaPoshtaShipping::class;

        return $methods;
    }

    public function getRateLabel($label, $rate)
    {
        if (WC_UKR_SHIPPING_NP_SHIPPING_NAME === $rate->get_method_id()) {
            $label = $this->translateService->getTranslates()['method_title'];
        }

        return $label;
    }

    public function calculateCost($cost, $rate)
    {
        if (WC_UKR_SHIPPING_NP_SHIPPING_NAME !== $rate->get_method_id()) {
            return $cost;
        }

        if (empty($_GET['wc-ajax']) || 'update_order_review' !== $_GET['wc-ajax'] || empty($_POST['post_data'])) {
            return 0;
        }

        parse_str($_POST['post_data'], $post);

        $orderData = new CheckoutOrderData($post);
        $cost = $this->calculationService->calculateCost($orderData);

        return $cost;
    }
}