<?php

namespace kirillbdev\WCUkrShipping\DB;

if ( ! defined('ABSPATH')) {
    exit;
}

class OptionsRepository
{
    /**
     * @param string $key
     * @return mixed|null
     */
    public static function getOption($key)
    {
        $defaults = [
            'wc_ukr_shipping_np_method_title' => 'Новая почта',
            'wc_ukr_shipping_np_block_title' => 'Укажите адрес доставки',
            'wc_ukr_shipping_np_placeholder_area' => 'Выберите область',
            'wc_ukr_shipping_np_placeholder_city' => 'Выберите город',
            'wc_ukr_shipping_np_placeholder_warehouse' => 'Выберите отделение',
            'wc_ukr_shipping_np_address_title' => 'Нужна адресная доставка',
            'wc_ukr_shipping_np_address_placeholder' => 'Введите адрес',
            'wc_ukr_shipping_np_not_found_text' => 'Ничего не найдено',
            'wc_ukr_shipping_np_block_pos' => 'billing',
            'wc_ukr_shipping_np_save_warehouse' => 0,
            'wc_ukr_shipping_np_translates_type' => WCUS_TRANSLATE_TYPE_PLUGIN,
            'wc_ukr_shipping_np_new_ui' => 1
        ];

        return get_option($key, isset($defaults[$key]) ? $defaults[$key] : null);
    }

    public function save($data)
    {
        foreach ($data['wc_ukr_shipping'] as $key => $value) {
            update_option('wc_ukr_shipping_' . $key, sanitize_text_field($value));
        }

        foreach ($data['wcus'] as $key => $value) {
            update_option('wcus_' . $key, sanitize_text_field($value));
        }

        // Flush WooCommerce Shipping Cache
        delete_option('_transient_shipping-transient-version');
    }

    public function deleteAll()
    {
        delete_option('_transient_shipping-transient-version');
    }
}