<?php

/**
 * Admin page.
 * 
 * @since 1.0.0
 */

class Admin_Page {

    /**
     * Constructor.
     * 
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
    }

    /**
     * Add plugin page.
     * 
     * @since 1.0.0
     */
    public function add_plugin_page()
    {
        add_menu_page(
            __( 'WP Plugin Template', 'wp-plugin-template' ),
            __( 'WP Plugin Template', 'wp-plugin-template' ),
            'manage_options',
            'wpt',
            array( $this, 'create_admin_page' ),
            'dashicons-admin-generic',
            99
        );
    }

    /**
     * Create admin page.
     * 
     * @since 1.0.0
     */
    public function create_admin_page()
    {
        require_once wpt_plugin_path() . 'includes/templates/pages/admin.php';
    }

}

new Admin_Page();
