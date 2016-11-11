<?php
/**
 * define acf fieldgroup for registrations
 * layouts: table, block, row
 * collapsed: not in layout table
 */

function trm_acf_add_registration_field_groups() {
	if ( function_exists( 'acf_add_local_field_group' ) ):

		acf_add_local_field_group( array(
			'key'                   => 'group_5824cfb6b2317',
			'title'                 => 'Anmeldung',
			'fields'                => array(
				array(
					'key'               => 'field_5824d001e209f',
					'label'             => 'Maximalanzahl Teilnehmer',
					'name'              => 'acf_max_count',
					'type'              => 'number',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
					'min'               => '',
					'max'               => '',
					'step'              => '',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'registrations',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => 1,
			'description'           => '',
		) );

	endif;
}

add_action('acf/init', 'trm_acf_add_registration_field_groups');