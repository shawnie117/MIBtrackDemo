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


						 
        </div>
				   <!-- <div class="col-md-12"> 
				  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
						<?php if($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID){ ?>
						 <div class="form-group col-md-3">  
						 <select class="form-control" id="report_to" name="report_to" onchange="table_list(1);">
							<option value="">Select Assigned To </option>
							 <?php  if(!empty($employee_list)){ 
								foreach($employee_list as $employee){ 
								   $report_to   = isset($team_followup_post_data['report_to'])?$team_followup_post_data['report_to']:"";
									     $selected = $report_to==$employee['user_id']?"selected":"";	
								?>
									<option value="<?php echo $employee['user_id'];?>"   <?php echo $selected;?>><?php echo $employee['emp_name']; ?></option>
							<?php } } ?>	
						   </select>
                          </div>
						<?php } ?>						  
							
                        </form>
				    </div> -->
                       
			  <div class="row">
                 
				
		 <div class="col-md-12">
			<div class="portlet-body"> 
               <div class="col-md-1">                                                   
      <?php
                     $this->load->helper('form');
                     $error = $this->session->flashdata('error');
                     if($error)
                     {
                     ?>
                  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
                     <?php echo $this->session->flashdata('error'); ?>
                  </div>
                  <?php } ?>
                  <?php  
                     $success = $this->session->flashdata('success');
                     if($success)
                     {
                     ?>
                  <div class="alert alert-success alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
                     <?php echo $this->session->flashdata('success'); ?>
                  </div>
                  <?php } ?>
                 
                  </div>
		    <?php $team_followup_post_data = array();
			      $page = "1";
			      $history = $this->input->get('history');
				  if($history == "back")
				  {
					  $team_followup_post_data = $this->session->userdata('team_followup_post_data');
					  $page = 	$team_followup_post_data['page'];				  
				  } 
			?>    
							  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">

							  <div class="row" id="filterRow">
							  <!-- <div class="col-md-3">
    <input 
        class="form-control datepicker" 
        id="date" 
        name="date" 
        required 
        type="text" 
        placeholder="Date" 
        maxlength="15" 
        value="<?php echo isset($cbilling_post_data['date']) ? htmlspecialchars($cbilling_post_data['date']) : ''; ?>">
</div>  -->


    <!-- <div class="form-group col-lg-4 col-md-4">
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
    </div> -->

	<div class="form-group col-lg-4 col-md-4">
    <select class="form-control" id="emp_id" name="emp_id" onchange="table_list(1);">
        <option value="">Select Employee</option>
        
        <?php if ($roleId == 1 || $roleId == 2): ?>
            <!-- Role is 1: Show employees from employee_list -->
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
            <!-- Role is not 1: Show employees from direct_employeee -->
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
</div>

	<div class="form-group col-lg-3 col-md-3 "> 
        <input class="form-control datepickerMY" id="month_year" name="month_year"  type="text" placeholder="To Month -Year" maxlength="15" value="<?php echo isset($emp_loc_post_data1['month_year'])?$emp_loc_post_data1['month_year']:"";?>">
	</div>	

    <div class="form-group col-lg-3 col-md-3"> 
        <input class="form-control datepicker" id="from_date" name="from_date" required type="text" placeholder="From Date" maxlength="15" value="<?php echo isset($order_post_data['from_date'])?$order_post_data['from_date']:"";?>">
    </div>

    <div class="form-group col-lg-3 col-md-3"> 
        <input type="text" class="form-control pull-right datepicker" id="date" name="date" placeholder="To Date" maxlength="10" value="<?php echo isset($emp_loc_post_data['date'])?$emp_loc_post_data['date']:"";?>">
    </div>

	<div class="col-md-3">
        <center>
            <!-- <span class="btn red btn-outline btn-sm" id="download_team_follow_report" title="Download Lead Report">
                <i class="fa fa-download"></i> Download
            </span> -->
			<?php if($role_id == SUPER_ADMIN_ROLE_ID){?>
            <span class="btn red btn-outline btn-sm" id="download_team_follow_report" title="Download Lead Report">
                <i class="fa fa-download"></i> Download
            </span>
<?php } ?>	
        </center>
    </div>

</div>
																					</form>
			<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">

			<thead>
				<tr>
					<th width="2%">Sr. No.</th>                     
					<th width="38%">Customer Name</th>                   
					<th width="8%">Contact No</th>                
					<th >FollowUp Description</th>                       
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
$("#download_customer_report").click(function(e){
	var html = $('#srch_form').html();
	$('#srch_form').attr("action",base_url+"customers/download_customer_report");
	$('#srch_form').attr("onsubmit","");
	$('#srch_form').submit();
	$('#srch_form').attr("action","");
	$('#srch_form').attr("onsubmit","return false;");
	
});		

$("#download_team_follow_report").click(function(e){
        $('#srch_form').attr("action",base_url+"leads/download_followup_report");
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
 		
		
	$('.datepicker').datepicker({
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
     $('.pagination').on('click','a',function(e){
       e.preventDefault(); 
       var pageno = $(this).attr('data-ci-pagination-page');
	   if(pageno){
		    table_list(pageno);
	   }
      
     });   

});
table_list(<?php echo $page;?>);
function table_list(pageno)
	{
		var formdata  = $("#srch_form").serializeArray();		
		$("#tbl_list").html("");
		$(".loader").fadeIn();
		$.ajax({
			url:base_url+"ajax/tbl_team_followup_list/"+pageno,
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


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<style>

#filterRow {
    display: flex; /* Enable flexbox layout */
    justify-content: space-between; /* Space elements evenly within the row */
}
</style>