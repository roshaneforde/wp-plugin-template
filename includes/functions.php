<?php

/**
 * General functions for your plugin with a few already written for you.
 * 
 * @package wp-plugin-template
 * @since 1.0.0
 */

/**
 * Retrieve the name of the plugin.
 * 
 * @since 1.0.0
 * @return string
 */
function wpt_plugin_name()
{
    return WP_PLUGIN_TEMPLATE_NAME;
}

/**
 * Retrieve the prefix of the plugin.
 * 
 * @since 1.0.0
 * @return string
 */
function wpt_plugin_prefix()
{
    return WP_PLUGIN_TEMPLATE_PREFIX;
}

/**
 * Retrieve the version number of the plugin.
 * 
 * @since 1.0.0
 * @return string
 */
function wpt_plugin_version()
{
    return WP_PLUGIN_TEMPLATE_VERSION;
}

/**
 * Retrieve the url of the plugin.
 * 
 * @since 1.0.0
 * @return string
 */
function wpt_plugin_url()
{
    return WP_PLUGIN_TEMPLATE_URL;
}

/**
 * Retrieve the path of the plugin.
 * 
 * @since 1.0.0
 * @return string
 */
function wpt_plugin_path()
{
    return WP_PLUGIN_TEMPLATE_PATH;
}

/**
 * Path for default avatar image.
 * 
 * @since 1.0.0
 * @return string
 */
function wpt_default_avatar_image()
{
    return wpt_plugin_url() . 'img/default-avatar.png';
}

/**
 * Add default url protocol if it's not present.
 * 
 * @since 1.0.0
 * @param string $url
 */
function wpt_add_url_protocol( $url )
{
    if ( strpos( $url, 'http' ) === false || strpos( $url, 'https'  === false ) ) {
        $url = 'http://' .$url;
    }

    return $url;
}

/**
 * Show theme's 404 page.
 * 
 * @since 1.0.0
 * @return void
 */
function wpt_template_show_404()
{
    global $wp_query;

    $wp_query->set_404();

    status_header ( 404 );

    nocache_headers();

    include( get_query_template( '404' ) );

    die();
}

/**
 * Get wordpress pages.
 * 
 * @since 1.0.0
 * @param array $args
 */
function wpt_get_pages( $args )
{
    $pages = array();

    foreach ( get_pages( $args ) as $page ) {
        $pages[] = array(
            'url'   => get_permalink( $page->ID )
        );
    }
    
    return $pages;
}

/**
 * Validate rest api requests
 */
function wpt_validate_rest_request( $request, $fields ) {
	$errors = array();

	foreach ( $fields as $field => $rules ) {
		// If the field is required.
		if ( isset( $rules['required'] ) && $rules['required'] && empty( $request->get_param( $field ) ) ) {
			$errors[ $field ] = $rules['required'];
		}

		// Email.
		if ( $field === 'email' ) {
			// If not valid email.
			if ( isset( $rules['email'] ) && ! empty( $request->get_param( $field ) ) && ! is_email( $request->get_param( $field ) ) ) {
				$errors[ $field ] = $rules['email'];
			}

			// If email should be unique.
			if ( isset( $rules['unique'] ) && ! empty( $request->get_param( $field ) ) && email_exists( $request->get_param( $field ) ) ) {
				$user = cc_get_user_from_email( $request->get_param( $field ) );

				// If the email is not the same as the user's email, add an error.
				if ( $request->get_param( $field ) !== $user->user_email ) {
					$errors[ $field ] = $rules['unique'];
				}
			}

			// If email and it doesn't exist.
			if ( isset( $rules['exists'] ) && ! empty( $request->get_param( $field ) ) && is_email( $request->get_param( $field ) ) && ! email_exists( $request->get_param( $field ) ) ) {
				$errors[ $field ] = $rules['exists'];
			}
		}

		// Password.
		if ( $field === 'password' ) {
			// If not valid password.
			if ( isset( $rules['format'] ) && ! empty( $request->get_param( $field ) ) && ! preg_match( '/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%&]{6,20}$/', $request->get_param( $field ) ) ) {
				$errors[ $field ] = $rules['format'];
			}
		}

		// Password confirm.
		if ( $field === 'password-confirm' ) {
			// If the field doesn't match the password.
			if ( isset( $rules['match'] ) && ! empty( $request->get_param( $field ) ) && $request->get_param( $field ) !== $request->get_param( $rules['match']['field'] ) ) {
				$errors[ $field ] = $rules['match']['message'];
			}
		}
	}

	return $errors;
}

/**
 * Get the blocks from a page.
 */
function wpt_get_page_blocks( $post_id, $block_name = '' ) {
	$blocks = array();
	$post = get_post( $post_id );

	// If the post has blocks.
	if ( has_blocks( $post->post_content ) ) {
		$blocks = parse_blocks( $post->post_content );

		// If we have a block name.
		if ( $block_name ) {
			$block = array();

			foreach ( $blocks as $b ) {
				if ( $b['blockName'] === $block_name ) {
					$block = $b;
					break;
				}
			}

			$blocks = $block;
		}
	}

	return $blocks;
}

/**
 * Get all notes.
 * 
 * @since 1.0.0
 * @return array $notes_data
 */
function wpt_all_notes()
{
    $notes = get_posts( array(
        'posts_per_page'    => -1,
        'post_type'         => 'note',
        'order'         => 'DESC',
    ) );

    $notes_data = array();

    foreach ( $notes as $note ) {
        // Get notes details
        $pinned = get_post_meta( $note->ID, 'pinned', true );

        // Note categories
        $notes_categories = array();

        $categories = get_the_terms( $note->ID, 'notes_category' );
            
        if ( $categories && ! is_wp_error( $categories ) ) {
            foreach ( $categories as $category ) {
                $notes_categories[] = array(
                    'name' => esc_html__( $category->name, 'wp-plugin-template' ),
                    'slug' => $category->slug,
                );
            }
        }

        $notes_data[] = array( 
            'id' => $note->ID,
            'title' => $note->post_title,
            'category' => $notes_categories,
            'content' => $note->post_content,
            'pinned' => $pinned,
        );
    }

    return $notes_data;
}
