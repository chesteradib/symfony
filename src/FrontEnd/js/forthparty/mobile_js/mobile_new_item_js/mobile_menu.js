$(function() {

    $('.toggle-nav-menu').click(function(e) {
        
        $(this).toggleClass('active');
        $('.menuItems').toggleClass('active');
        $('.navi').each(function(){
            if(!$(this).hasClass("menuItems")) $(this).addClass("active");
            
        });
        e.preventDefault();
    });
    
    $('.toggle-nav-by-category').click(function(e) {
        $(this).toggleClass('active');
        $('.by-category-select').toggleClass('active');
        $('.navi').each(function(){
            if(!$(this).hasClass("by-category-select")) $(this).addClass("active");
            
        });
 
        e.preventDefault();
    });
    
    $('.toggle-nav-search').click(function(e) {
        
        $(this).toggleClass('active');
        $('.search-form').toggleClass('active');
        $('.navi').each(function(){
            if(!$(this).hasClass("search-form")) $(this).addClass("active");
            
        });
        e.preventDefault();
    });
    
    $('select').change(function(e) {
        e.preventDefault();
        
        var value = $('select option:selected').val(); 
        if(value !==0)
        {
            var url= $(this).data('url');
            var newURL =  url.slice(0, url.indexOf('0'))+ value + '/g/0';
            
            window.location.replace(newURL);
        }
    }); 
});