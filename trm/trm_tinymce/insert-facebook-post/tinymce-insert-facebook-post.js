(function($) {

	var passed_data = trm_data;
	var php_version = passed_data.php_version;

	tinymce.PluginManager.add( 'insert_facebook_post', function( editor, url ) {
		// Add Button to Visual Editor Toolbar
		editor.addButton('insert_facebook_post', {
			title: 'Insert Facebook Post',
			image: url + '/facebook.png',
			cmd: 'insert_facebook_post',
		});

		// Add Command when Button Clicked
		editor.addCommand('insert_facebook_post', function() {

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

		});

	});
})(jQuery);
