<!-- Header Layout Content -->
<link rel="stylesheet" type="text/css" href="https://direct-buy.in/print.css" media="all" />
<div class="printableArea">

   <?php if(isset($orderData) && is_array($orderData) && count($orderData)): $i=1;
   foreach ($orderData as $key => $data) { ?>
        <table style='width:100%'>
            <tr><td ><strong style="font-size: 14px;">Order Id &nbsp;: <?php echo '#' . $data['order_code'];?></strong></td></tr>
            <tr><td><strong style="font-size: 14px;">Order placed : <?php echo date('d-m-Y', strtotime($data['payment_date']))?> </strong></td></tr>
            <tr><td><strong style="font-size: 14px;">Customer Name: <?php echo  $data['c_fname'];?></strong></td></tr>
            <tr><td><strong style="font-size: 14px;">Customer Address: <?php echo  $data['c_address1'];?>,<?php echo $data['c_address2'] ;?>,<?php echo  $data['city'];?>,<?php echo $data['pincode'];?></strong></td></tr>
            <br>
            <tr><td><strong style="font-size: 14px;">Payment Method: <?php echo  $data['Payment_method'];?></strong></td></tr>
            <?php if($data['payment_status'] == 0) {?>
                <tr><td><strong style="font-size: 14px;">Payment Status: Pending</strong></td></tr>
            <?php } else {?>
                <tr><td><strong style="font-size: 14px;">Payment Status: Paid</strong></td></tr>
            <?php }?>
        </table>
   <?php } endif; ?>

   <hr style="height:1px;border-width:0;color:gray;background-color:gray">
   <?php if($orderDataRow['product_name']=='null') {  ?>
   <div class="card-header">
        <h2>Uploaded Prescription</h2>
    </div>
    <div class="card-body">
        <img class="center" src="<?php echo base_url().'assets/uploads/prescription/'. $orderDataRow['upload'];?>" alt="">
    </div>
   <?php } else { ?> 
       <table>
          <tr>
             <td style="width:140px;" ><strong style="font-size: 14px";>Description</strong></td>
             <td style="width:30px;"><strong style="font-size: 14px";> Qty</strong></td>
             <td style="width:60px;"><strong style="font-size: 14px";> Price</strong></td>
          </tr>
       </table>
       <?php if(isset($pendingOrders) && is_array($pendingOrders) && count($pendingOrders)): $i=1; foreach ($pendingOrders as $key => $data) {  ?>
          <hr style="height:1px;border-width:0;color:gray;background-color:gray">
          <table>
             <tr >
                <td style="width:140px;"><strong style="font-size:14">   <?php echo $data['product_name']; ?></strong>
                   <!-- <p style="font-size: 12px;"><?php echo $data['product_name']; ?> | <?php echo $data['product_name']; ?></p> -->
                </td>
                <td style="width:30px;"><?php echo $data['product_qty']; ?></td>
                <td style="width:60px;"><?php echo $data['product_price']; ?></td>
             </tr>
          </table>
       <?php } endif; ?>
       <?php if(isset($orderData) && is_array($orderData) && count($orderData)): $i=1; foreach ($orderData as $key => $data) { ?>
          <hr style="height:1px;border-width:0;color:gray;background-color:grey">
          <table>
             <tr>
                <td style="width:140px; ">
                   <strong style="font-size:10">Sub Total</strong>
                </td>
                <td style="width:30px;">
                   <strong style="font-size: 10px;"></strong>
                </td>
                <td style="width:60px;">
                   <strong style="font-size: 10px;">&#8377; <?php echo $data['total']; ?></strong>
                </td>
             </tr>
             <?php if(empty($data['discount_amount'])) {?>
             <?php } else {?>
                <tr >
                   <td style="width:140px; ">
                      <strong style="font-size:14px">Discount</strong>
                   </td>
                   <td style="width:30px;">
                      <strong style="font-size: 14px;"></strong>
                   </td>
                   <td style="width:60px;">
                      <strong style="font-size: 14px;">&#8377; </strong>
                   </td>
                </tr>
             <?php }?>
             <?php if(empty($data['tax_amount'])) {?>
             <?php } else {?>
                <tr >
                   <td style="width:140px; ">
                      <strong style="font-size:14px; text-align:left">Tax</strong>
                   </td>
                   <td style="width:30px;">
                      <strong style="font-size: 14px;"></strong>
                   </td>
                   <td style="width:60px;">
                      <strong style="font-size: 14px;">&#8377;</strong>
                   </td>
                </tr>
             <?php }?>
             <tr >
                <td style="width:140px; ">
                   <strong style="font-size:14px; text-align:left">Total</strong>
                </td>
                <td style="width:30px;">
                   <strong style="font-size: 14px;"></strong>
                </td>
                <td style="width:60px;">
                   <strong style="font-size: 14px;">&#8377; <?php echo $data['total']; ?></strong>
                </td>
             </tr>
          </table>
       <?php } endif; ?>
    <?php }?>
   <?php if(isset($orderData) && is_array($orderData) && count($orderData)): $i=1; foreach ($orderData as $key => $data) { ?>
      <hr>
      <p><strong style="font-size: 14px;margin-top:10px;">&nbsp;<?php echo $data['shop_name'];?> </strong></p>
      <p style="font-size: 14px;">&nbsp;<strong><?php echo $data['shop_address'];?> | Support:+91 22 41642120 | E-mail: info@themurgiwala.com</strong></p>
      <p style="font-size: 14px;"><strong>GST:<?php echo $data['shop_gst'];?></strong></p>
   <?php } endif; ?>
</div>
<br>
<a href="javascript:void(0);" class="btn btn-success" id="printButton">Print</a>

<script src="https://direct-buy.in/js/jquery.min.js"></script>
<script src="https://direct-buy.in/js/jquery.PrintArea.js"></script>
<script>
   $(document).ready(function(){
      $("#printButton").click(function(){
var mode = 'iframe'; //popup
var close = mode == "popup";
var options = { mode : mode, popClose : close};
$("div.printableArea").printArea( options );
});
   });
</script>

