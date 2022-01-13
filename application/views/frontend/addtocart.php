<div class="row">
    <div class="col-md-2">
    </div> 
    <div class="col-md-8">
        <div class="cart-contents">
            <h5 class="text-muted">Your Cart</h5>
            <div class="table-responsive">
                <div align="right">
                    <a class="btn btn-warning btn-sm" style="color:white" id="clear_cart" href="<?php echo base_url('Welcome/clear');?>">Clear Cart</a>
                </div>
                <br />
                <table class="table table-bordered">
                    <tr>
                        <th width="20%">Name</th>
                        <th id="qt">Quantity</th>
                        <th width="5%">Price</th>
                        <th width="5%">Total</th>
                        <th width="2%"></th>
                    </tr>
                    <?php $count = 0;
                    foreach($this->cart->contents() as $items)
                        { ?>
                            <?php $count++; ?>
                            <tr> 
                                <td><?php echo $items["name"] ?>
                                <p >Brand : <?php echo $items["brand"] ?> </p></td>
                                <td>
                                    <div class="input-group" id="input" >
                                        <input type="hidden" name="rowid"  value="<?php echo  $items["rowid"] ?>">
                                        <button class="dec button" type="button">-</button>
                                        <input type="text" class="form-control " name="qty" maxlength="3" value="<?php echo  $items["qty"] ?>" >
                                        <button class="inc button" type="button">+</button>
                                    </div>
                                </td>
                            </td>
                            <td>&#8377;<?php echo  $items["price"] ?></td>
                            <td>&#8377;<?php echo $items["subtotal"] ?></td>
                            <td>
                                <a style="color: red" href="<?php echo base_url('Welcome/remove/'.$items["rowid"]);?>" ><i class="far fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4" align="right">Total</td>
                        <td>&#8377;<?php echo $this->cart->total() ?></td>
                    </tr>
                </table>
                <?php if($count != 0)
                { ?>
                    <?php if($homeDelivery->home_delivery==1){
                        if($homeDelivery->min_order_val<=$this->cart->total()){?>


                            <form action="<?php echo base_url('frontend/Checkout/place_order');?>" method="post">
                                <?php $count = 0;
                                foreach($this->cart->contents() as $items)
                                    { ?>
                                        <?php $count++; ?>
                                        <input type="hidden" name="rowid"  value="<?php echo  $items["rowid"] ?>">
                                        <input type="hidden" name="product_name"  value="<?php echo  $items["name"] ?>">
                                        <input type="hidden" name="product_img"  value="<?php echo  $items["img"] ?>">
                                        <input type="hidden" name="qty"  value="<?php echo  $items["qty"] ?>">
                                        <input type="hidden" name="price"  value="<?php echo  $items["price"] ?>">
                                        <input type="hidden" name="sub_total"  value="<?php echo   $items["subtotal"] ?>">
                                        <input type="hidden" name="total"  value="<?php echo $this->cart->total() ?>">
                                    <?php  } ?> 
                                    <div style="float:right">
                                        <a   href="<?php echo base_url('Welcome/Home/'.$this->session->userdata('store_id').'/'.$this->session->userdata('store_name'))?>"><button type="button" class="btn btn-info btn-sm">Shop More</button></a>
                                        <a  href="<?php echo base_url('Welcome/addtocart');?>" class="btn btn-danger btn-sm" >Update Cart</a>
                                        <input    class="btn btn-success btn-sm" type="submit" name="Submit" value="Checkout"/>
                                    </div>
                                </form>
                            <?php }  else {?>

                                <p>Please shop more than <?php echo $homeDelivery->min_order_val ?> to get home delivery</p>
                                <form action="<?php echo base_url('frontend/Checkout/store_pickup');?>" method="post">
                                    <?php $count = 0;
                                    foreach($this->cart->contents() as $items)
                                        { ?>
                                            <?php $count++; ?>
                                            <input type="hidden" name="rowid"  value="<?php echo  $items["rowid"] ?>">
                                            <input type="hidden" name="product_name"  value="<?php echo  $items["name"] ?>">
                                             <input type="hidden" name="product_img"  value="<?php echo  $items["img"] ?>">
                                            <input type="hidden" name="qty"  value="<?php echo  $items["qty"] ?>">
                                            <input type="hidden" name="price"  value="<?php echo  $items["price"] ?>">
                                            <input type="hidden" name="sub_total"  value="<?php echo   $items["subtotal"] ?>">
                                            <input type="hidden" name="total"  value="<?php echo $this->cart->total() ?>">
                                        <?php  } ?> 
                                        <div style="float:right">
                                            <a   href="<?php echo base_url('Welcome/Home/'.$this->session->userdata('store_id').'/'.$this->session->userdata('store_name'))?>"><button type="button" class="btn btn-info btn-sm">Shop More</button></a>
                                            <a  href="<?php echo base_url('Welcome/addtocart');?>" class="btn btn-danger btn-sm" >Update Cart</a>
                                            <input    class="btn btn-success btn-sm" type="submit" name="Submit" value="Checkout"/>
                                        </div>
                                    </form>
                                <?php }?>


                            <?php } else {?>
                                <form action="<?php echo base_url('frontend/Checkout/store_pickup');?>" method="post">
                                    <?php $count = 0;
                                    foreach($this->cart->contents() as $items)
                                        { ?>
                                            <?php $count++; ?>
                                            <input type="hidden" name="rowid"  value="<?php echo  $items["rowid"] ?>">
                                            <input type="hidden" name="product_name"  value="<?php echo  $items["name"] ?>">
                                             <input type="hidden" name="product_img"  value="<?php echo  $items["img"] ?>">
                                            <input type="hidden" name="qty"  value="<?php echo  $items["qty"] ?>">
                                            <input type="hidden" name="price"  value="<?php echo  $items["price"] ?>">
                                            <input type="hidden" name="sub_total"  value="<?php echo   $items["subtotal"] ?>">
                                            <input type="hidden" name="total"  value="<?php echo $this->cart->total() ?>">
                                        <?php  } ?> 
                                        <div style="float:right">
                                            <a   href="<?php echo base_url('Welcome/Home/'.$this->session->userdata('store_id').'/'.$this->session->userdata('store_name'))?>"><button type="button" class="btn btn-info btn-sm">Shop More</button></a>
                                            <a  href="<?php echo base_url('Welcome/addtocart');?>" class="btn btn-danger btn-sm" >Update Cart</a>
                                            <input    class="btn btn-success btn-sm" type="submit" name="Submit" value="Checkout"/>
                                        </div>
                                    </form>
                                <?php }?>   
                            </div>
                            <br>
                            <br>
                        <?php } ?>
                        <?php if($count == 0)
                        { ?>
                            <h3 align="center">Cart is Empty</h3>
                        <?php } ?>
                    </div>
                </div> 
                <div class="col-md-2">
                </div> 
            </div>
            <style type="text/css">
            a{
                color: white;
            }
            .table td,.table th {
                font-size: 15px;
            }
            #input{
                width: 60%;
            }
            #qt{
                width: 8%;
            }
            @media only screen and (max-width: 600px) {
                .dec.button, .inc.button {
                    border-radius: 0px;
                    height: 30px;
                    font-weight: bold;
                    font-size: 10px;
                    outline: none;
                    border: 0px solid;
                    width: 23px;
                }
                #qt{
                    width: 18%;
                }
                .table td, .table th {
                    font-size: 10px;
                }
                #input {
                    width: 100%;
                }
                .form-control{
                    font-size: 10px;
                    height: 30px;
                }
                td p{

                    color: grey;
                }

            }
            td p{

                color: grey;
            }
            button, html [type="button"], [type="reset"], [type="submit"] {
                -webkit-appearance: media-slider;
            }
            .row{
                width:100%;
            }
            .dec.button, .inc.button {
                border-radius: 0px;
                height: 30px;
                font-weight: bold;
                font-size: 10px;
                outline: none;
                border: 0px solid;
                width: 24px;
            }
            .form-control{
                font-size: 10px;
                height: 30px;
            }
        </style>
        <script type="text/javascript">
            incrementVar = 0;
            $('.inc.button').click(function(){
                var $this = $(this),
                $input = $this.prev('input'),
                $parent = $input.closest('div'),

                newValue = parseInt($input.val())+1;
                $parent.find('.inc').addClass('a'+newValue);
                $input.val(newValue);
                incrementVar += newValue;
                var qty=$input.val();
                var rowid=$(this).closest("div.input-group").find("input[name='rowid']").val();

                $.ajax({
                    url:"<?php echo base_url(); ?>welcome/updateQty",
                    method:"POST",
                    data:{rowid:rowid,qty:qty},
                    success:function(data)
                    {
                        console.log("Update");
//window.location.reload(true);
}
});
            });
            $('.dec.button').click(function(){
                var $this = $(this),
                $input = $this.next('input'),
                $parent = $input.closest('div'),

                newValue = parseInt($input.val())-1;
                if($input.val()==1)
                {
                    alert("Cant decrement the qty");
                }
                else{
                    console.log($parent);
                    $parent.find('.inc').addClass('a'+newValue);
                    $input.val(newValue);

                    incrementVar += newValue;
                    var qty=$input.val();
                    var rowid=$(this).closest("div.input-group").find("input[name='rowid']").val();

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
