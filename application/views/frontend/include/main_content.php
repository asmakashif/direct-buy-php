<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">
<link href = "<?php echo base_url(); ?>assets/css/jquery-ui.css" rel = "stylesheet">
<div class="main-content">

  
  <div class="row">
     <div class="col-md-1">
         </div>
       <div class="col-md-1" id="logo-div">
           
           <img  style="object-fit: contain" class="img-responsive" id="logo"  src="<?php echo base_url('')?>/assets1/uploads/<?php echo $logo->logo ?>" />
           
       </div>
       
    <div class="col-md-3">
        <br/>
        <span class="text-muted"> <?php echo $shop->shop_name ?></span>
        &nbsp;| &nbsp;
        <a href="tel:<?php echo $store_data->contact?>"><span  class="text-muted"><i class="fas fa-phone-alt"></i> <?php echo $store_data->contact;?></span></a>
        <br/>
        <?php if(!empty($logo->str_msg)) { ?>
        <small class="text-muted"><?php echo $logo->str_msg ?>	</small>
        <?php } ?>
    </div>
   
    <div class="col-md-4">
      <br/>
      <form class="navbar-form navbar-left" id="form" method="post" action="<?php echo base_url('Welcome/search')?>">
        <div class="input-group">
          <input type="text"  id="search" class="form-control" placeholder=" Products, Brand, Category" name="search" value="">
          <a   class="close-icon" type="reset" onclick="myFunction()"></a>
          <div class="input-group-btn">
            <button class="btn btn-default" id="btn" type="submit">
              <i class="fas fa-search" ></i>
            </button>
          </div>
        </div>
      </div>
      
      <div class="col-md-3">
         <?php if($shop_type->pharma_status==1) {?>
          <br />
           <a href="<?php echo base_url('welcome/upload_page') ?>"><button type="button" class="btn btn-warning" style="background-color:#fc814c; color:white"><i class="fas fa-notes-medical"></i> Upload Prescription</button></a>
          <?php }?>
          </div>
    </form>
    </div>
    <div >
    <div class="row">
      <div class="col-sm-2">
        <div class="fixed">
          <img src="<?php echo base_url('');?>assets/images/ad.jpg">
        </div>
      </div>
      <div class="col-sm-2">
          <br/>
          <div class="list-group">
          <p style="font-size:14px" >Filter By Price</p>
          
          <?php
          foreach($min_max_prices as $row)
          {        
            ?>
            <input type="hidden" id="hidden_minimum_price" value="<?php echo $row->min_price ?>" />
            <input type="hidden" id="hidden_maximum_price" value="<?php echo $row->max_price ?>" />
            <p id="price_show" style="font-size:14px"><?php echo $row->min_price ?>- <?php echo $row->max_price ?></p>
            <div id="price_range"></div>
          </div>
          <div  >
          <?php } ?>
          <br/>
          <div class="mobile">
          <div id="less-category">
           <?php if (!empty($category_data)) {?>
   <div class="accordion modified-accordion">
  <div class="card">
     <div class="card-header" id="headingThree">
    
        <!--<p data-toggle="collapse" data-target="#lesscategory" aria-expanded="false" aria-controls="collapseThree">-->
            <a style="color:black;" class="panel-title" data-toggle="collapse"   data-target="#lesscategory" aria-expanded="false">
             <span id="AccordionHeadings" style="font-size:14px">Filter By category</span></a>
             <!--</p>-->
  
 </div>
    <div id="lesscategory" class="collapse" aria-labelledby="headingThree">
     <?php  foreach(array_slice($category_data->result_array(), 0, 10) as $row) {
                    ?>
                    <div class="list-group-item checkbox" >
                      <label style="font-size:14px" ><input style="font-size:14px"  type="checkbox" class="common_selector ram" name="category" id="categorysl" value="<?php echo $row['category']; ?>"> <?php echo $row['category']; ?> </label>
                    </div>
                  <?php } ?>
                  <?php if($no_category > 10) { ?>
                  <div class="list-group-item checkbox"> 
                <a id="more-cat" style="font-size:14px" >More</a>
                </div>
                <?php }?>
    </div>
  </div>
</div>
            <?php } ?>
          </div>
       
          <div id="more-category" >
           <?php if (!empty($category_data)) {?>
         <div class="accordion modified-accordion">
  <div class="card">
     <div class="card-header" id="headingThree">
    
        <!--<p data-toggle="collapse" data-target="#lesscategory" aria-expanded="false" aria-controls="collapseThree">-->
            <a style="color:black;" class="panel-title" data-toggle="collapse"   data-target="#morecategory" aria-expanded="false">
             <span id="AccordionHeadings" style="font-size:14px">Filter By category</span></a>
             <!--</p>-->
  
 </div>
    <div id="morecategory" class="collapse" aria-labelledby="headingThree">
     <?php  foreach(array_slice($category_data->result_array(), 0, 10) as $row) {
                    ?>
                    <div class="list-group-item checkbox" >
                      <label style="font-size:14px" ><input style="font-size:14px"  type="checkbox" class="common_selector ram" name="category" id="categorysl" value="<?php echo $row['category']; ?>"> <?php echo $row['category']; ?> </label>
                    </div>
                  <?php } ?>
                  <div class="list-group-item checkbox"> 
                <a id="less-cat" style="font-size:14px" >Less</a>
                </div>
    </div>
  </div>
</div>
                </div>
               <?php } ?>
              </div>
            <br/>
        <div id="less-brand">
          <?php if (!empty($brand_data)) {?>
           <div class="accordion modified-accordion">
  <div class="card">
     <div class="card-header" id="headingThree">
    
        <!--<p data-toggle="collapse" data-target="#lesscategory" aria-expanded="false" aria-controls="collapseThree">-->
            <a style="color:black;" class="panel-title" data-toggle="collapse"   data-target="#Brand" aria-expanded="false">
             <span id="AccordionHeadings" style="font-size:14px">Filter By Brand</span></a>
             <!--</p>-->
  
 </div>
    <div id="Brand" class="collapse" aria-labelledby="headingThree">
      <?php
            $i = 0;
            foreach(array_slice($brand_data->result_array(), 0, 10) as $row)
              {?>
                <div class="list-group-item checkbox"> 
                  <label style="font-size:14px" ><input type="checkbox" class="common_selector brand" id="brandsl" value="<?php echo $row['brand']; ?>"  > <?php echo $row['brand']; ?></label>
                </div>
                <?php }  ?>
                
                    <div class="list-group-item checkbox"> 
                <a id="more" style="font-size:14px" >More</a>
                </div>
          
    </div>
  </div>
</div>
                <?php }  ?>
          </div>
          <div id="more-brand">
          <?php if (!empty($brand_data)) {?>
            <div class="accordion modified-accordion">
  <div class="card">
     <div class="card-header" id="headingThree">
    
        <!--<p data-toggle="collapse" data-target="#lesscategory" aria-expanded="false" aria-controls="collapseThree">-->
            <a style="color:black;" class="panel-title" data-toggle="collapse"   data-target="#Brand-ls" aria-expanded="false">
             <span id="AccordionHeadings" style="font-size:14px">Filter By Brand</span></a>
             <!--</p>-->
  
 </div>
    <div id="Brand-ls" class="collapse" aria-labelledby="headingThree">
      <?php
           foreach($brand_data->result_array() as $row)
              {?>
                <div class="list-group-item checkbox"> 
                  <label style="font-size:14px" ><input type="checkbox" class="common_selector brand" id="brandsl" value="<?php echo $row['brand']; ?>"  > <?php echo $row['brand']; ?></label>
                </div>
                <?php }  ?>
                
                     <div class="list-group-item checkbox"> 
                <a id="less" style="font-size:14px" >Less</a>
                </div>
          
    </div>
  </div>
</div>
              
                <?php }  ?>
                 </br>
                 
          </div>
          </div>
            <br/>
           </br>
              </br>
               </br>
          </div>
          
        
          <div class="col-md-8" >
            <br />
            <?php if (isset($search)) { ?>
              <?php if ($search == 'No record found !') { ?>
                <h6> <?php echo $search;?></h6>
              <?php } else {?>
                <?php foreach ($search as  $pro) { ?>
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-2">
                          <img id="prd_img1" style="object-fit: contain" src="<?php echo $pro->product_img ?>">
                          <!--<input type="hidden" name="product_id" value="<?php echo $pro->temp_str_config_id; ?>">-->
                        </div>
                        <div class="col-md-3">
                          <p align="center" style="margin-bottom:2px"  ><strong style="font-size:13px;color:#555555"><?php echo $pro->product_name; ?></strong></p>
                          <p align="center"  class="text-muted" style="font-size:12px"><?php echo substr($pro->product_description, 0, 40) ?></p>
                        </div>
                        <div class="col-md-3">
                          <p align="center" class="text-muted" style="margin-top:5px;font-size:13px">Brand :<?php echo $pro->brand; ?></p>
                        </div>
                        <div class="col-md-2">
                         <p align="center" > &#8377; <?php echo $pro->offer_price; ?><del style="color:#6e6c6c;"> <?php echo $pro->product_price; ?></del></p>
                        </div>
                        <div class="col-md-2">
                          <a href="<?php echo base_url('welcome/add/'.$pro->temp_str_config_id.'/'.$pro->product_price)?>"style="margin-top: 25px;" type="button"  class="btn btn-success btn-sm">Add to cart</a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php }}?>
                <?php if ($search != 'No record found !') { ?>
                  <p>&nbsp;&nbsp; Searched results shown above</p>
                <?php }  ?>
              <?php } else{?>
              <br/>
                <div class="filter_data">
                </div>
                <div align="center" id="pagination_link">
                </div>
                <br/>
                
              <?php } ?>
              <br/>
            </div>
          </div>
        </div>
        <script type="text/javascript">
          $('#loginModal').on('show.bs.modal', function (e) {

            $('body').addClass('test');
          })
        </script>
        <script type="text/javascript">
          $('#search').autocomplete({

            minimumInputLength: 1,
            ajax: {
              url: "<?php echo base_url();?>welcome/search",
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
                return {
                  results: data
                };
              },
              cache: true
            }
          });
        </script>

        <style type="text/css">
        .test[style] {
          padding-right:0 !important;
        }
      
        .test.modal-open {
          overflow: auto;
        }
          #logo
          {
           height:100%;
           width:100%;
           }
           #prd_img
{
    width:35%;
}
    #prd_img1
{
    width:40%;
}
        @media only screen and (max-width: 600px) {
          .btn.btn-success{
            width: 100%;

          }
          #prd_img,#prd_img1
         {
    width:100%;
       }
           .fixed {
           display: none;
          }
          #logo
          {
           height:70%;
           width:50%;
           margin-left:20%;
           }
           #logo-div
           {
           height:60%;
           width:100%;
          }
        }
        .btn.btn-success{
          font-size: 15px;

        }

        .nav-pills .nav-link
        {
          font-size: 23px;
          background-color: #f0f0f0;
          margin-right:55px;
          color: black;
        }
        .nav-pills .nav-link:hover{
          background-color: #fc814c;
          color: white;
        }
        .search-box,.close-icon,.search-wrapper {
          position: relative;
          padding: 0px;
        }


        .close-icon {
          border:1px solid transparent;
          background-color: transparent;
          display: inline-block;
          vertical-align: middle;
          outline: 0;
          cursor: pointer;
        }
        .modal {
          padding-right: 0px !important;
          margin-top: 40px;
          float: right;
        }

        .close-icon:after {
          content: "X";
          display: block;
          width: 25px;
          height: 25px;
          position: absolute;

          z-index:1;
          right: 35px;
          top: 0;
          bottom: 0;
          margin: auto;
          padding: 2px;

          text-align: center;
          color: black;
          font-weight: normal;
          font-size: 15px;

         
        }
        .pagination>li {
          display: inline;
        }
        .pagination>li>a, .pagination>li>span {
          position: relative;
          float: left;
          padding: 6px 12px;
          margin-left: -1px;
          line-height: 1.42857143;
          color: #337ab7;
          text-decoration: none;
          background-color: #fff;
          border: 1px solid #ddd;

        }
        .pagination {
          display: inline-block;
          padding-left: 0;
          margin: 20px 0;
          border-radius: 4px;
        }
        li.active a{
          display: inline;
          background-color: #799bc0;
          color: white;
          font-weight: 700;
        }
        .modal-open{
          padding-right: 0px;
        }
  .fixed img
{
width: 100%;
    padding: 5px;

}
.row{
    width:100%;
    margin:0;
}
#loading
{
  text-align:center; 
  background: url('<?php echo base_url(); ?>assets/images/loader.gif') no-repeat center; 
  height: 150px;
}
.card-body{
    padding:10px;
}
    
.list-group-item {
    position: relative;
    display: block;
    padding: .40rem .40rem;
    margin-bottom: -1px;
    background-color: #fff;
    border: 1px solid rgba(0,0,0,.125);
}


</style>

<script type="text/javascript">
  $(document).ready(function(){

    $('.category').click(function() {
      alert('hi');

      $(this).closest('.this_div').find('.close_this').hide();
    });
    $("#form").submit(function(e){
      var search = $('#search').val();
      sessionStorage.setItem("search", search);

    });
    var search = sessionStorage.getItem("search");
    document.getElementById('search').value = search;
  });
  function myFunction() {
    window.location.href ="<?php echo base_url('welcome/Home/'.$this->session->userdata('store_id').'/'.$this->session->userdata('store_name'))?>"
    sessionStorage.removeItem('search');
  }
</script>
<style type="text/css">
.panel-title:after {
  font-family: FontAwesome;
  content: "\f107";
  float: right;
  color: grey;
}

.panel-title[aria-expanded="true"]:after {
  content: "\f106";
}

.panel-title:after {
  font-family: FontAwesome;
  content: "\f107";
  float: right;
  color: grey;
}

.panel-title[aria-expanded="true"]:after {
  content: "\f106";
}
#more-brand,#more-category{
    display:none;
}
a{
    cursor:pointer;
}

</style>
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<script type="text/javascript">
    $(document).ready(function(){
    
        $("#more").click(function(){
    
  $('#less-brand').hide();
//   $("#brands").prop("checked", true);
  $('#more-brand').show();
});
  $("#less").click(function(){
  $('#more-brand').hide();
//   $("#brandsl").prop("checked", true);

  $('#less-brand').show();
});
 $("#more-cat").click(function(){
    //   var selected = input[name="category"]:checked').val();
   
    
  $('#less-category').hide();
//   $("#categorys").prop("checked", true);
  $('#more-category').show();
});
  $("#less-cat").click(function(){
  $('#more-category').hide();
//   $("#categorysl").prop("checked", true);
  $('#less-category').show();
});
  
    });
</script>
 

<script>
  $(document).ready(function(){

    filter_data(1);

    function filter_data(page)
    {
       
      $('.filter_data').html('<div id="loading" style="" ></div>');
      var action = 'fetch_data';
//var page = 1;
var minimum_price = $('#hidden_minimum_price').val();
var maximum_price = $('#hidden_maximum_price').val();
var brand = get_filter('brand');
var ram = get_filter('ram');

var storage = get_filter('storage');
$.ajax({
  url:"<?php echo base_url(); ?>welcome/fetch_data/"+page,
  method:"POST",
  dataType:"JSON",
  data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, brand:brand, ram:ram},
  success:function(data)
  {
    $('.filter_data').html(data.product_list);
    $('#pagination_link').html(data.pagination_link);
  }
})
}
var v1=parseInt($('#hidden_minimum_price').val());
var v2=parseInt($('#hidden_maximum_price').val())+parseInt(5);

$('#price_range').slider({

  range:true,
  min:$('#hidden_minimum_price').val()-0,
  max:v2,
  values:[v1, v2],
  step: 10,
  stop:function(event, ui){
    $('#price_show').show();
    $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
    $('#hidden_minimum_price').val(ui.values[0]);
    $('#hidden_maximum_price').val(ui.values[1]);
    filter_data(1);
  }
});

function get_filter(class_name)
{
  var filter = [];
  $('.'+class_name+':checked').each(function(){
    filter.push($(this).val());
    // alert(filter);
    //  $('.common_selector.ram ').prop('checked',true);
    // $('input.type_checkbox').prop('checked', true);
  });
  return filter;
}

$(document).on("click", ".pagination li a", function(event){
  event.preventDefault();
  var page = $(this).data("ci-pagination-page");
  filter_data(page);
});

$('.common_selector').click(function(){
  filter_data(1);
});
});
</script>
<style>
    	.modified-accordion .card-header{ position: relative;}
.modified-accordion .card-header:after{ content: ''; position: absolute; width: 100%; 
 height: 100%; left: 0; top: 0;}
.modified-accordion .collapse:not(.show){ display: block;}
@media (max-width: 767px) {
.modified-accordion .collapse:not(.show){ display: none;}
.modified-accordion .card-header:after{ display: none;}
}
</style>


