<!-- Header Layout Content -->
<div class="mdk-header-layout__content">
    <div data-push data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
        <div class="mdk-drawer-layout__content page ">
            <div class="container-fluid page__container">
                <h1 class="h2">Change Password</h1>
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo base_url('backend/MyProfile/updatePassword');?>" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" class="form-control" name="old_password" placeholder="Enter Old Password" required="">
                                        <input type="hidden" class="form-control" name="id" value="<?php echo $id?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" class="form-control" name="new_password" id="password" placeholder="Enter New Password" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required="">
                                        <span id='message'></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" name="submit" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('backend/include/sidebar')?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script>
            window.onunload = function(){
                window.opener.location.reload();
            };
            $(' #confirm_password').on('keyup', function () {
                if ($('#password').val() == $('#confirm_password').val()) {
                    $('#message').html('Matching').css('color', 'green');
                } else 
                $('#message').html('Not Matching').css('color', 'red');
            
                $("#submit").removeAttr('disabled','disabled');
            });
        </script>   