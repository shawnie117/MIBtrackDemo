<link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
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
                
                  <div class="row">
                     <div class="col-md-12">
                        <?php //echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                     </div>
                  </div>
                  <div class="col-md-12">
				       <form action="<?php echo get_module_path().'leads/'.$action."/?id=".base64_encode($id); ?>" id="add_form" method="post" autocomplete="off">
					  <div class="form-body">
					  <div class="col-md-12">
                       <div class="form-group">
                           <label for="wpnumber">Whatsapp Number</label><?php echo REQUIRED_STAR; ?>
                           <input type="text" class="form-control" id="wpnumber" name="wpnumber" 
						   placeholder="Enter Enter FollowUp" value="<?php echo $_SESSION['clmcontact']?>" >
						   <?php echo form_error('wpnumber','<span class="text-danger">','</span>'); ?>
                        </div>  
                        
                        <div class="form-group">
                           <label for="msg">Message</label><?php echo REQUIRED_STAR; ?>
                           <textarea class="form-control" id="msg" name="msg" 
						   placeholder="Enter Enter FollowUp  " maxlength="240" cols="5" rows="5"></textarea>
						   <?php echo form_error('msg','<span class="text-danger">','</span>'); ?>
                        </div>  
                       	<!-- <div class="form-group">   
                            <label for="followupstatusid">Follow Up Status </label>
                            <select class="form-control" id="followupstatusid" name="followupstatusid">
							<option value=""> Select Follow Up Status</option>
							 <?php  if(!empty($followup_list)){ 
								foreach($followup_list as $key=>$stat){ ?>
									<option value="<?php echo $key?>" ><?php echo $stat; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> -->

						<!-- <div class="form-group"> 
						  <label for="next_update_date">Next Follow Up Date & Time </label>
                          <input type="date" class="form-control pull-right datepicker" id="next_update_date" name="next_update_date" placeholder="Next Follow Up Date & Time" value="" >
                        </div> -->
                        	<br/>
                       
						   <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" id="mybutton" type="submit" >Submit</button>
                          <button type="button" class="btn red btn-outline" data-dismiss="modal">Cancel</button>
                        </div>
                        </div>
						</form>
						 </div>
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
         <!-- END PAGE BASE CONTENT -->
      </div>
      <!-- END CONTENT BODY -->
   </div>
   <!-- END CONTENT -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- Form Validation Plugins -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
		
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/moment.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
// Add Branch

$(document).ready(function() {
	$("#add_form").validate({
        rules: {
            required: {
                required: true
            },
            followup_feedback: {
                required: true,
				maxlength:500,
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
	
	$('.datepicker').datetimepicker({
		        format: 'dd-mm-yyyy HH:ii P',
				autoclose: true,
				todayHighlight: true,
			    showMeridian : true,

		});	
		
    });
</script>