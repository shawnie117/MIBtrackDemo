<?php
$vendor  = $this->session->userdata('vendor');
$role_id = $vendor['user_role_id'];
?>
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
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
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
											<?php echo $this->session->flashdata('error'); ?>
										</div>
									<?php } ?>
									<?php
									$success = $this->session->flashdata('success');
									if ($success) {
									?>
										<div class="alert alert-success alert-dismissable">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
											<?php echo $this->session->flashdata('success'); ?>
										</div>
									<?php } ?>

								</div>

								<!-- <div class="form-group col-md-2">
									<button type="button" class="btn btn-primary" onclick="view_route()">
										<i class="fa fa-map-marker"></i> View Route
									</button>
								</div> -->
								<div class="col-md-12">
									<form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
										<div class="form-group col-md-3">
											<input type="text" class="form-control pull-right datepicker" id="date" name="date" placeholder="Date" maxlength="10" value="<?php echo isset($emp_loc_post_data['date']) && !empty($emp_loc_post_data['date']) ? $emp_loc_post_data['date'] : date('d-m-Y'); ?>">
										</div>
										
										<div class="form-group" style="display:flex;">
											<a class="btn btn-danger btn-sm" id="clear_btn" title="Clear Search">
												<i class="icon-close"></i>
											</a>
										</div>
									</form>
								</div>
								<div class="tbl-container">
									<table class="table table-striped table-bordered table-hover  dataTable no-footer dtr-inline  tbl_data_table_no_srch" id="Srtable" role="grid" aria-describedby="sample_1_info">
										<thead>
											<tr>
												<th width="2%">Sr. No.</th>
												<th width="20%">Employee Name</th>
												<th width="10%">Date & Time</th>
												<th>Address</th>
												<th>Location</th>
												<th>live location</th>
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

									#Srtable {
										width: 619px;
									}

									#i-frame {
										height: 100px;
										width: 100px;
										text-align: center;
									}
								}
							</style>
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
<div class="modal fade" id="route_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>

				<h4 class="modal-title">
					<span id="route_title">Employee Route</span>
					<span class="pull-right">
						<small>
							Distance:
							<span id="total_distance">0 KM</span>
						</small>
					</span>
				</h4>
			</div>

			<div class="modal-body">
				<div id="map" style="height:450px;width:100%"></div>
			</div>

		</div>
	</div>
</div>
<div class="modal fade" id="msg_modal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header bg-warning">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Alert</h4>
            </div>

            <div class="modal-body">
                <p id="msg_modal_text"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    OK
                </button>
            </div>

        </div>
    </div>
</div>
<!--END START MODAL -->

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $key; ?>&libraries=places"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#form_modal").on("show.bs.modal", function(e) {
			var link = $(e.relatedTarget);
			$(this).data('bs.modal', null);
			$(this).find(".modal-content").load(link.attr("href"));
		});

		$("#clear_btn").click(function(e) {
			$('#date, #emp_id').val('');
			$('#srch_form').trigger("reset");
			$("#date").val('<?php echo date("d-m-Y"); ?>');
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

		// Detect pagination click
		$('.pagination').on('click', 'a', function(e) {
			e.preventDefault();
			var pageno = $(this).attr('data-ci-pagination-page');
			if (pageno) {
				table_list(pageno);
			}
		});
		$('#route_modal').on('hidden.bs.modal', function () {

			$("#route_title").html("Employee Route");
			$("#total_distance").html("0 KM");
			$("#map").html("");

		});

	});
	table_list(1);
	function showMessage(msg)
	{
		$("#msg_modal_text").html(msg);
		$("#msg_modal").modal("show");
	}


	function table_list(pageno) {
		var formdata = $("#srch_form").serializeArray();
		$("#tbl_list").html("");
		$.ajax({
			url: base_url + "ajax/tbl_employee_current_location_list/" + pageno,
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

			}
		});
	}

	// function view_route() {

	// 	var emp_id = $("#emp_id").val();
	// 	var from_date = $("#from_date").val();
	// 	var date = $("#date").val();

	// 	$.ajax({
	// 		url: base_url + "ajax/get_employee_route",
	// 		type: "POST",
	// 		data: {
	// 			emp_id: emp_id,
	// 			from_date: from_date,
	// 			date: date
	// 		},
	// 		dataType: "json",
	// 		success: function(res) {

	// 			if (!res || res.length === 0) {
	// 				alert("No location data available");
	// 				return;
	// 			}

	// 			$('#route_modal').modal('show');

	// 			drawRoute(res);

	// 		}
	// 	});

	// }

	function view_route(emp_id, emp_name) {

		$("#route_title").html(
			"Employee Route - " + emp_name
		);

		var date = $("#date").val();
		$.ajax({
			url: base_url + "ajax/get_employee_route",
			type: "POST",
			data: {
				emp_id: emp_id,
				from_date: date,
				date: date
			},
			dataType: "json",
			// success: function(res) {
			// 	if (!res || res.length === 0) {
			// 		alert("No location data available");
			// 		return;
			// 	}
			// 	$('#route_modal').modal('show');
			// 	drawRoute(res);
			// }
			success: function(res) {

				if (!res || res.length < 2) {
					$("#map").html("");
					$("#total_distance").html("0 KM");
					// alert("At least 2 valid locations are required.");
					showMessage("Route cannot be displayed because less than 2 location points were found.");
					return;
				}

				$('#route_modal').modal('show');
				drawRoute(res);
			}
		});
	}

	function drawRoute(locations) {

		$("#map").html(""); // clear previous map
		$("#total_distance").html("0 KM");

		if (!locations || locations.length === 0) {
			$('#route_modal').modal('hide');
			// alert("No location data available");
			showMessage("No location data available.");
			return;
		}

		var routeCoordinates = [];

		locations.forEach(function(loc) {

			var lat = parseFloat(loc.latt);
			var lng = parseFloat(loc.longt);

			if (!isNaN(lat) && !isNaN(lng)) {
				routeCoordinates.push({
					lat: lat,
					lng: lng,
					data: loc
				});
			}
		});

		if (routeCoordinates.length < 2) {
			$("#map").html("");
    		$("#total_distance").html("0 KM");
			
			$('#route_modal').modal('hide');

			// alert("At least 2 valid locations are required.");
			showMessage(
				"Route cannot be displayed because less than 2 location points were found."
			);
			return;
		}

		var map = new google.maps.Map(
			document.getElementById("map"), {
				zoom: 13,
				center: routeCoordinates[0]
			}
		);

		var bounds = new google.maps.LatLngBounds();

		routeCoordinates.forEach(function(point, index) {

			bounds.extend(point);

			var marker = new google.maps.Marker({
				position: point,
				map: map,
				label: (index + 1).toString()
			});

			var infoWindow = new google.maps.InfoWindow({
				content: "<div>" +
					"<b>Point #" + (index + 1) + "</b><br>" +
					"<b>Date:</b> " + point.data.mobile_date + "<br>" +
					"<b>Time:</b> " + point.data.mobile_time + "<br>" +
					"<b>Address:</b> " + point.data.address +
					"</div>"
			});

			marker.addListener("click", function() {
				infoWindow.open(map, marker);
			});
		});

		map.fitBounds(bounds);

		/*
		 * Google Directions API supports
		 * origin + destination + 23 waypoints
		 * so limit route points
		 */
		var reducedPoints = [];

		if (routeCoordinates.length <= 25) {

			reducedPoints = routeCoordinates;

		} else {

			var step = Math.ceil(routeCoordinates.length / 25);

			for (var i = 0; i < routeCoordinates.length; i += step) {
				reducedPoints.push(routeCoordinates[i]);
			}

			if (
				reducedPoints[reducedPoints.length - 1] !==
				routeCoordinates[routeCoordinates.length - 1]
			) {
				reducedPoints.push(
					routeCoordinates[routeCoordinates.length - 1]
				);
			}
		}

		var origin = reducedPoints[0];

		var destination =
			reducedPoints[reducedPoints.length - 1];

		var waypoints = [];

		for (
			var i = 1; i < reducedPoints.length - 1; i++
		) {

			waypoints.push({
				location: new google.maps.LatLng(
					reducedPoints[i].lat,
					reducedPoints[i].lng
				),
				stopover: true
			});
		}

		var directionsService =
			new google.maps.DirectionsService();

		var directionsRenderer =
			new google.maps.DirectionsRenderer({
				suppressMarkers: true,
				preserveViewport: false
			});

		directionsRenderer.setMap(map);

		directionsService.route({
				origin: origin,
				destination: destination,
				waypoints: waypoints,
				optimizeWaypoints: false,
				travelMode: google.maps.TravelMode.DRIVING
			},
			function(result, status) {

				if (
					status ===
					google.maps.DirectionsStatus.OK
				) {

					directionsRenderer.setDirections(
						result
					);

					var totalDistance = 0;
					var totalDuration = 0;

					result.routes[0].legs.forEach(
						function(leg) {

							totalDistance +=
								leg.distance.value;

							totalDuration +=
								leg.duration.value;
						}
					);

					$("#total_distance").html(
						(totalDistance / 1000).toFixed(2) +
						" KM (" +
						Math.round(
							totalDuration / 60
						) +
						" mins)"
					);

				} else {

					/*
					 * Fallback
					 */

					var distance = 0;

					for (
						var i = 1; i < routeCoordinates.length; i++
					) {

						distance += calculateDistance(
							routeCoordinates[i - 1].lat,
							routeCoordinates[i - 1].lng,
							routeCoordinates[i].lat,
							routeCoordinates[i].lng
						);
					}

					$("#total_distance").html(
						distance.toFixed(2) +
						" KM (Approx.)"
					);
				}
			}
		);
	}

	function calculateDistance(lat1, lon1, lat2, lon2) {

		var R = 6371;

		var dLat = (lat2 - lat1) * Math.PI / 180;
		var dLon = (lon2 - lon1) * Math.PI / 180;

		var a =
			Math.sin(dLat / 2) * Math.sin(dLat / 2) +
			Math.cos(lat1 * Math.PI / 180) *
			Math.cos(lat2 * Math.PI / 180) *
			Math.sin(dLon / 2) * Math.sin(dLon / 2);

		var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

		return R * c;
	}

	function employee_selected() {
		var emp_id = $("#emp_id").val();

		if (emp_id !== "") {
			$("#route_btn_container").show();
		} else {
			$("#route_btn_container").hide();
		}
	}
</script>