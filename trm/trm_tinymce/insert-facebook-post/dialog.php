<!DOCTYPE html>
<html>
<head>
    <!-- Disable browser caching of dialog window -->
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
    <title>Insert Facebook Post</title>
    <style type="text/css">
        body{
            font-family:"Arial", "sans-serif";
            font-size:14px;
        }
        .fb-post-object{
            background-color:#efefef;
            cursor:pointer;
        }
        .fb-post-object:hover{
            background-color:#cfcfcf;
        }

    </style>
</head>
<body>

    <h2>Facebookseite BG Blumenstraße</h2>

    <?php
        $admin = dirname( __FILE__ ) ;
        $admin = substr( $admin , 0 , strpos( $admin , "wp-content" ) ) ;
        require_once( $admin . 'wp-admin/admin.php' ) ;
        require_once WP_PLUGIN_DIR . '/trm_functions/trm/trm_facebook/config.php';
        $posts = new TRMPost();
        echo $posts->getPostListAsHTML();

    ?>


    <script language="JavaScript" type="text/javascript">

        var ajaxurl = <?php echo json_encode(admin_url( 'admin-ajax.php' ));?>;
        var ajaxnonce = <?php echo json_encode(wp_create_nonce( 'trm_functions_request_nonce' ))?>;

        var passed_arguments = top.tinymce.activeEditor.windowManager.getParams();
        var $ = passed_arguments.jquery;
        var jq = document.getElementsByTagName("body")[0];
        var editor = passed_arguments.editor;
        $('div.fb-post-object',jq).on('click',function(){
            var data = {
                action: 'trm_gallery_request',
                nonce: ajaxnonce,
                type: 'facebook',
                mode: 'link',
                id: $(this).data('id')
            };
            $(jq).html('<h1>loading content ...</h1>');
            $.post(ajaxurl, data, function(response) {
                if (response.success) {
                    editor.execCommand('mceReplaceContent', false, response.data);
                    editor.windowManager.close();
                } else {
                    // TODO
                }
            })
        })

    </script>

</body>
</html>