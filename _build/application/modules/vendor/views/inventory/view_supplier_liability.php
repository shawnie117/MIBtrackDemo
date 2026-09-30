<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
         <div class="portlet light bordered">
		  <ul class="page-breadcrumb breadcrumb">
	<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
	<li><a href="<?php echo base_url(get_module()."/inventory/supplier_liability_report")?>">All Supplier Liability Report </a><i class="fa fa-circle"></i></li>
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
						$id =  base64_encode($details['supp_lia_id']);
						$status    = $details['supp_lia_status'];
						//echo "<pre/>"; print_r($details);die;
					  ?> 
                    
                  <div class="col-md-12">
			           <div class="portlet-body">
					   <div class="col-md-6">
					   <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">Supplier Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
							<tr><th width="45%">Supplier Name </th><td><?php echo isset($details['supp_name'])?$details['supp_name']:""; ?> </td>	</tr>							
							<tr><th>Mobile No. </th><td><?php echo isset($details['supp_det_mob1'])?$details['supp_det_mob1']:""; ?> </td>	</tr>
							<tr><th> Alternate Mobile No. </th><td><?php echo isset($details['supp_det_mob2'])?$details['supp_det_mob2']:""; ?> </td>	</tr>
							<!--tr><th>Description</th><td><?php echo isset($details['supp_desc'])?$details['supp_desc']:""; ?> </td>	</tr-->
							<tr><th>Email Id</th><td><?php echo isset($details['supp_det_emailid'])?$details['supp_det_emailid']:""; ?> </td>	</tr>
							<tr><th>Landline No.</th><td><?php echo isset($details['supp_det_landline'])?$details['supp_det_landline']:""; ?> </td>	</tr>
							<tr><th>GST No.</th><td><?php echo isset($details['supp_det_gstno'])?$details['supp_det_gstno']:""; ?> </td>	</tr>
							<tr><th>Fax No.</th><td><?php echo isset($details['supp_det_faxno'])?$details['supp_det_faxno']:""; ?> </td>	</tr>
							<!--tr><th>Other Details </th><td><?php echo isset($details['supp_det_otherdet'])?$details['supp_det_otherdet']:""; ?> </td>	</tr-->
							<tr><th width="35%">Address </th><td><?php echo isset($details['supp_det_address'])?$details['supp_det_address']:""; ?> </td>	</tr>
							<!--tr><th>State </th><td><?php echo isset($details['supp_det_stateid'])?$details['supp_det_stateid']:""; ?> </td>	</tr>
							<tr><th>District </th><td><?php echo isset($details['supp_det_distid'])?$details['supp_det_distid']:""; ?> </td>	</tr>
							<tr><th>City </th><td><?php echo isset($details['supp_det_cityid'])?$details['supp_det_cityid']:""; ?> </td>	</tr>
							<tr><th>Area </th><td><?php echo isset($details['supp_det_area'])?$details['supp_det_area']:""; ?> </td>	</tr-->
							<tr><th>Pincode </th><td><?php echo isset($details['supp_det_pincode'])?$details['supp_det_pincode']:""; ?> </td>	</tr>
										
							</tbody>
							 </table>
						 </div>
						 </div>
						<div class="col-md-6">
						<div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint  icon-calculator"></i>
								  <span class="caption-subject font-red-mint sbold">Liability Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
						<table class="table table-striped table-bordered table-advance table-hover">
						<tbody>
						<tr><th width="35%">Total Amount </th><td><?php echo isset($details['supp_lia_totalamt'])?$details['supp_lia_totalamt']:""; ?> </td>	</tr>
						<tr><th>GST Amount  </th><td><?php echo isset($details['supp_lia_gst_amt'])?$details['supp_lia_gst_amt']:""; ?> </td>	</tr>
						<tr><th>Received Amount  </th><td><?php echo isset($details['supp_lia_recvd_amt'])?$details['supp_lia_recvd_amt']:""; ?> </td>	</tr>
						<tr><th>Grand Total  Amount</th><td><?php echo isset($details['supp_lia_grand_totamt'])?$details['supp_lia_grand_totamt']:""; ?> </td>	</tr>
						<tr><th>Order Id </th><td><?php echo isset($details['supp_lia_orderid'])?$details['supp_lia_orderid']:""; ?> </td>	</tr>
						<tr><th>Balance Amount </th><td><?php echo isset($details['supp_lia_bal_amt'])?$details['supp_lia_bal_amt']:""; ?> </td>	</tr>
						<tr><th>Added On </th><td><?php echo isset($details['supp_lia_sdate_n'])?$details['supp_lia_sdate_n']:""; ?> </td>	</tr>
						<tr><th>Added By </th><td><?php echo isset($details['supp_lia_addedbyname'])?$details['supp_lia_addedbyname']:""; ?> </td>	</tr>
					    <tr><th>Status </th>
							<td> <?php  if($status=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($status=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								} else { echo "<span class='label label-warning'>".$status."</span>"; }  ?> </td>
							</tr>
					
					     </tbody>
						</table>
						 </div>
					
						<div class="form-actions">
						 <div class="col-md-12">
						 <center>						  
                       
                          <a href="<?php echo get_module_path();?>inventory/add_payment/?ref_id=<?php echo $id; ?>" class="btn btn-success" data-toggle="modal" data-target="#form_modal"><i class="fa fa-plus"></i>Add Payment</a>
                          <a href="<?php echo get_module_path();?>inventory/supplier_liability_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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