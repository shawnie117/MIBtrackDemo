<?php $role_id = $this->session->userdata('user_role_id');?>
<div class="page-content-wrapper">	
      <div class="row">
         <div class="portlet light bordered">
		 <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint icon-wrench"></i>
                  <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
               </div>
			   <div class="actions">
			   <button type="button"  class="close" data-dismiss="modal">&times;</button>
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
                 <div class="portlet-body">
                      <?php //echo "<pre/>"; print_r($details);die;
					  if(!empty($details)){ 
						////$id =  base64_encode($details['customer_id']);
						$details = html_escape($details);
					/* 	$customer_name  = isset($details['customer_name'])?$details['customer_name']:"";
						$customer_uniqueid  = isset($details['customer_uniqueid'])?$details['customer_uniqueid']:"";
						$cust_type  = isset($details['cust_type'])?$details['cust_type']:"";
						$complaintList  = isset($details['complaintList'])?$details['complaintList']:"";
						$subscriptionList  = isset($details['subscriptionList'])?$details['subscriptionList']:"";
						$subscriptionServiceList  = isset($details['subscriptionServiceList'])?$details['subscriptionServiceList']:""; */
						
					  ?>
						<?php if (!empty($details)){ ?>						
						<div class="col-md-12">
						 <div class="portlet-title">
						      <div class="caption">
								  <i class="font-red-mint icon-wrench"></i>
								  <span class="caption-subject font-red-mint sbold">Service Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>
                          <table class="table table-condensed table-hover">
							<tbody>
								<tr><th width="20%"> Service Name  </th><td><?php echo isset($details['cust_subs_type_name'])?$details['cust_subs_type_name']:""; ?> </td>
								<th> Service Type  </th>
								<td><?php echo isset($details['cust_subs_type'])?$details['cust_subs_type']:""; ?> </td>
								<th> Services Duration </th>
								<td><?php echo isset($details['cust_subs_duration'])?$details['cust_subs_duration']:""; ?> </td>
								</tr>
								
								<tr><th> Total Price  </th>
								<td><?php echo isset($details['cust_subs_price'])?$details['cust_subs_price']:""; ?> </td>
								<th> Start Date  </th>
								<td><?php echo isset($details['cust_subs_startdate_n'])?$details['cust_subs_startdate_n']:""; ?> </td>
								<th>End Date </th>
								<td><?php echo isset($details['cust_subs_enddate_n'])?$details['cust_subs_enddate_n']:""; ?> </td>
								</tr>	
								
								<tr><th>Services Done</th>
								<td><?php echo isset($details['cust_subs_noofserv_done'])?$details['cust_subs_noofserv_done']:""; ?> </td>
								<th>Remaining Services </th>
								<td><?php echo isset($details['cust_subs_noofserv_remining'])?$details['cust_subs_noofserv_remining']:""; ?> </td>
								<th>No Of Services </th>
								<td><?php echo isset($details['cust_subs_noofserv'])?$details['cust_subs_noofserv']:""; ?> </td>
								</tr>	
								
							</tbody> 
							  </table>						   
					     <table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr class="success"><th width="2%">Sr. No.</th><th width="15%">Service Dates </th><th>Status </th><th>	Ticket ID</th><th width="12%">Done On</th></tr>
							<?php foreach ($details['serviceList'] as $key=>$serv){ ?>							 
							    <tr><td><?php echo $key+1; ?> </td>
								<td><?php echo $serv['cust_serv_date_n']; ?> </td>
								<td><?php echo $serv['cust_serv_status']; ?></td>
								<td><?php echo $serv['ticket_id']; ?></td>				
								<td><?php echo $serv['cust_serv_doneondate_n']; ?></td>
								
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
							<tr class="success"><th width="2%">Sr. No.</th><th width="5%">Complaint ID </th><th>Ticket ID</th><th>Complaint Title</th><th width="12%">Created On</th><th>Status</th></tr>
							<?php foreach ($complaintList as $key=>$ticket){ ?>							 
							    <tr><td><?php echo $key+1; ?> </td>
								<td><?php echo $ticket['complaint_ticket_id']; ?> </td>
								<td><?php echo $ticket['ticket_id']; ?></td>
								<td><?php echo $ticket['ticket_title']; ?></td>				
								<td><?php echo $ticket['tkt_sdate_n']; ?></td>
								
								<td>
								  <?php  if($ticket['ticket_status']=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($ticket['ticket_status']=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
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
								  <span class="caption-subject font-red-mint sbold">Payment Details Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>		
					     <table class="table table-condensed table-hover">
							<tbody>
								<tr ><th width="20%"> Invoice No  </th><td><?php echo isset($billPaymentList['cbpm_id'])?$billPaymentList['cbpm_id']:""; ?> </td>
								<th> Package Amount  </th>
								<td><?php echo isset($billPaymentList['cbpm_amount'])?$billPaymentList['cbpm_amount']:""; ?> </td>
								<th> Total Amount  </th>
								<td><?php echo isset($billPaymentList['cbpm_total_amnt'])?$billPaymentList['cbpm_total_amnt']:""; ?> </td>
								</tr>
								<tr>								
								
								<th> Received Payment  </th>
								
								<td><?php echo isset($billPaymentList['cbpm_received_amnt'])?$billPaymentList['cbpm_received_amnt']:""; ?> </td>
								<th> Balance Payment  </th>
								<td><?php echo isset($billPaymentList['cbpm_balance_amnt'])?$billPaymentList['cbpm_balance_amnt']:""; ?> </td>
								
								<th> Discount   </th>
								<td><?php echo isset($billPaymentList['cbpm_save_price'])?$billPaymentList['cbpm_save_price']:""; ?> </td>
								
								</tr>							
							</tbody> 
							  </table>
							<?php if(!empty($billPaymentList['paymentList'])){ ?>
							<table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr class="success"><th width="2%">Sr. No.</th><th width="5%">Receipt No (S/W)</th><th width="5%">Bill Book No</th><th width="12%">Paid Date</th><th>Paid Amt</th><th>Pay Mode</th><th>Chq/Card No</th><th>Bank Details</th><th>Status</th></tr>
							<?php foreach ($billPaymentList['paymentList'] as $key=>$pyment){ ?>							 
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
								</td></tr>
							  <?php } ?>
							
							</tbody>
                        </table>
						<?php } ?>
						</div>
						<?php } ?>
                        <!-- /.box-body -->
						<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     Service Details Not Found !!!
                  </div>
						<?php } ?>
                   
               </div>
            </div>
         </div>
         <!-- END PAGE BASE CONTENT -->
      </div>
      </div>
      <!-- END CONTENT BODY -->