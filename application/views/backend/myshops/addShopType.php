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
								<form action="<?php echo base_url('backend/MyShopController/saveShopType');?>" method="post"> 
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="shop_type"><b>Shop Type</b></label>
                                            <input type="text" class="form-control" name="shop_type" id="shop_type" placeholder="Enter Shop type" pattern="[a-zA-Z0-9\s]+" required="">
                                        </div>
                                    </div>
                          			<br>
                                    <a href="<?php echo base_url('backend/MyShopController/index');?>" class="btn btn-warning">Cancel</a>
                                    <input type="submit" class="btn btn-success" value="Save">
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