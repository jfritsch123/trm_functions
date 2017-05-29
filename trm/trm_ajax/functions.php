<?php
/**
 * trm_ajax functions
 */

/**
 *  javascript for ajax loader
 */
add_action( 'wp_enqueue_scripts', 'trm_ajax_enqueue_scripts' );
function trm_ajax_enqueue_scripts() {
	$plugin_dir_path = plugin_dir_path(__FILE__ );
	$plugin_dir_url= plugin_dir_url(__FILE__ );

	// Localize the script
	$args =  array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'trm_gallery_request_nonce' )
	);
	// main javascript file
	wp_enqueue_script( 'trm_ajax',plugin_dir_url(__FILE__ ).'js/trm_scripts.js', array('jquery' ),'1.0',true );
	// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
	wp_localize_script( 'trm_ajax', 'TRMAjax', $args) ;
}

// ajax requests
add_action( 'wp_ajax_nopriv_trm_ajax_request', 'trm_ajax_request_callback' );
add_action( 'wp_ajax_trm_ajax_request', 'trm_ajax_request_callback' );

function trm_ajax_request_callback() {
	check_ajax_referer( 'trm_gallery_request_nonce', 'nonce' );
	wp_send_json_success(trm_ajax_response());
	die();
}

function trm_ajax_response(){
	$response = 'please define a "trm_ajax_response" filter ';
	$response = apply_filters('trm_ajax_response',$response);
	return $response;
}

/**
 * sample filter
 */
//add_filter('trm_ajax_response','trm_ajax_response_filter');
function trm_ajax_response_filter(){
	return wpcf7_shortcode($_POST['_wpcf7']);
}
