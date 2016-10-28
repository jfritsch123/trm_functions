<?php
/**
 * query posts
 * requires acf plugin !
 */

function acf_query_posts_fromdate_todate($args,$template='display') {
	$date      = date( 'Ymd' );
	$args_new      = wp_parse_args( $args, array(
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
	var_dump($args_new);
	$the_query = new WP_Query( $args_new );
	if ( $the_query->have_posts() ):
		while ( $the_query->have_posts() ) : $the_query->the_post();
			echo '<h1>';the_title();echo '</h1>';
			echo '<h3>'.$date.' : ';the_field('acf_show_fromdate');echo '</h3>';
			echo '<h3>'.$date.' : ';the_field('acf_show_todate');echo '</h3>';
			the_content();
		endwhile;
	endif;
	wp_reset_query();     // Restore global post data stomped by the_post().
}
