<?php

/**
 * Enqueue scripts and styles.
 * 
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

class Enqueue
{   
    /**
     * Enqueue constructor.
     * 
     * @since 1.0.0
     */
    public function __construct()
	{
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

    /**
	 * Stylesheets for the frontend.
	 * 
	 * @since 1.0.0
	 */
	public function styles()
	{
		wp_enqueue_style(
			wpclear_plugin_name(),
			wpclear_plugin_url() . 'assets/min/wpclear.min.css',
			array(),
			wpclear_plugin_version(),
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
			wpclear_plugin_name(),
			wpclear_plugin_url() . 'assets/min/wpclear.min.js',
			array( 'jquery' ),
			wpclear_plugin_version(),
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
			wpclear_plugin_name(),
			wpclear_plugin_url() . 'assets/min/wpclear-admin.min.css',
			array(),
			wpclear_plugin_version(),
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
			wpclear_plugin_name(),
			wpclear_plugin_url() . 'assets/min/wpclear-admin.min.js',
			array( 'jquery' ),
			wpclear_plugin_version(),
			false
		);
	}
}
