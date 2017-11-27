////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
// first file for profile
////////////////////////////////////////////////////////////////////////////////



show_profile_listener();


function show_profile_listener()
{  
     $('a.show_my_profile').click(function(e){
        e.preventDefault();      
        var url = $('a.show_my_profile').attr('data-url');
        show_profile(url);
        return false;
   }); 
}

function show_profile(url)
{

    
    $.ajax({
                    type: "GET",
                    url: url,
                    cache: false,
                    beforeSend:centerProgressFirstBreak,
                    success: function(data){
                      $('.right').empty();
                      $('.center').empty();
                      $('.center').html(data);
                      
                      show_edit_profile_listener();
                      initialize_show_profile_map();
                      deactivate_profile_listener();
                      centerProgressSecondBreak();

                    },
                    complete:centerProgressThirdBreak
                    });    
    
}

function show_edit_profile_listener()
{
     $('a.edit_my_profile').click(function(e){
        e.preventDefault();    
        var url = $('a.edit_my_profile').attr('data-url');
        show_edit_profile(url);
        return false;
   });
}

function show_edit_profile(url)
{
    $.ajax({
                    type: "GET",
                    url: url,
                    cache: false,
                    beforeSend:centerProgressFirstBreak,
                    success: function(data){
                      
                      $('.center').empty();
                      $('.center').html(data);
                      initi();
                      profile_upload_listener();
                      update_profile_listener();
                      cancel_button_in_edit_profile_listener();
                      centerProgressSecondBreak();
                      

                    },
                    complete:centerProgressThirdBreak
                    });    
    
}



function update_profile_listener()
{
        $(".fos_user_profile_edit").submit(function(){ 
        
         var data= $(this).serialize();

         var url= $(this).attr('action');
         
         update_profile(data,url,update_profile_callback);      
         return false;
});
      
}


function update_profile(data,url,callback)
{
    $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            beforeSend:centerProgressFirstBreak,
            success: callback,
            complete:centerProgressThirdBreak
        });    
        return false;
}


 function update_profile_callback(data){
                
                      $('.center').empty();
                      $('.center').html(data);
                      
                      show_edit_profile_listener();
                      update_profile_listener();   
                      //initialize_show_profile_map();
                      initi();
                      
                      centerProgressSecondBreak();
               
                       
            }
    

    function initi() {
        
        //var url= $(".fos_user_profile_edit").attr("data-latlngjson");
        var latitude;
        var longitude;
        var myLatlng;
        var map;


        latitude= document.getElementById("fos_user_profile_form_latitude").value;
        longitude= document.getElementById("fos_user_profile_form_longitude").value;
        myLatlng = new google.maps.LatLng(latitude, longitude);
           
           
        var myOptions = {
            zoom: 8,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

        var marker = new google.maps.Marker({
            draggable: true,
            position: myLatlng,
            map: map,
            title: "Your location"
        });

        google.maps.event.addListener(marker, 'dragend', function (event) {
            document.getElementById("fos_user_profile_form_latitude").value = event.latLng.lat();
            document.getElementById("fos_user_profile_form_longitude").value = event.latLng.lng();
        });

    }
    
    
    function initialize_show_profile_map() {

        var latitude= $(".fos_user_user_show").attr("data-latitude");
        var longitude= $(".fos_user_user_show").attr("data-longitude");
        var myLatlng= new google.maps.LatLng(latitude, longitude);
        var map;

        var myOptions = {
            zoom: 8,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map-profile-show"), myOptions);

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: "Your location"
        });   

    }
    
////////////////////////////////////////////////////////////////////////////
/// Listen to cancel button  edit profile page
/// 
////////////////////////////////////////////////////////////////////////////

    
    function cancel_button_in_edit_profile_listener()
{
     $('a.cancel_button_edit_profile').click(function(e){ 
            e.preventDefault(); 
            var url = $(this).attr('data-url');
            show_profile(url);
            return false;
   });
}



////////////////////////////////////////////////////////////////////////////
/// Listen to deactivate profile in show profile page
/// Deactivate profile
////////////////////////////////////////////////////////////////////////////

    
function deactivate_profile_listener()
{
     $('a.deactivate_my_profile').click(function(e){ 
            e.preventDefault(); 
            var url = $(this).attr('data-url');
            deactivate_profile(url);
            return false;
   });
}


function deactivate_profile(url)
{
    $.ajax({
            type: "POST",
            url: url,
            cache: false,
            success: function(data)
            {
                location.href = data;
            }
        });    
        return false;
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
// second file for profile
////////////////////////////////////////////////////////////////////////////////

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



