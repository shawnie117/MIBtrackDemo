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
<?php if($role_id == SUPER_ADMIN_ROLE_ID){?>
			  <span  class="btn red btn-outline btn-sm pull-right"  id="download_sales_report" title="Download All Sales Report"><i class="fa fa-download"></i> Download </span> 

<?php } ?>				
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
		    <?php $all_sale_post_data = array();
			       $page    = "1";
				   $history = $this->input->get('history');
				  if($history == "back")
				  {
					  $all_sale_post_data = $this->session->userdata('all_sale_post_data');	
					  $page  = $all_sale_post_data['page'];
				  } 
			?>  
             <div class="col-md-12"> 
				  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				     
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
							  
						<div class="form-group col-md-3"> 
                          <input type="text" class="form-control pull-right datepickerMY" id="month_year" name="month_year" placeholder="Month/Year" maxlength="10" value="" >
                        </div>	

						<div class="form-group col-md-3"> 
                          <input type="text" class="form-control" id="bill_no" name="bill_no" placeholder="Bill No" maxlength="10" value="" >
                        </div>	 
					
						
                        </form>
				    </div>
								
			<table class="table table-striped table-bordered table-hover  dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th width="2%">Sr. No.</th>				 	  
				  <th width="5%">Quotation No.</th>        				  
				  <th>Customer/Lead</th>        				  
                  <th width="15%">Type </th>               
                  <th  width="12%">Contact</th>               
                  <th  width="12%">Added Date</th>               
                   
 
                                  		  
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
	
$("#download_sales_report").click(function(e){
	var html = $('#srch_form').html();
	$('#srch_form').attr("action",base_url+"reports/download_all_sales_report");
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
			url:base_url+"ajax/tbl_all_sales_list/"+pageno,
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

