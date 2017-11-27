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

////////////////////////////////////////////////////////////////////////////
/// Manage Following Notifications
/// 
////////////////////////////////////////////////////////////////////////////

function my_followers(data)
{
            var $myNetworkContent= $('#my_network_content');
    
            if(!$myNetworkContent.is(':empty')){

            var $noItems= $myNetworkContent.find('#no-items-my_network');
            if($noItems.length !== 0) {
                $noItems.remove();
            }
            // it is nor enough to remove the no items div but it is mandatory to empty it 
            // and incremennt its value shng like: you have 3 new items in network
            
            var $dataFollowerId= $('a[data-follower-id='+data.follower_id+']');
            
            if($dataFollowerId.length === 0) 
            {
                var followTemplate= $.templates("#followItemTemplate");
                var html =  followTemplate.render(data);
                $myNetworkContent.prepend(html);
            }
            else
            {
                var $di= $dataFollowerId.empty().html(html);
                var content= $di.contents();
                $dataFollowerId.remove(); 
                $myNetworkContent.prepend(content);      
            }
        
        increment_number_of_followers_of_current_user();
        }
        else{}
        
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

var inprogress2 = true; 

function show_network_listener(){
    $(".show_network_trigger").click(showNetworkListener); 
}

var showNetworkListener = function(e)
{
    e.preventDefault();
    var $myNetworkDialog = $('.network_dialog');
    var $myNetworkContent= $('#my_network_content');
    var $targetProgress= $('#my_network_progress');
        
    if($myNetworkDialog.is(":visible")) 
    {        
        $myNetworkDialog.hide();        
    }
    else {  
        $myNetworkDialog.show();
    }
    
    if($myNetworkContent.is(":empty")  && inprogress2=== true) {
        
            inprogress2 = false;
            var url= $(this).attr('data-url');             
            $.ajax({
                type: "GET",
                url: url,
                cache: false,
                beforeSend: function(){
                    progress.firstProgress($myNetworkContent,$targetProgress,85);
                }, 
                success: function(data){  
                    $myNetworkContent.append(data);
                    progress.secondProgress($targetProgress,95);
                    show_shop_listener();
                    show_all_my_network_listener();
                },
                complete: function(){
                    progress.thirdProgress($myNetworkContent,$targetProgress);
                }
            });
        }
             
};




function show_all_my_network_listener()
{
    
    $(".show_all_my_network_trigger").click(showAllMyNetworkListenerCallback); 
}


function showAllMyNetworkListenerCallback(e)
{
    e.preventDefault();
    var url= $('#content').attr('data-url-show-all-my-network');
    var $content= $('#content');
    $content.moveContentToLeft();
    show_all_my_network(url,false); 
}

function show_all_my_network(url,what){
    
    var $target = $('#left');
    var $targetProgress= $('#left_progress');
    
    var numberOfItemsPerPage= $('#content').data('number-of-items-per-left'); 
    //console.log(numberOfItemsPerPage);
    $.ajax({
        type: "POST",
        url: url,
        data:{ items_per_page: numberOfItemsPerPage},
        cache: false,
        beforeSend: function(){
            progress.firstProgress($target,$targetProgress,85);
            }, 
        success: showAllMyNetworkCallback,
        complete: function(){
            progress.thirdProgress($target,$targetProgress);
            if(what) {
                
                //I should check if there is no item to do not have asynchrounous deprecated call
                //var product_url=
                //$('#right').empty();
                //$('.show_article_trigger:first').click();
                        //.attr("data-show-url");   
                //show_article(product_url,showArticleCallback);}
            }
            }
    });
}
function showAllMyNetworkCallback(data)
{
    console.log('showAllMyNetworkCallback(');
    var $target = $('#left');
    var $targetProgress= $('#left_progress');
    progress.secondProgress($targetProgress,95);
    
    $target.empty().html(data);
    follow_shop_listener();
    //show_shop_listener_others();
    final_next_previous_page_listenner('left','network');
}


