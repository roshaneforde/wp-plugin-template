<?php

/**
 * General functions for your plugin with a few already written for you.
 * 
 * @package wp-plugin-template
 * @since 1.0.0
 */

/**
 * Retrieve the name of the plugin.
 * 
 * @since 1.0.0
 * @return string
 */
function wpt_plugin_name()
{
    return WP_PLUGIN_TEMPLATE_NAME;
}

/**
 * Retrieve the prefix of the plugin.
 * 
 * @since 1.0.0
 * @return string
 */
function wpt_plugin_prefix()
{
    return WP_PLUGIN_TEMPLATE_PREFIX;
}

/**
 * Retrieve the version number of the plugin.
 * 
 * @since 1.0.0
 * @return string
 */
function wpt_plugin_version()
{
    return WP_PLUGIN_TEMPLATE_VERSION;
}

/**
 * Retrieve the url of the plugin.
 * 
 * @since 1.0.0
 * @return string
 */
function wpt_plugin_url()
{
    return WP_PLUGIN_TEMPLATE_URL;
}

/**
 * Retrieve the path of the plugin.
 * 
 * @since 1.0.0
 * @return string
 */
function wpt_plugin_path()
{
    return WP_PLUGIN_TEMPLATE_PATH;
}

/**
 * Path for default avatar image.
 * 
 * @since 1.0.0
 * @return string
 */
function wpt_default_avatar_image()
{
    return wpt_plugin_url() . 'img/default-avatar.png';
}

/**
 * Add default url protocol if it's not present.
 * 
 * @since 1.0.0
 * @param string $url
 */
function wpt_add_url_protocol( $url )
{
    if ( strpos( $url, 'http' ) === false || strpos( $url, 'https'  === false ) ) {
        $url = 'http://' .$url;
    }

    return $url;
}

/**
 * Show theme's 404 page.
 * 
 * @since 1.0.0
 * @return void
 */
function wpt_template_show_404()
{
    global $wp_query;

    $wp_query->set_404();

    status_header ( 404 );

    nocache_headers();

    include( get_query_template( '404' ) );

    die();
}

/**
 * Get wordpress pages.
 * 
 * @since 1.0.0
 * @param array $args
 */
function wpt_get_pages( $args )
{
    $pages = array();

    foreach ( get_pages( $args ) as $page ) {
        $pages[] = array(
            'url'   => get_permalink( $page->ID )
        );
    }
    
    return $pages;
}

/**
 * Get all notes.
 * 
 * @since 1.0.0
 * @return array $notes_data
 */
function wpt_all_notes()
{
    $notes = get_posts( array(
        'posts_per_page'    => -1,
        'post_type'         => 'note',
        'order'         => 'DESC',
    ) );

    $notes_data = array();

    foreach ( $notes as $note ) {
        // Get notes details
        $pinned = get_post_meta( $note->ID, 'pinned', true );

        // Note categories
        $notes_categories = array();

        $categories = get_the_terms( $note->ID, 'notes_category' );
            
        if ( $categories && ! is_wp_error( $categories ) ) {
            foreach ( $categories as $category ) {
                $notes_categories[] = array(
                    'name' => esc_html__( $category->name, 'wp-plugin-template' ),
                    'slug' => $category->slug,
                );
            }
        }

        $notes_data[] = array( 
            'id' => $note->ID,
            'title' => $note->post_title,
            'category' => $notes_categories,
            'content' => $note->post_content,
            'pinned' => $pinned,
        );
    }

    return $notes_data;
}
