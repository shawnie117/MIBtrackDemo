<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	  <div class="col-md-10">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url(get_module()."/admin/branch_report")?>">All Branch </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
			<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint <?php echo $icon ;?> "></i>
                  <span class="caption-subject font-blue-madison bold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div>
            <div class="row">
			
               <div class="portlet-body form">
				  <?php if($action=="Edit"){ //echo "<pre/>"; print_r($branch_details);die;
				  	$branch_details = html_escape($branch_details);
					$formaction = "edit_branch/?branch_id=".base64_encode($branch_id);
					}else {  $formaction = "add_branch"; } ?>
                     <form action="<?php echo get_module_path().'admin/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					<?php if($action=="Edit"){?>
                           <input type="hidden" name="branch_id" value="<?php echo $branch_id; ?>">
						   <?php } ?>
					  <div class="col-md-6">
                        <div class="form-group">
                           <label for="p_branch_name">Branch Name </label><?php echo REQUIRED_STAR; ?>
						   
                           <input class="form-control" id="p_branch_name" name="p_branch_name" type="text" placeholder="Enter Branch Name" required maxlength="50" value="<?php echo isset($branch_details['branch_name'])?$branch_details['branch_name']:""; ?>">
						    <?php echo form_error('p_branch_name','<span class="text-danger">','</span>'); ?>
                         </div>  
						 
						 <div class="form-group">
                           <label for="p_branch_contact">Contact </label><?php echo REQUIRED_STAR; ?>
						   
                           <input class="form-control" id="p_branch_contact" name="p_branch_contact" type="text" placeholder="Enter Contact Number" required maxlength="10" value="<?php echo isset($branch_details['branch_contact'])?$branch_details['branch_contact']:""; ?>">
						    <?php echo form_error('p_branch_contact','<span class="text-danger">','</span>'); ?>
                         </div> 
						 
						  <div class="form-group">
                           <label for="p_branch_contact_person">Contact Person </label><?php echo REQUIRED_STAR; ?>
						   
                           <input class="form-control" id="p_branch_contact_person" name="p_branch_contact_person" type="text" placeholder="Enter Contact Person" required maxlength="100" value="<?php echo isset($branch_details['branch_contact_person'])?$branch_details['branch_contact_person']:""; ?>">
						    <?php echo form_error('p_branch_contact_person','<span class="text-danger">','</span>'); ?>
                         </div> 
						 
						
                        </div>
						
						 <div class="col-md-6">
						 <div class="form-group">
                           <label for="p_branch_details">Branch Details </label><?php echo REQUIRED_STAR; ?>						  
                           <input class="form-control" id="p_branch_details" name="p_branch_details" type="text" placeholder="Enter Branch Details" required maxlength="250" value="<?php echo isset($branch_details['branch_details'])?$branch_details['branch_details']:""; ?>">
						    <?php echo form_error('p_branch_details','<span class="text-danger">','</span>'); ?>
                        </div>
						
						<div class="form-group">
                           <label for="p_branch_contact1">Other Contact </label>						   
                           <input class="form-control" id="p_branch_contact1" name="p_branch_contact1" type="text" placeholder="Enter Other Contact Number"  maxlength="10" value="<?php echo isset($branch_details['branch_contact1'])?$branch_details['branch_contact1']:""; ?>">
						    <?php echo form_error('p_branch_contact1','<span class="text-danger">','</span>'); ?>
                         </div>

						<div class="form-group">
                           <label for="p_branch_address">Address</label><?php echo REQUIRED_STAR; ?>
						   
                           <input class="form-control" id="p_branch_address" name="p_branch_address" type="text" placeholder="Enter Address" required maxlength="250" value="<?php echo isset($branch_details['branch_address'])?$branch_details['branch_address']:""; ?>">
						    <?php echo form_error('p_branch_address','<span class="text-danger">','</span>'); ?>
                         </div> 
						 						 
						 
                        </div>
									  
						  </div>
						   <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" id="mybutton" type="submit" >Submit</button>
                          <a href="#" onclick="window.history.go(-1); return false;" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                        </div>
                        </div>
						</form>
				
                        <!-- /.box-body -->
                        
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
            p_branch_name: {
                required: true,
				maxlength: 50,
                minlength: 2,
				 }, 
			p_branch_contact: {
                required: true,
				maxlength: 10,
                minlength: 2,
				 }, 
			p_branch_contact1: {
				maxlength: 10,
                minlength: 2,
				 }, 
				 
			p_branch_contact_person: {
				required: true,
				maxlength: 100,
                minlength: 2,
				 }, 
			p_branch_details: {
				required: true,
				maxlength: 250,
                minlength: 2,
				 }, 
		   p_branch_address: {
				required: true,
				maxlength: 250,
                minlength: 2,
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