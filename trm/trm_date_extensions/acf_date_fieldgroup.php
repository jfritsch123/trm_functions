<?php
/**
* define acf fieldgroup for date extensions
*/
function trm_acf_add_date_field_group(){
	acf_add_local_field_group(array (
		'key' => 'group_58128a7a5f437',
		'title' => 'Datum',
		'fields' => array (
			array (
				'key' => 'field_58128a9b4ad55',
				'label' => 'Anzeige von Datum',
				'name' => 'acf_show_fromdate',
				'type' => 'date_picker',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '50%',
					'class' => '',
					'id' => '',
				),
				'display_format' => 'd.m.Y',
				'return_format' => 'd/m/Y',
				'first_day' => 1,
			),
			array (
				'key' => 'field_58128b0f4ad56',
				'label' => 'Anzeige bis Datum',
				'name' => 'acf_show_todate',
				'type' => 'date_picker',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '50%',
					'class' => '',
					'id' => '',
				),
				'display_format' => 'd.m.Y',
				'return_format' => 'd/m/Y',
				'first_day' => 1,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_category',
					'operator' => '==',
					'value' => 'category:news',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));
}
add_action('acf/init', 'trm_acf_add_date_field_group');