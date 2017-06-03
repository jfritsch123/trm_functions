/**
 * trm scripts for menu schedule
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
                $('#menu-schedule-form').submit();
            }
        });

        // set highlighted date oft datepicker control
        if($( "#datepicker-control" ).length){
            if($('#datepicker').val()){
                $( "#datepicker-control" ).datepicker( "setDate", $('#datepicker').val());
            }
        }

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

        $(document).on('click','#remove_image_button',function(e) {
            $('#upload_image_id').val('');
            $('#attachment_image > img').attr('src',$('#attachment_image').data('placehold-url'));
        });

        });
} )( jQuery );
