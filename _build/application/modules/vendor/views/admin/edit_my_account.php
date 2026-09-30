<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE BASE CONTENT -->

		<!-- <pre>
		<?php print_r($details); ?>
		</pre> -->

		<?php
		$icon = "icon-plus";
		if ($action == "Edit") {
			$icon = "icon-pencil";
		} ?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<ul class="page-breadcrumb breadcrumb">
						<li><a href="<?php echo base_url(get_module() . "/dashboard") ?>">Home</a><i
								class="fa fa-circle"></i></li>
						<li><a href="<?php echo base_url(get_module() . "/admin/my_account") ?>">My Account</a><i
								class="fa fa-circle"></i></li>
						<li><span class="active"><?php echo $page_title; ?></span></li>
					</ul>
					<!--div class="portlet-title">
			   <div class="caption">
				  <i class="font-red-mint <?php echo $icon; ?> "></i>
				  <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
			   </div>
			   
		   </div-->
					<div class="row">

						<div class="portlet-body form">
							<?php
							//echo "<pre/>"; print_r($details);die; 
							$details = html_escape($details);
							$formaction = "edit_my_account";
							?>

							<form action="<?php echo get_module_path() . 'admin/' . $formaction; ?>" id="add_edit_form"
								method="post" autocomplete="off" enctype="multipart/form-data">
								<div class="form-body">

									<div class="col-md-12">

										<div class="portlet-body">
											<div class="portlet-title">
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

											<div class="col-md-3">
												<div class="form-group">
													<label for="invoice_pattern_id">Invoice
														Type</label><?php echo REQUIRED_STAR; ?>
													<select class="form-control" id="invoice_pattern_id"
														name="invoice_pattern_id" required
														onchange="get_invoice_details(this);">
														<option value=""> Select Invoice Type</option>
														<?php
														$invoice_pattern_id = set_value("invoice_pattern_id");
														$selected = "";

														// If form was submitted, use selected value
														if (!empty($invoice_pattern_id)) {
															$selected = $invoice_type['invoice_id'] == $invoice_pattern_id ? "selected" : "";
														}
														// Otherwise, make "Default A4 type" selected by default
														else if ($invoice_type['invoice_pattern'] == "Default A4 type") {
															$selected = "selected";
														}
														?>

														<?php if (!empty($invoice_type_list)) {
															foreach ($invoice_type_list as $key => $invoice_type) {

																$invoice_pattern_id = set_value("invoice_pattern_id");
																$selected = "";

																if (!empty($invoice_pattern_id)) {
																	$selected = $invoice_type['invoice_id'] == $invoice_pattern_id ? "selected" : "";
																} else if ($invoice_type['invoice_pattern'] == "Default A4 type") {
																	$selected = "selected";
																}

																$image = $invoice_type['invoice_pattern_img'];
																$image = str_replace("getAuthApiKey", APIKEY, $image);
														?>
																<option value="<?php echo $invoice_type['invoice_id']; ?>"
																	<?php echo $selected; ?>
																	data-img="<?php echo $image; ?>">
																	<?php echo $invoice_type['invoice_pattern']; ?>
																</option>
														<?php }
														} ?>
													</select>
													<span id="invoice_det"></span>
													<?php echo form_error('cust_type', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>

											<div class="col-md-3">
												<div class="form-group">
													<label for="cust_gstno">Company GST No</label>
													<input class="form-control" id="cust_gstno" name="cust_gstno"
														type="text" placeholder="Enter Customer GST No" maxlength="15"
														value="<?php echo isset($details['customer_gstno']) ? $details['customer_gstno'] : set_value("cust_gstno"); ?>">
													<?php echo form_error('cust_gstno', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="cust_website">Website</label>
													<input class="form-control" id="cust_website" name="cust_website"
														type="text" placeholder="Enter Website" maxlength="100"
														value="<?php echo isset($details['cust_website']) ? $details['cust_website'] : set_value("cust_website"); ?>">
													<?php echo form_error('cust_website', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="company_chq_bounce_chrg">Cheque Bounce Charges</label>
													<input class="form-control" id="company_chq_bounce_chrg"
														name="company_chq_bounce_chrg" type="text"
														placeholder="Enter Cheque Bounce Charges" maxlength="8" value="0">
													<?php echo form_error('company_chq_bounce_chrg', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="portlet-title">
												<br />
												<div class="caption">
													<i class="font-red-mint icon-call-out"></i>
													<span class="caption-subject font-red-mint sbold">Contact
														Details</span>
												</div>
												<hr style="margin:3px;" />
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="cust_name">Customer Name</label>
													<?php echo REQUIRED_STAR; ?>
													<input class="form-control" id="cust_name" name="cust_name"
														type="text" placeholder="Enter Customer Name" required
														maxlength="100" disabled
														value="<?php echo isset($details['customer_name']) ? $details['customer_name'] : set_value("cust_name"); ?>">
													<?php echo form_error('cust_name', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="cust_company_name">Company Name</label>
													<?php echo REQUIRED_STAR; ?>
													<input class="form-control" id="cust_company_name"
														name="cust_company_name" type="text"
														placeholder="Enter Company Name" required maxlength="100"
														value="<?php echo isset($details['cust_company_name']) ? $details['cust_company_name'] : set_value("cust_company_name"); ?>">
													<?php echo form_error('cust_company_name', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="cust_contact">Mobile
														No.<?php echo REQUIRED_STAR; ?></label>
													<input class="form-control" id="cust_contact" name="cust_contact"
														type="text" placeholder="Enter Mobile No." maxlength="10" disabled
														value="<?php echo isset($details['customer_contact']) ? $details['customer_contact'] : set_value("cust_contact"); ?>">
													<?php echo form_error('cust_contact', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="cust_contact_email">Email
														Id<?php echo REQUIRED_STAR; ?></label>
													<input class="form-control" id="cust_contact_email"
														name="cust_contact_email" type="text"
														placeholder="Enter Email Id." maxlength="100"
														value="<?php echo isset($details['customer_contact_email']) ? $details['customer_contact_email'] : set_value("cust_contact_email"); ?>">
													<?php echo form_error('cust_contact_email', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="cust_contact_person">Contact Person</label>
													<input class="form-control" id="cust_contact_person"
														name="cust_contact_person" type="text"
														placeholder="Enter Contact Person" maxlength="100"
														value="<?php echo isset($details['customer_contact_person']) ? $details['customer_contact_person'] : set_value("cust_contact_person"); ?>">
													<?php echo form_error('cust_contact_person', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="alt_cust_contact">Alternate Mobile No.</label>
													<input class="form-control" id="alt_cust_contact"
														name="alt_cust_contact" type="text"
														placeholder="Enter Alternate Mobile No." maxlength="10"
														value="<?php echo isset($details['customer_alt_contact']) ? $details['customer_alt_contact'] : set_value("alt_cust_contact"); ?>">
													<?php echo form_error('alt_cust_contact', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="cust_landline">Landline No.</label>
													<input class="form-control" id="cust_landline" name="cust_landline"
														type="text" placeholder="Enter Landline No." maxlength="15"
														value="<?php echo isset($details['cust_landline']) ? $details['cust_landline'] : set_value("cust_landline"); ?>">
													<?php echo form_error('cust_landline', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>


										</div>

										<div class="col-md-12">
											<div class="portlet-title">
												<br />
												<div class="caption">
													<i class="font-red-mint icon-pointer"></i>
													<span class="caption-subject font-red-mint sbold">Address
														Details</span>
												</div>
												<hr style="margin:3px;" />
											</div>
											<div class="form-group col-md-9">
												<label for="cust_address">Address</label>
												<input class="form-control" id="cust_address" name="cust_address"
													type="text" placeholder="Enter Address" maxlength="300"
													value="<?php echo isset($details['customer_address']) ? $details['customer_address'] : set_value("cust_address"); ?>">
												<?php echo form_error('cust_address', '<span class="text-danger">', '</span>'); ?>
											</div>

											<div class="col-md-3">
												<div class="form-group">
													<label for="cust_stateid">State </label>
													<select class="form-control" id="cust_stateid" name="cust_stateid"
														onchange="get_state_districts(this,'cust_distid');">
														<option value=""> Select State</option>
														<?php if (!empty($state_list)) {
															foreach ($state_list as $state) {
																$state_id = isset($details['customer_state_id']) ? $details['customer_state_id'] : set_value("cust_stateid");
																$selected = $state_id == $state['state_id'] ? "selected" : "";

														?>
																<option value="<?php echo $state['state_id']; ?>" <?php echo $selected; ?>><?php echo $state['state_name']; ?></option>
														<?php }
														} ?>
													</select>
													<?php echo form_error('cust_stateid', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="cust_distid">District </label>
													<select class="form-control" id="cust_distid" name="cust_distid"
														onchange="get_district_cities(this,'cust_stateid','cust_cityid');">
														<option value=""> Select District</option>
														<?php if (!empty($dist_list)) {
															foreach ($dist_list as $dist) {
																$dist_id = isset($details['customer_dist_id']) ? $details['customer_dist_id'] : set_value("cust_distid");
																$selected = $dist_id == $dist['dist_id'] ? "selected" : "";

														?>
																<option value="<?php echo $dist['dist_id']; ?>" <?php echo $selected; ?>><?php echo $dist['dist_name']; ?></option>
														<?php }
														} ?>
													</select>
													<?php echo form_error('cust_distid', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="cust_cityid">City </label>
													<select class="form-control" id="cust_cityid" name="cust_cityid"
														onchange="get_city_area(this,'cust_stateid','cust_distid','cust_area');">
														<option value=""> Select City</option>
														<?php if (!empty($city_list)) {
															foreach ($city_list as $city) {
																$city_id = isset($details['customer_city_id']) ? $details['customer_city_id'] : set_value("cust_cityid");
																$selected = $city_id == $city['city_id'] ? "selected" : "";

														?>
																<option value="<?php echo $city['city_id']; ?>" <?php echo $selected; ?>><?php echo $city['city_name']; ?></option>
														<?php }
														} ?>
													</select>
													<?php echo form_error('cust_cityid', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="cust_area">Area</label>
													<select class="form-control" id="cust_area" name="cust_area">
														<option value=""> Select Area</option>
														<?php if (!empty($area_list)) {
															foreach ($area_list as $area) {
																$area_id = isset($details['customer_area']) ? $details['customer_area'] : set_value("cust_area");
																$selected = $area_id == $area['area_id'] ? "selected" : "";

														?>
																<option value="<?php echo $area['area_id']; ?>" <?php echo $selected; ?>><?php echo $area['area_name']; ?></option>
														<?php }
														} ?>
													</select>
													<?php echo form_error('cust_area', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="cust_pincode">Pincode</label>
													<input class="form-control" id="cust_pincode" name="cust_pincode"
														type="text" placeholder="Enter Pincode" maxlength="6"
														value="<?php echo isset($details['customer_pin']) ? $details['customer_pin'] : set_value("cust_pincode"); ?>">
													<?php echo form_error('cust_pincode', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
										</div>

										<div class="col-md-12 hidden">
											<div class="portlet-title">
												<br />
												<div class="caption">
													<i class="font-red-mint icon-pointer"></i>
													<span class="caption-subject font-red-mint sbold">Service
														Details</span>
												</div>
												<hr style="margin:3px;" />
											</div>
											<div class="form-group col-md-12">
												<label for="cust_service_det">Service Details</label>
												<?php echo REQUIRED_STAR; ?>
												<input class="form-control" id="cust_service_det"
													name="cust_service_det" type="text"
													placeholder="Enter Service Details" required maxlength="500"
													value="<?php echo isset($details['cust_service_det']) ? $details['cust_service_det'] : set_value("cust_service_det"); ?>">
												<?php echo form_error('cust_service_det', '<span class="text-danger">', '</span>'); ?>
											</div>


											<div class="col-md-3">
												<div class="form-group">
													<label for="cust_unit_no">Unit No.</label>
													<input class="form-control" id="cust_unit_no" name="cust_unit_no"
														type="text" placeholder="Enter Unit No." maxlength="50"
														value="<?php echo isset($details['cust_unit_no']) ? $details['cust_unit_no'] : set_value("cust_unit_no"); ?>">
													<?php echo form_error('cust_unit_no', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="cust_form_no">Form No.</label>
													<input class="form-control" id="cust_form_no" name="cust_form_no"
														type="text" placeholder="Enter Form No." maxlength="50"
														value="<?php echo isset($details['cust_form_no']) ? $details['cust_form_no'] : set_value("cust_form_no"); ?>">
													<?php echo form_error('cust_form_no', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="portlet-title">
												<br />
												<div class="caption">
													<i class="font-red-mint  icon-note"></i>
													<span class="caption-subject font-red-mint sbold">Bank Details for GST</span>
												</div>
												<hr style="margin:3px;" />
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="bank_acc_name">Bank Account Name</label>
													<input class="form-control" id="bank_acc_name" name="bank_acc_name"
														type="text" placeholder="Enter Bank Account Name"
														maxlength="100"
														value="<?php echo isset($details['cust_bank_acc_name']) ? $details['cust_bank_acc_name'] : set_value("bank_acc_name"); ?>">
													<?php echo form_error('bank_acc_name', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="bank_acc_number">Enter Account No.</label>
													<input class="form-control" id="bank_acc_number"
														name="bank_acc_number" type="text"
														placeholder="Enter Account No." maxlength="20"
														value="<?php echo isset($details['cust_bank_acc_number']) ? $details['cust_bank_acc_number'] : set_value("bank_acc_number"); ?>">
													<?php echo form_error('bank_acc_number', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="bank_ifsc">IFSC Code</label>
													<input class="form-control" id="bank_ifsc" name="bank_ifsc"
														type="text" placeholder="Enter IFSC Code" maxlength="15"
														value="<?php echo isset($details['cust_bank_ifsc']) ? $details['cust_bank_ifsc'] : set_value("bank_ifsc"); ?>">
													<?php echo form_error('bank_ifsc', '<span class="text-danger">', '</span>'); ?>
													<span id="ifsc_code" class="text-success"></span>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="bank_name">Bank Name</label>
													<input class="form-control" id="bank_name" name="bank_name"
														type="text" placeholder="Enter Bank Name" maxlength="100"
														value="<?php echo isset($details['cust_bank_name']) ? $details['cust_bank_name'] : set_value("bank_name"); ?>">
													<?php echo form_error('bank_name', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="bank_branch_address">Branch Address</label>
													<input class="form-control" id="bank_branch_address"
														name="bank_branch_address" type="text"
														placeholder="Enter Branch Address" maxlength="100"
														value="<?php echo isset($details['cust_bank_branch_address']) ? $details['cust_bank_branch_address'] : set_value("bank_branch_address"); ?>">
													<?php echo form_error('bank_branch_address', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="bank_micr">Bank MICR</label>
													<input class="form-control" id="bank_micr" name="bank_micr"
														type="text" placeholder="Enter Bank MICR" maxlength="9"
														value="<?php echo isset($details['cust_bank_micr']) ? $details['cust_bank_micr'] : set_value("bank_micr"); ?>">
													<?php echo form_error('bank_micr', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
										</div>


										<div class="col-md-12">
											<div class="portlet-title">
												<br />
												<div class="caption">
													<i class="font-red-mint  icon-note"></i>
													<span class="caption-subject font-red-mint sbold">Bank Details for Non-GST</span>
												</div>
												<hr style="margin:3px;" />
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="bank_acc_name1">Bank Account Name</label>
													<input class="form-control" id="bank_acc_name1" name="bank_acc_name1"
														type="text" placeholder="Enter Bank Account Name"
														maxlength="100"
														value="<?php echo isset($details['cust_bank_acc_name_non_gst']) ? $details['cust_bank_acc_name_non_gst'] : set_value("bank_acc_name1"); ?>">
													<?php echo form_error('bank_acc_name1', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="bank_acc_number1">Enter Account No.</label>
													<input class="form-control" id="bank_acc_number1"
														name="bank_acc_number1" type="text"
														placeholder="Enter Account No." maxlength="18"
														value="<?php echo isset($details['cust_bank_acc_number_non_gst']) ? $details['cust_bank_acc_number_non_gst'] : set_value("bank_acc_number1"); ?>">
													<?php echo form_error('bank_acc_number1', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="bank_ifsc1">IFSC Code</label>
													<input class="form-control" id="bank_ifsc1" name="bank_ifsc1"
														type="text" placeholder="Enter IFSC Code" maxlength="15"
														value="<?php echo isset($details['cust_bank_ifsc_non_gst']) ? $details['cust_bank_ifsc_non_gst'] : set_value("bank_ifsc1"); ?>">
													<?php echo form_error('bank_ifsc1', '<span class="text-danger">', '</span>'); ?>
													<span id="ifsc_code1" class="text-success"></span>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="bank_name1">Bank Name</label>
													<input class="form-control" id="bank_name1" name="bank_name1"
														type="text" placeholder="Enter Bank Name" maxlength="100"
														value="<?php echo isset($details['cust_bank_name_non_gst']) ? $details['cust_bank_name_non_gst'] : set_value("bank_name1"); ?>">
													<?php echo form_error('bank_name1', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="bank_branch_address1">Branch Address</label>
													<input class="form-control" id="bank_branch_address1"
														name="bank_branch_address1" type="text"
														placeholder="Enter Branch Address" maxlength="100"
														value="<?php echo isset($details['cust_bank_branch_address_non']) ? $details['cust_bank_branch_address_non'] : set_value("bank_branch_address1"); ?>">
													<?php echo form_error('bank_branch_address1', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="bank_micr1">Bank MICR</label>
													<input class="form-control" id="bank_micr1" name="bank_micr1"
														type="text" placeholder="Enter Bank MICR" maxlength="9"
														value="<?php echo isset($details['cust_bank_micr_non_gst']) ? $details['cust_bank_micr_non_gst'] : set_value("bank_micr1"); ?>">
													<?php echo form_error('bank_micr1', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
										</div>



										<div class="col-md-12">
											<div class="portlet-title">
												<br />
												<div class="caption">
													<i class="font-red-mint  icon-envelope"></i>
													<span class="caption-subject font-red-mint sbold">SMS API & Email
														Details</span>
												</div>
												<hr style="margin:3px;" />
											</div>

											<div class="form-group col-md-3">
												<label for="sms_api">SMS Api</label>
												<input class="form-control" id="sms_api" name="sms_api" type="text"
													placeholder="Enter SMS Api" maxlength="200"
													value="<?php echo isset($details['sms_api']) ? $details['sms_api'] : set_value("sms_api"); ?>">
												<?php echo form_error('sms_api', '<span class="text-danger">', '</span>'); ?>
											</div>

											<div class="form-group col-md-3">
												<label for="from_email">Email From </label>
												<input class="form-control" id="from_email" name="from_email"
													type="text" placeholder="Enter Email From" maxlength="200"
													value="<?php echo isset($details['from_email']) ? $details['from_email'] : set_value("from_email"); ?>">
												<?php echo form_error('from_email', '<span class="text-danger">', '</span>'); ?>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="from_email_pwd">Email Password</label>
													<input class="form-control" id="from_email_pwd" name="from_email_pwd"
														type="text" placeholder="Enter Email Password" maxlength="100"
														value="<?php echo isset($details['from_email_pwd']) ? $details['from_email_pwd'] : set_value("from_email_pwd"); ?>">

													<?php echo form_error('from_email_pwd', '<span class="text-danger help-inline">', '</span>'); ?>

													<small class="form-text text-muted helper-text">
														Your email password on google
													</small>
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="portlet-title">
												<br />
												<div class="caption">
													<i class="font-red-mint  icon-user"></i>
													<span class="caption-subject font-red-mint sbold">Reference
														Details</span>
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
															<option value="<?php echo $ref['ref_id']; ?>" <?php echo $selected; ?>><?php echo $ref['ref_name']; ?></option>
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
												<input class="form-control" id="cust_refby_contact"
													name="cust_refby_contact" type="text"
													placeholder="Enter Reference Contact" maxlength="10"
													value="<?php echo isset($details['cust_ref_contact']) ? $details['cust_ref_contact'] : set_value("cust_refby_contact"); ?>">
												<?php echo form_error('cust_refby_contact', '<span class="text-danger">', '</span>'); ?>
											</div>
											<div class="form-group col-md-3">
												<label for="cust_refby_email">Reference Email Id</label>
												<input class="form-control" id="cust_refby_email"
													name="cust_refby_email" type="text"
													placeholder="Enter Reference Email Id." maxlength="100"
													value="<?php echo isset($details['cust_ref_email']) ? $details['cust_ref_email'] : set_value("cust_refby_email"); ?>">
												<?php echo form_error('cust_refby_email', '<span class="text-danger">', '</span>'); ?>
											</div>

										</div>

										<div class="col-md-6 d-flex ">
											<div class="portlet-title">
												<br />
												<div class="caption">
													<i class="font-red-mint  icon-doc"></i>
													<span class="caption-subject font-red-mint sbold"> Company Logo
													</span>
												</div>
												<hr style="margin:3px;" />

											</div>


											<div class="form-group col-lg-6 col-md-2">
												<label for="cust_img">Upload Your Company Logo </label><br />
												<div class="input-icon">
													<input type="file" name="cust_img" id="cust_id_img"
														class="smart-file" data-label="Upload Company Logo"
														data-btn-class="btn btn red-pink btn-sm" data-preview="on"
														data-file-types="image/jpeg,image/png,image/jpg"
														accept="image/*" />
												</div>
												<?php echo form_error('cust_img', '<span class="text-danger">', '</span>'); ?>
												<span class="file_err text-danger "></span>
												<?php
												$logo_url = $details['cust_img_path'];
												$filename = basename(parse_url($logo_url, PHP_URL_PATH));

												if (!empty($filename) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $filename)) {
												?>
													<div id="existingLogoPreview" style="margin-bottom:10px;">
														<img src="<?php echo $logo_url; ?>"
															alt="Company Logo"
															style="max-height:120px; border:1px solid #ddd; padding:5px;">
													</div>
												<?php } ?>
											</div>
										</div>

										<div class="col-md-6 d-flex ">
											<div class="portlet-title">
												<br />
												<div class="caption">
													<i class="font-red-mint  icon-doc"></i>
													<span class="caption-subject font-red-mint sbold"> Company QR Code
													</span>
												</div>
												<hr style="margin:3px;" />

											</div>
											<div class="form-group col-lg-6 col-md-2">
												<label for="cust_qr">Upload Company QR Code </label><br />
												<div class="input-icon">
													<input type="file" name="cust_qr" id="cust_id_qr" class="smart-file"
														data-label="Upload Company QR Code"
														data-btn-class="btn btn red-pink btn-sm" data-preview="on"
														data-file-types="image/jpeg,image/png,image/jpg"
														accept="image/*" />
												</div>
												<?php echo form_error('cust_qr', '<span class="text-danger">', '</span>'); ?>
												<span class="file_err text-danger "></span>
												<?php
												$qr_url = $details['cust_qr_path'];
												$filenameqr = basename(parse_url($qr_url, PHP_URL_PATH));

												if (!empty($filenameqr) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $filenameqr)) {
												?>
													<div id="existingQrPreview" style="margin-bottom:10px;">
														<img src="<?php echo $qr_url; ?>"
															alt="Company QR Code"
															style="max-height:120px; border:1px solid #ddd; padding:5px;">
													</div>
												<?php } ?>
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
												<?php if (($action == "Add") || (isset($details['contactList']) && empty($details['contactList'])) || ($action == "Confirm" && empty($details['contactList']))) { ?>
													<div class="mt-repeater">
														<div data-repeater-list="group-b">
															<div data-repeater-item="" class="row">
																<div class="col-md-3">
																	<label class="control-label">Contact Person</label>
																	<input type="text" name="lead_altcontactperson"
																		placeholder="Contact Person"
																		class="form-control lead_altcontactperson"
																		maxlength="100">
																</div>
																<div class="col-md-3">
																	<label class="control-label">Contact No.</label>
																	<input type="text" name="lead_altcontact"
																		placeholder="Contact No." maxlength="10"
																		class="form-control lead_altcontact">
																</div>
																<div class="col-md-3">
																	<label class="control-label">Email Id.</label>
																	<input type="text" name="lead_altemail"
																		placeholder="Email Id." maxlength="100"
																		class="form-control lead_altemail">
																</div>
																<div class="col-md-1">
																	<label class="control-label">&nbsp;</label>
																	<a href="javascript:;" data-repeater-delete=""
																		class="btn btn-danger">
																		<i class="fa fa-close"></i>
																	</a>
																</div>
															</div>
														</div>
														<hr>
														<a href="javascript:;" data-repeater-create=""
															class="btn btn-info mt-repeater-add pull-right">
															<i class="fa fa-plus"></i></a>
														<br>
														<span class="text-danger" id="err_msg"></span><br>
													</div>

												<?php } ?>
												<?php if (($action == "Edit" || $action == "Confirm") && (isset($details['contactList']) && !empty($details['contactList']))) { ?>
													<div class="mt-repeater">
														<div data-repeater-list="group-b">
															<?php foreach ($details['contactList'] as $key => $cont) { ?>
																<div data-repeater-item="" class="row">
																	<div class="col-md-4">
																		<label class="control-label">Contact Person</label>
																		<input type="text"
																			name="group-b[<?php echo $key; ?>][lead_altcontactperson]"
																			placeholder="Contact Person"
																			class="form-control lead_altcontactperson"
																			maxlength="100"
																			value="<?php echo isset($cont['cust_contact_person']) ? $cont['cust_contact_person'] : ""; ?>">
																	</div>
																	<div class="col-md-3">
																		<label class="control-label">Contact No.</label>
																		<input type="text"
																			name="group-b[<?php echo $key; ?>][lead_altcontact]"
																			placeholder="Contact No." maxlength="10"
																			class="form-control lead_altcontact"
																			value="<?php echo isset($cont['cust_contact_no']) ? $cont['cust_contact_no'] : ""; ?>">
																	</div>
																	<div class="col-md-4">
																		<label class="control-label">Email Id.</label>
																		<input type="text"
																			name="group-b[<?php echo $key; ?>][lead_altemail]"
																			placeholder="Email Id." maxlength="100"
																			class="form-control lead_altemail"
																			value="<?php echo isset($cont['cust_contact_emailid']) ? $cont['cust_contact_emailid'] : ""; ?>">
																	</div>
																	<div class="col-md-1">
																		<label class="control-label">&nbsp;</label>
																		<a href="javascript:;" data-repeater-delete=""
																			class="btn btn-danger">
																			<i class="fa fa-close"></i>
																		</a>
																	</div>
																</div>
															<?php } ?>
														</div>
														<hr>
														<a href="javascript:;" data-repeater-create=""
															class="btn btn-info mt-repeater-add pull-right">
															<i class="fa fa-plus"></i></a>
														<br>
														<span class="text-danger" id="err_msg"></span><br>
													</div>

												<?php } ?>

											</div>

										</div>

										<div class="form-actions">
											<div class="col-md-12">
												<center>
													<span class="btn btn-success" id="add_edit_form_btn">Submit</span>
													<a href="<?php echo get_module_path(); ?>admin/my_account"
														class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
												</center>
											</div>
										</div>
							</form>

							<!-- /.box-body -->
							<script>
								const button = document.getElementById('add_edit_form_btn');

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
<style>
	.form-group {
		position: relative;
		margin-bottom: 25px;
		/* consistent spacing */
	}

	/* Default error message */
	.form-group .help-inline.text-danger {
		position: absolute;
		left: 0;
		font-size: 12px;
		line-height: 14px;
		margin-top: 2px;
	}

	/* For text inputs */
	.form-group input.form-control~.help-inline.text-danger {
		top: 100%;
	}

	/* For dropdowns */
	.form-group select.form-control~.help-inline.text-danger {
		top: 100%;
	}

	/* For textarea */
	.form-group textarea.form-control~.help-inline.text-danger {
		top: 100%;
	}

	.form-group select.form-control {
		height: 34px;
	}

	.form-group .help-inline.text-danger {
		top: 100%;
	}
</style>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- Form Validation Plugins -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js"
	type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js"
	type="text/javascript"></script>

<script type="text/javascript">
	// Add Branch

	$(document).ready(function() {

		// $.validator.addMethod("companyName", function(value, element) {
		// 	return this.optional(element) || /^[a-zA-Z0-9 .&-]+$/.test(value);
		// }, "Special characters are not allowed.");

		$.validator.addMethod("companyName", function(value, element) {
			return this.optional(element) || /^[a-zA-Z0-9 .&()\-]+$/.test(value);
		}, "Special characters are not allowed.");

		$.validator.addMethod("cust_refbyName", function(value, element) {
			return this.optional(element) || /^[a-zA-Z0-9\s.'-]+$/.test(value);
		}, "Only letters and valid name characters are allowed.");

		$.validator.addMethod("noOnlySpaces", function(value, element) {
			return this.optional(element) || $.trim(value).length > 0;
		}, "Spaces only are not allowed.");

		$('#bank_acc_name, #bank_acc_name1').on('input', function() {
			this.value = this.value.replace(/\s{2,}/g, ' '); // no double spaces
		});

		$('#cust_id_img').on('change', function() {
			if (this.files && this.files.length > 0) {
				$('#existingLogoPreview').hide();
			}
		});

		$('#cust_id_qr').on('change', function() {
			if (this.files && this.files.length > 0) {
				$('#existingQrPreview').hide();
			}
		});


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

		$('#bank_ifsc1').change(function() {
			var bank_ifsc1 = $("#bank_ifsc1").val();
			getIFSC1(bank_ifsc1);
		});


		$('.datepicker').datepicker({
			format: 'dd-M-yyyy',
			autoclose: true,
			todayHighlight: true,

		});

		// $('#cust_company_name').on('input', function() {
		// 	this.value = this.value.replace(/[^a-zA-Z0-9 .&-]/g, '');
		// });
		$('#cust_company_name').on('input', function() {
			this.value = this.value.replace(/[^a-zA-Z0-9 .&()\-]/g, '');
		});

		$('#cust_refbyname').on('input', function() {
			this.value = this.value
				.replace(/[^a-zA-Z0-9\s.'-]/g, '')
				.replace(/^[\s.'-]+/, '')
				.replace(/\s{2,}/g, ' ');
		});





		$("#add_edit_form").validate({
			rules: {
				required: {
					required: true
				},
				cust_service_type: {
					required: true,
				},
				invoice_pattern_id: {
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

				cust_company_name: {
					required: true,
					maxlength: 100,
					minlength: 2,
					companyName: true
				},

				cust_contact_person: {
					maxlength: 100,
					minlength: 2,
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
					required: true,
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
					maxlength: 6,
					minlength: 6,
					digits: true,
				},
				cust_service_det: {
					maxlength: 500,
					minlength: 2,
				},
				company_chq_bounce_chrg: {
					maxlength: 8,
					number: true,
				},
				cust_paid_amount: {
					maxlength: 8,
					number: true,
				},
				cust_unit_no: {
					maxlength: 50,
				},
				cust_form_no: {
					maxlength: 50,
				},

				cust_refbyname: {
					maxlength: 200,
					cust_refbyName: true,
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
				sms_api: {
					maxlength: 200,
				},
				from_email: {
					maxlength: 100,
					email: true,
				},
				from_email_pwd: {
					maxlength: 100,
					minlength: 5,
					/* noSpace: true, */
				},

				cust_img: {

					accept: "image/jpeg,image/png,image/jpg",
					filesize_max: 1000000, // 1 MB
					filesize_min: 10000, // 1 KB
				},

				cust_qr: {

					accept: "image/jpeg,image/png,image/jpg",
					filesize_max: 1000000, // 1 MB
					filesize_min: 10000, // 1 KB
				},


				bank_acc_name: {
					maxlength: 100,
					lettersonly: true,
					noOnlySpaces: true,
					required: function(element) {
						return $("#bank_acc_number").val().length > 0 ||
							$("#bank_name").val().length > 0 ||
							$("#bank_ifsc").val().length > 0 ||
							$("#bank_branch_address").val().length > 0 ||
							$("#bank_micr").val().length > 0;
					},
				},

				bank_micr: {
					required: function(element) {
						if ($("#bank_acc_number").val().length > 0) {
							return true;
						} else if ($("#bank_name").val().length > 0) {
							return true;
						} else if ($("#bank_ifsc").val().length > 0) {
							return true;
						} else if ($("#bank_branch_address").val().length > 0) {
							return true;
						} else if ($("#bank_acc_name").val().length > 0) {
							return true;
						} else {
							return false;
						}
					},
					maxlength: 9,
					digits: true,
				},
				bank_acc_number: {
					required: function(element) {
						if ($("#bank_micr").val().length > 0) {
							return true;
						} else if ($("#bank_name").val().length > 0) {
							return true;
						} else if ($("#bank_ifsc").val().length > 0) {
							return true;
						} else if ($("#bank_branch_address").val().length > 0) {
							return true;
						} else if ($("#bank_acc_name").val().length > 0) {
							return true;
						} else {
							return false;
						}
					},
					maxlength: 18,
					minlength: 9,
					digits: true,
				},
				bank_name: {
					required: function(element) {
						if ($("#bank_micr").val().length > 0) {
							return true;
						} else if ($("#bank_acc_number").val().length > 0) {
							return true;
						} else if ($("#bank_ifsc").val().length > 0) {
							return true;
						} else if ($("#bank_branch_address").val().length > 0) {
							return true;
						} else if ($("#bank_acc_name").val().length > 0) {
							return true;
						} else {
							return false;
						}
					},
					maxlength: 100,
					minlength: 2,
				},
				bank_ifsc: {
					ifsc: true,
					required: function(element) {
						if ($("#bank_micr").val().length > 0) {
							return true;
						} else if ($("#bank_acc_number").val().length > 0) {
							return true;
						} else if ($("#bank_name").val().length > 0) {
							return true;
						} else if ($("#bank_branch_address").val().length > 0) {
							return true;
						} else if ($("#bank_acc_name").val().length > 0) {
							return true;
						} else {
							return false;
						}
					},
					maxlength: 15,
					minlength: 11,
					remote: {
						url: base_url + "admin/checkIFSCExists",
						type: "post"
					},
				},
				bank_branch_address: {
					required: function(element) {
						if ($("#bank_micr").val().length > 0) {
							return true;
						} else if ($("#bank_acc_number").val().length > 0) {
							return true;
						} else if ($("#bank_name").val().length > 0) {
							return true;
						} else if ($("#bank_ifsc").val().length > 0) {
							return true;
						} else if ($("#bank_acc_name").val().length > 0) {
							return true;
						} else {
							return false;
						}
					},
					maxlength: 250,
					minlength: 2,
				},

				bank_acc_name1: {
					maxlength: 100,
					lettersonly: true,
					noOnlySpaces: true,
					required: function(element) {
						return $("#bank_acc_number1").val().length > 0 ||
							$("#bank_name1").val().length > 0 ||
							$("#bank_ifsc1").val().length > 0 ||
							$("#bank_branch_address1").val().length > 0 ||
							$("#bank_micr1").val().length > 0;
					},
				},

				bank_micr1: {
					required: function(element) {
						if ($("#bank_acc_number1").val().length > 0) {
							return true;
						} else if ($("#bank_name1").val().length > 0) {
							return true;
						} else if ($("#bank_ifsc1").val().length > 0) {
							return true;
						} else if ($("#bank_branch_address1").val().length > 0) {
							return true;
						} else if ($("#bank_acc_name1").val().length > 0) {
							return true;
						} else {
							return false;
						}
					},
					maxlength: 9,
					digits: true,
				},
				bank_acc_number1: {
					required: function(element) {
						if ($("#bank_micr1").val().length > 0) {
							return true;
						} else if ($("#bank_name1").val().length > 0) {
							return true;
						} else if ($("#bank_ifsc1").val().length > 0) {
							return true;
						} else if ($("#bank_branch_address1").val().length > 0) {
							return true;
						} else if ($("#bank_acc_name1").val().length > 0) {
							return true;
						} else {
							return false;
						}
					},
					maxlength: 18,
					minlength: 9,
					digits: true,
				},
				bank_name1: {
					required: function(element) {
						if ($("#bank_micr1").val().length > 0) {
							return true;
						} else if ($("#bank_acc_number1").val().length > 0) {
							return true;
						} else if ($("#bank_ifsc1").val().length > 0) {
							return true;
						} else if ($("#bank_branch_address1").val().length > 0) {
							return true;
						} else if ($("#bank_acc_name1").val().length > 0) {
							return true;
						} else {
							return false;
						}
					},
					maxlength: 100,
					minlength: 2,
				},
				bank_ifsc1: {
					ifsc: true,
					required: function(element) {
						if ($("#bank_micr1").val().length > 0) {
							return true;
						} else if ($("#bank_acc_number1").val().length > 0) {
							return true;
						} else if ($("#bank_name1").val().length > 0) {
							return true;
						} else if ($("#bank_branch_address1").val().length > 0) {
							return true;
						} else if ($("#bank_acc_name1").val().length > 0) {
							return true;
						} else {
							return false;
						}
					},
					maxlength: 15,
					minlength: 11,
					remote: {
						url: base_url + "admin/checkIFSCExists",
						type: "post"
					},
				},
				bank_branch_address1: {
					required: function(element) {
						if ($("#bank_micr1").val().length > 0) {
							return true;
						} else if ($("#bank_acc_number1").val().length > 0) {
							return true;
						} else if ($("#bank_name1").val().length > 0) {
							return true;
						} else if ($("#bank_ifsc1").val().length > 0) {
							return true;
						} else if ($("#bank_acc_name1").val().length > 0) {
							return true;
						} else {
							return false;
						}
					},
					maxlength: 250,
					minlength: 2,
				},
			},
			messages: {
				bank_ifsc: {
					remote: 'Invalid IFSC Code'
				},
				"service_id[]": {
					required: 'Please Select At least one Service'
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
					error.appendTo(element.closest('.form-group').find('.file_err'));
				} else if (element.is(":checkbox")) {
					error.appendTo("#file_err");
				} else {
					element.closest('.form-group').append(error);
				}
			},


		});

		$('#add_edit_form_btn').on('click', function(e) {

			$('#bank_acc_name, #bank_acc_name1').val(function(i, val) {
				return $.trim(val);
			});

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





	function delete_row(obj) {
		var id = $(obj).attr("data-id");
		$('#row_id_' + id).remove();

	}

	function add_row(obj) {
		var id = $(obj).attr("data-id");
		var data_id = getRandomInt(5);
		var html = '<tr id="row_id_' + data_id + '" data-id="' + data_id + '" ><td><input type="text" name="cust_service_dates_' + id + '[]" placeholder="Service Date" class="form-control datepicker" maxlength="100" value=""> </td><td><a href="javascript:;" onclick="delete_row(this);" data-id="' + data_id + '" class="btn btn-danger btn-xs"><i class="fa fa-close"></i></a></td></tr>';
		$("#table_" + id).append(html);
		$('.datepicker').datepicker({
			format: 'dd-M-yyyy',
			autoclose: true,
			todayHighlight: true,

		});
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

	function getIFSC1(emp_bank_ifsc_code) {
		$('#ifsc_code1').html("");
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
					$("#ifsc_code1").html(data.BRANCH);
					$("#bank_branch_address1").val(data.ADDRESS);
					$("#bank_name1").val(data.BANK);
					$("#bank_micr1").val(data.MICR);
				}
			});
		}
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

				$("#cust_refby_email").val(data.ref_email);
				$("#cust_refbyname").val(data.ref_person_name);
				$("#cust_refby_contact").val(data.ref_mobile);

			}
		});
	}

	function get_invoice_details(obj) {
		var img = $('option:selected', obj).attr('data-img');
		var html = '<br/><a class="fancybox-button" target="_blank" href="' + img + '" ><img title="" src="' + img + '" class="img-rounded" width="100"></a>';

		$("#invoice_det").html(html);

	}
</script>