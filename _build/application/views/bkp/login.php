
<!DOCTYPE html>
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title><?php echo SITE_NAME ?> | <?php echo isset($page_title)?$page_title:""; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="<?php echo SITE_NAME ?>" name="description" />
        <meta content="<?php echo SITE_NAME ?>" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/admin_theme/global/plugins/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/admin_theme/global/plugins/simple-line-icons/simple-line-icons.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/admin_theme/global/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/admin_theme/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo base_url('assets/admin_theme/global/plugins/select2/css/select2.min.css');?>" rel="stylesheet" type="text/css');?>" />
        <link href="<?php echo base_url('assets/admin_theme/global/plugins/select2/css/select2-bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo base_url('assets/admin_theme/global/css/components.min.css');?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo base_url('assets/admin_theme/global/css/plugins.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo base_url('assets/admin_theme/pages/css/login-4.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png');?>" /> 
		</head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <!--a href="index.html">
                <img src="<?php echo base_url('assets/admin_theme/pages/img/logo-big.png');?>" alt="" /> </a-->
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
		<?php if(isset($login) && !empty($login)){ ?>
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="<?php echo base_url()."login"?>" method="post">
                <h3 class="form-title">Login to MauliBtrack</h3>
				<center>
				<?php $error = $this->session->flashdata('error');
					if($error)
					{
					?>
					<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php echo $this->session->flashdata('error'); ?>
					</div>
					<?php } ?>
					
					<?php $success = $this->session->flashdata('success');
					if($success)
					{
					?>
					<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php echo $this->session->flashdata('success'); ?>
					</div>
					<?php } ?>
					
                  <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
				</center>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any username and password. </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" maxlength="100" /> </div>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" maxlength="100" /> </div>
                </div>
                <div class="form-actions">
					<center>
                    <button type="submit" class="btn green"> Login </button>
					 </center>
                </div>
             
                <div class="forget-password">           
                     <h4>Forgot your password ?</h4>
                        <p>Click
						<a href="<?php echo base_url("login/forgot_password");?>" id="forget-password">here</a> to reset your password. </p> 
                </div>
				
                <div class="create-account">
                      <a class="btn red" href="<?php echo base_url()."login/download_apk"?>">Download APK</a>
                </div>
            </form>
            <!-- END LOGIN FORM -->
		<?php } ?>
		
            <?php if(isset($forgot_password) && !empty($forgot_password)){ ?>
            <!-- BEGIN FORGOT PASSWORD FORM -->
           <form class="forget-form" style="display:block;" action="<?php echo base_url()."login/forgot_password"?>" method="post" id="forgot_password">
                <h3>Forget Password ?</h3>
                <p> Enter your Mobile No. below to reset your password. </p>
				<span  class="text-danger"><?php echo $this->session->flashdata('fp_error'); ?></span>
				<span class="text-success"></span><br/>
                <div class="form-group">
                    <div class="input-icon">
                        <i class="fa fa-phone"></i>
                        <input class="form-control placeholder-no-fix" type="text" required autocomplete="off" placeholder="Mobile No." name="mobile_no" id="mobile_no" maxlength="10" value="<?php echo $this->session->flashdata('fp_mobile')?$this->session->flashdata('fp_mobile'):set_value("mobile_no");?>" /> </div>
						<?php echo form_error('mobile_no','<span class="text-danger">','</span>'); ?>
                </div>
				  <div class="form-actions">
                    <a href="<?php echo base_url("login"); ?>" class="btn red"> Back </a> 
					<button type="submit" class="btn green pull-right"> Submit </button>                 
					</div>
				</form>
			<?php } ?>
			
			<?php if(isset($validate_otp) && !empty($validate_otp)){ ?>
            <!-- BEGIN FORGOT PASSWORD FORM -->
           <form class="forget-form" style="display:block;" action="<?php echo base_url()."login/validate_otp"?>" method="post" id="validate_otp">
                <h3>Validate OTP </h3>
                <p id="msg"> Please Enter OTP</p>				
				<span  class="text-danger"><?php echo $this->session->flashdata('vo_error'); ?></span>
				<span  class="text-success"></span><br/>
                <div class="form-group">
                    <div class="input-icon">
                        <i class="fa fa-phone"></i>
                        <input class="form-control placeholder-no-fix" type="text" required autocomplete="off" placeholder="Enter OTP" name="otp" id="otp" maxlength="10" /> </div>
						<?php echo form_error('otp','<span class="text-danger">','</span>'); ?>
                </div>
				  <div class="form-actions">
                    <a href="<?php echo base_url("login"); ?>" class="btn grey-salsa btn-outline"> Back </a> 
					<button type="submit" class="btn green pull-right"> Submit </button>                 
					</div>
				</form>
			<?php } ?>
			
			<?php if(isset($reset_password) && !empty($reset_password)){ ?>
			 <form class="forget-form"  style="display:block;" action="<?php echo base_url()."login/reset_password"?>" method="post" id="reset_password">
			 <h3>Forget Password ?</h3>
			 <span  class="text-danger"><?php echo $this->session->flashdata('rp_error'); ?></span>
			<span  class="text-success"></span><br/>
			
				<div class="form-group">
                    <div class="input-icon">
                        <i class="fa fa-key"></i>
                        <input class="form-control placeholder-no-fix" type="password" required autocomplete="off" placeholder="Enter New Password" name="new_password" id="new_password" maxlength="100" value="<?php echo set_value("new_password");?>" /> </div>
						<?php echo form_error('new_password','<span class="text-danger">','</span>'); ?>
                </div>
				<div class="form-group ">
                    <div class="input-icon">
                        <i class="fa fa-key"></i>
                        <input class="form-control placeholder-no-fix" type="password" required autocomplete="off" placeholder="Confirm Password" name="confirm_password" id="confirm_password" maxlength="100" value="<?php echo set_value("confirm_password");?>"/> </div>
						<?php echo form_error('confirm_password','<span class="text-danger">','</span>'); ?>
                </div>
                <div class="form-actions">
                   <div class="form-actions">
                    <a href="<?php echo base_url("login"); ?>" class="btn red"> Back </a> 
					<button type="submit" class="btn green pull-right"> Submit </button>                 
					</div></div>
                 </form>
            <!-- END FORGOT PASSWORD FORM -->
			<?php } ?>
  
        </div>
        <!-- END LOGIN -->
		
<!-- START MODAL -->		
<div id="branch_modal" class="modal fade" role="dialog"  data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-red-mint"><h4 class="modal-title font-white sbold "><i class="font-bold icon-share"></i> &nbsp;Select Branch</h4>
             </div>
            <div class="modal-body">
				<form action="<?php echo base_url().'login/get_branch_dashboard'; ?>" id="confirm_branch_form" method="post" autocomplete="off">
						  <div class="form-body">
							<div class="form-group">
							   <label for="branch_name">Select Branch</label><?php echo REQUIRED_STAR; ?>
								<select class="form-control" id="p_branch" name="p_branch" onchange="this.form.submit();">
								<option value="" >Select Branch</option>
								 <?php  if(!empty($branch_list)){ 
									foreach($branch_list as $branch){ 
										$branch_name = !empty($branch['branch_name'])?$branch['branch_name']:$branch['branch_id'];						
									?>
										<option value="<?php echo base64_encode($branch['branch_id']);?>" ><?php echo $branch_name;?></option>
								<?php } } ?>
								 <?php echo form_error('p_branch','<span class="text-danger">','</span>'); ?>
							   </select>
							</div> 	  
						  </div>
				</form>
            </div>
        </div>
    </div>
</div>
<div id="mymodal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title"> </h4>
                <button type="button" class="close" data-dismiss="modal">
                    &times;</button>
                
            </div>
            <div class="modal-body">
			<div class="form-group">
              
            </div>
			<div class="form-group">
				<button class="btn btn-fill-out btn-block text-uppercase rounded-0" title="Subscribe" type="submit">Validate</button>
			</div>
            </div>
            <div class="modal-footer">
                <!--button type="button" class="btn btn-danger" data-dismiss="modal">
                    Close</button-->
            </div>
        </div>
    </div>
</div>

 <!-- END MODAL -->
 
        <!-- BEGIN COPYRIGHT -->
        <div class="copyright">  Copyright &copy; <?php echo date("Y")?> <a href="https://www.mauli-infotech.co.in/" target="_blank">Mauli Infotech (OPC) Pvt. Ltd.</a> </div>
        <!-- END COPYRIGHT -->

        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/js.cookie.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/jquery.blockui.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js');?>" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/select2/js/select2.full.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/backstretch/jquery.backstretch.min.js');?>" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url('assets/admin_theme/global/scripts/app.min.js');?>" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
		  <script> var base_url = '<?php echo base_url();?>'</script>
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url('assets/admin_theme/pages/scripts/login-4.js');?>" type="text/javascript"></script>
       
		 <script src="<?php echo base_url('assets/js/login_custom.js'); ?>" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            });
			
			
			
	$(document).ready(function() {
	$("#confirm_branch_form").validate({
        rules: {
            required: {
                required: true
            },
            p_branch: {
                required: true,
				 },
			},
 
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        }
    });
    });
	<?php if(!empty($branch_list)){ ?>
	 /* $('#branch_modal').modal({
                    closable : false,
                    onDeny : function(){  },
                   }).modal('show'); */
				   
		$('#branch_modal').modal({
							backdrop: 'static',
							keyboard: false
						});		   
 	<?php } ?>
	
        </script>

<script type="text/javascript">
$(document).ready(function() {
	$("#reset_password").validate({
        rules: {
            required: {
                required: true
            },
            new_password: {
                required: true,
                minlength: 6,
                maxlength: 100,
                noSpace: true,
            },
         
            confirm_password: {
                required: true,
                equalTo: "#new_password"
            },
           
        },
 
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        }
    });
	$("#forgot_password").validate({
        rules: {
            required: {
                required: true
            },
            mobile_no: {
                required: true,
                minlength: 10,
                maxlength: 10,
                digits: true,
            },
         
                      
        },
 
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        }
    });
	$("#validate_otp").validate({
        rules: {
            required: {
                required: true
            },
            otp: {
                required: true,
                maxlength: 10,
            },
         
                      
        },
 
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        }
    });
	
	
    });
</script>
</body>


</html>