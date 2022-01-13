<!-- Header Layout Content -->
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
               <li class="breadcrumb-item active">My Shops</li>
            </ol>
            <h1 class="h2"><?php echo $fetchdatabyid->shop_name;?></h1>
            <ul class="nav nav-tabs">
               <!-- <li class="nav-item">
                  <a class="nav-link active" href="#first" data-toggle="tab"><?php echo $fetchdatabyid->shop_name;?></a>
               </li> -->
               &nbsp;
               <li class="nav-item">
                  <a class="nav-link active" href="#orders" data-toggle="tab">Orders</a>
               </li>
               &nbsp;
               <li class="nav-item">
                  <a class="nav-link" href="#crm" data-toggle="tab">CRM</a>
               </li>
               &nbsp;
               <li class="nav-item">
                  <a class="nav-link" href="#store_setting" data-toggle="tab">Store Settings</a>
               </li>
            </ul>
            <!-- <br> -->
            <div class="">
               <div class="tab-content ">
                  <div class="tab-pane" id="first">
                     <br>
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="card" style="background-color:lightgrey">
                              <div class="table-responsive border-bottom" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>
                                 <br>
                                 <div class="row">
                                    <div class="col-md-5">
                                       <a href="<?php echo base_url('backend/MyShopController/migrateMultiData/'. $fetchdatabyid->shopId);?>"><button type="button" class="btn btn-success">Migrate Products</button></a>
                                    </div>
                               
                                    <div class="col-md-3">
                                       <form method="post" action="<?php echo base_url('backend/ExportExcelController/exportProductData/'. $fetchdatabyid->shopId .'/'. $fetchdatabyid->shop_db_name);?>">
                                          <input type="submit" name="export" class="btn btn-success" value="Export"  style="float:right;"/>
                                       </form>
                                    </div>
                                    <div class="col-md-4">
                                       <form action="<?php echo base_url('backend/ImportExcelController/importProductData/'. $fetchdatabyid->shopId .'/'. $fetchdatabyid->shop_db_name);?>" method="post" enctype="multipart/form-data">
                                          <div class="row">
                                             <div class="col-md-9">
                                               <input type="file" class="form-control" name="uploadFile"/>
                                             </div>
                                             <div class="col-md-2">
                                               <input type="submit" name="submit" class="btn btn-success" value="Import"  style="float:right;" />
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                                 <table class="table mb-0">
                                    <thead>
                                       <tr>
                                          <th>#</th>
                                          <th>Product Category</th>
                                          <th>Product Name</th>
                                          <th>Product Description</th>
                                          <th>Product Price</th>
                                          <th>Product Image</th>
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                    <?php $i=1; if(!empty($shopProducts)){ foreach ($shopProducts as $key => $row) { ?>
                                       <tbody class="list" id="search">
                                          <tr>
                                             <td>
                                                <span class="js-lists-values-employee-name"><?php echo $i++;?></span>
                                             </td>
                                             <td>
                                                <span class="js-lists-values-employee-name"><?php echo $row->product_category_id;?></span>
                                             </td>
                                             <td>
                                                <span class="js-lists-values-employee-name"><?php echo $row->product_name;?></span>
                                             </td>
                                             <td>
                                                <span class="js-lists-values-employee-name"><?php echo $row->product_description;?></span>
                                             </td>
                                             <td>
                                                <span class="js-lists-values-employee-name">
                                                   <?php echo $row->product_price;?>
                                                </span>
                                             </td>


                                             <td>
                                                <span class="js-lists-values-employee-name">
                                                   <?php $uriSegments = explode("/", parse_url($row->product_img, PHP_URL_PATH));
                                                      $lastUriSegment = array_pop($uriSegments);
                                                   ?>
                                                   <?php echo $lastUriSegment;?>
                                                </span>
                                             </td>

                                             <td> 
                                                <a href="<?php echo base_url('StoreController/editStore/'.$row->product_id);?>" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>

                                                <a href="<?php echo base_url('StoreController/deleteStoreDetails/'.$row->product_id); ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete data?')?true:false;"><i class="fas fa-trash"></i></a> 
                                             </td>
                                          </tr>
                                       </tbody>
                                    <?php } }else{ ?>
                                       <tr><td colspan="6">Store(s) not found...</td></tr>
                                    <?php } ?>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane active" id="orders">
                     <br>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="card">
                              <div class="card-header">
                                 <h4>Pending Orders</h4>
                              </div>
                              <table class="table mb-0">
                                 <thead>
                                    <tr>
                                       <th>Order Id</th>
                                       <th>Customer Name</th>
                                       <th>Order Value</th>
                                       <th>Order Date</th>
                                    </tr>
                                 </thead>
                                 <?php if(!empty($shopCustPendingOrders)){ foreach ($shopCustPendingOrders as $key => $row) { ?>
                                    <tbody class="list" id="search">
                                       <tr>
                                          <td>
                                             <span class="js-lists-values-employee-name">
                                                <a href="<?php echo base_url('backend/MyShopController/pendingOrderDetails/'.$row->order_code. '/'. $fetchdatabyid->shopId);?>"><?php echo $row->order_code;?></a>
                                             </span>
                                          </td>
                                          <td>
                                             <span class="js-lists-values-employee-name"><?php echo $row->c_fname;?></span>
                                          </td>
                                          <td>
                                             <span class="js-lists-values-employee-name">&#8377; <?php echo $row->product_subtotal;?></span>
                                          </td>
                                          <td>
                                             <span class="js-lists-values-employee-name"><?php echo date('Y-m-d',strtotime($row->order_placed_date));?></span>
                                          </td>
                                       </tr>
                                    </tbody>
                                 <?php } }else{ ?>
                                    <tr><td colspan="6">No Pending orders</td></tr>
                                 <?php } ?>
                              </table>
                           </div>
                        </div>
                        <!-- <div class="vl"></div> -->
                        <div class="col-md-6">
                           <div class="card">
                              <div class="card-header">
                                 <h4>Completed Orders</h4>
                              </div>
                              <table class="table mb-0">
                                 <thead>
                                    <tr>
                                       <th>Order Id</th>
                                       <th>Customer Name</th>
                                       <th>Order Value</th>
                                       <th>Order Date</th>
                                    </tr>
                                 </thead>
                                 <?php if(!empty($shopCustOrders)){ foreach ($shopCustOrders as $key => $row) { ?>
                                    <tbody class="list" id="search">
                                       <tr>
                                          <td>
                                             <span class="js-lists-values-employee-name"><a href="<?php echo base_url('backend/MyShopController/completedOrderDetails/'.$row->order_code. '/'. $fetchdatabyid->shopId);?>"><?php echo $row->order_code;?></a></span>
                                          </td>
                                          <td>
                                             <span class="js-lists-values-employee-name"><?php echo $row->c_fname;?></span>
                                          </td>
                                          <td>
                                             <span class="js-lists-values-employee-name">&#8377; <?php echo $row->product_subtotal;?></span>
                                          </td>
                                          <td>
                                             <span class="js-lists-values-employee-name"><?php echo date('Y-m-d',strtotime($row->order_placed_date));?></span>
                                          </td>
                                       </tr>
                                    </tbody>
                                 <?php } }else{ ?>
                                    <tr><td colspan="6">Order(s) Not found</td></tr>
                                 <?php } ?>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="crm">
                     <br>
                     <div class="row">
                        <div class="col-sm-12">
                           <h1>CRM</h1>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="store_setting">
                     <br>
                     <div id="accordion">
                        <div class="card">
                           <div class="card-header" id="headingOne" style="background-color:#4C80E1">
                              <h5 class="mb-0">
                                 <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color:#fff;background-color:#32405A">
                                    Store Information
                                 </button>
                              </h5>
                           </div>

                           <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="row">
                                    <div class="col-lg-12">

                                       <form action="<?php echo base_url('backend/MyShopController/updateStoreInfo');?>" method="post" enctype="multipart/form-data">
                                          <div class="row">
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                   <label for="bname"><b>Shop Name</b></label>
                                                   <br>
                                                   <br>
                                                   <input required="" name="shop_name" id="shop_name" type="text" class="form-control"  value="<?php echo
                                                   $fetchdatabyid->shop_name;?>" readonly="" >
                                                   <input required="" name="shopId" type="hidden" class="form-control"  value="<?php echo
                                                   $fetchdatabyid->shopId;?>" readonly="" >
                                                </div>
                                             </div>
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                   <label for="menu"><b>Shop Address</b></label>
                                                   <br>
                                                   <br>
                                                   <input required="" name="shop_address" id="shop_address" type="text" class="form-control" value="<?php echo $fetchdatabyid->shop_address;?> " readonly="" >
                                                </div>
                                             </div>
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="bname"><b>Store GST [Goods and Services Tax]</b></label>
                                                    <br>
                                                   <br>
                                                    <input required="" name="shop_gst" id="shop_gst" type="text" class="form-control"  value="<?php echo $fetchdatabyid->shop_gst;?>" readonly="">
                                                   
                                                </div>
                                             </div>
                                          </div>

                                          <!--<div class="row">-->
                                          <!--   <div class="col-md-6">-->
                                          <!--      <div class="form-group">-->
                                          <!--         <label for="menu"><b>Brand Logo</b></label>&nbsp;&nbsp;<img src="<?php echo base_url().'assets/uploads/img/'. $fetchdatabyid->logo;?>" alt="Girl in a jacket" width="100" height="50" class="thumbnail">-->
                                          <!--         <br>-->
                                          <!--         <input name="shop_logo" id="shop_logo" type="file" class="form-control" readonly="">-->
                                          <!--      </div>-->
                                          <!--   </div>-->
                                          <!--</div>-->

                                          <br>
                                          <div class="form-group">
                                             <button type="" id="storeInfo" class="btn btn-info" name="storeInfo" style="background-color:#4C80E1;">Edit</button>
                                             <div class="" style="float:right">
                                                <?php if($fetchdatabyid->shop_status==2) {?>
                                                   <button id="button1" type="button" class="btn btn-info" data-toggle="modal" data-target="#activate">Activate</button>
                                                <?php } else {?>
                                                   <button id="button1" type="button" class="btn btn-warning" data-toggle="modal" data-target="#deactivate">Deactivate</button>
                                                   <!-- <a href="<?php echo base_url('backend/MyShopController/deactivateStore/'.$fetchdatabyid->shopId.'/'.$fetchdatabyid->shop_db_name); ?>" class="btn btn-info" onclick="return confirm('Are you sure to deactivate store?')?true:false;">Deactivate</a> -->
                                                <?php }?>
                                                &nbsp;
                                                <button id="button1" type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteShop"><i class="fas fa-trash"></i></button>
                                                <!-- <a href="<?php echo base_url('backend/MyShopController/deleteStore/'.$fetchdatabyid->shopId.'/'.$fetchdatabyid->shop_db_name); ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete store?')?true:false;"><i class="fas fa-trash"></i></a> -->
                                             </div>
                                          </div>
                                       </form>
                                       
                                    </div>  
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="card">
                           <div class="card-header" id="headingTwo" style="background-color:#4C80E1;">
                              <h5 class="mb-0">
                                 <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="color:#fff;background-color:#32405A">
                                    Store Payment Details
                                 </button>
                              </h5>
                           </div>
                           <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                              <div class="card-body">
                                 <a href="<?php echo base_url('backend/MyShopController/paymentSettingByStore/'. $fetchdatabyid->shopId);?>" class="btn btn-success" onclick="basicPopup(this.href);return false">Choose Payment Options</a>
                              
                                 <br>
                                 <br>
                                 <ul>
                                    <form action="<?php echo base_url('backend/PaymentController/updatePaymentSetting/'. $fetchdatabyid->shopId .'/'. $fetchdatabyid->shop_db_name);?>" method="post">
                                       <div class="row">
                                          <?php foreach($shopPaymentData as $spd) {?>
                                             <div class="col-md-4">
                                                <li class="list-group-item">
                                                   <div class="media align-items-center">
                                                      <div class="media-left">
                                                         <span class="btn btn-default btn-circle"><?php echo $spd->payment_p_icon?></span>
                                                      </div>
                                                      <div class="media-body">
                                                         <p class="mb-0"><?php echo $spd->pInfo_payment_name?></p>
                                                         <?php if($spd->default_payment ==0) {?>
                                                            <p style="font-size:12px;">Make Default
                                                                <?php if($spd->default_payment ==0) {?>
                                                                   <input type="checkbox" class="shop_pInfo_id" name="shop_pInfo_id" value="<?php echo $spd->shop_pInfo_id?>" style="margin-left:5px;">
                                                                <?php } else {?>
                                                                <?php }?>
                                                            </p>
                                                         <?php } else {?>
                                                            <p style="font-size:12px;">Default Payment</p>
                                                         <?php }?>  
                                                      </div>
                                                    </div>
                                                </li>
                                             </div>
                                          <?php }?>
                                       </div>
                                       <?php if(empty($shopPaymentData)) {?>
                                       <?php } else {?>
                                          <input type="submit" class="btn btn-success" name="submit"id="checkBtn"  value="submit">
                                       <?php }?>
                                    </form>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="card">
                           <div class="card-header" id="headingThree" style="background-color:#4C80E1">
                              <h5 class="mb-0">
                                 <a href="<?php echo base_url('backend/MyShopController/storeInfo/'.$fetchdatabyid->shopId);?>"><button class="btn btn-link" style="color:#fff;background-color:#32405A">
                                    Configuration
                                 </button></a>
                                 <!-- <button class="btn btn-link" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree" style="color:#fff;background-color:#32405A">
                                    Configuration
                                 </button> -->
                              </h5>
                           </div>

                           <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="row">
                                    <div class="col-lg-12">

                                       
                                    </div>  
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="card">
                           <div class="card-header" id="headingFour" style="background-color:#4C80E1;">
                              <h5 class="mb-0">
                                 <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" style="color:#fff;background-color:#32405A">
                                    Additional
                                 </button>
                              </h5>
                           </div>
                           <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="row">
                                    <div class="col-md-3">
                                       <span>
                                          <?php if($fetchdatabyid->home_delivery==0) {?>
                                             <strong>Home Delivery-<span style="color:red">Off</span></strong>
                                          <?php } else {?>
                                             <strong>Home Delivery-<span style="color:green">On</span></strong>
                                          <?php }?>
                                       </span>
                                    </div>
                                    <div class="col-md-4">
                                       <?php if($fetchdatabyid->home_delivery==0) {?>
                                             <a href="<?php echo base_url('backend/MyShopController/in_active/'.$fetchdatabyid->shopId);?>"><i class="fal fa-toggle-off fa-3x" style="color:red"></i></a>
                                       <?php } else {?>
                                             <a href="<?php echo base_url('backend/MyShopController/is_active/'.$fetchdatabyid->shopId);?>"><i class="fal fa-toggle-on fa-3x" style="color:green"></i></a>
                                       <?php }?>
                                    </div>
                                 </div>
                                 <form action="<?php echo base_url('backend/MyShopController/updateMinOrderVal/'. $fetchdatabyid->shopId);?>" method="post">
                                    <div class="row">
                                    
                                       <div class="col-md-3">
                                          <span>
                                             <strong>Minimum Order Value</strong>
                                          </span>
                                       </div>
                                    
                                       <div class="col-md-3">
                                          <input type="number" class="form-control" name="min_order_val" placeholder="Enter Minimum order value" value="<?php if(isset($fetchdatabyid->min_order_val)) { echo $fetchdatabyid->min_order_val; } ?>">
                                       </div>
                                       <div class="col-md-3">
                                          <div class="form-group">
                                             <input type="submit" class="btn btn-success" name="submit" value="Submit">
                                          </div>
                                       </div>
                                    </div>
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
      <div class="modal fade" id="deactivate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <form action="<?php echo base_url('backend/MyShopController/deactivateStore/'.$fetchdatabyid->shopId); ?>" method="post">
                  <div class="modal-body">
                     <?php if($fetchdatabyid->trial_activate==0) {?>
                        <?php if(date("Y-m-d",strtotime($fetchdatabyid->shop_exp_date)) < date("Y-m-d")) { ?>
                           <span style="color:red"><strong>Note: Subscription is expired for this store</strong></span>
                           <br>
                           <br>
                           <span>You can always reactivate the store and continue to use it.</span>
                           <br>
                           <br>
                           <span><strong>Are you sure to deactivate this store?</strong></span>
                        <?php } else {?>
                           <span style="color:red"><strong>Note: Subscription is active for this store</strong></span>
                           <br>
                           <br>
                           <span>Deactivating this store will not extend the expiry date of current subscription you can always reactivate the store within the subscription period and continue to use it.</span>
                           <br>
                           <br>
                           <span><strong>Do you confirm to deactivate the store?</strong></span>
                        <?php }?>
                     <?php } else {?>
                        <?php if(date("Y-m-d",strtotime($fetchdatabyid->shop_exp_date)) < date("Y-m-d")) { ?>
                           <span style="color:red"><strong>Note: Subscription is expired for this store</strong></span>
                           <br>
                           <br>
                           <span>You can always reactivate the store and continue to use it.</span>
                           <br>
                           <br>
                           <span><strong>Are you sure to deactivate this store?</strong></span>
                        <?php } else {?>
                           <span style="color:red"><strong>Note: Trial Period is active for this store</strong></span>
                           <br>
                           <br>
                           <span>Deactivating this store within the trial period ends the trial period and to reactivate the store you will have to activate the subscription. </span>
                           <br>
                           <br>
                           <span><strong>Do you wish to continue to deactivate the store?</strong></span>
                        <?php }?>
                     <?php }?>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                     <input type="submit" class="btn btn-success" name="deactivate" value="OK">
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div class="modal fade" id="activate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-body">
                  <?php if($fetchdatabyid->trial_activate==0) {?>
                     <?php if(date("Y-m-d",strtotime($fetchdatabyid->shop_exp_date)) < date("Y-m-d")) { ?>
                        <span><strong>Please copy the Store Unique Code and continue to make the payment </strong></span>
                        <div class="example" style="margin: 40px auto;width: 400px;">
                           <div class="input-group">
                              <input type='text' readonly="" id='input-text' value="<?php echo $fetchdatabyid->shopId?>">
                              <span class="input-group-button">
                                 <button onClick="copyToClipboard()">Copy to clipboard</button>
                              </span>
                           </div>
                        </div>
                     <?php } else {?>
                        <span><strong>Hoorraayyy!!! this shop hasn't expired yet.</strong></span>
                     <?php }?>
                  <?php } else {?>
                     <span><strong>Please copy the Store Unique Code and continue to make the payment </strong></span>
                     <div class="example" style="margin: 40px auto;width: 400px;">
                        <div class="input-group">
                           <input type='text' readonly="" id='input-text' value="<?php echo $fetchdatabyid->shopId?>">
                           <span class="input-group-button">
                              <button onClick="copyToClipboard()">Copy to clipboard</button>
                           </span>
                        </div>
                     </div>
                  <?php }?>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <?php if($fetchdatabyid->trial_activate==0) {?>
                     <?php if(date("Y-m-d",strtotime($fetchdatabyid->shop_exp_date)) < date("Y-m-d")) { ?>
                        <a href="https://direct-buy.in/Welcome/directbuy_plans" target="_blank" class="btn btn-success">OK</a>
                     <?php } else {?>
                        <a href="<?php echo base_url('backend/MyShopController/activateStore/'.$fetchdatabyid->shopId); ?>" class="btn btn-success">OK</a>
                     <?php }?>
                  <?php } else {?>
                     <a href="https://direct-buy.in/Welcome/directbuy_plans" class="btn btn-success">OK</a>
                  <?php }?>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="deleteShop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-body">
                  <span style="color:red"><strong>Deleting this store will delete all data including products, sales information etc.. </strong></span>
                  <br>
                  <span><strong>Do u wish to delete this store? If yes, you need to validate your account using OTP</strong></span>
                  <br>
                  <br>
                  <span><strong>Enter Email Address to receive OTP</strong></span>
                  <form  method="post" id="signinForm" >
                     <div class="example" style="margin: 40px auto;width: 400px;">
                        <div class="form-group">
                           <label><b>Email</b></label> &nbsp;
                           <input type='text' class="form-control" name="email" id="email" placeholder="Enter Email Address" required="">
                           <input type='hidden' class="form-control" name="shopId" id="shopId" value="<?php echo $fetchdatabyid->shopId?>" required="">
                        </div>
                     </div>
                     <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                     <input type="submit" class="btn btn-success" value="Proceed">
                  </form>
               </div>
               
            </div>
         </div>
      </div>
      <div class="modal fade" id="otp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-body">
                  <span><strong>Enter Email Address to receive OTP</strong></span>
                  <form  action="<?php echo base_url('backend/MyShopController/deleteStore/'.$fetchdatabyid->shopId);?>" method="post">
                     <div class="example" style="margin: 40px auto;width: 400px;">
                        <div class="form-group">
                           <label><b>Email</b></label> &nbsp;
                           <input type='email' class="form-control" name="email" id="email_id" >
                           <input type='hidden' class="form-control" name="shopId" id="shopId" value="<?php echo $fetchdatabyid->shopId?>" required="">
                        </div>
                        <div class="form-group">
                           <label class="form-label" for="otp" style="width:80px;">OTP</label>
                           <input name="otp" class="form-control" placeholder="Enter OTP" type="text" required/>
                        </div>
                     </div>
                     <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                     <input type="submit" class="btn btn-success" value="Verify OTP">
                  </form>
               </div>
               
            </div>
         </div>
      </div>
      <!-- End Page-content -->
      <?php $this->load->view('backend/include/sidebar');?>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
      <script>
            $(document).on('click', 'input[name="shop_pInfo_id"]', function() {      
                 $('input[name="shop_pInfo_id"]').not(this).prop('checked', false);      
             });
         $('#checkBtn').click(function() {
             checked = $("input[type=checkbox]:checked").length;

             if(!checked) {
                 alert("You must check at least one checkbox.");
                 return false;
             }

         });
         $(document).ready(function() {
            $("#signinForm").submit(function(e){
               e.preventDefault();
               var email = $('#email').val();
               var shopId = $('#shopId').val();
               sessionStorage.setItem("email", email);
               if(email != '')
               {
                  $.ajax({
                     url:"<?php echo base_url(); ?>backend/MyShopController/send_otp",
                     method:"POST",
                     data:{email:email,shopId:shopId},
                     success:function(data)
                     {
                        if(data == 0){
                           $("#msg").html('<div class="alert alert-danger">"Glad to you have here, to begin with we need to register you. Please click on the Register button, or wait we will take you there. Thank you."</div>');
                           //$("#msg").css("display", "block");
                        }else{
                           $("#deleteShop").modal('hide');
                           otp();
                           var email = data;
                           sessionStorage.setItem("email", email);
                        }
                     },
                     error:function(er){
                        console.log(er);
                     }
                  });
               }
            });
            function otp()
            {
               var emailId = sessionStorage.getItem("email");
               console.log(emailId);
               $('#otp').modal('show');
               document.getElementById('email_id').value = emailId;
            }
         });
      </script>
      <script>
         $(document).ready(function(){
            $('#storeInfo').click(function(){
               $('#shop_name').prop('readonly',false);
               $('#shop_address').prop('readonly',false);
               $('#shop_logo').prop('readonly',false);
               $('#shop_gst').prop('readonly',false);
               $('#storeInfo').replaceWith(`<button class="btn btn-success" value="submit">Update </button>`);
            });
         });
         function basicPopup(url) 
         {
            popupWindow = window.open(url,'popUpWindow','height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
         }
         function copyToClipboard() {
            var inputElement=document.getElementById('input-text');
            inputElement.select();
            document.execCommand('copy');
            //alert("Copied to clipboard");
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
         .vl {
           border-left: 1px solid grey;
           height: 500px;
         }
      </style>