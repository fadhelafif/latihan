<?php 

add_action( 'init', 'location_post_type' );
function location_post_type() {
  register_post_type( 'post_location',
    array(
      'labels' => array(
        'name' => __( 'Locations' ),
        'singular_name' => __( 'Location' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
