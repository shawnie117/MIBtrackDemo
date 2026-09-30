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
	<li><a href="<?php echo base_url(get_module()."/masters/sub_department_report")?>">All Sub Department </a><i class="fa fa-circle"></i></li>
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
				    $sub_department_details = html_escape($sub_department_details);
					$formaction = "edit_sub_department/?sub_dept_id=".base64_encode($sub_dept_id);
					}else {  $formaction = "add_sub_department"; }?>
                     <form action="<?php echo get_module_path().'masters/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					  
					   <div class="form-group  col-md-6">  
						<label for="sub_dept_name">Department </label><?php echo REQUIRED_STAR; ?>					   
                            <select class="form-control" id="dept_id" name="dept_id" >
							<option value=""> Select Department</option>
							 <?php  if(!empty($department_list)){ 
								foreach($department_list as $department){  
								  $dept_id = isset($sub_department_details['sub_dept_deptid'])?$sub_department_details['sub_dept_deptid']:"";
								  $selected = $dept_id==$department['dept_id']?"selected":"";
								
								?>
									<option value="<?php echo $department['dept_id'];?>" <?php echo $selected;?> ><?php echo $department['dept_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
					
					  <div class=" col-md-6">
                        <div class="form-group">
                           <label for="sub_dept_name">Sub Department Name </label><?php echo REQUIRED_STAR; ?>
						   <?php if($action=="Edit"){?>
                           <input type="hidden" name="sub_dept_id" value="<?php echo $sub_dept_id; ?>">
						   <?php } ?>
                           <input class="form-control" id="sub_dept_name" name="sub_dept_name" type="text" placeholder="Enter Sub Department Name" required maxlength="200" value="<?php echo isset($sub_department_details['sub_dept_name'])?$sub_department_details['sub_dept_name']:""; ?>">
						    <?php echo form_error('sub_dept_name','<span class="text-danger">','</span>'); ?>
                        </div>
						
                        </div>
									  
						  </div>
						   <div class="form-actions">
						 <div class=" col-md-12">
                            <center>
                           <button class="btn btn-success" id="mybutton" type="submit" >Submit</button>
                          <a href="#" onclick="window.history.go(-1); return false;" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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
            sub_dept_name: {
                required: true,
				maxlength: 200,
                minlength: 2,
				 }, 
			dept_id: {
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