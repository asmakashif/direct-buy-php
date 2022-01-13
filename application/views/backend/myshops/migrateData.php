<!-- Header Layout Content -->

<div class="mdk-header-layout__content">
	<div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
		<div class="mdk-drawer-layout__content page ">
			<div class="container-fluid page__container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url('backend/MyShopController/index')?>">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url('backend/MyShopController/myShop/'.$fetchdatabyid->shopId . '/' .$fetchdatabyid->shop_db_name)?>">View Products</a></li>
					<li class="breadcrumb-item active">Migarte Data</li>
				</ol>
				<h1 class="h2">Migarte Data to <?php echo $fetchdatabyid->shop_name?></h1>
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<h1>Select Category</h1>
								<form action="<?php echo base_url('backend/MyShopController/migrateDataToStoreDb/'. $fetchdatabyid->shopId .'/'. $fetchdatabyid->shop_db_name);?>" method="post">
									<?php foreach($products as $row) {?>
										<input type="checkbox" id="<?=$row->product_category?>" name="product_category[]" value="<?php echo $row->product_category ;?>">
	  									<label for="vehicle1"><?php echo $row->product_category;?></label><br>
	  								<?php }?>
	  								<input type="submit" class="btn btn-success" name="submit" value="submit">
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