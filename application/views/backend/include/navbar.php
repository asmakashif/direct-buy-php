<style type="text/css">
@media screen and (max-width : 1920px){
.div-only-mobile{
visibility:hidden;
}
}
@media screen and (max-width : 906px){
.div-only-mobile{
visibility:visible;
}
}
</style>
<!-- Header -->
<div id="header" data-fixed class="mdk-header js-mdk-header mb-0 div-only-mobile">
    <div class="mdk-header__content">
        <!-- Navbar -->
        <nav id="default-navbar" class="navbar navbar-expand navbar-dark bg-primary m-0" style="background-color: #179B17">
            <div class="container-fluid">
                <!-- Toggle sidebar -->
                <button class="navbar-toggler d-block" data-toggle="sidebar" type="button">
                    <span class="material-icons">menu</span>
                </button>
                <!-- Brand -->
                <a href="<?php echo base_url('welcome/index');?>"></a>
                <?php $data = explode('.',$_SERVER['SERVER_NAME']);?>
                <!--<span class="d-none d-xs-md-block" style="padding-top:0;padding-bottom: 0;-->
                <!--font-size:1.2rem;font-weight:500;display:flex;align-items:center;color:white"><?php echo ucfirst($data[0]);?></span>-->
                <div class="flex"></div>
                <!-- Menu -->
                <!--<ul class="nav navbar-nav flex-nowrap">-->
                    <!-- // END Notifications dropdown -->
                    <!-- User dropdown -->
                <!--    <li class="nav-item dropdown ml-1 ml-md-3">-->
                <!--        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"><img src="<?php echo base_url('assets1/images/avatar.png');?>" alt="Avatar" class="rounded-circle" width="40"></a>-->
                <!--        <div class="dropdown-menu dropdown-menu-right">-->
                            
                <!--            <a class="dropdown-item" href="https://direct-buy.in/Welcome/logout">-->
                <!--                <i class="material-icons">lock</i> Logout-->
                <!--            </a>-->
                <!--        </div>-->
                <!--    </li>-->
                    <!-- // END User dropdown -->

                <!--</ul>-->
                <!-- // END Menu -->
            </div>
        </nav>
        <!-- // END Navbar -->
    </div>
</div>
<!-- // END Header -->