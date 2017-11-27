
////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Show page of products, on click of paginated content
/// 
////////////////////////////////////////////////////////////////////////////


function final_next_previous_page_listenner()
{

    var $paginationInput = $("#current-page");
    var $mobileCententPagination = $("#mobile-content-pagination");
    var $paginationMessage = $("#pagination-message");

    $paginationInput.on("keydown",function search(e) {
        if(e.keyCode === 13) {
            var value= $(this).val();
            var total_pages = $mobileCententPagination.data('total-pages');
            
            if (Math.floor(value)== value && $.isNumeric(value) && Math.floor(value) < total_pages +1 && Math.floor(value) > 0 )
            {
                $paginationMessage.css('visibility','hidden');
                var url = $mobileCententPagination.data('url');
                value--;
                var newUrl= url.slice(0,url.lastIndexOf('/')+1);
                window.location= newUrl+value;

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

$(function(){
    
    final_next_previous_page_listenner();
});