<?php $role_id = $this->session->userdata('user_role_id'); ?>

<?php
$whatsapp_count = 0;
$has_whatsapp_account = false;

if (!empty($whatsappdeatils)) {
	$has_whatsapp_account = true;

	foreach ($whatsappdeatils as $noti) {
		$whatsapp_count = (int)$noti['user_wp_credit_count'];
		break;
	}
}
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
			<div class="portlet light bordered">
				<ul class="page-breadcrumb breadcrumb">
					<li><a href="<?php echo base_url(get_module() . "/dashboard") ?>">Home</a><i
							class="fa fa-circle"></i>
					</li>
					<li><a href="<?php echo base_url(get_module() . "/customers/customer_report") ?>">All Customer
							Report
						</a><i class="fa fa-circle"></i></li>
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
									<button type="button" class="close" data-dismiss="alert"
										aria-hidden="true">Ãƒâ€”</button>
									<?php echo $this->session->flashdata('error'); ?>
								</div>
							<?php } ?>
							<?php
							$success = $this->session->flashdata('success');
							if ($success) {
							?>

								<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert"
										aria-hidden="true">Ãƒâ€”</button>
									<?php echo $this->session->flashdata('success'); ?>
								</div>
							<?php } ?>


						</div>
					</center>
					<div class="portlet-body">
						<?php //echo "<pre/>"; print_r($details);die;
						$history = $this->input->get('history');
						if (!empty($details)) {
							$id = base64_encode($details['customer_id']);
							
							$details = html_escape($details);
							$customer_name = isset($details['customer_name']) ? $details['customer_name'] : "";
							$customer_uniqueid = isset($details['customer_uniqueid']) ? $details['customer_uniqueid'] : "";
							$cust_type = isset($details['cust_type']) ? $details['cust_type'] : "";

							$customer_contact = isset($details['customer_contact']) ? $details['customer_contact'] : "";
							$_SESSION['number'] = $customer_contact;
							$customer_alt_contact = isset($details['customer_alt_contact']) ? $details['customer_alt_contact'] : "";
							$customer_contact_email = isset($details['customer_contact_email']) ? $details['customer_contact_email'] : "";
							$customer_contact_person = isset($details['customer_contact_person']) ? $details['customer_contact_person'] : "";
							$cust_landline = isset($details['cust_landline']) ? $details['cust_landline'] : "";
							$customer_address = isset($details['customer_address']) ? $details['customer_address'] : "";
							$customer_gstno = isset($details['customer_gstno']) ? $details['customer_gstno'] : "";
							$customer_pin = isset($details['customer_pin']) ? $details['customer_pin'] : "";
							$customer_area = isset($details['area_name']) ? $details['area_name'] : "";
							$customer_city_name = isset($details['customer_city_name']) ? $details['customer_city_name'] : "";
							$customer_dist_name = isset($details['customer_dist_name']) ? $details['customer_dist_name'] : "";
							$customer_state_name = isset($details['customer_state_name']) ? $details['customer_state_name'] : "";
							$ref_name = isset($details['ref_name']) ? $details['ref_name'] : "";
							$cust_ref_contact = isset($details['cust_ref_contact']) ? $details['cust_ref_contact'] : "";
							$cust_ref_email = isset($details['cust_ref_email']) ? $details['cust_ref_email'] : "";
							$cust_ref_name = isset($details['cust_ref_name']) ? $details['cust_ref_name'] : "";
							$cust_uidate_n = isset($details['cust_uidate_n']) ? $details['cust_uidate_n'] : "";

							$cust_model = isset($details['cust_model_name']) ? $details['cust_model_name'] : "";
							$cust_serial = isset($details['cust_serial_number']) ? $details['cust_serial_number'] : "";
							$cust_registration = isset($details['cust_registration_number']) ? $details['cust_registration_number'] : "";


							$cust_state = !empty($details['cust_state']) ? $details['cust_state'] : Null;
							$cust_dist = !empty($details['cust_dist']) ? $details['cust_dist'] : Null;
							$cust_city = !empty($details['cust_city']) ? $details['cust_city'] : Null;

							$cust_company_name = isset($details['cust_company_name']) ? $details['cust_company_name'] : "";
							$status = isset($details['cust_status']) ? $details['cust_status'] : "";
							$cust_addedbyname = isset($details['cust_addedbyname']) ? $details['cust_addedbyname'] : "";
							$cust_sdate_n = isset($details['cust_sdate_n']) ? $details['cust_sdate_n'] : "";
							$branch_name = isset($details['branch_name']) ? $details['branch_name'] : "";
							$cust_unit_no = isset($details['cust_unit_no']) ? $details['cust_unit_no'] : "";
							$cust_form_no = isset($details['cust_form_no']) ? $details['cust_form_no'] : "";
							$cust_website = isset($details['cust_website']) ? $details['cust_website'] : "";

							$cust_bank_acc_name = isset($details['cust_bank_acc_name']) ? $details['cust_bank_acc_name'] : "";
							$cust_bank_acc_number = isset($details['cust_bank_acc_number']) ? $details['cust_bank_acc_number'] : "";
							$cust_bank_branch_address = isset($details['cust_bank_branch_address']) ? $details['cust_bank_branch_address'] : "";
							$cust_bank_ifsc = isset($details['cust_bank_ifsc']) ? $details['cust_bank_ifsc'] : "";
							$cust_bank_micr = isset($details['cust_bank_micr']) ? $details['cust_bank_micr'] : "";
							$cust_bank_name = isset($details['cust_bank_name']) ? $details['cust_bank_name'] : "";

							$cust_bank_name = isset($details['cust_bank_name']) ? $details['cust_bank_name'] : "";
							$cust_panno = isset($details['cust_panno']) ? $details['cust_panno'] : "";
							$cust_id_no = isset($details['cust_id_no']) ? $details['cust_id_no'] : "";

							$cust_id_img = isset($details['cust_id_img']) ? $details['cust_id_img'] : "";
							$cust_img_path = isset($details['cust_img_path']) ? $details['cust_img_path'] : "";
							$cust_pan_img = isset($details['cust_pan_img']) ? $details['cust_pan_img'] : "";

							$cust_img_path = str_replace("getAuthApiKey", APIKEY, $cust_img_path);
							$cust_id_img = str_replace("getAuthApiKey", APIKEY, $cust_id_img);
							$cust_pan_img = str_replace("getAuthApiKey", APIKEY, $cust_pan_img);


							$actvDeactvList = isset($details['actvDeactvList']) ? $details['actvDeactvList'] : "";
							$followupList = isset($details['followupList']) ? $details['followupList'] : "";
							$billPaymentList = isset($details['billPaymentList']) ? $details['billPaymentList'] : "";
							$complaintList = isset($details['complaintList']) ? $details['complaintList'] : "";
							$subscriptionList = isset($details['subscriptionList']) ? $details['subscriptionList'] : "";
							$subscriptionServiceList = isset($details['subscriptionServiceList']) ? $details['subscriptionServiceList'] : "";
							$ticketList = isset($details['ticketList']) ? $details['ticketList'] : "";
							$expireSubsList = isset($details['expireSubsList']) ? $details['expireSubsList'] : "";
							$installmentList = isset($details['installments']) ? $details['installments'] : "";
							$pay_id = "";

							$cust_dob = isset($details['cust_dob']) ? $details['cust_dob'] : "";
							$cust_dob = !empty($cust_dob)
								? date('d-M-Y', strtotime($cust_dob))
								: "";

							$cust_remark = isset($details['cust_remark']) ? $details['cust_remark'] : "";

						?>

							<div class="col-md-6">
								<div class="portlet-title">
									<div class="caption">
										<i class="font-red-mint icon-user"></i>
										<span class="caption-subject font-red-mint sbold">Customer Details</span>
									</div>
									<hr style="margin:3px;" />
								</div>
								<div class="slimScrollDiv450">
									<table class="table table-striped table-bordered table-advance table-hover">
										<tbody>
											<tr>
												<th>Customer Name </th>
												<td><?php echo $customer_name; ?></td>
											</tr>
											<tr>
												<th width="40%">Customer ID</th>
												<td><?php echo $customer_uniqueid; ?></td>
											</tr>
											<tr>
												<th>Customer Type </th>
												<td><?php echo $cust_type; ?></td>
											</tr>
											<tr>
												<th>Company Name </th>
												<td><?php echo $cust_company_name; ?></td>
											</tr>
											<tr>
												<th>Contact No</th>
												<td><?php echo $customer_contact; ?></td>
											</tr>
											<tr>
												<th>Alternate Contact No</th>
												<td><?php echo $customer_alt_contact; ?></td>
											</tr>
											<tr>
												<th>Contact Person</th>
												<td><?php echo $customer_contact_person; ?></td>
											</tr>
											<tr>
												<th>Date of Birth</th>
												<td><?php echo $cust_dob; ?></td>
											</tr>
											<tr>
												<th>Email ID</th>
												<td><?php echo $customer_contact_email; ?></td>
											</tr>
											<tr>
												<th>Website</th>
												<td><?php echo $cust_website; ?></td>
											</tr>
											<tr>
												<th>Landline</th>
												<td><?php echo $cust_landline; ?></td>
											</tr>
											<tr>
												<th>Customer GST No</th>
												<td><?php echo $customer_gstno; ?></td>
											</tr>


											<tr>
												<th colspan="2" class="text-danger">Software Entry Details </th>
											</tr>
											<!--tr><th>Bank Name</th><td><?php echo $cust_bank_name; ?></td>	</tr>
							<tr><th>Bank Account Name</th><td><?php echo $cust_bank_acc_name; ?></td>	</tr>
							<tr><th>Bank A/C No.</th><td><?php echo $cust_bank_acc_number; ?></td>	</tr>
							<tr><th>Bank Branch</th><td><?php echo $cust_bank_branch_address; ?></td>	</tr>
							<tr><th>Bank IFSC</th><td><?php echo $cust_bank_ifsc; ?></td>	</tr>
							<tr><th>Bank MICR</th><td><?php echo $cust_bank_micr; ?></td>	</tr-->
											<tr>
												<th>Status </th>
												<td> <?php if ($status == "Active") {
															echo "<span class='label label-success'>Active</span>";
														} else if ($status == "Deactivated") {
															echo "<span class='label label-danger'>Deactivated</span>";
														} else {
															echo "<span class='label label-warning'>" . $status . "</span>";
														} ?>

												</td>
											</tr>
											<tr>
												<th>Added By </th>
												<td><?php echo $cust_addedbyname; ?></td>
											</tr>
											<tr>
												<th>Software Entry Date </th>
												<td><?php echo $cust_sdate_n; ?></td>
											</tr>
											<tr>
												<th>Customer Start Date</th>
												<td><?php echo $cust_uidate_n; ?></td>
											</tr>
											<?php if (!empty($actvDeactvList)) { ?>
												<tr>
													<th colspan="2" class="text-danger">Status Details </th>
												</tr>
												<?php if (!empty($actvDeactvList[0]['cust_ad_deactive_by_name'])) { ?>
													<tr>
														<th>Deactivated By </th>
														<td><?php echo isset($actvDeactvList[0]['cust_ad_deactive_by_name']) ? $actvDeactvList[0]['cust_ad_deactive_by_name'] : ""; ?>
														</td>
													</tr>
													<tr>
														<th>Deactivated On </th>
														<td><?php echo isset($actvDeactvList[0]['cust_ad_deactive_date_n']) ? $actvDeactvList[0]['cust_ad_deactive_date_n'] : ""; ?>
														</td>
													</tr>
													<tr>
														<th>Deactivated Reason </th>
														<td><?php echo isset($actvDeactvList[0]['cust_ad_deactive_reasn']) ? $actvDeactvList[0]['cust_ad_deactive_reasn'] : ""; ?>
														</td>
													</tr>
												<?php } ?>

												<?php if (!empty($actvDeactvList[0]['cust_ad_reactive_by_name'])) { ?>
													<tr>
														<th>Re-Activated By </th>
														<td><?php echo isset($actvDeactvList[0]['cust_ad_reactive_by_name']) ? $actvDeactvList[0]['cust_ad_reactive_by_name'] : ""; ?>
														</td>
													</tr>
													<tr>
														<th>Re-Activated On </th>
														<td><?php echo isset($actvDeactvList[0]['cust_ad_reactive_date_n']) ? $actvDeactvList[0]['cust_ad_reactive_date_n'] : ""; ?>
														</td>
													</tr>
													<tr>
														<th>Re-Activated Reason </th>
														<td><?php echo isset($actvDeactvList[0]['cust_ad_reactive_reasn']) ? $actvDeactvList[0]['cust_ad_reactive_reasn'] : ""; ?>
														</td>
													</tr>
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
									<hr style="margin:3px;" />
								</div>
								<div class="slimScrollDiv450">
									<table class="table table-striped table-bordered table-advance table-hover">
										<tbody>
											<!-- <?php if (!empty($details['contactList'])) { ?>
												<tr>
													<th colspan="2" class="text-danger"> Alternate Contact Details </th>
												</tr>
												<tr>
													<td colspan="2">
														<table
															class="table table-striped table-bordered table-advance table-hover">
															<tbody>
																<tr>
																	<th>Sr.No.</th>
																	<th>Contact Person</th>
																	<th>Contact No</th>
																	<th>Email Id</th>
																</tr>
																<?php foreach ($details['contactList'] as $key => $contact) { ?>
																	<tr>
																		<td><?php echo $key + 1; ?> </td>
																		<td><?php echo $contact['cust_contact_person']; ?> </td>
																		<td><?php echo $contact['cust_contact_no']; ?> </td>
																		<td><?php echo $contact['cust_contact_emailid']; ?> </td>
																	</tr>
																<?php } ?>
															</tbody>
														</table>
													</td>
												</tr>
											<?php } ?> -->


											<tr>
												<th colspan="2" class="text-danger"> Address Details </th>
											</tr>
											<tr>
												<th width="30%"> Address </th>
												<td><?php echo $customer_address; ?> </td>
											</tr>
											<tr>
												<th> Pincode </th>
												<td><?php echo $customer_pin; ?> </td>
											</tr>
											<tr>
												<th> Area </th>
												<td><?php echo $customer_area; ?> </td>
											</tr>
											<tr>
												<th> City </th>
												<td><?php echo $customer_city_name; ?>
											</tr>
											<tr>
												<th> District </th>
												<td><?php echo $customer_dist_name; ?>
											</tr>
											<tr>
												<th> State </th>
												<td><?php echo $customer_state_name; ?>
											</tr>

											</td>
											</tr>

											<?php if (!empty($details['contactList'])) { ?>
												<tr>
													<td colspan="2" style="padding:0;border:none;">
														<div style="padding:8px 8px;background:#f5f5f5;border-bottom:1px solid #ddd;">
															<span style="font-size:14px;font-weight:bold;color:#dc3545;">
																Alternate Contact Details
															</span>
														</div>
														<div class="card-body p-0">
															<div class="table-responsive">
																<table class="table table-hover table-bordered mb-0" style="table-layout:fixed;width:100%;">
																	<thead>
																		<tr style="background:#f8f9fa;">
																			<!-- <th style="width:45px;text-align:center;">Sr.no</th> -->
																			<th style="width: 140px;">Contact Person</th>
																			<th style="width:95px;">Contact No</th>
																			<th>Email ID</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php foreach ($details['contactList'] as $key => $contact) { ?>
																			<tr>
																				<!-- <td style="text-align:center;">
                                        <?= $key + 1 ?>
                                    </td> -->

																				<td style="word-break:break-word;white-space:normal;">
																					<?= $contact['cust_contact_person'] ?>
																				</td>

																				<td>
																					<?= $contact['cust_contact_no'] ?>
																				</td>

																				<td style="word-break:break-word;white-space:normal;">
																					<?= $contact['cust_contact_emailid'] ?>
																				</td>
																			</tr>
																		<?php } ?>
																	</tbody>
																</table>
															</div>
														</div>

								</div>
								</td>
								</tr>
							<?php } ?>

							<tr>
								<th colspan="2" class="text-danger"> Reference Details </th>
							</tr>
							<tr>
								<th> Reference By </th>
								<td><?php echo $ref_name; ?> </td>
							</tr>
							<tr>
								<th> Reference Name </th>
								<td><?php echo $cust_ref_name; ?> </td>
							</tr>
							<tr>
								<th> Referral Contact </th>
								<td><?php echo $cust_ref_contact; ?> </td>
							</tr>
							<tr>
								<th> Referral Email </th>
								<td><?php echo $cust_ref_email; ?> </td>
							</tr>
							<!-- </td></tr><tr><th colspan="2" class="text-danger"> Vehicle Details </th></tr>
						<tr><th> Model Name </th><td><?php echo $cust_model; ?> </td></tr>
						<tr><th> Serial Number </th><td><?php echo $cust_serial; ?> </td></tr>
						<tr><th> Registration Number </th><td><?php echo $cust_registration; ?> </td></tr> -->
							</td>
							</tr>
							<tr>
								<th colspan="2" class="text-danger"> Other Details </th>
							</tr>
							<tr>
								<th> Branch </th>
								<td><?php echo $branch_name; ?> </td>
							</tr>
							<!-- <tr>
												<th> Unit No. </th>
												<td><?php echo $cust_unit_no; ?> </td>
											</tr>
											<tr>
												<th> Form No. </th>
												<td><?php echo $cust_form_no; ?> </td>
											</tr> -->
							<?php if (!empty($details['branch_details'])) {
								$branch_details = $details['branch_details'];
							?>
								<tr>
									<th colspan="2" class="text-danger"> Branch Details</th>
								</tr>
								<tr>
									<th> Branch Name </th>
									<td><?php echo isset($branch_details['branch_name']) ? $branch_details['branch_name'] : ""; ?>
									</td>
								</tr>
								<tr>
									<th> Branch Contact </th>
									<td><?php echo isset($branch_details['branch_contact']) ? $branch_details['branch_contact'] : ""; ?>
									</td>
								</tr>
								<tr>
									<th> Branch Address </th>
									<td><?php echo isset($branch_details['branch_address']) ? $branch_details['branch_address'] : ""; ?>
									</td>
								</tr>
							<?php } ?>
							</tbody>
							</table>
							</div>
					</div>
					<?php if (!empty($subscriptionList)) { ?>
						<div class="col-md-12">
							<div class="portlet-title">
								<br />
								<div class="caption">
									<i class="font-red-mint icon-check"></i>
									<span class="caption-subject font-red-mint sbold">All Service Details</span>
								</div>
								<hr style="margin:5px;" />
							</div>

							<div class="followuptbl"
								style="overflow-y:auto; overflow-x:hidden; max-height:155px; height:auto;">
								<table class="table table-striped table-bordered display"
									style="width:100%; table-layout:fixed;">
									<tr style=" position: sticky; top: 0; z-index: 1; background-color: #fff;"
										class="success">
										<th style="width:6%;">Sr.No.</th>
										<th style="width:50%;">Name</th>
										<th style="width:12%;">Start Date </th>
										<th style="width:12%;">End Date</th>
										<th style="width:10%;">Status</th>
										<th style="width:10%;">Action</th>
									</tr>

									<tbody>
										<?php foreach ($subscriptionList as $key => $subserv) {
											$cust_subs_cbpmid = $subserv['cust_subs_cbpmid'];
											$sub_id = $subserv['cust_subs_id'];
											$cust_subs_custid = $subserv['cust_subs_custid'];
											// $str = "?cust_id=" . base64_encode($cust_subs_custid) . "&sub_id=" . base64_encode($sub_id);
											$cust_name = isset($customer_name) ? $customer_name : "";

											$str = "?cust_id=" . base64_encode($cust_subs_custid) .
												"&sub_id=" . base64_encode($sub_id) .
												"&cust_name=" . urlencode(base64_encode($cust_name));
										?>
											<tr>
												<td><?php echo $key + 1; ?> </td>
												<td><?php echo $subserv['cust_subs_type_name']; ?> </td>
												<td><?php echo $subserv['cust_subs_startdate_n']; ?></td>
												<td><?php echo $subserv['cust_subs_enddate_n']; ?></td>
												<td> <?php if ($subserv['cust_subs_status'] == "Active") {
															echo "<span class='label label-success'>Active</span>";
														} else if ($subserv['cust_subs_status'] == "Deactivated") {
															echo "<span class='label label-danger'>Deactivated</span>";
														} else {
															echo "<span class='label label-warning'>" . $subserv['cust_subs_status'] . "</span>";
														} ?> </td>
												<td> <a class="btn btn-primary btn-xs"
														href="<?php echo get_module_path(); ?>customers/view_customer_subscriptions/<?php echo $str; ?>"
														title="View Details" data-toggle="modal"
														data-target="#form_modal_lg"><i class="fa fa-eye"></i></a>
													<?php if (!empty($billPaymentList)) {
														$cbpm_billno = $billPaymentList[0]['CBPM_ID']; ?>
														<!-- <?php if (empty($installmentList)) { ?>
						<a  class="btn btn-danger btn-xs"  href="<?php echo get_module_path(); ?>customers/download_invoice_single/?ref_id=<?php echo $id; ?>&billno=<?php echo $cbpm_billno; ?>&cust_subs_cbpmid=<?php echo $cust_subs_cbpmid; ?>" title="Download Invoice" ><i class="fa fa-download"></i></a>  
						 <?php } ?> -->


													<?php } ?>
												</td>
											</tr>
										<?php } ?>


									</tbody>

								</table>
							</div>


						<?php } ?>




						<?php if (!empty($subscriptionServiceList)) { ?>

							<div class="col-md-12" style="padding-left:0; padding-right:0;">
								<div class="portlet-title" style="margin-bottom:8px;">
									<br />
									<div class="caption">
										<i class="font-red-mint icon-wrench"></i>
										<span class="caption-subject font-red-mint sbold">Active Service Details</span>
									</div>
									<!-- <hr style="margin:3px;"/> -->
								</div>
								<?php foreach ($subscriptionServiceList as $subscription) { ?>

									<table class="table table-condensed table-hover">
										<tbody>
											<tr>
												<th width="20%"> Service Name </th>
												<td width="30%">
													<?php echo isset($subscription['cust_subs_type_name']) ? $subscription['cust_subs_type_name'] : ""; ?>
												</td>
												<th> Service Type </th>
												<td><?php echo isset($subscription['cust_subs_type']) ? $subscription['cust_subs_type'] : ""; ?>
												</td>
												<?php if (isset($subscription['cust_subs_type']) && $subscription['cust_subs_type'] !== "One Time Service") { ?>
													<th> Services Duration </th>
													<td><?php echo isset($subscription['cust_subs_duration']) ? $subscription['cust_subs_duration'] : ""; ?>
													</td>
												<?php } else { ?>
													<th> </th>
													<th> </th>
												<?php } ?>
											</tr>

											<tr>
												<th> Total Price </th>
												<td><?php echo isset($subscription['cust_subs_price']) ? $subscription['cust_subs_price'] : ""; ?>
												</td>
												<th> Start Date </th>
												<td><?php echo isset($subscription['cust_subs_startdate_n']) ? $subscription['cust_subs_startdate_n'] : ""; ?>
												</td>
												<th>End Date </th>
												<td><?php echo isset($subscription['cust_subs_enddate_n']) ? $subscription['cust_subs_enddate_n'] : ""; ?>
												</td>
											</tr>
											<?php if (isset($subscription['cust_subs_type']) && $subscription['cust_subs_type'] !== "One Time Service") { ?>
												<tr>
													<th>Services Done</th>
													<td><?php echo isset($subscription['cust_subs_noofserv_done']) ? $subscription['cust_subs_noofserv_done'] : ""; ?>
													</td>
													<th>Remaining Services </th>
													<td><?php echo isset($subscription['cust_subs_noofserv_remining']) ? $subscription['cust_subs_noofserv_remining'] : ""; ?>
													</td>
													<th>No Of Services </th>
													<td><?php echo isset($subscription['cust_subs_noofserv']) ? $subscription['cust_subs_noofserv'] : ""; ?>
													</td>
												</tr>
											<?php } ?>
										</tbody>


									</table>




									<?php if (!empty($subscription['serviceList'])) { ?>
										<div class="followuptbl"
											style="overflow: auto;-webkit-overflow-scrolling: touch;margin-bottom:10px; max-height: 160px; height:auto;">
											<table class="table table-striped table-bordered  " role="grid"
												aria-describedby="sample_1_info">
												<tr class="success"
													style=" position: sticky; top: 0; z-index: 1; background-color: #fff;"
													class="success">
													<th width="7%">Sr. No.</th>
													<th width="15%">Service Dates </th>
													<th width="10%">Status </th>
													<th width="10%">Ticket ID</th>
													<th width="12%">Done On</th>
													<th width="15%">Action</th>
												</tr>

												<tbody>
													<?php foreach ($subscription['serviceList'] as $key => $serv) {
														$cust_serv_id = base64_encode($serv['cust_serv_id']);
													?>
														<tr>
															<td><?php echo $key + 1; ?> </td>
															<td><?php echo $serv['cust_serv_date_n']; ?> </td>
															<td><?php echo $serv['cust_serv_status']; ?></td>
															<td><?php if (!empty($serv['ticket_id'])) { ?>
																	<a
																		href="<?php echo get_module_path(); ?>customers/view_ticket/?id=<?php echo base64_encode($serv['ticket_id']); ?>&history=back"><?php echo $serv['ticket_id']; ?></a>
																<?php } ?>
															</td>
															<td><?php echo $serv['cust_serv_doneondate_n']; ?></td>
															<td nowrap>

																<a href="<?php echo get_module_path(); ?>customers/schedule_service_ticket/?id=<?php echo $id; ?>&serv_id=<?php echo $cust_serv_id; ?>"
																	class="btn btn-success btn-xs"
																	title="Click To Schedule">
																	<i class="fa fa-clock-o"></i> Schedule
																</a>

																<?php if ($serv['cust_serv_done_status'] == 'Close') { ?>

																	<span class="label label-success" style="margin-left:5px;">
																		<i class="fa fa-check-circle"></i> Completed
																	</span>

																<?php } else { ?>

																	<button type="button"
																		class="btn btn-danger btn-xs"
																		style="margin-left:5px;"
																		onclick="openCompleteServiceModal('<?php echo $serv['cust_serv_id']; ?>')">

																		<i class="fa fa-times-circle"></i> Cancel Service

																	</button>

																<?php } ?>

															</td>
														</tr>
													<?php } ?>



												</tbody>
											</table>
										</div>
									<?php } ?>

								<?php } ?>


							<?php } ?>
							<?php if (!empty($expireSubsList)) { ?>
								<div class="col-md-12">
									<div class="portlet-title">
										<br />
										<div class="caption">
											<i class="font-red-mint  icon-close"></i>
											<span class="caption-subject font-red-mint sbold">Expired Service
												Details</span>
										</div>
										<hr style="margin:3px;" />
									</div>
									<div class="followuptbl"
										style="overflow: auto;-webkit-overflow-scrolling: touch;margin-bottom:10px; max-height: 160px; height:auto;">
										<table class="table table-striped table-bordered  " role="grid"
											aria-describedby="sample_1_info">
											<tbody>
												<tr class="success">
													<th>Sr. No.</th>
													<th>Name</th>
													<th>Start Date </th>
													<th>End Date</th>
													<th>Price</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
												<?php foreach ($expireSubsList as $key => $subserv2) {
													$sub_id = $subserv2['cust_subs_id'];
													$cust_subs_custid = $subserv2['cust_subs_custid'];
													$str = "?cust_id=" . base64_encode($cust_subs_custid) . "&sub_id=" . base64_encode($sub_id) . "&status=" . "Expired";
												?>
													<tr>
														<td><?php echo $key + 1; ?> </td>
														<td><?php echo $subserv2['cust_subs_type_name']; ?> </td>
														<td><?php echo $subserv2['cust_subs_startdate_n']; ?></td>
														<td><?php echo $subserv2['cust_subs_enddate_n']; ?></td>
														<td><?php echo $subserv2['cust_subs_price']; ?></td>
														<td> <?php if ($subserv2['cust_subs_status'] == "Active") {
																	echo "<span class='label label-success'>Active</span>";
																} else if ($subserv2['cust_subs_status'] == "Expired") {
																	echo "<span class='label label-danger'>Expired</span>";
																} else {
																	echo "<span class='label label-warning'>" . $subserv2['cust_subs_status'] . "</span>";
																} ?> </td>

														<td> <a class="btn btn-primary btn-xs"
																href="<?php echo get_module_path(); ?>customers/view_customer_subscriptions/<?php echo $str; ?>"
																title="View Details" data-toggle="modal"
																data-target="#form_modal_lg"><i class="fa fa-eye"></i></a>
															<?php if (!empty($billPaymentList)) {
																$cbpm_billno = $billPaymentList[0]['cbpm_billno']; ?>
																<a class="btn btn-danger btn-xs"
																	href="<?php echo get_module_path(); ?>customers/download_invoice_single/?ref_id=<?php echo $id; ?>&billno=<?php echo $cbpm_billno; ?>&cust_subs_cbpmid=<?php echo $cust_subs_cbpmid; ?>"
																	title="Download Invoice"><i class="fa fa-download"></i></a>
															<?php } ?>
														</td>

													</tr>
												<?php } ?>


											</tbody>
										</table>
									</div>
								<?php } ?>

								<?php if (!empty($ticketList)) { ?>
									<div class="col-md-12" style="padding-left:0; padding-right:0;">
										<div class="portlet-title">
											<br />
											<div class="caption">
												<i class="font-red-mint icon-note"></i>
												<span class="caption-subject font-red-mint sbold">Ticket Details</span>
											</div>
											<hr style="margin:3px;" />
										</div>
										<div class="followuptbl"
											style="overflow: auto;-webkit-overflow-scrolling: touch;margin-bottom:10px; max-height: 160px; height:auto;">
											<table class="table table-striped table-bordered  " role="grid"
												aria-describedby="sample_1_info">

												<tr class="success">
													<th width="7%">Sr. No.</th>
													<th>Ticket ID</th>
													<th>Title </th>
													<th>Priority</th>
													<th width="15%">Ticket Date </th>
													<th width="15%">Status</th>
												</tr>

												<tbody>
										</div>
										<?php foreach ($ticketList as $key => $tickett) { ?>
											<tr>
												<td><?php echo $key + 1; ?></td>
												<td><?php if (!empty($tickett['ticket_id'])) { ?>
														<a
															href="<?php echo get_module_path(); ?>customers/view_ticket/?id=<?php echo base64_encode($tickett['ticket_id']); ?>&history=back"><?php echo $tickett['ticket_id']; ?></a>
													<?php } ?>
												</td>
												<td><?php echo isset($tickett['ticket_title']) ? $tickett['ticket_title'] : ""; ?>
												</td>
												<!--td><?php echo isset($tickett['ticket_desc']) ? $tickett['ticket_desc'] : ""; ?> </td>
								<td><?php echo isset($tickett['tkt_type_name']) ? $tickett['tkt_type_name'] : ""; ?> </td-->
												<td><?php echo isset($tickett['ticket_priority']) ? $tickett['ticket_priority'] : ""; ?>
												</td>
												<td><?php echo isset($tickett['tkt_sdate_n']) ? $tickett['tkt_sdate_n'] : ""; ?>
												</td>
												<td><?php if ($tickett['ticket_status'] == "Open") {
														echo "<span class='label label-success'>Open</span>";
													} else if ($tickett['ticket_status'] == "Closed") {
														echo "<span class='label label-danger'>Closed</span>";
													} else {
														echo "<span class='label label-warning'>" . $tickett['ticket_status'] . "</span>";
													} ?></td>
											</tr>

										<?php } ?>
										</tbody>
										</table>
									</div>
								<?php } ?>



								<?php if (!empty($complaintList)) { ?>
									<div class="col-md-12" style="padding: 0px">
										<div class="portlet-title">
											<br />
											<div class="caption">
												<i class="font-red-mint icon-notebook"></i>
												<span class="caption-subject font-red-mint sbold">Complaint Ticket
													Details</span>
											</div>
											<hr style="margin:3px;" />
										</div>


										<div class="followuptbl"
											style="overflow-y:auto; overflow-x:auto; -webkit-overflow-scrolling: touch; margin-bottom:0; <?php echo (count($complaintList) > 2) ? 'max-height:230px;' : ''; ?>">
											<table class="table table-striped table-bordered  " role="grid"
												aria-describedby="sample_1_info" style="margin-bottom:0;">
												<tbody>
													<tr class="success">
														<th width="7%">Sr. No.</th>
														<th>Complaint ID </th>
														<th>Ticket ID</th>
														<th>Complaint Title</th>
														<th width="12%">Created On</th>
														<th>Status</th>
													</tr>
													<?php foreach ($complaintList as $key => $ticket) { ?>
														<tr>
															<td><?php echo $key + 1; ?> </td>
															<td><?php if (!empty($ticket['ticket_id'])) { ?>
																	<a
																		href="<?php echo get_module_path(); ?>customers/view_complaint/?id=<?php echo base64_encode($ticket['ticket_id']); ?>&history=back"><?php echo $ticket['ticket_id']; ?></a>
																<?php } ?>
															</td>
															<td><?php if (!empty($ticket['created_ticket_id'])) { ?>
																	<a
																		href="<?php echo get_module_path(); ?>customers/view_ticket//?id=<?php echo base64_encode($ticket['created_ticket_id']); ?>&history=back"><?php echo $ticket['created_ticket_id']; ?></a>
																<?php } ?>
															</td>
															<td><?php echo $ticket['ticket_title']; ?></td>
															<td><?php echo $ticket['tkt_sdate_n']; ?></td>

															<td>
																<?php if ($ticket['ticket_status'] == "Open") {
																	echo "<span class='label label-success'>Open</span>";
																} else if ($ticket['ticket_status'] == "Closed") {
																	echo "<span class='label label-danger'>Closed</span>";
																} else {
																	echo "<span class='label label-warning'>" . $ticket['ticket_status'] . "</span>";
																} ?>
															</td>
														</tr>
													<?php } ?>


												</tbody>
											</table>
										</div>
									<?php } ?>

									<?php if (!empty($billPaymentList)) { ?>
										<?php
										if (!empty($billPaymentList)) {
											$billPaymentList = array_reverse($billPaymentList); // Latest first
										}
										?>

										<?php foreach ($billPaymentList as $bkey => $bill) {

											$cbpm_billno1 = $bill['cbpm_billno'];
										?>

											<!-- ================= PAYMENT DETAILS ================= -->
											<div class="col-md-12" style="padding-left:0; padding-right:0;">


												<div class="portlet-title" style="overflow:hidden; margin-bottom:10px;">
													<br />
													<div class="caption pull-left">
														<i class="font-red-mint icon-wallet"></i>
														<span class="caption-subject font-red-mint sbold">
															Payment Details - Invoice <?php echo $bill['cbpm_billno']; ?>
														</span>
													</div>

													<!-- <div class="pull-right">
																<a class="btn btn-primary btn-sm"
																	href="<?php echo get_module_path(); ?>customers/download_invoice/?ref_id=<?php echo $id; ?>&billno=<?php echo $bill['cbpm_id']; ?>"
																	title="Download Invoice">
																	<i class="fa fa-download"></i> Download Invoice
																</a>
															</div> -->
													<div class="pull-right">

														<!-- Download Button -->
														<a class="btn btn-primary btn-sm"
															href="<?php echo get_module_path(); ?>customers/download_invoice/?ref_id=<?php echo $id; ?>&billno=<?php echo base64_encode($bill['cbpm_id']); ?>"
															title="Download Invoice">
															<i class="fa fa-download"></i> Download Invoice
														</a>

														<!-- WhatsApp Button (ONLY if credit > 0) -->
														<a class="btn btn-success btn-sm" style="margin-left:5px;"

															<?php if ($has_whatsapp_account && $whatsapp_count > 0) { ?>

															href="<?php echo get_module_path() . 'customers/send_download_invoice/?ref_id=' . $id . '&billno=' . base64_encode($bill['cbpm_id']); ?>"

															<?php } else { ?>

															href="javascript:void(0);"
															data-toggle="modal"
															data-target="#confirm-whatsapp"
															data-message="<?php
																			if (!$has_whatsapp_account) {
																				echo 'WhatsApp service is not enabled for your account. Please contact MIBtrack administration for activation.';
																			} else {
																				echo 'Your WhatsApp message credits have been exhausted. Please contact MIBtrack support team.';
																			}
																			?>"

															<?php } ?>

															title="Send Invoice on WhatsApp">

															<i class="fa fa-whatsapp"></i>
														</a>

													</div>


												</div>

												<!-- <table class="table table-condensed table-hover">
															<tbody>
																<tr>
																	<th width="20%">Invoice No</th>
																	<td><?php echo $bill['cbpm_billno']; ?></td>

																	<th>Package Amount</th>
																	<td><?php echo $bill['cbpm_amount_nogst']; ?></td>

																	<th>Total Amount</th>
																	<td><?php echo $bill['cbpm_total_amnt']; ?></td>
																</tr>

																<tr>
																	<th>Received Payment</th>
																	<td><?php echo $bill['cbpm_received_amnt']; ?></td>

																	<th>Balance Payment</th>
																	<td><?php echo $bill['cbpm_balance_amnt']; ?></td>

																	<th>Discount</th>
																	<td>
																		<?php
																		$disc = isset($bill['cbpm_adjustmentamnt']) ? $bill['cbpm_adjustmentamnt'] : 0;
																		echo ($disc < 0 ? 0 : $disc);
																		?>
																	</td>
																</tr>

																<tr>
																	<th>GST</th>
																	<td><?php echo $bill['gstAmount']; ?></td>

																	<th>GST Type</th>
																	<td><?php echo $bill['cbpm_gsttype']; ?></td>

																	
																</tr>

															</tbody>
														</table> -->

												<div class="table-responsive"
													style="overflow-x:auto; -webkit-overflow-scrolling:touch;">

													<table class="table table-hover table-bordered"
														style="margin-bottom:0; width:100%;">

														<tbody>

															<tr>

																<th style="white-space:nowrap; width=18px;">Invoice No</th>

																<td style="min-width=13px;">
																	<?php echo $bill['cbpm_billno']; ?>
																</td>

																<th style="white-space:nowrap; width=18px;">Package Amount</th>

																<td style="min-width=13px;">
																	<?php echo $bill['cbpm_amount_nogst']; ?>
																</td>

																<th style="white-space:nowrap; width=18px;">Total Amount</th>

																<td style="min-width=13px;">
																	<?php echo $bill['cbpm_total_amnt']; ?>
																</td>

															</tr>

															<tr>

																<th style="white-space:nowrap;">Received Payment</th>

																<td>
																	<?php echo $bill['cbpm_received_amnt']; ?>
																</td>

																<th style="white-space:nowrap;">Balance Payment</th>

																<td>
																	<?php echo $bill['cbpm_balance_amnt']; ?>
																</td>

																<th style="white-space:nowrap;">Discount</th>

																<td>
																	<?php
																	$disc = isset($bill['cbpm_adjustmentamnt']) ? $bill['cbpm_adjustmentamnt'] : 0;
																	echo ($disc < 0 ? 0 : $disc);
																	?>
																</td>

															</tr>

															<tr>

																<th style="white-space:nowrap;">GST</th>

																<td>
																	<?php echo $bill['gstAmount']; ?>
																</td>

																<th style="white-space:nowrap;">GST Type</th>

																<td>
																	<?php echo $bill['cbpm_gsttype']; ?>
																</td>

																<th></th>

																<td></td>

															</tr>

														</tbody>

													</table>

												</div>


											</div>
											<!-- =================================================== -->



											<!-- ================= INSTALLMENT LIST ================= -->
											<?php if (!empty($bill['installmentList'])) { ?>

												<div class="portlet-title">
													<br />
													<div class="caption">
														<i class="font-red-mint icon-wallet"></i>
														<span class="caption-subject font-red-mint sbold">Payment
															Installments</span>
													</div>
													<hr style="margin:3px;" />
												</div>

												<div class="followuptbl" style="overflow:auto; max-height:160px; height:auto;">
													<table class="table table-striped table-bordered">
														<thead>
															<tr class="success" style="position: sticky; top: 0; z-index: 1;">
																<th>Sr. No.</th>
																<th>Installment Date</th>
																<th>Installment Amount</th>
																<th>Status</th>
																<th>Action</th>
															</tr>
														</thead>

														<tbody>
															<?php foreach ($bill['installmentList'] as $ikey => $inst) { ?>
																<tr>
																	<td><?php echo $ikey + 1; ?></td>
																	<td><?php echo $inst['cbpi_pay_next_date']; ?></td>
																	<td><?php echo $inst['cbpi_pay_next_amount']; ?></td>

																	<td>
																		<?php
																		if ($inst['cbpi_status'] == "Paid")
																			echo "<span class='label label-success'>Paid</span>";
																		elseif ($inst['cbpi_status'] == "Unpaid")
																			echo "<span class='label label-warning'>Pending</span>";
																		else
																			echo "<span class='label label-danger'>Overdue</span>";
																		?>
																	</td>

																	<td>
																		<?php
																		$inst_id = base64_encode($inst['cbpi_id']);
																		$billno = base64_encode($inst['cbpi_bill_no']);
																		// $billno = $bill['cbpm_billno'];
																		?>

																		<?php if (!empty($inst['cbpi_bill_no'])) { ?>
																			<a class="btn btn-primary btn-sm"
																				href="<?php echo get_module_path(); ?>customers/download_invoice_installment/?ref_id=<?php echo $id; ?>&billno=<?php echo base64_encode($inst['cbpi_bill_no']); ?>&instId=<?php echo $inst_id; ?>&pay_next_date=<?php echo urlencode($inst['cbpi_pay_next_date']); ?>&pay_next_amount=<?php echo urlencode($inst['cbpi_pay_next_amount']); ?>">
																				<i class="fa fa-download"></i>
																			</a>
																		<?php } else { ?>
																			<a class="btn btn-success btn-sm"
																				href="<?php echo get_module_path(); ?>customers/create_invoice/?ref_id=<?php echo $id; ?>&instId=<?php echo $inst_id; ?>">
																				<i class="fa fa-file"></i> Create Invoice
																			</a>
																		<?php } ?>
																	</td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>

											<?php } ?>
											<!-- =================================================== -->


											<hr style="border:2px solid #ddd;margin:20px 0;">

										<?php } // end foreach 
										?>

									<?php } // end if 
									?>


									<!-- ================================================= -->
									<?php $allPayments = [];

									foreach ($billPaymentList as $bill) {

										if (!empty($bill['paymentList'])) {

											foreach ($bill['paymentList'] as $pay) {

												// Add invoice number inside payment
												$pay['invoice_no'] = $bill['cbpm_billno'];

												// Push into main array
												$allPayments[] = $pay;
											}
										}
									} ?>

									<!-- ================================================= -->




									<?php if (!empty($allPayments)) { ?>


										<div class="portlet-title" style="margin-bottom:8px;">
											<div class="caption">
												<i class="font-red-mint icon-wallet"></i>
												<span class="caption-subject font-red-mint sbold">
													All Payment History
												</span>

											</div>

										</div>

										<div class="followuptbl " style="overflow:auto; max-height:250px;  height:auto;">
											<table class="table table-bordered table-striped">
												<thead>
													<tr class="success">
														<th>Sr</th>
														<th>Invoice No</th>
														<th>Receipt No</th>
														<th>Bill Book No</th>
														<th>Paid Date</th>
														<th>Amount</th>
														<th>Pay Mode</th>
														<th>Chq/Card No</th>
														<th>Bank Details</th>
														<th>Status</th>
														<th width="10%">Action</th>
													</tr>
												</thead>

												<tbody>
													<?php foreach ($allPayments as $key => $pay) { ?>
														<tr>
															<td><?= $key + 1 ?></td>
															<td><?= $pay['invoice_no'] ?></td>
															<td><?= $pay['cp_receiptno'] ?></td>
															<td><?= $pay['cp_uibillno'] ?></td>
															<td><?= $pay['cp_udate_n'] ?></td>
															<td><?= $pay['cp_amount'] ?></td>
															<td><?= $pay['cp_paytype'] ?></td>
															<td><?php echo $pay['cp_chq_no']; ?></td>
															<td><?php echo $pay['cp_chq_bankname']; ?></td>

															<td>
																<?php
																if ($pay['cp_status'] == "Paid")
																	echo "<span class='label label-success'>Paid</span>";
																elseif ($pay['cp_status'] == "Closed" || $pay['cp_status'] == "Cancel")
																	echo "<span class='label label-danger'>{$pay['cp_status']}</span>";
																else
																	echo "<span class='label label-warning'>{$pay['cp_status']}</span>";
																?>
															</td>

															<td>

																<?php
																// Decide form action
																$action = "";
																$formName = "";

																if ($pay['cp_status'] == "Pending" && $pay['cp_paytype'] == "Cheque") {
																	$action = "clear_cheque";
																	$formName = "clear_cheque_form_$key";
																} elseif ($pay['cp_status'] == "Pending" && $pay['cp_paytype'] == "Online") {
																	$action = "clear_online_payment";
																	$formName = "clear_online_pay_$key";
																} elseif ($pay['cp_status'] == "Paid") {
																	$action = "cancel_payment";
																	$formName = "cancel_payment_form_$key";
																}
																?>

																<form
																	action="<?= get_module_path(); ?>customers/<?= $action; ?>"
																	method="post" name="<?= $formName; ?>"
																	id="form_<?= $key; ?>">

																	<input type="hidden" name="cust_id"
																		value="<?= base64_encode($pay['cp_custid']); ?>">
																	<input type="hidden" name="cbpm_id"
																		value="<?= $pay['cp_cbpmid']; ?>">
																	<input type="hidden" name="billno"
																		value="<?= $pay['cp_billno']; ?>">
																	<input type="hidden" name="receiptno"
																		value="<?= $pay['cp_receiptno']; ?>">
																	<input type="hidden" name="cp_id"
																		value="<?= $pay['cp_id']; ?>">

																	<?php if ($pay['cp_status'] == "Pending" && $pay['cp_paytype'] == "Cheque") { ?>
																		<a data-toggle="modal" data-id="form_<?= $key ?>"
																			data-target="#confirm-clear"
																			data-href="javascript:document.clear_cheque_form_<?= $key ?>.submit()"
																			class="btn btn-success btn-xs">Clear Cheque</a>
																	<?php } ?>

																	<?php if ($pay['cp_status'] == "Pending" && $pay['cp_paytype'] == "Online") { ?>
																		<a data-toggle="modal" data-id="form_<?= $key ?>"
																			data-target="#confirm-clear-payment"
																			data-href="javascript:document.clear_online_pay_<?= $key ?>.submit()"
																			class="btn btn-success btn-xs">Clear Payment</a>
																	<?php } ?>

																	<?php if ($pay['cp_status'] == "Paid") { ?>
																		<a data-toggle="modal" data-id="form_<?= $key ?>"
																			data-target="#confirm-cancel"
																			data-href="javascript:document.cancel_payment_form_<?= $key ?>.submit()"
																			class="btn btn-danger btn-xs">Cancel</a>
																	<?php } ?>

																</form>

															</td>
														</tr>
													<?php } ?>

												</tbody>
											</table>
										</div>

									<?php } ?>


									<!-- ================================================= -->



									<!-- ================= INSTALLMENT LIST ================= -->

									<?php
									$allInstallment = [];

									foreach ($installment as $bill) {

										if (!empty($bill['installments'])) {

											foreach ($bill['installments'] as $inst) {

												// Add invoice number inside installment
												$inst['invoice_no'] = $bill['cbpm_billno'];

												$allInstallment[] = $inst;
											}
										}
									}
									?>


									<?php if (!empty($allInstallment)) { ?>

										<div class="portlet-title">
											<br />
											<div class="caption">
												<i class="font-red-mint icon-wallet"></i>
												<span class="caption-subject font-red-mint sbold">Payment
													Installments</span>
											</div>
											<hr style="margin:3px;" />
										</div>

										<div class="followuptbl" style="overflow:auto; max-height:160px; height:auto;">
											<table class="table table-striped table-bordered">
												<thead>
													<tr class="success" style="position: sticky; top: 0; z-index: 1;">
														<th>Sr. No.</th>
														<th>Installment Date</th>
														<th>Installment Amount</th>
														<th>Status</th>
														<th>Action</th>
													</tr>
												</thead>

												<tbody>
													<?php foreach ($allInstallment as $ikey => $inst) { ?>
														<tr>
															<td><?php echo $ikey + 1; ?></td>
															<td><?php echo $inst['cbpi_pay_next_date']; ?></td>
															<td><?php echo $inst['cbpi_pay_next_amount']; ?></td>

															<td>
																<?php
																if ($inst['cbpi_status'] == "Paid")
																	echo "<span class='label label-success'>Paid</span>";
																elseif ($inst['cbpi_status'] == "Unpaid")
																	echo "<span class='label label-warning'>Pending</span>";
																else
																	echo "<span class='label label-danger'>Overdue</span>";
																?>
															</td>

															<td>
																<?php if ($inst['cbpi_status'] === "Paid") { ?>
																	<span class="label label-success">Paid</span>

																<?php } else { ?>
																	<?php
																	// Encode the ID within the loop
																	$pay_id = base64_encode($inst['cbpi_id']);
																	?>
																	<?php if (isset($billPaymentList[0]['cbpm_balance_amnt']) && $billPaymentList[0]['cbpm_balance_amnt'] != 0) { ?>
																		<a class="btn btn-success btn-xs"
																			href="<?php echo get_module_path(); ?>customers/add_customer_payment/?ref_id=<?php echo $id; ?>&pay_id=<?php echo $pay_id; ?>"
																			title="Make Payment"><i class="fa fa-check"></i>Make
																			Payment</a>
																	<?php } ?>
																<?php } ?>
																<?php
																$inst_id = base64_encode($inst['cbpi_id']);
																// $billno = base64_encode($inst['cbpi_bill_no']);
																$billno = base64_encode($inst['cbpi_cbpmid']);
																?>

																<?php if (!empty($inst['cbpi_bill_no'])) { ?>
																	<a class="btn btn-primary btn-sm"
																		href="<?php echo get_module_path(); ?>customers/download_invoice_installment/?ref_id=<?php echo $id; ?>&billno=<?php echo $billno; ?>&instId=<?php echo $inst_id; ?>&pay_next_date=<?php echo urlencode($inst['cbpi_pay_next_date']); ?>&pay_next_amount=<?php echo urlencode($inst['cbpi_pay_next_amount']); ?>">
																		<i class="fa fa-download"></i>
																	</a>
																<?php } else { ?>
																	<a class="btn btn-success btn-sm"
																		href="<?php echo get_module_path(); ?>customers/create_invoice/?ref_id=<?php echo $id; ?>&instId=<?php echo $inst_id; ?>">
																		<i class="fa fa-file"></i> Create Invoice
																	</a>
																<?php } ?>
															</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>

									<?php } ?>
									<!-- =================================================== -->


									<?php if (!empty($followupList)) { ?>

										<div class="portlet-title">
											<br />
											<div class="caption">
												<i class="font-red-mint icon-call-out"></i>
												<span class="caption-subject font-red-mint sbold">Follow-up
													Details</span>
											</div>
											<hr style="margin:3px;" />
										</div>
										<!-- <div class="followuptbl"
													style="overflow: auto;-webkit-overflow-scrolling: touch;margin-bottom:10px;height: 160px;  overflow-x:hidden;">
													<table class="table table-striped table-bordered  " role="grid"
														aria-describedby="sample_1_info">
														<tbody>
															<tr style=" position: sticky; top: 0; z-index: 1; background-color: #fff;"
																class="success">
																<th>Sr. No.</th>
																<th>FollowUp Date</th>
																<th>Next FollowUp Date</th>
																<th>Next FollowUp Time</th>
																<th>FollowUp By</th>
																<th>FeedBack</th>
																<th>Status</th>
																<th>FollowUp For</th>
																<th>Medium</th>
															</tr>
															<?php foreach ($followupList as $key => $follow) { ?>
																<?php foreach ($follow['followupList'] as $flw) { ?>
																	<tr>
																		<td><?php echo $key + 1; ?> </td>
																		<td><?php echo $flw['followup_date_n']; ?> </td>
																		<td><?php echo $flw['followup_nxt_folldate_n']; ?></td>
																		<td><?php echo $flw['followup_nxt_folltime']; ?></td>
																		<td><?php echo $flw['followup_addedby_name']; ?></td>
																		<td><?php echo $flw['followup_feedback']; ?></td>
																		<td>
																			<?php if ($flw['followup_status'] == "Following") {
																				echo "<span class='label label-success'>Following</span>";
																			} else if ($flw['followup_status'] == "Closed") {
																				echo "<span class='label label-danger'>Closed</span>";
																			} else {
																				echo "<span class='label label-warning'>" . $flw['followup_status'] . "</span>";
																			} ?>
																		</td>
																		<td><?php echo $flw['followup_for']; ?></td>
																		<td><?php echo $flw['followup_feedback_medium']; ?></td>
																	</tr>
																<?php } ?>
															<?php } ?>
														</tbody>
													</table>
												</div> -->

										<div class="followuptbl"
											style="overflow: auto;-webkit-overflow-scrolling: touch;margin-bottom:10px; max-height:230px; height:auto ">
											<table class="table table-striped table-bordered  " role="grid"
												aria-describedby="sample_1_info" style="min-width:950px;">
												<tbody>
													<tr style=" position: sticky; top: 0; z-index: 1; background-color: #fff;"
														class="success">
														<th style="width:30px;">Sr. No.</th>
														<th style="width:100px;">FollowUp Date</th>
														<th style="width:120px;">Next FollowUp Date / Time</th>

														<th style="min-width:120px;">FollowUp By</th>
														<th style="min-width:200px;">FeedBack</th>
														<th style="width:60px;">Status</th>
														<th style="width:60px;">FollowUp For</th>
														<th style="width:60px;">Medium</th>
													</tr>
													<?php foreach ($followupList as $key => $follow) { ?>
														<?php foreach ($follow['followupList'] as $flw) { ?>
															<tr>
																<td><?php echo $key + 1; ?> </td>
																<td><?php echo $flw['followup_date_n']; ?> </td>
																<td>
																	<?php echo $flw['followup_nxt_folldate_n']; ?>
																	<?php echo $flw['followup_nxt_folltime']; ?>
																</td>
																<td><?php echo $flw['followup_addedby_name']; ?></td>
																<td><?php echo $flw['followup_feedback']; ?></td>
																<td>
																	<?php if ($flw['followup_status'] == "Following") {
																		echo "<span class='label label-success'>Following</span>";
																	} else if ($flw['followup_status'] == "Closed") {
																		echo "<span class='label label-danger'>Closed</span>";
																	} else {
																		echo "<span class='label label-warning'>" . $flw['followup_status'] . "</span>";
																	} ?>
																</td>
																<td><?php echo $flw['followup_for']; ?></td>
																<td><?php echo $flw['followup_feedback_medium']; ?></td>
															</tr>
														<?php } ?>
													<?php } ?>
												</tbody>
											</table>
										</div>

									<?php } ?>
									<div class="form-actions ">
										<div class="col-md-12">

											<center>
												<?php if ($status == "Active") { ?>
													<a href="<?php echo get_module_path(); ?>customers/edit_customer/?id=<?php echo $id; ?>"
														class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
														Edit</a>

													<a class="btn btn-success btn-sm" style="margin: 5px 0px;"
														href="<?php echo get_module_path(); ?>customers/add_customer_follwoup/?id=<?php echo $id; ?>"
														title="Add Follow-up" data-toggle="modal"
														data-target="#form_modal"><i class="fa fa-phone"></i> Add
														Follow-up</a>






													<!-- <div class="col-lg-4"style="text-align:center
;"> -->
													<a class="btn btn-danger btn-sm" style="margin: 5px 0px;"
														href="<?php echo get_module_path(); ?>customers/deactivate_customer/?ref_id=<?php echo $id; ?>"
														title="Deactivate" data-toggle="modal"
														data-target="#form_modal"><i class="fa fa-ban"></i>
														Deactivate</a>
													<?php if (empty($installmentList)) { ?>
														<?php if (isset($billPaymentList[0]['cbpm_balance_amnt']) && $billPaymentList[0]['cbpm_balance_amnt'] != 0) { ?>
															<a class="btn btn-success btn-sm"
																href="<?php echo get_module_path(); ?>customers/add_customer_payment/?ref_id=<?php echo $id; ?>"
																title="Make Payment"><i class="fa fa-check"></i>Make Payment</a>
														<?php } ?>
													<?php } ?>


													<!-- <div class="col-lg-4" style="text-align:center
;"> -->
													<a class="btn btn-primary btn-sm" style="margin: 5px 0px;"
														href="<?php echo get_module_path(); ?>customers/renew_customer_service/?id=<?php echo $id; ?>"
														title="Renew Service"><i class="fa fa-clock-o"></i>Renew
														Service</a>

													<a class="btn btn-success btn-sm" style="margin: 5px 0px;"
														href="<?php echo get_module_path(); ?>customers/add_customer_service/?id=<?php echo $id; ?>"
														title="Add Service"><i class="fa fa-plus"></i>Add Service</a>

												<?php } ?>




												<?php if ($status == "Deactivated") { ?>
													<a class="btn btn-success btn-sm" style="margin: 5px 0px;"
														href="<?php echo get_module_path(); ?>customers/reactivate_customer/?ref_id=<?php echo $id; ?>"
														title="Re-Activate" data-toggle="modal"
														data-target="#form_modal"><i class="fa fa-phone"></i>
														Re-Activate</a>
												<?php } ?>
												<?php if ($status == "Pending") { ?>
													<a class="btn btn-success btn-sm" style="margin: 5px 0px;"
														href="<?php echo get_module_path(); ?>customers/approve_customer/?ref_id=<?php echo $id; ?>"
														title="Approve Customer" data-toggle="modal"
														data-target="#form_modal"><i class="fa fa-check"></i>Approve</a>
												<?php } ?>




												<?php if (empty($installmentList)) {
													$cbpm_billno = $billPaymentList[0]['cbpm_id']; ?>

													<!-- <?php if (empty($installmentList)) { ?>
						 <a  class="btn btn-primary btn-sm"  href="<?php echo get_module_path(); ?>customers/download_invoice/?ref_id=<?php echo $id; ?>&billno=<?php echo $cbpm_billno; ?>" title="Download Invoice...." ><i class="fa fa-download"></i></a> 
						 <?php } ?> -->
													<!-- <a  class="btn btn-danger btn-sm" style="margin: 5px 0px;"  href="<?php echo get_module_path(); ?>customers/print_invoice/?ref_id=<?php echo $id; ?>&billno=<?php echo $cbpm_billno; ?>" title="Print Invoice" target="_blank"><i class="fa fa-print"></i></a> -->


													<!-- <a  class="btn btn-primary btn-sm"  style="margin: 5px 0px;" href="<?php echo get_module_path(); ?>customers/send_download_invoice/?ref_id=<?php echo $id; ?>&billno=<?php echo base64_encode($cbpm_billno); ?>" title="send  Invoice on WhatsApp" ><i class="fa fa-whatsapp"></i></a>   -->


												<?php } ?>

												<!-- <a  class="btn btn-primary btn-sm"  href="<?php echo get_module_path(); ?>customers/download_contract/?ref_id=<?php echo $id; ?>&billno=<?php echo $cbpm_billno; ?>" title="Download Contract" >Contract<i class="fa fa-download"></i></a>  -->



												<!-- add by ritika -->
												<!--  -->

												<?php $history = $this->input->get('history');
												if ($history == "dashboard") { ?>

													<a href="<?php echo get_module_path(); ?>dashboard" class="btn btn-danger btn-sm"><i class="fa fa-history"></i>Back</a>
												<?php
												} elseif ($history == "amc") {
												?>

													<a href="<?php echo get_module_path(); ?>reports/amc_renewal_reminder?history=back&highlight=<?php echo $id; ?>"
														class="btn btn-danger btn-sm">
														<i class="fa fa-history"></i>Back
													</a>

												<?php
												} else {
												?>

													<a href="<?php echo get_module_path(); ?>customers/customer_report?history=back&highlight=<?php echo $id; ?>"
														class="btn btn-danger btn-sm">
														<i class="fa fa-history"></i>Back
													</a>

												<?php } ?>
											</center>
										</div>
									</div>
									</div>
								</div>
							</div>
							<!-- /.box-body -->
						<?php } else { ?>
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert"
									aria-hidden="true">Ãƒâ€”</button>
								Customer Details Not Found !!!
							</div>
						<?php } ?>

						</div>
				</div>
			</div>
			<!-- END PAGE BASE CONTENT -->
		</div>
		<!-- END CONTENT BODY -->
		<style>
			.tbl-container {
				overflow-y: scroll;
				max-height: 141px;
				margin-bottom: 20px;
			}

			.btn:not(.md-skip):not(.bs-select-all):not(.bs-deselect-all).btn-xs {
				margin: 0px;
			}

			@media screen and (max-width: 768px) {
				.followuptbl {
					height: 160px;
				}

				.tbl-box {
					overflow-x: scroll;
					padding: 10px;
				}

				.table-condensed {
					width: 800px;
				}

				.tbl-container {
					overflow-x: scroll;
					overflow-y: scroll;

				}

				#Srtable {
					width: 619px;
				}
			}
		</style>
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
<div class="modal fade" id="form_modal_lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="confirm-clear" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-green-sharp">
				<button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp;
					Clear Cheque</h4>
			</div>
			<div class="modal-body">
				<p id="myModalBody">Do you really want to Clear this Cheque ?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				<a class="btn btn-success btn-ok">Clear Cheque</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="confirm-clear-payment" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-green-sharp">
				<button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp;
					Clear Payment</h4>
			</div>
			<div class="modal-body">
				<p id="myModalBody">Do you really want to Clear this Payment ?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				<a class="btn btn-success btn-ok">Clear Payment</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="confirm-whatsapp" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">

			<div class="modal-header bg-green-sharp">
				<button type="button" class="close hidden" data-dismiss="modal">&times;</button>
				<h4 class="modal-title font-white">
					<i class="fa fa-exclamation-circle"></i> WhatsApp
				</h4>
			</div>

			<div class="modal-body">
				<p id="whatsappMessage"></p> <!-- IMPORTANT -->
			</div>

			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal">OK</button>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="confirm-cancel" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-red-mint">
				<button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-close"></i>&nbsp;
					Cancel Payment</h4>
			</div>
			<div class="modal-body">
				<p id="myModalBody">Do you really want to Cancel This Payment ?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				<a class="btn btn-danger btn-ok">Cancel Payment</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="#form_modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="sendwp" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-green-sharp">
				<button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp;Whats
					App</h4>
			</div>
			<div class="modal-body">
				<p id="myModalBody">Do you really want to send the message ?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-success btn-resolve" data-toggle="modal" data-target="#form_modal"
					data-dismiss="modal">Send</a>
			</div>
		</div>
	</div>
</div>





<div class="modal fade" id="completeServiceModal" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title">
					<i class="fa fa-times-circle text-danger"></i>
					Cancel Service
				</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<form action="<?php echo get_module_path(); ?>customers/complete_service/"
				method="post"
				id="complete_service_form"
				autocomplete="off">

				<div class="modal-body">

					<input type="hidden" name="cust_serv_id" id="cust_serv_id">

					<div class="form-group">
						<label>
							Reason For Cancel Service
							<span class="text-danger">*</span>
						</label>

						<textarea class="form-control"
							name="reason"
							id="reason"
							rows="4"
							maxlength="500"
							placeholder="Enter Reason"></textarea>
					</div>

				</div>

				<div class="form-actions text-center" style="padding-bottom:15px;">
					<button class="btn btn-success" id="mybutton" type="submit">
						Submit
					</button>

					<button type="button"
						class="btn red btn-outline"
						data-dismiss="modal">
						Cancel
					</button>
				</div>

			</form>

		</div>
	</div>
</div>
<!--END START MODAL -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js"
	type="text/javascript"></script>
<script>
	jQuery(document).ready(function() {

		jQuery('#confirm-whatsapp').on('show.bs.modal', function(e) {
			var button = jQuery(e.relatedTarget);
			var message = button.data('message');

			jQuery(this).find('#whatsappMessage').text(message);
		});

	});
</script>
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

		$('#sendwp').on('show.bs.modal', function(e) {
			$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
		});

	});
</script>
<script>
	function openCompleteServiceModal(serv_id) {
		$('#deactivateModal').modal('hide');

		$('.modal-backdrop').remove();
		$('body').removeClass('modal-open');

		$('#cust_serv_id').val(serv_id);

		setTimeout(function() {
			$('#completeServiceModal').modal('show');
		}, 300);
	}
</script>