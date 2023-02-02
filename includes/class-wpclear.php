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
		require_once wpclear_plugin_path() . 'config/class-enqueue.php';

		new Enqueue();
	}
}
