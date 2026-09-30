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
						<li><a href="<?php echo base_url(get_module() . "/customers/payment_report") ?>">All Payment Report </a><i class="fa fa-circle"></i></li>
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
							<?php if ($action == "Add") {
								$formaction = "add_payment";
							}
							if ($action == "Customer") {
								$formaction = "add_customer_payment/?ref_id=" . base64_encode($ref_id) . "&pay_id=" . base64_encode($pay_id);
							}

							?>

							<form action="<?php echo get_module_path() . 'customers/' . $formaction; ?>" id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data">
								<div class="form-body">
									<div class="portlet-body">
										<div class="col-md-12">
											<div class="portlet-title">
												<div class="caption">
													<i class="font-red-mint icon-user"></i>
													<span class="caption-subject font-red-mint sbold">Basic Details</span>
												</div>
												<hr style="margin:3px;" />
											</div>

											<!-- <?php if ($action == "Customer") { ?>
                           <input type="hidden" name="cust_id" value="<?php echo $ref_id; ?>">
						   <?php } ?> -->
											<?php if ($action == "Customer") { ?>
												<input type="hidden" name="cust_id" id="cust_id" value="<?php echo $ref_id; ?>">
											<?php } ?>


											<?php if ($action == "Add") { ?>
												<div class="form-group col-md-3">
													<label for="cust_id">Customer</label><?php echo REQUIRED_STAR; ?>
													<select class="form-control" id="cust_id" name="cust_id" required onchange="get_invoice_details(this);">
														<option value=""> Select Customer</option>
														<?php if (!empty($customer_list)) {
															foreach ($customer_list as $customer) {
																$service_type =  isset($details['clm_priority_level']) ? $details['clm_priority_level'] : set_value("cust_id");
																$selected  = $customer['customer_id'] == $service_type ? "selected" : "";
														?>
																<option value="<?php echo $customer['customer_id']; ?>" <?php echo $selected; ?>><?php echo $customer['customer_name']; ?></option>
														<?php }
														} ?>
													</select>
													<?php echo form_error('cust_id', '<span class="text-danger">', '</span>'); ?>
												</div>
											<?php } ?>
											<div class="form-group col-md-3">
												<label for="cbpm_id">Invoice</label><?php echo REQUIRED_STAR; ?>
												<!-- <select class="form-control" id="cbpm_id" name="cbpm_id" required > -->
												<select class="form-control" id="cbpm_id" name="cbpm_id" required onchange="get_invoice_details_by_invoice(this);">

													<?php echo isset($html_data['invoice_details']) ? $html_data['invoice_details'] : ""; ?>
												</select>
												<?php echo form_error('cbpm_id', '<span class="text-danger">', '</span>'); ?>
											</div>

											<div class="form-group col-md-3">
												<label for="ui_billno">Bill Book No</label>
												<input class="form-control" id="ui_billno" name="ui_billno" type="text" placeholder="Enter Bill Book No" maxlength="10" value="<?php echo set_value("ui_billno"); ?>">
												<?php echo form_error('ui_billno', '<span class="text-danger">', '</span>'); ?>
											</div>
											<div class="form-group col-md-3">
												<label for="pay_mode">Payment Mode <?php echo REQUIRED_STAR; ?></label>
												<select class="form-control" id="pay_mode" name="pay_mode" onchange="get_payment_details(this);">
													<option value=""> Payment Mode</option>
													<?php if (!empty($payment_mode_list)) {
														foreach ($payment_mode_list as $key => $pay) { ?>
															<option value="<?php echo $key; ?>"><?php echo $pay; ?></option>
													<?php }
													} ?>
												</select>
												<?php echo form_error('pay_mode', '<span class="text-danger">', '</span>'); ?>
											</div>
											<div class="col-md-12 hidden" id="online_payment_msg">
												<div class="alert alert-info" style="margin-top:10px;">
													<strong>Note:</strong> Online payment entries must be verified and confirmed from the Customer detailed Report before they are considered completed.
												</div>
											</div>
											<div class="col-md-12 hidden" id="cheque_payment_msg">
												<div class="alert alert-info" style="margin-top:10px;">
													<strong>Note:</strong> Cheque payment entries must be verified and confirmed from the Customer detailed Report before they are considered completed.
												</div>
											</div>
										</div>

										<div class="col-md-12">

											<div class="portlet-title">
												<div class="caption">
													<i class="font-red-mint icon-wallet"></i>
													<span class="caption-subject font-red-mint sbold">Payment Details</span>
												</div>
												<hr style="margin:3px;" />
											</div>

											<div class="form-group col-md-3">
												<label for="paying_amt">Paying Amount <?php echo REQUIRED_STAR; ?></label>
												<input class="form-control" id="paying_amt" name="paying_amt" type="text" placeholder="Total Paying Amount" maxlength='8' value="<?php echo isset($payment_intallments[0]['cbpi_pay_next_amount']) ? $payment_intallments[0]['cbpi_pay_next_amount'] : set_value("paying_amt"); ?>">
												<?php echo form_error('paying_amt', '<span class="text-danger">', '</span>'); ?>
											</div>

											<div class="form-group col-md-3">
												<label for="paying_ui_date">Payment Date<?php echo REQUIRED_STAR; ?></label>
												<input class="form-control datepicker" id="paying_ui_date" name="paying_ui_date" type="text" placeholder="Enter Payment Date" maxlength="15" value="<?php echo set_value("paying_ui_date"); ?>">
												<?php echo form_error('paying_ui_date', '<span class="text-danger">', '</span>'); ?>
											</div>

											<div class="form-group col-md-3">
												<label for="payment_terms">Payment Terms</label>
												<input class="form-control" id="payment_terms" name="payment_terms" type="text" placeholder="Enter Payment Terms" maxlength="100" value="<?php echo set_value("payment_terms"); ?>">
												<?php echo form_error('payment_terms', '<span class="text-danger">', '</span>'); ?>
											</div>
											<div class="form-group col-md-3">
												<label for="payment_remark">Payment Remark</label>
												<input class="form-control" id="payment_remark" name="payment_remark" type="text" placeholder="Enter Payment Remark" maxlength="100" value="<?php echo set_value("payment_remark"); ?>">
												<?php echo form_error('payment_remark', '<span class="text-danger">', '</span>'); ?>
											</div>

											<div class="col-md-12 hidden" id="cheque_details">
												<div class="portlet-title">
													<br />
													<div class="caption">
														<i class="font-red-mint  icon-note"></i>
														<span class="caption-subject font-red-mint sbold">Cheque Details</span>
													</div>
													<hr style="margin:3px;" />
												</div>
												<div class="form-group col-md-3">
													<label for="chq_bankname">Bank Name</label><?php echo REQUIRED_STAR; ?>
													<input class="form-control" id="chq_bankname" name="chq_bankname" type="text" placeholder="Enter Bank Name" maxlength="100" value="<?php echo set_value("chq_bankname"); ?>">
													<?php echo form_error('chq_bankname', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-3">
													<label for="chq_no">Bank Cheque Number<?php echo REQUIRED_STAR; ?></label>
													<input class="form-control" id="chq_no" name="chq_no" type="text" placeholder="Enter Cheque Number" maxlength="6" value="<?php echo set_value("chq_no"); ?>">
													<?php echo form_error('chq_no', '<span class="text-danger">', '</span>'); ?>
												</div>

												<div class="form-group col-md-3">
													<label for="chq_date">Cheque Date<?php echo REQUIRED_STAR; ?></label>
													<input class="form-control datepicker" id="chq_date" name="chq_date" type="text" placeholder="Enter Cheque Date" maxlength="15" value="<?php echo set_value("chq_date"); ?>">
													<?php echo form_error('chq_date', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-3">
													<label for="chq_img">Cheque Image</label>
													<input type="file" name="chq_img" id="chq_img"
														class="smart-file"
														data-label="Cheque Image"
														data-btn-class="btn btn-default btn-sm"
														data-preview="on"
														data-file-types="image/jpeg,image/png,image/jpg" />
													<?php echo form_error('chq_img', '<span class="text-danger">', '</span>'); ?>
													<span class="file_err"></span>
												</div>
												<div class="form-group col-md-3">
													<label for="chq_bounce_chrg">Cheque Bounce Charges</label>
													<input class="form-control" id="chq_bounce_chrg" name="chq_bounce_chrg" type="text" placeholder="Enter Cheque Bounce Charges" maxlength="6" value="<?php echo set_value("chq_bounce_chrg"); ?>">
													<?php echo form_error('chq_bounce_chrg', '<span class="text-danger">', '</span>'); ?>
												</div>

												<div class="form-group col-md-3">
													<label for="chq_clear_status">Cheque Clear Status</label>
													<input class="form-control" id="chq_clear_status" name="chq_clear_status" type="text" placeholder="Enter Clear Status" maxlength="50" value="<?php echo set_value("chq_clear_status"); ?>">
													<?php echo form_error('chq_clear_status', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>
											<div class="col-md-12 hidden" id="dd_details">
												<div class="portlet-title">
													<br />
													<div class="caption">
														<i class="font-red-mint  icon-note"></i>
														<span class="caption-subject font-red-mint sbold">DD Details</span>
													</div>
													<hr style="margin:3px;" />
												</div>
												<div class="form-group col-md-3">
													<label for="dd_bankname">Bank Name</label><?php echo REQUIRED_STAR; ?>
													<input class="form-control" id="dd_bankname" name="dd_bankname" type="text" placeholder="Enter Bank Name" maxlength="100" value="<?php echo set_value("dd_bankname"); ?>">
													<?php echo form_error('dd_bankname', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-3">
													<label for="dd_no">DD Number<?php echo REQUIRED_STAR; ?></label>
													<input class="form-control" id="dd_no" name="dd_no" type="text" placeholder="Enter DD Number" maxlength="6" value="<?php echo set_value("dd_no"); ?>">
													<?php echo form_error('dd_no', '<span class="text-danger">', '</span>'); ?>
												</div>

												<div class="form-group col-md-3">
													<label for="dd_img">DD Image</label><br />
													<input type="file" name="dd_img" id="dd_img"
														class="smart-file"
														data-label="DD Image"
														data-btn-class="btn btn-default btn-sm"
														data-preview="on"
														data-file-types="image/jpeg,image/png,image/jpg" />
													<?php echo form_error('dd_img', '<span class="text-danger">', '</span>'); ?>
													<span class="file_err"></span>
												</div>
											</div>

											<div class="col-md-12 hidden" id="bnk_details">
												<div class="portlet-title">
													<br />
													<div class="caption">
														<i class="font-red-mint  icon-note"></i>
														<span class="caption-subject font-red-mint sbold">Bank Details</span>
													</div>
													<hr style="margin:3px;" />
												</div>
												<div class="form-group col-md-4">
													<label for="bank_name">Bank Name</label><?php echo REQUIRED_STAR; ?>
													<input class="form-control" id="bank_name" name="bank_name" type="text" placeholder="Enter Bank Name" maxlength="100" value="<?php echo set_value("bank_name"); ?>">
													<?php echo form_error('bank_name', '<span class="text-danger">', '</span>'); ?>
												</div>
												<div class="form-group col-md-4">
													<label for="bank_details">Bank Details</label><?php echo REQUIRED_STAR; ?>
													<input class="form-control" id="bank_details" name="bank_details" type="text" placeholder="Enter Bank Details" maxlength="100" value="<?php echo set_value("bank_details"); ?>">
													<?php echo form_error('bank_details', '<span class="text-danger">', '</span>'); ?>
												</div>

											</div>
											<div class="col-md-12 hidden" id="other_details">
												<div class="portlet-title">
													<br />
													<div class="caption">
														<i class="font-red-mint  icon-note"></i>
														<span class="caption-subject font-red-mint sbold">Transaction / Payment Details</span>
													</div>
													<hr style="margin:3px;" />
												</div>
												<div class="form-group col-md-4">
													<label for="remark">Remark</label>
													<input class="form-control" id="remark" name="remark" type="text" placeholder="Enter Remark" maxlength="100" value="<?php echo set_value("remark"); ?>">
													<?php echo form_error('remark', '<span class="text-danger">', '</span>'); ?>
												</div>
											</div>




											<!-- <div class="col-md-12">                            
   <i class="font-red-mint icon-wallet"></i>
   <span class="caption-subject font-red-mint sbold">Installments</span>
</div>
<form method="POST" action="store_installments.php">
   <table class="table table-bordered" id="installments_table">
       <thead>
           <tr>
               <th>Next Installment Date</th>
               <th>Next Installment Amount</th>
               <th>Action</th>
           </tr>
       </thead>
       <tbody id="installments_table_body">
           <tr>
               <td>
                   <input type="text" class="form-control datepicker" name="next_installment_date[]" placeholder="Select Date" />
               </td>
               <td>
                   <input type="number" class="form-control" name="next_installment_amount[]" placeholder="Enter Amount" />
               </td>
               <td>
                   <button type="button" class="btn btn-success btn-xs" id="add_installment_row">
                       <i class="fa fa-plus"></i>
                   </button>
               </td>
           </tr>
       </tbody>
   </table>
   <button type="submit" class="btn btn-primary">Save Installments</button> -->
											<!-- </form> --><?php if (!empty($html_data['details']) && !empty($html_data['details']['installments'])) { ?>

												<div class="col-md-12">
													<div class="portlet-title">
														<br />
														<div class="caption">
															<i class="font-red-mint icon-wallet"></i>
															<span class="caption-subject font-red-mint sbold">Payment Installments</span>
														</div>
														<hr style="margin:3px;" />
													</div>

													<div class="tbl-container">

														<table class="table table-striped table-bordered table-advance table-hover">
															<thead>
																<tr class="success">
																	<th>Sr. No.</th>
																	<th>Installment Date</th>
																	<th>Installment Amount</th>
																	<th>Status</th>
																	<th>Action</th>
																</tr>
															</thead>

															<tbody>
																<?php foreach ($html_data['details']['installments'] as $key => $report) { ?>
																	<tr>
																		<td><?php echo $key + 1; ?></td>
																		<td><?php echo $report['cbpi_pay_next_date'] ?? ""; ?></td>
																		<td><?php echo $report['cbpi_pay_next_amount'] ?? ""; ?></td>

																		<td>
																			<?php
																			if ($report['cbpi_status'] == "Paid") {
																				echo "<span class='label label-success'>Paid</span>";
																			} elseif ($report['cbpi_status'] == "Unpaid") {
																				echo "<span class='label label-warning'>Pending</span>";
																			} else {
																				echo "<span class='label label-danger'>Overdue</span>";
																			}
																			?>
																		</td>

																		<td>
																			<?php if ($report['cbpi_status'] == "Paid") { ?>
																				<span class="label label-success">Paid</span>
																			<?php } else {
																				$pay_id = base64_encode($report['cbpi_id']);
																			?>
																				<span class="label label-danger">Unpaid</span>
																			<?php } ?>
																		</td>
																	</tr>
																<?php } ?>
															</tbody>
														</table>

													</div>
												</div>

											<?php } ?> <!-- END IF -->



											<div class="form-actions">
												<div class="col-md-12">
													<center>
														<span class="btn btn-success" id="add_edit_form_btn">Submit</span>
														<a href="<?php echo get_module_path(); ?>customers/payment_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
													</center>
												</div>
											</div>
										</div>
										<div class="col-md-12" id="payment_details"><?php echo isset($html_data['payment_details']) ? $html_data['payment_details'] : ""; ?></div>
										<div class="" id="service_details"><?php echo isset($html_data['service_list']) ? $html_data['service_list'] : ""; ?></div>
										<div class="" id="billpayment_details"><?php echo isset($html_data['payment_list']) ? $html_data['payment_list'] : ""; ?></div>

									</div>




							</form>

							<!-- /.box-body -->


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
				cust_id: {
					required: true,
				},
				cbpm_id: {
					required: true,
				},
				pay_mode: {
					required: true,
				},
				paying_ui_date: {
					required: true,
				},
				ui_billno: {
					/* required: true, */
					maxlength: 10,
					digits: true,
				},
				paying_amt: {
					required: true,
					maxlength: 12,
					number: true,
					// lessThanOrEqual: "#cbpm_balance_amnt",
					lessThanOrEqualAmount: "#cbpm_balance_amnt",
				},
				payment_terms: {
					maxlength: 100,
					minlength: 2,
				},
				payment_remark: {
					maxlength: 100,
					minlength: 2,
				},
				chq_bankname: {
					required: true,
					maxlength: 100,
					minlength: 2,
				},
				chq_no: {
					required: true,
					maxlength: 6,
					digits: true,
				},
				chq_bounce_chrg: {
					maxlength: 6,
					digits: true,
				},
				chq_clear_status: {
					maxlength: 50,
				},
				chq_date: {
					required: true,
				},
				chq_img: {
					// required: true,
					accept: "image/jpeg,image/png,image/jpg",
					filesize_max: 1000000, // 1 MB
				},

				dd_bankname: {
					required: true,
					maxlength: 100,
				},
				dd_no: {
					required: true,
					maxlength: 6,
					digits: true,
				},
				dd_img: {
					// required: true,
					accept: "image/jpeg,image/png,image/jpg",
					filesize_max: 1000000, // 1 MB
				},
				bank_name: {
					required: true,
					maxlength: 100,
				},
				bank_details: {
					required: true,
					maxlength: 100,
				},


			},
			messages: {
				paying_amt: {
					// lessThanOrEqual: "Paying Amount Must Be Less Than Or Equal To Balance Amount"
					lessThanOrEqualAmount: "Paying Amount Must Be Less Than Or Equal To Balance Amount"
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


		var firstInvoice = $("#cbpm_id option[value!='']:first").val();

		if (firstInvoice) {
			$("#cbpm_id").val(firstInvoice);

			// Call your existing function
			get_invoice_details_by_invoice(document.getElementById('cbpm_id'));
		}
	});

	function IsEmail(email) {
		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!regex.test(email)) {
			return false;
		} else {
			return true;
		}
	}

	function get_invoice_details(obj) {
		var cust_id = $(obj).val();
		if (cust_id) {
			$(".loader").fadeIn();
			$.ajax({
				url: base_url + "ajax/get_customer_invoice_details",
				type: "POST",
				data: {
					'cust_id': cust_id
				},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data) {
					var data = JSON.parse(data);
					var service_list = data.service_list;
					var payment_list = data.payment_list;
					var payment_details = data.payment_details;
					var invoice_details = data.invoice_details;
					var cbpm_balance_amnt = data.cbpm_balance_amnt;
					var instalment_detatails = data.html_data;

					// Clear details
					$("#payment_details").html("");
					$("#service_details").html("");
					$("#billpayment_details").html("");

					$("#payment_details").html(payment_details);
					$("#service_details").html(service_list);
					$("#billpayment_details").html(payment_list);
					$("#cbpm_id").html(invoice_details);
					if (cbpm_balance_amnt == "0") {
						$('#add_edit_form_btn').addClass("hidden");
					} else {
						$('#add_edit_form_btn').removeClass("hidden");
					}
					$(".loader").fadeOut();
				}
			});
		}
	}

	var action = "<?php echo $action; ?>";

	function get_invoice_details_by_invoice(obj) {
		var cust_id = $("#cust_id").val();
		var cbpm_id = $(obj).val();
		if (cust_id) {
			$(".loader").fadeIn();
			$.ajax({
				url: base_url + "ajax/get_customer_invoice_details",
				type: "POST",
				data: {
					'cust_id': cust_id,
					'cbpm_id': cbpm_id
				},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data) {
					var data = JSON.parse(data);
					var service_list = data.service_list;
					var payment_list = data.payment_list;
					var payment_details = data.payment_details;
					var invoice_details = data.invoice_details;
					var cbpm_balance_amnt = data.cbpm_balance_amnt;
					var instalment_detatails = data.html_data;

					// Clear details
					$("#payment_details").html("");
					$("#service_details").html("");
					$("#billpayment_details").html("");

					$("#payment_details").html(payment_details);
					$("#service_details").html(service_list);
					$("#billpayment_details").html(payment_list);
					// $("#cbpm_id").html(invoice_details);
					if (obj.id == "cust_id") {
						$("#cbpm_id").html(invoice_details);
					}
					if (cbpm_balance_amnt == "0") {
						$('#add_edit_form_btn').addClass("hidden");
					} else {
						$('#add_edit_form_btn').removeClass("hidden");
					}

					
					$("#paying_amt").val(data.paying_amt);
					
					$("#paying_ui_date").val(data.paying_ui_date);

					$(".loader").fadeOut();
				}
			});
		}
	}

	function get_payment_details(obj) {

		var payment_type = $(obj).val();
		$("#bnk_details").addClass("hidden");
		$("#other_details").addClass("hidden");
		$("#dd_details").addClass("hidden");
		$("#cheque_details").addClass("hidden");
		$("#online_payment_msg").addClass("hidden");
		$("#cheque_payment_msg").addClass("hidden");

		if (payment_type == "DD") {
			$("#dd_details").removeClass("hidden");
		} else if (payment_type == "Cheque") {
			$("#cheque_payment_msg").removeClass("hidden");
			$("#cheque_details").removeClass("hidden");

		} else if (payment_type == "Card") {
			$("#bnk_details").removeClass("hidden");
		} else {
			$("#other_details").removeClass("hidden");
			if (payment_type == "Online" ) {
				$("#online_payment_msg").removeClass("hidden");
			}
		}
	}
</script>