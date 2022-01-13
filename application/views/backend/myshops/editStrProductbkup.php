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
						<a class="nav-link" style="cursor: pointer">Store Configuration</a>
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
					
					<div class="tab-pane active" id="product_config">
						<div class="row">
							<div class="col-lg-12">
								<div class="card">
									<div class="card-body">
										<div class="fixTableHead">
											<table id="mytable" class="w3-table-all record_table">
												<thead>
													<tr>
														<th>Category</th>
														<th>SubCategory</th>
														<th>Brand</th>
														<th style="width:100px;"><input type="button" id="save_value" name="save_value" value="Add" style="height:25px" /></th>
													</tr>
												</thead>
												<tbody>
													<?php foreach($baseProducts as $row) {?>
														<tr>
															<td><?php echo $row['category'];?></td>
															<td><?php echo $row['sub_category'];?></td>
															<td><?php echo $row['brand'];?></td>
															<!-- <td>
																<input type="button" class="btn btn-success adddata" value="Add" id="<?=$row['base_product_id']?>">
															</td> -->
															<td>
																<input type="checkbox" class="adddata" name="chk[]" value="<?=$row['base_product_id']?>" id="<?=$row['base_product_id']?>" style="height:15px;width:15px" checked>
															</td>
														</tr>
													<?php }?>
												</tbody>
											</table>
										</div>
										<hr>
										<h3>List of Products</h3>
	                           <form name="frm-example" id="frm-example" method="POST">
	                               
	                               <div class="row">
	                                   <div class="col-md-6">
	                                       <span id='message' ></span>
	                                   </div>
	                                   <div class="col-md-4">
	                                       <img id="bigpic" src="<?php echo base_url('assets1/img/Flat_hourglass.gif');?>" style="display:none"/>
	                                   </div>
	                               </div>
	                                 
	                               
	                              <div class="NofixTableHead">
	                                 <table id="example" class="table table-centered table-nowrap display">
	                                 	<thead class="thead-light">
	                                 		<tr>
	                                 			<th>Id</th>
	                                 			<th>SKU</th>
	                                 			<th>Category</th>
	                                 			<th>SubCategory</th>
	                                 			<th>Brand</th>
	                                 			<th>Name</th>
	                                 			<th>Type</th>
	                                 			<th>SubType</th>
	                                 			<th>Description</th>
	                                 			<th>Weight</th>
	                                 			<th>SubWeight</th>
	                                 			<th>Qty</th>
	                                 			<th>Price</th>
	                                 			<th>OfferPrice</th>
	                                 			<th>Img</th>
	                                 		</tr>
	                                 	</thead>
	                                 	<tbody id="displayArea"></tbody>
	                                 	<tbody>
	                                 		<tr>
	                                 			<td>
	                                 			    <input class="btn btn-success" type="button" value="Submit" id="QAdddata" >
	                                 			</td>
	                                 		</tr>
	                                 	</tbody>
	                                 </table>
	                              </div>
	                           </form>
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
		<script type="text/javascript" src="<?php echo base_url('assets1/js/ddtf.js');?>"></script>
		<script type="text/javascript">
			$('#mytable').ddTableFilter();
			$(document).ready(function() {
			    
				$('.record_table tr').click(function(event) {
					if (event.target.type !== 'checkbox') {
						$(':checkbox', this).trigger('click');
					}
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#save_value').click(function(){
		        	var val = [];
	        		$(':checkbox:checked').each(function(i){
	        		
		        		val[i] = $(this).val();
		        		var id = val[i];
		        		var URL = window.location.href;
						var arr=URL.split('/');
						var storeId = arr[6];
						if (id != '')
	        			{
							$.ajax({
	               		url:"<?php echo base_url(); ?>backend/MyShopController/fetchBaseProductsById",
	               		method:"POST",
	               		data:{id:id},
	               		success:function(data)
	               		{
	               			var obj = jQuery.parseJSON(data);
	               			$.each(obj, function(i, item) {
	               				var rows = "";
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
							        	var base_url = window.location.origin;

							        	rows += "<tr data-index="+ id +"><td>" + db_SKU + "</td><td>" + category + "</td><td>" + sub_category + "</td><td>" + brand + "</td><td>" + product_name + "</td><td>" + product_type + "</td><td>" + product_sub_type + "</td><td>" + product_description + "</td><td>" + product_weight + "</td><td>" + product_weight_type + "</td><td>" + product_qty + "</td><td>" + product_price + "</td><td>" + offer_price + "</td><td>" + product_img + "</td></tr>";
	                    			$(rows).appendTo("#displayArea");
	                    			$('#QAdddata').click(function()
	                    			{
	                    			    $('#message').html('Data is being uploaded please wait while we finish uploading the data.').css('color', 'red');
	                    			    document.getElementById('bigpic').style.display='block';
                                        $('#QAdddata').prop('disabled',true);
	                        		    checkData(storeId,db_SKU,category,sub_category,brand,product_name,product_type,product_sub_type,product_description,product_weight,product_weight_type,product_qty,product_price,offer_price,product_img);
	                    			});
	                    			
							      });
	               		}
	               	});
						}
					});
	        	});
				function checkData(storeId,db_SKU,category,sub_category,brand,product_name,product_type,product_sub_type,product_description,product_weight,product_weight_type,product_qty,product_price,offer_price,product_img)
				{
					var storeId = storeId;
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
						url:"<?php echo base_url(); ?>backend/MyShopController/checkBaseProductInTemp/"+storeId+"",
						method:"POST",
						data:{'storeId': JSON.stringify(storeId)},
									
						success:function(data)
						{
						  //  console.log(data);
						    submitData(storeId,db_SKU,category,sub_category,brand,product_name,product_type,product_sub_type,product_description,product_weight,product_weight_type,product_qty,product_price,offer_price,product_img);
		
						}
					});
				}
				function submitData(storeId,db_SKU,category,sub_category,brand,product_name,product_type,product_sub_type,product_description,product_weight,product_weight_type,product_qty,product_price,offer_price,product_img)
				{
					var storeid = storeId;
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
						  //  console.log(data);
						    checkStrData(storeId,db_SKU,category,sub_category,brand,product_name,product_type,product_sub_type,product_description,product_weight,product_weight_type,product_qty,product_price,offer_price,product_img);
						}
					});
				}
				function checkStrData(storeId,db_SKU,category,sub_category,brand,product_name,product_type,product_sub_type,product_description,product_weight,product_weight_type,product_qty,product_price,offer_price,product_img)
				{
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
						url:"<?php echo base_url(); ?>backend/MyShopController/checkStrBaseProductInTemp/"+shopId+"",
						method:"POST",
						data:{'shopId': JSON.stringify(shopId)},
									
						success:function(data)
						{
							submitDataToStr(shopId,db_SKU,category,sub_category,brand,product_name,product_type,product_sub_type,product_description,product_weight,product_weight_type,product_qty,product_price,offer_price,product_img);
						}
					});
				}
				function submitDataToStr(shopId,db_SKU,category,sub_category,brand,product_name,product_type,product_sub_type,product_description,product_weight,product_weight_type,product_qty,product_price,offer_price,product_img)
				{
					var shopId = shopId;
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
						
						url:"<?php echo base_url(); ?>backend/MyShopController/saveBaseProductsToStrTemp/"+shopId+"",
						method:"POST",
						dataType: "json",
						data:{'shopId': JSON.stringify(shopId),'sku': JSON.stringify(sku),'cat': JSON.stringify(cat),'subcat': JSON.stringify(subcat),'brand': JSON.stringify(brand),'productName': JSON.stringify(productName),'productType': JSON.stringify(productType),'productSubType': JSON.stringify(productSubType),'productDescription': JSON.stringify(productDescription),'productWeight': JSON.stringify(productWeight),'productWeightType': JSON.stringify(productWeightType),'productQty': JSON.stringify(productQty),'productPrice': JSON.stringify(productPrice),'offerPrice': JSON.stringify(offerPrice),'productImg': JSON.stringify(productImg)},
						success:function(data)
						{
						    console.log(data);
						    
							if(data==1){
							    setTimeout(function () {
                                    var base_url = window.location.origin;
                                    window.location.href= base_url +'/backend/MyShopController/storeInfo/'+shopId+'';
                                }, 50000);
                            }
							else{
							    var base_url = window.location.origin;
							    window.location.href= base_url +'/backend/MyShopController/editStrProductConfig/'+shopId+'/datafrombaseDB';
								
							}
						},
						error:function(err){
                            console.log(err);
                        }
					});
				}
			});
		</script>
		<script type="text/javascript">
			function PharmaCheck()
			{
				if (document.getElementById('yesPharma').checked)
				{
					document.getElementById('ifYesPharma').style.display = 'block';
					document.getElementById('ifNoPharma').style.display = 'none';
					document.getElementById('ifYes').style.display = 'none';
					document.getElementById('ifComfortable').style.display = 'none';
					document.getElementById('ifExport').style.display = 'none';
					document.getElementById('ifMaybe').style.display = 'none';
					document.getElementById('ifMaybeYes').style.display = 'none';
					document.getElementById('ifMaybeExport').style.display = 'none';
					document.getElementById('ifHelp').style.display = 'none';
					document.getElementById('ifNo').style.display = 'none';
					$("input:radio[name=maybe]:checked")[0].checked = false;
				}
				else{	
					document.getElementById('ifYesPharma').style.display = 'none';
				}
				if (document.getElementById('noPharma').checked) 
				{
					document.getElementById('ifNoPharma').style.display = 'block';
					document.getElementById('ifMaybeExport').style.display = 'none';
					document.getElementById('ifMaybe').style.display = 'none';
					document.getElementById('ifMaybeYes').style.display = 'none';
					document.getElementById('ifHelp').style.display = 'none';
					document.getElementById('ifNo').style.display = 'none';
					$("input:radio[name=maybe]:checked")[0].checked = false;
				}
				else{	document.getElementById('ifNoPharma').style.display = 'none';
				}
			}
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
				else{	document.getElementById('ifYes').style.display = 'none';
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
				}
				else
				{
					document.getElementById('ifNo').style.display = 'none';
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
				else{	document.getElementById('ifComfortable').style.display = 'none';
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
				else {	document.getElementById('ifExport').style.display = 'none';
				}
			}

			function maybeCheck() 
			{
				if (document.getElementById('maybeYesCheck').checked) 
				{
					document.getElementById('ifMaybeYes').style.display = 'block';
					document.getElementById('ifMaybeExport').style.display = 'none';
				}
				else{	document.getElementById('ifMaybeYes').style.display = 'none';
				}

				if (document.getElementById('maybeNoCheck').checked) 
				{
					document.getElementById('ifHelp').style.display = 'block';
					document.getElementById("ifHelp").disabled = true;
				}
				else
				{
					document.getElementById('ifHelp').style.display = 'none';
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
				{			
					document.getElementById('ifMaybeExport').style.display = 'none';
				}
			}
		</script>