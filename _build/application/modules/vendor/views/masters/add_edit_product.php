<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE BASE CONTENT -->

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <ul class="page-breadcrumb breadcrumb">
                        <li><a href="<?php echo base_url(get_module() . "/dashboard") ?>">Home</a><i class="fa fa-circle"></i></li>
                        <li><a href="<?php echo base_url(get_module() . "/masters/sale_product_report") ?>">All Product Report </a><i class="fa fa-circle"></i></li>
                        <li><span class="active"><?php echo $page_title; ?></span></li>
                    </ul>
                    <div class="pull-right">
                        <a class="btn btn-success btn-sm " href="<?php echo get_module_path(); ?>masters/brand_report" title="Add"><i class="fa fa-plus"></i>Brand Report</a>
                        <!-- <span  class="btn red btn-outline btn-sm"  id="download_amc_report" title="Download AMC Report"><i class="fa fa-download"></i> Download </span>  -->
                    </div>
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
                                $formaction = "edit_sale_product/?id=" . base64_encode($id);
                            } else {
                                $formaction = "add_sale_product";
                            } ?>
                            <form action="<?php echo get_module_path() . 'masters/' . $formaction; ?>" id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data">
                                <div class="form-body">
                                    <center>
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
                                    </center>

                                    <?php if ($action == "Edit") { ?>
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <?php } ?>

                                    <div class="form-group col-md-12">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="p_brand_id">Select Brand</label>
                                                <select class="form-control" id="p_brand_id" name="p_brand_id">
                                                    <option value="">Select Brand</option>
                                                    <?php if (!empty($brand_list)) {
                                                        foreach ($brand_list as $brand) {
                                                            $brand_id = isset($details['pdt_brnd_id']) ? $details['pdt_brnd_id'] : set_value("p_brand_id");
                                                            $selected = $brand_id == $brand['pdt_brnd_id'] ? "selected" : "";
                                                    ?>
                                                            <option value="<?php echo $brand['pdt_brnd_id']; ?>" <?php echo $selected; ?>>
                                                                <?php echo $brand['pdt_brnd_name']; ?>
                                                            </option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                                <?php echo form_error('p_brand_id', '<span class="text-danger">', '</span>'); ?>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <br />
                                                <a data-toggle="modal" data-target="#form_modal" class="btn btn-success" href="<?php echo get_module_path(); ?>masters/add_brand/?url=<?php echo $formaction; ?>" title="Add Brand">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="pdt_name">Product Name</label><?php echo REQUIRED_STAR; ?>
                                                <input class="form-control" id="pdt_name" name="pdt_name" type="text" placeholder="Enter Product Name" required maxlength="250" value="<?php echo isset($details['pm_name']) ? $details['pm_name'] : set_value('pdt_name'); ?>">
                                                <div id="pdt_suggestion_box"
                                                    style="position:absolute; z-index:999; background:#fff; width:95%; border-radius:4px; box-shadow:0 4px 12px rgba(0,0,0,0.15); display:none; margin-top:4px;">
                                                </div>
                                                <?php echo form_error('pdt_name', '<span class="text-danger">', '</span>'); ?>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="p_model_name">Model</label>
                                                <input class="form-control" id="p_model_name" name="p_model_name" type="text" placeholder="Enter Model" maxlength="250" value="<?php echo isset($details['pm_model_name']) ? $details['pm_model_name'] : set_value('p_model_name'); ?>" onchange="get_sit();">
                                                <?php echo form_error('p_model_name', '<span class="text-danger">', '</span>'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="pdt_desc">Details </label>
                                        <input class="form-control" id="pdt_desc" name="pdt_desc" type="text" placeholder="Enter Details" maxlength="500" value="<?php echo isset($details['pm_desc']) ? $details['pm_desc'] : set_value('pdt_desc'); ?>">
                                        <?php echo form_error('pdt_desc', '<span class="text-danger">', '</span>'); ?>
                                    </div>



                                    <div class="form-group col-md-3">
                                        <label for="pdt_regular_price">Price(Regular) </label><?php echo REQUIRED_STAR; ?>
                                        <input class="form-control" id="pdt_regular_price" name="pdt_regular_price" type="text" placeholder="Enter Price(Regular)" maxlength="10" value="<?php echo isset($details['pm_regular_price']) ? $details['pm_regular_price'] : set_value('pdt_regular_price'); ?>" required>
                                        <?php echo form_error('pdt_regular_price', '<span class="text-danger">', '</span>'); ?>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="pdt_comm_price">Price(Commercial) </label><?php echo REQUIRED_STAR; ?>
                                        <input class="form-control" id="pdt_comm_price" name="pdt_comm_price" type="text" placeholder="Enter Price(Commercial)" maxlength="10" value="<?php echo isset($details['pm_commercial_price']) ? $details['pm_commercial_price'] : set_value('pdt_comm_price'); ?>" required>
                                        <?php echo form_error('pdt_comm_price', '<span class="text-danger">', '</span>'); ?>
                                    </div>



                                    <div class="form-group col-md-3">
                                        <label for="pdt_warranty_period">Warranty Period(In Days) </label><?php echo REQUIRED_STAR; ?>
                                        <input class="form-control" required maxlength="4" id="pdt_warranty_period" name="pdt_warranty_period" list="all_duration" placeholder="Select Warranty Period(In Days)" autocomplete="off" value="<?php echo isset($details['pm_warranty_period']) ? $details['pm_warranty_period'] : set_value('pdt_warranty_period'); ?>" onchange="get_sit();" />

                                        <datalist id="all_duration">
                                            <?php if (!empty($duration_list)) {
                                                foreach ($duration_list as $key => $duration) { ?>
                                                    <option value="<?php echo $key; ?>" label="<?php echo $duration; ?>"></option>
                                            <?php }
                                            } ?>
                                        </datalist>
                                        <?php echo form_error('amc_duration', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="p_noofservices">No. Of Free Services </label><?php echo REQUIRED_STAR; ?>

                                        <input class="form-control" id="p_noofservices" name="p_noofservices" type="text" placeholder="Enter No. Of Free Services" required maxlength="3" value="<?php echo isset($details['pm_noofserv']) ? $details['pm_noofserv'] : set_value('p_noofservices'); ?>" onchange="get_sit();">
                                        <?php echo form_error('p_noofservices', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="p_sit">Service Interval Time </label><?php echo REQUIRED_STAR; ?>
                                        <input class="form-control" id="p_sit" name="p_sit" type="text" placeholder="Enter Service Interval Time in Days" required maxlength="4" value="<?php echo isset($details['pm_sit']) ? $details['pm_sit'] : set_value('p_sit'); ?>" readonly>
                                        <?php echo form_error('p_sit', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pdt_gst">GST % </label><?php echo REQUIRED_STAR; ?>
                                        <input class="form-control" id="pdt_gst" name="pdt_gst" type="number" placeholder="Enter GST %" maxlength="4" value="<?php echo isset($details['pm_gst']) ? $details['pm_gst'] : set_value('pdt_gst'); ?>" required>
                                        <?php echo form_error('pdt_gst', '<span class="text-danger">', '</span>'); ?>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="pdt_hsn_code">HSN Code</label>
                                        <input class="form-control" id="pdt_hsn_code" name="pdt_hsn_code" type="text" placeholder="Enter HSN Code" maxlength="100" value="<?php echo isset($details['pm_hsn_code']) ? $details['pm_hsn_code'] : set_value('pdt_hsn_code'); ?>">
                                        <?php echo form_error('pdt_hsn_code', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <?php if ($action == "Add") {  ?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="p_image">Product Image </label>
                                                    <input type="file" name="p_image" id="p_image"
                                                        class="smart-file"
                                                        data-label="Product Image"
                                                        data-btn-class="btn btn-default btn-sm"
                                                        data-preview="on"
                                                        data-file-types="image/jpeg,image/png,image/jpg" accept="image/*" />
                                                    <?php echo form_error('p_image', '<span class="text-danger">', '</span>'); ?>
                                                    <span class="file_err"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="p_multi_image">Feature Images<small>(Upload multiple feature images)</small></label><br>
                                                    <input type="file" name="p_multi_image[]" id="p_multi_image"
                                                        class="smart-file"
                                                        data-label="Feature Images"
                                                        data-btn-class="btn btn-default btn-sm"
                                                        data-preview="on"
                                                        data-file-types="image/jpeg,image/png,image/jpg" accept="image/*" multiple />
                                                    <?php echo form_error('p_multi_image', '<span class="text-danger">', '</span>'); ?>
                                                    <span class="file_err"></span>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php if ($action == "Edit") {  ?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <?php $image      = $details['pm_img'];
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
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <?php $imageList    = $details['imageList']; ?>
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
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <div class="form-actions">
                                        <div class="col-md-12">
                                            <center>
                                                <button class="btn btn-success" id="mybutton" type="submit">Submit</button>
                                                <a href="<?php echo get_module_path(); ?>masters/sale_product_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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

<!-- START MODAL -->
<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        </div>
    </div>
</div>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- Form Validation Plugins -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $("#pdt_name").on("keyup", function() {

        let keyword = $(this).val().toLowerCase();
        let html = "";

        if (keyword.length >= 1) {
            $.ajax({
                url: base_url + "ajax/search_pdt_name",
                type: "POST",
                data: {
                    keyword: keyword
                },
                success: function(response) {

                    // Ignore an old name search once the user moves to another field.
                    if (!$("#pdt_name").is(":focus") || $("#pdt_name").val().toLowerCase() !== keyword) {
                        return;
                    }

                    if (response.trim() != "") {
                        html = `<div style="padding: 8px 12px; font-size: 11px; font-weight: 600; color: #888; background: #f8f9fa; border-bottom: 1px solid #eee; border-radius: 4px 4px 0 0; text-transform: uppercase; letter-spacing: 0.5px;">Existing Product Name</div>`;
                        $("#pdt_suggestion_box").html(html + response).show();
                    } else {
                        html = `<div style="padding: 10px 12px; color: #28a745; font-size: 13px; display: flex; align-items: center;">
                            <i class="fa fa-check-circle" style="margin-right: 8px; font-size: 14px;"></i> No Match Found
                        </div>`;
                        $("#pdt_suggestion_box").html(html).show();
                    }
                }
            });

        } else {
            $("#pdt_suggestion_box").hide();
        }
    });

    $("#pdt_name").on("blur", function() {
        $("#pdt_suggestion_box").hide();
    });

    // Hide suggestion box when clicking outside
	$(document).on("click", function(event) {
		if (!$(event.target).closest("#pdt_name, #pdt_suggestion_box").length) {
			$("#pdt_suggestion_box").hide();
		}
	});

    document.getElementById("p_noofservices").addEventListener("change", function() {
        var noofservices = parseInt(this.value);
        var parentElement = this.parentElement;

        if (noofservices <= 0) {
            // Create an error message element
            var errorMessage = document.createElement("span");
            errorMessage.classList.add("text-danger"); // Add red color class
            errorMessage.textContent = "Number of Free Services must be greater than 0.";

            // Get the parent element of the input field
            parentElement.appendChild(errorMessage);

            // Clear the input field
            this.value = "";
            // Set a timeout to remove the error message after 10 seconds
            setTimeout(function() {
                parentElement.removeChild(errorMessage);
            }, 4000);
        } else {
            // Remove any existing error messages
            var errorMessage = parentElement.querySelector(".text-danger");
            if (errorMessage) {
                parentElement.removeChild(errorMessage);
            }
        }
    });


    // Add Branch

    $(document).ready(function() {
        $('.smart-file').bootstrapFileField({
            maxNumFiles: 8,
            fileTypes: 'image/jpeg,image/png,image/jpg',
            maxFileSize: 4000000 // 8Mb in bytes */
        });

        $("#form_modal").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget);
            $(this).data('bs.modal', null);
            $(this).find(".modal-content").load(link.attr("href"));
        });


        $("#add_edit_form").validate({
            rules: {
                required: {
                    required: true
                },
                pdt_name: {
                    required: true,
                    maxlength: 250,
                    minlength: 2,
                },
                p_model_name: {
                    maxlength: 250,
                    minlength: 2,
                },
                /* p_brand_id: {
                required: true,
			 },  */
                pdt_desc: {
                    maxlength: 500,
                },
                pdt_regular_price: {
                    maxlength: 10,
                    number: true,
                },
                pdt_comm_price: {
                    maxlength: 10,
                    number: true,
                },
                pdt_gst: {
                    maxlength: 4,
                    number: true,
                },
                pdt_hsn_code: {
                    maxlength: 100,
                },

                pdt_warranty_period: {
                    required: true,
                    maxlength: 4,
                    digits: true,
                },

                p_noofservices: {
                    required: true,
                    maxlength: 3,
                    digits: true,
                },
                p_sit: {
                    required: true,
                    maxlength: 4,
                    digits: true,
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
        var duration = $("#pdt_warranty_period").val();
        var services = $("#p_noofservices").val();
        if (!services) {
            services = 1;
        }
        if (!duration) {
            duration = 1;
        }
        var sit = parseInt(duration) / parseInt(services);
        sit = Math.ceil(sit);
        $("#p_sit").val(sit);
    }

    function delete_image(obj) {
        var id = $(obj).attr("data-id");
        $('#image_li_' + id).remove();

    }
</script>
