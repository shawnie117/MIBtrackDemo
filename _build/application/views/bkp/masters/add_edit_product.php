<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	  <div class="col-md-10">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url("dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url("masters/sale_product_report")?>">All Product Report </a><i class="fa fa-circle"></i></li>
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
					$formaction = "edit_sale_product/?id=".base64_encode($id);
					}else {  $formaction = "add_sale_product"; } ?>
                     <form action="<?php echo base_url().'masters/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					 <center> 
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
			   </center>
					
					<?php if($action=="Edit"){?>
                           <input type="hidden" name="id" value="<?php echo $id; ?>">
						   <?php } ?>
							  
					   <div class="form-group col-md-6">
                           <label for="pdt_name">Product Name </label><?php echo REQUIRED_STAR; ?>
						   
                           <input class="form-control" id="pdt_name" name="pdt_name" type="text" placeholder="Enter Product Name" required maxlength="250" value="<?php echo isset($details['pm_name'])?$details['pm_name']:set_value('pdt_name'); ?>">
						    <?php echo form_error('pdt_name','<span class="text-danger">','</span>'); ?>
                         </div>
                       <div class="form-group col-md-6">						 
						   <div class="form-group col-md-10">
                           <label for="p_brand_id">Select Brand </label><?php echo REQUIRED_STAR; ?>
						   <select class="form-control" id="p_brand_id" name="p_brand_id" >
							<option value=""> Select Brand</option>
							 <?php  if(!empty($brand_list )){ 	 						
								foreach($brand_list as $brand){ 
                                    $brand_id =  isset($details['pdt_brnd_id'])?$details['pdt_brnd_id']:set_value("p_brand_id");
									$selected  = $brand_id == $brand['pdt_brnd_id']?"selected":"";
									?>
									<option value="<?php echo $brand['pdt_brnd_id'];?>" <?php echo $selected;?>><?php echo $brand['pdt_brnd_name']; ?></option>
							<?php } } ?>	
						   </select>						
						   
						    <?php echo form_error('p_brand_id','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-2"> <br/> <a  data-toggle="modal" data-target="#form_modal" class="btn btn-success " href="<?php echo base_url();?>masters/add_brand/?url=<?php  echo $formaction;?>" title="Add Brand" ><i class="fa fa-plus"></i></a></div>
						</div>
						
						<div class="form-group col-md-6">
                           <label for="p_model_name">Model </label>   
                           <input class="form-control" id="p_model_name" name="p_model_name" type="text" placeholder="Enter Model"  maxlength="250" value="<?php echo isset($details['pm_model_name'])?$details['pm_model_name']:set_value('p_model_name'); ?>" onchange="get_sit();">
						    <?php echo form_error('p_model_name','<span class="text-danger">','</span>'); ?>
                         </div> 
						 <div class="form-group col-md-6">
                           <label for="pdt_desc">Details </label>
						   
                           <input class="form-control" id="pdt_desc" name="pdt_desc" type="text" placeholder="Enter Details" maxlength="500" value="<?php echo isset($details['pm_desc'])?$details['pm_desc']:set_value('pdt_desc'); ?>">
						    <?php echo form_error('pdt_desc','<span class="text-danger">','</span>'); ?>
                         </div> 
						  <div class="form-group col-md-6">
                           <label for="pdt_regular_price">Price(Regular) </label>
                           <input class="form-control" id="pdt_regular_price" name="pdt_regular_price" type="text" placeholder="Enter Price(Regular)"  maxlength="10" value="<?php echo isset($details['pm_regular_price'])?$details['pm_regular_price']:set_value('pdt_regular_price'); ?>">
						    <?php echo form_error('pdt_regular_price','<span class="text-danger">','</span>'); ?>
                         </div> 
						  <div class="form-group col-md-6">
                           <label for="pdt_comm_price">Price(Commercial) </label>
                           <input class="form-control" id="pdt_comm_price" name="pdt_comm_price" type="text" placeholder="Enter Price(Commercial)"  maxlength="10" value="<?php echo isset($details['pm_commercial_price'])?$details['pm_commercial_price']:set_value('pdt_comm_price'); ?>">
						    <?php echo form_error('pdt_comm_price','<span class="text-danger">','</span>'); ?>
                         </div> 	  
						   <div class="form-group col-md-6">
                           <label for="pdt_gst">GST % </label>
                           <input class="form-control" id="pdt_gst" name="pdt_gst" type="text" placeholder="Enter GST %"  maxlength="4" value="<?php echo isset($details['pm_gst'])?$details['pm_gst']:set_value('pdt_gst'); ?>">
						    <?php echo form_error('pdt_gst','<span class="text-danger">','</span>'); ?>
                         </div>    
						 <div class="form-group col-md-6">
                           <label for="pdt_hsn_code">HSN Code</label>
                           <input class="form-control" id="pdt_hsn_code" name="pdt_hsn_code" type="text" placeholder="Enter HSN Code"  maxlength="100" value="<?php echo isset($details['pm_hsn_code'])?$details['pm_hsn_code']:set_value('pdt_hsn_code'); ?>">
						    <?php echo form_error('pdt_hsn_code','<span class="text-danger">','</span>'); ?>
                         </div>   
						 
						 <div class="form-group col-md-6">
                           <label for="pdt_warranty_period">Warranty Period(In Days) </label><?php echo REQUIRED_STAR; ?>
							<input class="form-control" required maxlength="4" id="pdt_warranty_period"  name="pdt_warranty_period" list="all_duration" placeholder="Select Warranty Period(In Days)" autocomplete="off" value="<?php echo isset($details['pm_warranty_period'])?$details['pm_warranty_period']:set_value('pdt_warranty_period'); ?>" onchange="get_sit();"/>
							 
							 <datalist id="all_duration">
							  <?php  if(!empty($duration_list )){ 	 						
								foreach($duration_list as $key=>$duration){ ?>
									<option value="<?php echo $key;?>" label="<?php echo $duration; ?>" ></option>
							<?php } } ?>	
						     </datalist>
						    <?php echo form_error('amc_duration','<span class="text-danger">','</span>'); ?>
                         </div>
						   <div class="form-group col-md-6">
                           <label for="p_noofservices">No. Of Free Services </label><?php echo REQUIRED_STAR; ?>
						   
                           <input class="form-control" id="p_noofservices" name="p_noofservices" type="text" placeholder="Enter No. Of Free Services" required maxlength="3" value="<?php echo isset($details['pm_noofserv'])?$details['pm_noofserv']:set_value('p_noofservices'); ?>" onchange="get_sit();">
						    <?php echo form_error('p_noofservices','<span class="text-danger">','</span>'); ?>
                         </div> 
                        <div class="form-group col-md-6">
                           <label for="p_sit">Service Interval Time </label><?php echo REQUIRED_STAR; ?>
                           <input class="form-control" id="p_sit" name="p_sit" type="text" placeholder="Enter Service Interval Time in Days"  required maxlength="4" value="<?php echo isset($details['pm_sit'])?$details['pm_sit']:set_value('p_sit'); ?>" >
						    <?php echo form_error('p_sit','<span class="text-danger">','</span>'); ?>
                         </div>
						  </div>
						   <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" type="submit" >Submit</button>
                          <a href="<?php echo base_url();?>masters/sale_product_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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
   
    <!-- START MODAL -->
		<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true" >
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
$("#form_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    }); 
	
	
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
            pdt_name: {
                required: true,
				maxlength: 250,
                minlength: 2,
				 },    
			p_model_name: {
               	maxlength: 250,
                minlength: 2,
				 },  
			p_brand_id: {
                required: true,
			 }, 
			pdt_desc: {
				maxlength: 500,
				 }, 
			pdt_regular_price: {
				maxlength: 10,
                number:true,
				 }, 		 
			pdt_comm_price: {
				maxlength: 10,
                number:true,
				 }, 
			pdt_gst: {
				maxlength: 4,
                number:true,
				 },	 
			pdt_hsn_code: {
				maxlength: 100,
                },	 
				 
			pdt_warranty_period: {
                 required: true,
				 maxlength: 4,
				 digits:true,
				 }, 
			
			p_noofservices: {
				required: true,
				maxlength: 3,
				digits:true,
				 },
			p_sit: {
				required: true,
				maxlength: 4,
				digits:true,
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
		var duration = $("#pdt_warranty_period").val();
		var services = $("#p_noofservices").val();
		if(!services){ services=1;} 
		if(!duration){ duration=1;} 
		var sit = parseInt(duration)/parseInt(services);
		sit = Math.ceil(sit);
		$("#p_sit").val(sit);
	}
</script>