<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->

	<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
      <div class="row">
	  <div class="col-md-8">
         <div class="portlet light bordered">
		 	<ul class="page-breadcrumb breadcrumb">
	<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
	<li><a href="<?php echo base_url(get_module()."/masters/faq_report")?>">All FAQ  </a><i class="fa fa-circle"></i></li>
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
				  <?php if($action=="Edit"){				  
					$formaction = "edit_faq/?faq_det_id=".base64_encode($faq_det_id);
					$faq_details = html_escape($faq_details);
					//echo "<pre/>"; print_r($faq_details);die;
					}else {  $formaction = "add_faq"; }?>
                     <form action="<?php echo get_module_path().'masters/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					  
					   <div class="form-group col-md-offset-2 col-md-6">  
                       <label for="faq_module_name">FAQ Module </label><?php echo REQUIRED_STAR; ?>					   
                            <select class="form-control" id="faq_m_id" name="faq_m_id" >
							<option value=""> Select Select FAQ Module</option>
							 <?php  if(!empty($faq_module_list)){ 	
								foreach($faq_module_list as $faq_module){ 
								  $selected = isset($faq_details['faq_det_mstr_id']) && ($faq_details['faq_det_mstr_id']==$faq_module['faq_m_id'])?"selected":"";
								
								?>
									<option value="<?php echo $faq_module['faq_m_id'];?>" <?php echo $selected;?> ><?php echo $faq_module['faq_module']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
					
					  <div class="col-md-offset-2 col-md-8">
                        <div class="form-group">
                           <label for="faq_ques">FAQ Question </label><?php echo REQUIRED_STAR; ?>
						   <?php if($action=="Edit"){?>
                           <input type="hidden" name="faq_det_id" value="<?php echo $faq_det_id; ?>">
						   <?php } ?>
                           <textarea class="form-control" id="faq_ques" name="faq_ques" 
						   placeholder="Enter FAQ Question" required maxlength="2000" cols="10" rows="7"><?php echo isset($faq_details['faq_det_questn'])?$faq_details['faq_det_questn']:""; ?></textarea>
						    <?php echo form_error('faq_ques','<span class="text-danger">','</span>'); ?>
							
                        </div>
						
                        </div> 
						
						<div class="col-md-offset-2 col-md-8">
                        <div class="form-group">
                           <label for="faq_ans">FAQ Answer </label><?php echo REQUIRED_STAR; ?>
						  <textarea class="form-control" id="faq_ans" name="faq_ans" 
						   placeholder="Enter FAQ Answer" required maxlength="4000" cols="10" rows="7"><?php echo isset($faq_details['faq_det_answers'])?$faq_details['faq_det_answers']:""; ?></textarea>
						    <?php echo form_error('faq_ans','<span class="text-danger">','</span>'); ?>
							
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
            faq_ques: {
                required: true,
				maxlength: 2000,
                minlength: 2,
				 }, 
			faq_ans: {
                required: true,
				maxlength: 4000,
                minlength: 2,
				 }, 
			faq_m_id: {
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