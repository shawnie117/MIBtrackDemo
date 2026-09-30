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
			   <div class="col-lg-8 col-md-6">
			   <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
			   <span class="caption-subject font-red-mint sbold float-right total_count">( Total - 0 )</span>	
			     
			  
			</div>  
			<!-- <div class="col-lg-4 col-md-6">
			<a  class="btn btn-success btn-sm" href="<?php echo get_module_path();?>admin/add_employee" title="Add"><i class="fa fa-plus"></i> Add New </a> 
			<span  class="btn red btn-outline btn-sm"  id="download_emp_report" title="Download Employee Report"><i class="fa fa-download"></i> Don't Download </span> 
</div> -->
			  <div class="row">
                 
				
		 <div class="col-md-12">
			<div class="portlet-body"> 
               <div class="col-md-6">                                                   
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
                  <?php } ?>
                  <?php  
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
				 <?php 
				  $emp_post_data       = array();
				  $sub_dept_list = array();
			      $history = $this->input->get('history');
				  if($history == "back")
				  {
					  $emp_post_data = $this->session->userdata('emp_post_data');
					  $sub_dept_list = $emp_post_data['sub_dept_list'];			  
				  } 
					 ?>     
             <div class="col-md-12" style="max-height:35px"> 
				  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				  
				     <div class="form-group col-md-2">                           
                            <select class="form-control" id="status" name="status" onchange="table_list(1);">
							<option value=""> Select Status</option>
							 <?php  if(!empty($status_list)){ 
								foreach($status_list as $stat){ 
								   $status   = isset($emp_post_data['status'])?$emp_post_data['status']:"Active";
								   $selected = $status==$stat?"selected":"";									
								?>
									<option value="<?php echo $stat?>" <?php echo $selected;?>  ><?php echo $stat; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
				       <div class="form-group col-md-2">                           
                            <select class="form-control" id="permission_id" name="permission_id" onchange="table_list(1);">
							<option value=""> Select Designation</option>
							 <?php  if(!empty($permission_list)){ 
								foreach($permission_list as $permission){ 
										 $permission_id   = isset($emp_post_data['permission_id'])?$emp_post_data['permission_id']:"";
								         $selected = $permission_id==$permission['permission_id']?"selected":"";					
								?>
									<option value="<?php echo $permission['permission_id'];?>" <?php echo $selected;?>><?php echo $permission['permission_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 
						
						
						<div class="form-group col-md-2">                           
                            <select class="form-control" id="department_id" name="department_id" onchange="table_list(1);get_sub_dept_list(this,'sub_dept_id');">
							<option value=""> Select Department</option>
							 <?php  if(!empty($department_list )){ 	 						
								foreach($department_list as $dept){ 
										$department_id   = isset($emp_post_data['department_id'])?$emp_post_data['department_id']:"";
								        $selected = $department_id==$dept['dept_id']?"selected":"";

								?>
									<option value="<?php echo $dept['dept_id'];?>" <?php echo $selected;?>><?php echo $dept['dept_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
						<div class="form-group col-md-3">                           
                            <select class="form-control" id="sub_dept_id" name="sub_dept_id" onchange="table_list(1);">
							  <option value=""> Select Sub Department</option>
								 <?php  if(!empty($sub_dept_list )){ 	 						
								foreach($sub_dept_list as $sub_dept){ 
                                        $sub_dept_id   = isset($emp_post_data['sub_dept_id'])?$emp_post_data['sub_dept_id']:"";
								        $selected = $sub_dept_id==$sub_dept['sub_dept_id']?"selected":"";

    								?>
									<option value="<?php echo $sub_dept['sub_dept_id'];?>"  <?php echo $selected;?>><?php echo $sub_dept['sub_dept_name']; ?></option>
							<?php } } ?>						
						   </select>						 
                        </div> 
						<div class="form-group col-md-2"> 
                           
                           <input class="form-control" id="searchStr" name="searchStr" type="text" placeholder="Search..." maxlength="100" value="<?php echo isset($emp_post_data['searchStr'])?$emp_post_data['searchStr']:""?>" onchange="table_list(1);">
						 
                        </div>
																		
						<div class="form-group col-md-2 hidden"> 
						
                          <button class="btn green btn-outline" type="submit" ><i class="fa fa-search"></i>Search</button>
						 
                        </div>
                        </form>
				    </div>
								
			<table class="table table-striped table-bordered table-hover no-footer dtr-inline  tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th width="2%">Sr. No.</th>
				  <th width="10%">Username </th>        				  
                  <th width="15%">Employee Name</th>               
                  <th width="10%">Designation</th>               
                  <th width="10%">Mobile No. </th>               
                  <!-- <th width="10%">Mobile No2. </th>  -->
                  <th style="text-align:center" width="5%">Status</th>
                  <th style="text-align:center" width="25%">Action</th>				  
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
		<div class="modal fade" id="form_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
    
      <div class="modal-header">
        <h4 class="modal-title">Select Login Date and Time</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
  <form action="<?php echo base_url('admin/save_login_entry'); ?>" method="post" id="login_datetime_form">
    <div class="form-group">
      <label for="datetime">Date and Time</label>
      <input type="datetime-local" id="datetime" name="datetime" class="form-control" required>
    </div>
</div>

<div class="modal-footer">
  <button type="submit" class="btn btn-success">Submit</button>
  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
</div>
</form> <!-- Close the form after modal-footer -->


    </div>
  </div>
</div>	
<!--END START MODAL -->

<!-- START MODAL-2 -->
<div class="modal fade" id="form_modal_one" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
    
      <div class="modal-header">
        <h4 class="modal-title">Select Logout Date and Time</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="datetime">Date and Time</label>
            <input type="datetime-local" id="datetime" class="form-control">
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>	
<!--END START MODAL -->

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function() {
$("#download_emp_report").click(function(e){
	$('#srch_form').attr("action",base_url+"admin/download_emp_report");
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
table_list(1);
function table_list(pageno)
	{
		var formdata  = $("#srch_form").serializeArray();		
		$("#tbl_list").html("");
		$.ajax({
			url:base_url+"ajax/tbl_employee_list_1/"+pageno,
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
				    
			}
		});
	}
</script>

