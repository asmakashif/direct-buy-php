<!-- Header Layout Content -->

<div class="mdk-header-layout__content">
	<div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
		<div class="mdk-drawer-layout__content page ">
			<div class="container-fluid page__container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url('backend/MyShopController/index')?>">Home</a></li>
					<li class="breadcrumb-item active">Edit Payment Configuration</li>
				</ol>
				<h1 class="h2">Edit Payment Configuration</h1>
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<form action="<?php echo base_url('backend/PaymentController/updatePaymentConfiguration');?>" method="post"> 
                                    <div class="row">
                                        <div class="col-md-6">
                                        	<label for="provider_type"><b>Provider Name</b></label>
                                            <input type="text" class="form-control" name="provider_type" id="provider_type" value="<?php echo $payment->provider_type?>" readonly="">
                                            <input type="hidden" class="form-control" name="payment_id" id="payment_id" value="<?php echo $payment->payment_id ?>" readonly="">
                                        </div>
                                        <div class="col-md-6">
                                        	<label for="payment_name"><b>Payment Method Name</b></label>
                                            <input type="text" class="form-control" name="payment_name" id="payment_name" value="<?php echo $payment->payment_name?>" required="">

                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                        	<?php if($provider=='Razorpay') {?>
                                        		<label for="payment_api_key"><b>Payment API Key</b></label>
                                        		<input type="text" class="form-control" name="payment_api_key" id="payment_api_key" value="<?php echo $payment->payment_api_key?>" required="">
                                        	<?php } elseif($provider=='Paytm') {?>

                                        		<label for="payment_api_key"><b>Merchant MID</b></label>
                                        		<input type="text" class="form-control" name="payment_api_key" id="payment_api_key" value="<?php echo $payment->payment_api_key?>" required="">
                                    		<?php } elseif($provider=='GooglePay') {?>
                                    		    <label for="payment_api_key"><b>Merchant UPI VPA ID</b></label>
                                    		    <input type="text" class="form-control" name="payee_vpa" value="<?php echo $payment->payment_api_key?>" required="">
                                        	<?php } else {?>
                                        	<?php }?>
                                            
                                        </div>
                                        <div class="col-md-6">
                                        	<?php if($provider=='Razorpay') {?>
                                        		<label for="payment_secret_key"><b>Payment Secret Key</b></label>
                                        		<input type="text" class="form-control" name="payment_secret_key" id="payment_secret_key" value="<?php echo $payment->payment_secret_key?>" required="">
                                        	<?php } elseif($provider=='Paytm') {?>
                                        		<label for="payment_api_key"><b>Merchant Key</b></label>
                                        		<input type="text" class="form-control" name="payment_secret_key" value="<?php echo $payment->payment_secret_key?>" required="">
                                        	<?php } elseif($provider=='GooglePay') {?>
                                    		    <label for="payee_name"><b>Merchant UPI VPA Name</b></label>
                                    		    <input type="text" class="form-control" name="payee_name" value="<?php echo $payment->payment_secret_key?>" required="">
                                    		<?php } else {?>
                                        	<?php }?>
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                        	<?php if($provider=='GooglePay') {?>
                                        		<label for="payee_name"><b>Transaction Note</b></label>
                                    		    <input type="text" class="form-control" name="trns_note" value="<?php echo $payment->transaction_note?>" required="">
                                    	    <?php } elseif($provider=='Paytm') {?>
                                        		<label for="payment_api_key"><b>Industry Type</b></label>
                                        		<input type="text" class="form-control" name="industry_type" value="<?php echo $payment->industry_type?>" required="">
                                    		<?php } else {?>
                                        	<?php }?>
                                            
                                        </div>
                                        <div class="col-md-6">
                                        	<?php if($provider=='GooglePay') {?>
                                    		    <label for="payee_name"><b>Merchant Code</b></label>
                                    		    <input type="text" class="form-control" name="merchant_code" value="<?php echo $payment->merchant_code?>" required="">
                                    	    <?php } elseif($provider=='Paytm') {?>
                                        		<label for="payment_api_key"><b>Merchant Website</b></label>
                                        		<input type="text" class="form-control" name="merchant_website" value="<?php echo $payment->merchant_website?>" required="">
                                        	<?php } else {?>
                                        	<?php }?>
                                            
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