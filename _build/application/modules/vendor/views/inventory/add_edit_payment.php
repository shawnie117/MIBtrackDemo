<link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />

<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
         <div class="portlet light bordered">
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint icon-wallet "></i>
                  <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
               </div>
			   <div class="actions">
			   <button type="button"  class="close" data-dismiss="modal">&times;</button>
               </div>
		   </div>
            <div class="row">
			   <div class="portlet-body form">
                 <?php if($action=="Edit"){  
				    $details = html_escape($details);
					//echo "<pre/>"; print_r($details); die;
					$formaction = "edit_payment/?ref_id=".base64_encode($ref_id);
					}else {  $formaction = "add_payment/?ref_id=".base64_encode($ref_id)."&url=".$url; } ?>
                  <div class="col-md-12">
			         <form action="<?php echo get_module_path().'inventory/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					  <input type="hidden" name="p_orderid" id= "p_orderid" value="<?php echo isset($details['supp_lia_orderid'])?$details['supp_lia_orderid']:"";?>" /> 
					  <input type="hidden" name="p_supp_lia_id" id= "p_supp_lia_id" value="<?php echo isset($details['supp_lia_id'])?$details['supp_lia_id']:"";?>" /> 
					  <input type="hidden" name="p_suppid" id= "p_suppid" value="<?php echo isset($details['supp_id'])?$details['supp_id']:"";?>" /> 
					  <input type="hidden" name="p_suppdetid" id= "p_suppdetid" value="<?php echo isset($details['supp_det_id'])?$details['supp_det_id']:"";?>" /> 
					  
					  <input type="hidden" name="supp_lia_bal_amt" id= "supp_lia_bal_amt" value="<?php echo isset($details['supp_lia_bal_amt'])?$details['supp_lia_bal_amt']:"0";?>" /> 
					  
					    <div class="col-md-12">
                        <div class="form-group col-md-6">
                           <label for="p_receiptno">Receipt No.</label><?php echo REQUIRED_STAR; ?>
                           <input type="text" class="form-control" id="p_receiptno" name="p_receiptno" maxlength="10" placeholder="Enter Receipt No." value="" required >
					
						    <?php echo form_error('p_receiptno','<span class="text-danger">','</span>'); ?>
                        </div> 
						
							 <div class="form-group col-md-6">
                           <label for="p_paiddate">Payment Date<?php echo REQUIRED_STAR; ?></label>
                           <input class="form-control datepicker" id="p_paiddate" name="p_paiddate" type="text" placeholder="Enter Payment Date"  maxlength="15" value="<?php echo set_value("p_paiddate"); ?>">
						    <?php echo form_error('p_paiddate','<span class="text-danger">','</span>'); ?>
                           </div> 

                          <div class="form-group col-md-6">
                           <label for="p_amt">Paying Amount <?php echo REQUIRED_STAR; ?></label>
						      <input class="form-control" id="p_amt" name="p_amt" type="text" placeholder="Total Paying Amount" maxlength='8' value="" >
						    <?php echo form_error('p_amt','<span class="text-danger">','</span>'); ?>		
                           </div>
                           <div class="form-group col-md-6">
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
                        <div class="form-group col-md-6">
                           <label for="payment_remark">Payment Remark</label>
                           <input class="form-control" id="payment_remark" name="payment_remark" type="text" placeholder="Enter Payment Remark"  maxlength="100" value="<?php echo set_value("payment_remark"); ?>">
						    <?php echo form_error('payment_remark','<span class="text-danger">','</span>'); ?>
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
						    
						    <div class="form-group col-md-6">
                           <label for="p_chqno">Cheque Number<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_chqno" name="p_chqno" type="text" placeholder="Enter Cheque Number"  maxlength="6" value="<?php echo set_value("p_chqno"); ?>">
						    <?php echo form_error('p_chqno','<span class="text-danger">','</span>'); ?>
                         </div>	 
						
						  <div class="form-group col-md-6">
                           <label for="p_chqdate">Cheque Date<?php echo REQUIRED_STAR; ?></label>
                           <input class="form-control datepicker" id="p_chqdate" name="p_chqdate" type="text" placeholder="Enter Cheque Date"  maxlength="15" value="<?php echo set_value("p_chqdate"); ?>">
						    <?php echo form_error('p_chqdate','<span class="text-danger">','</span>'); ?>
                           </div> 
						    <div class="form-group col-md-6" >
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
							<div class="form-group col-md-6">
                           <label for="p_payid">Payment Id</label><?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="p_payid" name="p_payid" type="text" placeholder="Enter Payment Id"  maxlength="100" value="<?php echo set_value("p_payid"); ?>">
						    <?php echo form_error('p_payid','<span class="text-danger">','</span>'); ?>
                            </div>
                         </div>
                        </div>
						   </div>
					
						   <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" id="mybutton" type="submit" >Submit</button>
                          <button type="button" class="btn red btn-outline" data-dismiss="modal">Cancel</button>
                        </div>
                        </div>
						</form>
						 </div>
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
         <!-- END PAGE BASE CONTENT -->
      </div>
      <!-- END CONTENT BODY -->
   </div>
   <!-- END CONTENT -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- Form Validation Plugins -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
	<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/moment.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
<script type="text/javascript">  	

$(document).ready(function() {
	
	jQuery.validator.addMethod("lessThanOrEqual",
        function(value, element, params) {
            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) <= new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val()) ||
                (Number(value) <= Number($(params).val()));
        }, 'Must be Less than or equal to {0}.');
	
	$('#bank_ifsc').change(function() {
			var bank_ifsc = $("#bank_ifsc").val();
			getIFSC(bank_ifsc);
	   });
	   
	   
	 $('.datepicker').datepicker({
				format: 'dd-M-yyyy',
				autoclose: true,
				todayHighlight: true,

		});	
	
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true,
				
            },
            p_receiptno: {
                required: true,
				maxlength: 100,
				
				 },  
			p_paiddate: {
                required: true,
				
				 },  
			p_type: {
                required: true,
				
				 },  
			p_amt: {
				 maxlength: 8,
                 required: true,
				 number: true,
				 lessThanOrEqual: "#supp_lia_bal_amt",
				 },  
			payment_remark: {
                required: true,
				maxlength: 100,
                minlength: 1,
				 },  
			p_chqno: {
				 required: true,
               	maxlength: 6,
                minlength: 6,
                digits: true,
				 }, 
			p_chq_det: {
				required: true,
               	maxlength: 100,
                minlength: 1,
				 }, 
			p_payid: {
				required: true,
               	maxlength: 100,
                minlength: 2,
               
				 }, 
			p_chqdate: {
                required: true,
				 },  
			
		},
		messages:
		{
			p_amt:{ lessThanOrEqual:"Paying Amount Must Be Less Than Or Equal To Balance Amount"},
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
	function getIFSC(emp_bank_ifsc_code)
	{ 
	   $('#ifsc_code').html("");
		if(emp_bank_ifsc_code){
			$.ajax({
				url:base_url+"admin/getIFSC",
				type: "POST",
				data: {'ifsc_code':emp_bank_ifsc_code},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var data = JSON.parse(data);
					$("#ifsc_code").html(data.BRANCH);
					$("#bank_branch_address").val(data.ADDRESS);
					$("#bank_name").val(data.BANK);
					$("#bank_micr").val(data.MICR);
				}
			});
		}
	} 
</script>