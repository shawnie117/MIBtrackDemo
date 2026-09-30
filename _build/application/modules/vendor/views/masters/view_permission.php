<?php $role_id = $this->session->userdata('user_role_id');?>
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
			<li><a href="<?php echo base_url(get_module()."/masters/permission_report")?>">All Permissions </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-green-sharp  icon-eye"></i>
                  <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
			
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
				  
				      <?php if(!empty($permission_details)){
						$permission_details = html_escape($permission_details);						  
						$id =  base64_encode($permission_details['permission_id']);
					  //echo "<pre/>"; print_r($permission_details);die; ?>
                    
					  <div class="form-body">
					
					  <div class="col-md-6 col-sm-6">				   
					   <div class="portlet-body">
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
							<tr><th> Permission Name </th><td><?php echo $permission_details['permission_name']?$permission_details['permission_name']:""; ?> </td>	</tr>
							<tr><th>Added By </th><td><?php echo $permission_details['permission_addedby_name']?$permission_details['permission_addedby_name']:""; ?> </td>	</tr>
							<tr><th> Date </th><td><?php echo $permission_details['permission_sdate_n']?$permission_details['permission_sdate_n']:""; ?> </td>	</tr>
							
							<tr><th>Status </th>
							<td> <?php  if($permission_details['permission_status']=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($permission_details['permission_status']=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								}  ?> </td>
							</tr>
						</tbody>
                        </table>	
						</div>
						</div>	
					  <div class="col-md-6 col-sm-6">				   
					   <div class="portlet-body">
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
					        <?php  if(!empty($permission_details['branch_details'])) { 
							$branch_details =  $permission_details['branch_details'];
						   ?>
							<tr><th colspan="2" class="text-danger"> Branch Details</th></tr>	<tr><th> Branch Name </th><td><?php echo isset($branch_details['branch_name'])?$branch_details['branch_name']:""; ?> </td>	</tr>				  
							<tr><th> Branch Contact </th><td><?php echo isset($branch_details['branch_contact'])?$branch_details['branch_contact']:""; ?> </td>	</tr>  
							<tr><th> Branch Address </th><td><?php echo isset($branch_details['branch_address'])?$branch_details['branch_address']:""; ?> </td>	</tr>				  
						 <?php } ?> 
						</tbody>
                        </table>	
						</div>
						</div>
										  
						<div class="form-actions ">
						 <div class=" col-md-12">  
							<center>
								<?php  if($permission_details['permission_status']=="Active") { ?>				   	
							       <a  class="btn btn-danger"  data-href="<?php echo get_module_path();?>masters/deactivate_permission/?id=<?php echo $id; ?>" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i> Deactivate </a>
								<?php } ?>
							   
						   <a href="#" onclick="window.history.go(-1); return false;" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
						   </center>
                        </div>
                        </div>
						 </div>
					
			   
                        <!-- /.box-body -->
						<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    Permission Details Not Found !!!
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
  
});
</script>