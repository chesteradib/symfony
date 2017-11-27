
////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Show page of products of market, input parameters : page
/// 2. Show page of products of market
////////////////////////////////////////////////////////////////////////////


function show_all_my_market_listener()
{
    
    $('a#show_all_my_market').click(function(e){
        e.preventDefault();      
        var url = $('#content').attr('data-url-show-all-my-market');
        console.log('show_all_my_market'+url);
        show_all_my_market(url);
        return false;
    });
    
}


function show_all_my_market(url)
{
    var $content= $('#content');

    var $target= $('#center');
    var $targetProgress = $("#center_progress");
    var numberOfItemsPerPage= $('#content').data('number-of-items-per-center');
    
    $.ajax({
            type: "POST",
            url: url,
            data:{ articles_per_page: numberOfItemsPerPage},
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
            },
            complete:function(){
                progress.thirdProgress($target,$targetProgress);
                $content.moveContentToCenter();
                var url= $('#content').attr('data-url-show-all-my-followeds');
                console.log(url);
                show_all_my_network(url,true);
                
            }
        });    
        return false;

  }
  
////////////////////////////////////////////////////////////////////////////
/// 
////////////////////////////////////////////////////////////////////////////

function my_market(data)
{
    var $myMarketContent= $('#my_market_content');
    
    if(!$myMarketContent.is(':empty')){

            var $noItems= $myMarketContent.find('#no-items-my_market');
            if($noItems.length !== 0) $noItems.remove();
            
            
            
            var $dataShopId= $('#my_market_content a[data-shop-id='+data.followed_id+']');
           
            if($dataShopId.length === 0) 
            {
                var newPostItemTemplate= $.templates("#newPostItemTemplate");
                var html =  newPostItemTemplate.render(data);   
                $myMarketContent.prepend(html);
            }
            else
            { 
               var $di= $($dataShopId[0]);
               var current_number= parseInt($dataShopId.find('.m-result').text());
               $di.find('.m-result').text(current_number+1);
               $dataShopId.remove();
               $myMarketContent.prepend($di[0]);
                  
            }
       }
       else
       {

           
       }
        
}


////////////////////////////////////////////////////////////////////////////
/// 1. Listen to SHOW INBOX click
/// 2. Show Inbox Callback
//  3. Bring messages of inbox via ajax before displaying them 
//  4. Bring Inbox callback
//  5. Hide the div when click outside callback
//  6. Call of the necessary function when document ready
//  
////////////////////////////////////////////////////////////////////////////

var inprogress3 = true;

function show_my_market_listener(){
    $(".show_my_market_trigger").click(showMyMarketDialogListener); 
}

var showMyMarketDialogListener = function(e)
{
    e.preventDefault();

    var $myMarketDialog = $('.my_market_dialog');
    var $myMarketContent= $('#my_market_content');
    var $targetProgress= $('#my_market_progress');

    if($myMarketDialog.is(":visible")) 
    {        
        $myMarketDialog.hide();        
    }
    else{
        $myMarketDialog.show();
    }

    if($myMarketContent.is(":empty") && inprogress3=== true ) {

        inprogress3= false;
        var url= $(this).attr('data-url');             
        $.ajax({
            type: "GET",
            url: url,
            cache: false,
            beforeSend: function(){
                progress.firstProgress($myMarketContent,$targetProgress,85);
            }, 
            success: function(data){
                $myMarketContent.append(data);
                progress.secondProgress($targetProgress,95);
                show_all_my_market_listener();
            },
            complete: function(){
                progress.thirdProgress($myMarketContent,$targetProgress);
            }
        });
    }
};

/*product_hover_listener();*/

function product_hover_listener()
{
 
    $('.product-image-and-title').hover(function() {
        //$(this).parent().find('.product-title-in-posts').show();
        $(this).find('.product-title-in-posts').css('z-index', 3000);

    }, function() {
        //$(this).parent().find('.product-title-in-posts').hide();
        $(this).find('.product-title-in-posts').css('z-index', -1);
});
    
}

