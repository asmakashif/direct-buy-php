<!DOCTYPE html>
<html lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title><?php echo $_SERVER['SERVER_NAME']?></title>
    <!-- Perfect Scrollbar -->
    <link type="text/css" href="<?php echo base_url('');?>assets1/vendor/perfect-scrollbar.css" rel="stylesheet">
    <!-- Material Design Icons -->
    <link type="text/css" href="<?php echo base_url('');?>assets1/css/material-icons.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('');?>assets1/css/material-icons.rtl.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('');?>assets1/css/app.css" rel="stylesheet">
    <?php if(!empty($userData)) {?>
        <link rel="shortcut icon" href="<?php echo base_url().'assets1/uploads/'. $userData->logo;?>">
    <?php } else {?>
        <link rel="shortcut icon" href="<?php echo base_url().'assets1/img/logo.png';?>">
    <?php }?>
    <script src="https://kit.fontawesome.com/96726ca6f2.js" crossorigin="anonymous"></script>
</head>
<body class=" layout-fluid">
    <div class="preloader">
        <div class="sk-double-bounce">
            <div class="sk-child sk-double-bounce1"></div>
            <div class="sk-child sk-double-bounce2"></div>
        </div>
    </div>
    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout">