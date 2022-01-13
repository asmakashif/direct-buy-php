<!-- Header Layout Content -->

<div class="mdk-header-layout__content">
	<div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
		<div class="mdk-drawer-layout__content page ">
			<div class="container-fluid page__container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url('backend/MyShopController/index')?>">Home</a></li>
					<li class="breadcrumb-item active">My Profile</li>
				</ol>
				<h1 class="h2">My Profile</h1>
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								
								<form action="<?php echo base_url('backend/MyProfile/updateProfile');?>" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                        	<label for="firstname"><b>First Name</b></label>
                                            <input readonly="" name="firstname" type="text" class="form-control" id="firstname"  value="<?php echo $userData->firstname;?>">
                                            <input name="userid" type="hidden" class="form-control" id="userid"  value="<?php echo $userData->id;?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname"><b>Last Name</b></label>
                                            <input readonly="" name="lastname" type="text" class="form-control" id="lastname"  value="<?php echo $userData->lastname;?>">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="domainame"><b>Domain Name</b></label>
                                            <input disabled="" name="domainame" type="text" class="form-control" id="domainame" value="<?php echo $userData->domainname;?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="contact"><b>Contact</b></label>
                                            <input readonly="" name="contact" type="text" class="form-control" id="contact" value="<?php echo $userData->contact;?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="email"><b>Email</b></label>
                                            <input readonly="" name="email" type="text" class="form-control" id="email" value="<?php echo $userData->email;?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password"><b>Password</b>&nbsp;<a href="<?php echo base_url('backend/MyProfile/changePassword/'. $userData->id);?>" onclick="basicPopup(this.href);return false">Change Password</a></label>
                                            <input readonly="" value="<?php echo $userData->password;?>" name="password" type="password" id="password" value="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="address"><b>Address</b></label>
                                            <br>
                                            <br>
                                            <input readonly="" name="address" type="text" class="form-control" id="address" value="<?php echo $userData->address;?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="logo"><b>Logo</b></label>&nbsp;&nbsp;<img src="<?php echo base_url().'assets1/uploads/'. $userData->logo;?>" alt="Logo" width="100" height="50" class="thumbnail">
                                                        <br>
                                            <input disabled="" name="comp_logo" type="file" id="logo" value="" class="form-control">
                                        </div>
                                    </div>
                                    <br>
                                    <a href="<?php echo base_url('backend/MyShopController/index');?>" class="btn btn-warning">Cancel</a>
                                    <button type="" id="editProfile"class="btn btn-info"  value="">Edit</button>
                                    <!-- <a href="<?php echo base_url('backend/MyProfile/editProfile');?>" ><button type="" class="btn btn-info"  value="">Edit</button></a> -->
                                </form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- container-fluid -->
		</div>
		<!-- End Page-content -->
		<?php $this->load->view('backend/include/sidebar');?>
        <script src="<?php echo base_url('assets1/js/jquery.min.js');?>"></script>
        <script>
            $(document).ready(function(){
                $('#editProfile').click(function(){
                    $('#firstname').prop('readonly',false);
                    $('#lastname').prop('readonly',false);
                    // $('#contact').prop('readonly',false);
                    $('#address').prop('readonly',false);
                    // $('#email').prop('readonly',false);
                    // $('#password').prop('readonly',false);
                    $('#logo').prop('disabled',false);
                    $('#editProfile').replaceWith(`<button class="btn btn-success" value="submit">Update</button>`);
                });
            });
            function basicPopup(url) 
            {
                popupWindow = window.open(url,'popUpWindow','height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
            }
        </script> 