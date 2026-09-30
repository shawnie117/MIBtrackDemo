<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE BASE CONTENT -->

		<?php $icon = "icon-plus";
		if ($action == "Edit") {
			$icon = "icon-pencil";
		}  ?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<ul class="page-breadcrumb breadcrumb">
						<li><a href="<?php echo base_url(get_module() . "/dashboard") ?>">Home</a><i class="fa fa-circle"></i></li>
						<li><a href="<?php echo base_url(get_module() . "/admin/employee_report") ?>">All Employees </a><i class="fa fa-circle"></i></li>
						<li><span class="active"><?php echo $page_title; ?></span></li>
					</ul>
					<div class="portlet-title">
						<div class="caption">
							<i class="font-red-mint <?php echo $icon; ?> "></i>
							<span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
						</div>
					</div>
					<div class="row">
						<div class="portlet-body form ">
							<?php if ($action == "Edit") {  //echo "<pre/>"; print_r($details);die; 
								$details = html_escape($details);

								// $formaction = "edit_employee/?id=" . base64_encode($id);
								//add by ritika 25 may 

								$page = isset($_GET['page']) ? $_GET['page'] : 1;

								$formaction = "edit_employee/?id=" . base64_encode($id) . "&page=" . $page . "&history=back";
							} else {
								$formaction = "add_employee";
							} ?>
							<form action="<?php echo get_module_path() . 'admin/' . $formaction; ?>" id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data">
								<div class="form-body" style="padding:0px">

									<div class="col-md-12">
										<div class="portlet-body">
											<div class="portlet-title">

												<div class="caption">
													<i class="font-red-mint icon-user"></i>
													<span class="caption-subject font-red-mint sbold">Basic Details</span>
												</div>
												<!-- <hr style="margin:1px;"/> -->
											</div>
											<div class="col-md-12">

												<div class="form-group col-md-3">
													<label for="emp_name">Employee Name</label><?php echo REQUIRED_STAR; ?>
													<?php if ($action == "Edit") { ?>
														<input type="hidden" name="id" value="<?php echo $id; ?>">
													<?php } ?>
													<input class="form-control" id="emp_name" name="emp_name" type="text" placeholder="Enter Employee Name" required maxlength="100" value="<?php echo isset($details['emp_name']) ? $details['emp_name'] : set_value("emp_name"); ?>">
													<?php echo form_error('emp_name', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-3">
													<label for="emp_mob1">Mobile No1</label><?php echo REQUIRED_STAR; ?>

													<?php
$isSuperAdmin = isset($details['emp_permissionid']) && $details['emp_permissionid'] == 1;
?>

<input class="form-control"
       id="emp_mob1"
       name="emp_mob1"
       type="text"
       placeholder="Enter Mobile No"
       required
       maxlength="10"
       value="<?php echo isset($details['emp_mob1']) ? $details['emp_mob1'] : set_value('emp_mob1'); ?>"
       <?= $isSuperAdmin ? 'readonly' : ''; ?>>

													<?php echo form_error('emp_mob1', '<span class="text-danger">', '</span>'); ?>

													<!-- <span id="mobile_error" class="text-danger"></span> -->

													<span id="mobile_error" class="text-danger"></span>

													<?php if ($this->session->flashdata('mobile_error')) { ?>
														<span class="text-danger">
															<?php echo $this->session->flashdata('mobile_error'); ?>
														</span>
													<?php } ?>
												</div>

												<div class="form-group col-md-3">
													<label for="emp_emailid">Email Id</label>
													<input class="form-control" id="emp_emailid" name="emp_emailid" type="text" placeholder="Enter Email Id" maxlength="100" value="<?php echo isset($details['emp_emailid']) ? $details['emp_emailid'] : set_value("emp_emailid"); ?>">
													<?php echo form_error('emp_emailid', '<span class="text-danger">', '</span>'); ?>
												</div>


												<!-- <div class="form-group col-md-3">
													<label for="emp_rpt_to">Reporting To </label><?php echo REQUIRED_STAR; ?>
													<select class="form-control" id="emp_rpt_to" name="emp_rpt_to">
														<option value=""> Select Reporting To</option>
														<?php if (!empty($employee_list)) {
															foreach ($employee_list as $employee) {
																$emp_rpt_to =  isset($details['emp_rpt_to']) ? $details['emp_rpt_to'] : set_value("emp_rpt_to");
																$selected  = $emp_rpt_to == $employee['emp_id'] ? "selected" : "";
														?>
																<option value="<?php echo $employee['emp_id']; ?>" <?php echo $selected; ?>><?php echo $employee['emp_name']; ?></option>
														<?php }
														} ?>
													</select>

													<?php echo form_error('emp_rpt_to', '<span class="text-danger">', '</span>'); ?>
												</div>  -->

												<!-- add by ritika -->
												<div class="form-group col-md-3">
													<label for="emp_rpt_to">Reporting To </label><?php echo REQUIRED_STAR; ?>
													<select class="form-control selectpicker" data-live-search="true"
														data-width="100%" id="emp_rpt_to" name="emp_rpt_to">
														<option value=""> Select Reporting To</option>
														<?php if (!empty($employee_list)) {
															foreach ($employee_list as $employee) {
																$emp_rpt_to =  isset($details['emp_rpt_to']) ? $details['emp_rpt_to'] : set_value("emp_rpt_to");
																$selected  = $emp_rpt_to == $employee['emp_id'] ? "selected" : "";
														?>
																<option value="<?php echo $employee['emp_id']; ?>" <?php echo $selected; ?>><?php echo $employee['emp_name']; ?></option>
														<?php }
														} ?>
													</select>

													<?php echo form_error('emp_rpt_to', '<span class="text-danger">', '</span>'); ?>
												</div>
												<!-- add by ritika 22 june -->
												<style>
													.bootstrap-select .dropdown-menu li a {
														white-space: nowrap !important;
														overflow: hidden !important;
														text-overflow: ellipsis !important;
														display: block !important;
														max-width: 250px !important;
													}

													.bootstrap-select .filter-option {
														white-space: nowrap !important;
														overflow: hidden !important;
														text-overflow: ellipsis !important;
													}
												</style>






												<div class="form-group col-md-3">
													<label for="permission_id">Designation </label><?php echo REQUIRED_STAR; ?>
													<select class="form-control" id="permission_id" name="permission_id">
														<option value=""> Select Designation</option>
														<?php if (!empty($permission_list)) {
															foreach ($permission_list as $permission) {
																$permission_id =  isset($details['emp_permissionid']) ? $details['emp_permissionid'] : set_value("permission_id");
																$selected  = $permission_id == $permission['permission_id'] ? "selected" : "";
														?>
																<option value="<?php echo $permission['permission_id']; ?>" <?php echo $selected; ?>><?php echo $permission['permission_name']; ?></option>
														<?php }
														} ?>
													</select>

													<?php echo form_error('permission_id', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-3">
													<label for="department_id">Department </label><?php echo REQUIRED_STAR; ?>
													<select class="form-control" id="department_id" name="department_id" onchange="get_sub_dept_list(this,'sub_dept_id');">
														<option value=""> Select Department</option>
														<?php if (!empty($department_list)) {
															foreach ($department_list as $dept) {
																$department_id =  isset($details['emp_departmentid']) ? $details['emp_departmentid'] : set_value("department_id");
																$selected  = $department_id == $dept['dept_id'] ? "selected" : "";
														?>
																<option value="<?php echo $dept['dept_id']; ?>" <?php echo $selected; ?>><?php echo $dept['dept_name']; ?></option>
														<?php }
														} ?>
													</select>

													<?php echo form_error('department_id', '<span class="text-danger">', '</span>'); ?>
												</div>

												<div class="form-group col-md-3">
													<label for="sub_dept_id">Sub Department </label>
													<select class="form-control" id="sub_dept_id" name="sub_dept_id">
														<option value=""> Select Sub Department</option>
														<?php if (!empty($sub_department_list)) {
															foreach ($sub_department_list as $sub_dept) {
																$sub_dept_id =  isset($details['emp_subdepartmentid']) ? $details['emp_subdepartmentid'] : set_value("sub_dept_id");
																$selected  = $sub_dept_id == $sub_dept['sub_dept_id'] ? "selected" : "";
														?>
																<option value="<?php echo $sub_dept['sub_dept_id']; ?>" <?php echo $selected; ?>><?php echo $sub_dept['sub_dept_name']; ?></option>
														<?php }
														} ?>
													</select>

													<?php echo form_error('sub_dept_id', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-3">
													<label for="emp_mob2">Mobile No2</label>
													<input class="form-control" id="emp_mob2" name="emp_mob2" type="text" placeholder="Enter Mobile No2" maxlength="10" value="<?php echo isset($details['emp_mob2']) ? $details['emp_mob2'] : set_value("emp_mob2"); ?>">
													<?php echo form_error('emp_mob2', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-3">
													<label for="location_tracking">Location Tracking</label>
													<?php echo REQUIRED_STAR; ?>

													<select class="form-control" id="location_tracking"
														name="location_tracking">
														<option value="">Select Option</option>

														<option value="Yes" <?php echo set_select(
																				'location_tracking',
																				'Yes',
																				isset($details['emp_location_tracking']) && $details['emp_location_tracking'] == "Yes"
																			); ?>>
															Yes
														</option>

														<option value="No" <?php echo set_select(
																				'location_tracking',
																				'No',
																				!isset($details['emp_location_tracking']) || $details['emp_location_tracking'] == "No"
																			); ?>>
															No
														</option>
													</select>

													<?php echo form_error('location_tracking', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-3">
													<label for="emp_dob">Date of Birth</label>
													<input class="form-control datepicker" id="emp_dob" name="emp_dob" type="text" placeholder="Select Date of Birth" maxlength="15" value="<?php echo isset($details['emp_dob']) ? date('d-m-Y', strtotime($details['emp_dob'])) : set_value('emp_dob'); ?>">
													<?php echo form_error('emp_dob', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-3">
													<label for="emp_joining_date">Joining Date</label><?php echo REQUIRED_STAR; ?>
													<input
														class="form-control datepicker"
														id="emp_joining_date"
														name="emp_joining_date"
														type="text"
														placeholder="Select Joining Date"
														autocomplete="off"
														value="<?php echo isset($details['emp_joining_date']) ? date('d-m-Y', strtotime($details['emp_joining_date'])) : set_value('emp_joining_date'); ?>">

													<?php echo form_error('emp_joining_date', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>

											<div class="col-md-12">
												<div class="portlet-title">
													<br />
													<div class="caption">
														<i class="font-red-mint icon-graduation"></i>
														<span class="caption-subject font-red-mint sbold">Education Details</span>
													</div>
													<hr style="margin:1px;" />
												</div>

												<?php  ?>
												<div class="form-group col-md-3">
													<label for="emp_hst_edu_id">Education </label>
													<select class="form-control" id="emp_hst_edu_id" name="emp_hst_edu_id">
														<option value=""> Select Education</option>
														<?php if (!empty($education_list)) {
															foreach ($education_list as $education) {
																$edu_id =  isset($details['empEducationList'][0]['emp_edu_hst_edu_id']) ? $details['empEducationList'][0]['emp_edu_hst_edu_id'] : set_value("emp_hst_edu_id");
																$selected  = $edu_id == $education['edu_id'] ? "selected" : "";
														?>
																<option value="<?php echo $education['edu_id']; ?>" <?php echo $selected; ?>><?php echo $education['edu_name']; ?></option>
														<?php }
														} ?>
													</select>

													<?php echo form_error('emp_hst_edu_id', '<span class="text-danger">', '</span>'); ?>
												</div>

												<div class="form-group col-md-3">
													<label for="emp_edu_other_details">Education Other Details</label>
													<input class="form-control" id="emp_edu_other_details" name="emp_edu_other_details" type="text" placeholder="Enter Education Other Details" maxlength="100" value="<?php echo isset($details['empEducationList'][0]['emp_edu_other_details']) ? $details['empEducationList'][0]['emp_edu_other_details'] : set_value("emp_edu_other_details"); ?>">
													<?php echo form_error('emp_edu_other_details', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>


											<div class="col-md-12">
												<div class="portlet-title">
													<br />
													<div class="caption">
														<i class="font-red-mint icon-wallet"></i>
														<span class="caption-subject font-red-mint sbold">Bank Account Details</span>
													</div>
													<hr style="margin:1px;" />
												</div>

												<div class="form-group col-md-4">
													<label for="emp_bank_account_name">Bank Account Name</label>
													<input class="form-control" id="emp_bank_account_name" name="emp_bank_account_name" type="text" placeholder="Enter Bank Account Name" maxlength="100" value="<?php echo isset($details['empBankList'][0]['emp_bank_account_name']) ? $details['empBankList'][0]['emp_bank_account_name'] : set_value("emp_bank_account_name"); ?>">
													<?php echo form_error('emp_bank_account_name', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-4">
													<label for="emp_bank_accno">Enter Account No.</label>
													<input class="form-control" id="emp_bank_accno" name="emp_bank_accno" type="number" placeholder="Enter Enter Account No." maxlength="20" value="<?php echo isset($details['empBankList'][0]['emp_bank_account_no']) ? $details['empBankList'][0]['emp_bank_account_no'] : set_value("emp_bank_accno"); ?>">
													<?php echo form_error('emp_bank_accno', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-4">
													<label for="re_emp_bank_accno">Re-Enter Account No.</label>
													<input class="form-control" id="re_emp_bank_accno" name="re_emp_bank_accno" type="number" placeholder="Enter Enter Account No." maxlength="20" value="<?php echo isset($details['empBankList'][0]['emp_bank_account_no']) ? $details['empBankList'][0]['emp_bank_account_no'] : set_value("emp_bank_accno"); ?>">
													<?php echo form_error('emp_bank_accno', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-4">
													<label for="emp_bank_ifsc_code">IFSC Code</label>
													<input class="form-control" id="emp_bank_ifsc_code" name="emp_bank_ifsc_code" type="text" placeholder="Enter IFSC Code" maxlength="15" value="<?php echo isset($details['empBankList'][0]['emp_bank_ifsc']) ? $details['empBankList'][0]['emp_bank_ifsc'] : set_value("emp_bank_ifsc_code"); ?>">
													<?php echo form_error('emp_bank_ifsc_code', '<span class="text-danger">', '</span>'); ?>
													<span id="ifsc_code" class="text-success"></span>
												</div>
												<div class="form-group col-md-4">
													<label for="emp_bank_name">Bank Name</label>
													<input class="form-control" id="emp_bank_name" name="emp_bank_name" type="text" placeholder="Enter Bank Name" maxlength="100" value="<?php echo isset($details['empBankList'][0]['emp_bank_name']) ? $details['empBankList'][0]['emp_bank_name'] : set_value("emp_bank_name"); ?>">
													<?php echo form_error('emp_bank_name', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-4">
													<label for="emp_bank_branch_addrs">Branch Address</label>
													<input class="form-control" id="emp_bank_branch_addrs" name="emp_bank_branch_addrs" type="text" placeholder="Enter Branch Address" maxlength="100" value="<?php echo isset($details['empBankList'][0]['emp_bank_branch_addrs']) ? $details['empBankList'][0]['emp_bank_branch_addrs'] : set_value("emp_bank_name"); ?>">
													<?php echo form_error('emp_bank_branch_addrs', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-12">
												<div class="portlet-title">
													<br />
													<div class="caption">
														<i class="font-red-mint icon-pointer"></i>
														<span class="caption-subject font-red-mint sbold">Current Address Details</span>
													</div>
													<hr style="margin:1px;" />
												</div>

												<div class="form-group col-md-3">
													<label for="emp_address">Address</label>
													<input class="form-control" id="emp_address" name="emp_address" type="text" placeholder="Enter Address" maxlength="300" value="<?php echo isset($details['emp_address']) ? $details['emp_address'] : set_value("emp_address"); ?>">
													<?php echo form_error('emp_address', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-3">
													<label for="emp_landmark">LandMark</label>
													<input class="form-control" id="emp_landmark" name="emp_landmark" type="text" placeholder="Enter LandMark" maxlength="50" value="<?php echo isset($details['emp_landmark']) ? $details['emp_landmark'] : set_value("emp_landmark"); ?>">
													<?php echo form_error('emp_landmark', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-3">
													<label for="emp_areaname">Area</label>
													<input class="form-control" id="emp_areaname" name="emp_areaname" type="text" placeholder="Enter Area" maxlength="50" value="<?php echo isset($details['emp_areaname']) ? $details['emp_areaname'] : set_value("emp_areaname"); ?>">
													<?php echo form_error('emp_areaname', '<span class="text-danger">', '</span>'); ?>
												</div>


												<!-- dhanraj - pincode dynamic 14-08-24 -->

												<div class="form-group col-md-3">
													<label for="emp_pincode">Pincode</label>
													<input class="form-control" id="emp_pincode" name="emp_pincode" type="text" placeholder="Enter Pincode" maxlength="6" value="<?php echo isset($details['custPinCodeList'][0]['cust_pin_code']) ? $details['custPinCodeList'][0]['cust_pin_code'] : set_value("cust_pincode"); ?>">
													<?php echo form_error('emp_pincode', '<span class="text-danger">', '</span>'); ?>
													<span id="pin_code" class="text-success"></span>
												</div>

												<div class="form-group col-md-3">
													<label for="emp_city">City</label>
													<select class="form-control" id="emp_city" name="emp_city">
														<option value="">Select City</option>
													</select>
													<?php echo form_error('emp_city', '<span class="text-danger">', '</span>'); ?>
												</div>

												<!-- dhanraj - select by dropdown api 14-08-24 -->



												<div class="form-group col-md-3">
													<label for="emp_state">State</label>
													<input class="form-control" id="emp_state" name="emp_state" type="text" placeholder="Enter State Name" maxlength="100" value="<?php echo isset($details['empPinCodeList'][0]['emp_state']) ? $details['empPinCodeList'][0]['emp_state'] : set_value("emp_state"); ?>">
													<?php echo form_error('emp_state', '<span class="text-danger">', '</span>'); ?>
												</div>

												<div class="form-group col-md-3">
													<label for="emp_dist">District</label>
													<input class="form-control" id="emp_dist" name="emp_dist" type="text" placeholder="Enter District Name" maxlength="100" value="<?php echo isset($details['empPinCodeList'][0]['emp_dist']) ? $details['empPinCodeList'][0]['emp_dist'] : set_value("emp_dist"); ?>">
													<?php echo form_error('emp_dist', '<span class="text-danger">', '</span>'); ?>
												</div>

												<div class="col-md-12" style="padding:0px;">

													<div class="portlet-title">
														<br />
														<div class="caption">
															<i class="font-red-mint icon-pointer"></i>
															<span class="caption-subject font-red-mint sbold">Permanant AddressDetails</span>
															&nbsp; &nbsp; &nbsp;
															<input type="checkbox" class="minimal" name="per_addr_same" id="per_addr_same" value="Yes" /> <small>(if Permanant Address Is Same As Current Address Click Checkbox)</small>
														</div>

														<hr style="margin:1px;" />
													</div>

													<div class="form-group col-md-3">
														<label for="emp_permaddress">Address</label>
														<input class="form-control" id="emp_permaddress" name="emp_permaddress" type="text" placeholder="Enter Address" maxlength="300" value="<?php echo isset($details['emp_perm_address']) ? $details['emp_perm_address'] : set_value("emp_permaddress"); ?>">
														<?php echo form_error('emp_permaddress', '<span class="text-danger">', '</span>'); ?>
													</div>
													<div class="form-group col-md-3">
														<label for="emp_perm_landmark">LandMark</label>
														<input class="form-control" id="emp_perm_landmark" name="emp_perm_landmark" type="text" placeholder="Enter LandMark" maxlength="50" value="<?php echo isset($details['emp_perm_landmark']) ? $details['emp_perm_landmark'] : set_value("emp_perm_landmark"); ?>">
														<?php echo form_error('emp_perm_landmark', '<span class="text-danger">', '</span>'); ?>
													</div>
													<div class="form-group col-md-3">
														<label for="emp_perm_areaname">Area</label>
														<input class="form-control" id="emp_perm_areaname" name="emp_perm_areaname" type="text" placeholder="Enter Area" maxlength="50" value="<?php echo isset($details['emp_perm_areaname']) ? $details['emp_perm_areaname'] : set_value("emp_perm_areaname"); ?>">
														<?php echo form_error('emp_perm_areaname', '<span class="text-danger">', '</span>'); ?>
													</div>

													<!-- dhanraj - pincode dynamic 14-08-24 -->

													<div class="form-group col-md-3">
														<label for="emp_perm_pincode">Pincode</label>
														<input class="form-control" id="emp_perm_pincode" name="emp_perm_pincode" type="text" placeholder="Enter Pincode" maxlength="6" value="<?php echo isset($details['empPinCodeList'][0]['emp_pin_code']) ? $details['empPinCodeList'][0]['emp_pin_code'] : set_value("emp_perm_pincode"); ?>">
														<?php echo form_error('emp_perm_pincode', '<span class="text-danger">', '</span>'); ?>
														<span id="pin_code" class="text-success"></span>
													</div>

													<div class="form-group col-md-3">
														<label for="emp_perm_city">City</label>
														<select class="form-control" id="emp_perm_city" name="emp_perm_city">
															<option value="">Select City</option>
														</select>
														<?php echo form_error('emp_perm_city', '<span class="text-danger">', '</span>'); ?>
													</div>

													<!-- dhanraj - select by dropdown api 14-08-24 -->





													<div class="form-group col-md-3">
														<label for="emp_perm_state">State</label>
														<input class="form-control" id="emp_perm_state" name="emp_perm_state" type="text" placeholder="Enter State Name" maxlength="100" value="<?php echo isset($details['empPinCodeList'][0]['emp_perm_state']) ? $details['empPinCodeList'][0]['emp_perm_state'] : set_value("emp_perm_state"); ?>">
														<?php echo form_error('emp_perm_state', '<span class="text-danger">', '</span>'); ?>
													</div>

													<div class="form-group col-md-3">
														<label for="emp_perm_dist">District</label>
														<input class="form-control" id="emp_perm_dist" name="emp_perm_dist" type="text" placeholder="Enter District Name" maxlength="100" value="<?php echo isset($details['empPinCodeList'][0]['emp_perm_dist']) ? $details['empPinCodeList'][0]['emp_perm_dist'] : set_value("emp_perm_dist"); ?>">
														<?php echo form_error('emp_perm_dist', '<span class="text-danger">', '</span>'); ?>
													</div>





													<!-- <div class="form-group col-md-3"> 
							<label for="emp_perm_stateid">State </label>	  
                            <select class="form-control" id="emp_perm_stateid" name="emp_perm_stateid" onchange="get_state_districts(this,'emp_perm_distid');">
							<option value=""> Select State</option>
							 <?php if (!empty($state_list)) {
									foreach ($state_list as $state) {
										$state_id =  isset($details['emp_perm_stateid']) ? $details['emp_perm_stateid'] : set_value("emp_perm_stateid");
										$selected = $state_id == $state['state_id'] ? "selected" : "";

								?>
									<option value="<?php echo $state['state_id']; ?>" <?php echo $selected; ?> ><?php echo $state['state_name']; ?></option>
							<?php }
								} ?>	
						   </select>	
                           <?php echo form_error('emp_perm_stateid', '<span class="text-danger">', '</span>'); ?>						   
                        </div> 
						
					    
						 
						
						 <div class="form-group col-md-3">  
						<label for="emp_perm_distid">District </label>
                          <select class="form-control" id="emp_perm_distid" name="emp_perm_distid" onchange="get_district_cities(this,'emp_perm_stateid','emp_perm_cityid');">
							<option value=""> Select District</option>
							 <?php if (!empty($per_dist_list)) {
									foreach ($per_dist_list as $dist) {
										$dist_id =  isset($details['emp_perm_distid']) ? $details['emp_perm_distid'] : set_value("emp_perm_distid");
										$selected = $dist_id == $dist['dist_id'] ? "selected" : "";

								?>
									<option value="<?php echo $dist['dist_id']; ?>" <?php echo $selected; ?> ><?php echo $dist['dist_name']; ?></option>
							<?php }
								} ?>	
						   </select>
							<?php echo form_error('emp_perm_distid', '<span class="text-danger">', '</span>'); ?>							   
                        </div>
						<div class="form-group col-md-3">  
						<label for="emp_perm_cityid">City </label>
                          <select class="form-control" id="emp_perm_cityid" name="emp_perm_cityid" >
							<option value=""> Select City</option>
							 <?php if (!empty($per_city_list)) {
									foreach ($per_city_list as $city) {
										$city_id =  isset($details['emp_perm_cityid']) ? $details['emp_perm_cityid'] : set_value("emp_perm_cityid");
										$selected = $city_id == $city['city_id'] ? "selected" : "";

								?>
									<option value="<?php echo $city['city_id']; ?>" <?php echo $selected; ?> ><?php echo $city['city_name']; ?></option>
							<?php }
								} ?>	
						   </select>
							<?php echo form_error('emp_perm_cityid', '<span class="text-danger">', '</span>'); ?>								   
                        </div>
						
                        </div> -->
												</div>

												<div class="col-md-12" style="padding:0px;">
													<div class="portlet-title">
														<br />
														<div class="caption">
															<i class="font-red-mint  icon-briefcase"></i>
															<span class="caption-subject font-red-mint sbold">KYC Details</span>
														</div>
														<hr style="margin:2px;" />
													</div>

													<div class="form-group col-md-3">
														<label for="emp_kyc_type1">ID Proof Type </label>
														<select class="form-control" id="emp_kyc_type1" name="emp_kyc_type1">
															<option value=""> Select ID Proof Type</option>
															<?php if (!empty($proof_list)) {
																foreach ($proof_list as $proof) {
																	$state_id =  isset($details['empKycList'][0]['emp_kyc_type1']) ? $details['empKycList'][0]['emp_kyc_type1'] : set_value("emp_kyc_type1");
																	$selected = $state_id == $proof ? "selected" : "";

															?>
																	<option value="<?php echo $proof; ?>" <?php echo $selected; ?>><?php echo $proof; ?></option>
															<?php }
															} ?>
														</select>
														<?php echo form_error('emp_kyc_type1', '<span class="text-danger">', '</span>'); ?>
													</div>
													<div class="form-group col-md-3">
														<label for="emp_kyc_idnum1">ID Proof No.</label>
														<input class="form-control" id="emp_kyc_idnum1" name="emp_kyc_idnum1" type="text" placeholder="Enter ID Proof No." maxlength="20" value="<?php echo isset($details['empKycList'][0]['emp_kyc_idnum1']) ? $details['empKycList'][0]['emp_kyc_idnum1'] : set_value("emp_kyc_idnum1"); ?>">
														<?php echo form_error('emp_kyc_idnum1', '<span class="text-danger">', '</span>'); ?>
													</div>
													<div class="form-group col-md-3">
														<label for="emp_kyc_photo1">ID Proof Image</label><br />
														<input type="file" name="emp_kyc_photo1" id="emp_kyc_photo1"
															class="smart-file"
															data-label="ID Proof Image"
															data-btn-class="btn btn-default btn-sm"
															data-preview="on"
															data-file-types="image/jpeg,image/png,image/jpg" accept="image/*" />
														<?php echo form_error('emp_kyc_photo1', '<span class="text-danger">', '</span>'); ?>


														<span class="file_err"></span>
													</div>
													<div class="">
														<?php if ($action == "Edit") {
															$image1      = $details['empKycList'][0]['emp_kyc_photo1'];
															$image1     = str_replace("getAuthApiKey", APIKEY, $image1);
														?>
															<ul class="list-unstyled small fileList thumbs">
																<li><a href="<?php echo $image1; ?>" class="fancybox-button" data-rel="fancybox-button"><img title="ID Proof Image" src="<?php echo $image1; ?>" alt="<?php echo $details['empKycList'][0]['emp_kyc_type1']; ?>" class="img-rounded"><span class="file-name"></span></a> </li>
															</ul>
														<?php } ?>
													</div>
												</div>

												<div class="col-md-12" style="padding:0px;">
													<div class="form-group col-md-3">
														<label for="emp_addrs_prf_type">Address Proof Type </label>
														<select class="form-control" id="emp_addrs_prf_type" name="emp_addrs_prf_type">
															<option value=""> Select Proof Type</option>
															<?php if (!empty($proof_list)) {
																foreach ($proof_list as $proof) {
																	$state_id =  isset($details['empKycList'][0]['emp_addrs_prf_type']) ? $details['empKycList'][0]['emp_addrs_prf_type'] : set_value("emp_addrs_prf_type");
																	$selected = $state_id == $proof ? "selected" : "";

															?>
																	<option value="<?php echo $proof; ?>" <?php echo $selected; ?>><?php echo $proof; ?></option>
															<?php }
															} ?>
														</select>
														<?php echo form_error('emp_addrs_prf_type', '<span class="text-danger">', '</span>'); ?>
													</div>
													<div class="form-group col-md-3">
														<label for="emp_addrs_prf_no">Address Proof No.</label>
														<input class="form-control" id="emp_addrs_prf_no" name="emp_addrs_prf_no" type="text" placeholder="Enter Address Proof Details" maxlength="20" value="<?php echo isset($details['empKycList'][0]['emp_addrs_prf_no']) ? $details['empKycList'][0]['emp_addrs_prf_no'] : set_value("emp_addrs_prf_no"); ?>">
														<?php echo form_error('emp_addrs_prf_no', '<span class="text-danger">', '</span>'); ?>
													</div>
													<div class="form-group col-md-3">
														<label for="emp_addrs_prf_img">Address Proof Image</label><br />
														<input type="file" name="emp_addrs_prf_img" id="emp_addrs_prf_img"
															class="smart-file"
															data-label="Address Proof Image"
															data-btn-class="btn btn-default btn-sm"
															data-preview="on"
															data-file-types="image/jpeg,image/png,image/jpg" accept="image/*" />
														<?php echo form_error('emp_addrs_prf_img', '<span class="text-danger">', '</span>'); ?>


														<span class="file_err"></span>
													</div>
													<div class="">
														<?php if ($action == "Edit") {
															$image3      = $details['empKycList'][0]['emp_addrs_prf_img'];
															$image3     = str_replace("getAuthApiKey", APIKEY, $image3);
														?>
															<ul class="list-unstyled small fileList thumbs">
																<li><a href="<?php echo $image3; ?>" class="fancybox-button" data-rel="fancybox-button"><img title="Address Proof Image" src="<?php echo $image3; ?>" alt="<?php echo $details['empKycList'][0]['emp_addrs_prf_type']; ?>" class="img-rounded"><span class="file-name"></span> </a></li>
															</ul>
														<?php } ?>
													</div>
													<div class="form-group col-md-3">
														<label for="emp_image">Employee Image</label><br />
														<input type="file" name="emp_image" id="emp_image"
															class="smart-file"
															data-label="Employee Image"
															data-btn-class="btn btn-default btn-sm"
															data-preview="on"
															data-file-types="image/jpeg,image/png,image/jpg" accept="image/*" />
														<?php echo form_error('emp_image', '<span class="text-danger">', '</span>'); ?>
														<?php if ($action == "Edit") {
															$image2     = $details['emp_image_path'];
															$image2     = str_replace("getAuthApiKey", APIKEY, $image2);
														?>
															<ul class="list-unstyled small fileList thumbs">
																<li><a href="<?php echo $image2; ?>" class="fancybox-button" data-rel="fancybox-button"><img title="Employee Image" src="<?php echo $image2; ?>" alt="<?php echo $details['emp_name']; ?>" class="img-rounded"><span class="file-name"></span></a> </li>
															</ul>
														<?php } ?>
														<span class="file_err"></span>
													</div>
												</div>
											</div>
										</div>
										<div class="form-actions">
											<div class="col-md-offset-3 col-md-9" style="display: flex; justify-content: center; gap: 5px; width: 50%;">
												<button class="btn btn-success" id="mybutton" type="submit">Submit</button>
												<a href="<?php echo get_module_path(); ?>admin/employee_report/?page=<?php echo isset($page) ? (int) $page : 1; ?>&history=back"
													class="btn btn-danger">
													<i class="fa fa-history"></i>Back
												</a>
											</div>
										</div>
							</form>

							<!-- /.box-body -->

							<script>
								const button = document.getElementById('mybutton');

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

							<!-- add by ritika -->

							<script>
								$('#emp_mob1').blur(function() {

									var mobile = $(this).val();

									if (mobile == '') {
										return;
									}

									$.ajax({
										url: "<?php echo get_module_path(); ?>admin/check_employee_mobile",
										type: "POST",
										data: {
											mobile: mobile
										},
										success: function(response) {

											if ($.trim(response) == "MOBILE_EXISTS") {

												$('#mobile_error').html('Mobile Number Already Exists');

											} else {

												$('#mobile_error').html('');
											}
										}
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
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- Form Validation Plugins -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

<script type="text/javascript">
	// Add Branch

	$(document).ready(function() {


		$('.smart-file').bootstrapFileField({
			maxNumFiles: 8,
			fileTypes: 'image/jpeg,image/png,image/jpg',
			/* 	minNumFiles:1, */
			maxFileSize: 4000000 // 8Mb in bytes */
		});

		$('.datepicker').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,
			endDate: "today"
		});

		$("#add_edit_form").validate({
			rules: {
				required: {
					required: true
				},
				emp_name: {
					required: true,
					maxlength: 100,
					minlength: 2,
				},
				emp_mob1: {
					required: true,
					maxlength: 10,
					minlength: 10,
					digits: true,
				},
				emp_mob2: {
					maxlength: 10,
					minlength: 10,
					digits: true,
				},
				emp_emailid: {
					// required: true,
					maxlength: 100,
					// minlength: 2,
					email: true,
				},

				emp_joining_date: {
					required: true
				},

				emp_rpt_to: {
					required: true,
				},
				permission_id: {
					required: true,
				},
				department_id: {
					required: true,
				},
				/*  sub_dept_id: {
                required: true,
				 },   */
				emp_hst_edu_id: {
					// required: true,
				},

				emp_edu_other_details: {
					// required: true,
					// maxlength: 100,
					// minlength: 2,
				},
				emp_bank_account_name: {
					// required: true,
					// lettersonly:true,
					// maxlength: 100,
					// minlength: 2,
				},
				emp_bank_accno: {
					// required: true,
					maxlength: 20,
					minlength: 9,
					digits: true,
				},
				re_emp_bank_accno: {
					// required: true,
					maxlength: 20,
					minlength: 9,
					digits: true,
					equalTo: "#emp_bank_accno",
				},
				emp_bank_name: {
					// required: true,
					// maxlength: 100,
					// minlength: 2,
				},
				emp_bank_ifsc_code: {
					// required: true,
					ifsc: true,
					maxlength: 11,
					minlength: 11,
					remote: {
						url: base_url + "admin/checkIFSCExists",
						type: "post"
					},
				},
				emp_bank_branch_addrs: {
					// required: true,
					maxlength: 250,
					minlength: 2,
				},
				emp_address: {
					// required: true,
					maxlength: 300,
					minlength: 2,
				},
				emp_landmark: {
					maxlength: 50,
					minlength: 2,
				},

				// emp_cityid:{
				// 	required: true},

				// emp_perm_distid:{
				// 	required: true},

				// emp_distid:{
				// 	required: true},

				emp_areaname: {
					maxlength: 50,
					minlength: 2,
				},
				emp_stateid: {
					required: true,
				},
				emp_pincode: {
					//required: true,
					// ifsc: true,
					digits: true,
					minlength: 6,
					maxlength: 6,
					remote: {
						url: base_url + "admin/checkPINExists",
						type: "post"
					},
				},
				emp_permaddress: {
					// required: true,
					maxlength: 300,
					minlength: 2,
				},
				emp_perm_landmark: {
					maxlength: 50,
					minlength: 2,
				},
				emp_perm_areaname: {
					maxlength: 50,
					minlength: 2,
				},
				//   emp_perm_stateid: {
				// 	    required: true,
				// 		 }, 
				emp_perm_pincode: {
					// required: true,
					digits: true,
					maxlength: 6,
					minlength: 6,
				},
				//   emp_kyc_type1: {
				// 	    required: true,

				// 		 },  
				emp_kyc_idnum1: {
					// required: true,
					maxlength: 50,

				},
				emp_kyc_photo1: {
					<?php if ($action !== "Edit") { ?>
						//   required: true,
					<?php } ?>
					accept: "image/jpeg,image/png,image/jpg",
					//dimention:[250, 350], 
					filesize_max: 1000000, // 1 MB
				},
				emp_addrs_prf_type: {
					// required: true,
					notEqualTo: "#emp_kyc_type1",
				},
				emp_addrs_prf_no: {
					// required: true,
					maxlength: 50,
				},
				emp_addrs_prf_img: {
					<?php if ($action !== "Edit") { ?>
						//   required: true,
					<?php } ?>
					accept: "image/jpeg,image/png,image/jpg",
					//dimention:[250, 350], 
					filesize_max: 1000000, // 1 MB
				},
				emp_image: {
					<?php if ($action !== "Edit") { ?>
						//   required: true,
					<?php } ?>
					accept: "image/jpeg,image/png,image/jpg",
					//dimention:[250, 350], 
					filesize_max: 1000000, // 1 MB
				},

			},
			messages: {
				emp_bank_ifsc_code: {
					remote: 'Invalid IFSC Code'
				},

				emp_bank_accno: {
					digits: "Only numbers allowed.",
					maxlength: "Account Number cannot exceed 20 digits.",
					minlength: "Account Number must be minimum 9 digits."
				},

				re_emp_bank_accno: {
					digits: "Only numbers allowed.",
					maxlength: "Account Number cannot exceed 20 digits.",
					minlength: "Please enter at least 9 digits.",
					equalTo: "Enter Same Account No."
				},
				emp_addrs_prf_type: {
					notEqualTo: 'Select Different Addres Proof'
				},
				emp_joining_date: {
					required: "Please select joining date"
				},


				// 	emp_pincode: {
				// 	remote: 'Invalid PINCODE Code'
				// },
				emp_pincode: {
					digits: "Only numbers allowed.",
					minlength: "Pincode must be exactly 6 digits.",
					maxlength: "Pincode must be exactly 6 digits."
				},

				emp_perm_pincode: {
					digits: "Only numbers allowed.",
					minlength: "Pincode must be exactly 6 digits.",
					maxlength: "Pincode must be exactly 6 digits."
				},
				emp_emailid: {
					email: "Please enter valid Email Id.",
					maxlength: "Email Id cannot exceed 100 characters."
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
				} else { // This is the default behavior of the script for all fields
					error.insertAfter(element);
				}
			},
		});

		$('#emp_kyc_photo1').change(function() {
			$('#emp_kyc_photo1').removeData('imageWidth');
			$('#emp_kyc_photo1').removeData('imageHeight');
			var file = this.files[0];
			var tmpImg = new Image();
			tmpImg.src = window.URL.createObjectURL(file);
			tmpImg.onload = function() {
				width = tmpImg.naturalWidth,
					height = tmpImg.naturalHeight;
				$('#emp_kyc_photo1').data('imageWidth', width);
				$('#emp_kyc_photo1').data('imageHeight', height);
			}
		});
		$('#emp_image').change(function() {
			$('#emp_image').removeData('imageWidth');
			$('#emp_image').removeData('imageHeight');
			var file = this.files[0];
			var tmpImg = new Image();
			tmpImg.src = window.URL.createObjectURL(file);
			tmpImg.onload = function() {
				width = tmpImg.naturalWidth,
					height = tmpImg.naturalHeight;
				$('#emp_image').data('imageWidth', width);
				$('#emp_image').data('imageHeight', height);
			}
		});


		$('#emp_addrs_prf_img').change(function() {
			$('#emp_addrs_prf_img').removeData('imageWidth');
			$('#emp_addrs_prf_img').removeData('imageHeight');
			var file = this.files[0];
			var tmpImg = new Image();
			tmpImg.src = window.URL.createObjectURL(file);
			tmpImg.onload = function() {
				width = tmpImg.naturalWidth,
					height = tmpImg.naturalHeight;
				$('#emp_addrs_prf_img').data('imageWidth', width);
				$('#emp_addrs_prf_img').data('imageHeight', height);
			}
		});

		$('#emp_bank_ifsc_code').change(function() {
			var emp_bank_ifsc_code = $("#emp_bank_ifsc_code").val();
			getIFSC(emp_bank_ifsc_code);
		});

		//pin code
		$('#emp_pincode').change(function() {
			var emp_pincode = $("#emp_pincode").val();
			getPIN(emp_pincode);
		});

		//pin code
		$('#emp_perm_pincode').change(function() {
			var emp_perm_pincode = $("#emp_perm_pincode").val();
			getPIN2(emp_perm_pincode);
		});

		$('input[name="per_addr_same"]').on('ifChanged', function(event) {
			if ($(this).is(':checked')) {
				var emp_address = $('#emp_address').val();
				var emp_landmark = $('#emp_landmark').val();
				var emp_areaname = $('#emp_areaname').val();
				var emp_state = $('#emp_state').val();
				var emp_dist = $('#emp_dist').val();
				var emp_city = $('#emp_city').val();
				var emp_pincode = $('#emp_pincode').val();

				// Set the address details
				$('#emp_permaddress').val(emp_address);
				$('#emp_perm_landmark').val(emp_landmark);
				$('#emp_perm_areaname').val(emp_areaname);
				$('#emp_perm_state').val(emp_state);

				// Trigger change event for state to load districts
				$('#emp_perm_state').trigger("change");

				// Set the district after a delay
				setTimeout(function() {
					$('#emp_perm_dist').val(emp_dist).trigger("change");
				}, 700);

				// Set the city after ensuring the options are populated
				setTimeout(function() {
					if ($("#emp_perm_city option[value='" + emp_city + "']").length > 0) {
						$('#emp_perm_city').val(emp_city);
					} else {
						// If the city option is not available, try re-triggering or adding a custom option
						$('#emp_perm_city').append(new Option(emp_city, emp_city, true, true));
					}
				}, 1200);

				// Set the pincode
				$('#emp_perm_pincode').val(emp_pincode);
			}
		});


	});

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
					$("#emp_bank_branch_addrs").val(data.ADDRESS);
					$("#emp_bank_name").val(data.BANK);
				}
			});
		}
	}

	//PINCODE
	function getPIN(emp_pincode) {
		$('#pin_code').html("");
		if (emp_pincode) {
			$.ajax({
				url: base_url + "admin/getPIN",
				type: "POST",
				data: {
					'pin_code': emp_pincode
				},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data) {
					var data = JSON.parse(data);
					var cityDropdown = $("#emp_city");
					cityDropdown.empty(); // Clear existing options

					if (data.length > 0 && data[0].PostOffice.length > 0) {
						// Populate the dropdown
						data[0].PostOffice.forEach(function(postOffice) {
							var option = $('<option></option>')
								.attr('value', postOffice.Name) // or any unique identifier
								.text(postOffice.Name); // or any display name
							cityDropdown.append(option);
						});

						// Optional: Set a default value
						// cityDropdown.val('DefaultCityName'); // Set default city if needed

						// Also set other fields if needed
						$("#emp_pincode").val(data[0].PostOffice[0].Pincode);
						$("#emp_state").val(data[0].PostOffice[0].State);
						$("#emp_dist").val(data[0].PostOffice[0].District);
					}
				},
				error: function(xhr, status, error) {
					console.error('Error fetching pin code data:', status, error);
				}
			});
		}
	}

	function getPIN2(emp_perm_pincode) {
		$('#pin_code').html("");
		if (emp_perm_pincode) {
			$.ajax({
				url: base_url + "admin/getPIN",
				type: "POST",
				data: {
					'pin_code': emp_perm_pincode
				},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data) {
					var data = JSON.parse(data);
					var cityDropdown = $("#emp_perm_city");
					cityDropdown.empty(); // Clear existing options

					if (data.length > 0 && data[0].PostOffice.length > 0) {
						// Populate the dropdown
						data[0].PostOffice.forEach(function(postOffice) {
							var option = $('<option></option>')
								.attr('value', postOffice.Name) // or any unique identifier
								.text(postOffice.Name); // or any display name
							cityDropdown.append(option);
						});

						// Optional: Set a default value
						// cityDropdown.val('DefaultCityName'); // Set default city if needed

						// Also set other fields if needed
						$("#emp_perm_pincode").val(data[0].PostOffice[0].Pincode);
						$("#emp_perm_state").val(data[0].PostOffice[0].State);
						$("#emp_perm_dist").val(data[0].PostOffice[0].District);
					}
				},
				error: function(xhr, status, error) {
					console.error('Error fetching pin code data:', status, error);
				}
			});
		}
	}
</script>
