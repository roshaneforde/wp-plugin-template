<?php

/**
 * Fired during plugin activation.
 * 
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since 1.0.0
 */

class WPT_Activator
{
	/**
	 * Description.
	 * 
	 * @since 1.0.0
	 */
	public static function activate()
	{
		flush_rewrite_rules();
	}
}
