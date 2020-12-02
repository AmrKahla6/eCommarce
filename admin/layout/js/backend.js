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

     // Confirmation message in button
     $('.confirm').click(function()
     {
         return confirm('Are you sure ?');
     });

     // Category View Options
     $('.cat h3').click(function()
     {
         $(this).next('.full-view').fadeToggle(200);
     });

     $('.option span').click(function()
     {
         $(this).addClass('active').siblings('span').removeClass('active');

        if($(this).data('view') == 'full')
        {
            $('.cat .full-view').fadeIn(200);
        }
        else
        {
            $('.cat .full-view').fadeOut(200);
        }
     });
 });
