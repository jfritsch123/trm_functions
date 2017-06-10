/**
 * trm scripts for menu schedule
 * wordpress 4.8 wp.editor
 * see https://make.wordpress.org/core/2017/05/20/editor-api-changes-in-4-8/
 */

( function( $ ) {

    $( document ).ready( function() {

        /**
         * datepicker
         */
        $('#datepicker-control').datepicker({
            dateFormat:'dd.mm.yy',
            firstDay: 1,
            showOtherMonths: true,
            selectOtherMonths: true,
            monthNames: ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'],
            monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun'],
            dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
            dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
            onSelect:function(){
                var date = $('#datepicker-control').datepicker('getDate');
                $('#datepicker').val($.datepicker.formatDate( "dd.mm.yy", date ));
                $('#menu-schedule-form-action').val('select');
                trm_load_ajax($('#menu-schedule-form').serialize(),$('#col-right'),function($container,response){
                    $container.html(response.data);
                    wp.editor.remove('editor_1');
                    wp.editor.initialize('editor_1',{tinymce:true,quicktags:true});
                });
            }
        });

        /**
         * only fort testing: get settings
         */
        $( document ).on( 'wp-before-tinymce-init', function( event, settings ) {
            console.debug(settings);
        });

        /**
         * form submit button
         */
        $(document).on('click','#menu-schedule-form-submit',function(e){
            tinyMCE.triggerSave();
            $('#menu-schedule-form-action').val('insert_update_table');
            trm_load_ajax($('#menu-schedule-form').serialize(),$('#col-right'),function($container,response){
                $container.html(response.data);
                $('#menu-schedule-form-action').val('2weeks-menu');
                wp.editor.remove('editor_1');
                wp.editor.initialize('editor_1',{tinymce:true,quicktags:true});

                // reload 2 weeks menu preview (#col-left)
                trm_load_ajax($('#menu-schedule-form').serialize(),$('#2weeks-menu'),function($container,response){
                    $container.html(response.data);
                });

            });

        });

        /**
         * drop down change event
         */
        $(document).on('change','#show_from_next_weekday',function(){
            $('#menu-schedule-form-action').val('update_option')
            trm_load_ajax($('#menu-schedule-form').serialize(),$('#trm-ajax-status'));
        })

        /**
         * convert links in weekmenus to ajax calls
         */
        $(document).on('click','table.admin-weekmenu a',function(e){
            e.preventDefault();
            $('#menu-schedule-form-action').val('select');
            $('#datepicker').val($(this).data('date'));
            trm_load_ajax($('#menu-schedule-form').serialize(),$('#col-right'),function($container,response){
                $container.html(response.data);
                wp.editor.remove('editor_1');
                wp.editor.initialize('editor_1',{tinymce:true,quicktags:true});
            });

        })

        /**
         * media uploader
         */
        var custom_uploader;
        $(document).on('click','#upload_image_button',function(e) {
            e.preventDefault();

            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }

            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: true
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function() {
                //console.log(custom_uploader.state().get('selection').first().toJSON());
                attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#upload_image_id').val(attachment.id);
                $('#attachment_image > img').attr('src',attachment.sizes.thumbnail.url);
            });

            //Open the uploader dialog
            custom_uploader.open();

        });

        /**
         * remove image
         */
        $(document).on('click','#remove_image_button',function(e) {
            $('#upload_image_id').val('');
            $('#attachment_image > img').attr('src',$('#attachment_image').data('placehold-url'));
        });

    });
} )( jQuery );
