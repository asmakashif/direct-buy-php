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
                  <div>




                    <?php if($store_data->min_order_val<$totals->total){?>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                           
                         <?php if($totals->store_pickup==1) {?>
                            <input type="radio" name="one" class="form-check-input" id="one-variable-equations"  onclick="checkRadio(name)" checked="checked"><label>Store Pickup</label><br>
                             <?php } else {?> 
                              <input type="radio" name="one" class="form-check-input" id="one-variable-equations"  onclick="checkRadio(name)" ><label>Store Pickup</label><br>
                              <?php } ?>
                          
                        </label>
                        <div class="form-check-inline">
                          <label class="form-check-label">
                             <?php if($shop->home_delivery ==1){ ?>
                               <?php if($totals->store_pickup==0) {?>
                            <input type="radio" name="multiple" class="form-check-input" id="multiple-variable-equations" onclick="checkRadio(name)" checked="checked"><label>Home Delivery</label>
                            <?php } else {?> 
                            <input type="radio" name="multiple" class="form-check-input" id="multiple-variable-equations" onclick="checkRadio(name)" ><label>Home Delivery</label>
                            <?php } ?>
                            <?php } else { ?>
                            <input type="radio" name="multiple" class="form-check-input" id="multiple-variable-equations" onclick="checkRadio(name)" disabled><label>Home Delivery</label>
                            <?php } ?>
                          </div>
                        </div>
                      <?php } else if ($store_data->min_order_val>$totals->total) {?>
                        <div class="form-check-inline">
                          <label class="form-check-label">
                              
                            <input type="radio" name="one" class="form-check-input" id="one-variable-equations"  onclick="checkRadio(name)" checked="checked"><label>Store Pickup</label><br>
                            
                          </label>
                          <div class="form-check-inline">
                            <label class="form-check-label">
                               
                              <input type="radio" name="multiple" class="form-check-input" id="multiple-variable-equations" onclick="checkRadio(name)" disabled><label>Home Delivery</label>
                               
                            </div>
                          </div>
                        <?php } ?>
                      </div>
                    </li>
                    <div id="store_pickup">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                  <div>
                                  <h7 class="my-0">Order Type : Store Pickup</h7><br>
                                 
                                </div>
                                <h7 class="my-0"><?php echo $store_data->shop_address ?></h7>
                              </li>
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
                                            <?php } ?>
                                          </div>
                                        </div>
                                      </li>
                                      
                                       
                                     
                
                    </div>
                    <div id="home_delivery">
                      <?php if($cus_data->c_address1 =='null' || $cus_data->c_address2 =='null') { ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                          <div>
                            <a class="panel-title"  data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Add new address</a>
                            <div class="row">
                              <div class="col">
                                <div class="collapse multi-collapse" id="multiCollapseExample1">
                                  <div class="card card-body">
                                    <form  class="form" action="<?php echo base_url('frontend/Checkout/add_address/'.$totals->order_code);?>" method="post">
                                      <div class="row">
                                        <div class="col-md-6">
                                          <label></label>
                                          <input type="text" class="form-control"  id="building_name" name="building_name" placeholder="Flat no/House name" >
                                        </div>
                                        <div class="col-md-6">
                                          <label></label>
                                          <input type="text" class="form-control"  id="street_address" name="street_address" placeholder="Street Address" >
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                          <label></label>
                                          <input type="text" class="form-control" name="City" placeholder="City">
                                        </div>
                                        <div class="col-md-6">
                                          <label></label>
                                          <input type="text" class="form-control"  name="Pincode" placeholder="Pincode">
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
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>
                        <?php } ?>
                        <?php if($cus_data->c_address1 =='null' || $cus_data->c_address2 =='null') { ?>
                          <?php if(!empty($user_address)) {?>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                              <div>
                                <a  data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">Change address</a>
                                <div class="row">
                                  <div class="col">
                                    <div class="collapse multi-collapse" id="multiCollapseExample2">
                                      <div class="card card-body">
                                        <form  action="<?php echo base_url('frontend/Checkout/updateSeletedAdrr/'.$totals->order_code); ?>" method="POST">
                                          <div class="row">

                                            <?php  foreach($user_address as $row){ ?>
                                              <div class="col">
                                                <label ><input type="radio" name="address" value="<?php echo $row->id?>"><?php echo $row->address1 ?>,<?php echo $row->address2 ?>,<?php echo $row->City ?>,<?php echo $row->pincode ?></label>
                                              </div>
                                              <?php 
                                            } ?>
                                          </div>
                                          <br/>
                                          <input type="submit" name="Submit" value="Submit" class="btn btn-success btn-sm"/>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </li>
                          <?php  }?>
                        <?php } ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                          <?php if($cus_data->c_address1 !='null' || $cus_data->c_address2 !='null') { ?>
                            <div id="all_addr">
                              <h7 class="my-0">Delivery Address :</h7>
                              <br/>
                              <p class="text-muted" ><?php echo $cus_data->c_address1 ?>,<?php echo $cus_data->c_address2 ?>,<?php echo $cus_data->city ?>,<?php echo $cus_data->pincode ?></p>

                              <a style="font-size:12px" class="text-muted" data-toggle="collapse" href="#multiCollapseExample5" role="button" aria-expanded="false" aria-controls="multiCollapseExample5">Change address</a>
                              <div class="collapse multi-collapse" id="multiCollapseExample5">
                                <div class="card card-body">
                                  <form  action="<?php echo base_url('frontend/Checkout/updateSeletedAdrr/'.$totals->order_code); ?>" method="POST">
                                    <div class="row">

                                      <?php  foreach($user_address as $row){ ?>
                                        <div class="col">
                                          <label ><input type="radio" name="address" value="<?php echo $row->id?>"><?php echo $row->address1 ?>,<?php echo $row->address2 ?>,<?php echo $row->City ?>,<?php echo $row->pincode ?></label>
                                        </div>
                                        <?php 
                                      } ?>
                                    </div>
                                    <br/>
                                    <input type="submit" name="Submit" value="Submit" class="btn btn-success btn-sm"/>
                                  </form>
                                </div>
                              </div>
                            </div>
                          <?php } else { ?>
                            <?php if(!empty($user_address) ){ ?>
                              <div id="def_sel_addr">
                                <h7 class="my-0">Select Address :</h7>
                                <form  action="<?php echo base_url('frontend/Checkout/updateSeletedAdrr/'.$totals->order_code); ?>" method="POST">
                                  <div class="row">
                                    <?php  foreach($user_address as $row){ ?>
                                      <div class="col-md-6">
                                        <label class="text-muted" ><input type="radio" name="address" value="<?php echo $row->id?>"><?php echo $row->address1 ?>,<?php echo $row->address2 ?>,<?php echo $row->City ?>,<?php echo $row->pincode ?></label>
                                      </div>
                                    <?php } ?>
                                  </div>
                                  <input type="submit" name="Submit" value="Submit" class="btn btn-success btn-sm"/>
                                </form>
                              </div>
                            <?php }?>
                          <?php } ?>
                          <div id="add_addr">
                            Add Address :
                            <form id="login-form" class="form" action="<?php echo base_url('frontend/Checkout/add_address/'.$totals->order_code);?>" method="post">
                              <div class="row" >
                                <div class="col-md-6">
                                  <div class="input-group">
                                    <input type="text" class="form-control"  id="building_name" name="building_name" placeholder="Flat no/House name" >
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="input-group">
                                    <input type="text" class="form-control"  id="street_address" name="street_address" placeholder="Street Address" >
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
                                   <?php if(!empty($slots)){ ?>
                                   <div class="form-group">
                                       <p>Select Slot :</p>
                                        <select class="form-control" id="sel1" name="slot">
                                            <option>Select</option>
                                        <?php foreach($slots as $row) {?>   
                                      <option value="<?php echo $row->from_time ?>-<?php echo $row->to_time ?>"><?php echo $row->from_time ?>-<?php echo $row->to_time ?> </option>
                                      <?php }?>
                                      </select>
                                       </div>
                                   <?php }?>
                                   </li>
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
                                            <?php } ?>
                                          </div>
                                        </div>
                                      </li>
                                 <?php  } ?>
                    </div>
                     
                </ul>
                 <br>
                   
                 <div id="Gpay">
                                      <div id="inputSection">

                                        <form class="form-horizontal">
                                          <input class="form-control" type="hidden" id="amount" value="<?php echo $totals->total ?>">
                                          <input class="form-control" type="hidden" id="pa" value="arscnetworks@icici">
                                          <input class="form-control" type="hidden" id="pn" value="ARSC Networks">
                                          <input class="form-control" type="hidden" id="tn" value="test note">
                                          <input class="form-control" type="hidden" id="mc" value="5734">
                                          <input class="form-control" type="hidden" id="tid" value="TXNARSC12344">
                                          <input class="form-control" type="hidden" id="tr" value="TXNARSCTXNARSC12344">
                                          <input class="form-control" type="hidden" id="url" value="https://teztytreats.com/demo">
                                        </form>
                                        <button class="btn btn-success btn-sm" onclick="onBuyClicked()">Confirm Order</button>
                                        <a class="btn btn-danger btn-sm" style="float: right;" href="<?php echo base_url('welcome/clear');?>" style="color:white;">Cancel Order </a>
                                      </div>
                                      <div id="outputSection" style="display:none">
                                        <pre id="response"></pre>
                                      </div>
                                    </div>
                                    <div id="CashOnDelivery">
                                      <form action="<?php echo base_url('frontend/Checkout/CashOnDelivery/'.$totals->order_code);?>" method="post">
                                        <input type="hidden"  name="total" value="<?php echo $totals->total ?>">
                                        <input type="submit" name="submit" value="Confirm Order" class="btn btn-success btn-sm" >
                                        <a class="btn btn-danger btn-sm" style="float: right;" href="<?php echo base_url('welcome/clear');?>" style="color:white;">Cancel Order</a>
                                      </form>
                                    </div>
                                    <div id="Paytm">
                                      <form action="<?php echo base_url('frontend/payment_integrations/Paytm/pgRedirect/'.$totals->shopId);?>" method="post">
                                        <input type="hidden" id="CUST_ID" name="CUST_ID" value="<?php echo $totals->order_code ?>">
                                        <input type="hidden" id="INDUSTRY_TYPE_ID" name="INDUSTRY_TYPE_ID" value="Retail">
                                        <?php $order_code=$totals->order_code ?>
                                        <input type="hidden"  id="CHANNEL_ID" name="CHANNEL_ID" value="WEB"> <input type="hidden" class="form-control" id="ORDER_ID" name="ORDER_ID" size="20" maxlength="20" autocomplete="off" tabindex="1" value="<?php echo $totals->id ?>">
                                        <input type="hidden" class="form-control" id="TXN_AMOUNT" name="TXN_AMOUNT" autocomplete="off" tabindex="5" value="<?php echo $totals->total ?>">
                                        <input type="submit" name="submit" value="Confirm Order" class="btn btn-success btn-sm" >
                                        <a class="btn btn-danger btn-sm" style="float: right;" href="<?php echo base_url('welcome/clear');?>" style="color:white;">Cancel Order</a>
                                      </form>
                                    </div>
                                    <!--<div id="Razorpay">-->
                                    <!--  <form name="razorpay-form" id="razorpay-form" action="<?php echo $return_url; ?>" method="POST">-->
                                    <!--    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />-->
                                    <!--    <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>"/>-->
                                    <!--    <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>"/>-->
                                    <!--      <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="<?php echo $productinfo; ?>"/> -->
                                    <!--    <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>"/>-->
                                    <!--    <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl; ?>"/>-->
                                    <!--    <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="<?php echo $card_holder_name; ?>"/>-->
                                    <!--    <input type="hidden" name="merchant_total" id="merchant_total" value="<?php echo $total; ?>"/>-->
                                    <!--    <input type="hidden" name="merchant_amount" id="merchant_amount" value="<?php echo $amount; ?>"/>-->
                                    <!--  </form>-->
                                    <!--  <input  id="submit-pay" type="submit" onclick="razorpaySubmit(this);" value="Confirm Order" class="btn btn-success btn-sm" />-->
                                    <!--  <a class="btn btn-danger btn-sm" style="float: right;" href="<?php echo base_url('welcome/clear');?>" style="color:white;">Cancel Order</a>-->
                                    <!--</div> -->
                                     <br> 
                                     <br>
                    
 </div>
  </div>
   </div>
   <br>
   <br> 
                                     <br>
   </div>
                          <style type="text/css">
                          #store_pickup,#home_delivery{
                            display: none;  
                          }
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
#Razorpay,#Paytm,#Gpay,#CashOnDelivery
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
    color:black;
  }
  .panel-title:after {
    font-family: FontAwesome;
    content: "\f107";
    float: right;
    color: grey;
    margin-left:10px;
    font-size:20px;
  }
  .panel-title[aria-expanded="true"]:after {
    content: "\f106";
  }
</style>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">
<script src="<?php echo base_url('assets1/js/demo.js');?>"></script>
<script>
    $(document).ready(function () {
       $('.radio').click(function () {
           document.getElementById('price').innerHTML = $(this).val();
       });

   });
</script>
<script>
    $("#sel1").on("change",function(){
    //Getting Value
    var selValue = $("#sel1").val();
        if(selValue != '')
                    {
                        $.ajax({
                            url:"<?php echo base_url();?>frontend/Checkout/update_slots/<?php echo $totals->order_code?>",
                            method:"POST",
                            data:{selValue:selValue},
                            success:function(data)
                            {   
                               alert('suceess');


                            }

                        });


                    }
  
});
</script>
<script type="text/javascript">

  $(document).ready(function() {
 var ordertype=$("input[type=radio][name=one]:checked").val();
 var ordertypem=$("input[type=radio][name=multiple]:checked").val();
 if(ordertypem=='on'){
   $('#store_pickup').hide();
      $('#home_delivery').show();  
 }
 else
 {
      $('#store_pickup').show();
      $('#home_delivery').hide();  
 }
    var radio=$('input[name="optradio"]:checked').val();
    if(radio == 'Razorpay') {
      $('#Razorpay').show(); 
      $('#Paytm').hide(); 
      $('#CashOnDelivery').hide();
      $('#Gpay').hide();
    }
    else  if(radio == 'Paytm'){
      $('#Razorpay').hide();
      $('#Paytm').show();
      $('#CashOnDelivery').hide();
      $('#Gpay').hide();
    }
    else  if(radio == 'CashOnDelivery'){
      $('#Razorpay').hide();
      $('#Paytm').hide(); 
      $('#CashOnDelivery').show();
      $('#Gpay').hide();
    }
    else if(radio =='GooglePay')
    {
      $('#Razorpay').hide();
      $('#Paytm').hide(); 
      $('#CashOnDelivery').hide();
      $('#Gpay').show();
    }
    $('input[type="radio"]').click(function() {
      var radio=$('input[name="optradio"]:checked').val();

      if(radio == 'Razorpay') {
        $('#Razorpay').show(); 
        $('#Paytm').hide(); 
        $('#CashOnDelivery').hide();
        $('#Gpay').hide();
      }

      else  if(radio == 'Paytm'){
        $('#Razorpay').hide();
        $('#Paytm').show();  
        $('#CashOnDelivery').hide();
        $('#Gpay').hide();
      }
      else  if(radio == 'CashOnDelivery'){
        $('#Razorpay').hide();
        $('#Paytm').hide(); 
        $('#CashOnDelivery').show();
        $('#Gpay').hide();
      }
      else if(radio =='GooglePay')
      {
        $('#Razorpay').hide();
        $('#Paytm').hide(); 
        $('#CashOnDelivery').hide();
        $('#Gpay').show();
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
  function checkRadio(name) {
      
    if(name == "one"){

      $('#store_pickup').show();
      $('#home_delivery').hide();
      document.getElementById("one-variable-equations").checked = true;
      document.getElementById("multiple-variable-equations").checked = false;
      
        if(name != '')
                    {
                        $.ajax({
                            url:"<?php echo base_url();?>frontend/Checkout/update_store_pickup/<?php echo $totals->order_code?>",
                            method:"POST",
                            data:{},
                            success:function(data)
                            {   
                               console.log('suceess');


                            }

                        });


                    }

    } else if (name == "multiple"){
      $('#store_pickup').hide();
      $('#home_delivery').show();
      document.getElementById("multiple-variable-equations").checked = true;
      document.getElementById("one-variable-equations").checked = false;
       if(name != '')
                    {
                        $.ajax({
                            url:"<?php echo base_url();?>frontend/Checkout/update_home_delivery/<?php echo $totals->order_code?>",
                            method:"POST",
                            data:{},
                            success:function(data)
                            {   
                               console.log('suceess');


                            }

                        });


                    }

    }
  }
</script>
<script>
  $(document).ready(function(){
    var radio = $("input[name='one']:checked").val();

    if(radio =='on')
    {
      $('#store_pickup').show();
      $('#home_delivery').hide();
      document.getElementById("one-variable-equations").checked = true;
      document.getElementById("multiple-variable-equations").checked = false;
    }

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