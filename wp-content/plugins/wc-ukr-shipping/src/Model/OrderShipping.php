<?php

namespace kirillbdev\WCUkrShipping\Model;

use kirillbdev\WCUkrShipping\Contracts\AddressInterface;
use kirillbdev\WCUkrShipping\Contracts\Customer\CustomerStorageInterface;
use kirillbdev\WCUkrShipping\Contracts\OrderDataInterface;
use kirillbdev\WCUkrShipping\Services\CalculationService;

if ( ! defined('ABSPATH')) {
    exit;
}

class OrderShipping
{
    /**
     * @var \WC_Order_Item_Shipping
     */
    private $item;

    /**
     * @var CustomerStorageInterface
     */
    private $customerStorage;

    /**
     * @param \WC_Order_Item_Shipping $item
     */
    public function __construct($item)
    {
        $this->item = $item;
        $this->customerStorage = wcus_container()->make(CustomerStorageInterface::class);
    }

    /**
     * @param OrderDataInterface $data
     */
    public function save($data)
    {
        $this->customerStorage->remove(CustomerStorageInterface::KEY_LAST_CITY_REF);
        $this->customerStorage->remove(CustomerStorageInterface::KEY_LAST_WAREHOUSE_REF);
        $address = $data->getShippingAddress();

        if ($data->isAddressShipping()) {
            $this->saveAddressShipping($address);
        }
        else {
            $this->saveWarehouseShipping($address);
        }

        $calculationService = new CalculationService();
        $cost = $calculationService->calculateCost($data);
        $this->item->set_total((string)$cost);
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function updateMeta($key, $value)
    {
        $this->item->update_meta_data($key, $value);
    }

    /**
     * @param AddressInterface $address
     */
    private function saveAddressShipping($address)
    {
        if (!$this->isNewUiEnabled()) {
            $this->updateMeta('wcus_area_ref', $address->getAreaRef());
        }
        $this->updateMeta('wcus_city_ref', $address->getCityRef());
        $this->updateMeta('wcus_address', $address->getCustomAddress());
        $this->customerStorage->add(CustomerStorageInterface::KEY_LAST_CITY_REF, sanitize_text_field($address->getCityRef()));
    }

    /**
     * @param AddressInterface $address
     */
    private function saveWarehouseShipping($address)
    {
        if (!$this->isNewUiEnabled()) {
            $this->updateMeta('wcus_area_ref', $address->getAreaRef());
        }
        $this->updateMeta('wcus_city_ref', $address->getCityRef());
        $this->updateMeta('wcus_warehouse_ref', $address->getWarehouseRef());
        $this->customerStorage->add(CustomerStorageInterface::KEY_LAST_CITY_REF, sanitize_text_field($address->getCityRef()));
        $this->customerStorage->add(CustomerStorageInterface::KEY_LAST_WAREHOUSE_REF, sanitize_text_field($address->getWarehouseRef()));
    }

    private function isNewUiEnabled(): bool
    {
        return (int)get_option('wcus_checkout_new_ui') === 1;
    }
}