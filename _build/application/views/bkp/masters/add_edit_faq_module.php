<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
	<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
      <div class="row">
	  <div class="col-md-8">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
	<li><a href="<?php echo base_url("dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
	<li><a href="<?php echo base_url("masters/faq_module_report")?>">All FAQ Modules </a><i class="fa fa-circle"></i></li>
	<li><span class="active"><?php echo $page_title; ?></span></li>
	</ul>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint <?php echo $icon ;?> "></i>
                  <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div>
            <div class="row">
			
               <div class="portlet-body form">
				  <?php if($action=="Edit"){  //echo "<pre/>"; print_r($faq_module_details);
				    $faq_module_details = html_escape($faq_module_details); 
					$formaction = "edit_faq_module/?faq_m_id=".base64_encode($faq_m_id);
					}else {  $formaction = "add_faq_module"; }?>
                     <form action="<?php echo base_url().'masters/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					  
					   <div class="form-group col-md-offset-2 col-md-6">  
                       <label for="faq_module_name">Modulefor </label><?php echo REQUIRED_STAR; ?>					   
                            <select class="form-control" id="permission_id" name="permission_id" >
							<option value=""> Select Modulefor</option>
							 <?php  if(!empty($permission_list)){  
							 	foreach($permission_list as $permission){  
								  $permission_id = $faq_module_details['faq_m_permissionid'];
								  $selected = $permission_id==$permission['permission_id']?"selected":"";
								
								?>
									<option value="<?php echo $permission['permission_id'];?>" <?php echo $selected;?> ><?php echo $permission['permission_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
					
					  <div class="col-md-offset-2 col-md-6">
                        <div class="form-group">
                           <label for="faq_module_name">FAQ Module Name </label><?php echo REQUIRED_STAR; ?>
						   <?php if($action=="Edit"){?>
                           <input type="hidden" name="faq_m_id" value="<?php echo $faq_m_id; ?>">
						   <?php } ?>
                           <input class="form-control" id="faq_module_name" name="faq_module_name" type="text" placeholder="Enter FAQ Module Name" required maxlength="1000" value="<?php echo isset($faq_module_details['faq_module'])?$faq_module_details['faq_module']:""; ?>">
						    <?php echo form_error('faq_module_name','<span class="text-danger">','</span>'); ?>
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
            faq_module_name: {
                required: true,
				maxlength: 1000,
                minlength: 2,
				 }, 
			permission_id: {
                required: true,
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