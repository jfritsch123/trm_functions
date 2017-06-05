/**
 * trm_ajax scripts
 */

/**
 * ajax loader: http://cssload.net/
 * @returns {string}
 */
function trm_ajax_loader(){
    return '<div id="fountainTextG"><div id="fountainTextG_1" class="fountainTextG">L</div><div id="fountainTextG_2" class="fountainTextG">o</div><div id="fountainTextG_3" class="fountainTextG">a</div><div id="fountainTextG_4" class="fountainTextG">d</div><div id="fountainTextG_5" class="fountainTextG">i</div><div id="fountainTextG_6" class="fountainTextG">n</div><div id="fountainTextG_7" class="fountainTextG">g</div></div>';
}

/**
 * ajax loading function
 * @param params: all POST params
 * @param $container: load this container with ajax content
 * @param callback: handle result
 */
function trm_load_ajax(params,$container,callback){
	console.debug(params);
    $container.html(trm_ajax_loader());
	var data = {
		action: 'trm_ajax_request',
		nonce: TRMAjax.nonce
	};
 	data = jQuery.param(data) + '&' + params;
	jQuery.post(TRMAjax.ajaxurl, data, function(response) {
		if(response.success){
            if(typeof callback == 'undefined'){
                $container.html(response.data);
            }else{
                callback($container,response)
            }
		}else{
            $container.html(response.success + ':' + response.data);
		}
	});
}

