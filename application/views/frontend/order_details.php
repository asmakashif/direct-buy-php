<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">
</br>
<div class="container">
    <div class="row">
        <div class="col-md-2">
        </div>
        <?php if($cus_data->store_pickup==0) { ?>
            <div class="col-md-8">
                <div class="card">
                    <?php if($cus_data->c_address1 =='null' || $cus_data->c_address2 =='null') { ?>
                        <div class="card-header">Order Details (Select/Add addresss to proceed)</div>
                    <?php } else { ?>
                        <div class="card-header">Order Details </div>
                    <?php } ?>
                    <div class="card-body">
                        <div class="row">
                            <?php if($cust_details->upload=='null'){?>
                                <div class="col-md-12">
                                    <p style="font-size:13px">Address : <?php echo $cust_details->	c_address1 ?><?php echo $cust_details->	c_address2 ?>,<?php echo $cust_details->city ?>,<?php echo $cust_details->pincode ?>
                                    <br/><?php echo $cust_details->c_mobile ?></p>
                                </div>
                            <?php } else{ ?>
                                <?php if($cus_data->c_address1 =='null' || $cus_data->c_address2 =='null') { ?>
                                    <div class="col-md-12">
                                        <?php if(!empty($user_address)) {?>
                                            <div class="card">
                                                <div class="card-header">
                                                    <a  data-toggle="collapse" href="#multiCollapseExample2"class="panel-title" role="button" aria-expanded="false" aria-controls="multiCollapseExample2"> Select address</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="collapse multi-collapse" id="multiCollapseExample2">
                                                        <div class="card card-body">
                                                            <form  action="<?php echo base_url('welcome/updateSeletedAdrr/'.$cust_details->order_code); ?>" method="POST">
                                                                <div class="row">
                                                                    <?php  foreach($user_address as $row){ ?>
                                                                        <div class="col">
                                                                            <label ><input type="radio" name="address" value="<?php echo $row->id?>"><?php echo $row->address1 ?>,<?php echo $row->address2 ?>,<?php echo $row->City ?>,<?php echo $row->pincode ?></label>
                                                                        </div>
                                                                        <?php 
                                                                    } ?>
                                                                </div>
                                                                <br/>
                                                                <input type="submit" name="Submit" value="Submit" class="btn btn-success btn-sm"/>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-12">
                                    </br>
                                    <div class="card">
                                        <div class="card-header">
                                            <a  data-toggle="collapse" href="#multiCollapseExample1" role="button" class="panel-title"  aria-expanded="false" aria-controls="multiCollapseExample1">Add new address</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                                <div class="card card-body">
                                                    Add Address :
                                                    <form id="login-form" class="form" action="<?php echo base_url('welcome/add_address_here/'.$cust_details->order_code);?>" method="post">
                                                        <div class="row" >
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"  id="building_name" name="building_name" placeholder="Address 1" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"  id="street_address" name="street_address" placeholder="Address 2 " >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br/>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" name="City" placeholder="City">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"  name="Pincode" placeholder="Pincode">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br/>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <!--<a  style="color: white;" class="btn btn-info btn-sm" id="update">Edit</a>-->
                                                                <input type="submit" name="Submit" value="Submit" class="btn btn-success btn-sm"/>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <br/>
                                    <div class="col-md-12">
                                        <p style="font-size:13px">Address : <?php echo $cust_details->	c_address1 ?><?php echo $cust_details->	c_address2 ?>,<?php echo $cust_details->city ?>,<?php echo $cust_details->pincode ?>
                                        <br/><?php echo $cust_details->c_mobile ?></p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <a class="my-0"  data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Add new address</a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="collapse multi-collapse" id="multiCollapseExample1">
                                                    <div class="card card-body">
                                                        Add Address :
                                                        <form id="login-form" class="form" action="<?php echo base_url('welcome/add_address_here/'.$cust_details->order_code);?>" method="post">
                                                            <div class="row" >
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"  id="building_name" name="building_name" placeholder="Address 1" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"  id="street_address" name="street_address" placeholder="Address 2 " >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br/>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="City" placeholder="City">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"  name="Pincode" placeholder="Pincode">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br/>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <!--<a  style="color: white;" class="btn btn-info btn-sm" id="update">Edit</a>-->
                                                                    <input type="submit" name="Submit" value="Submit" class="btn btn-success btn-sm"/>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($cus_data->c_address1 =='null' || $cus_data->c_address2 =='null') { ?> 
                                        <div class="col-md-12">
                                            <br/>
                                            <div class="card">
                                                <div class="card-header">
                                                    <a  data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">Select address</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="collapse multi-collapse" id="multiCollapseExample2">
                                                        <div class="card card-body">
                                                            <form  action="<?php echo base_url('welcome/updateSeletedAdrr/'.$cust_details->order_code); ?>" method="POST">
                                                                <div class="row">
                                                                    <?php  foreach($user_address as $row){ ?>
                                                                        <div class="col">
                                                                            <label ><input type="radio" name="address" value="<?php echo $row->id?>"><?php echo $row->address1 ?>,<?php echo $row->address2 ?>,<?php echo $row->City ?>,<?php echo $row->pincode ?></label>
                                                                        </div>
                                                                        <?php 
                                                                    } ?>
                                                                </div>
                                                                <br/>
                                                                <input type="submit" name="Submit" value="Submit" class="btn btn-success btn-sm"/>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>   
                                    <?php  } } } ?>
                                </div>
                                <?php if($cust_details->upload=='null'){?> 
                                    <div class="row">
                                        <?php if(!empty($order_details)){ foreach($order_details as $row){?>
                                            <div class="col-md-4">
                                                <img  src=<?php echo $row->product_img ?>" alt="" class="productImage" >
                                            </div>
                                            <div class="col-md-4">
                                                <h7 style="text-align:center"> <?php echo $row->product_name ?></h7>
                                                <br/>
                                                <small class="text-muted">&#8377;<?php echo $row->product_price ?>*<?php echo $row->product_qty ?></small>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="text-center">&#8377; <?php echo $row->product_subtotal ?></p>
                                            </div>
                                        <?php }}?>
                                    </div>
                                <?php } else {?>
                                    <br/>
                                    <img style="width:100%; " src="<?php echo base_url().'assets/uploads/prescription/'.$cust_details->upload;?>">
                                <?php } ?>
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text-center">Total : &#8377; <?php echo $cust_details->total ?></p>
                                        <br/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else {?>
                    
                    <div class="row">
                     <div class="col-md-4">
                    <p class="text-center"><b>Order Type</b> : Store Pickup</p>
                      
                    </div>
                    <div class="col-md-4">
                    <p class="text-center"><b>Store Name</b> : <?php echo $store_data->shop_name ?></p>
                     </div>
                     <div class="col-md-4">
                    <p class="text-center"><b>Address</b> : <?php echo $store_data->shop_address ?></p>
                    </div>
                    </div>
                    <?php if($cust_details->upload=='null'){?> 
                    <h7>Products Details</h7>
                        <div class="row">
                        
                            <?php if(!empty($order_details)){ foreach($order_details as $row){?>
                                <div class="col-md-4">
                                    <img  src=<?php echo $row->product_img ?>" alt="" class="productImage" >
                                </div>
                                <div class="col-md-4">
                                    <h7 style="text-align:center"> <?php echo $row->product_name ?></h7>
                                    <br/>
                                    <small class="text-muted">&#8377;<?php echo $row->product_price ?>*<?php echo $row->product_qty ?></small>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-center">&#8377; <?php echo $row->product_subtotal ?></p>
                                </div>
                            <?php }}?>
                            
                        </div>
                    <?php } else {?>
                     <?php if($cust_details->total<$store_data->min_order_val) {?>
                            <p class="text-center"><a href="<?php echo base_url('frontend/checkout/select_home_delivery/'.$cust_details->order_code);?>">Select Home Delivery</a></p>
                            <?php  }?>
                        <br/>
                        <img style="width:100%; " src="<?php echo base_url().'assets/uploads/prescription/'.$cust_details->upload;?>">
                    <?php } ?>
                <?php } ?>
                <div class="col-md-2">
                </div>
            </div>
        </div>
        <style>
        .panel-title:after {
            font-family: FontAwesome;
            content: "\f107";
            float: right;
            color: grey;
        }

        .panel-title[aria-expanded="true"]:after {
            content: "\f106";
        }
        .row{
            width:100%;
        }
        img{
            width:20%
        }
        a{
            color:black;

        }
        @media only screen and (max-width: 600px) {
            img{
                width:100%
            }
        }
    </style>