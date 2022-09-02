<?php
/**
 * Check if feature listing is globally enabled.
 *
 * @since 1.0.0
 * @return bool
 */
function wcfl_global_featured_listing_enabled() {
    return 'yes' === get_option( 'is_global_featured_listing' );
}

/**
 * Check if feature listing is shop enabled.
 *
 * @since 1.0.0
 * @return bool
 */
function wcfl_shop_featured_listing_enabled() {
    return 'yes' === get_option( 'is_shop_featured_listing' );
}

/**
 * Check if feature listing is archive taxonomy enabled.
 *
 * @since 1.0.0
 * @return bool
 */
function wcfl_taxonomy_featured_listing_enabled() {
    return 'yes' === get_option( 'is_taxonomy_featured_listing' );
}

/**
 * Check if feature listing is search enabled.
 *
 * @since 1.0.0
 * @return bool
 */
function wcfl_search_featured_listing_enabled() {
    return 'yes' === get_option( 'is_search_featured_listing' );
}

