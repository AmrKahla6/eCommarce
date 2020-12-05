 $(function(){
     'use strict';

     //Switch Between Login & Signup
     $('.login-page h1 span').click(function()
     {
         $(this).addClass('selected').siblings().removeClass('selected');

         $('.login-page form').hide();

         $("#formButton").click(function(){
            $("#form1").fadeIn(100);
        });

        $("#formButton2").click(function(){
            $("#form2").fadeIn(100);
        });
     })

     //Trigger The Selectboxit
     $("select").selectBoxIt({
         autoWidth : false,
          // Uses the jQueryUI theme for the drop down
          theme: "jqueryui",

         // Hides the first select box option from appearing when the drop down is opened
         showFirstOption: false,
         // Hides the currently selected option from appearing when the drop down is opened
         hideCurrent: true
     });
     //Hide placeholder on form focas
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
 });
