<!-- Header Layout Content -->
<div class="mdk-header-layout__content">
   <div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
      <div class="mdk-drawer-layout__content page ">
         <div class="container-fluid page__container">
            <h1 class="h2">Add Payment Gateway to Store</h1>
            <div class="card">
               <div class="card-body">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="table-responsive border-bottom" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>
                           <form action="<?php echo base_url('backend/PaymentController/savePaymentSetting/'. $fetchdatabyid->shopId);?>" method="post">
                              <ul>
                                
                                 <div class="row">
                                    <?php foreach($paymentData as $row) {?>
                                       <div class="col-md-4">
                                          <li class="list-group-item">
                                             <div class="media align-items-center">
                                                <div class="media-left">
                                                   <span class="btn btn-default btn-circle"><i class="material-icons">credit_card</i></span>
                                                </div>
                                                <div class="media-body">
                                                   <p class="mb-0"><?php echo $row->payment_name?></p>
                                                </div>

                                                <input  type="hidden" id="shopId" value="<?php echo $fetchdatabyid->shopId;?>" name="shopId" >

                                                <input type="hidden" class="payment_id" name="provider_type[]" multiple id="<?=$row->provider_type?>" value="<?php echo $row->provider_type; ?>" >
                                             
                                                <?php if(empty($row->pInfo_payment_name)) {?>
                                                   <input type="checkbox" class="payment_id" name="payment_id[]" id="<?=$row->payment_id?>" value="<?php echo $row->payment_name; ?>">
                                                <?php } else {?>
                                                    <!-- <input type="checkbox" class="payment_id" name="payment_id[]" id="<?=$row->payment_id?>" value="<?php echo $row->payment_name; ?>"> -->
                                                  <input type="checkbox" class="payment_id" name="payment_id[]" id="<?=$row->payment_id?>" value="<?php echo $row->payment_name; ?>"<?php if($row->payment_name == $row->pInfo_payment_name){echo'checked';} ?> >
                                                <?php }?>
                                             </div>
                                          </li>
                                       </div>
                                    <?php }?>   
                                 </div>
                              </ul>
                              <input type="submit" class="btn btn-success" name="submit" id="checkBtn" value="submit">
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php $this->load->view('backend/include/sidebar')?>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script>
            window.onunload = function(){
                window.opener.location.reload();
            };
            $('#checkBtn').click(function() {
                checked = $("input[type=checkbox]:checked").length;

                if(!checked) {
                    alert("You must check at least one checkbox.");
                    return false;
                }

            });
      </script>   