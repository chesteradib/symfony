

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Show product, input parameters : product id
/// 2. Show product
////////////////////////////////////////////////////////////////////////////

var show_article_listener = function()
{
    $('a.show_article_trigger').click(function(e){
        e.preventDefault();
        var product_url=$(this).attr("data-show-url");
        $(this).manageActiveItem();
        var $content= $('#content');
        $content.moveContentToRight();
        show_article(product_url);
        return false;
    });
}

var show_article = function(url)
{
    //abortPreviousRequests();
/*
    $.ajax({
        type: "GET",
        url: url,
        cache: true,
        beforeSend:function(jqXHR){
            //promises.push(jqXHR);
            startPogressRight();
        },
        success: showArticleCallback,
        complete: endPogressRight
    });*/
    Utils.ajax_call("GET", url, {} , true, startPogressRight ,showArticleCallback, endPogressRight);
}


var showArticleCallback = function (data){

    $.when(right_fully_loaded(data)).done(function(){
        articleImagesScroller();
        display_image_on_thumb_click_listener();
        bought_listener();
    });
}


var right_fully_loaded = function(data)
{
    $('#right').empty().html(data.html);
    return;
}


var validation_errors_control_listener = function()
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

    Utils.ajax_call("POST", url, { checked : checked } , false, function(){} ,updateBoughtValueCallback, function(){});

    return false;
}


var updateBoughtValueCallback = function(data) {
    var $boughtSymbol= $('.bought_article_symbol');
    var $boughtWord=$('.bought_article_text');
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