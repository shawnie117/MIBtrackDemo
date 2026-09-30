<?php
$vendor  = $this->session->userdata('vendor');
$role_id = $vendor['user_role_id'];
?>
<style>
	#form_err {
		display: none;
		position: fixed;
		top: 100px;
		left: 50%;
		transform: translateX(-50%);
		z-index: 9999;

		width: auto;
		min-width: 300px;
		max-width: 500px;
	}

	#form_success {
		display: none;
		position: fixed;
		top: 100px;
		left: 50%;
		transform: translateX(-50%);
		z-index: 9999;

		width: auto;
		min-width: 300px;
		max-width: 500px;
	}

	.custom-alert {
		display: flex;
		align-items: center;
		gap: 10px;
		background: #fdecea;
		color: #b71c1c;
		padding: 10px 14px;
		border-radius: 6px;
		font-size: 14px;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
	}

	.alert-icon {
		font-size: 18px;
		color: #e53935;
	}

	.alert-text {
		flex: 1;
	}


/* .ticket-action-btns{
    display:flex;
    justify-content:flex-end;
    align-items:center;
    
    gap:6px;
    padding-right:14px;
}

.ticket-action-btns .btn{
    margin:0;
    white-space:nowrap;
}

.ticket-action-btns .btn-sm{
    padding:6px 8px !important;
    font-size:12px;
} */
	.ticket-action-btns{
    display:flex;
    justify-content:flex-end;
    align-items:center;
    flex-wrap:wrap;      /* allow wrapping */
    gap:8px;
}

.ticket-action-btns .btn{
    margin:0;
    white-space:nowrap;
}

@media(max-width:768px){
    .ticket-action-btns{
        justify-content:center;
    }

    .ticket-action-btns .btn{
        flex:1 1 calc(50% - 8px);
        min-width:140px;
        text-align:center;
    }
}

@media (max-width:1200px){
    .ticket-action-btns{
        justify-content:center;
    }
}

@media (max-width:768px){
    .ticket-action-btns{
        justify-content:center;
    }

    .ticket-action-btns .btn{
        flex:1 1 auto;
        min-width:160px;
        text-align:center;
    }
}	
	.ticket-btn-group{
    display:flex;
    justify-content:flex-end;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
}

.ticket-btn-group .btn{
    margin:0;
    white-space:nowrap;
}

</style>
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
						<div class="col-lg-3 col-md-12">
						<span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
						<span class="caption-subject font-red-mint sbold float-right total_count">( Total - 0 )</span>
					</div>
	
	<!-- added by anjali -->

	
			<div class="col-lg-9 col-md-12">
		<div class="ticket-action-btns">

        <?php if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) { ?>
            <a class="btn btn-info btn-sm"
               style="padding:8px 4px;"
               href="<?php echo get_module_path(); ?>customers/ticket_summary_report"
               title="Ticket Summary Report">
                <i class="fa fa-bar-chart"></i> Ticket Summary Report
            </a>

            <button id="toggleCheckbox" class="btn btn-primary btn-sm"
                    style="padding:8px 4px;">
                Multiple Ticket Transfer
            </button>
        <?php } ?>

        <a class="btn btn-success btn-sm"
           style="padding:8px 4px;"
           href="<?php echo get_module_path(); ?>customers/add_ticket"
           title="Add">
            <i class="fa fa-plus"></i> Add New
        </a>

        <?php if ($role_id == SUPER_ADMIN_ROLE_ID) { ?>
            <span class="btn red btn-outline btn-sm"
                  style="padding:8px 4px;"
                  id="download_ticket_report"
                  title="Download Ticket Report">
                <i class="fa fa-download"></i> Download
            </span>
        <?php } ?>

        <a class="btn btn-success"
           style="padding:8px 8px;"
           id="toggle_btn"
           title="Advance Search">
            <i class="icon-magnifier-add"></i>
        </a>

        <a class="btn btn-danger"
           style="padding:8px 8px;"
           id="clear_btn"
           title="Clear Search">
            <i class="icon-close"></i>
        </a>
    </div>
</div>
					<div class="row">
						<div id="form_success"></div>
						<div id="form_err"></div>
						<div class="col-md-12">
							<div class="portlet-body">
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
								<?php $ticket_post_data = array();
								$history = $this->input->get('history');
								$type    = $this->input->get('type');
								$assigned_to    = $this->input->get('assigned_to');
								$ticket_status  = $this->input->get('status');
								$assigned_to = !empty($assigned_to) ? base64_decode($assigned_to) : "";
								$page    = "1";
								if ($history == "back") {
									$ticket_post_data = $this->session->userdata('ticket_post_data');
									$page  = $ticket_post_data['page'];
								}
								?>
								<div class="col-md-12">
									<form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
										<input type="hidden" name="highlight_id" value="<?php echo $this->input->get("highlight"); ?>" />
										<div class="form-group col-md-3">
											<select class="form-control" id="status" name="status" onchange="table_list(1);">
												<option value=""> ALL TICKETS</option>
												<?php if (!empty($status_list)) {
													foreach ($status_list as $stat) {
														$status   = isset($ticket_post_data['status']) ? $ticket_post_data['status'] : "Open Tickets";
														$tkt_sts = !empty($ticket_status) ? $ticket_status : $status;
														$selected = $tkt_sts == $stat ? "selected" : "";
												?>
														<option value="<?php echo $stat ?>" <?php echo $selected; ?>><?php echo $stat; ?></option>
												<?php }
												} ?>
											</select>
										</div>
										<div class="form-group col-md-3">
											<select class="form-control selectpicker" id="customer_id" name="customer_id" data-live-search="true">
												<option value=""> Select Customer</option>
												<?php if (!empty($customer_list)) {
													foreach ($customer_list as $customer) {
														$customer_id   = isset($ticket_post_data['customer_id']) ? $ticket_post_data['customer_id'] : "";
														$selected = $customer_id == $customer['customer_id'] ? "selected" : "";
												?>
														<option value="<?php echo $customer['customer_id']; ?>" <?php echo $selected; ?>><?php echo $customer['customer_name']; ?></option>
												<?php }
												} ?>
											</select>
										</div>
										<div class="form-group col-md-3">
											<select class="form-control" id="ticket_type" name="ticket_type" onchange="table_list(1);">
												<option value="Ticket,Servicing"> ALL TICKETS</option>
												<?php if (!empty($ticket_type_list)) {
													foreach ($ticket_type_list as $key => $tktype) {
														$ticket_type   = isset($ticket_post_data['ticket_type']) ? $ticket_post_data['ticket_type'] : $type;
														$selected = $ticket_type == $key ? "selected" : "";
												?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $tktype; ?></option>
												<?php }
												} ?>
											</select>
										</div>
<div class="form-group col-md-3">
    <select class="form-control" id="priority" name="priority" onchange="table_list(1);">
        <option value="">ALL PRIORITY</option>
        <option value="High"
            <?php echo (isset($ticket_post_data['priority']) && $ticket_post_data['priority']=="High") ? "selected" : ""; ?>>
            High
        </option>
        <option value="Medium"
            <?php echo (isset($ticket_post_data['priority']) && $ticket_post_data['priority']=="Medium") ? "selected" : ""; ?>>
            Medium
        </option>
        <option value="Low"
            <?php echo (isset($ticket_post_data['priority']) && $ticket_post_data['priority']=="Low") ? "selected" : ""; ?>>
            Low
        </option>
											</select>
										</div>

										<!--div class="form-group col-md-2">  
						 <select class="form-control selectpicker" id="clm_id" name="clm_id" data-live-search="true">
							<option value=""> Select Lead</option>
							 <?php if (!empty($lead_list)) {
									foreach ($lead_list as $lead_) {
										$clm_id   = isset($ticket_post_data['clm_id']) ? $ticket_post_data['clm_id'] : "";
										$selected = $clm_id == $lead_['clm_id'] ? "selected" : "";
								?>
									<option value="<?php echo $lead_['clm_id']; ?>"   <?php echo $selected; ?>><?php echo $lead_['clm_name']; ?></option>
							<?php }
								} ?>	
						   </select>
                          </div-->

										<div class="form-group col-md-3">
											<input class="form-control" id="searchStr_name" name="searchStr_name" type="text" placeholder="SEARCH BY TICKET TITLE" maxlength="100" value="<?php echo isset($ticket_post_data['searchStr_name']) ? $ticket_post_data['searchStr_name'] : ""; ?>" onchange="table_list(1);">
										</div>

										<!-- <div class="form-group col-md-2"> 
                           <a class="btn btn-success " id="toggle_btn"  title="Advance Search"><i class=" icon-magnifier-add"></i></a>
						   &nbsp;
						     <a class="btn btn-danger " id="clear_btn"  title="Clear Search"><i class=" icon-close"></i></a>
                          					 
                        </div> -->
										<?php
										$class = "";
										$ticket_assign_to  = isset($ticket_post_data['ticket_assign_to']) ? $ticket_post_data['ticket_assign_to'] : $assigned_to;
										// added by anjali 02-07-26 - get Ticket Summary date filters from URL
										$from_date = isset($ticket_post_data['from_date']) ? $ticket_post_data['from_date'] : $this->input->get('from_date');
										$to_date   = isset($ticket_post_data['to_date']) ? $ticket_post_data['to_date'] : $this->input->get('to_date');
										// end added by anjali 02-07-26

										if (!empty($ticket_assign_to) || !empty($from_date) || !empty($to_date)) {
											$class = "";
										}
										?>
										<div id="toggle_srch" class="<?php echo $class; ?>">
											<?php if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) { ?>
												<div class="form-group col-md-3">
													<!-- <select class="form-control selectpicker" id="ticket_assign_to" name="ticket_assign_to" data-live-search="true">
														<option value=""> Select Assigned To</option>
														<?php if (!empty($employee_list)) {
															foreach ($employee_list as $employee) {
																$selected = $ticket_assign_to == $employee['user_id'] ? "selected" : "";
														?>
																<option value="<?php echo $employee['user_id']; ?>" <?php echo $selected; ?>><?php echo $employee['emp_name']; ?></option>
														<?php }
														} ?>
													</select> -->
													

												<select class="form-control selectpicker"
														id="ticket_assign_to"
														name="ticket_assign_to"
														data-live-search="true">

													<option value="">Select Assigned To</option>

													<?php if (!empty($employee_list)) {
														foreach ($employee_list as $employee) {

															$selected = ($ticket_assign_to == $employee['user_id']) ? "selected" : "";

															$status = isset($employee['emp_status']) ? $employee['emp_status'] : '';

															$displayName = $employee['emp_name'];

															if (strcasecmp($status, 'Deactivated') == 0) {
																$displayName .= ' (Deactivated)';
															}
													?>
															<option value="<?php echo $employee['user_id']; ?>" <?php echo $selected; ?>>
																<?php echo $displayName; ?>
															</option>
													<?php
														}
													} ?>
												</select>
												</div>
											<?php } ?>
											<!-- added by anjali 02-07-26 - display Ticket Summary date filters -->
											<div class="form-group col-md-3">
												<input type="text" class="form-control pull-right datepickerD" id="from_date" name="from_date" placeholder="FROM DATE" maxlength="10" value="<?php echo html_escape($from_date); ?>">
											</div>
											<div class="form-group col-md-3">
												<input type="text" class="form-control pull-right datepickerD" id="to_date" name="to_date" placeholder="TO DATE" maxlength="10" value="<?php echo html_escape($to_date); ?>">
											</div>
											<!-- end added by anjali 02-07-26 -->
										</div>


									</form>
								</div>

								<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch" role="grid" aria-describedby="sample_1_info">
									<thead>
										<tr style="background-color:#ABE7ED; color:#000;">
											<th width="2%">Sr. No.</th>
											<th width="3%">Ticket ID </th>
											<th>Ticket Title</th>
											<th width="22%">Client Name </th>
											<th width="10%">Task Date</th>
											<th width="10%" style="text-align:center">Status </th>
											<th style="display:none;" class="action-col">
												<input type="checkbox" id="selectAllticket" class="select-all-checkbox"> Select All Ticket
											</th>
										</tr>
									</thead>
									<tbody id="tbl_list">
									</tbody>
								</table>

								<!-- Render pagination links -->
								<div class="pagination" style="float:right;">
								</div>
								<button id="submitButton" class="btn btn-success" style="display:none;margin-top:9px;">
									Transfer Tickets
								</button>
							</div>
						</div>
					</div>
					<!-- END Portlet PORTLET-->
				</div>            
			</div>
			<!-- END PAGE BASE CONTENT -->
		</div>
		<!-- END CONTENT BODY -->
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

<!-- START MODAL -->
<!-- Vihas added on 02/04/2026 -->
<div id="ticketTransferModal" class="modal fade">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Transfer Tickets</h4>
			</div>
			<div class="modal-body">
				<label for="ticket_assign_to">Ticket Assign To <?php echo REQUIRED_STAR; ?></label>
				<select id="assign_to" class="form-control">
					<option value="">Select Employee</option>
					<?php foreach ($employee_list as $emp) { ?>
						<option value="<?= $emp['user_id'] ?>">
							<?= $emp['emp_name'] ?>
						</option>
					<?php } ?>
				</select>

				<br>
				<center>
					<button id="confirmTransfer" class="btn btn-success" type="button">Submit</button>
					<button type="button" class="btn red btn-outline" data-dismiss="modal">Cancel</button>
				</center>
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

<div class="modal fade" id="form_modal1" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		</div>
	</div>
</div>
<!--END START MODAL -->

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {

		sessionStorage.removeItem('selectedTickets');
		sessionStorage.removeItem('ticketColumnVisible');
		selectedTickets.clear();

		sessionStorage.setItem('ticketColumnVisible', 'false');

		applyColumnState();

		$("#clear_btn").click(function(e) {
			$('#searchStr_name').val('');
			// $('#status, #ticket_assign_to, #customer_id, #clm_id').val('');
			$('#status, #priority, #ticket_assign_to, #customer_id, #clm_id').val('');
			$('#from_date, #from_date').val('');
			$('#srch_form').trigger("reset");
			$(".selectpicker").val('');
			$(".selectpicker").selectpicker("refresh");
			table_list(1);
		});

		$("#download_ticket_report").click(function(e) {
			$('#srch_form').attr("action", base_url + "customers/download_ticket_report");
			$('#srch_form').attr("onsubmit", "");
			$('#srch_form').submit();
			$('#srch_form').attr("action", "");
			$('#srch_form').attr("onsubmit", "return false;");

		});

		$('.selectpicker').selectpicker();
		$('.selectpicker').on('change', function() {
			table_list(1);
		});

		$("#form_modal").on("show.bs.modal", function(e) {
			var link = $(e.relatedTarget);
			$(this).data('bs.modal', null);
			$(this).find(".modal-content").load(link.attr("href"));
		});
		$('.datepickerD').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,

		}).on('changeDate', function(e) {
			table_list(1);
		});

		$('.datepickerMY').datepicker({
			format: 'mm-yyyy',
			autoclose: true,
			todayHighlight: true,
			viewMode: "months",
			minViewMode: "months"

		}).on('changeDate', function(e) {
			table_list(1);
		});


		$('#confirm-deactivate').on('show.bs.modal', function(e) {
			$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
		});

		// Detect pagination click
		$('.pagination').on('click', 'a', function(e) {
			e.preventDefault();
			var pageno = $(this).attr('data-ci-pagination-page');
			if (pageno) {
				table_list(pageno);
			}

		});

	});
	table_list(<?php echo $page; ?>);

	function table_list(pageno) {
		var formdata = $("#srch_form").serializeArray();
		$("#tbl_list").html("");
		$.ajax({
			url: base_url + "ajax/tbl_ticket_list/" + pageno,
			type: "POST",
			data: formdata,
			datatype: "json",
			async: true,
			cache: false,
			success: function(data) {
				var json_arr = JSON.parse(data);
				var html_data = '';
				var html_data = json_arr.list;
				var total_count = json_arr.total_count;

				$(".total_count").html("( Total - " + total_count + " )");
				$("#tbl_list").html(html_data);
				$('.pagination').html(json_arr.pagination);

				applyColumnState();
				
				// Auto select employee and status from Ticket Summary Report
				//added by anjali for count clickeble in lead summary report

					var assigned_to = '<?php echo $assigned_to; ?>';
					var ticket_status = '<?php echo $ticket_status; ?>';

					if (assigned_to != '') {
						$('#ticket_assign_to').val(assigned_to);
						$('#ticket_assign_to').selectpicker('refresh');
					}

					if (ticket_status != '') {
						$('#status').val(ticket_status);
					}
									restoreSelection();
								}
							});
						}
					</script>
<!-- Vihas added on 02/04/2026 -->
<script>
	var selectedTickets = new Set();

	// Toggle column
	$('#toggleCheckbox').click(function() {

		$('#status').val('Open');
		$('#status').trigger('change');
		$('#status').selectpicker('refresh');
		table_list(1);

		var isVisible = $('.action-col:visible').length > 0;

		if (isVisible) {
			sessionStorage.setItem('ticketColumnVisible', 'false');
		} else {
			sessionStorage.setItem('ticketColumnVisible', 'true');
		}

		applyColumnState();
	});

	function applyColumnState() {
		var isVisible = sessionStorage.getItem('ticketColumnVisible') === 'true';

		if (isVisible) {
			$('.action-col').show();
			$('#submitButton').show();
		} else {
			$('.action-col').hide();
			$('#submitButton').hide();
		}
	}

	// Select all
	$(document).on('change', '#selectAllticket', function() {
		var checked = $(this).prop('checked');

		$('.ticket-checkbox').each(function() {
			var id = $(this).data('id').toString();

			$(this).prop('checked', checked);

			if (checked) {
				selectedTickets.add(id);
			} else {
				selectedTickets.delete(id);
			}
		});

		sessionStorage.setItem('selectedTickets', JSON.stringify([...selectedTickets]));
	});

	// Individual select
	$(document).on('change', '.ticket-checkbox', function() {
		var id = $(this).data('id').toString();

		if ($(this).is(':checked')) {
			selectedTickets.add(id);
		} else {
			selectedTickets.delete(id);
		}

		sessionStorage.setItem('selectedTickets', JSON.stringify([...selectedTickets]));
		$('#selectAllticket').prop(
			'checked',
			$('.ticket-checkbox').length === $('.ticket-checkbox:checked').length
		);
	});

	// Open modal
	$('#submitButton').click(function() {
		$('#ticketTransferModal').modal('show');
	});

	function showError(message) {
		const el = $('#form_err');

		el.stop(true, true);

		el.css('display', 'block')
			.html(`
				<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span class="alert-text">${message}</span>
                </div>
			`)
			.removeClass('text-success text-danger')
			.fadeIn(200);

		setTimeout(() => {
			el.fadeOut(300);
		}, 3500);
	}

	function restoreSelection() {
		$('.ticket-checkbox').each(function() {
			var id = $(this).data('id').toString();

			if (selectedTickets.has(id)) {
				$(this).prop('checked', true);
			}
		});

		// Update select all checkbox
		$('#selectAllticket').prop(
			'checked',
			$('.ticket-checkbox').length === $('.ticket-checkbox:checked').length
		);
	}


	// Submit transfer
	$('#confirmTransfer').click(function(e) {
		e.preventDefault();
		var emp = $('#assign_to').val();

		if (selectedTickets.size === 0) {
			$('#ticketTransferModal').modal('hide');
			showError("Please select the ticket to transfer");
			return;
		}

		if (!emp) {
			$('#ticketTransferModal').modal('hide');
			showError("Please select the Employee to whom the ticket to be transfer");
			return;
		}

		$.ajax({
			url: base_url + "customers/transfer_multiple_tickets",
			type: "POST",
			data: {
				ticket_ids: [...selectedTickets],
				assign_to: emp
			},
			success: function(response) {
				// console.log(response);
				var res = typeof response === "string" ? JSON.parse(response) : response;

				if (res.status === 'success') {
					$('#ticketTransferModal').modal('hide');
					sessionStorage.removeItem('selectedTickets');
					sessionStorage.removeItem('ticketColumnVisible');
					selectedTickets.clear();
					showSuccess("Tickets transferred successfully");
					table_list(1);
				} else {
					$('#ticketTransferModal').modal('hide');
					location.reload();
					sessionStorage.setItem('selectedTickets', null);
					sessionStorage.setItem('isColumnHidden', null);
				}
			},
			error: function() {
				showError('There was an error submitting the ticket');
			}
		});
	});

	function showSuccess(message) {
		const el = $('#form_success');

		el.stop(true, true);

		el.css('display', 'block')
			.html(`
            <div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>	
                <span class="alert-text">${message}</span>
            </div>
        `)
			.fadeIn(200);

		setTimeout(() => {
			el.fadeOut(300);
		}, 3000);
	}
</script>
