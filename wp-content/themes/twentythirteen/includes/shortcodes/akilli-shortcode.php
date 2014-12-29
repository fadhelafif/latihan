<?php

add_shortcode("say_hello", "akilli_say_hello");
function akilli_say_hello( $atts, $content = null ) {

	$output = 'Hello World';

	return $output;		
}

add_shortcode("introduce_owner", "akilli_introduce_owner");
function akilli_introduce_owner( $atts, $content = null ) {  
 
	$output = '';

	if ( function_exists( 'ot_get_option') ) { 
		$copy_right = ot_get_option('web_copyright'); 

		$output = $copy_right;
	} 				

    return $output;		
}

add_shortcode("say_something", "akilli_say_something");
function akilli_say_something( $atts, $content = null ) {
    extract(shortcode_atts(array(
	    "word" => "",
    ), $atts));

    $output = $word;

    return $output;		
}

add_shortcode("title_page", "akilli_title_page");
function akilli_title_page( $atts, $content = null ) {

	$output = ( $content == null ) ? get_the_title() : $content;

	return $output;		
}