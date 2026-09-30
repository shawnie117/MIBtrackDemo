<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
	<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
	<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
	<li><a href="<?php echo base_url(get_module()."/inventory/item_report")?>">All Item Report </a><i class="fa fa-circle"></i></li>
	<li><span class="active"><?php echo $page_title; ?></span></li>
	</ul>
            <!--div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint <?php echo $icon ;?> "></i>
                  <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div-->
            <div class="row">
			
               <div class="portlet-body form">
				  <?php if($action=="Edit"){ 
				     //echo "<pre/>"; print_r($details);die; 
				    $details = html_escape($details);
					$supplierList  = $details['supplierList'];
					$formaction = "edit_item/?ref_id=".base64_encode($ref_id);
					}else {  $formaction = "add_item"; } 
					
					?>
					
                     <form action="<?php echo get_module_path().'inventory/'.$formaction; ?>" id="add_edit_item" method="post" autocomplete="off" enctype="multipart/form-data" >
					  <div class="form-body">
					  <?php if($action=="Edit"){ ?>
					  <input type="hidden" value="<?php echo isset($details['supp_det_id'])?$details['supp_det_id']:set_value("supp_det_id"); ?>" name="supp_det_id" id="supp_det_id" />
					  <?php } ?>
				<!-- <center>
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
                  </center> -->

                      <div class="col-md-12">
					     <div class="portlet-title">
					            <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-call-out"></i>
								  <span class="caption-subject font-red-mint sbold">Contact Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>
					 		<div class="form-group col-md-3">
                           <label for="p_name">Item Name</label> <?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="p_name" name="p_name" type="text" placeholder="Enter Item Name" required maxlength="100" value="<?php echo isset($details['item_name'])?$details['item_name']:set_value("p_name"); ?>">
						    <?php echo form_error('p_name','<span class="text-danger">','</span>'); ?>
                           </div>
						   <div class="form-group col-md-3">
                           <label for="p_price">Purchase Price<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_price" name="p_price" type="text" placeholder="Enter Purchase Price" required maxlength="8" value="<?php echo isset($details['item_price'])?$details['item_price']:set_value("p_price"); ?>">
						    <?php echo form_error('p_price','<span class="text-danger">','</span>'); ?>
                           </div>  
						   <div class="form-group col-md-3">
                           <label for="p_price2">Sale Price<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_price2" name="p_price2" type="text" placeholder="Enter Sale Price" required maxlength="8" value="<?php echo isset($details['item_price2'])?$details['item_price2']:set_value("p_price2"); ?>">
						    <?php echo form_error('p_price2','<span class="text-danger">','</span>'); ?>
                           </div>  
						   <div class="form-group col-md-3">
                           <label for="p_gst">GST %<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_gst" name="p_gst" type="text" placeholder="Enter GST %" required maxlength="5" value="<?php echo isset($details['item_gst'])?$details['item_gst']:set_value("p_gst"); ?>">
						    <?php echo form_error('p_gst','<span class="text-danger">','</span>'); ?>
                           </div> 
						    <div class="form-group col-md-3">
                           <label for="p_desc">Item Description</label> <?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="p_desc" name="p_desc" type="text" placeholder="Enter Item Description" required maxlength="500" value="<?php echo isset($details['item_desc'])?$details['item_desc']:set_value("p_desc"); ?>">
						    <?php echo form_error('p_desc','<span class="text-danger">','</span>'); ?>
                           </div>
						    
						   
						   <div class="form-group col-md-3">
                           <label for="p_no">Item No.<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_no" name="p_no" type="text" placeholder="Enter Item No." required maxlength="10" value="<?php echo isset($details['item_no'])?$details['item_no']:set_value("p_no"); ?>">
						    <?php echo form_error('p_no','<span class="text-danger">','</span>'); ?>
                           </div> 
						   <div class="form-group col-md-3">
                           <label for="p_bufferline">Bufferline</label>
						   <input class="form-control" id="p_bufferline" name="p_bufferline" type="text" placeholder="Enter Bufferline"  maxlength="5" value="<?php echo isset($details['item_bufferline'])?$details['item_bufferline']:set_value("p_bufferline"); ?>">
						    <?php echo form_error('p_bufferline','<span class="text-danger">','</span>'); ?>
                           </div>  
						   
						   
						   <div class="col-md-3">
						   <div class="form-group col-md-10" style="padding:0px;">
						   <label for="p_catid">Category </label><?php echo REQUIRED_STAR; ?>		   
                            <select class="form-control" id="p_catid" name="p_catid" onchange="get_cat_subcat(this,'p_subcatid');" >
							<option value=""> Select Category</option>
							 <?php  if(!empty($category_list)){ 	
								foreach($category_list as $category){ 
								  $selected = isset($details['inv_cat_id']) && ($details['inv_cat_id']==$category['inv_cat_id'])?"selected":"";
								
								?>
									<option value="<?php echo $category['inv_cat_id'];?>" <?php echo $selected;?> ><?php echo $category['inv_cat_name']; ?></option>
							<?php } } ?>	
						   </select><?php echo form_error('p_catid','<span class="text-danger">','</span>'); ?>			
                        </div> 
						<div class="form-group col-md-2"> <br> <a data-toggle="modal" data-target="#form_modal" class="btn btn-success btn-xs " href="<?php echo get_module_path();?>inventory/add_category/?url=add_item" style="top:10px;" title="Add Category"><i class="fa fa-plus"></i></a></div>	
                        </div> 
						
						<div class="col-md-3">
						 <div class="form-group col-md-10" style="padding:0px;">
						   <label for="p_subcatid">Sub Category </label><?php echo REQUIRED_STAR; ?>   
                            <select class="form-control" id="p_subcatid" name="p_subcatid" >
							<option value=""> Select Sub Category</option>
							 <?php  if(!empty($sub_cat_list)){ 	
								foreach($sub_cat_list as $sub_cat){ 
								  $selected = isset($details['inv_subcat_id']) && ($details['inv_subcat_id']==$sub_cat['inv_subcat_id'])?"selected":"";
								
								?>
									<option value="<?php echo $sub_cat['inv_subcat_id'];?>" <?php echo $selected;?> ><?php echo $sub_cat['inv_subcat_name']; ?></option>
							<?php } } ?>	
						   </select><?php echo form_error('p_subcatid','<span class="text-danger">','</span>'); ?>	
                        </div> 	
                        <div class="form-group col-md-2"> <br> <a data-toggle="modal" data-target="#form_modal" class="btn btn-success btn-xs " href="<?php echo get_module_path();?>inventory/add_sub_category/?url=add_item" style="top:10px;" title="Add Sub Category"><i class="fa fa-plus"></i></a></div>						   
                        </div> 
						
						  <div class="form-group col-md-3">
                           <label for="p_quantity">Quantity</label>
						   <input class="form-control" id="p_quantity" name="p_quantity" type="text" placeholder="Enter Bufferline"  maxlength="5" value="<?php echo isset($details['item_qty'])?$details['item_qty']:set_value("p_quantity"); ?>">
						    <?php echo form_error('p_quantity','<span class="text-danger">','</span>'); ?>
                           </div> 
						   <div class="col-md-3">
						   <div class="form-group col-md-10" style="padding:0px;">
						   
						   <label for="p_areaid">Area </label><?php echo REQUIRED_STAR; ?>		   
                            <select class="form-control" id="p_areaid" name="p_areaid" onchange="get_area_shelf(this,'p_shielfid');" >
							<option value=""> Select Area</option>
							 <?php  if(!empty($area_list)){ 	
								foreach($area_list as $area){ 
								  $selected = isset($details['area_id']) && ($details['area_id']==$area['area_id'])?"selected":"";
								
								?>
									<option value="<?php echo $area['area_id'];?>" <?php echo $selected;?> ><?php echo $area['area_name']; ?></option>
							<?php } } ?>	
						   </select><?php echo form_error('p_areaid','<span class="text-danger">','</span>'); ?>			
                          </div>
						  <div class="form-group col-md-2"> <br> <a data-toggle="modal" data-target="#form_modal" class="btn btn-success btn-xs " href="<?php echo get_module_path();?>inventory/add_area/?url=add_item" style="top:10px;" title="Add Area"><i class="fa fa-plus"></i></a></div>
                          </div>
                        <div class="col-md-3">
                         <div class="form-group col-md-10" style="padding:0px;">
						   <label for="p_shielfid">Shelf </label><?php echo REQUIRED_STAR; ?>		   
                            <select class="form-control" id="p_shielfid" name="p_shielfid" onchange="get_shelf_subshelf(this,'p_areaid','p_subshielfid');" >
							<option value=""> Select Shelf</option>
							 <?php  if(!empty($shelf_list)){ 	
								foreach($shelf_list as $shelf){ 
								  $selected = isset($details['item_shelfid']) && ($details['item_shelfid']==$shelf['shelf_id'])?"selected":"";
								
								?>
									<option value="<?php echo $shelf['shelf_id'];?>" <?php echo $selected;?> ><?php echo $shelf['shelf_name']; ?></option>
							<?php } } ?>	
						   </select><?php echo form_error('p_shielfid','<span class="text-danger">','</span>'); ?>			
                         </div> 	
                        <div class="form-group col-md-2"> <br> <a data-toggle="modal" data-target="#form_modal" class="btn btn-success btn-xs " href="<?php echo get_module_path();?>inventory/add_shelf/?url=add_item" style="top:10px;" title="Add Shelf"><i class="fa fa-plus"></i></a></div>
												
                        </div> 				
						
						<div class="col-md-3">
						<div class="form-group col-md-10" style="padding:0px;">
						   <label for="p_subshielfid">Sub Shelf </label> 
                            <select class="form-control" id="p_subshielfid" name="p_subshielfid"  >
							<option value=""> Select Sub Shelf</option>
							 <?php  if(!empty($sub_shelf_list)){ 	
								foreach($shelf_list as $sub_shelf){ 
								  $selected = isset($details['item_subshelfid']) && ($details['item_subshelfid']==$sub_shelf['subshelf_id'])?"selected":"";
								
								?>
									<option value="<?php echo $sub_shelf['subshelf_id'];?>" <?php echo $selected;?> ><?php echo $sub_shelf['subshelf_name']; ?></option>
							<?php } } ?>	
						   </select><?php echo form_error('p_subshielfid','<span class="text-danger">','</span>'); ?>			
                        </div> 	
                        <div class="form-group col-md-2"> <br> <a data-toggle="modal" data-target="#form_modal" class="btn btn-success btn-xs " href="<?php echo get_module_path();?>inventory/add_sub_shelf/?url=add_item" style="top:10px;" title="Add Sub Shelf"><i class="fa fa-plus"></i></a></div>						
						</div>
						
						
						<div class="col-md-3">
						<div class="form-group col-md-10" style="padding:0px;">
						   <label for="p_unit">Unit </label><?php echo REQUIRED_STAR; ?>		   
                            <select class="form-control" id="p_unit" name="p_unit" >
							<option value=""> Select Unit</option>
							 <?php  if(!empty($unit_list)){ 	
								foreach($unit_list as $unit){ 
								  $selected = isset($details['item_unitid']) && ($details['item_unitid']==$unit['inv_unit_id'])?"selected":"";
								
								?>
									<option value="<?php echo $unit['inv_unit_id'];?>" <?php echo $selected;?> ><?php echo $unit['inv_unit_name']; ?></option>
							<?php } } ?>	
						   </select><?php echo form_error('p_unit','<span class="text-danger">','</span>'); ?>			
                        </div>
						<div class="form-group col-md-2"> <br> <a data-toggle="modal" data-target="#form_modal" class="btn btn-success btn-xs " href="<?php echo get_module_path();?>inventory/add_unit/?url=add_item" style="top:10px;" title="Add Unit"><i class="fa fa-plus"></i></a></div>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="p_itempack">Pieces <?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_itempack" name="p_itempack" type="text" placeholder="Enter Pieces"  required maxlength="5" value="<?php echo isset($details['item_pack'])?$details['item_pack']:set_value("p_itempack"); ?>">
						    <?php echo form_error('p_itempack','<span class="text-danger">','</span>'); ?>
                        </div>	
                        <div class="form-group col-md-3">
						   <label for="p_suplids">Supplier </label><?php echo REQUIRED_STAR; ?>		   
                            <select class="form-control selectpicker" id="p_suplids" name="p_suplids[]"  multiple>
							<option value=""> Select Supplier</option>
							 <?php  if(!empty($supplier_list)){ 	
								foreach($supplier_list as $supplier){
									$selected = "";
									
                                     if(!empty($supplierList))	{
									    foreach($supplierList as $supp){  
										  if($supp['supp_det_id'] == $supplier['supp_id']){
											$selected = "selected";
										  }
									    }
								      }
																  
								  
								
								?>
									<option value="<?php echo $supplier['supp_det_id'];?>" <?php echo $selected;?> ><?php echo $supplier['supp_name']; ?></option>
							<?php } } ?>	
						   </select><?php echo form_error('p_suplids[]','<span class="text-danger">','</span>'); ?>			
                        </div> 						
					    <div class="col-md-3">
						 <div class="form-group col-md-10" style="padding:0px;">
						   <label for="p_brandid">Brand </label><?php echo REQUIRED_STAR; ?>		   
                            <select class="form-control" id="p_brandid" name="p_brandid" >
							<option value=""> Select Brand</option>
							 <?php  if(!empty($brand_list)){ 	
								foreach($brand_list as $brand){ 
								  $selected = isset($details['inv_brand_id']) && ($details['inv_brand_id']==$brand['inv_brand_id'])?"selected":"";
								
								?>
									<option value="<?php echo $brand['inv_brand_id'];?>" <?php echo $selected;?> ><?php echo $brand['inv_brand_name']; ?></option>
							<?php } } ?>	
						   </select><?php echo form_error('p_brandid','<span class="text-danger">','</span>'); ?>			
                        </div>
						<div class="form-group col-md-2"> <br> <a data-toggle="modal" data-target="#form_modal" class="btn btn-success btn-xs " href="<?php echo get_module_path();?>inventory/add_brand/?url=add_item" style="top:10px;" title="Add Brand"><i class="fa fa-plus"></i></a></div>
                        </div>  
						<div class="form-group col-md-3">
                           <label for="p_code">Item Code <?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_code" name="p_code" type="text" placeholder="Enter Item Code"  required maxlength="5" value="<?php echo isset($details['item_code'])?$details['item_code']:set_value("p_code"); ?>">
						    <?php echo form_error('p_code','<span class="text-danger">','</span>'); ?>
                        </div>
						
						<div class="form-group col-md-3">
                           <label for="p_hsncode">HSN Code <?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_hsncode" name="p_hsncode" type="text" placeholder="Enter HSN Code"  required maxlength="8" value="<?php echo isset($details['item_hsncode'])?$details['item_hsncode']:set_value("p_hsncode"); ?>">
						    <?php echo form_error('p_hsncode','<span class="text-danger">','</span>'); ?>
                        </div>
						   <div class="form-group col-md-3">
                           <label for="p_capacity">Capacity</label>
						   <input class="form-control" id="p_capacity" name="p_capacity" type="text" placeholder="Enter Capacity" maxlength="8" value="<?php echo isset($details['item_capacity'])?$details['item_capacity']:set_value("p_capacity"); ?>">
						    <?php echo form_error('p_capacity','<span class="text-danger">','</span>'); ?>
                            </div> 
						<div class="form-group col-md-3">
                           <label for="p_barcode">Barcode <?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_barcode" name="p_barcode" type="text" placeholder="Enter Barcode"  required maxlength="50" value="<?php echo isset($details['spm_barcode1'])?$details['spm_barcode1']:set_value("p_barcode"); ?>">
						    <?php echo form_error('p_barcode','<span class="text-danger">','</span>'); ?>
                        </div>	
						<?php if($action=="Add"){  ?>		
				         <div class="form-group col-md-3">
                           <label for="p_image">Item Image </label><br>
                            <input type="file" name="p_image"  id="p_image" 
							class="smart-file" 
							data-label="Item Image" 
							data-btn-class="btn btn-default btn-sm" 
							data-preview="on"
							data-file-types="image/jpeg,image/png,image/jpg"  accept="image/*"  />
							<?php echo form_error('p_image','<span class="text-danger">','</span>'); ?>
							<span class="file_err"></span>
                        </div>	 
						<div class="form-group col-md-5">
                           <label for="p_multi_image">Feature Images <small>(Upload multiple feature images)</small></label>
                            <input type="file" name="p_multi_image[]"  id="p_multi_image" 
							class="smart-file" 
							data-label="Feature Images" 
							data-btn-class="btn btn-default btn-sm" 
							data-preview="on"
							data-file-types="image/jpeg,image/png,image/jpg" accept="image/*"  multiple   />
							<?php echo form_error('p_multi_image','<span class="text-danger">','</span>'); ?>
							<span class="file_err"></span>
                        </div>
						<?php }  ?>		
						<?php if($action=="Edit"){  ?>		
						  <div class="form-group col-md-8">
							 <?php $image      = $details['item_image'];
								   $image      = str_replace("getAuthApiKey",APIKEY,$image); ?>
                           <label for="p_image">Item Image </label>
                            <input type="file" name="p_image"  id="p_image" 
							class="smart-file" 
							data-label="Item Image" 
							data-btn-class="btn btn-default btn-sm" 
							data-preview="on"
							data-file-types="image/jpeg,image/png,image/jpg" accept="image/*"   />
							<?php echo form_error('p_image','<span class="text-danger">','</span>'); ?>
							
							<ul class="list-unstyled small fileList thumbs"><li><img title="" src="<?php echo $image; ?>" class="img-rounded"><span class="file-name"></span></li></ul>
							
							<span class="file_err"></span>
                        </div>	 
						<div class="form-group col-md-12">
						     <?php $imageList    = $details['invItemImageList']; ?>
							 <small>(Upload multiple feature images)</small>
                           <label for="p_multi_image"> <br/>Feature Images </label>
                            <input type="file" name="p_multi_image[]"  id="p_multi_image" 
							class="smart-file" 
							data-label="Feature Images" data-btn-class="btn btn-default btn-sm" 		data-preview="on" 
							data-file-types="image/jpeg,image/png,image/jpg" accept="image/*" multiple   />
							<?php echo form_error('p_multi_image','<span class="text-danger">','</span>'); ?>
							
							<ul class="list-unstyled small fileList thumbs">
							
							<?php if(!empty($imageList)) { 
							       foreach($imageList as $key=>$image) {
								$image1      = $image['pid_img_path'];
								$image1     = str_replace("getAuthApiKey",APIKEY,$image1);
								$image_name_arr = explode("/",$image1);
								$image_name = end($image_name_arr);
								?>
								
							<li id="image_li_<?php echo $key; ?>"><input type="hidden" name="old_imgs[]" value="<?php echo $image_name; ?>" /><img title="" src="<?php echo $image1; ?>" class="img-rounded"><span class="file-name"></span> <input type="button" data-id="<?php echo $key; ?>" value="×" class="btn btn-danger btn-xs" onclick="delete_image(this)" title="Delete Image" style="float:right;"></li>
							<?php } } ?>
							</ul>
							<span class="file_err"></span>
                        </div>	 
						   <?php } ?>
				
						   <div class="form-actions">
						 <div class="col-md-12">
						 <center>						  
                           <button type="submit" class="btn btn-success" >Submit</button>
                          <a href="<?php echo get_module_path();?>inventory/item_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
						  </center>
                        </div>
                        </div>
						</form>
				
                        <!-- /.box-body -->
                 
               </div>
               </div>
            </div>
         </div>
         <!-- END PAGE BASE CONTENT -->
      </div>
      <!-- END CONTENT BODY -->
   </div>
   <!-- END CONTENT -->
   <div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true"  data-backdrop="static">
			<div class="modal-dialog modal-md">
			<div class="modal-content">			
			</div>
			</div>
		</div>	
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- Form Validation Plugins -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
		
<script type="text/javascript">
// Add Branch

$(document).ready(function() {
	
	
	 $('.smart-file').bootstrapFileField({
            maxNumFiles: 8,
            fileTypes: 'image/jpeg,image/png,image/jpg',  
		/* 	minNumFiles:1, */
            maxFileSize: 4000000 // 8Mb in bytes */
        });
	
$("#form_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    }); 
	
	$("#add_edit_item").validate({
        rules: {
            required: {
                required: true
            },
			p_name: {
				required: true,
            	maxlength: 100,
                minlength: 2,
				 },
			p_desc: {
				required: true,
            	maxlength: 500,
                minlength: 2,
				 },
			
            p_price: {
				required: true,
            	maxlength: 8,
				number:true,
				 },  
				 
			p_price2: {
				required: true,
            	maxlength: 8,
				number:true,
				 }, 
			p_bufferline: {
				maxlength: 5,
				digits:true,
				 }, 
			p_gst: {
				maxlength: 5,
				number:true,
				 }, 
            p_no: {
            	maxlength: 10,
                digits:true,
				 }, 	 
			p_quantity: {
            	maxlength: 5,
                digits:true,
				 }, 	
			p_unit: {
				required: true,
            	maxlength: 5,
                digits:true,
				 }, 
			p_code: {
				required: true,
            	maxlength: 5,
  				 }, 	
			p_hsncode: {
            	maxlength:8,
  				 }, 
			p_capacity: {
            	maxlength: 8,
				digits:true,
  				 }, 
			p_itempack: {
				required: true,
            	maxlength: 5,
				digits:true,
  				 }, 	 
			p_barcode: {
            	maxlength: 50,
				}, 	 
			"p_suplids[]": {
				required: true,
  				 }, 	 
		     p_image: {
				   accept: "image/jpeg,image/png,image/jpg",
				   filesize_max:1000000, // 1 MB
				   filesize_min:10000, // 1 KB
   				}, 
			"p_multi_image[]": {
				   accept: "image/jpeg,image/png,image/jpg",
				   filesize_max:1000000, // 1 MB
				   filesize_min:10000, // 1 KB
   				}, 				  
			
		   	},
		
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        },
		onfocusout: false,
	    invalidHandler: function(form, validator) {
			var errors = validator.numberOfInvalids();
			if (errors) {                    
            validator.errorList[0].element.focus();
			}
		   },
		errorPlacement: function(error, element) {
		   if (element.is(":file")) {
			 error.appendTo((element).parents('.form-group').find('.file_err'));
			}else if (element.is(":checkbox")){ // This is the default behavior of the script for all fields
			error.appendTo("#file_err");
			}else { // This is the default behavior of the script for all fields
			error.insertAfter(element);
			}
			
		},
    });
	

	
    });
	
	
</script>