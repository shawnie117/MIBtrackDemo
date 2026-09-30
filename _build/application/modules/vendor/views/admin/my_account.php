<?php
$vendor  = $this->session->userdata('vendor');
$role_id = $vendor['user_role_id'];
$user_trial = $vendor['user_trial'];
?>

<!-- Content Wrapper. Contains page content -->
<style>
	.profile-equal {
		display: flex;
		align-items: stretch;
	}

	.card-box {
		background: #fff;
		border: 1px solid #e6e6e6;
		border-radius: 6px;
		padding: 10px;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
	}

	.fixed-logo {
		max-width: 70%;
		height: auto;
	}

	.qr-img {
		max-width: 180px;
		margin-bottom: 15px;
	}

	.bank-table th {
		width: 35%;
		background: #f9f9f9;
	}

	.table-section th {
		background: #36c6d3 !important;
		color: #fff;
		font-weight: 600;
		text-align: left;
		padding: 10px;
	}

	@media (max-width: 992px) {
		.profile-equal {
			display: flex;
			flex-direction: column;
		}
	}
</style>
<div class="page-content-wrapper">
	<div class="page-content">
		
		<!-- BEGIN PAGE BASE CONTENT -->
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<!-- BEGIN PAGE BREADCRUMB -->
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<a href="<?php echo get_module_path() . "/dashboard" ?>">Home</a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<span class="active"><?php echo $page_title; ?></span>
						</li>

						<div class=" me-auto" style="float: right;">
							<?php foreach ($wts_details as $noti) { ?>
								<span style="float: padding-right:35px" class="btn btn-success btn-sm">WhatsApp Credit Count: <?php echo $noti['user_wp_credit_count']; ?></span>
							<?php } ?>

						</div>
					</ul>
					<!-- END PAGE BREADCRUMB -->
					<?php if (!empty($my_details)) {
						$my_details = $my_details[0];
						if ($role_id !== SUPER_ADMIN_ROLE_ID && $role_id !== CUSTOMER_ROLE_ID) {
							$empEducationList = isset($my_details['empEducationList']) && !empty($my_details['empEducationList']) ? $my_details['empEducationList'][0] : "";
							$empBankList = isset($my_details['empBankList']) && !empty($my_details['empBankList']) ? $my_details['empBankList'][0] : "";
							$empKycList = isset($my_details['empKycList']) && !empty($my_details['empKycList']) ? $my_details['empKycList'][0] : "";
						}
					?>
						<div class="portlet-title tabbable-line">
							<div class="caption caption-md">
								<i class="icon-globe theme-font hide"></i>
								<span class="caption-subject font-blue-madison bold uppercase"><?php echo $page_title; ?></span>
								<?php if ($role_id == SUPER_ADMIN_ROLE_ID) {  ?>
									&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo get_module_path(); ?>admin/edit_my_account" class="btn btn-success btn-sm pull-right"><i class="fa fa-edit"></i>Edit</a>
								<?php } ?>
							</div>
							<ul class="nav nav-tabs ">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab" aria-expanded="false">Basic Details</a>
								</li>
								<li>
									<a href="#tab_1_2" data-toggle="tab" aria-expanded="false">Contact Details</a>
								</li>
								<?php if ($role_id !== CUSTOMER_ROLE_ID) { ?>
									<li>
										<a href="#tab_1_3" data-toggle="tab" aria-expanded="false">Bank Details</a>
									</li>
									<?php if (!empty($empKycList)) { ?>
										<li>
											<a href="#tab_1_4" data-toggle="tab" aria-expanded="true">KYC Details</a>
										</li>
								<?php }
								}  ?>
								<?php if ($role_id == CUSTOMER_ROLE_ID) { ?>
									<li>
										<a href="#tab_1_5" data-toggle="tab" aria-expanded="true">Branch Details</a>
									</li>
								<?php } ?>

								<?php if ($role_id == SUPER_ADMIN_ROLE_ID) {  ?>
									<li>
										<a href="#tab_1_6" data-toggle="tab" aria-expanded="true">Subscription Details</a>
									</li>
								<?php } ?>
							</ul>
						</div>
						<div class="portlet-body">
							<div class="col-md-12">
								<center>
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
								</center>
							</div>
							<div class="tab-content  ">
								<!-- PERSONAL INFO TAB -->
								<div class="tab-pane active" id="tab_1_1">
									<div class="portlet-body">
										<?php if ($role_id == CUSTOMER_ROLE_ID) {
											$cust_image      = $my_details['cust_img_path'];
											$cust_image      = str_replace("getAuthApiKey", APIKEY, $cust_image);

										?>
											<div class="row profile-equal">
												<!-- LEFT CARD -->
												<div class="col-md-4">
													<div class="card-box text-center">

														<!-- SIDEBAR USERPIC -->

														<img src="<?php echo isset($cust_image) ? $cust_image : ""; ?>" class="img-responsive fixed-logo" alt="image">
														<!-- END SIDEBAR USERPIC -->
														<!-- SIDEBAR USER TITLE -->
														<div class="profile-usertitle">
															<div class="profile-usertitle-name"> <?php echo isset($my_details['cust_company_name']) ? $my_details['cust_company_name'] : ""; ?> </div>
															<div class="profile-usertitle-job"> <?php echo isset($my_details['customer_name']) ? $my_details['customer_name'] : ""; ?> </div>
														</div>
														<!-- END SIDEBAR USER TITLE -->
													</div>
												</div>
												<div class="col-md-9">
													<div class="h-100">
														<table class="table table-striped table-bordered table-advance table-hover">
															<tbody>

																<tr>
																	<th> Name </th>
																	<td><?php echo isset($my_details['customer_name']) ? $my_details['customer_name'] : ""; ?> </td>
																</tr>
																<tr>
																	<th> Company Name </th>
																	<td><?php echo isset($my_details['cust_company_name']) ? $my_details['cust_company_name'] : ""; ?> </td>
																</tr>
																<tr>
																	<th> Unique Id </th>
																	<td><?php echo isset($my_details['customer_uniqueid']) ? $my_details['customer_uniqueid'] : ""; ?> </td>
																</tr>
																<tr>
																	<th> Contact Person</th>
																	<td><?php echo isset($my_details['customer_contact_person']) ? $my_details['customer_contact_person'] : ""; ?> </td>
																</tr>
																<tr>
																	<th> Contact No.</th>
																	<td><?php echo isset($my_details['cust_landline']) ? $my_details['cust_landline'] : ""; ?> </td>
																</tr>

																<tr>
																	<th> Website.</th>
																	<td><?php echo isset($my_details['cust_website']) ? $my_details['cust_website'] : ""; ?> </td>
																</tr>
																<tr>
																	<th> PAN No.</th>
																	<td><?php echo isset($my_details['cust_panno']) ? $my_details['cust_panno'] : ""; ?> </td>
																</tr>
																<tr>
																	<th> GST No.</th>
																	<td><?php echo isset($my_details['customer_gstno']) ? $my_details['customer_gstno'] : ""; ?> </td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										<?php } ?>

										<?php if ($role_id == SUPER_ADMIN_ROLE_ID) { ?>
											<div class="row profile-equal">
												<!-- LEFT CARD -->
												<div class="col-md-4">
													<div class="card-box text-center">

														<!-- SIDEBAR USERPIC -->
														<?php
														$cust_image      = $com_details['cust_img_path'];
														$cust_image      = str_replace("getAuthApiKey", APIKEY, $cust_image);

														?>
														<center>
															<img src="<?php echo $cust_image; ?>" class="img-responsive fixed-logo" alt="image">
														</center>
														<!-- END SIDEBAR USERPIC -->
														<!-- SIDEBAR USER TITLE -->
														<div class="profile-usertitle">
															<div class="profile-usertitle-name"> <?php echo isset($com_details['cust_company_name']) ? $com_details['cust_company_name'] : ""; ?> </div>
														</div>
														<!-- END SIDEBAR USER TITLE -->
													</div>
												</div>
												<div class="col-md-9">
													<div class="h-100">
														<table class="table table-striped table-bordered table-advance table-hover">
															<tbody>

																<tr>
																	<th> Company Name </th>
																	<td><?php echo isset($com_details['cust_company_name']) ? $com_details['cust_company_name'] : ""; ?> </td>
																</tr>
																<tr>
																	<th>Owner Name </th>
																	<td><?php echo isset($com_details['customer_name']) ? $com_details['customer_name'] : ""; ?> </td>
																</tr>
																<tr>
																	<th>Website </th>
																	<td><?php echo isset($com_details['cust_website']) ? $com_details['cust_website'] : ""; ?> </td>
																</tr>
																<tr>
																	<th> GST No. </th>
																	<td><?php echo isset($com_details['customer_gstno']) ? $com_details['customer_gstno'] : ""; ?> </td>
																</tr>
																<?php $image = $my_details['invoice_pattern_img'];
																$image      = str_replace("getAuthApiKey", APIKEY, $image); ?>
																<tr>
																	<th> Invoice Pattern</th>
																	<td><?php echo isset($my_details['invoice_pattern']) ? $my_details['invoice_pattern'] : ""; ?>
																		<?php if (!empty($image)) {  ?>
																			&nbsp;&nbsp; <a target="_blank" href="<?php echo $image; ?>"> View</a></td>
																<?php } ?>
																</tr>


															</tbody>
														</table>
													</div>
												</div>
											</div>
										<?php } else if ($role_id !== SUPER_ADMIN_ROLE_ID && $role_id !== CUSTOMER_ROLE_ID) { ?>

											<table class="table table-striped table-bordered table-advance table-hover">
												<tbody>

													<tr>
														<th> Name </th>
														<td><?php echo isset($my_details['emp_name']) ? $my_details['emp_name'] : ""; ?> </td>
													</tr>
													<tr>
														<th> Role</th>
														<td><?php echo isset($my_details['permission_name']) ? $my_details['permission_name'] : ""; ?> </td>
													</tr>
													<tr>
														<th> Username</th>
														<td><?php echo isset($my_details['user_name']) ? $my_details['user_name'] : ""; ?> </td>
													</tr>
													<tr>
														<th> Password</th>
														<td><?php echo isset($my_details['user_pswd']) ? $my_details['user_pswd'] : ""; ?> </td>
													</tr>
													<tr>
														<th> Reporting To </th>
														<td><?php echo isset($my_details['emp_rpt_name']) ? $my_details['emp_rpt_name'] : ""; ?> </td>
													</tr>
													<tr>
														<th>Education </th>
														<td><?php echo isset($empEducationList['edu_name']) ? $empEducationList['edu_name'] : ""; ?> </td>
													</tr>
													<tr>
														<th> Education Details</th>
														<td><?php echo isset($empEducationList['emp_edu_other_details']) ? $empEducationList['emp_edu_other_details'] : ""; ?> </td>
													</tr>
												<?php } ?>

												</tbody>
											</table>
									</div>
								</div>
								<!-- END PERSONAL INFO TAB -->

								<!-- CONTACT INFO TAB -->
								<div class="tab-pane" id="tab_1_2">
									<div class="portlet-body">
										<table class="table table-striped table-bordered table-advance table-hover">
											<tbody>
												<?php if ($role_id == SUPER_ADMIN_ROLE_ID) { ?>
													<tr>
														<th> Contact Person </th>
														<td><?php echo isset($com_details['customer_contact_person']) ? $com_details['customer_contact_person'] : ""; ?> </td>
													</tr>
													<tr>
														<th> Address </th>
														<td><?php echo isset($com_details['customer_address']) ? $com_details['customer_address'] : ""; ?> </td>
													</tr>
													<tr>
														<th>Area </th>
														<td><?php echo isset($com_details['customer_area']) ? $my_details['customer_area'] : ""; ?> </td>
													</tr>
													<tr>
														<th>Contact No. </th>
														<td><?php echo isset($com_details['customer_contact']) ? $com_details['customer_contact'] : ""; ?> </td>
													</tr>
													<tr>
														<th> Alternate No.</th>
														<td><?php echo isset($com_details['customer_alt_contact']) ? $com_details['customer_alt_contact'] : ""; ?> </td>
													</tr>
													<tr>
														<th> Email Id.</th>
														<td><?php echo isset($com_details['customer_contact_email']) ? $com_details['customer_contact_email'] : ""; ?> </td>
													</tr>
												<?php } else if ($role_id !== SUPER_ADMIN_ROLE_ID && $role_id !== CUSTOMER_ROLE_ID) { ?>


													<tr>
														<th> Mobile No </th>
														<td><?php echo isset($my_details['emp_mob1']) ? $my_details['emp_mob1'] : ""; ?> </td>
														<th>Mobile No2 </th>
														<td><?php echo isset($my_details['emp_mob2']) ? $my_details['emp_mob2'] : ""; ?> </td>
													</tr>
													<tr>
														<th>Email Id </th>
														<td colspan="3"><?php echo isset($my_details['emp_emailid']) ? $my_details['emp_emailid'] : ""; ?> </td>
													</tr>
													<tr>
														<th colspan="4">Current Address Details : </th>
													</tr>
													<tr>
														<th>Address </th>
														<td colspan="3"><?php echo isset($my_details['emp_address']) ? $my_details['emp_address'] : ""; ?> </td>
													</tr>
													<tr>
														<th>State </th>
														<td><?php echo isset($my_details['state_name']) ? $my_details['state_name'] : ""; ?> </td>
														<th>District </th>
														<td colspan="3"><?php echo isset($my_details['dist_name']) ? $my_details['dist_name'] : ""; ?> </td>
													</tr>
													<tr>
														<th>City </th>
														<td><?php echo isset($my_details['city_name']) ? $my_details['city_name'] : ""; ?> </td>
														<th>Pincode </th>
														<td><?php echo isset($my_details['emp_pincode']) ? $my_details['emp_pincode'] : ""; ?> </td>
													</tr>
													<tr>
														<th>LandMark </th>
														<td><?php echo isset($my_details['emp_landmark']) ? $my_details['emp_landmark'] : ""; ?> </td>
														<th>Area </th>
														<td><?php echo isset($my_details['emp_areaname']) ? $my_details['emp_areaname'] : ""; ?> </td>
													</tr>
													<tr>
														<th colspan="4">Permanent Address Details : </th>
													</tr>

													<tr>
														<th>Address </th>
														<td colspan="3"><?php echo isset($my_details['emp_perm_address']) ? $my_details['emp_perm_address'] : ""; ?> </td>
													</tr>
													<tr>
														<th>State </th>
														<td><?php echo isset($my_details['emp_perm_state_name']) ? $my_details['emp_perm_state_name'] : ""; ?> </td>
														<th>District </th>
														<td colspan="3"><?php echo isset($my_details['emp_perm_dist_name']) ? $my_details['emp_perm_dist_name'] : ""; ?> </td>
													</tr>
													<tr>
														<th>City </th>
														<td><?php echo isset($my_details['emp_perm_city_name']) ? $my_details['emp_perm_city_name'] : ""; ?> </td>
														<th>Pincode </th>
														<td><?php echo isset($my_details['emp_perm_pincode']) ? $my_details['emp_perm_pincode'] : ""; ?> </td>
													</tr>
													<tr>
														<th>LandMark </th>
														<td><?php echo isset($my_details['emp_perm_landmark']) ? $my_details['emp_perm_landmark'] : ""; ?> </td>
														<th>Area </th>
														<td><?php echo isset($my_details['emp_perm_areaname']) ? $my_details['emp_perm_areaname'] : ""; ?> </td>
													</tr>

												<?php  } else if ($role_id == CUSTOMER_ROLE_ID) { ?>
													<tr>
														<th> Mobile No </th>
														<td><?php echo isset($my_details['customer_contact']) ? $my_details['customer_contact'] : ""; ?> </td>
													</tr>
													<tr>
														<th>Alternate Mobile No. </th>
														<td><?php echo isset($my_details['customer_alt_contact']) ? $my_details['customer_alt_contact'] : ""; ?> </td>
													</tr>
													<tr>
														<th>Email Id </th>
														<td><?php echo isset($my_details['customer_contact_email']) ? $my_details['customer_contact_email'] : ""; ?> </td>
													</tr>
													<tr>
														<th>Address</th>
														<td><?php echo isset($my_details['customer_address']) ? $my_details['customer_address'] : ""; ?> </td>
													</tr>
													<tr>
														<th>Area</th>
														<td><?php echo isset($my_details['customer_area']) ? $my_details['customer_area'] : ""; ?> </td>
													</tr>
													<tr>
														<th>City</th>
														<td><?php echo isset($my_details['customer_city_name']) ? $my_details['customer_city_name'] : ""; ?> </td>
													</tr>
													<tr>
														<th>State</th>
														<td><?php echo isset($my_details['customer_state_name']) ? $my_details['customer_state_name'] : ""; ?> </td>
													</tr>
													<tr>
														<th>District</th>
														<td><?php echo isset($my_details['customer_dist_name']) ? $my_details['customer_dist_name'] : ""; ?> </td>
													</tr>
													<tr>
														<th>Pincode</th>
														<td><?php echo isset($my_details['customer_pin']) ? $my_details['customer_pin'] : ""; ?> </td>
													</tr>
												<?php  }  ?>
											</tbody>
										</table>
									</div>
								</div>
								<!-- END CONTACT INFO TAB -->


								<?php if ($role_id !== CUSTOMER_ROLE_ID) { ?>
									<!-- BANK INFO TAB -->
									<div class="tab-pane" id="tab_1_3">
										<?php if ($role_id == SUPER_ADMIN_ROLE_ID) { ?>
											<div class="portlet-body">
												<div class="row profile-equal">

													<div class="col-md-4">
														<div class="card-box text-center">

															<!-- SIDEBAR USERPIC -->
															<?php $cust_qr = $com_details['cust_qr_path'];
															$cust_qr = str_replace("getAuthApiKey", APIKEY, $cust_qr); ?>
															<center>
																<img src="<?php echo $cust_qr; ?>" class="img-responsive fixed-logo" alt="QR code">
															</center>

															<div class="profile-usertitle">
																<div class="profile-usertitle-name">
																	<?php echo isset($com_details['cust_company_name']) ? $com_details['cust_company_name'] : ""; ?>
																</div>
															</div>
														</div>
													</div>

													<!-- RIGHT BANK DETAILS -->
													<div class="col-md-8">
														<div class="card-box">

															<table class="table table-bordered bank-table">
																<tbody>

																	<!-- GST HEADER -->
																	<tr class="table-section">
																		<th colspan="2">Bank Details For GST</th>
																	</tr>

																	<tr>
																		<th>Account Name</th>
																		<td><?php echo $com_details['cust_bank_acc_name'] ?? ""; ?></td>
																	</tr>
																	<tr>
																		<th>Account Number</th>
																		<td><?php echo $com_details['cust_bank_acc_number'] ?? ""; ?></td>
																	</tr>
																	<tr>
																		<th>Bank Name</th>
																		<td><?php echo $com_details['cust_bank_name'] ?? ""; ?></td>
																	</tr>
																	<tr>
																		<th>Branch</th>
																		<td><?php echo $com_details['cust_bank_branch_address'] ?? ""; ?></td>
																	</tr>
																	<tr>
																		<th>IFSC Code</th>
																		<td><?php echo $com_details['cust_bank_ifsc'] ?? ""; ?></td>
																	</tr>
																	<tr>
																		<th>MICR</th>
																		<td><?php echo $com_details['cust_bank_micr'] ?? ""; ?></td>
																	</tr>
																	<tr>
																		<th>Cheque Bounce Charges</th>
																		<td><?php echo $com_details['cust_company_chq_bounce_chrg'] ?? ""; ?></td>
																	</tr>

																	<!-- NON GST HEADER -->
																	<tr class="table-section">
																		<th colspan="2">Bank Details For Non-GST</th>
																	</tr>

																	<tr>
																		<th>Account Name</th>
																		<td><?php echo $com_details['cust_bank_acc_name_non_gst'] ?? ""; ?></td>
																	</tr>
																	<tr>
																		<th>Account Number</th>
																		<td><?php echo $com_details['cust_bank_acc_number_non_gst'] ?? ""; ?></td>
																	</tr>
																	<tr>
																		<th>Bank Name</th>
																		<td><?php echo $com_details['cust_bank_name_non_gst'] ?? ""; ?></td>
																	</tr>
																	<tr>
																		<th>Branch</th>
																		<td><?php echo $com_details['cust_bank_branch_address_non'] ?? ""; ?></td>
																	</tr>
																	<tr>
																		<th>IFSC Code</th>
																		<td><?php echo $com_details['cust_bank_ifsc_non_gst'] ?? ""; ?></td>
																	</tr>
																	<tr>
																		<th>MICR</th>
																		<td><?php echo $com_details['cust_bank_micr_non_gst'] ?? ""; ?></td>
																	</tr>
																	<tr>
																		<th>Cheque Bounce Charges</th>
																		<td><?php echo $com_details['cust_company_chq_bounce_chrg_non_gst'] ?? ""; ?></td>
																	</tr>

																</tbody>
															</table>

														</div>
													</div>

												</div>
											</div>

										<?php } else { ?>
											<div class="portlet-body">
												<div class="profile-content">
													<table class="table table-striped table-bordered table-advance table-hover">
														<tbody>
															<tr>
																<th>Account Name </th>
																<td><?php echo isset($empBankList['emp_bank_account_name']) ? $empBankList['emp_bank_account_name'] : ""; ?> </td>
															</tr>
															<tr>
																<th> Account Number</th>
																<td><?php echo isset($empBankList['emp_bank_account_no']) ? $empBankList['emp_bank_account_no'] : ""; ?> </td>
															</tr>
															<tr>
																<th> Bank Name</th>
																<td><?php echo isset($empBankList['emp_bank_name']) ? $empBankList['emp_bank_name'] : ""; ?> </td>
															</tr>
															<tr>
																<th> Branch</th>
																<td><?php echo isset($empBankList['emp_bank_branch_addrs']) ? $empBankList['emp_bank_branch_addrs'] : ""; ?> </td>
															</tr>
															<tr>
																<th> IFSC Code</th>
																<td><?php echo isset($empBankList['emp_bank_ifsc']) ? $empBankList['emp_bank_ifsc'] : ""; ?> </td>
															</tr>
															<tr>
																<th> Added By</th>
																<td><?php echo isset($empBankList['emp_bank_addedby_name']) ? $empBankList['emp_bank_addedby_name'] : ""; ?> </td>
															</tr>
															<tr>
																<th> Added On</th>
																<td><?php echo isset($empBankList['emp_bank_sdate_n']) ? $empBankList['emp_bank_sdate_n'] : ""; ?> </td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										<?php }  ?>
									</div>
									<!--END BANK INFO TAB -->

									<!-- KYC INFO TAB -->
									<?php if (!empty($empKycList)) { ?>
										<div class="tab-pane" id="tab_1_4">
											<div class="portlet-body">
												<table class="table table-striped table-bordered table-advance table-hover">
													<tbody>
														<tr>
															<th>Address Proof </th>
															<td><?php echo isset($empKycList['emp_addrs_prf_type']) ? $empKycList['emp_addrs_prf_type'] : ""; ?> </td>
														</tr>
														<tr>
															<th>Address Proof No. </th>
															<td><?php echo isset($empKycList['emp_addrs_prf_no']) ? $empKycList['emp_addrs_prf_no'] : ""; ?> </td>
														</tr>

														<?php $image = "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image";

														$image1      = $empKycList['emp_addrs_prf_img'];
														$image1      = str_replace("getAuthApiKey", APIKEY, $image1);
														$image1     = !empty($image1) ? $image1 : $image;

														$image2     = $empKycList['emp_kyc_photo1'];
														$image2     = str_replace("getAuthApiKey", APIKEY, $image2);
														$image2     = !empty($image2) ? $image2 : $image;

														?>

														<tr>
															<th>ID Proof </th>
															<td><?php echo isset($empKycList['emp_kyc_type1']) ? $empKycList['emp_kyc_type1'] : ""; ?> </td>
														</tr>
														<tr>
															<th>ID Proof No. </th>
															<td><?php echo isset($empKycList['emp_kyc_idnum1']) ? $empKycList['emp_kyc_idnum1'] : ""; ?> </td>
														</tr>

													</tbody>
												</table>
												<div class="form-group">
													<div class="fileinput fileinput-new" data-provides="fileinput">
														<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
															<img src="<?php echo $image1; ?>" alt="">
														</div>
														<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"> </div>
														<br /> Address Proof
													</div>
													<div class="fileinput fileinput-new" data-provides="fileinput">
														<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
															<img src="<?php echo $image2; ?>" alt="">
														</div>
														<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"> </div>
														<br /> ID Proof
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
								<?php } ?>


								<?php if ($role_id == CUSTOMER_ROLE_ID) { ?>
									<div class="tab-pane" id="tab_1_5">
										<div class="portlet-body">
											<table class="table table-striped table-bordered table-advance table-hover">
												<tbody>

													<tr>
														<th> Branch </th>
														<td><?php echo isset($my_details['branch_name']) ? $my_details['branch_name'] : ""; ?> </td>
													</tr>
													<tr>
														<th> Contact Person</th>
														<td><?php echo isset($my_details['branch_contact_person']) ? $my_details['branch_contact_person'] : ""; ?> </td>
													</tr>
													<tr>
														<th> Branch Address </th>
														<td><?php echo isset($my_details['branch_address']) ? $my_details['branch_address'] : ""; ?> </td>
													</tr>
													<tr>
														<th> City </th>
														<td><?php echo isset($my_details['city_name']) ? $my_details['city_name'] : ""; ?> </td>
													</tr>
													<tr>
														<th> Contact No. </th>
														<td><?php echo isset($my_details['branch_contact']) ? $my_details['branch_contact'] : ""; ?> </td>
													</tr>
													<tr>
														<th> Alternate Contact No. </th>
														<td><?php echo isset($my_details['branch_contact1']) ? $my_details['branch_contact1'] : ""; ?> </td>
													</tr>

												</tbody>
											</table>
										</div>
									</div>
								<?php } ?>

								<!-- SUBSCRIPTION DETAILS START -->
								<?php if ($role_id == SUPER_ADMIN_ROLE_ID) {
									$customer_id  = base64_encode($com_details['customer_id']);
									$billPaymentList  = $com_details['billPaymentList'];
									$subscriptionList = $com_details['subscriptionList']; 
									$expireSubsList   = $com_details['expireSubsList']; 
									
									$activeList = $subscriptionList ?? [];
									$expiredList = $expireSubsList ?? [];

									// Merge both
									$allSubscriptions = array_merge($activeList, $expiredList);

									usort($allSubscriptions, function ($a, $b) {
										return strtotime($b['cust_subs_enddate']) - strtotime($a['cust_subs_enddate']);
									});

									?>

									<div class="tab-pane" id="tab_1_6">
										<div class="portlet-body">
											<?php if (!empty($allSubscriptions)) {  ?>
												<table class="table table-striped table-bordered table-advance table-hover">
													<tbody>
														<tr class="success">
															<th>Sr. No.</th>
															<th>Name</th>
															<th>Start Date </th>
															<th>End Date</th>
															<th>Status</th>
														</tr>
														<?php foreach ($allSubscriptions as $key => $subserv) {
															$cust_subs_cbpmid = $subserv['cust_subs_cbpmid'];
															$sub_id = $subserv['cust_subs_id'];
															$cust_subs_custid = $subserv['cust_subs_custid'];
															$str = "?cust_id=" . base64_encode($cust_subs_custid) . "&sub_id=" . base64_encode($sub_id);
														?>
															<tr>
																<td><?php echo $key + 1; ?> </td>
																<td><?php echo $subserv['cust_subs_type_name']; ?> </td>
																<td><?php echo $subserv['cust_subs_startdate_n']; ?></td>
																<td><?php echo $subserv['cust_subs_enddate_n']; ?></td>
																<td> <?php if ($subserv['cust_subs_status'] == "Active") {
																			echo "<span class='label label-success'>Active</span>";
																		} elseif ($status == "Expired") {
																			echo "<span class='label label-danger'>Expired</span>";
																		} else if ($subserv['cust_subs_status'] == "Deactivated") {
																			echo "<span class='label label-danger'>Deactivated</span>";
																		} else {
																			echo "<span class='label label-warning'>" . $subserv['cust_subs_status'] . "</span>";
																		}    ?> </td>

															</tr>
														<?php } ?>
													</tbody>
												</table>
												<?php if (!empty($billPaymentList)) {
													$cbpm_billno = $billPaymentList[0]['cbpm_billno'];
													$cbpm_total_amnt = $billPaymentList[0]['cbpm_total_amnt'];
													if ($user_trial !== "InTrial") { ?>
														<a class="btn btn-danger btn-xs pull-right" href="<?php echo get_module_path(); ?>admin/download_invoice/?ref_id=<?php echo $customer_id; ?>&billno=<?php echo $cbpm_billno; ?>" title="Download Invoice"><i class="fa fa-download"></i>Download Invoice</a> <br /><br />
												<?php }
												}  ?>

											<?php } ?>
										</div>
									</div>
								<?php } ?>
								<!-- SUBSCRIPTION DETAILS END -->

							</div>
						</div>
					<?php } else {  ?>
						<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							Account Details Not Found !!!
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE BASE CONTENT -->
<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
		</div>
	</div>
</div>
<style>
	.alert {
		position: fixed;
		transform: translateX(-150%);
		z-index: 9999;
	}

	@media (max-width: 576px) {
		.alert {
			left: 50%;
			transform: translateX(-50%);
			right: auto;
		}
	}
</style>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {

		$("#form_modal").on("show.bs.modal", function(e) {
			var link = $(e.relatedTarget);
			$(this).data('bs.modal', null);
			$(this).find(".modal-content").load(link.attr("href"));
		});
	});

	setTimeout(function() {
		$('.alert').fadeOut('slow');
	}, 3000);
</script>