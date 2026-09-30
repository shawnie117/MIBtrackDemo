<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	   <div class="col-md-6">
         <div class="portlet light bordered">
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint icon-key"></i>
                  <span class="caption-subject font-blue-madison bold "><?php echo $page_title; ?></span>
               </div>
			  
		      </div>
                        
                 <div class="portlet-body form">  
				 				 
                 <?php
                     $this->load->helper('form');
                     $error = $this->session->flashdata('error');
                     if($error)
                     {
                     ?>
                  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     <?php echo $this->session->flashdata('error'); ?>
                  </div>
                  <?php } ?>
                  <?php  
                     $success = $this->session->flashdata('success');
                     if($success)
                     {
                     ?>
                  <div class="alert alert-success alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     <?php echo $this->session->flashdata('success'); ?>
                  </div>
                  <?php } ?>
				  
			<?php if(!empty($employee_list)) { $form_action = "change_emp_password";
					}else { $form_action = "change_my_password";  } ?>
					
                     <form action="<?php echo base_url().'admin/'.$form_action; ?>" id="pass_change_form" method="post" autocomplete="off">
					  <div class="form-body">	
						<?php if(!empty($employee_list)) { ?>
						
						<div class="form-group"> 
							<label for="old_password">Select User</label><?php echo REQUIRED_STAR; ?>
                            <select class="form-control" id="emp_id" name="emp_id">
							<option value=""> Select User</option>
							 <?php  if(!empty($employee_list)){ 
								foreach($employee_list as $employee){ 
								  $emp_name = $employee['emp_name'];
								  $emp_id   = $employee['emp_id'];
								  $selected = set_value('emp_id')==$emp_id?"selected":"";
								 
								
								?>
								<option value="<?php echo $emp_id?>" <?php echo $selected; ?>><?php echo $emp_name; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
						
						<?php } ?>					  
                        <div class="form-group">
                           <label for="old_password">Current Password</label><?php echo REQUIRED_STAR; ?>
                           <input class="form-control" id="old_password" name="old_password" type="password" placeholder="Enter Current Password" maxlength="100" value="<?php echo set_value('old_password'); ?>">
						    <?php echo form_error('old_password','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group">
                           <label for="new_password">New Password</label><?php echo REQUIRED_STAR; ?>
                           <input class="form-control" id="new_password" name="new_password" type="password" placeholder="Enter New Password" maxlength="100" value="<?php echo set_value('new_password'); ?>">
						    <?php echo form_error('new_password','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group">
                           <label for="confirm_password">Confirm Password</label><?php echo REQUIRED_STAR; ?>
                           <input class="form-control" id="confirm_password" name="confirm_password" type="password" placeholder="Enter Confirm Password" maxlength="100" value="<?php echo set_value('confirm_password'); ?>">
						    <?php echo form_error('confirm_password','<span class="text-danger">','</span>'); ?>
                        </div>
                        </div>						 
						<div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" type="submit" >Submit</button>
                          <button type="reset" class="btn red btn-outline">Cancel</button>
                        </div>
                        </div>
						</form>              
                         </div>
                     
                  </div>
               </div>
            </div>
         </div>
         <!-- END PAGE BASE CONTENT -->
      </div>
      <!-- END CONTENT BODY -->
   <!-- END CONTENT -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- Form Validation Plugins -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
		
<script type="text/javascript">
$(document).ready(function() {
	$("#pass_change_form").validate({
        rules: {
            required: {
                required: true
            },
            emp_id: {
                required: true,
             },  
			old_password: {
                required: true,
                minlength: 5,
                maxlength: 100,
                noSpace: true,
            }, 
			new_password: {
                required: true,
                minlength: 5,
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
    });
</script>