<?php $role_id = $this->session->userdata('user_role_id'); ?>

<div class="page-content-wrapper">

    <div class="page-content">

        <div class="row">

            <div class="col-md-12">

                <div class="portlet light bordered">

                    <!-- Page Heading -->

                    <div class="col-lg-9 col-sm-12">

                        <span class="caption-subject font-green-sharp sbold pull-left">
                            Inventory Consumption Report
                        </span>

                        <span class="caption-subject font-red-mint sbold total_count">
                            ( Total - 0 )
                        </span>

                    </div>

                    <center>
                        <a class="btn btn-success btn-sm" href="<?php echo get_module_path(); ?>inventory/inventory_consumption"><i class="fa fa-plus"></i>Add Consumption</a>
                    </center>

                    <br>

                    <div class="row">

                        <div class="col-md-12">

                            <div class="portlet-body">

                                <?php
                                $this->load->helper('form');

                                $error = $this->session->flashdata('error');

                                if ($error) {
                                ?>

                                    <div class="alert alert-danger">

                                        <?php echo $error; ?>

                                    </div>

                                <?php } ?>

                                <?php

                                $success = $this->session->flashdata('success');

                                if ($success) {

                                ?>

                                    <div class="alert alert-success">

                                        <?php echo $success; ?>

                                    </div>

                                <?php } ?>



                                <div class="col-md-12 table-group-actions">

                                    <form id="srch_form"
                                        autocomplete="off"
                                        onsubmit="return false;"
                                        method="post">

                                        <div class="form-group col-md-2">

                                            <label>From Date</label>

                                            <input
                                                type="date"
                                                name="from_date"
                                                id="from_date"
                                                class="form-control"
                                                onchange="table_list(1);">

                                        </div>

                                        <div class="form-group col-md-2">

                                            <label>To Date</label>

                                            <input
                                                type="date"
                                                name="to_date"
                                                id="to_date"
                                                class="form-control"
                                                onchange="table_list(1);">

                                        </div>

                                        <div class="form-group col-md-3">

                                            <label>Employee</label>

                                            <select
                                                name="employee_id"
                                                id="employee_id"
                                                class="form-control"
                                                onchange="table_list(1);">

                                                <option value="">Select Employee</option>

                                                <?php
                                                if (!empty($employee_list)) {
                                                    foreach ($employee_list as $emp) {
                                                ?>

                                                        <option value="<?php echo $emp['emp_id']; ?>">

                                                            <?php echo $emp['emp_name']; ?>

                                                        </option>

                                                <?php
                                                    }
                                                }
                                                ?>

                                            </select>

                                        </div>

                                        <div class="form-group col-md-2">

                                            <label>Purpose</label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                name="purpose"
                                                id="purpose"
                                                onchange="table_list(1);">

                                        </div>

                                        <div class="form-group col-md-3">

                                            <label>Search</label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                name="searchStr"
                                                id="searchStr"
                                                placeholder="Search..."
                                                onchange="table_list(1);">

                                        </div>

                                    </form>

                                </div>

                                <div class="tbl-container">

                                    <table
                                        class="table table-striped table-bordered table-hover"
                                        id="Srtable">

                                        <thead>

                                            <tr>

                                                <th width="5%">Sr No</th>

                                                <th>Consumption No</th>

                                                <th>Date</th>

                                                <th>Employee</th>

                                                <th>Purpose</th>

                                                <th>Total Items</th>

                                                <th>Status</th>

                                                <th width="12%">Action</th>

                                            </tr>

                                        </thead>

                                        <tbody id="tbl_list">

                                        </tbody>

                                    </table>

                                    <div
                                        class="pagination"
                                        style="float:right;">

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>