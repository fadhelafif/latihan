<?php 

add_action( 'init', 'product_post_type' );
function product_post_type() {
  register_post_type( 'post_product',
    array(
      'labels' => array(
        'name' => __( 'Products' ),
        'singular_name' => __( 'Product' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
