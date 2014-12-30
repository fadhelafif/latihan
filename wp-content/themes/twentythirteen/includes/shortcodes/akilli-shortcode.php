<?php
function pp($value){
	echo '<pre>';
	print_r($value);
	echo '</pre>';
}
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

add_shortcode("location", "akilli_location");
function akilli_location( $atts, $content = null ) {

	 extract(shortcode_atts(array(
	 	"id" => "",
	 ), $atts));

	if(!empty($id)) {
		$query = new WP_Query( 'post_type=post_location&p='.$id);

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$address =  get_field('coordinate')['address'] ; 	
			}
		} 
	/* Restore original Post Data */
		wp_reset_postdata();

	}

	return $address; 	
}