	/* ----------------- Start Document ----------------- */
(function($){
"use strict";

$(document).ready(function(){ 
    
    // Perform AJAX login on form submit
    $('#login-dialog form#workscout_login_form').on('submit', function(e){
        var redirecturl = $('input[name=_wp_http_referer]').val();
        var success;
        $('form#workscout_login_form .notification.reg-form-output').removeClass('error').addClass('notice').show().text(workscout_core.loadingmessage);
        
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: workscout_core.ajax_url,
                data: { 
                    'action': 'workscoutajaxlogin', 
                    'username': $('form#workscout_login_form #workscout_user_login').val(), 
                    'password': $('form#workscout_login_form #workscout_user_pass').val(), 
                    'login_security': $('form#workscout_login_form #login_security').val()
                   },
             
                }).done( function( data ) {
                    if (data.loggedin == true){
                        $('form#workscout_login_form .notification.reg-form-output').show().removeClass('error').removeClass('notice').addClass('success').text(data.message);

                        //document.location.href = redirecturl;
                        success = true;
                    } else {
                        $('form#workscout_login_form .notification.reg-form-output').show().addClass('error').removeClass('notice').removeClass('success').text(data.message);
                    }
            } )
            .fail( function( reason ) {
                // Handles errors only
                console.debug( 'reason'+reason );
            } )
            
            .then( function( data, textStatus, response ) {
                if(success){
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: workscout_core.ajax_url,
                        data: { 
                            'action': 'get_logged_header', 
                        },
                        success: function(new_data){
                            
                            $('body').removeClass('user_not_logged_in');                        
                            $('.header-widget').html(new_data.data.output);
                            var magnificPopup = $.magnificPopup.instance; 
                            if(magnificPopup) {
                                magnificPopup.close();  
                                header_menu(); 
                            }

                        }
                    });
             
                }
                
             
                // In case your working with a deferred.promise, use this method
                // Again, you'll have to manually separates success/error
            }) 
        e.preventDefault();
    });
    
    if(workscout_core.recaptcha_status){
        if(workscout_core.recaptcha_version == 'v3'){
            getRecaptcha();        
        }
    }
    
    // Perform AJAX login on form submit
    $('#signup-dialog form#register').on('submit', function(e){

  		$('form#register .notification.reg-form-output').removeClass('error').addClass('notice').show().text(workscout_login.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: workscout_core.ajax_url,
            data: { 
                'action': 'workscoutajaxregister', 
                'role': $('form#register .account-type-radio:checked').val(), 
                'username': $('form#register #workscout_user_login').val(), 
                'email':    $('form#register #workscout_user_email').val(), 
                'password': $('form#register #reg_password').val(), 
                'first-name': $('form#register #first-name').val(), 
                'last-name': $('form#register #last-name').val(), 
                'privacy_policy': $('form#register #privacy_policy:checked').val(), 
                'register_security': $('form#register #register_security').val(),
                'g-recaptcha-response': $('form#register #g-recaptcha-response').val(),
                'token': $('form#register #token').val(),
                'g-recaptcha-action': $('form#register #action').val()
               },
            success: function(data){
                if (data.registered == true){
				    $('form#register .notification.reg-form-output').show().removeClass('error').removeClass('notice').addClass('success').html(data.message);
				    // $( 'body, html' ).animate({
        //                 scrollTop: $('#sign-in-dialog').offset().top
        //             }, 600 );
                    $('#register').find('input:text').val(''); 
                    $('#register input:checkbox').removeAttr('checked');
                    if(workscout_core.autologin){
                        setTimeout(function(){
                            window.location.reload(); // you can pass true to reload function to ignore the client cache and reload from the server
                        },2000);    
                    }
                  
                    

				} else {
					$('form#register .notification.reg-form-output').show().addClass('error').removeClass('notice').removeClass('success').html(data.message);
                    
                    if(workscout_core.recaptcha_status){
                        if(workscout_core.recaptcha_version == 'v3'){
                            getRecaptcha();        
                        }
                    }
                    
                    // $( 'body, html' ).animate({
                    //     scrollTop: $('#sign-in-dialog').offset().top
                    // }, 600 );
				}

            }
        });
        e.preventDefault();
    });

   

// ------------------ End Document ------------------ //
});

})(this.jQuery);