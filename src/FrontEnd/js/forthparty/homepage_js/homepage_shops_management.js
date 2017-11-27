function show_shop_listener()
{
    $('#content').on('click','a.show_shop', showShopClickCallback);
}

var showShopClickCallback =  function(e)
{
    e.preventDefault();
    var $content= $('#content');
   
    
    var $target= $('#center');
    var $targetProgress = $("#center_progress");
    console.log($(this).attr('class'));
    var $this= $(this);
    var shop_id=$this.data('shop-id');
    var base_url = $this.attr('data-url');
        
    var show_shop_url= base_url + shop_id+'/';
    
    var numberOfItemsPerCenter= $('#content').data('number-of-items-per-center');

    $.ajax({
        type: "POST",
        url: show_shop_url,
        data:{ articles_per_page: numberOfItemsPerCenter},
        cache: false,
        beforeSend:function(){
            progress.firstProgress($target,$targetProgress,65);
        },
        success: function(data){
            $target.empty().html(data);
            show_article_listener();
            product_hover_listener();
            progress.secondProgress($targetProgress,85);
             
            final_next_previous_page_listenner('center');
            follow_unfollow_in_homepage_listener();
        },
            
        complete:function(){
            progress.thirdProgress($target,$targetProgress);
            $content.moveContentToCenter();
            
            if($('.show_article_trigger').length >0 )
                {
                    var product_url=$('.show_article_trigger:first').attr("data-show-url");
                    $('.show_article_trigger:first').manageActiveItem();    
                    show_article(product_url,showArticleCallback);
                }
            else $('#right').empty();

            if(!$this.hasClass('users'))
            {
                show_all_new_posters();
                //console.log($('.show_article_trigger')[0]);
                     
            }
            
                   
        }
    });    
    return false; 
};

//////////////////////////////////////////////////////////////////////////////
/// 1. Product Hover listener
////////////////////////////////////////////////////////////////////////////

function product_hover_listener()
{
 
    $('.product-image-and-title').hover(function() {
        //$(this).parent().find('.product-title-in-posts').show();
        $(this).find('.product-title-in-posts').css('z-index', 3000);

        }, 
        function() {
        //$(this).parent().find('.product-title-in-posts').hide();
        $(this).find('.product-title-in-posts').css('z-index', -1);
    });
    
}

