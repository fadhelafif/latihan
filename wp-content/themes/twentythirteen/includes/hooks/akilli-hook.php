<?php 

function akilli_fb_like($content) {

  if(is_single()){

    $content .= '<iframe src="//www.facebook.com/plugins/like.php?href='. urlencode(get_permalink()) .'&amp;width&amp;layout=button&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:35px;" allowTransparency="true"></iframe>';
  }

  return $content;
}

add_filter( 'the_content', 'akilli_fb_like' );