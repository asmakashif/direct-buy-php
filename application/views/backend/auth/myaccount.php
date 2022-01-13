<!-- Header Layout Content -->

<div class="mdk-header-layout__content">
	<div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
		<div class="mdk-drawer-layout__content page ">
			<div class="container-fluid page__container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url('backend/MyShopController/index')?>">Home</a></li>
					<li class="breadcrumb-item active">My Account</li>
				</ol>
				<h1 class="h2">My Account</h1>
                <div class="card mt-2 ml-2">
                    <div class="card-header">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <h4 class="card-title">Payment Info</h4>
                            </div>
                            <!-- <div class="media-right">
                                <a href="#" class="btn btn-sm btn-outline-primary"><i class="material-icons">add</i></a>
                            </div> -->
                        </div>
                    </div>
                    <ul class="card-footer ">
                        <div class="row">
                            <?php foreach($shopDetails as $row) {?>
                                <div class="col-md-6">
                                    <li class="list-group-item">
                                        <div class="media align-items-center">
                                            <div class="media-left">
                                                <!-- <img src="<?php echo base_url('assets/img/shop.png');?>" style="width:50px;height:50px"/> -->
                                                <span class="btn btn-default btn-circle"><i class="material-icons">credit_card</i></span>
                                            </div>
                                            <?php if($row->shop_payment_status == 1) {?>
                                                
                                                <?php if(date("Y-m-d",strtotime($row->shop_exp_date)) < date("Y-m-d")) { ?>
                                                    <div class="media-body">
                                                        <p class="mb-0"><?php echo $row->shop_name?></p>
                                                        <small>Activated on <?php echo date("Y-m-d",strtotime($row->shop_payment_date))?></small>
                                                        <br>
                                                        <small>Expired on <?php echo  date("Y-m-d",strtotime($row->shop_exp_date))?></small>
                                                    </div>
                                                    <div class="media-right">
                                                        <a href="https://direct-buy.in/Welcome/directbuy_plans/<?php echo $row->shopId ?>" class="btn btn-warning"><i class="material-icons btn__icon--left">autorenew</i> Renew
                                                        </a>
                                                    </div>
                                                <?php } else {?>
                                                    <?php if($row->shop_status == 2) {?>
                                                        <div class="media-body">
                                                            <p class="mb-0"><?php echo $row->shop_name?></p>
                                                            <small>Activated on <?php echo date("Y-m-d",strtotime($row->shop_payment_date))?></small>
                                                            <br>
                                                            <small>Expires on <?php echo  date("Y-m-d",strtotime($row->shop_exp_date))?></small>
                                                        </div>
                                                        <div class="media-right">
                                                            <a href="<?php echo base_url('backend/MyProfile/reActivateShop/'.$row->shopId);?>" class="btn btn-info"><i class="material-icons btn__icon--left">autorenew</i> Re-Activate
                                                            </a>
                                                        </div>
                                                    <?php } else {?>
                                                        <div class="media-body">
                                                            <p class="mb-0"><?php echo $row->shop_name?></p>
                                                            <small>Activated on <?php echo date("Y-m-d",strtotime($row->shop_payment_date))?></small>
                                                            <br>
                                                            <small>Expires on <?php echo  date("Y-m-d",strtotime($row->shop_exp_date))?></small>
                                                        </div>
                                                        <div class="media-right">
                                                            <button class="btn btn-success">Activated</button>
                                                        </div>
                                                    <?php }?>
                                                <?php }?>
                                            <?php } else {?>
                                                <?php if($row->trail_activate == 0) {?>
                                                    <div class="media-body">
                                                        <p class="mb-0"><?php echo $row->shop_name?></p>
                                                        <small style="background-color:#24a0ed;">Activate Trial</small>
                                                    </div>
                                                    <form action="<?php echo base_url('backend/MyProfile/activateTrailPeriod/'.$row->shopId);?>" method="post">
                                                        <div class="media-right">
                                                            <button class="btn btn-primary" onclick="return confirm('Are you sure to activate trail period of 3months?')?true:false;">Activate Trial</button>
                                                        </div>
                                                    </form>
                                                <?php } else {?>
                                                    <div class="media-body" style="height:65px;">
                                                        <p class="mb-0"><?php echo $row->shop_name?></p>
                                                        <small style="background-color:tomato;">Inactive</small>
                                                    </div>
                                                    <div class="media-right">
                                                        <button class="btn btn-danger">InActive</button>
                                                    </div>
                                                <?php }?>
                                            <?php }?>
                                            
                                        </div>
                                    </li>
                                </div>
                            <?php }?>
                        </div>
                    </ul>
                </div>

                <div class="card mt-2 ml-2">
                    <div class="card-header">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <h4 class="card-title">GST Info</h4>
                            </div>
                        </div>
                    </div>
                    <ul class="card-footer ">
                        <form action="<?php echo base_url('backend/MyProfile/saveGST');?>" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shop_gst"><b>GST</b></label>
                                        <input type="text" class="form-control" name="shop_gst" id="shop_gst" value="<?php if(isset($userData->gst)) { echo $userData->gst; } ?>" placeholder="Enter GST Number" readonly="" required="">
                                        <input type="hidden" class="form-control" name="userid" id="userid" value="<?php echo $this->session->userdata('id');?>" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="" id="storeInfo" class="btn btn-info" name="storeInfo" style="margin-top:30px;">Edit</button>
                                        <!--<input type="submit" class="btn btn-success" value="Save" name="submit" style="margin-top:30px;">-->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </ul>
                </div>
            </div>
			<!-- container-fluid -->
		</div>
		<!-- End Page-content -->
		<?php $this->load->view('backend/include/sidebar');?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script>
            $(document).ready(function(){
                $('#storeInfo').click(function(){
                    $('#shop_gst').prop('readonly',false);
                    $('#storeInfo').replaceWith(`<button class="btn btn-success" value="submit" style="margin-top:30px;">Update </button>`);
                });
            });
        </script>