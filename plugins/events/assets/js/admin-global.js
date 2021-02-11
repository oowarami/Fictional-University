(function($){
    $(document).on( "click", "#r-recipe-pending-notice .notice-dismiss",  function(e){
        e.preventDefault();

        $.post( ajaxurl, {
            action:         'r_dismiss_pending_recipe_notice'
        });
    });
})(jQuery);