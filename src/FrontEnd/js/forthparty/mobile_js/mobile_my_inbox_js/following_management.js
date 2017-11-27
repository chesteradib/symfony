
////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Follow Shop Click
/// 2. Follow the shop
////////////////////////////////////////////////////////////////////////////

function follow_shop_listener()
{
    $('a.trigger_follow').click(function(e){
        e.preventDefault();
        
        var $this= $(this);
        $this.toggleClass("trigger_unfollow");
        
        var url = $this.attr('data-url');
        
        var checked_bool = $this.hasClass('trigger_unfollow');
            
	var checked = (checked_bool ? 0 : 1);
        
        follow_shop($this,url,checked);
        return false;
   });
}

function follow_shop($this, url,checked)
{
    $.ajax({
        type: "POST",
        url: url,
        cache: false,
        data:{checked:checked},
        success: function(data){ 
            if(data.status) {
                if(checked)
                {
                    $this.next().empty().append('S\'abonner');
                }
                else
                {
                    $this.next().empty().append('Se désabonner');
                }
            }
            else{
                alert(data.message);
                $this.toggleClass("trigger_unfollow");
            }
        }
    });    
    return false;
}

