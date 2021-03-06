////////////////////////////////////////////////////////////////////////////
/// Configuration of JSRender so that {{ and }} don't conflict with twig ones
//  They are now replaced by <% and %>
////////////////////////////////////////////////////////////////////////////

$.views.settings.delimiters("<%", "%>");
$.views.converters("hmm", function(date) {
    return moment(date).format("HH:mm");
});
$.views.converters("mmmdo", function(date) {
    return moment(date).format("MMM-D");
});

////////////////////////////////////////////////////////////////////////////
/// On Dashboard DOM fully loaded
////////////////////////////////////////////////////////////////////////////


$(document).ready(function(){
    
    var $content= $('#content');
    $content.data('number-of-items-per-center',findNumberOfItemsPer('center',0));
    $content.data('number-of-items-per-left',findNumberOfItemsPer('left',6));

    var url_all_jawla = $('#content').attr('data-url-all-jawla');
    show_all_jawla(url_all_jawla);

    show_shop_listener();

    initialize_direction();
    direction_listener();
    hideWhenVisible();

    show_my_shop_listener();
    search_listener();

    new_article_listener();
    profile.show_profile_listener();
    
    return false;    
});




////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Show page of products of market, input parameters : page
/// 2. Show page of products of market
////////////////////////////////////////////////////////////////////////////

function show_all_jawla(url)
{
    var $content= $('#content');
    $content.moveContentToRight();

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
                    var product_url=$('.show_article_trigger:first').attr("data-show-url");
                    show_article(product_url,showArticleCallback);
                }
                else{
                    console.log('0');
                }

            },
            complete:function(){
                progress.endProgress($target,$targetProgress);
                show_all_new_posters();
            }
        });    
        return false;
}
  

function show_all_jawla_listener()
{
    $('a#show_all_jawla').click(function(e){
        e.preventDefault();      
        var url_all_jawla = $('#content').attr('data-url-all-jawla');
        show_all_jawla(url_all_jawla);
        return false;
    });
}

function show_all_new_posters(){

    var $target = $('#left');
    var $targetProgress= $('#left_progress');

    var all_new_posters_url = $('#content').attr('data-all-new-posters-url');
    var numberOfItemsPerLeft= $('#content').data('number-of-items-per-left');
    
    $.ajax({
        type: "POST",
        url: all_new_posters_url,
        cache: false,
        data: { items_per_page: numberOfItemsPerLeft},
        beforeSend: function(){
            }, 
        success: function(data){
            $target.css("visibility", "visible").empty().html(data);
            final_next_previous_page_listenner('left','network');
            show_shop_listener();
            },
        complete: function(){
            //var url_all_jawla = $('#content').attr('data-url-all-jawla');
            //show_all_jawla(url_all_jawla );
            }    
        });
} 
/////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
// Some old code 
/////////////////////////////////////////////////////////////////////

var frontend = (function()
{
    var config = {
        header_height : "80",
        footer_height: "20"
        
    };
    
    var calculateFlexibleHeigth = function(){
        
        console.log(document.documentElement.clientHeight - config.header_height- config.footer_height );
    };
    
    return {
        calculateFlexibleHeigth : calculateFlexibleHeigth
    };
 
})();

$(document).ready(frontend.calculateFlexibleHeigth);


var hideWhenVisible = function()
{

    $(document).mouseup(function (e)
    {
        var $categoriesDialogContainer = $('.categories_dialog')

        if (!$categoriesDialogContainer.is(e.target)
            && $categoriesDialogContainer.has(e.target).length !== 0
            && !$('.show_categories_trigger').is(e.target)
            ||
            !$categoriesDialogContainer.is(e.target)
            && !$('.show_categories_trigger').is(e.target))
        {

            //console.log($categoriesDialogContainer);
            $categoriesDialogContainer.hide();
        }
        // }

    });

}