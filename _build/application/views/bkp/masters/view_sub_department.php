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
			<li><a href="<?php echo base_url("masters/sub_department_report")?>">All Sub Departments </a><i class="fa fa-circle"></i></li>
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
				  
				      <?php if(!empty($sub_department_details)){
						$sub_department_details = html_escape($sub_department_details);  
						$id =  base64_encode($sub_department_details['sub_dept_id']);
						$status  = $sub_department_details['sub_dept_status'];
						//echo "<pre/>"; print_r($sub_department_details);die;
					  ?>
                    
					  <div class="form-body">
					
					  <div class="col-md-6">
					  
					   
					   <div class="portlet-body">
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
							<tr><th> Sub Department Name </th><td><?php echo isset($sub_department_details['sub_dept_name'])?$sub_department_details['sub_dept_name']:""; ?> </td>	</tr>
							<tr><th> Department Name </th><td><?php echo isset($sub_department_details['sub_dept_department_name'])?$sub_department_details['sub_dept_department_name']:""; ?> </td>	</tr>
							<tr><th>Added By </th><td><?php echo isset($sub_department_details['sub_dept_addedby_name'])?$sub_department_details['sub_dept_addedby_name']:""; ?> </td>	</tr>
							<tr><th> Date </th><td><?php echo isset($sub_department_details['sub_dept_sdate_n'])?$sub_department_details['sub_dept_sdate_n']:""; ?> </td>	</tr>
							
							<tr><th>Status </th>
							<td> <?php  if($status=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($status=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								}  ?> </td>
							</tr>
						<?php  if($status=="Deactivated") { ?> 
						<tr><th> Deactivated by </th><td><?php echo isset($sub_department_details['sub_dept_deactv_byname'])?$sub_department_details['sub_dept_deactv_byname']:""; ?> </td>	</tr>
						<tr><th> Deactivation date </th><td><?php echo isset($sub_department_details['sub_dept_deactvdate_n'])?$sub_department_details['sub_dept_deactvdate_n']:""; ?> </td>	</tr>
						 <?php } ?> 
						</tbody>
                        </table>	
						</div>
						</div>
										  
						<div class="form-actions ">
						 <div class="col-md-offset-1 col-md-7">  
												   	
							 <?php if($status=="Active")	{ ?>	
								
							  <a href="<?php echo base_url();?>masters/edit_sub_department/?sub_dept_id=<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>	
														
								<a  class="btn btn-danger"  data-href="<?php echo base_url();?>masters/deactivate_sub_department/?sub_dept_id=<?php echo $id; ?>" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i> Deactivate</a>

							<?php }	?>						
					
							
						  
						   <a href="#" onclick="window.history.go(-1); return false;" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                        </div>
                        </div>
						 </div>
					
			   
                        <!-- /.box-body -->
						<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     Sub Department Details Not Found !!!
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