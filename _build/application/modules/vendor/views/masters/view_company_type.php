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
			<li><a href="<?php echo base_url(get_module()."/masters/company_type_report")?>">All Company Type Report </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
            <div class="portlet-title hidden">
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
				  
				       <div class="form-body">
					 <?php if(!empty($details)){
						$details = html_escape($details);  
						$id =  base64_encode($details['ctm_id']);
						$status  = $details['ctm_status'];
					//echo "<pre/>"; print_r($details);die;
					  ?>
					  
					  
					   
					   <div class="portlet-body">
					   
						
					   <div class="col-md-6">
					 
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
							<tr><th>Company Type </th><td><?php echo isset($details['ctm_name'])?$details['ctm_name']:""; ?> </td>	</tr>
							<tr><th>Description </th><td><?php echo isset($details['ctm_desc'])?$details['ctm_desc']:""; ?> </td>	</tr>
							<tr><th>Service Type </th><td><?php echo isset($details['ctm_type'])?$details['ctm_type']:""; ?> </td>	</tr>
							<tr><th>Total Amount </th><td><?php echo isset($details['ctm_total_amt'])?$details['ctm_total_amt']:""; ?> </td>	</tr>
							
							
						   <tr><th> Added by  </th><td><?php echo isset($details['ctm_added_by'])?$details['ctm_added_by']:""; ?> </td>	</tr>
							<tr><th> Added on  </th><td><?php echo isset($details['ctm_sdate_n'])?$details['ctm_sdate_n']:""; ?> </td>	</tr>
						
							<tr><th>Status </th>
							<td> <?php  if($status=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($status=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								} else { echo "<span class='label label-warning'>".$status."</span>";  }   ?> </td>
							</tr>
							
					    <?php  if($status=="Deactivated") { ?> 
						<tr><th> Deactivated by </th><td><?php echo isset($details['ctm_deactvbyname'])?$details['ctm_deactvbyname']:""; ?> </td>	</tr>
						<tr><th> Deactivation date </th><td><?php echo isset($details['ctm_deactvdate_n'])?$details['ctm_deactvdate_n']:""; ?> </td>	</tr>
						 <?php } ?> 
							
							<?php  if(!empty($details['branch_details'])) { 
							$branch_details =  $details['branch_details'];
						   ?>
							<tr><th colspan="2" class="text-danger"> Branch Details</th></tr>	<tr><th> Branch Name </th><td><?php echo isset($branch_details['branch_name'])?$branch_details['branch_name']:""; ?> </td>	</tr>				  
							<tr><th> Branch Contact </th><td><?php echo isset($branch_details['branch_contact'])?$branch_details['branch_contact']:""; ?> </td>	</tr>  
							<tr><th> Branch Address </th><td><?php echo isset($branch_details['branch_address'])?$branch_details['branch_address']:""; ?> </td>	</tr>				  
						 <?php } ?> 			
							</tbody>
                        </table>
						</div>	
                        <div class="col-md-6">
                         
						
                        </div>						
						<div class="form-actions ">
						 <div class="col-md-offset-1 col-md-7">  
							<center>					   	
							 <?php if($status=="Active")	{ ?>	
								
							  <a href="<?php echo get_module_path();?>masters/edit_company_type/?id=<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>	
														
								<a  data-toggle="modal" data-target="#confirm-deactivate" class="btn btn-danger " data-href="<?php echo get_module_path();?>masters/deactivate_company_type/?id=<?php echo $id; ?>" title="Deactivate" ><i class="fa fa-ban"></i> Deactivate</a>

							<?php }	?>						
					
							
						  
						   <a href="<?php echo get_module_path();?>masters/company_type_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
						   </center>
                        </div>
                        </div>
						 </div>
					
			   
                        <!-- /.box-body -->
						<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     Details Not Found !!!
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
  
  <!-- START MODAL -->
		<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true"  data-backdrop="static">
			<div class="modal-dialog modal-md">
			<div class="modal-content">			
			</div>
			</div>
		</div>	
<!--END START MODAL -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	
	$("#form_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    }); 
	
  $('#confirm-deactivate').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });	
  
});
</script>