(function($){
    $("#recipe_rating").bind( 'rated', function(){
        $(this).rateit( 'readonly', true );

        var form        =   {
            action:         'r_rate_recipe',
            rid:            $(this).data( 'rid' ),
            rating:         $(this).rateit( 'value' )
        };

        $.post( recipe_obj.ajax_url, form, function(data){
            
        });
    });

    $("#event-form").on('submit', function(e){
        e.preventDefault();

        $(this).hide();

        $("#event-status").html(
            '<div class="alert alert-info>Please wait! we are submitting your event</div>'
        )

        let form = {
            action: 'r_submit_event',
            title: $("#r_inputTitle").val(),
            content: tinymce.activeEditor.getContent()
        }

        $.post(event_obj.ajax_url, form, function(data){
            if(data.status == 2) {
                $("#event-status").html(
                    '<div class="alert alert-success>Event submitted successfully</div>'
                )
            } else {
                $("#event-status").html(
                            '<div class="alert alert-danger>Unable to submit event. Please fill in all fields</div>'
                )
                $('#event-form').show();
            }
        })
    })
})(jQuery);