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
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Scripts for the frontend.
	 * 
	 * @since 1.0.0
	 */
	public function scripts()
	{
		wp_enqueue_style(
			wp_plugin_template_plugin_name(),
			wp_plugin_template_plugin_url() . 'assets/min/frontend.min.css',
			array(),
			wp_plugin_template_plugin_version(),
			'all'
		);

		wp_enqueue_script( 
			wp_plugin_template_plugin_name(),
			wp_plugin_template_plugin_url() . 'assets/min/frontend.min.js',
			array( 'jquery' ),
			wp_plugin_template_plugin_version(),
			false
		);
	}

	/**
	 * JavaScript for the admin area.
	 * 
	 * @since 1.0.0
	 */
	public function admin_scripts()
	{
		wp_enqueue_style(
			wp_plugin_template_plugin_name(),
			wp_plugin_template_plugin_url() . 'assets/min/admin.min.css',
			array(),
			wp_plugin_template_plugin_version(),
			'all'
		);

		wp_enqueue_script( 
			wp_plugin_template_plugin_name(),
			wp_plugin_template_plugin_url() . 'assets/min/admin.min.js',
			array( 'jquery', 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor' ),
			wp_plugin_template_plugin_version(),
			false
		);

		wp_localize_script(
			wp_plugin_template_plugin_name(),
			'wp_plugin_template',
			array(
				'nonce' => wp_create_nonce( 'wp_rest' ),
				'locale' => get_locale(),
				'notes' => wp_plugin_template_all_notes(),
			)
		);
	}
}

new Enqueue();
