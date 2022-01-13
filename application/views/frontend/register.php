<div class="main-content">
    <div class="text">
      <h4>REGISTER</h4>
  </div>
  <div>
     <div class="row">
       <div class="col-md-2">
       </div>
       <div class="col-md-8">
  <p style="font-size: 12px;">"Welcome to Direct-Buy. 
Direct-Buy has unified login across all stores. This means any stores of Direct-Buy can be logged in with the same login that you register now.Direct-Buy commits to customer privacy and your data is safe and never shared."</p>
</div>
<div class="col-md-2">
       </div>
</div>
</div>
  <form action="<?php echo base_url('welcome/customer_register');?>" method="post" id="form">
      <div class="row">
       <div class="col-md-2">
       </div>
       <div class="col-md-4">
          <label></label>
          <input type="text" style="font-size:15px;"class="form-control" name="firstname" placeholder="First Name" required>
      </div>
      <div class="col-md-4">
          <label></label>
          <input type="text" style="font-size: 15px;" class="form-control" name="lastname" placeholder="Last Name" required>
      </div>
  </div>
  <div class="row">
   <div class="col-md-2">
   </div>
   <div class="col-md-4">
    <label></label>
    <input type="text" style="font-size: 15px;" class="form-control" name="email"  placeholder="Email" required>
</div>
<div class="col-md-4">
  <label></label>
  <input type="text" style="font-size: 15px;" class="form-control" name="mobile" placeholder="Phone Number" minlength="10" maxlength="10"  pattern="[1-9]{1}[0-9]{9}" required>
</div>

</div>
<div class="row">
   <div class="col-md-2">
   </div>
   <div class="col-md-4">
    <span style="font-size: 10px;">Minimum length(4 characters)</span>
    <input type="password" style="font-size: 15px;" id="password" class="form-control" name="password"  placeholder="Password" minlength="5" maxlength="16">
</div>
<div class="col-md-4">
  <label></label>
  <input type="password" style="font-size: 15px;" id="confirm_password" class="form-control" name="confirm_password" placeholder="Confirm password" minlength="5" maxlength="16">
  <span style="font-size: 10px;" id='message'></span>
</div>

</div>
<div class="row">
   <div class="col-md-2">
   </div>
   <div class="col-md-4">
     <div class="submit">
      <input type="submit" id="submit" class="btn btn-success" name="" value="Submit" disabled>
  </div>
</div>
</div>
</form>


</div>
<style type="text/css">
/*
.form-control{
    font-size: 25px;
}*/
.submit{
    margin-top: 20px;
}
.btn.btn-success{
    font-size: 17px;
}
.text{
    text-align: center;
    padding-top: 40px;
    padding-bottom: 40px;
}
.row{
  margin: 0px;
}
footer{
    margin-top: 215px;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">

  $(' #confirm_password').on('keyup', function () {
      if ($('#password').val() == $('#confirm_password').val()) {
        $('#message').html('Matching').css('color', 'green');
    } else 
    $('#message').html('Not Matching').css('color', 'red');
    
    $("#submit").removeAttr('disabled','disabled');
});

</script>