<?php
add_action( 'wpcf7_init', 'wpcf7_add_shortcode_select_post_type' );

function wpcf7_add_shortcode_select_post_type() {
	wpcf7_add_shortcode(array('select_post_type','select_post_type*'),'wpcf7_select_post_type_shortcode_handler', true );
}

function wpcf7_select_post_type_shortcode_handler($tag){
	$sm = new WPCF7_Shortcode( $tag );
	$id = $sm->get_id_option();
	$post_type = $sm->get_option('post_type')[0];
	$args = array(
	    'post_type' => $post_type,
	    'posts_per_page' => -1,
	    'orderby'=>'title',
	    'order'=>'ASC'
    );

    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) :
	    $html = '<select name="'.$tag['name'].'" id="'.$id.'">';
	    while ( $the_query->have_posts() ) : $the_query->the_post();
		    $acf_max_count = get_field('acf_max_count');
			$html .= '<option data-key="'.get_the_ID().'" data-max-count="'.$acf_max_count.'">';
	        $html .= get_the_title() . ' -- '.$acf_max_count;
	        $html .= '</option>';
		endwhile;
        $html .= '</select>';
    else :
		$html = 'no data';
	endif;
	wp_reset_postdata();

	return $html;
}


?>

