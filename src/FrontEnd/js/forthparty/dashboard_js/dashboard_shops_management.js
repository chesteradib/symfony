
//
//////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Show shop on post show fragment
/// 2. Show shop of shop_id
////////////////////////////////////////////////////////////////////////////


function show_shop_listener_others()
{
    //always move to center , if current shop open => click on first item
    //                        if current shop not open => LOAD SHOP =>click first
    
    $('.network_dialog').on('click', 'a.show_shop',{where:"my_network"},showShopClickCallback);
    $('.my_market_dialog').on('click', 'a.show_shop',{where:"my_market"},showShopClickCallback); // show people i follow in left and show first item form shop
    $('#left').on('click', '.all_my_inbox a.show_shop',{where:"all_my_inbox"},showShopClickCallback); // keep left as it is  show first item form shop
    $('#left').on('click', '.all_my_network a.show_shop',{where:"all_my_network"},showShopClickCallback); // keep left as it is  show first item form shop
}

function show_shop_listener()
{

    $('a.show_shop.item').click({where:"item"},showShopClickCallback);
   
}

var showShopClickCallback=  function(e)
{
    e.preventDefault();

    var $content= $('#content');
    
    //$content.moveContentToLeft();
    // always move to center
    // if current shop open => click on first item
    // 
    $(this).manageLeftActiveItem();
    
    var $target= $('#center');
    var $targetProgress = $("#center_progress");
    
    var $this= $(this);
    var shop_id=$this.data('shop-id');
    var base_url = $this.attr('data-url');
        
    var show_shop_url= base_url + shop_id+'/';
    

    var numberOfItemsPerPage= $('#content').data('number-of-items-per-center');
    var second_class= $this.attr('class').split(' ')[1];
    
    var followSeen = second_class === 'my_networkk' ? true : false;

    $.ajax({
        type: "POST",
        url: show_shop_url,
        data:{ articles_per_page: numberOfItemsPerPage , followSeen: followSeen },
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

            switch(second_class)
            {
            case 'my_markett':
                var value_to_substract= parseInt($this.find('.m-result').text());
                decrement_notification_count_by('my_market', value_to_substract);
                break;
            case 'my_networkk':
                decrement_notification_count_by('my_followers', 1);
                break;
            default:
                break;
            }
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

                }
                show_direction();

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
    var $targetProgress = $("#center_progress");
    var numberOfItemsPerPage= $('#content').data('number-of-items-per-center');
    $.ajax({
            type: "POST",
            data:{ articles_per_page: numberOfItemsPerPage},
            url: url,
            cache: false,
            beforeSend: function(){
                progress.firstProgress($target,$targetProgress,65);
            },
            success: function(data){
                $('#right').empty();
                $target.empty().html(data);
                show_article_listener();
                product_hover_listener();
            
                progress.secondProgress($targetProgress,85);
            
             
                final_next_previous_page_listenner('center');

            },
            complete:function(){
                progress.thirdProgress($target,$targetProgress);
                var new_article_url=$('#content').attr("data-new-article-url");
                new_article(new_article_url);
            },
        });    
        return false;

  }

