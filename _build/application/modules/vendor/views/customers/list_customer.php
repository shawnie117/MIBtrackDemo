<?php
$vendor  = $this->session->userdata('vendor');
$role_id = $vendor['user_role_id'];
?>
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
                            <a class="btn btn-success btn-sm " href="<?php echo get_module_path(); ?>customers/add_customer" title="Add"><i class="fa fa-plus"></i> Add New </a>
                            <?php if ($role_id == SUPER_ADMIN_ROLE_ID) { ?>
                                <span class="btn red btn-outline btn-sm" id="download_customer_report" title="Download Customer Report"><i class="fa fa-download"></i> Download </span>

                            <?php } ?>
                        </center>
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
                                if ($history == "back") {
                                    $cust_post_data = $this->session->userdata('cust_post_data');
                                    $page  = $cust_post_data['page'];
                                }
                                ?>
                                <div class="col-md-12">
                                    <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
                                        <input type="hidden" name="highlight_id" value="<?php echo $this->input->get("highlight"); ?>" />
                                        <div class="form-group col-md-2">
                                            <select class="form-control" id="status" name="status" onchange="table_list(1);">
                                                <option value=""> Select Status</option>
                                                <?php if (!empty($status_list)) {
                                                    foreach ($status_list as $stat) {
                                                        $status   = isset($cust_post_data['status']) ? $cust_post_data['status'] : "Active";
                                                        $sel_stat = isset($sel_status) ? $sel_status : $status;
                                                        $selected = $sel_stat == $stat ? "selected" : "";
                                                ?>
                                                        <option value="<?php echo $stat ?>" <?php echo $selected; ?>><?php echo $stat; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <!-- <select class="form-control" id="service_type" name="service_type" onchange="table_list(1);"> -->
                                                 <select class="form-control" id="service_type" name="service_type" onchange="loadServiceNames();table_list(1);">
                                                <option value="">Select Service Type</option>
                                                <?php if (!empty($service_type_list)) {
                                                    foreach ($service_type_list as $key => $service_type) {
                                                        $followup   = isset($cust_post_data['followup']) ? $cust_post_data['followup'] : "";
                                                        $sev_type = isset($sev_type) ? $sev_type : $followup;
                                                        $selected = $sev_type == $key ? "selected" : "";
                                                ?>
                                                        <option value="<?php echo $key ?>" <?php echo $selected; ?>><?php echo $service_type; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <!-- add by ritika 17 june-->

                                        <div class="form-group col-md-2">
                                            <select class="form-control selectpicker"
                                             data-live-search="true"
                                                id="service_name"
                                                name="service_name"
                                                onchange="table_list(1);">
                                                <option value="">Select Service Name</option>
                                            </select>
                                        </div>



                                        <div class="form-group col-md-2">
                                            <select class="form-control" id="gst" name="gst" onchange="table_list(1);">
                                                <option value=""> Select GST</option>
                                                <option value="true">With GST</option>
                                                <option value="false">Without GST</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <input class="form-control" id="searchStr_name" name="searchStr_name" type="text" placeholder="Search Name/Contact/Company" maxlength="100" value="<?php echo isset($cust_post_data['searchStr_name']) ? $cust_post_data['searchStr_name'] : ""; ?>" onchange="table_list(1);">
                                        </div>
                                        <!-- <div class="form-group col-md-2">
                                            <input class="form-control" id="searchStr_cust_id" name="searchStr_cust_id" type="text" placeholder="Search By ID" maxlength="100" value="<?php echo isset($cust_post_data['searchStr_cust_id']) ? $cust_post_data['searchStr_cust_id'] : ""; ?>" onchange="table_list(1);">
                                        </div> -->

                                         <div class="form-group">
                                            <a class="btn btn-danger" id="clear_btn" title="Clear Search">
                                                <i class="icon-close"></i>
                                            </a>
                                        </div>


                                    </form>
                                </div>
                                <div class="tbl-container">
                                    <table class="table table-striped table-bordered table-hover  dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch" id="Srtable" role="grid" aria-describedby="sample_1_info">
                                        <thead>
                                            <tr>
                                                <th width="2%">Sr. No.</th>
                                                <th>Customer Name </th>
                                                <th>Company Name</th>
                                                <th>Contact Person</th>
                                                <th width="10%">Contact No</th>
                                                <th>Address </th>


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

          //add by ritika 
        // $("#clear_btn").click(function(e) {

        //     $('#service_type').val('');
        //     $('#service_name').html('<option value="">Select Service Name</option>');

        //     table_list(1);
        // });

        $("#clear_btn").click(function(e) {

            $('#srch_form')[0].reset();

            $('#service_name').html('<option value="">Select Service Name</option>');

            $('#service_type').selectpicker('refresh');
            $('#service_name').selectpicker('refresh');

            table_list(1);
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
        $("#tbl_list").html("");
        $(".loader").fadeIn();
        $.ajax({
            url: base_url + "ajax/tbl_customer_list/" + pageno,
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


   	//add by ritika 17 june 26

	function loadServiceNames()
{
    var service_type = $("#service_type").val();

    $.ajax({
        type: "POST",
        url: "<?php echo get_module_path(); ?>ajax/get_service_name_list",
        data: {
            service_type: service_type
        },
        success: function(response)
        {
            $("#service_name").html(response);
                 $('#service_name').selectpicker('refresh');
        }
    });
}


</script>

<script>
    $("#service_type").change(function(){

    $.ajax({
        url : base_url + "ajax/get_service_name_list",
        type : "POST",
        data : {
            service_type : $(this).val()
        },
        success:function(response){
            $("#service_name").html(response);
        }
    });

});
</script>

