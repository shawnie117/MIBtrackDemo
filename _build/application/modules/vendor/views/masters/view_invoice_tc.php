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
			<li><a href="<?php echo base_url(get_module()."/masters/invoice_tc_report")?>"> All Invoice Terms And Conditions </a><i class="fa fa-circle"></i></li>
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
				  
				      <?php if(!empty($details)){ 
					    $details = html_escape($details);
						$id =  base64_encode($details['invoice_tc_id']);
					//echo "<pre/>"; print_r($details);die; ?>
                    
					  <div class="form-body">
					
					  <div class="col-md-6">
					   <div class="portlet-body">
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
							<tr><th> Header </th><td><?php echo isset($details['invoice_tc_header'])?$details['invoice_tc_header']:""; ?> </td>	</tr>
							
							<?php if($details['invoice_tc_header']== "Footer") {  ?>
							<tr><th> Footer1 </th><td><?php echo isset($details['invoice_tc_footer1'])?$details['invoice_tc_footer1']:""; ?> </td>	</tr>
							<tr><th> Footer2 </th><td><?php echo isset($details['invoice_tc_footer2'])?$details['invoice_tc_footer2']:""; ?> </td>	</tr>
							<tr><th> Footer3 </th><td><?php echo isset($details['invoice_tc_footer3'])?$details['invoice_tc_footer3']:""; ?> </td>	</tr>
							<?php } else {  ?>
							<tr><th> Description </th><td><?php echo isset($details['invoice_tc_desc'])?$details['invoice_tc_desc']:""; ?> </td>	</tr>
							<?php }   ?>
							<tr><th>Added By </th><td><?php echo isset($details['invoice_tc_addedby_name'])?$details['invoice_tc_addedby_name']:""; ?> </td>	</tr>
							<tr><th>Added On </th><td><?php echo isset($details['invoice_tc_sdate_n'])?$details['invoice_tc_sdate_n']:""; ?> </td>	</tr>
							
							<tr><th>Status </th>
							<td> <?php  if($details['invoice_tc_status']=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($details['invoice_tc_status']=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								}  ?> </td>
							</tr>
						</tbody>
                        </table>	
						</div>
						</div>  
						<div class="col-md-6">
					   <div class="portlet-body">
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
							
						<?php  if($details['invoice_tc_status']=="Deactivated") { ?> 
						<tr><th> Deactivated by </th><td><?php echo isset($details['invoice_tc_deactvby_name'])?$details['invoice_tc_deactvby_name']:""; ?> </td>	</tr>
						<tr><th> Reason for Deactivation </th><td><?php echo isset($details['invoice_tc_deactv_rsn'])?$details['invoice_tc_deactv_rsn']:""; ?> </td>	</tr>
						<tr><th> Deactivation date </th><td><?php echo isset($details['invoice_tc_deactvdate_n'])?$details['invoice_tc_deactvdate_n']:""; ?> </td>	</tr>
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
						</div>
						
										  
						<div class="form-actions ">
						 <div class="col-md-12">  
										<center>		   	
							 <?php if($details['invoice_tc_status']=="Active")	{ ?>	
							 
							  <a href="<?php echo get_module_path();?>masters/edit_invoice_tc/?ref_id=<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>	
							
							
								<a  class="btn btn-danger"  href="<?php echo get_module_path();?>masters/deactivate_invoice_tc/?ref_id=<?php echo $id; ?>" title="Deactivate" data-toggle="modal" data-target="#form_modal"><i class="fa fa-ban"></i> Deactivate</a>

							<?php }	?>						
					
							
						  
						   <a href="#" onclick="window.history.go(-1); return false;" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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
		<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog modal-md">
			<div class="modal-content">			
			</div>
			</div>
		</div>	
<!--END START MODAL -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {

  $('#confirm-deactivate').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });	
    $("#form_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    }); 
  
});
</script>