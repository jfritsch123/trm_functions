<?php
/**
 * query posts
 * requires acf plugin !
 */

function acf_query_posts_fromdate_todate($args) {
	$date      = date( 'Ymd' );
	return wp_parse_args( $args, array(
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key'     => 'acf_show_fromdate',
				'value'   => $date,
				'type'    => 'DATE',
				'compare' => '<='
			),
			array(
				'key'     => 'acf_show_todate',
				'value'   => $date,
				'type'    => 'DATE',
				'compare' => '>='
			)
		)
	) );
}
