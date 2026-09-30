<style>
	.service-header {
		background: #eef6f9;
		cursor: pointer;
		font-weight: bold;
	}

	.service-header:hover {
		background: #d9edf7;
	}

	.service-body td {
		background: #fff;
	}
</style>
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE BASE CONTENT -->

		<?php $icon = "icon-plus";
		if ($action == "Edit") {
			$icon = "icon-pencil";
		} ?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<ul class="page-breadcrumb breadcrumb">
						<li><a href="<?php echo base_url(get_module() . "/dashboard") ?>">Home</a><i
								class="fa fa-circle"></i></li>
						<li><a href="<?php echo base_url(get_module() . "/customers/customer_report") ?>">All Customer
								Report </a><i class="fa fa-circle"></i></li>
						<li><span class="active"><?php echo $page_title; ?></span></li>
					</ul>
					<div class="portlet-title">
						<div class="caption">
							<i class="font-red-mint <?php echo $icon; ?> "></i>
							<span class="caption-subject  font-red-mint sbold"><?php echo $page_title; ?></span>
						</div>
					</div>
					<div class="row">
						<div class="portlet-body form">
							<?php if ($action == "Edit") {
								//echo "<pre/>"; print_r($details);die; 
								$details = html_escape($details);
								$formaction = "edit_customer/?id=" . base64_encode($id);
							} else if ($action == "Confirm") {
								$formaction = "confirm_lead/?ref_id=" . base64_encode($id);;
								// echo "<pre/>"; print_r($details);die; 
								$details = html_escape($details);
							} else {
								$formaction = "add_customer";
								// echo "<pre/>"; print_r($details);die; 
							}
							$subscriptionList = isset($details['subscriptionList']) ? $details['subscriptionList'] : "";
							$subscriptionServiceList = isset($details['subscriptionServiceList']) ? $details['subscriptionServiceList'] : "";
							$payment_installments = isset($details['installments']) ? $details['installments'] : "";
							$billPaymentList = isset($details['billPaymentList']) ? $details['billPaymentList'] : "";


							?>
							<form action="<?php echo get_module_path() . 'customers/' . $formaction; ?>"
								id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data">
								<div class="form-body py-0">
									<div class="col-md-12">
										<div class="portlet-body">
											<div class="portlet-title ">
												<div class="caption">
													<i class="font-red-mint icon-user"></i>
													<span class="caption-subject font-red-mint sbold">Basic
														Details</span>
												</div>
												<hr style="margin:3px;" />
											</div>

											<?php if ($action == "Edit") { ?>
												<input type="hidden" name="id" value="<?php echo $id; ?>">
												<input type="hidden" name="cust_type"
													value="<?php echo isset($details['cust_type']) ? $details['cust_type'] : ""; ?>">
											<?php } ?>

											<?php if ($action == "Confirm" || $action == "Add") { ?>
												<div class="form-group col-md-3">
													<label for="cust_service_type">Service
														Type</label><?php echo REQUIRED_STAR; ?>
													<select class="form-control" id="cust_service_type"
														name="cust_service_type" required onchange="get_services(this);">
														<option value=""> Select Service Type</option>
														<?php if (!empty($service_list)) {
															foreach ($service_list as $key => $service) {
																$service_type = isset($details['clm_priority_level']) ? $details['clm_priority_level'] : set_value("cust_service_type");
																$selected = $service == $service_type ? "selected" : "";
														?>
																<option value="<?php echo $key; ?>" <?php echo $selected; ?>>
																	<?php echo $service; ?>
																</option>
														<?php }
														} ?>
													</select>
													<?php echo form_error('cust_service_type', '<span class="text-danger">', '</span>'); ?>
												</div>

												<div class="form-group col-md-3">
													<label for="cust_gst_type">GST
														Option<?php echo REQUIRED_STAR; ?></label>
													<select class="form-control" id="cust_gst_type" name="cust_gst_type"
														required onchange="clear_service_details();">
														<option value=""> Select GST Option</option>
														<?php if (!empty($gst_type_list)) {
															foreach ($gst_type_list as $key => $gtype) {
																$cust_gst_type = isset($details['clm_priority_level']) ? $details['clm_priority_level'] : set_value("cust_gst_type");
																$selected = $gtype == $cust_gst_type ? "selected" : "";
														?>
																<option value="<?php echo $key; ?>" <?php echo $selected; ?>>
																	<?php echo $gtype; ?>
																</option>
														<?php }
														} ?>
													</select>
													<?php echo form_error('cust_gst_type', '<span class="text-danger">', '</span>'); ?>
												</div>


												<div class="form-group col-md-3">
													<label for="cust_type">Customer Type</label>
													<select class="form-control" id="cust_type" name="cust_type" required
														onchange="clear_service_details();">
														<?php if (!empty($cust_type_list)) {
															foreach ($cust_type_list as $key => $ctype) {
																$cust_type = isset($details['cust_type']) ? $details['cust_type'] : set_value("cust_type");
																$selected = $ctype == $cust_type ? "selected" : "";
														?>
																<option value="<?php echo $key; ?>" <?php echo $selected; ?>>
																	<?php echo $ctype; ?>
																</option>
														<?php }
														} ?>
													</select>
													<?php echo form_error('cust_type', '<span class="text-danger">', '</span>'); ?>
												</div>
											<?php } ?>
											<div class="form-group col-md-3">
												<label for="cust_gstno">Customer GST No</label>
												<input class="form-control" id="cust_gstno" name="cust_gstno"
													type="text" placeholder="Enter Customer GST No" maxlength="15"
													value="<?php echo isset($details['customer_gstno']) ? $details['customer_gstno'] : set_value("cust_gstno"); ?>">
												<?php echo form_error('cust_gstno', '<span class="text-danger">', '</span>'); ?>
											</div>

										</div>
									</div>



									<div class="col-md-12">
										<div class="portlet-title">
											<br />
											<div class="caption">
												<i class="font-red-mint icon-call-out"></i>
												<span class="caption-subject font-red-mint sbold">Contact Details</span>
											</div>
											<hr style="margin:3px;" />
										</div>
										<div class="form-group col-md-3">
											<label for="cust_name">Customer Name</label> <?php echo REQUIRED_STAR; ?>
											<input class="form-control" id="cust_name" name="cust_name" type="text"
												placeholder="Enter Customer Name" maxlength="100"
												value="<?php echo isset($details['customer_name']) ? $details['customer_name'] : set_value("cust_name"); ?>">
											<?php echo form_error('cust_name', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group col-md-3">
											<label for="cust_company_name">Company Name</label>
											<input class="form-control" id="cust_company_name" name="cust_company_name"
												type="text" placeholder="Enter Company Name" maxlength="100"
												value="<?php echo isset($details['cust_company_name']) ? $details['cust_company_name'] : set_value("cust_company_name"); ?>">
											<?php echo form_error('cust_company_name', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group col-md-3">
											<label for="cust_contact">Mobile No.</label>
											<input class="form-control" id="cust_contact" name="cust_contact"
												type="text" placeholder="Enter Mobile No." maxlength="10"
												value="<?php echo isset($details['customer_contact']) ? $details['customer_contact'] : set_value("cust_contact"); ?>">
											<?php echo form_error('cust_contact', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group col-md-3">
											<label for="cust_contact_email">Email Id</label>
											<input class="form-control" id="cust_contact_email"
												name="cust_contact_email" type="text" placeholder="Enter Email Id."
												maxlength="100"
												value="<?php echo isset($details['customer_contact_email']) ? $details['customer_contact_email'] : set_value("cust_contact_email"); ?>">
											<?php echo form_error('cust_contact_email', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group col-md-3">
											<label for="alt_cust_contact">Alternate Mobile No.</label>
											<input class="form-control" id="alt_cust_contact" name="alt_cust_contact"
												type="text" placeholder="Enter Alternate Mobile No." maxlength="10"
												value="<?php echo isset($details['customer_alt_contact']) ? $details['customer_alt_contact'] : set_value("alt_cust_contact"); ?>">
											<?php echo form_error('alt_cust_contact', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group col-md-3">
											<label for="cust_contact_person">Contact Person</label>
											<input class="form-control" id="cust_contact_person"
												name="cust_contact_person" type="text"
												placeholder="Enter Contact Person" maxlength="100"
												value="<?php echo isset($details['customer_contact_person']) ? $details['customer_contact_person'] : set_value("cust_contact_person"); ?>">
											<?php echo form_error('cust_contact_person', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group col-md-3">
											<label for="cust_landline">Landline No.</label>
											<input class="form-control" id="cust_landline" name="cust_landline"
												type="text" placeholder="Enter Landline No." maxlength="15"
												value="<?php echo isset($details['cust_landline']) ? $details['cust_landline'] : set_value("cust_landline"); ?>">
											<?php echo form_error('cust_landline', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group col-md-3">
											<label for="cust_website">Website</label>
											<input class="form-control" id="cust_website" name="cust_website"
												type="text" placeholder="Enter Website" maxlength="100"
												value="<?php echo isset($details['cust_website']) ? $details['cust_website'] : set_value("cust_website"); ?>">
											<?php echo form_error('cust_website', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group col-md-3">
											<label for="cust_dob">Date of Birth</label>
											<input class="form-control datepicker" id="cust_dob" name="cust_dob" type="text" placeholder="Enter Date of Birth" maxlength="15" value="<?php echo isset($details['cust_dob']) ? date("d-m-Y", strtotime($details['cust_dob'])) : set_value("cust_dob"); ?>">
											<?php echo form_error('cust_dob', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group col-md-6">
											<label for="cust_remark">Remark</label>
											<textarea class="form-control"
												id="cust_remark"
												name="cust_remark"
												rows="1"
												maxlength="1000"
												placeholder="Enter Additional Customer Information"><?php echo isset($details['cust_remark']) ? $details['cust_remark'] : set_value('cust_remark'); ?></textarea>
											<?php echo form_error('cust_remark', '<span class="text-danger">', '</span>'); ?>
										</div>

										<!-- Nandu 25/04/2025 -->
										<!--<div class="form-group col-md-3">
											<label for="cust_model">Model Name</label>
											<input class="form-control" id="cust_model" name="cust_model" type="text"
												placeholder="Enter Model Name" maxlength="100"
												value="<?php echo isset($details['cust_model_name']) ? $details['cust_model_name'] : set_value("cust_model_name"); ?>">
											<?php echo form_error('cust_model', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group col-md-3">
											<label for="cust_serial">Serial Number</label>
											<input class="form-control" id="cust_serial" name="cust_serial" type="text"
												placeholder="Enter Serial Number" maxlength="100"
												value="<?php echo isset($details['cust_serial_number']) ? $details['cust_serial_number'] : set_value("cust_serial_number"); ?>">
											<?php echo form_error('cust_serial', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group col-md-3">
											<label for="cust_registration">Registration Number</label>
											<input class="form-control" id="cust_registration" name="cust_registration"
												type="text" placeholder="Enter Registration Number" maxlength="100"
												value="<?php echo isset($details['cust_registration_number']) ? $details['cust_registration_number'] : set_value("cust_registration_number"); ?>">
											<?php echo form_error('cust_website', '<span class="text-danger">', '</span>'); ?>
										</div> -->
									</div>

									<div class="col-md-12">
										<div class="portlet-title">
											<br />
											<div class="caption">
												<i class="font-red-mint icon-pointer"></i>
												<span class="caption-subject font-red-mint sbold">Address Details</span>
											</div>
											<hr style="margin:3px;" />
										</div>
										<div class="form-group col-md-3">
											<label for="cust_address">Address</label>
											<input class="form-control" id="cust_address" name="cust_address"
												type="text" placeholder="Enter Address" maxlength="300"
												value="<?php echo isset($details['customer_address']) ? $details['customer_address'] : set_value("cust_address"); ?>">
											<?php echo form_error('cust_address', '<span class="text-danger">', '</span>'); ?>
										</div>

										<div class="form-group col-md-3">
											<label for="cust_stateid">State </label>
											<select class="form-control" id="cust_stateid" name="cust_stateid"
												onchange="get_state_districts(this,'cust_distid');">
												<?php
												$state_id = isset($details['customer_state_id']) ? $details['customer_state_id'] : set_value("cust_stateid");
												?>
												<option value=""> Select State</option>
												<?php
												if (!empty($state_list)) {
													foreach ($state_list as $state) {
														// Default Maharashtra if no state is selected
														if (empty($state_id) && strtolower($state['state_name']) == 'maharashtra') {
															$selected = "selected";
														} else {
															$selected = ($state_id == $state['state_id']) ? "selected" : "";
														}
												?>
														<option value="<?php echo $state['state_id']; ?>" <?php echo $selected; ?>>
															<?php echo $state['state_name']; ?>
														</option>
												<?php
													}
												}
												?>
											</select>
											<?php echo form_error('cust_stateid', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group col-md-3">
											<label for="cust_distid">District </label>
											<select class="form-control" id="cust_distid" name="cust_distid"
												onchange="get_district_cities(this,'cust_stateid','cust_cityid');">
												<option value=""> Select District</option>
												<?php if (!empty($dist_list)) {
													foreach ($dist_list as $dist) {
														$dist_id = isset($details['customer_dist_id']) ? $details['customer_dist_id'] : set_value("cust_distid");
														$selected = $dist_id == $dist['dist_id'] ? "selected" : "";

												?>
														<option value="<?php echo $dist['dist_id']; ?>" <?php echo $selected; ?>>
															<?php echo $dist['dist_name']; ?>
														</option>
												<?php }
												} ?>
											</select>
											<?php echo form_error('cust_distid', '<span class="text-danger">', '</span>'); ?>
										</div>
										<div class="form-group col-md-3">
											<label for="cust_cityid">City </label>
											<select class="form-control" id="cust_cityid" name="cust_cityid"
												onchange="get_city_area(this,'cust_stateid','cust_distid','cust_area');">
												<option value=""> Select City</option>
												<?php if (!empty($city_list)) {
													foreach ($city_list as $city) {
														$city_id = isset($details['customer_city_id']) ? $details['customer_city_id'] : set_value("cust_cityid");
														$selected = $city_id == $city['city_id'] ? "selected" : "";
												?>
														<option value="<?php echo $city['city_id']; ?>" <?php echo $selected; ?>>
															<?php echo $city['city_name']; ?>
														</option>
												<?php }
												} ?>
											</select>
											<?php echo form_error('cust_cityid', '<span class="text-danger">', '</span>'); ?>

										</div>
										<div class="form-group col-md-3">
											<label for="cust_area">Area</label>
											<select class="form-control" id="cust_area" name="cust_area">
												<option value=""> Select Area</option>
												<?php if (!empty($area_list)) {
													foreach ($area_list as $area) {
														$area_id = isset($details['customer_area']) ? $details['customer_area'] : set_value("cust_area");
														$selected = $area_id == $area['area_id'] ? "selected" : "";
												?>
														<option value="<?php echo $area['area_id']; ?>" <?php echo $selected; ?>>
															<?php echo $area['area_name']; ?>
														</option>
												<?php }
												} ?>
											</select>
											<?php echo form_error('cust_area', '<span class="text-danger">', '</span>'); ?>
										</div>




										<div class="form-group col-md-3">
											<label for="cust_pincode">Pincode</label>
											<input class="form-control" id="cust_pincode" name="cust_pincode"
												type="text" placeholder="Enter Pincode" maxlength="6"
												value="<?php echo isset($details['customer_pin']) ? $details['customer_pin'] : set_value("cust_pincode"); ?>">
											<?php echo form_error('cust_pincode', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>



									<!-- =========================================	START	============================================== -->

									<?php if (!empty($subscriptionList)) { ?>
										<div class="col-md-12">
											<div class="portlet-title">
												<br />
												<div class="caption">
													<i class="font-red-mint icon-check"></i>
													<span class="caption-subject font-red-mint sbold">All Service
														Details</span>
												</div>
												<hr style="margin:3px;" />
											</div>
											<div class="tbl-container ">
												<table class="table table-striped table-bordered table-advance table-hover"
													id="Editrtable">
													<tbody>

														<tr class="success">
															<th>Sr. No.</th>
															<th>Name</th>
															<th>Start Date </th>
															<th>End Date</th>
															<th>Status</th>
															<th width="15%">Action</th>
														</tr>
														<?php foreach ($subscriptionList as $key => $subserv) {
															$cust_subs_cbpmid = $subserv['cust_subs_cbpmid'];
															$sub_id = $subserv['cust_subs_id'];
															$cust_subs_custid = $subserv['cust_subs_custid'];
															$str = "?cust_id=" . base64_encode($cust_subs_custid) . "&sub_id=" . base64_encode($sub_id);
														?>
															<tr>

																<td style="display:none;"><input class="form-control datepicker"
																		id="service_id[]" name="service_id[]" type="text"
																		placeholder="Enter Customer Added Date" maxlength="15"
																		style="    width: 190px;text-align: center; height:28px;"
																		value="<?php echo $subserv['cust_subs_amcid'] ? $subserv['cust_subs_amcid'] : set_value("cust_subs_amcid"); ?>">
																</td>


																<td><?php echo $key + 1; ?> </td>
																<td><?php echo $subserv['cust_subs_type_name']; ?> </td>
																<td><input class="form-control datepicker"
																		id="cust_subs_startdate_n" name="cust_subs_startdate_n"
																		type="text" placeholder="Enter Customer Added Date"
																		maxlength="15"
																		style="    width: 190px;text-align: center; height:28px;"
																		value="<?php echo $subserv['cust_subs_startdate_n'] ? $subserv['cust_subs_startdate_n'] : set_value("cust_subs_startdate_n"); ?>">
																</td>

																<!-- <input class="form-control datepicker" id="cust_ui_date" name="cust_ui_date" type="text" placeholder="Enter Customer Added Date"  maxlength="15" value="<?php echo $subserv['cust_subs_startdate_n'] ? $subserv['cust_subs_startdate_n'] : set_value("cust_subs_startdate_n"); ?>"> -->


																<!-- <td><?php echo $subserv['cust_subs_enddate_n']; ?></td>				 -->


																<td><input class="form-control datepicker"
																		id="cust_subs_enddate_n" name="cust_subs_enddate_n"
																		type="text" placeholder="Enter Customer Added Date"
																		maxlength="15"
																		style="    width: 190px;text-align: center; height:28px;"
																		value="<?php echo $subserv['cust_subs_enddate_n'] ? $subserv['cust_subs_enddate_n'] : set_value("cust_subs_enddate_n"); ?>">
																</td>


																<td> <?php if ($subserv['cust_subs_status'] == "Active") {
																			echo "<span class='label label-success'>Active</span>";
																		} else if ($subserv['cust_subs_status'] == "Deactivated") {
																			echo "<span class='label label-danger'>Deactivated</span>";
																		} else {
																			echo "<span class='label label-warning'>" . $subserv['cust_subs_status'] . "</span>";
																		} ?> </td>
																<td>
																	<!-- <a  class="btn btn-primary btn-xs"  href="<?php echo get_module_path(); ?>customers/view_customer_subscriptions/<?php echo $str; ?>" title="View Details" data-toggle="modal" data-target="#form_modal_lg"><i class="fa fa-eye"></i></a> -->
																	<?php if (!empty($billPaymentList)) {
																		$cbpm_billno = $billPaymentList[0]['cbpm_billno']; ?>
																		<!-- <a  class="btn btn-danger btn-xs"  href="<?php echo get_module_path(); ?>customers/download_invoice_single/?ref_id=<?php echo $id; ?>&billno=<?php echo $cbpm_billno; ?>&cust_subs_cbpmid=<?php echo $cust_subs_cbpmid; ?>" title="Download Invoice" ><i class="fa fa-download"></i></a>  -->
																	<?php } ?>
																</td>
															</tr>
														<?php } ?>


													</tbody>
												</table>
											</div>
										</div>
									<?php } ?>

									<style>
										@media screen and (max-width: 768px) {
											.followuptbl {
												height: 200px;
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
												/* height: 300px; */
											}

											#Editrtable {
												width: 1000px;
											}
										}
									</style>
									<!-- ========================================================================================== -->


									<!-- ====================================================================================================================================================== -->

									<?php if (!empty($subscriptionServiceList)) { ?>

										<div class="col-md-12">
											<div class="portlet-title">
												<br />
												<div class="caption">
													<i class="font-red-mint icon-wrench"></i>
													<span class="caption-subject font-red-mint sbold">Active Service
														Details</span>
												</div>
												<hr style="margin:3px;" />
											</div>
											<?php foreach ($subscriptionServiceList as $subscription) { ?>
												<div class="tbl-box">
													<table class="table table-condensed">

														<tbody>
															<tr>
																<th width="20%"> Service Name </th>
																<td><?php echo isset($subscription['cust_subs_type_name']) ? $subscription['cust_subs_type_name'] : ""; ?>
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
																	<!-- <td style="display:none;"><input class="form-control datepicker" id="service_id[]" name="service_id[]" type="text" placeholder="Enter Customer Added Date"  maxlength="15" style="    width: 190px;text-align: center; height:28px;" value="<?php echo $subscription['serviceList']['cust_serv_amcid'] ? $subscription['serviceList']['cust_serv_amcid'] : set_value("cust_serv_amcid"); ?>"></td> -->
																</tr>


															<?php } ?>
														</tbody>
													</table>
												</div>

												<?php if (!empty($subscription['serviceList'])) { ?>

													<div class="tbl-container">
														<table class="table table-striped table-bordered table-advance table-hover"
															id="Editrtable">
															<tbody>
																<tr class="success">
																	<th>Sr. No.</th>
																	<th width="15%">Service Dates </th>
																	<th>Status </th>
																	<th> Ticket ID</th>
																	<th width="12%">Done On</th>
																	<th width="15%">Action</th>
																</tr>
																<?php foreach ($subscription['serviceList'] as $key => $serv) {
																	$cust_serv_id = base64_encode($serv['cust_serv_id']);
																?>
																	<tr>
																		<td><?php echo $key + 1; ?> </td>
																		<!-- <td><?php echo $serv['cust_serv_date_n']; ?> </td> -->

																		<td><input class="form-control datepicker"
																				id="cust_serv_date_n<?php echo $serv['cust_serv_amcid']; ?>[]"
																				name="cust_serv_date_n<?php echo $serv['cust_serv_amcid']; ?>[]"
																				type="text" placeholder="Enter Customer Added Date"
																				maxlength="15"
																				style="    width: 190px;text-align: center; height:28px;"
																				value="<?php echo $serv['cust_serv_date_n'] ? $serv['cust_serv_date_n'] : set_value("cust_serv_date_n"); ?>">
																		</td>

																		<td><?php echo $serv['cust_serv_status']; ?></td>
																		<td><?php if (!empty($serv['ticket_id'])) { ?>
																				<a
																					href="<?php echo get_module_path(); ?>customers/view_ticket/?id=<?php echo base64_encode($serv['ticket_id']); ?>&history=back"><?php echo $serv['ticket_id']; ?></a>
																			<?php } ?>
																		</td>
																		<td><?php echo $serv['cust_serv_doneondate_n']; ?></td>
																		<td>
																			<!-- <span><a href="<?php echo get_module_path(); ?>customers/schedule_service_ticket/?id=<?php echo $id; ?>&serv_id=<?php echo $cust_serv_id; ?>" class="btn btn-success btn-xs" title="Click To Schedule"><i class="fa fa-clock-o"></i> Schedule</a> -->
																			<!-- <a  class="btn btn-success btn-xs"  href="<?php echo get_module_path(); ?>customers/add_customer_follwoup/?id=<?php echo $id; ?>" title="Add Follow-up" data-toggle="modal" data-target="#form_modal"><i class="fa fa-whatsapp"></i></a> -->
																			<!-- <a href="<?php echo get_module_path(); ?>customers/add_customer_follwoup/?id=<?php echo $id; ?>" class="btn btn-success btn-xs"   title="wp"><i class="fa fa-whatsapp" data-toggle="modal" data-target="#form_modal"></i></a> -->
																			</span>

																		</td>
																	</tr>
																<?php } ?>
															</tbody>
														</table>
													</div>

												<?php } ?>

											<?php } ?>

											<hr />
										<?php } ?>


										<!-- =======================================================	END	=============================================================================================== -->

										<!-- Search By Services - dhnaraj - 13-08-24 -->
										<div class="col-md-12">
											<div class="portlet-title">
												<br />
												<div class="caption">
													<i class="font-red-mint icon-pointer"></i>
													<span class="caption-subject font-red-mint sbold">Service
														Details</span>
												</div>
												<hr style="margin:3px;" />
											</div>


											<div class="form-group col-md-3" style="position: relative;">
												<label for="cust_ui_date">Customer Added Date</label>
												<input class="form-control datepicker" id="cust_ui_date"
													name="cust_ui_date" type="text"
													placeholder="Enter Customer Added Date" maxlength="15"
													value="<?php echo isset($details['cust_uidate_n']) ? $details['cust_uidate_n'] : set_value("cust_ui_date"); ?>">
												<span class="m-0" id="hover-info" style="display: none">(Use This Field
													When Adding Back dated Date.)</span>
												<?php echo form_error('cust_ui_date', '<span class="text-danger">', '</span>'); ?>
											</div>

											<div class="form-group col-md-3">
												<label for="cust_service_det">Service Details</label>
												<input class="form-control" id="cust_service_det"
													name="cust_service_det" type="text"
													placeholder="If, Fill this details will be displyed on Invoice"
													maxlength="500"
													value="<?php echo isset($details['cust_service_det']) ? $details['cust_service_det'] : set_value("cust_service_det"); ?>">
												<?php echo form_error('cust_service_det', '<span class="text-danger">', '</span>'); ?>
											</div>


											<?php if ($action == "Confirm" || $action == "Add") { ?>
												<div class="form-group col-md-5">
													<div class="row d-flex align-items-end">
														<div class="col-md-8">
															<label for="cust_services_lbl" id="cust_services_lbl">Services &nbsp;
																&nbsp;</label> <br>
															<input type="text" id="amcSearch" placeholder="Search Services..."
																style="width:100%; padding: 5px; margin-bottom: 18px; border-radius: 5px; border: 1px solid #c2cad8;"
																onkeyup="filterAMCs();">
														</div>
														<div class="col-md-4" style="margin-top: 21px;">
															<button type="button" class="btn btn-primary btn-show-services" onclick="showServicesModal()">
																<i class="fa fa-eye"></i> Show Services
															</button>
														</div>
													</div>
												</div>
												<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#serviceModal">Add AMC</button> -->
												<span id="file_err"></span>
												<div class="form-group col-md-12 w-100">
													<div class="" style="border:1px solid #cdcdcd;" id="amcontainer">
														<table
															class="table table-striped table-bordered table-advance table-hover">
															<tbody id="tbl_service_id">
																<!-- Service rows will be populated here by the get_service_list function -->
															</tbody>
														</table>
													</div>
												</div>
											<?php } ?>
										</div>

										<style>
											#amcontainer {
												overflow-x: hidden;
												overflow-y: scroll;
												height: 200px;
											}

											@keyframes pulseGlow {
												0% {
													box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.6);
												}

												70% {
													box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
												}

												100% {
													box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
												}
											}

											.btn-show-services {
												animation: none;
											}

											.btn-show-services.active-pulse {
												animation: pulseGlow 1.5s infinite;
											}

											@media screen and (max-width: 768px) {

												.img-responsive,
												.img-thumbnail,
												.table,
												label #Ctables {
													width: 800px;
													/* Make the table take full width of the container */
													/* Allow horizontal scrolling if necessary */
												}

												#amcontainer {
													overflow-x: scroll;
													ovefow-y: scroll;
												}
											}
										</style>


										<div class="form-group col-md-3">
											<label for="cust_total_amount">Total Price</label>
											<!-- <input class="form-control" id="cust_total_amount" name="cust_total_amount" type="text" placeholder="Total Price" maxlength='8' value="0" readonly> -->
											<input class="form-control" id="cust_total_amount" name="cust_total_amount"
												type="text" placeholder="Total Price" maxlength='8'
												value="<?php echo isset($billPaymentList[0]['cbpm_total_amnt']) ? $billPaymentList[0]['cbpm_total_amnt'] : ""; ?>"
												readonly>

											<?php echo form_error('cust_total_amount', '<span class="text-danger">', '</span>'); ?>
										</div>
										<?php if ($action == "Edit") { ?>

											<div class="form-group col-md-3" id="edit_service_details">
												<label for="cbpm_amount_nogst">Package Amount</label>
												<!-- <input class="form-control" id="cust_total_amount" name="cust_total_amount" type="text" placeholder="Total Price" maxlength='8' value="0" readonly> -->
												<input class="form-control" id="cbpm_amount_nogst" name="cbpm_amount_nogst"
													type="text" placeholder="Total Package" maxlength='8'
													value="<?php echo isset($billPaymentList[0]['cbpm_amount_nogst']) ? $billPaymentList[0]['cbpm_amount_nogst'] : ""; ?>"
													readonly>

												<?php echo form_error('cbpm_amount_nogst', '<span class="text-danger">', '</span>'); ?>
											</div>

											<div class="form-group col-md-3">
												<label for="cust_total_amount1">Received Payment</label>
												<input class="form-control" id="cust_paid_amount" name="cust_total_amount1"
													type="text" placeholder="Total Price" maxlength='8'
													value="<?php echo isset($billPaymentList[0]['cbpm_received_amnt']) ? $billPaymentList[0]['cbpm_received_amnt'] : ""; ?>"
													readonly>


												<?php echo form_error('cust_total_amount1', '<span class="text-danger">', '</span>'); ?>
											</div>
											<div class="form-group col-md-3">
												<label for="cust_total_amount2">Balance Payment</label>
												<input class="form-control" id="cust_total_amount2"
													name="cust_total_amount2" type="text" placeholder="Total Price"
													maxlength='8'
													value="<?php echo isset($billPaymentList[0]['cbpm_balance_amnt']) ? $billPaymentList[0]['cbpm_balance_amnt'] : ""; ?>"
													readonly>


												<?php echo form_error('cust_total_amount2', '<span class="text-danger">', '</span>'); ?>
											</div>
										<?php } ?>

										<!-- <div class="form-group col-md-3">
										<label for="cust_unit_no">Unit No.</label>
										<input class="form-control" id="cust_unit_no" name="cust_unit_no"
											type="text" placeholder="Enter Unit No." maxlength="05"
											value="<?php echo isset($details['cust_unit_no']) ? $details['cust_unit_no'] : set_value("cust_unit_no"); ?>">
										<?php echo form_error('cust_unit_no', '<span class="text-danger">', '</span>'); ?>
									</div> -->
										<!-- <div class="form-group col-md-3">
										<label for="cust_form_no">Form No. </label>
										<input class="form-control" id="cust_form_no" name="cust_form_no"
											type="text" placeholder="Enter Form No." maxlength="05"
											value="<?php echo isset($details['cust_form_no']) ? $details['cust_form_no'] : set_value("cust_form_no"); ?>">
										<?php echo form_error('cust_form_no', '<span class="text-danger">', '</span>'); ?>
									</div> -->
										<div class="form-group col-md-3" style="visibility: hidden;">
											<label for="cust_form_no01">Form No. </label>
											<input class="form-control" id="cust_form_no01" name="cust_form_no01"
												type="text" placeholder="Enter Form No." maxlength="05"
												value="<?php echo isset($details['cust_form_no01']) ? $details['cust_form_no01'] : set_value("cust_form_no01"); ?>">
											<?php echo form_error('cust_form_no01', '<span class="text-danger">', '</span>'); ?>
										</div>

										<script>
											document.addEventListener('DOMContentLoaded', function() {
												var input = document.getElementById('cust_ui_date');
												var hoverInfo = document.getElementById('hover-info');

												// Show span on mouse over
												input.addEventListener('mouseover', function() {
													hoverInfo.style.display = 'block';
												});

												// Hide span on mouse out
												input.addEventListener('mouseout', function() {
													hoverInfo.style.display = 'none';
												});
											});
										</script>

										<div class="col-md-12">
											<i class="font-red-mint icon-wallet"></i>
											<span class="caption-subject font-red-mint sbold">Installments</span>
											<div class="form-group">

												<?php if ($action == "Confirm" || $action == "Add") { ?>

													<label>Do you want to pay in installments?</label>
												<?php } else { ?>
													<label>Do you want to edit pay in installments?</label>
												<?php } ?>
												<div>
													<label><input type="radio" name="pay_in_installments" value="yes">
														Yes</label>
													<label><input type="radio" name="pay_in_installments" value="no"
															checked> No</label>
												</div>
												<!-- Nandu 06-05-2025 -->
												<div id="installments_input_section" style="display: none;">
													<div class="form-group col-md-3">
														<label for="amc_duration">Installment Duration
														</label><?php echo REQUIRED_STAR; ?>
														<input class="form-control" required maxlength="4" id="amc_duration"
															name="amc_duration" list="all_amc_duration"
															placeholder="Select AMC Duration In Days" autocomplete="off"
															value="<?php echo isset($details['amc_duration']) ? $details['amc_duration'] : set_value('amc_duration'); ?>" />

														<datalist id="all_amc_duration">
															<?php if (!empty($duration_list)) {
																foreach ($duration_list as $key => $duration) { ?>
																	<option value="<?php echo $key; ?>"
																		label="<?php echo $duration; ?>">
																	</option>
															<?php }
															} ?>
														</datalist>
														<?php echo form_error('amc_duration', '<span class="text-danger">', '</span>'); ?>
													</div>

													<div>
														<label for="">Enter the number of installment</label><br>
														<input id="installment_count" class="form-control"
															style="width: 265px;" type="number"
															placeholder="No. of installments" maxlength='3'
															max="100" value="">
													</div>


												</div>
											</div>

										</div>
										<script>
											document.getElementById('installment_count').addEventListener('input', function() {
												const max = 100;
												if (parseInt(this.value) > max) {
													this.value = max;
												}
											});
										</script>

										<div id="installments_section" style="display: none;">
											<table class="table table-bordered" id="installments_table">
												<thead>
													<tr>
														<th>Next Installment Date</th>
														<th>Next Installment Amount</th>
														<th>Installment Start Date</th>
														<th>Installment End Date</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody id="installments_table_body">


												</tbody>
											</table>
										</div>

										<?php
										if (!empty($payment_installments)) { ?>
											<div id="installments_section_old">
												<table class="table table-bordered" id="installments_table">
													<thead>
														<tr>
															<th>Next Installment Date</th>
															<th>Next Installment Amount</th>
															<th>Installment Start Date</th>
															<th>Installment End Date</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody id="installments_table_body_old">
														<?php
														if (!empty($payment_installments)) {
															foreach ($payment_installments as $installment) {
																$isPaid = isset($installment['cbpi_status']) && $installment['cbpi_status'] === 'Paid';

																if ($isPaid) {
																	continue; // Skip paid installments

																} ?>

																<tr>
																	<td>
																		<div class="form-group col-md-12">

																			<input type="hidden" name="installment_id[]"
																				value="<?php echo isset($installment['cbpi_id']) ? htmlspecialchars($installment['cbpi_id']) : ''; ?>">
																			<label for="cust_pay_nxt_dt">Date</label>
																			<input class="form-control " id="cust_pay_nxt_dt"
																				name="next_installment_date01[]" type="text"
																				placeholder="Select Date" maxlength="100"
																				value="<?php echo isset($installment['cbpi_pay_next_date']) ? htmlspecialchars($installment['cbpi_pay_next_date']) : ''; ?>"
																				readonly>
																			<?php echo form_error('next_installment_date01[]', '<span class="text-danger">', '</span>'); ?>
																		</div>
																	</td>

																	<td>
																		<div class="form-group col-md-12">
																			<label for="cust_pay_nxt_amt">Amt.</label>
																			<input class="form-control" id="cust_pay_nxt_amt"
																				name="next_installment_amount01[]" type="text"
																				placeholder="Enter Amount" maxlength="100"
																				value="<?php echo isset($installment['cbpi_pay_next_amount']) ? htmlspecialchars($installment['cbpi_pay_next_amount']) : ''; ?>"
																				readonly>
																			<span class="installment-error text-danger"
																				style="display: none;"></span>
																			<?php echo form_error('next_installment_amount01[]', '<span class="text-danger">', '</span>'); ?>
																		</div>
																	</td>
																	<td>
																		<div class="form-group col-md-12">
																			<label for="cust_pay_nxt_start_date">Start Date</label>
																			<input class="form-control " id="cust_pay_nxt_start_date"
																				name="next_installment_start_date01[]" type="text"
																				placeholder="Enter Start Date" maxlength="100"
																				value="<?php echo isset($installment['cbpi_pay_next_start_date']) ? htmlspecialchars($installment['cbpi_pay_next_start_date']) : ''; ?>"
																				readonly>
																			<span class="installment-error text-danger"
																				style="display: none;"></span>
																			<?php echo form_error('next_installment_start_date01[]', '<span class="text-danger">', '</span>'); ?>
																		</div>
																	</td>
																	<td>
																		<div class="form-group col-md-12">
																			<label for="cust_pay_nxt_end_date">End Date</label>
																			<input class="form-control " id="cust_pay_nxt_end_date"
																				name="next_installment_end_date01[]" type="text"
																				placeholder="Enter End Date" maxlength="100"
																				value="<?php echo isset($installment['cbpi_pay_next_end_date']) ? htmlspecialchars($installment['cbpi_pay_next_end_date']) : ''; ?>"
																				readonly>
																			<span class="installment-error text-danger"
																				style="display: none;"></span>
																			<?php echo form_error('next_installment_end_date01[]', '<span class="text-danger">', '</span>'); ?>
																		</div>
																	</td>
																	<td>

																	</td>
																</tr>
														<?php }
														}


														?>

													</tbody>
												</table>
											</div>
										<?php } ?>


										<div class="col-md-12" id="full_payment_section" style="display: block;">
											<?php if ($action == "Confirm" || $action == "Add") { ?>
												<div class="portlet-body">
													<div class="portlet-title">
														<div class="caption">
															<i class="font-red-mint icon-wallet"></i>
															<span class="caption-subject font-red-mint sbold">Payment
																Details</span>
														</div>
														<hr style="margin:3px;" />
													</div>
													<div class="form-group col-md-3">
														<label for="company_pay_type">Payment Mode</label>
														<select class="form-control" id="company_pay_type"
															name="company_pay_type" onchange="get_payment_details(this);">
															<option value=""> Payment Mode</option>
															<?php if (!empty($payment_mode_list)) {
																foreach ($payment_mode_list as $key => $pay) { ?>
																	<option value="<?php echo $key; ?>"><?php echo $pay; ?></option>
															<?php }
															} ?>
														</select>
													</div>
													<div class="form-group col-md-3">
														<label for="cust_paid_amount">Paid Amount </label>
														<input class="form-control" id="cust_paid_amount"
															name="cust_paid_amount" type="number"
															placeholder="Total Paid Amount" maxlength='8' value="0">
														<?php echo form_error('cust_paid_amount', '<span class="text-danger">', '</span>'); ?>
													</div>



													<!-- <div class="form-group col-md-6">								  								
														<label for="cust_paid_amount">Installments <?php echo REQUIRED_STAR; ?></label>
													</div> -->

													<div class="col-md-12 hidden" id="cheque_details">
														<div class="portlet-title">
															<br />
															<div class="caption">
																<i class="font-red-mint  icon-note"></i>
																<span class="caption-subject font-red-mint sbold">Cheque
																	Details</span>
															</div>
															<hr style="margin:3px;" />
														</div>
														<div class="form-group col-md-3">
															<label for="company_cheque_bankname">Bank
																Name</label><?php echo REQUIRED_STAR; ?>
															<input class="form-control" id="company_cheque_bankname"
																name="company_cheque_bankname" type="text"
																placeholder="Enter Bank Name" maxlength="100"
																value="<?php echo set_value("company_cheque_bankname"); ?>">
															<?php echo form_error('company_cheque_bankname', '<span class="text-danger">', '</span>'); ?>
														</div>
														<div class="form-group col-md-3">
															<label for="company_chequeno">Bank Cheque
																Number</label><?php echo REQUIRED_STAR; ?>
															<input class="form-control" id="company_chequeno"
																name="company_chequeno" type="text"
																placeholder="Enter Cheque Number" maxlength="6"
																value="<?php echo set_value("company_chequeno"); ?>">
															<?php echo form_error('company_chequeno', '<span class="text-danger">', '</span>'); ?>
														</div>
														<div class="form-group col-md-3">
															<label for="company_cheque_date">Cheque
																Date</label><?php echo REQUIRED_STAR; ?>
															<input class="form-control datepicker" id="company_cheque_date"
																name="company_cheque_date" type="text"
																placeholder="Enter Cheque Date" maxlength="15"
																value="<?php echo set_value("company_cheque_date"); ?>">
															<?php echo form_error('company_cheque_date', '<span class="text-danger">', '</span>'); ?>
														</div>
														<div class="form-group col-md-3">
															<label for="company_chequeimg">Cheque
																Image</label><?php echo REQUIRED_STAR; ?>
															<input type="file" name="company_chequeimg" id="company_chequeimg"
																class="smart-file" data-label="Cheque Image"
																data-btn-class="btn btn-default btn-sm" data-preview="on"
																data-file-types="image/jpeg,image/png,image/jpg" />
															<?php echo form_error('company_chequeimg', '<span class="text-danger">', '</span>'); ?>


															<span class="file_err"></span>
														</div>
													</div>
													<div class="col-md-12 hidden" id="dd_details">
														<div class="portlet-title">
															<br />
															<div class="caption">
																<i class="font-red-mint  icon-note"></i>
																<span class="caption-subject font-red-mint sbold">DD
																	Details</span>
															</div>
															<hr style="margin:3px;" />
														</div>
														<div class="form-group col-md-3">
															<label for="company_dd_bank_name">Bank
																Name</label><?php echo REQUIRED_STAR; ?>
															<input class="form-control" id="company_dd_bank_name"
																name="company_dd_bank_name" type="text"
																placeholder="Enter Bank Name" maxlength="100"
																value="<?php echo set_value("company_dd_bank_name"); ?>">
															<?php echo form_error('company_dd_bank_name', '<span class="text-danger">', '</span>'); ?>
														</div>
														<div class="form-group col-md-3">
															<label for="company_dd_no">DD Number</label>
															<input class="form-control" id="company_dd_no" name="company_dd_no"
																type="text" placeholder="Enter DD Number" maxlength="6"
																value="<?php echo set_value("company_dd_no"); ?>">
															<?php echo form_error('company_dd_no', '<span class="text-danger">', '</span>'); ?>
														</div>
														<div class="form-group col-md-3">
															<label for="company_dd_date">DD Date</label>
															<input class="form-control datepicker" id="company_dd_date"
																name="company_dd_date" type="text" placeholder="Enter DD Date"
																maxlength="15"
																value="<?php echo set_value("company_dd_date"); ?>">
															<?php echo form_error('company_dd_date', '<span class="text-danger">', '</span>'); ?>
														</div>
														<div class="form-group col-md-3">
															<label for="company_dd_img">DD Image</label><br />
															<input type="file" name="company_dd_img" id="company_dd_img"
																class="smart-file" data-label="DD Image"
																data-btn-class="btn btn-default btn-sm" data-preview="on"
																data-file-types="image/jpeg,image/png,image/jpg" />
															<?php echo form_error('company_dd_img', '<span class="text-danger">', '</span>'); ?>


															<span class="file_err"></span>
														</div>
													</div>

													<div class="col-md-12 hidden" id="online_details">
														<div class="portlet-title">
															<br />
															<div class="caption">
																<i class="font-red-mint  icon-note"></i>
																<span class="caption-subject font-red-mint sbold">Online
																	Transaction Details</span>
															</div>
															<hr style="margin:3px;" />
														</div>
														<div class="form-group col-md-4">
															<label for="company_online_trxn_id">Transaction
																Id</label><?php echo REQUIRED_STAR; ?>
															<input class="form-control" id="company_online_trxn_id"
																name="company_online_trxn_id" type="text"
																placeholder="Enter Transaction Id" maxlength="100"
																value="<?php echo set_value("company_online_trxn_id"); ?>">
															<?php echo form_error('company_online_trxn_id', '<span class="text-danger">', '</span>'); ?>
														</div>
														<div class="form-group col-md-4">
															<label for="company_payment_id">Payment
																Id</label><?php echo REQUIRED_STAR; ?>
															<input class="form-control" id="company_payment_id"
																name="company_payment_id" type="text"
																placeholder="Enter Payment Id" maxlength="100"
																value="<?php echo set_value("company_payment_id"); ?>">
															<?php echo form_error('company_payment_id', '<span class="text-danger">', '</span>'); ?>
														</div>

														<div class="form-group col-md-4">
															<label for="company_order_id">Order
																Id</label><?php echo REQUIRED_STAR; ?>
															<input class="form-control" id="company_order_id"
																name="company_order_id" type="text" placeholder="Enter Order Id"
																maxlength="100"
																value="<?php echo set_value("company_order_id"); ?>">
															<?php echo form_error('company_order_id', '<span class="text-danger">', '</span>'); ?>
														</div>
													</div>

												</div>
										</div>
									<?php } ?>
										</div>

										<?php
										// Check if form is submitted
										if ($_SERVER['REQUEST_METHOD'] === 'POST') {
											$dates = $_POST['next_installment_date'] ?? [];
											$amounts = $_POST['next_installment_amount'] ?? [];
											$start_dates = $_POST['next_installment_start_date'] ?? [];
											$end_dates = $_POST['next_installment_end_date'] ?? [];

											// Echo values to validate
											echo '<h4>Submitted Data for Validation</h4>';
											echo '<pre>';
											echo 'Next Installment Dates: ';
											print_r($dates);
											echo 'Next Installment Amounts: ';
											print_r($amounts);
											echo 'Start Dates: ';
											print_r($start_dates);
											echo 'End Dates: ';
											print_r($end_dates);
											echo '</pre>';

											// Display as table for better readability
											echo '<h4>Submitted Installments</h4>';
											echo '<table class="table table-bordered">';
											echo '<thead><tr><th>Installment Date</th><th>Installment Amount</th></tr></thead><tbody>';
											foreach ($dates as $index => $date) {
												$amount = $amounts[$index] ?? '';
												$start_dates = $start_dates[$index] ?? '';
												$end_dates = $end_dates[$index] ?? '';
												echo '<tr>';
												echo '<td>' . htmlspecialchars($date) . '</td>';
												echo '<td>' . htmlspecialchars($amount) . '</td>';
												echo '<td>' . htmlspecialchars($start_dates) . '</td>';
												echo '<td>' . htmlspecialchars($end_dates) . '</td>';
												echo '</tr>';
											}
											echo '</tbody></table>';
										}
										?>

										<script>
											document.addEventListener("DOMContentLoaded", function() {
												const action = "<?php echo $action; ?>";

												const installmentSection = document.getElementById("installments_section");
												const installmentSection_old = document.getElementById("installments_section_old");
												const full_payment_section = document.getElementById("full_payment_section");
												const paidAmountInput = document.getElementById("cust_paid_amount");

												const installments_input_section = document.getElementById("installments_input_section");
												const amc_duration = document.getElementById("amc_duration");
												const installment_count = document.getElementById("installment_count");

												const radios = document.querySelectorAll("input[name='pay_in_installments']");

												radios.forEach(radio => {
													radio.addEventListener("change", function() {
														document.getElementById("installments_table_body").innerHTML = ""; // Clear table rows

														if (this.value === "yes") {
															if (installmentSection) installmentSection.style.display = "block";
															if (action === "Edit" && installmentSection_old) installmentSection_old.style.display = "none";
															if (full_payment_section) full_payment_section.style.display = "none";
															if (paidAmountInput && action !== "Edit") paidAmountInput.value = "";
															if (installments_input_section) installments_input_section.style.display = "block";
														} else {
															if (installmentSection) installmentSection.style.display = "none";
															if (action === "Edit" && installmentSection_old) installmentSection_old.style.display = "block";
															if (full_payment_section) full_payment_section.style.display = "block";
															if (installments_input_section) installments_input_section.style.display = "none";
															if (amc_duration) amc_duration.value = "";
															if (installment_count) installment_count.value = "";
														}
													});
												});
											});
										</script>

										<div class="col-md-12">
											<div class="portlet-title">
												<br />
												<div class="caption">
													<i class="font-red-mint  icon-user"></i>
													<span class="caption-subject font-red-mint sbold">Reference Details</span>
												</div>
												<hr style="margin:3px;" />
											</div>
											<div class="form-group col-md-3">
												<label for="cust_refbyid">Reference By</label>
												<select class="form-control" id="cust_refbyid" name="cust_refbyid"
													onchange="get_reference_details(this);">
													<option value=""> Select Reference By </option>
													<?php if (!empty($reference_list)) {
														foreach ($reference_list as $key => $ref) {
															$reference = isset($details['cust_ref_id']) ? $details['cust_ref_id'] : "";
															$selected = $reference == $ref['ref_id'] ? "selected" : ""; ?>
															<option value="<?php echo $ref['ref_id']; ?>" <?php echo $selected; ?>>
																<?php echo $ref['ref_name']; ?>
															</option>
													<?php }
													} ?>
												</select>
											</div>

											<div class="form-group col-md-3">
												<label for="cust_refbyname">Reference Name</label>
												<input class="form-control" id="cust_refbyname" name="cust_refbyname"
													type="text" placeholder="Enter Reference Name" maxlength="200"
													value="<?php echo isset($details['cust_ref_name']) ? $details['cust_ref_name'] : set_value("cust_refbyname"); ?>">
												<?php echo form_error('cust_refbyname', '<span class="text-danger">', '</span>'); ?>
											</div>

											<div class="form-group col-md-3">
												<label for="cust_refby_contact">Reference Contact</label>
												<input class="form-control" id="cust_refby_contact" name="cust_refby_contact"
													type="text" placeholder="Enter Reference Contact" maxlength="10"
													value="<?php echo isset($details['cust_ref_contact']) ? $details['cust_ref_contact'] : set_value("cust_refby_contact"); ?>">
												<?php echo form_error('cust_refby_contact', '<span class="text-danger">', '</span>'); ?>
											</div>
											<div class="form-group col-md-3">
												<label for="cust_refby_email">Reference Email Id</label>
												<input class="form-control" id="cust_refby_email" name="cust_refby_email"
													type="email" placeholder="Enter Reference Email Id." maxlength="100"
													value="<?php echo isset($details['cust_ref_email']) ? $details['cust_ref_email'] : set_value("cust_refby_email"); ?>">
												<?php echo form_error('cust_refby_email', '<span class="text-danger">', '</span>'); ?>
											</div>

										</div>

										<div class="col-md-12">
											<div class="portlet-title">
												<br />
												<div class="caption">
													<i class="font-red-mint  icon-mobile"></i>
													<span class="caption-subject font-red-mint sbold"> Alternate Contact
														Details</span>
												</div>
												<hr style="margin:3px;" />

											</div>
											<div class="col-md-12">

												<?php if ($action == "Add" || (isset($details['contactList']) && empty($details['contactList']))) { ?>
													<div class="mt-repeater">
														<div data-repeater-list="group-b">
															<div data-repeater-item="" class="row" style="margin-bottom: 10px;">
																<div class="col-md-3">
																	<label class="control-label">Contact Person</label>
																	<input type="text" name="lead_altcontactperson"
																		placeholder="Contact Person"
																		class="form-control lead_altcontactperson" maxlength="100">
																</div>
																<div class="col-md-3">
																	<label class="control-label">Contact No.</label>
																	<input type="text" name="lead_altcontact"
																		placeholder="Contact No." maxlength="10"
																		class="form-control lead_altcontact">
																</div>
																<div class="col-md-3">
																	<label class="control-label">Email Id.</label>
																	<input type="text" name="lead_altemail" placeholder="Email Id."
																		maxlength="100" class="form-control lead_altemail">
																</div>
																<!-- <div class="col-md-3" style="margin-top:5px;">
																	<br>

																	<label class="control-label">&nbsp;</label>
																	<a href="javascript:;" data-repeater-delete=""
																		class="btn btn-danger">
																		<i class="fa fa-close"></i>
																	</a>
																</div> -->
																<div class="col-md-3 action-buttons" style="margin-top:25px;">

																	<a href="javascript:;" class="btn btn-info btn-add-contact">
																		<i class="fa fa-plus"></i>
																	</a>

																	<a href="javascript:;" 
																		class="btn btn-danger btn-delete-contact"
																		style="display:none;">
																		<i class="fa fa-close"></i>
																	</a>

																</div>
															</div>
														</div>
														<a href="javascript:;"
															data-repeater-create
															id="hiddenRepeaterAdd"
															style="display:none;">
														</a>

														<!-- <div class=" col-md-4"
															style="height: 36px;align-items: center;margin: 10px 0px;display: flex;justify-content: flex-start;padding:0px;">
															<p>Add More Alternative Contact &nbsp; &nbsp; &nbsp;</p>
															<a href="javascript:;" data-repeater-create=""
																class="btn btn-info mt-repeater-add pull-right">
																<i class="fa fa-plus"></i></a>
															<span class="text-danger" id="err_msg"></span><br>
														</div> -->

													</div>

												<?php } ?>

												<?php if ($action == "Edit" && (isset($details['contactList']) && !empty($details['contactList']))) { ?>
													<div class="mt-repeater">
														<div data-repeater-list="group-b">
															<?php foreach ($details['contactList'] as $key => $cont) { ?>
																<div data-repeater-item="" class="row" style="margin-bottom: 10px;">
																	<div class="col-md-3">
																		<label class="control-label">Contact Person</label>
																		<input type="text"
																			name="group-b[<?php echo $key; ?>][lead_altcontactperson]"
																			placeholder="Contact Person"
																			class="form-control lead_altcontactperson" maxlength="100"
																			value="<?php echo $cont['cust_contact_person']; ?>">
																	</div>
																	<div class="col-md-3">
																		<label class="control-label">Contact No.</label>
																		<input type="text"
																			name="group-b[<?php echo $key; ?>][lead_altcontact]"
																			placeholder="Contact No." maxlength="10"
																			class="form-control lead_altcontact"
																			value="<?php echo $cont['cust_contact_no']; ?>">
																	</div>
																	<div class="col-md-3">
																		<label class="control-label">Email Id.</label>
																		<input type="text"
																			name="group-b[<?php echo $key; ?>][lead_altemail]"
																			placeholder="Email Id." maxlength="100"
																			class="form-control lead_altemail"
																			value="<?php echo $cont['cust_contact_emailid']; ?>">
																	</div>
																	<div class="col-md-3 action-buttons" style="margin-top:25px;">

																		<a href="javascript:;" class="btn btn-info btn-add-contact">
																			<i class="fa fa-plus"></i>
																		</a>

																		<a href="javascript:;" 
																			class="btn btn-danger btn-delete-contact"
																			style="display:none;">
																			<i class="fa fa-close"></i>
																		</a>

																	</div>
																</div>
															<?php } ?>
														</div>
														<a href="javascript:;"
															data-repeater-create
															id="hiddenRepeaterAdd"
															style="display:none;">
														</a>
														<!-- <div class="col-md-4" style="height: 36px;align-items: center;margin: 10px 0px;display: flex;justify-content: flex-start;padding:0px;">
															<p>Add More Alternative Contact &nbsp; &nbsp; &nbsp;</p>
															<a href="javascript:;" data-repeater-create=""
																class="btn btn-info mt-repeater-add pull-right">
																<i class="fa fa-plus"></i></a>
															<br>
															<span class="text-danger" id="err_msg"></span><br>
														</div> -->
													</div>
												<?php } ?>

											</div>

										</div>


										<div class="col-md-12">
											<div class="form-actions">
												<center>
													<button type="submit" class="btn btn-success" id="add_edit_form_btn">Submit</button>
													<a href="<?php echo get_module_path(); ?>customers/customer_report/?history=back"
														class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
												</center>

												<!-- Container to show the error message -->
												<div id="error-message" style="display:none; color:red;">
													Amount should be equal to Total Amount.
												</div>
											</div>
										</div>

										<div class="modal fade" id="serviceModal1" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
											<div class="modal-dialog custom-modal">
												<div class="modal-content">
													<div class="box" style="overflow-x: auto; white-space: nowrap; max-height: 70vh;border: 1px solid rgb(205, 205, 205); margin: 10px;">
														<div class="modal-header d-flex justify-content-between align-items-center">
															<h5 class="modal-title mb-0" id="service_detal_lbl" style=" display: inline-block; width: auto;">
																Service Details
															</h5>
															<button type="button" class="close" data-dismiss="modal">
																&times;
															</button>
														</div>
														<table class="table table-bordered">
															<thead id="services_tbl_header"> </thead>

															<tbody id="tbl_service_details">
																<!-- Service details will be populated here -->
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
							</form>

							<!-- /.box-body -->
							<script>
								(function() {
								const button = document.getElementById('add_edit_form_btn');
								if (!button) return;

								button.addEventListener('click', function() {
									// Clicked button becomes disabled after 1 second
									setTimeout(() => {
										button.disabled = true;

										// Re-enable the button after an additional 2 seconds (total of 3 seconds from click)
										setTimeout(() => {
											button.disabled = false;
										}, 1000);
									});
								});
								})();
							</script>

						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE BASE CONTENT -->
	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<div class="modal" id="serviceModal">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Add Service</h4>
				<button type="button" class="close" data-dismiss="modal">&times;"></button>
			</div>

			<!-- Modal Body -->
			<div class="modal-body">
				<form id="serviceForm" method="post" action="your_action_url_here">
					<!-- Service Type Selection -->
					<div class="form-group">
						<label for="serviceType">Select Service Type</label>
						<select class="form-control" id="serviceType" name="service_type"
							onchange="handleServiceTypeChange()">
							<option value="AMC">AMC</option>
							<option value="OneTimeService">One Time Service</option>
							<option value="Product">Product</option>
						</select>
					</div>

					<!-- AMC Specific Fields -->
					<div id="amcFields">
						<!-- AMC Duration -->
						<div class="form-group">
							<label for="amcDuration">AMC Duration (Days)</label>
							<input type="number" class="form-control" id="amcDuration" name="amc_duration"
								placeholder="Enter AMC Duration" onchange="calculateServiceInterval()">
						</div>

						<!-- Number of Services -->
						<div class="form-group">
							<label for="amcNoOfServices">Number of Services</label>
							<input type="number" class="form-control" id="amcNoOfServices" name="amc_no_of_services"
								placeholder="Enter Number of Services" onchange="calculateServiceInterval()">
						</div>

						<!-- Service Interval Time -->
						<div class="form-group">
							<label for="amcSIT">Service Interval Time (Days)</label>
							<input type="text" class="form-control" id="amcSIT" name="amc_sit" readonly>
						</div>
					</div>

					<!-- Product Specific Fields -->
					<div id="productFields" style="display: none;">
						<!-- Product Name -->
						<div class="form-group">
							<label for="productName">Product Name</label>
							<input type="text" class="form-control" id="productName" name="product_name"
								placeholder="Enter Product Name">
						</div>

						<!-- Product Warranty -->
						<div class="form-group">
							<label for="productWarranty">Product Warranty (Months)</label>
							<input type="number" class="form-control" id="productWarranty" name="product_warranty"
								placeholder="Enter Product Warranty">
						</div>
					</div>

					<!-- One Time Service Fields -->
					<div id="oneTimeServiceFields" style="display: none;">
						<!-- Service Date -->
						<div class="form-group">
							<label for="serviceDate">Service Date</label>
							<input type="date" class="form-control" id="serviceDate" name="service_date">
						</div>

						<!-- Service Description -->
						<div class="form-group">
							<label for="serviceDescription">Service Description</label>
							<textarea class="form-control" id="serviceDescription" name="service_description"
								placeholder="Enter Service Description"></textarea>
						</div>
					</div>

					<!-- Submit Button -->
					<button type="submit" id="serviceSubmitBtn" class="btn btn-success">Submit</button>
				</form>
			</div>

			<script>
				(function() {
				const button = document.getElementById('serviceSubmitBtn');
				if (!button) return;

				button.addEventListener('click', function() {
					// Clicked button becomes disabled after 1 second
					setTimeout(() => {
						button.disabled = true;

						// Re-enable the button after an additional 2 seconds (total of 3 seconds from click)
						setTimeout(() => {
							button.disabled = false;
						}, 1000);
					});
				});
				})();
			</script>


			<!-- Modal Footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>
<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
		</div>
	</div>
</div>
<div class="modal fade" id="list_modal" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		</div>
	</div>
</div>
<!--END START MODAL -->
<!-- Nandu 06-05-2025 -->
<div class="modal fade" id="deleteContactModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">

			<div class="modal-header bg-danger">
				<h4 class="modal-title">Delete Alternate Contact</h4>
			</div>

			<div class="modal-body">
				Are you sure you want to remove this alternate contact?
			</div>

			<div class="modal-footer">
				<button type="button"
					class="btn btn-default"
					data-dismiss="modal">
					Cancel
				</button>

				<button type="button"
					class="btn btn-danger"
					id="confirmDeleteContact">
					Delete
				</button>
			</div>

		</div>
	</div>
</div>

<style>
	.custom-modal {
		max-width: 95% !important;
		width: 95%;
	}

	.modal.fade .modal-dialog {
		transform: translateY(-20px);
	}

	.modal.show .modal-dialog {
		transform: translateY(0);
		transition: all 0.3s ease;
	}
</style>

<!-- Include jQuery and Bootstrap JS for modal functionality -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
	function calculateServiceInterval() {
		var duration = parseFloat(document.getElementById('amcDuration').value);
		var noOfServices = parseFloat(document.getElementById('amcNoOfServices').value);
		var serviceIntervalTimeField = document.getElementById('amcSIT');

		if (isNaN(duration) || duration <= 0) {
			serviceIntervalTimeField.value = '';
			return;
		}

		if (isNaN(noOfServices) || noOfServices <= 0) {
			// If number of services is not provided, use the duration value
			serviceIntervalTimeField.value = duration;
		} else {
			// Calculate the service interval time
			var serviceInterval = duration / noOfServices;
			serviceIntervalTimeField.value = serviceInterval.toFixed(2);
		}
	}

	function handleServiceTypeChange() {
		var serviceType = document.getElementById('serviceType').value;
		var amcFields = document.getElementById('amcFields');
		var productFields = document.getElementById('productFields');
		var oneTimeServiceFields = document.getElementById('oneTimeServiceFields');

		// Hide all sections initially
		amcFields.style.display = 'none';
		productFields.style.display = 'none';
		oneTimeServiceFields.style.display = 'none';

		// Show the relevant section based on selected service type
		if (serviceType === 'AMC') {
			amcFields.style.display = 'block';
		} else if (serviceType === 'Product') {
			productFields.style.display = 'block';
		} else if (serviceType === 'OneTimeService') {
			oneTimeServiceFields.style.display = 'block';
		}
	}
</script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js"
	type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js"
	type="text/javascript"></script>

<script type="text/javascript">
	// Add Branch
	var action = "<?php echo $action; ?>";


	$(document).ready(function() {


		if (action === "Add") {
			var state = $('#cust_stateid').val();

			if (state) {
				get_state_districts(document.getElementById('cust_stateid'), 'cust_distid');

				// Optional (if edit case)
				setTimeout(function() {
					var dist = $('#cust_distid').val();
					if (dist) {
						get_district_cities(document.getElementById('cust_distid'), 'cust_stateid', 'cust_cityid');
					}
				}, 500);
			}
		}

		$('.smart-file').bootstrapFileField({
			maxNumFiles: 8,
			fileTypes: 'image/jpeg,image/png,image/jpg',
			/* 	minNumFiles:1, */
			maxFileSize: 4000000 // 8Mb in bytes */
		});


		$('#bank_ifsc').change(function() {
			var bank_ifsc = $("#bank_ifsc").val();
			getIFSC(bank_ifsc);
		});


		$('.datepicker').datepicker({
			format: 'dd-M-yyyy',
			autoclose: true,
			todayHighlight: true,

		});

		$("#add_edit_form").validate({
			rules: {
				required: {
					required: true
				},
				cust_service_type: {
					required: true,
				},
				cust_gst_type: {
					required: true,
				},
				cust_type: {
					required: true,
				},

				cust_gstno: {
					maxlength: 15,
					gst: true,
					minlength: 2,
				},

				cust_name: {
					required: true,
					maxlength: 100,
					minlength: 2,
				},
				cust_company_name: {
					maxlength: 100,
					minlength: 2,
				},
				cust_contact_person: {
					maxlength: 100,
					minlength: 2,
				},
				cust_contact: {
					maxlength: 10,
					minlength: 10,
					digits: true,
				},
				alt_cust_contact: {
					maxlength: 10,
					minlength: 10,
					digits: true,
				},
				cust_landline: {
					maxlength: 15,
					digits: true,
				},
				cust_contact_email: {
					maxlength: 100,
					email: true,
				},
				cust_website: {

					maxlength: 100,
				},
				company_chequeno: {
					maxlength: 6,
					digits: true,
				},
				company_dd_no: {

					maxlength: 6,
					digits: true,
				},
				company_chequeimg: {
					accept: "image/jpeg,image/png,image/jpg",
					filesize_max: 1000000, // 1 MB
				},
				company_dd_img: {
					accept: "image/jpeg,image/png,image/jpg",
					filesize_max: 1000000, // 1 MB
				},
				company_online_trxn_id: {
					maxlength: 100,
					minlength: 2,
				},
				company_payment_id: {
					maxlength: 100,
					minlength: 2,
				},
				company_order_id: {
					maxlength: 100,
					minlength: 2,
				},
				company_cheque_bankname: {
					maxlength: 100,
					minlength: 2,
				},
				company_dd_bank_name: {
					maxlength: 100,
					minlength: 2,
				},
				cust_address: {
					maxlength: 1500,
					minlength: 2,
				},
				cust_pincode: {
					remote: {
						url: base_url + "customers/checkPINExists",
						type: "post"
					},
				},
				cust_service_det: {
					maxlength: 500,
					minlength: 2,
				},
				cust_total_amount: {
					maxlength: 8,
					number: true,
				},
				cust_paid_amount: {
					maxlength: 8,
					number: true,
					lessThanOrEqualNew: "#cust_total_amount",
				},
				cust_refbyname: {
					maxlength: 200,
				},
				cust_refby_contact: {
					maxlength: 10,
					minlength: 10,
					digits: true,
				},
				cust_refby_email: {
					maxlength: 100,
					email: true,
				},
				"group-b[0][lead_altcontactperson[]]": {
					maxlength: 100,
				},
				"group-b[0][lead_altcontact[]]": {
					maxlength: 10,
					minlength: 10,
					digits: true,
				},
				"group-b[0][lead_altemail[]]": {
					maxlength: 100,
					email: true,
				},
				"service_id[]": {
					required: true,
				},
				cust_remark: {
					maxlength: 1000,
				},

			},
			messages: {
				bank_ifsc: {
					remote: 'Invalid IFSC Code'
				},
				"service_id[]": {
					required: 'Please Select At least one Service'
				},
				cust_remark: {
					maxlength: "Maximum 1000 characters allowed",
				},
			},

			messages: {
				emp_pincode: {
					remote: 'Invalid PINCODE Code'
				},
			},


			errorClass: "help-inline text-danger",
			errorElement: "span",
			highlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-error');
				$(element).parents('.form-group').addClass('has-success');
			},
			onfocusout: false,
			invalidHandler: function(form, validator) {
				var errors = validator.numberOfInvalids();
				if (errors) {
					validator.errorList[0].element.focus();
				}
			},
			errorPlacement: function(error, element) {
				if (element.is(":file")) {
					error.appendTo((element).parents('.form-group').find('.file_err'));
				} else if (element.is(":checkbox")) { // This is the default behavior of the script for all fields
					error.appendTo("#file_err");
				} else { // This is the default behavior of the script for all fields
					error.insertAfter(element);
				}

			},
		});

		jQuery.validator.addMethod("lessThanOrEqualNew",
			function(value, element, params) {
				if (value === "" || value === null) return true; // Allow empty input

				let inputValue = parseFloat(value);
				let compareValue = parseFloat($(params).val()) || 0; // Default to 0 if empty/null

				if (isNaN(inputValue)) inputValue = 0; // Ensure input is valid
				if (isNaN(compareValue)) compareValue = 0; // Ensure comparison value is valid

				return inputValue <= compareValue; // Proper comparison
			},
			function(params, element) {
				let compareValue = parseFloat($(params).val()) || 0;
				return 'Must be less than or equal to ' + compareValue + '.';
			}
		);



		//pin code
		$('#cust_pincode').change(function() {
			var cust_pincode = $("#cust_pincode").val();
			getPIN(cust_pincode);
		});

		$('#add_edit_form_btn').on('click', function(e) {
			if ($('#add_edit_form').valid()) {
				var group_count = 0;
				var err_msg = "";
				$("#err_msg").html("");
				$(".mt-repeater").find(".lead_altcontactperson").each(function(j) {
					group_count = group_count + 1;

				});


				for (var i = 0; i <= group_count; i++) {
					var total = 0;
					var sr_no = (parseInt(i) + 1);

					$(".mt-repeater").find(".lead_altcontact").each(function(j) {
						if ($(this).attr("name") == "group-b[" + i + "][lead_altcontact]") {
							var lead_altcontact = $(this).val();
							$(this).css("border", "");
							if (lead_altcontact && lead_altcontact.length !== 10) {
								err_msg += "<br/>Row No - " + sr_no + " : Contact No. Should be 10 Digits";
								$(this).css("border", "1px solid red");
							}
						}
					});

					$(".mt-repeater").find(".lead_altemail").each(function(j) {
						if ($(this).attr("name") == "group-b[" + i + "][lead_altemail]") {
							var lead_altemail = $(this).val();
							$(this).css("border", "");
							if (lead_altemail && !(IsEmail(lead_altemail))) {
								err_msg += "<br/>Row No - " + sr_no + " : Please Enter Valid Email Id";
								$(this).css("border", "1px solid red");
							}
						}
					});

				}
				$("#err_msg").html(err_msg);
				if (err_msg == "") {
					$('#add_edit_form').submit();
				} else {
					e.preventDefault();
				}

			}


		});

	});

	function IsEmail(email) {
		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!regex.test(email)) {
			return false;
		} else {
			return true;
		}
	}

	function get_payment_details(obj) {

		var payment_type = $(obj).val();
		/* $("#bank_details").addClass("hidden"); */
		$("#online_details").addClass("hidden");
		$("#dd_details").addClass("hidden");
		$("#cheque_details").addClass("hidden");

		/* if(payment_type=="Card"){
			$("#bank_details").removeClass("hidden");
		} */
		if (payment_type == "Online") {
			$("#online_details").removeClass("hidden");
		}
		if (payment_type == "DD") {
			$("#dd_details").removeClass("hidden");
		}
		if (payment_type == "Cheque") {
			$("#cheque_details").removeClass("hidden");
		}
	}

	//dhanraj - 13-08-24

	function get_services(obj) {

		$("#tbl_service_details").html("");
		var service_type = $(obj).val();
		var service_lbl, service_detal_lbl;
		if (service_type == "AMC") {
			service_lbl = "AMC Services: ";
			service_detal_lbl = "AMC Details";
			$("#services_tbl_header").html("<tr class='success'><th>Sr.No.</th><th width:'1%'>AMC</th><th>Address</th><th>Service Date</th></tr>");
			// $("#services_tbl_header").html("<tr class='success'><th>Sr.No.</th><th>Service</th><th>Address</th><th width='120'>Action</th></tr>");
		}
		if (service_type == "One Time Service") {
			service_lbl = "One Time Services: ";
			service_detal_lbl = "One Time Service Details";
			$("#services_tbl_header").html("<tr class='success'><th width='5%'>Sr.No.</th><th>One Time Service</th><th>Address</th></tr>");
		}
		if (service_type == "Sales") {
			service_lbl = "Sales Products: ";
			service_detal_lbl = "Sales Product Details";
			$("#services_tbl_header").html("<tr class='success'><th width='5%'>Sr.No.</th><th>Sales Product</th><th>Address</th><th>Service Date</th></tr>");
			// $("#services_tbl_header").html("<tr class='success'><th width='5%'>Sr.No.</th><th>Sales Product</th><th>Address</th><th width='120'>Action</th></tr>");
		}
		$("#service_detal_lbl").text(service_detal_lbl);
		$("#cust_services_lbl").text(service_lbl);

		$("#tbl_service_id").html("");
		$.ajax({
			url: base_url + "ajax/get_service_list_new",
			type: "POST",
			datatype: "json",
			data: {
				"service_type": service_type
			},
			async: true,
			cache: false,
			success: function(data) {
				var html_data = JSON.parse(data);
				$("#tbl_service_id").html(html_data);

			}
		});
	}

	function get_amc_details(obj) {
		var amc_id = $(obj).val();
		var gst_type = $("#cust_gst_type").val();
		var cust_type = $("#cust_type").val();
		var cust_ui_date = $("#cust_ui_date").val();
		if ($(obj).is(':checked')) {
			$.ajax({
				url: base_url + "ajax/get_amc_details",
				type: "POST",
				datatype: "json",
				data: {
					"cust_gst_type": gst_type,
					"amc_id": amc_id,
					"cust_type": cust_type,
					"cust_ui_date": cust_ui_date
				},
				async: true,
				cache: false,
				success: function(data) {
					var html_data = JSON.parse(data);
					$("#tbl_service_details").append(html_data);
					get_total();
					get_srno();
					$('.datepicker').datepicker({
						format: 'dd-M-yyyy',
						autoclose: true,
						todayHighlight: true,

					});

				}
			});
		} else {
			$('#table_row_id_' + amc_id).remove();
			get_total();
			get_srno();
		}
	}

	function get_ots_details(obj) {
		var ots_id = $(obj).val();
		var gst_type = $("#cust_gst_type").val();
		var cust_type = $("#cust_type").val();

		if ($(obj).is(':checked')) {
			$.ajax({
				url: base_url + "ajax/get_ots_details",
				type: "POST",
				datatype: "json",
				data: {
					"cust_gst_type": gst_type,
					"ots_id": ots_id,
					"cust_type": cust_type
				},
				async: true,
				cache: false,
				success: function(data) {
					var html_data = JSON.parse(data);
					$("#tbl_service_details").append(html_data);
					get_total();
					get_srno();


				}
			});

		} else {
			$('#table_row_id_' + ots_id).remove();
			get_total();
			get_srno();
		}
	}

	function get_product_details(obj) {
		var pm_id = $(obj).val();
		var gst_type = $("#cust_gst_type").val();
		var cust_type = $("#cust_type").val();

		if ($(obj).is(':checked')) {
			$.ajax({
				url: base_url + "ajax/get_product_details",
				type: "POST",
				datatype: "json",
				data: {
					"cust_gst_type": gst_type,
					"pm_id": pm_id,
					"cust_type": cust_type
				},
				async: true,
				cache: false,
				success: function(data) {
					var html_data = JSON.parse(data);
					$("#tbl_service_details").append(html_data);
					get_total();
					get_srno();


				}
			});

		} else {
			$('#table_row_id_' + pm_id).remove();
			get_total();
			get_srno();
		}
	}

	function delete_row(obj) {
		var id = $(obj).attr("data-id");
		$('#row_id_' + id).remove();

	}


	function add_row(obj) {
		var id = $(obj).attr("data-id"); // Get the table ID from the clicked button
		var data_id = getRandomInt(5); // Generate a random ID for the new row

		// Get the Customer Added Date from the form
		var customerAddedDate = $("#cust_ui_date").val().trim();

		// Generate the new row with the first Service Date input pre-filled
		var html = '<tr id="row_id_' + data_id + '" data-id="' + data_id + '">';
		html += '<td><input type="text" name="cust_service_dates_' + id + '[]" placeholder="Service Date" class="form-control datepicker" maxlength="100" value="' + customerAddedDate + '"> </td>';
		html += '<td><a href="javascript:;" onclick="delete_row(this);" data-id="' + data_id + '" class="btn btn-danger btn-xs"><i class="fa fa-close"></i></a></td>';
		html += '</tr>';

		// Append the new row to the corresponding table
		$("#table_" + id).append(html);

		// Reinitialize the Datepicker for new elements
		$(".datepicker").datepicker("destroy"); // Destroy any existing datepicker to prevent conflicts
		$(".datepicker").datepicker({
			format: "dd-M-yyyy",
			autoclose: true,
			todayHighlight: true
		});

		// Manually set the date after initializing the datepicker
		$("#row_id_" + data_id + " .datepicker").datepicker("setDate", customerAddedDate);
	}

	function getRandomInt(max) {
		return Math.floor(Math.random() * Math.floor(max));
	}

	function calculate_total(obj) {
		var id = $(obj).attr("data-id");
		var gst_type = $("#cust_gst_type").val();
		var cust_pdt_qty = parseFloat($("#cust_pdt_qty_" + id).val());
		var cust_pdt_price = parseFloat($("#cust_pdt_price_" + id).val());

		if (isNaN(cust_pdt_qty)) {
			cust_pdt_qty = 0;
		}
		if (isNaN(cust_pdt_price)) {
			cust_pdt_price = 0;
		}


		var total = cust_pdt_price * cust_pdt_qty;
		total = Math.round(parseFloat((total * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);

		var cust_pdt_gst_price = parseFloat($("#cust_pdt_gst_price_" + id).val());
		var cust_pdt_gst = parseFloat($("#cust_pdt_gst_" + id).val());

		if (isNaN(total)) {
			total = 0;
		}
		if (isNaN(cust_pdt_gst)) {
			cust_pdt_gst = 0;
		}
		if (isNaN(cust_pdt_gst_price)) {
			cust_pdt_gst_price = 0;
		}

		var gst = (total * cust_pdt_gst) / 100;
		gst = Math.round(parseFloat((gst * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);
		gst = Math.round(gst);
		cust_pdt_gst_price = gst + total;
		$("#cust_pdt_gst_price_" + id).val(cust_pdt_gst_price);

		get_total();


	}

	function get_total() {

		var total_gst_price = 0;
		$("#tbl_service_details").find(".form-control").each(function(j) {
			if ($(this).attr("name") == "cust_pdt_gst_price[]") {
				var gst_price = parseFloat($(this).val());
				if (isNaN(gst_price)) {
					gst_price = 0;
				}
				total_gst_price = total_gst_price + gst_price;

			}
		});
		total_gst_price = Math.round(parseFloat((total_gst_price * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);
		$("#cust_total_amount").val(total_gst_price);

	}

	function get_srno() {
		var Srno = 1;
		$("#tbl_service_details").find(".sr_no").each(function(j) {
			$(this).html(Srno);
			Srno++
		});
	}

	function clear_service_details() {
		$("#tbl_service_details").html("");
		$('#tbl_service_id').find('input[type=checkbox]:checked').removeAttr('checked');
	}

	function getIFSC(emp_bank_ifsc_code) {
		$('#ifsc_code').html("");
		if (emp_bank_ifsc_code) {
			$.ajax({
				url: base_url + "admin/getIFSC",
				type: "POST",
				data: {
					'ifsc_code': emp_bank_ifsc_code
				},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data) {
					var data = JSON.parse(data);
					$("#ifsc_code").html(data.BRANCH);
					$("#bank_branch_address").val(data.ADDRESS);
					$("#bank_name").val(data.BANK);
					$("#bank_micr").val(data.MICR);
				}
			});
		}
	}

	//dhanraj - 13-08-24
	function filterAMCs() {
		var input = document.getElementById('amcSearch');
		var filter = input.value.toLowerCase();
		var serviceItems = document.querySelectorAll('#tbl_service_id tr');

		serviceItems.forEach(function(item) {
			var serviceText = item.textContent || item.innerText;
			if (serviceText.toLowerCase().indexOf(filter) > -1) {
				item.style.display = '';
			} else {
				item.style.display = 'none';
			}
		});
	}



	function get_reference_details(obj) {
		var ref_id = $(obj).val();
		$.ajax({
			url: base_url + "ajax/get_reference_details",
			type: "POST",
			datatype: "json",
			data: {
				"ref_id": ref_id
			},
			async: true,
			cache: false,
			success: function(data) {
				var data = JSON.parse(data);
				if (data) {
					$("#cust_refby_email").val(data.ref_email);
					$("#cust_refbyname").val(data.ref_person_name);
					$("#cust_refby_contact").val(data.ref_mobile);
				}

			}
		});
	}

	//PINCODE
	function getPIN(cust_pincode) {
		$('#pin_code').html("");
		if (cust_pincode) {
			$.ajax({
				url: base_url + "customers/getPIN",
				type: "POST",
				data: {
					'pin_code': cust_pincode
				},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data) {
					var data = JSON.parse(data);
					var cityDropdown = $("#cust_city");
					cityDropdown.empty(); // Clear existing options

					if (data.length > 0 && data[0].PostOffice.length > 0) {
						// Populate the dropdown
						data[0].PostOffice.forEach(function(postOffice) {
							var option = $('<option></option>')
								.attr('value', postOffice.Name) // or any unique identifier
								.text(postOffice.Name); // or any display name
							cityDropdown.append(option);
						});

						$("#cust_pincode").val(data[0].PostOffice[0].Pincode);
						$("#cust_state").val(data[0].PostOffice[0].State);
						$("#cust_dist").val(data[0].PostOffice[0].District);
					}
				},
				error: function(xhr, status, error) {
					console.error('Error fetching pin code data:', status, error);
				}
			});
		}
	}
</script>
<!-- by kiran dhaije 14/01/25 -->
<script>
	document.addEventListener('DOMContentLoaded', function() {
		const totalPriceInput = document.getElementById('cust_total_amount');
		const paidAmountInput = document.getElementById('cust_paid_amount');
		const form = document.getElementById('serviceForm');

		function validateInstallments() {
			const totalPrice = parseFloat(totalPriceInput.value) || 0;


			var total_gst_price = 0;

			if ($("#tbl_service_details").length > 0) {
				// 🚀 ADD MODE - Use the table
				$("#tbl_service_details").find(".form-control").each(function() {
					if ($(this).attr("name") == "cust_pdt_price[]") {
						var gst_price = parseFloat($(this).val()) || 0;
						if (gst_price === 0) {
							var cbpm_amount_nogst = parseFloat($("#cbpm_amount_nogst").val()) || 0;
							gst_price = cbpm_amount_nogst;
						}
						total_gst_price += gst_price;
					}
				});
			} else if ($("#edit_service_details").length > 0) {

				var gst_price = parseFloat($("#edit_cust_pdt_price").val()) || 0;
				if (gst_price === 0) {
					gst_price = parseFloat($("#cbpm_amount_nogst").val()) || 0;
				}

				total_gst_price = gst_price;
			}

			total_gst_price = Math.round(parseFloat((total_gst_price * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);



			const paidAmount = parseFloat(paidAmountInput.value) || 0;
			const expectedAmount = total_gst_price - paidAmount;
			const installmentInputs = document.querySelectorAll('input[name="next_installment_amount[]"]');
			let totalInstallmentSum = 0;
			let isValid = true;

			// Clear all previous error messages
			document.querySelectorAll('.installment-error').forEach(errorSpan => {
				errorSpan.textContent = '';
				errorSpan.style.display = 'none';
			});

			// Calculate the total sum of all installment amounts
			installmentInputs.forEach(input => {
				const value = parseFloat(input.value) || 0;
				totalInstallmentSum += value;
			});

			// Validate each installment input
			installmentInputs.forEach((input, index) => {
				const value = parseFloat(input.value) || 0;
				const parentDiv = input.closest('tr'); // Get the parent row of the input
				const errorSpan = parentDiv.querySelector('.installment-error'); // Error span for this row

				// Check if the total falls short of the expected amount
				if (totalInstallmentSum < expectedAmount && value > 0) {
					errorSpan.textContent = `The total installment amount is less than expected by (${expectedAmount - totalInstallmentSum}).`;
					errorSpan.style.display = 'block';
					isValid = false;
				} else if (totalInstallmentSum > expectedAmount && value > 0) {
					// Existing logic to handle exceeding expected amount
					if (totalInstallmentSum - value <= expectedAmount) {
						errorSpan.textContent = `The Installment amount must be Equal to the (${expectedAmount}).`;
						errorSpan.style.display = 'block';
						isValid = false;
					}
				}
			});

			return isValid;
		}


		// Add input event listeners to validate dynamically
		document.addEventListener('input', function(event) {
			if (
				event.target.matches('input[name="next_installment_amount[]"]') ||
				event.target === totalPriceInput ||
				event.target === paidAmountInput
			) {
				validateInstallments();
			}
		});

		// Prevent form submission if validation fails
		form.addEventListener('submit', function(event) {
			if (!validateInstallments()) {
				event.preventDefault(); // Stop form submission
				// You can optionally display a more prominent error message here
				alert('Please fix the errors in the installment amounts before submitting the form.');
			}
		});

		// Initial validation on page load
		validateInstallments();
	});
</script>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		const totalPriceInput = document.getElementById('total_price'); // adjust ID if different
		const paidAmountInput = document.getElementById('cust_paid_amount'); // adjust ID if different
		let installmentRowCounter = 1;

		document.getElementById('installment_count').addEventListener('input', function() {
			const count = parseInt(this.value, 10);
			const tableBody = document.getElementById('installments_table_body');
			if (isNaN(count) || count <= 0) return;

			tableBody.innerHTML = '';
			installmentRowCounter = 1;

			// ✅ Calculate total GST price
			let total_gst_price = 0;
			if ($("#tbl_service_details").length > 0) {
				$("#tbl_service_details").find(".form-control").each(function() {
					if ($(this).attr("name") === "cust_pdt_price[]") {
						let gst_price = parseFloat($(this).val()) || 0;
						if (gst_price === 0) {
							gst_price = parseFloat($("#cbpm_amount_nogst").val()) || 0;
						}
						total_gst_price += gst_price;
					}
				});
			} else if ($("#edit_service_details").length > 0) {
				total_gst_price = parseFloat($("#edit_cust_pdt_price").val()) || parseFloat($("#cbpm_amount_nogst").val()) || 0;
			}

			total_gst_price = Math.round((total_gst_price + Number.EPSILON) * 100) / 100;
			const paidAmount = parseFloat(paidAmountInput?.value || 0);
			const expectedAmount = total_gst_price - paidAmount;

			if (expectedAmount <= 0) return; // Nothing to distribute

			// ✅ Calculate equal installment amount
			const equalInstallment = Math.floor((expectedAmount / count) * 100) / 100;
			let remaining = expectedAmount;

			const monthMap = {
				Jan: 0,
				Feb: 1,
				Mar: 2,
				Apr: 3,
				May: 4,
				Jun: 5,
				Jul: 6,
				Aug: 7,
				Sep: 8,
				Oct: 9,
				Nov: 10,
				Dec: 11
			};

			// 🔥 Fetch and parse start date
			var startDateStr01 = $("#cust_ui_date").val();
			const startDateStr = document.getElementById('cust_ui_date')?.value || "";

			// // const startDateStr = document.getElementById('cust_ui_date'); 

			let durationDays = $("#amc_duration").val();
			// let [day, month, year] = startDateStr ? startDateStr.split("/") : [];
			// let startDate = (day && month && year) ? new Date(`${year}-${month}-${day}`) : new Date();

			let startDate = new Date();

			if (startDateStr) {
				const [dayStr, monStr, yearStr] = startDateStr.split("-");
				const day = parseInt(dayStr, 10);
				const month = monthMap[monStr];
				const year = parseInt(yearStr, 10);

				if (!isNaN(day) && !isNaN(month) && !isNaN(year)) {
					startDate = new Date(year, month, day);
				}
			}

			let currentStartDate = new Date(startDate); // continue normally

			// 🔥 Calculate number of days per installment
			let baseDays = Math.floor(durationDays / count);
			let extraDays = durationDays % count;

			// let currentStartDate = new Date(startDateStr);

			// ✅ Create rows
			for (let i = 0; i < count; i++) {
				let amount1 = (i === count - 1) ? remaining.toFixed(2) : equalInstallment.toFixed(2);
				//   let amount = round(amount1);
				// let amount = Number(round(amount1).toFixed(2));
				let amount = roundToWhole(amount1);
				remaining -= equalInstallment;

				// 🔥 Calculate installment start and end dates
				let installmentStartDate = new Date(currentStartDate);
				let installmentEndDate = new Date(currentStartDate);
				let daysThisInterval = baseDays + (i < extraDays ? 1 : 0);
				installmentEndDate.setDate(installmentEndDate.getDate() + daysThisInterval - 1);

				// 🔥 Format date as dd-MMM-yyyy
				//   const formatDate = (date) =>
				//     date.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }).replace(/ /g, '-');

				const formatDate = (date) => {
					const day = String(date.getDate()).padStart(2, '0');
					const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
					const month = monthNames[date.getMonth()];
					const year = date.getFullYear();
					return `${day}-${month}-${year}`;
				};


				const newRow = document.createElement('tr');
				newRow.innerHTML = `
	<td>
	  <div class="form-group col-md-12">
		<input type="text" id="cust_pay_nxt_dt_${installmentRowCounter}" 
			   class="form-control datepicker" 
			   name="next_installment_date[]" 
			   value="${formatDate(installmentStartDate)}"
			   placeholder="Select Date" />
	  </div>
	</td>
	<td>
	  <div class="form-group col-md-12">
		<input type="number" id="cust_pay_nxt_amt_${installmentRowCounter}" 
			   class="form-control installment-input" 
			   name="next_installment_amount[]" 
			   value="${amount}"
			   placeholder="Enter Amount" />
		<span class="installment-error text-danger" style="display: none;"></span>
	  </div>
	</td>
	<td>
	  <div class="form-group col-md-12">
		<input type="text" id="cust_pay_nxt_start_date_${installmentRowCounter}" 
			   class="form-control datepicker" 
			   name="next_installment_start_date[]" 
			   value="${formatDate(installmentStartDate)}"
			   placeholder="Start Date" />
	  </div>
	</td>
	<td>
	  <div class="form-group col-md-12">
		<input type="text" id="cust_pay_nxt_end_date_${installmentRowCounter}" 
			   class="form-control datepicker" 
			   name="next_installment_end_date[]" 
			   value="${formatDate(installmentEndDate)}"
			   placeholder="End Date" />
	  </div>
	</td>
	<td>
	  <button type="button" class="btn btn-danger btn-xs" onclick="this.closest('tr').remove();">
		<i class="fa fa-minus"></i>
	  </button>
	</td>
  `;
				tableBody.appendChild(newRow);
				installmentRowCounter++;

				// 🔁 Move to the next interval
				currentStartDate = new Date(installmentEndDate);
				currentStartDate.setDate(currentStartDate.getDate() + 1);
			}

			// ✅ Re-initialize datepickers
			$('.datepicker').datepicker({
				format: 'dd-M-yyyy',
				autoclose: true,
				todayHighlight: true
			});

			// ✅ Reattach validation
			document.querySelectorAll('.installment-input').forEach(function(input) {
				input.addEventListener('input', function() {
					validateInstallments();
				});
			});

			validateInstallments();
		});
	});

	function roundToWhole(num) {
		return Math.round(num);
	}

	function handleServiceClick(obj, id, type) {

		if ($(obj).is(':checked')) {
			openServiceModal(id, type);
		} else {
			$('#table_row_id_' + id).remove();
			get_total();
			get_srno();
		}
	}

	function openServiceModal(id, type) {

		let url = "";

		if (type === "AMC") url = base_url + "ajax/get_amc_details";
		if (type === "OTS") url = base_url + "ajax/get_ots_details";
		if (type === "PRODUCT") url = base_url + "ajax/get_product_details";

		$.ajax({
			url: url,
			type: "POST",
			data: {
				amc_id: id,
				ots_id: id,
				pm_id: id,
				cust_type: $("#cust_type").val(),
				cust_gst_type: $("#cust_gst_type").val(),
				cust_ui_date: $("#cust_ui_date").val()
			},
			success: function(data) {
				var html_data = JSON.parse(data);
				$("#tbl_service_details").append(html_data);
				get_total();
				get_srno();
				$('.datepicker').datepicker({
					format: 'dd-M-yyyy',
					autoclose: true,
					todayHighlight: true,

				});

				$("#serviceModal1").modal("show");
			}
		});
	}

	function showServicesModal() {
		$("#serviceModal1").modal("show");
	}

	document.addEventListener("change", function(e) {
		if (e.target.type === "checkbox") {
			const anyChecked = document.querySelectorAll("#tbl_service_id input[type='checkbox']:checked").length > 0;

			const btn = document.querySelector(".btn-show-services");

			if (anyChecked) {
				btn.classList.add("active-pulse");
			} else {
				btn.classList.remove("active-pulse");
			}
		}
	});
</script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#form_modal").on("show.bs.modal", function(e) {
			var link = $(e.relatedTarget);
			$(this).data('bs.modal', null);
			$(this).find(".modal-content").load(link.attr("href"));
		});
		$("#list_modal").on("show.bs.modal", function(e) {
			var link = $(e.relatedTarget);
			$(this).data('bs.modal', null);
			$(this).find(".modal-content").load(link.attr("href"));
		});

	});
</script>
<script>
	function refreshContactButtons() {

		var rows = $('[data-repeater-item]');

		rows.each(function(index) {

			var addBtn = $(this).find('.btn-add-contact');
			var deleteBtn = $(this).find('.btn-delete-contact');

			if (index === rows.length - 1) {
				addBtn.show();
				deleteBtn.hide();
			} else {
				addBtn.hide();
				deleteBtn.show();
			}
		});

		// If only one row exists
		if (rows.length === 1) {
			rows.first().find('.btn-add-contact').show();
			rows.first().find('.btn-delete-contact').hide();
		}
	}

	$(document).ready(function() {
		refreshContactButtons();
		$(document).on('click', '.btn-add-contact', function() {
			$('[data-repeater-create]').click();
			setTimeout(function() {
				refreshContactButtons();
			}, 100);
		});

		// $(document).on('click', '[data-repeater-delete]', function() {
		// 	var row = $(this).closest('[data-repeater-item]');
		// 	row.slideUp(function() {
		// 		$(this).remove();
		// 		refreshContactButtons();
		// 	});

		// });

	});

	var selectedRow = null;

	$(document).on('click', '.btn-delete-contact', function(e) {
		e.preventDefault();
		selectedRow = $(this).closest('[data-repeater-item]');
		$('#deleteContactModal').modal('show');
	});

	$('#confirmDeleteContact').click(function() {
		if (selectedRow) {
			selectedRow.slideUp(function() {
				$(this).remove();
				refreshContactButtons();
			});
		}
		$('#deleteContactModal').modal('hide');

	});
</script>
