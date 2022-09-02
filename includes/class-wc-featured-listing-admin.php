<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WC_Featured_Listing_Admin' ) ) :

    /**
     * WC_Featured_Listing_Admin.
     *
     * Backend Event Handler.
     *
     * @class    WC_Featured_Listing_Admin
     * @package  WC_Featured_Listing/Classes
     * @category Class
     * @author   itzmekhokan
     */
    class WC_Featured_Listing_Admin {
        
        /**
         * Constructor for the admin class. Hooks in methods.
         */
        public function __construct() {
            add_filter( 'woocommerce_products_general_settings', array( $this, 'add_wcfl_settings'  ), 60 );
        }
        
        /**
	 * Add settings in woocommerce settings product
	 *
	 * @access public
	 * @since 1.0.0
	 * @return array $settings
	 */
	public function add_wcfl_settings( $settings ) {
            $wcfl_settings = array(
                array( 
                    'name' => __( 'Featured listing', 'wc-featured-listing' ), 
                    'type' => 'title', 
                    'desc' => '', 
                    'id' => 'featured_listing_pro_first_options' 
                ),
                array(
                    'title'           => __( 'Enable feature listing', 'wc-featured-listing' ),
                    'desc'            => __( 'Enable feature products first in all woocommerce products page.', 'wc-featured-listing' ),
                    'id'              => 'is_global_featured_listing',
                    'default'         => 'yes',
                    'type'            => 'checkbox',
                    'checkboxgroup'   => 'start',
                ),
                array(
                    'desc'            => __( 'Enable feature products first for shop page only. Enabled it to override "Enable feature products globally" functionality.', 'wc-featured-listing' ),
                    'id'              => 'is_shop_featured_listing',
                    'default'         => 'no',
                    'type'            => 'checkbox',
                    'checkboxgroup'   => '',
                ),
                array(
                    'desc'            => __( 'Enable feature products first for taxonomy page only. Enabled it to override "Enable feature products globally" functionality.', 'wc-featured-listing' ),
                    'id'              => 'is_taxonomy_featured_listing',
                    'default'         => 'no',
                    'type'            => 'checkbox',
                    'checkboxgroup'   => '',
                ),
                array(
                    'desc'            => __( 'Enable feature products first for search page only. Enabled it to override "Enable feature products globally" functionality.', 'wc-featured-listing' ),
                    'id'              => 'is_search_featured_listing',
                    'default'         => 'no',
                    'type'            => 'checkbox',
                    'checkboxgroup'   => 'end',
                ),
                array( 
                    'type' => 'sectionend', 
                    'id' => 'featured_listing_pro_first_options' 
                ),
            );
            $settings = array_merge( $settings, apply_filters( 'wc_featured_listing_settings', $wcfl_settings ) );
            return $settings;
	}
    }

    endif; // class_exists

return new WC_Featured_Listing_Admin();
