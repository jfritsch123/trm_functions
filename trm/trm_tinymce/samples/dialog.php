<!DOCTYPE html>
<html>
<head>
    <!-- Disable browser caching of dialog window -->
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
    <title>Insert Facebook Post</title>
</head>
<body>

    <h1>Facebookseite BG Blumenstraße</h1>

    <?php
        require_once __DIR__ . '/config.php';
        $posts = new TRMPost();
        echo $posts->getPostListAsHTML();
    ?>


    <div id="var_test">PHP Version:</div>

    <select id="attr">
        <option>class</option>
        <option>style</option>
    </select>

    <input type="text" id="res">

    <input type="button" value="Set Attribute" id="setAttr">

    <div id="allAttr"></div>

    <script language="JavaScript" type="text/javascript">

        function getAttributesAsHTML ( node ) {
            var $node = $(node);
            var html = '';
            $.each( $node[0].attributes, function ( index, attribute ) {
                html += attribute.name + ' : <input type="text" id="' + attribute.name + '" value="' + attribute.value + '"><br>';
            } );
            return html;
        }

        function removeAttribute($node,name){

        }
        var passed_arguments = top.tinymce.activeEditor.windowManager.getParams();
        var $ = passed_arguments.jquery;
        var jq = document.getElementsByTagName("body")[0];
        var editor = passed_arguments.editor;
        var selectedNode = editor.selection.getNode();
        $('#allAttr',jq).append(getAttributesAsHTML(selectedNode));
        $('#var_test',jq).append(passed_arguments.custom_param );
        $('#var_test',jq).append(passed_arguments.php_version );
        $('#setAttr',jq).on('click',function(){
            selectedNode.setAttribute($('#attr',jq).val(),$('#res',jq).val())
            editor.windowManager.close();

        })
    </script>

</body>
</html>