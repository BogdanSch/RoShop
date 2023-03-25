<?php

namespace kirillbdev\WCUkrShipping\Modules\Frontend;

use kirillbdev\WCUkrShipping\Model\CheckoutOrderData;
use kirillbdev\WCUkrShipping\Model\OrderShipping;
use kirillbdev\WCUkrShipping\Model\WCUSOrder;
use kirillbdev\WCUSCore\Contracts\ModuleInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class OrderCreator implements ModuleInterface
{
    /**
     * Boot function
     *
     * @return void
     */
    public function init()
    {
        if (is_admin()) {
            return;
        }

        add_action('woocommerce_checkout_create_order', [ $this, 'createOrder' ]);
        add_action('woocommerce_checkout_create_order_shipping_item', [ $this, 'saveOrderShipping' ]);
    }

    /**
     * @param \WC_Order $order
     */
    public function createOrder($order)
    {
        if ( ! $this->isNovaPoshtaShipping($order)) {
            return;
        }

        $wcusOrder = new WCUSOrder($order);
        $orderData = new CheckoutOrderData($_POST);
        $wcusOrder->save($orderData);
    }

    /**
     * @param \WC_Order_Item_Shipping $item
     */
    public function saveOrderShipping($item)
    {
        if ( ! empty($_POST) && WC_UKR_SHIPPING_NP_SHIPPING_NAME === $item->get_method_id()) {
            $orderData = new CheckoutOrderData($_POST);
            $shipping = new OrderShipping($item);
            $shipping->save($orderData);
        }
    }

    /**
     * @param \WC_Order $order
     *
     * @return bool
     */
    private function isNovaPoshtaShipping($order)
    {
        return $order->has_shipping_method(WC_UKR_SHIPPING_NP_SHIPPING_NAME);
    }
}