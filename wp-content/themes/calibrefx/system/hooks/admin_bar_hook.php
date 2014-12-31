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

add_action('init', 'calibrefx_remove_admin_bar', 5);

/**
 * This will remove wordpress admin bar in admin area
 */
function calibrefx_remove_admin_bar() {
    //remove_action('init', '_calibrefx_admin_bar_init');
    //remove_action('admin_footer', 'calibrefx_admin_bar_render');
    remove_action( 'in_admin_header', 'wp_admin_bar_render', 0 );
}
add_action('init', 'calibrefx_admin_bar_init');
/**
 * This will add calibrefx admin bar
 */
function calibrefx_admin_bar_init() {
    global $calibrefx_admin_bar, $calibrefx;

    /* Instantiate the admin bar */
    $calibrefx->load->library('admin_bar');
    
    //@TODO: need to change this later
    $calibrefx_admin_bar = $calibrefx->admin_bar;
    
    $calibrefx_admin_bar->initialize();
    $calibrefx_admin_bar->add_top_bar();
    $calibrefx_admin_bar->add_bottom_bar();

    return true;
}

add_action('init', 'calibrefx_admin_bar_add_menu', 15);
function calibrefx_admin_bar_add_menu(){
    calibrefx_clear_admin_menu();
    calibrefx_add_admin_menu('Posts', 'edit_posts', 'posts', admin_url('edit.php'));
    calibrefx_add_admin_submenu('posts', 'All Posts', 'edit_posts', 'posts_all_post', admin_url('edit.php'));
    calibrefx_add_admin_submenu('posts', 'Add New', 'edit_posts', 'posts_add_new_post', admin_url('post-new.php'));
    calibrefx_add_admin_submenu('posts', 'Categories', 'edit_posts', 'posts_categories', admin_url('edit-tags.php?taxonomy=category'));
    calibrefx_add_admin_submenu('posts', 'Tags', 'edit_posts', 'posts_tags', admin_url('edit-tags.php?taxonomy=post_tag'));
    
    calibrefx_add_admin_menu('Pages', 'edit_pages', 'pages', admin_url('edit.php?post_type=page'));
    calibrefx_add_admin_submenu('pages', 'All Pages', 'edit_pages', 'pages_all_post', admin_url('edit.php?post_type=page'));
    calibrefx_add_admin_submenu('pages', 'Add New', 'edit_pages', 'pages_all_post', admin_url('post-new.php?post_type=page'));
    
    calibrefx_add_admin_menu('Menus', 'edit_theme_options', 'menus', admin_url('nav-menus.php'));
}


add_action('admin_footer', 'calibrefx_admin_bar_render', 1000);

/**
 * Render the calibrefx admin bar to the page.
 * This is called very late on the footer actions so that it will render after anything else being
 * added to the footer.
 */
function calibrefx_admin_bar_render() {
    global $calibrefx_admin_bar;

    do_action_ref_array('calibrefx_admin_bar_menu', array(&$calibrefx_admin_bar));

    do_action('calibrefx_before_admin_bar_render');

    $calibrefx_admin_bar->render();

    do_action('calibrefx_after_admin_bar_render');
    do_action( 'wp_after_admin_bar_render');
}

/**
 * Add the "My Account" item.
 */
function calibrefx_admin_bar_my_account_item($calibrefx_admin_bar) {
    $user_id = get_current_user_id();
    $current_user = wp_get_current_user();
    $profile_url = get_edit_profile_url($user_id);

    if (!$user_id)
        return;

    $avatar = get_avatar($user_id, 16);
    $howdy = sprintf(__('Welcome, %1$s', 'calibrefx'), $current_user->display_name);
    $class = empty($avatar) ? '' : 'with-avatar';

    $calibrefx_admin_bar->add_menu(array(
        'id' => 'my-account',
        'parent' => 'top-secondary',
        'title' => $howdy . $avatar,
        'href' => $profile_url,
        'meta' => array(
            'class' => $class,
            'title' => __('My Account', 'calibrefx'),
        ),
    ));
}

/**
 * Add search form.
 *
 * @since 3.3.0
 */
function calibrefx_admin_bar_search_menu($calibrefx_admin_bar) {
    if (is_admin())
        return;

    $form = '<form action="' . esc_url(home_url('/')) . '" method="get" id="adminbarsearch">';
    $form .= '<input class="adminbar-input" name="s" id="adminbar-search" tabindex="10" type="text" value="" maxlength="150" />';
    $form .= '<input type="submit" class="adminbar-button" value="' . __('Search', 'calibrefx') . '"/>';
    $form .= '</form>';

    $calibrefx_admin_bar->add_menu(array(
        'parent' => 'top-secondary',
        'id' => 'search',
        'title' => $form,
        'meta' => array(
            'class' => 'admin-bar-search',
            'tabindex' => -1,
        )
    ));
}

function calibrefx_admin_bar_my_account_menu($calibrefx_admin_bar) {
    $user_id = get_current_user_id();
    $current_user = wp_get_current_user();
    $profile_url = get_edit_profile_url($user_id);

    if (!$user_id)
        return;

    $calibrefx_admin_bar->add_group(array(
        'parent' => 'my-account',
        'id' => 'user-actions',
    ));

    $user_info = get_avatar($user_id, 64);
    $user_info .= "<span class='display-name'>{$current_user->display_name}</span>";

    if ($current_user->display_name !== $current_user->user_nicename)
        $user_info .= "<span class='username'>{$current_user->user_nicename}</span>";

    $calibrefx_admin_bar->add_menu(array(
        'parent' => 'user-actions',
        'id' => 'user-info',
        'title' => $user_info,
        'href' => $profile_url,
        'meta' => array(
            'tabindex' => -1,
        ),
    ));
    $calibrefx_admin_bar->add_menu(array(
        'parent' => 'user-actions',
        'id' => 'edit-profile',
        'title' => __('Edit My Profile', 'calibrefx'),
        'href' => $profile_url,
    ));
    $calibrefx_admin_bar->add_menu(array(
        'parent' => 'user-actions',
        'id' => 'logout',
        'title' => __('Log Out', 'calibrefx'),
        'href' => wp_logout_url(),
    ));
}

function calibrefx_admin_bar_wp_menu($calibrefx_admin_bar) {
    $calibrefx_admin_bar->add_menu(array(
        'id' => 'wp-logo',
        'title' => '<span class="ab-icon"></span>',
        'href' => admin_url('about.php'),
        'meta' => array(
            'title' => __('About WordPress', 'calibrefx'),
        ),
    ));

    // Add WordPress.org link
    $calibrefx_admin_bar->add_menu(array(
        'parent' => 'wp-logo-external',
        'id' => 'wporg',
        'title' => 'WordPress.org',
        'href' => 'http://wordpress.org',
    ));
}

function calibrefx_admin_bar_add_top_groups($calibrefx_admin_bar) {
    $calibrefx_admin_bar->add_group(array(
        'id' => 'top-secondary',
        'meta' => array(
            'class' => 'ab-top-secondary',
        ),
    ));

    $calibrefx_admin_bar->add_group(array(
        'parent' => 'wp-logo',
        'id' => 'wp-logo-external',
        'meta' => array(
            'class' => 'ab-sub-secondary',
        ),
    ));
}

function calibrefx_admin_bar_site_menu($calibrefx_admin_bar) {
    global $current_site;

    // Don't show for logged out users.
    if (!is_user_logged_in())
        return;

    // Show only when the user is a member of this site, or they're a super admin.
    if (!is_user_member_of_blog() && !is_super_admin())
        return;

    $blogname = get_bloginfo('name');

    if (empty($blogname))
        $blogname = preg_replace('#^(https?://)?(www.)?#', '', get_home_url());

    if (is_network_admin()) {
        $blogname = sprintf(__('Network Admin: %s', 'calibrefx'), esc_html($current_site->site_name));
    } elseif (is_user_admin()) {
        $blogname = sprintf(__('Global Dashboard: %s', 'calibrefx'), esc_html($current_site->site_name));
    }

    $title = wp_html_excerpt($blogname, 40);
    if ($title != $blogname)
        $title = trim($title) . '&hellip;';

    $calibrefx_admin_bar->add_menu(array(
        'id' => 'site-name',
        'title' => $title,
        'href' => is_admin() ? home_url('/') : admin_url(),
    ));

    // Create submenu items.

    if (is_admin()) {
        // Add an option to visit the site.
        $calibrefx_admin_bar->add_menu(array(
            'parent' => 'site-name',
            'id' => 'view-site',
            'title' => __('Visit Site', 'calibrefx'),
            'href' => home_url('/'),
        ));

        // We're on the front end, print a copy of the admin menu.
    } else {
        // Add the dashboard item.
        $calibrefx_admin_bar->add_menu(array(
            'parent' => 'site-name',
            'id' => 'dashboard',
            'title' => __('Dashboard', 'calibrefx'),
            'href' => admin_url(),
        ));

        // Add the appearance submenu items.
        calibrefx_admin_bar_appearance_menu($calibrefx_admin_bar);
    }
}
