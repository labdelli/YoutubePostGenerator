<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.4.1.js"></script>

<style>
    .hidden{
        display:none;
    }

    .result{
        max-width:80px; 
    }
#myProgress {
  width: 100%;
  background-color: grey;
  margin-top:100px;
}

#myBar {
  width: 1%;
  height: 30px;
  background-color: #17a2b8;
}
</style>
<script>


</script>

<div class="row">

    <div class="col"></div>

    <div class="col">

        <div class="card card-body">

            <!-- Form Wrapper & Button -->
            <button class="btn btn-sm btn-primary" id="add-test">CREATE CAMPAIGN</button>
            <div class="form-wrapper hidden">
                
                 <label for="campname" class="form-label">Campaign Name</label>
                <input type="text" class="form-control" id="campname">
                 <label for="channame" class="form-label">Channel Name</label>
                <select class="form-control" id="ChannelId">
                   
                </select>
                <label for="catname" class="form-label">Category Name</label>
 <select class="form-control" id="categoryid">
                   
                </select>
                <label class="form-label" for="qty">Post Quantity:</label>  
                
<input class ="" type="number" name="maxresult" id="qty" /> 

<button type="submit" class="addrowbtn btn btn-sm btn-info" id="create-test">PUSH</button>
<div id="myProgress">
  <div id="myBar"></div>
</div>
            </div>

            <!-- Data Table 
            <table id="createtest" class="table table-dark">
              <thead>
                <tr>
                    
                  <th scope="col">Channel ID</th>
                  <th scope="col">Campaign Name</th>
                  <th scope="col">Category ID</th>
                  <th scope="col">post_qty</th>
                </tr>
              </thead>
              <tbody id="tests-table">
                
              </tbody>
            </table>-->

        </div>

    </div>

    <div class="col"></div>
</div>


<script>
    
var channels = []

    
    $.ajax({
        method:'POST',
        url: ajaxurl,
       
        data: {
         action:'form_populate',
         
       
     },
        success:function(response){
            channels = response
        
         
         var chan=JSON.parse(channels)
         var options="";
          var optioncat="";
        for (var i=0;i<chan.length;i++){
        
             var channelname = chan[i].channel_name
             var channelid   = chan[i].yt_channel_id
             var catname     = chan[i].cat_name
             var catid       = chan[i].wp_category_id
             
        optioncat+="<option value='"+catid+"'>"+catname+"</option>";             
        options+="<option value='"+channelid+"'>"+channelname+"</option>";

      }       
        $("#ChannelId").html(options); 
        $("#categoryid").html(optioncat);   
        
        
      }       
        
      })



    $('#add-test').on('click', function(){
        $('.form-wrapper').removeClass('hidden')
      })





    var tests = []
    
    $.ajax({
        method:'POST',
        url: ajaxurl,
       
        data: {
         action:'set_form2',
         
        
       
    },
        success:function(response){
            tests = response
        
         
         var results=JSON.parse(tests)
        for (var i=0;i<results.length;i++){
             var id = results[i].id
             var campaign = results[i].campaign_name
             var postqty = results[i].post_qty
             var CatID = results[i].category_id
             addRow(results[i])
        }
            
           console.log(results)
            }
        
    })


             
    

    function addRow(obj){
        var row = `<tr scope="row" class="test-row-${obj.id}">
       <td id="result-${obj.id}" class="edito" data-testid="${obj.id}"">${obj.campaign_name}</>                 
    <td id="result-${obj.id}" data-testid="${obj.id}"">${obj.channel_id}</td>
   
    <td id="result-${obj.id}" data-testid="${obj.id}"">${obj.category_id}</td>
    <td id="result-${obj.id}" data-testid="${obj.id}"">${obj.post_qty}</td>
                      
                      <td>
                            <button class="btn btn-sm btn-danger" data-testid="${obj.id}" id="delete-${obj.id}">Delete</button>
                            <button class="btn btn-sm btn-info" disabled data-testid="${obj.id}"  id="save-${obj.id}">Save</button>
                            
                            <button class="btn btn-sm btn-danger hidden" data-testid="${obj.id}"  id="cancel-${obj.id}">Cancel</button>
                            <button class="btn btn-sm btn-primary hidden" data-testid="${obj.id}"  id="confirm-${obj.id}">Confirm</button>
                            
                       </td>
                   </tr>`
        $('#tests-table').append(row)

      
        
    }

   /* jQuery(document).ready(function($){*/
$('#create-test').on('click', function(e){
   e.preventDefault();
   var testid = $(this).data('testid')  
           var id = testid

   var campaign = $('#campname').val();
   var name = $('#ChannelId').val();
   var email = $('#categoryid').val();
   var message = $('#qty').val();
 alert(email);
 
 var i = 0;

 if (i == 0) {
    i = 1;
    var elem = document.getElementById("myBar");
    var width = 10;
    var id = setInterval(frame, 10);
    function frame() {
      if (width >= 100) {
        clearInterval(id);
        i = 0;
      } else {
        width++;
        elem.style.width = width + "%";
        elem.innerHTML = width  + "%";
      }
    }
  }

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
         id:id,
        
      },   success: function(data){
      
     },
   });   });  
       
 </script>