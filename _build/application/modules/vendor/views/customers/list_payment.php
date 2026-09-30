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
		 <div class="col-lg-10 col-md-6">
			  <!--span  class="btn red btn-outline btn-sm"  id="download_customer_report" title="Download Customer Report"><i class="fa fa-download"></i> Download </span--> 
 <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
				   <span class="caption-subject font-red-mint sbold  total_count">( Total - 0 )</span>	
				   <span class="caption-subject font-red-mint sbold  total_amount">( Total Received Amt. - 0 )</span>	
</div>
<div class="col-lg-2 col-md-6">
	<center>
<a  class="btn btn-success btn-sm " href="<?php echo get_module_path();?>customers/add_payment" title="Add"><i class="fa fa-plus"></i> Add New </a>
</center>
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
		    <?php $payment_post_data = array();
			      $page = "1";
			      $history = $this->input->get('history');
				  if($history == "back")
				  {
					  $payment_post_data = $this->session->userdata('payment_post_data');	
					  $page = $payment_post_data['page'];
				  } 
			?>  
             <div class="col-md-12"> 
				  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				       <input type="hidden" name="highlight_id" value="<?php echo $this->input->get("highlight"); ?>" />
				       <div class="form-group col-md-3">                           
                            <select class="form-control" id="service_type" name="service_type" onchange="table_list(1);">
							<option value=""> Select Service Type</option>
							 <?php  if(!empty($service_type_list)){ 
								foreach($service_type_list as $key=>$service_type){ 
								  		 $followup   = isset($payment_post_data['followup'])?$payment_post_data['followup']:"";
									     $selected = $followup==$key?"selected":"";						
								?>
									<option value="<?php echo $key?>" <?php echo $selected;?> ><?php echo $service_type; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 
						<div class="form-group col-md-3"> 
                           <input class="form-control" id="searchStr_name" name="searchStr_name" type="text" placeholder="Search By Name" maxlength="100" value="<?php echo isset($payment_post_data['searchStr_name'])?$payment_post_data['searchStr_name']:"";?>" onchange="table_list(1);">
                        </div>

						<div class="form-group col-md-2"> 
                          <input type="text" class="form-control  datepickerD" id="payment_date" name="payment_date" placeholder="Date" maxlength="10" value="<?php echo isset($payment_post_data['payment_date'])?$payment_post_data['payment_date']:"";?>" >
                        </div>

	                   <div class="form-group col-md-2"> 
                          <input type="text" class="form-control  datepickerD" id="from_date" name="from_date" placeholder="From Date" maxlength="10" value="<?php echo isset($payment_post_data['from_date'])?$payment_post_data['from_date']:"";?>" >
                        </div>	 

						<div class="form-group col-md-2"> 
                          <input type="text" class="form-control  datepickerD" id="to_date" name="to_date" placeholder="To Date" maxlength="10" value="<?php echo isset($payment_post_data['to_date'])?$payment_post_data['to_date']:"";?>" >
                        </div>							
					
						
                        </form>
				    </div>
				
			<table class="table table-striped table-bordered table-hover  dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch" id="Srtable" role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th width="2%">Sr. <br/> No.</th>
				  <th width="8%">Payment  Date</th>        				  
				  <th>Customer  Name </th>        				  
                  <th width="10%">Contact No</th>               
                  <th width="5%">Receipt No </th>               
                  <th width="10%">	Total  <br/> Amt </th>  
                  <th width="10%">	Received <br/> Amt </th>  
                  <th width="10%">	Balance  <br/>Amt </th>  
                  <!-- <th width="10%"> 	Service <br/> Type </th>   -->
                  <th width="10%">	Status </th>  
                                  		  
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
$("#download_customer_report").click(function(e){
	var html = $('#srch_form').html();
	$('#srch_form').attr("action",base_url+"customers/download_customer_report");
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
			url:base_url+"ajax/tbl_payment_list/"+pageno,
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
				var total_amount = json_arr.total_amount;
				
				$(".total_count").html("( Total - "+total_count+" )");
				$(".total_amount").html("( Total Received Amt. - "+total_amount+" )");
				$("#tbl_list").html(html_data);
				$('.pagination').html(json_arr.pagination);
				    
			}
		});
	}
</script>

