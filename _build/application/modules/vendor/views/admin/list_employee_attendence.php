<?php 
// Assuming $vendor and other session-related data remain relevant for attendance

$vendor  = $this->session->userdata('vendor');
$role_id = $vendor['user_role_id'];
?>

<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE BASE CONTENT -->
        
        <!-- ... -->

        <div class="portlet-body">
            <!-- ... -->

            <form id="attendance_form" autocomplete="off" onsubmit="return false;" method="post">
                <div class="col-md-12">
                    <div class="form-group col-md-4">                           
                        <select class="form-control" id="emp_id" name="emp_id" onchange="getAttendance(1);">
                            <option value="">Select Employee</option>
                            <?php if(!empty($employee_list)) { 
                                foreach($employee_list as $employee) { 
                                    $emp_id = isset($emp_loc_post_data['emp_id']) ? $emp_loc_post_data['emp_id'] : "";
                                    $selected = $emp_id == $employee['emp_id'] ? "selected" : "";
                            ?>
                                <option value="<?php echo $employee['user_id'];?>" <?php echo $selected;?>><?php echo $employee['emp_name']; ?></option>
                            <?php } } ?>    
                        </select>                         
                    </div> 

                    <div class="form-group col-md-4"> 
                        <input type="text" class="form-control pull-right datepicker" id="date" name="date" placeholder="Date..." maxlength="10" value="<?php echo isset($emp_loc_post_data['date']) ? $emp_loc_post_data['date'] : "";?>"  >
                    </div>	

                    <!-- Other form inputs for attendance -->

                    <button type="button" class="btn btn-primary" id="submit_attendance">Submit</button>
                </div>
            </form>

            <table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
                <!-- Table headers for attendance data -->
                <thead>
                    <tr>
                        <th width="2%">Sr. No.</th>
                        <th width="10%">Date</th>        				  
                        <th width="10%">Time</th>               
                        <th>Status</th>               
                    </tr>
                </thead>
                <tbody id="attendance_list">
                    <!-- Attendance data rows will be populated here -->
                </tbody>
            </table> 

            <!-- Pagination section -->
            <div class="pagination" style="float:right;">
                <!-- Pagination links will appear here -->
            </div>
        </div>
        
        <!-- ... -->

    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    // ...

    // Function to fetch and display attendance data
    function getAttendance(pageNo) {
        var formData = $("#attendance_form").serializeArray();
        $("#attendance_list").html("");
        $.ajax({
            url: base_url + "ajax/get_attendance/" + pageNo,
            type: "POST",
            data: formData,
            dataType: "json",
            async: true,
            cache: false,
            success: function(data) {
                var htmlData = data.list;
                var totalCount = data.total_count;

                $("#attendance_list").html(htmlData);
                $(".total_count").html("(Total - " + totalCount + ")");
                $('.pagination').html(data.pagination);
            }
        });
    }

    // Handle click event to get attendance data
    $('#submit_attendance').click(function() {
        getAttendance(1);
    });

    // ...
});
</script>
