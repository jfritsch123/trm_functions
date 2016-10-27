<?php
/**
 * masonry
 * settings
 *
 */

add_action( 'wp_enqueue_scripts', 'trm_masonry_enqueue',20 );
function trm_masonry_enqueue() {
	// masonry, images_loaded: wordpress 4.6.1 loads it automatically
	wp_deregister_script('masonry');
	wp_deregister_script('imagesloaded');
	wp_enqueue_script( 'imagesloaded', PLUGIN_DIR_URL.'vendor/masonry/imagesloaded.pkgd.min.js',array());
	wp_enqueue_script( 'masonry', PLUGIN_DIR_URL.'vendor/masonry/masonry.pkgd.min.js',array('imagesloaded'));
}
