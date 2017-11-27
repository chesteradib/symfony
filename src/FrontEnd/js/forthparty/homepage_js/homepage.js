
////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Show page of products of market, input parameters : page
/// 2. Show page of products of market
////////////////////////////////////////////////////////////////////////////


function show_all_jawla_listener()
{
    
    $('a#show_all_jawla').click(function(e){
        e.preventDefault();      
        var url_all_jawla = $('#content').attr('data-url-all-jawla');
        show_all_jawla(url_all_jawla);
        return false;
    });
    
}


function show_all_jawla(url)
{
    var $content= $('#content');
    //$content.moveContentToRight();
    
    
    var $target= $('#center');
    var $targetProgress = $("#center_progress");
    var numberOfItemsPerCenter= $('#content').data('number-of-items-per-center');
    
    $.ajax({
            type: "POST",
            url: url,
            data:{ articles_per_page: numberOfItemsPerCenter},
            cache: false,
            beforeSend:function(){
                progress.firstProgress($target,$targetProgress,65);
            },
            success: function(data){
                $target.empty().html(data.html);
                show_article_listener();
                product_hover_listener();
                final_next_previous_page_listenner('center');
                
                if(data.status===1)
                {
                    $('.show_article_trigger:first').children().eq(0).addClass('active');
                    //var product_url=$('.show_article_trigger:first').attr("data-show-url");
                    //show_article(product_url,showArticleCallback);
                    console.log($('.show_article_trigger:first'));
                    $('.show_article_trigger:first').click();
                }
                else{
                    console.log('0');
                }
                progress.secondProgress($targetProgress,85);
               
            },
            complete:function(){
                progress.thirdProgress($target,$targetProgress);
                show_all_new_posters();

            }
        });    
        return false;

  }
        
        
  function direction_listener(){
      
      $('#right_direction').click(function(){
          console.log('right_dircetion ');
          if($('#content').hasClass('centry'))
          {
            $('#content').moveContentToRight();
            $('#left_direction').css('visibility','visible');
            $('#right_direction').css('visibility','hidden');
          }
          else
          {
            $('#content').moveContentToCenter();
            $('#left_direction').css('visibility','visible');
            $('#right_direction').css('visibility','visible');
          }
          
          
          
      });
      $('#left_direction').click(function(){
          console.log('left_dircetion ');
          if($('#content').hasClass('centry'))
          {
                $('#content').moveContentToLeft();
                $('#right_direction').css('visibility','visible');

                $('#left_direction').css('visibility','hidden');
           }
           else
           {
               $('#content').moveContentToCenter();
            $('#left_direction').css('visibility','visible');
            $('#right_direction').css('visibility','visible');
               
           }
      
          
      });
  }
  
  
////////////////////////////////////////////////////////////////////////////
/// follow_unfollow_in_homepage
////////////////////////////////////////////////////////////////////////////


var timeoutId2; 
var follow_unfollow_in_homepage_listener= function()
{
    
    function hideFollowUnfollowError()
    {
        $('#follow-unfollow-error').fadeOut(800, function(){  
        });
    }

    $('.trigger_follow').on({ 
        click:function(e){
            e.preventDefault();
            var $followUnfollowError= $('#follow-unfollow-error');
            
            if($followUnfollowError.length === 0)
            {
                var followUnfollowErrorTemplate= $.templates("#followUnfollowErrorTemplate");
                var html = followUnfollowErrorTemplate.render();
                $('#left').append(html);

                validation_errors_control_listener();
                //login_signup_listener();
                timeoutId2 = setTimeout(hideFollowUnfollowError,3000);
            }
            else
            {   
                if($followUnfollowError.is(":visible")) 
                {        
                    $followUnfollowError.hide().fadeIn(100, function(){
                    clearTimeout(timeoutId2);
                    timeoutId2= setTimeout(hideFollowUnfollowError,2000);
                    });        
                }
                else 
                {
                    $followUnfollowError.fadeIn(100, function(){
                        clearTimeout(timeoutId2);
                        timeoutId2= setTimeout(hideFollowUnfollowError,2000);
                    });     
                }     
            }
        }
    });
    return false;
    
};
////////////////////////////////////////////////////////////////////////////
/// open_chat_in_homepage
////////////////////////////////////////////////////////////////////////////


var timeoutId;

var open_chat_in_homepage_listener= function()
{
    function hideChatErrorTemplate()
    {
        $('#open-chat-error').fadeOut(800, function(){  
        });
    }

    $('.open_chat_trigger').on({ 
       /* mouseenter: function(e){
            $(this).css('background-position', '76.72% 0');     
        },
        mouseleave:function(e){
            $(this).css('background-position', '81.78% 0');     
        },*/
        click:function(e){
            //$(this).css('background-position', '71.659% 0');
            //console.log($(this).offset());
            var $openChatTrigger= $('#open-chat-error');
                            
            if($openChatTrigger.length === 0)
            {
                var openChatErrorTemplate= $.templates("#openChatErrorTemplate");
                var html = openChatErrorTemplate.render();
                $('#post-chat').append(html);
                validation_errors_control_listener();
                

                
                timeoutId = setTimeout(hideChatErrorTemplate,3000);
            }
            else
            {


                
                if($openChatTrigger.is(":visible")) 
                {        
                    $openChatTrigger.hide().fadeIn(100, function(){
                    clearTimeout(timeoutId);
                    timeoutId= setTimeout(hideChatErrorTemplate,2000);
                    });        
                }
                else 
                {
                    $openChatTrigger.fadeIn(100, function(){
                        clearTimeout(timeoutId);
                        timeoutId= setTimeout(hideChatErrorTemplate,2000);
                    });     
                }     
            }
        }
    });
    return false;
    
};



