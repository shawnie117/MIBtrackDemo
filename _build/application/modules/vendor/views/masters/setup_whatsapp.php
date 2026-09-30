<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<!-- <li><a href="<?php echo base_url(get_module()."/masters/department_report")?>">All Department </a><i class="fa fa-circle"></i></li> -->
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
			<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint <?php echo $icon ;?> "></i>
                  <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div>
           <div class="col-md-6 " >
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

            <div class="row">			
               <div class="portlet-body form">
				  <?php if($action=="Edit"){ 
				  	$department_details = html_escape($department_details);
					$formaction = "edit_department/?dept_id=".base64_encode($dept_id);
					}else {  $formaction = "setup_whatsapp"; }?>
                     <form action="<?php echo get_module_path().'masters/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					<div class="col-md-12">
					  <div class="col-md-5">
                        <div class="form-group">
                           <label for="whatscontact">WhatsApp Number </label><?php echo REQUIRED_STAR; ?>
						   <?php if($action=="Edit"){?>
                           <input type="hidden" name="dept_id" value="<?php echo $dept_id; ?>">
						   <?php } ?>
                           <input class="form-control" id="whatscontact" name="whatscontact" type="text" placeholder="Enter WhatsApp No." required minlength="10" maxlength="10">
						    <?php echo form_error('whatscontact','<span class="text-danger">','</span>'); ?>
                        </div>
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
            dept_name: {
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