<?php

/**
 * The core plugin class.
 *
 * @since 1.0.0
 */

class WP_Plugin_Template
{
	/**
	 * Register and activate services.
	 * 
	 * @since 1.0.0
	 */
	public function __construct()
	{
		add_filter( 'block_categories_all', array( $this, 'block_categories' ), 10, 2 );

		require_once wp_plugin_template_plugin_path() . 'includes/config/class-enqueue.php';
		require_once wp_plugin_template_plugin_path() . 'includes/custom-post-types/class-notes.php';
		require_once wp_plugin_template_plugin_path() . 'includes/blocks/notes/class-notes-block.php';
	}

	/**
	 * Register custom block categories.
	 * 
	 * @since 1.0.0
	 */
	public function block_categories( $categories ) 
	{
        $category_slugs = wp_list_pluck( $categories, 'slug' );
        
        return in_array( wp_plugin_template_plugin_name() . '-blocks', $category_slugs, true ) ? $categories : array_merge(
            $categories,
            array(
                array(
                    'slug'  => wp_plugin_template_plugin_name() . '-blocks',
                    'title' => __( 'WP Plugin Template', 'wp-plugin-template' )
                ),
            )
        );
	}
}
