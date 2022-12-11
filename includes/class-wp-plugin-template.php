<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 * 
 * @since 1.0.0
 */

class WP_Plugin_Template 
{
	/**
	 * The unique identifier of this plugin.
	 * 
	 * @since 1.0.0
	 * @var string
	 */
	protected $plugin_name;

	/**
	 * List of classes that the plugin depends on.
	 * 
	 * @since 1.0.0
	 * @var array
	 */
	public $services =  array(
		// Translations::class,
	);

	/**
	 * Register and activate services.
	 * 
	 * Set the plugin name that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 * 
	 * @since 1.0.0
	 */
	public function __construct()
	{
		$this->plugin_name = 'wp-plugin-template';

		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

		foreach ( $this->services as $class ) {
            ( new $class );
		}
	}

	/**
	 * Stylesheets for the frontend.
	 * 
	 * @since 1.0.0
	 */
	public function styles()
	{
		wp_enqueue_style(
			$this->plugin_name,
			WP_PLUGIN_TEMPLATE_URL . 'css/wp-plugin-template.css',
			array(),
			wp_plugin_template_get_version(),
			'all'
		);
	}

	/**
	 * JavaScript for the frontend.
	 * 
	 * @since 1.0.0
	 */
	public function scripts()
	{
		wp_enqueue_script( 
			$this->plugin_name,
			WP_PLUGIN_TEMPLATE_URL . 'js/wp-plugin-template.js',
			array( 'jquery' ),
			wp_plugin_template_get_version(),
			false
		);
	}

	/**
	 * Stylesheets for the admin area.
	 * 
	 * @since 1.0.0
	 */
	public function admin_styles()
	{
		wp_enqueue_style(
			$this->plugin_name,
			WP_PLUGIN_TEMPLATE_URL . 'css/wp-plugin-template-admin.css',
			array(),
			wp_plugin_template_get_version(),
			'all'
		);
	}

	/**
	 * JavaScript for the admin area.
	 * 
	 * @since 1.0.0
	 */
	public function admin_scripts()
	{
		wp_enqueue_script( 
			$this->plugin_name,
			WP_PLUGIN_TEMPLATE_URL . 'js/wp-plugin-template-admin.js',
			array( 'jquery' ),
			wp_plugin_template_get_version(),
			false
		);
	}
}
