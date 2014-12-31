jQuery(document).ready(function($){
	
	if(jQuery.browser.chrome){
        jQuery('html').addClass('chrome');
    }else if(jQuery.browser.mozilla){
        jQuery('html').addClass('mozilla');
    }else if(jQuery.browser.opera){
        jQuery('html').addClass('opera');
    }else if(jQuery.browser.webkit){
        jQuery('html').addClass('webkit');
    }
	
});

function check_focus(elm,val){
    if(elm.value.toLowerCase() == val.toLowerCase()){
        elm.value = '';    
    }
}

function check_blur(elm,val){
    if(elm.value.toLowerCase() == ''){
        elm.value = val;    
    }
}

