        <style type="text/css">
        @media screen and (max-width : 1920px){
        .logo-mobile{
            margin-top:0px;
        }
        }
        @media screen and (max-width : 906px){
        .logo-mobile{
            margin-top:20px;
        }
        }
        </style>
        <div class="mdk-drawer js-mdk-drawer" id="default-drawer"> 
            <div class="mdk-drawer__content ">
                <div class="sidebar sidebar-left sidebar-dark bg-dark o-hidden" style="width:200px;" data-perfect-scrollbar>
                    <div class="sidebar-p-y" style="margin-left:-40px;">
                        <?php if(!empty($userData)) {?>
                            <img class="logo-mobile" src="<?php echo base_url().'assets1/uploads/'. $userData->logo;?>" alt="E-Mart" id="upfile1" style="width: 176px;height: 130px;margin-left: 50px;object-fit: contain;">
                        <?php } else {?>
                            <img class="logo-mobile" src="<?php echo base_url('assets1/img/dummy_logo.png');?>" alt="E-Mart" id="upfile1" style="width:250px;height:130px;object-fit: contain;"/>
                        <?php }?>
                        <ul>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="<?php echo base_url('backend/MyShopController/index');?>">
                                    <i class="material-icons">dashboard</i>&nbsp;<span class="sidebar-menu-text">My Dashboard</span>
                                </a>
                            </li>
                            
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="<?php echo base_url('backend/MyProfile/myaccount');?>">
                                    <i class="material-icons">account_box</i>&nbsp;<span class="sidebar-menu-text">My Account</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="<?php echo base_url('backend/MyProfile/myprofile');?>">
                                    <i class="material-icons">person</i>&nbsp;<span class="sidebar-menu-text">My Profile</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <!--<a class="sidebar-menu-button" href="<?php echo base_url('Login');?>">-->
                                <!--    <i class="material-icons">lock</i>&nbsp;<span class="sidebar-menu-text">Sign Out</span>-->
                                <!--</a>-->
                                <a class="sidebar-menu-button" href="https://direct-buy.in/Welcome/logout">
                                    <i class="material-icons">lock</i>&nbsp;<span class="sidebar-menu-text">Sign Out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>