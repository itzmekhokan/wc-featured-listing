<?php

/**
 * WC_Featured_Listing setup
 *
 * @package  WC_Featured_Listing
 * @since    1.0.0
 */
defined('ABSPATH') || exit;

/**
 * Main WC_Featured_Listing Class.
 *
 * @class WC_Featured_Listing
 */
final class WC_Featured_Listing {

    /**
     * WC_Featured_Listing version.
     *
     * @var string
     */
    public $version = '1.0.0';
    
    /**
     * instance of the core class.
     *
     * @var WC_Featured_Listing_Core
     */
    public $core = null;
    
    /**
     * instance of the core class.
     *
     * @var WC_Featured_Listing_Admin
     */
    public $admin = null;

    /**
     * The single instance of the class.
     *
     * @var WC_Featured_Listing
     * @since 1.0.0
     */
    protected static $_instance = null;

    /**
     * Main WC_Featured_Listing Instance.
     *
     * Ensures only one instance of WC_Featured_Listing is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @see WC_Featured_Listing()
     * @return WC_Featured_Listing - Main instance.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * WC_Featured_Listing Constructor.
     */
    public function __construct() {
        $this->define_constants();
        add_action( 'plugins_loaded', array( $this, 'load_classes' ), 9 );
        add_action( 'init', array( $this, 'init' ) );
        add_action( 'activated_plugin', array( $this, 'activated_plugin' ) );
        add_action( 'deactivated_plugin', array( $this, 'deactivated_plugin' ) );
        do_action( 'wc_featured_listing_loaded' );
    }

    /**
     * Define WC Constants.
     */
    private function define_constants() {
        if ( !defined( 'WC_FEATURED_LISTING_ABSPATH' ) )
            define( 'WC_FEATURED_LISTING_ABSPATH', dirname(WC_FEATURED_LISTING_PLUGIN_FILE) . '/' );
        if ( !defined( 'WC_FEATURED_LISTING_BASENAME' ) )
            define( 'WC_FEATURED_LISTING_BASENAME', plugin_basename(WC_FEATURED_LISTING_PLUGIN_FILE) );
        if (!defined( 'WC_FEATURED_LISTING_VERSION' ) )
            define( 'WC_FEATURED_LISTING_VERSION', $this->version );
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes() {
        /**
         * Core classes and functions.
         */
        include_once WC_FEATURED_LISTING_ABSPATH . 'includes/wc-featured-listing-functions.php';
        $this->core = include_once WC_FEATURED_LISTING_ABSPATH . 'includes/class-wc-featured-listing-core.php';

        if ( is_admin() ) {
            $this->admin = include_once WC_FEATURED_LISTING_ABSPATH . 'includes/class-wc-featured-listing-admin.php';
        }
        if ( ( !is_admin() || defined('DOING_AJAX') ) && !defined('DOING_CRON') ) {
            include_once WC_FEATURED_LISTING_ABSPATH . 'includes/class-wc-featured-listing-frontend.php';
        }
        
    }

    /**
     * Init WooCommerce when WordPress Initialises.
     */
    public function init() {
        // Before init action.
        do_action( 'before_wc_featured_listing_init' );
        // Set up localisation.
        $this->load_plugin_textdomain();
        // Init action.
        do_action( 'wc_featured_listing_init' );
    }

    /**
     * Load Localisation files.
     */
    public function load_plugin_textdomain() {
        $locale = is_admin() && function_exists('get_user_locale') ? get_user_locale() : get_locale();
        $locale = apply_filters( 'plugin_locale', $locale, 'wc-featured-listing' );

        unload_textdomain( 'wc-featured-listing' );
        load_textdomain( 'wc-featured-listing', WP_LANG_DIR . '/wc-featured-listing/wc-featured-listing-' . $locale . '.mo');
        load_plugin_textdomain( 'wc-featured-listing', false, plugin_basename( dirname (WC_FEATURED_LISTING_PLUGIN_FILE ) ) . '/languages' );
    }

    /**
     * Instantiate classes when woocommerce is activated
     */
    public function load_classes() {
        if ( $this->is_woocommerce_activated() === false ) {
            add_action( 'admin_notices', array( $this, 'need_woocommerce' ) );
            return;
        }
        // Activate license key
        add_action( 'admin_notices', array( $this, 'connect_to_store_license' ) );
       

        // all systems ready - GO!
        $this->includes();
    }

    /**
     * Check if woocommerce is activated
     */
    public function is_woocommerce_activated() {
        $blog_plugins = get_option( 'active_plugins', array() );
        $site_plugins = is_multisite() ? (array) maybe_unserialize( get_site_option( 'active_sitewide_plugins' ) ) : array();

        if ( in_array( 'woocommerce/woocommerce.php', $blog_plugins ) || isset( $site_plugins['woocommerce/woocommerce.php'] ) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * WooCommerce not active notice.
     *
     * @return string Fallack notice.
     */
    public function need_woocommerce() {
        $error = sprintf( __('WooCommerce Feature Listing requires %sWooCommerce%s to be installed & activated!', 'wc-featured-listing'), '<a href="http://wordpress.org/extend/plugins/woocommerce/">', '</a>' );

        $message = '<div class="error"><p>' . $error . '</p></div>';

        echo $message;
    }
    
    /**
     * Connect your store.
     *
     * @return string Fallack notice.
     */
    public function connect_to_store_license() {
        $error = sprintf( __('Thanks for installing WooCommerce Feature Listing. %sConnect your license key%s to get started.', 'wc-featured-listing'), '<a href="' . admin_url( 'admin.php?page=wc-addons&section=helper' ) . '">', '</a>' );

        $message = '<div class="error"><p>' . $error . '</p></div>';

        echo $message;
    }

    /**
     * Get the plugin url.
     *
     * @return string
     */
    public function plugin_url() {
        return untrailingslashit( plugins_url( '/', WC_FEATURED_LISTING_PLUGIN_FILE ) );
    }

    /**
     * Get the plugin path.
     *
     * @return string
     */
    public function plugin_path() {
        return untrailingslashit( plugin_dir_path( WC_FEATURED_LISTING_PLUGIN_FILE ) );
    }
    
    /**
     * Ran when any plugin is activated.
     *
    */
    public function activated_plugin( $filename ) {
        // set globally feature listing
        update_option( 'is_global_featured_listing', 'yes' );
    }
    
    /**
     * Ran when any plugin is deactivated.
     *
    */
    public function deactivated_plugin( $filename ) {
        
    }

}
