<style>
body
{
    counter-reset: Serial;           /* Set the Serial counter to 0 */
}

table
{
    border-collapse: separate;
}
.table1 td:first-child:before
{
  counter-increment: Serial;      /* Increment the Serial counter */
  content: counter(Serial); /* Display the counter */
}

.no-bordered>tbody>tr>td, .no-bordered>tbody>tr>th, .no-bordered>tfoot>tr>td, .no-bordered>tfoot>tr>th, .no-bordered>thead>tr>td, .no-bordered>thead>tr>th {
    padding: 3px;
    border:none;
}
</style>
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
	<li><a href="<?php echo base_url("reports/quotation_report")?>">All Quotation Report </a><i class="fa fa-circle"></i></li>
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
				  <?php if($action=="Add"){ 
				    $formaction = "add_quotation";
				    }
					if($action=="Edit"){ 
				    $formaction = "edit_quotation/?id=".base64_encode($id);
					
					//echo "<pre/>"; print_r($details);die;
					$id = isset($details['quote_id'])?$details['quote_id']:"";
					$quote_date_n = isset($details['quote_date_n'])?$details['quote_date_n']:"";
		
					$clm_id = isset($details['clm_id'])?$details['clm_id']:"";
					$clm_name = isset($details['clm_name'])?$details['clm_name']:"";
					$customer_name = isset($details['customer_name'])?$details['customer_name']:"";
					$clm_contact = isset($details['clm_contact'])?$details['clm_contact']:"";
					$customer_contact = isset($details['customer_contact'])?$details['customer_contact']:"";
					$clm_adress = isset($details['clm_adress'])?$details['clm_adress']:"";
					$customer_address = isset($details['customer_address'])?$details['customer_address']:"";
					
					$quoDetaillist = isset($details['quoDetaillist'])?$details['quoDetaillist']:"";
				
					
					$name    = !empty($clm_name)?$clm_name:$customer_name;
					$contact = !empty($clm_contact)?$clm_contact:$customer_contact;
					$adress  = !empty($clm_adress)?$clm_adress:$customer_address;
						
					$customer_id = isset($details['customer_id'])?$details['customer_id']:"";
					$cust_type = !empty($clm_id)?"Leads":"Customers";
					$ref_id    = !empty($clm_id)?$clm_id:$customer_id;
					$quoDetaillist = isset($details['quoDetaillist'])?$details['quoDetaillist']:"";
					 if(!empty($quoDetaillist)) { $quoDetaillist = $quoDetaillist[0] ; }
					 
					 $amc_id = isset($quoDetaillist['quoVersionlist'][0]['amc_id'])?$quoDetaillist['quoVersionlist'][0]['amc_id']:"";
					 $ots_id = isset($quoDetaillist['quoVersionlist'][0]['ots_id'])?$quoDetaillist['quoVersionlist'][0]['ots_id']:"";
					 $product_id = isset($quoDetaillist['quoVersionlist'][0]['product_id'])?$quoDetaillist['quoVersionlist'][0]['product_id']:"";
					 $prod_details = "";
					 if(!empty($amc_id)) { $prod_details = "AMC";}
					 if(!empty($ots_id)) { $prod_details = "One Time Service";}
					 if(!empty($product_id)) { $prod_details = "Sales";}
					}
					?>
					
                     <form action="<?php echo base_url().'reports/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" class="form-horizontal" role="form" >
					  <div class="form-body">
					    <?php //echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
						<div class="col-md-12"> 
						  <!--div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">Basic Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div-->					   
					  
					    <?php if($action=="Edit"){ ?>
                           <input type="hidden" name="id" value="<?php echo $id; ?>">
                           <input type="hidden" name="cust_type"  id="cust_type" value="<?php echo $cust_type; ?>">
                           <input type="hidden" name="ref_id"  id="ref_id" value="<?php echo $ref_id; ?>">
						   
						   <?php } ?>
						<?php if($action=="Edit"){ ?>
						 <div class="form-group col-md-8">
                           <label for="cust_type">Customer Type</label> <?php echo REQUIRED_STAR; ?>
                           <label> &nbsp;&nbsp;</label><label><input type="radio" name="cust_type1" value="Customers" <?php echo $cust_type=="Customers"?"checked":""; ?> disabled /> Customers</label>
                          <label><input type="radio" name="cust_type1" value="Leads"  <?php echo $cust_type=="Leads"?"checked":""; ?> disabled /> Leads</label>
                        </div> 
						 
						<?php } ?>
						
			             <?php if($action=="Add"){ ?>
						 <div class="form-group col-md-8">
                           <label for="cust_type"><b>Customer Type</b></label><?php echo REQUIRED_STAR; ?>
                          <label><input type="radio" name="cust_type" value="Customers" onclick="get_customers();" /> Customers</label>
                          <label><input type="radio" name="cust_type" value="Leads" onclick="get_leads();" /> Leads</label>
						  <span id="radio_err" class="text-danger"></span>
						    <?php echo form_error('cust_type','<span class="text-danger">','</span>'); ?>
                        </div> 						 
						
						  <div class="form-group col-md-8">
                           <label for="ref_id"> Lead/Customer</label><?php echo REQUIRED_STAR; ?>
                           <select class="form-control selectpicker" name="ref_id" id="ref_id" onchange="get_ref_details(this);" data-live-search="true">
						   </select>
						    <?php echo form_error('ref_id','<span class="text-danger">','</span>'); ?>
                        </div> 
						
						
						<?php } ?>
						
						<div class="form-group col-md-4">
                           <label for="p_quote_priorty">Priority</label><?php echo REQUIRED_STAR; ?>
                           <select class="form-control" id="p_quote_priorty" name="p_quote_priorty" maxlength="100" required >							 
							<option value=""> Select Priority</option>
							 <?php  if(!empty($priority_list)){ 
								foreach($priority_list as $priority){ 
								   $p_quote_priorty   = isset($quoDetaillist['quote_priorty'])?$quoDetaillist['quote_priorty']:"";
									     $selected = $p_quote_priorty==$priority?"selected":"";	
								?>
									<option value="<?php echo $priority;?>"   <?php echo $selected;?>><?php echo $priority; ?></option>
							<?php } } ?>	
						  
						   </select>
						    <?php echo form_error('p_quote_priorty','<span class="text-danger">','</span>'); ?>
                        </div> 
						
						 <div class="form-group col-md-12 shadow">
                           <label for="cust_service_details_lbl" id="cust_service_details_lbl"><b>Quotation Details</b></label> 
						   
						   <div style="border:1px solid #cdcdcd;">
						  <table class="table no-bordered">
						
						   
						   <tr><td colspan="5">&nbsp;</td>
						  <td class="pull-right"><input type="text" class="form-control datepicker" style="border-radius:0px;" placeholder="Date" name="p_quote_date" id="p_quote_date" value="<?php echo isset($details['quote_date_n'])?$details['quote_date_n']:""; ?>" /></td></tr>
						  <tr><td><b>To,</b></td><td colspan="5">&nbsp;</td></tr>		 
						 
						  <tr>
						  <td width="10%" style="text-align:right;"><b>Name :</b></td>
						  <td><input type="text" class="form-control" name="p_quote_name" id="p_quote_name" maxlength="100" placeholder="Name" value="<?php echo isset($name)?$name:""; ?>" required />
						  <?php echo form_error('p_quote_name','<span class="text-danger">','</span>'); ?>
						  </td>
						  <td colspan="5">&nbsp;</td></tr>
						  
						  <tr><td width="10%" style="text-align:right;"><b>Address  :</b></td>
						  <td><textarea class="form-control" name="p_quote_address" id="p_quote_address" maxlength="500" required placeholder="Address" style="resize:none;"><?php echo isset($adress)?$adress:""; ?></textarea>
						   <?php echo form_error('p_quote_address','<span class="text-danger">','</span>'); ?>
						  </td>
						  <td colspan="5">&nbsp;</td></tr>
						  
						  <input type="hidden" name="p_quote_landline" id="p_quote_landline" />
						  <input type="hidden" name="p_quote_email" id="p_quote_email" />
						  <input type="hidden" name="p_quote_contact_person" id="p_quote_contact_person" />
						  <input type="hidden" name="p_quote_dist_id" id="p_quote_dist_id" />
						  <input type="hidden" name="p_quote_state_id" id="p_quote_state_id" />
						  <input type="hidden" name="p_quote_pin_code" id="p_quote_pin_code" />
						   <tr><td  width="10%" style="text-align:right;"><b>Contact :</b></td>
						  <td><input type="text" class="form-control " name="p_quote_contact" id="p_quote_contact" maxlength="10" placeholder="Contact" value="<?php echo isset($contact)?$contact:""; ?>" required />
						   <?php echo form_error('p_quote_contact','<span class="text-danger">','</span>'); ?>
						  </td>
						  <td colspan="5">&nbsp;</td></tr>
						  <tr>						  
						  <td class="pull-right">&nbsp;</td>
						  <td class="pull-right"><b>Sub :</b></td>
						  <td colspan="5"><input type="text" class="form-control" placeholder="Subject" style="width:100%;" name="p_quote_subject" id="p_quote_subject" maxlength="100" value="<?php echo isset($quoDetaillist['quote_subject'])?$quoDetaillist['quote_subject']:""; ?>" />
						   <?php echo form_error('p_quote_subject','<span class="text-danger">','</span>'); ?>
						  </tr>
						    <tr><td width="10%"><b>Dear Sir,</b></td><td colspan="5">&nbsp;</td></tr>
						    <tr><td colspan="6">
							<textarea class="form-control"  placeholder="Description"  rows="5" style="width:100%;resize:none;" name="p_quote_desc" id="p_quote_desc" maxlength="1000"><?php echo isset($quoDetaillist['quote_desc'])?$quoDetaillist['quote_desc']:""; ?></textarea>
							  <?php echo form_error('p_quote_desc','<span class="text-danger">','</span>'); ?>
							</td></tr>
							 <tr><td width="20%"><b>Product Details</b><?php echo REQUIRED_STAR; ?></td><td colspan="5">&nbsp;</td></tr>
							 <tr><td width="20%">   <select class="form-control" id="cust_service_type" name="cust_service_type" required onchange="get_services(this);" >
							<option value=""> Select Product Type</option>
							 <?php  if(!empty($service_list )){ 	 						
								foreach($service_list as $key=>$service){
                                    $service_type =  isset($prod_details)?$prod_details:set_value("cust_service_type");
									$selected  = $service == $service_type?"selected":"";
									?>
									<option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $service; ?></option>
							<?php } } ?>	
						   </select>
						    <?php echo form_error('cust_service_type','<span class="text-danger">','</span>'); ?></td><td colspan="5">&nbsp;</td></tr>
						   </table>
						   <table class="table table-bordered table-striped table-condensed flip-content">
						  <tr class="success"><th width="20%">Package</th><th>Quantity</th><th>Price</th><th>Total</th><th>Description1</th><th>Description2</th><th></th><th></th></tr>
							<tbody id="tbl_service_details">
							<?php if($action == "Edit"){ 
							      if(!empty($quoDetaillist['quoVersionlist'])){ 
							      foreach($quoDetaillist['quoVersionlist'] as $key=>$ver){
                                   $product_price   = $ver['product_price'];
                                   $product_gst_amt = $ver['product_gst_amt'];
								   $gst_amount = $product_gst_amt-$product_price;
								   $gst = ($gst_amount/$product_price)*100;
                                   $amc_id = $ver['amc_id'];
                                   $ots_id = $ver['ots_id'];
                                   $product_id = $ver['product_id'];
								   $service_id = "";
								   
								   if(!empty($amc_id)){$service_id     = $amc_id;}
								   if(!empty($product_id)){$service_id = $product_id;}
								   if(!empty($ots_id)){$service_id     = $ots_id;}
								   
								  ?>
								 <tr id='tr_cls_<?php echo $key; ?>' data-id='<?php echo $key; ?>'><td><?php  echo $ver['product_name'];?></td>
								 <td><input type='text' class='form-control qty' name='qty[]' Placeholder='Qty' onchange='calculate_total(this);' maxlength='4' value="<?php  echo $ver['product_qty'];?>" /></td>
								 <td><input type='text' class='form-control price' name='price[]' Placeholder='Price' onchange='calculate_total(this);' maxlength='8' value="<?php  echo $ver['product_price'];?>" /></td>
								 <td><input type='text' class='form-control total_price' name='total_price[]' readonly  maxlength='8' value="<?php  echo $ver['product_gst_amt'];?>" /></td><td><input type='text' class='form-control' name='desc1[]'  Placeholder='Description1' maxlength='100' value="<?php  echo $ver['desc1'];?>" /></td>
								 <td><input type='text' class='form-control' name='desc2[]'  Placeholder='Description2' maxlength='100' value="<?php  echo $ver['desc2'];?>" /></td>
								 <input type='hidden' class='form-control gst' name='gst[]' id='gst_<?php echo $key; ?>' value="<?php  echo $gst;?>" />
								 <input type='hidden' class='form-control unit_price' id='unit_price_<?php echo $key; ?>' name='unit_price[]' value='<?php  echo $ver['product_price'];?>'  />
				                 <input type='hidden' class='form-control gst_price' id='gst_price_<?php echo $key; ?>' name='gst_price[]' value="<?php  echo $ver['product_gst_amt'];?>"  />				   
				                <input type='hidden' class='form-control p_product_name' id='p_product_name_<?php echo $key; ?>' name='p_product_name[]' value='<?php  echo $ver['product_name'];?>'  />
				                <input type='hidden' class='form-control service_id' id='service_id_<?php echo $key; ?>' name='service_id[]' value='<?php  echo $service_id;?>'  />
								 
								 </tr>  
							<?php } } }  ?>
						   </tbody>
						   </table>   
						   
						   <table class="table table-bordered table-striped table-condensed flip-content table1">
						  <tr class="success"><th width="5%">Sr.No</th><th>Description</th><th width="5%"></th><th width="5%"></th></tr>
							<tbody id="tbl_desc_details">
							<?php if($action == "Edit"){ ?>
							<?php if(!empty($quoDetaillist['quoFieldlist'])){ 
							       foreach($quoDetaillist['quoFieldlist'] as $key=>$filds){ ?>
							<tr><td></td><td><input type="text" placeholder="Description" class="form-control" name="p_qf_desc[]" maxlength="100"value="<?php  echo $filds['qf_desc'];?>"></td></tr>
							<?php } } } else { ?>
							
							<tr id="tr_desc_1" data-id='1'><td></td><td>
							<input type="text" placeholder="Description" class="form-control" name="p_qf_desc[]" maxlength="100"></td> <td><a href='javascript:;'  class='btn btn-info btn-xs' onclick='add_desc_row(this);' ><i class='fa fa-plus'></i> </a></td></tr>
							<?php } ?>
						   </tbody>
						   </table>  
						
						  
						    <table class="table no-bordered">						   
							
								<tr><td class="pull-left"><b>Total Amount</b></td>
								<td class="pull-left"><input class="form-control" id="cust_total_amount" name="cust_total_amount" type="text" placeholder="Total Price" maxlength='8' value="<?php echo isset($quoDetaillist['quote_gst_amt'])?$quoDetaillist['quote_gst_amt']:0; ?>" readonly>
						    <?php echo form_error('cust_total_amount','<span class="text-danger">','</span>'); ?><td><td colspan="4">&nbsp;</td></tr>	
								<tr><td colspan="6">&nbsp;&nbsp;</td><td><b>Thanking You</b></td></tr>	
								<tr><td colspan="6">&nbsp;&nbsp;</td><td><input class="form-control" id="p_quote_ack_by" name="p_quote_ack_by" type="text" placeholder="Mauli-Infotech" maxlength='100' value="<?php echo isset($quoDetaillist['quote_ack_by'])?$quoDetaillist['quote_ack_by']:"Mauli-Infotech"; ?>" ></td></tr>	
						  </table>
                           </div>
                           </div>
                        </div>
					  
						  <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" type="submit"  id="add_edit_form_btn" >Submit</button>
                          <a href="<?php echo base_url();?>reports/quotation_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                        </div>
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
	
	 $('.selectpicker').selectpicker();
	 $('#ref_id').on('change', function(){  }); 
	 $('.datepicker').datepicker({
		        format: 'd-M-yyyy',
				autoclose: true,
				todayHighlight: true,

		});	
	
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
             cust_type: {
                required: true,
			 }, 
			 ref_id: {
                required: true,
			 },  
			 p_quote_priorty: {
                required: true,
			 }, 
			 p_quote_date: {
                required: true,
			 }, 
			 
			 p_quote_name: {
                required: true,
				maxlength: 100,
			 },   
			 p_quote_address: {
                required: true,
				maxlength: 500,
			 }, 
			 p_quote_contact: {
                required: true,
				maxlength: 10,
				minlength: 10,
				digits: true,
			 },  
			 
			 p_quote_subject: {
                required: true,
				maxlength: 100,
			 },   
			 p_quote_desc: {
                required: true,
				maxlength: 1000,
			 },  
			  cust_service_type: {
                required: true,
			 },  
			 p_quote_ack_by: {
                required: true,
				maxlength: 100,
			 }, 
			 cust_total_amount: {
				required: true,
            	maxlength: 8,
            	number: true,
				 },  
			"service_id[]": {
				required: true,
  				 }, 
				 
			"qty[]": {
				required: true,
            	maxlength: 4,
            	digits: true,
				 }, 
			"price[]": {
				required: true,
            	maxlength: 8,
            	number: true,
				 }, 
			"total_price[]": {
				required: true,
            	maxlength: 8,
            	number: true,
				 }, 
			"desc1[]": {
            	maxlength: 100,
				 }, 
			"desc2[]": {
            	maxlength: 100,
				 }, 
			"p_qf_desc[]": {
            	maxlength: 100,
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
		  if (element.is(":radio")){ 
			error.appendTo("#radio_err");
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

function get_amc_details(obj) {
		var amc_id    = $(obj).val();
        var id        = $(obj).closest('tr').attr("data-id");
        var pm_name   = $('option:selected', obj).attr('data-name');	
		if (amc_id !=="") {
		 $.ajax({
			url:base_url+"ajax/get_amc_details_quote",
			type: "POST",
			datatype: "json",
			data: {"amc_id":amc_id},
			async: true,
			cache: false,
			success: function(data)
			{		
				  var data         = JSON.parse(data);	
				   var gst         = parseFloat(data.cust_pdt_gst); 
				   var gst_price   = parseFloat(data.cust_pdt_gst_price); 
				   var price       = parseFloat(data.cust_pdt_price); 
	            //   var gst_amnt    = parseFloat(data.gst_amnt); 
					if(isNaN(gst))   { gst = 0;} 
					if(isNaN(gst_price)) { gst_price = 0;} 
					if(isNaN(price)) { price = 0;} 
		         //  if(isNaN(gst_amnt))  { gst_amnt = 0;} 
				   var html_data = "<input type='hidden' class='form-control gst' name='gst[]' id='gst_"+id+"' value='"+gst+"'  />";
				   html_data += "<input type='hidden' class='form-control unit_price' id='unit_price_"+id+"' name='unit_price[]' value='"+price+"'  />";
				   html_data += "<input type='hidden' class='form-control gst_price' id='gst_price_"+id+"' name='gst_price[]' value='"+gst_price+"'  />";
				   
				   html_data += "<input type='hidden' class='form-control p_product_name' id='p_product_name_"+id+"' name='p_product_name[]' value='"+pm_name+"'  />";
				   
				   $("#tr_cls_"+id).find(".qty").val("1");
		           $("#tr_cls_"+id).find(".price").val(price);
		           $("#tr_cls_"+id).find(".total_price").val(gst_price);
				 //  $("#tr_cls_"+id).find(".gst_amnt").val(gst_amnt);
				   
				   if($("#gst_"+id).length){
					   $("#gst_"+id).val(gst);
					   $("#unit_price_"+id).val(price);
					   $("#gst_price_"+id).val(gst_price);
					   $("#p_product_name_"+id).val(pm_name);
				   }else{
                   $("#tr_cls_"+id).append(html_data);
				   }
				   get_total();
			}
		});
			
		} 		
	}
	
	function get_ots_details(obj) {
		var ots_id    = $(obj).val();
        var id        = $(obj).closest('tr').attr("data-id");	
        var pm_name   = $('option:selected', obj).attr('data-name');		
		if (ots_id !=="") {
			$.ajax({
			url:base_url+"ajax/get_ots_details_quote",
			type: "POST",
			datatype: "json",
			data: {"ots_id":ots_id},
			async: true,
			cache: false,
			success: function(data)
			{		
				   var data        = JSON.parse(data);	
				   var gst         = parseFloat(data.cust_pdt_gst); 
				   var gst_price   = parseFloat(data.cust_pdt_gst_price); 
				   var price       = parseFloat(data.cust_pdt_price); 
				//  var gst_amnt       = parseFloat(data.gst_amnt); 
	
					if(isNaN(gst))       { gst = 0;} 
					if(isNaN(gst_price)) { gst_price = 0;} 
					if(isNaN(price))     { price = 0;} 
					///if(isNaN(gst_amnt))  { gst_amnt = 0;} 
		           var html_data = "";		
				   html_data = "<input type='hidden' class='form-control gst' name='gst[]' id='gst_"+id+"' value='"+gst+"'  />";
				   html_data += "<input type='hidden' class='form-control unit_price' id='unit_price_"+id+"' name='unit_price[]' value='"+price+"'  />";
				   html_data += "<input type='hidden' class='form-control gst_price' id='gst_price_"+id+"' name='gst_price[]' value='"+gst_price+"'  />";
				   
				   html_data += "<input type='hidden' class='form-control p_product_name' id='p_product_name_"+id+"' name='p_product_name[]' value='"+pm_name+"'  />";
					 
				   $("#tr_cls_"+id).find(".qty").val("1");
		           $("#tr_cls_"+id).find(".price").val(price);
				   $("#tr_cls_"+id).find(".total_price").val(gst_price);
				  // $("#tr_cls_"+id).find(".gst_amnt").val(gst_amnt);
				   
				   if($("#gst_"+id).length){
					   $("#gst_"+id).val(gst);
					   $("#unit_price_"+id).val(price);
					   $("#gst_price_"+id).val(gst_price);
					   $("#p_product_name_"+id).val(pm_name);
				   }else{
                   $("#tr_cls_"+id).append(html_data);
				   }
				 get_total();
				   
			}
		});
			
		} 	
	}
	function get_product_details(obj) {
		var pm_id     = $(obj).val();		
		var id        = $(obj).closest('tr').attr("data-id");
		var pm_name   = $('option:selected', obj).attr('data-name');	
		if (pm_id !=="") {					
		 $.ajax({
			url:base_url+"ajax/get_product_details_quote",
			type: "POST",
			datatype: "json",
			data: {"pm_id":pm_id},
			async: true,
			cache: false,
			success: function(data)
			{		
				   var data        = JSON.parse(data);	
				   var gst         = parseFloat(data.cust_pdt_gst); 
				   var gst_price   = parseFloat(data.cust_pdt_gst_price); 
				   var price       = parseFloat(data.cust_pdt_price); 
	             // var gst_amnt       = parseFloat(data.gst_amnt); 
					if(isNaN(gst))   { gst = 0;} 
					if(isNaN(gst_price)) { gst_price = 0;} 
					if(isNaN(price)) { price = 0;} 
		            //if(isNaN(gst_amnt))  { gst_amnt = 0;} 
				   var html_data = "<input type='hidden' class='form-control gst' name='gst[]' id='gst_"+id+"' value='"+gst+"'  />";
				   html_data += "<input type='hidden' class='form-control unit_price' id='unit_price_"+id+"' name='unit_price[]' value='"+price+"'  />";
				   html_data += "<input type='hidden' class='form-control gst_price' id='gst_price_"+id+"' name='gst_price[]' value='"+gst_price+"'  />";
				   
				   html_data += "<input type='hidden' class='form-control p_product_name' id='p_product_name_"+id+"' name='p_product_name[]' value='"+pm_name+"'  />";
				   
				   $("#tr_cls_"+id).find(".qty").val("1");
		           $("#tr_cls_"+id).find(".price").val(price);
				   $("#tr_cls_"+id).find(".total_price").val(gst_price);
				  // $("#tr_cls_"+id).find(".gst_amnt").val(gst_amnt);
				   if($("#gst_"+id).length){
					   $("#gst_"+id).val(gst);
					   $("#unit_price_"+id).val(price);
					   $("#gst_price_"+id).val(gst_price);
					   $("#p_product_name_"+id).val(pm_name);
				   }else{
                   $("#tr_cls_"+id).append(html_data);
				   }
                   get_total();
				   
			}
		});
			
		} 	
	}


function calculate_total(obj) {
	
		var id       = $(obj).closest('tr').attr("data-id");
		var cust_pdt_qty           = 0;		
        var cust_pdt_price         = 0;
        var cust_pdt_gst           = 0;
		var total      = 0;
		cust_pdt_qty   = parseFloat($("#tr_cls_"+id).find(".qty").val());
		cust_pdt_price = parseFloat($("#tr_cls_"+id).find(".price").val());
		cust_pdt_gst   = parseFloat($("#gst_"+id).val());
		
		if(isNaN(cust_pdt_qty))     { cust_pdt_qty = 0;} 
		if(isNaN(cust_pdt_price))   { cust_pdt_price = 0;} 
		if(isNaN(cust_pdt_gst))     { cust_pdt_gst = 0;} 
		
		var total = cust_pdt_price*cust_pdt_qty;
			total = Math.round(parseFloat((total * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);
		var gst = (total * cust_pdt_gst)/100;		
		 gst = Math.round(parseFloat((gst * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);
         cust_pdt_gst_price	 = gst + total;	 
		 total = Math.round(parseFloat((total * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);
         $("#gst_price_"+id).val(cust_pdt_gst_price);
		 $("#tr_cls_"+id).find(".total_price").val(cust_pdt_gst_price);
		 //$("#tr_cls_"+id).find(".gst_amnt").val(gst);
		 get_total();
       	
    }
	
function get_total()
{
	
	 var total_gst_price = 0;
	 $("#tbl_service_details").find(".form-control").each(function( j ) {
	 if( $(this).attr("name") == "gst_price[]"){
			var gst_price = parseFloat($(this).val());
			if(isNaN(gst_price))   { gst_price = 0;} 
			total_gst_price = total_gst_price + gst_price;
			
		} 
   });	
   total_gst_price = Math.round(parseFloat((total_gst_price * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2); 
   $("#cust_total_amount").val(total_gst_price);	
	
}
	
	
function get_services(obj) {
	
	    $("#tbl_service_details").html("");
        var service_type   = $(obj).val();			
		$.ajax({
			url:base_url+"ajax/get_service_list_quotation",
			type: "POST",
			datatype: "json",
			data: {"service_type":service_type},
			async: true,
			cache: false,
			success: function(data)
			{		
				var html_data = JSON.parse(data);	
                 $("#tbl_service_details").html(html_data);

			}
		});
}

function get_customers()
{ 
   $(".loader").fadeIn();
	$.ajax({
			url:base_url+"ajax/get_customers",
			type: "POST",
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
				{		
					var data = JSON.parse(data);
					$("#ref_id").html(data);
					$(".loader").fadeOut();
					$('.selectpicker').selectpicker('refresh');
				}
			});

}
function get_leads()
{ 
   $(".loader").fadeIn();
	$.ajax({
			url:base_url+"ajax/get_leads",
			type: "POST",
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
				{		
					var data = JSON.parse(data);
					$("#ref_id").html(data);
					$(".loader").fadeOut();
					$('.selectpicker').selectpicker('refresh');
				}
			});

}

function get_ref_details()
{ 
   var ref_id    = $("#ref_id").val();
   $("#ref_details").html("");
   var cust_type = $('input[name="cust_type"]:checked').val();
   if(ref_id && cust_type){
   $(".loader").fadeIn();
	$.ajax({
			url:base_url+"ajax/get_ref_details_quot",
			type: "POST",
			data: {"ref_id":ref_id,"cust_type":cust_type},
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
				{		
					var data = JSON.parse(data);
					var p_quote_name = data.name;
					var p_quote_contact = data.contact;
					var p_quote_contact_person = data.contact_person;
					var p_quote_address = data.address;
					var p_quote_landline = data.landline;
					var p_quote_email = data.emailid;
					var p_quote_dist_id = data.dist_id;
					var p_quote_state_id = data.state_id;
					var p_quote_pin_code = data.pincode;
					$("#p_quote_name").val(p_quote_name);
					$("#p_quote_address").val(p_quote_address);
					$("#p_quote_contact").val(p_quote_contact);
					$("#p_quote_landline").val(p_quote_landline);
					$("#p_quote_email").val(p_quote_email);
					$("#p_quote_contact_person").val(p_quote_contact_person);
					$("#p_quote_dist_id").val(p_quote_dist_id);
					$("#p_quote_state_id").val(p_quote_state_id);
					$("#p_quote_pin_code").val(p_quote_pin_code);
					$(".loader").fadeOut();
					
				}
			});
   }

}

function delete_row(obj)
	{
		var id = $(obj).attr("data-id");
		$('#tr_cls_'+id).remove();
		get_total();
		
	}	
	function delete_desc_row(obj)
	{
		var id = $(obj).attr("data-id");
		$('#tr_desc_'+id).remove();
		
	}	
	
	function add_row(obj)
	{
		var id = $(obj).attr("data-id");
		var tr_html = $("#tr_cls_1").html();
		var data_id = getRandomInt(20);
		var html = '<tr id="tr_cls_'+data_id+'" data-id="'+data_id+'" >';
		var html = html + tr_html;
		var html = html +"<td><a href='javascript:;'  class='btn btn-danger btn-xs' onclick='delete_row(this);' data-id='"+data_id+"' ><i class='fa fa-close'></i> </a></td></tr>";
		 
		$("#tbl_service_details").append(html);		
		
		 $("#tr_cls_"+data_id).find(".form-control").each(function( j ) {
		 if( $(this).attr("name") == "gst_price[]"){
				$(this).attr("id","gst_price_"+data_id);
				
			} 
		 if( $(this).attr("name") == "unit_price[]"){
				$(this).attr("id","unit_price_"+data_id);
				
			}  
		if( $(this).attr("name") == "gst[]"){
				$(this).attr("id","gst_"+data_id);
				
			} 
		if( $(this).attr("name") == "p_product_name[]"){
				$(this).attr("id","p_product_name_"+data_id);
				
			} 
	
	   });	
		//get_total();
		
	}	
	function add_desc_row(obj)
	{
		var id = $(obj).attr("data-id");
		var tr_html = $("#tr_desc_1").html();
		var data_id = getRandomInt(20);
		var html = '<tr id="tr_desc_'+data_id+'" data-id="'+data_id+'" >';
		var html = html + tr_html;
		var html = html +"<td><a href='javascript:;'  class='btn btn-danger btn-xs' onclick='delete_desc_row(this);' data-id='"+data_id+"' ><i class='fa fa-close'></i> </a></td></tr>";
		$("#tbl_desc_details").append(html);
		
	}	
function getRandomInt(max) {
      return Math.floor(Math.random() * Math.floor(max))+2;
    }
	
	
</script>