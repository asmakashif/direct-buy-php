<!--<html>-->
<!--  <head> -->
<!--      <title>Image Upload Example from Scratch</title>-->
<!--      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
<!--      <script src="https://malsup.github.com/jquery.form.js"></script>-->
<!--  </head>-->
<!--  <body> -->

<!--      <?php echo form_open_multipart('upload-image-using-ajax/post');?> -->
<!--         <input type="file" name="file" size="20" />-->
<!--         <input type="submit" class="btn-image-upload" value="upload" /> -->
<!--      </form> -->
<!--      <div class="preview" style="display: none;">-->
<!--        <img src="">-->
<!--      </div>-->

<!--   <script type="text/javascript">-->
<!--      $("body").on("click",".btn-image-upload",function(e){-->
<!--       $(this).parents("form").ajaxForm(options);-->
<!--      });-->


<!--     var options = { -->
<!--       complete: function(response) -->
<!--       {-->
<!--         if($.isEmptyObject(response.responseJSON.error)){-->
<!--            alert('Image Upload Successfully.');-->
<!--            $(".preview").css("display","block");-->
<!--            $(".preview").find("img").attr("src","./images/"+response.responseJSON.success);-->
<!--         }else{-->
<!--            alert(response.responseJSON.error);-->
<!--         }-->
<!--       }-->
<!--     };-->

<!--   </script>-->
<!--  </body>-->
<!--</html>-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('');?>assets/css/bootstrap.min.css" media="all" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('');?>assets/css/bootstrap.css" media="all" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" integrity="undefined" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" rel="stylesheet">
   <link type="text/css" href="<?php echo base_url('');?>assets1/css/app.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="<?php echo base_url('');?>assets/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url('');?>assets/js/jquery.js"></script>
<form name="myform" method="post" action="<?php echo base_url('ImageUpload/saveProduct')?>" enctype="multipart/form-data" id="msform">
<div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="bname"><b>Image<span style="color:green;">(image selected at last will be set as default image)</span></b></label></br>
                                                        <input type="file" id="upload_file" name="images[]" class="form-control" onchange="preview_image();" multiple>
                                                    </div>
                                                </div>
                                                 <div class="row">
                                                <div id="image_preview"></div>
                                                 <input type="submit" name="imgSubmit" class="btn btn-success" value="Next">
                                            </div>
                                           
                                                </form>
                                                <script>
                                                      function preview_image() 
            {
                var total_file=document.getElementById("upload_file").files.length;
                for(var i=0;i<total_file;i++)
                {
                    $('#image_preview').append('<img src="'+URL.createObjectURL(event.target.files[i])+'" width="150" height="100"/>');
                }
            }
        
                                                </script>
                                            </div>