

jQuery(document).ready(function($){
$('form.ajax').on('submit', function(e){
   e.preventDefault();
   var that = $(this),
   url = that.attr('action'),
   type = that.attr('method');
   var campaign = $('#exampleFormControlInput0').val();
   var name = $('#exampleFormControlInput1').val();
   var email = $('#exampleFormControlInput2').val();
   var message = $('#exampleFormControlInput3').val();
   $.ajax({
      url: ajaxurl,
      type:"POST",
      dataType:'type',
      data: {
         action:'set_form4',
         campaign:campaign,
         name:name,
         email:email,
         message:message,
    },   success: function(response){
        $(".success_msg").css("display","block");
     }, error: function(data){
         $(".error_msg").css("display","block");      }
   });
$('.ajax')[0].reset();
  });
});

// Find and remove selected table rows

$(document).on('click','row_data',function(event) {
    event.preventDefault();
$(this).closest('div').attr('contenteditable','true');
$(this).addClass('bg.warning').css('padding','5px');
$(this).focus();   
 });
 

 $(document).ready(function() {
        $('.deleteRowButton').click(DeleteRow);
        $('.deleteRowButton').click(Dbdelete);
        $('.rowedit').click(addelement);      });





function DeleteRow()
    {
      $(this).parents('tr').first().remove();
       id = $(this).closest('tr').attr('id');
       alert (id);
     }
 function addelement()
    {
     $(this).first('td').replaceWith( "<input id='exampleFormControlInput0'type='text'></input>" );
     }
function Dbdelete()
    {
   
  id = $(this).closest('tr').attr('id');
   $.ajax({
      url: ajaxurl,
      type:"POST",
      dataType:'type',
      data: {
         action:'set_form',
         id:id,
      
    },
    }); 
     }
   
   
   
   
   
   
   

 
 
    
    
    