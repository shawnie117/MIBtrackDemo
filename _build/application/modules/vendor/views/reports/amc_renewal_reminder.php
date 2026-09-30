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

                    </div>
                    <div class="row">


                        <div class="col-md-12">
                            <div class="portlet-body">
                                <div class="col-md-5">
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
                                <?php $cust_post_data = array();
                                $page       = "1";
                                $history    = $this->input->get('history');
                                $sel_status = $this->input->get('status');
                                $sev_type   = $this->input->get('type');
                                //add by ritika
                              //  $highlight_id = base64_decode($this->input->post('highlight_id'));
                                $highlight = $this->input->get('highlight');
                               // $highlight  = $this->input->get('highlight');

                                // echo "Highlight = " . $highlight;
                                // die;

                                if ($history == "back") {
                                    $cust_post_data = $this->session->userdata('cust_post_data');
                                    $page  = $cust_post_data['page'];
                                }
                                ?>

                                <div class="tbl-container">
                                    <table class="table table-striped table-bordered table-hover  dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch" id="Srtable" role="grid" aria-describedby="sample_1_info">
                                        <thead>
                                            <tr>

                                                <!-- update by ritika -->
                                                <th style="width:6%">Sr. No.</th>
                                                <th style="width:22%">Customer Name</th>
                                                <th style="width:42%">AMC Name</th>
                                                <th style="width:15%">Mobile</th>
                                                <th style="width:15%">Start Date</th>
                                                <th style="width:15%">End Date</th>


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
<!--END START MODAL -->

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#download_customer_report").click(function(e) {
            $('#srch_form').attr("action", base_url + "customers/download_customer_report");
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

        // Automatically select "With GST" if GST parameter is present in URL
        const urlParams = new URLSearchParams(window.location.search);
        const gstValue = urlParams.get('gst');
        if (gstValue) {
            $("#gst").val(gstValue).trigger('change'); // Ensures value is recognized by the form
        }

    });
    table_list(<?php echo $page; ?>);

    function table_list(pageno) {
        var formdata = $("#srch_form").serializeArray();
        //add by ritika
        formdata.push({
            name: "highlight_id",
            value: "<?php echo $highlight; ?>"
        });


        $("#tbl_list").html("");
        $(".loader").fadeIn();
        $.ajax({
            url: base_url + "ajax/tbl_amc_renewal_reminder/" + pageno,
            type: "POST",
            data: formdata,
            datatype: "json",
            async: true,
            cache: false,
            success: function(data) {
                var json_arr = JSON.parse(data);
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