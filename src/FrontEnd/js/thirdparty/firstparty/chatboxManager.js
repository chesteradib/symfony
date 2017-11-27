
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

var chatboxManager = function() {

    // list of all opened boxes
    var boxList = new Array();
    // list of boxes shown on the page
    var showList = new Array();
    // list of first names, for in-page demo
    var nameList = new Array();

    var config = {
	width : 200, //px
	gap : 20,
	maxBoxes : 5,
        messageReceived: function(post_id,source,source_c_n, msg)
        {
            $('#box'+source+'-'+post_id).chatbox('option', 'boxManager').addMsg(source_c_n, msg);
        }
    };

    var init = function(options) {
	$.extend(config, options)
    };


    var delBox = function(id) {
	// TODO
    };

    var getNextOffset = function() {
	return (config.width + config.gap) * showList.length;
    };

    var boxClosedCallback = function(id) {
	// close button in the titlebar is clicked
	var idx = showList.indexOf(id);
	if(idx != -1) {
	    showList.splice(idx, 1);
	    diff = config.width + config.gap;
	    for(var i = idx; i < showList.length; i++) {
		offset = $("#" + showList[i]).chatbox("option", "offset");
		$("#" + showList[i]).chatbox("option", "offset", offset - diff);
	    }
	}
	else {
	    alert("should not happen: " + id);
	}
    };
    
    var existsInBoxList = function(id){
        var idx2 = boxList.indexOf(id);
        if(idx2!=-1) return true; else return false;
    };

    // caller should guarantee the uniqueness of id
    var addBox = function(id,url,past_discussion,discussion_input, user, title) {
        
        var idx1 = showList.indexOf(id);
	var idx2 = boxList.indexOf(id);
	if(idx1 != -1) {

	    // found one in show box, do nothing
	}
	else if(idx2 != -1) {

	    // exists, but hidden
	    // show it and put it back to showList
	    $("#"+id).chatbox("option", "offset", getNextOffset());
	    var manager = $("#"+id).chatbox("option", "boxManager");
	    manager.toggleBox();
	    showList.push(id);
	}
	else{

	    var el = document.createElement('div');
	    el.setAttribute('id', id);
	    $(el).chatbox({id : id,
                           url:url,
                           past_discussion:past_discussion,
                           discussion_input:discussion_input,
			   user : user,
			   title : title,
			   hidden : false,
			   width : config.width,
			   offset : getNextOffset(),
                           messageReceived: messageReceivedCallback,
			   boxClosed : boxClosedCallback,
			  });
	    boxList.push(id);
	    showList.push(id);
	    nameList.push(user.current_user_username);
	}
    };

    var messageReceivedCallback = function(post_id,source,source_c_n, msg) {
	config.messageReceived(post_id,source,source_c_n, msg);
    }

    // not used in demo
    var dispatch = function(id, user, msg) {
	$("#" + id).chatbox("option", "boxManager").addMsg(user.first_name, msg);
    }

    return {
	init : init,
	addBox : addBox,
	delBox : delBox,
	dispatch : dispatch,
        messageReceivedCallback : messageReceivedCallback,
        existsInBoxList:existsInBoxList
    };
}();