//////////////////////////////////////////////////////////////////////////////
/// Call to listener of show page of products of shop
////////////////////////////////////////////////////////////////////////////
//show_page_of_products_listener();

show_my_shop_listener();

////////////////////////////////////////////////////////////////////////////
/// Call to listener of add new product
////////////////////////////////////////////////////////////////////////////
new_article_listener();

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to SHOW MY SHOP click, input parameters : page/ shop id
/// 2. Show my_shop
////////////////////////////////////////////////////////////////////////////


function show_my_shop_listener()
{
    $('a.show_my_shop').click(function(e){
        e.preventDefault();      
        var url = $(this).attr('data-url');
        show_my_shop(url);
        return false;
   });   
}


function show_my_shop(url)
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
/// 1. Show page of products after click on pagination
////////////////////////////////////////////////////////////////////////////



function show_page_of_products(url)
{

    $.ajax({
            type: "GET",
            url: url,
            cache: false,
            beforeSend:IntraCenterProgressFirstBreak,
            success: function(data){
                $('.page-content').empty();
                //$('.center').empty();
                $('.page-content').html(data);
                show_article_listener();
                product_hover_listener();
                IntraCenterProgressSecondBreak();

            },
            complete:IntraCenterProgressThirdBreak
        });    
        return false;

  }

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Show product, input parameters : product id
/// 2. Show product
////////////////////////////////////////////////////////////////////////////

function show_article_listener()
{
    $('a.show_article_trigger').click(function(e){
        e.preventDefault();            
        var product_url=$(this).attr("data-show-url");
        show_article(product_url,showArticleCallback);
        return false;
   });
}  

function show_article(url,callback)
{
    
    
    $.ajax({
         type: "GET",
         url: url,
         cache: false,
         /*
         xhr: function(){
            var xhr = $.ajaxSettings.xhr();
            xhr.onprogress = function(evt){ console.log('progress', evt.total); } ;

            return xhr ;
            },*/
         beforeSend: rightProgressFirstBreak,
         success: callback,
         complete:rightProgressThirdBreak
          });    

}


function showArticleCallback(data)
{
    $.when(app_f(data)).done(function(){              
                     show_edit_article_listener();
                     
                     delete_listener();
                     bought_listener();
                     open_chat_listener();
                     buildMyThumbs();
                     display_image_on_thumb_click_listener();
                     $(".post-content").mCustomScrollbar({
                                    theme:'dark',
                                    scrollButtons:{enable:true}
                                    });
                     rightProgressSecondBreak();
                     
                     show_shop_listener();
                  
              });  
}

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Edit product, input parameters : product id
/// 2. Show product edit page
////////////////////////////////////////////////////////////////////////////


function show_edit_article_listener()
{
    
     $('.edit_article_trigger').click(function(e){
       
        e.preventDefault();      
    
        var url=$(this).attr("data-edit-article-url");

        show_edit_article(url);
   
        return false;
   });    
}
function show_edit_article(url)
{
    $.ajax({
         type: "GET",
         url: url,
         cache: false,
         beforeSend: rightProgressFirstBreak,
         success: function(data){
              
             $.when(app_f(data)).done(function(){              
                  add_tag_listener();
                  delete_image_listener();
                  set_as_main_listener();
                  $('.right').initializeAddImageFunction();
                  var width= $('div.add_image').outerWidth();
                  
                 $('div.image_cont').each(function(){
                        $(this).initializeImageDiv(width);
                        $(this).find('image_div').initializeImageControlsFunction();
                        $(this).find('image_div').imageHoverFunction();
 
                    });
                  
              });
              
              update_article_listener();
              cancel_button_in_edit_page_listener();
              delete_listener();
              bought_listener();
              rightProgressSecondBreak();
              
             },
          complete:rightProgressThirdBreak
          }); 

}
////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Update Button in Edit-product page,
/// 2. Update product,
////////////////////////////////////////////////////////////////////////////


function update_article_listener()
{
        $("#update_article_trigger").submit(function(){ 
        
         var data= $(this).serialize();

         var url= $(this).attr('action');
         update_article(data,url);      
         return false;
});
      
}

function update_article(data,url)
{
    $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            beforeSend: rightProgressFirstBreak,
            success: function(data){
                
               $.when(app_f(data)).done(function(){  
               delete_image_listener();
               add_tag_listener();
               set_as_main_listener();
                  
              });
              
               
               /* in case of success */
               show_edit_article_listener();
               delete_listener();
               
               /* in case of failure */ 
               update_article_listener();

               
               // TODO: reload ONLY updated article if photo changed(e.g)= reload my_article
               //vote_managing();
               //manage_post_listener();
               rightProgressSecondBreak();
                       
            },
            complete:rightProgressThirdBreak         
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
            var url=$(this).attr("data-new-article-url");
            
            new_article(url);  
       
            return false;
   });
}  


function new_article(url)   
{
// I need to call the show_my_shop after the ajax call is finished to avoid the Synchronous on main thread error
//show_my_shop();

//$('a.show_market').click();  
// to be replaced by opacity 0.5 to center div // better approch

$.ajax({
         type: "GET",
         url: url,
         cache: false,
         beforeSend: rightProgressFirstBreak,
         success: function(data){

              $.when(app_f(data)).done(function(){  
                     /*
                      * Old one instead of add_new_inputForImageUpload_listener()
                     add_tag_listener();
                        */
                    add_new_inputForImageUpload_listener();
                    imageUpload_listener();
                    imageDelete_listener();
                    // 
                     
                     //delete_image_listener();
                     set_as_main_listener();
                     $('.right').initializeAddImageFunction();
                     
                      
              });
              
              create_article_listener();
              delete_listener();
              
              rightProgressSecondBreak();
              
             },
             complete:rightProgressThirdBreak
          }); 
     return false;

}  

/*
function rightProgressHandlingFunction(e){
    
     console.log("fd");

    if(e.lengthComputable){
        var progressElem= $(".right-progress");
        var percentComplete = e.loaded / e.total;
            //progressElem.html(Math.round(percentComplete * 100) + "%");
            

        console.log(percentComplete);
        progressElem.progressbar({
      value: e.loaded,max:e.total
    });
    }
}
*/
////////////////////////////////////////////////////////////////////////////
/// 1. Listen to create Button in add-new-product page,
/// 2. Create product product,
////////////////////////////////////////////////////////////////////////////

function create_article_listener()
{   
       
    $("#create_article_trigger").submit(function(){ 
         
         
         var formData = new FormData($(this)[0]);
         var url= $(this).attr('action');
         create_article(formData,url);      
        
         return false;       
        });              
}

function create_article(data,url)
{
    $.ajax({
         type: "POST",
         url: url,
         data: data,
         cache: false,
         processData: false,
         contentType:false,
         beforeSend: rightProgressFirstBreak,
         success: function(data){
                     $.when(app_f(data)).done(function(){              
                        //add_tag_listener();
                        add_new_inputForImageUpload_listener();
                        imageUpload_listener();
                        imageDelete_listener();
                        
                        set_as_main_listener();
                        $('.right').initializeAddImageFunction();
                        
                     });
                     
                     show_edit_article_listener();
                     create_article_listener();
                     delete_listener();
                     
                     rightProgressSecondBreak();
                     
            },
        complete:rightProgressThirdBreak
     });    
}


////////////////////////////////////////////////////////////////////////////
/// Listen to delete button  ( delete button is represented in 'new' by Cancel, in 'edit new valid'
//  by Cancel, and in 'edit' by Delete.
/// 
////////////////////////////////////////////////////////////////////////////
function delete_listener()
{
         $(".delete_article_trigger").submit(function(){ 
            
         var url= $(this).attr('action');
         var data= $(this).serialize();
         delete_article(data,url);      
        
         return false;       
  
        }); 
}

function delete_article(data,url)
{

    $.ajax({
         type: "POST",
         url: url,
         data: data,
         cache: false,
         beforeSend: rightProgressFirstBreak,
         success: function(data){

                     $('.right').empty();
                     $('.right').append(data);
                     
                     rightProgressSecondBreak();
                                },
         complete:rightProgressThirdBreak
                              
           });    
}

////////////////////////////////////////////////////////////////////////////
/// Listen to cancel button  in add-new-product pages (new and edit_for_valid),
/// 
////////////////////////////////////////////////////////////////////////////


function cancel_button_in_edit_page_listener()
{
     $('a.cancel_button_edit_page').click(function(e){ 
            e.preventDefault(); 
            $('.right').empty();            
            return false;
   });
}


////////////////////////////////////////////////////////////////////////////////
function app_f(data)
{
    //console.log($('.right'));
              $('.right').empty();
              $('.right').html(data);
 return;             
}

function app_wellf(data)
{
              $('.wellright').empty();
              $('.wellright').html(data);
 return;             
}


////////////////////////////////////////////////////////////////////////////
/// 1. Dynamically add an inout field to the collection of input fields
//  2. use html prototype for the new input
//  3. Listen to upload image event
////////////////////////////////////////////////////////////////////////////
function add_tag_listener()
{
    $('a.add_image_trigger').click(function(e){
                e.preventDefault();            
              
                var $collectionHolder;

                $collectionHolder = $('div.images');
                //dump($collectionHolder);
                console.log('$collectionHolder lenght'+$collectionHolder.find(':input').length);

                $collectionHolder.data('index', $collectionHolder.find(':input').length);
        
                var prototype = $collectionHolder.data('prototype');

                var index = $collectionHolder.data('index');
                

                var newForm = prototype.replace(/__name__/g, index);
               

                $collectionHolder.data('index', index + 1);

                var $newFormLi = $('<div></div>').append(newForm);
                $newFormLi.find(':input').trigger('click'); 
                $('a.add_image_trigger').before($newFormLi);
                
                upload_listener(index);
    
                return false;
   });

}


////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Bought click on Show page and Edit Page
//  2. Validating if current user is equal to entity user
/// 3. Update Bought value 
////////////////////////////////////////////////////////////////////////////

function bought_listener()
{
    $('a.bought_trigger_off').click(function(e){
        e.preventDefault();      

	var url = $(this).attr('data-url');
        var author_is_user= parseInt($(this).attr('data-author-is-user'));

        $(this).toggleClass("bought_trigger_on");
    
        if(author_is_user)
        {
            
            var checked_bool = $(this).hasClass('bought_trigger_on');
	    var checked;
            if(!checked_bool) { checked=1; }  else { checked=0; }
            update_bought_value(url,checked);  
        }
        else
        { 
            $(this).toggleClass("bought_trigger_on"); 
        }
        return false;
   });
    
}

function update_bought_value(url,checked)
{

    $.ajax({
            type: "POST",
            url: url,
            cache: false,
            data:{checked:checked},
            success: function(data){
                         //console.log(data);
            }
        });    
        return false;
    
}


////////////////////////////////////////////////////////////////////////////
/// Progress 
////////////////////////////////////////////////////////////////////////////


function rightProgressFirstBreak()
{
    var progressElem= $(".right-progress");
    progressElem.progressbar({
                value: 35
    });
    $('.right').fadeTo('fast', 0.05);

}

function rightProgressSecondBreak()
{
    var progressElem= $(".right-progress");
    progressElem.progressbar({
                        value: 38
                    });
    $('.right').fadeTo('slow', 1.0);

}

function rightProgressThirdBreak()
{
    var progressElem= $(".right-progress");
    progressElem.progressbar({
                        value: 100
                    });
//console.log('f');
}



function centerProgressFirstBreak()
{
    var progressElem= $(".center-progress");
    progressElem.progressbar({
                value: 35
    });
    $('.center').fadeTo('fast', 0.05);

}

function centerProgressSecondBreak()
{
    var progressElem= $(".center-progress");
    progressElem.progressbar({
                        value: 38
                    });
    $('.center').fadeTo('slow', 1.0);

}

function centerProgressThirdBreak()
{
    var progressElem= $(".center-progress");
    progressElem.progressbar({
                        value: 100
                    });

}

function IntraCenterProgressFirstBreak()
{
    var progressElem= $(".center-progress");
    progressElem.progressbar({
                value: 35
    });
    $('.page-content').fadeTo('fast', 0.05);

}

function IntraCenterProgressSecondBreak()
{
    var progressElem= $(".center-progress");
    progressElem.progressbar({
                        value: 38
                    });
    $('.page-content').fadeTo('slow', 1.0);

}

function IntraCenterProgressThirdBreak()
{
    var progressElem= $(".center-progress");
    progressElem.progressbar({
                        value: 100
                    });

}




