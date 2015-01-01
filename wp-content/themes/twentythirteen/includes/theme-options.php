<?php



/**
 * Initialize the custom theme options.
 */
add_action( 'admin_init', 'custom_theme_options', 1 );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  
  /* OptionTree is not loaded yet */
  if ( ! function_exists( 'ot_settings_id' ) )
    return false;
    
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( ot_settings_id(), array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'contact',
        'title'       => 'Contact'
      ),
      array(
        'id'          => 'image',
        'title'       => 'Image'
      ),
      array(
        'id'          => 'copyright',
        'title'       => 'Copyright'
      ),
      array(
        'id'          => 'about',
        'title'       => 'About'
      ),      
      array(
        'id'          => 'banner',
        'title'       => 'Banner'
      ),
    ),
    'settings'        => array( 
      array(
        'id'          => 'contact_address',
        'label'       => 'Address',
        'desc'        => 'Description for the sample text field.',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'contact',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'logo',
        'label'       => 'Logo',
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'image',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'web_copyright',
        'label'       => 'Copyright',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'copyright',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'name',
        'label'       => 'Name',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'about',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'description',
        'label'       => 'Description',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'about',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'banner_image',
        'label'       => 'Banner Image',
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'banner',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( ot_settings_id() . '_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( ot_settings_id(), $custom_settings ); 
  }
  
  /* Lets OptionTree know the UI Builder is being overridden */
  global $ot_has_custom_theme_options;
  $ot_has_custom_theme_options = true;
  
}