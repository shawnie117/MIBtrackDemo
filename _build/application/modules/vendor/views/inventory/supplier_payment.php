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
	<li><a href="<?php echo base_url(get_module()."/inventory/supplier_pay_det")?>">All Payment Details</a><i class="fa fa-circle"></i></li>
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
					  $formaction = "supplier_payment"; } 
					
					?>
					
                     <form action="<?php echo get_module_path().'inventory/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					  <?php if($action=="Edit"){ ?>
					  <input type="hidden" value="<?php echo isset($details['supp_det_id'])?$details['supp_det_id']:set_value("supp_det_id"); ?>" name="supp_det_id" id="supp_det_id" />
					  <?php } ?>
										 
                      <div class="col-md-12">
					     <div class="portlet-title">
					            <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-call-out"></i>
								  <span class="caption-subject font-red-mint sbold">Add Payment</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>
                           <div class="form-group col-md-3">
                           <label for="p_supp_rct">Receipt No.:</label>
						   <input class="form-control" id="p_supp_rct" name="p_supp_rct" type="text" placeholder="  " required maxlength="100" value="<?php echo isset($details['supp_name'])?$details['supp_name']:set_value("p_supp_rct"); ?>">
						    <?php echo form_error('p_supp_rct','<span class="text-danger">','</span>'); ?>
                           </div>
                   

					  <!-- <div class="form-group col-md-8">
						   <label for="p_suplids"> Select Supplier </label><?php echo REQUIRED_STAR; ?>		   
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
                        </div> 	 -->
						
						
						<div class="form-group col-md-3"> 
                        <label for="s_type">Supplier <?php echo REQUIRED_STAR; ?></label>				 
						   <select class="form-control" id="p_suplid" name="p_suplid" required onchange="get_supplier_invoice(this,'p_supp_inv');" >
							<option value=""> Select Supplier</option>
							 <?php  if(!empty($supplier_list)){ 	
								foreach($supplier_list as $supplier){ 
								  $selected = isset($details['order_suppid']) && ($details['order_suppid']==$supplier['supp_id'])?"selected":"";
								
								?>
									<option value="<?php echo $supplier['supp_id'];?>" data-detid="<?php echo $supplier['supp_det_id'];?>"  <?php echo $selected;?> ><?php echo $supplier['supp_name']; ?></option>
							<?php } } ?>	
						   </select>
						     </div>


					 	
                        <div class="form-group col-md-3">
                           <label for="cust_ui_date">Date</label><?php echo REQUIRED_STAR; ?>
                           <input class="form-control datepicker" id="cust_ui_date" name="cust_ui_date" type="text" placeholder="Enter Date"  maxlength="15" value="<?php echo isset($details['cust_uidate_n'])?$details['cust_uidate_n']:set_value("cust_ui_date"); ?>">
						    <?php echo form_error('cust_ui_date','<span class="text-danger">','</span>'); ?>
                           </div> 

						   <div class="form-group col-md-3">
                           <label for="p_supp_total_price">Total Price</label>
						   <input class="form-control" id="p_supp_total_price" name="p_supp_total_price" type="text" placeholder="Enter Total Price" required maxlength="15" >
						    <?php echo form_error('p_supp_total_price','<span class="text-danger">','</span>'); ?>
                        </div>



                      </div>

                      <!-- <div class="col-md-12">
                      <div class="form-group col-md-8">
                           <label for="p_supp_desc">Location</label> <?php echo REQUIRED_STAR; ?>
						   <select class="form-control" id="p_supp_desc" name="p_supp_desc" value="<?php echo isset($details['supp_desc'])?$details['supp_desc']:set_value("p_supp_desc"); ?>">
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
                        </div> -->


						<div class="col-md-12">
                      <!-- <div class="form-group col-md-4">
                           <label for="">Location</label> <?php echo REQUIRED_STAR; ?>
						   <select class="form-control" id="supp_det_address" name="supp_det_address" onchange="get_supplier_invoice_detail(this,'p_supp_total_price','p_supp_paid_ammount','p_supp_balance_amt');">
							<option value=""> Select Location</option>
							 <?php  if(!empty($supplier_list )){ 	 						
								foreach($supplier_list as $supplier){ 
                                    $supplier_id =  isset($details['supplier_id'])?$details['supplier_id']:set_value("supp_idd");
								
									?>
								<option value="<?php echo $supplier['supp_idd'];?>" <?php echo $selected;?>><?php echo $product['supp_det_id']; ?></option>

							<?php } } ?>	
						   </select>						 -->
						   
						    <?php echo form_error('prod_id','<span class="text-danger">','</span>'); ?>
                        </div>
					
				
						 <div class="col-md-12">
						  
						 <div class="form-group col-md-3">
                           <label for="p_supp_paying_amt">Amount<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_supp_paying_amt" name="p_supp_paying_amt" type="text" placeholder="Enter Total Amount" maxlength="15" value="<?php echo isset($details['p_supp_paying_amt'])?$details['p_supp_paying_amt']:set_value("p_supp_paying_amt"); ?>">
						    <?php echo form_error('p_supp_paying_amt','<span class="text-danger">','</span>'); ?>
                            </div>
						 
                         <div class="form-group col-md-3">
                           <label for="p_supp_balance_amt">Balance:</label>
						   <input class="form-control" id="p_supp_balance_amt" name="p_supp_balance_amt" type="text" placeholder="Enter Balance Amount" required  maxlength="300" value="<?php echo isset($details['supp_det_address'])?$details['supp_det_address']:set_value("p_supp_balance_amt"); ?>">
						    <?php echo form_error('p_supp_balance_amt','<span class="text-danger">','</span>'); ?>
                         </div>
						 
						
						
						 <div class="form-group col-md-3">
                           <label for="p_type">Payment Mode <?php echo REQUIRED_STAR; ?></label>
						     <select class="form-control" id="p_type" name="p_type" onchange="get_payment_details(this);" >
							<option value=""> Payment Mode</option>
							 <?php  if(!empty($payment_mode_list)){ 							
								foreach($payment_mode_list as $key=>$pay){ ?>			          
									<option value="<?php echo $key;?>"  ><?php echo $pay; ?></option>
							<?php } } ?>	
						   </select>	
                            <?php echo form_error('p_type','<span class="text-danger">','</span>'); ?>						   
                           </div>
                        <div class="form-group col-md-3">
                           <label for="payment_remark">Payment Remark</label>
                           <input class="form-control" id="payment_remark" name="payment_remark" type="text" placeholder="Enter Payment Remark"  maxlength="100" value="<?php echo set_value("payment_remark"); ?>">
						    <?php echo form_error('payment_remark','<span class="text-danger">','</span>'); ?>
                           </div> 						   
                        </div>
						</div>
						                 
						 <div class="col-md-12">					 
					  
										
                      <div class="col-md-12 hidden" id="cheque_details">
						    <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint  icon-note"></i>
								  <span class="caption-subject font-red-mint sbold">Cheque Details</span>
							   </div>
							  <hr style="margin:3px;"/>
						   </div>
						    
						    <div class="form-group col-md-3">
                           <label for="p_chqno">Cheque Number<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_chqno" name="p_chqno" type="text" placeholder="Enter Cheque Number"  maxlength="6" value="<?php echo set_value("p_chqno"); ?>">
						    <?php echo form_error('p_chqno','<span class="text-danger">','</span>'); ?>
                         </div>	 
						
						  <div class="form-group col-md-3">
                           <label for="p_chqdate">Cheque Date<?php echo REQUIRED_STAR; ?></label>
                           <input class="form-control datepicker" id="p_chqdate" name="p_chqdate" type="text" placeholder="Enter Cheque Date"  maxlength="15" value="<?php echo set_value("p_chqdate"); ?>">
						    <?php echo form_error('p_chqdate','<span class="text-danger">','</span>'); ?>
                           </div> 
						    <div class="form-group col-md-3" >
                           <label for="p_chq_det">Cheque Details</label>
						   <input class="form-control" id="p_chq_det" name="p_chq_det" type="text" placeholder="Enter Cheque Details"  maxlength="100"  value="<?php echo set_value("p_chq_det"); ?>">
						    <?php echo form_error('p_chq_det','<span class="text-danger">','</span>'); ?>
                         </div>	 
						 
						
                         </div>
                      	
						   <div class="col-md-12 hidden" id="other_details">
						    <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint  icon-note"></i>
								  <span class="caption-subject font-red-mint sbold">Transaction / Payment Details</span>
							   </div>
							  <hr style="margin:3px;"/>
						   </div>
							<div class="form-group col-md-3">
                           <label for="p_payid">Payment Id</label><?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="p_payid" name="p_payid" type="text" placeholder="Enter Payment Id"  maxlength="100" value="<?php echo set_value("p_payid"); ?>">
						    <?php echo form_error('p_payid','<span class="text-danger">','</span>'); ?>
                            </div>
                         </div>
                        </div>
						   </div>
				
						   <div class="form-actions">
						 <div class="col-md-12">
						 <center>						  
                           <button type="submit" class="btn btn-success" >Submit</button>
                          <a href="<?php echo get_module_path();?>inventory/supplier_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Cancel</a>
						  </center>
                        </div>
                        </div>
						</form>
								</div>
				
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
			p_supp_rct: {
				required: true,
            	maxlength: 100,
                minlength: 2,
				 },
			p_supp_desc: {
				required: true,
            	maxlength: 500,
                minlength: 2,
				 },
			
            p_supp_det_mob1: {
				required: true,
            	maxlength: 10,
                minlength: 10,
				digits:true,
				 }, 
			p_supp_det_mob2: {
				maxlength: 10,
                minlength: 10,
				digits:true,
				 }, 
            p_supp_det_landline: {
            	maxlength: 15,
                digits:true,
				 }, 	 
			p_supp_paying_amt: {
            	maxlength: 15,
                digits:true,
				 }, 	
			p_supp_balance_amt: {
				required: true,
			    maxlength: 300,
                minlength: 2,
				 }, 
				 
            p_supp_det_stateid: {
				required: true,
   				 }, 	
    		p_supp_det_distid: {
				required: true,
   				 }, 
			p_supp_det_cityid: {
				required: true,
   				 }, 
			p_supp_det_area: {
				maxlength: 100,
   				 }, 
			p_supp_det_pincode: {
				required: true,
				maxlength: 6,
                minlength: 6,
				digits:true,
				 }, 
            p_supp_det_emailid: {
			    required: true,
            	maxlength: 100,
                email:true,
				 },  				 
			p_supp_total_price: {
				required: true,
            	maxlength: 15,
				gst:false,
                minlength: 1,
				 }, 				 
		    p_supp_det_otherdet: {
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
			}else if (element.is(":checkbox")){ // This is the default behavior of the script for all fields
			error.appendTo("#file_err");
			}else { // This is the default behavior of the script for all fields
			error.insertAfter(element);
			}
			
		},
    });
	
	

	
    });


		function get_payment_details(obj) {
				
				var payment_type   = $(obj).val();	
				
				$("#other_details").addClass("hidden");
				$("#cheque_details").addClass("hidden");
				
				if(payment_type=="Cheque"){
					$("#cheque_details").removeClass("hidden");
					
				}else if(payment_type=="Online"){
					$("#other_details").removeClass("hidden");
				}
			}
	
	
	
</script>

