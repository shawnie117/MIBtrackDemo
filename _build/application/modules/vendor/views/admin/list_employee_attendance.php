<?php
$vendor  = $this->session->userdata('vendor');
$role_id = $vendor['user_role_id'];
?>
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE BASE CONTENT -->

		<!-- <div class="page-head">
		<div class="page-title">
			<h1><?php echo $page_title; ?></h1>
		</div>	
	</div>
	 -->

		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="row">
						<div class="col-lg-10 col-md-7">
							<span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
							<span class="caption-subject font-red-mint sbold float-right total_count">( Total - 0 )</span>
						</div>
						<div class=" col-lg-2 col-md-5">
							<center>
								<?php if ($role_id == SUPER_ADMIN_ROLE_ID) { ?>
									<span class="btn red btn-outline btn-sm  m-0" id="download_emp_attendance_report" title="Download Employee Attendance Report"><i class="fa fa-download"></i> Download </span>

								<?php } ?>
							</center>
						</div>
					</div>
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
								<?php
								$emp_loc_post_data1       = array();
								$history = $this->input->get('history');
								if ($history == "back") {
									$emp_loc_post_data1 = $this->session->userdata('emp_loc_post_data1');
								}
								?>
								<!-- <div class="row" style="margin:15px 0 10px 0;">

									<div class="col-md-4">
										<div class="alert alert-info text-center">
											<h4 style="margin:0;">
												Total
											</h4>
											<h3 id="total_count" style="margin:5px 0 0 0;">0</h3>
										</div>
									</div>

									<div class="col-md-4">
										<div class="alert alert-success text-center">
											<h4 style="margin:0;">
												Present
											</h4>
											<h3 id="present_count" style="margin:5px 0 0 0;">0</h3>
										</div>
									</div>

									<div class="col-md-4">
										<div class="alert alert-danger text-center">
											<h4 style="margin:0;">
												Absent
											</h4>
											<h3 id="absent_count" style="margin:5px 0 0 0;">0</h3>
										</div>
									</div>

								</div> -->
								<div class="col-md-12" style="max-height:35px">
									<form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">


										<!-- <div class="form-group col-md-3">
											<select class="form-control" id="emp_id" name="emp_id" onchange="table_list(1);">
												<option value=""> Select Employee</option>
												<?php if (!empty($employee_list)) {
													foreach ($employee_list as $employee) {
														$emp_id   = isset($emp_loc_post_data1['emp_id']) ? $emp_loc_post_data1['emp_id'] : "";
														$selected = $emp_id == $employee['emp_id'] ? "selected" : "";
												?>
														<option value="<?php echo $employee['user_id']; ?>" <?php echo $selected; ?>><?php echo $employee['emp_name']; ?></option>
												<?php }
												} ?>
											</select>						 
                        </div>   -->
										<!-- Ritika added this 30 may -->
										<div class="form-group col-md-3">

											<select class="form-control selectpicker"
												id="emp_id"
												name="emp_id"
												data-live-search="true"
												onchange="table_list(1);">

												<option value="">Select Employee</option>

												<?php
												if (!empty($employee_list)) {

													foreach ($employee_list as $employee) {

														$emp_id = isset($emp_loc_post_data1['emp_id'])
															? $emp_loc_post_data1['emp_id']
															: "";

														$selected = ($emp_id == $employee['user_id'])
															? "selected"
															: "";
												?>

														<option value="<?php echo $employee['user_id']; ?>" <?php echo $selected; ?>>
															<?php echo $employee['emp_name']; ?>
														</option>

												<?php
													}
												}
												?>

											</select>

										</div>


										<div class="form-group col-md-2 ">

											<input type="text" class="form-control pull-right datepicker" style="margin-bottom: 15px;" id="date" name="date" placeholder="To Date..." maxlength="10" value="<?php echo isset($emp_loc_post_data1['date']) ? $emp_loc_post_data1['date'] : ""; ?>">

										</div>
										<div class="form-group col-md-2 ">
											<input class="form-control datepickerMY" id="month_year" name="month_year" type="text" placeholder="To Month -Year" maxlength="15" value="<?php echo isset($emp_loc_post_data1['month_year']) ? $emp_loc_post_data1['month_year'] : ""; ?>">
										</div>

										<div class="form-group col-md-2 hidden">

											<input class="form-control" id="searchStr" name="searchStr" type="text" placeholder="Search..." maxlength="100" value="" onchange="table_list(1);">

										</div>
										<div class="form-group col-md-2 ">

											<select id="attendance_status"
													name="attendance_status"
													class="form-control">
												<option value="ALL" selected>All</option>
												<option value="PRESENT">Present</option>
												<option value="ABSENT">Absent</option>
											</select>

										</div>

										<div class="form-group ">
											<a class="btn btn-danger " id="clear_btn" title="Clear Search"><i class=" icon-close"></i></a>
											<a  class="btn btn-success btn-sm" href="<?php echo get_module_path();?>admin/employee_attendance" title="Add"><i class="fa fa-check"></i> Mark Attendance</a> 
											
										</div>

									</form>
								</div>
								<div class="tbl-container">
									<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch" role="grid" aria-describedby="sample_1_info">
										<thead>
											<tr>
												<th width="0.5%">#</th>
												<th width="10%">Employee Name</th>
												<!-- <th width="3%">Emp Img</th> -->
												<th width="10%">Login Image</th>
												<th width="10%">Login Time</th>
												<th id="addressColumn">Login Loc</th>


												<!-- <th width="10%">Date </th>         -->

												<th width="10%">Logout Image</th>
												<th width="10%">Logout Time</th>
												<th id="addressColumn">Logout Loc</th>

												<th width="10%">Status</th>


											</tr>
										</thead>
										<tbody id="tbl_list">

										</tbody>
									</table>
								</div>
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
	$(document).ready(function() {

		$("#download_emp_attendance_report").click(function(e) {
			$('#srch_form').attr("action", base_url + "admin/download_emp_attendance_report");
			$('#srch_form').attr("onsubmit", "");
			$('#srch_form').submit();
			$('#srch_form').attr("action", "");
			$('#srch_form').attr("onsubmit", "return false;");

		});

		$("#form_modal").on("show.bs.modal", function(e) {
			var link = $(e.relatedTarget);
			$(this).data('bs.modal', null);
			$(this).find(".modal-content").load(link.attr("href"));
		});

		$("#clear_btn").click(function(e) {

			$('#srch_form').trigger("reset");

			$('#emp_id').val('');
			$('#emp_id').selectpicker('refresh');

			$('#attendance_status').val('ALL');

			table_list(1);
		});

		$('#confirm-deactivate').on('show.bs.modal', function(e) {
			$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
		});

		$('.datepicker').datepicker({
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

		// Detect pagination click
		$('.pagination').on('click', 'a', function(e) {
			e.preventDefault();
			var pageno = $(this).attr('data-ci-pagination-page');
			if (pageno) {
				table_list(pageno);
			}

		});

		$('#attendance_status').change(function(){
			table_list(1);
		});

		$('#date').change(function () {

			$('#month_year').val('');

			table_list(1);
		});

		$('#month_year').change(function () {

			$('#date').val('');

			table_list(1);
		});

	});
	table_list(1);

	function table_list(pageno) {
		var formdata = $("#srch_form").serializeArray();
		$("#tbl_list").html("");
		$.ajax({
			url: base_url + "ajax/tbl_employee_attendance_list/" + pageno,
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

				// $(".total_count").html("( Total - " + total_count + " )");
				$(".total_count").html(
					"( Total : " + total_count +
					" | Present : " + json_arr.present_count +
					" | Absent : " + json_arr.absent_count +
					" )"
				);
				$("#tbl_list").html(html_data);
				$('.pagination').html(json_arr.pagination);

				$('#present_count').html(json_arr.present_count);
				$('#absent_count').html(json_arr.absent_count);
				$('#total_count').html(json_arr.total_count);

			}
		});
	}
</script>

<!--by kiran dhaije 08-01-25 -->

<script>
	$(document).ready(function() {
		// Create a container for the zoomed image
		var zoomContainer = $('<div id="zoom-container" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7); display: none; z-index: 9999;">' +
			'<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: transparent; padding: 0;">' +
			'<img id="zoomed-image" style="max-width: 90%; max-height: 90%;" />' +
			'<button id="close-zoom" style="position: absolute; top: 10px; right: 10px; background-color: transparent; border: none; color: white; font-size: 24px; font-weight: bold;">&times;</button>' + // Add close button
			'</div>' +
			'</div>').appendTo('body');

		// Handle image clicks for zoom
		$(document).on('click', '.img-responsive', function() {
			var imageUrl = $(this).attr('src');

			// Calculate image dimensions
			var img = new Image();
			img.src = imageUrl;
			img.onload = function() {
				var imgWidth = img.width;
				var imgHeight = img.height;

				// Set maximum dimensions for zoomed image
				var maxWidth = window.innerWidth * 0.8; // 80% of viewport width
				var maxHeight = window.innerHeight * 0.8; // 80% of viewport height

				// Calculate and set zoomed image dimensions
				var zoomedWidth = imgWidth;
				var zoomedHeight = imgHeight;
				if (zoomedWidth > maxWidth) {
					zoomedHeight = zoomedHeight * (maxWidth / zoomedWidth);
					zoomedWidth = maxWidth;
				}
				if (zoomedHeight > maxHeight) {
					zoomedWidth = zoomedWidth * (maxHeight / zoomedHeight);
					zoomedHeight = maxHeight;
				}

				$('#zoomed-image').attr('src', imageUrl);
				$('#zoomed-image').css({
					'width': zoomedWidth + 'px',
					'height': zoomedHeight + 'px'
				}); // Set calculated dimensions

				$('#zoom-container').fadeIn(200); // Fade in the container
			};
		});

		// Handle clicks outside the zoomed image or close button to close it
		$(document).on('click', '#zoom-container, #close-zoom', function(event) {
			if (event.target === this || $(event.target).attr('id') === 'close-zoom') { // Close if clicked outside the image or close button
				$('#zoom-container').fadeOut(200);
			}
		});
	});
</script>
<!-- ritika added this 30 may -->
<script>
  $(document).ready(function() {
    $('.selectpicker').selectpicker();
  });
</script>

<!-- //  <div style="display: flex; justify-content: center; align-items: center; height: 100vh; background-color: white; font-family: Arial, sans-serif;">
//     <div style="text-align: center; font-weight: bold; font-size: 55px;">
//         Kindly Contact Administrator!!!
// </div>
// </div> -->