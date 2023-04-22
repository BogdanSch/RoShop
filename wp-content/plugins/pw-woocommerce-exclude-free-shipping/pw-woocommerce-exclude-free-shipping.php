<?php
/**
 * Plugin Name: PW WooCommerce Exclude Free Shipping
 * Plugin URI: https://wordpress.org/plugins/pw-woocommerce-exclude-free-shipping
 * Description: Specify products that cause Free Shipping to not be available when they are in the cart.
 * Version: 1.30
 * Author: Pimwick, LLC
 * Author URI: https://pimwick.com
 * Text Domain: pw-woocommerce-exclude-free-shipping
 * Domain Path: /languages
 * WC requires at least: 4.0
 * WC tested up to: 7.5
*/

/*
Copyright (C) Pimwick, LLC

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

// Verify this isn't called directly.
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

if ( ! class_exists( 'PW_Exclude_Free_Shipping' ) ) :

final class PW_Exclude_Free_Shipping {

    private $meta_name = '_pw_exclude_free_shipping';

    function __construct() {
        add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
        add_action( 'woocommerce_init', array( $this, 'woocommerce_init' ) );
    }

    function plugins_loaded() {
        load_plugin_textdomain( 'pw-woocommerce-exclude-free-shipping', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }

    function woocommerce_init() {
        if ( is_admin() ) {
            add_action( 'woocommerce_product_options_shipping', array( $this, 'woocommerce_product_options_shipping' ), 9 );
            add_action( 'woocommerce_variation_options', array( $this, 'woocommerce_variation_options' ), 10, 3 );
            add_action( 'woocommerce_process_product_meta', array( $this, 'woocommerce_process_product_meta' ) );
            add_action( 'woocommerce_admin_process_variation_object', array( $this, 'woocommerce_admin_process_variation_object' ), 10, 2 );
            add_filter( 'pwbe_common_joins', array( $this, 'pwbe_common_joins' ) );
            add_filter( 'pwbe_common_fields', array( $this, 'pwbe_common_fields' ) );
            add_filter( 'pwbe_common_where', array( $this, 'pwbe_common_where' ) );
            add_filter( 'pwbe_product_columns', array( $this, 'pwbe_product_columns' ) );
            add_filter( 'pwbe_filter_types', array( $this, 'pwbe_filter_types' ) );
        }

        add_filter( 'woocommerce_shipping_free_shipping_is_available', array( $this, 'woocommerce_shipping_free_shipping_is_available' ), 9999 );
    }

    function woocommerce_product_options_shipping() {
        woocommerce_wp_checkbox( array(
            'id'            => $this->meta_name,
            'label'         => __( 'Exclude Free Shipping', 'pw-woocommerce-exclude-free-shipping' ),
            'description'   => __( 'If this product is in the cart, "Free Shipping" is not an option.', 'pw-woocommerce-exclude-free-shipping' )
        ) );
    }

    function woocommerce_variation_options( $loop, $variation_data, $variation ) {
        $variation_object = wc_get_product( $variation );
        ?>
        <label class="tips" data-tip="<?php esc_attr_e( 'If this Variation is in the cart, "Free Shipping" is not an option.', 'pw-woocommerce-exclude-free-shipping' ); ?>">
            <?php esc_html_e( 'Exclude Free Shipping', 'pw-woocommerce-exclude-free-shipping' ); ?>
            <input type="checkbox" class="checkbox variable_<?php echo esc_attr( $this->meta_name ); ?>" name="variable_<?php echo esc_attr( $this->meta_name ); ?>[<?php echo esc_attr( $loop ); ?>]" <?php checked( $variation_object->get_meta( $this->meta_name ), 'yes' ); ?> />
        </label>
        <?php
    }

    function woocommerce_process_product_meta( $post_id ) {
        if ( isset( $_POST[ $this->meta_name ] ) && !empty( $_POST[ $this->meta_name ] ) ) {
            update_post_meta( $post_id, $this->meta_name, esc_attr( $_POST[ $this->meta_name ] ) );
        } else {
            delete_post_meta( $post_id, $this->meta_name );
        }
    }

    function woocommerce_admin_process_variation_object( $variation, $i ) {
        if ( isset( $_POST['variable_' . $this->meta_name ][ $i ] ) ) {
            update_post_meta( $variation->get_id(), $this->meta_name, 'yes' );
        } else {
            delete_post_meta( $variation->get_id(), $this->meta_name );
        }
    }

    function woocommerce_shipping_free_shipping_is_available( $is_available ) {
        global $woocommerce;

        $cart_items = $woocommerce->cart->get_cart();

        foreach ( $cart_items as $key => $item ) {
            if ( isset( $item['variation_id'] ) && !empty( $item['variation_id'] ) ) {
                if( 'yes' === get_post_meta( $item['variation_id'], $this->meta_name, 'true' ) ) {
                    return false;
                }
            }

            if( 'yes' === get_post_meta( $item['product_id'], $this->meta_name, 'true' ) ) {
                return false;
            }
        }

        return $is_available;
    }

    function pwbe_common_joins( $sql ) {
        global $wpdb;

        $sql .= "
            LEFT JOIN
                {$wpdb->postmeta} AS exclude_free_shipping ON (exclude_free_shipping.post_id = parent.ID AND exclude_free_shipping.meta_key = '_pw_exclude_free_shipping')
        ";

        return $sql;
    }

    function pwbe_common_fields( $sql ) {
        global $wpdb;

        $sql .= ",
            COALESCE(NULLIF(exclude_free_shipping.meta_value, ''), 'no') AS _pw_exclude_free_shipping
        ";

        return $sql;
    }

    function pwbe_common_where( $sql ) {
        global $wpdb;

        if ( isset( $_POST['pwbe_flash_store_products_only'] ) && $_POST['pwbe_flash_store_products_only'] == 'true' ) {
            $sql .= "
                AND COALESCE(flash_store.meta_value, '') != ''
            ";
        }

        return $sql;
    }

    function pwbe_product_columns( $product_columns ) {

        $new_column = array(
            'name' => __( 'Exclude free shipping', 'pw-woocommerce-exclude-free-shipping' ),
            'type' => 'checkbox',
            'table' => 'meta',
            'field' => '_pw_exclude_free_shipping',
            'readonly' => 'false',
            'visibility' => 'parent',
            'sortable' => 'true',
            'views' => array( 'all', 'standard' )
        );

        $insert_index = $this->index_of( 'field', 'product_shipping_class', $product_columns);
        if ( $insert_index <= 0 ) {
            $insert_index = $this->index_of( 'field', '_visibility', $product_columns);
        }
        $existing_index = $insert_index + 1;

        array_splice( $product_columns, $existing_index, 0, array( $new_column ) );

        return $product_columns;
    }

    function pwbe_filter_types( $filter_types ) {
        global $wpdb;

        $filter_types['exclude_free_shipping'] = array( 'name' => __( 'Exclude free shipping', 'pw-woocommerce-exclude-free-shipping' ), 'type' => 'boolean' );

        ksort( $filter_types );

        return $filter_types;
    }

    function index_of( $key, $value, $array ) {
        foreach ( $array as $k => $v ) {
            if ( $v[ $key ] === $value ) {
                return $k;
            }
        }

        return null;
    }
}

new PW_Exclude_Free_Shipping();

endif;
