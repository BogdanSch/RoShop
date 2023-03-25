<?php

namespace kirillbdev\WCUkrShipping\Modules\Legacy;

use kirillbdev\WCUkrShipping\DB\NovaPoshtaRepository;
use kirillbdev\WCUkrShipping\Http\ResponseLegacy;
use kirillbdev\WCUkrShipping\Model\CheckoutOrderData;
use kirillbdev\WCUkrShipping\Services\CalculationService;
use kirillbdev\WCUkrShipping\Services\TranslateService;
use kirillbdev\WCUSCore\Contracts\ModuleInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class Ajax implements ModuleInterface
{
    private $novaPoshtaRepository;

    /**
     * @var TranslateService
     */
    private $translator;

    public function __construct(TranslateService $translateService)
    {
        $this->novaPoshtaRepository = new NovaPoshtaRepository();
        $this->translator = $translateService;
    }

    public function init()
    {
        if (wp_doing_ajax()) {
            $this->initRoutes();
        }
    }

    public function initRoutes()
    {
        /* === API V2 === */
        add_action('wp_ajax_wcus_api_v2_get_cities', [ $this, 'apiV2GetCities' ]);
        add_action('wp_ajax_nopriv_wcus_api_v2_get_cities', [ $this, 'apiV2GetCities' ]);

        add_action('wp_ajax_wcus_api_v2_get_warehouses', [ $this, 'apiV2GetWarehouses' ]);
        add_action('wp_ajax_nopriv_wcus_api_v2_get_warehouses', [ $this, 'apiV2GetWarehouses' ]);

        add_action('wp_ajax_wcus_calculate_cost', [ $this, 'apiV2CalculateCost' ]);
        add_action('wp_ajax_nopriv_wcus_calculate_cost', [ $this, 'apiV2CalculateCost' ]);
    }

    public function apiV2GetCities()
    {
        $this->apiV2ValidateRequest();

        if (empty($_POST['value'])) {
            ResponseLegacy::makeAjax('error');
        }

        // todo: refactor
        $cities = $this->novaPoshtaRepository->getCities($_POST['value']);
        $result = [];

        if ($cities ) {
            foreach ($cities as $city) {
                $result[] = [
                    'name' => $this->translator->translateCity($city),
                    'value' => $city['ref']
                ];
            }
        }

        ResponseLegacy::makeAjax('success', [
            'items' => $result
        ]);
    }

    public function apiV2GetWarehouses()
    {
        $this->apiV2ValidateRequest();

        if (empty($_POST['value'])) {
            ResponseLegacy::makeAjax('error');
        }

        // todo: refactor
        $warehouses = $this->novaPoshtaRepository->getWarehouses($_POST['value']);
        $result = [];

        if ($warehouses ) {
            foreach ($warehouses as $warehouse) {
                $result[] = [
                    'name' => $this->translator->translateWarehouse($warehouse),
                    'value' => $warehouse['ref']
                ];
            }
        }

        ResponseLegacy::makeAjax('success', [
            'items' => $result
        ]);
    }

    public function apiV2CalculateCost()
    {
        $this->apiV2ValidateRequest();

        foreach ([ 'wcus_ajax', 'wcus_city_ref', 'wcus_address_shipping', 'wcus_method_name' ] as $key) {
            if ( ! isset($_POST[ $key ])) {
                ResponseLegacy::makeAjax('error');
            }
        }

        $orderData = new CheckoutOrderData($_POST);
        $calculationService = new CalculationService();
        $cost = (int)$calculationService->calculateCost($orderData);

        wc()->cart->set_total((string)($orderData->getCalculatedTotal() + $cost));
        $shippingName = wp_unslash(esc_html($_POST['wcus_method_name']));

        $label = $cost ? $shippingName . ': ' . wc_price($cost) : $shippingName;
        $dynamicLabel = apply_filters('wcus_dynamic_shipping_label', $label, $cost, $orderData);

        wp_send_json([
            'success' => true,
            'data' => [
                'shipping' => $dynamicLabel,
                'total' => wc()->cart->get_total()
            ]
        ]);
    }

    private function apiV2ValidateRequest()
    {
        if (empty($_POST['_token']) || ! wp_verify_nonce($_POST['_token'], 'wc-ukr-shipping')) {
            ResponseLegacy::makeAjax('error');
        }
    }
}