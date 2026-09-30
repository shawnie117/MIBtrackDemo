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
           <div class="actions pull-right">
		       <a  class="btn btn-success btn-sm" href="<?php echo base_url();?>leads/add_lead" title="Add"><i class="fa fa-plus"></i> Add New </a> 
			   <span  class="btn red btn-outline btn-sm"  id="download_lead_report" title="Download Lead Report"><i class="fa fa-download"></i> Download </span> 
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
		    <?php $lead_post_data = array();
			      $history     = $this->input->get('history');
				  $dist_list   = array();
		          $city_list   = array();
		          $area_list   = array();
				  $page       = "1";
				  if($history == "back")
				  {
					  $lead_post_data = $this->session->userdata('lead_post_data');	
					  $dist_list      = $lead_post_data['dist_list'];
		              $city_list      = $lead_post_data['city_list'];
		              $area_list      = $lead_post_data['area_list'];
		              $page           = $lead_post_data['page'];
				  } 
			?>  
             <div class="col-md-12"> 
				  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				  
				       <div class="form-group col-md-2">                           
                            <select class="form-control" id="followup" name="followup" onchange="table_list(1);">
							<option value=""> Select Followup</option>
							 <?php  if(!empty($followup_list)){ 
								foreach($followup_list as $key=>$stat){ 
								  		 $followup   = isset($lead_post_data['followup'])?$lead_post_data['followup']:"";
									     $selected = $followup==$key?"selected":"";						
								?>
									<option value="<?php echo $key?>" <?php echo $selected;?> ><?php echo $stat; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 
						
						<div class="form-group col-md-2">                           
                            <select class="form-control" id="status" name="status" onchange="table_list(1);">
							<option value=""> Select Status</option>
							 <?php  if(!empty($status_list)){ 
								foreach($status_list as $stat){ 
								  		 $status   = isset($lead_post_data['status'])?$lead_post_data['status']:"Active";
									     $selected = $status==$stat?"selected":"";						
								?>
									<option value="<?php echo $stat?>" <?php echo $selected;?> ><?php echo $stat; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
												
						       
						
						<div class="form-group col-md-3"> 
                           <input class="form-control" id="searchStr_name" name="searchStr_name" type="text" placeholder="Search By Name" maxlength="100" value="<?php echo isset($lead_post_data['searchStr_name'])?$lead_post_data['searchStr_name']:"";?>" onchange="table_list(1);">
                        </div>
						<div class="form-group col-md-3"> 
                           <input class="form-control" id="searchStr_contact" name="searchStr_contact" type="text" placeholder="Search By Contact No." maxlength="100" value="<?php echo isset($lead_post_data['searchStr_contact'])?$lead_post_data['searchStr_contact']:"";?>" onchange="table_list(1);">
                        </div>
						
						<div class="form-group col-md-2"> 
                           <a class="btn btn-success " id="toggle_btn"  title="Advance Search"><i class=" icon-magnifier-add"></i></a>
						   &nbsp;
						     <a class="btn btn-danger " id="clear_btn"  title="Clear Search"><i class=" icon-close"></i></a>
                          					 
                        </div>
						<?php 
						$class = "hidden";
						$reference  = isset($lead_post_data['ref_id'])?$lead_post_data['ref_id']:"";
						$product_id = isset($lead_post_data['product_id'])?$lead_post_data['product_id']:"";
						$added_by   = isset($lead_post_data['added_by'])?$lead_post_data['added_by']:"";
						$priority   = isset($lead_post_data['priority'])?$lead_post_data['priority']:"";
						$lead_date  = isset($lead_post_data['lead_date'])?$lead_post_data['lead_date']:"";
						$lead_month_year  = isset($lead_post_data['lead_month_year'])?$lead_post_data['lead_month_year']:"";
						$state_id = isset($lead_post_data['state_id'])?$lead_post_data['state_id']:"";
						$dist_id  = isset($lead_post_data['dist_id'])?$lead_post_data['dist_id']:"";
						$city_id = isset($lead_post_data['city_id'])?$lead_post_data['city_id']:"";
						$area_id = isset($lead_post_data['area_id'])?$lead_post_data['area_id']:"";
						
						if(!empty($reference) || !empty($product_id) || !empty($added_by) ||!empty($priority) ||!empty($lead_date) ||!empty($lead_month_year) ||!empty($state_id) ||!empty($dist_id) ||!empty($city_id)||!empty($area_id) )
						{
							$class = "";
						}
						?>
						
						<div id="toggle_srch" class="<?php echo $class;?>">
						
						<div class="form-group col-md-2">                           
                            <select class="form-control" id="ref_id" name="ref_id" onchange="table_list(1);">
							<option value=""> Select Reference By </option>
							 <?php  if(!empty($reference_list)){ 							
								foreach($reference_list as $key=>$ref){					        
									     $selected    = $reference==$ref['ref_id']?"selected":"";	?>
									<option value="<?php echo $ref['ref_id']?>"  <?php echo $selected;?>><?php echo $ref['ref_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>					
						
						<div class="form-group col-md-2">                           
                            <select class="form-control" id="product_id" name="product_id" onchange="table_list(1);">
							<option value=""> Select Product</option>
							 <?php  if(!empty($product_list)){ 
								foreach($product_list as $product){										 
									     $selected      = $product_id==$product['pm_id']?"selected":""; ?>
									<option value="<?php echo $product['pm_id'];?>" <?php echo $selected;?>><?php echo $product['pm_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 
						<div class="form-group col-md-2">                           
                            <select class="form-control" id="added_by" name="added_by" onchange="table_list(1);">
							<option value=""> Select Added By</option>
							 <?php  if(!empty($employee_list)){ 
								foreach($employee_list as $employee){ 
										$selected  = $added_by==$employee['user_id']?"selected":"";?>
									<option value="<?php echo $employee['user_id'];?>" <?php echo $selected;?>><?php echo $employee['emp_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 
                        <div class="form-group col-md-2">                           
                            <select class="form-control" id="priority" name="priority" onchange="table_list(1);">
							<option value=""> Select Priority</option>
							 <?php  if(!empty($priority_list)){ 
								foreach($priority_list as $prity){
									$selected = $priority==$prity?"selected":"";?>
									<option value="<?php echo $prity?>" <?php echo $selected;?> ><?php echo $prity; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>					
						<div class="form-group col-md-2"> 
                          <input type="text" class="form-control pull-right datepickerD" id="lead_date" name="lead_date" placeholder="Date" maxlength="10" value="<?php echo isset($lead_post_data['lead_date'])?$lead_post_data['lead_date']:"";?>" readonly="true">
                        </div>	
						<div class="form-group col-md-2"> 
                          <input type="text" class="form-control pull-right datepickerMY" id="lead_month_year" name="lead_month_year" placeholder="Month" maxlength="7" value="<?php echo isset($lead_post_data['lead_month_year'])?$lead_post_data['lead_month_year']:"";?>" readonly="true">
                        </div>	
					 
						
					   <div class="form-group col-md-2">                           
                            <select class="form-control" id="state_id" name="state_id" onchange="get_state_districts(this,'dist_id');table_list(1);">
							<option value=""> Select State</option>
							 <?php  if(!empty($state_list)){ 
								foreach($state_list as $state){ 
								      $selected  = $state_id==$state['state_id']?"selected":""; ?>
									<option value="<?php echo $state['state_id'];?>" <?php echo $selected;?>><?php echo $state['state_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>  
						
						<div class="form-group col-md-2">                           
                            <select class="form-control" id="dist_id" name="dist_id" onchange="get_district_cities(this,'state_id','city_id');table_list(1);">
							<option value=""> Select District</option>
							 <?php  if(!empty($dist_list)){ 
								foreach($dist_list as $dist){ 
										
									     $selected      = $dist_id==$dist['dist_id']?"selected":""; ?>
									<option value="<?php echo $dist['dist_id'];?>" <?php echo $selected;?>><?php echo $dist['dist_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 
						
						<div class="form-group col-md-2">                           
                            <select class="form-control" id="city_id" name="city_id" onchange="get_city_area(this,'state_id','dist_id','area_id');table_list(1);">
							<option value=""> Select City</option>
							 <?php  if(!empty($city_list)){ 
								foreach($city_list as $city){ 
										
									     $selected      = $city_id==$city['city_id']?"selected":""; ?>
									<option value="<?php echo $city['city_id'];?>" <?php echo $selected;?>><?php echo $city['city_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
						<div class="form-group col-md-2">                           
                             <select class="form-control" id="area_id" name="area_id" onchange="table_list(1);" >
							<option value=""> Select Area</option>
						    <?php  if(!empty($area_list)){ 
								foreach($area_list as $area){ 
								  $selected = $area_id==$area['area_id']?"selected":"";
								
								?>
									<option value="<?php echo $area['area_id'];?>" <?php echo $selected;?> ><?php echo $area['area_name']; ?></option>
							<?php } } ?>	
						   </select>
                        </div>

											
						
						
                        </div>		
						
						
                        </form>
				    </div>
								
			<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th width="2%">Sr. No.</th>
				  <th width="20%">Lead Name </th>        				  
                  <th width="10%">Contact No</th>               
                  <th width="12%">Landline No </th>               
                  <th>	Address </th>  
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
	
$("#clear_btn").click(function(e){
	 $('#lead_date, #lead_month, #lead_year').val('');
	 $('#followup, #status, #searchStr_name').val('');
	 $('#searchStr_contact, #ref_id, #product_id').val('');
	 $('#added_by, #priority, #state_id').val('');
	 $('#dist_id, #city_id').val('');
	 $('#srch_form').trigger("reset");
	 table_list(1);
});		
$("#download_lead_report").click(function(e){
	var html = $('#srch_form').html();
	$('#srch_form').attr("action",base_url+"leads/download_lead_report");
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
		});	;	
		
		$('.datepickerMY').datepicker({
				format: 'mm-yyyy',
				autoclose: true,
				todayHighlight: true,
				viewMode: "months",
				minViewMode: "months"

		}).on('changeDate', function(e) {
			table_list(1);
		});	;	
		

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
			url:base_url+"ajax/tbl_lead_list/"+pageno,
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

