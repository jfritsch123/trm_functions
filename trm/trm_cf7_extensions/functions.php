<?php
/**
 * cf7_extensions functions
 */

/**
 *  custom field hidden
 */
function wpcf7_add_shortcode_hidden() {
	wpcf7_add_shortcode(array('hidden'),'wpcf7_hidden_shortcode_handler', true );
}
add_action( 'wpcf7_init', 'wpcf7_add_shortcode_hidden' );

function wpcf7_hidden_shortcode_handler($tag){
	return'<input type="hidden" name="'.$tag['name'].'" value="'.$tag['values'][0].'">';
}

/**
 * count db entries
 * plugin CFDB must be installed !
 * filter="strpos($field,$value) !== false
 */
function count_db_entries($title,$field,$value){
	$exp = new CFDBFormIterator();
	$filter = "strpos($field,$value) >= 0";
	$exp->export($title, array('filter' => $filter));
	$i = 0;
	while ($row = $exp->nextRow()) $i++;
	return $i;
}

/**
 *  custom field select_post_type
 *  must have option post_type defined: post_type:type
 */
function wpcf7_add_shortcode_select_post_type() {
	wpcf7_add_shortcode(array('select_post_type','select_post_type*'),'wpcf7_select_post_type_shortcode_handler', true );
}
add_action( 'wpcf7_init', 'wpcf7_add_shortcode_select_post_type' );

function wpcf7_select_post_type_shortcode_handler($tag){
	$wpcf7_obj = WPCF7_ContactForm::get_current();
	$title = $wpcf7_obj->title;
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
	    $html = '<span class="wpcf7-form-control-wrap '.$tag['name'].'"><select autocomplete="off" name="'.$tag['name'].'" id="'.$id.'">';
	    $selected = isset($_POST['select-course']) ? '' : 'selected="selected"';
	    $html .= '<option '.$selected.' value="-1">Bitte wählen Sie einen Kurs</option>';
	    $selected = '';
	    while ( $the_query->have_posts() ) : $the_query->the_post();
		    $acf_max_count = get_field('acf_max_count');
		    $count_db_entries = count_db_entries($title,'select-course',get_the_title());
		    $option_text  = get_the_title(). ' -- '.$count_db_entries.'/'.$acf_max_count;
		    if(isset($_POST['select-course'])) $selected = $option_text == $_POST['select-course'] ? 'selected="selected"' : '';
			$html .= '<option '.$selected.' data-id="'.get_the_ID().'" data-max-count="'.$acf_max_count.'" data-db-entries="'.$count_db_entries.'">';
	        $html .= $option_text;
	        $html .= '</option>';
		endwhile;
        $html .= '</select></span>';
    else :
		$html = 'no data';
	endif;
	wp_reset_postdata();

	return $html;
}

// filter  wpcf7_form_class_attr callback
function filter_wpcf7_form_class_attr( $class ) {
	// make filter magic happen here...
	if(!isset($_POST['select-course']) || $_POST['select-course'] == "-1"){
		return $class .' hidden';
	}
	return $class;
};
//add_filter( 'wpcf7_form_class_attr', 'filter_wpcf7_form_class_attr');

// filter wpcf7_form_autocomplete
function filter_wpcf7_form_autocomplete() {
	return 'on';
};
add_filter( 'wpcf7_form_autocomplete', 'filter_wpcf7_form_autocomplete');

// filter wpcf7_form_action_url
function filter_wpcf7_form_action_url( $url ) {
	$post = get_page_by_path($_POST['form-slug']);
	return get_permalink($post->ID);
};
add_filter( 'wpcf7_form_action_url', 'filter_wpcf7_form_action_url', 10, 1 );

/**
 * filter wpcf7_before_send_mail
 * set cookies for all form elements
 */
function trm_before_send_mail(){
	$submission = WPCF7_Submission::get_instance();
	if($submission) {
		$posted_data = $submission->get_posted_data();
		foreach ($posted_data as $keyval => $posted) {
			setcookie($keyval,$posted,time()+3600*24*365,'/');
		}
	}
}
add_action("wpcf7_before_send_mail", "trm_before_send_mail");

// filter wpcf7_form_tag: fill in the cookies
function filter_wpcf7_form_tag( $tag, $unused ) {
	if(isset($_COOKIE[$tag['name']])){
		$tag['values'] = array($_COOKIE[$tag['name']]);
	}
	if($tag['name'] == 'action'){
		$tag['values'] = array('trm_ajax_request');
	}
	if($tag['name'] == 'nonce'){
		$tag['values'] = array('6b9701abea');
	}
	return $tag;
}
add_filter( 'wpcf7_form_tag', 'filter_wpcf7_form_tag', 10, 2);

/**
 * shortcode output
 */
function wpcf7_shortcode($id){
	return do_shortcode('[contact-form-7 id="'.$id.'"]');

}
?>