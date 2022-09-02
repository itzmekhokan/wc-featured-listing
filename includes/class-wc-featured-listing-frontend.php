<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WC_Featured_Listing_Frontend' ) ) :

    /**
     * WC_Featured_Listing_Frontend.
     *
     * Frontend Event Handler.
     *
     * @class    WC_Featured_Listing_Frontend
     * @package  WC_Featured_Listing/Classes
     * @category Class
     * @author   itzmekhokan
     */
    class WC_Featured_Listing_Frontend {

        /**
         * Constructor for the frontend class. Hooks in methods.
         */
        public function __construct() {
            add_filter( 'woocommerce_product_is_on_sale', array( $this, 'woocommerce_product_is_on_sale' ), 99, 2 );
            add_filter( 'woocommerce_sale_flash', array( $this, 'woocommerce_sale_flash' ), 99, 3 );
            add_filter( 'wcfl_is_enabled_featured_products', array( $this, 'wcfl_is_enabled_featured_products' ), 10, 2 );
        }

        public function woocommerce_product_is_on_sale( $onsale, $product ) {
            if ( $product->is_featured() ) {
                return true;
            } else {
                return $onsale;
            }
        }

        public function woocommerce_sale_flash( $html, $post, $product ) {
            if ( $product->is_featured() ) {
                return '<span class="onsale">' . esc_html__('Featured!', 'woocommerce') . '</span>';
            } else {
                return $html;
            }
        }
        
        public function wcfl_is_enabled_featured_products( $flag, $query ) {
            if( !isset($query->query_vars['wc_query'] ) ) $flag = false; // if query not related to product
            if ( ! wcfl_global_featured_listing_enabled() ) {      
                if( isset( $query->is_post_type_archive ) && $query->is_post_type_archive && wcfl_shop_featured_listing_enabled() ) {
                    $flag = true;
                }
                if( isset( $query->is_archive ) && $query->is_archive && isset( $query->is_tax ) && $query->is_tax && wcfl_taxonomy_featured_listing_enabled() ) {
                    $flag = true;
                }
                if( isset( $query->query['s'] ) && isset( $query->is_search ) && $query->is_search && wcfl_search_featured_listing_enabled() ) {
                    $flag = true;
                }
            } else {
                $flag = true;
            }
            return $flag;
        }

    }

    endif; // class_exists

return new WC_Featured_Listing_Frontend();
