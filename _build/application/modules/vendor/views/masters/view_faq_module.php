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
			<li><a href="<?php echo base_url(get_module()."/masters/faq_module_report")?>">All FAQ Modules </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-green-sharp icon-eye"></i>
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
				  
				      <?php if(!empty($faq_module_details)){ 
					    $faq_module_details = html_escape($faq_module_details);
						$id =  base64_encode($faq_module_details['faq_m_id']);
						$status  = $faq_module_details['faq_m_status'];
						$faq_m_permissionname  = $faq_module_details['faq_m_permissionname'];
						//echo "<pre/>"; print_r($faq_module_details);die;
					  ?>
                    
					  <div class="form-body">
					
					  <div class="col-md-6">
					   <div class="portlet-body">
					   <table class="table table-striped table-bordered table-advance table-hover">
						<tbody>
							<tr><th> FAQ Module </th><td><?php echo isset($faq_module_details['faq_module'])?$faq_module_details['faq_module']:""; ?> </td>	</tr>
							<tr><th> Modulefor </th><td><?php echo isset($faq_module_details['faq_m_permissionname'])?$faq_module_details['faq_m_permissionname']:""; ?> </td>	</tr>
							<tr><th>Added By </th><td><?php echo isset($faq_module_details['faq_m_added_by_name'])?$faq_module_details['faq_m_added_by_name']:""; ?> </td>	</tr>
							<tr><th> Date </th><td><?php echo isset($faq_module_details['faq_m_sdate_n'])?$faq_module_details['faq_m_sdate_n']:""; ?> </td>	</tr>
							
							<tr><th>Status </th>
							<td> <?php  if($status=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($status=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								}  ?> </td>
							</tr>
						<?php  if($status=="Deactivated") { ?> 
						<tr><th> Deactivated by </th><td><?php echo isset($faq_module_details['faq_m_deactvby_name'])?$faq_module_details['faq_m_deactvby_name']:""; ?> </td>	</tr>
						<tr><th>Reason for Deactivation </th><td><?php echo isset($faq_module_details['faq_m_deactv_rsn'])?$faq_module_details['faq_m_deactv_rsn']:""; ?> </td>	</tr>
						<tr><th> Deactivation date </th><td><?php echo isset($faq_module_details['faq_m_deactv_date_n'])?$faq_module_details['faq_m_deactv_date_n']:""; ?> </td>	</tr>
						 <?php } ?> 
						 </tbody>
                        </table>	
						</div>
						</div>
					   <div class="col-md-6">
					   <div class="portlet-body">
					   <table class="table table-striped table-bordered table-advance table-hover">
						<tbody>
						  <?php  if(!empty($faq_module_details['branch_details'])) { 
							$branch_details =  $faq_module_details['branch_details'];
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
						 <div class="col-md-offset-1 col-md-7">  
												   	
							 <?php if($status=="Active")	{ ?>	
								
							  <a href="<?php echo get_module_path();?>masters/edit_faq_module/?faq_m_id=<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>	
														
								<a  data-toggle="modal" data-target="#form_modal" class="btn btn-danger " href="<?php echo get_module_path();?>masters/deactivate_faq_module/?ref_id=<?php echo $id; ?>" title="Deactivate" ><i class="fa fa-ban"></i> Deactivate</a>

							<?php }	?>						
					
							
						  
						   <a href="#" onclick="window.history.go(-1); return false;" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                        </div>
                        </div>
						 </div>
					
			   
                        <!-- /.box-body -->
						<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     FAQ Module Details Not Found !!!
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