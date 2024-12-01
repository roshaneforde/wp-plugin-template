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

		add_action( 'enqueue_block_editor_assets', array( $this, 'block_editor_scripts' ) );
	}

	/**
	 * Assets for the frontend.
	 * 
	 * @since 1.0.0
	 */
	public function scripts()
	{
		wp_enqueue_style(
			wpt_plugin_prefix(),
			wpt_plugin_url() . 'assets/min/' . wpt_plugin_prefix() . '-frontend.min.css',
			array(),
			wpt_plugin_version(),
			'all'
		);

		wp_enqueue_script( 
			wpt_plugin_prefix(),
			wpt_plugin_url() . 'assets/min/' . wpt_plugin_prefix() . '-frontend.min.js',
			array( 'jquery' ),
			wpt_plugin_version(),
			false
		);
	}

	/**
	 * Assets for the admin area.
	 * 
	 * @since 1.0.0
	 */
	public function admin_scripts()
	{
		wp_enqueue_style(
			wpt_plugin_prefix(),
			wpt_plugin_url() . 'assets/min/' . wpt_plugin_prefix() . '-admin.min.css',
			array(),
			wpt_plugin_version(),
			'all'
		);

		wp_enqueue_script( 
			wpt_plugin_prefix(),
			wpt_plugin_url() . 'assets/min/' . wpt_plugin_prefix() . '-admin.min.js',
			array( 'jquery', 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor' ),
			wpt_plugin_version(),
			false
		);

		wp_localize_script(
			wpt_plugin_prefix(),
			'wp_plugin_template',
			array(
				'nonce' => wp_create_nonce( 'wp_rest' ),
				'locale' => get_locale(),
				'notes' => wpt_all_notes(),
			)
		);
	}

	/**
	 * Block editor only scripts.
	 */
	public function block_editor_scripts()
	{
		wp_enqueue_script( 
			wpt_plugin_prefix() . '-blocks',
			wpt_plugin_url() . 'assets/min/' . wpt_plugin_prefix() . '-blocks.min.js',
			array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor' ),
			wpt_plugin_version(),
			false
		);
	}
}

new Enqueue();
