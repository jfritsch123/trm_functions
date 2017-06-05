<?php
/**
 * trm_ajax functions
 */

/**
 *  javascript and css for ajax loader
 */
function trm_ajax_enqueue_assets() {
	$plugin_dir_path = plugin_dir_path(__FILE__ );
	$plugin_dir_url= plugin_dir_url(__FILE__ );

	// styles for ajax loding animation
    wp_enqueue_style( 'trm-admin', plugin_dir_url(__FILE__ ).'css/admin.css', array(), '1.0.0' );

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
add_action( 'wp_enqueue_scripts', 'trm_ajax_enqueue_assets' );
add_action( 'admin_enqueue_scripts', 'trm_ajax_enqueue_assets' );

/**
 * ajax requests
 */
add_action( 'wp_ajax_nopriv_trm_ajax_request', 'trm_ajax_request_callback' );
add_action( 'wp_ajax_trm_ajax_request', 'trm_ajax_request_callback' );

function trm_ajax_request_callback() {
	check_ajax_referer( 'trm_gallery_request_nonce', 'nonce' );
	wp_send_json_success(trm_ajax_response());
}
function trm_ajax_response(){
	$response = 'please define a "trm_ajax_response" filter ';
	return apply_filters('trm_ajax_action',$response );
}

/**
 * sample filter
 */
//add_filter('trm_ajax_action','trm_ajax_action_filter');
function trm_ajax_action_filter(){
	return $_POST;
}
