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
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url("dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url("customers/payment_report")?>">All Payment Report </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
            <!--div class="portlet-title">
               <div class="caption">
                  <i class="font-green-sharp icon-eye"></i>
                  <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
			
			   </div>
            </div-->
            <div class="row">
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
                 <div class="portlet-body">
                      <?php //echo "<pre/>";  print_r($details);die;
					  if(!empty($details)){ 
						$clientList = $details['clientList'];
						$detailList = $details['detailList'];
						$paymentList = $details['paymentList'];
						if(!empty($clientList)){ 
						$clientList = $clientList[0];
					  ?>
                 
					    <div class="col-md-6">
						 <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-book-open"></i>
								  <span class="caption-subject font-red-mint sbold">Ticket Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
                    	 <div class="slimScrollDiv200">						   
					   <table class="table table-striped table-bordered table-advance table-hover">	
						<tbody>
							<tr><th width="40%">Customer Name</th>
							<td><?php echo isset($clientList['customer_name'])?$clientList['customer_name']:""; ?></td>
							</tr>
							<tr><th>Customer Address </th><td><?php echo isset($clientList['customer_address'])?$clientList['customer_address']:""; ?></td>	</tr>
							<tr><th>Customer Contact </th><td><?php echo isset($clientList['customer_contact'])?$clientList['customer_contact']:""; ?></td></tr>
							<tr><th>Customer GST No.</th><td><?php echo isset($clientList['customer_gstno'])?$clientList['customer_gstno']:""; ?></td></tr>
						</tbody>
                        </table>
					
						</div>
						</div>
						
											
						<div class="col-md-6">
						 <div class="portlet-title">
						        <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-check"></i>
								  <span class="caption-subject font-red-mint sbold">OneTime/AMC/Product Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>
                        <?php if (!empty($detailList)){ ?>							   
					     <table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr class="success"><th >Sr. No.</th><th>Product/AMC/One Time</th><th>Qty </th><th>Amount</th></tr>
							<?php foreach ($detailList as $key=>$subserv){ ?>							 
							    <tr><td><?php echo $key+1; ?> </td>
								<td><?php echo $subserv['cbpd_product_type_name']; ?> </td>
								<td><?php echo $subserv['cbpd_qty']; ?></td>
								<td><?php echo $subserv['cbpd_saleprice']; ?></td>				
							
								</tr>
							  <?php } ?>
							
							
							</tbody>
                        </table>
						<?php } ?>	
						</div>
										
						<div class="col-md-12">
						 <div class="portlet-title">
						 <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-wallet"></i>
								  <span class="caption-subject font-red-mint sbold">Payment Details Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>		
					     <table class="table table-condensed table-hover">
							<tbody>
								<tr><th width="20%"> Invoice No  </th><td><?php echo isset($details['cbpm_id'])?$details['cbpm_id']:""; ?> </td>
								<th> Package Amount  </th>
								<td><?php echo isset($details['cbpm_amount'])?$details['cbpm_amount']:""; ?> </td>
								<th> Total Amount  </th>
								<td><?php echo isset($details['cbpm_total_amnt'])?$details['cbpm_total_amnt']:""; ?> </td>
								</tr>
								<tr>								
								
								<th> Received Payment  </th>
								
								<td><?php echo isset($details['cbpm_received_amnt'])?$details['cbpm_received_amnt']:""; ?> </td>
								<th> Balance Payment  </th>
								<td><?php echo isset($details['cbpm_balance_amnt'])?$details['cbpm_balance_amnt']:""; ?> </td>
								
								<th> Discount   </th>
								<td><?php echo isset($details['cbpm_save_price'])?$details['cbpm_save_price']:""; ?> </td>
								
								</tr>							
							</tbody> 
							  </table>
							  
							<?php if (!empty($paymentList)){ ?>		
							<table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr class="success"><th>Sr. No.</th><th>Receipt <br/> No (S/W)</th><th>Bill  <br/>Book No</th><th>Paid Date</th><th>Paid Amt</th><th>Pay  <br/>Mode</th><th>Chq/Card No</th><th>Bank <br/> Details</th><th>Pay  <br/>Remark</th><th>Status</th><th>Chq <br/> Status</th></tr>
							<?php foreach ($paymentList as $key=>$pyment){ ?>							 
							    <tr><td><?php echo $key+1; ?> </td>
								<td><?php echo $pyment['cp_receiptno']; ?> </td>
								<td><?php echo $pyment['cp_uibillno']; ?></td>
								<td><?php echo $pyment['cp_udate_n']; ?></td>				
								<td><?php echo $pyment['cp_amount']; ?></td>
								<td><?php echo $pyment['cp_paytype']; ?></td>
								<td><?php echo $pyment['cp_chq_no']; ?></td>
								<td><?php echo $pyment['cp_bank_details']; ?></td>
								<td><?php echo $pyment['cp_payment_remark']; ?></td>
																
								<td>
								  <?php  if($pyment['cp_status']=="Paid") { 				  
								  echo "<span class='label label-success'>Paid</span>"; 
								  } else if($pyment['cp_status']=="Closed" || $pyment['cp_status']=="Cancel") {		  
								  echo "<span class='label label-danger'>".$pyment['cp_status']."</span>"; 
								} else { 
								  echo "<span class='label label-warning'>".$pyment['cp_status']."</span>";
								}    ?> 
								</td>
								<td>
								  <?php  if($pyment['cp_chq_clear_status']=="Paid") { 				  
								  echo "<span class='label label-success'>Paid</span>"; 
								  } else if($pyment['cp_chq_clear_status']=="Closed" || $pyment['cp_chq_clear_status']=="Cancel") {		  
								  echo "<span class='label label-danger'>".$pyment['cp_chq_clear_status']."</span>"; 
								} else { 
								  echo "<span class='label label-warning'>".$pyment['cp_chq_clear_status']."</span>";
								}    ?> 
								</td>
							
								</tr>
								
							  <?php } ?>
							
							</tbody>
                        </table>
							<?php } ?>
						</div>
					
					  <?php }   ?>
						
												
						<div class="col-md-12">			  
						<div class="form-actions ">
						 <div class="col-md-offset-1 col-md-10">  
							<center>				   	
					
						   <a href="<?php echo base_url();?>customers/payment_report?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
						   </center>
                        </div>
                        </div>
                        </div>
                        <!-- /.box-body -->
						<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     Payment Details Not Found !!!
                  </div>
						<?php } ?>
                   
               </div>
            </div>
         </div>
         <!-- END PAGE BASE CONTENT -->
      </div>
      <!-- END CONTENT BODY -->
   </div>   
   </div>   
  <!-- END CONTENT -->
  
  <!-- START MODAL -->
		
		<div class="modal fade" id="form_modal_lg" tabindex="-1" role="dialog" aria-hidden="true"  >
			<div class="modal-dialog modal-lg">
			<div class="modal-content">			
			</div>
			</div>
		</div>	
		
		<div class="modal fade" id="confirm-resolve" tabindex="-1" role="dialog"  data-backdrop="static" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">            
                <div class="modal-header bg-green-sharp">
                    <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp; Resolve Ticket</h4>
                </div>            
                <div class="modal-body">          
                    <p id="myModalBody">Are you really  Want To Resolve This Ticket ?</p>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-success btn-resolve" data-toggle="modal" data-target="#form_modal">Resolve</a>
                </div>
            </div>
        </div>
         </div>	
		 
		 <div class="modal fade" id="confirm-close" tabindex="-1" role="dialog"  data-backdrop="static" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">            
                <div class="modal-header bg-red-mint">
                    <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp; Close Ticket</h4>
                </div>            
                <div class="modal-body">          
                    <p id="myModalBody">Are you really  Want To Close This Ticket ? </p>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-close" data-toggle="modal" data-target="#form_modal">Close Ticket</a>
                </div>
            </div>
        </div>
         </div>	 
		 
		 <div class="modal fade" id="confirm-deactivate1" tabindex="-1" role="dialog"  data-backdrop="static" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">            
                <div class="modal-header bg-red-mint">
                    <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp; Deactivate Ticket</h4>
                </div>            
                <div class="modal-body">          
                    <p id="myModalBody">Are you really  Want To Deactivate This Ticket ? </p>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-deactivate" data-toggle="modal" data-target="#form_modal">Deactivate</a>
                </div>
            </div>
        </div>
         </div>	
		 
		
		 
		 <div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true"  data-backdrop="static" >
			<div class="modal-dialog modal-md">
			<div class="modal-content">			
			</div>
			</div>
		</div>	
<!--END START MODAL -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	
	$("#form_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    }); 
	$("#form_modal_lg").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    }); 
	
    
  $('#confirm-deactivate1').on('show.bs.modal', function(e) {
            $(this).find('.btn-deactivate').attr('href', $(e.relatedTarget).data('href'));
  });	
   $('#confirm-resolve').on('show.bs.modal', function(e) {
            $(this).find('.btn-resolve').attr('href', $(e.relatedTarget).data('href'));
  });	 
  $('#confirm-close').on('show.bs.modal', function(e) {
            $(this).find('.btn-close').attr('href', $(e.relatedTarget).data('href'));
  });	 
  $('#confirm-cancel').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });	
  
});
</script>