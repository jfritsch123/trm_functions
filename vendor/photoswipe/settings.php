<?php
/**
 * photoswipe
 * settings
 *
 */

add_action( 'wp_enqueue_scripts', 'trm_photoswipe_enqueue' );
function trm_photoswipe_enqueue() {
	//photoswipe
	wp_enqueue_script( 'photoswipe', PLUGIN_DIR_URL.'/vendor/photoswipe/photoswipe.min.js',array('jquery'));
	wp_enqueue_script( 'photoswipe-ui', PLUGIN_DIR_URL.'/vendor/photoswipe/photoswipe-ui-default.min.js',array());

	// photoswipe styles
	wp_enqueue_style( 'photoswipe', PLUGIN_DIR_URL.'/vendor/photoswipe/photoswipe.css', array(), '20160816' );
	wp_enqueue_style( 'photoswipe-skin', PLUGIN_DIR_URL.'/vendor/photoswipe/default-skin/default-skin.css', array(), '20160816' );
}

/**
 *  load extra content in footer
 */
add_action('wp_footer', 'trm_photoswipe_footer',10);
function trm_photoswipe_footer(){
	ob_start();
	include(PLUGIN_DIR_PATH.'/vendor/photoswipe/pspw_template.php');
	$v = ob_get_clean();
	echo $v;
}
