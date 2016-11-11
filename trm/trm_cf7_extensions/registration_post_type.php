<?php
/**
 * registration post type
 * requires acf plugin !
 */

function registration_post_type() {
	$labels = array(
		'name' => 'Anmeldungen',
		'singular_name' => 'Anmeldung',
		'add_new' => 'Hinzufügen',
		'add_new_item' => 'Neue Anmeldung hinzufügen',
		'edit_item' => 'Anmeldung bearbeiten',
		'new_item' => 'Neue Anmeldung',
		'view_item' => 'Anmeldung anzeigen',
		'search_items' => 'Anmeldung suchen',
		'not_found' => 'Keine Anmeldung gegfunden',
		'not_found_in_trash' => 'Keine Anmeldung im Papierkorb gefunden',
		'parent_item_colon' => '',
		'menu_name' => 'Anmeldungen'
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
	register_post_type(CUSTOM_POST_TYPE, $args);
}
add_action('init', 'registration_post_type');
