<div >
<div class="row" >
  <div class="col-md-2">
    </div>
  <div class="col-md-4">
    <div id="accordion">
      <div class="card">
        <div class="card-header">
          <a class="card-link" data-toggle="collapse" href="#collapseFour">
            <h5>Customer Details</h5>
          </a>
        </div>
      <div id="collapseFour" class="collapse show" data-parent="#accordion">
    <div class="card-body">
    <p> Name : <?php echo $address->firstname ?> <?php echo $address->lastname ?></p>
    
    <p> Email : <?php echo $address->email ?></p>
     <p> Contact : <?php echo $address->mobile ?></p>
     <a href="<?php echo base_url('welcome/order_history')?>" style="text-decoration: underline;">View order history</a>
  </div>
  
  </div>
    </div>
  </div>
</div>
<?php if($address->password!="null"){?>
<div class="col-md-4">
<div class="card">
  <div class="card-header">
    <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
      <h5>Change Password</h5>
    </a>
  </div>
  <?php if(!$this->session->userdata('is_logged_in')) { ?>
  <div id="collapseThree" class="collapse show" data-parent="#accordion">
    <div class="card-body">
      <form id="login-form" class="form" action="<?php echo base_url('welcome/change_password');?>" method="post">
      <div class="row">

        <div class="col-md-8">
          <div class="input-group">
            <input type="email" class="form-control" name="email" id="email" placeholder="Email" >
          </div>
        </div>

        <div class="col-md-8">
          <div class="input-group">
            <input type="password" class="form-control" name="current_pass" id="current_pass" placeholder="Current Password" >
          </div>
        </div>
        <div class="col-md-8">
          <div class="input-group">
            <input type="password" class="form-control" name="new_pass" id="new_pass" placeholder="New Password " >
          </div>
        </div>
     

        <div class="col-md-8">
          <div class="input-group">

            <input type="password" class="form-control" name="confirm_new_pass" id="confirm_new_pass" placeholder="Confirm New Password">
            <br>
            
          </div>
           <span id='message'></span>
        </div>
         <div class="col-md-8" id="otp">

          <div class="input-group"  >
           
            <input type="text" class="form-control" name="otp" placeholder="OTP" >
            <br/>
         
          </div>
             <label >OTP is sent to your email</label>
        </div>
      

      <div class="col-md-8" >
        <a  style="color: white;" class="btn btn-info btn-sm" id="update_password" >Get OTP</a>
       
        <input type="submit" name="Submit" value="Submit" class="btn btn-success btn-sm" id="submit" disabled>
      </div>
    </div>

   </form>
  </div>
  
</div>
<?php }else{ ?>
<div id="collapseThree" class="collapse show" data-parent="#accordion">
    <div class="card-body">
      <form id="login-form" class="form" action="<?php echo base_url('welcome/signedin_change_password');?>" method="post">
      <div class="row">

        <div class="col-md-8">
          <div class="input-group">
            <input type="password" class="form-control" name="current_pass" id="current_pass" placeholder="Current Password" >
          </div>
        </div>
        <div class="col-md-8">
          <div class="input-group">
            <input type="password" class="form-control" name="new_pass" id="new_pass" placeholder="New Password " >
          </div>
        </div>
      

        <div class="col-md-8">
          <div class="input-group">

            <input type="password" class="form-control" name="confirm_new_pass" id="confirm_new_pass" placeholder="Confirm New Password">
            <br>
            
          </div>
           <span id='message'></span>
        </div>
        
    

      <div class="col-md-8">
       
       
        <input type="submit" name="Submit" value="Submit" class="btn btn-success btn-sm" id="submit">
      </div>
    </div>

   </form>
  </div>
  
</div>

<?php }?>
</div>
</div>
   <?php } ?>
 </div>
<br/>

   
<div class="row">
  <div class="col-md-2">
    
  </div>

<div class="col-md-8">
   <div class="row">
  

<?php if(!empty($user_address)){ foreach($user_address as $row){ ?>
<div class="col-md-5">
<div class="card">
  <div class="card-header">
   <?php if($row->status==0) {?>
      Address
      <?php } else {?>
      Default Address
      <?php }  ?>
  </div>
  <div class="card-body"><?php echo $row->address1 ?>,<?php echo $row->address2 ?>,<?php echo $row->City ?>,<?php echo $row->pincode ?></div>
  <div class="row">
  <?php if($row->status==0) {?>
  
  <div class="col-md-6">
 &nbsp; &nbsp; &nbsp;<a href="<?php echo base_url('welcome/make_default_address/'.$row->id)?>" style="text-decoration:underline">Make Default </a> 
 
 </div>
 


 <?php } else {?>
   
      <?php }  ?>
      
  <div class="col-md-6">
  &nbsp; &nbsp; &nbsp;<a href="<?php echo base_url('welcome/delete_address/'.$row->id)?>" style="text-decoration:underline">Delete</a>
 </div>
 </div>
</div>
</div>
<?php  }} ?>

</div>
</div>
</div>
<br/>
<div class="row">
  
<div class="col-md-2">
    
  </div>
<div class="col-md-8">
    <div id="accordion">
         <?php if(!$this->session->userdata('is_logged_in')) { ?>

        <?php } else {?>
      <div class="card">
        <div class="card-header">
          <a class="card-link" data-toggle="collapse" href="#collapseOne">
            <h5>Add Address</h5>
          </a>
        </div>
     
        <div id="collapseOne" class="collapse show" data-parent="#accordion">
          <div class="card-body">
            <form id="login-form" class="form" action="<?php echo base_url('welcome/update_address');?>" method="post">

         
          
          <div class="row">

            <div class="col-md-6">
                <label>House / Flat name</label>
              <div class="input-group">
              
      
                  <input type="text" class="form-control"  id="building_name" name="building_name" placeholder="House name" >
          
              </div>
            </div>
            <div class="col-md-6">
              <label>Street address</label>
              <div class="input-group">
             
                  <input type="text" class="form-control"  id="street_address" name="street_address" placeholder="Street " >
                  
              </div>
            </div>
          </div>

          <div class="row">

            <div class="col-md-6">
              <label>City </label>
              <div class="input-group">
                
              
                <input type="text" class="form-control" name="City" placeholder="City">
                
              </div>
            </div>
            <div class="col-md-6">
              <label>Pincode </label>
                 
              <div class="input-group">

             
                <input type="text" class="form-control"  name="Pincode" placeholder="Pincode">
               
              </div>
            </div>
          </div>
          <br/>
          <div class="row">

            <div class="col-md-6">
              <!--<a  style="color: white;" class="btn btn-info btn-sm" id="update">Edit</a>-->
              <input type="submit" name="Submit" value="Submit" class="btn btn-success btn-sm"/>
         
            </div>

          </div>
               </form>
                </div>
    </div>
     </div>
    </div>
<?php }  ?>
<br>
<br>
<br>
<style type="text/css">

  @media only screen and (min-width: 700px){
     .row{
    width:100%;
}   
    }
.col-md-8{
  margin-top: 10px;
}
a{
  color: black;
  
}
a:hover{
  text-decoration: underline;
}
.accordion .card-header:after {
    font-family: 'FontAwesome';  
    content: "\f068";
    float: right; 
}
.accordion .card-header.collapsed:after {
    /* symbol for "collapsed" panels */
    content: "\f067"; 
}
#otp,#update_password{
  display: none;

}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
  $("#update").click(function(){
  $('#pincode').removeAttr("disabled");
   $('#building_name').removeAttr("disabled");
    $('#street_address').removeAttr("disabled");
     $('#city').removeAttr("disabled");

      
});
  


  $(' #confirm_new_pass').on('keyup', function () {
      if ($('#new_pass').val() == $('#confirm_new_pass').val()) {
        $('#message').html('Matching').css('color', 'green');
    } else 
    $('#message').html('Not Matching').css('color', 'red');
    
    $("#update_password").show();
});


$("#update_password").click(function(){

     var email =$('#email').val();
     var current_pass= $('#current_pass').val();
     var new_pass=$('#new_pass').val();
     var confirm_new_pass= $('#confirm_new_pass').val();
      
     $.ajax({
      url:"<?php echo base_url(); ?>welcome/update_password",
      method:"POST",
   
      data:{current_pass:current_pass, new_pass:new_pass},
      success:function(data)
      {
       //location.reload(true);
       $('#submit').removeAttr('disabled');
         $('#otp').show();
      }
    })

 });  
});
</script>