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
});