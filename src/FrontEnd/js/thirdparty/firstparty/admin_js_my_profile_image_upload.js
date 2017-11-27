
function profile_upload_listener()
{
    $(':file').change(function(){

        var file = this.files[0];

        var url= $('.fos_user_profile_edit').attr('data-iu-url');
        
        var formData = new FormData($('form')[0]);
  
        $.ajax({
            url: url,
            type: 'POST',
            xhr: function() {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();

                if(myXhr.upload){ // Check if upload property exists
                    myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
                }
                return myXhr;
            },
            //beforeSend: beforeSendHandler, 
            success: completeHandlerProfile,
            //error: errorHandler,
            data: formData,
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false,
            contentType: false,
            processData: false
        });
        //$(this).replaceWith($(this).clone(true).val('')); 
        
    });

}

function completeHandlerProfile(data){

$('.profile_picture').empty();
$('.profile_picture').append(data);
delete_profile_photo_listener();
return;


}

function delete_profile_photo_listener()
{
     $('.profile_picture').on("click", "a.delete_profile_photo_trigger", function(e){

        e.preventDefault();  
        
        var url=$(this).parent().attr("url");
        var id=$(this).parent().attr("id");

        delete_profile_photo(url, id);
               
   });

}

function delete_profile_photo(url, id)
{
    $('.profile_picture a').remove();
    $.ajax({
                    type: "POST",
                    url: url,
                    cache: false,
                    success: function(data){       
                    }
                    });  
}



