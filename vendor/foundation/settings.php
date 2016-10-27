<?php
/**
 * masonry
 * settings
 *
 */

add_action( 'wp_enqueue_scripts', 'trm_foundation_enqueue',20 );
function trm_foundation_enqueue() {
	// foundation javascript
	wp_enqueue_script( 'foundation', PLUGIN_DIR_URL.'vendor/foundation/foundation.js',array(),1);
	// foundation motion-ui javascript
	//wp_enqueue_script( 'foundation-motion-ui', PLUGIN_DIR_URL.'vendor/foundation/motion-ui.js',array('foundation'),1);

	// foundation styles
	//wp_enqueue_style( 'foundation', PLUGIN_DIR_URL.'/vendor/foundation/foundation.min.css', array(), '20160816' );

	// foundation styles
	wp_enqueue_style( 'foundation-motion-ui', PLUGIN_DIR_URL.'/vendor/foundation/motion-ui.min.css', array(), '20160816' );


}

/**
 *  load extra content in footer
 */
add_action('wp_footer', 'trm_foundation_footer',10);
function trm_foundation_footer(){
	ob_start();
	include(PLUGIN_DIR_PATH.'vendor/foundation/reveal_templates.phtml');
	$v = ob_get_clean();
	echo $v;
}

