<?php 
$vendor = $this->session->userdata('vendor');
$role_id = $vendor['user_role_id']; // Current logged-in user role ID

// Assume Admin role_id is 1 and Super Admin role_id is 2
$isAdminOrSuperAdmin = ($role_id == 1 || $role_id == 2);
?>
<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
      <div class="row">
         <div class="portlet light bordered">
            <ul class="page-breadcrumb breadcrumb">
               <li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
               <li><span class="active"><?php echo $page_title; ?></span></li>
            </ul>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-green-sharp icon-user-following"></i>
                  <span class="caption-subject font-blue-madison bold"><?php echo $page_title; ?></span>
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
                     <?php if(!empty($menu_list)){
                        $menu_list = html_escape($menu_list);  
                        ?>
                     <div class="form-body">
                        <span class="checkbox_err text-danger"><?php echo form_error('0_0_permission_ids[]','<span class="text-danger">','</span>'); ?></span>
                        <form action="<?php echo get_module_path().'admin/assign_menu'; ?>" id="add_edit_form" method="post" autocomplete="off">  
                           <?php foreach($menu_list as $key1=>$menu){
                              $menu_name = $menu['menu_name'];
                              $menu_no   = $menu['menu_no'];
                              $submenuList = $menu['submenuList'];
                              ?>
                           <div class="portlet-body">  
                              <input type="hidden" name="menu_no[]" value="<?php echo $menu_no; ?>">
                              <div class="portlet-title">
                                 <div class="caption">
                                    <h3><span class="caption-subject font-red-mint sbold"><?php echo $menu_name; ?></span></h3>
                                 </div>
                              </div>
                              <div class="portlet-body">
                                 <div class="col-md-12">
                                    <?php foreach($submenuList as $key2=>$submenu){
                                       $sub_menu_name = $submenu['sub_menu_name'];
                                       $sub_menu_menuno = $submenu['sub_menu_menuno'];
                                       $sub_menu_no = $submenu['sub_menu_no'];
                                       $permissionList = $submenu['permissionList'];
                                       ?>
                                    <div class="col-md-3 portlet light bordered">
                                       <h5 class="font-green-sharp sbold">
                                          <input type="hidden" name="<?php echo $key1; ?>_sub_menu_no[]" value="<?php echo $sub_menu_no; ?>">
                                          <strong><?php echo $sub_menu_name; ?></strong>
                                       </h5>
                                       <?php if(!empty($permissionList)){ ?>
                                       <ul class="list-unstyled" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                          <?php foreach($permissionList as $permission){ 
                                             $permission_id   = $permission['permission_id'];
                                             $permission_name = $permission['permission_name'];
                                             $status          = $permission['status'];
                                             $checked         = $status == "Yes" ? "checked" : "";
                                             
                                             // If Admin/Super Admin, make checkboxes disabled
											 $disabled = ($permission_name == "Super Admin" || $permission_name == "Admin") ? "disabled" : "";
											 ?>
											 
											 <li>
												 <label>
													 <input type="checkbox" name="<?php echo $key1 . "_" . $key2; ?>_permission_ids[]" class="minimal" value="<?php echo $permission_id; ?>" <?php echo $checked; ?> <?php echo $disabled; ?>>
													 <?php echo $permission_name; ?>
											 
													 <!-- Hidden input to preserve disabled checkbox value -->
													 <?php if($disabled == "disabled"): ?>
														 <input type="hidden" name="<?php echo $key1 . "_" . $key2; ?>_permission_ids[]" value="<?php echo $permission_id; ?>">
													 <?php endif; ?>
												 </label>
											 </li>
                                          <?php } ?>
                                       </ul>
                                       <?php } ?>
                                    </div>
                                    <?php } ?>
                                 </div>
                              </div>
                           </div>
                           <?php } ?>
                           <!-- If the user is Admin/Super Admin, they can assign permissions to other roles -->
                           <?php if($isAdminOrSuperAdmin) { ?>
                           <input type="hidden" name="admin_or_super_admin" value="1">
                           <?php } ?>
                        </form>
                        <div class="form-actions">
                           <div class=" col-md-12">
                              <center>
                              <button class="btn btn-success" type="button" data-toggle="modal" data-target="#confirm-submit">Submit</button>
                              <a href="<?php echo get_module_path();?>dashboard" class="btn btn-danger"><i class="fa fa-history"></i> Back</a>
                              <center>
                           </div>
                        </div>
                     </div>
                     <?php } else  { ?>
                     <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Menu Details Not Found !!!
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
   		$('#confirm-submit').hide();
   		$(".loader").fadeIn();
   	});
       });	
     
   	$("#add_edit_form").validate({
           rules: {
               required: {
                   required: true
               },
               "0_0_permission_ids[]": {
                 required: true,
   			 }, 
   	
   	   	},
   		messages: {
           "0_0_permission_ids[]": { required: 'Select Atleast one Permission' },
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
