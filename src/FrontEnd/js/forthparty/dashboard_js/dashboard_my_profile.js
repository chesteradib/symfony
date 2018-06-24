var profile = (function(){

    var $content= $('#content');
    var $right = $('#right');
    var $center = $('#center');
    var $left = $('#left');
    var $deleteProfilePictureTrigger = $('#delete_profile_picture_trigger');
    var $profilePicture = $('#profile_picture');

    var show_profile_listener = function ()
    {
        $('a.show_my_profile').click(function(e){
            $content.moveContentToLeft();
            e.preventDefault();
            var url = $('a.show_my_profile').attr('data-url');
            show_profile(url);
            return false;
        });
    };

    var show_profile = function(url)
    {
        Utils.ajax_call("GET", url, {} , true, startPogressLeft ,showProfileCallback, endPogressLeft);
        return false;
    };


    var showProfileCallback = function(data)
    {
        $right.empty();
        $center.empty();
        $left.empty().html(data);

        deactivate_profile_listener();
        profile_upload_listener();
        profile_image_Upload_listener();
        delete_profile_photo_listener();
        return false;
    };




    var profile_upload_listener =  function()
    {
        $('a#change_profile_picture_trigger').click(function(e){
            e.preventDefault();

            $('#fos_user_profile_form_profile_picture').trigger('click');
            return false;
        });

    }

    var profile_image_Upload_listener= function()
    {
        $('input[type=file]').on('change',function(e){

            var url= $(this).attr('data-iu-url');
            var formData = new FormData($('form#user_profile_form_profile_picture')[0]);
            Utils.ajax_call("POST", url, formData , false, function(){}, completeHandlerProfile, function(){}, false, false);
            return false;

        });
    }

    var completeHandlerProfile = function(data){

        $('#profile_picture').attr('src', data);
        $('#delete_profile_picture_trigger').show();
        delete_profile_photo_listener();
        return false;


    }

    ////////////////////////////////////////////////////////////////////////////
    /// delete_profile_photo
    ////////////////////////////////////////////////////////////////////////////


    var delete_profile_photo_listener = function ()
    {
        $('#delete_profile_picture_trigger').on("click", function(e){

            e.preventDefault();
            var url=$(this).attr("data-id-url");

            delete_profile_photo(url);
            return false;
        });

    }

    var  delete_profile_photo = function(url)
    {
        Utils.ajax_call("POST", url, {} , false, function(){}, deleteProfilePhotoComplete, function(){});
        return false;

    }

    var deleteProfilePhotoComplete = function(data){

        $('#profile_picture').attr('src', data);
        $('#delete_profile_picture_trigger').hide();
        return false;


    }

    ////////////////////////////////////////////////////////////////////////////
    /// Listen to deactivate profile in show profile page
    ////////////////////////////////////////////////////////////////////////////


    var deactivate_profile_listener = function()
    {
        $('a.deactivate_my_profile').click(function(e){
            e.preventDefault();
            var url = $(this).attr('data-url');
            deactivate_profile(url);
            return false;
        });
    };

    ////////////////////////////////////////////////////////////////////////////
    /// Deactivate profile
    ////////////////////////////////////////////////////////////////////////////

    var deactivate_profile = function(url)
    {
        Utils.ajax_call("POST", url, data , false, startPogressLeft, deactivateProfileCallback, endPogressLeft, false, false);
        return false;
    };

    var deactivateProfileCallback = function(data){

        //add simple http alert with 2 buttons
        location.href = data;
    }



    return {
        show_profile_listener: show_profile_listener
    };


})();


