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
 * Calibrefx SEO Hooks
 *
 * @package     Calibrefx
 * @subpackage          Hook
 * @author      CalibreFx Team
 * @since       Version 1.0
 * @link        http://www.calibrefx.com
 */

add_action( 'calibrefx_seo', 'calibrefx_init_seo_hook' );
function calibrefx_init_seo_hook(){
    global $calibrefx;
    //developer can deactivate this from the functions.php
    if($calibrefx->seo_settings_m->get('enable_seo')){
        add_filter('calibrefx_do_title', 'calibrefx_seo_title');
        add_filter('calibrefx_do_meta_description', 'calibrefx_seo_description');
        add_filter('calibrefx_do_meta_keywords', 'calibrefx_seo_keywords');
        add_filter('calibrefx_do_link_author', 'calibrefx_link_author');
        add_filter('calibrefx_do_link_publisher', 'calibrefx_link_publisher');
        add_action('calibrefx_meta', 'calibrefx_do_meta_robot');
        add_action('wp_head', 'calibrefx_canonical', 5);
        add_action('template_redirect', 'calibrefx_custom_redirect', 5);
    }
}

/**
 * Generate SEO title based on the format given
 */
function calibrefx_seo_title() {
    global $calibrefx;

    $replace_tags = get_replace_title_tags();
    
    $cfx_replacer = $calibrefx->replacer->set_replace_tag($replace_tags);

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    if($paged != 1){
        $paged = ' - Page ' . $paged;
    }else{
        $paged = '';
    }

    if (is_home() || is_front_page()) {
        $post_seo_title = calibrefx_get_custom_field('_calibrefx_title');
        $home_title = calibrefx_get_option('home_title', $calibrefx->seo_settings_m);
        
        if ($home_title){
            return $home_title . $paged;
        }elseif($post_seo_title){
            return $post_seo_title . $paged;
        }
        else{
            return get_bloginfo('name') . $paged;
        }
    }

    if (is_category()) {
        return $cfx_replacer->get(calibrefx_get_option('category_rewrite_title', $calibrefx->seo_settings_m)) . $paged;
    }

    if (is_date()) {
        return $cfx_replacer->get(calibrefx_get_option('archive_rewrite_title', $calibrefx->seo_settings_m)) . $paged;
    }
    
    if (is_tax()) {        
        return $cfx_replacer->get(calibrefx_get_option('taxonomy_rewrite_title', $calibrefx->seo_settings_m)) . $paged;
    }

    if (is_tag()) {
        return $cfx_replacer->get(calibrefx_get_option('tag_rewrite_title', $calibrefx->seo_settings_m)) . $paged;
    }

    if (is_page()) {
        return $cfx_replacer->get(calibrefx_get_option('page_rewrite_title', $calibrefx->seo_settings_m)) . $paged;
    }

    if (is_single()) {
        return $cfx_replacer->get(calibrefx_get_option('post_rewrite_title', $calibrefx->seo_settings_m)) . $paged;
    }

    if (is_author()) {
        return $cfx_replacer->get(calibrefx_get_option('author_rewrite_title', $calibrefx->seo_settings_m)) . $paged;
    }

    if (is_search()) {
        return $cfx_replacer->get(calibrefx_get_option('search_rewrite_title', $calibrefx->seo_settings_m)) . $paged;
    }

    if (is_404()) {
        return $cfx_replacer->get(calibrefx_get_option('404_rewrite_title', $calibrefx->seo_settings_m));
    }

    if(is_archive()){
        return $cfx_replacer->get(calibrefx_get_option('taxonomy_rewrite_title', $calibrefx->seo_settings_m)) . $paged;
    }
}

/**
 * Generate SEO description based on the format given
 */
function calibrefx_seo_description() {
    global $calibrefx;
    $replace_tags = get_replace_title_tags();
    
    $cfx_replacer = $calibrefx->replacer->set_replace_tag($replace_tags);

    if (is_home() || is_front_page()) {
        $post_seo_description = calibrefx_get_custom_field('_calibrefx_description');  
        $home_description = calibrefx_get_option('home_meta_description', $calibrefx->seo_settings_m);
        
        if($post_seo_description)
            return $post_seo_description;
        elseif ($home_description)
            return $home_description;
        else
            return get_bloginfo('description');
    }

    if (is_category()) {
        return $cfx_replacer->get(calibrefx_get_option('category_description', $calibrefx->seo_settings_m));
    }

    if (is_date()) {
        return $cfx_replacer->get(calibrefx_get_option('archive_description', $calibrefx->seo_settings_m));
    }

    if (is_tag()) {
        return $cfx_replacer->get(calibrefx_get_option('tag_description', $calibrefx->seo_settings_m));
    }

    if (is_page()) {
        return $cfx_replacer->get(calibrefx_get_option('page_description', $calibrefx->seo_settings_m));
    }

    if (is_single()) {
        return $cfx_replacer->get(calibrefx_get_option('post_description', $calibrefx->seo_settings_m));
    }

    if (is_author()) {
        return $cfx_replacer->get(calibrefx_get_option('author_description', $calibrefx->seo_settings_m));
    }

    if (is_search()) {
        return $cfx_replacer->get(calibrefx_get_option('search_description', $calibrefx->seo_settings_m));
    }

    if (is_404()) {
        return $cfx_replacer->get(calibrefx_get_option('404_description', $calibrefx->seo_settings_m));
    }

    if(is_archive()){
        return $cfx_replacer->get(calibrefx_get_option('taxonomy_description', $calibrefx->seo_settings_m));
    }
}

/**
 * Generate SEO keywords based on the format given
 */
function calibrefx_seo_keywords() {
    global $calibrefx;
    $replace_tags = get_replace_title_tags();

    $cfx_replacer = $calibrefx->replacer->set_replace_tag($replace_tags);

    if (is_home() || is_front_page()) {        
        $post_seo_keywords = calibrefx_get_custom_field('_calibrefx_keywords');  
        $home_keywords = calibrefx_get_option('home_meta_keywords', $calibrefx->seo_settings_m);
        
        if($post_seo_keywords)
            return $post_seo_keywords;
        else
            return $home_keywords;
    }

    if (is_category()) {
        return $cfx_replacer->get(calibrefx_get_option('category_keywords', $calibrefx->seo_settings_m));
    }

    if (is_date()) {
        return $cfx_replacer->get(calibrefx_get_option('archive_keywords', $calibrefx->seo_settings_m));
    }

    if (is_tag()) {
        return $cfx_replacer->get(calibrefx_get_option('tag_keywords', $calibrefx->seo_settings_m));
    }

    if (is_page()) {
        return $cfx_replacer->get(calibrefx_get_option('page_keywords', $calibrefx->seo_settings_m));
    }

    if (is_single()) {
        return $cfx_replacer->get(calibrefx_get_option('post_keywords', $calibrefx->seo_settings_m));
    }

    if (is_author()) {
        return $cfx_replacer->get(calibrefx_get_option('author_keywords', $calibrefx->seo_settings_m));
    }

    if (is_search()) {
        return $cfx_replacer->get(calibrefx_get_option('search_keywords', $calibrefx->seo_settings_m));
    }

    if (is_404()) {
        return $cfx_replacer->get(calibrefx_get_option('404_keywords', $calibrefx->seo_settings_m));
    }

    if(is_archive()){
        return $cfx_replacer->get(calibrefx_get_option('taxonomy_keywords', $calibrefx->seo_settings_m));
    }
}

/**
 * Return link author URL to be displayed in html head
 */
function calibrefx_link_author(){
    if(is_single()){
        global $post;

        return esc_attr(get_the_author_meta('gplus_profile',$post->post_author));
    }else{
        return calibrefx_get_option('gplus_profile');
    }
}

/**
 * Return link publisher URL to be displayed in html head
 */
function calibrefx_link_publisher(){ 
    return calibrefx_get_option('gplus_page');        
}

/**
 * This function generates the index / follow / noodp / noydir / noarchive code
 * in the document <head>.
 */
function calibrefx_do_meta_robot() {
    global $wp_query, $post;
    global $calibrefx;

    /*
     * If the blog is private, then following logic is unnecessary as WP will
     * insert noindex and nofollow
     */
    if (0 == get_option('blog_public'))
        return;

    $meta = array(
        'noindex' => '',
        'nofollow' => '',
        'noarchive' => calibrefx_get_option('noarchive', $calibrefx->seo_settings_m) ? 'noarchive' : '',
        'noodp' => calibrefx_get_option('site_noodp', $calibrefx->seo_settings_m) ? 'noodp' : '',
        'noydir' => calibrefx_get_option('site_noydir', $calibrefx->seo_settings_m) ? 'noydir' : '',
    );

    /** Check home page SEO settings, set noindex, nofollow and noarchive */
    if (is_front_page()) {
        $meta['noindex'] = calibrefx_get_option('home_noindex', $calibrefx->seo_settings_m) ? 'noindex' : $meta['noindex'];
        $meta['nofollow'] = calibrefx_get_option('home_nofollow', $calibrefx->seo_settings_m) ? 'nofollow' : $meta['nofollow'];
        $meta['noarchive'] = calibrefx_get_option('home_noarchive', $calibrefx->seo_settings_m) ? 'noarchive' : $meta['noarchive'];
    }

    if (is_category()) {
        $term = $wp_query->get_queried_object();

        if(isset($term->meta['noindex'])) $meta['noindex'] = $term->meta['noindex'] ? 'noindex' : $meta['noindex'];
        if(isset($term->meta['nofollow'])) $meta['nofollow'] = $term->meta['nofollow'] ? 'nofollow' : $meta['nofollow'];
        if(isset($term->meta['noarchive'])) $meta['noarchive'] = $term->meta['noarchive'] ? 'noarchive' : $meta['noarchive'];

        $meta['noindex'] = calibrefx_get_option('category_noindex', $calibrefx->seo_settings_m) ? 'noindex' : $meta['noindex'];
        $meta['noarchive'] = calibrefx_get_option('category_noarchive', $calibrefx->seo_settings_m) ? 'noarchive' : $meta['noarchive'];

        /**     noindex paged archives, if canonical archives is off */
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $meta['noindex'] = $paged > 1 && !calibrefx_get_option('archive_canonical', $calibrefx->seo_settings_m) ? 'noindex' : $meta['noindex'];
    }

    if (is_tag()) {
        $term = $wp_query->get_queried_object();

        if(isset($term->meta['noindex'])) $meta['noindex'] = $term->meta['noindex'] ? 'noindex' : $meta['noindex'];
        if(isset($term->meta['nofollow'])) $meta['nofollow'] = $term->meta['nofollow'] ? 'nofollow' : $meta['nofollow'];
        if(isset($term->meta['noarchive'])) $meta['noarchive'] = $term->meta['noarchive'] ? 'noarchive' : $meta['noarchive'];

        $meta['noindex'] = calibrefx_get_option('tag_noindex', $calibrefx->seo_settings_m) ? 'noindex' : $meta['noindex'];
        $meta['noarchive'] = calibrefx_get_option('tag_noarchive', $calibrefx->seo_settings_m) ? 'noarchive' : $meta['noarchive'];

        /**     noindex paged archives, if canonical archives is off */
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $meta['noindex'] = $paged > 1 && !calibrefx_get_option('archive_canonical', $calibrefx->seo_settings_m) ? 'noindex' : $meta['noindex'];
    }

    if (is_tax()) {
        $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

        if(isset($term->meta['noindex'])) $meta['noindex'] = $term->meta['noindex'] ? 'noindex' : $meta['noindex'];
        if(isset($term->meta['nofollow'])) $meta['nofollow'] = $term->meta['nofollow'] ? 'nofollow' : $meta['nofollow'];
        if(isset($term->meta['noarchive'])) $meta['noarchive'] = $term->meta['noarchive'] ? 'noarchive' : $meta['noarchive'];

        /** noindex paged archives, if canonical archives is off */
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $meta['noindex'] = $paged > 1 && !calibrefx_get_option('archive_canonical', $calibrefx->seo_settings_m) ? 'noindex' : $meta['noindex'];
    }

    if (is_author()) {
        $meta['noindex'] = get_the_author_meta('noindex', (int) get_query_var('author')) ? 'noindex' : $meta['noindex'];
        $meta['nofollow'] = get_the_author_meta('nofollow', (int) get_query_var('author')) ? 'nofollow' : $meta['nofollow'];
        $meta['noarchive'] = get_the_author_meta('noarchive', (int) get_query_var('author')) ? 'noarchive' : $meta['noarchive'];

        $meta['noindex'] = calibrefx_get_option('author_noindex', $calibrefx->seo_settings_m) ? 'noindex' : $meta['noindex'];
        $meta['noarchive'] = calibrefx_get_option('author_noarchive', $calibrefx->seo_settings_m) ? 'noarchive' : $meta['noarchive'];

        /**     noindex paged archives, if canonical archives is off */
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $meta['noindex'] = $paged > 1 && !calibrefx_get_option('archive_canonical', $calibrefx->seo_settings_m) ? 'noindex' : $meta['noindex'];
    }

    if (is_date()) {
        $meta['noindex'] = calibrefx_get_option('date_noindex', $calibrefx->seo_settings_m) ? 'noindex' : $meta['noindex'];
        $meta['noarchive'] = calibrefx_get_option('date_noarchive', $calibrefx->seo_settings_m) ? 'noarchive' : $meta['noarchive'];
    }

    if (is_search()) {
        $meta['noindex'] = calibrefx_get_option('search_noindex', $calibrefx->seo_settings_m) ? 'noindex' : $meta['noindex'];
        $meta['noarchive'] = calibrefx_get_option('search_noarchive', $calibrefx->seo_settings_m) ? 'noarchive' : $meta['noarchive'];
    }

    if (is_singular()) {
        $meta['noindex'] = calibrefx_get_custom_field('_calibrefx_noindex') ? 'noindex' : $meta['noindex'];
        $meta['nofollow'] = calibrefx_get_custom_field('_calibrefx_nofollow') ? 'nofollow' : $meta['nofollow'];
        $meta['noarchive'] = calibrefx_get_custom_field('_calibrefx_noarchive') ? 'noarchive' : $meta['noarchive'];
    }

    /** Strip empty array items */
    $meta = array_filter($meta);

    /** Add meta if any exist */
    if ($meta)
        printf('<meta name="robots" content="%s" />' . "\n", implode(',', $meta));
}

/**
 * Echo custom canonical link tag.
 *
 * Remove the default WordPress canonical tag, and use our custom
 * one. Gives us more flexibility and effectiveness.
 *
 */
function calibrefx_canonical() {

    /** Remove the WordPress canonical */
    remove_action('wp_head', 'rel_canonical');

    global $wp_query, $calibrefx;

    $canonical = '';

    if (is_front_page())
        $canonical = trailingslashit(home_url());

    if (is_singular()) {
        if (!$id = $wp_query->get_queried_object_id())
            return;

        $cf = calibrefx_get_custom_field('_calibrefx_canonical_uri');

        $canonical = $cf ? $cf : get_permalink($id);
    }

    if (is_category() || is_tag() || is_tax()) {
        if (!$id = $wp_query->get_queried_object_id())
            return;

        $taxonomy = $wp_query->queried_object->taxonomy;

        $canonical = calibrefx_get_option('archive_canonical', $calibrefx->seo_settings_m) ? get_term_link((int) $id, $taxonomy) : 0;
    }

    if (is_author()) {
        if (!$id = $wp_query->get_queried_object_id())
            return;

        $canonical = calibrefx_get_option('archive_canonical', $calibrefx->seo_settings_m) ? get_author_posts_url($id) : 0;
    }

    if ($canonical)
        printf('<link rel="canonical" href="%s" />' . "\n", esc_url(apply_filters('calibrefx_canonical', $canonical)));
}

/**
 * Redirect to another post with permanent redirect 
 */
function calibrefx_custom_redirect(){
    $cf = calibrefx_get_custom_field('_calibrefx_redirect_url');
    
    if(!empty($cf)){
        wp_redirect( $cf, 301 );
        exit;
    }
}

add_action('admin_menu', 'calibrefx_add_inpost_seo_box');
/**
 * Register a new meta box to the post / page edit screen, so that the user can
 * set SEO options on a per-post or per-page basis.
 */
function calibrefx_add_inpost_seo_box() {
    global $calibrefx;
    foreach ((array) get_post_types(array('public' => true)) as $type) {
        if (post_type_supports($type, 'calibrefx-seo') AND current_theme_supports('calibrefx-seo') && $calibrefx->seo_settings_m->get('enable_seo'))
            add_meta_box('calibrefx_inpost_seo_box', __('CalibreFx SEO Settings', 'calibrefx'), 'calibrefx_inpost_seo_box', $type, 'normal', 'high');
    }
}

/**
 * Show inpost seo box
 */
function calibrefx_inpost_seo_box() {
    wp_nonce_field('calibrefx_inpost_seo_action', 'calibrefx_inpost_seo_nonce');
    ?>

    <p><label for="calibrefx_title"><b><?php _e('Custom Document Title', 'calibrefx'); ?></b> <abbr title="&lt;title&gt; Tag">[?]</abbr> <span class="hide-if-no-js"><?php printf(__('Characters Used: %s', 'calibrefx'), '<span id="calibrefx_title_chars">' . strlen(calibrefx_get_custom_field('_calibrefx_title')) . '</span>'); ?></span></label></p>
    <p><input class="large-text" type="text" name="calibrefx_seo[_calibrefx_title]" id="calibrefx_title" value="<?php echo esc_attr(calibrefx_get_custom_field('_calibrefx_title')); ?>" /></p>

    <p><label for="calibrefx_description"><b><?php _e('Custom Post/Page Meta Description', 'calibrefx'); ?></b> <abbr title="&lt;meta name=&quot;description&quot; /&gt;">[?]</abbr> <span class="hide-if-no-js"><?php printf(__('Characters Used: %s', 'calibrefx'), '<span id="calibrefx_description_chars">' . strlen(calibrefx_get_custom_field('_calibrefx_description')) . '</span>'); ?></span></label></p>
    <p><textarea class="large-text" name="calibrefx_seo[_calibrefx_description]" id="calibrefx_description" rows="4" cols="4"><?php echo esc_textarea(calibrefx_get_custom_field('_calibrefx_description')); ?></textarea></p>

    <p><label for="calibrefx_keywords"><b><?php _e('Custom Post/Page Meta Keywords, comma separated', 'calibrefx'); ?></b> <abbr title="&lt;meta name=&quot;keywords&quot; /&gt;">[?]</abbr></label></p>
    <p><input class="large-text" type="text" name="calibrefx_seo[_calibrefx_keywords]" id="calibrefx_keywords" value="<?php echo esc_attr(calibrefx_get_custom_field('_calibrefx_keywords')); ?>" /></p>

    <p><label for="calibrefx_canonical"><b><?php _e('Custom Canonical URI', 'calibrefx'); ?></b> <a href="http://www.mattcutts.com/blog/canonical-link-tag/" target="_blank" title="&lt;link rel=&quot;canonical&quot; /&gt;">[?]</a></label></p>
    <p><input class="large-text" type="text" name="calibrefx_seo[_calibrefx_canonical_uri]" id="calibrefx_canonical" value="<?php echo esc_url(calibrefx_get_custom_field('_calibrefx_canonical_uri')); ?>" /></p>

    <p><label for="calibrefx_redirect"><b><?php _e('Custom Redirect URI', 'calibrefx'); ?></b> <a href="http://www.google.com/support/webmasters/bin/answer.py?hl=en&amp;answer=93633" target="_blank" title="301 Redirect">[?]</a></label></p>
    <p><input class="large-text" type="text" name="calibrefx_seo[_calibrefx_redirect_url]" id="calibrefx_redirect_url" value="<?php echo esc_url(calibrefx_get_custom_field('_calibrefx_redirect_url')); ?>" /></p>

    <br />

    <p><b><?php _e('Robots Meta Settings', 'calibrefx'); ?></b></p>

    <p>
        <input type="checkbox" name="calibrefx_seo[_calibrefx_noindex]" id="calibrefx_noindex" value="1" <?php checked(calibrefx_get_custom_field('_calibrefx_noindex')); ?> />
        <label for="calibrefx_noindex"><?php printf(__('Apply %s to this post/page', 'calibrefx'), '<code>noindex</code>'); ?> <a href="http://www.robotstxt.org/meta.html" target="_blank">[?]</a></label><br />

        <input type="checkbox" name="calibrefx_seo[_calibrefx_nofollow]" id="calibrefx_nofollow" value="1" <?php checked(calibrefx_get_custom_field('_calibrefx_nofollow')); ?> />
        <label for="calibrefx_nofollow"><?php printf(__('Apply %s to this post/page', 'calibrefx'), '<code>nofollow</code>'); ?> <a href="http://www.robotstxt.org/meta.html" target="_blank">[?]</a></label><br />

        <input type="checkbox" name="calibrefx_seo[_calibrefx_noarchive]" id="calibrefx_noarchive" value="1" <?php checked(calibrefx_get_custom_field('_calibrefx_noarchive')); ?> />
        <label for="calibrefx_nofollow"><?php printf(__('Apply %s to this post/page', 'calibrefx'), '<code>noarchive</code>'); ?> <a href="http://www.ezau.com/latest/articles/no-archive.shtml" target="_blank">[?]</a></label>
    </p>

    <br />

    <p><label for="calibrefx_scripts"><b><?php _e('Custom Tracking/Conversion Code', 'calibrefx'); ?></b></label></p>
    <p><textarea class="large-text" rows="4" cols="4" name="calibrefx_seo[_calibrefx_scripts]" id="calibrefx_scripts"><?php echo esc_textarea(calibrefx_get_custom_field('_calibrefx_scripts')); ?></textarea></p>
    <?php
}

add_action('save_post', 'calibrefx_inpost_seo_save', 1, 2);

/**
 * Save the SEO settings when we save a post or page.
 */
function calibrefx_inpost_seo_save($post_id, $post) {
    global $calibrefx;
    
    if(!in_array($post->post_type, get_post_types(array('public' => true)))) return $post->ID;
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
    if (defined('DOING_CRON') && DOING_CRON)
        return;
    
    if(!$calibrefx->security->verify_nonce('calibrefx_inpost_seo_action','calibrefx_inpost_seo_nonce')){    
        return $post_id;
    }

    if (( 'page' == $_POST['post_type'] && !current_user_can('edit_page', $post->ID) ) || !current_user_can('edit_post', $post->ID))
        return $post->ID;

    /** Don't try to store data during revision save */
    if ('revision' == $post->post_type)
        return;

    /** Define all as false, to be trumped by user submission */
    $seo_post_defaults = array(
        '_calibrefx_title' => '',
        '_calibrefx_description' => '',
        '_calibrefx_keywords' => '',
        '_calibrefx_canonical_uri' => '',
        '_calibrefx_redirect_url' => '',
        '_calibrefx_noindex' => 0,
        '_calibrefx_nofollow' => 0,
        '_calibrefx_noarchive' => 0,
        '_calibrefx_scripts' => '',
    );

    /** Merge defaults with user submission */
    $calibrefx_seo = wp_parse_args($_POST['calibrefx_seo'], $seo_post_defaults);

    /** Loop through values, to potentially store or delete as custom field */
    foreach ((array) $calibrefx_seo as $key => $value) {
        /** Sanitize the title, description, and tags before storage */
        if (in_array($key, array('_calibrefx_title', '_calibrefx_description', '_calibrefx_keywords')))
            $value = esc_html(strip_tags($value));

        /** Save, or delete if the value is empty */
        if ($value)
            update_post_meta($post->ID, $key, $value);
        else
            delete_post_meta($post->ID, $key);
    }
}