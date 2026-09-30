<?php 
$vendor  = $this->session->userdata('vendor');
$role_id = $vendor['user_role_id'];
?>
<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	  <!--div class="page-head">		
		<div class="page-title">
			<h1><?php echo $page_title; ?></h1>
		</div>	
	   </div-->
	
      <div class="row">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-green-sharp icon-user-following"></i>
                  <span class="caption-subject font-blue-madison bold "><?php echo $page_title; ?></span>
			
			   </div>
            </div>
            <div class="row">
               
			    <div class="col-md-6">
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
                 <div class="portlet-body form">
                  <div class="col-md-12">
				      <?php if(!empty($block_details)){
						$block_details = html_escape($block_details);  
						//echo "<pre/>"; print_r($block_details);die;
					  ?>
                    
					  <div class="form-body">
					   <span class="checkbox_err text-danger" > <?php echo form_error('0_permission_ids[]','<span class="text-danger">','</span>'); ?></span>
					   <div class="portlet-body">
					  
					   <div class="col-md-12">
					   <form action="<?php echo get_module_path().'admin/assign_block'; ?>" id="add_edit_form" method="post" autocomplete="off" >	
							
							<?php foreach($block_details as $key=>$block){
								$d_name         = $block['d_name'];
								$d_name        = preg_replace('/(?<!\ )[A-Z]/', ' $0', $d_name);
								$d_id           = $block['d_id'];
								$permissionList = $block['permissionList'];
								
								?>
							  <div class="col-md-3 portlet light bordered">				
							
								<h4 class="font-red-mint sbold">
							  <input type="hidden" name="block_ids[]"  value="<?php echo $d_id; ?>"><strong><?php echo $d_name; ?></strong></h4>
							  <?php if(!empty($permissionList)){ ?>
								<ul class="list-unstyled">
								<?php foreach($permissionList as $permission){ 
								$permission_id   = $permission['permission_id'];
								$permission_name = $permission['permission_name'];
								$status 		 = $permission['status'];
								$checked 		 = $status=="Yes"?"checked":"";
								
								?>
									<li>
										<label>
											<input type="checkbox" name="<?php echo $key;?>_permission_ids[]" class="minimal"  value="<?php echo $permission_id; ?>" <?php echo $checked; ?>><?php echo $permission_name; ?></label>
									</li>
								 <?php } ?>
								</ul>
							  <?php } ?>
							 
							
							</div>
							<?php } ?>
							 
						
							</form>
						
						  <div class="form-actions">
						 <div class="col-md-12">
                     <center>
						     <button class="btn btn-success" type="button" data-toggle="modal" data-target="#confirm-submit" >Submit</button>
                          <a href="<?php echo get_module_path();?>dashboard" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                     </center>
                        </div>
                        </div>
					
						</div>
						</div>
						 </div>
                        <!-- /.box-body -->
						<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     Block Details Not Found !!!
                  </div>
						<?php } ?>
                        
                     
                  </div>
               </div>
            </div>
         </div>
         <!-- END PAGE BASE CONTENT -->
      </div>
      <!-- END CONTENT BODY -->
   </div>   
   </div>   
  <!-- END CONTENT -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {

  $('#confirm-deactivate').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });	
  
    $('#confirm-submit').on('show.bs.modal', function(e) {
			 $(this).find('.btn-ok').on("click", function() {
				 $("#add_edit_form").submit();
			});
    });	
  
  	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
            "0_permission_ids[]": {
              required: true,
				 }, 
	
		   	},
		messages: {
            "0_permission_ids[]": { required: 'Select Atleast one Permission' },
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
		
		errorPlacement: function(error, element) {
			if (element.is(":checkbox")) {
				$('.checkbox_err').html("");
			   error.appendTo('.checkbox_err');
			} else {
				error.insertAfter(element);
			}
		},
    });
  
});
</script>