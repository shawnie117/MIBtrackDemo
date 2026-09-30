<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
	
      <div class="row">
	  <div class="col-md-6">
         <div class="portlet light bordered">
	     <div class="portlet-title">
               <div class="caption">
                  <i class=" font-green-sharp icon-pencil"></i>
                  <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
               </div> 
			   <div class="actions">
			   <button type="button"  class="close" data-dismiss="modal">&times;</button>
               </div>
		   </div>
            <div class="row">		
               <div class="portlet-body form">
			   <div class="col-md-1">                                                   
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
                 
                  </div>
				
				  <form action="<?php echo get_module_path().'customers/send_wp_msg/?id='.$id; ?>" id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data">

					  <div class="form-body">
					    <div class="portlet-body">
						<div class="col-md-12"> 
                           <input type="hidden" name="id" value="<?php echo $id; ?>">
						<div class="form-group">
                           <label for="wpnumber">Whats App Number<?php echo REQUIRED_STAR; ?> </label>
						   <input class="form-control" id="wpnumber" name="wpnumber" type="text" readonly placeholder="Enter Ticket Review" required  maxlength="100" value="<?php echo $_SESSION['number']; ?>">
						    <?php echo form_error('tkt_review','<span class="text-danger">','</span>'); ?>
                        </div>							
						<div class="form-group">
                           <label for="msg">Message<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="msg" name="msg" type="text" placeholder="Enter a Message"  required maxlength="50" value="">
						    <?php echo form_error('msg','<span class="text-danger">','</span>'); ?>
                        </div>
						<!-- <div class="form-group">
                           <label for="wp_image">Image Attachment</label>
                           <input type="file" name="wp_image"  id="wp_image" 
								class="smart-file" 
								data-label="Image Attachment" 
								data-btn-class="btn btn-default btn-sm" 
								data-preview="on"
								data-file-types="image/jpeg,image/png,image/jpg"    />
								<?php echo form_error('wp_image','<span class="text-danger">','</span>'); ?>
								
								
								<span class="file_err"></span>
                           </div> 
                            -->
                        </div>
					  
						  <div class="form-actions">
						 <div class="col-md-offset-3 col-md-10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           <button class="btn btn-success" type="submit"  id="add_edit_form_btn" >Submit</button>
                           <a href="<?php echo get_module_path(); ?>/customers/customer_report" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                        </div>
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
<!-- Form Validation Plugins -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
		
<script type="text/javascript">
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
}, "File should not be larger than 1 Mb.");
$(document).ready(function() {
		 
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
            	
			 msg: {
				required: true,
            	maxlength: 50,
				 },  
			 wp_image: {
				  accept: "image/jpeg,image/png,image/jpg",
				  filesize_max:1000000, // 1 MB
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