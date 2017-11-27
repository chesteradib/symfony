
if(!Array.indexOf){
    Array.prototype.indexOf = function(obj){
	for(var i=0; i<this.length; i++){
	    if(this[i]==obj){
	        return i;
	    }
	}
	return -1;
    }
}

var chatManager = function() {

    // list of all available boxes (a box can be 
    // visibile or not but its id in chatters list will always be available when in Boxlist)
    var boxList = new Array();
    // Currently showing box
    var showBox;
    // This list is normally the same at a given moment as boxList, but contains 'c_' prepended
    // It is for Chatters list
    var chatterBoxList = new Array();
    
    var config = {
	chatBoxWidth : 250,
        chatterBoxWidth: 120,
        messageReceived: function(post_id,source,source_c_n, msg)
        {
            $('#box'+source+'-'+post_id).chatbox('option', 'boxManager').addMsg(source_c_n, msg);
        }
    };

    var init = function(options) {
	$.extend(config, options)
    };
    
    // this boxClosedCallback is for chat box (when close 
    // button in the chatbox is clicked => chatbox toggled
    // both chatbox and chatterbox are in dom
    var boxClosedCallback = function(id) {
        //showBox= null;
    };
    
    // this boxClosedCallback is for chatter box (when close 
    // button in the chatter box is clicked => chatbox and chatterbox removed 
    // from dom => bottom positions for chatter boxes updated
    var chatterBoxClosedCallback = function(id)
    {   
        var idx = boxList.indexOf(id);
        var idy = chatterBoxList.indexOf('c_'+id);

        $("#" + id).chatbox("option","close", true);
	
        if(idy != -1) {
            chatterBoxList.splice(idy, 1);
	    for(var i = idy; i < chatterBoxList.length; i++) {
		$("#" + chatterBoxList[i]).chatterbox("option", "position", i * 60);
	    }
	}
	else {
	    alert("should not happen: " + id);
	}
        
        if(idx != -1) {
            boxList.splice(idx, 1);
	}
	else {
	    alert("should not happen: " + id);
	}  
    };
    
    var existsInChatterBoxList = function(idd){
        var id='c_'+idd;
        var idx = chatterBoxList.indexOf(id);
        
        if(idx!==-1) return true; else return false;
    };
    
    var getNextBottomPosition = function() {

	return 60 * chatterBoxList.length;
    };
    // Box already exists in chattersBoxList just need to be show in Box list and highlighted in Chattersboxlist
    var justShowBox = function(id){
        if(showBox){
            if(id=== showBox ) {
                // show box is exactly the box with id=id
            }
            else
            {
                // exists, but hidden
                // show it and put it back to showList
                var manager = $("#" + id).chatbox("option", "boxManager");
                manager.toggleBox();

                $("#" + showBox).chatbox("option","hidden", true);
                $("#" + id).chatbox("option","hidden", false);

                showBox = id;  
            }
        }
        else
        {

            $("#" + id).chatbox("option","hidden", false);
            showBox = id;  

        }
    };

    var addBox = function(id,url,past_discussion,discussion_input, user, titleFull, titleSmall) {
        
        $("#" + showBox).chatbox("option","hidden", true);

        var el = document.createElement('div');
        el.setAttribute('id', id);
        $(el).chatbox({id : id,
            url:url,
            past_discussion:past_discussion,
            discussion_input:discussion_input,
            user : user,
            title : titleFull,
            hidden : false,
            width : config.chatBoxWidth,
            messageReceived: messageReceivedCallback,
            boxClosed : boxClosedCallback,
           });
           
        // Chatters
        var el2 = document.createElement('div');
        el2.setAttribute('id', 'c_'+id);

        $(el2).chatterbox({id : id,
            user : user,
            title : titleSmall,
            hidden : false,
            width : config.chatterBoxWidth,
            position : getNextBottomPosition,
            chatterBoxClosed : chatterBoxClosedCallback,
           });
        
        $(el2).chatterbox("option", "offset", getNextBottomPosition());
        
        boxList.push(id);
        showBox = id;
        chatterBoxList.push('c_'+id);
    };

    var messageReceivedCallback = function(post_id,source,source_c_n, msg) {
	config.messageReceived(post_id,source,source_c_n, msg);
    }

    return {
	init : init,
	addBox : addBox,
        messageReceivedCallback : messageReceivedCallback,
        existsInChatterBoxList:existsInChatterBoxList,
        justShowBox:justShowBox
    };
}();