<style>
	.form-group {
		margin-bottom: 18px;
	}

	.form-body .col-md-4,
	.form-body .col-md-3,
	.form-body .col-md-6 {
		margin-bottom: 10px;
	}

	.panel {
		border-radius: 5px;
		border: 1px solid #e6e9ec;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
	}

	.panel-heading {
		background: #f8f9fb;
		border-radius: 4px;
		padding: 12px 15px;
		font-weight: 600;
	}

	.panel-heading:hover {
		background: #eef1f5;
	}

	.panel-title {
		font-size: 15px;
		font-weight: 600;
	}

	.panel-body {
		padding: 20px 15px;
	}

	.panel-collapse {
		transition: all .3s ease;
	}

	/* Anjali spacing change 30-05-2025 */
	.lead-form-breadcrumb {
		margin-bottom: 4px;
		padding-bottom: 4px;
	}

	.mt-repeater {
		background: #fafafa;
		padding: 15px;
		border-radius: 4px;
		border: 1px dashed #dcdcdc;
	}

	.mt-repeater .row {
		margin-bottom: 10px;
	}

	.mt-repeater-add {
		margin-left: 10px;
	}

	.alt-contact-repeater {
		padding-bottom: 5px;
	}

	.alt-contact-repeater .row,
	.form-body .alt-contact-repeater .col-md-3 {
		margin-bottom: 0;
	}

	.alt-contact-repeater .mt-repeater-add {
		display: none;
	}

	.alt-contact-action {
		padding-top: 23px;
	}

	.form-control {
		height: 36px;
		border-radius: 4px;
		box-shadow: none;
		border: 1px solid #d1d5db;
	}

	.form-control:focus {
		border-color: #36c6d3;
		box-shadow: 0 0 3px rgba(54, 198, 211, .2);
	}

.convert-customer-field{
    margin-left:15px;
}

.convert-customer-field .bootstrap-select,
.convert-customer-field .bootstrap-select .dropdown-toggle{
    width:100% !important;
}

.reference-by-group{
    display:flex;
}

.reference-by-group .form-control{
    flex:1 1 auto;
    width:100%;
}

.reference-by-group .input-group-btn{
    display:block;
    padding-left:8px;
    width:auto;
}

/* Customer Card UI */

.customer-top-card{
    /* background:#fff; */
    /* border-radius:16px; */
    padding:17px;
    /* margin:15px 0 25px; */
    /* border:1px solid #edf1f7; */
    /* box-shadow:0 4px 14px rgba(0,0,0,0.04); */
}

.customer-card-header{
    display:flex;
    align-items:center;
    margin-bottom:18px;
}

.customer-icon{
    width:40px;
    height:40px;
    border-radius:50%;
    background:#eef7ff;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-right:15px;
    font-size:15px;
    color:#36c6d3;
}

.customer-card-content h4{
    display:none;
}

.customer-card-content p{
    margin:0;
    color:#14171a;
    font-size:14px;
}

.customer-select-box .bootstrap-select,
.customer-select-box .bootstrap-select .dropdown-toggle{
    width:100% !important;
}

.customer-select-box .dropdown-toggle{
    height:38px !important;
    min-height:38px !important;
    border-radius:10px;
    background:#fff;
    font-size:13px;
	border:1px solid #b9e7ef !important;
    box-shadow:none !important;

}
.customer-select-box .bootstrap-select.open .dropdown-toggle,
.customer-select-box .dropdown-toggle:focus,
.customer-select-box .dropdown-toggle:active{
    border:1px solid #36c6d3 !important;
    box-shadow:0 0 5px rgba(54,198,211,0.20) !important;
    outline:none !important;
}

.customer-help-box{
    margin-top:14px;
    background:#f3fbfd;
    border-left:4px solid #36c6d3;
    padding:12px 15px;
    border-radius:8px;
    color:#546371;
    font-size:13px;
}

.customer-help-box i{
    color:#36c6d3;
    margin-right:6px;
}

.customer-toggle{
    cursor:pointer;
    display:flex;
    align-items:center;
}

.customer-arrow{
    margin-left:auto;
    color:#36c6d3;
    font-size:14px;
    transition:0.3s;
}

.customer-arrow.rotate{
    transform:rotate(180deg);
}

.customer-collapse{
    display:none;
    margin-top:15px;
}
/* last change */

.lead-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    width:100%;
}

.customer-link{
    font-size:14px;
    color:#666;
    text-align:right;
}

@media (max-width:768px){
    .lead-header{
        flex-direction:column;
        align-items:flex-start;
    }

    .customer-link{
        margin-top:8px;
        text-align:left;
    }
}
</style>
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
					<ul class="page-breadcrumb breadcrumb lead-form-breadcrumb">
						<li><a href="<?php echo base_url(get_module() . "/dashboard") ?>">Home</a><i class="fa fa-circle"></i></li>
						<li><a href="<?php echo base_url(get_module() . "/leads/lead_report") ?>">All Leads </a><i class="fa fa-circle"></i></li>
						<li><span class="active"><?php echo $page_title; ?></span></li>
					</ul>

					<!-- div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint <?php echo $icon; ?> "></i>
                  <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div -->
					<div class="row">

						<div class="portlet-body form">
							<?php
							$clm_ots_id     = "";
							$clm_amcid      = "";
							$clm_productid  = "";
							if ($action == "Edit") {  //echo "<pre/>"; print_r($details);die; 
								$details = html_escape($details);
								$lead_productid = "";
								$clm_ots_id     = isset($details['clm_ots_id']) ? $details['clm_ots_id'] : "";
								$clm_amcid      = isset($details['clm_amcid']) ? $details['clm_amcid'] : "";
								$clm_productid  = isset($details['clm_productid']) ? $details['clm_productid'] : "";
								if (!empty($clm_ots_id)) {
									$lead_productid =  $clm_ots_id;
								}
								if (!empty($clm_amcid)) {
									$lead_productid =  $clm_amcid;
								}
								if (!empty($clm_productid)) {
									$lead_productid =  $clm_productid;
								}

								$formaction = "edit_lead/?id=" . base64_encode($id);
							} else {
								$formaction = "add_lead";
							} ?>
							<form action="<?php echo get_module_path() . 'leads/' . $formaction; ?>" id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data">
								<div class="form-body">

									<div class="col-md-12">
										<div class="portlet-body">
											<div class="portlet-title">
											<!-- <div class="caption" style="padding-bottom:20px;">
														<i class="font-red-mint icon-user"></i>
														<span class="caption-subject font-red-mint sbold">Lead Details</span>

														<span style="margin-left:580px;font-size:14px;color:#666;">
															If your lead is an existing customer,
															<a href="javascript:void(0);" id="openCustomerSection">click here</a>
														</span>
													</div> -->

												<div class="caption lead-header" style="padding-bottom:20px;">
												<div>
													<i class="font-red-mint icon-user"></i>
													<span class="caption-subject font-red-mint sbold">Lead Details</span>
												</div>
<!-- 
												<div class="customer-link">
													If your lead is an existing customer,
													<a href="javascript:void(0);" id="openCustomerSection">click here</a>
												</div> -->
												<?php if($action == "Add"){ ?>
												<div class="customer-link">
													If your lead is an existing customer,
													<a href="javascript:void(0);" id="openCustomerSection">click here</a>
												</div>
												<?php } ?>
											</div>
												<hr style="margin:0 0 15px 0;" />
											</div>
											
											<?php if ($action == "Edit") { ?>
												<input type="hidden" name="id" value="<?php echo $id; ?>">
											<?php } ?>
											<input type="hidden" name="clm_ots_id" id="clm_ots_id" value="<?php echo $clm_ots_id; ?>">
											<input type="hidden" name="clm_amcid" id="clm_amcid" value="<?php echo $clm_amcid; ?>">
											<input type="hidden" name="clm_productid" id="clm_productid" value="<?php echo $clm_productid; ?>">

											<!-- Anjali Customer 10-06-2025 -->

										<div class="customer-collapse" id="customerCollapse">

										<div class="customer-select-box">
											<select class="form-control selectpicker"
												name="ref_id"
												id="ref_id"
												onchange="get_customers_details();"
												data-live-search="true"
												title="Select Customer">
											</select>
										</div>

										<div class="customer-help-box" style="margin-bottom:20px;">
											<i class="fa fa-info-circle"></i>
											Already a customer? Select customer and details will auto-fill automatically.
										</div>

									</div>
											<!-- Anjali End Customer 28-05-2025 -->

											<div class="col-md-4">
												<div class="form-group">
													<label for="lead_name">Lead Name</label><?php echo REQUIRED_STAR; ?>
													<input class="form-control" id="lead_name" name="lead_name" type="text" placeholder="Enter Lead Name" required maxlength="50" value="<?php echo isset($details['clm_name']) ? $details['clm_name'] : set_value("lead_name"); ?>" autofocus>
													<?php echo form_error('lead_name', '<span class="text-danger">', '</span>'); ?>
												</div>

												<div class="form-group">
													<label for="lead_desc">Enquiry Details</label>
													<input class="form-control" id="lead_desc" name="lead_desc" type="text" placeholder="Enter Enquiry Details" maxlength="500" value="<?php echo isset($details['clm_description']) ? $details['clm_description'] : set_value("lead_desc"); ?>">
													<?php echo form_error('lead_desc', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group">
													<label for="lead_priority">Priority Level </label>
													<select class="form-control" id="lead_priority" name="lead_priority">
														<option value=""> Select Priority Level</option>
														<?php if (!empty($priority_list)) {
															foreach ($priority_list as $priority) {
																$priorty =  isset($details['clm_priority_level']) ? $details['clm_priority_level'] : set_value("lead_priority");
																$selected  = $priority == $priorty ? "selected" : "";
														?>
																<option value="<?php echo $priority; ?>" <?php echo $selected; ?>><?php echo $priority; ?></option>
														<?php }
														} ?>
													</select>
													<?php echo form_error('lead_priority', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Mobile No</label>
													<input class="form-control" id="lead_contact" name="lead_contact"
														type="tel" placeholder="Enter Mobile No." maxlength="10"
														value="<?php echo isset($details['clm_contact']) ? $details['clm_contact'] : set_value("lead_contact"); ?>">
													<?php echo form_error('lead_contact', '<span class="text-danger">', '</span>'); ?>
													<!-- add by ritika -->
													<!-- <?php if ($this->session->flashdata('mobile_error')) { ?>
														<span class="text-danger">
															<?php echo $this->session->flashdata('mobile_error'); ?>
														</span>
													<?php } ?> -->

													<?php if (isset($mobile_error)) { ?>
    <span class="text-danger">
        <?php echo $mobile_error; ?>
    </span>
<?php } ?>
													<!--  -->
												</div>
												<div class="form-group">
													<label for="website">Website</label>
													<input class="form-control" id="website" name="website" type="text" placeholder="Enter Website" maxlength="100" value="<?php echo isset($details['clm_website']) ? $details['clm_website'] : set_value("website"); ?>">
													<?php echo form_error('website', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group">
													<label for="company_name">Company Name</label>
													<input class="form-control" id="company_name" name="company_name" type="text" placeholder="Enter Company Name" maxlength="100" value="<?php echo isset($details['clm_company_name']) ? $details['clm_company_name'] : set_value("company_name"); ?>">
													<?php echo form_error('company_name', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="lead_contact_person">Contact Person</label>
													<input class="form-control" id="lead_contact_person" name="lead_contact_person" type="text" pattern="[A-Za-z\s]+" placeholder="Enter Contact Person" maxlength="200" value="<?php echo isset($details['clm_contact_person']) ? $details['clm_contact_person'] : set_value("lead_contact_person"); ?>">
													<?php echo form_error('lead_contact_person', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group">
													<label for="lead_productid">Enquiry For </label>
													<select class="form-control" id="lead_productid" name="lead_productid" onchange="get_prod_details(this);">
														<option value=""> Select Enquiry For</option>
														<?php if (!empty($product_list)) { 	//echo "<pre/>";  print_r($product_list)	;					
															foreach ($product_list as $product) {
																$prod_id   = "";
																$prod_name = "";
																$prod_type = "";
																$pm_id    = isset($product['pm_id']) ? $product['pm_id'] : "";
																$pm_name  = isset($product['pm_name']) ? $product['pm_name'] : "";
																$ots_id   = isset($product['ots_id']) ? $product['ots_id'] : "";
																$ots_name = isset($product['ots_name']) ? $product['ots_name'] : "";
																$amc_id   = isset($product['amc_id']) ? $product['amc_id'] : "";
																$amc_name = isset($product['amc_name']) ? $product['amc_name'] : "";
																if (!empty($pm_id)) {
																	$prod_name = $pm_name;
																	$prod_id = $pm_id;
																	$prod_type = "PROD";
																}
																if (!empty($ots_id)) {
																	$prod_name = $ots_name;
																	$prod_id = $ots_id;
																	$prod_type = "OTS";
																}

																if (!empty($amc_id)) {
																	$prod_name = $amc_name;
																	$prod_id = $amc_id;
																	$prod_type = "AMC";
																}

																$lead_productid1 =  isset($lead_productid) ? $lead_productid : set_value("lead_productid");
																$selected  = $lead_productid1 == $prod_id ? "selected" : "";
														?>
																<option value="<?php echo $prod_id; ?>" <?php echo $selected; ?> data-type="<?php echo $prod_type; ?>"><?php echo $prod_name; ?></option>
														<?php }
														} ?>
													</select>
													<?php echo form_error('lead_productid', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group">
													<label for="lead_dob">Date of Birth</label>
													<input class="form-control datepicker" id="lead_dob" name="lead_dob" type="text" placeholder="Enter Date of Birth" maxlength="15" value="<?php echo isset($details['clm_dob']) ? date("d-m-Y", strtotime($details['clm_dob'])) : set_value("clm_dob"); ?>">
													<?php echo form_error('lead_dob', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-12">
												<div class="panel panel-default">
													<div class="panel-heading" data-toggle="collapse" data-target="#additional_details" style="cursor:pointer;">
														<div class="panel-title">
															<i class="fa fa-plus"></i>
															<span class="caption-subject font-red-mint sbold">Additional Details</span>
														</div>
													</div>
													<div id="additional_details" class="panel-collapse collapse">
														<div class="panel-body">
															<div class="form-group col-md-4">
																<label>Email</label>
																<!-- <input class="form-control" id="lead_contact_email" name="lead_contact_email" placeholder="Enter email"> -->
																<input class="form-control"
																id="lead_contact_email"
																name="lead_contact_email"
																placeholder="Enter email"
																value="<?php echo isset($details['clm_contact_emailid']) ? $details['clm_contact_emailid'] : set_value('lead_contact_email'); ?>">
															</div>
															<div class="form-group col-md-4">
																<label>Landline</label>
																<input class="form-control"
																id="lead_landline"
																name="lead_landline"
																placeholder="Enter landline"
																value="<?php echo isset($details['clm_landline']) ? $details['clm_landline'] : set_value('lead_landline'); ?>">
																															<!-- <input class="form-control" id="lead_landline" name="lead_landline" placeholder="Enter landline"> -->
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-12">
												<div class="panel panel-default">
													<div class="panel-heading" data-toggle="collapse" data-target="#address_section" style="cursor:pointer;">
														<div class="panel-title">
															<i class="fa fa-plus"></i>
															<span class="caption-subject font-red-mint sbold">Address Details</span>
														</div>
													</div>

													<div id="address_section" class="panel-collapse collapse">
														<div class="panel-body">
															<div class="col-md-4">
																<div class="form-group">
																	<label for="lead_addrs">Address</label>
																	<input class="form-control" id="lead_addrs" name="lead_addrs" type="text" placeholder="Enter Address" maxlength="300" value="<?php echo isset($details['clm_address']) ? $details['clm_address'] : set_value("lead_addrs"); ?>">
																	<?php echo form_error('lead_addrs', '<span class="text-danger">', '</span>'); ?>
																</div>
																<div class="form-group">
																	<label for="lead_cityid">City </label>
																	<select class="form-control" id="lead_cityid" name="lead_cityid" onchange="get_city_area(this,'lead_stateid','lead_distid','lead_arealoc');">
																		<option value=""> Select City</option>
																		<?php if (!empty($city_list)) {
																			foreach ($city_list as $city) {
																				$city_id =  isset($details['clm_cityid']) ? $details['clm_cityid'] : set_value("lead_cityid");
																				$selected = $city_id == $city['city_id'] ? "selected" : "";

																		?>
																				<option value="<?php echo $city['city_id']; ?>" <?php echo $selected; ?>><?php echo $city['city_name']; ?></option>
																		<?php }
																		} ?>
																	</select>
																	<?php echo form_error('lead_cityid', '<span class="text-danger">', '</span>'); ?>
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label for="lead_stateid">State </label>
																	<select class="form-control" id="lead_stateid" name="lead_stateid" onchange="get_state_districts(this,'lead_distid');">
																		<?php
																		$state_id =  isset($details['clm_stateid']) ? $details['clm_stateid'] : set_value("lead_stateid");
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
																	<?php echo form_error('lead_stateid', '<span class="text-danger">', '</span>'); ?>
																</div>
																<div class="form-group">
																	<label for="lead_arealoc">Area</label>
																	<select class="form-control" id="lead_arealoc" name="lead_arealoc">
																		<option value=""> Select Area</option>
																		<?php if (!empty($area_list)) {
																			foreach ($area_list as $area) {
																				$area_id =  isset($details['clm_areaid']) ? $details['clm_areaid'] : set_value("lead_arealoc");
																				$selected = $area_id == $area['area_id'] ? "selected" : "";

																		?>
																				<option value="<?php echo $area['area_id']; ?>" <?php echo $selected; ?>><?php echo $area['area_name']; ?></option>
																		<?php }
																		} ?>
																	</select>
																	<?php echo form_error('lead_arealoc', '<span class="text-danger">', '</span>'); ?>
																</div>

															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label for="lead_distid">District </label>
																	<select class="form-control" id="lead_distid" name="lead_distid" onchange="get_district_cities(this,'lead_stateid','lead_cityid');">
																		<option value=""> Select District</option>
																		<?php if (!empty($dist_list)) {
																			foreach ($dist_list as $dist) {
																				$dist_id =  isset($details['clm_distid']) ? $details['clm_distid'] : set_value("lead_distid");
																				$selected = $dist_id == $dist['dist_id'] ? "selected" : "";

																		?>
																				<option value="<?php echo $dist['dist_id']; ?>" <?php echo $selected; ?>><?php echo $dist['dist_name']; ?></option>
																		<?php }
																		} ?>
																	</select>
																	<?php echo form_error('lead_distid', '<span class="text-danger">', '</span>'); ?>
																</div>

																<div class="form-group">
																	<label for="lead_pincode">Pincode</label>
																	<input class="form-control" id="lead_pincode" name="lead_pincode" type="text" placeholder="Enter Pincode" maxlength="6" value="<?php echo isset($details['clm_pincode']) ? $details['clm_pincode'] : set_value("lead_pincode"); ?>">
																	<?php echo form_error('lead_pincode', '<span class="text-danger">', '</span>'); ?>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<!-- Anjali Reference 28-05-2025 -->
											<div class="col-md-12">
												<div class="panel panel-default">
													<div class="panel-heading" data-toggle="collapse" data-target="#reference_section" style="cursor:pointer;">
														<h4 class="panel-title">
															<i class="fa fa-plus"></i>
															<span class="caption-subject font-red-mint sbold"> Reference</span>
														</h4>
													</div>

													<div id="reference_section" class="panel-collapse collapse">
														<div class="panel-body">
															<div class="form-group col-md-4">
																<label for="lead_refby">Reference By</label>
																<div class="input-group reference-by-group">
																	<select class="form-control" id="lead_refby" name="lead_refby" onchange="get_reference_details(this);">
																		<option value=""> Select Reference By </option>
																		<?php if (!empty($reference_list)) {
																			foreach ($reference_list as $key => $ref) {
																				$reference   = isset($details['clm_refby']) ? $details['clm_refby'] : "";
																				$selected    = $reference == $ref['ref_id'] ? "selected" : "";	?>
																				<option value="<?php echo $ref['ref_id']; ?>" <?php echo $selected; ?>><?php echo $ref['ref_name']; ?></option>
																		<?php }
																		} ?>
																	</select>
																	
																	<span class="input-group-btn">
																		<a href="javascript:;" class="btn btn-info" title="Add Reference" data-toggle="modal" data-target="#quick_reference_modal">
																			<i class="fa fa-plus"></i>
																		</a>
																	</span>
																</div>
															</div>
															<div class="form-group col-md-4">
																<label for="lead_refby_name">Reference Name</label>
																<input class="form-control" id="lead_refby_name" name="lead_refby_name" type="text" placeholder="Enter Reference Name" maxlength="200" value="<?php echo isset($details['clm_refby_name']) ? $details['clm_refby_name'] : set_value("lead_refby_name"); ?>">
																<?php echo form_error('lead_refby_name', '<span class="text-danger">', '</span>'); ?>
															</div>
															<div class="form-group col-md-4">
																<label for="lead_refby_contact">Reference Contact</label>
																<input class="form-control" id="lead_refby_contact" name="lead_refby_contact" type="text" placeholder="Enter Reference Contact" maxlength="10" value="<?php echo isset($details['clm_refby_contact']) ? $details['clm_refby_contact'] : set_value("lead_refby_contact"); ?>">
																<?php echo form_error('lead_refby_contact', '<span class="text-danger">', '</span>'); ?>
															</div>
															<div class="form-group col-md-4">
																<label for="lead_refby_email">Reference Email Id</label>
																<input class="form-control" id="lead_refby_email" name="lead_refby_email" type="text" placeholder="Enter Reference Email Id." maxlength="100" value="<?php echo isset($details['clm_refby_emailid']) ? $details['clm_refby_emailid'] : set_value("lead_refby_email"); ?>">
																<?php echo form_error('lead_refby_email', '<span class="text-danger">', '</span>'); ?>
															</div>
															<div class="form-group col-md-4">
																<label for="lead_refby_address">Reference Address</label>
																<input class="form-control" id="lead_refby_address" name="lead_refby_address" type="text" placeholder="Enter Reference Address" maxlength="300" value="<?php echo isset($details['clm_refby_address']) ? $details['clm_refby_address'] : set_value("lead_refby_address"); ?>">
																<?php echo form_error('lead_refby_address', '<span class="text-danger">', '</span>'); ?>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div id="quick_reference_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
															<h4 class="modal-title">Add Reference</h4>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="form-group col-md-6">
																	<label for="quick_ref_name">Reference Name</label><?php echo REQUIRED_STAR; ?>
																	<input type="text" id="quick_ref_name" class="form-control" placeholder="Enter Reference Name" maxlength="100">
																	<span class="text-danger quick-ref-error" id="quick_ref_name_error"></span>
																</div>
																<div class="form-group col-md-6">
																	<label for="quick_ref_contact_per">Contact Person</label><?php echo REQUIRED_STAR; ?>
																	<input type="text" id="quick_ref_contact_per" class="form-control" placeholder="Enter Contact Person" maxlength="100">
																	<span class="text-danger quick-ref-error" id="quick_ref_contact_per_error"></span>
																</div>
																<div class="form-group col-md-6">
																	<label for="quick_ref_mobile_no">Mobile No.</label>
																	<input type="text" id="quick_ref_mobile_no" class="form-control" placeholder="Enter Mobile No." maxlength="10">
																	<span class="text-danger quick-ref-error" id="quick_ref_mobile_no_error"></span>
																</div>
																<div class="form-group col-md-6">
																	<label for="quick_ref_email">Email Id</label>
																	<input type="email" id="quick_ref_email" class="form-control" placeholder="Enter Email Id" maxlength="100">
																	<span class="text-danger quick-ref-error" id="quick_ref_email_error"></span>
																</div>
																<div class="form-group col-md-12">
																	<label for="quick_ref_addr">Address</label>
																	<textarea id="quick_ref_addr" class="form-control" placeholder="Enter Address" maxlength="500"></textarea>
																</div>
																<div class="form-group col-md-12">
																	<label for="quick_ref_details">Details</label>
																	<textarea id="quick_ref_details" class="form-control" placeholder="Enter Details" maxlength="500"></textarea>
																</div>
																<div class="col-md-12">
																	<span class="text-danger quick-ref-error" id="quiajaorm_error"></span>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<button type="button" class="btn btn-info" id="quick_reference_save">Save</button>
														</div>
													</div>
												</div>
											</div>
											<!-- Anjali End Reference 28-05-2025 -->


											<!-- Anjali Alternate Contact 28-05-2025 -->
											<div class="col-md-12">
												<div class="panel panel-default">
													<div class="panel-heading" data-toggle="collapse" data-target="#alt_contact_section" style="cursor:pointer;">
														<h4 class="panel-title">
															<i class="fa fa-plus"></i>
															<span class="caption-subject font-red-mint sbold"> Alternate Contacts</span>
														</h4>
													</div>
													<div id="alt_contact_section" class="panel-collapse collapse">
														<div class="panel-body">

															<div class="col-md-12">
																<?php if ($action == "Add" || ($action == "Edit" && (!isset($details['contactList']) || empty($details['contactList'])))) { ?>
																	<div class="mt-repeater alt-contact-repeater">
																		<div data-repeater-list="group-b">
																			<div data-repeater-item="" class="row">
																				<div class="col-md-3">
																					<label class="control-label">Contact Person</label>
																					<input type="text" name="lead_altcontactperson" placeholder="Contact Person" class="form-control lead_altcontactperson" maxlength="100">
																				</div>
																				<div class="col-md-3">
																					<label class="control-label">Contact No.</label>
																					<input type="text" name="lead_altcontact" placeholder="Contact No." maxlength="10" class="form-control lead_altcontact">
																				</div>
																				<div class="col-md-3">
																					<label class="control-label">Email Id.</label>
																					<input type="text" name="lead_altemail" placeholder="Email Id." maxlength="100" class="form-control lead_altemail">
																				</div>
																				<div class="col-md-3 alt-contact-action">
																					<a href="javascript:;" class="btn btn-info js-alt-contact-add" title="Add another contact number">
																						<i class="fa fa-plus"></i>
																					</a>
																				</div>
																			</div>
																		</div>
																		<a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add pull-right"><i class="fa fa-plus"></i></a>
																		<span class="text-danger" id="err_msg"></span>

																	</div>

																<?php } ?>
																<?php
																$alternateContactList = array();
																if ($action == "Edit" && isset($details['contactList']) && !empty($details['contactList'])) {
																	foreach ($details['contactList'] as $cont) {
																		$contactName = isset($cont['lead_cntct_name']) ? trim($cont['lead_cntct_name']) : "";
																		$contactNo = isset($cont['lead_cntct_mob']) ? trim($cont['lead_cntct_mob']) : "";
																		$contactEmail = isset($cont['lead_cntct_email']) ? trim($cont['lead_cntct_email']) : "";

																		if ($contactName == "" && $contactNo == "" && $contactEmail == "") {
																			continue;
																		}

																		$alternateContactList[] = $cont;
																	}
																}
																?>
																<?php if ($action == "Edit" && !empty($alternateContactList)) { ?>
																	<div class="mt-repeater alt-contact-repeater">
																		<div data-repeater-list="group-b">
																			<?php
																			foreach ($alternateContactList as $key => $cont) {
																			?>
																				<div data-repeater-item="" class="row">
																					<div class="col-md-3">
																						<label class="control-label">Contact Person</label>
																						<input type="text" name="group-b[<?php echo $key; ?>][lead_altcontactperson]" placeholder="Contact Person" class="form-control lead_altcontactperson" maxlength="100" value="<?php echo $cont['lead_cntct_name']; ?>">
																					</div>
																					<div class="col-md-3">
																						<label class="control-label">Contact No.</label>
																						<input type="text" name="group-b[<?php echo $key; ?>][lead_altcontact]" placeholder="Contact No." maxlength="10" class="form-control lead_altcontact" value="<?php echo $cont['lead_cntct_mob']; ?>">
																					</div>
																					<div class="col-md-3">
																						<label class="control-label">Email Id.</label>
																						<input type="text" name="group-b[<?php echo $key; ?>][lead_altemail]" placeholder="Email Id." maxlength="100" class="form-control lead_altemail" value="<?php echo $cont['lead_cntct_email']; ?>">
																					</div>
																					<div class="col-md-3 alt-contact-action">
																						<a href="javascript:;" class="btn btn-danger js-alt-contact-delete" title="Remove contact number">
																							<i class="fa fa-close"></i>
																						</a>
																					</div>
																				</div>
																			<?php } ?>
																			<div data-repeater-item="" class="row">
																				<div class="col-md-3">
																					<label class="control-label">Contact Person</label>
																					<input type="text" name="group-b[<?php echo count($alternateContactList); ?>][lead_altcontactperson]" placeholder="Contact Person" class="form-control lead_altcontactperson" maxlength="100">
																				</div>
																				<div class="col-md-3">
																					<label class="control-label">Contact No.</label>
																					<input type="text" name="group-b[<?php echo count($alternateContactList); ?>][lead_altcontact]" placeholder="Contact No." maxlength="10" class="form-control lead_altcontact">
																				</div>
																				<div class="col-md-3">
																					<label class="control-label">Email Id.</label>
																					<input type="text" name="group-b[<?php echo count($alternateContactList); ?>][lead_altemail]" placeholder="Email Id." maxlength="100" class="form-control lead_altemail">
																				</div>
																				<div class="col-md-3 alt-contact-action">
																					<a href="javascript:;" class="btn btn-info js-alt-contact-add" title="Add another contact number">
																						<i class="fa fa-plus"></i>
																					</a>
																				</div>
																			</div>
																		</div>
																		<a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add pull-right"><i class="fa fa-plus"></i></a>
																		<span class="text-danger" id="err_msg"></span>
																	</div>

																<?php } ?>
																<?php if ($action == "Edit" && isset($details['contactList']) && !empty($details['contactList']) && empty($alternateContactList)) { ?>
																	<div class="mt-repeater alt-contact-repeater">
																		<div data-repeater-list="group-b">
																			<div data-repeater-item="" class="row">
																				<div class="col-md-3">
																					<label class="control-label">Contact Person</label>
																					<input type="text" name="group-b[0][lead_altcontactperson]" placeholder="Contact Person" class="form-control lead_altcontactperson" maxlength="100">
																				</div>
																				<div class="col-md-3">
																					<label class="control-label">Contact No.</label>
																					<input type="text" name="group-b[0][lead_altcontact]" placeholder="Contact No." maxlength="10" class="form-control lead_altcontact">
																				</div>
																				<div class="col-md-3">
																					<label class="control-label">Email Id.</label>
																					<input type="text" name="group-b[0][lead_altemail]" placeholder="Email Id." maxlength="100" class="form-control lead_altemail">
																				</div>
																				<div class="col-md-3 alt-contact-action">
																					<a href="javascript:;" class="btn btn-info js-alt-contact-add" title="Add another contact number">
																						<i class="fa fa-plus"></i>
																					</a>
																				</div>
																			</div>
																		</div>
																		<a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add pull-right"><i class="fa fa-plus"></i></a>
																		<span class="text-danger" id="err_msg"></span>
																	</div>
																<?php } ?>

															</div>
														</div>
													</div>
												</div>
											</div>
											<!-- Anjali End Alternate Contact 28-05-2025 -->

											<div class="form-group col-lg-6 col-md-2">
												<label for="clm_img">Upload Business card </label><br />
												<div class="input-icon">
													<input type="file" name="clm_img" id="clm_img"
														class="smart-file" data-label="Upload Business card"
														data-btn-class="btn btn red-pink btn-sm" data-preview="on"
														data-file-types="image/jpeg,image/png,image/jpg"
														accept="image/*" />
												</div>
												<?php echo form_error('clm_img', '<span class="text-danger">', '</span>'); ?>
												<span class="file_err text-danger "></span>
												<?php
												$clm_url = isset($details['clm_img']) ? $details['clm_img'] : '';
												$filename = !empty($clm_url) ? basename(parse_url($clm_url, PHP_URL_PATH)) : '';

												if (!empty($filename) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $filename)) {
												?>
													<div id="existingLogoPreview" style="margin-bottom:10px;">
														<img src="<?php echo $clm_url; ?>"
															alt="Upload Business card"
															style="max-height:120px; border:1px solid #ddd; padding:5px;">
													</div>
												<?php } ?>
											</div>

											<div class="form-actions">
												<div class="col-md-12">
													<center>
														<button type="submit" class="btn btn-success" id="add_edit_form_btn">
															Submit
														</button>														
														<a href="<?php echo get_module_path(); ?>leads/lead_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

<script type="text/javascript">
	// Add Branch

	$(document).ready(function() {
		// $('#openCustomerSection').click(function () {
		// 	$('#customerCollapse').slideDown();
		// 	$('.customer-arrow').addClass('rotate');
		// });
		$('#openCustomerSection').click(function () {
    	$('#customerCollapse').slideToggle(250);
		});

		$('#customerToggle').click(function () {

			$('#customerCollapse').slideToggle(250);

			$('.customer-arrow i').toggleClass('rotate');

		});
		if ($('.selectpicker').length > 0) {
			$('.selectpicker').selectpicker();
		}
		get_customers();

		var state = $('#lead_stateid').val();

		if (state) {
			get_state_districts(document.getElementById('lead_stateid'), 'lead_distid');

			// Optional (if edit case)
			setTimeout(function() {
				var dist = $('#cust_distid').val();
				if (dist) {
					get_district_cities(document.getElementById('lead_distid'), 'lead_stateid', 'lead_cityid');
				}
			}, 500);
		}

		$('.datepicker').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,
			endDate: "today"
		});

		$('.smart-file').bootstrapFileField({
			maxNumFiles: 8,
			fileTypes: 'image/jpeg,image/png,image/jpg',
			/* 	minNumFiles:1, */
			maxFileSize: 4000000 // 8Mb in bytes */
		});

		$('.panel-heading').click(function() {
			$(this).find('i').toggleClass('fa-plus fa-minus');
		});
		function resetQuickReferenceForm() {
			$('#quick_reference_modal').find('input, textarea').val('');
			$('#quick_reference_modal').find('.quick-ref-error').html('');
			$('#quick_reference_save').prop('disabled', false).html('Save');
		}
		$('#quick_reference_modal').on('hidden.bs.modal', function() {
			resetQuickReferenceForm();
		});

		$('#quick_reference_save').on('click', function() {
			var $button = $(this);
			var refName = $.trim($('#quick_ref_name').val());
			var refContactPer = $.trim($('#quick_ref_contact_per').val());
			var refMobile = $.trim($('#quick_ref_mobile_no').val());
			var refEmail = $.trim($('#quick_ref_email').val());

			$('#quick_reference_modal').find('.quick-ref-error').html('');

			if (refName == '') {
				$('#quick_ref_name_error').html('Please enter reference name');
				$('#quick_ref_name').focus();
				return;
			}
			
			if (refContactPer == '') {
				$('#quick_ref_contact_per_error').html('Please enter contact person');
				$('#quick_ref_contact_per').focus();
				return;
			}

			if (refMobile != '' && refMobile.length != 10) {
				$('#quick_ref_mobile_no_error').html('Mobile no. should be 10 digits');
				$('#quick_ref_mobile_no').focus();
				return;
			}

			if (refEmail != '' && !IsEmail(refEmail)) {
				$('#quick_ref_email_error').html('Please enter valid email id');
				$('#quick_ref_email').focus();
				return;
			}

			$button.prop('disabled', true).html('Saving...');

			// Anjali quick reference AJAX fix start 30-05-2025
			$.ajax({
				url: base_url + "ajax/add_reference_inline",
				type: "POST",
				dataType: "json",
				data: {
					ref_name: refName,
					ref_contact_per: refContactPer,
					ref_mobile_no: refMobile,
					ref_email: refEmail,
					ref_addr: $.trim($('#quick_ref_addr').val()),
					ref_details: $.trim($('#quick_ref_details').val())
				},
				success: function(response) {
					if (response && response.status == 'success') {
						var $referenceBy = $('#lead_refby');

						$referenceBy.find('option:not(:first)').remove();

						$.each(response.reference_list, function(index, ref) {
							$referenceBy.append($('<option>', {
								value: ref.ref_id,
								text: ref.ref_name
							}));
						});

						$referenceBy.val(response.ref_id);
						$('#lead_refby_name').val(response.ref_person_name);
						$('#lead_refby_contact').val(response.ref_mobile);
						$('#lead_refby_email').val(response.ref_email);
						$('#lead_refby_address').val(response.ref_address);
						$('#quick_reference_modal').modal('hide');
					} else {
						$('#quick_ref_form_error').html(response && response.message ? response.message : 'Reference could not be added');
						$button.prop('disabled', false).html('Save');
					}
				},
				error: function() {
					$('#quick_ref_form_error').html('Reference could not be added');
					$button.prop('disabled', false).html('Save');
				}
			});
			// Anjali quick reference AJAX fix end 30-05-2025
		});

		function refreshAltContactNames($repeater) {
			$repeater.find('[data-repeater-item]').each(function(index) {
				var $row = $(this);

				$row.find('.lead_altcontactperson').attr('name', 'group-b[' + index + '][lead_altcontactperson]');
				$row.find('.lead_altcontact').attr('name', 'group-b[' + index + '][lead_altcontact]');
				$row.find('.lead_altemail').attr('name', 'group-b[' + index + '][lead_altemail]');
			});
		}

		function hasAltContactValue($row) {
			return $.trim($row.find('.lead_altcontactperson').val()) !== '' ||
				$.trim($row.find('.lead_altcontact').val()) !== '' ||
				$.trim($row.find('.lead_altemail').val()) !== '';
		}

		function clearAltContactErrors($scope) {
			$scope.find('.js-alt-contact-error').remove();
			$scope.find('.lead_altcontact, .lead_altemail').css('border', '');
		}

		function showAltContactError($input, message) {
			$input
				.css('border', '1px solid red')
				.after('<span class="help-inline text-danger js-alt-contact-error">' + message + '</span>');
		}

		function removeExtraBlankAltContactRows($repeater) {
			var blankRowFound = false;

			$repeater.find('[data-repeater-item]').each(function() {
				var $row = $(this);

				if (hasAltContactValue($row)) {
					return;
				}

				if (blankRowFound) {
					$row.remove();
					return;
				}

				blankRowFound = true;
				$row.find('.js-alt-contact-delete')
					.removeClass('btn-danger js-alt-contact-delete')
					.addClass('btn-info js-alt-contact-add')
					.attr('title', 'Add another contact number')
					.html('<i class="fa fa-plus"></i>');
			});

			refreshAltContactNames($repeater);
		}

		$('.alt-contact-repeater').each(function() {
			removeExtraBlankAltContactRows($(this));
		});

		$(document).on('click', '.js-alt-contact-add', function(e) {
			e.preventDefault();

			var $button = $(this);
			var $repeater = $button.closest('.mt-repeater');
			var $currentRow = $button.closest('[data-repeater-item]');
			var $newRow = $currentRow.clone();

			if (!hasAltContactValue($currentRow)) {
				$currentRow.find('.lead_altcontactperson').focus();
				return;
			}

			$newRow.find('input').val('').css('border', '');
			$newRow.find('.help-inline, .text-danger')
				.not('#err_msg')
				.remove();

			$currentRow.after($newRow);

			$button
				.removeClass('btn-info js-alt-contact-add')
				.addClass('btn-danger js-alt-contact-delete')
				.attr('title', 'Remove contact number')
				.html('<i class="fa fa-close"></i>');

			refreshAltContactNames($repeater);
		});

		$(document).on('click', '.js-alt-contact-delete', function(e) {
			e.preventDefault();

			var $repeater = $(this).closest('.mt-repeater');

			$(this).closest('[data-repeater-item]').remove();
			refreshAltContactNames($repeater);
		});

		$("#add_edit_form").validate({
			rules: {
				required: {
					required: true
				},
				lead_name: {
					required: true,
					maxlength: 50,
					minlength: 2,
				},

				lead_desc: {
					maxlength: 500,
					minlength: 2,
				},
				lead_contact_person: {
					maxlength: 200,
					minlength: 2,
				},
				website: {
					maxlength: 100,
					minlength: 2,
				},
				pan_no: {
					maxlength: 10,
					minlength: 2,
					pan: true,
				},
				company_name: {
					maxlength: 100,
					minlength: 2,
				},
				lead_contact: {

					maxlength: 10,
					minlength: 10,
					digits: true,
				},
				lead_refby_contact: {
					maxlength: 10,
					minlength: 10,
					digits: true,
				},
				lead_contact_email: {

					maxlength: 100,
					email: true,
				},
				lead_refby_email: {
					maxlength: 100,
					email: true,
				},
				lead_landline: {
					maxlength: 15,
					digits: true,
				},
				/*  lead_productid: {
                required: true,
				 },  */

				lead_addrs: {

					maxlength: 300,
					minlength: 2,
				},

				lead_stateid: {

				},
				lead_distid: {},
				lead_cityid: {
				},
				
				lead_refby_address: {
					maxlength: 300,
					minlength: 2,
				},
				lead_pincode: {
					maxlength: 6,
					minlength: 6,
					digits: true,
				},
				lead_refby_name: {
					maxlength: 200,
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

				emp_permaddress: {
					maxlength: 300,
					minlength: 2,
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
		});

		$('#add_edit_form_btn').on('click', function(e) {
			if ($('#add_edit_form').valid()) {

				var group_count = 0;
				var has_alt_contact_error = false;
				$("#err_msg").html("");
				clearAltContactErrors($('.mt-repeater'));
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
								has_alt_contact_error = true;
								showAltContactError($(this), "Contact Number Should be 10 Digits");
							}
						}
					});

					$(".mt-repeater").find(".lead_altemail").each(function(j) {
						if ($(this).attr("name") == "group-b[" + i + "][lead_altemail]") {
							var lead_altemail = $(this).val();
							$(this).css("border", "");
							if (lead_altemail && !(IsEmail(lead_altemail))) {
								has_alt_contact_error = true;
								showAltContactError($(this), "Please Enter Valid Email Id");
							}
						}
					});

				}
				if (!has_alt_contact_error) {
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
					$("#lead_refby_address").val(data.ref_address);
					$("#lead_refby_email").val(data.ref_email);
					$("#lead_refby_name").val(data.ref_person_name);
					$("#lead_refby_contact").val(data.ref_mobile);
				}

			}
		});
	}

	function get_prod_details(obj) {
		var ref_id = $(obj).val();
		var type = $('option:selected', obj).attr('data-type');
		$("#clm_ots_id").val("");
		$("#clm_amcid").val("");
		$("#clm_productid").val("");

		if (type == "AMC") {
			$("#clm_amcid").val(ref_id);
		}
		if (type == "OTS") {
			$("#clm_ots_id").val(ref_id);
		}
		if (type == "PROD") {
			$("#clm_productid").val(ref_id);
		}

	}
	
	function get_customers() {
		$.ajax({
			url: base_url + "ajax/get_customers_for_leads",
			type: "POST",
			dataType: "json",
			async: true,
			cache: false,
			success: function(data) {
				// var data = JSON.parse(data);        //anjali ajax fix 30-05-2025
				$("#ref_id").html(data);
				if ($('.selectpicker').length > 0) {
					$('.selectpicker').selectpicker('refresh');
				}
			},
			error: function() {
				$("#ref_id").html("<option value=''>Unable to load customers</option>");
				if ($('.selectpicker').length > 0) {
					$('.selectpicker').selectpicker('refresh');
				}
			}
		});
	}
	
	function get_customers_details() {
		var ref_id = $("#ref_id").val();       // anjali ajax fix 30-05-2025
		if (!ref_id) {
			return;
		}
		$.ajax({
			url: base_url + "ajax/get_customers_details01",
			type: "POST",
			dataType: "json",
			data: {
				"ref_id": ref_id
			},
			async: true,
			cache: false,
			success: function(data) {
				if (data) {
					$('#lead_name').val(data.name);
					$('#lead_contact').val(data.contact);
					$('#lead_addrs').val(data.address);
					$('#lead_contact_email').val(data.emailid);
					$('#lead_contact_person').val(data.contact_person);
					$('#lead_stateid').val(data.state_id);
					$('#lead_distid').val(data.dist_id);
					$('#lead_pincode').val(data.pincode);
					if (data.dob) {
						let d = new Date(data.dob);
						let formatted = ("0" + d.getDate()).slice(-2) + "-" +
							("0" + (d.getMonth() + 1)).slice(-2) + "-" +
							d.getFullYear();
						$('#lead_dob').val(formatted);
					}
					$('#company_name').val(data.company_name);
					if (data.lead_id) {
						$('#lead_id').val(data.lead_id);
					}
				}

			}
		});
	}
</script>

