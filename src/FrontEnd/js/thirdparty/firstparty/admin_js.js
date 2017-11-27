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
                    success: function(data){
                      
                      $('.contents').empty();
                      $('.contents').html(data);
                      
                      show_edit_profile_listener();

                    }
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
                    success: function(data){
                      
                      $('.contents').empty();
                      $('.contents').html(data);

                    }
                    });    
    
}
