<?php
/**
 * Plugin Name: TinyMCE Custom Buttons
 * Plugin URI: http://wpbeginner.com
 * Version: 1.0
 * Author: WPBeginner, J.F
 * Author URI: http://www.wpbeginner.com
 * Description: TinyMCE Plugins to add custom buttons in the Visual Editor
 * License: GPL2
 */

class TinyMCE_Custom_Buttons{

    /**
     * Constructor. Called when the plugin is initialised.
     */
    function __construct() {
        if ( is_admin() ) {
            add_action( 'init', array(  $this, 'setup_tinymce_plugin' ) );
        }
    }

    /**
     * Check if the current user can edit Posts or Pages, and is using the Visual Editor
     * If so, add some filters so we can register our plugin
     */
    function setup_tinymce_plugin() {

        // Check if the logged in WordPress User can edit Posts or Pages
        // If not, don't register our TinyMCE plugin
        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
            return;
        }

        // Check if the logged in WordPress User has the Visual Editor enabled
        // If not, don't register our TinyMCE plugin
        if ( get_user_option( 'rich_editing' ) !== 'true' ) {
            return;
        }

        // Setup some filters
        add_filter( 'mce_external_plugins', array( &$this, 'add_tinymce_plugin' ) );
        add_filter( 'mce_buttons', array( &$this, 'add_tinymce_toolbar_button' ) );
        add_filter( 'tiny_mce_before_init', array( &$this, 'trm_mce_modify') );
        add_filter( 'mce_buttons_2', array( &$this, 'mce_add_buttons' ) );

        // Save Data to Pass to TinyMCE
        add_action( 'admin_head', array( &$this, 'trm_save_tinymce_data' ) );

        // setup jquery
        // not neccessary in this version (4.6) ?
        //add_action( 'admin_enqueue_scripts', array( &$this,'trm_enqueue_admin_scripts' ) );

    }

    /**
     * Adds a TinyMCE plugin compatible JS file to the TinyMCE / Visual Editor instance
     *
     * @param array $plugin_array Array of registered TinyMCE Plugins
     * @return array Modified array of registered TinyMCE Plugins
     */
    function add_tinymce_plugin( $plugin_array ) {

        $plugin_array['clear_left'] = plugin_dir_url('') . 'trm_functions/trm/trm_tinymce/clear-left/tinymce-clear-left.js';
        $plugin_array['insert_facebook_post'] = plugin_dir_url('') . 'trm_functions/trm/trm_tinymce/insert-facebook-post/tinymce-insert-facebook-post.js';
        return $plugin_array;

    }


    /**
     * Adds a button to the TinyMCE / Visual Editor which the user can click
     * to insert a link with a custom CSS class.
     *
     * @param array $buttons Array of registered TinyMCE Buttons
     * @return array Modified array of registered TinyMCE Buttons
     */
    function add_tinymce_toolbar_button( $buttons ) {
        array_push( $buttons, '|', 'clear_left' );
        array_push( $buttons, '|', 'insert_facebook_post' );
        return $buttons;
    }

    /**
     *  modify tinymce: block formats, style_formats
     *  http://alisothegeek.com/2011/05/tinymce-styles-dropdown-wordpress-visual-editor/
    title [required] 	label for this dropdown item
    selector | block | inline [required]

    selector limits the style to a specific HTML tag, and will apply the style to an existing tag instead of creating one
    block creates a new block-level element with the style applied, and will replace the existing block element around the cursor
    inline creates a new inline element with the style applied, and will wrap whatever is selected in the editor, not replacing any tags

    classes [optional] 	space-separated list of classes to apply to the element
    styles [optional] 	array of inline styles to apply to the element (two-word attributes, like font-weight, are written in Javascript-friendly camel case: fontWeight)
    attributes [optional] 	assigns attributes to the element (same syntax as styles)
    wrapper [optional, default = false] 	if set to true, creates a new block-level element around any selected block-level elements
    exact [optional, default = false] 	disables the “merge similar styles” feature, needed for some CSS inheritance issues
     */
    function trm_mce_modify( $init ) {
        $init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3';

        $style_formats = array (
            array(
                'title' => 'Bildumbruch',
                'selector' => 'p',
                'styles' => array(
                    'clear' => 'left'
                )
            ),
            array(
                'title' => 'Großbuchstaben',
                'inline' => 'span',
                'styles' => array(
                    'textTransform' => 'uppercase'
                )
            )

        );

        $init['style_formats'] = json_encode( $style_formats );
        $init['style_formats_merge'] = false;
        return $init;
    }

    /**
     * Filter to add buttons
     * @param $buttons
     * @return mixed
     */
    function mce_add_buttons( $buttons ){
        // insert element 'styleselect' on 2cnd position (1), remove (0) elements
        array_splice( $buttons, 1, 0, 'styleselect' );
        return $buttons;
    }

    /**
     * Outputs JavaScript which stores data we need to pass from the server to the
     * client.
     */
    function trm_save_tinymce_data() {
        /**
         * Essentially, all we are doing is creating a JavaScript variable in the
         * global namespace. We will then retrieve this in the TinyMCE dialog. This
         * function is merely outputting content the the head section of the WordPress
         * admin.
         */

        ?>
        <script type='text/javascript'>
            var trm_data = {
                'php_version': '<?php echo phpversion(); ?>'
            };
        </script>
        <?php
    }

    /**
     * Enqueue jQuery
     *
     * More information on jQuery and TinyMCE in Wordpress can be found here:
     * http://johnmorris.me/computers/using-jquery-and-jquery-ui-in-tinymce-dialog-iframe/
     */
    function trm_enqueue_admin_scripts() {
        wp_enqueue_script( 'jquery' );
    }

}

$tinymce_custom_buttons = new TinyMCE_Custom_Buttons();
