
<div class="mdk-header-layout__content">
	<div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
		<div class="mdk-drawer-layout__content page ">
			<div class="container-fluid page__container">
				<?php if($this->session->flashdata('flashSuccess')) { ?>
					<div style="width: 30%;margin-top: -4%;z-index: 1;margin-left: 35%;" class="alert alert-dismissible bg-success text-white border-0 fade show successmsg" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<?php echo $this->session->flashdata("flashSuccess"); ?>
					</div>
				<?php } ?> 
				<?php if($this->session->flashdata('flashError')) { ?>
					<div style="width: 30%;margin-top: -4%;z-index: 1;margin-left: 35%;" class="alert alert-dismissible bg-danger text-white border-0 fade show errormsg" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<?php echo $this->session->flashdata("flashError"); ?>
					</div>
				<?php } ?>
				<br>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url('backend/MyShopController/index')?>">Home</a></li>
					<li class="breadcrumb-item active">Shop Created</li>
				</ol>
				<!-- <br> -->
				<div class="card">
					<div class="card-body">
						<?php if($shopSummary->shop_payment_status==0) {?>
							<span><strong>Store is not active. Please activate store to view store link for customers</strong></span>
							<br>
							<br>
							<?php if($shopSummary->trail_activate==1) {?>
							<?php } else {?>
							    <a href="<?php echo base_url('backend/MyShopController/activateTrailPeriod/'.$shopId); ?>" class="btn btn-primary" onclick="return confirm('Are you sure to activate trial period of 3months?')?true:false;">Activate 3 months Trial</a> 
						    <?php }?>
						    <button id="button1" type="button" class="btn btn-info" data-toggle="modal" data-target="#activate">Activate</button>
						<?php } else {?>
							<span><strong>Congratulations Your store got created and URL of the store <a target="_blank" href="https://<?php echo $shopSummary->domainname?>.direct-buy.in/welcome/Home/<?php echo $shopSummary->shopId?>/<?php echo $shopSummary->shop_db_name?>"><?php echo $shopSummary->domainname?>.direct-buy.in/<?php echo $shopSummary->shop_name?></a> can be provide to your customers to access your store.</strong></span>
						<?php }?>
						<br>
						<br>
						<span style="font-size:18px;"><strong>Step - 2 : <span>Configure Payment Gateway</strong></span>
						<br>
						<br>
						<!--<form action="<?php echo base_url('backend/MyShopController/myShop/'.$shopId);?>" method="post">-->
						<!--    <input type="button" class="btn btn-primary" name="paymentConfig" value="Take me there">-->
						<!--</form>-->
						<a href="<?php echo base_url('backend/PaymentController/addPaymentMethod/'); ?>" class="btn btn-primary" >Take me there</a> 
						
					</div>
				</div>
			</div>
			<!-- container-fluid -->
			
		</div>
		<div class="modal fade" id="activate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<span><strong>Please copy the Store Unique Code and continue to make the payment </strong></span>
							<div class="example" style="margin: 40px auto;width: 400px;">
								<div class="input-group">
									<input type='text' readonly="" id='input-text' value="<?php echo $shopId?>">
									<span class="input-group-button">
										<button onClick="copyToClipboard()">Copy to clipboard</button>
									</span>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<a href="https://direct-buy.in/Welcome/directbuy_plans" class="btn btn-success">OK</a>
						</div>
					</div>
				</div>
			</div>
		<!-- End Page-content -->
		<?php $this->load->view('backend/include/sidebar');?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
		<script>
		    function copyToClipboard() {
                var inputElement=document.getElementById('input-text');
                inputElement.select();
                document.execCommand('copy');
                //alert("Copied to clipboard");
             }
		</script>
		<?php if($this->session->flashdata('flashSuccess')) { ?>
			<script type="text/javascript">
				window.setTimeout(function() {
					$(".successmsg").fadeTo(1000, 0).slideUp(500, function(){
						$(this).remove(); 
					});
				}, 3000);
			</script>
		<?php } ?>  
		<?php if($this->session->flashdata('flashError')) { ?>
			<script type="text/javascript">
				window.setTimeout(function() {
					$(".errormsg").fadeTo(900, 0).slideUp(800, function(){
						$(this).remove(); 
					});
				}, 4000);
			</script>
		<?php } ?> 