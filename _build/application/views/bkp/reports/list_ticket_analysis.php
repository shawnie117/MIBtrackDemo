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
		
			   <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
				  
                       
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
		 
             <div class="col-md-12"> 
				  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				    
						<div class="form-group col-md-3"> 
                          <input type="text" class="form-control pull-right datepickerMY" id="month_year" name="month_year" placeholder="Month/ Year" maxlength="10" value="" >
                        </div>
             <?php if($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID){ ?>						
					<div class="form-group col-md-3">                           
                            <select class="form-control" id="user_id" name="user_id" onchange="table_list(1);">
							<option value=""> Select User</option>
							 <?php  if(!empty($employee_list)){ 
								foreach($employee_list as $employee){ ?>
									<option value="<?php echo $employee['user_id'];?>" ><?php echo $employee['emp_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 
						<?php } ?>
                        </form>
				    </div>
			<div class="col-md-12 shadow"> 		
				    <div class="portlet-title">
					  <br/>
					   <div class="caption">
						  <i class="font-red-mint icon-list"></i> <span class="caption-subject font-red-mint sbold">All Tickets </span>
						  <span class="caption-subject font-red-mint sbold float-right count_all_tickets_list">( Total - 0 )</span>	
					   </div>
						<hr style="margin:3px;"/>
				    </div>							
				<table class="table table-striped table-bordered  tbl_data_table_no_srch2  "  role="grid" aria-describedby="sample_1_info">
						<thead>
							<tr class="success">
						  <th>Sr. No.</th>	
						  <th>Ticket ID </th>        				  
						  <th>Title</th>               
						  <th>Ticket Date </th>               
						  <th>Customer Name</th>               
						  <th>Assigned To</th>            		  
						  <th>Assigned On</th>            		  
						  <th>Resolved On</th>          		  
						</tr>
						</thead>					   
						<tbody class=""  id="tbl_all_tickets_list">					  
						</tbody>
						
				    </table> 
					
			</div>	
			
		
			
			<div class="col-md-12 shadow"> 		
				    <div class="portlet-title">
					  <br/>
					   <div class="caption">
						  <i class="font-red-mint icon-hourglass"></i> <span class="caption-subject font-red-mint sbold">Pending Tickets </span>
						  <span class="caption-subject font-red-mint sbold float-right count_pending_tickets_list">( Total - 0 )</span>	
					   </div>
						<hr style="margin:3px;"/>
				    </div>							
					<table class="table table-striped table-bordered  tbl_data_table_no_srch2  "  role="grid" aria-describedby="sample_1_info">
						<thead>
							<tr class="success">
						  <th>Sr. No.</th>	
						  <th>Ticket ID </th>        				  
						  <th>Title</th>               
						  <th>Ticket Date </th>               
						  <th>Customer Name</th>               
						  <th>Assigned To</th>            		  
						  <th>Assigned On</th>            		  
						  <th>Resolved On</th>          		  
						</tr>
						</thead>
						<tbody  id="tbl_pending_tickets_list">
					 	</tbody>
				    </table> 					
			</div>	
				<div class="col-md-12 shadow"> 		
				    <div class="portlet-title">
					  <br/>
					   <div class="caption">
						  <i class="font-red-mint icon-check"></i> <span class="caption-subject font-red-mint sbold">Resolved Tickets </span>
						  <span class="caption-subject font-red-mint sbold float-right count_resoved_tickets_list">( Total - 0 )</span>	
					   </div>
						<hr style="margin:3px;"/>
				    </div>							
					<table class="table table-striped table-bordered  tbl_data_table_no_srch2  "  role="grid" aria-describedby="sample_1_info">
						<thead>
						<tr class="success">
						  <th>Sr. No.</th>	
						  <th>Ticket ID </th>        				  
						  <th>Title</th>               
						  <th>Ticket Date </th>               
						  <th>Customer Name</th>               
						  <th>Assigned To</th>            		  
						  <th>Assigned On</th>            		  
						  <th>Resolved On</th>          		  
						</tr>
						</thead>
						<tbody  id="tbl_resoved_tickets_list">
					 	</tbody>
				    </table> 					
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
	 $('#searchStr_name').val('');
	 $('#status, #ticket_assign_to, #customer_id, #clm_id').val('');
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
				minViewMode: "months",
		});
		 
    $(".datepickerMY").datepicker("setDate", new Date()).on('changeDate', function(e) {
			table_list(1);
		});;
  
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
			url:base_url+"ajax/tbl_ticket_analysis_list/"+pageno,
			type: "POST",
			data: formdata,
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
			{		
				var json_arr = JSON.parse(data);	
				
				var tbl_all_tickets_list     = json_arr.tbl_all_tickets_list;
				var count_all_tickets_list   = json_arr.count_all_tickets_list;
				$(".count_all_tickets_list").html("( Total - "+count_all_tickets_list+" )");
				$("#tbl_all_tickets_list").html(tbl_all_tickets_list);
				
				
						
				var tbl_pending_tickets_list     = json_arr.tbl_pending_tickets_list;
				var count_pending_tickets_list   = json_arr.count_pending_tickets_list;
				$(".count_pending_tickets_list").html("( Total - "+count_pending_tickets_list+" )");
				$("#tbl_pending_tickets_list").html(tbl_pending_tickets_list);
				
				
				var tbl_resoved_tickets_list     = json_arr.tbl_resoved_tickets_list;
				var count_resoved_tickets_list   = json_arr.count_resoved_tickets_list;
				$(".count_resoved_tickets_list").html("( Total - "+count_resoved_tickets_list+" )");
				$("#tbl_resoved_tickets_list").html(tbl_resoved_tickets_list);
				
				    
			}
		});
	}
</script>

