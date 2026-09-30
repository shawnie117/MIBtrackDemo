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
                                        <div class="col-lg-8 col-md-12">
                                                <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
                                                <span class="caption-subject font-red-mint sbold float-right total_count">( Total - 0 )</span>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                                <center>
                                                        <a class="btn btn-success btn-sm " href="<?php echo get_module_path(); ?>reports/add_quotation" title="Add"><i class="fa fa-plus"></i> Add New </a>
                                                        <?php if ($role_id == SUPER_ADMIN_ROLE_ID) { ?>
                                                                <span class="btn red btn-outline btn-sm" id="download_quotation_report" title="Download Quotation Report"><i class="fa fa-download"></i> Download </span>

                                                        <?php } ?>
                                                </center>
                                        </div>
                                        <!-- <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
                                   <span class="caption-subject font-red-mint sbold float-right total_count">( Total - 0 )</span>        -->

                                        <div class="row">


                                                <div class="col-md-12">
                                                        <div class="portlet-body">
                                                                <div class="col-md-6 notification-alert">
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
                                                                <?php $quot_post_data = array();
                                                                $page    = "1";
                                                                $history = $this->input->get('history');
                                                                if ($history == "back") {
                                                                        $quot_post_data = $this->session->userdata('quot_post_data');
                                                                        $page  = $quot_post_data['page'];
                                                                }
                                                                ?>
                                                                <div class="col-md-12">
                                                                        <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
                                                                                <!-- Vihas added on 24/03/2026 -->
                                                                                <div class="form-group col-md-2">
                                                                                        <select class="form-control" name="priority" id="priority" onchange="table_list(1);">
                                                                                                <option value="">All Priority</option>
                                                                                                <?php foreach ($priority_list as $p) {
                                                                                                        $selected = (isset($quotation_post_data['priority']) && $quotation_post_data['priority'] == $p) ? 'selected' : '';
                                                                                                ?>
                                                                                                        <option value="<?php echo $p; ?>" <?php echo $selected; ?>><?php echo $p; ?></option>
                                                                                                <?php } ?>
                                                                                        </select>
                                                                                </div>
                                                                                <div class="form-group col-md-2">
                                                                                        <select class="form-control" name="status" id="status" onchange="table_list(1);">
                                                                                                <option value="">All Status</option>
                                                                                                <?php foreach ($status_list as $s) {
                                                                                                        $selected = "";
                                                                                                        if (!isset($quotation_post_data['status']) && $s == "Active") {
                                                                                                                $selected = "selected";
                                                                                                        } elseif (isset($quotation_post_data['status']) && $quotation_post_data['status'] == $s) {
                                                                                                                $selected = "selected";
                                                                                                        }
                                                                                                ?>
                                                                                                        <option value="<?php echo $s; ?>" <?php echo $selected; ?>><?php echo $s; ?></option>
                                                                                                <?php } ?>
                                                                                        </select>
                                                                                </div>
                                                                                <div class="form-group col-md-3">
                                                                                        <select class="form-control" name="type_filter" id="type_filter" onchange="table_list(1);">
                                                                                                <option value="">All Customers and Leads</option>
                                                                                                <option value="customer" <?= (isset($my_followup_post_data['type_filter']) && $my_followup_post_data['type_filter'] == "customer") ? 'selected' : ''; ?>>Customer</option>
                                                                                                <option value="lead" <?= (isset($my_followup_post_data['type_filter']) && $my_followup_post_data['type_filter'] == "lead") ? 'selected' : ''; ?>>Lead</option>
                                                                                        </select>
                                                                                </div>
                                                                                <div class="form-group col-md-2">
                                                                                        <button type="button" id="clear_btn" class="btn btn-danger">
                                                                                                <i class=" icon-close"></i>
                                                                                        </button>
                                                                                </div>
                                                                        </form>
                                                                </div>
                                                                <div class="tbl-container">
                                                                        <table class="table table-striped table-bordered table-hover  dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch" id="Srtable" role="grid" aria-describedby="sample_1_info">
                                                                                <thead>
                                                                                        <tr>
                                                                                                <th width="2%">Sr. No.</th>
                                                                                                <!-- <th width="5%">Quotation No.</th> -->
                                                                                                <th>Customer/Lead</th>
                                                                                                <th>Type </th>
                                                                                                <th>Status</th>
                                                                                                <th>Priority</th>
                                                                                                <th width="12%">Contact</th>
                                                                                                <th>Remark</th>
                                                                                                <th width="12%">Added Date</th>



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
                                        }
                                </style>
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
                $("#clear_btn").click(function(e) {
                        $('#searchStr_name').val('');
                        $('#status, #ticket_assign_to, #customer_id, #clm_id').val('');
                        $('#from_date, #from_date').val('');
                        $('#srch_form').trigger("reset");
                        $(".selectpicker").val('');
                        $(".selectpicker").selectpicker("refresh");
                        table_list(1);
                });

                $("#download_quotation_report").click(function(e) {
                        var html = $('#srch_form').html();
                        $('#srch_form').attr("action", base_url + "reports/download_quotation_report");
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
                        $(".loader").fadeIn();
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
                        url: base_url + "ajax/tbl_quotation_list/" + pageno,
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
                                $(".loader").fadeOut();
                        }
                });
        }
</script>