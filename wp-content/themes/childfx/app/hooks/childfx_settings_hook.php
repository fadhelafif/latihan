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

// add_filter( 'calibrefx_theme_settings_defaults', 'simonwarner_theme_settings_default', $priority = 10, $accepted_args = 1 );
// function simonwarner_theme_settings_default($default_arr = array()){
//     $simonwarner_default=array(
//     );

//     return array_merge($default_arr, $simonwarner_default);
// }

// add_action( 'calibrefx_theme_settings_meta_section', 'simonwarner_meta_sections' );
// function simonwarner_meta_sections(){
// 	global $calibrefx_target_form;
    
//     calibrefx_add_meta_section('design', __('Design Settings', 'calibrefx'), $calibrefx_target_form, 10);
//     calibrefx_add_meta_section('homepage', __('Homepage Settings', 'calibrefx'), $calibrefx_target_form,10);
// }

// add_action( 'calibrefx_theme_settings_meta_box', 'simonwarner_meta_boxes' );
// function simonwarner_meta_boxes(){
//     global $calibrefx;
    
//     // calibrefx_add_meta_box('design', 'basic', 'page-header-settings', __('Custom Teaser Image Settings', 'calibrefx'), 'page_header_settings', $calibrefx->theme_settings->pagehook, 'main', 'low');
// }


add_filter( 'calibrefx_theme_settings_defaults', 'ivancfx_theme_settings_default', $priority = 10, $accepted_args = 1 );
function ivancfx_theme_settings_default($default_arr = array()){
    $ivancfx_default=array(
    );

    return array_merge($default_arr, $ivancfx_default);
}

add_action( 'calibrefx_theme_settings_meta_section', 'ivancfx_meta_sections' );
function ivancfx_meta_sections(){
	global $calibrefx_target_form;
    
    calibrefx_add_meta_section('design', __('Design Settings', 'calibrefx'), $calibrefx_target_form,10);
    calibrefx_add_meta_section('themeoption', __('Theme Options Settings', 'calibrefx'), $calibrefx_target_form,10);
}

add_action( 'calibrefx_theme_settings_meta_box', 'ivancfx_meta_boxes' );
function ivancfx_meta_boxes(){
    global $calibrefx;
  
    //calibrefx_add_meta_box('design', 'basic', 'codemaniac-custom-logo', __('Custom Logo & Favicon', 'calibrefx'), 'ivancfx_custom_logo', $calibrefx->theme_settings->pagehook, 'main', 'low');
    calibrefx_add_meta_box('themeoption', 'basic', 'themeoption-settings', __('Social Integrated Settings', 'calibrefx'), 'childfx_socials_integrated_box', $calibrefx->theme_settings->pagehook, 'main', 'low');
}

function childfx_socials_integrated_box(){
    global $calibrefx;
    
    calibrefx_add_meta_group('themeoption-settings', 'facebook-settings', __('Facebook Settings', 'calibrefx'));
    calibrefx_add_meta_group('themeoption-settings', 'social-settings', __('Social Link Settings', 'calibrefx'));
    calibrefx_add_meta_group('themeoption-settings', 'feed-settings', __('RSS Feed Settings', 'calibrefx'));
    
    calibrefx_do_meta_options($calibrefx->theme_settings, 'themeoption-settings');
}

//For Facebook Settings
add_action( 'themesocial-settings_options', 'facebook_settings_options' );
function facebook_settings_options(){
    
    calibrefx_add_meta_option(
            'facebook-settings',  // group id
            'facebook_admins2', // field id and option name
            __('Facebook Admin ID'), // Label
            array(
                'option_type' => 'textinput',
                'option_default' => 'anyvalue',
                'option_filter' => 'safe_text',
                'option_description' => __("This will be use for Facebook Insight. <br/>This will output: <code>&lt;meta property=\"fb:admins\" content=\"YOUR ADMIN ID HERE\"/></code> Read More about this <a href='https://developers.facebook.com/docs/insights/' target='_blank'>here</a>.", 'calibrefx'),
            ), // Settings config
            100 //Priority
    );

    calibrefx_add_meta_option(
            'facebook-settings',  // group id
            'facebook_og_type2', // field id and option name
            __('Facebook Page Type'), // Label
            array(
                'option_type' => 'radio',
                'option_items' => apply_filters(
                                'calibrefx_facebook_og_types', array(
                                'article' => 'Article',
                                'website' => 'Website',
                                'blog' => 'Blog',
                                'movie' => 'Movie',
                                'song' => 'Song',
                                'product' => 'Product',
                                'book' => 'Book',
                                'food' => 'Food',
                                'drink' => 'Drink',
                                'activity' => 'Activity',
                                'sport' => 'Sport',
                                )
                        ),
                'option_default' => 'website',
                'option_filter' => 'safe_text',
                'option_description' => __("This is open graph protocol that helo to identify your content. <br/>This will output: <code>&lt;meta property=\"og:type\" content=\"TYPE\"/></code>", 'calibrefx'),
            ), // Settings config
            5 //Priority
    );
}

//Social Link Settings
add_action( 'themeoption-settings_options', 'social_settings_options' );
function social_settings_options(){
    
    calibrefx_add_meta_option(
            'social-settings',  // group id
            'gplus_profile', // field id and option name
            __('Google+ Profile Link'), // Label
            array(
                'option_type' => 'textinput',
                'option_default' => '',
                'option_filter' => 'safe_text',
                'option_description' => __("This will output <code>&lt;link rel=\"author\" href=\"YOUR GOOGLE+ LINK HERE\"/></code> in html head.", 'calibrefx'),
            ), // Settings config
            1 //Priority
    );

    calibrefx_add_meta_option(
            'social-settings',  // group id
            'gplus_page', // field id and option name
            __('Google+ Page Link'), // Label
            array(
                'option_type' => 'textinput',
                'option_default' => '',
                'option_filter' => 'safe_text',
                'option_description' => __("This will use for Google Page For Business link, and it will show if using the Social Widget", 'calibrefx'),
            ), // Settings config
            5 //Priority
    );

    calibrefx_add_meta_option(
            'social-settings',  // group id
            'facebook_fanpage', // field id and option name
            __('Facebook Page Link'), // Label
            array(
                'option_type' => 'textinput',
                'option_default' => '',
                'option_filter' => 'safe_text',
                'option_description' => __("This will use for Facebook Page link, and it will show if using the Social Widget", 'calibrefx'),
            ), // Settings config
            10 //Priority
    );

    calibrefx_add_meta_option(
            'social-settings',  // group id
            'twitter_profile', // field id and option name
            __('Twitter Profile Link'), // Label
            array(
                'option_type' => 'textinput',
                'option_default' => '',
                'option_filter' => 'safe_text',
                'option_description' => __("This will use for Twitter link, and it will show if using the Social Widget", 'calibrefx'),
            ), // Settings config
            15 //Priority
    );

    calibrefx_add_meta_option(
            'social-settings',  // group id
            'youtube_channel', // field id and option name
            __('Youtube Channel Link'), // Label
            array(
                'option_type' => 'textinput',
                'option_default' => '',
                'option_filter' => 'safe_text',
                'option_description' => __("This will use for Youtube Channel link, and it will show if using the Social Widget", 'calibrefx'),
            ), // Settings config
            20 //Priority
    );

    calibrefx_add_meta_option(
            'social-settings',  // group id
            'linkedin_profile', // field id and option name
            __('Linkedin Profile Link'), // Label
            array(
                'option_type' => 'textinput',
                'option_default' => '',
                'option_filter' => 'safe_text',
                'option_description' => __("This will use for Linkedin link, and it will show if using the Social Widget", 'calibrefx'),
            ), // Settings config
            25 //Priority
    );

    calibrefx_add_meta_option(
            'social-settings',  // group id
            'pinterest_profile', // field id and option name
            __('Pinterest Profile Link'), // Label
            array(
                'option_type' => 'textinput',
                'option_default' => '',
                'option_filter' => 'safe_text',
                'option_description' => __("This will use for Pinterest link, and it will show if using the Social Widget", 'calibrefx'),
            ), // Settings config
            30 //Priority
    );
}

//Social Link Settings
add_action( 'themeoption-settings_options', 'feed_settings_options' );
function feed_settings_options(){
    calibrefx_add_meta_option(
            'feed-settings',  // group id
            'feed_uri', // field id and option name
            __('Main Feed URL'), // Label
            array(
                'option_type' => 'textinput',
                'option_default' => '',
                'option_filter' => 'safe_text',
                'option_description' => __("You can replace WordPress builtin Feed URL using this options. For sample you want to use feedburner instead. Sample: http://feeds2.feedburner.com/calibrefx.", 'calibrefx'),
            ), // Settings config
            1 //Priority
    );

    calibrefx_add_meta_option(
            'feed-settings',  // group id
            'comments_feed_uri', // field id and option name
            __('Comment Feed URL'), // Label
            array(
                'option_type' => 'textinput',
                'option_default' => '',
                'option_filter' => 'safe_text',
                'option_description' => __("You can replace WordPress builtin Feed URL using this options. For sample you want to use feedburner instead. Sample: http://feeds2.feedburner.com/calibrefxcomment.", 'calibrefx'),
            ), // Settings config
            1 //Priority
    );
}