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
		      <a  class="btn btn-success btn-sm pull-right" href="<?php echo base_url();?>masters/add_notification" title="Add"><i class="fa fa-plus"></i> Add New </a> 
			  
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
		    <?php $noti_post_data = array();
			      $history = $this->input->get('history');
				  if($history == "back")
				  {
					  $noti_post_data = $this->session->userdata('noti_post_data');	
				  } 
			?>  
             <div class="col-md-12"> 
				  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				   <div class="form-group col-md-2">                           
                            <select class="form-control" id="noti_type" name="noti_type" onchange="table_list(1);">
							<option value=""> Select Type</option>
							 <?php  if(!empty($noti_type_list)){ 
							
								foreach($noti_type_list as $key=>$noti){ 
								         $noti_type   = isset($noti_post_data['noti_type'])?$noti_post_data['noti_type']:"";
									     $selected    = $noti_type==$key?"selected":"";	
					
								?>
									<option value="<?php echo $key?>"  <?php echo $selected;?>><?php echo $noti; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
				    <?php if($role_id == TECHNICIAN_ROLE_ID || $role_id == SALES_ROLE_ID || $role_id == CUSTOMER_ROLE_ID){ ?>
                         <div class="form-group col-md-3">                            
                          <input type="text" class="form-control pull-right datepicker" id="date" name="date" placeholder="Date..." maxlength="10" value="<?php echo isset($noti_post_data['date'])?$noti_post_data['date']:"";?>"  >
						 
                        </div>
						 <?php  } ?>
						
                     <?php  if($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID || $role_id == SUB_ADMIN_ROLE_ID){ ?>						 
				       <div class="form-group col-md-3">                           
                            <select class="form-control" id="permission_id" name="permission_id" onchange="table_list(1);">
							<option value=""> Select Notification For</option>
							 <?php  if(!empty($permission_list)){ 
								foreach($permission_list as $permission){ 
										 $permission_id = isset($noti_post_data['permission_id'])?$noti_post_data['permission_id']:"";
									     $selected      = $permission_id==$permission['permission_id']?"selected":"";						
								?>
									<option value="<?php echo $permission['permission_id'];?>" <?php echo $selected;?>><?php echo $permission['permission_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 
						
						<div class="form-group col-md-2">                           
                            <select class="form-control" id="status" name="status" onchange="table_list(1);">
							<option value=""> Select Status</option>
							 <?php  if(!empty($status_list)){ 
								foreach($status_list as $stat){ 
								  		 $status   = isset($noti_post_data['status'])?$noti_post_data['status']:"";
									     $selected = $status==$stat?"selected":"";						
								?>
									<option value="<?php echo $stat?>" <?php echo $selected;?> ><?php echo $stat; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
						
						<div class="form-group col-md-3"> 
                           
                           <input class="form-control" id="searchStr" name="searchStr" type="text" placeholder="Search..." maxlength="100" value="<?php echo isset($noti_post_data['searchStr'])?$noti_post_data['searchStr']:"";?>" onchange="table_list(1);">
						 
                        </div>
						<div class="form-group col-md-2"> 
                           <a class="btn green btn-outline" id="toggle_btn"  title="Advance Search"><i class=" icon-magnifier-add"></i></a>
						   <a class="btn btn-danger " id="clear_btn"  title="Clear Search"><i class=" icon-close"></i></a>
                          					 
                        </div>
						
						<?php  
						     $toggle = "hidden";
						    $noti_from = isset($noti_post_data['noti_from'])?$noti_post_data['noti_from']:"";
					         $noti_to = isset($noti_post_data['noti_to'])?$noti_post_data['noti_to']:"";
                            if(!empty($noti_to) || !empty($noti_from)){ $toggle = ""; } 
						?> 
						<div id="toggle_srch" class="<?php echo $toggle; ?>">	

						
						  <div class="form-group col-md-3"> 
                           
                          <input type="text" class="form-control pull-right datepicker" id="noti_from" name="noti_from" placeholder="From Date..." maxlength="10" value="<?php echo isset($noti_post_data['noti_from'])?$noti_post_data['noti_from']:"";?>"  >
						 
                        </div>			
						<div class="form-group col-md-3">                            
                          <input type="text" class="form-control pull-right datepicker" id="noti_to" name="noti_to" placeholder="To Date..." maxlength="10" value="<?php echo isset($noti_post_data['noti_to'])?$noti_post_data['noti_to']:"";?>"  >
						 
                        </div>
						<?php } ?>	
	                    			
                        </div>		
						
						
                        </form>
				    </div>
								
			<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th width="2%">Sr. No.</th>
				  <th width="10%">Image </th>        				  
                  <th>Title</th>               
                  <th width="20%">Description </th>               
                  <th width="8%">From Date </th>               
                  <th width="8%">To Date </th>               
                        
                  <th style="text-align:center" width="5%">Status</th>
                  <th style="text-align:center" width="5%">Action</th>				  
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
$("#form_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    }); 
	
	$("#clear_btn").click(function(e){
	 $('#noti_from, #noti_to').val('');
	 $('#noti_type, #status, #searchStr').val('');
	 $('#srch_form').trigger("reset");
	 table_list(1);
});		
	
  $('.datepicker').datepicker({
				format: 'dd-mm-yyyy',
				autoclose: true,
				todayHighlight: true,

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
table_list(1);
function table_list(pageno)
	{
		var formdata  = $("#srch_form").serializeArray();		
		$("#tbl_list").html("");
		$.ajax({
			url:base_url+"ajax/tbl_notification_list/"+pageno,
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

