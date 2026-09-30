<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE BASE CONTENT -->

		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<ul class="page-breadcrumb breadcrumb">
						<li><a href="<?php echo base_url(get_module() . "/dashboard") ?>">Home</a><i class="fa fa-circle"></i></li>
						<li><a href="<?php echo base_url(get_module() . "/masters/amc_report") ?>">All AMC Service Report </a><i class="fa fa-circle"></i></li>
						<li><span class="active"><?php echo $page_title; ?></span></li>
					</ul>
					<?php $icon = "icon-plus";
					if ($action == "Edit") {
						$icon = "icon-pencil";
					}  ?>
					<div class="portlet-title">
						<div class="caption">
							<i class="font-red-mint <?php echo $icon; ?> "></i>
							<span class="caption-subject font-green-sharp bold"><?php echo $page_title; ?></span>
						</div>

					</div>
					<div class="row">

						<div class="portlet-body form">
							<?php if ($action == "Edit") { //echo "<pre/>"; print_r($details);die;
								$details = html_escape($details);
								$formaction = "edit_amc/?id=" . base64_encode($id);
							} else {
								$formaction = "add_amc";
							} ?>
							<form action="<?php echo get_module_path() . 'masters/' . $formaction; ?>" id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data">
								<div class="form-body">
									<?php if ($action == "Edit") { ?>
										<input type="hidden" name="id" value="<?php echo $id; ?>">
									<?php } ?>

									<div class="form-group col-md-3">
										<label for="amc_product_id">Select Product </label>
										<select class="form-control" id="amc_product_id" name="amc_product_id">
											<option value=""> Select Product</option>
											<?php if (!empty($product_list)) {
												foreach ($product_list as $product) {
													$product_id = isset($details['product_id']) ? $details['product_id'] : "";
													$selected = $product_id == $product['pm_id'] ? "selected" : "";
											?>
													<option value="<?php echo $product['pm_id']; ?>" <?php echo $selected; ?>><?php echo $product['pm_name']; ?></option>
											<?php }
											} ?>
										</select>

										<?php echo form_error('amc_product_id', '<span class="text-danger">', '</span>'); ?>
									</div>
									<div class="form-group col-md-3">
										<label for="amc_name">AMC Name </label><?php echo REQUIRED_STAR; ?>
										<input class="form-control" id="amc_name" name="amc_name" type="text" placeholder="Enter AMC Name" required maxlength="100" value="<?php echo isset($details['amc_name']) ? $details['amc_name'] : set_value('amc_name'); ?>">
										<div id="amc_suggestion_box"
											style="position:absolute; z-index:999; background:#fff; width:95%; border-radius:4px; box-shadow:0 4px 12px rgba(0,0,0,0.15); display:none; margin-top:4px;">
										</div>
										<?php echo form_error('amc_name', '<span class="text-danger">', '</span>'); ?>
									</div>
									<div class="form-group col-md-3">
										<label for="amc_desc">AMC Description </label>

										<input class="form-control" id="amc_desc" name="amc_desc" type="text" placeholder="Enter AMC Description" maxlength="1000" value="<?php echo isset($details['amc_desc']) ? $details['amc_desc'] : set_value('amc_desc'); ?>">
										<?php echo form_error('amc_desc', '<span class="text-danger">', '</span>'); ?>
									</div>
									<div class="form-group col-md-3">
										<label for="amc_duration">AMC Duration </label><?php echo REQUIRED_STAR; ?>
										<input class="form-control" required maxlength="4" id="amc_duration" name="amc_duration" list="all_amc_duration" placeholder="Select AMC Duration In Days" autocomplete="off" value="<?php echo isset($details['amc_duration']) ? $details['amc_duration'] : set_value('amc_duration'); ?>" onchange="get_sit();" />

										<datalist id="all_amc_duration">
											<?php if (!empty($duration_list)) {
												foreach ($duration_list as $key => $duration) { ?>
													<option value="<?php echo $key; ?>" label="<?php echo $duration; ?>"></option>
											<?php }
											} ?>
										</datalist>
										<?php echo form_error('amc_duration', '<span class="text-danger">', '</span>'); ?>
									</div>

									<div class="form-group col-md-3">
										<label for="amc_noofservices">No. Of Services </label><?php echo REQUIRED_STAR; ?>

										<input class="form-control" id="amc_noofservices" name="amc_noofservices" type="number" min="1" step="1" placeholder="Enter No. Of Services" maxlength="3" value="<?php echo isset($details['amc_noofservices']) ? $details['amc_noofservices'] : set_value('amc_noofservices'); ?>" onchange="get_sit();" required>
										<?php echo form_error('amc_noofservices', '<span class="text-danger">', '</span>'); ?>
									</div>

									<div class="form-group col-md-3">
										<label for="amc_sit">Service Interval Time </label>
										<input class="form-control" id="amc_sit" name="amc_sit" type="text" placeholder="Enter Service Interval Time in Days" maxlength="4" value="<?php echo isset($details['amc_sit']) ? $details['amc_sit'] : set_value('amc_sit'); ?>" readonly>
										<?php echo form_error('amc_sit', '<span class="text-danger">', '</span>'); ?>
									</div>


									<div class="form-group col-md-3">
										<label for="amc_gst">GST % </label><?php echo REQUIRED_STAR; ?>
										<input class="form-control" id="amc_gst" name="amc_gst" type="number" min="1" step="1" placeholder="Enter GST %" maxlength="4" value="<?php echo isset($details['amc_gst']) ? $details['amc_gst'] : set_value('amc_gst'); ?>" required>
										<?php echo form_error('amc_gst', '<span class="text-danger">', '</span>'); ?>
									</div>

									<div class="form-group col-md-3">
										<label for="amc_price">Price(Regular) </label><?php echo REQUIRED_STAR; ?>
										<input class="form-control" id="amc_price" name="amc_price" type="number" min="1" step="1" placeholder="Enter Price(Regular)" maxlength="10" value="<?php echo isset($details['amc_price']) ? $details['amc_price'] : set_value('amc_price'); ?>" required>
										<?php echo form_error('amc_price', '<span class="text-danger">', '</span>'); ?>
									</div>

									<div class="form-group col-md-3">
										<label for="amc_corporate_price">Price(Commercial) </label><?php echo REQUIRED_STAR; ?>
										<input class="form-control" id="amc_corporate_price" name="amc_corporate_price" type="number" min="1" step="1" placeholder="Enter Price(Commercial)" maxlength="10" value="<?php echo isset($details['amc_corporate_price']) ? $details['amc_corporate_price'] : set_value('amc_corporate_price'); ?>" required>
										<?php echo form_error('amc_corporate_price', '<span class="text-danger">', '</span>'); ?>
									</div>
									<?php if ($action == "Add") {  ?>
										<div class="form-group col-md-3">
											<label for="p_image">Product Image </label><br>
											<input type="file" name="p_image" id="p_image"
												class="smart-file"
												data-label="Product Image"
												data-btn-class="btn btn-default btn-sm"
												data-preview="on"
												data-file-types="image/jpeg,image/png,image/jpg" accept="image/*" />
											<?php echo form_error('p_image', '<span class="text-danger">', '</span>'); ?>
											<span class="file_err"></span>
										</div>
										<div class="form-group col-md-5">
											<label for="p_multi_image">Feature Images &nbsp; <small>(Upload multiple feature images)</small> </label><br>
											<input type="file" name="p_multi_image[]" id="p_multi_image"
												class="smart-file"
												data-label="Feature Images"
												data-btn-class="btn btn-default btn-sm"
												data-preview="on"
												data-file-types="image/jpeg,image/png,image/jpg" accept="image/*" multiple />
											<?php echo form_error('p_multi_image', '<span class="text-danger">', '</span>'); ?>
											<span class="file_err"></span>
										</div>
									<?php } ?>

									<?php if ($action == "Edit") {  ?>
										<div class="form-group col-md-3">
											<?php $image      = $details['product_image'];
											$image      = str_replace("getAuthApiKey", APIKEY, $image); ?>
											<label for="p_image">Product Image </label>
											<input type="file" name="p_image" id="p_image"
												class="smart-file"
												data-label="Product Image"
												data-btn-class="btn btn-default btn-sm"
												data-preview="on"
												data-file-types="image/jpeg,image/png,image/jpg" accept="image/*" />
											<?php echo form_error('p_image', '<span class="text-danger">', '</span>'); ?>

											<ul class="list-unstyled small fileList thumbs">
												<li><img title="" src="<?php echo $image; ?>" class="img-rounded"><span class="file-name"></span></li>
											</ul>

											<span class="file_err"></span>
										</div>
										<div class="form-group col-md-5">
											<?php $imageList    = $details['amcImageList']; ?>
											<label for="p_multi_image"><small>(Upload multiple feature images)</small> <br />Feature Images </label>
											<input type="file" name="p_multi_image[]" id="p_multi_image"
												class="smart-file"
												data-label="Feature Images" data-btn-class="btn btn-default btn-sm" data-preview="on"
												data-file-types="image/jpeg,image/png,image/jpg" accept="image/*" multiple />
											<?php echo form_error('p_multi_image', '<span class="text-danger">', '</span>'); ?>

											<ul class="list-unstyled small fileList thumbs">

												<?php if (!empty($imageList)) {
													foreach ($imageList as $key => $image) {
														$image1      = $image['pid_img_path'];
														$image1     = str_replace("getAuthApiKey", APIKEY, $image1);
														$image_name_arr = explode("/", $image1);
														$image_name = end($image_name_arr);
												?>

														<li id="image_li_<?php echo $key; ?>"><input type="hidden" name="old_imgs[]" value="<?php echo $image_name; ?>" /><img title="" src="<?php echo $image1; ?>" class="img-rounded"><span class="file-name"></span> <input type="button" data-id="<?php echo $key; ?>" value="×" class="btn btn-danger btn-xs" onclick="delete_image(this)" title="Delete Image" style="float:right;"></li>
												<?php }
												} ?>
											</ul>
											<span class="file_err"></span>
										</div>
									<?php } ?>


								</div>
								<div class="form-actions">
									<div class="col-lg-12">
										<center>
											<button class="btn btn-success" id="mybutton" type="submit">Submit</button>
											<a href="<?php echo get_module_path(); ?>masters/amc_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
										</center>
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
<script>
	var amcList = <?php echo json_encode($amc_list); ?>;
</script>
<script type="text/javascript">
	// Add Branch

	$("#amc_name").on("keyup", function() {

		let keyword = $(this).val().toLowerCase();
		let html = "";

		if (keyword.length >= 1) {

			let filtered = amcList.filter(item =>
				item.amc_name.toLowerCase().includes(keyword)
			);

			if (filtered.length > 0) {
				html += `<div style="padding: 8px 12px; font-size: 11px; font-weight: 600; color: #888; background: #f8f9fa; border-bottom: 1px solid #eee; border-radius: 4px 4px 0 0; text-transform: uppercase; letter-spacing: 0.5px;">Existing AMC </div>`;
				filtered.forEach(item => {
					html += `<div style="padding: 10px 12px; color: #444; border-bottom: 1px solid #f1f1f1; font-size: 13px; display: flex; align-items: center;">
                                <i class="fa fa-info-circle font-blue" style="margin-right: 8px; font-size: 14px;"></i> ${item.amc_name}
                             </div>`;
				});
			} else {
				html = `<div style="padding: 10px 12px; color: #28a745; font-size: 13px; display: flex; align-items: center;">
                            <i class="fa fa-check-circle" style="margin-right: 8px; font-size: 14px;"></i> No Match Found
                        </div>`;
			}

			$("#amc_suggestion_box").html(html).show();

		} else {
			$("#amc_suggestion_box").hide();
		}
	});

	// Hide suggestion box when clicking outside
	$(document).on("click", function(event) {
		if (!$(event.target).closest("#amc_name, #amc_suggestion_box").length) {
			$("#amc_suggestion_box").hide();
		}
	});

	$(document).ready(function() {

		$('.smart-file').bootstrapFileField({
			maxNumFiles: 8,
			fileTypes: 'image/jpeg,image/png,image/jpg',
			maxFileSize: 4000000 // 8Mb in bytes */
		});

		$("#add_edit_form").validate({
			rules: {
				required: {
					required: true
				},
				amc_name: {
					required: true,
					maxlength: 100,
					minlength: 2,
				},
				amc_duration: {
					required: true,
					maxlength: 4,
					digits: true,
				},
				amc_desc: {
					maxlength: 1000,
				},
				amc_noofservices: {
					required: true,
					maxlength: 3,
					digits: true,
				},
				// amc_sit: {
				// 	required: true,
				// 	maxlength: 4,
				// 	digits:true,
				// 	 },
				ots_gst: {
					maxlength: 4,
					number: true,
				},
				amc_price: {
					maxlength: 10,
					number: true,
				},
				amc_corporate_price: {
					maxlength: 10,
					number: true,
				},
				p_image: {
					<?php if ($action == "Add") {  ?>
						// required: true,
					<?php  } ?>
					accept: "image/jpeg,image/png,image/jpg",
					filesize_max: 1000000, // 1 MB
					filesize_min: 10000, // 1 KB
				},
				"p_multi_image[]": {
					<?php if ($action == "Add") {  ?>
						// required: true,
					<?php  } ?>
					accept: "image/jpeg,image/png,image/jpg",
					filesize_max: 1000000, // 1 MB
					filesize_min: 10000, // 1 KB
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
			success: function(error) {
				error.removeClass("error"); // <- no, no, no!!
			},
		});
	});

	function get_sit() {
		var duration = $("#amc_duration").val();
		var services = $("#amc_noofservices").val();
		if (!services) {
			services = 1;
		}
		if (!duration) {
			duration = 1;
		}
		var sit = parseInt(duration) / parseInt(services);
		sit = Math.ceil(sit);
		$("#amc_sit").val(sit);
	}

	function delete_image(obj) {
		var id = $(obj).attr("data-id");
		$('#image_li_' + id).remove();

	}
</script>