<?php

/**
 * The notes custom post type.
 * 
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

class Notes
{
    public function __construct()
    {   
        add_action( 'admin_init', array( $this, 'menu_separator' ) );

        add_action( 'init', array( $this, 'register_custom_post_type' ) );
        add_action( 'init', array( $this, 'add_taxonomies' ), 0 );

        add_action( 'add_meta_boxes', array( $this, 'add_metaboxes' ), 1 );
        add_action( 'save_post', array( $this, 'save_meta' ), 1, 2 );
    }

    /**
     * Add menu separator
     * 
     * @since 1.0.0
     */
    public function menu_separator()
    {
        global $menu;

        $position = 26;

        $menu[ $position ] = array(
            0 => '',
            1 => 'read',
            2 => 'separator' . $position,
            3 => '',
            4 => 'wp-menu-separator'
        );

        ksort( $menu );
    }

    /**
     * Register the custom post type
     * 
     * @since 1.0.0
     */
    public function register_custom_post_type()
    {
        $labels = array(
            'name'                  => __( 'Notes', 'wpclear' ),
            'singular_name'         => __( 'Note', 'wpclear' ),
            'menu_name'             => __( 'Notes', 'wpclear' ),
            'all_items'             => __( 'All Notes', 'wpclear' ),
            'add_new_item'          => __( 'Add New Note', 'wpclear' ),
            'add_new'               => __( 'Add Note', 'wpclear' ),
            'new_item'              => __( 'New Note', 'wpclear' ),
            'edit_item'             => __( 'Edit Note', 'wpclear' ),
            'update_item'           => __( 'Update Note', 'wpclear' ),
            'view_item'             => __( 'View Note', 'wpclear' ),
            'view_items'            => __( 'View Notes', 'wpclear' ),
            'search_items'          => __( 'Search Notes', 'wpclear' ),
            'not_found'             => __( 'No Notes found', 'wpclear' ),
            'not_found_in_trash'    => __( 'No Notes found in Trash', 'wpclear' ),
        );

        $args = array(
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
            'taxonomies'            => array( 'notes_category' ),
            'public'                => true,
            'menu_position'         => 27,
            'menu_icon'             => 'dashicons-media-text',
            'has_archive'           => false,
            'show_in_rest'          => true,
            'capability_type'       => 'post',
        );

        register_post_type( 'note', $args );
    }

    /**
     * Add custom taxonomies
     * 
     * @since 1.0.0
     */
    public function add_taxonomies()
    {
        register_taxonomy( 'notes_category', 'note',
            array(
                'hierarchical'          => true,
                'show_ui'               => true,
                'show_admin_column'     => true,
                'query_var'             => true,
                'show_in_rest'          => true,
                'labels' => array(
                    'name'              => __( 'Categories', 'wpclear' ),
                    'singular_name'     => __( 'Category', 'wpclear' ),
                    'search_items'      => __( 'Search Categories', 'wpclear' ),
                    'all_items'         => __( 'All Categories', 'wpclear' ),
                    'parent_item'       => __( 'Parent Category', 'wpclear' ),
                    'parent_item_colon' => __( 'Parent Category:', 'wpclear' ),
                    'edit_item'         => __( 'Edit Category', 'wpclear' ),
                    'update_item'       => __( 'Update Category', 'wpclear' ),
                    'add_new_item'      => __( 'Add New Category', 'wpclear' ),
                    'new_item_name'     => __( 'New Category Name', 'wpclear' ),
                    'menu_name'         => __( 'Categories', 'wpclear' ),
                ),
                'rewrite' => array(
                    'slug'              => 'notes_category',
                    'with_front'        => false,
                    'hierarchical'      => true,
                )
            )
        );
    }

    /**
     * Adds metaboxes
     * 
     * @since 1.0.0
     */
    public function add_metaboxes()
    {
        add_meta_box(
            'note_details',
            __( 'Details', 'wpclear' ),
            array( $this, 'note_details' ),
            'note',
            'normal',
            'high'
        );
    }

    /**
     * The HTML output for showing the note details metabox.
     * 
     * @since 1.0.0
     */
    public function note_details()
    {
        global $post;

        wp_nonce_field( basename( __FILE__ ), 'note_details' );

        $pinned = get_post_meta( $post->ID, 'pinned', true );

        include( wpclear_plugin_path() . 'templates/metaboxes/note-details.php' );
    }

    /**
     * Save the metabox data
     */
    public function save_meta( $post_id, $post ) 
    {
        // Return if the user doesn't have edit permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) && 'note' != $post->post_type ) { 
            return $post_id; 
        }

        // Verify nonce
        $nonce = isset( $_POST['note_details'] ) ? $_POST['note_details'] : '';

        if ( ! wp_verify_nonce( $nonce, basename( __FILE__ ) ) ) { 
            return $post_id; 
        }

        // Now that we're authenticated, time to save the data.
        // This sanitizes the data from the field and saves it into an array $note_meta.
        $note_meta['pinned'] = esc_textarea( $_POST['pinned'] );

        // Loop through the $investment_meta array.
        foreach ( $note_meta as $key => $value ) {
            if ( 'revision' === $post->post_type ) {
                return;
            }

            if ( get_post_meta( $post_id, $key, false ) ) {
                // If the custom field already has a value, update it.
                update_post_meta( $post_id, $key, $value ); 
            } else {
                // If the custom field doesn't have a value, add it.
                add_post_meta( $post_id, $key, $value ); 
            }

            if ( ! $value ) {
                // Delete the meta key if there's no value
                delete_post_meta( $post_id, $key ); 
            }
        }
    }
}
