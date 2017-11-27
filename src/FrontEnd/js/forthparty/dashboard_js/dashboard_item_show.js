$.fn.manageActiveScrollable = function(){
    $('.scrollable.active').removeClass('active');
    this.addClass('active');
};
var articleImagesScroller = function(){

        var $postScroller =$('#post-scroller');
        var containerWidth= $('#right_container').outerWidth();
        var numberOfPossibleVisibleElement;
        var $rightArrow= $('#right_arrow');
        var $leftArrow= $('#left_arrow');
        var currentImagesNumber= $postScroller.data('number-of-images');
        var $postImagesToScroll = $('#post-images-toScroll');
        var postScrollerHeight= $postScroller.outerHeight();
        
        $postImagesToScroll.width(currentImagesNumber*postScrollerHeight);
        if(containerWidth === 400) 
        {
            numberOfPossibleVisibleElement= 5;
        }

        $leftArrow.css('visibility', 'hidden');
        if(currentImagesNumber<=numberOfPossibleVisibleElement) $rightArrow.css('visibility', 'hidden');
        
        var index=0;

        $('#right_arrow').on({ 
            mouseenter: function(e){
                $(this).css('background-position', '58.33% 0');     
            },
            mouseleave:function(e){
                $(this).css('background-position', '61.30% 0');     
            },
            click:function(e){

                index++;  
                $leftArrow.css('visibility', 'visible');
                $postImagesToScroll.animate({left:-postScrollerHeight* index}, {duration: 300, easing: "swing"});
                if(index===currentImagesNumber-5)  $rightArrow.css('visibility', 'hidden');
                
                $(this).css('background-position', '55.357% 0');     
            }
        });
        
        
        $('#left_arrow').on({ 
            mouseenter: function(e){
                $(this).css('background-position', '97.02% 0');     
            },
            mouseleave:function(e){
                $(this).css('background-position', '100% 0');     
          },
            click:function(e){
                
                index--;
                $rightArrow.css('visibility', 'visible');
                $postImagesToScroll.animate({left: -postScrollerHeight* index}, {duration: 300, easing: "swing"});
                if(index===0)  $leftArrow.css('visibility', 'hidden');
                
                $(this).css('background-position', '94.04% 0');
                
          }
        });
        
        // display the image horizontally or vertically for the main image
        var main_image_src=$postImagesToScroll.find('.mainy img').attr("src").replace('s_','m_');
        var n= $postImagesToScroll.find('.mainy').attr("data-number");
        
        display_image(main_image_src,n);
        // end display the image horizontally or vertically for the first image in the set of thumbs

    return false;

};

function display_image_on_thumb_click_listener()
{  
    $(".scrollable").on("click", function(e){
        e.preventDefault();
        var $this=$(this);
        var scrollable_image_src=$this.find('img').attr("src").replace('s_','m_');
        var number=$this.attr("data-number");
        $this.manageActiveScrollable();
        display_image(scrollable_image_src,number);
    });
}

function display_image(p,n)
{
    var $postMainImage=$('#post-main-image');
    var $postMainImageImg= $('#post-main-image img');    
    
    var img = new Image();
    img.onload = function() {
        //first case: very fat
        if(this.width>1.6*this.height) 
        {
            $postMainImage.find('.helper').remove(); 
            $postMainImage.prepend($('<span class="helper"></span>'));
            $('.post-main-image').css('text-align','');
            $postMainImageImg.removeClass().addClass('mi-very-fat');

        }
        // second case: fat
        if(this.height<this.width && this.width<1.6*this.height)
        {
            $postMainImage.find('.helper').remove(); 
            $postMainImage.prepend($('<span class="helper"></span>'));
            $postMainImage.css('text-align','center');
            $postMainImageImg.removeClass().addClass('mi-fat');

        }
        // third case: tall
        if(this.width<this.height)
        {
            $postMainImage.find('.helper').remove(); 
            $postMainImageImg.removeClass().addClass('mi-tall');
            $postMainImage.css('text-align','center');
        }
    };
        
    img.src=p;
    $postMainImageImg.attr('src',p);
    $postMainImage.attr('data-number',n); 
}
