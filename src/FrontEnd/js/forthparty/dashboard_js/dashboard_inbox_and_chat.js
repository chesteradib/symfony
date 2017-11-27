
////////////////////////////////////////////////////////////////////////////
/// The openening of Websocket connection from client at the moment of web server connection
//listening to websocket connection for incoming messages
////////////////////////////////////////////////////////////////////////////

$(document).ready(function() { 

var current_user_id = $('#content').data('current-user-id').toString();
var current_user_username = $('#content').data('current-user-username').toString();

var ip= $('#content').data('ws-ip').toString();

var conn = new ab.Session('ws://'+ip+':8080',
        function() {  
            conn.subscribe(current_user_id, function(topic, data) {
                    update_after_realtime(data);
            });
        },
        function() {
            console.warn('WebSocket connection closed');
        },
        {'skipSubprotocolCheck': true}
    );
});

////////////////////////////////////////////////////////////////////////////
/// Management of all websockets and corresponding events
////////////////////////////////////////////////////////////////////////////

function update_after_realtime(data)
{
    console.log(data);
    if(data.type==='my_followers' 
      || data.type==='my_market' 
      || (data.type==='my_inbox' && !chatManager.existsInChatterBoxList('box'+data.sender_id+'-'+data.post_id) ))
    update_notification_counter(data.type);
    
    switch(data.type)
    {
        case 'my_inbox':
            console.log(moment(data.messageDate).fromNow());
            
            my_inbox(data);
            message_received_management_in_chatboxManager(data);
            message_seen_management(data);
            break;     
        case 'my_followers':
            my_followers(data);
            break;  
        case 'my_market':
            my_market(data);
            break;  
        default:
            break;
        }            
}

function update_notification_counter(what)
{
        var $counter = $('.notification-counter-'+what);
        var val = parseInt($counter.text());
        
        if (isNaN(val)){
            val = 0;
            val++;
        }
        else
        {
            val++;
        }
        if(what==="my_followers") {
            $counter.css({opacity: 0}).text(val).css({top: '-50px'}).animate({top: '-25px', opacity: 1}, 500).show(); 
            
        }
        else
        {
            $counter.css({opacity: 0}).text(val).css({top: '-50px'}).animate({top: '-12px', opacity: 1}, 500).show();
        
        }
};

var decrement_notification_count_by= function (type, value)
{
        var $counter = $('.notification-counter-'+type);
        var val = parseInt($counter.text());
        
        if (isNaN(val)){
             return;
        }
        else
        {
            val= val-value;
            if(val===0) 
            {
                $counter.text('');
                $counter.hide();
            }
            else $counter.text(val); 
        }

};

////////////////////////////////////////////////////////////////////////////
/// Management of message Seen
//
////////////////////////////////////////////////////////////////////////////

function message_seen_management(data)
{
    if(chatManager.existsInChatterBoxList('box'+data.sender_id+'-'+data.post_id))
    {
        // Add checking of box toggled or not / hidden or not
        // til now it is just taking into account the fact that exists

    var message_seen_base_url=$('#content').data('message-seen-base-url');

        $.ajax({
            type: "POST",
            url: message_seen_base_url,
            data: {message_id:data.message_id},
            cache: false,
        });    
        return false;
    }

}


function messages_seen_management(sender_id,post_id)
{

        var messages_seen_base_url=$('#content').data('messages-seen-base-url');

        $.ajax({
            type: "POST",
            url: messages_seen_base_url,
            data: {sender_id:sender_id, post_id:post_id},
            cache: false
        });    
        return false;


}
////////////////////////////////////////////////////////////////////////////
/// Management Inbox dialog
////////////////////////////////////////////////////////////////////////////

function my_inbox(data)
{           
        //console.log(data);
        var $myInboxContent= $('#my_inbox_content');
    
        if(!$myInboxContent.is(':empty')){
            
            var $noItems= $myInboxContent.find('#no-items-my_inbox');
            if($noItems.length !== 0) $noItems.remove();
            
            
            
            var $dataSenderPostId= $('a[data-sender-id='+data.sender_id+'][data-post-id='+data.post_id+']');
           
            if($dataSenderPostId.length === 0) 
            {
            var messageTemplate= $.templates("#messageItemTemplate");
            var html =  messageTemplate.render(data);    
            $myInboxContent.prepend(html);
            }
            else
            {
               // add additional if else for seen messages already appended or not seen
               
               var $di= $($dataSenderPostId[0]);
               var current_number= parseInt($dataSenderPostId.find('.m-result').text());
               $di.find('.m-result').text(current_number+1);
               $dataSenderPostId.remove();
               $myInboxContent.prepend($di[0]);
            }
        }
       else
       {

           
       }
}

////////////////////////////////////////////////////////////////////////////
/// Management of Message received and appending it to corresponding chat box in chat box Manager if it exists
////////////////////////////////////////////////////////////////////////////

function message_received_management_in_chatboxManager(data)
{

    if(chatManager.existsInChatterBoxList('box'+data.sender_id+'-'+data.post_id))
    chatManager.messageReceivedCallback(data.post_id,data.sender_id,data.sender_username, data.message_content);
   
}


////////////////////////////////////////////////////////////////////////////
/// Management chat boxes: their openning when open chat event triggered in both possible cases:
//  when click on open chat in shpw product page and when message item in inbox dialog clicked.
//  1. open chat listener: listens to click on chat trigger.
//  2. retrieve necessary data to open the chat box and send them to first ajax call (3)
//  3. get the past messages between the two interlocutors via first ajax call and return the html
//  4. callback of the first ajax call : getMessagesBetweenTwoUsersAboutArticleCallback
//  5. when 4 finished lunch second ajax call to retrieve chat textarea and and join it to 3 result
//  6. final callback that will get the whole data (first ajax call+ second ajax call + ui chat widget) and build the chat box
// 
////////////////////////////////////////////////////////////////////////////

function open_chat_listener(){
    $('body').on('click', 'a.open_chat_trigger', openChatListenerCallback);
}




var openChatListenerCallback = function(e) {
        e.preventDefault();
        
        var $this= $(this);
        var discussion_input_base_url=$this.attr('data-url');
        var past_discussion_base_url= $this.attr('data-url2');
        var post_id= $this.attr('data-post-id');
        var box_id,
            receiver_id,
            title_interlocutor_picture_url,
            title_interlocutor_picture_widthVsHeight,
            title_interlocutor_user_name,
            title_interlocutor_post_main_image_url,
            title_interlocutor_post_main_image_widthVsHeight;
    
        var current_user_id = $('#content').data('current-user-id');

        var inter_data;
        // In the case the triggering event comes from inbox dialog
        if ($this.hasClass('trigger')) 
        { 
            
            receiver_id=$this.attr('data-sender-id');
            title_interlocutor_picture_url= $this.children().find('img.m-s-p-p-u').attr('src');
            title_interlocutor_user_name= $this.children().find('div.m-s-u').text();
            title_interlocutor_post_main_image_url= $this.children().find('img.m-p-m-i-u').attr('src');
            title_interlocutor_picture_widthVsHeight= $this.attr('data-ppwvsh');   
            title_interlocutor_post_main_image_widthVsHeight=$this.attr('data-miwvsh');  

            var value_of_decrement= parseInt($this.find('.m-result').text());
            decrement_notification_count_by('my_inbox', value_of_decrement);
        }
        
        else 
        {
            // In the case the triggering event comes from all my inbox
            if($this.hasClass('trigger2'))
            {
                receiver_id=$this.attr('data-sender-id');
                title_interlocutor_picture_url= $this.parent().find('img.m-i-p-p-u').attr('src');
                title_interlocutor_user_name= $this.data('sender-username');
                title_interlocutor_post_main_image_url= $this.parent().find('img.myimg').attr('src');
                title_interlocutor_picture_widthVsHeight= $this.attr('data-ppwvsh');   
                title_interlocutor_post_main_image_widthVsHeight=$this.attr('data-miwvsh');     
            }
            // In the case the triggering event comes from post Show
            else 
            {   
                receiver_id=$this.attr('data-post-author-id');
                title_interlocutor_picture_url= $this.parents().eq(1).find('.post-owner-image img').attr('src');
                title_interlocutor_user_name= $this.parents().eq(1).find('.post-owner-name').text();
                title_interlocutor_post_main_image_url= $this.attr('data-main-src');
                title_interlocutor_picture_widthVsHeight= $this.parents().eq(1).find('.post-owner-image').attr('data-wVsH');   
                title_interlocutor_post_main_image_widthVsHeight=$this.attr('data-wVsH');  
        }}
        box_id = 'box'+receiver_id+'-'+post_id;
        
        if(!chatManager.existsInChatterBoxList(box_id))
        {
            console.log('not exists in chatbix manager final');
            var discussion_input_url= discussion_input_base_url+receiver_id+'/'+post_id;

            var past_discussion_url= past_discussion_base_url + current_user_id +'/'+receiver_id+'/'+post_id;

            inter_data = {
              past_discussion_url:past_discussion_url,
              discussion_input_url:discussion_input_url,
              box_id:box_id,
              receiver_id:receiver_id,
              post_id:post_id,
              discussion_input_base_url:discussion_input_base_url,
              title_interlocutor_picture_url:title_interlocutor_picture_url,
              title_interlocutor_user_name: title_interlocutor_user_name,
              title_interlocutor_post_main_image_url:title_interlocutor_post_main_image_url,
              title_interlocutor_picture_widthVsHeight:title_interlocutor_picture_widthVsHeight,
              title_interlocutor_post_main_image_widthVsHeight:title_interlocutor_post_main_image_widthVsHeight
            };

            get_messages_between_two_users_about_article(
                    inter_data,
                    getMessagesBetweenTwoUsersAboutArticleCallback
                    );
        }
        else
        {   console.log('exists in chatbix manager final');
            chatManager.justShowBox(box_id);   
        }
    }

function get_messages_between_two_users_about_article(inter_data, callback)
{
        $.ajax({
            type: "GET",
            url: inter_data.past_discussion_url,
            cache: false,
            success: callback(inter_data)
        });    
        return false;  
    
}

                
var getMessagesBetweenTwoUsersAboutArticleCallback = function(inter_data)
{
    return function(data, textStatus, jqXHR){
        new_message_form(data,
                        openChatCallback,
                        inter_data);
        }; 
};


function new_message_form(data_two, callback, inter_data)
{    
      
    $.ajax({
         type: "GET",
         url: inter_data.discussion_input_url,
         cache: false,
         success: callback(data_two,inter_data)
      });     
}


var openChatCallback= function(past_discussion,inter_data)
{      
        return function(data, textStatus, jqXHR){

                var current_user_id = $('#content').data('current-user-id').toString();
                var current_user_username = $('#content').data('current-user-username').toString();
                
                var title= {
                    title_interlocutor_picture_url:inter_data.title_interlocutor_picture_url,
                    title_interlocutor_picture_widthVsHeight: parseInt(inter_data.title_interlocutor_picture_widthVsHeight),
                    title_interlocutor_post_main_image_url:inter_data.title_interlocutor_post_main_image_url,
                    title_interlocutor_post_main_image_widthVsHeight:parseInt(inter_data.title_interlocutor_post_main_image_widthVsHeight),
                    title_interlocutor_user_name: inter_data.title_interlocutor_user_name
                }; // put here inter_data title infos
                
                
                var chatBoxTitleTemplate= $.templates("#chatBoxTitleTemplate");
                var renderedTitleFull= chatBoxTitleTemplate.render(title);
                
                var chatterBoxTitleTemplate= $.templates("#chatterBoxTitleTemplate");
                var renderedTitleSmall= chatterBoxTitleTemplate.render(title);
                
                chatManager.addBox(inter_data.box_id,
                                        inter_data.discussion_input_base_url,
                                        past_discussion,
                                        data, 
                                        {
                                            current_user_username:current_user_username, 
                                            current_user_id:current_user_id
                                        }, 
                                        renderedTitleFull,
                                        renderedTitleSmall
                                      );
                              
                
                messages_seen_management(inter_data.receiver_id,inter_data.post_id);
                
        };
};
      




////////////////////////////////////////////////////////////////////////////
/// 1. Listen to SHOW INBOX click
/// 2. Show Inbox Callback
//  3. Bring messages of inbox via ajax before displaying them 
//  4. Bring Inbox callback
//  5. Hide the div when click outside callback
//  6. Call of the necessary function when document ready
//  
////////////////////////////////////////////////////////////////////////////

var inprogress = true; 

function show_inbox_listener(){
    $(".show_inbox_trigger").click(showInboxListener); 
}

var showInboxListener = function(e)
{
    e.preventDefault();

    var $inboxDialog = $('.inbox_dialog');
    var $myInboxContent= $('#my_inbox_content');
    var $targetProgress= $('#my_inbox_progress');
    
    if($inboxDialog.is(":visible")) 
    {        
        $inboxDialog.hide();        
    }
    else{     
        $inboxDialog.show(); 
    }

    if($myInboxContent.is(":empty") && inprogress=== true) {
            inprogress = false;
            var url= $(this).attr('data-url');
               
            $.ajax({
                type: "GET",
                url: url,
                cache: false,
                beforeSend: function(){
                    progress.firstProgress($myInboxContent,$targetProgress,85);
                }, 
                success: function(data){
                    $myInboxContent.append(data);
                    show_all_my_inbox_listener();
                    progress.secondProgress($targetProgress,95);
                },
                complete: function(){
                    progress.thirdProgress($myInboxContent,$targetProgress);
                }
            });
        }
};

var hideWhenVisible = function()
{

    $(document).mouseup(function (e)
    {
        var $inboxDialogContainer = $('.inbox_dialog');
        var $networkDialogContainer = $('.network_dialog');
        var $myMarketDialogContainer = $('.my_market_dialog');
        var $categoriesDialogContainer = $('.categories_dialog')
        
        /*
        if($inboxDialogContainer.is(':visible') 
            || $networkDialogContainer.is(':visible') 
            || $myMarketDialogContainer.is(':visible') 
            || $categoriesDialogContainer.is(':visible')
            )
        { */
            if (!$inboxDialogContainer.is(e.target) // if the target of the click isn't the container...
                && $inboxDialogContainer.has(e.target).length !== 0  // ... nor a descendant of the container
                && !$('.show_inbox_trigger').is(e.target)
                ||
                !$inboxDialogContainer.is(e.target)
                && !$('.show_inbox_trigger').is(e.target)
                )
            {
                $inboxDialogContainer.hide();
            }

            if (!$networkDialogContainer.is(e.target)
                && $networkDialogContainer.has(e.target).length !== 0 
                && !$('.show_network_trigger').is(e.target)
                ||
                !$networkDialogContainer.is(e.target)
                && !$('.show_network_trigger').is(e.target))
            {
                $networkDialogContainer.hide();

            }

            if (!$myMarketDialogContainer.is(e.target) 
                && $myMarketDialogContainer.has(e.target).length !== 0 
                && !$('.show_my_market_trigger').is(e.target)
                || 
                !$myMarketDialogContainer.is(e.target)
                && !$('.show_my_market_trigger').is(e.target)) 
            {
                $myMarketDialogContainer.hide();

            }
            
            if (!$categoriesDialogContainer.is(e.target)
                && $categoriesDialogContainer.has(e.target).length !== 0
                && !$('.show_categories_trigger').is(e.target)
                ||
                !$categoriesDialogContainer.is(e.target)
                && !$('.show_categories_trigger').is(e.target))
            {
                
                //console.log($categoriesDialogContainer);
                $categoriesDialogContainer.hide();
            }
       // }

}); 
    
}


function show_all_my_inbox_listener()
{
    
    $(".show_all_my_inbox_trigger").click(showAllMyInboxListenerCallback); 
}


function showAllMyInboxListenerCallback(e)
{
    e.preventDefault();
    
    var $content= $('#content');
    $content.moveContentToLeft();
    
    var $target = $('#left');
    var $targetProgress= $('#left_progress');

    var url= $(this).attr('data-url');
    var numberOfItemsPerPage= $('#content').data('number-of-items-per-left');

    $.ajax({
        type: "POST",
        data:{ items_per_page: numberOfItemsPerPage},
        url: url,
        cache: false,
        beforeSend: function(){
            progress.firstProgress($target,$targetProgress,85);
            }, 
        success: function(data){
            $target.empty().html(data);
            progress.secondProgress($targetProgress,95); 
            show_shop_listener();
            show_article_listener();
            final_next_previous_page_listenner('left');
        },
        complete: function(){
            progress.thirdProgress($target,$targetProgress);
            var value_of_decrement= parseInt($('.notification-counter-my_inbox').text());
            decrement_notification_count_by('my_inbox', value_of_decrement);
        }
    });
}

