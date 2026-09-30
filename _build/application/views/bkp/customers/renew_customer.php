<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
	<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
	<li><a href="<?php echo base_url("dashboard")?>">Home</a><i class="fa fa-circle"></i></li>

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
				  <?php if($action=="Renew"){ 
				  //  echo "<pre/>"; print_r($details);die; 
				    $details   = html_escape($details);
					$cust_type =  isset($details['cust_type'])?$details['cust_type']:"";
					$cust_subs_type =  isset($subscriptionList[0]['cust_subs_type'])?$subscriptionList[0]['cust_subs_type']:"";
					$formaction = "renew_customer_service/?id=".base64_encode($id);
					}
					
					if($action=="Add"){ 
				  //  echo "<pre/>"; print_r($details);die; 
				    $details   = html_escape($details);
					$cust_type =  isset($details['cust_type'])?$details['cust_type']:"";
					$formaction = "add_customer_service/?id=".base64_encode($id);
					}
					
					?>
					
                     <form action="<?php echo base_url().'customers/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off">
					  <div class="form-body">
					  
					   <div class="col-md-12"> 
					  
					    <div class="portlet-body">
						  <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">Basic Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
						   
                           <input type="hidden" name="cust_id" value="<?php echo $id; ?>">
                           <input type="hidden" name="cust_type" id="cust_type" value="<?php echo $cust_type; ?>">		   
					 <?php if($action=="Renew"){  ?>
						 <div class="form-group col-md-3">
                           <label for="cust_service_type">Service Type</label><?php echo REQUIRED_STAR; ?>
                           <select class="form-control" id="cust_service_type" name="cust_service_type" required onchange="get_services(this);">
							<option value=""> Select Service Type</option>
							 <?php  if(!empty($service_list )){ 	 						
								foreach($service_list as $key=>$service){
                                    $selected  = $service == $cust_subs_type?"selected":"";
									?>
									<option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $service; ?></option>
							<?php } } ?>	
						   </select>
						    <?php echo form_error('cust_service_type','<span class="text-danger">','</span>'); ?>
                        </div> 
					 <?php } ?>
					 
					  <?php if($action=="Add"){  ?>
						 <div class="form-group col-md-3">
                           <label for="cust_service_type">Service Type</label><?php echo REQUIRED_STAR; ?>
                           <select class="form-control" id="cust_service_type" name="cust_service_type" required onchange="get_services(this);" >
							<option value=""> Select Service Type</option>
							 <?php  if(!empty($service_list )){ 	 						
								foreach($service_list as $key=>$service){                                 
									?>
									<option value="<?php echo $key;?>" ><?php echo $service; ?></option>
							<?php } } ?>	
						   </select>
						    <?php echo form_error('cust_service_type','<span class="text-danger">','</span>'); ?>
                        </div> 
						 <?php } ?>
						
						<div class="form-group col-md-3">
                           <label for="cust_gst_type">GST Option</label><?php echo REQUIRED_STAR; ?>
                           <select class="form-control" id="cust_gst_type" name="cust_gst_type" required onchange="clear_service_details();" >
							 <?php  if(!empty($gst_type_list )){ 	 						
								foreach($gst_type_list as $key=>$gtype){
                                    $cust_gst_type =  isset($details['clm_priority_level'])?$details['clm_priority_level']:set_value("cust_gst_type");
									$selected  = $gtype == $cust_gst_type?"selected":"";
									?>
									<option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $gtype; ?></option>
							<?php } } ?>	
						   </select>
						    <?php echo form_error('cust_gst_type','<span class="text-danger">','</span>'); ?>
                        </div> 
                        </div>
                      <div class="col-md-12">
					     <div class="portlet-title">
					            <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-call-out"></i>
								  <span class="caption-subject font-red-mint sbold">Contact Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>
					 		<div class="form-group col-md-4">
                           <label for="cust_name">Customer Name</label> <?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="cust_name" name="cust_name" type="text" placeholder="Enter Customer Name" required maxlength="100" value="<?php echo isset($details['customer_name'])?$details['customer_name']:set_value("cust_name"); ?>" readonly>
						    <?php echo form_error('cust_name','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-4">
                           <label for="cust_contact_person">Contact Person</label>
						   <input class="form-control" id="cust_contact_person" name="cust_contact_person" type="text" placeholder="Enter Contact Person" maxlength="100" value="<?php echo isset($details['customer_contact_person'])?$details['customer_contact_person']:set_value("cust_contact_person"); ?>" readonly>
						    <?php echo form_error('cust_contact_person','<span class="text-danger">','</span>'); ?>
                        </div>
						
						<div class="form-group col-md-4">
                           <label for="cust_contact">Mobile No.</label>
						   <input class="form-control" id="cust_contact" name="cust_contact" type="text" placeholder="Enter Mobile No." maxlength="10" value="<?php echo isset($details['customer_contact'])?$details['customer_contact']:set_value("cust_contact"); ?>" readonly>
						    <?php echo form_error('cust_contact','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-4">
                           <label for="cust_landline">Landline No.</label>
						   <input class="form-control" id="cust_landline" name="cust_landline" type="text" placeholder="Enter Landline No." maxlength="15" value="<?php echo isset($details['cust_landline'])?$details['cust_landline']:set_value("cust_landline"); ?>" readonly>
						    <?php echo form_error('cust_landline','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-4">
                           <label for="cust_contact_email">Email Id</label>
						   <input class="form-control" id="cust_contact_email" name="cust_contact_email" type="text" placeholder="Enter Email Id." maxlength="100" value="<?php echo isset($details['customer_contact_email'])?$details['customer_contact_email']:set_value("cust_contact_email"); ?>" readonly>
						    <?php echo form_error('cust_contact_email','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-4">
                           <label for="cust_website">Website</label>
						   <input class="form-control" id="cust_website" name="cust_website" type="text" placeholder="Enter Website" maxlength="100" value="<?php echo isset($details['cust_website'])?$details['cust_website']:set_value("cust_website"); ?>" readonly>
						    <?php echo form_error('cust_website','<span class="text-danger">','</span>'); ?>
                        </div>
						
					
                        </div>
					  
						 
						
						 <div class="col-md-12">
						  <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-pointer"></i>
								  <span class="caption-subject font-red-mint sbold">Service Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
						   <div class="form-group col-md-12">
                           <label for="cust_service_det">Service Details</label> <?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="cust_service_det" name="cust_service_det" type="text" placeholder="Enter Service Details" required maxlength="500" value="<?php echo isset($details['cust_service_det'])?$details['cust_service_det']:set_value("cust_service_det"); ?>">
						    <?php echo form_error('cust_service_det','<span class="text-danger">','</span>'); ?>
                           </div> 
						  
						   <div class="form-group col-md-12">
                           <label for="cust_services_lbl" id="cust_services_lbl">Services</label> 
						    <span id="file_err"></span>
						   <div class="slimScrollDiv150" style="border:1px solid #cdcdcd;">
						  <table class="table table-striped table-bordered table-advance table-hover">
						   <tbody id="tbl_service_id">
						    <?php if($action=="Renew"){ 
							      if(!empty($subscriptionList)){ 
							      foreach($subscriptionList as $subs){
									$subs_type = $subs['cust_subs_type'];
									 $onlclick = "";
								if($subs_type == "AMC") {$onlclick = "get_amc_details(this);";}									
								if($subs_type == "One Time Service") {$onlclick = "get_ots_details(this);";}									
								if($subs_type == "Sales") {$onlclick = "get_product_details(this);";}									
                                  									  
							       $html = "<td><lable><input type='checkbox' name='service_id[]'  value='".$subs['cust_subs_type_id']."' onchange='".$onlclick."' /> &nbsp;".$subs['cust_subs_type_name']."</label></td>"; 
								   echo $html;
								   ?>
								   
							<?php } } }   ?>
						     
						   </tbody>
						   </table>
						  
                           </div> 
                           </div> 
						
						   <div class="form-group col-md-12 shadow">
                           <label for="cust_service_details_lbl" id="cust_service_details_lbl">Service Details</label> 
						   
						   <div class="slimScrollDiv250" style="border:1px solid #cdcdcd;">
						  <table class="table table-striped table-bordered table-advance table-hover">
						  <thead id="services_tbl_header"> </thead>
						   <tbody id="tbl_service_details">
						   
							
						   </tbody>
						   </table>
                           </div>
                           </div>
						   
						   
						 
						    <div class="form-group col-md-3">
                           <label for="cust_total_amount">Total Price</label>
                           <input class="form-control" id="cust_total_amount" name="cust_total_amount" type="text" placeholder="Total Price" maxlength='8' value="0" readonly>
						    <?php echo form_error('cust_total_amount','<span class="text-danger">','</span>'); ?>
                           </div> 
						   <div class="form-group col-md-3">
                           <label for="cust_paid_amount">Paid Amount</label>
                           <input class="form-control" id="cust_paid_amount" name="cust_paid_amount" type="text" placeholder="Total Price" maxlength='8' value="0" readonly>
						    <?php echo form_error('cust_paid_amount','<span class="text-danger">','</span>'); ?>
                           </div>
						   
						   <div class="form-group col-md-3">
                           <label for="cust_unit_no">Unit No</label>
                           <input class="form-control" id="cust_unit_no" name="cust_unit_no" type="text" placeholder="Enter Reference Name"  maxlength="50" value="<?php echo isset($details['cust_unit_no'])?$details['cust_unit_no']:set_value("cust_unit_no"); ?>">
						    <?php echo form_error('cust_unit_no','<span class="text-danger">','</span>'); ?>
                           </div> 
						   <div class="form-group col-md-3">
                           <label for="cust_form_no">Form No</label>
                           <input class="form-control" id="cust_form_no" name="cust_form_no" type="text" placeholder="Enter Reference Name"  maxlength="50" value="<?php echo isset($details['cust_form_no'])?$details['cust_form_no']:set_value("cust_form_no"); ?>">
						    <?php echo form_error('cust_form_no','<span class="text-danger">','</span>'); ?>
                           </div>  
						 
						   </div>
					
						  				
						 
						   <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" type="submit"  id="add_edit_form_btn" >Submit</button>
                          <a href="<?php echo base_url();?>customers/customer_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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
	
	
	 $('.smart-file').bootstrapFileField({
            maxNumFiles: 8,
            fileTypes: 'image/jpeg,image/png,image/jpg',  
		/* 	minNumFiles:1, */
            maxFileSize: 4000000 // 8Mb in bytes */
        });
	
	 $('.datepicker').datepicker({
				format: 'dd-M-yyyy',
				autoclose: true,
				todayHighlight: true,

		});	
	
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
             cust_service_type: {
                required: true,
			 }, 
			 cust_gst_type: {
                required: true,
			 },  
			 cust_type: {
                required: true,
			 },
          cust_service_det: {
            	maxlength: 500,
                minlength: 2,
				 }, 	
		  cust_total_amount: {
            	maxlength: 8,
				number:true,
				 },
		 cust_paid_amount: {
            	maxlength: 8,
				number:true,
				 },
		 cust_unit_no: {
            	maxlength: 50,
				 }, 
		  cust_form_no: {
            	maxlength: 50,
				 }, 
		    "service_id[]": {
				required:true,
  				 },  
		   	},
		messages: {
           "service_id[]": { required: 'Please Select At least one Service' },
            
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
	
	
	
function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
}

	function get_payment_details(obj) {
		
		var payment_type   = $(obj).val();	
		/* $("#bank_details").addClass("hidden"); */
		$("#online_details").addClass("hidden");
		$("#dd_details").addClass("hidden");
		$("#cheque_details").addClass("hidden");
		
		/* if(payment_type=="Card"){
			$("#bank_details").removeClass("hidden");
		} */
		if(payment_type=="Online"){
			$("#online_details").removeClass("hidden");
		}
		if(payment_type=="DD"){
			$("#dd_details").removeClass("hidden");
		}
		if(payment_type=="Cheque"){
			$("#cheque_details").removeClass("hidden");
		}
	}

function get_services(obj) {
	
	    $("#tbl_service_details").html("");
        var service_type   = $(obj).val();	
		var service_lbl,service_detal_lbl;
		if(service_type=="AMC")
		{
			service_lbl = "AMC Services";
			service_detal_lbl = "AMC Details";
			$("#services_tbl_header").html("<tr class='success'><th width='5%'>Sr.No.</th><th>AMC</th><th>Address</th><th>Service Date</th></tr>");
			
		}
		if(service_type=="One Time Service")
		{
			service_lbl = "One Time Services";
			service_detal_lbl = "One Time Service Details";
			$("#services_tbl_header").html("<tr class='success'><th width='5%'>Sr.No.</th><th>One Time Service</th><th>Address</th></tr>");
		}
		if(service_type=="Sales")
		{
			service_lbl = "Sales Products";
			service_detal_lbl = "Sales Product Details";
			$("#services_tbl_header").html("<tr class='success'><th width='5%'>Sr.No.</th><th>Sales Product</th><th>Address</th><th>Service Date</th></tr>");
		}
		$("#cust_service_details_lbl").text(service_detal_lbl);
		$("#cust_services_lbl").text(service_lbl);
			
		$("#tbl_service_id").html("");		
		$.ajax({
			url:base_url+"ajax/get_service_list",
			type: "POST",
			datatype: "json",
			data: {"service_type":service_type},
			async: true,
			cache: false,
			success: function(data)
			{		
				var html_data = JSON.parse(data);	
                 $("#tbl_service_id").html(html_data);

			}
		});
}

	function get_amc_details(obj) {
		var amc_id   = $(obj).val();	
		var gst_type = $("#cust_gst_type").val();
		var cust_type = $("#cust_type").val();
		if ($(obj).is(':checked')) {
		 $.ajax({
			url:base_url+"ajax/get_amc_details",
			type: "POST",
			datatype: "json",
			data: {"cust_gst_type":gst_type,"amc_id":amc_id,"cust_type":cust_type},
			async: true,
			cache: false,
			success: function(data)
			{		
				   var html_data = JSON.parse(data);	
                   $("#tbl_service_details").append(html_data);
                   get_total();
				   get_srno();
				   $('.datepicker').datepicker({
				         format: 'dd-M-yyyy',
				         autoclose: true,
				         todayHighlight: true,

		           });
				   
			}
		});
			
		} else 
		{
			$('#table_row_id_'+amc_id).remove();
			get_total();
			get_srno();
		}			
	}
	
	function get_ots_details(obj) {
		var ots_id    = $(obj).val();	
		var gst_type  = $("#cust_gst_type").val();
		var cust_type = $("#cust_type").val();
		
		if ($(obj).is(':checked')) {
		 $.ajax({
			url:base_url+"ajax/get_ots_details",
			type: "POST",
			datatype: "json",
			data: {"cust_gst_type":gst_type,"ots_id":ots_id,"cust_type":cust_type},
			async: true,
			cache: false,
			success: function(data)
			{		
				   var html_data = JSON.parse(data);	
                   $("#tbl_service_details").append(html_data);
                   get_total();
				   get_srno();
				 
				   
			}
		});
			
		} else 
		{
			$('#table_row_id_'+ots_id).remove();
			get_total();
			get_srno();
		}			
	}
	function get_product_details(obj) {
		var pm_id     = $(obj).val();	
		var gst_type  = $("#cust_gst_type").val();
		var cust_type = $("#cust_type").val();
		
		if ($(obj).is(':checked')) {
		 $.ajax({
			url:base_url+"ajax/get_product_details",
			type: "POST",
			datatype: "json",
			data: {"cust_gst_type":gst_type,"pm_id":pm_id,"cust_type":cust_type},
			async: true,
			cache: false,
			success: function(data)
			{		
				   var html_data = JSON.parse(data);	
                   $("#tbl_service_details").append(html_data);
                   get_total();
				   get_srno();
				 
				   
			}
		});
			
		} else 
		{
			$('#table_row_id_'+pm_id).remove();
			get_total();
			get_srno();
		}			
	}
	
	function delete_row(obj)
	{
		var id = $(obj).attr("data-id");
		$('#row_id_'+id).remove();
		
	}	
	
	function add_row(obj)
	{
		var id = $(obj).attr("data-id");
		var data_id = getRandomInt(5);
		var html = '<tr id="row_id_'+data_id+'" data-id="'+data_id+'" ><td><input type="text" name="cust_service_dates_'+id+'[]" placeholder="Service Date" class="form-control datepicker" maxlength="100" value=""> </td><td><a href="javascript:;" onclick="delete_row(this);" data-id="'+data_id+'" class="btn btn-danger btn-xs"><i class="fa fa-close"></i></a></td></tr>';
		$("#table_"+id).append(html);
		$('.datepicker').datepicker({
				         format: 'dd-M-yyyy',
				         autoclose: true,
				         todayHighlight: true,

		           });	
	}	
	function getRandomInt(max) {
      return Math.floor(Math.random() * Math.floor(max));
    }
	
	function calculate_total(obj) {
		var id       = $(obj).attr("data-id");
		var gst_type = $("#cust_gst_type").val();
        var cust_pdt_qty           = parseFloat($("#cust_pdt_qty_"+id).val());		
        var cust_pdt_price         = parseFloat($("#cust_pdt_price_"+id).val());
		
		if(isNaN(cust_pdt_qty))   { cust_pdt_qty = 0;} 
		if(isNaN(cust_pdt_price)) { cust_pdt_price = 0;} 
		
	
		var total = cust_pdt_price*cust_pdt_qty;
			total = Math.round(parseFloat((total * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);

			var cust_pdt_gst_price     = parseFloat($("#cust_pdt_gst_price_"+id).val());		
            var cust_pdt_gst           = parseFloat($("#cust_pdt_gst_"+id).val());	
			
			if(isNaN(total))         { total = 0;} 	
			if(isNaN(cust_pdt_gst))  { cust_pdt_gst = 0;} 	
			if(isNaN(cust_pdt_gst_price)) { cust_pdt_gst_price = 0;} 
			
		 var gst = (total * cust_pdt_gst)/100;		
		 gst = Math.round(parseFloat((gst * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);
         cust_pdt_gst_price	 = gst + total;	 
		 $("#cust_pdt_gst_price_"+id).val(cust_pdt_gst_price);
		
		get_total();

       	
    }
function get_total()
{
	
	 var total_gst_price = 0;
	 $("#tbl_service_details").find(".form-control").each(function( j ) {
	 if( $(this).attr("name") == "cust_pdt_gst_price[]"){
			var gst_price = parseFloat($(this).val());
			if(isNaN(gst_price))   { gst_price = 0;} 
			total_gst_price = total_gst_price + gst_price;
			
		} 
   });	
   total_gst_price = Math.round(parseFloat((total_gst_price * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2); 
   $("#cust_total_amount").val(total_gst_price);	
	
}

function get_srno()
{
	var Srno = 1;
    $("#tbl_service_details").find(".sr_no").each(function( j ) {
	   $(this).html(Srno);
	   Srno++
   });
}

function clear_service_details(){
	 $("#tbl_service_details").html("");
	 $('#tbl_service_id').find('input[type=checkbox]:checked').removeAttr('checked');
}

</script>