

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to Follow Shop Click
/// 2. Follow the shop
////////////////////////////////////////////////////////////////////////////

function follow_shop_listener()
{
    
     $('a.trigger_follow').click(function(e){
        e.preventDefault();
        
        $(this).toggleClass("trigger_unfollow");
        var url = $(this).attr('data-url');

        var checked_bool = $(this).hasClass('trigger_unfollow');
            
	var checked;
        if(!checked_bool) { checked=1; }  else { checked=0; }
            
            
        follow_shop(url,checked);
        return false;
   });
    
}

function follow_shop(url,checked)
{
    
    $.ajax({
            type: "POST",
            url: url,
            cache: false,
            data:{checked:checked},
            success: function(data){
            }
        });    
        return false;
    
}

////////////////////////////////////////////////////////////////////////////
/// Manage Following Notifications
/// 
////////////////////////////////////////////////////////////////////////////

function my_followers(data)
{
         
        console.log(data);
        
        var $networkDialog = $('.network_dialog');
          
        if($networkDialog.length !== 0)
        {
            var followTemplate= $.templates("#followItemTemplate");
            var html =  followTemplate.render(data);
            
            var $dataFollowerId= $('a[data-follower-id='+data.follower_id+']');
           
            if($dataFollowerId.length === 0) 
            {
                $networkDialog.prepend(html);
            }
            else
            {
                var $di= $dataFollowerId.empty().html(html);
                var content= $di.contents();
                $dataFollowerId.remove(); 
                $networkDialog.prepend(content);      
            }
        }
        increment_number_of_followers_of_current_user();
}

var increment_number_of_followers_of_current_user= function()
{
        var $counter = $('.show_network_trigger');
        
        var val = parseInt($counter.text());

        if (isNaN(val)){
            val = 0;
            val++;
        }
        else
        {
            val++;
        }
        
        $counter.text(val); 
    
};
////////////////////////////////////////////////////////////////////////////
/// Management of follow Seen
//
////////////////////////////////////////////////////////////////////////////

function follow_seen_management(follow_seen_url,follower_id,last_date_url)
{
            
    
console.log('fillow');
    $.ajax({
            type: "POST",
            url: follow_seen_url,
            data: {follower_id:follower_id},
            success: function()
            {
                
                update_last_date(follower_id,last_date_url);
            },
            cache: false,
        });    
        return false;
}

////////////////////////////////////////////////////////////////////////////
/// 1. Listen to SHOW Network click
/// 2. Show Network Callback
//  3. Bring follows of network via ajax before displaying them 
//  4. Bringnetwork callback
//  5. Call of the necessary function when document ready
//  
////////////////////////////////////////////////////////////////////////////


function show_network_listener(){
    $(".show_network_trigger").click(showNetworkListener); 
}

var showNetworkListener = function(e)
{
        var $networkDialog = $('.network_dialog');
        e.preventDefault();
          
        if($networkDialog.length === 0) {
                    var url= $(this).attr('data-url');
                    $.when(bring_network(url, bringNetworkDialogCallback)).done(function(){
                    }
                ); 
        }
        else
        {   
            if($networkDialog.is(":visible")) 
            { 
                $networkDialog.hide(); 
            }
            else { 
                 
                $networkDialog.show(); 
            }
        }
};


function bring_network(url, callback)
{
    $.ajax({
            type: "GET",
            url: url,
            cache: false,
            success: callback
            
        });    
        return false;  
}

function bringNetworkDialogCallback(data)
{
     var $headerDialogs =  $('.header_dialogs');
     $headerDialogs.append(data);
     show_shop_listener();
}



$(document).ready(function (e)
{
    show_network_listener();

});


