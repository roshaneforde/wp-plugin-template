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
        add_action( 'init', array( $this, 'register_custom_post_type' ) );
        add_action( 'init', array( $this, 'add_taxonomies' ), 0 );

        add_action( 'add_meta_boxes', array( $this, 'add_metaboxes' ), 1 );
        add_action( 'save_post', array( $this, 'save_meta' ), 1, 2 );
    }

    /**
     * Register the custom post type
     * 
     * @since 1.0.0
     */
    public function register_custom_post_type()
    {
        $labels = array(
            'name'                  => __( 'Notes', 'wp-plugin-template' ),
            'singular_name'         => __( 'Note', 'wp-plugin-template' ),
            'menu_name'             => __( 'Notes', 'wp-plugin-template' ),
            'all_items'             => __( 'All Notes', 'wp-plugin-template' ),
            'add_new_item'          => __( 'Add New Note', 'wp-plugin-template' ),
            'add_new'               => __( 'Add Note', 'wp-plugin-template' ),
            'new_item'              => __( 'New Note', 'wp-plugin-template' ),
            'edit_item'             => __( 'Edit Note', 'wp-plugin-template' ),
            'update_item'           => __( 'Update Note', 'wp-plugin-template' ),
            'view_item'             => __( 'View Note', 'wp-plugin-template' ),
            'view_items'            => __( 'View Notes', 'wp-plugin-template' ),
            'search_items'          => __( 'Search Notes', 'wp-plugin-template' ),
            'not_found'             => __( 'No Notes found', 'wp-plugin-template' ),
            'not_found_in_trash'    => __( 'No Notes found in Trash', 'wp-plugin-template' ),
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
                    'name'              => __( 'Categories', 'wp-plugin-template' ),
                    'singular_name'     => __( 'Category', 'wp-plugin-template' ),
                    'search_items'      => __( 'Search Categories', 'wp-plugin-template' ),
                    'all_items'         => __( 'All Categories', 'wp-plugin-template' ),
                    'parent_item'       => __( 'Parent Category', 'wp-plugin-template' ),
                    'parent_item_colon' => __( 'Parent Category:', 'wp-plugin-template' ),
                    'edit_item'         => __( 'Edit Category', 'wp-plugin-template' ),
                    'update_item'       => __( 'Update Category', 'wp-plugin-template' ),
                    'add_new_item'      => __( 'Add New Category', 'wp-plugin-template' ),
                    'new_item_name'     => __( 'New Category Name', 'wp-plugin-template' ),
                    'menu_name'         => __( 'Categories', 'wp-plugin-template' ),
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
            __( 'Details', 'wp-plugin-template' ),
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

        include( wp_plugin_template_plugin_path() . 'templates/metaboxes/note-details.php' );
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

new Notes();
