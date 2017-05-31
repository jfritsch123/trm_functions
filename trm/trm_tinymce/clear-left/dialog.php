<!DOCTYPE html>
<html>
<head>
    <!-- Disable browser caching of dialog window -->
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
    <title>clear left</title>
</head>
<body>

    <h1>clear left</h1>

    <div id="action"></div>

    <script language="JavaScript" type="text/javascript">

        var passed_arguments = top.tinymce.activeEditor.windowManager.getParams();
        var $ = passed_arguments.jquery;
        var jq = document.getElementsByTagName("body")[0];
        var editor = passed_arguments.editor;
        var $selectedNode = $(editor.selection.getNode(),jq);

        var str = (typeof $selectedNode.attr('style') != 'undefined') ? $selectedNode.attr('style').replace(/ /g,"") : '';

        if(str.indexOf('clear:left') > -1){
            $('#action',jq).append('<input type="button" id="remove" value="Lösche Clear Left">');
        }else{
            $('#action',jq).append('<input type="button" id="insert" value="Clear Left">');
        }
        $('#insert',jq).on('click',function(){
            $selectedNode.attr('style','clear:left');
            editor.windowManager.close();
        });
        $('#remove',jq).on('click',function(){
            $selectedNode.removeAttr('style');
            editor.windowManager.close();
        });

    </script>

</body>
</html>