<?php
/**
 * define acf fielgroup for carousel slider
 * layouts: table, block, row
 * collapsed: not in layout table
 */
function trm_acf_add_carousel_field_groups(){
	acf_add_local_field_group(array (
		'key' => 'group_57ef960289921',
		'title' => 'Bootstrap Carousel',
		'fields' => array (
			array (
				'key' => 'field_57ef961a0f526',
				'label' => 'Carousel Slider',
				'name' => 'acf_carousel_slider',
				'type' => 'repeater',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => 'field_57efae45fb5a2',
				'min' => '',
				'max' => '',
				'layout' => 'block',
				'button_label' => 'Eintrag hinzufügen',
				'sub_fields' => array (
					array (
						'key' => 'field_57efae45fb5a2',
						'label' => 'Bild',
						'name' => 'acf_slide_image',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'return_format' => 'array',
						'preview_size' => 'medium',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
					),
					array (
						'key' => 'field_57efb064ce838',
						'label' => 'Titel',
						'name' => 'acf_slide_title',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array (
						'key' => 'field_57efb086ce839',
						'label' => 'Text',
						'name' => 'acf_slide_text',
						'type' => 'wysiwyg',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
					),
				),
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'slider_photos',
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
add_action('acf/init', 'trm_acf_add_carousel_field_groups');