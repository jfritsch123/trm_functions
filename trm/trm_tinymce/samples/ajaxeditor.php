<?php
/**
 * use ajax tinymce (not recommended)
 * jf
 * 01.06.17
 */


$settings = array(
    'media_buttons' => false,
    'tinymce'       => array(
        //'toolbar1' => 'bold, italic, underline,|,fontsizeselect',
        //'toolbar2'=>true
    ),
    'editor_height' => 200
);
$settings['textarea_name'] = 'editor_1';
wp_editor( $content, 'tmce_1' ,$settings);

_WP_Editors::enqueue_scripts();
print_footer_scripts();
_WP_Editors::editor_js();

?>
