
//////////////////////////////////////////////////////////////////////////////
/// Call to listener of show page of products of market
////////////////////////////////////////////////////////////////////////////
show_market_listener();

$(document).ready(function(){
  
    $('a.show_market').click();  
    
});

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Show page of products of market, input parameters : page
/// 2. Show page of products of market
////////////////////////////////////////////////////////////////////////////


function show_market_listener()
{
    
     $('a.show_market').click(function(e){
        e.preventDefault();      
        var url = $(this).attr('data-url');
        show_market(url);
        return false;
   });
    
}


function show_market(url)
{

    $.ajax({
            type: "GET",
            url: url,
            cache: false,
            beforeSend:centerProgressFirstBreak,
            success: function(data){
             $('.right').empty();
             $('.center').empty();
             $('.center').html(data);
             show_article_listener();
             product_hover_listener();
             centerProgressSecondBreak();
             
             next_previous_page_listenner();

            },
            complete:centerProgressThirdBreak
        });    
        return false;

  }
  
////////////////////////////////////////////////////////////////////////////
/// 
////////////////////////////////////////////////////////////////////////////

function my_market(data)
{
         
        console.log(data);
        
        var $myMarketDialog = $('.my_market_dialog');
          
        if($myMarketDialog.length !== 0)
        {
            var followTemplate= $.templates("#followItemTemplate");
            var html =  followTemplate.render(data);
            
            var $dataShopId= $('a[data-shop-id='+data.followed_id+']');
           
            if($dataShopId.length === 0) 
            {
                $myMarketDialog.prepend(html);
            }
            else
            {
                // add additional if else for seen messages already appended or not seen
                var current_number= parseInt($dataShopId.find('.m-result').text());
                console.log(current_number);
                var $di= $dataShopId.empty().html(html);
                var content= $di.contents();
                content.find('.m-result').text(current_number+1);
                $dataShopId.remove(); 
                $myMarketDialog.prepend(content);    
            }
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


function show_my_market_listener(){
    $(".show_my_market_trigger").click(showMyMarketDialogListener); 
}

var showMyMarketDialogListener = function(e)
{
        var $myMarketDialog = $('.my_market_dialog');
        e.preventDefault();
          
        if($myMarketDialog.length === 0) {
                    var url= $(this).attr('data-url');
                    $.when(bring_inbox(url,bringMyMarketDialogCallback )).done(function(){
                    }
                ); 
        }
        else
        { 
            if($myMarketDialog.is(":visible")) 
            { 
                $myMarketDialog.hide(); 
                
            }
            else { 
                 
                $myMarketDialog.show(); 
            }
        }
};


function bring_inbox(url, callback)
{
    $.ajax({
            type: "GET",
            url: url,
            cache: false,
            success: callback
            
        });    
        return false;  
}

function bringMyMarketDialogCallback(data)
{
     var $headerDialogs =  $('.header_dialogs');
     $headerDialogs.append(data);
     show_shop_listener();
     
}



$(document).ready(function (e)
{
show_my_market_listener();
});

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

