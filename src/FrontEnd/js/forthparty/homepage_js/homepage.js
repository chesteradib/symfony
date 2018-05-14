
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
    var $targetProgress = $("#progress_center");
    var numberOfItemsPerCenter= $('#content').data('number-of-items-per-center');
    
    $.ajax({
            type: "POST",
            url: url,
            data:{ articles_per_page: numberOfItemsPerCenter},
            cache: false,
            beforeSend:function(){
                progress.startProgress($target,$targetProgress);
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
                    //console.log($('.show_article_trigger:first'));
                    $('.show_article_trigger:first').click();
                }
                else{
                    //console.log('0');
                }
               
            },
            complete:function(){
                progress.endProgress($target,$targetProgress);
                show_all_new_posters();

            }
        });    
        return false;

  }
