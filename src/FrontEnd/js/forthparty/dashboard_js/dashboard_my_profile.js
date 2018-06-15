var profile = (function(){

    var $content= $('#content');
    var $right = $('#right');
    var $center = $('#center');
    var $left = $('#left');

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
    };


    var showProfileCallback = function(data)
    {
        $right.empty();
        $center.empty();
        $left.empty().html(data);

        show_edit_profile_listener();
        //initialize_show_profile_map();
        deactivate_profile_listener();

    };

    var show_edit_profile_listener = function()
    {
        $('a.edit_my_profile').click(function(e){
            e.preventDefault();
            var url = $('a.edit_my_profile').attr('data-url');
            show_edit_profile(url);
            return false;
        });
    };

    var show_edit_profile = function(url)
    {
        Utils.ajax_call("GET", url, {} , true, startPogressLeft ,showEditProfileCallback, endPogressLeft);
    };

    var showEditProfileCallback = function(data)
    {
        $left.empty().html(data);
        //initi();
        profile_upload_listener();
        update_profile_listener();
        cancel_button_in_edit_profile_listener();

    };


    function update_profile_listener()
    {
        $(".fos_user_profile_edit").submit(function(){
            var data= $(this).serialize();
            var url= $(this).attr('action');

            update_profile(data,url);
            return false;
        });

    };


    function update_profile(data,url)
    {
        Utils.ajax_call("POST", url, data , false, startPogressLeft,updateProfileCallback, endPogressLeft, false, false);
        return false;
    }


    var updateProfileCallback = function(data){

        $left.empty().html(data);

        show_edit_profile_listener();
        update_profile_listener();
        //initialize_show_profile_map();
        //initi();
    };


    var initi = function() {

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

    };


    var initialize_show_profile_map = function(){

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

    };

////////////////////////////////////////////////////////////////////////////
/// Listen to cancel button  edit profile page
///
////////////////////////////////////////////////////////////////////////////


    var cancel_button_in_edit_profile_listener = function ()
    {
        $('a.cancel_button_edit_profile').click(function(e){
            e.preventDefault();
            var url = $(this).attr('data-url');
            show_profile(url);
            return false;
        });
    };



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

        location.href = data;
    }

    var profile_upload_listener =  function()
    {
        $(':file').change(function(){

            var url= $('.fos_user_profile_edit').attr('data-iu-url');
            var formData = new FormData($('form')[0]);

            Utils.ajax_call("POST", url, formData , false, function(){}, completeHandlerProfile, function(){}, false, false);
            return false;
        });

    }

     var completeHandlerProfile = function(data){

        $('.profile_picture').empty().append(data);
        delete_profile_photo_listener();
        return;


    }

    var delete_profile_photo_listener = function ()
    {
        $('.profile_picture').on("click", "a.delete_profile_photo_trigger", function(e){

            e.preventDefault();

            var url=$(this).parent().attr("url");
            var id=$(this).parent().attr("id");

            delete_profile_photo(url, id);

        });

    }

    var  delete_profile_photo = function(url, id)
    {
        $('.profile_picture a').remove();

        Utils.ajax_call("POST", url, data , false, function(){}, function(){}, function(){});
        return false;

    }



    return {
        show_profile_listener: show_profile_listener
    };


})();


