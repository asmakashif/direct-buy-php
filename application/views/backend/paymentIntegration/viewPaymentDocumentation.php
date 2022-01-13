<!-- Header Layout Content -->

<div class="mdk-header-layout__content">
	<div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
		<div class="mdk-drawer-layout__content page ">
			<div class="container-fluid page__container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url('backend/MyShopController/index')?>">Home</a></li>
					<li class="breadcrumb-item active">Documentation on <?php echo $payment->payment_p_name?></li>
				</ol>
				<h1 class="h2">Documentation on <?php echo $payment->payment_p_name?></h1>
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
                            <div class="card-header">
                                <h1>How to generate API Details</h1>
                            </div>
							<div class="card-body">
                                <iframe src="<?php echo base_url('assets1/uploads/documentation_img/'.$payment->payment_p_document);?>" width="100%" height="600px"> </iframe>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- container-fluid -->
		</div>
		<!-- End Page-content -->
		<?php $this->load->view('backend/include/sidebar');?>