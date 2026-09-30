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

       
			<div class="portlet light portlet-fit bordered" >
				<div class="portlet-title">
					<div class="caption">
						<i class=" icon-layers font-green"></i>
						<span class="caption-subject font-green bold uppercase"><?php echo $page_title; ?></span>				
					</div>
			<div class="portlet-body">
				<div class="mt-element-list">
					<div class="mt-list-head list-todo green-sharp">
					<div class="list-head-title-container">
					<h3 class="list-title">All Reports</h3>
					</div>
			
					</div>
		<div class="col-md-6">
			<div class="mt-list-container list-todo">
			<div class="list-todo-line red"></div>
			<ul>
			<li class="mt-list-item">
			<div class="list-todo-icon bg-white font-blue-sharp">
			<i class="fa fa-database"></i>
			</div>
			<div class="list-todo-item blue-sharp">
			<a class="list-toggle-container font-white collapsed" data-toggle="collapse" href="#task-1-2" aria-expanded="false">
			<div class="list-toggle done uppercase">
			<div class="list-toggle-title bold">Masters</div>
			<div class="badge badge-default pull-right bold">12</div>
			</div>
			</a>
			<div class="task-list panel-collapse collapse" id="task-1-2" aria-expanded="false" style="height: 0px;">
		      <table class="table table-bordered">
				<tr>
				<th><a href="<?php echo get_module_path().'masters/area_report'; ?>">Area Report</a></th>
				<th><a href="<?php echo get_module_path().'masters/reference_report'; ?>">Reference Report</a></th>
				<th><a href="<?php echo get_module_path().'masters/permission_report'; ?>">Permission Report</a></th>
				</tr>
				<tr>
				<th><a href="<?php echo get_module_path().'masters/department_report'; ?>">Department Report</a></th>
				<th><a href="<?php echo get_module_path().'masters/sub_department_report'; ?>">Sub Department Report</a></th>
				<th><a href="<?php echo get_module_path().'masters/education_report'; ?>">Education Report</a></th>
				</tr>
							
				<tr>
				<th><a href="<?php echo get_module_path().'masters/city_report'; ?>">City Report</a></th>
				<th><a href="<?php echo get_module_path().'masters/one_time_service_report'; ?>">OTS Report</a></th>
				<th><a href="<?php echo get_module_path().'masters/amc_report'; ?>">AMC Report</a></th>
				</tr>
				
				<tr>
				<th><a href="<?php echo get_module_path().'masters/sale_product_report'; ?>">Sale Product Report</a></th>
				<th><a href="<?php echo get_module_path().'masters/notification_report'; ?>">Notifications Report</a></th>
				<th><a href="<?php echo get_module_path().'masters/invoice_tc_report'; ?>">Invoice  Terms & Conditions Report</a></th>
				<th></th></tr>
													
				</table>
                                                   
		
			</div>
			</div>
			</li>
			<li class="mt-list-item">
			<div class="list-todo-icon bg-white font-purple-intense">
			<i class="fa fa-user"></i>
			</div>
			<div class="list-todo-item purple-intense">
			<a class="list-toggle-container font-white collapsed" data-toggle="collapse" href="#task-2-2" aria-expanded="false">
			<div class="list-toggle done uppercase">
			<div class="list-toggle-title bold">Admin</div>
			<div class="badge badge-default pull-right bold">5</div>
			</div>
			</a>
			<div class="task-list panel-collapse collapse" id="task-2-2" aria-expanded="false" style="height: 0px;">
			  <table class="table table-bordered">
				<tr>
				<th><a href="<?php echo get_module_path().'admin/branch_report'; ?>">Branch Report</a></th>
				<th><a href="<?php echo get_module_path().'admin/employee_report'; ?>">Employee Report</a></th>
				<th><a href="<?php echo get_module_path().'admin/emp_location_report'; ?>">Employee Location Report</a></th>
				</tr>
					<tr>
						<th><a href="<?php echo get_module_path().'reports/pwd_change_track_report'; ?>">Password Track Report</a></th>
						<th><a href="<?php echo get_module_path().'admin/two_step_verification_report'; ?>">Two Step Verification Report</a></th>
						<th></th>
						</tr>			
				</table>
			
			</div>
			</div>
			</li>
			<li class="mt-list-item">
				<div class="list-todo-icon bg-white font-red-soft">
				<i class="fa fa-user-plus"></i>
				</div>
				<div class="list-todo-item red-soft">
					<a class="list-toggle-container" data-toggle="collapse" href="#task-3-2" aria-expanded="false">
					<div class="list-toggle done uppercase">
					<div class="list-toggle-title bold">Customer</div>
					<div class="badge badge-default pull-right bold">11</div>
					</div>
					</a>
					<div class="task-list panel-collapse collapse" id="task-3-2">
					   <table class="table table-bordered">
						<tr>
						<th><a href="<?php echo get_module_path().'customers/customer_report'; ?>">Customer Report</a></th>
						<th><a href="<?php echo get_module_path().'customers/payment_report'; ?>">Payment Report</a></th>
						<th><a href="<?php echo get_module_path().'reports/payment_defaulter_report'; ?>">Payment Defaulter Report</a></th>
</tr>
						<th><a href="<?php echo get_module_path().'customers/customer_report/?status=Active'; ?>">Active Customer Report</a></th>
						<th><a href="<?php echo get_module_path().'customers/customer_report/?status=Pending'; ?>">Pending Customer Report</a></th>
						<th><a href="<?php echo get_module_path().'customers/customer_report/?type=AMC'; ?>">AMC Customer Report</a></th></tr>
						<tr>
						<th><a href="<?php echo get_module_path().'customers/customer_report/?type=One Time'; ?>">OTS Customer Report</a></th>
						<!-- <th><a href="<?php echo get_module_path().'customers/customer_report/?type=Sales'; ?>">Sale Customer Report</a></th> -->
						<th><a href="<?php echo get_module_path().'reports/employee_availability_report'; ?>">Employee Availability Report</a></th>
						<th><a href="<?php echo get_module_path().'reports/my_followup_report'; ?>">My Followup Report</a></th>
						</tr>						
						<tr>
						
						<th><a href="<?php echo get_module_path().'customers/followup_report'; ?>">Follow -Up Report</a></th>
						</tr>	
						</table>
					</div>
				</div>	
			</li>
			<li class="mt-list-item">
				<div class="list-todo-icon bg-white font-grey-soft">
				<i class="fa fa-inr"></i>
				</div>
				<div class="list-todo-item grey-cascade">
					<a class="list-toggle-container" data-toggle="collapse" href="#task-6-9" aria-expanded="false">
					<div class="list-toggle done uppercase">
					<div class="list-toggle-title bold">Sales</div>
					<div class="badge badge-default pull-right bold">2</div>
					</div>
					</a>
					
					<div class="task-list panel-collapse collapse" id="task-6-9">
					   <table class="table table-bordered">
						<tr>
						<th><a href="<?php echo get_module_path().'reports/sales_analysis_report'; ?>">Sales Report</a></th>
						<th><a href="<?php echo get_module_path().'customers/customer_gst_report'; ?>">GST Report</a></th>
						</tr>	
						</table>
					
					</div>
				</div>
			</li>

			
			<li class="mt-list-item">
				<div class="list-todo-icon bg-white font-yellow-haze">
				<i class="fa fa-cogs"></i>
				</div>
				<div class="list-todo-item yellow-haze">
					<a class="list-toggle-container" data-toggle="collapse" href="#task-2-3" aria-expanded="false">
					<div class="list-toggle done uppercase">
					<div class="list-toggle-title bold">Service</div>
					<div class="badge badge-default pull-right bold">2</div>
					</div>
					</a>
					<div class="task-list panel-collapse collapse" id="task-2-3">
					   <table class="table table-bordered">
						<tr>
						<th><a href="<?php echo get_module_path().'customers/upcoming_service_report'; ?>">Upcoming Service Report</a></th>
						<th><a href="<?php echo get_module_path().'customers/upcoming_service_report/?pdate=Yes'; ?>">Pending Services Report</a></th>
						<th></th>
						</tr>		
						</table>
					</div>
				</div>
			</li>

			<li class="mt-list-item">
				<div class="list-todo-icon bg-white font-red-pink">
				<i class="fa fa-thumb-tack"></i>
				</div>
				<div class="list-todo-item red-pink">
					<a class="list-toggle-container" data-toggle="collapse" href="#task-2-4" aria-expanded="false">
					<div class="list-toggle done uppercase">
					<div class="list-toggle-title bold">Complaint</div>
					<div class="badge badge-default pull-right bold">1</div>
					</div>
					</a>
					<div class="task-list panel-collapse collapse" id="task-2-4">
					   <table class="table table-bordered">
						<tr>
						<th><a href="<?php echo get_module_path().'customers/complaint_report'; ?>">Complaint Report</a></th>
						<th></th>
						<th></th>
						</tr>		
						</table>
					</div>
				</div>
			</li>

			
			</div>
			</div>
			</ul>
			<div class="col-md-6">
			<div class="mt-list-container list-todo">
			<div class="list-todo-line red"></div>
			<ul>
			<li class="mt-list-item">
				<div class="list-todo-icon bg-white font-purple-intense">
				<i class="fa fa-ticket"></i>
				</div>
				<div class="list-todo-item purple-intense">
					<a class="list-toggle-container" data-toggle="collapse" href="#task-4-1" aria-expanded="false">
					<div class="list-toggle done uppercase">
					<div class="list-toggle-title bold">Ticket</div>
					<div class="badge badge-default pull-right bold">4</div>
					</div>
					</a>
					<div class="task-list panel-collapse collapse" id="task-4-1">
					   <table class="table table-bordered">
						<tr>
						<th><a href="<?php echo get_module_path().'customers/ticket_report'; ?>">Ticket Report</a></th>
						<th><a href="<?php echo get_module_path().'customers/ticket_report/?status=Resolved'; ?>">Resolved Ticket Report</a></th>
						<th><a href="<?php echo get_module_path().'customers/ticket_report/?status=Closed'; ?>">Closed Ticket Report</a></th>
						</tr>
						<tr>
						
						<th><a href="<?php echo get_module_path().'customers/ticket_report/?status=Open'; ?>">Pending Ticket Report</a></th>
						<th></th><th></th>
						</tr>				
						</table>
					</div>
				</div>
			</li>
		<li class="mt-list-item">
				<div class="list-todo-icon bg-white font-grey-cascade">
				<i class="fa fa-phone"></i>
				</div>
				<div class="list-todo-item grey-cascade">
					<a class="list-toggle-container" data-toggle="collapse" href="#task-4-2" aria-expanded="false">
					<div class="list-toggle done uppercase">
					<div class="list-toggle-title bold">Lead</div>
					<div class="badge badge-default pull-right bold">4</div>
					</div>
					</a>
					<div class="task-list panel-collapse collapse" id="task-4-2">
					   <table class="table table-bordered">
						<tr>
						<th><a href="<?php echo get_module_path().'leads/lead_report'; ?>">Lead Report</a></th>
						<th><a href="<?php echo get_module_path().'leads/lead_report/?status=Active'; ?>">Active Lead Report</a></th>
						<th><a href="<?php echo get_module_path().'leads/lead_report/?status=Deactivated'; ?>">Deactivated Lead Report</a></th>
						</tr>
						<tr>
						
						<th><a href="<?php echo get_module_path().'leads/lead_report/?status=FS'; ?>">Confirm Lead Report</a></th>
						<th></th><th></th>
						</tr>
						
						
										
						</table>
					
					</div>
				</div>
			</li>
			<li class="mt-list-item">
				<div class="list-todo-icon bg-white font-blue-sharp">
				<i class="fa fa-map"></i>
				</div>
				<div class="list-todo-item blue-sharp">
					<a class="list-toggle-container" data-toggle="collapse" href="#task-8-2" aria-expanded="false">
					<div class="list-toggle done uppercase">
					<div class="list-toggle-title bold">Quotation Reports</div>
					<div class="badge badge-default pull-right bold">1</div>
					</div>
					</a>
					<div class="task-list panel-collapse collapse" id="task-8-2">
					   <table class="table table-bordered">
						<tr>
						<th><a href="<?php echo get_module_path().'reports/quotation_report'; ?>">Quotation Report</a></th>
						<th></th>
						<th></th>
						</tr>							
						</table>
					
					</div>
				</div>
			</li>
				<li class="mt-list-item">
				<div class="list-todo-icon bg-white font-red-pink">
				<i class="fa fa-line-chart"></i>
				</div>
				<div class="list-todo-item red-pink">
					<a class="list-toggle-container" data-toggle="collapse" href="#task-5-2" aria-expanded="false">
					<div class="list-toggle done uppercase">
					<div class="list-toggle-title bold">Analysis Reports</div>
					<div class="badge badge-default pull-right bold">8</div>
					</div>
					</a>
					<div class="task-list panel-collapse collapse" id="task-5-2">
					   <table class="table table-bordered">
						<tr>
						<th><a href="<?php echo get_module_path().'reports/ticket_analysis_report'; ?>">Ticket Analysis Report</a></th>
						<th><a href="<?php echo get_module_path().'reports/sales_analysis_report'; ?>">Sale Analysis Report</a></th>
						<th><a href="<?php echo get_module_path().'reports/payment_balance_report'; ?>">Payment Analysis Report</a></th>
						</tr>
						<tr>
						<th><a href="<?php echo get_module_path().'reports/lead_analysis_report'; ?>">Lead Analysis Report</a></th>
						<th><a href="<?php echo get_module_path().'reports/complaint_analysis_report'; ?>">Complaint Analysis Report</a></th>
						<th><a href="<?php echo get_module_path().'reports/service_analysis_report'; ?>">Service Analysis Report</a></th>
						</tr>
						
						<tr>
						<th><a href="<?php echo get_module_path().'reports/collection_report'; ?>">Collection Report</a></th>
						<th><a href="<?php echo get_module_path().'reports/daily_analysis_report'; ?>">Daily Analysis Report</a></th>
						<th></th>
						</tr>
						
															
						</table>
					
					</div>
				</div>
			</li>
			<li class="mt-list-item">
				<div class="list-todo-icon bg-white font-yellow-haze">
				<i class="fa fa-bar-chart"></i>
				</div>
				<div class="list-todo-item yellow-haze">
					<a class="list-toggle-container" data-toggle="collapse" href="#task-6-2" aria-expanded="false">
					<div class="list-toggle done uppercase">
					<div class="list-toggle-title bold">Analysis Graph</div>
					<div class="badge badge-default pull-right bold">3</div>
					</div>
					</a>
					<div class="task-list panel-collapse collapse" id="task-6-2">
					   <table class="table table-bordered">
						<tr>
						<th><a href="<?php echo get_module_path().'reports/lead_analysis_graph'; ?>">Lead Analysis Graph</a></th>
						<th><a href="<?php echo get_module_path().'reports/payment_analysis_graph'; ?>">Payment Analysis Graph</a></th>
						<th><a href="<?php echo get_module_path().'reports/customer_analysis_graph'; ?>">Customer Analysis Graph</a></th>
						</tr>
														
						</table>
					
					</div>
				</div>
			</li>
			<li class="mt-list-item">
				<div class="list-todo-icon bg-white font-red-soft">
				<i class="fa fa-users"></i>
				</div>
				<div class="list-todo-item red-soft">
					<a class="list-toggle-container" data-toggle="collapse" href="#task-7-2" aria-expanded="false">
					<div class="list-toggle done uppercase">
					<div class="list-toggle-title bold">Team Reports</div>
					<div class="badge badge-default pull-right bold">5</div>
					</div>
					</a>
					<div class="task-list panel-collapse collapse" id="task-7-2">
					   <table class="table table-bordered">
						<tr>
						<th><a href="<?php echo get_module_path().'reports/team_employee_report'; ?>">Team Employee Report</a></th>
						<th><a href="<?php echo get_module_path().'reports/team_followup_report'; ?>">Team Followup Report</a></th>
						<th><a href="<?php echo get_module_path().'reports/team_customer_report'; ?>">Team Customer Report</a></th>
						</tr>
						
						<tr>
						<th><a href="<?php echo get_module_path().'reports/team_lead_report'; ?>">Team Lead Report</a></th>
						<th><a href="<?php echo get_module_path().'reports/team_ticket_report'; ?>">Team Ticket Report</a></th>
						<th></th>
						</tr>
														
						</table>
					
				
			</li>
			</ul>
		
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
				"setDate":new Date(),
		})
		 
  $(".datepickerMY").datepicker("setDate", new Date()).on('changeDate', function(e) {
			table_list(1);
		});;
  
  $('#confirm-deactivate').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });

 

});

</script>

