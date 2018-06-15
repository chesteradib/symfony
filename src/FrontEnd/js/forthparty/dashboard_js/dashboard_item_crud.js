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
    Utils.ajax_call("GET", url, {} , true, startPogressRight ,showArticleCallback, endPogressRight);
}

var showArticleCallback = function(data){

    $.when(right_fully_loaded(data)).done(function(){
        show_edit_article_listener();
        retweet_listener();
        delete_listener();
        bought_listener();
        articleImagesScroller();
        display_image_on_thumb_click_listener();
        show_shop_listener();
    });  
}

var right_fully_loaded = function(data)
{
    $('#right').empty().html(data.html);
    return;             
}




////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Edit product, input parameters : product id
/// 2. Show product edit page
////////////////////////////////////////////////////////////////////////////


var show_edit_article_listener = function()
{
    $('#edit_article_trigger').click(function(e){
        e.preventDefault();
        console.log($(this));
        var url=$(this).attr("data-url");
        show_edit_article(url, showEditArticleCallback);
        return false;
   });    
}
var show_edit_article = function (url, callback)
{
    Utils.ajax_call("GET", url, {} , true, startPogressRight ,callback, endPogressRight);
}


var showEditArticleCallback = function(data){

    if(data.status)
    {
        $.when(right_fully_loaded(data)).done(function(){
            add_new_inputForImageUpload_listener();
            imageUpload_listener();
            imageDelete_listener();
            set_as_main_listener();
            validation_errors_control_listener();
            update_article_listener();
            cancel_button_in_edit_page_listener();
            delete_listener();
            bought_listener();
        });
    }
    else
    {
        console.log(data.message);
    }
}
////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Update Button in Edit-product page,
/// 2. Update product,
////////////////////////////////////////////////////////////////////////////


var update_article_listener = function ()
{
    $("#update_article_trigger").submit(function(){
        
        var main_image_id= $('#uploaded_images .has-image').last().find('.one_photo').attr('id');
        
        if ( $('input[type=hidden][name=main-image]').val()==='') 
            $('input[type=hidden][name=main-image]').val(main_image_id); 
         
        var formData = new FormData($(this)[0]);

        var url= $(this).attr('action');
        update_article(formData,url);
        return false;
    });
      
}

var update_article = function(data,url){

    Utils.ajax_call("POST", url, data , false, startPogressRight ,updateArticleCallback, endPogressRight, false, false);
    return false;
}

var updateArticleCallback = function(data) {
    if (data.status) {
        $.when(right_fully_loaded(data)).done(function () {
            if (data.target === "show") {
                show_edit_article_listener();
                delete_listener();
                bought_listener();
                articleImagesScroller();
                display_image_on_thumb_click_listener();
                show_shop_listener();
                retweet_listener();
            }
            if (data.target === "form") {
                update_article_listener();
                add_new_inputForImageUpload_listener();
                imageUpload_listener();
                imageDelete_listener();
                set_as_main_listener();
                validation_errors_control_listener();
            }
        });
    }
    else {
        console.log(data.message);
    }
    return false;
};

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Add new article admin page
/// 2. Show add new form 
////////////////////////////////////////////////////////////////////////////

var new_article_listener = function()
{
     $('a.new_article_trigger').click(function(e){ 
            e.preventDefault();          
            var new_article_url=$('#content').attr("data-new-article-url");
            
            new_article(new_article_url);  
       
            return false;
   });
}

var newArticleCallback = function(data) {
    if(data.status){
        $.when(right_fully_loaded(data)).done(function(){
            add_new_inputForImageUpload_listener();
            imageUpload_listener();
            imageDelete_listener();
            validation_errors_control_listener();
            set_as_main_listener();
        });

        create_article_listener();
        cancel_in_new_article_listener();
    }
    else
    {
        console.log(data.message);
    }
    return false;
};

var new_article = function(url) {
    // I need to call the show_my_shop after the ajax call is finished to avoid the Synchronous on main thread error
    //show_my_shop();

    //$('a.show_market').click();  
    // to be replaced by opacity 0.5 to center div // better approch
    
    var $content= $('#content');
    $content.moveContentToRight();

    Utils.ajax_call("GET", url, {}, false, startPogressRight ,newArticleCallback, endPogressRight);
    return false;
}  


var cancel_in_new_article_listener = function()
{
    
    $('#cancel_item_button').click(function(e){
        
        e.preventDefault();
        var $showArticleTrigger= $('.show_article_trigger');
        if($showArticleTrigger.length !==0)
        {
            $showArticleTrigger.each(function(){
                $(this).children().eq(0).removeClass("active");
            });

            $showArticleTrigger.first().children().eq(0).addClass('active');
            var product_url = $showArticleTrigger.first().attr("data-show-url");
            show_article(product_url,showArticleCallback);
  
        }
        else
        {
            $('#right').empty();
        }
        return false;
    });
}

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to create Button in add-new-product page,
/// 2. Create product product,
////////////////////////////////////////////////////////////////////////////

var create_article_listener = function()
{   
       
    $("#create_article_trigger").submit(function(){ 
         
        var main_image_id= $('.uploaded_images .has-image').last().find('.one_photo').attr('id');
        
        if ( $('input[type=hidden][name=main-image]').val()==='') 
            $('input[type=hidden][name=main-image]').val(main_image_id); 
        
         var formData = new FormData($(this)[0]);
         var url= $(this).attr('action');
         
         
         // if value of hidden image-main is empty, fill it before sending it
         
         
         create_article(formData,url);      
        
         return false;       
        });              
}

var create_article = function(data,url){

    Utils.ajax_call("POST", url, data , false, startPogressRight ,createArticleCallback, endPogressRight, false, false);
}

var createArticleCallback = function(data) {

    if(data.status){
        $.when(right_fully_loaded(data)).done(function(){
            if(data.target==="show")
            {
                /* in case of success */
                show_edit_article_listener();
                delete_listener();
                bought_listener();
                articleImagesScroller();
                display_image_on_thumb_click_listener();
                show_shop_listener();
                retweet_listener();
            }
            else if (data.target==="form")
            {
                add_new_inputForImageUpload_listener();
                imageUpload_listener();
                imageDelete_listener();
                set_as_main_listener();
                validation_errors_control_listener();
                create_article_listener();
                delete_listener();
                cancel_in_new_article_listener();
            }

        });
    }
    else
    {
        console.log(data.message);
    }
    return false;
};
////////////////////////////////////////////////////////////////////////////
/// Listen to delete button  ( delete button is represented in 'new' by Cancel, in 'edit new valid'
//  by Cancel, and in 'edit' by Delete.
/// 
////////////////////////////////////////////////////////////////////////////
var delete_listener = function()
{
    $("#delete_article_trigger").submit(function(){ 
        var $this= $(this);
        var url= $this.attr('action');
        var data= $this.serialize();
        delete_article(data,url);

        return false;       
  
    }); 
}

var delete_article = function(data,url){

    Utils.ajax_call("POST", url, data , false, startPogressRight ,deleteArticleCallback, endPogressRight, false, false);
}


var deleteArticleCallback = function(data) {

    if(data.status){
        $('.show_my_shop').click();
    }
    else{
        //$target.empty().append(data);
    }
    return false;
};
////////////////////////////////////////////////////////////////////////////
/// Listen to cancel button  in add-new-product pages (new and edit_for_valid),
/// 
////////////////////////////////////////////////////////////////////////////


var cancel_button_in_edit_page_listener = function()
{
     $('#cancel_item_button').click(function(e){ 
            e.preventDefault(); 
            $('.show_article_trigger').each(function(){
            $(this).children().eq(0).removeClass("active");
            });

            $('.show_article_trigger:first').children().eq(0).addClass('active');
            var product_url=$('.show_article_trigger:first').attr("data-show-url");
            show_article(product_url,showArticleCallback);
            //$(this).data('id');            
            return false;
   });
}


////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Bought click on Show page and Edit Page
//  ( Validating if current user is equal to entity user id done server side)
/// 23. Update Bought value 
////////////////////////////////////////////////////////////////////////////

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
/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Retweet click on Show
//  ( Validating if current user is equal to entity user id done server side)
/// 2. Retweet
////////////////////////////////////////////////////////////////////////////

var retweet_listener = function()
{
    $('a#retweet_article_trigger').click(function(e){
        e.preventDefault();   
        var $this= $(this);
        var url = $this.attr('data-url');
        retweet(url);  
        return false;
    });
}



var retweet= function(url)
{
    Utils.ajax_call("POST", url, {}, false, function(){} ,retweetCallback, function(){});
    return false;
}


var retweetCallback = function(data) {
    if(data.status) {
        alert(data.message);
    }
    else{
        alert(data.message);
    }
}
/////////////////////////////////////////////////////////////////////////

function validation_errors_control_listener()
{

    $('.error-message-close').click(function(){  
        $(this).parents().eq(1).hide();
    });
}

function show_error_number_of_images_exceeded()
{
    
    // show the error
    
    //set timeout
    setTimeout(function(){ 
    
    
    }, 3000);
    
}