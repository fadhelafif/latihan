<?php
/**
 * simonwarner
 *
 * simonwarner Theme by Calibrefx Team
 *
 * @package     simonwarner
 * @author      Calibrefx Team
 * @link        http://www.calibrefx.com/
 * @since       Version 1.0
 * @filesource 
 *
 * @package simonwarner
 */
add_action('admin_init', 'simonwarner_load_admin_scripts');
/**
 * This function loads the admin CSS files
 */
function simonwarner_load_admin_scripts() {
    wp_enqueue_style('simonwarner-admin', CHILD_CSS_URL . '/admin.style.css');

    wp_enqueue_script('simonwarner-admin', CHILD_JS_URL . '/admin.functions.js', array('jquery'));
}


add_action('init', 'simonwarner_register_scripts');
/**
 * This function register our style and script files
 */
function simonwarner_register_scripts(){   
    wp_register_script('simonwarner-functions', CHILD_JS_URL . '/functions.js', array('jquery'));
}

/**
 * This function load our style and script files
 */
add_action('calibrefx_meta', 'simonwarner_load_script');
function simonwarner_load_script(){   
	wp_enqueue_script('simonwarner-functions');
    
}
