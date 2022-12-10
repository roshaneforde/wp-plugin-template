<?php

/**
 * General functions for your plugin with a few already written for you.
 * 
 * Exit if accessed directly.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Retrieve the version number of the plugin.
 */
function wp_plugin_template_get_version()
{
    return WP_PLUGIN_TEMPLATE_VERSION;
}

/**
 * Default avatar path.
 */
function wp_plugin_template_default_avatar_image()
{
    return WP_PLUGIN_TEMPLATE_URL . 'img/default-avatar.png';
}

/**
 * Add default url protocol if it's not present.
 */
function wp_plugin_template_full_link_url( $url )
{
    if ( strpos( $url, 'http' ) === false || strpos( $url, 'https'  === false ) ) {
        $url = 'http://' .$url;
    }

    return $url;
}

/**
 * Show theme's 404 page.
 */
function wp_plugin_template_show_404()
{
    global $wp_query;

    $wp_query->set_404();

    status_header ( 404 );

    nocache_headers();

    include( get_query_template( '404' ) );

    die();
}

/**
 * Get wordpress pages
 */
function wp_plugin_template_get_pages( $args )
{
    $pages = array();

    foreach ( get_pages( $args ) as $page ) {
        $pages[] = array(
            'url'   => get_permalink( $page->ID )
        );
    }
    
    return $pages;
}
