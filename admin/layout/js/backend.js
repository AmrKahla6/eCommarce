/**
 * Hide placeholder on form focas
 */

 $(function(){
     'use strict';
     $('[placeholder]').focus(function(){
         $(this).attr('data-text' , $(this).attr('placeholder'));
         $(this).attr('placeholder' , '');
     }).blur(function(){
         $(this).attr('placeholder' , $(this).attr('data-text'));
     });

     // Add Astersk * on required field
     $('input').each(function() {
         if($(this).attr('required') === 'required')
         {
             $(this).after('<span class="asterisk">*</span>');
         }
     });

     // Convert Password field to text field
     var passField = $('.password');
     $('.show-pass').hover(function() {
          passField.attr('type' , 'text');
     },function(){
        passField.attr('type' , 'password');
     });
 });
