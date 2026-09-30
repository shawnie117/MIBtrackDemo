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
	
	<?php if(!empty($city_list)){  $count = count($city_list); } else { $count = 0 ;} ?>
   <div class="row">
      <div class="col-md-12">
         <div class="portlet light bordered">
		    <a  class="btn btn-success btn-sm pull-right" href="<?php echo base_url();?>masters/add_city" title="Add"><i class="fa fa-plus"></i> Add New </a> 
              
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
			<?php 
				  $city_post_data = array();
				  $dist_list      = array();
			      $history = $this->input->get('history');
				  if($history == "back")
				  {
					  $city_post_data = $this->session->userdata('city_post_data');
					  $dist_list = $city_post_data['dist_list'];					  
				  } 
			?>
             <div class="col-md-12"> 
				  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				       <div class="form-group col-md-3"> 
                            <input type="hidden" name="history" value="<?php $this->input->get('history');?>"/>					   
                            <select class="form-control" id="state_id" name="state_id" onchange="get_state_districts(this,'dist_id');">
							<option value=""> Select State</option>
							 <?php  if(!empty($state_list)){ 
								foreach($state_list as $state){
                                      $state_id = isset($city_post_data['state_id'])?$city_post_data['state_id']:"";
									  $selected = $state_id==$state['state_id']?"selected":"";
									?>
									<option value="<?php echo $state['state_id'];?>" <?php echo $selected;?>><?php echo $state['state_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 
						<div class="form-group col-md-3">                           
                            <select class="form-control" id="dist_id" name="dist_id" onchange="table_list(1);">
							<option value=""> Select District</option>
							 <?php  if(!empty($dist_list)){ 
								foreach($dist_list as $dist){
									  $dist_id  = isset($city_post_data['dist_id'])?$city_post_data['dist_id']:"";
									  $selected = $dist_id==$dist['dist_id']?"selected":"";									
								?>
									<option value="<?php echo $dist['dist_id'];?>" <?php echo $selected;?>><?php echo $dist['dist_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 
						
						<div class="form-group col-md-2">                           
                            <select class="form-control" id="status" name="status" onchange="table_list(1);">
							<option value=""> Select Status</option>
							 <?php  if(!empty($status_list)){ 
								foreach($status_list as $stat){ 
								      $status   = isset($city_post_data['status'])?$city_post_data['status']:"";
									  $selected = $status==$stat?"selected":"";
								
								?>
									<option value="<?php echo $stat?>" <?php echo $selected;?> ><?php echo $stat; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
						<div class="form-group col-md-2"> 
                           
                           <input class="form-control" id="searchStr" name="searchStr" type="text" placeholder="Search..." maxlength="100" value="<?php echo isset($city_post_data['searchStr'])?$city_post_data['searchStr']:"";?>" onchange="table_list(1);">
						 
                        </div>		
						
						<div class="form-group col-md-2 hidden"> 
						
                          <button class="btn green btn-outline" type="submit" ><i class="fa fa-search"></i>Search</button>
						 
                        </div>
                        </form>
				    </div>
						
			<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th>Sr. No.</th>	
                  <th>State</th>               
                  <th>District</th>               
                  <th>City</th>               
                  <th style="text-align:center">Status</th>
                  <th style="text-align:center">Action</th>				  
                </tr>
                </thead>
                <tbody id="tbl_list">
               
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
		
<!--END START MODAL -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
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
			url:base_url+"ajax/tbl_city_list/"+pageno,
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

