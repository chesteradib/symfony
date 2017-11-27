(function($){
    
    
    $.fn.initializeImageDiv = function(width)
        {
            
         $('div.image_cont').each(function(){
             var $this = $(this);
             if ($this.is(':empty')) $('div.image_div').width(width).height(width);   
         });


        $(this).find('.one_photo').css('width', width).css('height', width);
        $(this).find('img').css('max-height',width);
        $(this).find('img').css('max-width',width);

        return this;
        

        };
    
    $.fn.initializeImageControlsFunction = function(){
        
        var $setAsMainAnchor = $(this).next().find('a.set_as_main');
        var $deleteImageAnchor = $(this).next().find('a.delete_image_trigger');
        
        $setAsMainAnchor.css('background-size', '3610% 185.7%');
        $setAsMainAnchor.css('background-position', '80.05% 0');     
        
        
        $deleteImageAnchor.css('background-size', '1605% 200%');
        $deleteImageAnchor.css('background-position', '38.205% 0');
        
        return this;
        
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
    
    
    $.fn.initializeAddImageFunction = function(){
        
        var width= $('.right').outerWidth();
        width= width/5;
        $('.add_image').width(width).height(width);
        $('.add_image a').width(width).height(width);
        
        $('.add_image a').css('background-position', '12.77% 0%');
        $('.add_image a').css('background-size', '1660% 100%');
        
        $('a.add_image_trigger').on({ 
            mouseenter: function(e){
                $(this).css('background-position', '6.385% 0%');
            },
            mouseleave:function(e){
                $(this).css('background-position', '12.77% 0%');
          },
            click:function(e){
                $(this).css('background-position', '0% 0%');
                
          },
                  
        });
        

    return this;
    };
})(jQuery);




        /*
         * This code is to be merged with the code of complete handler in admin_js_my_shop_image_upload
        $(".images img").each(function(){
            var $this = $(this);
            if ($this.width() > $this.height()) {
                $this.addClass("horizontal");
            }
        });
        */