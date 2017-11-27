////////////////////////////////////////////////////////////////////////////
/// Configuration of JSRender so that {{ and }} don't conflict with twig ones
//They are now replaced by <% and %>
////////////////////////////////////////////////////////////////////////////

$.views.settings.delimiters("<%", "%>");

////////////////////////////////////////////////////////////////////////////
/// The openening of Websocket connection from client at the moment of web server connection
//listening to websocket connection for incoming messages
////////////////////////////////////////////////////////////////////////////

$(document).ready(function() { 

var current_user_id = $('#container').data('current-user-id').toString();
var current_user_username = $('#container').data('current-user-username').toString();

var conn = new ab.Session('ws://localhost:8080',
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
    
    if(data.type==='my_followers' 
      || data.type==='my_market' 
      || (data.type==='my_inbox' && !chatboxManager.existsInBoxList('box'+data.sender_id+'-'+data.post_id) ))
    update_notification_counter(data.type);

    switch(data.type)
    {
        case 'my_inbox':
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
            console.log('default behaviour of PubSub');
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
        $counter.css({opacity: 0}).text(val).css({top: '-10px'}).animate({top: '-1px', opacity: 1}, 500); 
}

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
            if(val===0) $counter.text('');
            else $counter.text(val); 
        }

};

////////////////////////////////////////////////////////////////////////////
/// Management of message Seen
//
////////////////////////////////////////////////////////////////////////////

function message_seen_management(data)
{
    if(chatboxManager.existsInBoxList('box'+data.sender_id+'-'+data.post_id))
    {
        // Add checking of box toggled or not / hidden or not
        // til now it is just taking into account the fact that exists

    var message_seen_base_url=$('#container').data('message-seen-base-url');

        $.ajax({
            type: "POST",
            url: message_seen_base_url,
            data: {message_id:data.message_id},
            cache: false,
        });    
        return false;
    }

}


function messages_seen_management(sender_id,receiver_id,post_id)
{

        var messages_seen_base_url=$('#container').data('messages-seen-base-url');

        $.ajax({
            type: "POST",
            url: messages_seen_base_url,
            data: {sender_id:sender_id , receiver_id:receiver_id, post_id:post_id},
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
        var $inboxDialog = $('.inbox_dialog');
          
        if($inboxDialog.length !== 0)
        {
            var messageTemplate= $.templates("#messageItemTemplate");
            var html =  messageTemplate.render(data);
            
            var $dataSenderPostId= $('a[data-sender-id='+data.sender_id+'][data-post-id='+data.post_id+']');
           
            if($dataSenderPostId.length === 0) 
            {
                $inboxDialog.prepend(html);
            }
            else
            {
                // add additional if else for seen messages already appended or not seen
                var current_number= parseInt($dataSenderPostId.find('.m-result').text());
                console.log(current_number);
                var $di= $dataSenderPostId.empty().html(html);
                var content= $di.contents();
                content.find('.m-result').text(current_number+1);
                $dataSenderPostId.remove(); 
                $inboxDialog.prepend(content);
                  
            }
        }
}

////////////////////////////////////////////////////////////////////////////
/// Management of Message received and appending it to corresponding chat box in chat box Manager if it exists
////////////////////////////////////////////////////////////////////////////

function message_received_management_in_chatboxManager(data)
{

    if(chatboxManager.existsInBoxList('box'+data.sender_id+'-'+data.post_id))
    chatboxManager.messageReceivedCallback(data.post_id,data.sender_id,data.sender_username, data.message_content);
   
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
    $('.right a.open_chat_trigger').click( openChatListenerCallback);
    $('.inbox_dialog').on('click', 'a.open_chat_trigger', openChatListenerCallback);
}

var openChatListenerCallback = function(e) {
        
       
        e.preventDefault();
        
        
        var $this= $(this);
        var discussion_input_base_url=$this.attr('data-url');
        var past_discussion_base_url= $this.attr('data-url2');
        var post_id= $this.attr('data-post-id');
        var box_id,
            sender_id,
            receiver_id,
            title_interlocutor_picture_url,
            title_interlocutor_user_name,
            title_interlocutor_post_main_image_url;

        var inter_data;
        
        if ($this.hasClass('trigger')) 
        { 
            receiver_id=$this.attr('data-sender-id');
            sender_id=$this.attr('data-post-author-id');
            title_interlocutor_picture_url= $this.children().find('img.m-s-p-p-u').attr('src');
            title_interlocutor_user_name= $this.children().find('span').text();
            title_interlocutor_post_main_image_url= $this.children().find('img.m-p-m-i-u').attr('src');
            //console.log(title_interlocutor_post_main_image_url);
            
            var value_of_decrement= parseInt($this.find('.m-result').text());
            decrement_notification_count_by('my_inbox', value_of_decrement);

        }
        else 
        {
            receiver_id=$this.attr('data-post-author-id');
            sender_id =$this.attr('data-sender-id');
            title_interlocutor_picture_url= $this.parents().eq(1).find('.post-owner-image img').attr('src');
            title_interlocutor_user_name= $this.parents().eq(1).find('.post-owner-name').text();
            title_interlocutor_post_main_image_url= $this.attr('data-main-src');
            //console.log(title_interlocutor_post_main_image_url);
            
            
        }
        box_id = 'box'+receiver_id+'-'+post_id;
        
        if(!chatboxManager.existsInBoxList(box_id))
        {
            
        var discussion_input_url= discussion_input_base_url+receiver_id+'/'+post_id;
             
        var past_discussion_url= past_discussion_base_url + sender_id +'/'+receiver_id+'/'+post_id;
        
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

          
        };
        
        get_messages_between_two_users_about_article(
                inter_data,
                getMessagesBetweenTwoUsersAboutArticleCallback
                );
        }
        else
        {
        chatboxManager.addBox(box_id);   
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

                var current_user_id = $('#container').data('current-user-id').toString();
                var current_user_username = $('#container').data('current-user-username').toString();
                
                var title= {
                    title_interlocutor_picture_url:inter_data.title_interlocutor_picture_url,
                    title_interlocutor_post_main_image_url:inter_data.title_interlocutor_post_main_image_url,
                    title_interlocutor_user_name: inter_data.title_interlocutor_user_name
                }; // put here inter_data title infos
                
                chatboxManager.addBox(inter_data.box_id,
                                        inter_data.discussion_input_base_url,
                                        past_discussion,
                                        data, 
                                        {
                                            current_user_username:current_user_username, 
                                            current_user_id:current_user_id
                                        }, 
                                        title
                                      );
                              
                var current_user_id = $('#container').data('current-user-id');
                messages_seen_management(inter_data.receiver_id,current_user_id,inter_data.post_id);
                
        };
};
      

////////////////////////////////////////////////////////////////////////////
/// 1. Store chat message via ajax call, do nothing in success
//  in future do something in failure
////////////////////////////////////////////////////////////////////////////      
      
function store_chat_message_listener()
{
    $('body').on('submit','.message-form', function(){ 

      var url= $(this).attr('action');
      var data= $(this).serialize();

      $.ajax({
                type: "POST",
                url: url,
                data:data,
                cache: false
         });                 
         return false;       
        }); 
}


////////////////////////////////////////////////////////////////////////////
/// 1. Listen to SHOW INBOX click
/// 2. Show Inbox Callback
//  3. Bring messages of inbox via ajax before displaying them 
//  4. Bring Inbox callback
//  5. Hide the div when click outside callback
//  6. Call of the necessary function when document ready
//  
////////////////////////////////////////////////////////////////////////////


function show_inbox_listener(){
    $(".show_inbox_trigger").click(showInboxListener); 
}

var showInboxListener = function(e)
{
        var $inboxDialog = $('.inbox_dialog');
        e.preventDefault();
          
        if($inboxDialog.length === 0) {
                    var url= $(this).attr('data-url');
                    $.when(bring_inbox(url, bringInboxDialogCallback)).done(function(){
                    }
                ); 
        }
        else
        { 
            if($inboxDialog.is(":visible")) 
            { 
                $inboxDialog.hide(); 
                
            }
            else { 
                 
                $inboxDialog.show(); 
            }
        }
};


function bring_inbox(url, callback)
{
    $.ajax({
            type: "GET",
            url: url,
            cache: false,
            success: callback
            
        });    
        return false;  
}

function bringInboxDialogCallback(data)
{
     var $headerDialogs =  $('.header_dialogs');
     $headerDialogs.append(data);
     open_chat_listener();
     
}

var hideWhenVisible = function()
{

    $(document).mouseup(function (e)
    {
        var inboxDialogContainer = $('.inbox_dialog');
        var networkDialogContainer = $('.network_dialog');
        var $myMarketDialogContainer = $('.my_market_dialog');
        

        if (!inboxDialogContainer.is(e.target) // if the target of the click isn't the container...
            && inboxDialogContainer.has(e.target).length === 0 && !$('.show_inbox_trigger').is(e.target)) // ... nor a descendant of the container
        {
            inboxDialogContainer.hide();
            //$('.show_inbox_trigger').unbind( 'click',showInboxListener);
        }
        
        if (!networkDialogContainer.is(e.target) // if the target of the click isn't the container...
            && networkDialogContainer.has(e.target).length === 0 && !$('.show_network_trigger').is(e.target)) // ... nor a descendant of the container
        {
            networkDialogContainer.hide();
            
        }
        
        if (!$myMarketDialogContainer.is(e.target) // if the target of the click isn't the container...
            && $myMarketDialogContainer.has(e.target).length === 0 && !$('.show_my_market_trigger').is(e.target)) // ... nor a descendant of the container
        {
            $myMarketDialogContainer.hide();
            
        }
}); 
    
}

$(document).ready(function (e)
{
    show_inbox_listener();
    hideWhenVisible();
    store_chat_message_listener();
});



