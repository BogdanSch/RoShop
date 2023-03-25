<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';
	require 'inc/nux/class-storefront-nux-starter-content.php';
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */

//Custom code

//Custom
add_action('woocommerce_created_customer', 'wdm_custom_new_user_action',10,3);

function wdm_custom_new_user_action ($customer_id, $new_customer_data, $password_generated)
{
     $to = $new_customer_data['user_email'];
     $subject = 'Your free Coupon new registration';
     $message = "Here is Your free coupon id : newBee45 ";
     $headers = "Content-Type: text/html\r\n";
     $attachments = "";
     wp_mail($to, $subject, $message, $headers, $attachments);
}

add_filter('woocommerce_checkout_fields', 'bbloomer_simplify_checkout_virtual');

function bbloomer_simplify_checkout_virtual($fields)
{
    $only_virtual = true;
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        // Check if there are non-virtual products
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

function custom_header_metadata() {
    echo '<meta name="google-site-verification" content="qFhIMnCwnyc8nULGUvWan90mDitOUaLUrDVwYtIU4vs" />';
	echo '<meta name="description" content="This\'\s a test online shop website that based on wordpress. Happy online shopping day!"/>';
	echo '<meta name="keywords" content="shop, online, shopping, sale"/>';
}
add_action( 'wp_head', 'custom_header_metadata' );