<?php $role_id = $this->session->userdata('user_role_id'); ?>
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
					<?php if ($role_id == SUPER_ADMIN_ROLE_ID) { ?>
						<span class="btn red btn-outline btn-sm pull-right" id="download_upcoming_service_report"
							title="Download Upcoming Service Report"><i class="fa fa-download"></i> Download </span>

					<?php } ?> <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
					<span class="caption-subject font-red-mint sbold float-right total_count">( Total - 0 )</span>

					<div class="row">


						<div class="col-md-12">
							<div class="portlet-body">
								<div class="col-md-6">
									<?php
									$this->load->helper('form');
									$error = $this->session->flashdata('error');
									if ($error) {
										?>
										<div class="alert alert-danger alert-dismissable">
											<button type="button" class="close" data-dismiss="alert"
												aria-hidden="true">×</button>
											<?php echo $this->session->flashdata('error'); ?>
										</div>
									<?php } ?>
									<?php
									$success = $this->session->flashdata('success');
									if ($success) {
										?>
										<div class="alert alert-success alert-dismissable">
											<button type="button" class="close" data-dismiss="alert"
												aria-hidden="true">×</button>
											<?php echo $this->session->flashdata('success'); ?>
										</div>
									<?php } ?>

								</div>
								<?php $upserv_post_data = array();
								$history = $this->input->get('history');
								$pdate = $this->input->get('pdate');
								if ($history == "back") {
									$upserv_post_data = $this->session->userdata('upserv_post_data');
								}
								?>
								<div class="col-md-12">
									<form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">

										<input type="hidden" name="pdate" id="pdate" value="<?php echo $pdate; ?>" />
										<div class="form-group col-md-2">
											<input class="form-control" id="searchStr_name" name="searchStr_name"
												type="text" placeholder="Search By Name" maxlength="100"
												value="<?php echo isset($upserv_post_data['searchStr_name']) ? $upserv_post_data['searchStr_name'] : ""; ?>"
												onchange="table_list(1);">
										</div>
										<div class="form-group col-md-2">
											<input type="text" class="form-control pull-right datepickerD" id="sdate"
												name="sdate" placeholder="Date" maxlength="10"
												value="<?php echo isset($upserv_post_data['sdate']) ? $upserv_post_data['sdate'] : ""; ?>">
										</div>

										<!-- <div class="form-group col-md-2"> 
						  <input type="text" class="form-control pull-right datepickerD" id="pdate" name="pdate" placeholder="From Date" maxlength="10" value="<?php echo isset($upserv_post_data['pdate']) ? $upserv_post_data['pdate'] : ""; ?>" >
						</div>	 
						<div class="form-group col-md-2"> 
						  <input type="text" class="form-control pull-right datepickerD" id="udate" name="udate" placeholder="To Date" maxlength="10" value="<?php echo isset($upserv_post_data['udate']) ? $upserv_post_data['udate'] : ""; ?>" >
						</div>							 -->
										<div class="form-group col-md-2">
											<input class="form-control datepickerMY" id="month_year" name="month_year"
												type="text" placeholder="To Month -Year" maxlength="15"
												value="<?php echo isset($upserv_post_data['month_year']) ? $upserv_post_data['month_year'] : ""; ?>">
										</div>

										<div class="form-group col-md-2">
											<input class="form-control datepickerYear" id="one_year" name="one_year"
												type="text" placeholder="To Year" maxlength="15"
												value="<?php echo isset($upserv_post_data['one_year']) ? $upserv_post_data['one_year'] : ""; ?>">
										</div>

										<div class="form-group col-md-2">
											<select class="form-control" id="pending_upcoming" name="pending_upcoming"
												onchange="table_list(1);">
												<option value="">Select Service</option>
												<?php
												foreach ($pen_up as $service) {
													$value = strtolower(str_replace(" ", "_", $service));
													// Check if the value matches the selected option
													$selected = (isset($pending_upcoming) && $pending_upcoming === $value) ? 'selected' : '';
													echo '<option value="' . $value . '" ' . $selected . '>' . $service . '</option>';
												}
												?>
											</select>
										</div>



										<div class="form-group col-md-2">
											<a class="btn btn-danger " id="clear_btn" title="Clear Search"><i
													class=" icon-close"></i></a>
										</div>

									</form>
								</div>

								<table
									class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"
									role="grid" aria-describedby="sample_1_info">
									<thead>
										<tr>
											<th width="2%">Sr. No.</th>
											<th>Customer Name</th>
											<th width="12%">Contact No</th>
											<th>Service</th>
											<th width="12%">Service Date</th>
											<th width="12%">Start Date</th>
											<th width="12%">End Date</th>
											<th width="5%">Action</th>

										</tr>
									</thead>
									<tbody id="tbl_list">

									</tbody>
								</table>

								<!-- Render pagination links -->
								<div class="pagination" style="float:right;">
								</div>
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
<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
		</div>
	</div>
</div>
<!--END START MODAL -->

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$("#download_upcoming_service_report").click(function (e) {
			$('#srch_form').attr("action", base_url + "customers/download_upcoming_service_report");
			$('#srch_form').attr("onsubmit", "");
			$('#srch_form').submit();
			$('#srch_form').attr("action", "");
			$('#srch_form').attr("onsubmit", "return false;");

		});

		$("#clear_btn").click(function (e) {
			$('#month_year, #sdate, #searchStr_name, #one_year').val('');
			table_list(1);
		});

		$("#form_modal").on("show.bs.modal", function (e) {
			var link = $(e.relatedTarget);
			$(this).data('bs.modal', null);
			$(this).find(".modal-content").load(link.attr("href"));
		});
		$('.datepickerD').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,

		}).on('changeDate', function (e) {
			table_list(1);
		});

		$('.datepickerMY').datepicker({
			format: 'mm-yyyy',
			autoclose: true,
			todayHighlight: true,
			viewMode: "months",
			minViewMode: "months"

		}).on('changeDate', function (e) {
			table_list(1);
		});

		$('.datepickerYear').datepicker({
			format: 'yyyy',          // Format to display only the year
			autoclose: true,         // Close the datepicker automatically after selection
			todayHighlight: true,    // Highlight the current date
			viewMode: "years",       // Start the view mode as "years"
			minViewMode: "years"     // Set the minimum view mode to "years"
		}).on('changeDate', function (e) {
			table_list(1);            // Call table_list function on date change
		});


		$('#confirm-deactivate').on('show.bs.modal', function (e) {
			$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
		});

		// Detect pagination click
		$('.pagination').on('click', 'a', function (e) {
			e.preventDefault();
			var pageno = $(this).attr('data-ci-pagination-page');
			if (pageno) {
				table_list(pageno);
			}

		});

	});
	table_list(1);
	function table_list(pageno) {
		var formdata = $("#srch_form").serializeArray();
		$("#tbl_list").html("");
		$.ajax({
			url: base_url + "ajax/tbl_upcoming_services_list/" + pageno,
			type: "POST",
			data: formdata,
			datatype: "json",
			async: true,
			cache: false,
			success: function (data) {
				var json_arr = JSON.parse(data);
				var html_data = '';
				var html_data = json_arr.list;
				var total_count = json_arr.total_count;

				$(".total_count").html("( Total - " + total_count + " )");
				$("#tbl_list").html(html_data);
				$('.pagination').html(json_arr.pagination);

			}
		});
	}
</script>

<script>
	$(document).ready(function () {
		const urlParams = new URLSearchParams(window.location.search);

		// When coming from dashboard block
		if (urlParams.get("auto") === "pending_services") {

			// Set dropdown to Pending Services
			$("#pending_upcoming").val("pending_services");

			// Trigger table load
			$("#pending_upcoming").change();  
		}
	});
</script>