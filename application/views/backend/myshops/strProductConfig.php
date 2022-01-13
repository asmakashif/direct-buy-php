<!-- Header Layout Content -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets1/css/fixTableHead.css');?>">
<div class="mdk-header-layout__content">
	<div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
		<div class="mdk-drawer-layout__content page ">
			<div class="container-fluid page__container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url('Admin/dashboard')?>">Home</a></li>
					<li class="breadcrumb-item active">My Shops</li>
				</ol>
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link" style="cursor: pointer">Store Information</a>
					</li>
					&nbsp;
					<li class="nav-item">
						<a class="nav-link" href="#store_config" data-toggle="tab">Store Configuration</a>
					</li>
					&nbsp;
					<li class="nav-item">
						<a class="nav-link active" href="#product_config" data-toggle="tab">Product Configuration</a>
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
				<br>
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
																<span><strong>“Direct-buy will provide you with limited information of products that Direct-Buy holds in its central database. This database is every growing and we keep up updated with more products as they get added to our central database. You can reach out to dataupload@direct-buy.in for data upload.” &nbsp;</strong></span>
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
					<div class="tab-pane active" id="product_config">
						<div id="msg"></div>
						<div class="row">
							<input type="button" name="checkfield" value="CheckAll" id="checkfield" class="btn btn-info" style="padding:0px;width:100px;height:25px;border-radius:5px;margin-top:20px;"/>
							&nbsp;
							<input type="button" name="uncheckfield" value="UncheckAll" id="uncheckfield" class="btn btn-primary" style="padding:0px;width:100px;height:25px;border-radius:5px;margin-top:20px;"/>
							&nbsp;
							<input type="button" id="save_value" name="save_value" value="Add" class="btn btn-success" style="padding:0px;width:100px;height:25px;border-radius:5px;margin-top:20px;background-color:#66BB6A"/>
						</div>
						<br>
						<div id="hot" class="handsontable"></div>
					</div>
				</div>
			</div>
			<!-- container-fluid -->
		</div>
		<!-- End Page-content -->
		<?php $this->load->view('backend/include/sidebar');?>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets1/css/handsontable.full.min.css');?>">
	
		<script src="<?php echo base_url('assets1/js/handsontable.full.min.js');?>"></script>
		<script src="<?php echo base_url('assets1/js/jquery.min.js');?>"></script> 
		<script type="text/javascript">
			$(document).ready(function(){
				$.ajax({
					url:"<?php echo base_url(); ?>backend/MyShopController/fetchBaseProducts",
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
						  	//maxRows: 22,
						  	manualRowResize: true,
						  	manualColumnResize: true,
						  	licenseKey:"non-commercial-and-evaluation",
						  	// rowHeaders: true,
						  	hiddenColumns: {
							    columns: [1],
							    indicators: false
							},
						  	columns: [{
						  			data: 'Add',
							  		type: 'checkbox'
							  	},
							  	{
							  		data: 'base_product_id'
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
						  	colHeaders: ['Select','Id','Category','Sub-Category','Brand','Product Name','Product Type','Product Sub-Type','Product Weight','Product Weight-Type','Product Qty','Product Price','Offer Price','Product Img','Product Description'],
						  	manualRowMove: true,
						  	manualColumnMove: true,
						  	contextMenu: true,
						  	filters: true,
						  	dropdownMenu: true,
						  	language: 'en-US'
						};
						var hot = new Handsontable(hotElement, hotSettings);

						$('#checkfield').click(function(){
							var rows = hot.countRows();
							for(var i = 0; i < rows; i++){
								hot.setDataAtCell(i, 0, true);
							}
						});

						$('#uncheckfield').click(function(){
							var rows = hot.countRows();
							for(var i = 0; i < rows; i++){
								hot.setDataAtCell(i, 0, false)
							}
						});

						hot.updateSettings({
							
						 	afterChange: function(changes, source) {
						 		var rowThatHasBeenChanged = changes[0][0],
						 		columnThatHasBeenChanged = changes[0][1],
						 		previousValue = changes[0][2],
						 		newValue = changes[0][3];

						 		var sourceRow = hot.getSourceDataAtRow(rowThatHasBeenChanged),
						 		visualRow = hot.getDataAtRow(rowThatHasBeenChanged); 
						 		
						 		var visualObjectRow = function(row) {
						 			var obj = {}, key, name;
						 			for (var i = 0; i < hot.countCols(); i++) {
						 				obj[hot.colToProp(i)] = hot.getDataAtCell(row, i);
						 			}
						 			return obj
						 		} 
							   var id = visualRow[1];
							   var cat = visualRow[2];
							   var subcat = visualRow[3];
							   var brand = visualRow[4];
							   var productName = visualRow[5];
							   var productType = visualRow[6];
							   var productSubType = visualRow[7];
							   var productWeight = visualRow[8];
							   var productWeightType = visualRow[9];
							   var productQty = visualRow[10];
							   var productPrice = visualRow[11];
							   var offerPrice = visualRow[12];
							   var productImg = visualRow[13];
							   var productDescription = visualRow[14];

							   $('#save_value').click(function(){
							    	var id = visualRow[1];
						    		var URL = window.location.href;
									var arr=URL.split('/');
									//console.log(arr);
									var storeId = arr[6];
									//alert(storeId);
						    		if (id != '')
						    		{
						    			$.ajax({
						    				url:"<?php echo base_url(); ?>backend/MyShopController/fetchBaseProductsById",
						    				method:"POST",
						    				data:{id:id},
						    				success:function(data)
						    				{
						    					var obj = jQuery.parseJSON(data);
						    					console.log(obj);
						    					$.each(obj, function(i, item) {
						    						var db_SKU = obj[i].db_SKU;
						    						var category = obj[i].category;
						    						var sub_category = obj[i].sub_category;
						    						var brand = obj[i].brand;
						    						var product_name = obj[i].product_name;
						    						var product_type = obj[i].product_type;
						    						var product_sub_type = obj[i].product_sub_type;
						    						var product_description = obj[i].product_description;
						    						var product_weight = obj[i].product_weight;
						    						var product_weight_type = obj[i].product_weight_type;
						    						var product_qty = obj[i].product_qty;
						    						var product_price = obj[i].product_price;
						    						var offer_price = obj[i].offer_price;
						    						var product_img = obj[i].product_img;

						    						// checkData(storeId,db_SKU,category,sub_category,brand,product_name,product_type,product_sub_type,product_description,product_weight,product_weight_type,product_qty,product_price,offer_price,product_img);
						    						submitData(storeId,db_SKU,category,sub_category,brand,product_name,product_type,product_sub_type,product_description,product_weight,product_weight_type,product_qty,product_price,offer_price,product_img);
						    					});
						    				}
						    			});
						    		}
						    	});

							 //  function checkData(storeId,db_SKU,category,sub_category,brand,product_name,product_type,product_sub_type,product_description,product_weight,product_weight_type,product_qty,product_price,offer_price,product_img)
								// {
								// 	var storeId = storeId;
								// 	var sku = db_SKU;
								// 	var cat = category;
								// 	var subcat = sub_category;
								// 	var brand = brand;
								// 	var productName = product_name;
								// 	var productType = product_type;
								// 	var productSubType = product_sub_type;
								// 	var productDescription = product_description;
								// 	var productWeight = product_weight;
								// 	var productWeightType = product_weight_type;
								// 	var productQty = product_qty;
								// 	var productPrice = product_price;
								// 	var offerPrice = offer_price;
								// 	var productImg = product_img;

								// 	$.ajax({
								// 		url:"<?php echo base_url(); ?>backend/MyShopController/checkBaseProductInTemp/"+storeId+"",
								// 		method:"POST",
								// 		data:{storeId:storeId},
								// 		success:function(data)
								// 		{
								// 		   submitData(storeId,db_SKU,category,sub_category,brand,product_name,product_type,product_sub_type,product_description,product_weight,product_weight_type,product_qty,product_price,offer_price,product_img);
								// 		}
								// 	});
								// }
								function submitData(storeId,db_SKU,category,sub_category,brand,product_name,product_type,product_sub_type,product_description,product_weight,product_weight_type,product_qty,product_price,offer_price,product_img)
								{
									var storeid = storeId;
									var shopId = storeId;
									var sku = db_SKU;
									var cat = category;
									var subcat = sub_category;
									var brand = brand;
									var productName = product_name;
									var productType = product_type;
									var productSubType = product_sub_type;
									var productDescription = product_description;
									var productWeight = product_weight;
									var productWeightType = product_weight_type;
									var productQty = product_qty;
									var productPrice = product_price;
									var offerPrice = offer_price;
									var productImg = product_img;
									
									$.ajax({
										url:"<?php echo base_url(); ?>backend/MyShopController/saveBaseProductsToTemp",
										method:"POST",
										dataType: "json",
										data:{'storeid': JSON.stringify(storeid),'sku': JSON.stringify(sku),'cat': JSON.stringify(cat),'subcat': JSON.stringify(subcat),'brand': JSON.stringify(brand),'productName': JSON.stringify(productName),'productType': JSON.stringify(productType),'productSubType': JSON.stringify(productSubType),'productDescription': JSON.stringify(productDescription),'productWeight': JSON.stringify(productWeight),'productWeightType': JSON.stringify(productWeightType),'productQty': JSON.stringify(productQty),'productPrice': JSON.stringify(productPrice),'offerPrice': JSON.stringify(offerPrice),'productImg': JSON.stringify(productImg)},
										success:function(data)
										{
											$.ajax({
                                    url: '<?php echo base_url(); ?>backend/MyShopController/countInsertedRow',
                                    type: 'POST',
                                    data: { shopId: shopId },
                                    success: function (data) {
                                       var rowInserted = JSON.parse(data);
                                       var rowSelected = hot.countRows();
                                       console.log(rowInserted);
                                       console.log(rowSelected);
                                       if (rowInserted == rowSelected) {
                                           var base_url = window.location.origin;
                                           window.location.href= base_url +'/backend/MyShopController/viewProductsByShopId/'+shopId+'/datafrombaseDB';
                                        }
                                       else{
                                           //alert('not done');
                                           setTimeout(function () {
                                               var base_url = window.location.origin;
                                               window.location.href= base_url +'/backend/MyShopController/viewProductsByShopId/'+shopId+'/datafrombaseDB';
                                               }, 10000);
                                        }
                                    },
                                	});
										}
									});
								}
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