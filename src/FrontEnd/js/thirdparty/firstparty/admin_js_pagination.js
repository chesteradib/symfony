
////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Show page of products, on click of paginated content
/// 
////////////////////////////////////////////////////////////////////////////

function next_previous_page_listenner()
{
    var show_next_page=1;
    var show_previous_page=0;
    
    if ( $("a.show_next_page").hasClass('hide')) show_next_page=0;

    $("a.show_previous_page").click(function(e){
        e.preventDefault();
        
        var url = $(this).parent().data('url');
        var current_page= $(this).parent().attr('data-current-page');
        current_page--;
        
        var base_url= url.substr(0, url.indexOf('/posts/')+('/posts/'.length));
        var target_url = base_url + current_page;
        
        if(current_page>0)
        {
            show_previous_page = 1;
            
            $(this).parent().attr('data-current-page', current_page);
            
            if (show_next_page==0 ) $("a.show_next_page").show();
        }
        else 
        {
            show_previous_page = 0;
            
            $(this).parent().attr('data-current-page', current_page);
            
            $(this).hide();
            
            if (show_next_page==0 ) $("a.show_next_page").show();
  
        }
        $(this).parent().find('input').val(current_page+1);
        show_page_of_products(target_url);
        return false;

    });

    $("a.show_next_page").click(function(e){
        e.preventDefault();
        
        var url = $(this).parent().data('url');
        var current_page= $(this).parent().attr('data-current-page');
        var total_pages = $(this).parent().data('total-pages');
        current_page++;
        
        var base_url = url.substr(0, url.indexOf('/posts/')+('/posts/'.length));
        var target_url = base_url + current_page;
               
        
        if(current_page < total_pages -1 )
        {           
            show_next_page = 1;
            
            $(this).parent().attr('data-current-page', current_page);
            
            if (show_previous_page==0 ) $("a.show_previous_page").show();
            
        }
        else 
        {
            show_next_page = 0;
            
            $(this).parent().attr('data-current-page', current_page);
            
            $(this).hide();
            
            if (show_previous_page==0 ) $("a.show_previous_page").show();
  
        }

        $(this).parent().find('input').val(current_page+1);
        show_page_of_products(target_url);
        return false;


    });
    
    $("input").bind("change paste keyup", function() {
         $('.message').empty();
         $('.message').append("Press enter");
    });
    
    
    $("input").on("keydown",function search(e) {
            if(e.keyCode == 13) {
                var value= $(this).val();
                var total_pages = $(this).parent().data('total-pages');
                
                if (Math.floor(value) == value && $.isNumeric(value) && value < total_pages +1 && value > 0 )
                {
                    var url = $(this).parent().data('url');
                    value= value -1;
                    var base_url = url.substr(0, url.indexOf('/posts/')+('/posts/'.length));
                    var target_url = base_url + value;

                    show_page_of_products(target_url);
                    if(!$('.message').is(':empty'))  $('.message').empty();

                }
                else
                {
                   $('.message').empty();
                   $('.message').append("Not valid number"); 
                }

            }
    });
}

