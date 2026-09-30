<?php $role_id = $this->session->userdata('user_role_id');
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
                                        <div class="col-lg-7 col-md-12">

                                        <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
                                        <span class="caption-subject font-red-mint sbold  total_count">( Total - 0 )</span>

                                        </div>

                                        
                                        <div class="col-lg-5 col-md-12">

                                        <center>
                                        
                                        <?php if($role_id_con == SUPER_ADMIN_ROLE_ID || $role_id_con == ADMIN_ROLE_ID){	?>
						  <a href="<?php echo get_module_path();?>leads/multi_transfer_lead" class="btn btn-primary" ><i class="fa fa-share-square-o"></i> Lead Transfer To</a>
						   <?php } ?>
       
                                        </center>

                                        </div>



                                        <div class="row">
                                                <div class="col-md-12">
                                                        <div class="portlet-body">
                                                                <div class="col-md-6 notification-alert">
                                                                        <?php
                                                                                $this->load->helper('form');
                                                                                $error = $this->session->flashdata('error');
                                                                                if($error)
                                                                                {
                                                                        ?>
                                                                        <div class="alert alert-danger alert-dismissable">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                                                <?php echo $this->session->flashdata('error'); ?>
                                                                        </div>
                                                                        <?php }
                                                                                $success = $this->session->flashdata('success');
                                                                                if($success)
                                                                                {
                                                                        ?>
                                                                        <div class="alert alert-success alert-dismissable">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                                                <?php echo $this->session->flashdata('success'); ?>
                                                                        </div>
                                                                        <?php } ?>
                                                                </div>
                                                                <?php $lead_post_data = array();
                                                                        $history     = $this->input->get('history');
                                                                        $lead_status = $this->input->get('status');
                                                                        $dist_list   = array();
                                                                        $city_list   = array();
                                                                        $area_list   = array();
                                                                        $page       = "1";
                                                                        if($history == "back")
                                                                        {
                                                                                $lead_post_data = $this->session->userdata('lead_post_data');
                                                                                $dist_list      = $lead_post_data['dist_list'];
                                                                                $city_list      = $lead_post_data['city_list'];
                                                                                $area_list      = $lead_post_data['area_list'];
                                                                                $page           = $lead_post_data['page'];
                                                                        }
                                                                ?>
                                                                <div class="col-md-12 p-0">
                                                                        <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
                                                                                <input type="hidden" name="highlight_id" value="<?php echo $this->input->get("highlight"); ?>" />
                                                                                

                                                                               



                                                                                
                                                                               
                                                                                
                                                                                <?php if ($role_id_con == 1 || $role_id_con == 2): ?>
                                                                                <div class="form-group col-md-3">                           
                                                                                        <select class="form-control" id="emp_id" name="emp_id" onchange="table_list(1);">
                                                                                        <option value="">Select Employee</option>
                                                                                        <?php  
                                                                                        if (!empty($employee_list)) { 
                                                                                                foreach ($employee_list as $employee) { 
                                                                                                $emp_id   = isset($emp_loc_post_data1['emp_id']) ? $emp_loc_post_data1['emp_id'] : "";
                                                                                                $selected = $emp_id == $employee['emp_id'] ? "selected" : "";                                   
                                                                                        ?>
                                                                                                <option value="<?php echo $employee['user_id'];?>" <?php echo $selected;?>><?php echo $employee['emp_name']; ?></option>
                                                                                        <?php 
                                                                                                } 
                                                                                        } 
                                                                                        ?>      
                                                                                        </select>                                                
                                                                                </div>
                                                                                <?php endif; ?>

                                                                                
                                                                            

                                                                                <div id="toggle_srch" class="<?php echo $class;?>">
                                                                                       
                                                                                        
                                                                                        
                                                                                        
                                                                                        
                                                                                       
                                                                                </div>
                                                                        </form>
                                                                </div>

                                                                <table class="table table-striped table-bordered table-hover  dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
                                                                        <thead>
                                                                                <tr>
                                                                                        <th width="2%">Sr. No.</th>
                                                                                        <th width="20%">Lead Name </th>
                                                                                        <th width="10%">Contact No</th>
                                                                                        <!-- <th width="12%">Landline No </th> -->
                                                                                        <th>Address </th>
                                                                                        <!-- <th width="10%">Option to Transfer Lead </th> -->
                                                                                        <th style="text-align:center" width="10%">Status</th>
                                                                                </tr>
                                                                        </thead>
                                                                        <tbody  id="tbl_list">
                                                                        </tbody>

                                                                </table>

                                                                <!-- Render pagination links -->
                                                                <div class="pagination" style="float:right;">


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

$("#clear_btn").click(function(e){
         $('#lead_date, #lead_month, #lead_year').val('');
         $('#followup, #emp_id, #status, #searchStr_name').val('');
         $('#searchStr_contact, #ref_id, #product_id').val('');
         $('#added_by, #priority, #state_id').val('');
         $('#dist_id, #city_id').val('');
         $('#srch_form').trigger("reset");
         table_list(1);
});
$("#download_lead_report").click(function(e){
        $('#srch_form').attr("action",base_url+"leads/download_lead_report");
        $('#srch_form').attr("onsubmit","");
        $('#srch_form').submit();
        $('#srch_form').attr("action","");
        $('#srch_form').attr("onsubmit","return false;");

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
                });     ;

                $('.datepickerMY').datepicker({
                                format: 'mm-yyyy',
                                autoclose: true,
                                todayHighlight: true,
                                viewMode: "months",
                                minViewMode: "months"

                }).on('changeDate', function(e) {
                        table_list(1);
                });     ;


  $('#confirm-deactivate').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });

  // Detect pagination click
     $('.pagination').on('click','a',function(e){
       e.preventDefault();
           $(".loader").fadeIn();
       var pageno = $(this).attr('data-ci-pagination-page');
           if(pageno){
                    table_list(pageno);
           }

     });

});

function table_list(pageno)
        {
                var formdata  = $("#srch_form").serializeArray();
                $("#tbl_list").html("");
                $.ajax({
                        url:base_url+"ajax/tbl_trf_lead_list/"+pageno,
                        type: "POST",
                        data: formdata,
                        datatype: "json",
                        async: true,
                        cache: false,
                        success: function(data)
                        {
                                var json_arr = JSON.parse(data);
                                var html_data = '';
                                var html_data   = json_arr.list;
                                var total_count = json_arr.total_count;

                                $(".total_count").html("( Total - "+total_count+" )");
                                $("#tbl_list").html(html_data);
                                $('.pagination').html(json_arr.pagination);
                                $(".loader").fadeOut();
                        }
                });
        }
</script>
