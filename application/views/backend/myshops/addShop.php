<!-- Header Layout Content -->

<div class="mdk-header-layout__content">
	<div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
		<div class="mdk-drawer-layout__content page ">
			<div class="container-fluid page__container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url('backend/MyShopController/index')?>">Home</a></li>
					<li class="breadcrumb-item active">Add Shop</li>
				</ol>
				<h1 class="h2">Add Shop</h1>
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<form action="<?php echo base_url('backend/MyShopController/saveShopDetails');?>" method="post"> 
								<!-- <form  method="post" id="shopDetails">  -->
                                    <div class="row">
                                        <div class="col-md-5">
                                        	<label for="shop_name"><b>Shop Name</b></label>
                                            <input type="text" class="form-control" name="shop_name" id="shop_name" placeholder="Enter Shop Name" pattern="[a-zA-Z0-9\s]+" required="">
                                        </div>
                                        <div class="col-md-7">
                                        	<label for="shop_type_name"><b>Select Shop Type</b></label>
                                        	<br>
                                            <?php foreach($shopType as $row) {?>
										
												<input type="checkbox" id="<?=$row->shop_type_id?>" name="shop_type[]" value="<?php echo $row->shop_type_id ;?>">
			  									<label for="shop_type_name"><?php echo $row->shop_type_name;?></label>
			  								<?php }?>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="shop_gst"><b>GST</b></label>
                                            <input type="text" class="form-control" name="shop_gst" id="shop_gst" placeholder="Enter GST Number" required="">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="shop_address"><b>Shop Address</b></label>
                                            <textarea class="form-control" name="shop_address" id="shop_address"></textarea> 
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
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script>
		    $(document).ready(function() {
		        $("#shopDetails").submit(function(e){
		            e.preventDefault();
		            var shop_name = $('#shop_name').val();
		            console.log(shop_name);
		            var shop_type = $('#shop_type').val();
		            console.log(shop_type);
		            var shop_gst = $('#shop_gst').val();
		            var shop_address = $('#shop_address').val();
		            console.log(shop_gst);
		            console.log(shop_address);
		            // sessionStorage.setItem("contact", contact);
		            if(shop_name != '')
		            {
		                $.ajax({
		                	url:"<?php echo base_url(); ?>backend/MyShopController/saveShopDetails",
		                    method:"POST",
		                    data:{shop_name:shop_name,shop_type:shop_type,shop_gst:shop_gst,shop_address:shop_address},
		                    success:function(data)
		                    {
		                    	$("#successmsg").html('<div class="alert alert-danger">"Submitted Successfully"</div>');
		                    	// console.log(data);
		                        // $("#register").modal('hide');
		                        // enterOTP();
		                        // var contact = data;
		                        // sessionStorage.setItem("contact", contact);
		                    },
		                    error:function(er){
		                    	$("#errormsg").html('<div class="alert alert-danger">"Something went wrong"</div>');
		                        console.log(er);
		                    }
		                });
		            }
		        });
		    });
		</script> -->