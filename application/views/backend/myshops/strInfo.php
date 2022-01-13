
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
					<li class="breadcrumb-item active">Add Shops</li>
				</ol>
				<h1 class="h2">Add Shop</h1>
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" href="#first" data-toggle="tab">Store Information</a>
					</li>
					&nbsp;
					<li class="nav-item">
						<a class="nav-link" style="cursor: pointer">Store Configuration</a>
					</li>
					&nbsp;
					<li class="nav-item">
						<a class="nav-link" style="cursor: pointer">Product Configuration</a>
					</li>
					&nbsp;
					<li class="nav-item">
						<a class="nav-link" style="cursor: pointer">Product Information</a>
					</li>
					&nbsp;
					<li class="nav-item">
						<a class="nav-link" style="cursor: pointer">Store Summary</a>
					</li>
				</ul>
				<div class="">
					<div class="tab-content ">
						<div class="tab-pane active" id="first">
							<br>
							<div class="row">
								<div class="col-sm-12">
									<div class="card">
										<div class="card-body">
											<form action="<?php echo base_url('backend/MyShopController/saveShopDetails');?>" method="post"> 
												<div class="row">
													<div class="col-md-6">
														<label for="shop_name"><b>Shop Name</b><small>(Only letters & numbers)</small></label>
														<input type="text" class="form-control" name="shop_name" id="shop_name" placeholder="Enter Shop Name" title="Only letters (either case), numbers" pattern="[a-zA-Z0-9\s]+" required="">
													    <span id='message'></span>
													</div>
													<div class="col-md-6">
														<label for="shop_address"><b>Shop Address</b></label>
														<textarea class="form-control" name="shop_address" id="shop_address"></textarea> 
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-md-12">
														<label for="shop_type_name"><b>Select Shop Type</b></label>
														<br>
														<table class="table mb-0">
															<thead>
																<tr>
																	<th></th>
																	<th>Shop Type</th>
																	<th>Shop type Description</th>
																</tr>
															</thead>

															<?php foreach($shopType as $row) {?>	
																<tbody class="list" id="search">
																	<tr>
																		<td><input type="checkbox" id="<?=$row->shop_type_id?>" name="shop_type[]" value="<?php echo $row->shop_type_id ;?>"></td>
																		<td>
																			<?php echo $row->shop_type_name;?>
																		</td> 
																		<td>
																			<?php echo $row->shop_type_description;?>
																		</td>
																	</tr>
																</tbody>
															<?php }?>
														</table>
													</div>
												</div>
												<br>
												<input type="submit" class="btn btn-success" value="Next" id="checkBtn" name="submit">
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- container-fluid -->
		</div>
		<!-- End Page-content -->
		<?php $this->load->view('backend/include/sidebar');?>
		<script type="text/javascript" src="<?php echo base_url('assets1/js/jquery.min.js');?>"></script>
		<script type="text/javascript">
		    $('#checkBtn').click(function() {
                checked = $("input[type=checkbox]:checked").length;

                if(!checked) {
                    alert("You must check at least one checkbox.");
                    return false;
                }

            });
			$('#shop_name').on('keyup', function () {
				var shopName = $('#shop_name').val();
				if(shopName != '')
				{
					$.ajax({
						url:"<?php echo base_url(); ?>backend/MyShopController/fetchShopByName",
						method:"POST",
						data:{shopName:shopName},
						success:function(data)
						{
							if(data==0)
							{
								$('#message').html('Good to go').css('color', 'green');
							}
							else
							{
								$('#message').html('Shop already present').css('color', 'red');
								$("#submit").removeAttr('disabled','disabled');
							}
						}
					});
				}
      	    });
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
		<style>
			.fixTableHead {
				overflow-y: auto;
				height: 510px;
			}
			.NofixTableHead {
				overflow-y: auto;
				width:1000px;
			}
			.fixTableHead thead th {
				position: sticky;
				top: 0;
			}
			table {
				border-collapse: collapse;        
				width: 100%;
			}
			th,td {
				padding: 8px 15px;
				border: 2px solid #529432;
			}
			th {
				background: #ABDD93;
			}
		</style>