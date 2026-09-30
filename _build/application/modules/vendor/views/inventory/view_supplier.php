<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
         <div class="portlet light bordered">
		  <ul class="page-breadcrumb breadcrumb">
	<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
	<li><a href="<?php echo base_url(get_module()."/inventory/supplier_report")?>">All Supplier Report </a><i class="fa fa-circle"></i></li>
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
						$id =  base64_encode($details['supp_id']);
						$supp_det_id =  base64_encode($details['supp_det_id']);
						$status    = $details['supp_status'];
						$itemList  = $details['itemList'];
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
							<tr><th>Description</th><td><?php echo isset($details['supp_desc'])?$details['supp_desc']:""; ?> </td>	</tr>
							<tr><th>Email Id</th><td><?php echo isset($details['supp_det_emailid'])?$details['supp_det_emailid']:""; ?> </td>	</tr>
							<tr><th>Landline No.</th><td><?php echo isset($details['supp_det_landline'])?$details['supp_det_landline']:""; ?> </td>	</tr>
							<tr><th>GST No.</th><td><?php echo isset($details['supp_det_gstno'])?$details['supp_det_gstno']:""; ?> </td>	</tr>
							<tr><th>Fax No.</th><td><?php echo isset($details['supp_det_faxno'])?$details['supp_det_faxno']:""; ?> </td>	</tr>
							<tr><th>PAN No.</th><td><?php echo isset($details['supp_det_panno'])?$details['supp_det_panno']:""; ?> </td>	</tr>

							<tr><th>Other Details </th><td><?php echo isset($details['supp_det_otherdet'])?$details['supp_det_otherdet']:""; ?> </td>	</tr>
							<tr><th>Contact Person</th><td><?php echo isset($details['supp_det_contact'])?$details['supp_det_contact']:""; ?> </td>	</tr>
				
							</tbody>
							 </table>
						 </div>
						 </div>
						<div class="col-md-6">
						<div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-pointer"></i>
								  <span class="caption-subject font-red-mint sbold">Address Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
						<table class="table table-striped table-bordered table-advance table-hover">
						<tbody>
						<tr><th width="35%">Address </th><td><?php echo isset($details['supp_det_address'])?$details['supp_det_address']:""; ?> </td>	</tr>
						<tr><th>State </th><td><?php echo isset($details['supp_det_stateid'])?$details['supp_det_stateid']:""; ?> </td>	</tr>
						<tr><th>District </th><td><?php echo isset($details['supp_det_distid'])?$details['supp_det_distid']:""; ?> </td>	</tr>
						<tr><th>City </th><td><?php echo isset($details['supp_det_cityid'])?$details['supp_det_cityid']:""; ?> </td>	</tr>
						<tr><th>Area </th><td><?php echo isset($details['supp_det_area'])?$details['supp_det_area']:""; ?> </td>	</tr>
						<tr><th>Pincode </th><td><?php echo isset($details['supp_det_pincode'])?$details['supp_det_pincode']:""; ?> </td>	</tr>
						<tr><th>Added By </th><td><?php echo isset($details['supp_addedbyname'])?$details['supp_addedbyname']:""; ?> </td>	</tr>
							<tr><th>Added On </th><td><?php echo isset($details['supp_det_sdate_n'])?$details['supp_det_sdate_n']:""; ?> </td>	</tr>
							<tr><th>Status </th>
							<td> <?php  if($status=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($status=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								}  ?> </td>
							</tr>
					 <?php  if(!empty($details['branch_details'])) { 
							$branch_details =  $details['branch_details'];
						   ?>
							<tr><th colspan="2" class="text-danger"> Branch Details</th></tr>	<tr><th> Branch Name </th><td><?php echo isset($branch_details['branch_name'])?$branch_details['branch_name']:""; ?> </td>	</tr>				  
							<tr><th> Branch Contact </th><td><?php echo isset($branch_details['branch_contact'])?$branch_details['branch_contact']:""; ?> </td>	</tr>  
							<tr><th> Branch Address </th><td><?php echo isset($branch_details['branch_address'])?$branch_details['branch_address']:""; ?> </td>	</tr>				  
						 <?php } ?> 					
					     </tbody>
						</table>
						 </div>
						  <?php if(!empty($itemList)){ ?>
						<div class="col-md-10">
						<div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-tag"></i>
								  <span class="caption-subject font-red-mint sbold">Item Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
						<table class="table table-striped table-bordered table-advance table-hover">
						<tbody>
						<tr><th>Sr.No.  </th><th>Item Name  </th><th>Category  </th>
						<th>Brand</th><th>Purchase Price </th><th>Sale Price </th><th>Status </th> </tr>
						<?php foreach($itemList as $key=>$item) {   ?>
							<tr>
							<td><?php echo $key+1; ?> </td>
							<td><?php echo isset($item['item_name'])?$item['item_name']:""; ?> </td>
							<td><?php echo isset($item['inv_cat_name'])?$item['inv_cat_name']:""; ?> </td>
							<td><?php echo isset($item['inv_brand_name'])?$item['inv_brand_name']:""; ?> </td>
							<td><?php echo isset($item['item_price'])?$item['item_price']:""; ?> </td>
							<td><?php echo isset($item['item_price2'])?$item['item_price2']:""; ?> </td>
							<td> <?php  if($item['item_status']=="Active") { 		
       							echo "<span class='label label-success'>Active</span>"; 
								  } else if($item['item_status']=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								} else {  echo "<span class='label label-warning'>".$item['item_status']."</span>";}    ?> </td>
								
								</tr>
								<?php } ?>
								</tbody>
						</table>
						</div>
						<?php } ?>
						<div class="form-actions">
						 <div class="col-md-12">
						 <center>						  
                          <?php  if($status=="Active") { ?>
						     <a href="<?php echo get_module_path();?>inventory/edit_supplier/?ref_id=<?php echo  $id;?>" class="btn btn-primary"><i class="fa fa-pencil"></i>Edit</a>
							 <a  class="btn btn-danger"  data-href="<?php echo get_module_path();?>inventory/deactivate_supplier/?ref_id=<?php echo  $id."&det_id=".$supp_det_id;?>" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i>Deactivate</a>
						  <?php } ?>
                          <a href="<?php echo get_module_path();?>inventory/supplier_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
						  </center>
                        </div>
                        </div>
						
						 </div>
						 
						 
                        <!-- /.box-body -->
                        	<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
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
			<div class="modal-dialog modal-md">
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