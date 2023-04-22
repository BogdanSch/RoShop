<?php
function bloomer_simplify_checkout_virtual($fields)
{
    $only_virtual = true;
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        if (!$cart_item['data']->is_virtual()) {
            $only_virtual = false;
        }
    }
    if ($only_virtual) {
        unset($fields['billing']['billing_company']);
        unset($fields['billing']['billing_address_1']);
        unset($fields['billing']['billing_address_2']);
        unset($fields['billing']['billing_city']);
        unset($fields['billing']['billing_postcode']);
        unset($fields['billing']['billing_country']);
        unset($fields['billing']['billing_state']);
        unset($fields['billing']['billing_phone']);
        add_filter('woocommerce_enable_order_notes_field', '__return_false');
    }
    return $fields;
}