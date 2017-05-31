/**
 * trm scripts for menu schedule
 */

/**
 * submit form
 * form must define data-mce-id
 * @param form
 * @returns {boolean}
 */
function submit_form(form){
    var $form = jQuery(form);
    var tmce = $form.data('tmce-id');
    jQuery(tmce).val(tinyMCE.activeEditor.getContent())
    var params = $form.serialize();
    trm_load_ajax(params,jQuery('#col-right'),function ($container,response) {
        $container.html(response.data);
    })
    return false;
}


( function( $ ) {

    $( document ).ready( function() {
        $('#load-test').on('click',function(){
            trm_load_ajax('',$('#col-right'),function ($container,response) {
                $container.html(response.data);
                //tinyMCE.activeEditor.setContent(response.data.editor + response.data.editor)
            })
        });
    });
} )( jQuery );
