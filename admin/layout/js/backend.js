 $(function(){
     'use strict';
     //Dashboard
     $('.toggle-info').click(function()
     {
         $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

         if($(this).hasClass('selected'))
         {
             $(this).html('<i class="fa fa-minus fa-lg"></i>');
         }
         else{
            $(this).html('<i class="fa fa-plus fa-lg"></i>');
         }
     })
     //Trigger The Selectboxit
     $("select").selectBoxIt({
         autoWidth : false,
          // Uses the jQueryUI theme for the drop down
          theme: "jqueryui",

         // Hides the first select box option from appearing when the drop down is opened
         showFirstOption: true,
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

     //Show Delete Button On Child Cats
     $('.child-link').hover(function ()
     {
        $(this).find('.show-delete').fadeIn(500);
     }, function()
     {
        $(this).find('.show-delete').fadeOut(300);
     });
 });
