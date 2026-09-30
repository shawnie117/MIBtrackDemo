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
		     	  
			   <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
				   <span class="caption-subject font-red-mint sbold float-right total_count">( Total - 0 )</span>	
                       
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
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
                     <?php echo $this->session->flashdata('error'); ?>
                  </div>
                  <?php } ?>
                  <?php  
                     $success = $this->session->flashdata('success');
                     if($success)
                     {
                     ?>
                  <div class="alert alert-success alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
                     <?php echo $this->session->flashdata('success'); ?>
                  </div>
                  <?php } ?>
                 
                  </div>
				 <?php 
				  $emp_loc_post_data       = array();
				  $history = $this->input->get('history');
				  if($history == "back")
				  {
					  $emp_loc_post_data = $this->session->userdata('emp_loc_post_data');
				  } 
					 ?>             
             <div class="col-md-12"> 
				  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				  
				    
				      <div class="form-group col-md-4">                           
                            <select class="form-control" id="emp_id" name="emp_id" onchange="table_list(1);">
							<option value=""> Select Employee</option>
							 <?php  if(!empty($employee_list)){ 
								foreach($employee_list as $employee){ 
										 $emp_id   = isset($emp_loc_post_data['emp_id'])?$emp_loc_post_data['emp_id']:"";
								         $selected = $emp_id==$employee['emp_id']?"selected":"";					
								?>
									<option value="<?php echo $employee['user_id'];?>" <?php echo $selected;?>><?php echo $employee['emp_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 
						
						<div class="form-group col-md-3"> 
                        	<input class="form-control datepicker" id="from_date" name="from_date"  required type="text" placeholder="From Date" maxlength="15" value="<?php echo isset($order_post_data['from_date'])?$order_post_data['from_date']:"";?>">
				        </div>


						<div class="form-group col-md-3"> 
                           
                          <input type="text" class="form-control pull-right datepicker" id="date" name="date" placeholder="To Date..." maxlength="10" value="<?php echo isset($emp_loc_post_data['date'])?$emp_loc_post_data['date']:"";?>"  >
						 
                        </div>			
						
						<div class="form-group col-md-2 hidden"> 
                           
                           <input class="form-control" id="searchStr" name="searchStr" type="text" placeholder="Search..." maxlength="100" value="" onchange="table_list(1);">
						 
                        </div>
						<div class="form-group col-md-2 "> 
                      
						     <a class="btn btn-danger " id="clear_btn"   title="Clear Search"><i class=" icon-close"></i></a>
                          					 
                        </div>												
						
                        </form>
				    </div>
							<div class="tbl-container">
			<table class="table table-striped table-bordered table-hover  dataTable no-footer dtr-inline  tbl_data_table_no_srch" id="Srtable"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th width="2%">Sr. No.</th>
				  <th width="10%">Date </th>        				  
                  <th width="10%">Time</th>               
                  <th>Address</th>               
                  <th>Location</th>               
                  		  
                </tr>
                </thead>
                <tbody  id="tbl_list">
              
				 </tbody>
						</table> 
								</div>					
						<!-- Render pagination links -->
						<div class="pagination" style="float:right;">
						</div>
						  </div>
                       
            		
						  <style>
	  @media screen and (max-width: 768px) {
    .followuptbl {
        height: 200px;
    }
	.tbl-box{
		overflow-x:scroll;
		padding: 10px;
	}
	.table-condensed{
		width: 800px;
	}
	.tbl-container{
		overflow-x:scroll;
		overflow-y:scroll;
		/* height: 300px; */
	}
	#Srtable{
		width: 619px;
	}
	#i-frame{
		height: 100px;
    width: 100px;
	text-align:center;
	}
}
</style>
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
$("#form_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    }); 

$("#clear_btn").click(function(e){
	 $('#date, #emp_id').val('');
	 $('#srch_form').trigger("reset");
	 table_list(1);
});		

  $('#confirm-deactivate').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });
  
   $('.datepicker').datepicker({
				format: 'dd-mm-yyyy',
				autoclose: true,
				todayHighlight: true,

		}).on('changeDate', function(e) {
			table_list(1);
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
			url:base_url+"ajax/tbl_employee_location_list/"+pageno,
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

