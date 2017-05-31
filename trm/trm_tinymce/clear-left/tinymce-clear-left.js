(function($) {

	tinymce.PluginManager.add( 'clear_left', function( editor, url ) {
		// Add Button to Visual Editor Toolbar
		editor.addButton('clear_left', {
			title: 'clear left',
			image: url + '/clear-left.png',
			cmd: 'clear_left',
		});

		// Add Command when Button Clicked
		editor.addCommand('clear_left', function() {
			// Check if selected node has style = clear:left
			var $selectedNode = $(editor.selection.getNode());
			var styleAttr = $selectedNode.attr('style');
			// if attribute exists
			if(typeof styleAttr != 'undefined'){
				// replace blanks
				var str = styleAttr.replace(/ /g,"");
				// if not in str
				if(str.indexOf('clear:left') == -1){
					styleAttr += ';clear:left;';
					$selectedNode.attr('style',styleAttr);
					console.debug($selectedNode);
				}else{
					editor.windowManager.open({
						url: url + '/dialog.php',
						width: 400 ,
						height: 300
					},
					{
						jquery:$,
						editor : editor,
					});
				}

			}else{
				$selectedNode.attr('style','clear:left');
			}
		});
	});
})(jQuery);
