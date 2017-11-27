
(function($) {
    $.widget("ui.chatterbox", {
        options: {
            id: null, //id for the DOM element
            title: null, // title of the chatbox
            user: null, // can be anything associated with this chatbox
            hidden: false,
            position: 60, // relative to right edge of the browser window
            width: 120, // width of the chatbox
            messageSent: function(c_user_n, msg) {
                // override this
                //this.boxManager.addMsg(c_user_n, msg);
            },
            messageReceived: function(source, msg) {
                //this.chatterBoxManager.addMsg(source, msg);
            },
            chatterBoxClosed: function(id) {
            }, // called when the close icon is clicked
            chatterBoxManager: {
                // thanks to the widget factory facility
                // similar to http://alexsexton.com/?p=51
                init: function(elem) {
                    this.elem = elem;
                },
                highlightBox: function() {
                    /*
                     var self = this;
                    self.elem.uiChatboxTitlebar.effect("highlight", {}, 300);
                    self.elem.uiChatbox.effect("bounce", {times: 3}, 300, function() {
                        self.highlightLock = false;
                        self._scrollToBottom();
                    });*/
                },
                toggleBox: function() {
                    //this.elem.uiChatbox.toggle();
                } 
            }
        },
        focusOnChatter: function(event) {
            $('.ui-chatbox').each(function(){
                $(this).hide();
            });
            $('#'+this.options.id).toggle();
            if ($('#'+this.options.id).is(":visible")) {
                $('#'+this.options.id).focus();
            }
        },
        widget: function() {
            return this.uiChatterBox;
        },
        _create: function() {
            var self = this,
            options = self.options,
            title = options.title || "No Title",
            // chatbox
            uiChatterBox = (self.uiChatterBox = self.element)
                .appendTo($('#chatters_container'))
                .addClass('ui-widget ' +
                          'ui-corner-top ' +
                          'ui-chatterbox'
                         )
                .attr('outline', 0)
                .focusin(function() {
                    // ui-state-highlight is not really helpful here
                    //self.uiChatbox.removeClass('ui-state-highlight');
                    self.uiChatterBoxTitlebar.addClass('ui-state-focus');
                })
                .focusout(function() {
                    self.uiChatterBoxTitlebar.removeClass('ui-state-focus');
                }),
            // titlebar
            uiChatterBoxTitlebar = (self.uiChatterBoxTitlebar = $('<div></div>'))
                .addClass('ui-widget-header ' +
                          'ui-corner-top ' +
                          'ui-chatterbox-titlebar ' +
                          'ui-dialog-header' // take advantage of dialog header style
                         )
                .appendTo(uiChatterBox),
            uiChatterBoxTitle = (self.uiChatterBoxTitle = $('<span></span>'))
                .html(title)
                .click(function(event) {

                    self.focusOnChatter(event);
                    return false;
                })
                .appendTo(uiChatterBoxTitlebar),

            uiChatterBoxTitlebarClose = (self.uiChatterBoxTitlebarClose = $('<a href="#"></a>'))
                .addClass('ui-corner-all ' +
                          'ui-chatbox-icon '
                         )
                .attr('role', 'button')
                .hover(function() { uiChatterBoxTitlebarClose.addClass('ui-state-hover'); },
                       function() { uiChatterBoxTitlebarClose.removeClass('ui-state-hover'); })
                .click(function(event) {
                    
                    uiChatterBox.remove();
                    
                    self.options.chatterBoxClosed(self.options.id);
                    return false;
                })
                .appendTo(uiChatterBoxTitlebar),
            uiChatboxTitlebarCloseText = $('<span></span>')
                .addClass('ui-icon ' +
                          'ui-icon-closethick')
                .text('close')
                .appendTo(uiChatterBoxTitlebarClose);
            
           
            self._setWidth(self.options.width);
            self._position(self.options.position);

            self.options.chatterBoxManager.init(self);

            if (!self.options.hidden) {
                uiChatterBox.show();
            }
        },
        _setOption: function(option, value) {
            
            if (value != null) {
                switch (option) {
                case "hidden":
                    if (value)
                        this.uiChatterBox.hide();
                    else
                        this.uiChatterBox.show();
                    break;
                case "position":
                    this._position(value);
                    break;
                case "width":
                    this._setWidth(value);
                    break;
                }
            }
            $.Widget.prototype._setOption.apply(this, arguments);
        },
        _setWidth: function(width) {
            
            this.uiChatterBoxTitlebar.width(width + "px");
          
        },
        _position: function(value) {
            this.uiChatterBox.css("bottom", value);
            
        }
    });
}(jQuery));
