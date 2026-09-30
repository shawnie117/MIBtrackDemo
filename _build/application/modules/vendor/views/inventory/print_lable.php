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
		      <a  class="btn btn-success btn-sm " href="<?php echo get_module_path();?>customers/add_customer" title="Add"><i class="fa fa-plus"></i> Add New </a>
<?php if($role_id == SUPER_ADMIN_ROLE_ID){?>
			  <span  class="btn red btn-outline btn-sm"  id="download_customer_report" title="Download Customer Report"><i class="fa fa-download"></i> Download </span> 

<?php } ?>				</div>  
			   <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
				   <span class="caption-subject font-red-mint sbold float-right total_count">( Total - 0 )</span>	
                       
			  <div class="row">
                 
				
		 <div class="col-md-12">
			<div class="portlet-body"> 
               <div class="col-md-5">                                                   
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
		    <?php $cust_post_data = array();
			      $page       = "1";
			      $history    = $this->input->get('history');
			      $sel_status = $this->input->get('status');
			      $sev_type   = $this->input->get('type');
				  if($history == "back")
				  {
					  $cust_post_data = $this->session->userdata('cust_post_data');	
					  $page  = $cust_post_data['page'];
				  } 
			?>  
             <div class="col-md-12"> 
				  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				  <input type="hidden" name="highlight_id" value="<?php echo $this->input->get("highlight"); ?>" />
				       <div class="form-group col-md-2">                           
                            <select class="form-control" id="status" name="status" onchange="table_list(1);">
							<option value=""> Select Status</option>
							 <?php  if(!empty($status_list)){ 
								foreach($status_list as $stat){ 
								  		 $status   = isset($cust_post_data['status'])?$cust_post_data['status']:"Active";
										 $sel_stat = isset($sel_status)?$sel_status:$status;
									     $selected = $sel_stat==$stat?"selected":"";						
								?>
									<option value="<?php echo $stat?>" <?php echo $selected;?> ><?php echo $stat; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
				       <div class="form-group col-md-3">                           
                            <select class="form-control" id="service_type" name="service_type" onchange="table_list(1);">
							<option value=""> Select Service Type</option>
							 <?php  if(!empty($service_type_list)){ 
								foreach($service_type_list as $key=>$service_type){ 
								  		 $followup   = isset($cust_post_data['followup'])?$cust_post_data['followup']:"";
										 $sev_type = isset($sev_type)?$sev_type:$followup;
									     $selected = $sev_type==$key?"selected":"";						
								?>
									<option value="<?php echo $key?>" <?php echo $selected;?> ><?php echo $service_type; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 
						<div class="form-group col-md-4"> 
                           <input class="form-control" id="searchStr_name" name="searchStr_name" type="text" placeholder="Search By Name/ Contact No." maxlength="100" value="<?php echo isset($cust_post_data['searchStr_name'])?$cust_post_data['searchStr_name']:"";?>" onchange="table_list(1);">
                        </div>
						<div class="form-group col-md-3"> 
                           <input class="form-control" id="searchStr_cust_id" name="searchStr_cust_id" type="text" placeholder="Search By Customer Id" maxlength="100" value="<?php echo isset($cust_post_data['searchStr_cust_id'])?$cust_post_data['searchStr_cust_id']:"";?>" onchange="table_list(1);">
                        </div>
                        </form>
				    </div>
								
			<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th width="2%">Sr. No.</th>
				  <th width="25%">Customer Name </th>        				  
                  <th width="10%">Contact No</th>               
                  <!--th>Company</th-->                     
                  <th>Address </th>  
                  <!--th width="12%">	Email </th-->  
                  <!--th width="15%">	GST </th-->  
                  <th style="text-align:center" width="10%">Status</th>
                  		  
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
<!--END START MODAL -->

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
$("#download_customer_report").click(function(e){
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
	   $(".loader").fadeIn();
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
		$(".loader").fadeIn();
		$.ajax({
			url:base_url+"ajax/tbl_customer_list/"+pageno,
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
				$(".loader").fadeOut();    
			}
		});
	}
</script>

