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
                          <input type="text" class="form-control pull-right datepickerD" id="date" name="date" placeholder="Date" maxlength="10" value="" >
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
						  <i class="font-red-mint icon-hourglass"></i> <span class="caption-subject font-red-mint sbold">Leads Waiting For Approval </span>
						  <span class="caption-subject font-red-mint sbold float-right count_all_leads_list">( Total - 0 )</span>	
					   </div>
						<hr style="margin:3px;"/>
				    </div>
					
					<table class="table table-striped table-bordered display tbl_data_table_no_srch2  "  role="grid" aria-describedby="sample_1_info" style="width:100%">
						<thead>
						<tr class="success">
						  <th>Sr. No.</th>	
						  <th>Lead Name </th>        				  
						  <th>Contact No</th>               
						  <th>Landline No </th>               
						  <th>	Address </th>      		  
		
						</tr>
						</thead>					   
						<tbody class=""  id="tbl_all_leads_list">					  
						</tbody>
						
				    </table> 
					
			</div>	
			
			<div class="col-md-12 shadow"> 		
				    <div class="portlet-title">
					  <br/>
					   <div class="caption">
						  <i class="font-red-mint icon-list"></i> <span class="caption-subject font-red-mint sbold">All Sales </span>
						  <span class="caption-subject font-red-mint sbold float-right count_all_sales_list">( Total - 0 )</span>	
					   </div>
						<hr style="margin:3px;"/>
				    </div>							
					<table class="table table-striped table-bordered  tbl_data_table_no_srch2  "  role="grid" aria-describedby="sample_1_info">
						<thead>
						<tr class="success">
				  <th>Sr. No.</th>				 	  
				  <th>Customer Name</th>        				  
				  <th>Contact</th>        				  
                  <th>Type</th>               
                  <th>Total Amt</th>               
                  <th>Received Amt</th>               
                  <th>Balance Amt</th>               
                                                 		  
                </tr>
                </thead>
                <tbody  id="tbl_all_sales_list">
              
				 </tbody>
						</table> 	
			</div>	
			
				<div class="col-md-12 shadow"> 		
				    <div class="portlet-title">
					  <br/>
					   <div class="caption">
						  <i class="font-red-mint icon-wallet"></i> <span class="caption-subject font-red-mint sbold">Total Collection </span>
						  <span class="caption-subject font-red-mint sbold float-right count_collection_list">( Total Records - 0 )</span>	
					   </div>
						<hr style="margin:3px;"/>
				    </div>							
					<table class="table table-striped table-bordered  tbl_data_table_no_srch2  "  role="grid" aria-describedby="sample_1_info">
						<thead>
						<tr class="success">
						  <th>Sr. No.</th>	
						  <th>Invoice No</th>        				  
						  <th>Receipt No</th>               
						  <th>Paid Amt </th>               
						  <th>Pay Mode </th>               
						  <th>Type </th>               
						  <th>Payment Added By </th>               
						  <th>	Added On </th>            		  
    		  
						</tr>
						</thead>					   
						<tbody class=""  id="tbl_collection_list">					  
						</tbody>
						
				    </table> 
					
			</div>	
			
			<div class="col-md-12 shadow"> 		
				    <div class="portlet-title">
					  <br/>
					   <div class="caption">
						  <i class="font-red-mint icon-wallet"></i> <span class="caption-subject font-red-mint sbold">Payment Balance </span>
						  <span class="caption-subject font-red-mint sbold float-right count_all_pay_list">( Total Records - 0 )</span>	
					   </div>
						<hr style="margin:3px;"/>
				    </div>							
					<table class="table table-striped table-bordered  tbl_data_table_no_srch2  "  role="grid" aria-describedby="sample_1_info">
						<thead>
						<tr class="success">
						  <th>Sr. No.</th>	
						  <th>Invoice No</th>        				  
						  <th>Receipt No</th>               
						  <th>Paid Amt </th>               
						  <th>Pay Mode </th>               
						  <th>Type </th>               
						  <th>Payment Added By </th>               
						  <th>	Added On </th>            		  
    		  
						</tr>
						</thead>					   
						<tbody class=""  id="tbl_all_pay_list">					  
						</tbody>
						
				    </table> 
					
			</div>	
			
			<div class="col-md-12 shadow"> 		
				    <div class="portlet-title">
					  <br/>
					   <div class="caption">
						  <i class="font-red-mint icon-clock"></i> <span class="caption-subject font-red-mint sbold">Follow Ups Planned </span>
						  <span class="caption-subject font-red-mint sbold float-right count_planned_followup_list">( Total - 0 )</span>	
					   </div>
						<hr style="margin:3px;"/>
				    </div>							
					<table class="table table-striped table-bordered display tbl_data_table_no_srch2  "  role="grid" aria-describedby="sample_1_info" style="width:100%">
						<thead>
						<tr class="success">
						  <th>Sr. No.</th>	
						  <th>Lead/Customer Name </th>        				  
						  <th>Contact</th>               
						  <th>Added By</th>               
						  <th>Assigned To </th>               
						  <th>Followup Date</th>            		  
						       		  
						</tr>
						</thead>					
						<tbody  id="tbl_planned_followup_list">
					 	</tbody>
				    </table> 					
			</div>	
			
			<div class="col-md-12 shadow"> 		
				    <div class="portlet-title">
					  <br/>
					   <div class="caption">
						  <i class="font-red-mint icon-hourglass"></i> <span class="caption-subject font-red-mint sbold">Follow Ups Pending </span>
						  <span class="caption-subject font-red-mint sbold float-right count_pending_followup_list">( Total - 0 )</span>	
					   </div>
						<hr style="margin:3px;"/>
				    </div>							
					<table class="table table-striped table-bordered display tbl_data_table_no_srch2  "  role="grid" aria-describedby="sample_1_info" style="width:100%">
						<thead>
						<tr class="success">
						  <th>Sr. No.</th>	
						  <th>Lead/Customer Name </th>        				  
						  <th>Contact</th>               
						  <th>Added By</th>               
						  <th>Assigned To </th>               
						  <th>Followup Date</th>            		  
						       		  
						</tr>
						</thead>					
						<tbody  id="tbl_pending_followup_list">
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

		});

   $(".datepickerD").datepicker("setDate", new Date()).on('changeDate', function(e) {
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
			url:base_url+"ajax/tbl_daily_analysis_list/"+pageno,
			type: "POST",
			data: formdata,
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
			{		
				var json_arr = JSON.parse(data);	
				
				var tbl_all_leads_list     = json_arr.tbl_all_leads_list;
				var count_all_leads_list   = json_arr.count_all_leads_list;
				$(".count_all_leads_list").html("( Total - "+count_all_leads_list+" )");
				$("#tbl_all_leads_list").html(tbl_all_leads_list);
				
				
				var tbl_all_sales_list     = json_arr.tbl_all_sales_list;
				var count_all_sales_list   = json_arr.count_all_sales_list;
				$(".count_all_sales_list").html("( Total - "+count_all_sales_list+" )");
				$("#tbl_all_sales_list").html(tbl_all_sales_list);
				
				
				var tbl_collection_list     = json_arr.tbl_collection_list;
				var count_collection_list   = json_arr.count_collection_list;
				$(".count_collection_list").html("( Total - "+count_collection_list+" )");
				$("#tbl_collection_list").html(tbl_collection_list);
				
				
				var tbl_all_pay_list     = json_arr.tbl_all_pay_list;
				var count_all_pay_list   = json_arr.count_all_pay_list;
				$(".count_all_pay_list").html("( Total - "+count_all_pay_list+" )");
				$("#tbl_all_pay_list").html(tbl_all_pay_list);	
				
				
				var tbl_planned_followup_list     = json_arr.tbl_planned_followup_list;
				var count_planned_followup_list   = json_arr.count_planned_followup_list;
				$(".count_planned_followup_list").html("( Total - "+count_planned_followup_list+" )");
				$("#tbl_planned_followup_list").html(tbl_planned_followup_list);
				
				var tbl_pending_followup_list     = json_arr.tbl_pending_followup_list;
				var count_pending_followup_list   = json_arr.count_pending_followup_list;
				$(".count_pending_followup_list").html("( Total - "+count_pending_followup_list+" )");
				$("#tbl_pending_followup_list").html(tbl_pending_followup_list);
				
				    
			}
		});
	}
</script>

