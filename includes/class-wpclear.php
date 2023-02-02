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
		require_once wpclear_plugin_path() . 'includes/config/class-enqueue.php';
		require_once wpclear_plugin_path() . 'includes/custom-post-types/class-notes.php';

		new Enqueue();
		new Notes();
	}
}
