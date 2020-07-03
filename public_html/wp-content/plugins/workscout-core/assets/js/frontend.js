  /* ----------------- Start Document ----------------- */
(function($){
"use strict";

$(document).ready(function(){ 
  // Contact Form Ajax

        $('#workscout-activities-list a.close-list-item').on('click',function(e) {
        var $this = $(this),
        id = $(this).data('id'),
        nonce = $(this).data('nonce');
       
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ws.ajaxurl,
            data: { 
                'action': 'remove_activity', 
                'id': id,
                'nonce': nonce
               },
            success: function(data){
              
                if (data.success == true){
                  $this.parent().addClass('wait').fadeOut( "normal", function() {
                    $this.remove();
                  });
                } else {
                                      
                }

            }
        });
        e.preventDefault();
    });

        $('#workscout-clear-activities').on('click',function(e) {
        var $this = $(this),
        nonce = $(this).data('nonce');
       
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ws.ajaxurl,
            data: { 
                'action': 'remove_all_activities', 
                'nonce': nonce
               },
            success: function(data){
              
                if (data.success == true){
                  $('ul#workscout-activities-list li:not(.cleared)').remove();
                  $('li.cleared').show();
                  $this.parent().parent().find('.pagination-container').remove();
                } else {
                                      
                }

            }
        });
        e.preventDefault();
    });

    $('#send-message-from-widget').on('submit',function(e) {
      $('#send-message-from-widget button').addClass('loading').prop('disabled', true);

       $.ajax({
            type: 'POST', dataType: 'json',
            url: ws.ajaxurl,
            data: { 
                'action': 'workscout_send_message', 
                'recipient' : $(this).find('textarea#contact-message').data('recipient'),
                'referral' : $(this).find('textarea#contact-message').data('referral'),
                'message' : $(this).find('textarea#contact-message').val(),
                //'nonce': nonce
               },
            success: function(data){
              
                if(data.type == "success") {

                  $('#send-message-from-widget button').removeClass('loading');
                  $('#send-message-from-widget .notification').show().html(data.message);
                  //window.setTimeout( closepopup, 3000 );
                  
                } else {
                    $('#send-message-from-widget .notification').removeClass('success').addClass('error').show().html(data.message);
                    $('#send-message-from-widget button').removeClass('loading').prop('disabled', false);
                }

            }
        });
        e.preventDefault();
    }); 

    function closepopup(){
      var magnificPopup = $.magnificPopup.instance; 
      if(magnificPopup) {
          magnificPopup.close();   
          $('#send-message-from-widget button').removeClass('loading').prop('disabled', false);
      }
    }  

    $('#send-message-from-chat').on('submit',function(e) {
      
      var message = $(this).find('textarea#contact-message').val();

      if(message){
        $(this).find('textarea#contact-message').removeClass('error');
        $('.loading').show();
        $(this).find('button').prop('disabled', true);
         $.ajax({
              type: 'POST', dataType: 'json',
              url: ws.ajaxurl,
              data: { 
                  'action': 'workscout_send_message_chat', 
                  'recipient' : $(this).find('input#recipient').val(),
                  'conversation_id' : $(this).find('input#conversation_id').val(),
                  'message' : message,
                  //'nonce': nonce
                 },
              success: function(data){
                
                  if(data.type == "success") {
                      $(this).addClass('success');                    
                      refreshMessages();
                      $('#send-message-from-chat textarea').val('');
                      $('#send-message-from-chat button').prop('disabled', false);
                  } else {
                      $(this).addClass('error')                    
                  }

              }
          });
       } else {
          $(this).find('textarea#contact-message').addClass('error');

       }
        e.preventDefault();
    }); 

    // $('#send-message-from-booking').on('submit',function(e) {
      
    //   var message = $(this).find('textarea#contact-message').val();

    //   if(message){
    //     $(this).find('textarea#contact-message').removeClass('error');
    //     $('.loading').show();
    //     $(this).find('button').prop('disabled', true);
    //      $.ajax({
    //           type: 'POST', dataType: 'json',
    //           url: workscout.ajaxurl,
    //           data: { 
    //               'action': 'workscout_send_message_chat', 
    //               'recipient' : $(this).find('input#recipient').val(),
    //               'conversation_id' : $(this).find('input#conversation_id').val(),
    //               'message' : message,
    //               //'nonce': nonce
    //              },
    //           success: function(data){
                
    //               if(data.type == "success") {
    //                   $(this).addClass('success');                    
    //                   refreshMessages();
    //                   $('#send-message-from-chat textarea').val('');
    //                   $('#send-message-from-chat button').prop('disabled', false);
    //               } else {
    //                   $(this).addClass('error')                    
    //               }

    //           }
    //       });
    //    } else {
    //       $(this).find('textarea#contact-message').addClass('error');

    //    }
    //     e.preventDefault();
    // });

    $(document).on('click', '.booking-message', function(e) {
      var recipient = $(this).data('recipient');
      var referral = $(this).data('booking_id');
    
      $('#send-message-from-widget textarea').data('referral',referral).data('recipient',recipient);
      
    
      $('.send-message-to-owner').trigger('click');
    });
    
    function refreshMessages(){
      if($('.message-bubbles').length){


        $.ajax({
            type: 'POST', dataType: 'json',
            url: ws.ajaxurl,
            data: { 
                'action': 'workscout_get_conversation', 
                'conversation_id' : $('#send-message-from-chat input#conversation_id').val(),
                //'nonce': nonce
               },
            success: function(data){
              
                if(data.type == "success") {
                    $('.message-bubbles').html(data.message);
                }
                $('.loading').hide();
             
            },
            complete: function() {
              setTimeout(refreshMessages, 4000);
            }
        });
 
      }
    }
    setTimeout(refreshMessages, 4000);

    function avatarSwitcher() {
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
     
                    reader.onload = function (e) {
                        $('.profile-pic').attr('src', e.target.result);
                    };
           
                    reader.readAsDataURL(input.files[0]);
                }
            };
           
            $(".workscout-avatar-form .file-upload").on('change', function(){
                readURL(this);
            });
           
            $(".workscout-avatar-form .upload-button").on('click', function() {
               $(".file-upload").click();
            });
        } avatarSwitcher();

// ------------------ End Document ------------------ //
});

})(this.jQuery);
/**/