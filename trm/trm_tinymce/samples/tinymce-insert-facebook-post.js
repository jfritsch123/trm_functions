(function($) {

	var passed_data = trm_data;
	var php_version = passed_data.php_version;

	tinymce.PluginManager.add( 'insert_facebook_post', function( editor, url ) {
		// Add Button to Visual Editor Toolbar
		editor.addButton('insert_facebook_post', {
			title: 'Insert Facebook Post',
			image: url + '/facebook.png',
			cmd: 'insert_facebook_post',
			stateSelector: 'span[class]'
		});

		// Add Command when Button Clicked
		editor.addCommand('insert_facebook_post', function() {


				// Check we have selected some text selected
				var text = editor.selection.getContent({
					'format': 'html'
				});
				console.debug(text);
				if ( text.length === 0 ) {
					alert( 'Please select some text.' );
					return;
				}

				// Ask the user to enter a CSS class
				var result = prompt('Enter the CSS class');
				if ( !result ) {
					// User cancelled - exit
					return;
				}
				if (result.length === 0) {
					// User didn't enter anything - exit
					return;
				}

				// Insert selected text back into editor, wrapping it in a span tag
			editor.execCommand('mceReplaceContent', false, '<span class="' + result + '">' + text + '</span>');
			/*
			// Check we have selected some text that we want to link
			var text = editor.selection.getContent({
				'format': 'html'
			});

			editor.windowManager.open({
				url: url + '/dialog.php',
				width: 400 ,
				height: 300
			},
			{
				jquery:$,
				editor : editor,
				custom_param: 1,
				php_version: php_version
			});
			// Insert shortcode tag
			//editor.execCommand('mceReplaceContent', false, '[facebook-post id="123456"]');
			*/
		});

	});
})(jQuery);
