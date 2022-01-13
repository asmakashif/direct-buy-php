<div>
    <div class="row">
<div class="col-md-1">
</div>
<div class="col-md-10">
    <table class="table table-hover">
  <thead>
     
    <tr>
      
      <th style="width:10%">Order ID</th>
      <th style="width:10%">Shop Name</th>
      <th style="width:5%">Date</th>
      <th style="width:5%">Total</th>
      <th style="width:10%">Payment Method</th>
      <th style="width:10%">Status</th>
    </tr>
   
  </thead>
<tbody>
     <?php if(!empty($order_items)){ foreach($order_items as $row){?>
     <tr>
      
      <td><a href="<?php echo base_url('welcome/order_details/'.$row->order_code );?>" style="color:black"><?php echo $row->order_code ?></a></td>
      <td><?php echo $row->shop_name ?></td>
      <td><?php echo date('d-m-Y', strtotime($row->order_placed_date)) ?></td>
      <td><?php echo $row->total ?></td>
      <td><?php echo $row->Payment_method ?></td>
      <td><?php if($row->payment_status==0 ){?>Payment pending<?php } else {?> Delivered <?php } ?> </td>
    </tr>
      <?php }}?>
</tbody>
</table>
</br>
</br>
</div>
<div class="col-md-1">
</div>
</div>
</div>
<style>
    .row{
        width:100%;
    }
    a{
        text-decoration:underline;
    }
</style>