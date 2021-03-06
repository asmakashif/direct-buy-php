
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
						<a class="nav-link" style="cursor: pointer">Store Information</a>
					</li>
					&nbsp;
					<li class="nav-item">
						<a class="nav-link" href="#store_config" data-toggle="tab">Store Configuration</a>
					</li>
					&nbsp;
					<?php if($this->uri->segment(5)=='datafrombaseDB') {?>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url('backend/MyShopController/strProductConfig/'.$shopId.'/'.$proConfig);?>">Product Configuration</a>
							
						</li>
					<?php } else {?>
						<li class="nav-item">
							<a class="nav-link"  style="cursor: pointer">Product Configuration</a>
						</li>
					<?php }?>
					&nbsp;
					<li class="nav-item">
						<a class="nav-link active" href="#product_information" data-toggle="tab">Product Information</a>
					</li>
					&nbsp;
					<li class="nav-item">
						<a class="nav-link" style="cursor: pointer">Store Summary</a>
					</li>
				</ul>
				<!-- <br> -->
				<div class="">
					<div class="tab-content ">
						<div class="tab-pane" id="store_config">
							<br>
							<div class="row">
    							<div class="col-sm-12">
    								<div class="card">
    									<div class="card-body">
    										<div class="form-group">
    											<div class="radio">
    												<div class="ez-radio pull-left">
    													<label>
    														<strong>1. &nbsp; <span>I am configuring a Pharmaceutical store </span></strong>
    														<input type="checkbox" name="pharma" id="yesPharma" value="Yes">
    													</label>
    												</div>
    												
    											</div>
    										</div>
    										
    										
    										<div class="form-group">
    											<div class="radio">
    												<div class="ez-radio pull-left">
    													<label>
    														<strong>2. &nbsp; <span>Do you have inventory (SKU) information of the products in your store? </span></strong>
    													</label>
    												</div>
    												<div class="ez-radio">
    													<label>
    														<input type="radio" name="product_info" id="yes" value="Yes" onclick="javascript:SKUCheck();">
    														Yes
    													</label>
    													<label>
    														<input type="radio" name="product_info" id="maybe" value="Maybe" onclick="javascript:SKUCheck();">
    														Maybe
    													</label>
    													<label>
    														<input type="radio" name="product_info" id="no" value="No" onclick="javascript:SKUCheck();">
    														No
    													</label>
    												</div>
    											</div>
    										</div>
    										
    										<div id="ifYes" style="display:none">
    											<div class="row">
    												<div class="col-sm-12">
    													<div class="radio">
    														<div class="ez-radio pull-left">
    															<label>
    																<strong>3. &nbsp; <span>Would you be comfortable in uploading your store products by yourself or would you want assistance from Direct-Buy team? </span></strong>
    															</label>
    														</div>
    
    														<div class="ez-radio pull-left">
    															<label>
    																<input type="radio" onclick="javascript:yesCheck();" name="yes" value="I am comfortable" id="comfortableCheck">
    																I am comfortable
    															</label>
    															<label>
    																<input type="radio" onclick="javascript:yesCheck();" name="yes" value="I need help" id="helpCheck">
    																I need help
    															</label>
    														</div>
    													</div>
    												</div>
    											</div>
    											&nbsp;
    										</div>
    
    										<div id="ifComfortable" style="display:none">
    											<div class="row">
    												<div class="col-sm-12">
    													<div class="radio">
    														<div class="ez-radio pull-left">
    															<label>
    																<strong>4. &nbsp; <span>Click here to download the template to upload your products data to your store</span></strong>
    															</label>
    														</div>
    														<div class="col-md-6">
    															
    															<form method="post" action="<?php echo base_url('backend/ExportExcelController/exportProductDataFromBaseDB/');?>">
    																<input type="submit" name="export" class="btn btn-success" value="Export" onclick="javascript:exportCheck();" id="export"/>
    															</form>
    														</div>
    													</div>
    												</div>
    											</div>
    											&nbsp;
    										</div>
    										<div id="ifExport" style="display:none">
    											<div class="row">
    												<div class="col-sm-12">
    													<div class="radio">
    														<div class="ez-radio pull-left">
    															<label>
    																<strong>5. &nbsp; <span>Fill out the data and upload the file</span></strong>
    															</label>
    														</div>
    
    														<form action="<?php echo base_url('backend/ImportExcelController/importProductDataToBaseDB/'.$this->uri->segment(4));?>" method="post" enctype="multipart/form-data">
    															<div class="row">
    																<div class="col-md-6">
    																	<input type="file" class="form-control" name="uploadFile"/>
    
    																	<input type="hidden" value="" id="fullyuploadedbycustomer" name="fullyuploadedbycustomer">
    																	<input type="hidden" id="pharma" name="pharma">
    																</div>
    																<div class="col-md-2">
    																	<input type="submit" name="submit" class="btn btn-success" value="Import"/>
    																</div>
    															</div>
    														</form>
    													</div>
    												</div>
    											</div>
    											&nbsp;
    										</div>
    
    										<div id="ifMaybe" style="display:none">
    											<div class="row">
    												<div class="col-sm-12">
    													<div class="radio">
    														<div class="ez-radio pull-left">
    															<label>
    																<strong>3. &nbsp; <span>Would you confirm you have some data, but not all data?</span></strong>
    															</label>
    														</div>
    
    														<div class="ez-radio pull-left">
    															<label>
    																<input type="radio" onclick="javascript:maybeCheck();" name="maybe" value="Yes" id="maybeYesCheck">
    																Yes
    															</label>
    															<label>
    																<input type="radio" onclick="javascript:maybeCheck();" name="maybe" value="No" id="maybeNoCheck">
    																No
    															</label>
    														</div>
    													</div>
    												</div>
    											</div>
    											&nbsp;
    										</div>
    										<div id="ifMaybeYes" style="display:none">
    											<div class="row">
    												<div class="col-sm-12">
    													<div class="radio">
    														<div class="ez-radio pull-left">
    															<label>
    																<strong>4. &nbsp; <span>Click here to download the template to upload your products data to your store.</span></strong>
    															</label>
    														</div>
    														<div class="col-md-6">
    															<form method="post" action="<?php echo base_url('backend/ExportExcelController/exportProductDataFromBaseDB/');?>">
    																<input type="submit" name="export" class="btn btn-success" value="Export" onclick="javascript:maybeexportCheck();" id="maybeexport"/>
    															</form>
    														</div>
    													</div>
    												</div>
    											</div>
    											&nbsp;
    										</div>
    										<div id="ifMaybeExport" style="display:none">
    											<div class="row">
    												<div class="col-sm-12">
    													<div class="radio">
    														<div class="ez-radio pull-left">
    															<label>
    																<strong>5. &nbsp; <span>Fill out the data and upload the file partially</span></strong>
    															</label>
    														</div>
    														<form action="<?php echo base_url('backend/ImportExcelController/importProductDataToBaseDB/'.$this->uri->segment(4));?>" method="post" enctype="multipart/form-data">
    															<div class="row">
    																<div class="col-md-6">
    																	<input type="file" class="form-control" name="uploadFile"/>
    																	<input type="hidden" value="" id="partiallyuploadedbycustomer" name="partiallyuploadedbycustomer">
    																	<input type="hidden" id="partialpharma" name="pharma">
    																</div>
    																<div class="col-md-2">
    																	<input type="submit" name="submit" class="btn btn-success" value="Import"/>
    																</div>
    															</div>
    														</form>
    														<span><b>Note: You can also reach out to dataupload@direct-buy.in for data that you do not have.</b></span>
    														
    													</div>
    												</div>
    											</div>
    											&nbsp;
    										</div>
    										<div id="ifHelp" style="display:none">
    											<form action="<?php echo base_url('backend/MyShopController/continueWithoutProductUpload/'.$this->uri->segment(4));?>" method="post" >
    												<div class="row">
    													<div class="col-sm-12">
    														<div class="radio">
    															<div class="ez-radio pull-left">
    																<label>
    																	<strong>4. &nbsp; <span>Please email your products database to dataupload@direct-buy.in</span></strong>
    																</label>
    															</div>
    														</div>
    													</div>
    												</div>
    												<input type="hidden" id="no_pharma" name="pharma">
    												<input type="submit" class="btn btn-success" value="Continue" name="submit">
    											</form>
    											&nbsp;
    										</div>
    										<div id="ifNo" style="display:none">
    											<div class="row">
    												<div class="col-sm-12">
    													<div class="radio">
    														<div class="ez-radio pull-left">
    															<label>
    																<span><strong>???Direct-buy will provide you with limited information of products that Direct-Buy holds in its central database. This database is every growing and we keep up updated with more products as they get added to our central database. You can reach out to dataupload@direct-buy.in for data upload.??? &nbsp;</strong></span>
    															</label>
    														</div>
    													</div>
    												</div>
    												<form action="<?php echo base_url('backend/MyShopController/strProductConfig/'.$this->uri->segment(4).'/'.'datafrombaseDB');?>" method="post" >
    													<input type="hidden" id="basepharma" name="pharma">
    													<input type="submit" class="btn btn-success" value="Continue" name="submit">
    												</form>
    											</div>
    											&nbsp;
    										</div>
    									</div>
    								</div>
    							</div>
    						</div>
						</div>
						
						<div class="tab-pane active" id="product_information">
							<br>
							<div class="row">
								<div class="col-sm-12">
									<div class="card">
										<div class="card-body">
										    <?php if($this->uri->segment(5)=='datafrombaseDB') {?>
												<a href="<?php echo base_url('backend/MyShopController/strProductConfig/'.$shopId.'/'.$proConfig);?>" class="btn btn-info">Back</a>
												<a href="<?php echo base_url('backend/MyShopController/storeSummary/'.$shopId.'/'.$proConfig);?>" class="btn btn-info">Continue</a>
											<?php } else {?>
												<a href="<?php echo base_url('backend/MyShopController/configureStore/'.$shopId);?>" class="btn btn-info">Back</a>
												<a href="<?php echo base_url('backend/MyShopController/storeSummary/'.$shopId);?>" class="btn btn-info">Continue</a>
											<?php }?>
												
											<div style="float:right;">
												<?php if($this->uri->segment(5)=='datafrombaseDB') {?>
													<div class="row">
														<div class="col-md-3">
															<form method="post" action="<?php echo base_url('backend/ExportExcelController/exportProductDataFromTemp/'.$shopId);?>">
																<input type="submit" name="export" class="btn btn-success" value="Export"/>
															</form>
														</div>
														<div class="col-md-9">
															<form action="<?php echo base_url('backend/ImportExcelController/importUpdatedProductDataToTemp/'.$shopId.'/'.$proConfig);?>" method="post" enctype="multipart/form-data">
																<div class="row">
																	<div class="col-md-7">
																		<input type="file" class="form-control" name="uploadFile"/>
																	</div>
																	<div class="col-md-1">
																		<input type="submit" name="submit" class="btn btn-success" value="Import"/>
																	</div>
																</div>
															</form>
														</div>
													</div>
													
												<?php } else {?>
													
												<?php }?>
											</div>
											<br>
											<br>
											<?php if($this->uri->segment(5)=='notuploadedbycustomer') {?>
												<h2>No products uploaded</h2>
											<?php } else {?>
											    <div id="hot" class="handsontable"></div>
											<?php }?>
											
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
		<script type="text/javascript" src="<?php echo base_url('assets1/js/jquery.min.js');?>"></script>
		<!-- fetch product data start-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets1/css/handsontable.full.min.css');?>">
        <script src="<?php echo base_url('assets1/js/handsontable.full.min.js');?>"></script>
       
         <script type="text/javascript">
         $(document).ready(function(){
            var URL = window.location.href;
            var arr=URL.split('/');
            var storeId = arr[6];
            $.ajax({
               url:"<?php echo base_url(); ?>backend/MyShopController/fetchStrTempProducts/"+storeId+"",
               method: 'post',  
               success: function (data) 
               {  
                  var dataObject = jQuery.parseJSON(data);
                  var hotElement = document.querySelector('#hot');
                  var hotElementContainer = hotElement.parentNode;
                  var hotSettings = {
                     data: dataObject,
                     stretchH: 'all',
                     width: 1050,
                     autoWrapRow: true,
                     height: 400,
                     maxRows: 22,
                     manualRowResize: true,
                     manualColumnResize: true,
                     // rowHeaders: true,
                     hiddenColumns: {
                         columns: [0],
                         indicators: false
                     },
                     columns: [
                        {
                           data: 'temp_str_config_id'
                        },
                        {
                           data: 'category'
                         },
                         {
                           data: 'sub_category'
                         },
                         {
                           data: 'brand'
                        },
                        {
                           data: 'product_name'
                        },
                        {
                           data: 'product_type'
                         },
                         {
                           data: 'product_sub_type'
                         },
                        {
                           data: 'product_weight'
                        },
                        {
                           data: 'product_weight_type'
                        },
                        {
                           data: 'product_qty'
                         },
                         {
                           data: 'product_price'
                         },
                         {
                           data: 'offer_price'
                        },
                        {
                           data: 'product_img'
                        },
                         {
                           data: 'product_description'
                        }
                     ],
                     colHeaders: ['Id','Category','Sub-Category','Brand','Product Name','Product Type','Product Sub-Type','Product Weight','Product Weight-Type','Product Qty','Product Price','Offer Price','Product Img','Product Description'],
                     manualRowMove: true,
                     manualColumnMove: true,
                     contextMenu: true,
                     filters: true,
                     dropdownMenu: true,
                     language: 'en-US',
                     licenseKey:"non-commercial-and-evaluation"
                  };
                  var hot = new Handsontable(hotElement, hotSettings);
                  hot.updateSettings({
                     
                     afterChange: function(changes, source) {
                        var rowThatHasBeenChanged = changes[0][0],
                        columnThatHasBeenChanged = changes[0][1],
                        previousValue = changes[0][2],
                        newValue = changes[0][3];

                        var sourceRow = hot.getSourceDataAtRow(rowThatHasBeenChanged), 
                        
                        visualRow = hot.getDataAtRow(rowThatHasBeenChanged); 
                        
                        
                        var id = visualRow[0];
                        console.log(id);
                        var cat = visualRow[1];
                        var subcat = visualRow[2];
                        var brand = visualRow[3];
                        var productName = visualRow[4];
                        var productType = visualRow[5];
                        var productSubType = visualRow[6];
                        var productWeight = visualRow[7];
                        var productWeightType = visualRow[8];
                        var productQty = visualRow[9];
                        var productPrice = visualRow[10];
                        var offerPrice = visualRow[11];
                        var productImg = visualRow[12];
                        var productDescription = visualRow[13];

                         
                        $.ajax({
                           url:"<?php echo base_url(); ?>backend/MyShopController/updateBaseProduct",
                           method:"POST",
                           dataType: "json",
                           data:{'id':id,'cat':cat,'subcat': subcat,'brand': brand,'productName': productName,'productType': productType,'productSubType': productSubType,'productWeight':productWeight,'productWeightType':productWeightType,'productQty':productQty,'productPrice':productPrice,'offerPrice': offerPrice,'productImg': productImg,'productDescription': productDescription},
                           success:function(data)
                           {
                              console.log(data);
                              //alert(data);
                           }
                        });
                     }
                  });  
                     },  
                  error: function (err) {  
                     alert(err);  
                  }  
               });
         });
      </script>
        <script type="text/javascript">
			$('input[name="pharma"]').click(function(){
			    
			    var pharma = document.getElementById('yesPharma').value;
			 //   alert(pharma);
			    document.getElementById('pharma').value = pharma;
			    document.getElementById('partialpharma').value = pharma;
			    document.getElementById('no_pharma').value = pharma;
			    document.getElementById('basepharma').value = pharma;
			});
			function SKUCheck() 
			{
				if (document.getElementById('yes').checked) 
				{
					document.getElementById('ifYes').style.display = 'block';
					document.getElementById('ifMaybeExport').style.display = 'none';
					document.getElementById('ifMaybe').style.display = 'none';
					document.getElementById('ifMaybeYes').style.display = 'none';
					document.getElementById('ifHelp').style.display = 'none';
					document.getElementById('ifNo').style.display = 'none';
					$("input:radio[name=maybe]:checked")[0].checked = false;
				}
				else 
				{	document.getElementById('ifYes').style.display = 'none';
					// document.getElementById("ifAgency").disabled = true;	
				}
				if (document.getElementById('maybe').checked) 
				{
					document.getElementById('ifMaybe').style.display = 'block';
					document.getElementById('ifExport').style.display = 'none';
					document.getElementById('ifComfortable').style.display = 'none';
					document.getElementById('ifHelp').style.display = 'none';
					document.getElementById('ifNo').style.display = 'none';
					$("input:radio[name=yes]:checked")[0].checked = false;
					document.getElementById("ifMaybe").disabled = true;
					document.getElementById("ifComfortable").disabled = true;
					document.getElementById("ifHelp").disabled = true;
				}
				else
				{
					document.getElementById('ifMaybe').style.display = 'none';
					//document.getElementById("ifIndividual").disabled = true;
				} 

				if (document.getElementById('no').checked) 
				{
					document.getElementById('ifNo').style.display = 'block';
					document.getElementById('ifMaybeExport').style.display = 'none';
					document.getElementById('ifExport').style.display = 'none';
					document.getElementById('ifComfortable').style.display = 'none';
					document.getElementById('ifHelp').style.display = 'none';
					document.getElementById('ifMaybeYes').style.display = 'none';
					document.getElementById("ifNo").disabled = true;
					document.getElementById("ifComfortable").disabled = true;
					document.getElementById("ifHelp").disabled = true;
					$("input:radio[name=yes]:checked")[0].checked = false;
					//$("input:radio[name=maybe]:checked")[0].checked = false;
					//    var radio = document.querySelector('input[type=radio][name=maybe]:checked');
					// radio.checked = false;
				}
				else
				{
					document.getElementById('ifNo').style.display = 'none';
					//document.getElementById("ifIndividual").disabled = true;
				} 
			}
			function yesCheck() 
			{

				if (document.getElementById('comfortableCheck').checked) 
				{
					document.getElementById('ifComfortable').style.display = 'block';
					document.getElementById('ifMaybeExport').style.display = 'none';
					document.getElementById('ifMaybeYes').style.display = 'none';
					document.getElementById('ifHelp').style.display = 'none';
				}
				else 
				{	document.getElementById('ifComfortable').style.display = 'none';
					// document.getElementById("ifAgency").disabled = true;	
				}

				if (document.getElementById('helpCheck').checked) 
				{
					document.getElementById('ifHelp').style.display = 'block';
					document.getElementById('ifComfortable').style.display = 'none';
					document.getElementById("ifHelp").disabled = true;
				}
				else
				{
					document.getElementById('ifHelp').style.display = 'none';
					//document.getElementById("ifIndividual").disabled = true;
				} 
			}

			function exportCheck()
			{
				if (document.getElementById('export').click) 
				{
					document.getElementById('ifExport').style.display = 'block';
					document.getElementById('ifMaybeExport').style.display = 'none';
					var fullyByCust = 'fullyuploadedbycustomer'
					document.getElementById('fullyuploadedbycustomer').value = fullyByCust;
				}
				else 
				{	document.getElementById('ifExport').style.display = 'none';
					// document.getElementById("ifAgency").disabled = true;	
				}
			}

			function maybeCheck() 
			{
				if (document.getElementById('maybeYesCheck').checked) 
				{
					document.getElementById('ifMaybeYes').style.display = 'block';
					document.getElementById('ifMaybeExport').style.display = 'none';
				}
				else 
				{	document.getElementById('ifMaybeYes').style.display = 'none';
					// document.getElementById("ifAgency").disabled = true;	
				}

				if (document.getElementById('maybeNoCheck').checked) 
				{
					document.getElementById('ifHelp').style.display = 'block';
					document.getElementById("ifHelp").disabled = true;
					document.getElementById('ifMaybeExport').style.display = 'none';
				}
				else
				{
					document.getElementById('ifHelp').style.display = 'none';
					//document.getElementById("ifIndividual").disabled = true;
				} 
			}

			function maybeexportCheck()
			{
				if (document.getElementById('maybeexport').click) 
				{
					document.getElementById('ifMaybeExport').style.display = 'block';
					document.getElementById('ifExport').style.display = 'none';
					var partialByCust = 'partiallyuploadedbycustomer'
					document.getElementById('partiallyuploadedbycustomer').value = partialByCust;
				}
				else 
				{	document.getElementById('ifMaybeExport').style.display = 'none';
					// document.getElementById("ifAgency").disabled = true;	
				}
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
<style>
	.fixTableHead {
		overflow-y: auto;
		height: 510px;
	}<style>
	.fixTableHead {
		overflow-y: auto;
		height: 510px;
	}
	.NofixTableHead {
		overflow-y: auto;
		width:1000px;
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