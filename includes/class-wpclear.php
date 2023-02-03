<?php

/**
 * The core plugin class.
 *
 * @since 1.0.0
 */

class WP_Clear
{
	/**
	 * Register and activate services.
	 * 
	 * @since 1.0.0
	 */
	public function __construct()
	{
		add_filter( 'block_categories_all', array( $this, 'block_categories' ), 10, 2 );

		require_once wpclear_plugin_path() . 'includes/config/class-enqueue.php';
		require_once wpclear_plugin_path() . 'includes/custom-post-types/class-notes.php';
		require_once wpclear_plugin_path() . 'includes/blocks/notes/class-notes-block.php';

		new Enqueue();
		new Notes();
		new Notes_Block();
	}

	/**
	 * Register custom block categories.
	 * 
	 * @since 1.0.0
	 */
	public function block_categories( $categories ) 
	{
        $category_slugs = wp_list_pluck( $categories, 'slug' );
        
        return in_array( 'wpclear-blocks', $category_slugs, true ) ? $categories : array_merge(
            $categories,
            array(
                array(
                    'slug'  => 'wpclear-blocks',
                    'title' => __( 'WP Clear' )
                ),
            )
        );
	}
}
