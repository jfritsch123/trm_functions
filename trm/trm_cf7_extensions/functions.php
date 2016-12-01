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
	$value = empty($tag['values'][0]) ? '' : $tag['values'][0];
	return '<input type="hidden" name="'.$tag['name'].'" value="'.$value.'">';
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

// filter wpcf7_form_autocomplete
function filter_wpcf7_form_autocomplete() {
	return 'on';
};
#add_filter( 'wpcf7_form_autocomplete', 'filter_wpcf7_form_autocomplete');

// filter wpcf7_form_action_url
function filter_wpcf7_form_action_url( $url ) {
	$post = get_page_by_path($_POST['form-slug']);
	return get_permalink($post->ID);
};
#add_filter( 'wpcf7_form_action_url', 'filter_wpcf7_form_action_url', 10, 1 );

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
#add_action("wpcf7_before_send_mail", "trm_before_send_mail");

// filter wpcf7_form_tag: fill in the cookies
function filter_wpcf7_form_tag( $tag, $unused ) {
	if(isset($_COOKIE[$tag['name']])){
		$tag['values'] = array($_COOKIE[$tag['name']]);
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

/********************************************************************
 * FILTER: wpcf7_validate_email*
 * @param $result WPCF7_Validation
 * @param $tag array
 * @return WPCF7_Validation
 */
function trm_validate_date($result, $tag) {
	$max_date = substr($tag['options'][2],9);
	$cur_date = $_POST[$tag['name']];
	if(strtotime($max_date) < strtotime($cur_date)) {
		$errorMessage = 'Das Datum ist unterhalb der Grenze '. $max_date;
		$result->invalidate($tag,$errorMessage );
		return $result;
	}
	return $result;

}
// add this filter if your field is a **required email** field on your form
add_filter('wpcf7_validate_date*', 'trm_validate_date', 10, 2);

/********************************************************************
 * FILTER: wpcf7_ajax_json_echo
 * $items['mailSent'] true or false
 * $result['status'] mail_failed or mail_sent or validation_failed
 *
 */
function trm_wpcf7_ajax_json_echo( $items, $result ) {

	// get postet data
	$submission = WPCF7_Submission::get_instance();
	$posted_data = $submission->get_posted_data();
	$cf = WPCF7_ContactForm::get_current();

	// validation failed: return standard message
	if($result['status'] == 'validation_failed'){
		return $items;
	}

	// send mail failed: return standard message
	if($result['status'] == 'mail_failed'){
		//return $items;
	}

	// if field trm-message-template is set:
	// return message from template if $result['status'] = mail_failed or mail_sent
		if ($result['status'] == 'mail_sent') {
			$items['message'] = output_buffer(plugin_dir_path( __FILE__ ).'inc/message-template.phtml',$posted_data);
		}
	return $items;
}
// add the filter
add_filter( 'wpcf7_ajax_json_echo', 'trm_wpcf7_ajax_json_echo', 10, 2 );

?>
