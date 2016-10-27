<?php
/**
 * masonry
 * settings
 *
 */

add_action( 'wp_enqueue_scripts', 'trm_fancybox_enqueue',20 );
function trm_fancybox_enqueue() {
	// masonry, images_loaded: wordpress 4.6.1 loads it automatically
	wp_enqueue_script( 'jquery-tools', PLUGIN_DIR_URL.'vendor/fancybox/jquery.tools.min.js',array('jquery'));
	wp_enqueue_script( 'fancybox', PLUGIN_DIR_URL.'vendor/fancybox/jquery.fancybox-1.3.4.pack.js',array('jquery'));
	wp_enqueue_script( 'fancybox', PLUGIN_DIR_URL.'vendor/fancybox/jquery.fancybox-1.3.4.pack.js',array('jquery'));
}
