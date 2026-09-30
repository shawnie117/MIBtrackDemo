<?php $role_id = $this->session->userdata('user_role_id');
$role_id = $vendor['user_role_id'];
?>
<style>
        #form_err {
                display: none;
                position: fixed;
                top: 100px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 9999;

                width: auto;
                min-width: 300px;
                max-width: 500px;
        }

        #form_success {
                display: none;
                position: fixed;
                top: 100px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 9999;

                width: auto;
                min-width: 300px;
                max-width: 500px;
        }

        .custom-alert {
                display: flex;
                align-items: center;
                gap: 10px;
                background: #fdecea;
                color: #b71c1c;
                padding: 10px 14px;
                border-radius: 6px;
                font-size: 14px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .alert-icon {
                font-size: 18px;
                color: #e53935;
        }

        .alert-text {
                flex: 1;
        }

        .bootstrap-select .dropdown-toggle {
    width: 100% !important;
}

.bootstrap-select .filter-option {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.bootstrap-select .dropdown-menu {
    width: 100% !important;
    min-width: 100% !important;
    max-width: 100% !important;
}

.bootstrap-select .dropdown-menu.inner {
    max-height: 200px !important;
}

.bootstrap-select .dropdown-menu li a span.text {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
}
.lead-report-actions{
    text-align:right;
}
</style>
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
                                        <div id="form_success"></div>
                                        <div id="form_err"></div>
                                        <div class="col-lg-3 col-md-12">

                                                <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
                                                <span class="caption-subject font-red-mint sbold  total_count">( Total - 0 )</span>

                                        </div>


                                        <!-- Anjali CSS 28-05-2025 -->
                                        <!-- <div class="col-lg-9 col-md-12 lead-report-actions"> -->
                                        <div class="col-lg-9 col-md-12 lead-report-actions text-right">

                                                <!-- <center> -->

                                                        <!-- <button id="toggleCheckbox" class="btn btn-primary">Multiple Lead Transfer</button>

                                                        <a class="btn btn-success btn-sm" href="<?php echo get_module_path(); ?>leads/add_lead" title="Add"><i class="fa fa-plus"></i> Add New </a> -->
                                                        
                                                        <a class="btn btn-info btn-sm"
                                                        href="<?php echo get_module_path(); ?>leads/lead_summary_report"
                                                        title="Lead Summary Report">
                                                        <i class="fa fa-bar-chart"></i> Lead Summary Report
                                                        </a>

                                                        <button id="toggleCheckbox" class="btn btn-primary">
                                                        Multiple Lead Transfer
                                                        </button>

                                                        <a class="btn btn-success btn-sm"
                                                        href="<?php echo get_module_path(); ?>leads/add_lead"
                                                        title="Add">
                                                        <i class="fa fa-plus"></i> Add New
                                                        </a>
                                                     

                                                        <?php if ($roleId == SUPER_ADMIN_ROLE_ID) { ?>
                                                                <!-- <span class="btn red btn-outline btn-sm" id="download_team_lead_report" title="Download Team Lead Report"><i class="fa fa-download"></i> Download Team Report </span> -->
                                                                <span class="btn red btn-outline btn-sm" id="download_lead_report" title="Download Lead Report"><i class="fa fa-download"></i> Download </span>
                                                        <?php } ?>




                                                        <a class="btn btn-success " id="toggle_btn" title="Advance Search"><i class=" icon-magnifier-add"></i></a>
                                                        &nbsp;
                                                        <a class="btn btn-danger " id="clear_btn" title="Clear Search"><i class=" icon-close"></i></a>


                                                <!-- </center> -->

                                        </div>
                                        <!-- Anjali End CSS 28-05-2025 -->

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
                                                                        <?php }
                                                                        $success = $this->session->flashdata('success');
                                                                        if ($success) {
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
                                                                $lead_month_year = $this->input->get('lead_month_year');
                                                                $dist_list   = array();
                                                                $city_list   = array();
                                                                $area_list   = array();
                                                                $page       = "1";
                                                                if ($history == "back") {
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
										<!-- Added by Anjali 29/06/26 -->
										<input type="hidden" id="summary_employee_name" name="summary_employee_name" value="<?php echo htmlspecialchars($summary_employee_name, ENT_QUOTES, 'UTF-8'); ?>" />
                                                                                <div class="form-group col-md-2">
                                                                                        <select class="form-control selectpicker" id="followup" name="followup" data-ive-search="true" onchange="table_list(1);">
                                                                                                <option value=""> Select Followup</option>
                                                                                                <?php if (!empty($followup_list)) {
                                                                                                        foreach ($followup_list as $key => $stat) {
                                                                                                                $followup   = isset($lead_post_data['followup']) ? $lead_post_data['followup'] : "";
                                                                                                                $selected = $followup == $key ? "selected" : "";
                                                                                                ?>
                                                                                                                <option value="<?php echo $key ?>" <?php echo $selected; ?>><?php echo $stat; ?></option>
                                                                                                <?php }
                                                                                                } ?>
                                                                                        </select>
                                                                                </div>

                                                                                <div class="form-group col-md-2">
                                                                                        <select class="form-control" id="status" name="status" onchange="table_list(1);">
                                                                                                <option value=""> Select Status</option>
                                                                                                <?php if (!empty($status_list)) {
                                                                                                        foreach ($status_list as $stat) {
                                                                                                                $status   = isset($lead_post_data['status']) ? $lead_post_data['status'] : "Active";
                                                                                                                $sel_state = isset($lead_status) ? $lead_status : $status;
                                                                                                                $selected = $sel_state == $stat ? "selected" : "";
                                                                                                ?>
                                                                                                                <option value="<?php echo $stat ?>" <?php echo $selected; ?>><?php echo $stat; ?></option>
                                                                                                <?php }
                                                                                                } ?>
                                                                                        </select>
                                                                                </div>

                                                                                <div class="form-group col-md-2">
                                                                                        <input class="form-control" id="searchStr_name" name="searchStr_name" type="text" placeholder="Search By Name/Contact No" maxlength="100" value="<?php echo isset($lead_post_data['searchStr_name']) ? $lead_post_data['searchStr_name'] : ""; ?>" onchange="table_list(1);">
                                                                                </div>


                                                                                <div class="form-group col-lg-3 col-md-3">
                                                                                        <!-- <select class="form-control" id="emp_id" name="emp_id" onchange="table_list(1);"> -->
                                                                                                <!-- add by ritika -->
								<!-- Added by Anjali 29/06/26 -->
								<select class="form-control selectpicker" id="emp_id" name="emp_id" data-live-search="true" onchange="$('#summary_employee_name').val('');table_list(1);">
                                                                                                <option value="">Select Employee</option>


                                                                                                <?php if ($roleId == 1 || $roleId == 2): ?>
                                                                                                       
                                                                                                        <?php if (!empty($employee_list)): ?>
                                                                                                                <?php foreach ($employee_list as $employee): ?>
                                                                                                                        <?php
						// Added by Anjali 29/06/26
												$selected = ((string) $selected_emp === (string) $employee['user_id']) ? "selected" : "";
                                                                                                                        ?>
                                                                                                                        <option value="<?php echo $employee['user_id']; ?>" <?php echo $selected; ?>><?php echo $employee['emp_name']; ?></option>
                                                                                                                <?php endforeach; ?>
                                                                                                        <?php endif; ?>

                                                                                                <?php else: ?>
                                                                                                       
                                                                                                        <?php if (!empty($direct_employeee)): ?>
                                                                                                                <?php foreach ($direct_employeee as $employee): ?>
                                                                                                                        <?php
						// Added by Anjali 29/06/26
												$selected = ((string) $selected_emp === (string) $employee['user_id']) ? "selected" : "";
                                                                                                                        ?>
                                                                                                                        <option value="<?php echo $employee['user_id']; ?>" <?php echo $selected; ?>><?php echo $employee['user_person_name']; ?></option>
                                                                                                                <?php endforeach; ?>
                                                                                                        <?php endif; ?>
                                                                                                <?php endif; ?>

                                                                                        </select>
                                                                                </div>

                                                                                <!-- <div class="form-group col-md-3">
                                                                                        <select class="form-control" id="product_id" name="product_id" onchange="table_list(1);">
                                                                                                <option value=""> Select Product</option>
                                                                                                <?php if (!empty($product_list)) {
                                                                                                        foreach ($product_list as $product) {
                                                                                                               
                                                                                                                if (!empty($product['pm_name'])) {
                                                                                                                        $selected = $product_id == $product['pm_id'] ? "selected" : ""; ?>
                                                                                                        <option value="<?php echo $product['pm_id']; ?>" <?php echo $selected; ?>>
                                                                                                                <?php echo $product['pm_name']; ?>
                                                                                                        </option>
                                                                                                        <?php }
                                                                                                        }
                                                                                                } ?>
                                                                                        </select>
                                                                                        </div>   -->

                                                                                <?php
                                                                                $product_id = isset($lead_post_data['product_id']) ? $lead_post_data['product_id'] : "";
                                                                                $product_type = isset($lead_post_data['product_type']) ? $lead_post_data['product_type'] : "";
                                                                                ?>
                                                                                <input type="hidden" name="product_type" id="product_type" value="<?php echo $product_type; ?>">

                                                                                <div class="form-group col-md-3">

                                                                                        <select class="form-control selectpicker" id="product_id" name="product_id"  data-live-search="true" onchange="set_enquiry_filter(this);">
                                                                                                <option value="">Select Enquiry</option>
                                                                                                <?php
                                                                                                if (!empty($product_list)) {
                                                                                                        foreach ($product_list as $product) {
                                                                                                                $prod_id   = "";
                                                                                                                $prod_name = "";
                                                                                                                $prod_type = "";

                                                                                                                $pm_id    = isset($product['pm_id']) ? $product['pm_id'] : "";
                                                                                                                $pm_name  = isset($product['pm_name']) ? $product['pm_name'] : "";
                                                                                                                $ots_id   = isset($product['ots_id']) ? $product['ots_id'] : "";
                                                                                                                $ots_name = isset($product['ots_name']) ? $product['ots_name'] : "";
                                                                                                                $amc_id   = isset($product['amc_id']) ? $product['amc_id'] : "";
                                                                                                                $amc_name = isset($product['amc_name']) ? $product['amc_name'] : "";

                                                                                                                if (!empty($pm_id)) {
                                                                                                                        $prod_id = $pm_id;
                                                                                                                        $prod_name = $pm_name;
                                                                                                                        $prod_type = "PROD";
                                                                                                                }

                                                                                                                if (!empty($ots_id)) {
                                                                                                                        $prod_id = $ots_id;
                                                                                                                        $prod_name = $ots_name;
                                                                                                                        $prod_type = "OTS";
                                                                                                                }

                                                                                                                if (!empty($amc_id)) {
                                                                                                                        $prod_id = $amc_id;
                                                                                                                        $prod_name = $amc_name;
                                                                                                                        $prod_type = "AMC";
                                                                                                                }

                                                                                                                $selected = ($product_id == $prod_id && $product_type == $prod_type) ? "selected" : "";
                                                                                                ?>
                                                                                                                <option value="<?php echo $prod_id; ?>" <?php echo $selected; ?> data-type="<?php echo $prod_type; ?>">
                                                                                                                        <?php echo $prod_name; ?>
                                                                                                                </option>
                                                                                                <?php
                                                                                                        }
                                                                                                }
                                                                                                ?>
                                                                                        </select>
                                                                                        <?php echo form_error('product_id', '<span class="text-danger">', '</span>'); ?>
                                                                                </div>


                                                                                <!-- <div class="form-group col-md-2">
                                                                                        <a class="btn btn-success " id="toggle_btn"  title="Advance Search"><i class=" icon-magnifier-add"></i></a>
                                                                                        &nbsp;
                                                                                        <a class="btn btn-danger " id="clear_btn"  title="Clear Search"><i class=" icon-close"></i></a>

                                                                                </div> -->
                                                                                <?php
                                                                                $class = "hidden";
                                                                                $reference  = isset($lead_post_data['ref_id']) ? $lead_post_data['ref_id'] : "";
                                                                                $product_id = isset($lead_post_data['product_id']) ? $lead_post_data['product_id'] : "";
                                                                                $added_by   = isset($lead_post_data['added_by']) ? $lead_post_data['added_by'] : "";
                                                                                $priority   = isset($lead_post_data['priority']) ? $lead_post_data['priority'] : "";
                                                                                $lead_date  = isset($lead_post_data['lead_date']) ? $lead_post_data['lead_date'] : "";
					// Added by Anjali 29/06/26: preserve the URL month before reading saved filters.
										$saved_lead_month_year = isset($lead_post_data['lead_month_year']) ? $lead_post_data['lead_month_year'] : "";
                                                                                $state_id = isset($lead_post_data['state_id']) ? $lead_post_data['state_id'] : "";
                                                                                $dist_id  = isset($lead_post_data['dist_id']) ? $lead_post_data['dist_id'] : "";
                                                                                $city_id = isset($lead_post_data['city_id']) ? $lead_post_data['city_id'] : "";
                                                                                $area_id = isset($lead_post_data['area_id']) ? $lead_post_data['area_id'] : "";

										if (!empty($reference) || !empty($product_id) || !empty($added_by) || !empty($priority) || !empty($lead_date) || !empty($lead_month_year) || !empty($saved_lead_month_year) || !empty($state_id) || !empty($dist_id) || !empty($city_id) || !empty($area_id)) {
                                                                                        $class = "";
                                                                                }
                                                                                ?>

                                                                                <div id="toggle_srch" class="<?php echo $class; ?>">
                                                                                        <div class="form-group col-md-2">
                                                                                                <select class="form-control selectpicker" id="ref_id" name="ref_id" data-live-search="true" onchange="table_list(1);">
                                                                                                        <option value=""> Select Reference By </option>
                                                                                                        <?php if (!empty($reference_list)) {
                                                                                                                foreach ($reference_list as $key => $ref) {
                                                                                                                        $selected    = $reference == $ref['ref_id'] ? "selected" : "";        ?>
                                                                                                                        <option value="<?php echo $ref['ref_id'] ?>" <?php echo $selected; ?>><?php echo $ref['ref_name']; ?></option>
                                                                                                        <?php }
                                                                                                        } ?>
                                                                                                </select>
                                                                                        </div>

                                                                                        <!-- <div class="form-group col-md-2">
                                                                                                <select class="form-control" id="added_by" name="added_by" onchange="table_list(1);">
                                                                                                        <option value=""> Select Added By</option>
                                                                                                        <?php if (!empty($employee_list)) {
                                                                                                                foreach ($employee_list as $employee) {
                                                                                                                        $selected  = $added_by == $employee['user_id'] ? "selected" : ""; ?>
                                                                                                                        <option value="<?php echo $employee['user_id']; ?>" <?php echo $selected; ?>><?php echo $employee['emp_name']; ?></option>
                                                                                                        <?php }
                                                                                                        } ?>
                                                                                                </select>
                                                                                        </div> -->

                                                                                        <!-- <div class="form-group col-lg-2 col-md-2">
                                                                                                <select class="form-control" id="added_by" name="added_by" onchange="table_list(1);">
                                                                                                        <option value="">Added By</option>

                                                                                                        <?php if ($roleId == 1 || $roleId == 2): ?>
                                                                                                                
                                                                                                                <?php if (!empty($employee_list)): ?>
                                                                                                                        <?php foreach ($employee_list as $employee): ?>
                                                                                                                                <?php
                                                                                                                                $emp_id = isset($emp_loc_post_data1['emp_id']) ? $emp_loc_post_data1['emp_id'] : "";
                                                                                                                                $selected = $emp_id == $employee['emp_id'] ? "selected" : "";
                                                                                                                                ?>
                                                                                                                                <option value="<?php echo $employee['user_id']; ?>" <?php echo $selected; ?>><?php echo $employee['emp_name']; ?></option>
                                                                                                                        <?php endforeach; ?>
                                                                                                                <?php endif; ?>

                                                                                                        <?php else: ?>
                                                                                                               
                                                                                                                <?php if (!empty($direct_employeee)): ?>
                                                                                                                        <?php foreach ($direct_employeee as $employee): ?>
                                                                                                                                <?php
                                                                                                                                $emp_id = isset($emp_loc_post_data1['emp_id']) ? $emp_loc_post_data1['emp_id'] : "";
                                                                                                                                $selected = $emp_id == $employee['user_id'] ? "selected" : "";
                                                                                                                                ?>
                                                                                                                                <option value="<?php echo $employee['user_id']; ?>" <?php echo $selected; ?>><?php echo $employee['user_person_name']; ?></option>
                                                                                                                        <?php endforeach; ?>
                                                                                                                <?php endif; ?>
                                                                                                        <?php endif; ?>

                                                                                                </select>
                                                                                        </div> -->

                                                                                        <!-- <div class="form-group col-md-2">
                                                                                                <select class="form-control" id="transfer_to" name="transfer_to" onchange="table_list(1);">
                                                                                                        <option value=""> Select Transfered To</option>
                                                                                                        <?php if (!empty($employee_list)) {
                                                                                                                foreach ($employee_list as $employee) {
                                                                                                                        $selected  = $added_by == $employee['user_id'] ? "selected" : ""; ?>
                                                                                                                        <option value="<?php echo $employee['user_id']; ?>" <?php echo $selected; ?>><?php echo $employee['emp_name']; ?></option>
                                                                                                        <?php }
                                                                                                        } ?>
                                                                                                </select>
                                                                                        </div> -->

                                                                                        <div class="form-group col-lg-2 col-md-2">
                                                                                                <!-- <select class="form-control" id="transfer_to" name="transfer_to" onchange="table_list(1);"> -->
                                                                                                        <!-- add by ritika -->
                                                                                                      <select class="form-control selectpicker" id="transfer_to" name="transfer_to"data-live-search="true" onchange="table_list(1);"> 
                                                                                                <option value="">Transfer To</option>

                                                                                                        <?php if ($roleId == 1 || $roleId == 2): ?>
                                                                                                                <!-- Role is 1: Show employees from employee_list -->
                                                                                                                <?php if (!empty($employee_list)): ?>
                                                                                                                        <?php foreach ($employee_list as $employee): ?>
                                                                                                                                <?php
                                                                                                                                $emp_id = isset($emp_loc_post_data1['emp_id']) ? $emp_loc_post_data1['emp_id'] : "";
                                                                                                                                // $selected = $emp_id == $employee['emp_id'] ? "selected" : "";
                                                                                                                                //added anjali dhane 26/06/2026
                                                                                                                                $selected = ($selected_transfer_to == $employee['user_id']) ? "selected" : "";
                                                                                                                                ?>
                                                                                                                                <option value="<?php echo $employee['user_id']; ?>" <?php echo $selected; ?>><?php echo $employee['emp_name']; ?></option>
                                                                                                                        <?php endforeach; ?>
                                                                                                                <?php endif; ?>

                                                                                                        <?php else: ?>
                                                                                                                <!-- Role is not 1: Show employees from direct_employeee -->
                                                                                                                <?php if (!empty($direct_employeee)): ?>
                                                                                                                        <?php foreach ($direct_employeee as $employee): ?>
                                                                                                                                <?php
                                                                                                                                $emp_id = isset($emp_loc_post_data1['emp_id']) ? $emp_loc_post_data1['emp_id'] : "";
                                                                                                                                // $selected = $emp_id == $employee['user_id'] ? "selected" : "";
                                                                                                                                //added anjali dhane 26/06/2026
                                                                                                                                $selected = ($selected_transfer_to == $employee['user_id']) ? "selected" : "";
                                                                                                                                ?>
                                                                                                                                <option value="<?php echo $employee['user_id']; ?>" <?php echo $selected; ?>><?php echo $employee['user_person_name']; ?></option>
                                                                                                                        <?php endforeach; ?>
                                                                                                                <?php endif; ?>
                                                                                                        <?php endif; ?>

                                                                                                </select>
                                                                                        </div>

                                                                                        <div class="form-group col-md-2">
                                                                                                <select class="form-control selectpicker" id="priority" name="priority" data-live-search="true" onchange="table_list(1);">
                                                                                                        <option value=""> Select Priority</option>
                                                                                                        <?php if (!empty($priority_list)) {
                                                                                                                foreach ($priority_list as $prity) {
                                                                                                                        $selected = $priority == $prity ? "selected" : ""; ?>
                                                                                                                        <option value="<?php echo $prity ?>" <?php echo $selected; ?>><?php echo $prity; ?></option>
                                                                                                        <?php }
                                                                                                        } ?>
                                                                                                </select>
                                                                                        </div>
                                                                                        <div class="form-group col-md-2">
                                                                                                <input type="text" class="form-control pull-right datepickerD" id="lead_date" name="lead_date" placeholder="Date" maxlength="10" value="<?php echo isset($lead_post_data['lead_date']) ? $lead_post_data['lead_date'] : ""; ?>" readonly="true">
                                                                                        </div>
                                                                                        <div class="form-group col-md-2">
											 <!-- Added by Anjali 29/06/26 -->
											<input type="text" class="form-control pull-right datepickerMY" id="lead_month_year" name="lead_month_year" placeholder="Month" maxlength="7" value="<?php echo htmlspecialchars(!empty($lead_month_year) ? $lead_month_year : $saved_lead_month_year, ENT_QUOTES, 'UTF-8'); ?>" readonly="true">
                                                                                        </div>
                                                                                        <div class="form-group col-md-2">
                                                                                                <select class="form-control selectpicker" id="state_id" name="state_id" data-live-search="true" onchange="get_state_districts(this,'dist_id');table_list(1);">
                                                                                                        <option value=""> Select State</option>
                                                                                                        <?php if (!empty($state_list)) {
                                                                                                                foreach ($state_list as $state) {
                                                                                                                        $selected  = $state_id == $state['state_id'] ? "selected" : ""; ?>
                                                                                                                        <option value="<?php echo $state['state_id']; ?>" <?php echo $selected; ?>><?php echo $state['state_name']; ?></option>
                                                                                                        <?php }
                                                                                                        } ?>
                                                                                                </select>
                                                                                        </div>
                                                                                        <div class="form-group col-md-2">
                                                                                                <select class="form-control selectpicker" id="dist_id" name="dist_id" data-live-search="true" onchange="get_district_cities(this,'state_id','city_id');table_list(1);">
                                                                                                        <option value=""> Select District</option>
                                                                                                        <?php if (!empty($dist_list)) {
                                                                                                                foreach ($dist_list as $dist) {
                                                                                                                        $selected      = $dist_id == $dist['dist_id'] ? "selected" : ""; ?>
                                                                                                                        <option value="<?php echo $dist['dist_id']; ?>" <?php echo $selected; ?>><?php echo $dist['dist_name']; ?></option>
                                                                                                        <?php }
                                                                                                        } ?>
                                                                                                </select>
                                                                                        </div>
                                                                                        <div class="form-group col-md-2">
                                                                                                <select class="form-control selectpicker" id="city_id" name="city_id" data-live-search="true" onchange="get_city_area(this,'state_id','dist_id','area_id');table_list(1);">
                                                                                                        <option value=""> Select City</option>
                                                                                                        <?php if (!empty($city_list)) {
                                                                                                                foreach ($city_list as $city) {
                                                                                                                        $selected      = $city_id == $city['city_id'] ? "selected" : ""; ?>
                                                                                                                        <option value="<?php echo $city['city_id']; ?>" <?php echo $selected; ?>><?php echo $city['city_name']; ?></option>
                                                                                                        <?php }
                                                                                                        } ?>
                                                                                                </select>
                                                                                        </div>
                                                                                        <div class="form-group col-md-2">
                                                                                                <select class="form-control selectpicker" id="area_id" name="area_id" data-live-search="true" onchange="table_list(1);">
                                                                                                        <option value=""> Select Area</option>
                                                                                                        <?php if (!empty($area_list)) {
                                                                                                                foreach ($area_list as $area) {
                                                                                                                        $selected = $area_id == $area['area_id'] ? "selected" : "";
                                                                                                        ?>
                                                                                                                        <option value="<?php echo $area['area_id']; ?>" <?php echo $selected; ?>><?php echo $area['area_name']; ?></option>
                                                                                                        <?php }
                                                                                                        } ?>
                                                                                                </select>
                                                                                        </div>
                                                                                </div>
                                                                        </form>
                                                                </div>

                                                                <table class="table table-striped table-bordered table-hover  dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch" role="grid" aria-describedby="sample_1_info">
                                                                        <thead>
                                                                                <tr>
                                                                                        <th width="2%">Sr. No.</th>
                                                                                        <th>Lead Name </th>
                                                                                        <th>Contact Person</th>
                                                                                        <th>Company Name</th>
                                                                                        <th>Contact No</th>
                                                                                        <!-- Changes by Shawn Arakal - 14-08-2026: Reference column added to show the lead source reference (e.g. Facebook Lead API) -->
                                                                                        <th>Reference</th>
                                                                                        <th style="display:none;" class="action-col">
                                                                                                <input type="checkbox" id="selectAllLeads" class="select-all-checkbox"> Select All Leads
                                                                                        </th>

                                                                                        <th style="display:none;" class="owner-col">Current Owner </th>
                                                                                        <!-- <th style="text-align:center" width="10%">Status</th> -->
                                                                                </tr>
                                                                        </thead>
                                                                        <tbody id="tbl_list">
                                                                        </tbody>

                                                                </table>

                                                                <!-- Render pagination links -->
                                                                <div class="pagination" style="float:right;">




                                                                </div>

                                                        </div>
                                                        <button id="submitButton" class="btn btn-success" style="display: none; margin-right:40px; margin-top:9px;">Transfer Leads</button>
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


        <!-- Lead Transfer Modal -->
        <div id="leadTransferModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="leadTransferModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                        <div class="modal-content" style="background-color: white;">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="leadTransferModalLabel">Transfer Leads</h4>
                                </div>
                                <div class="modal-body">
                                        <form id="add_edit_form" method="post" autocomplete="off">
                                                <div class="form-group">
                                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                        <input type="hidden" name="selected_leads" id="selected_leads">

                                                        <label for="assign_to">Lead Transfer To <?php echo REQUIRED_STAR; ?></label>
                                                        <!-- <select class="form-control" id="assign_to" name="assign_to" maxlength="100" data-live-search="true" required> -->
                                                               <select class="form-control selectpicker"  id="assign_to" name="assign_to" maxlength="100"data-live-search="true" required>
                                                        <option value="">Lead Transfer To</option>
                                                                <?php if (!empty($employee_list)) {
                                                                        foreach ($employee_list as $employee) { ?>
                                                                                <option value="<?php echo $employee['user_id']; ?>"><?php echo $employee['emp_name']; ?></option>
                                                                <?php }
                                                                } ?>
                                                        </select>
                                                        <?php echo form_error('assign_to', '<span class="text-danger">', '</span>'); ?>
                                                </div>

                                                <div class="form-actions text-center">
                                                        <button class="btn btn-success" type="button" id="confirmTransfer">Submit</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                </div>
                                        </form>
                                </div>
                        </div>
                </div>
        </div>
</div>



<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
        // Added by Anjali 29/06/26
        var initialLeadSummaryFilters = <?php echo json_encode(array(
                'emp_id' => (string) $selected_emp,
		'transfer_to' => (string) $selected_transfer_to,
                'status' => (string) $selected_status,
                'lead_month_year' => (string) $lead_month_year,
        )); ?>;
        var initialLeadSummaryRequestPending = initialLeadSummaryFilters.emp_id !== '' ||
		initialLeadSummaryFilters.transfer_to !== '' ||
                initialLeadSummaryFilters.status !== '' ||
                initialLeadSummaryFilters.lead_month_year !== '';

        if (initialLeadSummaryFilters.emp_id !== '') {
                $('#emp_id').val(initialLeadSummaryFilters.emp_id);
        }
	if (initialLeadSummaryFilters.transfer_to !== '') {
		$('#transfer_to').val(initialLeadSummaryFilters.transfer_to);
	}
        if (initialLeadSummaryFilters.status !== '') {
                $('#status').val(initialLeadSummaryFilters.status);
        }
        if (initialLeadSummaryFilters.lead_month_year !== '') {
                $('#lead_month_year').val(initialLeadSummaryFilters.lead_month_year);
        }
        if ($.fn.selectpicker) {
		$('#emp_id, #transfer_to').selectpicker('refresh');
        }

        $(document).ready(function() {

                sessionStorage.removeItem('selectedLead');
                sessionStorage.removeItem('leadColumnVisible');
                selectedLeads.clear();

                sessionStorage.setItem('leadColumnVisible', 'false');

                applyColumnState();

                $("#clear_btn").click(function(e) {
                        $('#lead_date, #lead_month, #lead_year').val('');
                        $('#followup, #emp_id, #status, #searchStr_name').val('');
                        $('#searchStr_contact, #ref_id, #product_id, #product_type').val('');
                        $('#added_by, #priority, #state_id').val('');
                        $('#dist_id, #city_id').val('');
                        // $('#srch_form').trigger("reset");
                        // table_list(1);
                        // add by ritika 30 may 
                        $('#srch_form').trigger("reset");
				// Added by Anjali 29/06/26
				$('#summary_employee_name').val('');

                        $('.selectpicker').selectpicker('val', '');

                        $('.selectpicker').selectpicker('refresh');

                        table_list(1);
                });

                // When a fields is selected, clear the date field

                $("#emp_id").click(function() {
				// Added by Anjali 29/06/26
				$('#summary_employee_name').val('');
                        $('#added_by, #transfer_to, #ref_id').val('');
                });

                $("#added_by").click(function() {
                        $('#emp_id, #transfer_to, #ref_id').val('');
                });

                $("#transfer_to").click(function() {
                        $('#added_by, #emp_id, #ref_id').val('');
                });

                $("#ref_id").click(function() {
                        $('#added_by, #emp_id, #transfer_to').val('');
                });

                $("#download_lead_report").click(function(e) {
                        $('#srch_form').attr("action", base_url + "leads/download_lead_report");
                        $('#srch_form').attr("onsubmit", "");
                        $('#srch_form').submit();
                        $('#srch_form').attr("action", "");
                        $('#srch_form').attr("onsubmit", "return false;");

                });

                $("#download_team_lead_report").click(function(e) {
                        $('#srch_form').attr("action", base_url + "leads/download_team_lead_report");
                        $('#srch_form').attr("onsubmit", "");
                        $('#srch_form').submit();
                        $('#srch_form').attr("action", "");
                        $('#srch_form').attr("onsubmit", "return false;");

                });

                // When a date is selected, clear the month field
                $('#lead_date').change(function() {
                        $('#lead_month_year').val('');
                });

                // When a month is selected, clear the date field
                $('#lead_month_year').change(function() {
                        $('#lead_date').val('');
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
                        $('#lead_month_year').val('');
                        table_list(1);
                });;

                $('.datepickerMY').datepicker({
                        format: 'mm-yyyy',
                        autoclose: true,
                        todayHighlight: true,
                        viewMode: "months",
                        minViewMode: "months"

                }).on('changeDate', function(e) {
                        $('#lead_date').val('');
                        table_list(1);
                });;


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
                                //             $('table tr td:nth-child(5), table tr td:nth-child(6)').hide();
                                // $('table tr th:nth-child(5), table tr th:nth-child(6)').hide();
                                // $('#submitButton').hide();
                        }

                });

		// Added by Anjali 29/06/26
		// Datepicker/selectpicker initialization can reset values applied above.
		// Reapply URL filters before making the one initial table request.
		if (initialLeadSummaryRequestPending) {
			if (initialLeadSummaryFilters.emp_id !== '') {
				$('#emp_id').val(initialLeadSummaryFilters.emp_id);
			}
			if (initialLeadSummaryFilters.transfer_to !== '') {
				$('#transfer_to').val(initialLeadSummaryFilters.transfer_to);
			}
			if (initialLeadSummaryFilters.status !== '') {
				$('#status').val(initialLeadSummaryFilters.status);
			}
			if (initialLeadSummaryFilters.lead_month_year !== '') {
				$('#lead_month_year').val(initialLeadSummaryFilters.lead_month_year);
			}
			if ($.fn.selectpicker) {
				$('#emp_id, #transfer_to').selectpicker('refresh');
			}
		}

        table_list(<?php echo $page; ?>);

        });

        function set_enquiry_filter(obj) {
                var type = $('option:selected', obj).attr('data-type') || '';
                $('#product_type').val(type);
                table_list(1);
        }

        function table_list(pageno) {
                $('#product_type').val($('#product_id option:selected').attr('data-type') || '');
                var formdata = $("#srch_form").serializeArray();

                // Added by Anjali 29/06/26: guarantee summary filters in the first AJAX payload.
                if (initialLeadSummaryRequestPending) {
                        $.each(initialLeadSummaryFilters, function(name, value) {
                                if (value === '') {
                                        return;
                                }

                                formdata = $.grep(formdata, function(field) {
                                        return field.name !== name;
                                });
                                formdata.push({name: name, value: value});
                        });
                }

                $("#tbl_list").html("");
                $.ajax({
                        url: base_url + "ajax/tbl_lead_list_new/" + pageno,
                        type: "POST",
                        data: formdata,
                        datatype: "json",
                        async: true,
                        cache: false,
                        success: function(data) {
				// Added by Anjali 29/06/26
				initialLeadSummaryRequestPending = false;
                                var json_arr = JSON.parse(data);
                                var html_data = '';
                                var html_data = json_arr.list;
                                var total_count = json_arr.total_count;

                                $(".total_count").html("( Total - " + total_count + " )");
                                $("#tbl_list").html(html_data);
                                $('.pagination').html(json_arr.pagination);
                                $(".loader").fadeOut();

                                applyColumnState();
                                restoreSelection();
                        }
                });
        }
</script>

<!-- Vihas added on 03/04/2026 -->
<script>
        var selectedLeads = new Set();

        // Toggle column
        $('#toggleCheckbox').click(function() {

                var isVisible = $('.action-col:visible').length > 0;

                if (isVisible) {
                        sessionStorage.setItem('leadColumnVisible', 'false');
                } else {
                        sessionStorage.setItem('leadColumnVisible', 'true');
                }

                applyColumnState();
        });

        function applyColumnState() {
                var isVisible = sessionStorage.getItem('leadColumnVisible') === 'true';

                if (isVisible) {
                        $('.action-col').show();
                        $('.owner-col').show();
                        $('#submitButton').show();
                } else {
                        $('.action-col').hide();
                        $('.owner-col').hide();
                        $('#submitButton').hide();
                }
        }

        // Select all
        $(document).on('change', '#selectAllLeads', function() {
                var checked = $(this).prop('checked');

                $('.lead-checkbox').each(function() {
                        var id = $(this).data('id').toString();

                        $(this).prop('checked', checked);

                        if (checked) {
                                selectedLeads.add(id);
                        } else {
                                selectedLeads.delete(id);
                        }
                });

                sessionStorage.setItem('selectedLeads', JSON.stringify([...selectedLeads]));
        });

        // Individual select
        $(document).on('change', '.lead-checkbox', function() {
                var id = $(this).data('id').toString();

                if ($(this).is(':checked')) {
                        selectedLeads.add(id);
                } else {
                        selectedLeads.delete(id);
                }

                sessionStorage.setItem('selectedLeads', JSON.stringify([...selectedLeads]));
                $('#selectAllLeads').prop(
                        'checked',
                        $('.lead-checkbox').length === $('.lead-checkbox:checked').length
                );
        });

        // Open modal
        $('#submitButton').click(function() {
                $('#leadTransferModal').modal('show');
        });

        function showError(message) {
                const el = $('#form_err');

                el.stop(true, true);

                el.css('display', 'block')
                        .html(`
                                <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <span class="alert-text">${message}</span>
                                </div>
                        `)
                        .removeClass('text-success text-danger')
                        .fadeIn(200);

                setTimeout(() => {
                        el.fadeOut(300);
                }, 3500);
        }

        function restoreSelection() {
                $('.lead-checkbox').each(function() {
                        var id = $(this).data('id').toString();

                        if (selectedLeads.has(id)) {
                                $(this).prop('checked', true);
                        }
                });

                // Update select all checkbox
                $('#selectAllLeads').prop(
                        'checked',
                        $('.lead-checkbox').length === $('.lead-checkbox:checked').length
                );
        }


        // Submit transfer
        $('#confirmTransfer').click(function(e) {
                e.preventDefault();
                var emp = $('#assign_to').val();

                if (selectedLeads.size === 0) {
                        $('#leadTransferModal').modal('hide');
                        showError("Please select the lead to transfer");
                        return;
                }

                if (!emp) {
                        $('#leadTransferModal').modal('hide');
                        showError("Please select the Employee to whom the lead to be transfer");
                        return;
                }

                $.ajax({
                        url: base_url + "leads/transfer_multiple",
                        type: "POST",
                        data: {
                                selected_leads: [...selectedLeads],
                                assign_to: emp
                        },
                        success: function(response) {
                                var res = typeof response === "string" ? JSON.parse(response) : response;

                                if (res.status === 'success') {
                                        $('#leadTransferModal').modal('hide');
                                        sessionStorage.removeItem('selectedLeads');
                                        sessionStorage.removeItem('leadColumnVisible');
                                        selectedLeads.clear();
                                        showSuccess("Tickets transferred successfully");
                                        table_list(1);
                                } else {
                                        $('#leadTransferModal').modal('hide');
                                        location.reload();
                                        sessionStorage.setItem('selectedLeads', null);
                                        sessionStorage.setItem('isColumnHidden', null);
                                }
                        },
                        error: function() {
                                showError('There was an error submitting the leads');
                        }
                });
        });

        function showSuccess(message) {
                const el = $('#form_success');

                el.stop(true, true);

                el.css('display', 'block')
                        .html(`
                        <div class="alert alert-success alert-dismissable">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>	
                                <span class="alert-text">${message}</span>
                        </div>
                        `)
                        .fadeIn(200);

                setTimeout(() => {
                        el.fadeOut(300);
                }, 3000);
        }
</script>
<!-- add by ritika 30 may -->
<script>
// $(document).ready(function () {

//     $('.selectpicker').selectpicker();

// });
// //changes done by anjali dhane 26/06/26
// $(document).ready(function() {

//     var emp = "<?= $selected_emp;?>";
//     var status = "<?= $selected_status;?>";

//     if(emp!="")
//     {
//         loadLeadList();     // your existing function
//     }

// });
</script>
