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
$('div.image_div').imageHoverFunction();
mythis.initializeImageDiv(width);

return;


}




////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Set As main Image click on  Edit Page
/// 2. Update main Image Bought value 
////////////////////////////////////////////////////////////////////////////

function set_as_main_listener()
{
    $(".images").on("click", "a.set_as_main", function(e){
                e.preventDefault();            
              
                var image_id=$(this).parents().eq(1).prop("id");
                var url= $('.post-form').attr('data-smi-url');
                
                // Code that maybe will be factorized
                
                $('a.main').removeClass("main");
                $(this).toggleClass("main");
                
                // end Code that maybe will be factorized
        
                set_as_main(image_id,url);
    
                return false;
   });

}


function set_as_main(image_id,url)
{
    
$.ajax({
         type: "POST",
         url: url,
         data: {image_id:image_id},
         cache: false,
         success: function(data){
                         }
           
       });  


}
////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Delete Image click on  Edit Page/New page
/// 2. Update database by removing corresponding record
////////////////////////////////////////////////////////////////////////////
function delete_image_listener()
{
     $('.images').on("click", "a.delete_image_trigger", function(e){

        e.preventDefault();  
        
        var url=$(this).parents().eq(1).attr("url");
        var id=$(this).parents().eq(1).attr("id");
        
        // Code in the case of main image deleted. It really depend on the final structure of dom
        // check if parent element contains at least 2 photo div and set main image in adjacent-before div
        // but if the patent div is empty then set no main image
         if($(this).hasClass("main") )
            {
                
                
            }
        
        //alert(id);
        delete_image(url, id);
               
   });

}

function delete_image(url, id)
{
    $('.images #'+id).remove(); 
    $.ajax({
                    type: "POST",
                    url: url,
                    cache: false,
                    success: function(data){
                                                   
                     
                           
                    }
                    });  
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

