<?php
/**
 * bootstrap carousel slider
 * display slider from acf field
 * requires acf plugin !
 *  http://frankackermann.com/twitter-bootstrap-slider-einfach-wordpress-integrieren/
 */

function display_bootstrap_slider($post_name='frontpage-slider',$template='jumbotron') {
	$args = array(
		'post_type' => 'slider_photos',
		'post_name' => $post_name
	);

	$loop = new WP_Query($args);
	$images = array();

	if ($loop->have_posts()) {
		$loop->the_post();
		while( have_rows('acf_carousel_slider',get_the_ID()) ): the_row();
			$images[] = array(
				'image' => get_sub_field('acf_slide_image'),
				'title' => get_sub_field('acf_slide_title'),
				'text' => get_sub_field('acf_slide_text')
			);
		endwhile;

	}
	if (count($images) > 0) {
		ob_start();
		include PLUGIN_DIR_PATH.'/trm/trm_bootstrap/carousel/phtml/'.$template.'.phtml';
	}

	$output = ob_get_contents();
	ob_end_clean();
	wp_reset_postdata();

	return $output;
}