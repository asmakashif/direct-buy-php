  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Direct-Buy</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('');?>assets/css/bootstrap.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('');?>assets/css/bootstrap.css" media="all" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" integrity="undefined" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('');?>assets1/css/app.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="<?php echo base_url('');?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('');?>assets/js/jquery.js"></script>
    <!--<script src="<?php echo base_url('');?>assets1/js/app.js"></script>-->
  </head>
  <body style="padding-right: 0px;">
    <?php $url = $_SERVER['REQUEST_URI'];
      $url = explode("/", $url);
      $id = $url[count($url) - 1];?>
      <div class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div style="float:right" id="cart-icon">
            <a data-toggle="modal" data-target="#myModal" class="icon-shopping-cart" id="show-cart"> <i class="fa fa-shopping-cart"></i></a>
            <a  data-toggle="modal" data-target="#myModal"  class="icon-shopping-cart" >
              <asp:Label ID="lblCartCount" runat="server" CssClass="badge badge-warning"  ForeColor="White"/><?php echo $this->cart->total_items() ?></a>
            </div>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <?php if(!$this->session->userdata('is_logged_in')) { ?>
              <a class="navbar-brand" href="<?php echo base_url('Welcome/index')?>">Home</a>
              <?php } else { ?>
              <!--<a class="navbar-brand" href="<?php echo base_url('Welcome/Home/'.$this->session->userdata('store_id').'/'.$this->session->userdata('store_name'))?>">Home</a>-->
              <ul class="navbar-nav ">
                <li class="nav-item">
                  <a class="nav-link dropdown-toggle" style="color: white;"   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Home
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php if($id=='select_store'){?>
                    <?php } else { ?>
                    <a class="dropdown-item" href="<?php echo base_url('Welcome/Home/'.$this->session->userdata('store_id').'/'.$this->session->userdata('store_name'))?>">Home</a>
                    <?php }?>
                    <a class="dropdown-item" href="<?php echo base_url('welcome/select_store');?>">All Stores</a>
                  </li>
                </ul>
                <?php } ?>
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                  <li class="nav-item">
                    <?php if(!$this->session->userdata('is_logged_in')) { ?>
                    <a class="navbar-brand"  href="<?php echo base_url('Welcome/index')?>" ><i class="fas fa-sign-in-alt"></i>&nbsp;Sign In</a>
                    <?php } else{ ?> 
                    <a class="nav-link dropdown-toggle" style="color: white;" id="navbarDropdown"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      My Account
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="<?php echo base_url('Welcome/customer_profile');?>"><i class="fas fa-user"></i>&nbsp;Profile</a>
                      <a class="dropdown-item" href="<?php echo base_url('welcome/logout');?>"><i class="fas fa-sign-out-alt"></i>&nbsp;Signout</a>
                      <?php }?>
                    </li>
                  </ul>
                  <?php if(!$this->session->userdata('is_logged_in')) { ?>
                  <?php } else{ ?>
                  <div class="desktop-cart">
                    <a data-toggle="modal" data-target="#myModal" class="icon-shopping-cart" id="show-cart"> <i class="fa fa-shopping-cart"></i></a>
                    <a  data-toggle="modal" data-target="#myModal"  class="icon-shopping-cart" >
                      <asp:Label ID="lblCartCount" runat="server" CssClass="badge badge-warning"  ForeColor="White"/><?php echo $this->cart->total_items() ?></a>
                    </div>
                    <?php }?>
                  </nav>
                  <div id="myModal" class="modal fade" >
                    <div class="modal-dialog">
                      <!-- Modal content -->
                      <div class="modal-content">
                        <!-- header -->
                        <div class="modal-header">
                          <h7>Your Cart</h7>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="cart">
                          <div class="table-responsive">
                            <table class="table table-bordered">
                              <tr>
                                <th width="50%" style="font-size: 13px;" >Name</th>
                                <th  id="floatqty">Qty</th>
                                <th width="1%" style="font-size: 13px;">Price</th>
                                <th width="1%" style="font-size: 13px;">Total</th>
                                <th width="1%"></th>
                              </tr>
                              <?php $count = 0;
                                foreach($this->cart->contents() as $items)
                                { ?>
                                <?php $count++; ?>
                                <tr class="mytd"> 
                                  <td style="font-size: 15px;"><?php echo $items["name"] ?>
                                  </td>
                                  <td id="floatqty">
                                    <div class="input-group" id="input">
                                      <input type="hidden" name="rowid"  value="<?php echo  $items["rowid"] ?>">
                                      <button  id="dec" class="decb" type="button">-</button>
                                      <input type="text" class="form-control" name="qty" maxlength="3" id="num" value="<?php echo  $items["qty"] ?>" >
                                      <button   id="inc"class="incb" type="button">+</button>
                                      <input type="hidden" class="price" name="price"  value="<?php echo  $items["price"] ?>">
                                      <input type="hidden" class="subtotal" name="subtotal"  value="<?php echo   $items["subtotal"] ?>">
                                    </div>
                                  </td>
                                  <td ><?php echo  $items["price"] ?></td>
                                  <td class="disc">
                                    <?php echo  $items["subtotal"] ?>
                                  </td>
                                  <td><a style="color: red" href="<?php echo base_url('Welcome/remove_item/'.$items["rowid"]);?>" ><i class="far fa-trash-alt"></i></a></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                  <td colspan="4" align="right">Total</td>
                                  <td><span class="grandtotal"><?php echo $this->cart->total() ?></span><span class="grandtotal1">0</span></td>
                                </tr>
                              </table>
                              <?php if($count != 0)
                                { ?>
                                <?php if($homeDelivery->home_delivery==1){
                                  if($homeDelivery->min_order_val<=$this->cart->total()){?>
                                    <form action="<?php echo base_url('frontend/checkout/place_order');?>" method="post">
                                      <?php $count = 0;
                                        foreach($this->cart->contents() as $items)
                                        { ?>
                                        <?php $count++; ?>
                                        <input type="hidden" name="rowid"  value="<?php echo  $items["rowid"] ?>">
                                        <input type="hidden" name="product_name"  value="<?php echo  $items["name"] ?>">
                                        <input type="hidden" name="qty"  value="<?php echo  $items["qty"] ?>">
                                        <input type="hidden" name="price"  value="<?php echo  $items["price"] ?>">
                                        <input type="hidden" name="sub_total"  value="<?php echo   $items["subtotal"] ?>">
                                        <input type="hidden" name="total"  value="<?php echo $this->cart->total() ?>">
                                        <?php  } ?> 
                                        <a style="color:white" href="<?php echo base_url('Welcome/addtocart');?>" class="btn btn-warning btn-sm" >View Details</a>
                                        <div style="float: right;" >
                                          <!--<a  href="" class="btn btn-danger btn-sm" >Update Cart</a>-->
                                          <input class="btn btn-success btn-sm" type="submit" name="Submit" value="Checkout"/>
                                        </div>
                                      </form>
                                      <?php } else{?>
                                      <p>Please shop more than <?php echo $homeDelivery->min_order_val ?> to get home delivery</p>
                                      <form action="<?php echo base_url('frontend/checkout/store_pickup');?>" method="post">
                                        <?php $count = 0;
                                          foreach($this->cart->contents() as $items)
                                          { ?>
                                          <?php $count++; ?>
                                          <input type="hidden" name="rowid"  value="<?php echo  $items["rowid"] ?>">
                                          <input type="hidden" name="product_name"  value="<?php echo  $items["name"] ?>">
                                          <input type="hidden" name="qty"  value="<?php echo  $items["qty"] ?>">
                                          <input type="hidden" name="price"  value="<?php echo  $items["price"] ?>">
                                          <input type="hidden" name="sub_total"  value="<?php echo   $items["subtotal"] ?>">
                                          <input type="hidden" name="total"  value="<?php echo $this->cart->total() ?>">
                                          <?php  } ?> 
                                          <a style="color:white" href="<?php echo base_url('Welcome/addtocart');?>" class="btn btn-warning btn-sm" >View Details</a>
                                          <div style="float: right;" >
                                            <!--<a  href="" class="btn btn-danger btn-sm" >Update Cart</a>-->
                                            <input class="btn btn-success btn-sm" type="submit" name="Submit" value="Checkout"/>
                                          </div>
                                        </form>
                                        <?php } ?>

                                        <?php } else { ?>
                                        <form action="<?php echo base_url('frontend/checkout/store_pickup');?>" method="post">
                                          <?php $count = 0;
                                            foreach($this->cart->contents() as $items)
                                            { ?>
                                            <?php $count++; ?>
                                            <input type="hidden" name="rowid"  value="<?php echo  $items["rowid"] ?>">
                                            <input type="hidden" name="product_name"  value="<?php echo  $items["name"] ?>">
                                            <input type="hidden" name="qty"  value="<?php echo  $items["qty"] ?>">
                                            <input type="hidden" name="price"  value="<?php echo  $items["price"] ?>">
                                            <input type="hidden" name="sub_total"  value="<?php echo   $items["subtotal"] ?>">
                                            <input type="hidden" name="total"  value="<?php echo $this->cart->total() ?>">
                                            <?php  } ?> 
                                            <a style="color:white" href="<?php echo base_url('Welcome/addtocart');?>" class="btn btn-warning btn-sm" >View Details</a>
                                            <div style="float: right;" >
                                              <!--<a  href="" class="btn btn-danger btn-sm" >Update Cart</a>-->
                                              <input class="btn btn-success btn-sm" type="submit" name="Submit" value="Checkout"/>
                                            </div>
                                          </form>
                                          <?php } ?>
                                        </div>
                                        <br>
                                        <br>
                                        <?php } ?>
                                        <?php if($count == 0)
                                          { ?>
                                          <h6 align="center">Cart is Empty</h6>
                                          <?php } ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <?php if($this->session->flashdata('flashSuccess')) { ?>
                                <br>
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
                                <style type="text/css">
                                #cart-icon
                                {
                                  display:none;
                                }
                                .mobile-bottom-nav
                                {
                                  display:none;
                                }
                                .bg-light {
                                  background-color: #fc814c !important;
                                }
                                .navbar-light .navbar-brand ,.nav-link{
                                  color: #fffdfd;
                                  font-size:13px;
                                }
                                #lblCartCount {
                                  font-size: 10px;
                                  background: #fc814c;
                                  color: #fff;
                                  padding: 0 5px;
                                  vertical-align: top;
                                }
                                .fa{
                                  color: white;
                                  font-size: 10px;
                                }
                                .cart{
                                  padding: 15px;
                                }
                                .modal.show .modal-dialog {
                                  -webkit-transform: translate(0,0);
                                  transform: translate(0,0);
                                  float: right;
                                  width: 90%;
                                }
                                #dec, #inc {
                                  border-radius: 0px;
                                  /* height: 45px; */
                                  font-weight: bold;
                                  /* font-size: 20px; */
                                  outline: none;
                                  border: 0px solid;
                                  width: 25px;
                                }
                                #floatqty{
                                  font-size: 12px;
                                  width: 32%;
                                }
                                /*#mobile_cart-icon*/
                                /*{*/
                                  /*    display:none;*/
                                  /*}*/
                                  @media only screen and (max-width: 600px) {
                                    #dec, #inc {
                                      border-radius: 0px;
                                      /* height: 45px; */
                                      font-weight: bold;
                                      /* font-size: 20px; */
                                      outline: none;
                                      border: 0px solid;
                                      width: 16px;
                                    }
                                    #floatqty{
                                      font-size: 12px;
                                      width: 100%;
                                    }

                                    .header{
                                      /*position:fixed;*/
                                      /*z-index:1;*/
                                      width:100%;

                                    }
                                    .nav{
                                      position:fixed;
                                    }
                                    .mobile-bottom-nav
                                    {
                                      display:block;
                                    }
                                    #cart-icon
                                    {
                                      display:block;
                                    }
                                    .desktop-cart{
                                      display:none;
                                    }
                                  }

                                  @media only screen and (max-width: 425px) {
                                    #input{
                                      width: 50%;
                                    }  
                                    #cart-icon
                                    {
                                      display:block;
                                    }
                                    .mobile-bottom-nav
                                    {
                                      display:block;
                                    }
                                    .desktop-cart{
                                      display:none;
                                    }
                                  }

                                  @media only screen and (max-width: 360px) {
                                    #input{
                                      width: 100%;
                                    } 
                                    .mobile-bottom-nav
                                    {
                                      display:block;
                                    }
                                    #cart-icon
                                    {
                                      display:block;
                                    }
                                    .desktop-cart{
                                      display:none;
                                    }
                                  }
                                  @media only screen and (max-width: 375px) {
                                    #input{
                                      width: 70%;
                                    }  
                                    .mobile-bottom-nav
                                    {
                                      display:block;
                                    }
                                    #cart-icon
                                    {
                                      display:block;
                                    }
                                    .desktop-cart{
                                      display:none;
                                    }
                                  }
                                  @media only screen and (max-width: 400px) {
                                    #dec, #inc {
                                      border-radius: 0px;
                                      /* height: 45px; */
                                      font-weight: bold;
                                      /* font-size: 20px; */
                                      outline: none;
                                      border: 0px solid;
                                      width: 40px;
                                    }
                                    #num{
                                      font-size:10px;
                                      padding: 0.275rem 0.65rem;

                                    }
                                    #input{
                                      width: 70%;
                                    }
                                    .mobile-bottom-nav
                                    {
                                      display:block;
                                    }
                                    #cart-icon
                                    {
                                      display:block;
                                    }
                                    .desktop-cart{
                                      display:none;
                                    }
                                  }
                                  @media only screen and (max-width: 320px) {
                                    #input{
                                      width: 100%;
                                    } 
                                  }
                                  .modal-dialog
                                  {
                                    float: right;
                                    width: 90%;
                                  }
                                  .grandtotal1{
                                    display:none;
                                  }
                                </style>
                                <script type="text/javascript">
                                  incrementVar = 0;
                                  $('.incb').click(function(){
                                    var $this = $(this),
                                    $input = $this.prev('input'),
                                    $parent = $input.closest('div'),

                                    newValue = parseInt($input.val())+1;
                                    $parent.find('.inc').addClass('a'+newValue);
                                    $input.val(newValue);
                                    incrementVar += newValue;

                                    var qty=$input.val();
                                    var rowid=$(this).closest("div.input-group").find("input[name='rowid']").val();
                                    var subtotal=$(this).closest("div.input-group").find("input[name='subtotal']").val();
                                    var total=subtotal*qty;
                                    $(".grandtotal").hide();
                                    $(".grandtotal1").show();
                                    sessionStorage.setItem("total","total");

                                    var ge=$(".grandtotal").text();
                                    var n1 = parseInt(ge);
                                    var n2 = parseInt(subtotal);
                                    var gtl=n1+n2;
                                    var grandtotal=$(".grandtotal").text();
                                    $('.grandtotal1').text(gtl);
                                    $('.grandtotal').text(gtl);
                                    $(this).closest('tr').find('.disc').text(total);



                                    $.ajax({
                                      url:"<?php echo base_url(); ?>welcome/updateQty",
                                      method:"POST",
                                      data:{rowid:rowid,qty:qty},

                                      success:function(data)
                                      {
                                        console.log("Update");
                                      }
                                    });
                                  });
                                  $('.decb').click(function(){
                                    var $this = $(this),
                                    $input = $this.next('input'),
                                    $parent = $input.closest('div'),

                                    newValue = parseInt($input.val())-1;

                                    if(newValue !=0){

                                      console.log($parent);
                                      $parent.find('.inc').addClass('a'+newValue);
                                      $input.val(newValue);

                                      incrementVar += newValue;
                                      var qty=$input.val();
                                      if(qty!=0){

                                        var rowid=$(this).closest("div.input-group").find("input[name='rowid']").val();
                                        var subtotal=$(this).closest("div.input-group").find("input[name='subtotal']").val();



                                        $(this).closest('tr').find('.disc').text(total);
                                        var total=subtotal*qty;
                                        var grandtotal=$(".grandtotal").text();

                                        var ge=$(".grandtotal").text();
                                        var n1 = parseInt(ge);
                                        var n2 = parseInt(subtotal);
                                        var gtl=n1-n2;
                                        $('.grandtotal1').text(gtl);
                                        $('.grandtotal').text(gtl);
                                      }
                                      $(this).closest('tr').find('.disc').text(total);
                                      $.ajax({
                                        url:"<?php echo base_url(); ?>welcome/updateQty",
                                        method:"POST",
                                        data:{rowid:rowid,qty:qty},
                                        success:function(data)
                                        {
                                          console.log("Update");

                                        }

                                      });

                                    }

                                  });
                                </script>

