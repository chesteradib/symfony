//Tnhis 
//hfuiew ljfewf 

var add_new_inputForImageUpload_listener= function ()
{

    $('a.add_image_trigger').click(function(e){
                e.preventDefault();            
              
                var $collectionHolder;

                $collectionHolder = $('div.images_input');
                var maximum;
                var l;
                        
                l=$('.post-form').find('input[type="hidden"][name="result[]"]').length;
                
                console.log(l);
                if(l===0) maximum = -1;
                if(l>0) 
                {    
                var maximum = 0;
                
                $('.post-form').find('input[type="hidden"][name="result[]"]').each(function() {
                  var value = parseInt($(this).attr('data-index'));
                  
                  maximum = (value > maximum) ? value : maximum;
                });
                }
                console.log('max'+maximum);
                //$collectionHolder.data('index', maximum+1);
                var prototype = $collectionHolder.data('prototype');
                
                var newFormElement = prototype.replace(/__name__/g, maximum+1);   

                $collectionHolder.data('index', maximum+1);

                var $newFormDiv = $('<div></div>').attr('data-index',maximum+1).append(newFormElement);
                
                $newFormDiv.find(':input').trigger('click'); 
                
                $('a.add_image_trigger').before($newFormDiv);

                return false;
   });
    
   
    
}


var imageUpload_listener= function() 
{
    $('.images_input').on('change','input[type=file]',function(e){
        
        var url= $('.post-form').attr('data-iu-url');
        var index= $(this).parents().eq(2).data('index');
         
        var formData = new FormData($('form')[0]);
        formData.append("index", index);
        
        $.ajax({
            url: url,
            type: 'POST',
            xhr: function() {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();

                if(myXhr.upload){ // Check if upload property exists
                    myXhr.upload.addEventListener('progress',imageUploadProgressHandler, false); // For handling the progress of the upload
                }
                return myXhr;
            },
            beforeSend: beforeImageUploadHandler, 
            success: imageUploadCompleteHandler,
            //error: errorHandler,
            data: formData,
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false,
            contentType: false,
            processData: false
        });
        
    return false;   
    });
}

var imageUploadCompleteHandler = function(data)
{
    var $uploadedImages= $('.uploaded_images')
    var $imageContainer=$('.uploaded_images').children().first();

    $imageContainer.append(data.output);
    
    $uploadedImages.prepend('<div class="image_cont"></div>');

    var width= $('div.add_image').outerWidth();

    $('div.image_div').initializeImageControlsFunction();
    $('div.image_div').imageHoverFunction();
    $imageContainer.initializeImageDiv(width);
    

    var $newHidden=$('<input type="hidden" name="result[]">');
    $newHidden.attr('value', data.image_id);
    $newHidden.attr('data-index', data.index);
    $newHidden.appendTo($('.post-form'));

    return;
    
};

var beforeImageUploadHandler = function()
{
    
    
};

var imageUploadProgressHandler = function()
{
    
    
};


var imageDelete_listener= function()
{
     $('.uploaded_images').on("click", "a.delete_image_trigger", function(e){

        e.preventDefault();  
        
        var delete_image_url= $('.post-form').attr('data-id-url');
        var id=$(this).parents().eq(1).attr("id");

        
        // Code in the case of main image deleted. It really depend on the final structure of dom
        // check if parent element contains at least 2 photo div and set main image in adjacent-before div
        // but if the patent div is empty then set no main image
         if($(this).hasClass("main") )
            {
                
                
            }
        
        deletes_image(delete_image_url, id);
        manageImageDeletionInDOM(id);
               
   });

};

var deletes_image=function(url, id)
{

    $.ajax({
                    type: "POST",
                    url: url,
                    data: {image_id:id},
                    cache: false
                    });
          
};

var manageImageDeletionInDOM= function(image_id)
{
    
    var current_index=$('input[type=hidden][value='+image_id+']').data('index');
    //remove the specific hidden field
    $('input[type=hidden][value='+image_id+']').remove();
     
    // remove the specific div item that cotnainta the input field
    $('.images_input div[data-index='+current_index+']').remove();
     
    // remove the image container
    $('.uploaded_images #'+image_id).parent().remove();

};
