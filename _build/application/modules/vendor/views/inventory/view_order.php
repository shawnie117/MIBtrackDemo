<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
         <div class="portlet light bordered">
		  <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url(get_module()."/inventory/order_report")?>">All Order Report </a><i class="fa fa-circle"></i></li>
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
                  <?php if(!empty($details)){
						$details = html_escape($details);  
						$id =  base64_encode($details['order_id']);
						$status  = $details['order_status'];
						$orderDetailList  = $details['orderDetailList'];
						$liabilityList  = $details['liabilityList'];
						if(!empty($liabilityList)){ $liabilityList = $liabilityList[0]; }
						$supp_lia_id = $liabilityList['supp_lia_id'];
						//echo "<pre/>"; print_r($details);die;
						
					  ?> 
                    
                  <div class="col-md-12">
			           <div class="portlet-body">
					   <div class="col-md-4">
					     <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-basket"></i>
								  <span class="caption-subject font-red-mint sbold">Order Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
							<tr><th width="45%">Order Id </th><td><?php echo isset($details['order_id'])?$details['order_id']:""; ?> </td>	</tr>							
							<tr><th>Order Date </th><td><?php echo isset($details['order_orderdate'])?$details['order_orderdate']:""; ?> </td>	</tr>
							<tr><th>Remark </th><td><?php echo isset($details['order_remarks'])?$details['order_remarks']:""; ?> </td>	</tr>
							<tr><th>Order Status</th><td><?php echo isset($details['o_status'])?$details['o_status']:""; ?> </td>	</tr>
							  <tr><th>Added By </th><td><?php echo isset($details['order_adddebyname'])?$details['order_adddebyname']:""; ?> </td>	</tr>
							<tr><th>Added On </th><td><?php echo isset($details['order_sdate_n'])?$details['order_sdate_n']:""; ?> </td>	</tr>
							<tr><th>Status </th>
							<td> <?php  if($status=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($status=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								}else {  echo "<span class='label label-warning'>".$status."</span>";}   ?> </td>
							</tr>
							
												
							</tbody>
							 </table>
						 </div>
						 </div>
						 <?php if(!empty($orderDetailList)){ ?>
						<div class="col-md-8">
						<div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-basket"></i>
								  <span class="caption-subject font-red-mint sbold">Order Item Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
						<table class="table table-striped table-bordered table-advance table-hover">
						<tbody>
						<tr><th>Sr.No.  </th><th>Item Name  </th><th>Qty  </th>
						<th>Total Amt</th><th>Status </th><th>Action </th> </tr>
						<?php foreach($orderDetailList as $key=>$itemList) { 
						$item       =  $itemList['itemList'][0];
						$item_name = $item['item_name'];
						$order_id = $itemList['ord_det_orderid'];
						$order_id = base64_encode($order_id);
						$det_id   = $itemList['ord_det_id'];
						$det_id   = base64_encode($det_id);
						  ?>
							<tr>
							<td><?php echo $key+1; ?> </td>
							<td><?php echo $item_name; ?> </td>
							<td><?php echo isset($itemList['ord_det_qty'])?$itemList['ord_det_qty']:""; ?> </td>
							<td><?php echo isset($itemList['ord_det_totamnt'])?$itemList['ord_det_totamnt']:""; ?> </td>
						    <td> <?php  if($itemList['ord_det_status']=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($itemList['ord_det_status']=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								} else {  echo "<span class='label label-warning'>".$itemList['ord_det_status']."</span>";}    ?> </td>
								<td>
								<?php  if($itemList['ord_det_status']=="Active") {  ?>
								<a  class="btn btn-danger btn-xs"  data-href="<?php echo get_module_path();?>inventory/deactivate_order_item/?order_id=<?php echo  $order_id;?>&det_id=<?php echo  $det_id;?>" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i>Deactivate</a>
								<?php } ?>
								</td>
							</tr>
						<?php } ?>
						<tr><th colspan="3">Total Amount  </th>
						<th><?php echo isset($details['order_totamnt'])?$details['order_totamnt']:""; ?>  </th> <th colspan="3"> </th> </tr>
					     </tbody>
						</table>
						 </div>
						 <?php } ?>
						 
						  <?php if(!empty($liabilityList)){ ?>
						   <div class="col-md-10">
					     <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-calculator"></i>
								  <span class="caption-subject font-red-mint sbold">Liability Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
							<tr><th width="45%">Total Amount</th><td><?php echo isset($liabilityList['supp_lia_grand_totamt'])?$liabilityList['supp_lia_grand_totamt']:"0"; ?> </td>	</tr>							
							<tr><th>Amount Received </th><td><?php echo isset($liabilityList['supp_lia_recvd_amt'])?$liabilityList['supp_lia_recvd_amt']:"0"; ?> </td>	</tr>
							<tr><th>Balance Amount </th><td><?php echo isset($liabilityList['supp_lia_bal_amt'])?$liabilityList['supp_lia_bal_amt']:"0"; ?> </td>	</tr>
							<tr><th>Order Id</th><td><?php echo isset($liabilityList['supp_lia_orderid'])?$liabilityList['supp_lia_orderid']:"0"; ?> </td>	</tr>
							
							
												
							</tbody>
							 </table>
						 </div>
						 <?php } ?>
						 
						<div class="form-actions">
						 <div class="col-md-12">
						 <center>						  
                          <?php  if($status=="Active") { ?>
						     <a href="<?php echo get_module_path();?>inventory/edit_order/?ref_id=<?php echo  $id;?>" class="btn btn-primary"><i class="fa fa-pencil"></i>Edit</a>
							 <a  class="btn btn-danger"  data-href="<?php echo get_module_path();?>inventory/deactivate_order/?ref_id=<?php echo  $id;?>" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i>Deactivate</a>
						  <?php } ?>
						    <a href="<?php echo get_module_path();?>inventory/add_payment/?ref_id=<?php echo base64_encode($supp_lia_id); ?>&url=inventory/view_order/?ref_id=<?php echo  $id;?>" class="btn btn-success" data-toggle="modal" data-target="#form_modal"><i class="fa fa-plus"></i>Add Payment</a>
                          <a href="<?php echo get_module_path();?>inventory/order_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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