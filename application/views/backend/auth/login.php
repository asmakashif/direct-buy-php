<!DOCTYPE html>
<html lang="en" dir="ltr">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $_SERVER['SERVER_NAME']?> Login</title>
    <!-- Perfect Scrollbar -->
    <link type="text/css" href="<?php echo base_url('assets1/vendor/perfect-scrollbar.css');?>" rel="stylesheet">
    <!-- Material Design Icons -->
    <link type="text/css" href="<?php echo base_url('assets1/css/material-icons.css');?>" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('assets1/css/material-icons.rtl.css');?>" rel="stylesheet">
  <!-- Font Awesome Icons -->
    <link type="text/css" href="<?php echo base_url('assets1/css/fontawesome.css');?>" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('assets1/css/fontawesome.rtl.css');?>" rel="stylesheet">
  
    <!-- App CSS -->
    <link type="text/css" href="<?php echo base_url('assets1/css/app.css');?>" rel="stylesheet">
    <?php if(!empty($userData)) {?>
        <link rel="shortcut icon" href="<?php echo base_url().'assets1/uploads/'. $userData->logo;?>">
    <?php } else {?>
        <link rel="shortcut icon" href="<?php echo base_url().'assets1/img/new_logo.png';?>">
    <?php }?>
</head>

<body class="login" style="background-color:#E0E0E0">
    <div class="d-flex align-items-center">
        <div class="col-sm-10 col-md-6 col-lg-5 mx-auto">
            <div class="text-center mt-5 mb-1">
                <?php if($this->session->flashdata('flashSuccess')) { ?>
                    <div style="width:90%;margin-top: -4%;z-index: 1;margin-left: 35%;" class="alert alert-dismissible bg-success text-white border-0 fade show successmsg" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php echo $this->session->flashdata("flashSuccess"); ?>
                    </div>
                <?php } ?> 
                <?php if($this->session->flashdata('flashError')) { ?>
                    <div style="width:70%;margin-top: -4%;z-index: 1;margin-left:15%;" class="alert alert-dismissible bg-danger text-white border-0 fade show errormsg" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php echo $this->session->flashdata("flashError"); ?>
                    </div>
                <?php } ?>
                <?php if(!empty($userData)) {?>
                    <img class="logo-mobile" src="<?php echo base_url().'assets1/uploads/'. $userData->logo;?>" alt="E-Mart" id="upfile1" style="width:250px;height:130px;">
                <?php } else {?>
                    <img src="<?php echo base_url('assets1/img/new_logo.png');?>" alt="E-Mart" id="upfile1" style="width:250px;height:130px;"/>
                <?php }?>
            </div>
            &nbsp;
            <div id="content-desktop">
                <div class="card navbar-shadow" style="border-radius:35px;">
                    
                    <div class="card-body">
                        <form action="<?php echo base_url('Login/auth');?>" method="post" >
                            <?php $data = explode('.',$_SERVER['SERVER_NAME']);?>
                            <div class="form-group"> 
                                <label class="form-label" for="email">Store Domain</label>
                                <div class="input-group">
                                    <input name="domainname" class="form-control" type="text" class="form-control" value="asma" style="border-radius:5px;width:250px;height:40px;background-color:#E0E0E0;">
                                </div>
                            </div>
                            <?php $data = explode('.',$_SERVER['SERVER_NAME']);?>
                            
                            <?php if($data[0] == 'demo') {?>
                                <div class="form-group"> 
                                    <label class="form-label" for="email" >Email</label>
                                    <div class="input-group">
                                        <input name="email" class="form-control" type="email" required="" class="form-control" value="<?php if(isset($userData->email)) { echo $userData->email; } ?>" placeholder="Email Address" style="border-radius:5px;width:250px;height:40px;background-color:#E0E0E0;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="password">Your password</label>
                                    <div class="input-group">
                                        <input name="password" class="form-control" placeholder="Enter Password" type="password" value="<?php if(isset($userData->password)) { echo $userData->password; } ?>" required style="border-radius:5px;width:250px;height:40px;background-color:#E0E0E0;"/>
                                    </div>
                                </div>
                            <?php } else {?>
                                <div class="form-group"> 
                                    <label class="form-label" for="email" >Email</label>
                                    <div class="input-group">
                                        <input name="email" class="form-control" type="email" required="" class="form-control" value="<?php if(isset($_COOKIE["loginId"])) { echo $_COOKIE["loginId"]; } ?>" placeholder="Email Address" style="border-radius:5px;width:250px;height:40px;background-color:#E0E0E0;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="password">Your password</label>
                                    <div class="input-group">
                                        <input name="password" class="form-control" placeholder="Enter Password" type="password" value="<?php if(isset($_COOKIE["loginPass"])) { echo $_COOKIE["loginPass"]; } ?>" required style="border-radius:5px;width:250px;height:40px;background-color:#E0E0E0;"/>
                                    </div>
                                </div>
                            <?php }?>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" <?php if(isset($_COOKIE["loginId"])) { ?> checked="checked" <?php } ?>> Remember Me
                                    </label>   
                                    <a href="<?php echo base_url('Admin/forgotPassword');?>" class="NrmLnk" style="color:#4C80E1;float:right;">Forgot Password?</a>                                 
                                </div>
                            </div>
                            <br>
                            <div class="form-group ">
                                <button type="submit" class="btn btn-default" style="background-color:#4C80E1;border-color:#4C80E1;float:right;color:#fff">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script src="<?php echo base_url('assets1/vendor/jquery.min.js');?>"></script>
<!--//Satarts fluesh message  -->
<?php if($this->session->flashdata('flashSuccess')) { ?>
<script type="text/javascript">
    window.setTimeout(function() {
        $(".successmsg").fadeTo(1000, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 3000);
</script>
<?php } ?>  
<?php if($this->session->flashdata('flashError')) { ?>
<script type="text/javascript">
    window.setTimeout(function() {
        $(".errormsg").fadeTo(900, 0).slideUp(800, function(){
            $(this).remove(); 
        });
    }, 4000);
</script>
<?php } ?> 
<script>
    function myFunction() 
    {
        var x = document.getElementById("password");
        if (x.type === "password") 
        {
            x.type = "text";
        } 
        else 
        {
            x.type = "password";
        }
    }
</script>