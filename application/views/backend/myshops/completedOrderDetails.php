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
               <li class="breadcrumb-item"><a href="<?php echo base_url('backend/MyShopController/myShop/'.$shopId)?>">My Shop</a></li>
               <li class="breadcrumb-item active">Completed Orders</li>
            </ol>
            <?php if(isset($orderData) && is_array($orderData) && count($orderData)): $i=1; foreach ($orderData as $key => $data) { ?>
               <h1 class="h2">Order Details - <?php echo '#' . $data['order_code'];?></h1>
            <?php } endif; ?>
            <div class="card">
               <div class="card-body">
                  <?php if(isset($orderData) && is_array($orderData) && count($orderData)): $i=1; foreach ($orderData as $key => $data) { ?>
                     <div class="row">
                        <div class="row">
                           <strong>&nbsp;&nbsp;&nbsp;Product id &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</strong><?php echo '#' . $data['order_code'];?>
                        </div>
                     </div>
                     <div class="row">
                        <strong> Billing Name &nbsp;:&nbsp;&nbsp;</strong><?php echo $data['c_fname']; ?>
                     </div>
                  <?php } endif; ?>

                  <table class="table table-centered table-nowrap">
                        <?php if($orderDataRow['product_name']=='null') {  ?>
                            <div class="card-header">
                                <h2>Uploaded Prescription</h2>
                            </div>
                            <div class="card-body">
                                <img class="center" src="<?php echo base_url().'assets/uploads/prescription/'. $orderDataRow['upload'];?>" alt="">
                            </div>
                        <?php } else { ?> 
                             <thead>
                                <tr>
                                   <th>Product</th>
                                   <th>Product Name</th>
                                   <th>Price</th>
                                </tr>
                             </thead>
                             <tbody class="list" id="search">
                                <?php
                                if(isset($completedOrders) && is_array($completedOrders) && count($completedOrders)): $i=1;
                                foreach ($completedOrders as $key => $data) { 
                                   ?>
                                   <tr>
                                      <td><img style="height: 100px;width:100px" src="<?php echo $data['product_img']; ?>" alt="" class="avatar sm"></td>
                                      <td>
                                         <div>
                                            <h5 class="text-truncate font-size-14"><?php echo $data['product_name']; ?></h5>
        
                                            <p class="text-muted mb-0"><?php echo $data['product_price']; ?> x <?php echo $data['product_qty']; ?></p>
                                         </div>
                                      </td>
                                      <td>&#8377; <?php echo $data['product_subtotal']; ?></td>
                                   </tr>
                                <?php } endif; ?>
                             </tbody>
                             <tfoot>
                                <?php if(isset($orderData) && is_array($orderData) && count($orderData)): $i=1;
                                foreach ($orderData as $key => $data) { 
                                   ?>
                                   <?php if(empty($data['tax_amount'])) {?>
                                   <?php } else {?>
                                       <tr>
                                          <td colspan="2">
                                             <h6 class="m-0 text-right">Tax:</h6>
                                          </td>
                                          <td>
                                             &#8377; <!-- <?php echo $data['tax_amount']; ?> -->
                                          </td>
                                       </tr>
                                    <?php }?>
                                    <?php if(empty($data['discount_amount'])) {?>
                                    <?php } else {?>
                                   <tr>
                                      <td colspan="2">
                                         <h6 class="m-0 text-right">Discount@50%:</h6>
                                      </td>
                                      <td>
                                         &#8377; <!-- <?php echo $data['discount_amount']; ?> -->
                                      </td>
                                   </tr>
                                   <?php }?>
                                   <tr>
                                      <td colspan="2">
                                         <h6 class="m-0 text-right">Total:</h6>
                                      </td>
                                      <td>
                                         &#8377; <?php echo $data['total']; ?>
                                      </td>
                                   </tr>
                                <?php } endif; ?>
                             </tfoot>
                        <?php }?>
                  </table>
               </div>
            </div>
         </div>
         <!-- container-fluid -->
      </div>
      <!-- End Page-content -->
      <?php $this->load->view('backend/include/sidebar');?>
      <style>
          .center {
          display: block;
          margin-left: auto;
          margin-right: auto;
          width: 50%;
        }
      </style>