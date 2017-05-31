<?php
/**
 * trm_facebook
 * settings
 *
 */

function override_mce_options($initArray) {
	$opts = '*[*]';
	$initArray['valid_elements'] = $opts;
	$initArray['extended_valid_elements'] = $opts;
	return $initArray;
}
add_filter('tiny_mce_before_init', 'override_mce_options');
include_once PLUGIN_DIR_PATH.'trm/trm_tinymce/classes/class.tinymce_custom_buttons.php';
