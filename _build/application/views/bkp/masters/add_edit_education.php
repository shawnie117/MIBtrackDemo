<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	  <div class="col-md-8">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url("dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url("masters/education_report")?>">All Education </a><i class="fa fa-circle"></i></li>
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
				  	$education_details = html_escape($education_details);
					$formaction = "edit_education/?edu_id=".base64_encode($edu_id);
					}else {  $formaction = "add_education"; }?>
                     <form action="<?php echo base_url().'masters/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					
					  <div class="col-md-offset-2 col-md-6">
                        <div class="form-group">
                           <label for="edu_name">Education Name </label><?php echo REQUIRED_STAR; ?>
						   <?php if($action=="Edit"){?>
                           <input type="hidden" name="edu_id" value="<?php echo $edu_id; ?>">
						   <?php } ?>
                           <input class="form-control" id="edu_name" name="edu_name" type="text" placeholder="Enter Education Name" required maxlength="100" value="<?php echo isset($education_details['edu_name'])?$education_details['edu_name']:""; ?>">
						    <?php echo form_error('edu_name','<span class="text-danger">','</span>'); ?>
                        </div>
						
                        </div>
									  
						  </div>
						   <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" type="submit" >Submit</button>
                          <a href="#" onclick="window.history.go(-1); return false;" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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
            edu_name: {
                required: true,
				maxlength: 100,
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