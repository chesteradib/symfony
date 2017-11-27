 function buildMyThumbs() {
  
  // initializing left arrow and right arrow of thumbnail scroller
  
        var $leftArrow = $('.left_arrow');
        var $rightArrow = $('.right_arrow');

        $rightArrow.css('background-size', '3460% 117.647%');
        $rightArrow.css('background-position', '61.30% 0');     
        
        
        $leftArrow.css('background-size', '3460% 117.64%');
        $leftArrow.css('background-position', '100% 0');
  
  
  

  // end initializing left arrow and right arrow of thumbnail scroller
  
  // initializing edit article button
  
        var $editArticleTrigger = $('.edit_article_trigger');

        $editArticleTrigger.css('background-size', '3008.33% 162.5%');
        $editArticleTrigger.css('background-position', '25.5% 0');  
        /*var height= $editArticleTrigger.outerHeight();
        $editArticleTrigger.width(height*0.9);*/
        
        
  
  // end initializing edit article button
  
  
    // initializing edit article button
  
        var $deleteArticleTrigger = $('.post-footer .delete_article_trigger button');

        $deleteArticleTrigger.css('background-size', '1003.125% 100%');
        $deleteArticleTrigger.css('background-position', '100% 0');  
        /*var height= $editArticleTrigger.outerHeight();
        $editArticleTrigger.width(height*0.9);*/
        
        
  
  // end initializing edit article button
  
    // initializing edit article button
  
        var $openChatTrigger= $('.open_chat_trigger');
        $openChatTrigger.css('background-size', '2076% 146.34%');
        $openChatTrigger.css('background-position', '81.78% 0');  
        
  
  // end initializing edit article button
  
  // initializing post footer

    var $postFooter= $('.post-footer');
    var $postFooterLeft= $('.post-footer-left');
    var $postFooterRight= $('.post-footer-right');
    var postFooterWidth= $postFooter.outerWidth();
    var postFooterHeight= $postFooter.outerHeight();
   
    var qo= Math.floor(postFooterWidth/postFooterHeight);

    var re= postFooterWidth/postFooterHeight % 1;
  
    $postFooterLeft.width(qo/2*postFooterHeight);
    $postFooterRight.width(qo/2*postFooterHeight);
   
    $postFooter.css('margin-right', (re/2*postFooterHeight));
    $postFooter.css('margin-left', (re/2*postFooterHeight));


//$postFooterLeft.width(qo*);
   


    // end initializing post footer
    
    
    
    
    // initializing post bought
      var $boughtTriggerOff= $('.bought_trigger_off');
        $boughtTriggerOff.css('background-size', '1547.14% 116.07%');
      //  $boughtTriggerOff.css('background-position', '100% 0');  
    
    
    // end initializing post bought
  
   var scrollableHorizontalBoders=2;
   var $postScroller =$('.post-scroller');
   var postScrollerWidth= $postScroller.outerWidth();
   //console.log(postScrollerWidth);
   
   
   var postScrollerHeight= $postScroller.outerHeight();
   //console.log(postScrollerHeight);
   
   
   var q= Math.floor(postScrollerWidth/postScrollerHeight);
   //console.log('q:'+q);
   
   var r= postScrollerWidth/postScrollerHeight % 1;
   //console.log(r);
   
   var $wrapper = $('.left_arrow').next(); 
   var $toScroll = $wrapper.find('.post-images-toScroll');   
   
   
   $('.right_arrow').width(postScrollerHeight/2);
   $('.left_arrow').width(postScrollerHeight/2);
   
   $wrapper.width(((q-1)*postScrollerHeight));
   // +(q-1)*scrollableHorizontalBoders
   // 
   // 
   // 
   //console.log((q-1)*postScrollerHeight);
   $postScroller.css('margin-right', (r/2*postScrollerHeight));
   $postScroller.css('margin-left', (r/2*postScrollerHeight));
   //-(q-1)*scrollableHorizontalBoders
   
   
   
   
   $postScroller.css('width', q*postScrollerHeight);
   
  
    var i=0;
    var totalWidth = 0;
    $toScroll.find('.scrollable').each(function(){
        $(this).width(postScrollerHeight);
        $(this).css('text-align', 'center');
        totalWidth += $(this).outerWidth(true);
        i++;

        
  });
 
  $toScroll.width(i*postScrollerHeight);
  //console.log(i*postScrollerHeight); 
  //console.log('i*postScrollerHeight:'+ (i*postScrollerHeight) + 50); 
  
  $('div.left_arrow').css('visibility', 'hidden');
 
  if(totalWidth < $wrapper.outerWidth(true))
  {
  $('div.right_arrow').css('visibility', 'hidden'); 
  }
  
  var index=0;



         $('div.right_arrow').on({ 
            mouseenter: function(e){
                $(this).css('background-position', '58.33% 0');     
            },
            mouseleave:function(e){
                $(this).css('background-position', '61.30% 0');     
          },
            click:function(e){
                index++;  
                $('div.left_arrow').css('visibility', 'visible');
                $toScroll.animate({left:-postScrollerHeight* index}, {duration: 300, easing: "swing"});
                if(index===i-q)  $('div.right_arrow').css('visibility', 'hidden');
                
                $(this).css('background-position', '55.357% 0');
                
          }
        });
        
        
        $('div.left_arrow').on({ 
            mouseenter: function(e){
                $(this).css('background-position', '97.02% 0');     
            },
            mouseleave:function(e){
                $(this).css('background-position', '100% 0');     
          },
            click:function(e){
                index--;
                $('div.right_arrow').css('visibility', 'visible');
                $toScroll.animate({left: -postScrollerHeight* index}, {duration: 300, easing: "swing"});
                if(index===0)  $('div.left_arrow').css('visibility', 'hidden');
                
                $(this).css('background-position', '94.04% 0');
                
          }
        });

        // display the image horizontally or vertically for the first image in the set of thumbs 
        var zero_path=$toScroll.find('img').attr("src");
        display_image(zero_path,0);
        // end display the image horizontally or vertically for the first image in the set of thumbs


        $('.edit_article_trigger').on({ 
            mouseenter: function(e){
                $editArticleTrigger.css('background-position', '22.06% 0');     
            },
            mouseleave:function(e){
                $editArticleTrigger.css('background-position', '25.5% 0');     
          },
            click:function(e){
                $editArticleTrigger.css('background-position', '18.62% 0');
                
          }
        });



         $deleteArticleTrigger.on({ 
            mouseenter: function(e){
               $(this).css('background-position', '88.927% 0');     
            },
            mouseleave:function(e){
                $(this).css('background-position', '100% 0');     
          },
            click:function(e){
               $(this).css('background-position', '77.854% 0');
                
          }
        });

        $('.open_chat_trigger').on({ 
            mouseenter: function(e){
                $(this).css('background-position', '76.72% 0');     
            },
            mouseleave:function(e){
                $(this).css('background-position', '81.78% 0');     
          },
            click:function(e){
                $(this).css('background-position', '71.659% 0');
                
          }
        });
        
        $('.bought_trigger_off').on({ 
            mouseenter: function(e){
            
                var checked_bool = $(this).hasClass('bought_trigger_on');
                if(!checked_bool) {
                    $(this).css('background-position', '93.089% 0');  
                }  
                   
            },
            mouseleave:function(e){
                var checked_bool = $(this).hasClass('bought_trigger_on');
                if(!checked_bool) {
                    $(this).css('background-position', '100% 0'); 
                }  
                    
          },
            click:function(e){
        
                var checked_bool = $(this).hasClass('bought_trigger_on');
                if(!checked_bool) {
                    $(this).css('background-position', '100% 0');
                }
                else
                {
                    $(this).css('background-position', '86.179% 0');
                }
                
                
          }
        });




       return false;
  
}

 
 


function display_image_on_thumb_click_listener()
{
    
    $(".scrollable").on("click", function(e){
        e.preventDefault();
        var new_path=$(this).find('img').attr("src");
        
        var number=$(this).attr("data-number");
       
        display_image(new_path,number);
       
        
    });
}

function display_image(p,n)

{
        var img = new Image();
        img.onload = function() {
            
        var main_image_container_height= $('.post-main-image').height();
        var main_image_container_width= $('.post-main-image').width();

        if(this.width>this.height) 
        {
                $('.post-main-image').prepend($('<span class="helper"></span>'));
                $('.post-main-image').css('text-align','center');
                $('.post-main-image img').css('width',main_image_container_width*0.94);
                $('.post-main-image img').css('vertical-align','middle');
                $('.post-main-image img').css('max-height',main_image_container_width);
                $('.post-main-image img').css('max-width',main_image_container_width);
                $('.post-main-image img').css('height','');
         }
         else
         {
                $('.post-main-image .helper').remove();     
                $('.post-main-image').css('text-align','center');
                $('.post-main-image img').css('max-height',main_image_container_height);
                $('.post-main-image img').css('max-width',main_image_container_width);
                $('.post-main-image img').css('height',main_image_container_height);
                $('.post-main-image img').css('vertical-align','');
                $('.post-main-image img').css('width','');

          }
        };
        
    img.src=p;
    $('.post-main-image img').attr('src',p);
    $('.post-main-image').attr('data-number',n); 
    
}





////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Show shop on post show fragment
/// 2. Show shop of shop_id
////////////////////////////////////////////////////////////////////////////


function show_shop_listener()
{
    
     $('a.show_shop').click(showShopClickCallback);
     $('.network_dialog').on('click', 'a.show_shop',showShopClickCallback);
     $('.my_market_dialog').on('click', 'a.show_shop',showShopClickCallback);
    
}

var showShopClickCallback=  function(e)
{
    
    e.preventDefault();
        var $this= $(this);
        var shop_id=$this.data('shop-id');
        var base_url = $this.attr('data-url');
        
        var show_shop_url= base_url + shop_id;
        var follow_seen_url=  $this.attr('data-follow-seen-url');
        var last_date_url=  $this.attr('data-last-date-url');
        console.log(last_date_url);
        var has=false;
        
        if ($this.hasClass('trigger')) 
        { 
            
            has =true;
            
            }
        show_shop(show_shop_url,has,follow_seen_url,shop_id,last_date_url);
        
        return false;
    
    
};


function show_shop(url,has,follow_seen_url,shop_id,last_date_url)
{
    console.log('here');
    $.ajax({
            type: "GET",
            url: url,
            cache: false,
            beforeSend:centerProgressFirstBreak,
            success: function(data){
             //$('.right').empty();
             $('.center').empty();
             $('.center').html(data);
             show_article_listener();
             product_hover_listener();
             centerProgressSecondBreak();
             
             next_previous_page_listenner();
             follow_shop_listener();
             
             if(has) 
             {
                    decrement_notification_count_by('my_followers', 1);
                    follow_seen_management(follow_seen_url,shop_id,last_date_url);
             }
             else
             {update_last_date(shop_id,last_date_url);}

            },
            complete:centerProgressThirdBreak
        });    
        return false;

  }
  
/********/

var update_last_date= function(shop_id,last_date_url)
{
    console.log('last_date'+shop_id);
    $.ajax({
            type: "POST",
            url: last_date_url,
            data:{shop_id:shop_id},
            cache: false,
        });    
    return false;
    
};