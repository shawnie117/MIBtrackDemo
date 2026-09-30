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
		    <a  class="btn btn-success btn-sm  pull-right" href="<?php echo get_module_path();?>inventory/add_item"  title="Add"><i class="fa fa-plus"></i> Add New </a> 
			
			<span class="caption-subject font-green-sharp sbold pull-left"><?php echo $page_title; ?></span>&nbsp; <span class="caption-subject font-red-mint sbold total_count ">( Total - 0 )</span>	 
			
            
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
				   <?php $item_post_data = array();
			      $history = $this->input->get('history');
				  $page = 1;
				  if($history == "back")
				  {
					  $item_post_data = $this->session->userdata('item_post_data');	
					  $page = $item_post_data['page'];	
				  } 
			?>        
             <div class="col-md-12 table-group-actions pull-right"> 
			     <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				      <div class="form-group col-md-2">                           
                            <select class="form-control" id="status" name="status" onchange="table_list(1);">
							<option value=""> Select Status</option>
							 <?php  if(!empty($status_list)){ 
								foreach($status_list as $stat){ 
								  		 $status   = isset($item_post_data['status'])?$item_post_data['status']:"";
									     $selected = $status==$stat?"selected":"";						
								?>
									<option value="<?php echo $stat?>" <?php echo $selected;?> ><?php echo $stat; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
						 <div class="form-group col-md-2">   
						 <select class="form-control" id="brand_id" name="brand_id"  onchange="table_list(1);">
							<option value=""> Select Brand</option>
							 <?php  if(!empty($brand_list)){ 	
								foreach($brand_list as $brand){ 
								  $selected = isset($item_post_data['inv_brand_id']) && ($item_post_data['inv_brand_id']==$brand['inv_brand_id'])?"selected":"";
								
								?>
									<option value="<?php echo $brand['inv_brand_id'];?>" <?php echo $selected;?> ><?php echo $brand['inv_brand_name']; ?></option>
							<?php } } ?>	
						   </select>
						   </div>
						    <div class="form-group col-md-3">   
						   <select class="form-control" id="p_catid" name="p_catid" onchange="get_cat_subcat(this,'p_subcatid');table_list(1);" >
							<option value=""> Select Category</option>
							 <?php  if(!empty($category_list)){ 	
								foreach($category_list as $category){ 
								  $selected = isset($item_post_data['p_catid']) && ($item_post_data['p_catid']==$category['inv_cat_id'])?"selected":"";
								
								?>
									<option value="<?php echo $category['inv_cat_id'];?>" <?php echo $selected;?> ><?php echo $category['inv_cat_name']; ?></option>
							<?php } } ?>	
						   </select>
						     </div>
							 <div class="form-group col-md-3">   
						   <select class="form-control" id="p_subcatid" name="p_subcatid" onchange="table_list(1);" >
							<option value=""> Select Sub Category</option>
							 </select>
							   </div>
							   
							    <div class="form-group col-md-2">   
							<select class="form-control" id="p_unit" name="p_unit" onchange="table_list(1);">
							<option value=""> Select Unit</option>
							 <?php  if(!empty($unit_list)){ 	
								foreach($unit_list as $unit){ 
								  $selected = isset($item_post_data['p_unit']) && ($item_post_data['p_unit']==$unit['inv_unit_id'])?"selected":"";
								
								?>
									<option value="<?php echo $unit['inv_unit_id'];?>" <?php echo $selected;?> ><?php echo $unit['inv_unit_name']; ?></option>
							<?php } } ?>	
						   </select>
						     </div>
							   <div class="form-group col-md-2">   
							  <select class="form-control" id="p_areaid" name="p_areaid" onchange="get_area_shelf(this,'p_shielfid');table_list(1);" >
							<option value=""> Select Area</option>
							 <?php  if(!empty($area_list)){ 	
								foreach($area_list as $area){ 
								  $selected = isset($item_post_data['p_areaid']) && ($item_post_data['p_areaid']==$area['area_id'])?"selected":"";
								
								?>
									<option value="<?php echo $area['area_id'];?>" <?php echo $selected;?> ><?php echo $area['area_name']; ?></option>
							<?php } } ?>	
						   </select>
						     </div>
							 <div class="form-group col-md-2">   
						    <select class="form-control" id="p_shielfid" name="p_shielfid" onchange="get_shelf_subshelf(this,'p_areaid','p_subshielfid');table_list(1);" >
							<option value=""> Select Shelf</option>
						   </select>
						     </div>
							 <div class="form-group col-md-2">   
						   <select class="form-control" id="p_subshielfid" name="p_subshielfid" onchange="table_list(1);" >
							<option value=""> Select Sub Shelf</option>
							</select>
							  </div>
							 
							 <div class="form-group col-md-3">   
						   <select class="form-control" id="p_suplid" name="p_suplid" onchange="table_list(1);" >
							<option value=""> Select Supplier</option>
							 <?php  if(!empty($supplier_list)){ 	
								foreach($supplier_list as $supplier){ 
								  $selected = isset($item_post_data['p_suplid']) && ($item_post_data['p_suplid']==$supplier['supp_det_id'])?"selected":"";
								
								?>
									<option value="<?php echo $supplier['supp_det_id'];?>" <?php echo $selected;?> ><?php echo $supplier['supp_name']; ?></option>
							<?php } } ?>	
						   </select>
						     </div>
					     <div class="form-group col-md-3"> 
                           <input class="form-control" id="searchStr" name="searchStr" type="text" placeholder="Search..." maxlength="100" value="<?php echo isset($item_post_data['searchStr'])?$item_post_data['searchStr']:"";?>" onchange="table_list(1);">
						 
                        </div>
                        </form>
					  
				    </div>
						
			<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th style="text-align:center" width="5%">Sr. No.</th>	
                  <th width="13%">Item</th> 
                  <th>Purchase Price</th> 
				  <th>Brand</th> 
				  <th>GST</th> 
				  <th>Unit</th> 
				  <th>Quantity</th> 
				  <th>Bufferline</th> 
                  <th>Sale Price</th>        				  
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

});
table_list(<?php echo $page; ?>);
function table_list(pageno)
	{
		var formdata  = $("#srch_form").serializeArray();		
		$("#tbl_list").html("");
		$.ajax({
			url:base_url+"ajax_inventory/tbl_item_list/"+pageno,
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

