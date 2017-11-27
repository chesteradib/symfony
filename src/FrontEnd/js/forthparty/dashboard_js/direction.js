$.fn.moveContentToLeft = function(){
    this.removeClass("righty");
    this.removeClass("centry");
    $('#right_direction').css('visibility','visible');
    $('#left_direction').css('visibility','hidden');  
};

$.fn.moveContentToCenter = function(){
    this.addClass("centry");
    this.removeClass("righty");
    $('#left_direction').css('visibility','visible');
    $('#right_direction').css('visibility','visible');
};

$.fn.moveContentToRight = function(){
    this.addClass("righty");
    this.removeClass("centry");
    $('#left_direction').css('visibility','visible');
    $('#right_direction').css('visibility','hidden'); 
};

function initialize_direction()
{
    $('#left_direction').css('visibility','hidden');
    $('#right_direction').css('visibility','hidden');  
}

function show_direction()
{
    $('#left_direction').css('visibility','visible');
    $('#right_direction').css('visibility','visible');    
}

function direction_listener(){ 
    $('#right_direction').click(function(){
        if($('#content').hasClass('centry'))
        {
            $('#content').moveContentToRight();
        }
        else
        {
            $('#content').moveContentToCenter();
        }
    });
    $('#left_direction').click(function(){
        if($('#content').hasClass('centry'))
        {
            $('#content').moveContentToLeft();
        }
        else
        {
          $('#content').moveContentToCenter();
        }
    });
}
  
