<?php

class Sample
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    /**
     * Register the quiz routes.
     */
    public function register_routes()
    {
        register_rest_route( 'twg-quizzes/v1', 'accidental-diminisher-quiz', array(
            'methods'  => 'POST',
            'callback' => array( $this, 'init' ),
            'permission_callback' => '__return_true',
        ) );
    }

    /**
     * Save the user contact form information.
     */
    public function init( $request )
    {
        // Validate the data.
        $errors = wpt_validate_rest_request( $request, array(
            'email' => array(
                'required' => 'Email is required',
                'email' => 'Email is invalid',
            ),
            'name' => array(
                'required' => 'Name is required',
            ),
        ) );

        // If there are errors, return them.
        if ( ! empty( $errors ) ) {
            return new WP_Error( 'errors', 'There was an error', array( 'status' => 400, 'errors' => $errors ) );
        }

        // Get the parameters.
        $email = $request->get_param( 'email' );
        $name = $request->get_param( 'name' );

        // Save the user data.
        
        // Return the user data.
        return new WP_REST_Response( array( 'status' => 'success'), 200 );
    }
}

new Sample();
