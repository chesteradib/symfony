function validation_errors_control_listener()
{

    $('.error-message-close').click(function(){  
        $(this).parents().eq(1).hide();
    });
}
