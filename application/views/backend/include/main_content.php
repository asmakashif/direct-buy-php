<!-- Header Layout Content -->

<div class="mdk-header-layout__content">
	<div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
		<div class="mdk-drawer-layout__content page ">
			<div class="container-fluid page__container">
				<br>
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
				<?php $data = explode('.',$_SERVER['SERVER_NAME']);?>
                <?php if($data[0] == 'demo') {?>
				    <h1>Dashboard<normal style="color:red;font-size:16px">(Note: All changes will be removed within 24 hours) </normal></h1>
			    <?php } else {?>
			        <h1>Dashboard</h1>
			    <?php }?>
            	<ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#first" data-toggle="tab">My Shops</a>
                    </li>
                    &nbsp;
                    <li class="nav-item">
                        <a class="nav-link" href="#second" data-toggle="tab">Payment Gateway</a>
                    </li>
                    &nbsp;
                    <li class="nav-item">
                        <a class="nav-link" href="#third" data-toggle="tab">Reports</a>
                    </li>
                    &nbsp;
                    <li class="nav-item">
                        <a class="nav-link" href="#fourth" data-toggle="tab">Communication</a>
                    </li>
                </ul>
                 <br> 
                <div class="row">
                    <div class="col-md-8">
                        
                            <div class="tab-content">
                        	    <div class="tab-pane active" id="first">
                        	        <div class="row">
                                        <div class="col-md-4">
                                            <a href="<?php echo base_url('backend/MyShopController/storeInfo');?>" style="text-decoration: none">
                    							<div class="card mini-stats-wid" style="border-radius: 15px">
                    								<div class="card-body">
                    									<div class="media">
                    										<div class="media-body">
                    											<p class=" font-weight-medium"> New Shop</p>
                    											<img src="<?php echo base_url('assets1/img/add-sign.png');?>" class="plus-icon" />
                    										</div>
                    									</div>
                    								</div>
                    							</div>
                    						</a>
                						</div>
                                        <?php if(!empty($shopDetails)){ foreach ($shopDetails as $sd) { ?>
                                            <div class="col-md-4">
                                                <?php if($sd->shop_payment_status==0) {?>
                                                    <a href="<?php echo base_url('backend/MyShopController/storeSummary/'.$sd->shopId);?>" style="text-decoration: none">
                        								<div class="card mini-stats-wid" style="border-radius: 15px">
                        									<div class="card-body">
                        										<div class="media">
                        											<div class="media-body" style="height:90px;">
                        												<p class=" font-weight-medium" style="text-align:center"> <?php echo $sd->shop_name;?> </p>
                        												<!--<h4 class="mb-0"><?php echo $ud->domainname;?></h4>-->
                        												<br>
                        											</div>
                        										
                        										</div>
                        									</div>
                        								</div>
                        							</a>
                        						<?php } else {?>
                        						    <a href="<?php echo base_url('backend/MyShopController/myShop/'.$sd->shopId);?>" style="text-decoration: none">
                        						        <?php if($sd->shop_status==2) {?>
                            								<div class="card mini-stats-wid" title="Shop is not active" style="border-radius: 15px">
                            									<div class="card-body">
                            										<div class="media">
                            											<div class="media-body" style="height:90px;">
                            											    <p class=" font-weight-medium" title="shop deactivated" style="text-align:center;color:orange"> <?php echo $sd->shop_name;?> </p>
                            											</div>
                            										</div>
                            									</div>
                            								</div>
                            							<?php } elseif(date("Y-m-d",strtotime($sd->shop_exp_date)) < date("Y-m-d")) {?>
                            							    <div class="card mini-stats-wid" title="Subscription expired" style="border-radius: 15px">
                            									<div class="card-body">
                            										<div class="media">
                            											<div class="media-body" style="height:90px;">
                            											    <p class=" font-weight-medium" title="shop deactivated" style="text-align:center;color:red"> <?php echo $sd->shop_name;?> </p>
                            											</div>
                            								        </div>
                            									</div>
                            								</div>
                            							<?php } else {?>
                            							    <div class="card mini-stats-wid" title="Shop active" style="border-radius: 15px">
                            									<div class="card-body">
                            										<div class="media">
                            											<div class="media-body" style="height:90px;">
                            											    <p class=" font-weight-medium" style="text-align:center;color:green"> <?php echo $sd->shop_name;?> </p>
                            											</div>
                            										</div>
                            									</div>
                            								</div>
                            							<?php }?>
                        							</a>
                        						<?php }?>
                							</div>
                                        <?php } }?>
                                    </div>
                        	    </div>
                        	    <div class="tab-pane" id="second">
                        	        <div class="row">
                                        <div class="col-md-4">
                                            <a href="<?php echo base_url('backend/PaymentController/addPaymentMethod');?>" style="text-decoration: none">
                    							<div class="card mini-stats-wid" style="border-radius: 15px">
                    								<div class="card-body">
                    									<div class="media">
                    										<div class="media-body">
                    											<p class=" font-weight-medium">Add Payment</p>
                    											<img src="<?php echo base_url('assets1/img/add-sign.png');?>" class="plus-icon" />
                    										</div>
                    									</div>
                    								</div>
                    							</div>
                    						</a>
                						</div>
                						<div class="col-md-4">
                                            <a onclick="return confirm('Not Editable')?true:false;" style="text-decoration: none">
                                                <div class="card mini-stats-wid" style="border-radius: 15px">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body" style="height:90px;">
                                                                <p class=" font-weight-medium">CashOnDelivery</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                       </div>
                                        <?php if(!empty($paymentDetails)){ foreach ($paymentDetails as $sd) { ?>
                                            <div class="col-md-4">
                                                <a href="<?php echo base_url('backend/PaymentController/editPaymentConfiguration/' .$sd->provider_type);?>" style="text-decoration: none">
                        							<div class="card mini-stats-wid" style="border-radius: 15px">
                        								<div class="card-body">
                        									<div class="media">
                        										<div class="media-body" style="height:90px;">
                        											<p class=" font-weight-medium"><?php echo $sd->payment_name;?></p>
                        										</div>
                        									</div>
                        								</div>
                        							</div>
                        						</a>
                    						</div>
                                        <?php } }?>
                                    </div>
                        	    </div>
                        	    <div class="tab-pane" id="third">
                        	        <h1>Reports</h1>
                        	    </div>
                        	    <div class="tab-pane" id="fourth">
                        	        <form action="<?php echo base_url('backend/MyShopController/updateStrMsg');?>" method="post" enctype="multipart/form-data">
                            	        <div class="row">
                                            <div class="col-md-6">
                                                <input readonly="" name="store_message" type="text" class="form-control" id="store_message" value="<?php if(isset($strMsg->str_msg)) { echo $strMsg->str_msg; } ?>">
                                                
                                            </div>
                                            <button type="" id="editMessage"class="btn btn-info"  value="" style="height:40px;">Edit Message</button>
                    					</div>
                    				</form>
                        	    </div>
                        	</div>
                        
                    </div>
                    <div class="col-md-4">
                        <div class="">
                            <div class="card-body">
                                <img src="<?php echo base_url('');?>assets1/img/ad.jpg">
                            </div>
                        </div>
                    </div>
                </div>
			</div>
			<!-- container-fluid -->
		</div>
		<!-- End Page-content -->
		<?php $this->load->view('backend/include/sidebar');?>
		<script src="<?php echo base_url('assets1/js/jquery.min.js');?>"></script>
        <script>
            $(document).ready(function(){
                $('#editMessage').click(function(){
                    $('#store_message').prop('readonly',false);
                    
                    $('#editMessage').replaceWith(`<button class="btn btn-success" value="submit" style="height:40px;">Update</button>`);
                });
                $('#store_message').bind('input propertychange', function() {
                    if (this.value.length > 50) {
                        alert("Only 50 characters allowed");
                        $("#store_message").val($("#textareaID").val().substring(0,50));
                    }
                });
            });
            function basicPopup(url) 
            {
                popupWindow = window.open(url,'popUpWindow','height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
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
		<style type="text/css">
			.plus-icon {
        		width: 50px;
        		height: 50px;
    		}
	        .panel:hover {
                -webkit-box-shadow: 4px 4px 15px -2px rgba(0, 0, 0, .19);
                box-shadow: 4px 4px 15px -2px rgba(0, 0, 0, .19)
            }
            .boximage{
                width:150px;
                height:100px;
                float:left;
                margin-left:-10px;
                margin-top: -30px;
                
            }
		</style>