<div class="page-content-wrapper">
    <div class="page-content">

        <div class="row">

            <div class="col-md-12">

                <div class="portlet light bordered">
                    <ul class="page-breadcrumb breadcrumb">

                        <li><a href="<?php echo base_url(get_module() . "/dashboard") ?>">Home</a><i class="fa fa-circle"></i></li>
                        <li><a href="<?php echo base_url(get_module() . "/inventory/inventory_consumption_report") ?>">Inventory Consumption Report</a><i class="fa fa-circle"></i></li>

                        <!-- <i class="fa fa-circle"></i> -->
                        <li><span class="active">Add Inventory Consumption</span></li>

                    </ul>

                    <form
                        method="post"
                        action="<?php echo get_module_path(); ?>inventory/add_inventory_consumption"
                        id="inventory_consumption">

                        <div class="form-body">
                            <div class="row">

                                <div class="form-group col-md-3">

                                    <label>

                                        Consumption Date

                                        <?php echo REQUIRED_STAR; ?>

                                    </label>

                                    <input
                                        type="date"
                                        name="consume_date"
                                        class="form-control"
                                        value="<?php echo date('Y-m-d'); ?>">

                                </div>

                                <div class="form-group col-md-3">

                                    <label>

                                        Employee

                                        <?php echo REQUIRED_STAR; ?>

                                    </label>

                                    <select name="employee_id"
                                        class="form-control selectpicker"
                                        data-live-search="true">
                                        <option value="">

                                            Select Employee

                                        </option>

                                        <?php

                                        foreach ($employee_list as $emp) {

                                        ?>

                                            <option value="<?php echo $emp['emp_id']; ?>">

                                                <?php echo $emp['emp_name']; ?>

                                            </option>

                                        <?php

                                        }

                                        ?>

                                    </select>



                                </div>
                                <style>
                                    .bootstrap-select .dropdown-menu {
                                        min-width: 100% !important;
                                        width: 100% !important;
                                    }
                                </style>

                                <div class="form-group col-md-3">

                                    <label>

                                        Purpose

                                    </label>

                                    <input
                                        type="text"
                                        name="purpose"
                                        class="form-control">

                                </div>

                                <div class="form-group col-md-3">


                                    <label>

                                        Remarks

                                    </label>

                                    <input
                                        type="text"
                                        name="remarks"
                                        class="form-control">
                                </div>

                            </div>
                            <div class="clearfix"></div>


                            <!-- <div class="col-md-12">
                                <div class="portlet-title">
                                    <br />
                                    <div class="caption">
                                        <i class="font-red-mint icon-basket"></i>
                                        <span class="caption-subject font-red-mint sbold">
                                            Item Details
                                        </span>
                                    </div>
                                    <hr style="margin:3px;" />
                                </div>
                            </div> -->

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="portlet-title">

                                        <div class="caption">
                                            <i class="fa fa-shopping-cart font-red"></i>

                                            <span class="caption-subject font-red sbold">
                                                Item Details
                                            </span>
                                        </div>

                                        <hr style="margin-top:5px;margin-bottom:10px;">

                                    </div>

                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    <table class="table table-bordered table-striped" id="tbl_item">

                                        <thead>

                                            <tr>

                                                <th width="35%">Item</th>

                                                <th width="15%">Available Stock</th>

                                                <th width="15%">Unit</th>

                                                <th width="15%">Issue Qty</th>

                                                <th width="10%">Action</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            <!-- <tr> -->
                                                <tr id="itemRowTemplate">

                                                <td>

                                                    <select name="item_id[]"
                                                        class="form-control item_id selectpicker"
                                                        data-live-search="true">
                                                        <option value="">Select Item</option>

                                                        <?php
                                                        if (!empty($item_list)) {
                                                            foreach ($item_list as $item) {
                                                        ?>

                                                                <option
                                                                    value="<?php echo $item['item_id']; ?>"
                                                                    data-stock="<?php echo $item['item_qty']; ?>"
                                                                    data-unit="<?php echo $item['inv_unit_name']; ?>">

                                                                    <?php echo $item['item_name']; ?>

                                                                </option>

                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                                    </select>

                                                </td>

                                                <td>

                                                    <input
                                                        type="text"
                                                        class="form-control stock"
                                                        readonly>

                                                </td>

                                                <td>

                                                    <input
                                                        type="text"
                                                        class="form-control unit"
                                                        readonly>

                                                </td>

                                                <td>

                                                    <input
                                                        type="number"
                                                        name="qty[]"
                                                        class="form-control"
                                                        min="1">

                                                </td>

                                                <td align="center">

                                                    <button
                                                        type="button"
                                                        class="btn btn-success addRow">

                                                        <i class="fa fa-plus"></i>

                                                    </button>

                                                </td>

                                            </tr>

                                        </tbody>

                                    </table>

                                </div>
                            </div>


                            <div class="row">
                                <div class="form-actions">

                                    <div class="col-md-12">

                                        <center>

                                            <button
                                                type="submit"
                                                class="btn btn-success">

                                                Save Consumption

                                            </button>

                                            <a
                                                href="<?php echo get_module_path(); ?>inventory/inventory_consumption_report"
                                                class="btn btn-danger">

                                                Back

                                            </a>

                                        </center>

                                    </div>

                                </div>

                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>

<script>
    $(document).ready(function() {

        $(document).on("change", ".item_id", function() {

            var row = $(this).closest("tr");

            var stock = $(this).find(":selected").data("stock");

            var unit = $(this).find(":selected").data("unit");

            row.find(".stock").val(stock);

            row.find(".unit").val(unit);

        });

    });
</script>

<!-- <script>
  

    $(document).on("click", ".addRow", function() {
          var itemOptions = $(".item_id:first").html();

        var html = "";

        html += '<tr>';

        // html += '<td>' + $(this).closest("tr").find("td:eq(0)").html() + '</td>';

        html += '<td>';

        html += '<select name="item_id[]" class="form-control item_id selectpicker" data-live-search="true">';

        html += itemOptions;

        html += '</select>';

        html += '</td>';

        html += '<td><input type="text" class="form-control stock" readonly></td>';

        html += '<td><input type="text" class="form-control unit" readonly></td>';

        html += '<td><input type="number" name="qty[]" class="form-control" min="1"></td>';

        html += '<td align="center">';

        html += '<button type="button" class="btn btn-danger removeRow">';

        html += '<i class="fa fa-minus"></i>';

        html += '</button>';

        html += '</td>';

        html += '</tr>';

        $("#tbl_item tbody").append(html);

       $("#tbl_item tbody tr:last .selectpicker").selectpicker();

    });

    $(document).on("click", ".removeRow", function() {

        $(this).closest("tr").remove();

    });
</script> -->


<script>

$(document).on("click", ".addRow", function () {

    // Clone first row
    var newRow = $("#itemRowTemplate").clone();

    // Remove ID so duplicate IDs are not created
    newRow.removeAttr("id");

    // Reset values
    newRow.find(".item_id").val("");
    newRow.find(".stock").val("");
    newRow.find(".unit").val("");
    newRow.find("input[name='qty[]']").val("");

    // Destroy old bootstrap-select generated HTML
    newRow.find(".bootstrap-select").remove();

    // Show original select
    newRow.find(".item_id").show();

    // Change + button to - button
    newRow.find(".addRow")
        .removeClass("btn-success addRow")
        .addClass("btn-danger removeRow")
        .html('<i class="fa fa-minus"></i>');

    // Add row
    $("#tbl_item tbody").append(newRow);

    // Initialize bootstrap-select only for new row
   // $("#tbl_item tbody tr:last .item_id").selectpicker();
 $("#tbl_item tbody tr:last .item_id").selectpicker();
$("#tbl_item tbody tr:last .item_id").selectpicker('refresh');

});

$(document).on("click", ".removeRow", function () {

    $(this).closest("tr").remove();

});

</script>