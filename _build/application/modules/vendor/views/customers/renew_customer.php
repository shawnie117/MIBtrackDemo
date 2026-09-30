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
							<?php if ($action == "Renew") {
								//  echo "<pre/>"; print_r($details);die; 
								$details   = html_escape($details);
								$subscriptionList  = isset($details['subscriptionList']) ? $details['subscriptionList'] : "";
								$cust_type =  isset($details['cust_type']) ? $details['cust_type'] : "";
								$cust_subs_type =  isset($subscriptionList[0]['cust_subs_type']) ? $subscriptionList[0]['cust_subs_type'] : "";
								$formaction = "renew_customer_service/?id=" . base64_encode($id);
							}

							if ($action == "Add") {
								//  echo "<pre/>"; print_r($details);die; 
								$details   = html_escape($details);
								$cust_type =  isset($details['cust_type']) ? $details['cust_type'] : "";
								$formaction = "add_customer_service/?id=" . base64_encode($id);
							}

							?>

							<form action="<?php echo get_module_path() . 'customers/' . $formaction; ?>" id="add_edit_form" method="post" autocomplete="off">
								<div class="form-body">

									<div class="col-md-12">

										<div class="portlet-body">
											<div class="portlet-title">
												<div class="caption">
													<i class="font-red-mint icon-user"></i>
													<span class="caption-subject font-red-mint sbold">Basic Details</span>
												</div>
												<hr style="margin:3px;" />
											</div>

											<input type="hidden" name="cust_id" value="<?php echo $id; ?>">
											<input type="hidden" name="cust_type" id="cust_type" value="<?php echo $cust_type; ?>">
											<?php if ($action == "Renew") {  ?>
												<div class="form-group col-md-3">
													<label for="cust_service_type">Service Type</label><?php echo REQUIRED_STAR; ?>
													<select class="form-control" id="cust_service_type" name="cust_service_type" required onchange="get_services(this);">
														<option value=""> Select Service Type</option>
														<?php if (!empty($service_list)) {
															foreach ($service_list as $key => $service) {
																$selected  = $service == $service_type ? "selected" : "";
														?>
																<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $service; ?></option>
														<?php }
														} ?>
													</select>
													<?php echo form_error('cust_service_type', '<span class="text-danger">', '</span>'); ?>
												</div>
											<?php } ?>

											<?php if ($action == "Add") {  ?>
												<div class="form-group col-md-3">
													<label for="cust_service_type">Service Type</label><?php echo REQUIRED_STAR; ?>
													<select class="form-control" id="cust_service_type" name="cust_service_type" required onchange="get_services(this);">
														<option value=""> Select Service Type</option>
														<?php if (!empty($service_list)) {
															foreach ($service_list as $key => $service) {
														?>
																<option value="<?php echo $key; ?>"><?php echo $service; ?></option>
														<?php }
														} ?>
													</select>
													<?php echo form_error('cust_service_type', '<span class="text-danger">', '</span>'); ?>
												</div>
											<?php } ?>

											<div class="form-group col-md-3">
												<label for="cust_gst_type">GST Option</label><?php echo REQUIRED_STAR; ?>
												<select class="form-control" id="cust_gst_type" name="cust_gst_type" required onchange="clear_service_details();">
													<?php if (!empty($gst_type_list)) {
														foreach ($gst_type_list as $key => $gtype) {
															$cust_gst_type =  isset($details['clm_priority_level']) ? $details['clm_priority_level'] : set_value("cust_gst_type");
															$selected  = $gtype == $cust_gst_type ? "selected" : "";
													?>
															<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $gtype; ?></option>
													<?php }
													} ?>
												</select>
												<?php echo form_error('cust_gst_type', '<span class="text-danger">', '</span>'); ?>
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
											<div class="form-group col-md-4">
												<label for="cust_name">Customer Name</label> <?php echo REQUIRED_STAR; ?>
												<input class="form-control" id="cust_name" name="cust_name" type="text" placeholder="Enter Customer Name" required maxlength="100" value="<?php echo isset($details['customer_name']) ? $details['customer_name'] : set_value("cust_name"); ?>" readonly>
												<?php echo form_error('cust_name', '<span class="text-danger">', '</span>'); ?>
											</div>
											<div class="form-group col-md-4">
												<label for="cust_contact_person">Contact Person</label>
												<input class="form-control" id="cust_contact_person" name="cust_contact_person" type="text" placeholder="Enter Contact Person" maxlength="100" value="<?php echo isset($details['customer_contact_person']) ? $details['customer_contact_person'] : set_value("cust_contact_person"); ?>" readonly>
												<?php echo form_error('cust_contact_person', '<span class="text-danger">', '</span>'); ?>
											</div>

											<div class="form-group col-md-4">
												<label for="cust_contact">Mobile No.</label>
												<input class="form-control" id="cust_contact" name="cust_contact" type="text" placeholder="Enter Mobile No." maxlength="10" value="<?php echo isset($details['customer_contact']) ? $details['customer_contact'] : set_value("cust_contact"); ?>" readonly>
												<?php echo form_error('cust_contact', '<span class="text-danger">', '</span>'); ?>
											</div>
											<div class="form-group col-md-4">
												<label for="cust_landline">Landline No.</label>
												<input class="form-control" id="cust_landline" name="cust_landline" type="text" placeholder="Enter Landline No." maxlength="15" value="<?php echo isset($details['cust_landline']) ? $details['cust_landline'] : set_value("cust_landline"); ?>" readonly>
												<?php echo form_error('cust_landline', '<span class="text-danger">', '</span>'); ?>
											</div>
											<div class="form-group col-md-4">
												<label for="cust_contact_email">Email Id</label>
												<input class="form-control" id="cust_contact_email" name="cust_contact_email" type="text" placeholder="Enter Email Id." maxlength="100" value="<?php echo isset($details['customer_contact_email']) ? $details['customer_contact_email'] : set_value("cust_contact_email"); ?>" readonly>
												<?php echo form_error('cust_contact_email', '<span class="text-danger">', '</span>'); ?>
											</div>
											<div class="form-group col-md-4">
												<label for="cust_website">Website</label>
												<input class="form-control" id="cust_website" name="cust_website" type="text" placeholder="Enter Website" maxlength="100" value="<?php echo isset($details['cust_website']) ? $details['cust_website'] : set_value("cust_website"); ?>" readonly>
												<?php echo form_error('cust_website', '<span class="text-danger">', '</span>'); ?>
											</div>

											<div class="form-group col-md-3" style="position: relative;">
												<label for="cust_ui_date">Customer Added Date</label>
												<input class="form-control datepicker" id="cust_ui_date" name="cust_ui_date" type="text" placeholder="Enter Customer Added Date" maxlength="15" value="<?php echo isset($details['cust_uidate_n']) ? $details['cust_uidate_n'] : set_value("cust_ui_date"); ?>">
												<span class="m-0" id="hover-info" style="display: none">(Use This Field When Adding Back dated Date.)</span>
												<?php echo form_error('cust_ui_date', '<span class="text-danger">', '</span>'); ?>
											</div>


										</div>


										<!-- Added by ANkit Tiwari on 16 / 01/2026 -->
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


											<?php if ($action == "Renew" || $action == "Add") { ?>
												<div class="form-group col-md-5">
													<div class="row d-flex align-items-end">
														<div class="form-group  col-md-8">
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



											<?php } ?>

										</div>
									</div>

									<!-- <div class="form-group col-md-12 shadow">
										<label for="cust_service_details_lbl" id="cust_service_details_lbl">Service Details</label>

										<div class="slimScrollDiv250" style="border:1px solid #cdcdcd;">
											<table class="table table-striped table-bordered table-advance table-hover">
												<thead id="services_tbl_header"> </thead>
												<tbody id="tbl_service_details">


												</tbody>
											</table>
										</div>
									</div> -->



									<div class="form-group col-md-3">
										<label for="cust_total_amount">Total Price</label>
										<input class="form-control" id="cust_total_amount" name="cust_total_amount" type="text" placeholder="Total Price" maxlength='8' value="0" readonly>
										<?php echo form_error('cust_total_amount', '<span class="text-danger">', '</span>'); ?>
									</div>
									<div class="form-group col-md-3">
										<label for="cust_paid_amount">Paid Amount</label>
										<input class="form-control" id="cust_paid_amount" name="cust_paid_amount" type="text" placeholder="Total Price" maxlength='8' value="0">
										<?php echo form_error('cust_paid_amount', '<span class="text-danger">', '</span>'); ?>
									</div>

									<!-- <div class="form-group col-md-3">
										<label for="cust_unit_no">Unit No</label>
										<input class="form-control" id="cust_unit_no" name="cust_unit_no" type="text" placeholder="Enter Reference Name" maxlength="50" value="<?php echo isset($details['cust_unit_no']) ? $details['cust_unit_no'] : set_value("cust_unit_no"); ?>">
										<?php echo form_error('cust_unit_no', '<span class="text-danger">', '</span>'); ?>
									</div>
									<div class="form-group col-md-3">
										<label for="cust_form_no">Form No</label>
										<input class="form-control" id="cust_form_no" name="cust_form_no" type="text" placeholder="Enter Reference Name" maxlength="50" value="<?php echo isset($details['cust_form_no']) ? $details['cust_form_no'] : set_value("cust_form_no"); ?>">
										<?php echo form_error('cust_form_no', '<span class="text-danger">', '</span>'); ?>
									</div> -->

								</div>


								<?php if ($page_title != "Add Customer Service") { ?>
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

											<div class="followuptbl" style="overflow: auto; -webkit-overflow-scrolling: touch;margin-bottom:10px;height: 160px; overflow-x:hidden;">
												<table class="table table-striped table-bordered display" role="grid" aria-describedby="sample_1_info">
													<tr style=" position: sticky; top: 0; z-index: 1; background-color: #fff;"
														class="success">
														<th width="100px">Sr. No.</th>
														<th>Name</th>
														<th>Start Date </th>
														<th>End Date</th>
														<th>Status</th>
														<th>Action</th>
													</tr>

													<tbody>
														<?php foreach ($subscriptionList as $key => $subserv) {
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
																		} else if ($subserv['cust_subs_status'] == "Deactivated") {
																			echo "<span class='label label-danger'>Deactivated</span>";
																		} else {
																			echo "<span class='label label-warning'>" . $subserv['cust_subs_status'] . "</span>";
																		}    ?> </td>
																<td> <input type="checkbox" name="selected_subscriptions[]" value="<?php echo $subserv['cust_subs_id']; ?>">
																</td>
															</tr>
														<?php } ?>


													</tbody>

												</table>
											</div>


										<?php } ?>
									<?php } ?>


									<div class="col-md-12">
										<i class="font-red-mint icon-wallet"></i>
										<span class="caption-subject font-red-mint sbold">Installments</span>
										<div class="form-group">
											<label>Do you want to pay in installments?</label>
											<div>
												<label><input type="radio" name="pay_in_installments" value="yes"> Yes</label>
												<label><input type="radio" name="pay_in_installments" value="no" checked> No</label>
											</div>
										</div>
									</div>

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
																	<label for="cust_pay_nxt_dt">Date</label>
																	<input class="form-control datepicker" id="cust_pay_nxt_dt" name="next_installment_date[]" type="text"
																		placeholder="Select Date" maxlength="100"
																		value="<?php echo isset($installment['cbpi_pay_next_date']) ? htmlspecialchars($installment['cbpi_pay_next_date']) : ''; ?>">
																	<?php echo form_error('next_installment_date[]', '<span class="text-danger">', '</span>'); ?>
																</div>
															</td>

															<td>
																<div class="form-group col-md-12">
																	<label for="cust_pay_nxt_amt">Amt.</label>
																	<input class="form-control" id="cust_pay_nxt_amt" name="next_installment_amount[]" type="text"
																		placeholder="Enter Amount" maxlength="100"
																		value="<?php echo isset($installment['cbpi_pay_next_amount']) ? htmlspecialchars($installment['cbpi_pay_next_amount']) : ''; ?>">
																	<span class="installment-error text-danger" style="display: none;"></span>
																	<?php echo form_error('next_installment_amount[]', '<span class="text-danger">', '</span>'); ?>
																</div>
															</td>
															<td>
																<div class="form-group col-md-12">
																	<label for="cust_pay_nxt_start_date">Start Date</label>
																	<input class="form-control datepicker" id="cust_pay_nxt_start_date" name="next_installment_start_date[]" type="text"
																		placeholder="Enter Start Date" maxlength="100"
																		value="<?php echo isset($installment['cbpi_pay_next_start_date']) ? htmlspecialchars($installment['cbpi_pay_next_start_date']) : ''; ?>">
																	<span class="installment-error text-danger" style="display: none;"></span>
																	<?php echo form_error('next_installment_start_date[]', '<span class="text-danger">', '</span>'); ?>
																</div>
															</td>
															<td>
																<div class="form-group col-md-12">
																	<label for="cust_pay_nxt_end_date">End Date</label>
																	<input class="form-control datepicker" id="cust_pay_nxt_end_date" name="next_installment_end_date[]" type="text"
																		placeholder="Enter End Date" maxlength="100"
																		value="<?php echo isset($installment['cbpi_pay_next_end_date']) ? htmlspecialchars($installment['cbpi_pay_next_end_date']) : ''; ?>">
																	<span class="installment-error text-danger" style="display: none;"></span>
																	<?php echo form_error('next_installment_end_date[]', '<span class="text-danger">', '</span>'); ?>
																</div>
															</td>
															<td>
																<button type="button" class="btn btn-success btn-xs" id="add_installment_row">
																	<i class="fa fa-plus"></i>
																</button>
															</td>
														</tr>
													<?php }
												}

												// If there are no unpaid installments, show an empty row for adding new installment
												if (empty($payment_installments) || !array_filter($payment_installments, fn($installment) => $installment['cbpi_status'] !== 'Paid')) { ?>
													<tr>
														<td>
															<div class="form-group col-md-12">
																<label for="cust_pay_nxt_dt">Date</label>
																<input class="form-control datepicker col-md-4" id="cust_pay_nxt_dt" name="next_installment_date[]" type="text" placeholder="Select Date" maxlength="100" value="<?php echo set_value('next_installment_date[]'); ?>">
																<?php echo form_error('next_installment_date[]', '<span class="text-danger">', '</span>'); ?>
															</div>
														</td>

														<td>
															<div class="form-group col-md-12">
																<label for="cust_pay_nxt_amt">Amt.</label>
																<input class="form-control col-md-4 installment-input" id="cust_pay_nxt_amt"
																	name="next_installment_amount[]" type="text"
																	placeholder="Enter Amount" maxlength="100"
																	value="<?php echo set_value('next_installment_amount[]'); ?>">
																<span class="installment-error text-danger" style="display: none;"></span>
																<?php echo form_error('next_installment_amount[]', '<span class="text-danger">', '</span>'); ?>
															</div>
														</td>

														<td>
															<div class="form-group col-md-12">
																<label for="cust_pay_nxt_start_date">Date</label>
																<input class="form-control datepicker col-md-4" id="cust_pay_nxt_start_date" name="next_installment_start_date[]" type="text" placeholder="Select Date" maxlength="100" value="<?php echo set_value('next_installment_start_date[]'); ?>">
																<?php echo form_error('next_installment_start_date[]', '<span class="text-danger">', '</span>'); ?>
															</div>
														</td>

														<td>
															<div class="form-group col-md-12">
																<label for="cust_pay_nxt_end_date">Date</label>
																<input class="form-control datepicker col-md-4" id="cust_pay_nxt_end_date" name="next_installment_end_date[]" type="text" placeholder="Select Date" maxlength="100" value="<?php echo set_value('next_installment_end_date[]'); ?>">
																<?php echo form_error('next_installment_end_date[]', '<span class="text-danger">', '</span>'); ?>
															</div>
														</td>

														<td>
															<button type="button" class="btn btn-success btn-xs" id="add_installment_row">
																<i class="fa fa-plus"></i>
															</button>
														</td>
													</tr>
												<?php } ?>

											</tbody>
										</table>
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
											const installmentSection = document.getElementById("installments_section");
											const radios = document.querySelectorAll("input[name='pay_in_installments']");

											radios.forEach(radio => {
												radio.addEventListener("change", function() {
													if (this.value === "yes") {
														installmentSection.style.display = "block";
													} else {
														installmentSection.style.display = "none";
													}
												});
											});
										});
									</script>

									<!--by kiran dhaije 7/1/25 -->
									<script>
										let installmentRowCounter = 1;

										// Add new installment row with auto-fill logic
										document.getElementById('add_installment_row').addEventListener('click', function() {
											const tableBody = document.getElementById('installments_table_body');

											// Get last row's end date
											let lastEndDate = '';
											const lastRow = tableBody.querySelector('tr:last-child');
											if (lastRow) {
												const lastEndDateInput = lastRow.querySelector('#cust_pay_nxt_end_date, [id^="cust_pay_nxt_end_date_"]');
												if (lastEndDateInput && lastEndDateInput.value) {
													lastEndDate = lastEndDateInput.value;
												}
											}

											const newRow = document.createElement('tr');
											newRow.innerHTML = `
        <td>
          <div class="form-group col-md-12">
            <input type="text" id="cust_pay_nxt_dt_${installmentRowCounter}" 
                   class="form-control datepicker" 
                   name="next_installment_date[]" 
                   maxlength="100"
                   value="${lastEndDate}"
                   placeholder="Select Date" />
          </div>
        </td>
        <td>
          <div class="form-group col-md-12">
            <input type="number" id="cust_pay_nxt_amt_${installmentRowCounter}" 
                   class="form-control installment-input" 
                   name="next_installment_amount[]" 
                   maxlength="100"
                   placeholder="Enter Amount" />
            <span class="installment-error text-danger" style="display: none;"></span>
          </div>
        </td>
        <td>
          <div class="form-group col-md-12">
            <input type="text" id="cust_pay_nxt_start_date_${installmentRowCounter}" 
                   class="form-control datepicker" 
                   name="next_installment_start_date[]" 
                   maxlength="100"
                   value="${lastEndDate}"
                   placeholder="Select Date" />
          </div>
        </td>
        <td>
          <div class="form-group col-md-12">
            <input type="text" id="cust_pay_nxt_end_date_${installmentRowCounter}" 
                   class="form-control datepicker" 
                   name="next_installment_end_date[]" 
                   maxlength="100"
                   placeholder="Select Date" />
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


											// Reapply datepicker to all new inputs
											$('.datepicker').datepicker({
												format: 'dd-M-yyyy',
												autoclose: true,
												todayHighlight: true
											});

											// Re-validate
											validateInstallments();
										});

										// Initialize datepicker for initial rows
										$('.datepicker').datepicker({
											format: 'dd-M-yyyy',
											autoclose: true,
											todayHighlight: true
										});

										// Re-validate when any amount changes
										document.querySelectorAll('.installment-input').forEach(function(input) {
											input.addEventListener('input', function() {
												validateInstallments();
											});
										});

										// Initial validation
										validateInstallments();
									</script>


									<div class="form-actions">
										<div class=" col-md-offset-5 col-md-5">
											<button class="btn btn-success" type="submit" id="add_edit_form_btn">Submit</button>
											<a onclick="window.history.back();" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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
<!-- END CONTENT -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- Form Validation Plugins -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

<script type="text/javascript">
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
	// Add Branch

	$(document).ready(function() {


		$('.smart-file').bootstrapFileField({
			maxNumFiles: 8,
			fileTypes: 'image/jpeg,image/png,image/jpg',
			/* 	minNumFiles:1, */
			maxFileSize: 4000000 // 8Mb in bytes */
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
				},
				cust_unit_no: {
					maxlength: 50,
				},
				cust_form_no: {
					maxlength: 50,
				},
				"service_id[]": {
					required: true,
				},
			},
			messages: {
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
					error.appendTo((element).parents('.form-group').find('.file_err'));
				} else if (element.is(":checkbox")) { // This is the default behavior of the script for all fields
					error.appendTo("#file_err");
				} else { // This is the default behavior of the script for all fields
					error.insertAfter(element);
				}

			},
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

	function get_services(obj) {

		$("#tbl_service_details").html("");
		var service_type = $(obj).val();
		var service_lbl, service_detal_lbl;
		if (service_type == "AMC") {
			service_lbl = "AMC Services";
			service_detal_lbl = "AMC Details";
			$("#services_tbl_header").html("<tr class='success'><th width='5%'>Sr.No.</th><th>AMC</th><th>Address</th><th>Service Date</th></tr>");

		}
		if (service_type == "One Time Service") {
			service_lbl = "One Time Services";
			service_detal_lbl = "One Time Service Details";
			$("#services_tbl_header").html("<tr class='success'><th width='5%'>Sr.No.</th><th>One Time Service</th><th>Address</th></tr>");
		}
		if (service_type == "Sales") {
			service_lbl = "Sales Products";
			service_detal_lbl = "Sales Product Details";
			$("#services_tbl_header").html("<tr class='success'><th width='5%'>Sr.No.</th><th>Sales Product</th><th>Address</th><th>Service Date</th></tr>");
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
<!-- Added by Ankit on 16/01/2026-->
<script src="jquery.min.js"></script>
<script>
	$(document).ready(function() {
		...
	});
</script>

<!-- 3. Your helper JS -->
<script>
	function filterAMCs() {
		const input = document.getElementById("amcSearch");
		if (!input) return;

		const filter = input.value.toLowerCase();
		const rows = document.querySelectorAll("#tbl_service_id tr");

		rows.forEach(row => {
			row.style.display = row.innerText.toLowerCase().includes(filter) ?
				"" :
				"none";
		});
	}
</script>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		const totalPriceInput = document.getElementById('cust_total_amount');
		const paidAmountInput = document.getElementById('cust_paid_amount');
		const form = document.getElementById('serviceForm');

		function validateInstallments() {
			const totalPrice = parseFloat(totalPriceInput.value) || 0;


			var total_gst_price = 0;
			$("#tbl_service_details").find(".form-control").each(function(j) {
				if ($(this).attr("name") == "cust_pdt_price[]") {
					var gst_price = parseFloat($(this).val());
					if (isNaN(gst_price)) {
						gst_price = 0;
					}
					total_gst_price = total_gst_price + gst_price;

				}
			});
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