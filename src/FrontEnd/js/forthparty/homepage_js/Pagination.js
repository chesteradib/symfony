////////////////////////////////////////////////////////////////////////////
/// Find number of items for left and center, knowing their respective margin
/// 
////////////////////////////////////////////////////////////////////////////


function findNumberOfItemsPer(where, margin)
{
    var $itemsContainer = $("#"+where+"-items-container");
    var itemContainerHeight = $itemsContainer.height();
    var count = 0;
    var trueTopPosition = 0;
    
    $("."+where+"-item-container").each(function(){
        trueTopPosition = $(this).position().top - $itemsContainer.position().top;
        if ( trueTopPosition + $(this).height() + margin <= itemContainerHeight)
        {           
            count++;
        }
   });
   return count;
}

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Show page of products, on click of paginated content
/// 
////////////////////////////////////////////////////////////////////////////


function final_next_previous_page_listenner(where,type)
{
    

    var $showNextPageAnchor = $("#"+where+" #show_next_page");
    var $showPreviousPageAnchor = $("#"+where+" #show_previous_page");
    var $paginationInput = $("#"+where+" #current-page");
    var $centerCententPagination = $("#"+where+" #center-content-pagination");
    var $paginationMessage = $("#"+where+" #pagination-message");
    var articlesPerPage= $('#content').data("number-of-items-per-"+where);

    var show_next_page=1;
    var show_previous_page=0;
    

    if($showNextPageAnchor.hasClass('hide')) show_next_page=0;

    $showPreviousPageAnchor.click(function(e){
        e.preventDefault();
        
        var url = $centerCententPagination.data('url');
        var current_page = $centerCententPagination.attr('data-current-page');
        current_page--;

        if(current_page>0)
        {
            show_previous_page = 1;
            $centerCententPagination.attr('data-current-page', current_page);
            if (show_next_page===0 ) $showNextPageAnchor.css('visibility','visible');   
        }
        else 
        {
            show_previous_page = 0;
            $centerCententPagination.attr('data-current-page', current_page);
            $(this).css('visibility','hidden');
            if (show_next_page===0 ) $showNextPageAnchor.css('visibility','visible');   
        }
        $paginationInput.val(current_page+1);
        
        
        switch(where)
        {
            case 'left':
                show_page_of_nonproducts(url,current_page,articlesPerPage,type);
                break;
            case 'center':
                show_page_of_products(url,current_page,articlesPerPage);
                break;
            
        }
            
        return false;
    });

    $showNextPageAnchor.click(function(e){
        e.preventDefault();
        
        var $this= $(this);
        
        var url = $centerCententPagination.data('url');
        var current_page = $centerCententPagination.attr('data-current-page');
        var total_pages = $centerCententPagination.data('total-pages');
        current_page++;

        if(current_page < total_pages -1 )
        {           
            show_next_page = 1;
            $centerCententPagination.attr('data-current-page', current_page);
            if (show_previous_page===0 ) $showPreviousPageAnchor.css('visibility','visible');   
        }
        else 
        {
            show_next_page = 0;
            $centerCententPagination.attr('data-current-page', current_page);
            $(this).css('visibility','hidden');
            if (show_previous_page===0 ) $showPreviousPageAnchor.css('visibility','visible');  
        }      
        $centerCententPagination.find('input').val(current_page+1);
        
        
        switch(where)
        {
            case 'left':
                show_page_of_nonproducts(url,current_page,articlesPerPage,type);
                break;
            case 'center':
                show_page_of_products(url,current_page,articlesPerPage);
                break;
            
        }
        
        return false;
    });
    /*
    $paginationInput.bind("change paste keyup", function() {
        //$paginationMessage.empty();
        //$paginationMessage.append("Press enter");
        console.log('bind');
    });*/
    
    $paginationInput.on("keydown",function search(e) {
        if(e.keyCode === 13) {
            var value= $(this).val();
            var total_pages = $centerCententPagination.data('total-pages');
            
            if (Math.floor(value)== value && $.isNumeric(value) && Math.floor(value) < total_pages +1 && Math.floor(value) > 0 )
            {
                var url = $centerCententPagination.data('url');
                value--;
                
                $paginationMessage.css('visibility','hidden');
                
                switch(where)
                {
                    case 'left':
                        show_page_of_nonproducts(url,current_page,articlesPerPage,type);
                        break;
                    case 'center':
                        show_page_of_products(url,current_page,articlesPerPage);
                        break;

                }
                
                $centerCententPagination.attr('data-current-page',value);
                
                var current_page = $centerCententPagination.attr('data-current-page');
                
                console.log(current_page);
                if(current_page >= total_pages -1 ) 
                { 
                    $showNextPageAnchor.css('visibility','hidden');
                }
                else 
                {
                    if (current_page <=0)
                    {
                        $showPreviousPageAnchor.css('visibility','hidden');
                    }
                    else
                    {
                        $showPreviousPageAnchor.css('visibility','visible');
                        $showNextPageAnchor.css('visibility','visible');
                    }
                }
            }
            else
            {
                $paginationMessage.css('visibility','visible');
            }
        }   
        $('#pagination-message-close').click(function(){
                $paginationMessage.css('visibility','hidden');
        });
    });
}

