<?php
// Setup
define('BOOTSTRAPTOPIC_DEV_MODE', true);
//Includes
include get_theme_file_path('includes/enqueue.php');
include get_theme_file_path('includes/store.php');
//Hooks
add_action('wp_enqueue_scripts', 'enqueue_parent_styles');
add_action('wp_enqueue_scripts', 'storefront_child_enqueue');
add_filter('woocommerce_checkout_fields', 'bloomer_simplify_checkout_virtual');