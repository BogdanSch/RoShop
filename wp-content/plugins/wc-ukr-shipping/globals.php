<?php

if ( ! defined('ABSPATH')) {
    exit;
}

if ( ! function_exists('wc_ukr_shipping_import_svg')) {

    function wc_ukr_shipping_import_svg($image)
    {
        return file_get_contents(WC_UKR_SHIPPING_PLUGIN_DIR . '/image/' . $image);
    }

}

if ( ! function_exists('wc_ukr_shipping_get_option')) {

    function wc_ukr_shipping_get_option($key)
    {
        return \kirillbdev\WCUkrShipping\DB\OptionsRepository::getOption($key);
    }

}

if ( ! function_exists('wc_ukr_shipping_is_checkout')) {

    function wc_ukr_shipping_is_checkout()
    {
        return function_exists('is_checkout') && is_checkout();
    }

}

if ( ! function_exists('wcus_container')) {

    function wcus_container(): \kirillbdev\WCUSCore\Foundation\Container
    {
        return \kirillbdev\WCUkrShipping\Foundation\WCUkrShipping::instance()->getContainer();
    }

}

if ( ! function_exists('wcus_i18n')) {
    function wcus_i18n(string $text): string
    {
        return __($text, WCUS_TRANSLATE_DOMAIN);
    }
}
