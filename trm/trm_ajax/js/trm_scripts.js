/**
 * trm_ajax scripts
 */

/**
 * ajax loading function
 * @param params: all POST params
 * @param $container: load this container with ajax content
 * @param callback: handle result
 */
function trm_load_ajax(params,$container,callback){
    var data = {
        action: 'trm_ajax_request',
        nonce: TRMAjax.nonce
    };
    data = jQuery.param(data) + '&' + params;

    jQuery.LoadingOverlay("show",{maxSize:60});

    jQuery.ajax({
        url:TRMAjax.ajaxurl,
        method: 'POST',
        data: data,
        success: function(response) {

            jQuery.LoadingOverlay("hide");

            if(response.success){
                if(typeof callback == 'undefined'){
                    $container.html(response.data);
                }else{
                    callback($container,response)
                }
            }else{
                $container.html(response.success + ':' + response.data);
            }
        }
    });
}

jQuery(document).ready(function($){
    $.post(TRMAjax.ajaxurl, 'action=trm_nonce_action', function(response) {
        $('body').append('<script>TRMAjax.nonce = "' + response + '";</script>');
    });
})
