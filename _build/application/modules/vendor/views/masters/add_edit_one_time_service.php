<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE BASE CONTENT -->

		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<ul class="page-breadcrumb breadcrumb">
						<li><a href="<?php echo base_url(get_module() . "/dashboard") ?>">Home</a><i class="fa fa-circle"></i></li>
						<li><a href="<?php echo base_url(get_module() . "/masters/one_time_service_report") ?>">All One Time Services </a><i class="fa fa-circle"></i></li>
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
								$formaction = "edit_one_time_service/?id=" . base64_encode($id);
							} else {
								$formaction = "add_one_time_service";
							} ?>
							<form action="<?php echo get_module_path() . 'masters/' . $formaction; ?>" id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data">
								<div class="form-body">
									<?php if ($action == "Edit") { ?>
										<input type="hidden" name="id" value="<?php echo $id; ?>">
									<?php } ?>

									<div class="form-group col-md-3">
										<label for="prod_id">Select Product </label>
										<select class="form-control" id="prod_id" name="prod_id">
											<option value=""> Select Product</option>
											<?php if (!empty($product_list)) {
												foreach ($product_list as $product) {
													$product_id =  isset($details['product_id']) ? $details['product_id'] : set_value("prod_id");
													$selected  = $product_id == $product['pm_id'] ? "selected" : "";
											?>
													<option value="<?php echo $product['pm_id']; ?>" <?php echo $selected; ?>><?php echo $product['pm_name']; ?></option>
											<?php }
											} ?>
										</select>

										<?php echo form_error('prod_id', '<span class="text-danger">', '</span>'); ?>
									</div>
									<div class="form-group col-md-3">
										<label for="ots_name">Service Name </label><?php echo REQUIRED_STAR; ?>
										<input class="form-control" id="ots_name" name="ots_name" type="text" placeholder="Enter Service Name" required maxlength="100" value="<?php echo isset($details['ots_name']) ? $details['ots_name'] : set_value('ots_name'); ?>">
										<div id="ots_suggestion_box"
											style="position:absolute; z-index:999; background:#fff; width:95%; border-radius:4px; box-shadow:0 4px 12px rgba(0,0,0,0.15); display:none; margin-top:4px;">
										</div>
										<?php echo form_error('ots_name', '<span class="text-danger">', '</span>'); ?>
									</div>
									<div class="form-group col-md-3">
										<label for="ots_type">Service type </label>
										<input class="form-control" id="ots_type" name="ots_type" type="text" placeholder="Enter Service type" maxlength="50" value="<?php echo isset($details['ots_type']) ? $details['ots_type'] : set_value('ots_type'); ?>">
										<?php echo form_error('ots_type', '<span class="text-danger">', '</span>'); ?>
									</div>

									<div class="form-group col-md-3">
										<label for="ots_desc">Details</label>

										<textarea class="form-control" id="ots_desc" name="ots_desc" placeholder="Enter Details" maxlength="500" cols="6"><?php echo isset($details['ots_desc']) ? $details['ots_desc'] : set_value('ots_desc'); ?></textarea>
										<?php echo form_error('ots_desc', '<span class="text-danger">', '</span>'); ?>
									</div>

									<div class="form-group col-md-3">
										<label for="ots_gst">GST % </label><?php echo REQUIRED_STAR; ?>
										<input class="form-control" id="ots_gst" name="ots_gst" type="number" placeholder="Enter GST %" maxlength="4" value="<?php echo isset($details['ots_gst']) ? $details['ots_gst'] : set_value('ots_gst'); ?>" required>
										<?php echo form_error('ots_gst', '<span class="text-danger">', '</span>'); ?>
									</div>

									<div class="form-group col-md-3">
										<label for="price_regular">Price(Regular) </label><?php echo REQUIRED_STAR; ?>
										<input class="form-control" id="price_regular" name="price_regular" type="text" placeholder="Enter Price(Regular)" maxlength="10" value="<?php echo isset($details['ots_regular']) ? $details['ots_regular'] : set_value('price_regular'); ?>" required>
										<?php echo form_error('price_regular', '<span class="text-danger">', '</span>'); ?>
									</div>
									<div class="form-group col-md-3">
										<label for="price_comm">Price(Commercial) </label><?php echo REQUIRED_STAR; ?>
										<input class="form-control" id="price_comm" name="price_comm" type="text" placeholder="Enter Price(Commercial)" maxlength="10" value="<?php echo isset($details['ots_commerial']) ? $details['ots_commerial'] : set_value('price_comm'); ?>" required>
										<?php echo form_error('price_comm', '<span class="text-danger">', '</span>'); ?>
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
										<div class="form-group col-md-6">
											<label for="p_multi_image"><small></small> Feature Images &nbsp; (Upload multiple feature images) </label>
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
											<?php $ots_img      = $details['ots_img'];
											$ots_img      = str_replace("getAuthApiKey", APIKEY, $ots_img); ?>
											<label for="p_image">Product Image </label><br>
											<input type="file" name="p_image" id="p_image"
												class="smart-file"
												data-label="Product Image"
												data-btn-class="btn btn-default btn-sm"
												data-preview="on"
												data-file-types="image/jpeg,image/png,image/jpg" accept="image/*" />
											<?php echo form_error('p_image', '<span class="text-danger">', '</span>'); ?>

											<ul class="list-unstyled small fileList thumbs">
												<li><img title="" src="<?php echo $ots_img; ?>" class="img-rounded"><span class="file-name"></span></li>
											</ul>

											<span class="file_err"></span>
										</div>
										<div class="form-group col-md-6">
											<?php $imageList    = $details['ostImageList']; ?>
											<label for="p_multi_image"><small>(Upload multiple feature images)</small> <br />Feature Images </label>
											<input type="file" name="p_multi_image[]" id="p_multi_image"
												class="smart-file"
												data-label="Feature Images" data-btn-class="btn btn-default btn-sm" data-preview="on"
												data-file-types="image/jpeg,image/png,image/jpg" accept="image/*" multiple />
											<?php echo form_error('p_multi_image', '<span class="text-danger">', '</span>'); ?>

											<ul class="list-unstyled small fileList thumbs hidden">

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
									<div class=" col-md-12">
										<center>
											<button class="btn btn-success" id="mybutton" type="submit">Submit</button>
											<a href="<?php echo get_module_path(); ?>masters/one_time_service_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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

<script type="text/javascript">
	// Add Branch

	$("#ots_name").on("keyup", function() {

		let keyword = $(this).val().toLowerCase();
		let html = "";

		if (keyword.length >= 1) {
			$.ajax({
				url: base_url + "ajax/search_ots_name",
				type: "POST",
				data: {
					keyword: keyword
				},
				success: function(response) {

					// Ignore an old name search once the user moves to another field.
					if (!$("#ots_name").is(":focus") || $("#ots_name").val().toLowerCase() !== keyword) {
						return;
					}

					if (response.trim() != "") {
						html = `<div style="padding: 8px 12px; font-size: 11px; font-weight: 600; color: #888; background: #f8f9fa; border-bottom: 1px solid #eee; border-radius: 4px 4px 0 0; text-transform: uppercase; letter-spacing: 0.5px;">Existing AMC </div>`;
						$("#ots_suggestion_box").html(html + response).show();
					} else {
						html = `<div style="padding: 10px 12px; color: #28a745; font-size: 13px; display: flex; align-items: center;">
                            <i class="fa fa-check-circle" style="margin-right: 8px; font-size: 14px;"></i> No Match Found
                        </div>`;
						$("#ots_suggestion_box").html(html).show();
					}
				}
			});

		} else {
			$("#ots_suggestion_box").hide();
		}
	});


	$("#ots_name").on("blur", function() {
		$("#ots_suggestion_box").hide();
	});

	// Hide suggestion box when clicking outside
	$(document).on("click", function(event) {
		if (!$(event.target).closest("#ots_name, #ots_suggestion_box").length) {
			$("#ots_suggestion_box").hide();
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
				ots_name: {
					required: true,
					maxlength: 100,
					minlength: 2,
				},
				ots_type: {
					maxlength: 50,
				},
				ots_desc: {
					maxlength: 500,
				},
				ots_gst: {
					maxlength: 4,
					number: true,
				},
				price_regular: {
					maxlength: 10,
					number: true,
				},
				price_comm: {
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
						//required: true,
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

	function delete_image(obj) {
		var id = $(obj).attr("data-id");
		$('#image_li_' + id).remove();

	}
</script>
