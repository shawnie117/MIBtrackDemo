<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url(get_module()."/masters/invoice_pattern_report")?>">All Invoice Pattern Report </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
			<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint <?php echo $icon ;?> "></i>
                  <span class="caption-subject font-green-sharp bold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div>
            <div class="row">
			
               <div class="portlet-body form">
				  <?php if($action=="Edit"){ //echo "<pre/>"; print_r($details);die;
				  	$details = html_escape($details);
					$formaction = "edit_invoice_pattern/?id=".base64_encode($id);
					}else {  $formaction = "add_invoice_pattern"; } ?>
                     <form action="<?php echo get_module_path().'masters/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data" >
					  <div class="form-body">
					<?php if($action=="Edit"){?>
                           <input type="hidden" name="id" value="<?php echo $id; ?>">
						   <?php } ?>
						
                        <div class="form-group col-md-6">
                           <label for="invoice_pattern">Invoice Pattern </label><?php echo REQUIRED_STAR; ?>
						   
                           <input class="form-control" id="invoice_pattern" name="invoice_pattern" type="text" placeholder="Enter Invoice Pattern " required maxlength="100" value="<?php echo isset($details['invoice_pattern'])?$details['invoice_pattern']:set_value('invoice_pattern'); ?>">
						    <?php echo form_error('invoice_pattern','<span class="text-danger">','</span>'); ?>
                         </div> 
						
                        <?php if($action=="Add"){  ?>						 
                         <div class="form-group col-md-6">
                           <label for="invoice_pattern_img">Invoice Pattern Image <?php echo REQUIRED_STAR; ?></label><br>
                            <input type="file" name="invoice_pattern_img"  id="invoice_pattern_img" 
							class="smart-file" 
							data-label="Invoice Pattern Image" 
							data-btn-class="btn btn-default btn-sm" 
							data-preview="on"
							data-file-types="image/jpeg,image/png,image/jpg"  accept="image/*"  />
							<?php echo form_error('invoice_pattern_img','<span class="text-danger">','</span>'); ?>
							<span class="file_err"></span>
                        </div>	 
						
                        <?php } ?>
						
						<?php if($action=="Edit"){  ?>		
						  <div class="form-group col-md-6">
							 <?php $image      = $details['invoice_pattern_img'];
								   $image      = str_replace("getAuthApiKey",APIKEY,$image); ?>
                           <label for="invoice_pattern_img">Invoice Pattern Image <?php echo REQUIRED_STAR; ?></label><br>
                            <input type="file" name="invoice_pattern_img"  id="invoice_pattern_img" 
							class="smart-file" 
							data-label="Invoice Pattern Image" 
							data-btn-class="btn btn-default btn-sm" 
							data-preview="on"
							data-file-types="image/jpeg,image/png,image/jpg" accept="image/*"   />
							<?php echo form_error('invoice_pattern_img','<span class="text-danger">','</span>'); ?>
							
							<ul class="list-unstyled small fileList thumbs"><li><a class="fancybox-button" data-rel="fancybox-button" href="<?php echo $image; ?>"><img title="" src="<?php echo $image; ?>" class="img-rounded"><span class="file-name"></span></a></li></ul>
							
							<span class="file_err"></span>
                        </div>	 
						
						   <?php } ?>
						 
						 
						  </div>
						   <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" id="mybutton" type="submit" >Submit</button>
                          <a href="<?php echo get_module_path();?>masters/invoice_pattern_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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
	
	 $('.smart-file').bootstrapFileField({
            maxNumFiles: 8,
            fileTypes: 'image/jpeg,image/png,image/jpg',  
            maxFileSize: 4000000 // 8Mb in bytes */
        });
		
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
            invoice_pattern: {
                required: true,
				maxlength: 100,
                minlength: 2,
				 }, 
		    invoice_pattern_img: {
				  <?php if($action=="Add"){  ?>	
                   required: true,
				   <?php  } ?>
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
			
		},
		success: function(error) { 
        error.removeClass("error");  // <- no, no, no!!
		},
    });
    });
	function get_sit(){
		var duration = $("#amc_duration").val();
		var services = $("#amc_noofservices").val();
		if(!services){ services=1;} 
		if(!duration){ duration=1;} 
		var sit = parseInt(duration)/parseInt(services);
		sit = Math.ceil(sit);
		$("#amc_sit").val(sit);
	}
	function delete_image(obj)
	{
		var id = $(obj).attr("data-id");
		$('#image_li_'+id).remove();
		
	}	
</script>