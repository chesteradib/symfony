
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

            //console.log(l);
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
            
            $newFormDiv.find(':input').attr('capture','camera');
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

    
        var $newHidden=$('<input type="hidden" name="result[]">');
        $newHidden.attr('value', data.image_id);
        $newHidden.attr('data-index', data.index);
        $newHidden.appendTo($('.post-form #form-hiddens'));

        
        if( $('.has-image').length===1 )
        {
           $('input[type=hidden][name=main-image]').val(data.image_id);
           set_first_image_as_main();
           
        }
        
    }
    else{
        var $whatTo= $('<div class="error_text"></div>').append(data.error_message);
        $imageContainer.empty().append($whatTo).removeClass().addClass('image_cont has-text '); 

    }
    // call the number of images count
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

    $('.has-image').first().find('.set_as_main').exchangeMain();
    var first_image_id= $('.has-image').first().find('.one_photo').attr('id');
    $('input[type=hidden][name=main-image]').val(first_image_id);
    
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

var manageImageDeletionInDOM= function(image_id, is)
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
    console.log('set_as_main_listener');
    $("#uploaded_images").on("mouseup", "a.set_as_main", function(e){      
        e.preventDefault();            

        var image_id=$(this).parents().eq(1).prop("id");               
        $('input[type=hidden][name=main-image]').val(image_id);
        console.log($(this));
        
        $(this).exchangeMain();

        return false;
   });
};






// VEry old approach// VEry old approach// VEry old approach// VEry old approach// VEry old approach
// // VEry old approach// VEry old approach// VEry old approach// VEry old approach// VEry old approach
// // VEry old approach// VEry old approach// VEry old approach// VEry old approach// VEry old approach
// // VEry old approach// VEry old approach// VEry old approach// VEry old approach// VEry old approach
// VEry old approach // VEry old approach// VEry old approach// VEry old approach// VEry old approach//// VEry old approach// VEry old approach// VEry old approach// VEry old approach// VEry old approach
// // VEry old approach// VEry old approach// VEry old approach// VEry old approach// VEry old approach
// // VEry old approach// VEry old approach// VEry old approach// VEry old approach// VEry old approach
// // VEry old approach// VEry old approach// VEry old approach// VEry old approach// VEry old approach
// VEry old approach // VEry old approach// VEry old approach// VEry old approach// VEry old approach//
// VEry old approach// VEry old approach// VEry old approach// VEry old approach// VEry old approach
// // VEry old approach// VEry old approach// VEry old approach// VEry old approach// VEry old approach
// // VEry old approach// VEry old approach// VEry old approach// VEry old approach// VEry old approach
// // VEry old approach// VEry old approach// VEry old approach// VEry old approach// VEry old approach
// VEry old approach // VEry old approach// VEry old approach// VEry old approach// VEry old approach//
var widthIsBigger;
var widthVsHeight;

function upload_listener(index)
{
    var _URL = window.URL || window.webkitURL;
    
    $(':file').change(function(e){
        console.log(e.target);
        var file = this.files[0];
        

        //var name = file.name;
        //var size = file.size;
        //var type = file.type;
        //Your validation = extention + if file already uploaded
        //console.log(file.size);
        /*
        var img = new Image();
       
        img.onload = function() {
            if (this.width>this.height) 
            { 
                widthIsBigger= true;
                widthVsHeight=1;
                console.log('hhh');
                
            } 
            else if(this.width==this.height) 
            {
                widthVsHeight=0;
                console.log('hh');
                console.log(widthVsHeight);
            }
            else
            { 
                
                widthIsBigger= false;
                widthVsHeight=2;
                console.log('h');
                console.log(widthVsHeight);
            } 
          //console.log(widthVsHeight);
        };

        img.src = _URL.createObjectURL(file);
*/
        var url= $('.post-form').attr('data-iu-url');
        
        var formData = new FormData($('form')[0]);
        formData.append("index", index);
        console.log('index'+index);
        $.ajax({
            url: url,
            type: 'POST',
            xhr: function() {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();

                if(myXhr.upload){ // Check if upload property exists
                    myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
                }
                return myXhr;
            },
            beforeSend: beforeSendHandler, 
            success: completeHandler,
            //error: errorHandler,
            data: formData,
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false,
            contentType: false,
            processData: false
        });
        //$(this).replaceWith($(this).clone(true).val('')); 
        
    });

}

function beforeSendHandler(){
    
    var image_container = $('div.image_cont'); 
    
    console.log(image_container);
    $('<div id="progressbar"></div>').appendTo(image_container);
   //console.log($('.images').children().first()[0]);
    //console.log(progress_bar);
}

function progressHandlingFunction(e){
    if(e.lengthComputable){
        var progressElem= $( "#progressbar" );
        var percentComplete = e.loaded / e.total;
            //progressElem.html(Math.round(percentComplete * 100) + "%");
        progressElem.progressbar({
      value: e.loaded,max:e.total
    });
    }
}

function completeHandler(data){
    

var mythis=$('.images').children().first();

mythis.append(data.output);
mythis.find('#progressbar').hide();
$('.images').prepend('<div class="image_cont"></div>');

var width= $('div.add_image').outerWidth();

$('div.image_div').initializeImageControlsFunction();
mythis.initializeImageDiv(width);

return;


}






////////////////////////////////////////////////////////////////////////////
/// Dumping function for debug purposes To be deleted in production
////////////////////////////////////////////////////////////////////////////


function dump(obj) {
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }

   

    // or, if you wanted to avoid alerts...

    var pre = document.createElement('pre');
    pre.innerHTML = out;
    document.body.appendChild(pre)
}

