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
						$id =  base64_encode($details['customer_id']);
						$details = html_escape($details);
						$customer_name  = isset($details['customer_name'])?$details['customer_name']:"";
						$customer_uniqueid  = isset($details['customer_uniqueid'])?$details['customer_uniqueid']:"";
						$cust_type  = isset($details['cust_type'])?$details['cust_type']:"";
						
						$customer_contact  = isset($details['customer_contact'])?$details['customer_contact']:"";
						$customer_alt_contact  = isset($details['customer_alt_contact'])?$details['customer_alt_contact']:"";
						$customer_contact_email  = isset($details['customer_contact_email'])?$details['customer_contact_email']:"";
						$customer_contact_person  = isset($details['customer_contact_person'])?$details['customer_contact_person']:"";
						$cust_landline  = isset($details['cust_landline'])?$details['cust_landline']:"";
						$customer_address  = isset($details['customer_address'])?$details['customer_address']:"";
						$customer_gstno  = isset($details['customer_gstno'])?$details['customer_gstno']:"";
						$customer_pin    = isset($details['customer_pin'])?$details['customer_pin']:"";
						$customer_area    = isset($details['area_name'])?$details['area_name']:"";
						$customer_city_name    = isset($details['customer_city_name'])?$details['customer_city_name']:"";
						$customer_dist_name    = isset($details['customer_dist_name'])?$details['customer_dist_name']:"";
						$customer_state_name    = isset($details['customer_state_name'])?$details['customer_state_name']:"";
						$ref_name    = isset($details['ref_name'])?$details['ref_name']:"";
						$cust_ref_contact    = isset($details['cust_ref_contact'])?$details['cust_ref_contact']:"";
						$cust_ref_email    = isset($details['cust_ref_email'])?$details['cust_ref_email']:"";
						$cust_ref_name    = isset($details['cust_ref_name'])?$details['cust_ref_name']:"";
						$cust_uidate_n    = isset($details['cust_uidate_n'])?$details['cust_uidate_n']:"";
											
						$cust_company_name  = isset($details['cust_company_name'])?$details['cust_company_name']:"";
						$status  = isset($details['cust_status'])?$details['cust_status']:"";
						$cust_addedbyname  = isset($details['cust_addedbyname'])?$details['cust_addedbyname']:"";
						$cust_sdate_n  = isset($details['cust_sdate_n'])?$details['cust_sdate_n']:"";
						$branch_name  = isset($details['branch_name'])?$details['branch_name']:"";
						$cust_unit_no  = isset($details['cust_unit_no'])?$details['cust_unit_no']:"";
						$cust_form_no  = isset($details['cust_form_no'])?$details['cust_form_no']:"";
						$cust_website  = isset($details['cust_website'])?$details['cust_website']:"";
						
						$cust_bank_acc_name  = isset($details['cust_bank_acc_name'])?$details['cust_bank_acc_name']:"";
						$cust_bank_acc_number  = isset($details['cust_bank_acc_number'])?$details['cust_bank_acc_number']:"";
						$cust_bank_branch_address  = isset($details['cust_bank_branch_address'])?$details['cust_bank_branch_address']:"";
						$cust_bank_ifsc  = isset($details['cust_bank_ifsc'])?$details['cust_bank_ifsc']:"";
						$cust_bank_micr  = isset($details['cust_bank_micr'])?$details['cust_bank_micr']:"";
						$cust_bank_name  = isset($details['cust_bank_name'])?$details['cust_bank_name']:"";
						
						$cust_bank_name  = isset($details['cust_bank_name'])?$details['cust_bank_name']:"";
						$cust_panno  = isset($details['cust_panno'])?$details['cust_panno']:"";
						$cust_id_no  = isset($details['cust_id_no'])?$details['cust_id_no']:"";
						
						$cust_id_img    = isset($details['cust_id_img'])?$details['cust_id_img']:"";
						$cust_img_path  = isset($details['cust_img_path'])?$details['cust_img_path']:"";
						$cust_pan_img   = isset($details['cust_pan_img'])?$details['cust_pan_img']:"";
						
						$cust_img_path     = str_replace("getAuthApiKey",APIKEY,$cust_img_path);
						$cust_id_img       = str_replace("getAuthApiKey",APIKEY,$cust_id_img);
						$cust_pan_img      = str_replace("getAuthApiKey",APIKEY,$cust_pan_img);
						
						
						$actvDeactvList  = isset($details['actvDeactvList'])?$details['actvDeactvList']:"";
						$followupList  = isset($details['followupList'])?$details['followupList']:"";
						$billPaymentList  = isset($details['billPaymentList'])?$details['billPaymentList']:"";
						$complaintList  = isset($details['complaintList'])?$details['complaintList']:"";
						$subscriptionList  = isset($details['subscriptionList'])?$details['subscriptionList']:"";
						$subscriptionServiceList  = isset($details['subscriptionServiceList'])?$details['subscriptionServiceList']:"";
						$ticketList  = isset($details['ticketList'])?$details['ticketList']:"";
						$expireSubsList  = isset($details['expireSubsList'])?$details['expireSubsList']:"";
						
					  ?>
                 
					    <div class="col-md-6">
						 <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">Customer Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
                        <div class="slimScrollDiv450">								   
					   <table class="table table-striped table-bordered table-advance table-hover">	
						<tbody>
							<tr><th width="40%">Customer ID</th><td><?php echo $customer_uniqueid; ?></td>	</tr>
							<tr><th>Customer Type </th><td><?php echo $cust_type; ?></td>	</tr>
							<tr><th>Customer Name </th><td><?php echo $customer_name; ?></td>	</tr>
							<tr><th>Company Name </th><td><?php echo $cust_company_name; ?></td>	</tr>
							<tr><th>Contact No</th><td><?php echo $customer_contact; ?></td>	</tr>
							<tr><th>Alternate Contact No</th><td><?php echo $customer_alt_contact; ?></td>	</tr>
							<tr><th>Contact Person</th><td><?php echo $customer_contact_person; ?></td>	</tr>
							<tr><th>Email ID</th><td><?php echo $customer_contact_email; ?></td>	</tr>
							<tr><th>Website</th><td><?php echo $cust_website; ?></td>	</tr>
							<tr><th>Landline</th><td><?php echo $cust_landline; ?></td>	</tr>
							<tr><th>Customer GST No</th><td><?php echo $customer_gstno; ?></td>	</tr>
												
							<tr><th>Customer UI Date</th><td><?php echo $cust_uidate_n; ?></td>	</tr>
							<tr><th colspan="2" class="text-danger">Bank Account Details </th></tr>
							<!--tr><th>Bank Name</th><td><?php echo $cust_bank_name; ?></td>	</tr>
							<tr><th>Bank Account Name</th><td><?php echo $cust_bank_acc_name; ?></td>	</tr>
							<tr><th>Bank A/C No.</th><td><?php echo $cust_bank_acc_number; ?></td>	</tr>
							<tr><th>Bank Branch</th><td><?php echo $cust_bank_branch_address; ?></td>	</tr>
							<tr><th>Bank IFSC</th><td><?php echo $cust_bank_ifsc; ?></td>	</tr>
							<tr><th>Bank MICR</th><td><?php echo $cust_bank_micr; ?></td>	</tr-->
							<tr><th>Status </th>
							   <td> <?php  if($status=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($status=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								} else { 
								  echo "<span class='label label-warning'>".$status."</span>";
								}    ?> 
								
								</td></tr>
								<tr><th>Added By </th><td><?php echo $cust_addedbyname; ?></td></tr>
								<tr><th>Added On </th><td><?php echo $cust_sdate_n; ?></td></tr>
								<?php if(!empty($actvDeactvList)){ ?>
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
						
					<div class="col-md-6">
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
								<tr><td><?php echo $key+1; ?> </td><td><?php echo $contact['cust_contact_person']; ?> </td><td><?php echo $contact['cust_contact_no']; ?> </td><td><?php echo $contact['cust_contact_emailid']; ?> </td></tr>
							<?php } ?>
							</tbody>
                        </table></td></tr>
						<?php } ?>
						<tr><th colspan="2" class="text-danger"> Address Details </th></tr>
						<tr><th width="30%"> Address </th><td><?php echo $customer_address; ?> </td></tr>
						<tr><th> Pincode </th><td><?php echo $customer_pin; ?> </td></tr>
						<tr><th> Area </th><td><?php echo $customer_area; ?> </td></tr>
						<tr><th> City </th><td><?php echo $customer_city_name; ?> </tr>
						<tr><th> District </th><td><?php echo $customer_dist_name; ?> </tr>
						<tr><th> State </th><td><?php echo $customer_state_name; ?> </tr>
						
						</td></tr><tr><th colspan="2" class="text-danger"> Reference Details </th></tr>
						<tr><th> Reference By </th><td><?php echo $ref_name; ?> </td></tr>
						<tr><th> Reference Name </th><td><?php echo $cust_ref_name; ?> </td></tr>
						<tr><th> Referral Contact </th><td><?php echo $cust_ref_contact; ?> </td></tr>
						<tr><th> Referral Email </th><td><?php echo $cust_ref_email; ?> </td></tr>
						</td></tr><tr><th colspan="2" class="text-danger"> Other Details </th></tr>
						<tr><th> Branch </th><td><?php echo $branch_name; ?> </td></tr>
						<tr><th> Unit No. </th><td><?php echo $cust_unit_no; ?> </td></tr>
						<tr><th> Form No. </th><td><?php echo $cust_form_no; ?> </td></tr>
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
						<?php if (!empty($subscriptionList)){ ?>						
						<div class="col-md-12">
						 <div class="portlet-title">
						        <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-check"></i>
								  <span class="caption-subject font-red-mint sbold">All Service Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>                     			   
					     <table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr class="success"><th >Sr. No.</th><th >Name</th><th>Start Date </th><th>End Date</th><th >Status</th><th width="15%">Action</th></tr>
							<?php foreach ($subscriptionList as $key=>$subserv){
									$cust_subs_cbpmid = $subserv['cust_subs_cbpmid'];
									$sub_id = $subserv['cust_subs_id'];
									$cust_subs_custid = $subserv['cust_subs_custid'];
									$str = "?cust_id=".base64_encode($cust_subs_custid)."&sub_id=".base64_encode($sub_id);
     							?>							 
							    <tr><td><?php echo $key+1; ?> </td>
								<td><?php echo $subserv['cust_subs_type_name']; ?> </td>
								<td><?php echo $subserv['cust_subs_startdate_n']; ?></td>
								<td><?php echo $subserv['cust_subs_enddate_n']; ?></td>				
								<td> <?php  if($subserv['cust_subs_status']=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($subserv['cust_subs_status']=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								} else { 
								  echo "<span class='label label-warning'>".$subserv['cust_subs_status']."</span>";
								}    ?> </td>
								<td>  <a  class="btn btn-primary btn-xs"  href="<?php echo get_module_path();?>customers/view_customer_subscriptions/<?php echo $str; ?>" title="View Details" data-toggle="modal" data-target="#form_modal_lg"><i class="fa fa-eye"></i></a>
								<?php if (!empty($billPaymentList)){
					            $cbpm_billno = $billPaymentList[0]['cbpm_billno'];  ?>
						        <a  class="btn btn-danger btn-xs"  href="<?php echo get_module_path();?>customers/download_invoice_single/?ref_id=<?php echo $id; ?>&billno=<?php echo $cbpm_billno; ?>&cust_subs_cbpmid=<?php echo $cust_subs_cbpmid; ?>" title="Download Invoice" ><i class="fa fa-download"></i></a> 
								<?php } ?>
								</td>
								</tr>
							  <?php } ?>
							
							
							</tbody>
                        </table>
						
						</div>
						<?php } ?>	
						
							
						
						
						<?php if (!empty($subscriptionServiceList)){ ?>						
											
						<div class="col-md-12">
						 <div class="portlet-title">
						        <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-wrench"></i>
								  <span class="caption-subject font-red-mint sbold">Active Service Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>
						   	<?php foreach ($subscriptionServiceList as $subscription){ ?>
                          <table class="table table-condensed">
							<tbody>
								<tr><th width="20%"> Service Name  </th><td><?php echo isset($subscription['cust_subs_type_name'])?$subscription['cust_subs_type_name']:""; ?> </td>
								<th> Service Type  </th>
								<td><?php echo isset($subscription['cust_subs_type'])?$subscription['cust_subs_type']:""; ?> </td>
								<th> Services Duration </th>
								<td><?php echo isset($subscription['cust_subs_duration'])?$subscription['cust_subs_duration']:""; ?> </td>
								</tr>
								
								<tr><th> Total Price  </th>
								<td><?php echo isset($subscription['cust_subs_price'])?$subscription['cust_subs_price']:""; ?> </td>
								<th> Start Date  </th>
								<td><?php echo isset($subscription['cust_subs_startdate_n'])?$subscription['cust_subs_startdate_n']:""; ?> </td>
								<th>End Date </th>
								<td><?php echo isset($subscription['cust_subs_enddate_n'])?$subscription['cust_subs_enddate_n']:""; ?> </td>
								</tr>	
								
								<tr><th>Services Done</th>
								<td><?php echo isset($subscription['cust_subs_noofserv_done'])?$subscription['cust_subs_noofserv_done']:""; ?> </td>
								<th>Remaining Services </th>
								<td><?php echo isset($subscription['cust_subs_noofserv_remining'])?$subscription['cust_subs_noofserv_remining']:""; ?> </td>
								<th>No Of Services </th>
								<td><?php echo isset($subscription['cust_subs_noofserv'])?$subscription['cust_subs_noofserv']:""; ?> </td>
								</tr>	
								
							</tbody> 
							  </table>	
							  
                         <?php if(!empty($subscription['serviceList'])){ ?> 
						 <div class="slimScrollDiv200">								  
					     <table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr class="success"><th>Sr. No.</th><th width="15%">Service Dates </th><th>Status </th><th>	Ticket ID</th><th width="12%">Done On</th><th width="15%">Action</th></tr>
							<?php foreach ($subscription['serviceList'] as $key=>$serv){
									$cust_serv_id = base64_encode($serv['cust_serv_id']);
							?>							 
							    <tr><td><?php echo $key+1; ?> </td>
								<td><?php echo $serv['cust_serv_date_n']; ?> </td>
								<td><?php echo $serv['cust_serv_status']; ?></td>
								<td><?php if(!empty($serv['ticket_id'])) { ?>
								<a href="<?php echo get_module_path();?>customers/view_ticket/?id=<?php echo base64_encode($serv['ticket_id']); ?>&history=back"><?php echo $serv['ticket_id']; ?></a>
								<?php } ?>
								</td>				
								<td><?php echo $serv['cust_serv_doneondate_n']; ?></td>
								<td> 
								
								</td>
								</tr>
							  <?php } ?>
							</tbody>
                        </table>
							</div>
							<?php } ?>	
					
						<?php } ?>
						</div>
						<hr/>
					   <?php } ?>	
					   <?php if (!empty($expireSubsList)){ ?>						
						<div class="col-md-12">
						 <div class="portlet-title">
						        <br/>
							   <div class="caption">
								  <i class="font-red-mint  icon-close"></i>
								  <span class="caption-subject font-red-mint sbold">Expired Service Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>                     			   
					     <table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr class="success"><th >Sr. No.</th><th >Name</th><th>Start Date </th><th>End Date</th><th >Status</th></tr>
							<?php foreach ($expireSubsList as $key=>$subserv2){
									$sub_id = $subserv2['cust_subs_id'];
									$cust_subs_custid = $subserv2['cust_subs_custid'];
									$str = "?cust_id=".base64_encode($cust_subs_custid)."&sub_id=".base64_encode($sub_id);
     							?>							 
							    <tr><td><?php echo $key+1; ?> </td>
								<td><?php echo $subserv2['cust_subs_type_name']; ?> </td>
								<td><?php echo $subserv2['cust_subs_startdate_n']; ?></td>
								<td><?php echo $subserv2['cust_subs_enddate_n']; ?></td>				
								<td> <?php  if($subserv2['cust_subs_status']=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($subserv2['cust_subs_status']=="Expired") {		  
								  echo "<span class='label label-danger'>Expired</span>"; 
								} else { 
								  echo "<span class='label label-warning'>".$subserv2['cust_subs_status']."</span>";
								}    ?> </td>
								
								</tr>
							  <?php } ?>
							
							
							</tbody>
                        </table>
						
						</div>
						<?php } ?>	
					   
					  	<?php if (!empty($ticketList)){ ?>				 
					   <div class="col-md-12">
						 <div class="portlet-title">
						        <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-note"></i>
								  <span class="caption-subject font-red-mint sbold">Ticket Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>
					   
					   
					   <table class="table table-striped table-bordered table-advance table-hover">
						<tr class="success"><th>Sr. No.</th><th>Ticket ID</th><th>Title </th><th>Priority</th><th width="15%">Ticket Date </th><th width="15%">Status</th></tr>
                       
							<tbody>
							<?php foreach ($ticketList as $key=>$tickett){ ?>
								<tr>
								<td><?php echo $key+1; ?></td>
								<td><?php echo $tickett['ticket_id']; ?></td>							
								<td><?php echo isset($tickett['ticket_title'])?$tickett['ticket_title']:""; ?></td>								
								<!--td><?php echo isset($tickett['ticket_desc'])?$tickett['ticket_desc']:""; ?> </td>
								<td><?php echo isset($tickett['tkt_type_name'])?$tickett['tkt_type_name']:""; ?> </td-->
								<td><?php echo isset($tickett['ticket_priority'])?$tickett['ticket_priority']:""; ?> </td>
								<td><?php echo isset($tickett['tkt_sdate_n'])?$tickett['tkt_sdate_n']:""; ?> </td>								
								<td><?php  if($tickett['ticket_status']=="Open") { 				  
								  echo "<span class='label label-success'>Open</span>"; 
								  } else if($tickett['ticket_status']=="Closed") {		  
								  echo "<span class='label label-danger'>Closed</span>"; 
								} else { 
								echo "<span class='label label-warning'>".$tickett['ticket_status']."</span>"; } ?></td>
								</tr>
								
								<?php } ?>
							</tbody> 
							  </table>	
							</div> 
							<?php } ?>
                        
						
						<?php if (!empty($complaintList)){ ?>						
						<div class="col-md-12">
						 <div class="portlet-title">
						        <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-notebook"></i>
								  <span class="caption-subject font-red-mint sbold">Complaint Ticket Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>
                         
													   
					     <table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr class="success"><th>Sr. No.</th><th>Complaint ID </th><th>Ticket ID</th><th>Complaint Title</th><th width="12%">Created On</th><th>Status</th></tr>
							<?php foreach ($complaintList as $key=>$ticket){ ?>							 
							    <tr><td><?php echo $key+1; ?> </td>
								<td><?php echo $ticket['ticket_id']; ?>	</td>
								<td><?php echo $ticket['created_ticket_id']; ?></td>				
								<td><?php echo $ticket['ticket_title']; ?></td>				
								<td><?php echo $ticket['tkt_sdate_n']; ?></td>
								
								<td>
								  <?php  if($ticket['ticket_status']=="Open") { 				  
								  echo "<span class='label label-success'>Open</span>"; 
								  } else if($ticket['ticket_status']=="Closed") {		  
								  echo "<span class='label label-danger'>Closed</span>"; 
								} else { 
								  echo "<span class='label label-warning'>".$ticket['ticket_status']."</span>";
								}    ?> 
								</td></tr>
							  <?php } ?>
							
							
							</tbody>
                        </table>
						</div>
						<?php } ?>	
						
						<?php if (!empty($billPaymentList)){ ?>						
						<div class="col-md-12">
						 <div class="portlet-title">
						 <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-wallet"></i>
								  <span class="caption-subject font-red-mint sbold">Payment Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>		
					     <table class="table table-condensed table-hover">
							<tbody>
								<tr><th width="20%"> Invoice No  </th><td><?php echo isset($billPaymentList[0]['cbpm_id'])?$billPaymentList[0]['cbpm_id']:""; ?> </td>
								<th> Package Amount  </th>
								<td><?php echo isset($billPaymentList[0]['cbpm_amount'])?$billPaymentList[0]['cbpm_amount']:""; ?> </td>
								<th> Total Amount  </th>
								<td><?php echo isset($billPaymentList[0]['cbpm_total_amnt'])?$billPaymentList[0]['cbpm_total_amnt']:""; ?> </td>
								</tr>
								<tr>								
								
								<th> Received Payment  </th>								
								<td><?php echo isset($billPaymentList[0]['cbpm_received_amnt'])?$billPaymentList[0]['cbpm_received_amnt']:""; ?> </td>
								<th> Balance Payment  </th>
								<td><?php echo isset($billPaymentList[0]['cbpm_balance_amnt'])?$billPaymentList[0]['cbpm_balance_amnt']:""; ?> </td>
								
								<th> Discount   </th>
								<td><?php echo isset($billPaymentList[0]['cbpm_save_price'])?$billPaymentList[0]['cbpm_save_price']:""; ?> </td>						
								</tr>							
								<tr>	
								<th> GST </th>
								<td><?php echo isset($billPaymentList[0]['cbpm_gst'])?$billPaymentList[0]['cbpm_gst']:"0"; ?> </td>
								<th> GST  Type  </th>
								<td><?php echo isset($billPaymentList[0]['cbpm_gsttype'])?$billPaymentList[0]['cbpm_gsttype']:""; ?> </td>						
								</tr>							
							</tbody> 
							  </table>
							<?php if (!empty($billPaymentList[0]['paymentList'])){ ?>		
							<table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr class="success"><th>Sr. No.</th><th>Receipt No (S/W)</th><th>Bill Book No</th><th>Paid Date</th><th>Paid Amt</th><th>Pay Mode</th><th>Chq/Card No</th><th>Bank Details</th><th>Status</th><th width="15%">Action</th></tr>
							<?php foreach ($billPaymentList[0]['paymentList'] as $key=>$pyment){ ?>							 
							    <tr><td><?php echo $key+1; ?> </td>
								<td><?php echo $pyment['cp_receiptno']; ?> </td>
								<td><?php echo $pyment['cp_uibillno']; ?></td>
								<td><?php echo $pyment['cp_udate_n']; ?></td>				
								<td><?php echo $pyment['cp_amount']; ?></td>
								<td><?php echo $pyment['cp_paytype']; ?></td>
								<td><?php echo $pyment['cp_chq_no']; ?></td>
								<td><?php echo $pyment['cp_bank_details']; ?></td>
														
								<td>
								  <?php  if($pyment['cp_status']=="Paid") { 				  
								  echo "<span class='label label-success'>Paid</span>"; 
								  } else if($pyment['cp_status']=="Closed" || $pyment['cp_status']=="Cancel") {		  
								  echo "<span class='label label-danger'>".$pyment['cp_status']."</span>"; 
								} else { 
								  echo "<span class='label label-warning'>".$pyment['cp_status']."</span>";
								}    ?> 
								</td>
								<td></td>
								</tr>
								
							  <?php } ?>
							
							</tbody>
                        </table>
							<?php } ?>
						</div>
						<?php } ?>
						
							<?php if (!empty($followupList)){ ?>						
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
							<tr class="success"><th>Sr. No.</th><th>FollowUp Date</th><th>Next FollowUp Date</th><th>Next FollowUp Time</th><th>FollowUp By</th><th>FeedBack</th><th>Status</th></tr>
							<?php foreach ($followupList as $key=>$follow){ ?>
							  <?php foreach ($follow['followupList'] as $flw){ ?>
							    <tr><td><?php echo $key+1; ?> </td>
								<td><?php echo $flw['followup_date_n']; ?> </td>
								<td><?php echo $flw['followup_nxt_folldate_n']; ?></td>
								<td><?php echo $flw['followup_nxt_folltime']; ?></td>				
								<td><?php echo $flw['followup_addedby_name']; ?></td>
								<td><?php echo $flw['followup_feedback']; ?></td>
								<td>
								  <?php  if($flw['followup_status']=="Following") { 				  
								  echo "<span class='label label-success'>Following</span>"; 
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
		<div class="modal fade" id="form_modal_lg" tabindex="-1" role="dialog" aria-hidden="true"  >
			<div class="modal-dialog modal-lg">
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
	$("#form_modal_lg").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    }); 
	
  $('#confirm-deactivate').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });	
   $('#confirm-clear').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });	   
  $('#confirm-clear-payment').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });	 
  $('#confirm-cancel').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });	
  
});
</script>