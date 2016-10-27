<?php
/**
 * trm_gallery
 * settings
 *
 */

define ('PICASA_URL','http://picasaweb.google.com/data/feed/base/user/gukps1?alt=rss&kind=album&hl=de');

include_once PLUGIN_DIR_PATH.'/trm/trm_gallery/lib/dom_functions.php';
include_once PLUGIN_DIR_PATH.'/trm/trm_gallery/classes/class.gallery.php';
include_once PLUGIN_DIR_PATH.'/trm/trm_gallery/classes/class.picasa_album.php';
include_once PLUGIN_DIR_PATH.'/trm/trm_gallery/classes/class.picasa_gallery.php';
include_once PLUGIN_DIR_PATH.'/trm/trm_gallery/classes/class.wordpress_album.php';
include_once PLUGIN_DIR_PATH.'/trm/trm_gallery/classes/class.wordpress_gallery.php';
include_once PLUGIN_DIR_PATH.'/trm/trm_gallery/classes/class.wordpress_picasa_album.php';

//add_action( 'wp_enqueue_scripts', 'trm_gallery_enqueue' );
function trm_gallery_enqueue() {
}

// ajax requests
add_action( 'wp_ajax_nopriv_trm_gallery_request', 'trm_gallery_request' );
add_action( 'wp_ajax_trm_gallery_request', 'trm_gallery_request' );

function trm_gallery_request(){
	check_ajax_referer( 'trm_functions_request_nonce', 'nonce' );

	// picasa album
	if($_POST['type'] == 'picasa' && $_POST['mode'] == 'album'){
		$c = new PicasaAlbum(PICASA_URL);
		wp_send_json_success($c->toHTML(plugin_dir_path(__FILE__ ).'phtml/picasa_album.phtml'));
		wp_die();
	}

	// picasa_wordpress album
	if($_POST['type'] == 'wordpress_picasa' && $_POST['mode'] == 'album'){
		$c = new WordpressPicasaAlbum();
		wp_send_json_success($c->toHTML(plugin_dir_path(__FILE__ ).'phtml/wordpress_picasa_album.phtml'));
		wp_die();
	}

	// picasa gallery
	if($_POST['type'] == 'picasa' && $_POST['mode'] == 'gallery') {
		$c = new PicasaGallery( $_POST['url'] );
		wp_send_json_success( $c->toHTML( plugin_dir_path( __FILE__ ) . 'phtml/picasa_gallery.phtml' ) );
		wp_die();
	}

	// wordpress gallery
	if($_POST['type'] == 'wordpress' && $_POST['mode'] == 'gallery') {
		$c = new WordpressGallery( $_POST['url'] );
		wp_send_json_success($c->toHTML( plugin_dir_path( __FILE__ ) . 'phtml/wordpress_gallery.phtml' ) );
		wp_die();
	}
}

/*
 * define the shortcodes
 */
add_shortcode('trm_gallery', 'trm_gallery_shortcodes');
function trm_gallery_shortcodes($atts, $content=null, $code=""){
	$a = shortcode_atts( array(
		'type' => 'picasa',
		'mode' => 'album',
	), $atts );

	$ret = '';
	if($a['mode'] == 'album'){
		switch($a['type']) {
			case 'picasa':
				$c = new PicasaAlbum(PICASA_URL);
				$ret = $c->toHTML(plugin_dir_path(__FILE__ ).'phtml/picasa_album.phtml');
				break;
			case 'wordpress':
				$c = new WordpressAlbum();
				$ret = $c->toHTML(plugin_dir_path(__FILE__ ).'phtml/wordpress_album.phtml');
				break;
			case 'wordpress_picasa':
				$c = new WordpressPicasaAlbum();
				$ret = $c->toHTML(plugin_dir_path(__FILE__ ).'phtml/wordpress_picasa_album.phtml');
				break;
		}
	}
	return $ret;

}
