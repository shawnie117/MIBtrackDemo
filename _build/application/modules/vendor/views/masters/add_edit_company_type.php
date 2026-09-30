<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url(get_module()."/masters/company_type_report")?>">All Company Type Report </a><i class="fa fa-circle"></i></li>
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
					$formaction = "edit_company_type/?id=".base64_encode($id);
					}else {  $formaction = "add_company_type"; } ?>
                     <form action="<?php echo get_module_path().'masters/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					<?php if($action=="Edit"){?>
                           <input type="hidden" name="id" value="<?php echo $id; ?>">
						   <?php } ?>
						 <div class="form-group col-md-3">
                           <label for="cust_service_type">Service Type</label><?php echo REQUIRED_STAR; ?>
                           <select class="form-control" id="cust_service_type" name="cust_service_type" required onchange="get_services(this);" >
							<option value=""> Select Service Type</option>
							 <?php  if(!empty($service_list )){ 	 						
								foreach($service_list as $key=>$service){
                                    $service_type =  isset($details['ctm_type'])?$details['ctm_type']:set_value("cust_service_type");
									$selected  = $service == $service_type?"selected":"";
									?>
									<option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $service; ?></option>
							<?php } } ?>	
						   </select>
						    <?php echo form_error('cust_service_type','<span class="text-danger">','</span>'); ?>
                        </div>  
						<div class="form-group col-md-3">
                           <label for="cust_services_lbl" id="cust_services_lbl">Select Service</label><?php echo REQUIRED_STAR; ?>
                           <select class="form-control" id="service_id" name="service_id" required onchange="get_service_amount(this);">
							<option value="">Select Service</option>
							<?php if($action=="Edit"){
								echo $service_id_html;
							} ?>
						   </select>
						    <?php echo form_error('service_id','<span class="text-danger">','</span>'); ?>
                        </div>
                        <div class="form-group col-md-3">
                           <label for="total_amount">Total Amount </label><?php echo REQUIRED_STAR; ?>  
                           <input type="text" name="total_amount"  class="form-control" id="total_amount" value="<?php echo isset($details['ctm_total_amt'])?$details['ctm_total_amt']:set_value('ctm_total_amt'); ?>"  maxlength="8" readonly>		
						    <?php echo form_error('total_amount','<span class="text-danger">','</span>'); ?>
                         </div>   				
                        <div class="form-group col-md-3">
                           <label for="name">Company Type </label><?php echo REQUIRED_STAR; ?>
						   
                           <input class="form-control" id="name" name="name" type="text" placeholder="Enter Company Type" required maxlength="100" value="<?php echo isset($details['ctm_name'])?$details['ctm_name']:set_value('name'); ?>">
						    <?php echo form_error('name','<span class="text-danger">','</span>'); ?>
                         </div>  
						 
						 <div class="form-group col-md-12">
                           <label for="name">Description </label><?php echo REQUIRED_STAR; ?>
						   
                           <input class="form-control" id="desc" name="desc" type="text" placeholder="Enter Description " required maxlength="500" value="<?php echo isset($details['ctm_desc'])?$details['ctm_desc']:set_value('desc'); ?>">
						    <?php echo form_error('desc','<span class="text-danger">','</span>'); ?>
                         </div> 
						 
						  </div>
						   <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" id="mybutton" type="submit" >Submit</button>
                          <a href="<?php echo get_module_path();?>masters/company_type_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                        </div>
                        </div>
						</form>
				
                        <!-- /.box-body -->
						<script>
						const button = document.getElementById('mybutton');

button.addEventListener('click', function() {
    // Clicked button becomes disabled after 1 second
    setTimeout(() => {
        button.disabled = true;
        
        // Re-enable the button after an additional 2 seconds (total of 3 seconds from click)
        setTimeout(() => {
            button.disabled = false;
        }, 1000);
    });
});
</script>
                     
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
	
	 $('.smart-file').bootstrapFileField({
            maxNumFiles: 8,
            fileTypes: 'image/jpeg,image/png,image/jpg',  
            maxFileSize: 4000000 // 8Mb in bytes */
        });
		
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
			cust_service_type: {
                required: true,
			},
			service_id: {
                required: true,
			},
			total_amount: {
                required: true,
				maxlength: 8,
				number:true,
			},
            name: {
                required: true,
				maxlength: 100,
                minlength: 2,
				 },  
		    desc: {
                required: true,
				maxlength: 500,
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
			}else { // This is the default behavior of the script for all fields
			error.insertAfter(element);
			}
			
		},
		success: function(error) { 
        error.removeClass("error");  // <- no, no, no!!
		},
    });
    });
function get_services(obj) {
	
        var service_type   = $(obj).val();	
		var service_lbl;
		if(service_type=="AMC")
		{
			service_lbl = "AMC Services";
			
		}
		if(service_type=="One Time Service")
		{
			service_lbl = "One Time Services";
			
		}
		if(service_type=="Sales")
		{
			service_lbl = "Sales Products";
			
		}
		$("#cust_services_lbl").text(service_lbl);
			
		$("#service_id").html("");	
		$(".loader").fadeIn();		
		$.ajax({
			url:base_url+"ajax/get_service_list_selectbox",
			type: "POST",
			datatype: "json",
			data: {"service_type":service_type},
			async: true,
			cache: false,
			success: function(data)
			{		
				var html_data = JSON.parse(data);	
                 $("#service_id").html(html_data);
				 $(".loader").fadeOut();

			}
		});
}	
	
function get_service_amount(obj) {
	
	    var amount = $('option:selected', obj).attr('data-amount');;	
		$('#total_amount').val(amount);
}
</script>