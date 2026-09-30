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
			<li><a href="<?php echo base_url("leads/lead_report")?>">All Lead Report </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
            <!--div class="portlet-title">
               <div class="caption">
                  <i class="font-green-sharp icon-eye"></i>
                  <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
			
			   </div>
            </div-->
            <div class="row">
               <center>
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
				  </center>
                 <div class="portlet-body">
                      <?php //echo "<pre/>"; print_r($details);die;
					  $history = $this->input->get('history');
					  if(!empty($details)){ 
						$id =  base64_encode($details['clm_id']);
						$details = html_escape($details);
						$clm_name  = isset($details['clm_name'])?$details['clm_name']:"";
						$clm_contact  = isset($details['clm_contact'])?$details['clm_contact']:"";
						$clm_contact_emailid  = isset($details['clm_contact_emailid'])?$details['clm_contact_emailid']:"";
						$clm_contact_person  = isset($details['clm_contact_person'])?$details['clm_contact_person']:"";
						$clm_company_name  = isset($details['clm_company_name'])?$details['clm_company_name']:"";
						$clm_website  = isset($details['clm_website'])?$details['clm_website']:"";
						$clm_panno    = isset($details['clm_panno'])?$details['clm_panno']:"";
						$clm_landline    = isset($details['clm_landline'])?$details['clm_landline']:"";
						$clm_priority_level    = isset($details['clm_priority_level'])?$details['clm_priority_level']:"";
						$clm_type_name    = isset($details['clm_type_name'])?$details['clm_type_name']:"";
						$clm_description    = isset($details['clm_description'])?$details['clm_description']:"";
						$clm_refby_name    = isset($details['clm_refby_name'])?$details['clm_refby_name']:"";
						$ref_name    = isset($details['ref_name'])?$details['ref_name']:"";
						$clm_refby_contact    = isset($details['clm_refby_contact'])?$details['clm_refby_contact']:"";
						$clm_refby_emailid    = isset($details['clm_refby_emailid'])?$details['clm_refby_emailid']:"";
						$clm_address    = isset($details['clm_address'])?$details['clm_address']:"";
						$clm_pincode    = isset($details['clm_pincode'])?$details['clm_pincode']:"";
						$clm_area_name    = isset($details['clm_area_name'])?$details['clm_area_name']:"";
						$clm_city_name    = isset($details['clm_city_name'])?$details['clm_city_name']:"";
						$clm_state_name    = isset($details['clm_state_name'])?$details['clm_state_name']:"";
						$clm_dist_name    = isset($details['clm_dist_name'])?$details['clm_dist_name']:"";
						
						
						$status  = isset($details['clm_status'])?$details['clm_status']:"";
						$clm_addedbyname  = isset($details['clm_addedbyname'])?$details['clm_addedbyname']:"";
						$clm_sdate_n  = isset($details['clm_sdate_n'])?$details['clm_sdate_n']:"";
						
						$actvDeactvList  = isset($details['actvDeactvList'])?$details['actvDeactvList']:"";
						$ticketList  = isset($details['ticketList'])?$details['ticketList']:"";
						
					  ?>
                 
					    <div class="col-md-6">
						
						 <div class="portlet-title">
						
							   <div class="caption">
								  <i class="font-red-mint icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">Lead Details</span>
							   </div>
							 <hr style="margin:3px;"/>
						   </div>	
                        <div class="slimScrollDiv450" >						   
					   <table class="table table-striped table-bordered table-advance table-hover">	
						<tbody>
							<tr><th width="30%">Lead Name </th><td><?php echo $clm_name; ?></td>	</tr>
							<tr><th>Contact No</th><td><?php echo $clm_contact; ?></td>	</tr>
							<tr><th>Email ID</th><td><?php echo $clm_contact_emailid; ?></td>	</tr>
							<tr><th>Contact Person</th><td><?php echo $clm_contact_person; ?></td>	</tr>
							<tr><th>Company Name</th><td><?php echo $clm_company_name; ?></td>	</tr>
							<tr><th>Website</th><td><?php echo $clm_website; ?></td>	</tr>
							<tr><th>PAN No</th><td><?php echo $clm_panno; ?></td>	</tr>
							<tr><th>Landline</th><td><?php echo $clm_landline; ?></td>	</tr>
							<tr><th>Priority Level</th><td><?php echo $clm_priority_level; ?></td>	</tr>
							<tr><th>Enquiry For</th><td><?php echo $clm_type_name; ?></td>	</tr>
							<tr><th style="word-break:break-all;">Enquiry Details</th><td><?php echo $clm_description; ?></td>	</tr>
							<tr><th>Status </th>
							<td> <?php  if($status=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($status=="Deactivated" || $status=="Rejected") {		  
								  echo "<span class='label label-danger'>".$status."</span>"; 
								} else { 
								  echo "<span class='label label-warning'>".$status."</span>";
								}    ?> 
								
								</td></tr>
								<tr><th>Lead Added By </th><td><?php echo $clm_addedbyname; ?></td></tr>
								<tr><th>Lead Added On </th><td><?php echo $clm_sdate_n; ?></td></tr>
								<?php if(!empty($actvDeactvList)){   ?>
								<tr><th colspan="2" class="text-danger">Status Details </th></tr>
								<?php if(!empty($actvDeactvList[0]['cust_ad_deactive_by_name'])){ ?>
								<tr><th>Deactivated By </th><td><?php echo isset($actvDeactvList[0]['cust_ad_deactive_by_name'])?$actvDeactvList[0]['cust_ad_deactive_by_name']:"";?></td></tr>
								<tr><th>Deactivated On  </th><td><?php echo isset($actvDeactvList[0]['cust_ad_deactive_date_n'])?$actvDeactvList[0]['cust_ad_deactive_date_n']:"";?></td></tr>
								<tr><th>Deactivated Reason  </th><td><?php echo isset($actvDeactvList[0]['cust_ad_deactive_reasn'])?$actvDeactvList[0]['cust_ad_deactive_reasn']:"";?></td></tr>
								<?php } ?>
								
								<?php if(!empty($actvDeactvList[0]['cust_ad_reactive_by_name'])){ ?>
								<tr><th>Re-Activated By </th><td><?php echo isset($actvDeactvList[0]['cust_ad_reactive_by_name'])?$actvDeactvList[0]['cust_ad_reactive_by_name']:"";?></td></tr>
								<tr><th>Re-Activated On  </th><td><?php echo isset($actvDeactvList[0]['cust_ad_reactive_date_n'])?$actvDeactvList[0]['cust_ad_reactive_date_n']:"";?></td></tr>
								<tr><th>Re-Activated Reason  </th><td><?php echo isset($actvDeactvList[0]['cust_ad_reactive_reasn'])?$actvDeactvList[0]['cust_ad_reactive_reasn']:"";?></td></tr>
								<?php } ?>
								
								<?php } ?>
						</tbody>
                        </table>
						</div>
						</div>
						
					<div class="col-md-6 ">
					
					 <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-screen-smartphone"></i>
								  <span class="caption-subject font-red-mint sbold">Contact Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
                       <div class="slimScrollDiv450">						   
					   <table class="table table-striped table-bordered table-advance table-hover">	
					   <tbody>
						<?php if (!empty($details['contactList'])){ ?>
						<tr><th colspan="2" class="text-danger"> Alternate Contact Details </th></tr>
						<tr><td colspan="2">
						 <table class="table table-striped table-bordered table-advance table-hover">	
							<tbody>
							<tr><th>Sr.No.</th><th>Contact Person</th><th>Contact No</th><th>Email Id</th></tr>
							<?php foreach ($details['contactList'] as $key=>$contact){ ?>
								<tr><td><?php echo $key+1; ?> </td><td><?php echo $contact['lead_cntct_name']; ?> </td><td><?php echo $contact['lead_cntct_mob']; ?> </td><td><?php echo $contact['lead_cntct_email']; ?> </td></tr>
							<?php } ?>
							</tbody>
                        </table></td></tr>
						<?php } ?>
						<tr><th colspan="2" class="text-danger"> Address Details </th></tr>
						<tr><th width="30%"> Address </th><td><?php echo $clm_address; ?> </td></tr>
						<tr><th> Pincode </th><td><?php echo $clm_pincode; ?> </td></tr>
						<tr><th> Area </th><td><?php echo $clm_area_name; ?> </td></tr>
						<tr><th> City </th><td><?php echo $clm_city_name; ?> </tr>
						<tr><th> District </th><td><?php echo $clm_dist_name; ?> </tr>
						<tr><th> State </th><td><?php echo $clm_state_name; ?> </tr>
						
						</td></tr><tr><th colspan="2" class="text-danger"> Reference Details </th></tr>
						<tr><th> Reference By </th><td><?php echo $ref_name; ?> </td></tr>
						<tr><th> Reference Name </th><td><?php echo $clm_refby_name; ?> </td></tr>
						<tr><th> Referral Contact </th><td><?php echo $clm_refby_contact; ?> </td></tr>
						<tr><th> Referral Email </th><td><?php echo $clm_refby_emailid; ?> </td></tr>
						
						</tbody>
                        </table>
						</div>
						</div>
						<?php if (!empty($ticketList)){ ?>	
						
						<div class="col-md-12">
						 <div class="portlet-title">
						 <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-call-out"></i>
								  <span class="caption-subject font-red-mint sbold">Follow-up Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>		
					     <table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr><th>Sr. No.</th><th width="12%">FollowUp <br/>Date</th><th width="12%">Next FollowUp <br/> Date</th><th width="12%">Next FollowUp<br/>  Time</th><th>FollowUp By</th><th>FeedBack</th><th>Status</th></tr>
							<?php foreach ($ticketList as $key=>$follow){ ?>
							  <?php foreach ($follow['followupList'] as $flw){ ?>
							    <tr><td><?php echo $key+1; ?> </td>
								<td><?php echo $flw['followup_date_n']; ?> </td>
								<td><?php echo $flw['followup_nxt_folldate_n']; ?></td>
								<td><?php echo $flw['followup_nxt_folltime']; ?></td>				
								<td><?php echo $flw['followup_addedby_name']; ?></td>
								<td><?php echo $flw['followup_feedback']; ?></td>
								<td>
								  <?php  if($flw['followup_status']=="Open") { 				  
								  echo "<span class='label label-success'>Open</span>"; 
								  } else if($flw['followup_status']=="Closed") {		  
								  echo "<span class='label label-danger'>Closed</span>"; 
								} else { 
								  echo "<span class='label label-warning'>".$flw['followup_status']."</span>";
								}    ?> 
								</td></tr>
							  <?php } ?>
							<?php } ?>
							</tbody>
                        </table>
						</div>
						
						<?php } ?>
						
										  
						<div class="form-actions ">
						 <div class="col-md-offset-3 col-md-7">  
												   	
						 <?php if($status=="Active" || $status=="FS"){ ?>	
						  <a href="<?php echo base_url();?>leads/edit_lead/?id=<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
						  
						   <a  class="btn btn-success"  href="<?php echo base_url();?>leads/add_lead_follwoup/?id=<?php echo $id; ?>" title="Add Follow-up" data-toggle="modal" data-target="#form_modal"><i class="fa fa-phone"></i> Add Follow-up</a>
						  <?php } ?>		
						  
						<?php if($status=="Active"){ ?>	 
						  <a  class="btn btn-danger"  href="<?php echo base_url();?>leads/deactivate_lead/?ref_id=<?php echo $id; ?>" title="Deactivate" data-toggle="modal" data-target="#form_modal"><i class="fa fa-ban"></i> Deactivate</a>
						  
						  <a  class="btn btn-success"  href="<?php echo base_url();?>leads/confirm_lead/?ref_id=<?php echo $id; ?>" title="Make Final" data-toggle="modal" data-target="#form_modal"><i class="fa fa-check"></i>Make Final</a>
						  
						 <?php } ?>		
						 
					 <?php if($status=="Deactivated"){ ?>
							<a  class="btn btn-success"  href="<?php echo base_url();?>leads/reactivate_lead/?ref_id=<?php echo $id; ?>" title="Re-Activate" data-toggle="modal" data-target="#form_modal"><i class="fa fa-phone"></i> Re-Activate</a>
					  <?php } ?>		
					 
					 
					 	 <?php if(isset($history) && $history=="back") { ?>
						   <a onclick="window.history.back();" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
					 <?php } else {  ?>
						  <a href="<?php echo base_url();?>leads/lead_report?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
					 <?php }  ?>  
						  
                        </div>
                        </div>
						
					
			   
                        <!-- /.box-body -->
						<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     Lead Details Not Found !!!
                  </div>
						<?php } ?>
                   
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