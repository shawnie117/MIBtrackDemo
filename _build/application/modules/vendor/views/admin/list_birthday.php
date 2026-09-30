<?php
$vendor = $this->session->userdata('vendor');
$role_id = $vendor['user_role_id'];
?>

<div class="page-content-wrapper">

	<div class="page-content">

		<div class="row">

			<div class="col-md-12">

				<div class="portlet light bordered">

					<div class="col-lg-8 col-md-6">

						<span class="caption-subject font-green-sharp sbold">
							<?php echo $page_title; ?>
						</span>

						<span class="caption-subject font-red-mint sbold float-right total_count">
							( Total - 0 )
						</span>

					</div>

					<div class="row">

						<div class="col-md-12">

							<div class="portlet-body">

								<?php
								$this->load->helper('form');

								$error = $this->session->flashdata('error');

								if ($error) {
									?>

									<div class="alert alert-danger alert-dismissable">

										<button type="button" class="close" data-dismiss="alert"
											aria-hidden="true">×</button>

										<?php echo $error; ?>

									</div>

								<?php } ?>

								<?php
								$success = $this->session->flashdata('success');

								if ($success) {
									?>

									<div class="alert alert-success alert-dismissable">

										<button type="button" class="close" data-dismiss="alert"
											aria-hidden="true">×</button>

										<?php echo $success; ?>

									</div>

								<?php } ?>

								<?php

								$birthday_post_data = array();

								$history = $this->input->get('history');

								if ($history == "back") {
									$birthday_post_data =
										$this->session->userdata(
											'birthday_post_data'
										);
								}

								?>

								<div class="col-md-12">

									<form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">

										<!-- SEARCH -->

										<div class="form-group col-md-3">

											<input class="form-control" id="searchStr_name" name="searchStr_name"
												type="text" placeholder="Search Name..." maxlength="100"
												value="<?php echo isset($birthday_post_data['searchStr_name']) ? $birthday_post_data['searchStr_name'] : ""; ?>"
												onchange="table_list(1);">

										</div>

										<!-- DATE -->

										<div class="form-group col-md-2">

											<input type="date" class="form-control" id="selected_date"
												name="selected_date"
												value="<?php echo isset($birthday_post_data['selected_date']) ? $birthday_post_data['selected_date'] : date('Y-m-d'); ?>"
												onchange="table_list(1);">

										</div>
										<!-- <div class="form-group col-md-2">

    <input type="text"
           class="form-control datepickerMY"
           id="selected_month"
           name="selected_month"
           placeholder="Select Month">

</div> -->

										<!-- TYPE -->

										<!-- <div class="form-group col-md-2">

											<select class="form-control" id="birthday_type" name="birthday_type"
												onchange="table_list(1);">

												<option value="">Birthday Type</option>

												<option value="Today">Today</option>

												<option value="Tomorrow">Tomorrow</option>

											</select>

										</div> -->

										<!-- PERSON TYPE -->

										<div class="form-group col-md-2">

											<select class="form-control" id="person_type" name="person_type"
												onchange="table_list(1);">

												<option value="">Person Type</option>

												<option value="Employee">Employee</option>

												<option value="Customer">Customer</option>

												<option value="Lead">Lead</option>

											</select>

										</div>
										
										
										<div class="form-group col-md-1">

											<a class="btn btn-danger"
											id="clear_btn"
											title="Clear Search"
											onclick="clear_filters();">

												<i class="icon-close"></i>

											</a>

										</div>

									</form>

								</div>

								<table class="table table-striped table-bordered table-hover no-footer">

									<thead>

										<tr>

											<th width="10%">Sr No</th>

											<th>Name</th>

											<th width="12%">Type</th>

											<th width="15%">Contact</th>

											<th width="12%">DOB</th>

											<!-- <th width="12%">Birthday</th> -->

										</tr>

									</thead>

									<tbody id="tbl_list">

									</tbody>

								</table>

								<div class="pagination" style="float:right;">

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript">

	$(document).ready(function () {

		$('.pagination').on('click', 'a', function (e) {

			e.preventDefault();

			var pageno =
				$(this).attr(
					'data-ci-pagination-page'
				);

			if (pageno) {

				table_list(pageno);
			}

		});

		$('.datepickerMY').datepicker({
    format: 'mm-yyyy',
    autoclose: true,
    todayHighlight: true,
    viewMode: "months",
    minViewMode: "months"
});



$('.datepickerMY').on(
    'changeDate',
    function(e) {
        table_list(1);
    }
);

	});

	table_list(1);

	function table_list(pageno) {
		var formdata =
			$("#srch_form").serializeArray();

		$("#tbl_list").html("");

		$.ajax({

			url:
				base_url +
				"ajax/tbl_birthday_reminder_list/" +
				pageno,

			type: "POST",

			data: formdata,

			datatype: "json",

			async: true,

			cache: false,

			success: function (data) {
				var json_arr = JSON.parse(data);

				var html_data = json_arr.list;

				var total_count =
					json_arr.total_count;

				$(".total_count").html(
					"( Total - " +
					total_count +
					" )"
				);

				$("#tbl_list").html(
					html_data
				);

				$('.pagination').html(
					json_arr.pagination
				);
			}
		});
	}
	function clear_filters()
{
    $("#searchStr_name").val("");

    $("#selected_date").val(
        "<?php echo date('Y-m-d'); ?>"
    );

    $("#selected_month").val("");

    $("#person_type").val("");

    table_list(1);
}

</script>