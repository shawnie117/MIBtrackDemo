<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
	
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered">
	     <div class="portlet-title">
               <div class="caption">
                  <i class=" font-green-sharp icon-call-out"></i>
                  <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
               </div>
			   <div class="actions">
			   <button type="button"  class="close" data-dismiss="modal">&times;</button>
               </div>
		   </div>
            <div class="row">
			
               <div class="portlet-body form">
				  <?php if($action=="Assign"){ 
				    $formaction = "assign_ticket/?id=".base64_encode($id);
				    }
					if($action=="AssignC"){ 
				    $formaction = "assign_complaint_ticket/?id=".base64_encode($id);
				    }
					if($action=="AssignS"){ 
				    $formaction = "assign_service_ticket/?id=".base64_encode($id);
				    }
					
					
					?>
					
                     <form action="<?php echo base_url().'customers/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					    <div class="portlet-body">
						<div class="col-md-12"> 
                           <input type="hidden" name="id" value="<?php echo $id; ?>">
						 <div class="form-group">
                           <label for="ticket_assign_to">Ticket Assign To <?php echo REQUIRED_STAR; ?></label>
                           <select class="form-control" id="ticket_assign_to" name="ticket_assign_to" maxlength="100" data-live-search="true" required>							 
							<option value=""> Select Ticket Assign To</option>
							 <?php  if(!empty($employee_list)){ 
								foreach($employee_list as $employee){ ?>
									<option value="<?php echo $employee['user_id'];?>" ><?php echo $employee['emp_name']; ?></option>
							<?php } } ?>	
						  
						   </select>
						    <?php echo form_error('ticket_assign_to','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group">
                           <label for="ticket_priority">Ticket Priority</label><?php echo REQUIRED_STAR; ?>
                           <select class="form-control" id="ticket_priority" name="ticket_priority" maxlength="100" required >							 
							<option value=""> Select Ticket Priority</option>
							 <?php  if(!empty($priority_list)){ 
								foreach($priority_list as $priority){ ?>
									<option value="<?php echo $priority;?>" ><?php echo $priority; ?></option>
							<?php } } ?>	
						  
						   </select>
						    <?php echo form_error('ticket_priority','<span class="text-danger">','</span>'); ?>
                        </div> 
						
						<div class="form-group">
                           <label for="tkt_instruction">Instructions to User </label>
						   <input class="form-control" id="tkt_instruction" name="tkt_instruction" type="text" placeholder="Enter Instructions to User"  maxlength="500" value="<?php echo set_value("tkt_instruction"); ?>">
						    <?php echo form_error('tkt_instruction','<span class="text-danger">','</span>'); ?>
                        </div>
                        </div>
					  
						  <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" type="submit"  id="add_edit_form_btn" >Submit</button>
                        
                        </div>
                        </div>
						   </div>
						   </div>
						  
						</form>
				
                        <!-- /.box-body -->
                        
                     
                  </div>
               </div>
               </div>
            </div>
         </div>
         <!-- END PAGE BASE CONTENT -->
      </div>
      <!-- END CONTENT BODY -->
   </div>
   <!-- END CONTENT -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- Form Validation Plugins -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
		
<script type="text/javascript">
// Add Branch

$(document).ready(function() {
		 
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
            		 
			 ticket_priority: {
                required: true,
			 },  
			 ticket_assign_to: {
                required: true,
			 }, 
			 tkt_title: {
				required: true,
            	maxlength: 100,
				 },
			tkt_instruction: {
                maxlength: 500,
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
		  if (element.is(":radio")){ 
			error.appendTo("#radio_err");
			}else { // This is the default behavior of the script for all fields
			error.insertAfter(element);
			}
			
		},
    });
    });
	
	
function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
}


</script>