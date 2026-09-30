<?php
// $role_id = $this->session->userdata('user_role_id');
$role_id = $this->session->userdata('vendor')['user_role_id'];
?>
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
			<div class="col-md-12">
			
			<div class="portlet light bordered">
				<ul class="page-breadcrumb breadcrumb">
					<li><a href="<?php echo base_url(get_module() . "/dashboard") ?>">Home</a><i class="fa fa-circle"></i></li>
					<li><a href="<?php echo base_url(get_module() . "/customers/ticket_report") ?>">All Ticket Report </a><i class="fa fa-circle"></i></li>
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
							if ($error) {
							?>

								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<?php echo $this->session->flashdata('error'); ?>
								</div>
							<?php } ?>
							<?php
							$success = $this->session->flashdata('success');
							if ($success) {
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
						if (!empty($details)) {
							$id =  base64_encode($details['ticket_id']);
							$details = html_escape($details);
							$ticket_id  = isset($details['ticket_id']) ? $details['ticket_id'] : "";
							$ticket_id1  = isset($details['ticket_seq_id']) ? $details['ticket_seq_id'] : "";
							$ticket_title  = isset($details['ticket_title']) ? $details['ticket_title'] : "";
							$ticket_desc  = isset($details['ticket_desc']) ? $details['ticket_desc'] : "";
							$ticket_date_n  = isset($details['ticket_date_n']) ? $details['ticket_date_n'] : "";
							$ticket_time  = isset($details['ticket_time']) ? $details['ticket_time'] : "";
							$ticket_added_by  = isset($details['ticket_added_by']) ? $details['ticket_added_by'] : "";
							$user_id  = isset($details['user_id']) ? $details['user_id'] : "";
							$tkt_resolved_by  = isset($details['tkt_resolved_by']) ? $details['tkt_resolved_by'] : "";

							$ticket_added_byname  = isset($details['ticket_added_byname']) ? $details['ticket_added_byname'] : "";
							$tkt_resolved_date  = isset($details['tkt_resolved_date_n']) ? $details['tkt_resolved_date_n'] : "";
							$tkt_closed_date  = isset($details['tkt_closed_date_n']) ? $details['tkt_closed_date_n'] : "";
							$tkt_sdate  = isset($details['tkt_sdate_n']) ? $details['tkt_sdate_n'] : "";
							$ticket_priority  = isset($details['ticket_priority']) ? $details['ticket_priority'] : "";

							$ticketReviewList  = isset($details['ticketReviewList']) ? $details['ticketReviewList'] : "";

							$ticket_detailList  = isset($details['ticket_detailList']) ? $details['ticket_detailList'] : "";
							$subscriptionList  = isset($details['subscriptionList']) ? $details['subscriptionList'] : "";

							$clm_name  = isset($details['clm_name']) ? $details['clm_name'] : "";
							$customer_name  = isset($details['customer_name']) ? $details['customer_name'] : "";

							$customer_address  = isset($details['customer_address']) ? $details['customer_address'] : "";
							$clm_adress  = isset($details['clm_adress']) ? $details['clm_adress'] : "";

							$clm_contact  = isset($details['clm_contact']) ? $details['clm_contact'] : "";
							$customer_contact  = isset($details['customer_contact']) ? $details['customer_contact'] : "";

							$status  = isset($details['ticket_status']) ? $details['ticket_status'] : "";
							$tkt_sdate_n  = isset($details['tkt_sdate_n']) ? $details['tkt_sdate_n'] : "";

							$name    = !empty($clm_name) ? $clm_name : $customer_name;
							$contact = !empty($clm_contact) ? $clm_contact : $customer_contact;
							$adress  = !empty($clm_adress) ? $clm_adress : $customer_address;



						?>


							<!-- Ticket Short Summary Container START -->

							<div class="row" style="margin-bottom:25px;  margin-left:1px; margin-right:1px;">

    <div class="col-md-12">

        <div style="background:#f8f9fb; border:1px solid #e5e7eb; border-radius:18px; padding:15px;">

            <div class="row">

                <!-- LEFT COLUMN -->
                <div class="col-md-6" style="padding-left:10px; padding-right:10px;">

                    <div style="display:flex; align-items:flex-start; margin-bottom:2px; line-height:1.6;">

                        <span style="font-weight:700; color:#222; min-width:90px; flex-shrink:0;">
                            Ticket ID :
                        </span>

                        <span style="color:#555;">
                            <?php echo $ticket_id1; ?>
                        </span>

                    </div>


                    <div style="display:flex; align-items:flex-start; line-height:1.6;">

                        <span style="font-weight:700; color:#222; min-width:90px; flex-shrink:0;">
                            Ticket Title :
                        </span>

                        <span style="color:#555; word-break:break-word;">
                            <?php echo $ticket_title; ?>
                        </span>

                    </div>

                </div>



                <!-- MIDDLE COLUMN -->
                <div class="col-md-3" style="padding-left:10px; padding-right:10px;">

                    <div style="display:flex; align-items:flex-start; margin-bottom:2px; line-height:1.6;">

                        <span style="font-weight:700; color:#222; min-width:90px; flex-shrink:0;">
                            Status :
                        </span>

                        <span>

                            <?php if($status=="Open") { ?>				  

                                <span class="label label-success" style="padding:2px 6px; border-radius:20px; font-size:12px;">
                                    Open
                                </span>

                            <?php } else if($status=="Closed") { ?>		  

                                <span class="label label-danger" style="padding:2px 6px; border-radius:20px; font-size:12px;">
                                    Closed
                                </span>

                            <?php } else if($status=="Reopened") { ?>		  

                                <span class="label label-info" style="padding:2px 6px; border-radius:20px; font-size:12px;">
                                    Reopened
                                </span>
						    <?php } else if($status=="Deactivated") { ?>		  

                                <span class="label label-danger" style="padding:2px 6px; border-radius:20px; font-size:12px;">
                                    Deactivated
                                </span>

                            <?php } else { ?> 

                                <span class="label label-warning" style="padding:2px 6px; border-radius:20px; font-size:12px;">
                                    <?php echo $status; ?>
                                </span>

                            <?php } ?>

                        </span>

                    </div>



                    <div style="display:flex; align-items:flex-start; line-height:1.6;">

                        <span style="font-weight:700; color:#222; min-width:90px; flex-shrink:0;">
                            Priority :
                        </span>

                        <span style="color:#555;">
                            <?php echo $ticket_priority; ?>
                        </span>

                    </div>

                </div>



                <!-- RIGHT COLUMN -->
                <div class="col-md-3" style="padding-left:10px; padding-right:0px;">

                    <div style="display:flex; align-items:flex-start; margin-bottom:2px; line-height:1.6;">

                        <span style="font-weight:700; color:#222; min-width:90px; flex-shrink:0;">
                            Added On :
                        </span>

                        <span style="color:#555;">
                            <?php echo $tkt_sdate_n; ?>
                        </span>

                    </div>



                    <div style="display:flex; align-items:flex-start; line-height:1.6;">

                        <span style="font-weight:700; color:#222; min-width:90px; flex-shrink:0;">
                            Added By :
                        </span>

                        <span style="color:#555;">
                            <?php echo $ticket_added_byname; ?>
                        </span>

                    </div>

                </div>

            </div>
			<div class="row">
				 <div class="col-md-12" style="padding-left:10px; padding-right:10px; margin-top:5px;">

                    <div style="display:flex; align-items:flex-start; line-height:1.6;">

                        <span style="font-weight:700; color:#222; min-width:95px; flex-shrink:0;">
                             Description :
                        </span>

                        <span style="color:#555; word-break:break-word;">
                            <?php echo $ticket_desc; ?>
                        </span>

                    </div>

                </div>

                </div>
			</div>

        </div>

    </div>

</div>
							<!-- Ticket Short Summary Container END -->


							<?php if (!empty($ticket_detailList)) { ?>
								<div class="col-md-12" style="margin-top:-20px !important;">
									<div class="portlet-title">
										<br />
										<div class="caption" >
											<i class="font-red-mint icon-user-following"></i>
											<span class="caption-subject font-red-mint sbold">Assigned To</span>
										</div>
										<hr style="margin:3px;" />
									</div>
									<table class="table table-striped table-bordered table-advance table-hover">
										<tbody>
											<tr class="success">
												<th>Sr. No.</th>
												<th>Assigned By</th>
												<th>Assigned To</th>
												<th>Assigned On</th>
											</tr>

											<?php foreach ($ticket_detailList as $key => $det) { ?>
												<tr>
													<td><?php echo $key + 1; ?> </td>
													<td><?php echo $det['ticket_update_by_n']; ?> </td>
													<td><?php echo $det['emp_name']; ?></td>
													<td><?php echo $det['tkt_det_sdate_n']; ?></td>
												</tr>
											<?php } ?>

										</tbody>
									</table>
								</div>
							<?php } ?>


							<div class="col-md-6" style="margin-top:10px;">
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-ticket font-red-mint" style="font-size:14px; vertical-align:middle; margin-top:-2px;"></i>
										<span class="caption-subject font-red-mint sbold">Ticket Details</span>
									</div>
									<hr style="margin:3px;" />
								</div>
								<!-- <div class="slimScrollDiv200">		 -->
								<div>
									<table class="table table-striped table-bordered table-advance table-hover">
										<tbody>

											<!-- <tr>
												<th>Ticket Description </th>
												<td><?php echo $ticket_desc; ?></td>
											</tr> -->
											<tr>
												<th>Ticket Date & Time</th>
												<td><?php echo $ticket_date_n; ?> <?php echo $ticket_time; ?></td>
											</tr>
											<!-- <tr>
												<th>Ticket Time</th>
												<td><?php echo $ticket_time; ?></td>
											</tr> -->
											<tr>
												<th>Assign Date & Time</th>
												<td><?php echo $tkt_sdate; ?></td>
											</tr>
											<tr>
												<th>Resolved Date & Time</th>
												<td><?php echo $tkt_resolved_date; ?></td>
											</tr>
											<tr>
												<th>Closed Date & Time </th>
												<td><?php echo $tkt_closed_date; ?></td>
											</tr>
											<tr>
												<th>Re-Opened Date & Time </th>
												<td><?php echo ($details['tkt_reopened_date_n']) ? $details['tkt_reopened_date_n'] : "";; ?></td>
											</tr>

										</tbody>
									</table>

								</div>
							</div>

							<div class="col-md-6" style="margin-top:10px;">
								<div class="portlet-title">
									<div class="caption">
										<i class="font-red-mint icon-user"></i>
										<span class="caption-subject font-red-mint sbold">Customer/Lead Details</span>
									</div>
									<hr style="margin:3px;" />
								</div>

								<table class="table table-striped table-bordered table-advance table-hover">
									<tbody>
										<tr>
											<th width="52%"> Name </th>
											<td><?php echo $name; ?> </td>
										</tr>
										<tr>
											<th> Contact </th>
											<td><?php echo $contact; ?> </td>
										</tr>
										<tr>
											<th> Address </th>
											<td><?php echo $adress; ?> </td>
										</tr>
										<?php if (!empty($subscriptionList)) {
											$cust_subs_enddate_n = $subscriptionList[0]['cust_subs_enddate_n'];
											$cust_subs_startdate_n = $subscriptionList[0]['cust_subs_startdate_n'];
										?>
											<tr>
												<th> AMC/Service/Product Start Date : </th>
												<td><?php echo $cust_subs_startdate_n; ?>
											</tr>
											<tr>
												<th> AMC/Service/Product End Date : </th>
												<td><?php echo $cust_subs_enddate_n; ?>
											</tr>
										<?php }  ?>
									</tbody>
								</table>

								<?php if ($status == "Reopened") { ?>

									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-refresh font-red-mint"></i>
											<span class="caption-subject font-red-mint sbold">
												Re-Opened Details
											</span>
										</div>
										<hr style="margin:3px;" />
									</div>

									<table class="table table-striped table-bordered table-advance table-hover">
										<tbody>

											<tr>
												<th>Re-Opened On</th>
												<td>
													<?php echo isset($details['tkt_reopened_date_n']) ? $details['tkt_reopened_date_n'] : ""; ?>
												</td>
											</tr>

											<tr>
												<th>Re-Opened By</th>
												<td>
													<?php echo isset($details['tkt_reopened_by_name']) ? $details['tkt_reopened_by_name'] : ""; ?>
												</td>
											</tr>

										</tbody>
									</table>

								<?php } ?>

							</div>

							<!-- <?php if (!empty($ticket_detailList)) { ?>
								<div class="col-md-12">
									<div class="portlet-title">
										<br />
										<div class="caption">
											<i class="font-red-mint icon-user-following"></i>
											<span class="caption-subject font-red-mint sbold">Assigned To</span>
										</div>
										<hr style="margin:3px;" />
									</div>
									<table class="table table-striped table-bordered table-advance table-hover">
										<tbody>
											<tr class="success">
												<th>Sr. No.</th>
												<th>Assigned By</th>
												<th>Assigned To</th>
												<th>Assigned On</th>
											</tr>

											<?php foreach ($ticket_detailList as $key => $det) { ?>
												<tr>
													<td><?php echo $key + 1; ?> </td>
													<td><?php echo $det['ticket_update_by_n']; ?> </td>
													<td><?php echo $det['emp_name']; ?></td>
													<td><?php echo $det['tkt_det_sdate_n']; ?></td>
												</tr>
											<?php } ?>

										</tbody>
									</table>
								</div>
							<?php } ?> -->

							<?php if (!empty($ticketReviewList)) { ?>
								<div class="col-md-12">
									<div class="portlet-title">
										<br />
										<div class="caption">
											<i class="font-red-mint icon-notebook"></i>
											<span class="caption-subject font-red-mint sbold">Review Details</span>
										</div>
										<hr style="margin:3px;" />
									</div>
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-advance table-hover">
											<tbody>
												<tr class="success">
													<th width="4%">Sr.No.</th>
													<th width="25%">Review</th>
													<th width="25%">Review Description</th>
													<th width="15%">Updated By</th>
													<th width="10%">Updated On</th>
													<th width="8%">Status</th>
													<th width="8%">Signature</th>
												</tr>
												<?php foreach ($ticketReviewList as $key => $rev) { ?>
													<tr>
														<td style="text-align:center;"><?php echo $key + 1; ?> </td>

														<td>
															<?php
															echo $rev['trm_name'];

															if (!empty($rev['trm_img_path'])) {
																$image = trim($rev['trm_img_path']); // Remove spaces
																$image = str_replace("getAuthApiKey", APIKEY, $image);

																// Check if the path contains a valid file extension
																if (preg_match('/\.(png|jpg|jpeg|gif|pdf|doc|docx)$/i', $image)) {
																	echo "&nbsp;<a href='" . $image . "' target='_blank' title='View Attachment'><i class='fa fa-paperclip'></i></a>";
																}
															}
															?>

														</td>
														<td><?php echo $rev['trm_desc']; ?></td>
														<td><?php echo $rev['user_person_name']; ?></td>
														<td><?php echo $rev['trm_sdate_n']; ?></td>
														<td> <?php if ($rev['trm_status'] == "Open") {
																	echo "<span class='label label-success' style='display:inline-block; min-width:66px; text-align:center; padding:5px 0;'>Open</span>";
																} else if ($rev['trm_status'] == "Closed") {
																	echo "<span class='label label-danger' style='display:inline-block; min-width:66px; text-align:center; padding:5px 0;'>Closed</span>";
																} else if ($rev['trm_status'] == "Reopen" || $rev['trm_status'] == "Reopened") {
																	echo "<span class='label label-success' style='background:#3F51B5; display:inline-block; min-width:66px; text-align:center; padding:5px 0;'>Reopened</span>";
																} else {
																	echo "<span class='label label-warning' style='display:inline-block; min-width:66px; text-align:center; padding:5px 0;'>" . $rev['trm_status'] . "</span>";
																}    ?> </td>

														<td>
															<?php
															$signature = isset($rev['trm_sign_img_path']) ? trim($rev['trm_sign_img_path']) : ''; // Remove spaces

															// Check if the path contains an image file extension
															if (!empty($rev['story_signature'])) {
                                                            echo "<span class='label label-info'>Demo signature</span>";
                                                        } elseif (!empty($signature) && preg_match('/\.(png|jpg|jpeg|gif)$/i', $signature)) {
																$signature = str_replace("getAuthApiKey", APIKEY, $signature);
																echo "<img src='" . $signature . "' alt='Signature' style='max-width:80px; width:100%; height:auto; border:1px solid #ddd;'/>";
															} else {
																echo "<p class='label label-danger' font-weight:bold;'>No Signature</p>";
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


							<div class="col-md-12">
								<div class="form-actions ">
									<div class=" col-md-12">
										<center>
											<?php if ($status == "Open" || $status == "Reopened") { ?>
												<?php if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {	?>
													<a id="btn" href="<?php echo get_module_path(); ?>customers/edit_ticket/?id=<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
												<?php } ?>

												<?php if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID || $ticket_added_by == $user_id) {	?>
													<a id="btn" href="<?php echo get_module_path(); ?>customers/assign_ticket/?id=<?php echo $id; ?>" class="btn btn-success" data-toggle="modal" data-target="#form_modal"><i class="fa fa-user-plus"></i> Assign To</a>
												<?php } ?>


												<a id="btn" class="btn btn-primary" data-href="<?php echo get_module_path(); ?>customers/resolve_ticket/?id=<?php echo $id; ?>" title="Resolve Ticket" data-toggle="modal" data-target="#confirm-resolve"><i class="fa fa-check"></i> Resolve Ticket</a>

												<a id="btn" class="btn btn-danger" data-href="<?php echo get_module_path(); ?>customers/deactivate_ticket/?ref_id=<?php echo $id; ?>" title="Deactivate Ticket" data-toggle="modal" data-target="#confirm-deactivate1"><i class="fa fa-ban"></i> Deactivate Ticket</a>

											<?php } ?>

											<?php if ($status == "Resolved" || $status == "Closed" || $status == "Deactivated") { ?>

												<a id="btn" class="btn btn-primary" data-href="<?php echo get_module_path(); ?>customers/reopen_ticket/?id=<?php echo $id; ?>" title="Re-Open Ticket" data-toggle="modal" data-target="#confirm-reopen"><i class="fa fa-check"></i> Reopen Ticket</a>

											<?php } ?>

											<?php if ($status == "Resolved" && $status != "Closed" && ($role_id == ADMIN_ROLE_ID || $role_id == SUPER_ADMIN_ROLE_ID || $ticket_added_by == $userId) && ($tkt_resolved_by != $userId || ($role_id == ADMIN_ROLE_ID || $role_id == SUPER_ADMIN_ROLE_ID))): ?>


												<a id="btn" class="btn btn-danger" data-href="<?php echo get_module_path(); ?>customers/close_ticket/?id=<?php echo $id; ?>" title="Close Ticket" data-toggle="modal" data-target="#confirm-close">
													<i class="fa fa-close"></i> Close Ticket
												</a>
											<?php endif; ?>

											<!-- <p>Ticket Added By: <?php echo htmlspecialchars($ticket_added_by); ?></p>
<p>User ID: <?php echo htmlspecialchars($userId); ?></p> -->


											<style>
												@media screen and (max-width : 405px) {
													#btn {
														margin: 5px;
													}

												}

												.hide-button {
													display: none;
												}
											</style>

											<!-- <?php if (isset($history) && $history == "back") { ?>
												<a onclick="window.history.back();" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
											<?php } else {  ?>
												<a href="<?php echo get_module_path(); ?>customers/ticket_report?history=back&highlight=<?php echo $id; ?>" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
											<?php } ?> -->
											<?php if (isset($history) && $history == "dashboard") { ?>

                                                    <a href="<?php echo get_module_path(); ?>dashboard" class="btn btn-danger">
                                                        <i class="fa fa-history"></i>Back
                                                    </a>

                                                <?php } elseif (isset($history) && $history == "back") { ?>

                                                    <a onclick="window.history.back();" class="btn btn-danger">
                                                        <i class="fa fa-history"></i>Back
                                                    </a>

                                                <?php } else { ?>

                                                    <a href="<?php echo get_module_path(); ?>customers/ticket_report?history=back&highlight=<?php echo $id; ?>" class="btn btn-danger">
                                                        <i class="fa fa-history"></i>Back
                                                    </a>

											<?php } ?>
										</center>
									</div>
								</div>
							</div>
							<!-- /.box-body -->
						<?php } else { ?>
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								Ticket Details Not Found !!!
							</div>
						<?php } ?>

					</div>
				</div>
			</div>
			</div> <!-- row -->
			<!-- END PAGE BASE CONTENT -->
		</div>
		<!-- END CONTENT BODY -->
	</div>
</div>
<!-- END CONTENT -->

<!-- START MODAL -->

<div class="modal fade" id="form_modal_lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="confirm-resolve" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-green-sharp">
				<button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp; Resolve Ticket</h4>
			</div>
			<div class="modal-body">

				<p id="myModalBody">Are you really Want To Resolve This Ticket ?</p>

			</div>
			<div class="modal-footer">
				<center>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<a class="btn btn-success btn-resolve" data-toggle="modal" data-target="#form_modal" data-dismiss="modal">Resolve</a>
					<center>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="confirm-reopen" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-green-sharp">
				<button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp; Re-Open Ticket</h4>
			</div>
			<div class="modal-body">

				<p id="myModalBody">Are you really Want To Re-Open This Ticket ?</p>

			</div>
			<div class="modal-footer">
				<center>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<a class="btn btn-success btn-reopen" data-toggle="modal" data-target="#form_modal" data-dismiss="modal">Re-Open</a>
					<center>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="confirm-close" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-red-mint">
				<button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp; Close Ticket</h4>
			</div>
			<div class="modal-body">
				<p id="myModalBody">Are you really Want To Close This Ticket ? </p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-close" data-toggle="modal" data-target="#form_modal" data-dismiss="modal">Close Ticket</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="confirm-deactivate1" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-red-mint">
				<button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp; Deactivate Ticket</h4>
			</div>
			<div class="modal-body">
				<p id="myModalBody">Are you really Want To Deactivate This Ticket ? </p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-deactivate" data-toggle="modal" data-target="#form_modal" data-dismiss="modal">Deactivate</a>
			</div>
		</div>
	</div>
</div>



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


		$('#confirm-deactivate1').on('show.bs.modal', function(e) {
			$(this).find('.btn-deactivate').attr('href', $(e.relatedTarget).data('href'));
		});
		$('#confirm-resolve').on('show.bs.modal', function(e) {
			$(this).find('.btn-resolve').attr('href', $(e.relatedTarget).data('href'));
		});
		$('#confirm-reopen').on('show.bs.modal', function(e) {
			$(this).find('.btn-reopen').attr('href', $(e.relatedTarget).data('href'));
		});
		$('#confirm-close').on('show.bs.modal', function(e) {
			$(this).find('.btn-close').attr('href', $(e.relatedTarget).data('href'));
		});
		$('#confirm-cancel').on('show.bs.modal', function(e) {
			$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
		});

	});
</script>

