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
			<li><a href="<?php echo base_url("dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url("admin/branch_report")?>">All Branch </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-green-sharp icon-basket-loaded"></i>
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
				  
				      <?php if(!empty($branch_details)){
						$branch_details = html_escape($branch_details);  
						$id =  base64_encode($branch_details['branch_id']);
						$status  = $branch_details['branch_status'];
						//echo "<pre/>"; print_r($branch_details);die;
					  ?>
                    
					  <div class="form-body">
					
					  
					  
					   
					   <div class="portlet-body">
					   <div class="col-md-6">
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
							<tr><th> Branch Name </th><td><?php echo isset($branch_details['branch_name'])?$branch_details['branch_name']:""; ?> </td>	</tr>
							<tr><th> Branch Details </th><td><?php echo isset($branch_details['branch_details'])?$branch_details['branch_details']:""; ?> </td>	</tr>
							
							<tr><th>Contact Person </th><td><?php echo isset($branch_details['branch_contact_person'])?$branch_details['branch_contact_person']:""; ?> </td>	</tr>
							<tr><th>Contact  </th><td><?php echo isset($branch_details['branch_contact'])?$branch_details['branch_contact']:""; ?> </td>	</tr>
							<tr><th> Other Contact  </th><td><?php echo isset($branch_details['branch_contact1'])?$branch_details['branch_contact1']:""; ?> </td>	</tr>
							<tr><th> Address  </th><td><?php echo isset($branch_details['branch_address'])?$branch_details['branch_address']:""; ?> </td>	</tr>
						
							<tr><th>Status </th>
							<td> <?php  if($status=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($status=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								}  ?> </td>
							</tr>
							</tbody>
                        </table>
						</div>
						 <div class="col-md-6">
						<table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
						<tr><th>Added By </th><td><?php echo isset($branch_details['branch_addedby_name'])?$branch_details['branch_addedby_name']:""; ?> </td>	</tr>
						<tr><th> Date </th><td><?php echo isset($branch_details['branch_sdate_n'])?$branch_details['branch_sdate_n']:""; ?> </td>	</tr>
							
						<?php  if($status=="Deactivated") { ?> 
						<tr><th> Deactivated by </th><td><?php echo isset($branch_details['branch_deactv_byname'])?$branch_details['branch_deactv_byname']:""; ?> </td>	</tr>
						<tr><th> Deactivation date </th><td><?php echo isset($branch_details['branch_deactvdate_n'])?$branch_details['branch_deactvdate_n']:""; ?> </td>	</tr>
						 <?php } ?> 
							</tbody>
                        </table>
						</div>
						
						</div>
										  
						<div class="form-actions ">
						 <div class="col-md-offset-1 col-md-7">  
												   	
							 <?php if($status=="Active")	{ ?>	
								
							  <a href="<?php echo base_url();?>admin/edit_branch/?branch_id=<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>	
														
								<a  class="btn btn-danger"  data-href="<?php echo base_url();?>admin/deactivate_branch/?branch_id=<?php echo $id; ?>" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i> Deactivate</a>

							<?php }	?>						
					
							
						  
						   <a href="#" onclick="window.history.go(-1); return false;" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                        </div>
                        </div>
						 </div>
					
			   
                        <!-- /.box-body -->
						<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     Branch Details Not Found !!!
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