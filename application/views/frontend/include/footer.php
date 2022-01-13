

 <div class="menu">
     <br/>
  <nav class="mobile-bottom-nav">
	<div class="mobile-bottom-nav__item mobile-bottom-nav__item--active">
		<div class="mobile-bottom-nav__item-content">
		    <?php if($this->session->userdata('store_name')==''){ ?>
		    <a href=""><i  style="color:#fc814c; margin-left:30%;font-size:30px" class="fas fa-home"></i></a>
		    <?php } else { ?>
	<a href="<?php echo base_url('welcome/home/'.$this->session->userdata('store_id').'/'.$this->session->userdata('store_name'))?>"><i  style="color:#fc814c; margin-left:30%;font-size:30px" class="fas fa-home"></i></a>
		  <?php } ?>
		</div>		
	</div>
	<div class="mobile-bottom-nav__item">		
		<div class="mobile-bottom-nav__item-content">

           <!--<a data-toggle="modal" data-target="#myModal" class="icon-shopping-cart" id="show-cart"> <i  style="color:#fc814c;margin-left:30%;font-size:30px"class="fa fa-shopping-cart"></i></a>-->
           <!--   <a  data-toggle="modal" data-target="#myModal"  class="icon-shopping-cart" >-->
           <!--     <asp:Label ID="lblCartCount" runat="server" CssClass="badge badge-warning"  ForeColor="White"/ style="background-color:white; color:#fc814c; "><?php echo $this->cart->total_items() ?></a>-->
		
		</div>
	</div>
	<div class="mobile-bottom-nav__item">
		<div class="mobile-bottom-nav__item-content">
		    <?php if($this->session->userdata('store_name')==''){ ?>
		  <a href=""><i style="color:#fc814c; margin-left:30%;font-size:30px" class="fas fa-user-circle"></i></a>  
		    <?php } else { ?>
	<a href="<?php echo base_url('welcome/customer_profile');?>">	<i style="color:#fc814c; margin-left:30%;font-size:30px" class="fas fa-user-circle"></i></a>
		 <?php } ?>
		</div>		
	</div>
	</nav>
	</div>

<?php if($this->session->userdata('store_name')) { ?>  
<div class="footer"><small>Copyright © 2021 direct-buy.<?php echo $this->session->userdata('store_name');?></small>

</div>
<?php  } ?>
<style type="text/css">
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: #3f3f3f;
   color: white;
   padding: 10px;
   text-align: center;
}
.menu
{
    display:none;
}

@media only screen and (max-width: 600px) {
  .footer {
    position: fixed;
  }
}
    @media only screen and (max-width: 320px){
    #dec, #inc {
            border-radius: 0px;
            /* height: 45px; */
            font-weight: bold;
            /* font-size: 20px; */
            outline: none;
            border: 0px solid;
            width: 32px;
          }
          #qty-value{
              font-size:10px;
          }
          .menu
{
    display:block;
    margin-top:50px;
}
    
       }
       @media only screen and (max-width: 600px){
    .menu{
         display:block;
         margin-top:10px;
    }
       }

.mobile-bottom-nav__item
{
    width:100%;
    padding-top: 10px;
}
.mobile-bottom-nav{
	position:fixed;
	bottom:0;
	left:0;
	right:0;
	z-index:1000;
	
	//give nav it's own compsite layer
	will-change:transform;
	transform: translateZ(0);
	
	display:flex;	
	
	height:50px;
	
	box-shadow: 0 -2px 5px -2px #333;
	background-color:#fff;
	
	&__item{
		flex-grow:1;
		text-align:center;
		font-size:12px;
		
		display:flex;
		flex-direction:column;
		justify-content:center;
	}
	&__item--active{
		//dev
		color:red;
	}
	&__item-content{ 
		display:flex;
		flex-direction:column;		
	}
	
}
</style>

  <?php if($this->session->flashdata('flashSuccess')) {?>
    <script type="text/javascript">
    window.setTimeout(function() {
      $(".successmsg").fadeTo(1000, 0).slideUp(500, function(){
        $(this).remove();
      });
    }, 3000);
  </script>
<?php }?>
<?php if($this->session->flashdata('flashError')) { ?>
  <script type="text/javascript">
    window.setTimeout(function() {
      $(".errormsg").fadeTo(900, 0).slideUp(800, function(){
        $(this).remove();
      });
    }, 4000);
  </script>
<?php } ?>
</script>
<script>
    var navItems = document.querySelectorAll(".mobile-bottom-nav__item");
navItems.forEach(function(e, i) {
	e.addEventListener("click", function(e) {
		navItems.forEach(function(e2, i2) {
			e2.classList.remove("mobile-bottom-nav__item--active");
		})
		this.classList.add("mobile-bottom-nav__item--active");
	});
});
</script>

  
</body>
</html>