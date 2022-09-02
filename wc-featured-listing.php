<?php

/**
 * Plugin Name: WooCommerce Featured Listing
 * Plugin URI: 
 * Description: An eCommerce toolkit used to show featured or exclusive products first priority basis.
 * Version: 1.0.0
 * Author: itzmekhokan
 * Author URI: https://itzmekhokan.wordpress.com/
 * Text Domain: wc-featured-listing
 * Domain Path: /languages/
 * Requires at least: 4.4
 * Tested up to: 5.2
 * WC requires at least: 3.0
 * WC tested up to: 3.6.2
 *
 * @package wc-featured-listing
 */
if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define WC_FEATURED_LISTING_PLUGIN_FILE.
if ( !defined( 'WC_FEATURED_LISTING_PLUGIN_FILE' ) ) {
    define( 'WC_FEATURED_LISTING_PLUGIN_FILE', __FILE__ );
}

// Include the main WC_Featured_Listing class.
if ( !class_exists( 'WC_Featured_Listing' ) ) {
    include_once dirname(__FILE__) . '/includes/class-wc-featured-listing.php';
}

/**
 * Main instance of WC_Featured_Listing.
 *
 * Returns the main instance of WC_Featured_Listing to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return WC_Featured_Listing
 */
function WC_Featured_Listing() {
    return WC_Featured_Listing::instance();
}

// Global for backwards compatibility.
$GLOBALS['wc_featured_listing'] = WC_Featured_Listing();
