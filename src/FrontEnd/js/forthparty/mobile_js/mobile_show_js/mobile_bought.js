var mobile_show= (function($){

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Bought click on Show page and Edit Page
/// 3. Update Bought value 
////////////////////////////////////////////////////////////////////////////

    var bought_listener = function()
    {
        $('a.bought-trigger').click(function(e){
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
    return { 
        bought_listener :bought_listener
    };
})(jQuery);



$(function(){
    mobile_show.bought_listener();
    
});