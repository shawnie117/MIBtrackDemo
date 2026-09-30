<link rel="stylesheet"
href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/select2/css/select2.min.css">

<link rel="stylesheet"
href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/select2/css/select2-bootstrap.min.css">
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
					
                     <form action="<?php echo get_module_path().'customers/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					    <div class="portlet-body">
						<div class="col-md-12"> 
                           <input type="hidden" name="id" value="<?php echo $id; ?>">
						 <div class="form-group">
                           <label for="ticket_assign_to">Ticket Assign To <?php echo REQUIRED_STAR; ?></label>
                           <!-- <select class="form-control" id="ticket_assign_to" name="ticket_assign_to" maxlength="100" data-live-search="true" required>							 
							<option value=""> Select Ticket Assign To</option>
							 <?php  if(!empty($employee_list)){ 
								foreach($employee_list as $employee){ ?>
									<option value="<?php echo $employee['user_id'];?>" ><?php echo $employee['emp_name']; ?></option>
							<?php } } ?>	
						  
						   </select> -->
                           <select class="form-control select2"
        id="ticket_assign_to"
        name="ticket_assign_to"
        required>

    <option value="">Select Ticket Assign To</option>

    <?php if(!empty($employee_list)){ ?>
        <?php foreach($employee_list as $employee){ ?>

            <option value="<?php echo $employee['user_id']; ?>">
                <?php echo $employee['emp_name']; ?>
            </option>

        <?php } ?>
    <?php } ?>

</select>
						    <?php echo form_error('ticket_assign_to','<span class="text-danger">','</span>'); ?>
							<a href="<?php echo get_module_path().'reports/employee_availability_report'; ?>" target="_blank">Check Employee Availability</a>
                        </div>
						<div class="form-group">
                           <label for="ticket_priority">Ticket Priority</label><?php echo REQUIRED_STAR; ?>
                           <!-- <select class="form-control" id="ticket_priority" name="ticket_priority" maxlength="100" required >							 
							<option value=""> Select Ticket Priority</option>
							 <?php  if(!empty($priority_list)){ 
								foreach($priority_list as $priority){ ?>
									<option value="<?php echo $priority;?>" ><?php echo $priority; ?></option>
							<?php } } ?>	
						  
						   </select> -->
                           <select class="form-control select2-no-search"
        id="ticket_priority"
        name="ticket_priority"
        required>

    <option value="">Select Ticket Priority</option>

    <?php if(!empty($priority_list)){ ?>
        <?php foreach($priority_list as $priority){ ?>
            <option value="<?php echo $priority; ?>">
                <?php echo $priority; ?>
            </option>
        <?php } ?>
    <?php } ?>

</select>
						    <?php echo form_error('ticket_priority','<span class="text-danger">','</span>'); ?>
                        </div> 
						
						<div class="form-group">
                           <label for="tkt_instruction">Instructions to User </label>
						   <input class="form-control" id="tkt_instruction" name="tkt_instruction" type="text" placeholder="Enter Instructions to User"  maxlength="500" value="<?php echo set_value("tkt_instruction"); ?>">
						    <?php echo form_error('tkt_instruction','<span class="text-danger">','</span>'); ?>
                        </div>
                        </div>
					  
						  <!-- <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" type="submit"  id="add_edit_form_btn" >Submit</button>
                        
                        </div>
                        </div> -->
                        <div class="form-actions text-center">
    <button class="btn btn-success"
            type="submit"
            id="add_edit_form_btn">
        Submit
    </button>
</div>
						   </div>
						   </div>
						  
						</form>
				
                        <!-- /.box-body -->
						<script>
						const button = document.getElementById('add_edit_form_btn');

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
         </div>
         <!-- END PAGE BASE CONTENT -->
      </div>
      <!-- END CONTENT BODY -->
   </div>
   <!-- END CONTENT -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/select2/js/select2.full.min.js"></script>
<!-- Form Validation Plugins -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
		
<script type="text/javascript">
// Add Branch

$(document).ready(function() {
   $('.select2').select2({
    width:'100%',
    placeholder:"Select Ticket Assign To",
    dropdownParent:$('#form_modal')
});

$('.select2-no-search').select2({
    width:'100%',
    minimumResultsForSearch: Infinity,
    dropdownParent:$('#form_modal')
});
		 
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

<style>

/* Full Width */
.select2-container{
    width:100% !important;
}

/* Main Select Box */
.select2-container .select2-selection--single{
    height:34px !important;
    border:1px solid #c2cad8 !important;
    border-radius:4px !important;
    background:#fff !important;
    box-shadow:none !important;
    position:relative;
}

/* Placeholder / Selected Text */
.select2-container .select2-selection--single .select2-selection__rendered{
    height:32px !important;
    line-height:32px !important;
    padding-left:12px !important;
    padding-right:24px !important;
    color:#555 !important;
}

/* Arrow Area */
.select2-container .select2-selection--single .select2-selection__arrow{
    position:absolute !important;
    top:0 !important;
    right:0 !important;
    width:24px !important;
    height:32px !important;
    border:none !important;
    background:transparent !important;
}

/* Remove default arrow */
.select2-container .select2-selection--single .select2-selection__arrow b{
    border:none !important;
    width:0;
    height:0;
}

/* Custom Bootstrap-like Arrow */
.select2-container .select2-selection--single .select2-selection__arrow:after{
    content:"";
    position:absolute;
    top:50%;
    left:50%;
    margin-left:-4px;
    margin-top:-2px;
    width:0;
    height:0;
    border-left:4px solid transparent;
    border-right:4px solid transparent;
    border-top:5px solid #666;
}

/* Search box */
.select2-search__field{
    border:1px solid #c2cad8 !important;
    border-radius:4px;
    padding:6px 10px;
}

/* Dropdown */
.select2-dropdown{
    border:1px solid #c2cad8 !important;
    border-radius:4px;
}

/* Remove focus glow */
.select2-container--focus .select2-selection{
    box-shadow:none !important;
}

/* Hide clear button if any */
.select2-selection__clear{
    display:none !important;
}

</style>