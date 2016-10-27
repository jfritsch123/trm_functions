<?php
/**
 * trm_functions
 * settings
 *
 */

include_once PLUGIN_DIR_PATH.'/trm/trm_functions/trm_post_gallery_filter.php';

add_action( 'wp_enqueue_scripts', 'trm_functions_enqueue' );
function trm_functions_enqueue() {
	// trm_gallery styles
	//wp_enqueue_style( 'trm_gallery', PLUGIN_DIR_URL.'trm/trm_gallery/css/ajax-load-more.css', array(), '20160816' );
}
