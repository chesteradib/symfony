var mobile_chat= (function($){
    

var uiChatboxLog = $('.ui-chatbox-log');
var uiChatboxTitlebar = $('.ui-chatbox-titlebar');
var uiChatboxContent = $('.ui-chatbox-content');
var uiChatboxInput = $('.ui-chatbox-input');

var init = function()
{
    var value = $('#mobile_discussion_container').width();
    console.log(value);
    uiChatboxTitlebar.width(value);
    uiChatboxContent.width(value);
    uiChatboxLog.width(value);
    uiChatboxInput.width(value);
    _scrollToBottom();
}
///////////////////////////////////////////////////////////////////////////
// Message Sent 
////////////////////////////////////////////////////////////////////////////      
  
    var addMsg = function(peer, msg) {
        var self = this;
        //var box = self.uiChatboxLog;
        //console.log(uiChatboxLog);
        var e = document.createElement('div');
       uiChatboxLog.append(e);
        $(e).hide();

        var systemMessage = false;

        if (peer) {
            var peerName = document.createElement("b");
            $(peerName).text(peer + ": ");
            e.appendChild(peerName);
        } else {
            systemMessage = true;
        }

        var msgElement = document.createElement(
            systemMessage ? "i" : "span");
        $(msgElement).text(msg);
        e.appendChild(msgElement);
        $(e).addClass("ui-chatbox-msg");
        $(e).css("maxWidth", uiChatboxLog.width());
        $(e).fadeIn();
        _scrollToBottom();

        if (!uiChatboxTitlebar.hasClass("ui-state-focus")
            && !self.highlightLock) {
            self.highlightLock = true;
        }
    };

    var _scrollToBottom = function() {
            uiChatboxContent.scrollTop(uiChatboxContent.get(0).scrollHeight);
        };
        
        
    var update_after_realtime = function (data)
    {
        console.log(data);
        switch(data.type)
        {
            case 'my_inbox':
                message_received(data);
                message_seen_management(data);
                break;     
            case 'my_followers':
                break;  
            case 'my_market':
                break;  
            default:
                break;
            }            
    }
    
    
    var message_received= function (data)
    {

       addMsg(data.sender_username, data.message_content);

    }

    var message_seen_management = function(data)
    {
        var message_seen_base_url=$('#mobile_discussion_container').data('message-seen-base-url');

        $.ajax({
            type: "POST",
            url: message_seen_base_url,
            data: {message_id:data.message_id},
            cache: false,
        });    
        return false;
    }
    var messages_seen_management= function(sender_id,post_id)
    {

        var messages_seen_base_url=$('#mobile_discussion_container').data('messages-seen-base-url');
        
        $.ajax({
            type: "POST",
            url: messages_seen_base_url,
            data: {sender_id:sender_id, post_id:post_id},
            cache: false
        });    
        return false;


}
///////////////////////////////////////////////////////////////////////////
/// 1. Store chat message via ajax call, do nothing in success
//  Print "Not connected" if failure
////////////////////////////////////////////////////////////////////////////      
      
var store_chat_message_listener= function(current_user_username){

    $('.message-form textarea').keydown(function(event){
            if (event.keyCode && event.keyCode == $.ui.keyCode.ENTER) {
                console.log('keydown ok');
                msg = $.trim($(this).val());
                if (msg.length > 0) {

                    addMsg(current_user_username, msg);

                    var $concerned_form=  $(this).parents().eq(1);

                    var url= $concerned_form.attr('action');
                    var data=$concerned_form.serialize();

                    $.ajax({
                       type: "POST",
                       url: url,
                       data: data,
                       cache: false,
                       success: function(data){
                            if(!data.status) 
                            addMsg(null, data.message);
                       }
                    });                 
                }
                $(this).val('');
                return false;
            }
        })
        .focusin(function() {
            
            $(this).addClass('ui-chatbox-input-focus');
            //var box = $(this).parent().parent().parent().prev();
           // box.scrollTop(box.get(0).scrollHeight);
        })
        .focusout(function() {
            
            $(this).removeClass('ui-chatbox-input-focus');
        });
    };
    
    
    return {
        init:init,
        store_chat_message_listener :store_chat_message_listener,
        update_after_realtime : update_after_realtime,
        messages_seen_management :messages_seen_management
    };
})(jQuery);



$(function(){
    
    var $container= $('#mobile_discussion_container');
    var current_user_id = $container.data('current-user-id').toString();
    var current_user_username = $container.data('current-user-username').toString();
    var current_post_id = $container.data('current-post-id').toString();
    var current_sender_id= $container.data('current-sender-id').toString();
    
    var ip= $('#mobile_discussion_container').data('ws-ip').toString();
    console.log(ip);
    var conn = new ab.Session('ws://'+ip+':8080',
        function() { 
            conn.subscribe(current_user_id, function(topic, data) {
                console.warn('Connection Established');
                mobile_chat.update_after_realtime(data);
            });
        },
        function() {
            console.warn('WebSocket connection closed');
        },
        {'skipSubprotocolCheck': true}
    );
    mobile_chat.messages_seen_management(current_sender_id,current_post_id);
    mobile_chat.store_chat_message_listener(current_user_username);
    mobile_chat.init();
});