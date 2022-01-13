<!-- Header Layout Content -->

<div class="mdk-header-layout__content">
	<div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
		<div class="mdk-drawer-layout__content page ">
			<div class="container-fluid page__container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url('backend/MyShopController/index')?>">Home</a></li>
					<li class="breadcrumb-item active">Add Payment Method</li>
				</ol>
				<h1 class="h2">Add Payment Method</h1>
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<form action="<?php echo base_url('backend/PaymentController/savePaymentDetails');?>" method="post"> 
								<!-- <form  method="post" id="shopDetails">  -->
                                    <div class="row">
                                    	<div class="col-md-4">
                                        	<label for="payment_option"><b>Provider Type</b></label>
                                            <select type="text" class="form-control" name="provider_type" id="provider_type" onchange='CheckProvider(this.value);' required="">
                                            	<option value="">Select Provider Type</option>
                                                <?php foreach($paymentProvider as $row) {
                                                    echo '<option value="'.$row->payment_p_name.'">'.$row->payment_p_name.'</option>';
                                                } ?>
                                            </select>
                                            <!--<input type="text" name="shopDbName" value="<?php echo $shopDBName->shop_db_name;?>">-->
                                        </div>
                                        <div class="col-md-8" style="margin-top:35px;">
                                            <i class="fad fa-question-circle"></i>&nbsp;
                                            <span><b>Select payment mode for customer to make the payment through</b></span>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                        	<label for="payment_name"><b>Payment Method Name</b></label>
                                            <input type="text" class="form-control" name="payment_name" id="payment_name" placeholder="Enter Payment Method Name" required="">
                                        </div>
                                        <div class="col-md-8" style="margin-top:35px;">
                                            <i class="fad fa-question-circle"></i>&nbsp;
                                            <span><b>Enter payment name </b></span>
                                        </div>
                                    </div>
                                    <br>
                                    <div id="razorpay" style="display: none">
                                        <div class="row">
                                        	<div class="col-md-4">
                                                <label for="payment_api_key"><b>Payment API Key</b></label>
                                                <input type="text" class="form-control" name="payment_api_key" id="payment_api_key" placeholder="Enter API Key">
                                                <br>
                                                <span style="color:red;">NOTE:</span>&nbsp;<span><b>Know how to generate API key </b><a href="<?php echo base_url('backend/PaymentController/viewPaymentDocumentation/razorpay');?>" target="_blank">Click here</a></span>
                                            </div>
                                            <div class="col-md-1" style="margin-top:35px;">
                                                <i class="fad fa-question-circle"></i>
                                            </div>
                                            <div class="col-md-6" >
                                                <img src="<?php echo base_url('assets1/uploads/Inkedrazor1_LI.jpg');?>" style="width:600px;height:300px;">
                                            </div>
                                        </div>
                                        <br>    
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="payment_secret_key"><b>Payment Secret Key</b></label>
                                                <input type="text" class="form-control" name="payment_secret_key" id="payment_secret_key" placeholder="Enter Secret Key">
                                                <br>
                                                <span style="color:red;">NOTE:</span>&nbsp;<span><b>Know how to generate API Secret key </b><a href="<?php echo base_url('backend/PaymentController/viewPaymentDocumentation/razorpay');?>" target="_blank">Click here</a></span>
                                            </div>
                                            <div class="col-md-1" style="margin-top:35px;">
                                                <i class="fad fa-question-circle"></i>
                                            </div>
                                            <div class="col-md-6" >
                                                <img src="<?php echo base_url('assets1/uploads/Inkedrazor1_L2.jpg');?>" style="width:600px;height:300px;">
                                            </div>
                                            <!-- <div>
                                                <span id="pop-up" style="position: absolute; display:none;">
                                                    <img src="<?php echo base_url('assets/uploads/Inkedrazor1_L2.jpg');?>"/>
                                                </span>
                                                <div id="image" style="width:500px;height:30px; margin-left:100px;">    <a href="#">
                                                    <img src="<?php echo base_url('assets1/uploads/Inkedrazor1_L2.jpg');?>" border="none"/></a>
                                                </div>
                                            </div>  -->
                                        </div>
                                    </div>
                                    <div id="paytm" style="display: none">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="payment_api_key"><b>Merchant MID</b></label>
                                                <input type="text" class="form-control" name="merchant_mid" placeholder="Enter Merchant MID">
                                                <br>
                                                <span style="color:red;">NOTE:</span>&nbsp;<span><b>Know how to generate Merchant MID </b><a href="<?php echo base_url('backend/PaymentController/viewPaymentDocumentation/paytm');?>" target="_blank">Click here</a></span>
                                            </div>
                                            <div class="col-md-1" style="margin-top:35px;">
                                                <i class="fad fa-question-circle"></i>
                                            </div>
                                            <div class="col-md-6" >
                                                <img src="<?php echo base_url('assets1/uploads/paytm_L1.jpg');?>" style="width:600px;height:300px;">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="payment_secret_key"><b>Merchant Key</b></label>
                                                <input type="text" class="form-control" name="merchant_secret_key" placeholder="Enter Merchant Key" >
                                                <br>
                                                <span style="color:red;">NOTE:</span>&nbsp;<span><b>Know how to generate Merchant Key </b><a href="<?php echo base_url('backend/PaymentController/viewPaymentDocumentation/paytm');?>" target="_blank">Click here</a></span>
                                            </div>
                                            <div class="col-md-1" style="margin-top:35px;">
                                                <i class="fad fa-question-circle"></i>
                                            </div>
                                            <div class="col-md-6" >
                                                <img src="<?php echo base_url('assets1/uploads/paytm_L2.jpg');?>" style="width:600px;height:300px;">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="industry_type"><b>Industry Type</b></label>
                                                <input type="text" class="form-control" name="industry_type" placeholder="Enter Industry Type" >
                                                <br>
                                                <span style="color:red;">NOTE:</span>&nbsp;<span><b>Know how to generate Industry Type </b><a href="<?php echo base_url('backend/PaymentController/viewPaymentDocumentation/paytm');?>" target="_blank">Click here</a></span>
                                            </div>
                                            <div class="col-md-1" style="margin-top:35px;">
                                                <i class="fad fa-question-circle"></i>
                                            </div>
                                            <div class="col-md-6" >
                                                <img src="<?php echo base_url('assets1/uploads/paytm_L2.jpg');?>" style="width:600px;height:300px;">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="merchant_website"><b>Merchant Website</b></label>
                                                <input type="text" class="form-control" name="merchant_website" placeholder="Enter Merchant Website" >
                                                <br>
                                                <span style="color:red;">NOTE:</span>&nbsp;<span><b>Know how to generate Merchant Website </b><a href="<?php echo base_url('backend/PaymentController/viewPaymentDocumentation/paytm');?>" target="_blank">Click here</a></span>
                                            </div>
                                            <div class="col-md-1" style="margin-top:35px;">
                                                <i class="fad fa-question-circle"></i>
                                            </div>
                                            <div class="col-md-6" >
                                                <img src="<?php echo base_url('assets1/uploads/paytm_L2.jpg');?>" style="width:600px;height:300px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="gpay" style="display: none">
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="payment_api_key"><b>Payee VPA:</b></label>
                                                <input type="text" class="form-control" name="payee_vpa" placeholder="Enter Merchant UPI VPA ID" >
                                                <br>
                                                <!--<span style="color:red;">NOTE:</span>&nbsp;<span><b>Know how to generate Merchant MID </b><a href="<?php echo base_url('backend/PaymentController/viewPaymentDocumentation/paytm');?>" target="_blank">Click here</a></span>-->
                                            </div>
                                            <div class="col-md-1" style="margin-top:35px;">
                                                <i class="fad fa-question-circle"></i>
                                            </div>
                                            <!--<div class="col-md-6" >-->
                                            <!--    <img src="<?php echo base_url('assets1/uploads/paytm_L1.jpg');?>" style="width:600px;height:300px;">-->
                                            <!--</div>-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="payment_secret_key"><b>Payee Name</b></label>
                                                <input type="text" class="form-control" name="payee_name" placeholder="Enter Payee Name(Merchant name)" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="payment_secret_key"><b>Transaction Note</b></label>
                                                <input type="text" class="form-control" name="trns_note" placeholder="Enter Transaction Note" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="payment_secret_key"><b>Merchant Code</b></label>
                                                <input type="text" class="form-control" name="merchant_code" placeholder="Enter Merchant Code" >
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <a href="<?php echo base_url('backend/MyShopController/index');?>" class="btn btn-warning">Cancel</a>
                                    <input type="submit" class="btn btn-success" value="Save" name="submit">
                                </form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- container-fluid -->
		</div>
		<!-- End Page-content -->
		<?php $this->load->view('backend/include/sidebar');?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
        <script type="text/javascript">
            function CheckProvider(val)
            {
                // alert(val);
                var razorelement=document.getElementById('razorpay');
                if(val=='Razorpay')
                razorelement.style.display='block';
                else razorelement.style.display='none';

                var paytmelement=document.getElementById('paytm');
                if(val=='Paytm')
                paytmelement.style.display='block';
                else paytmelement.style.display='none';

                var gpayelement=document.getElementById('gpay');
                if(val=='GooglePay')
                gpayelement.style.display='block';
                else gpayelement.style.display='none';
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#image").mouseover(function(){
                    $("#pop-up").show();
                });
                $("#image").mouseout(function(){
                    $("#pop-up").hide();
                });
            });
        </script>