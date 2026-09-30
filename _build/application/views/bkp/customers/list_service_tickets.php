<?php $role_id = $this->session->userdata('user_role_id');?>
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
		 <div class="pull-right">
		      <a  class="btn btn-success btn-sm " href="<?php echo base_url();?>customers/add_service_ticket" title="Add"><i class="fa fa-plus"></i> Add New </a>
			  <!--span  class="btn red btn-outline btn-sm"  id="download_ticket_report" title="Download Ticket Report"><i class="fa fa-download"></i> Download </span--> 
			</div> 
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
		    <?php $serv_ticket_post_data = array();
			      $page = "1";
			      $history = $this->input->get('history');
				  if($history == "back")
				  {
					  $serv_ticket_post_data = $this->session->userdata('serv_ticket_post_data');	
					  $page = $serv_ticket_post_data['page'];
				  } 
			?>  
             <div class="col-md-12"> 
				  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				     
				        <div class="form-group col-md-3">                           
                            <select class="form-control" id="status" name="status" onchange="table_list(1);">
							<option value=""> Select Status</option>
							 <?php  if(!empty($status_list)){ 
								foreach($status_list as $stat){ 
								  		 $status   = isset($serv_ticket_post_data['status'])?$serv_ticket_post_data['status']:"Open";
									     $selected = $status==$stat?"selected":"";						
								?>
									<option value="<?php echo $stat?>" <?php echo $selected;?> ><?php echo $stat; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 
						
						 <div class="form-group col-md-3">  
						 <select class="form-control selectpicker" id="customer_id" name="customer_id" data-live-search="true">
							<option value=""> Select Customer</option>
							 <?php  if(!empty($customer_list)){ 
								foreach($customer_list as $customer){ 
								   $customer_id   = isset($serv_ticket_post_data['customer_id'])?$serv_ticket_post_data['customer_id']:"";
									     $selected = $customer_id==$customer['customer_id']?"selected":"";	
								?>
									<option value="<?php echo $customer['customer_id'];?>"   <?php echo $selected;?>><?php echo $customer['customer_name']; ?></option>
							<?php } } ?>	
						   </select>
                          </div>						   
						<div class="form-group col-md-3"> 
                           <input class="form-control" id="searchStr_name" name="searchStr_name" type="text" placeholder="Search By Name / Complaint ID" maxlength="100" value="<?php echo isset($serv_ticket_post_data['searchStr_name'])?$serv_ticket_post_data['searchStr_name']:"";?>" onchange="table_list(1);">
                        </div>
											
						  
						  <div class="form-group col-md-2"> 
                           <a class="btn btn-success " id="toggle_btn"  title="Advance Search"><i class=" icon-magnifier-add"></i></a>
						   &nbsp;
						     <a class="btn btn-danger " id="clear_btn"  title="Clear Search"><i class=" icon-close"></i></a>
                          					 
                        </div>
						<?php 
						$class = "hidden";
						$ticket_assign_to  = isset($serv_ticket_post_data['ticket_assign_to'])?$serv_ticket_post_data['ticket_assign_to']:"";
						$from_date = isset($serv_ticket_post_data['from_date'])?$serv_ticket_post_data['from_date']:"";
						$to_date   = isset($serv_ticket_post_data['to_date'])?$serv_ticket_post_data['to_date']:"";
						
						if(!empty($ticket_assign_to) || !empty($from_date) || !empty($to_date))
						{
							$class = "";
						}
						?>
						<div id="toggle_srch" class="<?php echo $class;?>">
						<?php if($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID){ ?>
						<div class="form-group col-md-3">  
						 <select class="form-control selectpicker" id="ticket_assign_to" name="ticket_assign_to" data-live-search="true">
							<option value=""> Select Assigned To</option>
							 <?php  if(!empty($employee_list)){ 
								foreach($employee_list as $employee){ 
								       $selected = $ticket_assign_to==$employee['user_id']?"selected":"";	
								?>
									<option value="<?php echo $employee['user_id'];?>"   <?php echo $selected;?>><?php echo $employee['emp_name']; ?></option>
							<?php } } ?>	
						   </select>
                          </div>
						<?php } ?>
	                   <div class="form-group col-md-2"> 
                          <input type="text" class="form-control pull-right datepickerD" id="from_date" name="from_date" placeholder="From Date" maxlength="10" value="<?php echo isset($serv_ticket_post_data['from_date'])?$serv_ticket_post_data['from_date']:"";?>" >
                        </div>	 
						<div class="form-group col-md-2"> 
                          <input type="text" class="form-control pull-right datepickerD" id="to_date" name="to_date" placeholder="To Date" maxlength="10" value="<?php echo isset($serv_ticket_post_data['to_date'])?$serv_ticket_post_data['to_date']:"";?>" >
                        </div>							
                        </div>							
					
						
                        </form>
				    </div>
								
			<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th width="2%">Sr. No.</th>				 	  
				  <th width="5%">Ticket ID</th>        				  
				  <th>Customer</th>        				  
				  <th>Ticket Title</th> 
                  <th  width="12%">Ticket Date</th>               
                  <th width="10%" style="text-align:center">Status </th>  
 
                                  		  
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
$("#clear_btn").click(function(e){
	 $('#searchStr_id, #searchStr_name').val('');
	 $('#status, #ticket_assign_to, #customer_id').val('');
	 $('#from_date, #from_date').val('');
	 $('#srch_form').trigger("reset");
	  $(".selectpicker").val('');
     $(".selectpicker").selectpicker("refresh"); 
	 table_list(1);
});			
	
	
	
$("#download_ticket_report").click(function(e){
	var html = $('#srch_form').html();
	$('#srch_form').attr("action",base_url+"customers/download_ticket_report");
	$('#srch_form').attr("onsubmit","");
	$('#srch_form').submit();
	$('#srch_form').attr("action","");
	$('#srch_form').attr("onsubmit","return false;");
	
});

$('.selectpicker').selectpicker();
$('.selectpicker').on('change', function(){ table_list(1); });

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
		$.ajax({
			url:base_url+"ajax/tbl_servicing_list/"+pageno,
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

