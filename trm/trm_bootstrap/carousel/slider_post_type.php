<?php
/**
 * bootstrap carousel slider post type
 * bootstrap slider integration
 * requires acf plugin !
 *  http://frankackermann.com/twitter-bootstrap-slider-einfach-wordpress-integrieren/
 */

function slider_photo_post_types() {
	$labels = array(
		'name' => 'Slider Fotos',
		'singular_name' => 'Slider Foto',
		'add_new' => 'Hinzufügen',
		'add_new_item' => 'Neues Foto hinzufügen',
		'edit_item' => 'Foto bearbeiten',
		'new_item' => 'Neues Foto',
		'view_item' => 'Foto anzeigen',
		'search_items' => 'Foto suchen',
		'not_found' => 'Kein Foto gegfunden',
		'not_found_in_trash' => 'Kein Foto im Papierkorb gefunden',
		'parent_item_colon' => '',
		'menu_name' => 'Slider Fotos'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'exclude_from_search' => true,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'page',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 21,
		'supports' => array('title')
	);
	register_post_type('slider_photos', $args);
}
add_action('init', 'slider_photo_post_types');
