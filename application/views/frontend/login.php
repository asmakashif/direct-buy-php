    <?php 
    $url = explode('.',$_SERVER['SERVER_NAME']);
		$domain=$url[0];
		?>
		  <?php if($logo->remove_user!=2){?>
    <div id="login-page" >
    <div id="login" >
     
        <div class="container">
          
            <?php if($domain=='demo') { ?>
  
            <div id="login-row" class="row ">
                <div class="col-md-4 center-block">
                    
                    <img  class="img-responsive" src="<?php echo base_url('')?>/assets1/uploads/<?php echo $logo->logo ?>" />
                    </div>
                <div id="login-column" class="col-md-4">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="<?php echo base_url('welcome/login');?>" method="post">
                         
                            <h4 class="text-center text-info" >Sign In</h4>
                         
                            <div class="form-group">
                                <label for="username" class="text-info">Email:</label><br>
                                <input type="text" name="email" value="demoCustomer@gmail.com" placeholder="Email" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info" >Password:</label><br>
                                <input type="password" name="password" value="demo123" id="password" class="form-control" placeholder="Password" >
                            </div>
                          
                           <div>
                           <br/>
                        <div >
                          <!--<a class="btn btn-info btn-sm" href="<?php echo base_url('Welcome/register/');?>" >Register Here</a>-->
                            <button class="btn btn-info btn-sm" disabled>Register Here</button>
                               <input style="float:right" type="submit" value="Submit"  class="btn btn-success btn-sm" name="">
                           </div>
                                <h5 class="text-center text-info" style="color:black; text-align:center">OR</h5>
                           </div>
                      
                            <?php   $url = explode('.',$_SERVER['SERVER_NAME']);
	                    	$domain=$url[0]; ?>
                         <a  href="https://direct-buy.in/Customer/index/<?php echo $domain ?>"><img style="margin-top:5px" src="<?php echo base_url('')?>/assets/images/gmail.png" /></a>
                        </form>
                               
                    </div>
                    </div>
                    <div  class="col-md-4 center-block">
                    <img  class="img-responsive" src="<?php echo base_url('')?>/assets1/uploads/made-in-india.jpg" />
                    </div>
                </div>
                <?php } else {?>
                 <div id="login-row" class="row ">
                <div class="col-md-4 center-block">
                    <?php if(!empty( $logo->logo)) {?>
                    <img  class="img-responsive" src="<?php echo base_url('')?>/assets1/uploads/<?php echo $logo->logo ?>" />
                    <?php } else {?>
                    <img  class="img-responsive" src="https://direct-buy.in//assets1/img/defaltlogo.png" />
                    <?php } ?>
                    </div>
                <div id="login-column" class="col-md-4">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="<?php echo base_url('welcome/login');?>" method="post">
                         
                            <h4 class="text-center text-info" >Sign In</h4>
                         
                            <div class="form-group">
                                <label for="username" class="text-info">Email:</label><br>
                                <input type="text" name="email"  placeholder="Email" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info" >Password:</label><br>
                                <input type="password" name="password"  id="password" class="form-control" placeholder="Password" >
                            </div>
                          
                           <div>
                           <br/>
                        <div >
                          <a class="btn btn-info btn-sm" href="<?php echo base_url('Welcome/register/');?>" >Register Here</a>
                            
                               <input style="float:right" type="submit" value="Submit"  class="btn btn-success btn-sm" name="">
                           </div>
                            <h5 class="text-center text-info" style="color:black; text-align:center">OR</h5>
                           </div>
                            <?php   $url = explode('.',$_SERVER['SERVER_NAME']);
	                    	$domain=$url[0]; ?>
                         <a  href="https://direct-buy.in/Customer/index/<?php echo $domain ?>"><img style="margin-top:5px" src="<?php echo base_url('')?>/assets/images/gmail.png" /></a>
                        </form>
                    </div>
                    </div>
                    <div  class="col-md-4 center-block">
                    <img  class="img-responsive" src="<?php echo base_url('')?>/assets1/uploads/made-in-india.jpg" />
                    </div>
                </div>
                <?php } ?>
            </div>
            </br>
             </br>
        </div>
    </div>
   
    </div>
    
     <?php } else {?>
     <br/>
    <h4 style="text-align:center">Page no longer exists</h4>
     <?php } ?>
      <style type="text/css">
  
#login .container #login-row #login-column #login-box {
  margin-top: 0px;
  /*max-width: 500px;*/
  /*height: 420px;*/
  border: 0px solid #9C9C9C;
  background-color: #fff;

  box-shadow: 0px 1px 16px 0px #bfbec2;;
}

#login-row{
    margin-bottom: 0px;
}
#login .container #login-row #login-column #login-box #login-form {
  padding: 20px;
}
.container{
    width:100%;
}
a{
    color: black;
}
.text-info {
    color: #767a7a !important;
}
img{
    margin-left:20%;
    margin-top:20%;
    width:60%;
     height:60%;
}
#login-page
{
    padding-top:100px;
    padding-bottom:50px;
    background-color:#c4c4c4;
}
#login-box{
    color:white;
}
@media only screen and (max-width: 600px) {

   #login-page
{
    padding-top:0px;
    padding-bottom:0px;
    background-color:#c4c4c4;
}
  img {
    margin-left: 20%;
    margin-top: 0%;
      width:50%;
     height:90%;
}
}
    </style>