<?php

namespace kirillbdev\WCUkrShipping\Model;

use kirillbdev\WCUkrShipping\Contracts\AddressInterface;
use kirillbdev\WCUkrShipping\Contracts\OrderDataInterface;
use kirillbdev\WCUkrShipping\Model\Address\CheckoutAddress;

if ( ! defined('ABSPATH')) {
    exit;
}

class CheckoutOrderData implements OrderDataInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $data;

    /**
     * @var AddressInterface
     */
    private $address;

    /**
     * CheckoutOrder constructor.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;

        $this->init();
    }

    /**
     * @return float
     */
    public function getSubTotal()
    {
        return (float)wc()->cart->get_subtotal();
    }

    /**
     * @return float
     */
    public function getDiscountTotal()
    {
        return (float)wc()->cart->get_discount_total();
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return (float)wc()->cart->get_total('');
    }

    /**
     * @return float
     */
    public function getCalculatedTotal()
    {
        return $this->getSubTotal() + (float)wc()->cart->get_fee_total() - $this->getDiscountTotal();
    }

    /**
     * @return AddressInterface
     */
    public function getShippingAddress()
    {
        return $this->address;
    }

    /**
     * @return bool
     */
    public function isAddressShipping()
    {
        return $this->address->isAddressShipping();
    }

    private function init()
    {
        if (isset($this->data['ship_to_different_address']) && 1 === (int)$this->data['ship_to_different_address']) {
            $this->type = 'shipping';
        }
        else {
            $this->type = 'billing';
        }

        $this->address = new CheckoutAddress($this->data, $this->type);
    }

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        if (isset($this->data['wcus_ajax']) && 1 === (int)$this->data['wcus_ajax']) {
            return $this->data['wcus_payment_method'];
        }

        return ! empty($this->data['payment_method'])
            ? $this->data['payment_method']
            : '';
    }

    /**
     * @return bool
     */
    public function isShipToDifferentAddress()
    {
        return 'shipping' === $this->type;
    }
}