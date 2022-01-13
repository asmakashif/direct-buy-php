<div class="container">
    <br/>
    <br/>
    <h5 style="text-align:center">Upload the prescription provided by doctor..We will reach you</h5>
    <br/>
     <?php if($homeDelivery->home_delivery==1){?>
    <form name="myform" method="post" action="<?php echo base_url('frontend/Checkout/uploadImage')?>" enctype="multipart/form-data" id="msform">
<div class="row">
<div class="col-md-3">
</div>
<div class="col-md-5">
    <div class="form-group">
        <input type="file" id="upload_file" name="images[]" class="form-control" onchange="preview_image();" multiple>
    </div>
</div>
</div>                                             
<div class="row">
     <div class="col-md-3">
         </div>
<div class="col-md-1">
    <input type="submit" name="imgSubmit" class="btn btn-success btn-sm" value="Upload" style="height:40px">
</div>
<div class="col-md-1">
     <a href="<?php echo base_url('welcome/Home/'.$this->session->userdata('store_id').'/'.$this->session->userdata('store_name'));?>" class="btn btn-danger">Cancel</a>
  </div>

 </div>
  <div class="row">
       <div class="col-md-3">
         </div>
     <div class="col-md-5">
         <div id="image_preview"></div>
         </div>
         </div>
 
 </form>
 <?php } else {?>
     <form name="myform" method="post" action="<?php echo base_url('frontend/Checkout/uploadImageStorePick')?>" enctype="multipart/form-data" id="msform">
<div class="row">
<div class="col-md-3">
</div>
<div class="col-md-5">
    <div class="form-group">
        <input type="file" id="upload_file" name="images[]" class="form-control" onchange="preview_image();" multiple>
    </div>
</div>
</div>                                             
<div class="row">
     <div class="col-md-3">
         </div>
<div class="col-md-1">
    <input type="submit" name="imgSubmit" class="btn btn-success btn-sm" value="Upload" style="height:40px">
</div>
<div class="col-md-1">
     <a href="<?php echo base_url('welcome/Home/'.$this->session->userdata('store_id').'/'.$this->session->userdata('store_name'));?>" class="btn btn-danger">Cancel</a>
  </div>

 </div>
  <div class="row">
       <div class="col-md-3">
         </div>
     <div class="col-md-5">
         <div id="image_preview"></div>
         </div>
         </div>
 
 </form>
 <?php } ?>
</div>
        <script>
            function preview_image() 
            {
                var total_file=document.getElementById("upload_file").files.length;
                for(var i=0;i<total_file;i++)
                {
                    $('#image_preview').append('<img src="'+URL.createObjectURL(event.target.files[i])+'" width="100%" />');
                }
            }
        
         </script>
         
         