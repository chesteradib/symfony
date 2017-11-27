////////////////////////////////////////////////////////////////////////////
/// Configuration of JSRender so that {{ and }} don't conflict with twig ones
//  They are now replaced by <% and %>
////////////////////////////////////////////////////////////////////////////

$.views.settings.delimiters("<%", "%>");
$.views.converters("hmm", function(date) {
    return moment(date).format("HH:mm");
});
$.views.converters("mmmdo", function(date) {
    return moment(date).format("MMM-D");
});

/////////////////////////////////////////////////////////////////////////


function validation_errors_control_listener()
{

    $('.error-message-close').click(function(){  
        $(this).parents().eq(1).hide();
    });
}

$(function(){
    add_new_inputForImageUpload_listener();
    imageUpload_listener();
    imageDelete_listener();
    validation_errors_control_listener();
    set_as_main_listener();
})
