/**
 * trm_ajax scripts
 */

function trm_load_ajax(params,callback){
	var data = {
		action: 'trm_ajax_request',
		nonce: TRMAjax.nonce
	};
	data = jQuery.param(data) + '&' + params;
	jQuery.post(TRMAjax.ajaxurl, data, function(response) {
		console.log(response);
		callback(response.data)
	}).fail(function(xhr, textStatus, e) {
		console.log(xhr.responseText);
	});
}

jQuery(document).ready(function($){
	$('.entry-content').on('change','#trm-registrations',function() {
		var $form = $('div.wpcf7 > form');
		var action_param = '&form_action=' + $form.attr('action');
		trm_load_ajax($form.serialize() + action_param, function (response_data) {
			$('.entry-content').html(response_data);
			$('div.wpcf7 > form').wpcf7InitForm();
		});
	});

	$('#load-wpcf7').on('click',function() {
		var form_slug = $(this).data('form-slug');
		trm_load_ajax('form-slug=' + form_slug + '&_wpcf7=4', function (response_data) {
			$('.entry-content').html(response_data);
			$('div.wpcf7 > form').wpcf7InitForm();
		})
	})

});