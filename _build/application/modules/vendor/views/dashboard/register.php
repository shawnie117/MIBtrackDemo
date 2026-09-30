
<!DOCTYPE html>
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title><?php echo V_SITE_NAME ?> | <?php echo isset($page_title)?$page_title:""; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="<?php echo V_SITE_NAME ?>" name="description" />
        <meta content="<?php echo V_SITE_NAME ?>" name="author" />
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
		 <link href="<?php echo get_assets_path(); ?>admin_theme/file_upload_jscss/css/bootstrap_file_field.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png');?>" /> 
		</head>
    <!-- END HEAD -->

    <body class="login" style="margin-top:10px;">
      
        <div class="content" style="width:650px;margin-top:55px;">		
			
			<?php if(isset($register_now) && !empty($register_now)){ ?>
			
			    <!-- BEGIN REGISTRATION FORM -->
            <form class="register-form"  style="display:block;" id="registration_form" action="<?php echo base_url()."register-now"?>" method="post" enctype="multipart/form-data">
                <center><h3>New Registration</h3>
				 <span  class="text-danger"><?php echo $this->session->flashdata('rn_error'); ?></span>
			     <span  class="text-success"><?php echo $this->session->flashdata('rn_successs'); ?></span><br/><br/></center>
				 <div class="col-md-6">
                <div class="form-group ">
                    <label class="control-label visible-ie8 visible-ie9">Owner Name <?php echo REQUIRED_STAR; ?></label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Owner Name " name="cust_name" id="cust_name" maxlength="100" value="<?php echo set_value("cust_name");?>" required /> </div>
						<?php echo form_error('cust_name','<span class="text-danger">','</span>'); ?>
                </div> 
				 <div class="form-group">                  
                    <label class="control-label visible-ie8 visible-ie9">Contact No <?php echo REQUIRED_STAR; ?></label>
                    <div class="input-icon">
                        <i class="fa fa-phone"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Contact No" name="cust_contact" id="cust_contact" maxlength="10" value="<?php echo set_value("cust_contact");?>" required /> </div>
						<?php echo form_error('cust_contact','<span class="text-danger">','</span>'); ?>
                </div>
                <div class="form-group">                    
                    <label class="control-label visible-ie8 visible-ie9">Email ID <?php echo REQUIRED_STAR; ?></label>
                    <div class="input-icon">
                        <i class="fa fa-envelope"></i>
                        <input class="form-control placeholder-no-fix" type="email" placeholder="Email ID"name="cust_contact_email" id="cust_contact_email" maxlength="100"  value="<?php echo set_value("cust_contact_email");?>" required /> </div>
						<?php echo form_error('cust_contact_email','<span class="text-danger">','</span>'); ?>
                </div> 

              <div class="form-group">                    
                    <label class="control-label visible-ie8 visible-ie9">Pan No. <?php echo REQUIRED_STAR; ?></label>
                    <div class="input-icon">
                        <i class="fa fa-file-image-o"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="PAN No."name="cust_panno" id="cust_panno" maxlength="10"  value="<?php echo set_value("cust_panno");?>" required /> </div>
						<?php echo form_error('cust_panno','<span class="text-danger">','</span>'); ?>
                </div>
                		
				</div>
				 <div class="col-md-6">
				
				<div class="form-group ">
                    <label class="control-label visible-ie8 visible-ie9">Company Name <?php echo REQUIRED_STAR; ?></label>
                    <div class="input-icon">
                        <i class="fa fa-university"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Company Name"  name="cust_comp_name" id="cust_comp_name" maxlength="100" value="<?php echo set_value("cust_comp_name");?>"  required /> </div>
						<?php echo form_error('cust_comp_name','<span class="text-danger">','</span>'); ?>
                </div>
				<div class="form-group">                  
                    <label class="control-label visible-ie8 visible-ie9">Contact Person <?php echo REQUIRED_STAR; ?></label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Contact Person" name="cust_contact_person" id="cust_contact_person" maxlength="100" value="<?php echo set_value("cust_contact_person");?>" required /> </div>
						<?php echo form_error('cust_contact_person','<span class="text-danger">','</span>'); ?>
                </div> 
				<div class="form-group">                    
                    <label class="control-label visible-ie8 visible-ie9">Website </label>
                    <div class="input-icon">
                        <i class="fa fa-at"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Website"name="cust_website" id="cust_website" maxlength="100"  value="<?php echo set_value("cust_website");?>"  /> </div>
						<?php echo form_error('cust_website','<span class="text-danger">','</span>'); ?>
                </div>
				<div class="form-group">                    
                    <label class="control-label visible-ie8 visible-ie9">Id Proof No. <?php echo REQUIRED_STAR; ?></label>
                    <div class="input-icon">
                        <i class="fa fa-file-image-o"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Id Proof No."name="cust_id_num" id="cust_id_num" maxlength="50"  value="<?php echo set_value("cust_id_num");?>" required /> </div>
						<?php echo form_error('cust_id_num','<span class="text-danger">','</span>'); ?>
                </div>				
				</div>  				
				<div class="form-group col-md-12">                    
                    <label class="control-label visible-ie8 visible-ie9 " >Address<?php echo REQUIRED_STAR; ?></label>
                    <div class="input-icon">
                        <i class="fa fa-home"></i>
                        <textarea class="form-control placeholder-no-fix" placeholder="Address" name="cust_address" id="cust_address" maxlength="500" required style="resize:none;" ><?php echo set_value("cust_address");?></textarea> </div>
						<?php echo form_error('cust_address','<span class="text-danger">','</span>'); ?>
                </div>
				  <div class="form-group col-md-6">
					   <label for="cust_pan_img">PAN Image</label><br/>
					    <div class="input-icon">
						<input type="file" name="cust_pan_img"  id="cust_pan_img" 
						class="smart-file" 
						data-label="Upload PAN Image" 
						data-btn-class="btn btn red-pink btn-sm" 
				
						data-file-types="image/jpeg,image/png,image/jpg"  required  accept="image/*"  />
						</div>
						<?php echo form_error('cust_pan_img','<span class="text-danger">','</span>'); ?>
						<span class="file_err text-danger"></span>
				  </div>
                 		  <!-- data data-preview="on" is off -->
				<div class="form-group col-md-6 ">
				   <label for="cust_id_img">Id Proof Image</label><br/>
				     <div class="input-icon">
					<input type="file" name="cust_id_img"  id="cust_id_img" 
					class="smart-file" 
					data-label="Upload Id Proof Image" 
					data-btn-class="btn btn red-pink btn-sm" 
					
					data-file-types="image/jpeg,image/png,image/jpg" required accept="image/*"    />
					</div>
					<?php echo form_error('cust_id_img','<span class="text-danger">','</span>'); ?>								
					<span class="file_err text-danger "></span>
				</div>  
               <!-- data data-preview="on" is off -->
                <div class="form-actions">
				   <center>
                    <a href="<?php echo base_url("login"); ?>" class="btn red"> Back </a> 
                    <span id="register-submit-btn" class="btn green"> Register</span>
					</center>
                </div>
				
            </form>
            <!-- END REGISTRATION FORM -->
			<?php } ?>
        </div>
        <!-- END LOGIN -->
		

        <!-- BEGIN COPYRIGHT -->
        <div class="copyright">  Copyright &copy; <?php echo date("Y")?> <a href="https://www.mauli-infotech.co.in/" target="_blank" style="color:#5bedcb;">Mauli Infotech (OPC) Pvt. Ltd.</a> </div>
        <!-- END COPYRIGHT -->

<div id="mymodal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-red-mint"><h4 class="modal-title font-white sbold"> </h4>
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
		  <script> var base_url = '<?php echo get_module_path();?>'</script>
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url('assets/admin_theme/pages/scripts/login-4-2.js');?>" type="text/javascript"></script>
       <script src="<?php echo get_assets_path(); ?>admin_theme/file_upload_jscss/js/bootstrap_file_field.js" type="text/javascript"></script>

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
				
				 $('.smart-file').bootstrapFileField({
                    fileTypes: 'image/jpeg,image/png,image/jpg',  
		            maxFileSize: 1000000 // 1Mb in bytes */
               });
				
			jQuery.validator.addMethod("pan", function(value, element, param) {
            return this.optional(element) ||  /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/.test(value);
            }, "Enter Valid PAN No.");	
			
			
			
			jQuery.validator.addMethod("filesize_max", function(value, element, param) {
			var isOptional = this.optional(element),
			file;
    
			if(isOptional) {
				return isOptional;
			}
    
			if ($(element).attr("type") === "file") {
				
				if (element.files && element.files.length) {
					
					file = element.files[0];            
					return ( file.size && file.size <= param ); 
				}
			}
			return false;
		}, "File size must be less than 1Mb.");


		jQuery.validator.addMethod("filesize_min", function(value, element, param) {
			var isOptional = this.optional(element),
				file;
			
			if(isOptional) {
				return isOptional;
			}
			
			if ($(element).attr("type") === "file") {
				
				if (element.files && element.files.length) {
					
					file = element.files[0];            
					return ( file.size && file.size >= param ); 
				}
			}
			return false;
		}, "File should be at least 10 Kb.");
						

	$("#registration_form1").validate({
        rules: {
            required: {
                required: true
            },
            cust_name: {
                required: true,
                maxlength: 100,
            },
			cust_comp_name: {
                required: true,
                maxlength: 100,
            },
			cust_contact: {
                required: true,
                maxlength: 10,
                minlength: 10,
				digits:true,
            },
			cust_contact_email: {
                required: true,
                maxlength: 100, 
				email: true,
            },
			cust_contact_person: {
                required: true,
                maxlength: 100, 
            },
			cust_address: {
                required: true,
                maxlength: 500, 
            },
			cust_website: {
                maxlength: 100, 
            },
			cust_panno: {
				required: true,
				pan: true,
                maxlength: 10, 
            },
			cust_id_num: {
				required: true,
                maxlength: 50, 
            },
			cust_pan_img: {				 
				  required: true,
                   accept: "image/jpeg,image/png,image/jpg",
				   filesize_max:1000000, // 1 MB
				   filesize_min:10000, // 1 KB
   				}, 
			emp_addrs_prf_img: {				 
				  required: true,
                   accept: "image/jpeg,image/png,image/jpg",
				   filesize_max:1000000, // 1 MB
				   filesize_min:10000, // 1 KB
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
        },
		onfocusout: false,
	    invalidHandler: function(form, validator) {
			var errors = validator.numberOfInvalids();
			if (errors) {                    
            validator.errorList[0].element.focus();
			}
		   },
		 errorPlacement: function(error, element) {
		   if (element.is(":file")) {
			 error.appendTo((element).parents('.form-group').find('.file_err'));
			}else { // This is the default behavior of the script for all fields
			error.insertAfter(element);
			}
		 }
    });
    });
</script>
</body>


</html>