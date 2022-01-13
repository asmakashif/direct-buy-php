



<div class="main" style="margin: 20px;">
	<div class="row">
		<?php if(!empty($store)) foreach ($store as $row) { ?>
		
		
		<div class="col-md-3">
			
  
     
      <?php if( $row->shop_status!=2) { ?>
      <div class="card">
  <div class="card-body">
     <h6 style="text-align:center;"><?php echo $row->shop_name ?></p>
     <small class="text-muted" style="text-align:center;"><?php echo $row->shop_address ?></small>
     <br/>
     <br/>
     
    
     
     <a href="<?php echo base_url('welcome/Home/'.$row->shopId.'/'.$row->shop_name)?>" class="btn btn-danger btn-sm">Click Here</a>
    
     <form action="<?php echo base_url('welcome/make_default_store');?>" method="post">
      
         <input type="hidden"   name="store_id" value="<?php echo $row->shop_id ?>">
            <input type="hidden"   name="store_name" value="<?php echo $row->shop_name ?>">
     <!--<input type="submit" id="button" class="btn btn-info btn-sm" value="Make default store">-->
     </form>
      </div>

</div>
 <?php }?>
   
 
  <br/>
		</div>
		<?php } else {?>
                 No store(s) found!!
		<?php }?>
		
	</div>
</div>
<style type="text/css">
	a{
		color: black;
		text-decoration:none;
	}
	a:hover{
		color: black;
		text-decoration:none;
	}
	body{
	    background:#f1f1f1;
	}
	.card{
	  
	    border: 0px solid rgba(0, 0, 0, 0.125);
	}
	#button {
    display: none;
    margin-left:50px;
}
.card:hover #button {
    display:block;
}
	/*.card:hover{*/
	/*    display*/
	/*}*/

</style>
