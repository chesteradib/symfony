
////////////////////////////////////////////////////////////////////////////
/// 1. Dynamically add an inout field to the collection of input fields
//  2. use html prototype for the new input
//  3. Listen to upload image event
////////////////////////////////////////////////////////////////////////////

var countNumberOfImages = function(){
    return $('#uploaded_images').children('.has-image').length;
    
};

var add_new_inputForImageUpload_listener= function ()
{

    $('a#add_image_trigger').click(function(e){
        e.preventDefault();            
        
        if(countNumberOfImages()<8) {
            
           var $collectionHolder;

            $collectionHolder = $('div.images_input');
            var maximum;
            var l;

            l=$('.post-form').find('input[type="hidden"][name="result[]"]').length;

            console.log('gio'+l);
            if(l===0) maximum = -1;
            if(l>0) 
            {    
                var maximum = 0;

                $('.post-form').find('input[type="hidden"][name="result[]"]').each(function() {
                    var value = parseInt($(this).attr('data-index'));

                    maximum = (value > maximum) ? value : maximum;
                });
            }
            //console.log('max'+maximum);
            //$collectionHolder.data('index', maximum+1);
            var prototype = $collectionHolder.data('prototype');

            var newFormElement = prototype.replace(/__name__/g, maximum+1);   

            $collectionHolder.data('index', maximum+1);

            var $newFormDiv = $('<div></div>').attr('data-index',maximum+1).append(newFormElement);

            $newFormDiv.find(':input').trigger('click'); 

            $('a#add_image_trigger').before($newFormDiv);
            return false;
            
        }
        else
        {
           
            show_error_number_of_images_exceeded();
            return false;
            
        }
        
   });
}


var imageUpload_listener= function() 
{
    $('.images_input').on('change','input[type=file]',function(e){
        
        $("#dvloader").show();
         
        var $postForm= $('.post-form');
        
        var url= $postForm.attr('data-iu-url');
        var index= $(this).parents().eq(2).data('index');
        
        var formData = new FormData($postForm[0]);
        
        formData.append("index", index);

        Utils.ajax_call("POST", url, formData , false, function(){} ,imageUploadCompleteHandler, function(){}, false, false);
        return false;

    });
}

var imageUploadCompleteHandler = function(data)
{
    $("#dvloader").hide();
    
    var $uploadedImages= $('#uploaded_images')
    var $imageContainer=$uploadedImages.find('.empty'); // previous because I have div.clear
    
    if(data.code)
    {
        var uploadedImageTemplate= $.templates("#uploadedImageTemplate");
        var html =  uploadedImageTemplate.render(data);
       
        if(!$imageContainer.hasClass('has-image')) 
        {
            $imageContainer.empty().append(html).removeClass().addClass('image_cont has-image');
        }
        
        $('<div class="image_cont empty"></div>').insertBefore( "#dvloader" );

        $('div.image_div').imageHoverFunction();
    
        var $newHidden=$('<input type="hidden" name="result[]">');
        $newHidden.attr('value', data.image_id);
        $newHidden.attr('data-index', data.index);
        $newHidden.appendTo($('.post-form #form-hiddens'));
        //console.log($('.has-image'));
        
        if( $('.has-image').length===1 )
        {
           $('input[type=hidden][name=main-image]').val(data.image_id);
           set_first_image_as_main();
           
        }
        
    }
    else{
        var $whatTo= $('<div class="error_text"></div>').append(data.error_message);
        $imageContainer.empty().append($whatTo).removeClass().addClass('image_cont has-text '); 
        $('div.image_div').imageHoverFunction();

    }
    // call the number of images count
    return;
    
};


$.fn.imageHoverFunction = function(){

    $('div.image_div').on({
        mouseenter: function(e){

            $(this).next().find('.delete_image_trigger').css('background-position', '31.565% 0');
            $(this).next().find('.set_as_main').css('background-position', '77.20% 0');

        },
        mouseleave:function(e){
            $(this).next().find('.delete_image_trigger').css('background-position', '38.205% 0');
            $(this).next().find('.set_as_main').css('background-position', '80.05% 0');
        }
    });

    $('a.delete_image_trigger').on({
        mouseenter: function(e){
            $(this).css('background-position', '24.91% 0');
        },
        mouseleave:function(e){
            $(this).css('background-position', '38.205% 0');
        },
        click:function(e){
            $(this).css('background-position', '31.56% 0');
        }
    });

    $('a.set_as_main').on({
        mouseenter: function(e){
            $(this).css('background-position', '77.20% 0');
        },
        mouseleave:function(e){
            $(this).css('background-position', '80.05% 0');
        },
        click:function(e){
            $(this).css('background-position', '74.359% 0');
        }

    });

    return this;
};


var imageDelete_listener= function()
{
     $('#uploaded_images').on("click", "a.delete_image_trigger", function(e){
        
        e.preventDefault(); 

        var delete_image_url= $('.post-form').attr('data-id-url');
        var id=$(this).parents().eq(1).attr("id");
        var is= false;
        
        if($(this).parent().find('a.set_as_main').hasClass("main") )
        {
           //$('input[type=hidden][name=main-image]').val('');
           is= true;
           
           
        }
        
        deletes_image(delete_image_url, id);
        manageImageDeletionInDOM(id, is);
        
         
               
   });

};

var set_first_image_as_main= function(){
    //console.log($('.has-image').first().find('.set_as_main'));
    $('.has-image').first().find('.set_as_main').exchangeMain();
    var first_image_id= $('.has-image').first().find('.one_photo').attr('id');
    //console.log('first image id'+first_image_id);
    $('input[type=hidden][name=main-image]').val(first_image_id);
    
    
    
    
};

var deletes_image = function(url, id)
{
    Utils.ajax_call("POST", url, { image_id : id } , false, function(){} ,function(){}, function(){});
    return false;
};

var manageImageDeletionInDOM = function(image_id, is)
{
    
    var current_index=$('input[type=hidden][name="result[]"][value='+image_id+']').data('index');
    //remove the specific hidden field
    $('input[type=hidden][name="result[]"][value='+image_id+']').remove();
     
    // remove the specific div item that cotnainta the input field
    $('.images_input div[data-index='+current_index+']').remove();
     
    // remove the image container
    $('#uploaded_images #'+image_id).parent().remove();
    
    if(is)
    {
        set_first_image_as_main();
    }
    else
    {}
    

};
$.fn.exchangeMain = function(){
    $('a.set_as_main').each(function(){
        $(this).removeClass("main");
        $(this).parents().eq(1).find('#principale').remove(); 
    });
                
    $(this).toggleClass("main");
        
    var $principaleContainer=$('<div id="principale"></div>');
    $principaleContainer.html($('#uploaded_images').data('principale'));
    $(this).parents().eq(1).append($principaleContainer);

};

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Set As main Image click on  Edit Page
/// 2. Update main Image Bought value 
////////////////////////////////////////////////////////////////////////////



var  set_as_main_listener = function()
{
    
    $("#uploaded_images").on("mouseup", "a.set_as_main", function(e){      
        e.preventDefault();            

        var image_id=$(this).parents().eq(1).prop("id");               
        $('input[type=hidden][name=main-image]').val(image_id);
        
        $(this).exchangeMain();

        return false;
   });
};







