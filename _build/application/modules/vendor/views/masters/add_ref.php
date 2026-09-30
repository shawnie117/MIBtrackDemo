<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url(get_module()."/masters/reference_report")?>">All Reference </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
			<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint <?php echo $icon ;?> "></i>
                  <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div>
            <div class="row">
			
               <div class="portlet-body form">
				  <?php if($action=="Edit"){ 
				  	$details = html_escape($details);
					$formaction = "edit_reference/?ref_id=".base64_encode($ref_id);
					}else {  $formaction = "add_reference"; }?>
                  <form action="<?php echo get_module_path().'masters/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off">
  <div class="form-body">
    <?php if($action=="Edit"){?>
      <input type="hidden" name="ref_id" value="<?php echo $ref_id; ?>">
    <?php } ?>

    <!-- Reference Name Field -->
    <div class="col-md-12">
      <div class="form-group">
        <label for="ref_name">Reference Name</label><?php echo REQUIRED_STAR; ?>  
        <input class="form-control" id="ref_name" name="ref_name" type="text" placeholder="Enter Reference Name" required maxlength="100" value="<?php echo isset($details['ref_name'])?$details['ref_name']:""; ?>">
        <?php echo form_error('ref_name','<span class="text-danger">','</span>'); ?>
      </div>
    </div>

    <!-- Contact Person Field -->
    <div class="col-md-12">
      <div class="form-group">
        <label for="ref_contact_per">Contact Person</label>
        <input class="form-control" id="ref_contact_per" name="ref_contact_per" type="text" pattern="[A-Za-z\s.]+" placeholder="Enter Contact Person" maxlength="100" value="<?php echo isset($details['ref_person_name'])?$details['ref_person_name']:""; ?>">
        <?php echo form_error('ref_contact_per','<span class="text-danger">','</span>'); ?>
      </div>
    </div> 

    <!-- Mobile Number Field -->
    <div class="col-md-12">
      <div class="form-group">
        <label for="ref_mobile_no">Mobile No.</label>
        <input class="form-control" id="ref_mobile_no" name="ref_mobile_no" type="text" placeholder="Enter Mobile No." maxlength="10" value="<?php echo isset($details['ref_mobile'])?$details['ref_mobile']:""; ?>">
        <?php echo form_error('ref_mobile_no','<span class="text-danger">','</span>'); ?>
      </div>
    </div>

    <!-- Email Field -->
    <div class="col-md-12">
      <div class="form-group">
        <label for="ref_email">Email Id</label>
        <input class="form-control" id="ref_email" name="ref_email" type="email" placeholder="Enter Email Id" maxlength="100" value="<?php echo isset($details['ref_email'])?$details['ref_email']:""; ?>">
        <?php echo form_error('ref_email','<span class="text-danger">','</span>'); ?>
      </div>
    </div> 

    <!-- Details Field -->
    <div class="col-md-12">
      <div class="form-group">
        <label for="ref_details">Details</label>
        <textarea class="form-control" id="ref_details" name="ref_details" placeholder="Enter Details" maxlength="500">
          <?php echo isset($details['ref_details']) ? $details['ref_details'] : ""; ?>
        </textarea>
        <?php echo form_error('ref_details', '<span class="text-danger">', '</span>'); ?>
      </div>
    </div>

    <!-- Address Field -->
    <div class="col-md-12">
      <div class="form-group">
        <label for="ref_addr">Address</label>
        <textarea class="form-control" id="ref_addr" name="ref_addr" placeholder="Enter Address" maxlength="500">
          <?php echo isset($details['ref_address']) ? $details['ref_address'] : ""; ?>
        </textarea>
        <?php echo form_error('ref_addr', '<span class="text-danger">', '</span>'); ?>
      </div>
    </div>

  </div>

  <!-- Form Actions -->
  <div class="form-actions">
    <div class="col-md-12">
      <center>
        <button class="btn btn-success" id="mybutton" type="submit">Submit</button>
        <!-- <a href="#" onclick="window.history.go(-1); return false;" class="btn btn-danger"><i class="fa fa-history"></i>Back</a> -->
      </center>
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
            ref_name: {
                required: true,
				maxlength: 100,
                minlength: 2,
				 }, 
			// ref_contact_per: {
            //     required: true,
			// 	maxlength: 100,
            //     minlength: 2,
			// 	 }, 
			// ref_mobile_no: {
            //     required: true,
            //     digits: true,
			// 	maxlength: 10,
            //     minlength: 10,
			// 	 }, 
			// ref_email: {
            //     required: true,
			// 	maxlength: 100,
            //     minlength: 2,
			// 	email: true,
			// 	 }, 
			ref_addr: {
                /* required: true, */
				maxlength: 500,
                minlength: 2,
				 }, 
			ref_details: {
                /* required: true, */
				maxlength: 500,
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