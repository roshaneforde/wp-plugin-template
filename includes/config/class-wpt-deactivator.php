<?php

/**
 * Fired during plugin deactivation
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 * 
 * @since 1.0.0
 */

class WPT_Deactivator
{
	/**
	 * Description.
	 * 
	 * @since 1.0.0
	 */
	public static function deactivate()
	{
		flush_rewrite_rules();
	}
}
