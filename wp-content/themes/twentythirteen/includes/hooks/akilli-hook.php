<?php 

function akilli_fb_like($content) {

  if(is_single()){

    $content .= '<iframe src="//www.facebook.com/plugins/like.php?href='. urlencode(get_permalink()) .'&amp;width&amp;layout=button&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:35px;" allowTransparency="true"></iframe>';
  }

  return $content;
}

add_filter( 'the_content', 'akilli_fb_like' );



function akilli_banner() {  
	if ( function_exists( 'ot_get_option') ) { 
		$image = ot_get_option('banner_image');

		if(is_single() && get_post_type() == 'post_product' ){
			?>
			<center><img src="<?php echo $image; ?>" alt="" /></center>
			<?php
		}
	}
}
add_action( 'akilli_before_menu', 'akilli_banner' );