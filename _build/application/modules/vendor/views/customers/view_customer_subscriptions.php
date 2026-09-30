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
						$cust_name = isset($_GET['cust_name']) 
    ? base64_decode(urldecode($_GET['cust_name'])) 
    : "";
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
						  
                          <!-- <table class="table table-condensed table-hover">
							<tbody>
								<tr>
                                 <th width="20%">Customer Name</th><td><?php echo $cust_name; ?></td>
                                 </tr>
								<tr><th width="20%"> Service Name  </th><td><?php echo isset($details['cust_subs_type_name'])?$details['cust_subs_type_name']:""; ?> </td>
								<th> Service Type  </th>
								<td><?php echo isset($details['cust_subs_type'])?$details['cust_subs_type']:""; ?> </td>
									<?php if(isset($details['cust_subs_type']) && $details['cust_subs_type'] !== "One Time Service"){ ?>
								<th> Services Duration </th>
								<td><?php echo isset($details['cust_subs_duration'])?$details['cust_subs_duration']:""; ?> </td>
									<?php } else {  ?>
								<th>  </th><th>  </th>
								<?php }   ?>
								</tr>
								
								<tr><th> Total Price  </th>
								<td><?php echo isset($details['cust_subs_price'])?$details['cust_subs_price']:""; ?> </td>
								<th> Start Date  </th>
								<td><?php echo isset($details['cust_subs_startdate_n'])?$details['cust_subs_startdate_n']:""; ?> </td>
								<th>End Date </th>
								<td><?php echo isset($details['cust_subs_enddate_n'])?$details['cust_subs_enddate_n']:""; ?> </td>
								</tr>	
								<?php if(isset($details['cust_subs_type']) && $details['cust_subs_type'] !== "One Time Service"){ ?>
								<tr><th>Services Done</th>
								<td><?php echo isset($details['cust_subs_noofserv_done'])?$details['cust_subs_noofserv_done']:""; ?> </td>
								<th>Remaining Services </th>
								<td><?php echo isset($details['cust_subs_noofserv_remining'])?$details['cust_subs_noofserv_remining']:""; ?> </td>
								<th>No Of Services </th>
								<td><?php echo isset($details['cust_subs_noofserv'])?$details['cust_subs_noofserv']:""; ?> </td>
								</tr>	
								<?php }   ?>
							</tbody> 
							  </table>						    -->

							 <div style="border:1px solid #e5e7eb; border-radius:18px; margin-bottom: 10px; padding:20px; background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.04);">

    <div class="row">

        <!-- LEFT COLUMN -->
        <div class="col-md-7 col-sm-12">

            <!-- Customer Name -->
            <div style="display:flex; align-items:flex-start; margin-bottom:5px; line-height:1.5;">

                <div style="min-width:150px; font-weight:700; color:#222;">
                    <!-- <i class="fa fa-user" style="margin-right:6px;"></i> -->
                    Customer Name :
                </div>

                <div style="color:#666; word-break:break-word;">
                    <?php echo $cust_name; ?>
                </div>

            </div>


            <!-- Service Name -->
            <div style="display:flex; align-items:flex-start; margin-bottom:5px; line-height:1.5;">

                <div style="min-width:150px; font-weight:700; color:#222;">
                    <!-- <i class="fa fa-cogs" style="margin-right:6px;"></i> -->
                    Service Name :
                </div>

                <div style="color:#666; word-break:break-word;">
                    <?php echo isset($details['cust_subs_type_name']) ? $details['cust_subs_type_name'] : ""; ?>
                </div>

            </div>


            <!-- Total Price -->
            <div style="display:flex; align-items:flex-start; margin-bottom:5px; line-height:1.5;">

                <div style="min-width:150px; font-weight:700; color:#222;">
                    <!-- <i class="fa fa-inr" style="margin-right:6px;"></i> -->
                    Total Price :
                </div>

                <div style="color:#666;">
                    <?php echo isset($details['cust_subs_price']) ? $details['cust_subs_price'] : ""; ?>
                </div>

            </div>


           


            <?php if(isset($details['cust_subs_type']) && $details['cust_subs_type'] !== "One Time Service"){ ?>

            <!-- Services Done -->
            <div style="display:flex; align-items:flex-start; margin-bottom:5px; line-height:1.5;">

                <div style="min-width:150px; font-weight:700; color:#222;">
                    <!-- <i class="fa fa-check-circle" style="margin-right:6px;"></i> -->
                    Services Done :
                </div>

                <div style="color:#666;">
                    <?php echo isset($details['cust_subs_noofserv_done']) ? $details['cust_subs_noofserv_done'] : ""; ?>
                </div>

            </div>


            <!-- No Of Services -->
            <div style="display:flex; align-items:flex-start; line-height:1.5;">

                <div style="min-width:150px; font-weight:700; color:#222;">
                    <!-- <i class="fa fa-list-ol" style="margin-right:6px;"></i> -->
                    No Of Services :
                </div>

                <div style="color:#666;">
                    <?php echo isset($details['cust_subs_noofserv']) ? $details['cust_subs_noofserv'] : ""; ?>
                </div>

            </div>

            <?php } ?>

        </div>



        <!-- RIGHT COLUMN -->
        <div class="col-md-5 col-sm-12">

            <!-- Service Type -->
            <div style="display:flex; align-items:flex-start; margin-bottom:5px; line-height:1.5;">

                <div style="min-width:150px; font-weight:700; color:#222;">
                    <!-- <i class="fa fa-tags" style="margin-right:6px;"></i> -->
                    Service Type :
                </div>

                <div style="color:#666;">
                    <?php echo isset($details['cust_subs_type']) ? $details['cust_subs_type'] : ""; ?>
                </div>

            </div>


            <?php if(isset($details['cust_subs_type']) && $details['cust_subs_type'] !== "One Time Service"){ ?>

            <!-- Services Duration -->
            <div style="display:flex; align-items:flex-start; margin-bottom:5px; line-height:1.5;">

                <div style="min-width:150px; font-weight:700; color:#222;">
                    <!-- <i class="fa fa-clock-o" style="margin-right:6px;"></i> -->
                    Services Duration :
                </div>

                <div style="color:#666;">
                    <?php echo isset($details['cust_subs_duration']) ? $details['cust_subs_duration'] : ""; ?>
                </div>

            </div>

            <?php } ?>


            <!-- Start Date -->
            <div style="display:flex; align-items:flex-start; margin-bottom:5px; line-height:1.5;">

                <div style="min-width:150px; font-weight:700; color:#222;">
                    <!-- <i class="fa fa-calendar" style="margin-right:6px;"></i> -->
                    Start Date :
                </div>

                <div style="color:#666;">
                    <?php echo isset($details['cust_subs_startdate_n']) ? $details['cust_subs_startdate_n'] : ""; ?>
                </div>

            </div>

             <!-- End Date -->
            <div style="display:flex; align-items:flex-start; margin-bottom:5px; line-height:1.5;">

                <div style="min-width:150px; font-weight:700; color:#222;">
                    <!-- <i class="fa fa-calendar-check-o" style="margin-right:6px;"></i> -->
                    End Date :
                </div>

                <div style="color:#666;">
                    <?php echo isset($details['cust_subs_enddate_n']) ? $details['cust_subs_enddate_n'] : ""; ?>
                </div>

            </div>


            <?php if(isset($details['cust_subs_type']) && $details['cust_subs_type'] !== "One Time Service"){ ?>

            <!-- Remaining Services -->
            <div style="display:flex; align-items:flex-start; margin-bottom:5px; line-height:1.5;">

                <div style="min-width:150px; font-weight:700; color:#222;">
                    <!-- <i class="fa fa-refresh" style="margin-right:6px;"></i> -->
                    Remaining Services :
                </div>

                <div style="color:#666;">
                    <?php echo isset($details['cust_subs_noofserv_remining']) ? $details['cust_subs_noofserv_remining'] : ""; ?>
                </div>

            </div>

            <?php } ?>

        </div>

    </div>

</div>

							 
					     <!-- <table class="table table-striped table-bordered table-advance table-hover">
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
                        </table> -->

                       <?php if(!empty($details['serviceList'])){ ?>

<div class="table-responsive" style="overflow-x:auto;">

    <table class="table table-striped table-bordered table-advance table-hover" style="min-width:700px;">

        <tbody>

            <tr class="success">
                <th width="8%">Sr. No.</th>
                <th width="14%">Service Dates</th>
                <th>Status</th>
                <th>Ticket ID</th>
                <th width="12%">Done On</th>
            </tr>

            <?php foreach ($details['serviceList'] as $key => $serv){ ?>							 

                <tr>

                    <td style="text-align:center;">
                        <?php echo $key+1; ?>
                    </td>

                    <td>
                        <?php echo $serv['cust_serv_date_n']; ?>
                    </td>

                    <td>
                        <?php echo $serv['cust_serv_status']; ?>
                    </td>

                    <td>
                        <?php echo $serv['ticket_id']; ?>
                    </td>				

                    <td>
                        <?php echo $serv['cust_serv_doneondate_n']; ?>
                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

<?php } ?>


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
								  <span class="caption-subject font-red-mint sbold">Payment Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>		
					     <!-- <table class="table table-condensed table-hover">
							<tbody>
								<tr ><th width="20%"> Invoice No  </th><td><?php echo isset($billPaymentList['cbpm_billno'])?$billPaymentList['cbpm_billno']:""; ?> </td>
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
								<td><?php echo isset($billPaymentList['cbpm_adjustmentamnt'])?$billPaymentList['cbpm_adjustmentamnt']:"0"; ?> </td>
								
								</tr>							
							</tbody> 
							  </table> -->

<div style="border:1px solid #ddd; border-radius:18px; overflow:hidden; background:#fff;">

    <!-- Row 1 -->
    <div class="row" style="margin:0; border-bottom:1px solid #eee;">

        <div class="col-md-4 col-sm-12 col-xs-12"
             style="padding:12px 15px; border-right:1px solid #eee;">

            <span style="font-weight:700; min-width:140px; display:inline-block; white-space:nowrap;">
                Invoice No :
            </span>

            <span style="color:#555; margin-left:6px;">
                <?php echo isset($billPaymentList['cbpm_billno']) ? $billPaymentList['cbpm_billno'] : ""; ?>
            </span>

        </div>


        <div class="col-md-4 col-sm-12 col-xs-12"
             style="padding:12px 15px; border-right:1px solid #eee;">

            <span style="font-weight:700; min-width:140px; display:inline-block; white-space:nowrap;">
                Package Amount :
            </span>

            <span style="color:#555; margin-left:6px;">
                <?php echo isset($billPaymentList['cbpm_amount']) ? $billPaymentList['cbpm_amount'] : ""; ?>
            </span>

        </div>


        <div class="col-md-4 col-sm-12 col-xs-12"
             style="padding:12px 15px;">

            <span style="font-weight:700; min-width:140px; display:inline-block; white-space:nowrap;">
                Total Amount :
            </span>

            <span style="color:#555; margin-left:6px;">
                <?php echo isset($billPaymentList['cbpm_total_amnt']) ? $billPaymentList['cbpm_total_amnt'] : ""; ?>
            </span>

        </div>

    </div>



    <!-- Row 2 -->
    <div class="row" style="margin:0;">

        <div class="col-md-4 col-sm-12 col-xs-12"
             style="padding:12px 15px; border-right:1px solid #eee;">

            <span style="font-weight:700; min-width:140px; display:inline-block; white-space:nowrap;">
                Received Payment :
            </span>

            <span style="color:#555; margin-left:6px;">
                <?php echo isset($billPaymentList['cbpm_received_amnt']) ? $billPaymentList['cbpm_received_amnt'] : ""; ?>
            </span>

        </div>


        <div class="col-md-4 col-sm-12 col-xs-12"
             style="padding:12px 15px; border-right:1px solid #eee;">

            <span style="font-weight:700; min-width:140px; display:inline-block; white-space:nowrap;">
                Balance Payment :
            </span>

            <span style="color:#555; margin-left:6px;">
                <?php echo isset($billPaymentList['cbpm_balance_amnt']) ? $billPaymentList['cbpm_balance_amnt'] : ""; ?>
            </span>

        </div>


        <div class="col-md-4 col-sm-12 col-xs-12"
             style="padding:12px 15px;">

            <span style="font-weight:700; min-width:140px; display:inline-block; white-space:nowrap;">
                Discount :
            </span>

            <span style="color:#555; margin-left:6px;">
                <?php echo isset($billPaymentList['cbpm_adjustmentamnt']) ? $billPaymentList['cbpm_adjustmentamnt'] : "0"; ?>
            </span>

        </div>

    </div>

</div>

							<?php if(!empty($billPaymentList['paymentList'])){ ?>
							<!-- <table class="table table-striped table-bordered table-advance table-hover">
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
                        </table> -->

<div style="width:100%;  overflow:hidden;  margin-top:10px;">
    <div class="table-responsive hidden-xs" style="margin-bottom:0;">
        <table class="table table-striped table-bordered table-advance table-hover"
               style="margin-bottom:0; table-layout:fixed; width:100%;">
            <tbody>
                <tr class="success">
                    <th width="4%">Sr. No.</th>
                    <th width="8%">Receipt No (S/W)</th>
                    <th width="8%">Bill Book No</th>
                    <th width="11%">Paid Date</th>
                    <th width="10%">Paid Amt</th>
                    <th width="9%">Pay Mode</th>
                    <th width="14%">Chq/Card No</th>
                    <th width="18%">Bank Details</th>
                    <th width="8%">Status</th>
                </tr>
                <?php foreach ($billPaymentList['paymentList'] as $key => $pyment){ ?>							 
                    <tr>
                        <td>
                            <?php echo $key+1; ?>
                        </td>
                        <td>
                            <?php echo $pyment['cp_receiptno']; ?>
                        </td>
                        <td>
                            <?php echo $pyment['cp_uibillno']; ?>
                        </td>
                        <td>
                            <?php echo $pyment['cp_udate_n']; ?>
                        </td>				
                        <td>
                            <?php echo $pyment['cp_amount']; ?>
                        </td>
                        <td>
                            <?php echo $pyment['cp_paytype']; ?>
                        </td>
                        <td style="word-break:break-word;">
                            <?php echo $pyment['cp_chq_no']; ?>
                        </td>
                        <td style="word-break:break-word;">
                            <?php echo $pyment['cp_bank_details']; ?>
                        </td>
                        <td style="text-align:center;">
                            <?php  
                            if($pyment['cp_status']=="Paid") { 				  
                                echo "<span class='label label-success'>Paid</span>"; 
                            } else if($pyment['cp_status']=="Closed" || $pyment['cp_status']=="Cancel") {		  
                                echo "<span class='label label-danger'>".$pyment['cp_status']."</span>"; 
                            } else { 
                                echo "<span class='label label-warning'>".$pyment['cp_status']."</span>";
                            }    
                            ?> 
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- Mobile Scroll -->
    <div class="table-responsive visible-xs" 
         style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
        <table class="table table-striped table-bordered table-advance table-hover"
               style="min-width:1100px; margin-bottom:0; white-space:nowrap;">
            <tbody>
                <tr class="success">
                    <th width="4%">Sr. No.</th>
                    <th width="12%">Receipt No (S/W)</th>
                    <th width="12%">Bill Book No</th>
                    <th width="10%">Paid Date</th>
                    <th width="10%">Paid Amt</th>
                    <th width="10%">Pay Mode</th>
                    <th width="14%">Chq/Card No</th>
                    <th width="18%">Bank Details</th>
                    <th width="10%">Status</th>
                </tr>
                <?php foreach ($billPaymentList['paymentList'] as $key => $pyment){ ?>							 
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $pyment['cp_receiptno']; ?></td>
                        <td><?php echo $pyment['cp_uibillno']; ?></td>
                        <td><?php echo $pyment['cp_udate_n']; ?></td>
                        <td><?php echo $pyment['cp_amount']; ?></td>
                        <td><?php echo $pyment['cp_paytype']; ?></td>
                        <td><?php echo $pyment['cp_chq_no']; ?></td>
                        <td><?php echo $pyment['cp_bank_details']; ?></td>
                        <td style="text-align:center;">
                            <?php  
                            if($pyment['cp_status']=="Paid") { 				  
                                echo "<span class='label label-success'>Paid</span>"; 
                            } else if($pyment['cp_status']=="Closed" || $pyment['cp_status']=="Cancel") {		  
                                echo "<span class='label label-danger'>".$pyment['cp_status']."</span>"; 
                            } else { 
                                echo "<span class='label label-warning'>".$pyment['cp_status']."</span>";
                            }    
                            ?> 
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

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