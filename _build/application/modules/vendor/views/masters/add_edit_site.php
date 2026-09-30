<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE BASE CONTENT -->

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <ul class="page-breadcrumb breadcrumb">
                        <li><a href="<?php echo base_url(get_module() . "/dashboard") ?>">Home</a><i
                                class="fa fa-circle"></i></li>
                        <li><a href="<?php echo base_url(get_module() . "/masters/reference_report") ?>">All Site </a><i
                                class="fa fa-circle"></i></li>
                        <li><span class="active"><?php echo $page_title; ?></span></li>
                    </ul>
                    <?php $icon = "icon-plus";
                    if ($action == "Edit") {
                        $icon = "icon-pencil";
                    } ?>
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="font-red-mint <?php echo $icon; ?> "></i>
                            <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
                        </div>

                    </div>
                    <div class="row">

                        <div class="portlet-body form">
                            <?php if ($action == "Edit") {
                                $details = html_escape($details);
                                $formaction = "edit_reference/?ref_id=" . base64_encode($ref_id);
                            } else {
                                $formaction = "add_site";
                            } ?>
                            <form action="<?php echo get_module_path() . 'masters/' . $formaction; ?>"
                                id="add_edit_form" method="post" autocomplete="off">
                                <div class="form-body">
                                    <?php if ($action == "Edit") { ?>
                                        <input type="hidden" name="ref_id" value="<?php echo $ref_id; ?>">
                                    <?php } ?>

                                    <div class="form-row">
                                        <!-- Site Name -->
                                        <div class="form-group col-md-3">
                                            <label for="ref_name">Site Name <?php echo REQUIRED_STAR; ?></label>
                                            <input type="text" class="form-control" id="ref_name" name="ref_name"
                                                placeholder="Enter Site Name" required maxlength="100"
                                                value="<?php echo isset($details['ref_name']) ? $details['ref_name'] : ""; ?>">
                                            <?php echo form_error('ref_name', '<span class="text-danger">', '</span>'); ?>
                                        </div>

                                        <!-- Contact Person -->
                                        <div class="form-group col-md-3">
                                            <label for="ref_contact_per">Contact Person</label>
                                            <input type="text" class="form-control" id="ref_contact_per"
                                                name="ref_contact_per" placeholder="Enter Contact Person"
                                                maxlength="100" pattern="[A-Za-z\s.]+"
                                                value="<?php echo isset($details['ref_person_name']) ? $details['ref_person_name'] : ""; ?>">
                                            <?php echo form_error('ref_contact_per', '<span class="text-danger">', '</span>'); ?>
                                        </div>

                                        <!-- Mobile No. -->
                                        <div class="form-group col-md-3">
                                            <label for="ref_mobile_no">Mobile No.</label>
                                            <input type="text" class="form-control" id="ref_mobile_no"
                                                name="ref_mobile_no" placeholder="Enter Mobile No." maxlength="10"
                                                value="<?php echo isset($details['ref_mobile']) ? $details['ref_mobile'] : ""; ?>">
                                            <?php echo form_error('ref_mobile_no', '<span class="text-danger">', '</span>'); ?>
                                        </div>

                                        <!-- Alternate Mobile No -->
                                        <div class="form-group col-md-3">
                                            <label for="ref_email">Alternate Mobile No</label>
                                            <input type="text" class="form-control" id="alt_ref_mobile_no"
                                                name="alt_ref_mobile_no" placeholder="Enter Alternate Mobile No"
                                                maxlength="10"
                                                value="<?php echo isset($details['alt_ref_mobile_no']) ? $details['alt_ref_mobile_no'] : ""; ?>">
                                            <?php echo form_error('alt_ref_mobile_no', '<span class="text-danger">', '</span>'); ?>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="ref_addr">Address</label>
                                            <input type="text" class="form-control" id="ref_addr" name="ref_addr"
                                                placeholder="Enter Address" maxlength="500"
                                                value="<?php echo isset($details['ref_address']) ? $details['ref_address'] : ""; ?>">
                                            <?php echo form_error('ref_addr', '<span class="text-danger">', '</span>'); ?>
                                        </div>

                                        <!-- GST Type -->
                                        <div class="form-group col-md-3">
                                            <label for="gst_type">GST Type</label>
                                            <select class="form-control" id="gst_type" name="gst_type">
                                                <option value="">Select GST Type</option>
                                                <option value="GST" <?php echo (isset($details['gst_type']) && $details['gst_type'] == 'CGST/SGST') ? 'selected' : ''; ?>>GST
                                                </option>
                                                <option value="IGST" <?php echo (isset($details['gst_type']) && $details['gst_type'] == 'IGST') ? 'selected' : ''; ?>>IGST</option>
                                            </select>
                                            <?php echo form_error('gst_type', '<span class="text-danger">', '</span>'); ?>
                                        </div>

                                        <!-- GST No -->
                                        <div class="form-group col-md-3">
                                            <label for="gst_no">GST No</label>
                                            <input type="text" class="form-control" id="gst_no" name="gst_no"
                                                placeholder="Enter GST Number" maxlength="15"
                                                value="<?php echo isset($details['gst_no']) ? $details['gst_no'] : ""; ?>">
                                            <?php echo form_error('gst_no', '<span class="text-danger">', '</span>'); ?>
                                        </div>

                                        <!-- State -->
                                        <div class="form-group col-md-3">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control" id="state" name="state"
                                                placeholder="Enter State"
                                                value="<?php echo isset($details['state']) ? $details['state'] : ""; ?>">
                                            <?php echo form_error('state', '<span class="text-danger">', '</span>'); ?>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <!-- Site Salary -->
                                        <div class="form-group col-md-4">
                                            <label for="site_salary">Site Salary</label>
                                            <input type="number" class="form-control" id="site_salary"
                                                name="site_salary" placeholder="Enter Monthly Site Salary"
                                                value="<?php echo isset($details['site_salary']) ? $details['site_salary'] : ""; ?>">
                                            <?php echo form_error('site_salary', '<span class="text-danger">', '</span>'); ?>
                                        </div>

                                        <!-- Contract Start Date -->
                                        <div class="form-group col-md-4">
                                            <label for="cust_pay_nxt_start_date">Contract Start Date
                                                <?php echo REQUIRED_STAR; ?></label>
                                            <input type="text" class="form-control datepicker"
                                                id="cust_pay_nxt_start_date" name="next_installment_start_date"
                                                placeholder="Enter Start Date" maxlength="100"
                                                value="<?php echo isset($installment['cbpi_pay_next_start_date']) ? htmlspecialchars($installment['cbpi_pay_next_start_date']) : ''; ?>"
                                                required>
                                            <span class="installment-error text-danger" style="display: none;"></span>
                                            <?php echo form_error('next_installment_start_date', '<span class="text-danger">', '</span>'); ?>
                                        </div>

                                        <!-- Contract End Date -->
                                        <div class="form-group col-md-4">
                                            <label for="cust_pay_nxt_end_date">Contract End Date
                                                <?php echo REQUIRED_STAR; ?></label>
                                            <input type="text" class="form-control datepicker"
                                                id="cust_pay_nxt_end_date" name="next_installment_end_date"
                                                placeholder="Enter End Date" maxlength="100"
                                                value="<?php echo isset($installment['cbpi_pay_next_end_date']) ? htmlspecialchars($installment['cbpi_pay_next_end_date']) : ''; ?>"
                                                required>
                                            <span class="installment-error text-danger" style="display: none;"></span>
                                            <?php echo form_error('next_installment_end_date', '<span class="text-danger">', '</span>'); ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Site Rate Card Section -->
                                <div class="form-row mt-4">
                                    <div class="col-md-12">
                                        <div class="portlet-title">
                                            <div class="portlet-title">
                                                <i class="font-red-mint icon-notebook"
                                                    style="padding-right: 4px; margin-top: 20px; font-size: 14px !important"></i>
                                                <span class="caption-subject font-red-mint sbold" style="font-size: 16px !important">Site Rate Card</span>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="rate_card_table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 4%;">Sr. No.</th>
                                                        <th style="width: 44%;">Designation</th>
                                                        <th style="width: 44%;">Salary (₹)</th>
                                                        <th style="width: 8%;">Remove</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($permission_list)) {
                                                        $permission_list = html_escape($permission_list);
                                                        foreach ($permission_list as $index => $permission) {
                                                            $perm_id = htmlspecialchars($permission['permission_id']);
                                                            $perm_name = htmlspecialchars($permission['permission_name']);
                                                            ?>
                                                            <tr>
                                                                <td><?= $index + 1; ?></td>
                                                                <td>
                                                                    <?= $perm_name; ?>
                                                                    <input type="hidden" name="permission_id[]"
                                                                        value="<?= $perm_id; ?>">
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="designation_salary[]"
                                                                        class="form-control" placeholder="Enter salary" min="0"
                                                                        required>
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm remove-row" title="Remove">
                                                                        <i class="bi bi-dash-circle"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        <?php }
                                                    } else { ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center text-muted">No designations
                                                                found.</td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Include jQuery -->
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                <!-- Remove Row Script -->
                                <script>
                                    $(document).on('click', '.remove-row', function () {
                                        $(this).closest('tr').remove();

                                        // Optional: Recalculate Sr. No. after removal
                                        $('#rate_card_table tbody tr').each(function (index) {
                                            $(this).find('td:first').text(index + 1);
                                        });
                                    });
                                </script>



                                <div class="form-actions mt-3">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success" id="mybutton">Submit</button>
                                        <a href="#" onclick="window.history.go(-1); return false;"
                                            class="btn btn-danger">
                                            <i class="fa fa-history"></i> Back
                                        </a>
                                    </div>
                                </div>
                            </form>

                            <!-- /.box-body -->
                            <script>
                                const button = document.getElementById('mybutton');

                                button.addEventListener('click', function () {
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
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js"
    type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js"
    type="text/javascript"></script>

<script type="text/javascript">
    // Add Branch

    $(document).ready(function () {
        $("#add_edit_form").validate({
            rules: {
                required: {
                    required: true
                },
                ref_name: {
                    required: true,
                    maxlength: 100,
                    minlength: 2,
                },
                ref_addr: {
                    /* required: true, */
                    maxlength: 500,
                    minlength: 2,
                },
                ref_details: {
                    /* required: true, */
                    maxlength: 500,
                    minlength: 2,
                },
            },

            errorClass: "help-inline text-danger",
            errorElement: "span",
            highlight: function (element, errorClass, validClass) {
                $(element).parents('.form-group').addClass('has-error');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents('.form-group').removeClass('has-error');
                $(element).parents('.form-group').addClass('has-success');
            }
        });
    });

</script>
</script>
<!-- Include Bootstrap Datepicker CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">



<!-- Include Bootstrap Datepicker JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
    $(document).ready(function () {
        $('#cust_pay_nxt_start_date, #cust_pay_nxt_end_date').datepicker({
            format: 'dd-M-yyyy',
            autoclose: true,
            todayHighlight: true,
            container: 'body'
        }).on('show', function () {
            $('.datepicker-dropdown').css('z-index', '9999');
        });

        $('#cust_pay_nxt_end_date').on('change', function () {
            const startDateStr = $('#cust_pay_nxt_start_date').val();
            const endDateStr = $('#cust_pay_nxt_end_date').val();

            if (startDateStr && endDateStr) {
                const startDate = new Date(startDateStr);
                const endDate = new Date(endDateStr);

                if (endDate <= startDate) {
                    alert("End date must be after Start date.");
                    $(this).val('');
                }
            }
        });
    });
</script>