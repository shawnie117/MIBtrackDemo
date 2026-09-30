<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	  <div class="col-md-10">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url("dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url("masters/one_time_service_report")?>">All One Time Services </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
			<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint <?php echo $icon ;?> "></i>
                  <span class="caption-subject font-green-sharp bold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div>
            <div class="row">
			
               <div class="portlet-body form">
				  <?php if($action=="Edit"){ //echo "<pre/>"; print_r($details);die;
				  	$details = html_escape($details);
					$formaction = "edit_one_time_service/?id=".base64_encode($id);
					}else {  $formaction = "add_one_time_service"; } ?>
                     <form action="<?php echo base_url().'masters/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					<?php if($action=="Edit"){?>
                           <input type="hidden" name="id" value="<?php echo $id; ?>">
						   <?php } ?>
							  
					  <div class="form-group col-md-6">
                           <label for="prod_id">Select Product </label>
						   <select class="form-control" id="prod_id" name="prod_id" >
							<option value=""> Select Product</option>
							 <?php  if(!empty($product_list )){ 	 						
								foreach($product_list as $product){ 
                                    $product_id =  isset($details['product_id'])?$details['product_id']:set_value("prod_id");
									$selected  = $product_id == $product['pm_id']?"selected":"";
									?>
									<option value="<?php echo $product['pm_id'];?>" <?php echo $selected;?>><?php echo $product['pm_name']; ?></option>
							<?php } } ?>	
						   </select>						
						   
						    <?php echo form_error('prod_id','<span class="text-danger">','</span>'); ?>
                        </div>
                        <div class="form-group col-md-6">
                           <label for="ots_name">Service Name </label><?php echo REQUIRED_STAR; ?>
						   
                           <input class="form-control" id="ots_name" name="ots_name" type="text" placeholder="Enter Service Name" required maxlength="100" value="<?php echo isset($details['ots_name'])?$details['ots_name']:set_value('ots_name'); ?>">
						    <?php echo form_error('ots_name','<span class="text-danger">','</span>'); ?>
                         </div> 
						  <div class="form-group col-md-6">
                           <label for="ots_type">Service type </label>
                           <input class="form-control" id="ots_type" name="ots_type" type="text" placeholder="Enter Service type"  maxlength="50" value="<?php echo isset($details['ots_type'])?$details['ots_type']:set_value('ots_type'); ?>">
						    <?php echo form_error('ots_type','<span class="text-danger">','</span>'); ?>
                         </div> 
						  
						 <div class="form-group col-md-6">
                           <label for="ots_desc">Details</label>
						   
                           <textarea class="form-control" id="ots_desc" name="ots_desc" placeholder="Enter Details"  maxlength="500" cols="6"><?php echo isset($details['ots_desc'])?$details['ots_desc']:set_value('ots_desc'); ?></textarea>
						    <?php echo form_error('ots_desc','<span class="text-danger">','</span>'); ?>
                         </div> 
						  <div class="form-group col-md-6">
                           <label for="ots_gst">GST % </label>
                           <input class="form-control" id="ots_gst" name="ots_gst" type="text" placeholder="Enter GST %"  maxlength="4" value="<?php echo isset($details['ots_gst'])?$details['ots_gst']:set_value('ots_gst'); ?>">
						    <?php echo form_error('ots_gst','<span class="text-danger">','</span>'); ?>
                         </div>   
						
						 <div class="form-group col-md-6">
                           <label for="price_regular">Price(Regular) </label>
                           <input class="form-control" id="price_regular" name="price_regular" type="text" placeholder="Enter Price(Regular)"  maxlength="10" value="<?php echo isset($details['ots_regular'])?$details['ots_regular']:set_value('price_regular'); ?>">
						    <?php echo form_error('price_regular','<span class="text-danger">','</span>'); ?>
                         </div> 
						 <div class="form-group col-md-6">
                           <label for="price_comm">Price(Commercial) </label>
                           <input class="form-control" id="price_comm" name="price_comm" type="text" placeholder="Enter Price(Commercial)"  maxlength="10" value="<?php echo isset($details['ots_commerial'])?$details['ots_commerial']:set_value('price_comm'); ?>">
						    <?php echo form_error('price_comm','<span class="text-danger">','</span>'); ?>
                         </div> 	  
						  </div>
						   <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" type="submit" >Submit</button>
                          <a href="<?php echo base_url();?>masters/one_time_service_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                        </div>
                        </div>
						</form>
				
                        <!-- /.box-body -->
                        
                     
                  </div>
               </div>
               </div>
            </div>
         </div>
         <!-- END PAGE BASE CONTENT -->
      </div>
      <!-- END CONTENT BODY -->
   </div>
   <!-- END CONTENT -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- Form Validation Plugins -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
		
<script type="text/javascript">
// Add Branch

$(document).ready(function() {
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
            ots_name: {
                required: true,
				maxlength: 100,
                minlength: 2,
				 }, 
			ots_type: {
               	maxlength: 50,
				 }, 
			ots_desc: {
				maxlength: 500,
				 },
			ots_gst: {
				maxlength: 4,
                number:true,
				 },
			price_regular: {
				maxlength: 10,
                number:true,
				 }, 	
		    price_comm: {
				maxlength: 10,
                number:true,
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