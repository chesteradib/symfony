
//
//////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Show shop on post show fragment
/// 2. Show shop of shop_id
////////////////////////////////////////////////////////////////////////////



function show_shop_listener()
{

    $('a.show_shop').click({where:"item"},showShopClickCallback);

}

var showShopClickCallback =  function(e)
{
    e.preventDefault();

    var $content= $('#content');
    
    //$content.moveContentToLeft();
    // always move to center
    // if current shop open => click on first item
    // 
    $(this).manageLeftActiveItem();

    var $target= $('#center');
    var $targetProgress = $("#progress_center");

    var $this= $(this);
    var shop_id=$this.data('shop-id');
    var base_url = $this.attr('data-url');
        
    var show_shop_url= base_url + shop_id +'/';

    console.log(shop_id);console.log(base_url);console.log(show_shop_url);
    var numberOfItemsPerPage= $('#content').data('number-of-items-per-center');

    $.ajax({
        type: "POST",
        url: show_shop_url,
        data:{ articles_per_page: numberOfItemsPerPage},
        cache: false,
        beforeSend:function(){
                progress.startProgress($target,$targetProgress);
            },
        success: function(data){
            $target.empty().html(data);

            show_article_listener();
            product_hover_listener();

            final_next_previous_page_listenner('center');

        },
        complete:function(){
                progress.endProgress($target,$targetProgress);
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

                }
                //show_direction();

            }
    });
    return false;
};

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to SHOW MY SHOP click, input parameters : page/ shop id
/// 2. Show my_shop
////////////////////////////////////////////////////////////////////////////


function show_my_shop_listener()
{
    $('a.show_my_shop').click(function(e){
        e.preventDefault();      
        var url = $(this).attr('data-url');
        show_my_shop(url);
        return false;
   });   
}


function show_my_shop(url)
{
    var $content= $('#content');
    $content.moveContentToRight();
    
    var $target= $('#center');
    var $targetProgress = $("#progress_center");
    var numberOfItemsPerPage= $('#content').data('number-of-items-per-center');
    $.ajax({
            type: "POST",
            data:{ articles_per_page: numberOfItemsPerPage},
            url: url,
            cache: false,
            beforeSend: function(){
                progress.startProgress($target,$targetProgress);
            },
            success: function(data){
                $('#right').empty();
                $target.empty().html(data);
                show_article_listener();
                product_hover_listener();

                final_next_previous_page_listenner('center');

            },
            complete:function(){
                progress.endProgress($target,$targetProgress);
                $('.show_article_trigger:first').children().eq(0).addClass('active');
                //var product_url=$('.show_article_trigger:first').attr("data-show-url");
                //show_article(product_url,showArticleCallback);
                //console.log($('.show_article_trigger:first'));
                $('.show_article_trigger:first').click();
            },
        });    
        return false;

  }

