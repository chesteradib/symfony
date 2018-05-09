(function(){
    
    var $ = jQuery;
    
    ////////////////////////////////////////////////////////////////////////
    /// On document ready : 
    /// 1. Listen to SHOW categories click
    ////////////////////////////////////////////////////////////////////////
    
    $(function(){
        $(".show_categories_trigger").click(showCategoriesListener); 
        $(".show_category_trigger").click(showCategoryListener); 
    });
    
    ////////////////////////////////////////////////////////////////////////
    /// Show category callback
    ////////////////////////////////////////////////////////////////////////

    var showCategoriesListener = function(e)
    {
        e.preventDefault();
        var $categoriesDialog = $('.categories_dialog');
        console.log($categoriesDialog);
        if($categoriesDialog.is(":visible")) 
        {        
            console.log($categoriesDialog);
            $categoriesDialog.hide();
            
        }
        else
        {
            $categoriesDialog.show(); 
        }
        return;
    };
    
    var showCategoryListener = function(e)
    {
        e.preventDefault();

        var url_category = $('#content').attr('data-url-category');
        var category_id =  $(this).attr('data-id');
        show_category_articles(url_category,category_id);
        return false;

        
    };
    
    
////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Show page of products of market, input parameters : page
/// 2. Show page of products of market
////////////////////////////////////////////////////////////////////////////

var show_category_articles= function(url,category_id)
{
    var $content= $('#content');
    $content.moveContentToRight();
    
    var $right= $('#right');
    var $target= $('#center');
    var $targetProgress = $("#progress_center");
    var numberOfItemsPerCenter= $('#content').data('number-of-items-per-center');
    
    $.ajax({
            type: "POST",
            url: url,
            data:{ articles_per_page: numberOfItemsPerCenter,
                   category_id: category_id
                },
            cache: false,
            beforeSend:function(){
                progress.startProgress($target,$targetProgress);
            },
            success: function(data){
                if(data.status){  
                    $target.empty().html(data.html);               
                    show_article_listener();
                    product_hover_listener();
                    final_next_previous_page_listenner('center');

                    if(!data.empty)
                    {
                        $('.show_article_trigger:first').children().eq(0).addClass('active');
                        var product_url=$('.show_article_trigger:first').attr("data-show-url");
                        show_article(product_url,showArticleCallback);
                    }
                    else{
                        $right.empty();
                        console.log('0');
                    }
                }

            },
            complete:function(){
                progress.endProgress($target,$targetProgress);
                
            }
        });    
        return false;
}
    
})();



