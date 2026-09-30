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
	
	<?php if(!empty($reference_list)){  $count = count($reference_list); } else { $count = 0 ;} ?>
   <div class="row">
      <div class="col-md-12">

         <div class="portlet light bordered">
		   
			
			<div class="col-sm-8 col-md-8  col-lg-10">
			<span class="caption-subject font-green-sharp sbold "><?php echo $page_title; ?></span>
			
			<span class="caption-subject font-red-mint sbold total_count ">( Total - 0 )</span>	 
			</div>
			
<center>
			<a  class="btn btn-success btn-sm  " href="<?php echo get_module_path();?>masters/add_cheque" title="Add"><i class="fa fa-plus"></i> Add New </a> 
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
				   <?php $ref_post_data = array();
			      $history = $this->input->get('history');
				  if($history == "back")
				  {
					  $ref_post_data = $this->session->userdata('ref_post_data');	
				  } 
			?>        
             <div class="col-md-12 table-group-actions "> 
			     <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				      <div class="form-group col-md-4">                           
                            <select class="form-control" id="status" name="status" onchange="table_list(1);">
							<option value=""> Select Status</option>
							 <?php  if(!empty($status_list)){ 
								foreach($status_list as $stat){ 
								  		 $status   = isset($ref_post_data['status'])?$ref_post_data['status']:"";
									     $selected = $status==$stat?"selected":"";						
								?>
									<option value="<?php echo $stat?>" <?php echo $selected;?> ><?php echo $stat; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
						<div class="form-group col-md-4"> 
                           <input class="form-control" id="searchStr" name="searchStr" type="text" placeholder="Search By Name / Amount" maxlength="100" value="<?php echo isset($ref_post_data['searchStr'])?$ref_post_data['searchStr']:"";?>" onchange="table_list(1);">
						 
                        </div>
                        </form>
					  
				    </div>
						<div class="tbl-container">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th width="5%">Sr.No.</th>
						<th>Name</th>
						<th>Amount</th>
						<th>Date</th>
						<th>Bank</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
					</thead>

					<tbody id="tbl_list">
					
				</tbody>
			</table>
						</div>
						   		<!-- Render pagination links -->
						<div class="pagination" >
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
			url:base_url+"ajax/tbl_cheque_list/"+pageno,
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


<style>


@media (max-width:768px) {
	
	.tbl-container{
overflow-x: auto;
	}
	.caption-subject{
		font-size: 13px;
		padding-bottom:10px;
	}
}

</style>