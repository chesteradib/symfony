

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Show product, input parameters : product id
/// 2. Show product
////////////////////////////////////////////////////////////////////////////

function show_article_listener()
{
    $('a.show_article_trigger').click(function(e){
        e.preventDefault();
        var product_url=$(this).attr("data-show-url");
        $(this).manageActiveItem();
        var $content= $('#content');
        $content.moveContentToRight();
        show_article(product_url,showArticleCallback);
        return false;
    });
}

function show_article(url,callback)
{
    var $target= $('#right');
    var $targetProgress = $("#progress_right");

    $.ajax({
        type: "GET",
        url: url,
        cache: false,
        beforeSend: function(){
            progress.startProgress($target,$targetProgress);
        },
        success: callback,
        complete:function(){
            progress.endProgress($target,$targetProgress);
        }
    });
}


function showArticleCallback(data){

    var $targetProgress = $("#right_progress");

    $.when(right_fully_loaded(data)).done(function(){
        articleImagesScroller();
        display_image_on_thumb_click_listener();
        open_chat_in_homepage_listener();
        bought_listener();
    });
}



////////////////////////////////////////////////////////////////////////////////
function right_fully_loaded(data)
{
    $('#right').empty().html(data.html);
    return;
}


function validation_errors_control_listener()
{

    $('.error-message-close').click(function(){
        $(this).parents().eq(1).fadeOut(400);
    });
    /*
     $('.login_trigger, .signup_trigger').on('click', function(event) {

     console.log($(event.target).attr('class'));
     if($(event.target).hasClass('login_trigger')) {
     console.log('login');
     $('#login').show();
     $('#register').hide();
     }
     if($(event.target).hasClass('signup_trigger')) {
     console.log('signup');
     $('#register').show();
     $('#login').hide();
     }
     });*/
}

validation_errors_control_listener();

var bought_listener = function()
{
    $('a#bought-trigger').click(function(e){
        e.preventDefault();
        var $this= $(this);

        var url = $this.attr('data-url');

        var checked_bool = $('.bought_article_symbol').hasClass('bought_trigger_off');

        var checked = (checked_bool ? 0 : 1);

        update_bought_value(url,checked);

        return false;
    });

}

var update_bought_value = function(url,checked)
{
    var $boughtSymbol= $('.bought_article_symbol');
    var $boughtWord=$('.bought_article_text');

    $.ajax({
        type: "POST",
        url: url,
        cache: false,
        data:{checked:checked},
        success: function(data){
            if(data.status) {
                $boughtSymbol.toggleClass("bought_trigger_off");
                if(checked)
                {
                    $boughtWord.empty().append('Disponible');
                }
                else
                {
                    $boughtWord.empty().append('Vendu');
                }
            }
            else{
                alert(data.message);
            }
        }
    });
    return false;
}