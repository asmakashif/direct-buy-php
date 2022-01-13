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
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets1/css/main.css');?>">
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
						  	// rowHeaders: true,
						  	hiddenColumns: {
							    columns: [1],
							    indicators: false
							},
				// 			colWidths:[70, 99, 140, 170, 103, 160, 192, 192,
    //                                     192, 192, 192, 192, 192],
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
						  	language: 'en-US',
						  	licenseKey:"non-commercial-and-evaluation"
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

						    						checkData(storeId,db_SKU,category,sub_category,brand,product_name,product_type,product_sub_type,product_description,product_weight,product_weight_type,product_qty,product_price,offer_price,product_img);
						    					});
						    				}
						    			});
						    		}
						    	});
							 //  $.ajax({
							 //   	url:"<?php echo base_url(); ?>backend/MyShopController/updateBaseProduct",
							 //   	method:"POST",
							 //   	dataType: "json",
							 //   	data:{'id':id,'cat':cat,'subcat': subcat,'brand': brand,'productName': productName,'productType': productType,'productSubType': productSubType,'productWeight':productWeight,'productWeightType':productWeightType,'productQty':productQty,'productPrice':productPrice,'offerPrice': offerPrice,'productImg': productImg,'productDescription': productDescription},
							 //   	success:function(data)
							 //   	{
							 //   		console.log(data);
							 //   	}
							 //  });

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
										data:{storeId:storeId},
										success:function(data)
										{
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
                                                   window.location.href= base_url +'/backend/MyShopController/storeInfo/'+shopId+'';
                                                }
                                               else{
                        							    setTimeout(function () {
                                                        var base_url = window.location.origin;
                                                        window.location.href= base_url +'/backend/MyShopController/storeInfo/'+shopId+'';
                                                    }, 50000);
                        								
                        							}
                                            },
                                        	});
                						},
                						error:function(err){
                                            console.log(err);
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
