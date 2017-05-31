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
		callback(response)
	}).fail(function(xhr, textStatus, e) {
		console.debug(xhr.responseText)
	});
}

function submit_form(form){
    var $form = jQuery(form);
    var tmce = $form.data('tmce-id');
    jQuery(tmce).val(tinyMCE.activeEditor.getContent())
    var params = $form.serialize();
    trm_load_ajax(params,function (response) {
        tinyMCE.activeEditor.setContent(response.data.editor + response.data.editor)
    })
    return false;
}


( function( $ ) {

    $( document ).ready( function() {

    });
} )( jQuery );
