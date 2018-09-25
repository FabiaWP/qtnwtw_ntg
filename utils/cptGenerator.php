<?php
// Our custom post type function
function create_posttype() {

    register_post_type( 'notification',
    // CPT Options
    array(
        'labels' => array(
            'name' => __( 'Notifications' ),
            'singular_name' => __( 'Notification' )
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'notifications'),
    )
);
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );
