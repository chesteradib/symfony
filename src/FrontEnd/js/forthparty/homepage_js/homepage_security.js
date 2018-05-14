(function(){
    
    var $ = jQuery;
    
    var SecurityManagement= (function(){
        function SecurityManagement(){   
            this.init();
        }
        
        SecurityManagement.prototype.init= function(){
            this.enable();
            this.start();  
        };
        
        SecurityManagement.prototype.enable= function(){       
            var self = this;
            
            this.$overlay= $('#lightboxOverlay');
            this.$security= $('#security');
            this.$login= $('#login');
            this.$register= $('#register');
            this.$securityHeader= $('#security_header');
            this.$securityFucker= $('#security_fucker');
            this.$targetProgress = $("#security_progress");
            
            
            this.$overlay.hide().on('click', function() {
                self.end();
                return false;
            });
     
            this.$security.hide().on('click', function(event) {
                if ($(event.target).attr('id') === 'security') {
                    self.end();
                }
                if ($(event.target).hasClass('login_trigger') ||$(event.target).hasClass('signup_trigger'))
                {
                    console.log('higigi');
                    if($(event.target).hasClass('login_trigger')) {
                        $('#login').show();
                        $('#register').hide();
                    }
                    if($(event.target).hasClass('signup_trigger')) {
                        $('#register').show();
                        $('#login').hide();
                    }
                }

                if($(event.target).attr('id') === 'register_button') {
                    event.preventDefault();
                    var formData = new FormData($('#register_form')[0]);
                    var url= $('#register_form').attr('action');
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType:false,
                        beforeSend: function(){
                            progress.firstProgress($('#register'),$("#security_progress"), 35);   
                        }, 
                        success: function(data){
                                $('#register').empty().append(data);
                                validation_errors_control_listener();
                            },
                        complete:function(){
                            progress.thirdProgress($('#register'),$("#security_progress"));   
                        } 
                    });    
                    return false;
                }
                if($(event.target).attr('id') === 'reset_request_button') {
                    event.preventDefault();
                    var formData = new FormData($('#reset_request_form')[0]);
                    var url= $('#reset_request_form').attr('action');
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType:false,
                        beforeSend: function(){
                            progress.firstProgress($('#login'),$("#security_progress"), 35);   
                        }, 
                        success: function(data){
                                $('#login').empty().append(data);
                                validation_errors_control_listener();
                            },
                        complete:function(){
                            progress.thirdProgress($('#login'),$("#security_progress"));   
                        } 
                    });    
                    return false;
                }
                if($(event.target).attr('id') === '_submit') {
                    $('#login_form').submit();
                }
                if($(event.target).attr('id') === 'login_trigger_in_passwordAlreadyRequested' || $(event.target).attr('id') === 'back_to_login') {
                    event.preventDefault();
                    var url= $('#content').attr('data-login-login-url');
                    //console.log(url);
                    $.ajax({
                        type: "GET",
                        url: url,
                        cache: false,
                        beforeSend: function(){
                            progress.firstProgress($('#login'),$("#security_progress"), 35);   
                        }, 
                    
                        success: function(data){
                                $('#login').empty().append(data);
                                validation_errors_control_listener();
                        },
                        complete:function(){
                            progress.thirdProgress($('#login'),$("#security_progress"));   
                        }  
                    });    
                    return false;
                }
                if($(event.target).attr('id') === 'forgot_trigger') {
                    event.preventDefault();
                    var url= $(event.target).attr('href');
                    console.log(url);
                    $.ajax({
                        type: "GET",
                        url: url,
                        cache: false,
                        beforeSend: function(){
                            progress.firstProgress($('#login'),$("#security_progress"), 35);   
                        }, 
                    
                        success: function(data){
                                $('#login').empty().append(data);
                                validation_errors_control_listener();
                        },
                        complete:function(){
                            progress.thirdProgress($('#login'),$("#security_progress"));   
                        }  
                    });    
                    return false;
                }
                if($(event.target).attr('id') === 'reset_reset_button') {
                    $('#reset_reset_form').submit();
                    
                }
                
            return false;
            });
            
            this.$security.find('#security_footer').on('click',function(){
                    self.end(); 
                    return false;
                });
            };

        SecurityManagement.prototype.start = function(){
                var self = this;
                
                
                $('body').on('click','.login_trigger, .signup_trigger',function(e){ 
                    self.sizeOverlay();
                    self.showOverlay();
                    self.showSecurity(e.target);
                    
                    return false;
                 });    
        };
        
        SecurityManagement.prototype.sizeOverlay = function() {
            this.$overlay
              .width($(window).width())
              .height($(document).height());
          };
          
        SecurityManagement.prototype.showOverlay = function() {
            this.$overlay.css({top: '0px'}).fadeIn(500);
              
          };
          
        SecurityManagement.prototype.showSecurity= function(f) {
            
            var self    = this;
            var $window = $(window);
            this.$security.fadeIn(500);
            
            //console.log($(f).attr('class'));
            
            if($(f).hasClass('login_trigger')) {

                this.$login.show();
                this.$register.hide();
                
            }
            if($(f).hasClass('signup_trigger') ){

                this.$register.show();
                this.$login.hide();
            }
            
            var top  = $window.scrollTop();
                    //+ this.options.positionFromTop;
            var left = $window.scrollLeft();
            this.$security.css({
              top: top + 'px',
              left: left + 'px'
            }).fadeIn(500);
          };
        
        SecurityManagement.prototype.end= function(){
            $(window).off("resize", this.sizeOverlay);
            this.$security.fadeOut(500);
            this.$overlay.css({top: 0}).fadeOut(500);
        };

        return SecurityManagement;
        
    })();
    
    $(function(){
        var security = new SecurityManagement();
        
        var $content= $('#content');
        $content.data('number-of-items-per-center',findNumberOfItemsPer('center',0));
        $content.data('number-of-items-per-left',findNumberOfItemsPer('left',6));

        var is_login_login = parseInt($('#content').attr('data-is-login-login'));
        console.log(is_login_login);

        if(is_login_login === 1) {
            console.log('hi login');
            $('.login_trigger')[0].click();
        }
        if(is_login_login === 0)
        {
            var url_all_jawla = $('#content').attr('data-url-all-jawla');
            show_all_jawla(url_all_jawla );
        }
        show_shop_listener();
        initialize_direction();
        direction_listener();
        search_listener();
        validation_errors_control_listener();
        
        
        });
}).call(this);


function show_all_new_posters(){
    
    var $target = $('#left');
    var $targetProgress= $('#left_progress');

    var all_new_posters_url = $('#content').attr('data-all-new-posters-url');
    var numberOfItemsPerLeft= $('#content').data('number-of-items-per-left');
    
    $.ajax({
            type: "POST",
            url: all_new_posters_url,
            cache: false,
            data: { items_per_page: numberOfItemsPerLeft},
            beforeSend: function(){
                progress.firstProgress($target,$targetProgress,85);
                }, 
            success: function(data){
                $target.css("visibility", "visible").empty().html(data);
                progress.secondProgress($targetProgress,95);
                show_shop_listener();
                final_next_previous_page_listenner('left','network');

                },
            complete: function(){

                progress.thirdProgress($target,$targetProgress);
                
                //var url_all_jawla = $('#content').attr('data-url-all-jawla');
                //show_all_jawla(url_all_jawla );
                }    
            });
} 

function validation_errors_control_listener()
{

    $('.error-message-close').on("click", function(){  
        $(this).parents().eq(1).hide();
    });
}