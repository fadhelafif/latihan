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
 * Calibrefx Ajax Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

add_action('wp_ajax_cfx_ajax', 'calibrefx_ajax');
add_action('wp_ajax_nopriv_cfx_ajax', 'calibrefx_ajax');

/**
 * Run any action to do ajax
 */
function calibrefx_ajax() {
	check_ajax_referer( 'calibrefx_ajax_nonce', '_ajax_nonce' );
	header("Content-Type: application/json");
    do_action('calibrefx_do_ajax');
    exit;
}

/*
SAMPLE SCRIPT FOR AJAX CALL

add_action('calibrefx_do_ajax', 'test_ajax');
function test_ajax() {
    if($_REQUEST['do'] == "test"){
    	echo json_encode(array("TEST" => $_REQUEST['data']));
    }
}


add_action('wp_head', 'my_action_javascript');

function my_action_javascript() {
?>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {

		jQuery.ajax({
			url: cfx_ajax.ajaxurl,
			data: { "action" : cfx_ajax.ajax_action, "do" : "test", "data" : "OK"},
			dataType:  'json',
			success: function(response) { 
				console.log(response);
				//alert('Got this from the server: ' + response.TEST);
			},
		});
	});
	</script>
<?php
}
*/