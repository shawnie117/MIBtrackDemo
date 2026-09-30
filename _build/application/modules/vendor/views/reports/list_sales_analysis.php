<?php 
$vendor  = $this->session->userdata('vendor');
$role_id = $vendor['user_role_id'];
?>


<style>
	table {
    table-layout: fixed;
}

.sr-col {
    width: 50px;
    text-align: center;
}
</style>
<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
   <!-- BEGIN PAGE BASE CONTENT -->
   
   <!--div class="page-head">
		<div class="page-title">
			<h1><?php echo $page_title; ?></h1>
		</div>	
	</div-->
	

	<!-- <pre>
	<?php print_r($service_list); ?>
	</pre> -->

	<!-- <pre>
	<?php print_r($employee_list); ?>
	</pre> -->

	
   <div class="row">
      <div class="col-md-12">
         <div class="portlet light bordered">
		
			   	<div class="row" style="margin-bottom:10px;">

					<!-- LEFT SIDE -->
					<div class="col-md-6">
						<span class="caption-subject font-green-sharp sbold">
							<?php echo $page_title; ?>
						</span>
						<br>
						<span class="caption-subject font-red-mint sbold total_count">
							( Total - 0 )
						</span>
					</div>

					<!-- RIGHT SIDE -->
					<div class="col-md-6 text-right" style="position:relative;">

						<button id="toggleMultiDownload" class="btn btn-primary btn-sm">
							Multiple Invoice Download
						</button>

						<div id="multiDownloadControls"
							style="display:none;
									position:absolute;
									right:0;
									top:40px;
									background:#fff;
									padding:8px 12px;
									border:1px solid #ddd;
									box-shadow:0 2px 6px rgba(0,0,0,0.1);
									border-radius:4px;
									z-index:9999;">

							<label style="margin-right:10px;">
								<input type="checkbox" id="selectAllInvoices"> Select All
							</label>

							<button id="downloadSelectedInvoices" 
									class="btn btn-success btn-sm">
								Download Invoices
							</button>

						</div>

					</div>

				</div>
                       
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
				    
                   
						 <div class="form-group col-md-2">  
						 <select class="form-control" id="service_type" name="service_type" onchange="table_list(1);" >
							 <?php  if(!empty($service_list)){  
								foreach($service_list as $key=>$type){ ?>
									<option value="<?php echo $key;?>" ><?php echo $type; ?></option>
							<?php } } ?>	
						   </select>
                          </div> 
						  <?php if($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID){ ?>
						 <div class="form-group col-md-3">  
						 <select class="form-control selectpicker" id="user_id" name="user_id" data-live-search="true">
							<option value=""> Select User</option>
							 <?php  if(!empty($employee_list)){ 
								foreach($employee_list as $employee){ ?>
									<option value="<?php echo $employee['user_id'];?>" ><?php echo $employee['emp_name']; ?></option>
							<?php } } ?>	
						   </select>
                          </div>
						<?php } ?>
							  
						<!-- <div class="form-group col-md-3"> 
                          <input type="text" class="form-control pull-right datepickerMY" id="month_year" name="month_year" placeholder="Month/Year" maxlength="10" value="" >
                        </div>	  -->
						
						<div class="form-group col-md-2" style="display:flex;">
							<label style="margin-right:5px;">From: </label>
							<input type="text"
								class="form-control pull-right datepickerMY"
								id="from_month"
								name="from_month"
								placeholder="From Month">
						</div>

						<div class="form-group col-md-2" style="display:flex;">
							<label style="margin-right:5px;">To: </label>
							<input type="text"
								class="form-control pull-right datepickerMY"
								id="to_month"
								name="to_month"
								placeholder="To Month">
						</div>
						
                        </form>
				    </div>
								
			<table class="table table-striped table-bordered  tbl_data_table_no_srch3  "  role="grid" aria-describedby="sample_1_info">
						<thead>
						<tr class="success">
				  <th class="sr-col">Sr. No.</th>				 	  
				  <th>Customer Name</th>        				  
				  <th>Contact</th>        				  
                  <th>Type</th>               
                  <th>Total Amt</th>               
                  <th>Received Amt</th>               
                  <th>Balance Amt</th> 
				  <th>Invoice No.</th>              
                  <th> Invoice Download</th>               
                                                 		  
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
	 $('#searchStr_name').val('');
	 $('#status, #ticket_assign_to, #customer_id, #clm_id').val('');
	 $('#from_date, #from_date').val('');
	 $('#srch_form').trigger("reset");
	 $(".selectpicker").val('');
     $(".selectpicker").selectpicker("refresh"); 	
	 table_list(1);
});	
// added by ANkit on 20/01/2026 
var multiMode = false;

$('#toggleMultiDownload').click(function() {

    multiMode = !multiMode;

    if(multiMode) {
        $('.single-download').hide();
        $('.invoice-checkbox').show();
        $('#multiDownloadControls').show();
    } else {
        $('.single-download').show();
        $('.invoice-checkbox').hide().prop('checked', false);
        $('#multiDownloadControls').hide();
        $('#selectAllInvoices').prop('checked', false);
    }

});

// Select All checkbox logic
$(document).on('change', '#selectAllInvoices', function() {
    var isChecked = $(this).is(':checked');
    $('.invoice-checkbox').prop('checked', isChecked);
});

// If individual checkbox changes
$(document).on('change', '.invoice-checkbox', function() {

    var total = $('.invoice-checkbox').length;
    var checked = $('.invoice-checkbox:checked').length;

    if(total === checked) {
        $('#selectAllInvoices').prop('checked', true);
    } else {
        $('#selectAllInvoices').prop('checked', false);
    }

});


// Added by Ankit on 20/02/2026
$(document).on('click', '#downloadSelectedInvoices', function(e) {

    e.preventDefault();

    var selected = [];

    $('.invoice-checkbox:checked').each(function() {
        selected.push({
            customer_id: $(this).data('customer'),
            billno: $(this).data('billno')
        });
    });

    if(selected.length === 0) {
        alert("Please select at least one invoice");
        return false;
    }

    // 🔥 RESET UI BACK TO NORMAL MODE
    // 🔥 RESET UI BACK TO NORMAL MODE
	multiMode = false;
	$('.invoice-checkbox').prop('checked', false).hide();
	$('.single-download').show();
	$('#multiDownloadControls').hide();   // ← ADD THIS
	$('#selectAllInvoices').prop('checked', false); // ← ADD THIS

    // Create form
    var form = $('<form method="POST" action="' + base_url + 'customers/download_multiple_invoices"></form>');

    var input = $('<input type="hidden" name="invoices">');
    input.val(JSON.stringify(selected));

    form.append(input);
    $('body').append(form);

    form.submit();
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

		});
		
    //   $(".datepickerMY").datepicker("setDate", new Date()).on('changeDate', function(e) {
	// 		table_list(1);
	// 	});

	$('#from_month').datepicker("setDate", new Date());
	$('#to_month').datepicker("setDate", new Date());

	$('.datepickerMY').on('changeDate', function(e) {
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
		$(".loader").fadeIn();
		$.ajax({
			url:base_url+"ajax/tbl_sales_analysis_list/"+pageno,
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
				var balanced_Amount = json_arr.balanced_Amount;
				var received_Amount = json_arr.received_Amount;
				var total_amount    = json_arr.total_amount;

				
				
				$(".total_count").html("( Total Count - "+total_count+"&nbsp;&nbsp;&nbsp; Total Balance - "+balanced_Amount+" &nbsp;&nbsp;&nbsp;Total Received - "+received_Amount+"&nbsp;&nbsp;&nbsp;Total Amt - "+total_amount+" )");
				$("#tbl_list").html(html_data);
				$('.pagination').html(json_arr.pagination);
				$(".loader").fadeOut();   
				    
			}
		});
	}
</script>

