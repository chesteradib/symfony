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
        cache: true,
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
function right_fully_loaded(data)
{
    $('#right').empty().html(data.html);
    return;             
}

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Edit product, input parameters : product id
/// 2. Show product edit page
////////////////////////////////////////////////////////////////////////////


function show_edit_article_listener()
{
    $('#edit_article_trigger').click(function(e){
        e.preventDefault();
        console.log($(this));
        var url=$(this).attr("data-url");
        show_edit_article(url);
        return false;
   });    
}
function show_edit_article(url)
{
    var $target=$('#right');
    var $targetProgress = $("#progress_right");
    
    $.ajax({
        type: "GET",
        url: url,
        cache: false,
        beforeSend: function(){
            progress.startProgress($target,$targetProgress);
        },
        success: function(data){
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
            },
        complete:function(){
            progress.endProgress($target,$targetProgress);
        }
    }); 

}
////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Update Button in Edit-product page,
/// 2. Update product,
////////////////////////////////////////////////////////////////////////////


function update_article_listener()
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

function update_article(data,url){
    
    var $target= $('#right');
    var $targetProgress = $("#progress_right");
    
    $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            processData: false,
            contentType:false,
            beforeSend: function(){
                progress.startProgress($target,$targetProgress);
            },
            success: function(data){
                if(data.status)
                { 
                   $.when(right_fully_loaded(data)).done(function(){  
                        if(data.target==="show")
                        {
                            show_edit_article_listener();
                            delete_listener();
                            bought_listener();
                            articleImagesScroller();
                            display_image_on_thumb_click_listener();
                            show_shop_listener();
                            retweet_listener();
                        }
                        if(data.target==="form")
                        {
                            update_article_listener();
                            add_new_inputForImageUpload_listener();
                            imageUpload_listener();
                            imageDelete_listener();
                            set_as_main_listener();
                            validation_errors_control_listener();
                       }
                    });
                }
                else
                {
                    console.log(data.message);
                }

            },
            complete:function(){
                progress.endProgress($target,$targetProgress);
            }      
        });    
        return false;
}



////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Add new article admin page
/// 2. Show add new form 
////////////////////////////////////////////////////////////////////////////

function new_article_listener()   
{
     $('a.new_article_trigger').click(function(e){ 
            e.preventDefault();          
            var new_article_url=$('#content').attr("data-new-article-url");
            
            new_article(new_article_url);  
       
            return false;
   });
}  


function new_article(url)   {
    // I need to call the show_my_shop after the ajax call is finished to avoid the Synchronous on main thread error
    //show_my_shop();

    //$('a.show_market').click();  
    // to be replaced by opacity 0.5 to center div // better approch
    
    var $content= $('#content');
    $content.moveContentToRight();


    var $target= $('#right');
    var $targetProgress = $("#progress_right");

    $.ajax({
        type: "GET",
        url: url,
        cache: false,
        beforeSend: function(){
            progress.startProgress($target,$targetProgress);
        },
        success: function(data){
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
            },
        complete:function(){
            progress.endProgress($target,$targetProgress);
        }   
    }); 
    return false;
}  


function cancel_in_new_article_listener()
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
            var product_url=$showArticleTrigger.first().attr("data-show-url");
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

function create_article_listener()
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

function create_article(data,url){
    
    var $target= $('#right');
    var $targetProgress = $("#progress_right");
    
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        cache: false,
        processData: false,
        contentType:false,
        beforeSend: function(){
            progress.startProgress($target,$targetProgress);
        }, 
        success: function(data){
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
                    }

                });
            }
            else
            {
                console.log(data.message);
            }
            },
        complete:function(){
            progress.endProgress($target,$targetProgress);
        }
     });    
}

 
////////////////////////////////////////////////////////////////////////////
/// Listen to delete button  ( delete button is represented in 'new' by Cancel, in 'edit new valid'
//  by Cancel, and in 'edit' by Delete.
/// 
////////////////////////////////////////////////////////////////////////////
function delete_listener()
{
    $("#delete_article_trigger").submit(function(){ 
        var $this= $(this);
        var url= $this.attr('action');
        var data= $this.serialize();
        delete_article(data,url);

        return false;       
  
    }); 
}

function delete_article(data,url){
    
    var $target= $('#right');
    var $targetProgress = $("#progress_right");
    
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        cache: false,
        beforeSend: function(){
            progress.startProgress($target,$targetProgress);
        }, 
        success: function(data){
            if(data.status){
                $('.show_my_shop').click();
            }
            else{
                //$target.empty().append(data);
            }
            },
        complete:function(){
            progress.endProgress($target,$targetProgress);
        }                     
    });    
}

////////////////////////////////////////////////////////////////////////////
/// Listen to cancel button  in add-new-product pages (new and edit_for_valid),
/// 
////////////////////////////////////////////////////////////////////////////


function cancel_button_in_edit_page_listener()
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

var retweet = function(url)
{
    $.ajax({
        type: "POST",
        url: url,
        cache: false,
        success: function(data){
            if(data.status) {
                alert(data.message);
            }
            else{
                alert(data.message);
            }
        }
    });    
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