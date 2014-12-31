<?php
/* Template Name: Blog
 *
 * CalibreFx Framework
 *
 * WordPress Themes by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @authorlink  http://www.calibrefx.com
 * @copyright   Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://www.calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * CalibreFx Page file
 *
 * @package CalibreFx
 */

if(file_exists(CHILD_URI . '/page-blog.php') AND (CHILD_URI != CALIBREFX_URI)){
    include CHILD_URI . '/page-blog.php';
    exit;
}

$cfxgenerator->replace('calibrefx_loop', 'calibrefx_do_loop', 'calibrefx_do_blog_loop');

/**
 * CalibreFx Loop for blog bage
 *
 * It's just like the default loop except it is used for displaying blog post category
 *
 */
function calibrefx_do_blog_loop() {
    global $wp_query;
    $query = new WP_Query('category_name=blog&paged=' . get_query_var('paged'));
    $wp_query = $query;
    
	$loop_counter = 1;
    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); // the loop

            do_action('calibrefx_before_post');
            get_template_part( 'content', get_post_format() );
            do_action('calibrefx_after_post');
            $loop_counter++;

        endwhile;/** end of one post * */
        do_action('calibrefx_after_post_loop');

    else : /** if no posts exist * */
        do_action('calibrefx_no_post');
    endif;/** end loop * */
}

remove_action( 'calibrefx_post_title', 'calibrefx_do_post_title' );
add_action('calibrefx_post_title', 'calibrefx_do_blog_title');

/**
 * calibrefx_post_title callback
 *
 * It outputs the post title in blog post category
 *
 */
function calibrefx_do_blog_title() {
    $title = get_the_title();

    if (strlen($title) == 0)
        return;

    $title = sprintf('<h1 class="entry-title"><a href="%s" title="%s" rel="bookmark">%s</a></h1>',  get_permalink(), the_title_attribute('echo=0'),			apply_filters('calibrefx_post_title_text', $title));

    echo apply_filters('calibrefx_post_title_output', $title) . "\n";
}

remove_action( 'calibrefx_post_content', 'calibrefx_do_post_content' );
add_action('calibrefx_post_content', 'calibrefx_do_blog_content');

/**
 * calibrefx_post_content callback
 *
 * It outputs the post content for blog page category
 *
 */
function calibrefx_do_blog_content() {

	if (calibrefx_get_option('content_archive_limit')){
		$read_more_text = apply_filters( 'calibrefx_readmore_text', __('[Read more...]', 'calibrefx') );
		the_content_limit((int) calibrefx_get_option('content_archive_limit'), $read_more_text);
	}
	else{
		the_content();
	}
    

    wp_link_pages(array('before' => '<p class="pages">' . __('Pages:', 'calibrefx'), 'after' => '</p>'));
}

calibrefx();