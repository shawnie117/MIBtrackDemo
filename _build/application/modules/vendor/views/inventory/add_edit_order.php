<?php $role_id = $this->session->userdata('user_role_id');?>
<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
   <!-- BEGIN PAGE BASE CONTENT -->
   
   <!--div class="page-head">
		<div class="page-title">
			<h1><?php echo $page_title; ?></h1>
		</div>	
	</div-->
	
	
   <div class="row">
      <div class="col-md-12">
         <div class="portlet light bordered">
		   		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url(get_module()."/inventory/order_report")?>">All Order Report </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
			<span class="caption-subject font-green-sharp sbold pull-left"><?php echo $page_title; ?></span>&nbsp; <span class="caption-subject font-red-mint sbold total_count ">( Total - 0 )</span>	 
			
            
			  <div class="row">
                 
				
		 <div class="col-md-12">
			<div class="portlet-body"> 
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
				  
             <div class="col-md-12 table-group-actions"> 
			 <?php if($action == "Add") { $disabled = "";
				 $formaction = "add_order";
			 } else if ($action == "Edit"){ $disabled = "disabled";
				 $formaction = "edit_order/?ref_id=".base64_encode($ref_id);
				 $orderDetailList = $details['orderDetailList'];
				 //echo "<pre/>"; print_r($details);die;
			 } ?>
			  <form id="submit_srch_form" autocomplete="off"  method="post" action="<?php echo get_module_path()."inventory/".$formaction ?>">
			  <input type="hidden" name="supplier_id" id="supplier_id" value="<?php echo isset($details['order_suppid'])?$details['order_suppid']:"";?>" />	
               <input type="hidden" name="det_id" id="det_id" value="<?php echo isset($details['order_supp_locid'])?$details['order_supp_locid']:"";?>" />	
			    <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint  icon-basket"></i>
								  <span class="caption-subject font-red-mint sbold">Order Details</span>
							   </div>
							  <!-- <hr style="margin:3px;"/> -->
						   </div>
                 <div class="form-group col-md-3"> 
                        <label for="p_type">Supplier <?php echo REQUIRED_STAR; ?></label>				 
						   <select class="form-control" id="p_suplid" name="p_suplid" required onchange="table_list(1);get_det_id(this);" <?php echo $disabled;?> >
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
               <label for="p_type">Order Date <?php echo REQUIRED_STAR; ?></label>				
                <input class="form-control datepicker" id="order_date" name="order_date"  required type="text" placeholder="Order Date" maxlength="15" value="<?php echo isset($details['order_orderdate'])?$details['order_orderdate']:"";?>">
				</div>
				<div class="form-group col-md-4"> 
				 <label for="p_type">Remark <?php echo REQUIRED_STAR; ?></label>
                <input class="form-control" id="remark" name="remark"  required type="text" placeholder="Remark" maxlength="100" value="<?php echo isset($details['order_remarks'])?$details['order_remarks']:"";?>" />
				</div>	
				<div class="form-group col-md-2"> 
				 <label for="p_type">Invoice No. <?php echo REQUIRED_STAR; ?></label>
                <input class="form-control" id="invoice" name="invoice"  required type="text" placeholder="Invoice No" maxlength="100" value="<?php echo isset($details['order_remarks'])?$details['order_remarks']:"";?>" />
				</div>	
								</div>
			<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th style="text-align:center">Sr. No.</th>	
                  <th>Item</th> 
                  <th>Purchase Price</th> 
                  <th>Sale Price</th>        				  
                  <th style="text-align:center">Qty</th>
                  <th style="text-align:center">Price</th>				  
                </tr>
                </thead>
				<?php if($action == "Edit"){  
				      if(!empty($orderDetailList)){  
					  $html = "";
				      foreach($orderDetailList as $key=>$item){
                       $sr_no = $key+1;			
                       $itemList = $item['itemList'][0];					   
				      $html = '<tr>
					  <td><input type="hidden" class="ckbox" name="item_id[]" value="'.$itemList['item_id'].'" /> &nbsp;'.$sr_no.'</td>
					  <td>'.$itemList['item_name'].'</td>
					  <td>'.$itemList['item_price'].'</td>
					  <td>'.$itemList['item_price2'].'</td>
					  <td><input type="number" id="'.$sr_no.'" class="form-control"  min="1" name="qty[]" value="'.$item['ord_det_qty'].'" placeholder="Qty"  /></td>
					  <td><input type="number" name="price[]" class="form-control" value="'.$item['ord_det_mrp_amnt'].'"  /> </td></tr>';
					  echo $html;
				?>
				<?php } } } ?>
				<?php if($action == "Add") { ?>
                <tbody  id="tbl_list">
               
				 </tbody>
				 <?php } ?>
						</table> 
						   		<!-- Render pagination links -->
						<div class="pagination" style="float:right;">
						</div>				
					
						  </div>

                    <div class="col-md-12">
					    <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint  icon-note"></i>
								  <span class="caption-subject font-red-mint sbold">Payment Details</span>
							   </div>
							  <hr style="margin:3px;"/>
						   </div>
                        <div class="form-group col-md-3">
                           <label for="p_receiptno">Receipt No.</label>
                           <input type="text" class="form-control" id="p_receiptno" name="p_receiptno" maxlength="10" placeholder="Enter Receipt No." value="" >
					
						    <?php echo form_error('p_receiptno','<span class="text-danger">','</span>'); ?>
                        </div> 
						
							 <div class="form-group col-md-3">
                           <label for="p_paiddate">Payment Date</label>
                           <input class="form-control datepicker" id="p_paiddate" name="p_paiddate" type="text" placeholder="Enter Payment Date"  maxlength="15" value="<?php echo set_value("p_paiddate"); ?>">
						    <?php echo form_error('p_paiddate','<span class="text-danger">','</span>'); ?>
                           </div> 

                          <div class="form-group col-md-3">
                           <label for="p_amt">Paying Amount <?php echo REQUIRED_STAR; ?></label>
						      <input class="form-control" id="p_amt" name="p_amt" type="text" placeholder="Total Paying Amount" maxlength='8' value="0" >
						    <?php echo form_error('p_amt','<span class="text-danger">','</span>'); ?>		
                           </div>
                           <div class="form-group col-md-3">
                           <label for="p_type">Payment Mode </label>
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
                           <label for="p_payid">Payment Id</label>
						   <input class="form-control" id="p_payid" name="p_payid" type="text" placeholder="Enter Payment Id"  maxlength="100" value="<?php echo set_value("p_payid"); ?>">
						    <?php echo form_error('p_payid','<span class="text-danger">','</span>'); ?>
                            </div>
                         </div>
                        </div>
						   </div>				
						   <div class="form-group col-md-12">
				<center><button type="submit" class="btn btn-success btn-sm">Submit</button></center>
				</div>
						  
						  
                       
            	 </form>	
			    </div>
               </div>
            </div>
            <!-- END Portlet PORTLET-->
         </div>
         </div>
         <!-- END PAGE BASE CONTENT -->
      </div>
      <!-- END CONTENT BODY -->
   </div>
   <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true"  data-backdrop="static">
			<div class="modal-dialog modal-md">
			<div class="modal-content">			
			</div>
			</div>
		</div>	
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
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
  // Detect pagination click
     $('.pagination').on('click','a',function(e){
       e.preventDefault(); 
       var pageno = $(this).attr('data-ci-pagination-page');
	   if(pageno){
		    table_list(pageno);
	   }
      
     });  

     $('.datepicker').datepicker({
				format: 'dd-M-yyyy',
				autoclose: true,
				todayHighlight: true,

		});	



$("#submit_srch_form").validate({
        rules: {
            required: {
                required: true
            },
             order_date: {
                required: true,
			 }, 
			 p_suplid: {
                required: true,
			 }, 
			
			remark: {
				required: true,
            	maxlength: 100,
                minlength: 2,
				 }, 
			"item_id[]": {
                required: true,
			 }, 
			"qty[]": {
                required: true,
			 }, 
			"price[]": {
                required: true,
			 },
            p_receiptno: {
                maxlength: 100,
				
				 },  
			/* p_paiddate: {
                required: true,
				
				 },  
			p_type: {
                required: true,
				
				 },   */
			p_amt: {
				 maxlength: 8,
                 number: true,
				 /* lessThanOrEqual: "#supp_lia_bal_amt", */
				 },  
			payment_remark: {
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
			//p_amt:{ lessThanOrEqual:"Paying Amount Must Be Less Than Or Equal To Balance Amount"},
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
			}else if (element.is(":checkbox")){ 
			//error.insertBefore(element);
			error.appendTo((element).parents('td').find('.chk_err'));
			}else { 
			error.insertAfter(element);
			}
			
		},
    });		

});

function table_list(pageno)
	{
		//var p_suplid  = $("#p_suplid").val();
        var p_suplid = $('option:selected', "#p_suplid").attr('data-detid');		
		$("#tbl_list").html("");
		
		if(p_suplid){
			$.ajax({
				url:base_url+"ajax_inventory/tbl_inward_item_list/"+pageno,
				type: "POST",
				data: {"p_suplid":p_suplid},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var json_arr = JSON.parse(data);			
					var html_data = '';
					var html_data   = json_arr.list;
					var total_count = json_arr.total_count;
					
					$(".total_count").html("( Total - "+total_count+" )");
					$("#tbl_list").html(html_data);
					$('.pagination').html(json_arr.pagination);
						
				}
			});
		}
	}
	function show_text_box(obj)
	{
			var id = $(obj).attr("data-pp_id");
			$('#'+id).prop("disabled", !$(obj).is(':checked'));
			$('.'+id).prop("disabled", !$(obj).is(':checked'));
	}
	function get_det_id(obj)
	{
			var supplier_id = $(obj).val();
			var det_id = $('option:selected', obj).attr('data-detid');
			$('#supplier_id').val(supplier_id);
			$('#det_id').val(det_id);
			
	}




	function get_payment_details(obj) {
		
		var payment_type   = $(obj).val();	
		 
		$("#other_details").addClass("hidden");
		$("#cheque_details").addClass("hidden");
		
		if(payment_type=="Cheque"){
			$("#cheque_details").removeClass("hidden");
			
		}else if(payment_type=="Online"){
			$("#other_details").removeClass("hidden");
		}

		function calculateTotalPrice(sr_no) {
        var qtyInput = document.getElementById('qty_' + sr_no);
        var totalPriceInput = document.querySelector('#' + sr_no + ' .total-price');
        var itemPrice = parseFloat(qtyInput.parentNode.previousElementSibling.textContent);
        var qty = parseFloat(qtyInput.value);
        var totalPrice = itemPrice * qty;
        totalPriceInput.value = totalPrice.toFixed(2);
    }

    // Event listener to call the calculateTotalPrice function when the quantity input changes
    var qtyInputs = document.querySelectorAll('.qty-input');
    qtyInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            var sr_no = this.id.split('_')[1]; // Extract sr_no from input id
            calculateTotalPrice(sr_no);
        });
    });
	}
</script>

