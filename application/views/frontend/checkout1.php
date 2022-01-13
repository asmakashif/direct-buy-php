  <?php if(!empty($payment)){foreach($payment as $row){ ?>
 
  <?php if($row->provider_type=='Razorpay'){ 
$txnid = rand(100000000000000,999999999999999);
$surl = $surl;
$furl = $furl;        
$key_id = $row->payment_api_key;
$currency_code = $currency_code;            
$total = ($totals->total* 100); 
$amount = $totals->total;
$merchant_order_id =$totals->id;
$card_holder_name = "abc";
$order_code=$totals->order_code;
$email = 'info@techarise.com';
$phone = "123456789";
$name = "e-mart";
$return_url = base_url().'frontend/payment_integrations/Razorpay/callback';
}} }?>
  <?php if(!empty($payment)){foreach($payment as $row){ ?>
<?php if($row->provider_type=='Paytm'){ 
$txnid = rand(100000000000000,999999999999999);
$merchant_order_id =$totals->id;
$card_holder_name = "abc";
$total = ($totals->total* 100); 
$amount = $totals->total;
}}}
$txnid = rand(100000000000000,999999999999999);
$merchant_order_id =$totals->id;
$card_holder_name = "abc";
$total = ($totals->total* 100); 
$amount = $totals->total;
?>

<div class="container"> 
  <div style="margin-top:20px">
    <br>

    <div class="row">
        <div class="col-md-1">
            </div>
      <div class="col-md-10">
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
              <h7 class="my-0" >Name : <?php echo $totals->c_fname ?>  <?php echo $totals->c_lname ?></h5>
            </div>

          </li>
          <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
              <h7 class="my-0" >Order Id : <?php echo $totals->order_code?></h7>
            </div>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-condensed">
              <?php if($cus_data->c_address1 !='null' || $cus_data->c_address2 !='null') { ?>
            <div id="all_addr">
              <h7 class="my-0">Delivery Address :</h7>
              <br/>
              <p class="text-muted" ><?php echo $cus_data->c_address1 ?>,<?php echo $cus_data->c_address2 ?>,<?php echo $cus_data->city ?>,<?php echo $cus_data->pincode ?></p>
          
              <a id="change" style="font-size:12px;text-decoration:underline">Change address</a> | <a style="font-size:12px;;text-decoration:underline" id="add">Add address</a>
            </div>
          
           
             
          
            <?php } else { ?>
          <div id="def_sel_addr">
                 <?php if(!empty($user_address)){ ?>
                     <form  action="<?php echo base_url('frontend/Checkout/updateSeletedAdrr/'.$totals->order_code); ?>" method="POST">
                         <div>
              <h7 class="my-0">Select Address :</h7> or <a style="font-size:12px;;text-decoration:underline" id="add">Add address</a>
              <br/>
              <?php  foreach($user_address as $row){ ?>
              <label ><input type="radio" name="address" value="<?php echo $row->id?>"><?php echo $row->address1 ?>,<?php echo $row->address2 ?>,<?php echo $row->City ?>,<?php echo $row->pincode ?></label>
              </div>
             
              <?php } ?>
           
              <div id="confrm">
               <div class="row">
                    <div class="col-md-8">
                        </div>
                <div class="col-md-3">
            <input type="submit" name="submit" value="Confirm Addres" class="btn btn-success btn-sm" >
            </div>
             </div>
             </div>
              </form>
              </div>
             <?php } else {?>
               <div>
              Add Address :
               
               <form id="login-form" class="form" action="<?php echo base_url('frontend/Checkout/add_address/'.$totals->order_code);?>" method="post">

         
          
          <div class="row">

            <div class="col-md-6">
                
              <div class="input-group">
              
      
                  <input type="text" class="form-control"  id="building_name" name="building_name" placeholder="Address 1" >
          
              </div>
            </div>
            <div class="col-md-6">
              
              <div class="input-group">
             
                  <input type="text" class="form-control"  id="street_address" name="street_address" placeholder="Address 2 " >
                  
              </div>
            </div>
          </div>
<br/>
          <div class="row">

            <div class="col-md-6">
       
              <div class="input-group">
                
              
                <input type="text" class="form-control" name="City" placeholder="City">
                
              </div>
            </div>
            <div class="col-md-6">
              
                 
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
                <div>
              <?php } ?>
          
             <?php } ?>
               <div id="select_addr">
                 <?php if(!empty($user_address)){ ?>
                     <form  action="<?php echo base_url('frontend/Checkout/updateSeletedAdrr/'.$totals->order_code); ?>" method="POST">
                         <div>
              <h7 class="my-0">Select Address :</h7>
              <br/>
              <?php  foreach($user_address as $row){ ?>
              <label class="text-muted"><input type="radio" name="address" value="<?php echo $row->id?>"> <?php echo $row->address1 ?>,<?php echo $row->address2 ?>,<?php echo $row->City ?>,<?php echo $row->pincode ?></label>
              </div>
              </form>
              <?php } ?>
               <a style="font-size:12px;;text-decoration:underline" id="add1">Add address</a>
              <?php } ?>
            </div>
            <div id="add_addr">
            Add Address :
               <form id="login-form" class="form" action="<?php echo base_url('frontend/Checkout/add_address/'.$totals->order_code);?>" method="post">

         
          
          <div class="row" >

            <div class="col-md-6">
                
              <div class="input-group">
              
      
                  <input type="text" class="form-control"  id="building_name" name="building_name" placeholder="Address 1" >
          
              </div>
            </div>
            <div class="col-md-6">
              
              <div class="input-group">
             
                  <input type="text" class="form-control"  id="street_address" name="street_address" placeholder="Address 2 " >
                  
              </div>
            </div>
          </div>
<br/>
          <div class="row">

            <div class="col-md-6">
       
              <div class="input-group">
                
              
                <input type="text" class="form-control" name="City" placeholder="City">
                
              </div>
            </div>
            <div class="col-md-6">
              
                 
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
                <div>
            <span class="text-muted"></span>
          </li>
          <?php if($cus_data->c_address1 !='null' || $cus_data->c_address2 !='null') { ?>
          <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
              <h7 class="my-0">To Pay</h7>
              <small class="text-muted"></small>
            </div>
            <h7 class="my-0">&#8377;<?php echo $totals->total ?></h7>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
              <h7 class="my-0">Pay Using</h7>
              <div class="row">
                  <?php if($default_method==1){?>
                  <?php if(!empty($payment)){foreach($payment as $row){ ?>
                  <!--<h1>Hi</h1>-->
                   <fieldset class="optionGroup">
                       
                      <label>
                        <input type="radio"  name="optradio" value="<?php echo $row->provider_type ?>"  checked><img style="width:15%; height:15%" src="<?php echo base_url().'assets/images/'.$row->payment_p_logo;?>"> </label>
                      </fieldset>
                  <?php } }} else{ ?>
                <?php if(!empty($payment)){foreach($payment as $row){ ?>
               
                 
                  <fieldset class="optionGroup">
                      
                            <?php if($row->default_payment==0) { ?>
                        <label><input type="radio"  name="optradio" value="<?php echo $row->provider_type ?>" ><img style="width:15%; height:15%" src="<?php echo base_url().'assets/images/'.$row->payment_p_logo;?>"></label>
                        <?php }  else {?>
                        <label> <input type="radio"  name="optradio" value="<?php echo $row->provider_type ?>"  checked><img style="width:15%; height:15%" src="<?php echo base_url().'assets/images/'.$row->payment_p_logo;?>"> </label>
                        <?php }} }?></label>
                      </fieldset>

                          
                         <!--<h1>Hi</h1>-->
                     <!--<fieldset class="optionGroup">-->
                        
                     <!-- <label>-->
                       
                     <!-- </fieldset>-->
                    
                    <?php } ?>
                  </div>
                </div>
              </li>
               </ul>
               <br/>
                <div id="CashOnDelivery">
                <form action="<?php echo base_url('frontend/Checkout/CashOnDelivery/'.$totals->order_code);?>" method="post">
                     <input type="hidden"  name="total" value="<?php echo $totals->total ?>">
                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-success btn-sm" >
                   <a class="btn btn-danger btn-sm" style="float: right;" href="<?php echo base_url('welcome/clear');?>" style="color:white;">Cancel </a>
              </form>
             </div>
            <div id="Paytm">
              <form action="<?php echo base_url('frontend/payment_integrations/Paytm/pgRedirect');?>" method="post">
                <input type="hidden" id="CUST_ID" name="CUST_ID" value="CUST001">
                <input type="hidden" id="INDUSTRY_TYPE_ID" name="INDUSTRY_TYPE_ID" value="Retail">
                <input type="hidden"  id="CHANNEL_ID" name="CHANNEL_ID" value="WEB">
                <input type="hidden" class="form-control" id="ORDER_ID" name="ORDER_ID"   value="<?php echo $totals->order_code ?>">
                <input type="hidden" class="form-control" name="TXN_AMOUNT" value="<?php echo $totals->total ?>" autocomplete="off" tabindex="5" 

                value="20">
                <input type="submit" name="submit" value="Confirm Order" class="btn btn-success btn-sm" >
                <a class="btn btn-danger btn-sm" style="float: right;" href="<?php echo base_url('welcome/clear');?>" style="color:white;">Cancel </a>
              </form>
            </div>
            <div id="Razorpay">
              <form name="razorpay-form" id="razorpay-form" action="<?php echo $return_url; ?>" method="POST">
                <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
                <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>"/>
                <!--<input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>"/>-->
                <!--  <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="<?php echo $productinfo; ?>"/> -->
                <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>"/>
                <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl; ?>"/>
                <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="<?php echo $card_holder_name; ?>"/>
                <input type="hidden" name="merchant_total" id="merchant_total" value="<?php echo $total; ?>"/>
                <input type="hidden" name="merchant_amount" id="merchant_amount" value="<?php echo $amount; ?>"/>
              </form>
              <input  id="submit-pay" type="submit" onclick="razorpaySubmit(this);" value="Confirm Order" class="btn btn-success btn-sm" />
              <a class="btn btn-danger btn-sm" style="float: right;" href="<?php echo base_url('welcome/clear');?>" style="color:white;">Cancel </a>
            </div>
            <?php } else {?>
            </br>
             <div>
                 <?php if(!empty($user_address)){ ?>
                 <input type="submit" name="submit" value="Confirm Address" class="btn btn-success btn-sm" >
                 <?php } ?>
                <a class="btn btn-danger btn-sm" style="float: right;" href="<?php echo base_url('welcome/clear');?>" style="color:white;">Cancel </a>
             </div>
             </form>
<?php } ?>
          </div>

          <div>

          </div>
        </div>  
        <br>
        <br>
      </div>
      <div class="col-md-1">
            </div>
    </div>
       

<style type="text/css">
#add1{
    display: none;
}
#select_addr{
    display:none;
}
#add_addr{
    display:none;
}
    .container {
/* 
background: #f6f6f6*/
}
td p{
  font-size: 15px;
  color: grey;
}
#Razorpay,#Paytm
{
  display: none;
}
label{
  margin-right: 10px;
}
input[type="radio"], input[type="checkbox"] {
  margin-right: 5px;
}
/*img{*/
/*    width:100%;*/
/*    height:100%;*/
/*}*/
a{
    cursor: pointer;
}
</style>
<script type="text/javascript">
  $(document).ready(function() {
     var radio=$('input[name="optradio"]:checked').val();
     if(radio == 'Razorpay') {
  $('#Razorpay').show(); 
  $('#Paytm').hide(); 
  $('#CashOnDelivery').hide();
}

else  if(radio == 'Paytm'){
  $('#Razorpay').hide();
  $('#Paytm').show();
  $('#CashOnDelivery').hide();
}

else  if(radio == 'CashOnDelivery'){
  $('#Razorpay').hide();
  $('#Paytm').hide(); 
  $('#CashOnDelivery').show();
}
    $('input[type="radio"]').click(function() {
      var radio=$('input[name="optradio"]:checked').val();

if(radio == 'Razorpay') {
  $('#Razorpay').show(); 
  $('#Paytm').hide(); 
 $('#CashOnDelivery').hide();
}

else  if(radio == 'Paytm'){
  $('#Razorpay').hide();
  $('#Paytm').show();  
   $('#CashOnDelivery').hide();
}
else  if(radio == 'CashOnDelivery'){
  $('#Razorpay').hide();
  $('#Paytm').hide(); 
  $('#CashOnDelivery').show();
}
});
  });
</script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>


<script>
  var razorpay_options = {
    key: "<?php echo $key_id; ?>",
    amount: "<?php echo $total; ?>",
    name: "<?php echo $name; ?>",
    description: "Order # <?php echo $merchant_order_id; ?>",
    netbanking: true,
    currency: "<?php echo $currency_code; ?>",
    prefill: {
      name:"<?php echo $card_holder_name; ?>",
      email: "<?php echo $email; ?>",
      contact: "<?php echo $phone; ?>"
    },
    notes: {
      soolegal_order_id: "<?php echo $merchant_order_id; ?>",
      txn_id: "<?php echo $txnid; ?>",
      order_code: "<?php echo $order_code; ?>",
      amount: "<?php echo $amount; ?>",
    },
    handler: function (transaction) {
      document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
      document.getElementById('razorpay-form').submit();
    },
    "modal": {
      "ondismiss": function(){
        location.reload()
      }
    }
  };
  var razorpay_submit_btn, razorpay_instance;

  function razorpaySubmit(el){
    if(typeof Razorpay == 'undefined'){
      setTimeout(razorpaySubmit, 200);
      if(!razorpay_submit_btn && el){
        razorpay_submit_btn = el;
        el.disabled = true;
        el.value = 'Please wait...';  
      }
    } else {
      if(!razorpay_instance){
        razorpay_instance = new Razorpay(razorpay_options);
        if(razorpay_submit_btn){
          razorpay_submit_btn.disabled = false;
          razorpay_submit_btn.value = "Pay Now";
        }
      }
      razorpay_instance.open();
    }
  }  
</script>
<script>
    $(document).ready(function(){
  $("#add").click(function(){
     $("#all_addr").hide();
     $("#select_addr").hide();
     $("#add_addr").show();
     $("#def_sel_addr").hide();
     $("confrm").hide();
  });
   $("#add1").click(function(){
     $("#all_addr").hide();
     $("#select_addr").hide();
     $("#add_addr").show();
      $("#def_sel_addr").hide();
      $("confrm").hide();
  });
   $("#change").click(function(){
     $("#all_addr").hide();
     $("#select_addr").show();
     $("#add1").show();
      $("#add_addr").hide();
        $("#def_sel_addr").hide();
     $("confrm").hide();
  });
});
</script>