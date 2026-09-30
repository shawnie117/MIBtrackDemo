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
			<div class="col-lg-9 col-sm-12">
			<span class="caption-subject font-green-sharp sbold pull-left"><?php echo $page_title; ?></span>&nbsp; <span class="caption-subject font-red-mint sbold total_count ">( Total - 0 )</span>	 
</div>
			<center>
			<a  class="btn btn-success btn-sm" href="<?php echo get_module_path();?>inventory/add_order"  title="Add"><i class="fa fa-plus"></i> Add New </a> 
			<center>

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
				   <?php $order_post_data = array();
			      $history = $this->input->get('history');
				  $page = 1;
				  if($history == "back")
				  {
					  $order_post_data = $this->session->userdata('order_post_data');	
					  $page = $order_post_data['page'];	
				  } 
			?>        
             <div class="col-md-12 table-group-actions"> 
			     <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				      <div class="form-group col-md-2">                           
                            <select class="form-control" id="status" name="status" onchange="table_list(1);">
							<option value=""> Select Status</option>
							 <?php  if(!empty($status_list)){ 
								foreach($status_list as $stat){ 
								  		 $status   = isset($order_post_data['status'])?$order_post_data['status']:"";
									     $selected = $status==$stat?"selected":"";						
								?>
									<option value="<?php echo $stat?>" <?php echo $selected;?> ><?php echo $stat; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
						<div class="form-group col-md-2"> 
                        <input class="form-control datepicker" id="from_date" name="from_date"  required type="text" placeholder="From Date" maxlength="15" value="<?php echo isset($order_post_data['from_date'])?$order_post_data['from_date']:"";?>">
				        </div>
						<div class="form-group col-md-2"> 
                        <input class="form-control datepicker" id="to_date" name="to_date"  required type="text" placeholder="To Date" maxlength="15" value="<?php echo isset($order_post_data['to_date'])?$order_post_data['to_date']:"";?>">
				        </div>
						<div class="form-group col-md-2"> 
                        <input class="form-control datepickerMY" id="month_year" name="month_year"  required type="text" placeholder="To Month -Year" maxlength="15" value="<?php echo isset($order_post_data['month_year'])?$order_post_data['month_year']:"";?>">
				        </div>
						<div class="form-group col-md-3">
						<select class="form-control" id="p_suplid" name="p_suplid" onchange="table_list(1);" >
							<option value=""> Select Supplier</option>
							 <?php  if(!empty($supplier_list)){ 	
								foreach($supplier_list as $supplier){ 
								  $selected = isset($order_post_data['p_suplid']) && ($order_post_data['p_suplid']==$supplier['supp_suppid'])?"selected":"";
								
								?>
									<option value="<?php echo $supplier['supp_suppid'];?>" <?php echo $selected;?> ><?php echo $supplier['supp_name']; ?></option>
							<?php } } ?>	
						   </select>
						   </div>
					     <div class="form-group col-md-3 hidden"> 
                           <input class="form-control" id="searchStr" name="searchStr" type="text" placeholder="Search..." maxlength="100" value="<?php echo isset($order_post_data['searchStr'])?$order_post_data['searchStr']:"";?>" onchange="table_list(1);">
						 
                        </div>
                        </form>
					  
				    </div>
						
			<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th style="text-align:center" width="5%">Sr. No.</th>	
                  <th>Order Id</th> 
                  <th>Remark</th> 
                  <th>Amount</th> 
                  <th>Order Date</th>        				  
                  <th style="text-align:center">Status</th>
                  <th style="text-align:center">Action</th>				  
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
<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true"  data-backdrop="static">
			<div class="modal-dialog modal-md">
			<div class="modal-content">			
			</div>
			</div>
		</div>	
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {

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
       $('.datepicker').datepicker({
				format: 'dd-M-yyyy',
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

});
table_list(<?php echo $page; ?>);
function table_list(pageno)
	{
		var formdata  = $("#srch_form").serializeArray();		
		$("#tbl_list").html("");
		$.ajax({
			url:base_url+"ajax_inventory/tbl_order_list/"+pageno,
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

