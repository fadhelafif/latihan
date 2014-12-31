<?php defined('CALIBREFX_URL') OR exit();
/**
 * CalibreFx Framework
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package     CalibreFx
 * @author      CalibreFx Team
 * @authorlink  http://www.calibrefx.com
 * @copyright   Copyright (c) 2012-2013, CalibreWorks. (http://www.calibreworks.com/)
 * @license     GNU GPL v2
 * @link        http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This define the framework constants
 *
 * @package CalibreFx
 */

/**
 * Calibrefx Inpost Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */
add_action('admin_menu', 'calibrefx_add_inpost_layout_box');

/**
 * Register a new meta box to the post / page edit screen, so that the user can
 * set layout options on a per-post or per-page basis.
 *
 * @access public
 * @author Hilaladdiyar <hilal@calibrefx.com>
 * @return void
 *
 */
function calibrefx_add_inpost_layout_box() {
    if (!current_theme_supports('calibrefx-inpost-layouts'))
        return;
    
    foreach ((array) get_post_types(array('public' => true)) as $type) {
        if (post_type_supports($type, 'calibrefx-layouts'))
            add_meta_box('calibrefx_inpost_layout_box', __('Calibrefx Custom Layout', 'calibrefx'), 'calibrefx_inpost_layout_box', $type, 'normal', 'high');
    }
}

/**
 * Show inpost layout box
 */
function calibrefx_inpost_layout_box() {

    wp_nonce_field('calibrefx_inpost_layout_action', 'calibrefx_inpost_layout_nonce');

    $layout = calibrefx_get_custom_field('site_layout');
    ?>
    <div class="calibrefx-layout-selector">
        <p><input type="radio" name="_calibrefx_layout" id="default-layout" value="" <?php checked($layout, ''); ?> /> <label class="default" for="default-layout"><?php printf(__('Default Layout set in <a href="%s">Theme Settings</a>', 'calibrefx'), menu_page_url('calibrefx', 0)); ?></label></p>

        <p><?php calibrefx_layout_selector(array('name' => '_calibrefx_layout', 'selected' => $layout, 'type' => 'site')); ?></p>
    </div>

    <br class="clear" />

    <p><label for="calibrefx_custom_body_class"><b><?php _e('Custom Body Class', 'calibrefx'); ?></b></label></p>
    <p><input class="large-text" type="text" name="_calibrefx_custom_body_class" id="calibrefx_custom_body_class" value="<?php echo esc_attr(sanitize_html_class(calibrefx_get_custom_field('_calibrefx_custom_body_class'))); ?>" /></p>

    <p><label for="calibrefx_custom_post_class"><b><?php _e('Custom Post Class', 'calibrefx'); ?></b></label></p>
    <p><input class="large-text" type="text" name="_calibrefx_custom_post_class" id="calibrefx_custom_post_class" value="<?php echo esc_attr(sanitize_html_class(calibrefx_get_custom_field('_calibrefx_custom_post_class'))); ?>" /></p>
    <?php
}

add_action('save_post', 'calibrefx_inpost_layout_save', 1, 2);

/**
 * Saves the layout options when we save a post / page.
 *
 * It does so by grabbing the array passed in $_POST, looping through it, and
 * saving each key / value pair as a custom field.
 *
 * @access public
 * @author Hilaladdiyar <hilal@calibrefx.com>
 * @return voides
 */
function calibrefx_inpost_layout_save($post_id, $post) {
    global $calibrefx;
    
    if(!in_array($post->post_type, get_post_types(array('public' => true)))) return $post->ID;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
    if (defined('DOING_CRON') && DOING_CRON)
        return;
    
    if(!$calibrefx->security->verify_nonce('calibrefx_inpost_layout_action','calibrefx_inpost_layout_nonce')){    
        return $post_id;
    }
    
    calibrefx_log_message('debug', 'POST LAYOUT:'.$_POST['_calibrefx_layout']);
    

    if (( 'page' == $_POST['post_type'] && !current_user_can('edit_page', $post_id) ) || !current_user_can('edit_post', $post_id))
        return $post_id;

    $calibrefx_post_layout = $_POST['_calibrefx_layout'];
    
    
    if ($calibrefx_post_layout)
        update_post_meta($post_id, 'site_layout', $calibrefx_post_layout);
    else
        delete_post_meta($post_id, 'site_layout');

    $calibrefx_custom_body_class = $_POST['_calibrefx_custom_body_class'];

    if ($calibrefx_custom_body_class)
        update_post_meta($post_id, '_calibrefx_custom_body_class', $calibrefx_custom_body_class);
    else
        delete_post_meta($post_id, '_calibrefx_custom_body_class');

    $calibrefx_custom_post_class = $_POST['_calibrefx_custom_post_class'];

    if ($calibrefx_custom_post_class)
        update_post_meta($post_id, '_calibrefx_custom_post_class', $calibrefx_custom_post_class);
    else
        delete_post_meta($post_id, '_calibrefx_custom_post_class');
}