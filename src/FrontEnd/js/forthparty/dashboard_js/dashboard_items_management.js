$.fn.manageActiveItem = function(){
    $('.item-container.active').removeClass('active');
    this.children().eq(0).addClass('active'); 
};
$.fn.manageLeftActiveItem = function(){
    $('.left-item-container.active').removeClass('active');
    this.parents().eq(0).addClass('active'); 
};
////////////////////////////////////////////////////////////////////////////
/// 1. Show page of products after click on pagination
////////////////////////////////////////////////////////////////////////////



function show_page_of_products(url, page, numberOfItemsPerPage)
{
    
    var $target= $('#center-items-container');

    $.ajax({
            type: "POST",
            data: {page: page, articles_per_page: numberOfItemsPerPage},
            url: url,
            cache: false,
            beforeSend:function(){
            },
            success: function(data){
                
                $target.empty().html(data);
                show_article_listener();
                product_hover_listener();
                
            },
            complete:function(){
            },
        });    
        return false;

  }

////////////////////////////////////////////////////////////////////////////
/// 1. Show page of non products after click on pagination
////////////////////////////////////////////////////////////////////////////

function show_page_of_nonproducts(url,current_page,numberOfItemsPerPage,type)
{

    var $target= $('#left-items-container');

    $.ajax({
            type: "POST",
            data: {current_page: current_page, items_per_page: numberOfItemsPerPage},
            url: url,
            cache: false,
            beforeSend:function(){

            },
            success: function(data){
                
                $target.empty().html(data);
                if(type==='inbox')
                {
                    //open_chat_listener();
                    show_article_listener();
                }
                if(type==='network')
                {
                    follow_shop_listener();
                }
                show_shop_listener();
                 
            },
            complete:function(){

            },
        });    
        return false;
    
}

/*product_hover_listener();*/

function product_hover_listener()
{

    $('.product-image-and-title').hover(function() {
        //$(this).parent().find('.product-title-in-posts').show();
        $(this).find('.product-title-in-posts').css('z-index', 3000);

    }, function() {
        //$(this).parent().find('.product-title-in-posts').hide();
        $(this).find('.product-title-in-posts').css('z-index', -1);
    });

}