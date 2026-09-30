<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	  <div class="col-md-10">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url("dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url("masters/amc_report")?>">All AMC Service Report </a><i class="fa fa-circle"></i></li>
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
					$formaction = "edit_amc/?id=".base64_encode($id);
					}else {  $formaction = "add_amc"; } ?>
                     <form action="<?php echo base_url().'masters/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					<?php if($action=="Edit"){?>
                           <input type="hidden" name="id" value="<?php echo $id; ?>">
						   <?php } ?>
							  
					  <div class="form-group col-md-6">
                           <label for="amc_product_id">Select Product </label>
						   <select class="form-control" id="amc_product_id" name="amc_product_id[]" multiple >
							<option value=""> Select Product</option>
							 <?php  if(!empty($product_list )){ 	 						
								foreach($product_list as $product){ 
                                    $selected = "";
									if(!empty($details['amcDetailDetails'])){ 
										foreach($details['amcDetailDetails'] as $prod){
											
									            if($prod['product_id']==$product['pm_id']){
													 $selected = "selected";
												}
										}
									}?>
									<option value="<?php echo $product['pm_id'];?>" <?php echo $selected;?>><?php echo $product['pm_name']; ?></option>
							<?php } } ?>	
						   </select>						
						   
						    <?php echo form_error('amc_product_id','<span class="text-danger">','</span>'); ?>
                        </div>
						 <div class="form-group col-md-6">
                           <label for="amc_duration">AMC Duration </label><?php echo REQUIRED_STAR; ?>
							<input class="form-control" required maxlength="4" id="amc_duration"  name="amc_duration" list="all_amc_duration" placeholder="Select AMC Duration In Days" autocomplete="off" value="<?php echo isset($details['amc_duration'])?$details['amc_duration']:set_value('amc_duration'); ?>" onchange="get_sit();"/>
							 
							 <datalist id="all_amc_duration">
							  <?php  if(!empty($duration_list )){ 	 						
								foreach($duration_list as $key=>$duration){ ?>
									<option value="<?php echo $key;?>" label="<?php echo $duration; ?>" ></option>
							<?php } } ?>	
						     </datalist>
						    <?php echo form_error('amc_duration','<span class="text-danger">','</span>'); ?>
                         </div>
						   <div class="form-group col-md-6">
                           <label for="amc_noofservices">No. Of Services </label><?php echo REQUIRED_STAR; ?>
						   
                           <input class="form-control" id="amc_noofservices" name="amc_noofservices" type="text" placeholder="Enter No. Of Services" required maxlength="3" value="<?php echo isset($details['amc_noofservices'])?$details['amc_noofservices']:set_value('amc_noofservices'); ?>" onchange="get_sit();">
						    <?php echo form_error('amc_noofservices','<span class="text-danger">','</span>'); ?>
                         </div> 
                        <div class="form-group col-md-6">
                           <label for="amc_name">AMC Name </label><?php echo REQUIRED_STAR; ?>
						   
                           <input class="form-control" id="amc_name" name="amc_name" type="text" placeholder="Enter AMC Name" required maxlength="100" value="<?php echo isset($details['amc_name'])?$details['amc_name']:set_value('amc_name'); ?>">
						    <?php echo form_error('amc_name','<span class="text-danger">','</span>'); ?>
                         </div>  
						  <div class="form-group col-md-6">
                           <label for="amc_sit">Service Interval Time </label><?php echo REQUIRED_STAR; ?>
                           <input class="form-control" id="amc_sit" name="amc_sit" type="text" placeholder="Enter Service Interval Time in Days"  required maxlength="4" value="<?php echo isset($details['amc_sit'])?$details['amc_sit']:set_value('amc_sit'); ?>" >
						    <?php echo form_error('amc_sit','<span class="text-danger">','</span>'); ?>
                         </div> 
						 <div class="form-group col-md-6">
                           <label for="amc_desc">AMC Description </label>
						   
                           <input class="form-control" id="amc_desc" name="amc_desc" type="text" placeholder="Enter AMC Description" maxlength="1000" value="<?php echo isset($details['amc_desc'])?$details['amc_desc']:set_value('amc_desc'); ?>">
						    <?php echo form_error('amc_desc','<span class="text-danger">','</span>'); ?>
                         </div> 
						
						  
						
						  <div class="form-group col-md-6">
                           <label for="amc_gst">GST % </label>
                           <input class="form-control" id="amc_gst" name="amc_gst" type="text" placeholder="Enter GST %"  maxlength="4" value="<?php echo isset($details['amc_gst'])?$details['amc_gst']:set_value('amc_gst'); ?>">
						    <?php echo form_error('amc_gst','<span class="text-danger">','</span>'); ?>
                         </div>   
						
						 <div class="form-group col-md-6">
                           <label for="amc_price">Price(Regular) </label>
                           <input class="form-control" id="amc_price" name="amc_price" type="text" placeholder="Enter Price(Regular)"  maxlength="10" value="<?php echo isset($details['amc_price'])?$details['amc_price']:set_value('amc_price'); ?>">
						    <?php echo form_error('amc_price','<span class="text-danger">','</span>'); ?>
                         </div> 
						 <div class="form-group col-md-6">
                           <label for="amc_corporate_price">Price(Commercial) </label>
                           <input class="form-control" id="amc_corporate_price" name="amc_corporate_price" type="text" placeholder="Enter Price(Commercial)"  maxlength="10" value="<?php echo isset($details['amc_corporate_price'])?$details['amc_corporate_price']:set_value('amc_corporate_price'); ?>">
						    <?php echo form_error('amc_corporate_price','<span class="text-danger">','</span>'); ?>
                         </div> 	  
						  </div>
						   <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" type="submit" >Submit</button>
                          <a href="<?php echo base_url();?>masters/amc_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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
            amc_name: {
                required: true,
				maxlength: 100,
                minlength: 2,
				 }, 
			amc_duration: {
                 required: true,
				 maxlength: 4,
				 digits:true,
				 }, 
			amc_desc: {
				maxlength: 1000,
				 },
			amc_noofservices: {
				required: true,
				maxlength: 3,
				digits:true,
				 },
			amc_sit: {
				required: true,
				maxlength: 4,
				digits:true,
				 },
			ots_gst: {
				maxlength: 4,
                number:true,
				 },
			amc_price: {
				maxlength: 10,
                number:true,
				 }, 	
		    amc_corporate_price: {
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
	function get_sit(){
		var duration = $("#amc_duration").val();
		var services = $("#amc_noofservices").val();
		if(!services){ services=1;} 
		if(!duration){ duration=1;} 
		var sit = parseInt(duration)/parseInt(services);
		sit = Math.ceil(sit);
		$("#amc_sit").val(sit);
	}
</script>