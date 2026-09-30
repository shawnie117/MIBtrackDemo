<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	   <div class="col-md-12">
         <div class="portlet light bordered">
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint icon-key"></i>
                  <span class="caption-subject font-red-mint bold "><?php echo $page_title; ?></span>
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
					
                     <form action="<?php echo get_module_path().'admin/'.$form_action; ?>" id="pass_change_form" method="post" autocomplete="off">
					  <div class="form-body">	
						<?php if(!empty($employee_list)) { ?>
						
						<div class="form-group col-md-3"> 
							<label for="old_password">Select User</label><?php echo REQUIRED_STAR; ?>
                            <select class="form-control" id="user_id" name="user_id" required>
							<option value=""> Select User</option>
							 <?php  if(!empty($employee_list)){ 
								foreach($employee_list as $employee){ 
								  $emp_name = $employee['emp_name'];
								  $user_id   = $employee['user_id'];
								  $selected = set_value('user_id')==$user_id?"selected":"";
								 
								
								?>
								<option value="<?php echo $user_id?>" <?php echo $selected; ?>><?php echo $emp_name; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>									  
                       
						<?php } ?>	
						<?php if(empty($employee_list)) { ?>
						 <div class="form-group col-md-3">
                           <label for="old_password">Current Password</label><?php echo REQUIRED_STAR; ?>
                           <input class="form-control" id="old_password" name="old_password" type="password" placeholder="Enter Current Password" maxlength="100" value="<?php echo set_value('old_password'); ?>" required><i class="fa fa-eye" aria-hidden="true" style="cursor:pointer;float:right;position:relative;top:-23px;right:10px;" onclick="show_password('old_password');" title="Show Password"></i>
						    <?php echo form_error('old_password','<span class="text-danger">','</span>'); ?>
                        </div>
						<?php } ?>	
						<div class="form-group col-md-3">
                           <label for="new_password">New Password</label><?php echo REQUIRED_STAR; ?>
                           <input class="form-control" id="new_password" name="new_password" type="password" placeholder="Enter New Password" maxlength="100" value="<?php echo set_value('new_password'); ?>" required><i class="fa fa-eye" aria-hidden="true" style="cursor:pointer;float:right;position:relative;top:-23px;right:10px;" onclick="show_password('new_password');" title="Show Password"></i> 
						    <?php echo form_error('new_password','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-3">
                           <label for="confirm_password">Confirm Password</label><?php echo REQUIRED_STAR; ?>
                           <input class="form-control" id="confirm_password" name="confirm_password" type="password" placeholder="Enter Confirm Password" maxlength="100" value="<?php echo set_value('confirm_password'); ?>" required><i class="fa fa-eye" aria-hidden="true" style="cursor:pointer;float:right;position:relative;top:-23px;right:10px;" onclick="show_password('confirm_password');" title="Show Password"></i>
						    <?php echo form_error('confirm_password','<span class="text-danger">','</span>'); ?>
                        </div>
                        </div>						 
						<div class="form-actions  " >
						 <div class="col-md-offset-4 col-md-8">
                           <button class="btn btn-success" id="mybutton" type="submit" >Submit</button>
                          <button type="reset" class="btn red btn-outline">Cancel</button>
                        </div>
                        </div>
						</form>              
                         </div>
                         <script>
						const button = document.getElementById('mybutton');

button.addEventListener('click', function() {
    // Clicked button becomes disabled after 1 second
    setTimeout(() => {
        button.disabled = true;
        
        // Re-enable the button after an additional 2 seconds (total of 3 seconds from click)
        setTimeout(() => {
            button.disabled = false;
        }, 1000);
    });
});
</script>
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