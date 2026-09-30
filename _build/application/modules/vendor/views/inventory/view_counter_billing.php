<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
         <div class="portlet light bordered">
		  <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url(get_module()."/inventory/counter_billing_report")?>">All Billing Report </a><i class="fa fa-circle"></i></li>
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
                  <?php if(!empty($details)){
						$details = html_escape($details);  
						 $id =  base64_encode($details['cc_id']);
					     $item        = $details['billMaster'];
					     $payList     = $details['payList'];
						$billDetailList    = $item['billDetailList'];
					  ?> 
                    
                  <div class="col-md-12">
			           <div class="portlet-body">
					   <div class="col-md-12">
					     <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint  icon-printer"></i>
								  <span class="caption-subject font-red-mint sbold">Bill Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
							<tr><th>Customer Name </th><td><?php echo isset($details['cc_name'])?$details['cc_name']:""; ?> </td> <td></td><td></td><th>Bill Amount </th><td><?php echo isset($item['ccbm_amount_nogst'])?$item['ccbm_amount_nogst']:""; ?> </td>	</tr>							
							<tr><th>Customer Contact </th><td><?php echo isset($details['cc_contact'])?$details['cc_contact']:""; ?> </td><th>Bill No. </th><td><?php echo isset($item['ccbm_billno'])?$item['ccbm_billno']:""; ?> </td><th>GST Amount </th><td><?php echo isset($item['ccbm_gst'])?$item['ccbm_gst']:""; ?> </td></tr>
							<tr><th>Customer Address </th><td><?php echo isset($details['cc_address'])?$details['cc_address']:""; ?> </td><th>Bill Date </th><td><?php echo isset($details['cc_sdate_n'])?$details['cc_sdate_n']:""; ?> </td>
                           <th>Total Bill Amount </th><td><?php echo isset($item['ccbm_amount'])?$item['ccbm_amount']:""; ?> </td>	
                           </tr>
							
							<tr> <th>GST No.</th><td><?php echo isset($details['cc_gstno'])?$details['cc_gstno']:""; ?> </td> <th>Discount </th><td><?php echo isset($item['ccbm_adjustmentamnt'])?$item['ccbm_adjustmentamnt']:""; ?> </td><th>Grand Total </th><td><?php echo isset($item['ccbm_total_amnt'])?$item['ccbm_total_amnt']:""; ?> </td>	</tr>
							<tr><th>Added By </th><td><?php echo isset($details['order_adddebyname'])?$details['order_adddebyname']:""; ?> </td><th>Received Amount </th><td><?php echo isset($item['ccbm_received_amnt'])?$item['ccbm_received_amnt']:""; ?> </td><th>Balance Amount </th><td><?php echo isset($item['ccbm_balance_amnt'])?$item['ccbm_balance_amnt']:""; ?> </td>	</tr>
							</tbody>
							 </table>
						 </div>
						 </div>
						 <?php if(!empty($billDetailList)){ ?>
						<div class="col-md-12">
						<div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-printer"></i>
								  <span class="caption-subject font-red-mint sbold">Bill Item Details
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
						<table class="table table-striped table-bordered table-advance table-hover">
						<tbody>
						<tr><th>Sr.No. </th><th>Item Name </th><th>Rate</th><th>Qty </th><th>CGST  </th><th>CGST P </th><th>Total Amt</th> </tr>
						<?php foreach($billDetailList as $key=>$itemList) {  ?>
							<tr>
							<td><?php echo $key+1; ?> </td>
							<td><?php echo isset($itemList['item_name'])?$itemList['item_name']:""; ?> </td>
							<td><?php echo isset($itemList['ccbd_rate'])?$itemList['ccbd_rate']:""; ?> </td>
							<td><?php echo isset($itemList['ccbd_qty'])?$itemList['ccbd_qty']:""; ?> </td>
							<td><?php echo isset($itemList['ccbd_cgst'])?$itemList['ccbd_cgst']:""; ?> </td>
							<td><?php echo isset($itemList['ccbd_sgst_p'])?$itemList['ccbd_sgst_p']:""; ?> </td>
							
							<td><?php echo isset($itemList['ccbd_saleprice'])?$itemList['ccbd_saleprice']:""; ?> </td>
							
								
							</tr>
						<?php } ?>
						<tr><th colspan="5"> </th><th >Total Amount  </th>
						<th><?php echo isset($item['ccbm_total_amnt'])?$item['ccbm_total_amnt']:""; ?>  </th>  </tr>
					     </tbody>
						</table>
						 </div>
						 <?php } ?>
						 
						 <?php if(!empty($payList)){ //print_r($payList); ?>
						<div class="col-md-12">
						<div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-wallet"></i>
								  <span class="caption-subject font-red-mint sbold">Payment Details
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
						<table class="table table-striped table-bordered table-advance table-hover">
						<tbody>
                        <tr><th>Sr No.</th><th>Bill No.</th><th>Receipt No.</th><th>Payment Mode</th><th>Paid Amount</th><th>Payment Status</th><th>Payment Date</th><th>Payment Remark</th></tr>
                        <?php foreach($payList as $key=>$pay){ ?>
						<tr>
                        <td><?php echo $key+1; ?> </td>	
                        <td><?php echo isset($pay['ccp_billno'])?$pay['ccp_billno']:""; ?> </td>	
                        <td><?php echo isset($pay['ccp_receiptno'])?$pay['ccp_receiptno']:""; ?> </td>	
                        <td><?php echo isset($pay['ccp_paytype'])?$pay['ccp_paytype']:""; ?> </td>	
                        <td><?php echo isset($pay['ccp_amount'])?$pay['ccp_amount']:""; ?> </td>	
                        <td><?php echo isset($pay['ccp_status'])?$pay['ccp_status']:""; ?> </td>	
                        <td><?php echo isset($pay['ccp_sdate_n'])?$pay['ccp_sdate_n']:""; ?> </td>	
                        <td><?php echo isset($pay['ccp_remark'])?$pay['ccp_remark']:""; ?> </td>	
                        </tr>
                        <?php } ?>
					     </tbody>
						</table>
						 </div>
						 <?php } ?>
						 
				
						 
						<div class="form-actions">
						 <div class="col-md-12">
						 <center>
                          <a href="<?php echo get_module_path();?>inventory/print_bill/?ref_id=<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-print"></i>Print Bill</a>
						  <a href="<?php echo get_module_path();?>inventory/download_bill/?ref_id=<?php echo $id; ?>" class="btn btn-success"><i class="fa fa-download"></i>Download Bill</a>
                          <?php if(isset($item['ccbm_balance_amnt']) && ($item['ccbm_balance_amnt'] !=0)){ ?>
                           <a href="<?php echo get_module_path();?>inventory/add_bill_payment/?ref_id=<?php echo $id; ?>" class="btn btn-success" data-toggle="modal" data-target="#form_modal"><i class="fa fa-plus"></i>Add Payment</a>
                          <?php } ?>
                          <a href="<?php echo get_module_path();?>inventory/counter_billing_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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
			<div class="modal-dialog modal-lg">
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