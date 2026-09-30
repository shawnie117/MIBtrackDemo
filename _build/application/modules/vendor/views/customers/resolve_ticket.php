<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
	
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered">
	     <div class="portlet-title">
               <div class="caption">
                  <i class=" font-green-sharp icon-notebook"></i>
                  <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
               </div>
			   <div class="actions">
			   <button type="button"  class="close" data-dismiss="modal">&times;</button>
               </div>
		   </div>
            <div class="row">
			
               <div class="portlet-body form">
				  <?php 
				   if($action=="Resolve"){ 
				    $formaction = "resolve_ticket/?id=".base64_encode($id);
				    } 
					if($action=="ResolveC"){ 
				    $formaction = "resolve_complaint_ticket/?id=".base64_encode($id);
				    }
					if($action=="ResolveS"){ 
				    $formaction = "resolve_service_ticket/?id=".base64_encode($id);
				    }
					if($action=="Close"){ 
				    $formaction = "close_ticket/?id=".base64_encode($id);
				    }
					if($action=="CloseC"){ 
				    $formaction = "close_complaint_ticket/?id=".base64_encode($id);
				    }
					if($action=="CloseS"){ 
				    $formaction = "close_service_ticket/?id=".base64_encode($id);
				    }
                    if($action=="Reopen"){ 
				    $formaction = "reopen_ticket/?id=".base64_encode($id);
				    }
					
					?>
					
                     <form action="<?php echo get_module_path().'customers/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data" >
					  <div class="form-body">
					    <div class="portlet-body">
						<div class="col-md-12"> 
                           <input type="hidden" name="id" value="<?php echo $id; ?>">
						<div class="form-group">
                           <label for="tkt_review">Ticket Review<?php echo REQUIRED_STAR; ?> </label>
						   <input class="form-control" id="tkt_review" name="tkt_review" type="text" placeholder="Enter Ticket Review" required  maxlength="100" value="<?php echo set_value("tkt_review"); ?>">
						    <?php echo form_error('tkt_review','<span class="text-danger">','</span>'); ?>
                        </div>	
						
						<div class="form-group">
                           <label for="tkt_desc">Description <?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="tkt_desc" name="tkt_desc" type="text" placeholder="Enter Ticket Description"  required maxlength="500" value="<?php echo set_value("tkt_desc"); ?>">
						    <?php echo form_error('tkt_desc','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group">
                           <label for="ticket_image">Image Attachment</label>
                           <input type="file" name="ticket_image"  id="ticket_image" 
								class="smart-file" 
								data-label="Image Attachment" 
								data-btn-class="btn btn-default btn-sm" 
								data-preview="on"
								data-file-types="image/jpeg,image/png,image/jpg"    />
								<?php echo form_error('ticket_image','<span class="text-danger">','</span>'); ?>
								
								
								<span class="file_err"></span>
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
            	
			 tkt_review: {
				required: true,
            	maxlength: 100,
				 },
			tkt_desc: {
				required: true,
                maxlength: 500,
			 },  
			  ticket_image: {
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