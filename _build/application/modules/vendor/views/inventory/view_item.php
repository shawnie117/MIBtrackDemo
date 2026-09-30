<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
         <div class="portlet light bordered">
		  <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url(get_module()."/inventory/item_report")?>">All Item Report </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint icon-list "></i>
                  <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
               </div>
			  
		   </div>
            <div class="row">
               <div class="portlet-body form">
                  <?php if(!empty($details)){
						$details = html_escape($details);  
						$id =  base64_encode($details['item_id']);
						$status  = $details['item_status'];
						$supplierList  = $details['supplierList'];
						//echo "<pre/>"; print_r($details);die;
						
					  ?> 
                    
                  <div class="col-md-12">
			           <div class="portlet-body">
					    <div class="col-md-12">
					   <div class="form-group">
						     <?php $imageList   = $details['invItemImageList']; 
							        $image      = $details['item_image'];
								    $image      = str_replace("getAuthApiKey",APIKEY,$image); 
							 
							 ?>
                          						
							<ul class="list-unstyled small fileList thumbs">
							<li><a class="fancybox-button" data-rel="fancybox-button" href="<?php echo $image; ?>"><img title="" src="<?php echo $image; ?>" class="img-rounded"><span class="file-name"></span></a></li>
							<?php if(!empty($imageList)) { 
							       foreach($imageList as $imageL) {
								$image      = $imageL['pid_img_path'];
								$image      = str_replace("getAuthApiKey",APIKEY,$image); ?>
							<li><a class="fancybox-button" data-rel="fancybox-button" href="<?php echo $image; ?>"><img title="" src="<?php echo $image; ?>" class="img-rounded"><span class="file-name"></span></a></li>
							<?php } } ?>
							
							</ul>
                        </div>
                        </div>
						
					   <div class="col-md-12">
					   <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-tag"></i>
								  <span class="caption-subject font-red-mint sbold">Item Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
							<tr><th width="25%">Item Name </th><td><?php echo isset($details['item_name'])?$details['item_name']:""; ?> </td>
							<th>Pieces  </th><td><?php echo isset($details['item_pack'])?$details['item_pack']:""; ?> </td>	</tr>	
							
							<tr><th>Purchase Price </th><td><?php echo isset($details['item_price'])?$details['item_price']:""; ?> </td><th>Brand  </th><td><?php echo isset($details['inv_brand_name'])?$details['inv_brand_name']:""; ?> </td>	</tr>
							
							<tr><th>Sale Price </th><td><?php echo isset($details['item_price2'])?$details['item_price2']:""; ?> </td><th>Item Code  </th><td><?php echo isset($details['item_code'])?$details['item_code']:""; ?> </td>	</tr>
							
							<tr><th> Description </th><td><?php echo isset($details['item_desc'])?$details['item_desc']:""; ?> </td><th>HSN Code  </th><td><?php echo isset($details['item_hsncode'])?$details['item_hsncode']:""; ?> </td>	</tr>
							
							<tr><th>GST %</th><td><?php echo isset($details['item_gst'])?$details['item_gst']:""; ?> </td><th>Capacity </th><td><?php echo isset($details['item_capacity'])?$details['item_capacity']:""; ?> </td>		</tr>
							
							<tr><th>Item No.</th><td><?php echo isset($details['item_no'])?$details['item_no']:""; ?> </td><th>Barcode1 </th><td><?php echo isset($details['spm_barcode1'])?$details['spm_barcode1']:""; ?> </td>	</tr>
							
							<tr><th>Bufferline</th><td><?php echo isset($details['item_bufferline'])?$details['item_bufferline']:""; ?> </td><th>Added By </th><td><?php echo isset($details['item_addedbyname'])?$details['item_addedbyname']:""; ?> </td>	</tr>
							
							<tr><th>Category</th><td><?php echo isset($details['inv_cat_name'])?$details['inv_cat_name']:""; ?> </td><th>Added On </th><td><?php echo isset($details['item_sdate'])?$details['item_sdate']:""; ?> </td>	</tr>
							
							<tr><th>Sub Category</th><td><?php echo isset($details['inv_subcat_name'])?$details['inv_subcat_name']:""; ?> </td><th>Status </th>
							<td> <?php  if($status=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($status=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								}  ?> </td>	</tr>
								
							<tr><th>Quantity</th><td><?php echo isset($details['item_qty'])?$details['item_qty']:""; ?> </td>
							<th>Area</th><td><?php echo isset($details['area_name'])?$details['area_name']:""; ?> </td>	</tr>
							<tr><th>Shelf </th><td><?php echo isset($details['shelf_name'])?$details['shelf_name']:""; ?> </td>
							<th>Sub Shelf </th><td><?php echo isset($details['subshelf_name'])?$details['subshelf_name']:""; ?> </td>	</tr>
							<tr><th>Unit </th><td><?php echo isset($details['inv_unit_name'])?$details['inv_unit_name']:""; ?> </td><th>Barcode2 </th><td><?php echo isset($details['spm_barcode1'])?$details['spm_barcode2']:""; ?> </td>	</tr>
							
												
							</tbody>
							 </table>
						 </div>
						 </div>
				
						  <?php if(!empty($supplierList)){ ?>
						 <div class="col-md-8">
						  <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-users"></i>
								  <span class="caption-subject font-red-mint sbold">Supplier Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
						<table class="table table-striped table-bordered table-advance table-hover">
						<tbody>
						<tr><th>Sr.No.  </th><th>Supplier Name  </th><th>Contact No.  </th>
						<th>Email Id</th></tr>
						<?php foreach($supplierList as $key=>$supp) {  ?>
							<tr>
							<td><?php echo $key+1; ?> </td>
							<td><?php echo isset($supp['supp_name'])?$supp['supp_name']:""; ?> </td>
							<td><?php echo isset($supp['supp_det_mob1'])?$supp['supp_det_mob1']:""; ?> </td>
							<td><?php echo isset($supp['supp_det_emailid'])?$supp['supp_det_emailid']:""; ?> </td></tr>
							<?php } ?> 
					     </tbody>
						</table>
						 </div>
						 <?php } ?> 
						 
						<div class="form-actions">
						 <div class="col-md-12">
						 <center>						  
                          <?php  if($status=="Active") { ?>
						     <a href="<?php echo get_module_path();?>inventory/edit_item/?ref_id=<?php echo  $id;?>" class="btn btn-primary"><i class="fa fa-pencil"></i>Edit</a>
							 <a  class="btn btn-danger"  data-href="<?php echo get_module_path();?>inventory/deactivate_item/?ref_id=<?php echo  $id;?>" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i>Deactivate</a>
						  <?php } ?>
                          <a href="<?php echo get_module_path();?>inventory/item_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
						  </center>
                        </div>
                        </div>
						
						 </div>
						 
						 
                        <!-- /.box-body -->
                        	<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      Details Not Found !!!
                  </div>
						<?php } ?>
                        
                     
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
$(document).ready(function() {
	
	 $("#form_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    }); 
  $('#confirm-deactivate').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });	
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
            brand_name: {
                required: true,
				maxlength: 100,
                minlength: 2,
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
        }
    });
    });
</script>