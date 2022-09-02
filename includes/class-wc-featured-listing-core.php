<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WC_Featured_Listing_Core' ) ) :

    /**
     * WC_Featured_Listing_Core.
     *
     * Core Event Handler.
     *
     * @class    WC_Featured_Listing_Core
     * @package  WC_Featured_Listing/Classes
     * @category Class
     * @author   itzmekhokan
     */
    class WC_Featured_Listing_Core {

        /**
         * Constructor for the core class. Hooks in methods.
         */
        public function __construct() {
            $this->active_woocommerce_version();
        }

        public function active_woocommerce_version() {
            if ( version_compare (WC_VERSION, 3.0, '>' ) ) {
                if ( !is_admin() ) {
                    add_filter( 'posts_clauses_request', array( $this, 'featured_listing_query_clauses' ), 999, 2 );
                }
            } else {
                if ( !is_admin() ) {
                    add_action( 'woocommerce_product_query', array( $this, 'woocommerce_product_query' ), 999 );
                }
            }
        }

        public function featured_listing_query_clauses( $clauses, $query ) {
            global $wpdb;
            if( !apply_filters( 'wcfl_is_enabled_featured_products', false, $query ) ) return $clauses;
            $featured_product_ids = apply_filters( 'wcfl_before_query_clauses_featured_product_ids', wc_get_featured_product_ids() );
            $featured_product_ids_order = apply_filters( 'wcfl_before_query_clauses_featured_product_ids_order', 'DESC' );
            $orderby = "FIELD(" . $wpdb->posts . ".ID,'" . implode( "','", $featured_product_ids ) . "') $feture_product_ids_order, ";
            $clauses['orderby'] = $orderby . $clauses['orderby'];
            return $clauses;
        }

        public function woocommerce_product_query($query) {
            if( !apply_filters( 'wcfl_is_enabled_featured_products', false, $query ) ) return $query;
            $query->set( 'meta_key', '_featured' );
            $query->set( 'orderby', "meta_value_num " . $query->get('orderby') );
            $query->set( 'order', "DESC " . $query->get('order') );
            return $query;
        }

    }

    endif; // class_exists

return new WC_Featured_Listing_Core();
