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
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url(get_module()."/masters/sale_product_report")?>">All Product Report  </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-green-sharp  icon-eye"></i>
                  <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
			
			   </div>
            </div>
            <div class="row">
               
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
                 <div class="portlet-body form">
                  <div class="col-md-12">
				  
				       <div class="form-body">
					 <?php if(!empty($details)){
						$details = html_escape($details);  
						$id =  base64_encode($details['pm_id']);
						$status  = $details['pm_status'];
					//echo "<pre/>"; print_r($details);die;
					  ?>
					  
					  
					   
					   <div class="portlet-body">
					    <div class="col-md-12">
                           <div class="portlet-title">
                              <div class="caption">
                                 <i class="icon-picture font-red-mint"></i>
                                 <span class="caption-subject font-red-mint bold uppercase">Product Images</span>
                              </div>
                           </div>
						 	 
						<div class="form-group">
						     <?php $imageList   = $details['imageList']; 
							        $image      = $details['pm_img'];
								    $image      = str_replace("getAuthApiKey",APIKEY,$image); 
							 
							 ?>
                          						
							<ul class="list-unstyled small fileList thumbs">
							<li><a class="fancybox-button" data-rel="fancybox-button" href="<?php echo $image; ?>"><img title="" src="<?php echo $image; ?>" class="img-rounded"><span class="file-name"></span></a></li>
							<?php if(!empty($imageList)) { 
							       foreach($imageList as $imageL) {
								$image      = $imageL['pid_img_path'];
								$image      = str_replace("getAuthApiKey",APIKEY,$image); ?>
							<li><a class="fancybox-button" data-rel="fancybox-button" href="<?php echo $image; ?>"><img title="" src="<?php echo $image; ?>" class="img-rounded"><span class="file-name"></span></a></li>
							<?php } } ?>
							
							</ul>
                        </div>
                        </div>
					   
					   <div class="col-md-6">
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
							<tr><th width="35%"> Product Name </th><td><?php echo isset($details['pm_name'])?$details['pm_name']:""; ?> </td>	</tr>
							<tr><th> Brand Name </th><td><?php echo isset($details['pdt_brnd_name'])?$details['pdt_brnd_name']:""; ?> </td>	</tr>
							<tr><th> Model </th><td><?php echo isset($details['pm_model_name'])?$details['pm_model_name']:""; ?> </td>	</tr>
							<tr><th> Details </th><td><?php echo isset($details['pm_desc'])?$details['pm_desc']:""; ?> </td>	</tr>
							<tr><th> HSN Code </th><td><?php echo isset($details['pm_hsn_code'])?$details['pm_hsn_code']:""; ?> </td>	</tr>
							<tr><th>Warranty Period (in Days) </th><td><?php echo isset($details['pm_warranty_period'])?$details['pm_warranty_period']:""; ?> </td>	</tr>
							<tr><th>No. Of Free Services </th><td><?php echo isset($details['pm_noofserv'])?$details['pm_noofserv']:""; ?> </td>	</tr>
							<tr><th>Service Interval Time (in Days) </th><td><?php echo isset($details['pm_sit'])?$details['pm_sit']:""; ?> </td>	</tr>
							</tbody>
                        </table>
						</div>
						 <div class="col-md-6">
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
						   <tr><th width="40%">Regular Price </th><td><?php echo isset($details['pm_regular_price'])?$details['pm_regular_price']:""; ?> </td>	</tr>
							<tr><th> Commercial Price  </th><td><?php echo isset($details['pm_commercial_price'])?$details['pm_commercial_price']:""; ?> </td>	</tr>
							<tr><th> GST %  </th><td><?php echo isset($details['pm_gst'])?$details['pm_gst']:""; ?> </td>	</tr>
							
						  <tr><th> Added by  </th><td><?php echo isset($details['pm_addedbyname'])?$details['pm_addedbyname']:""; ?> </td>	</tr>
							<tr><th> Added on  </th><td><?php echo isset($details['pm_sdate_n'])?$details['pm_sdate_n']:""; ?> </td>	</tr>
						
							<tr><th>Status </th>
							<td> <?php  if($status=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($status=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								}  ?> </td>
							</tr>
							
					    <?php  if($status=="Deactivated") { ?> 
						<tr><th> Deactivated by </th><td><?php echo isset($details['pm_deactv_byname'])?$details['pm_deactv_byname']:""; ?> </td>	</tr>
						<tr><th> Deactivation date </th><td><?php echo isset($details['pm_deactv_date_n'])?$details['pm_deactv_date_n']:""; ?> </td>	</tr>
						 <?php } ?> 
						 
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
						
										  
						<div class="form-actions ">
						 <div class="col-md-12">
						 <center>
												   	
							 <?php if($status=="Active")	{ ?>	
								
							  <a href="<?php echo get_module_path();?>masters/edit_sale_product/?id=<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>	
														
								<a  data-toggle="modal" data-target="#confirm-deactivate" class="btn btn-danger " data-href="<?php echo get_module_path();?>masters/deactivate_sale_product/?id=<?php echo $id; ?>" title="Deactivate" ><i class="fa fa-ban"></i> Deactivate</a>

							<?php }	?>						
					
							
						  
						   <!-- Added by Anjali on 01/07/26: show Reactivate on the left and Back on the right. -->
						   <?php if($status=="Deactivated") { ?>
						   <!-- <a href="<?php echo get_module_path();?>masters/reactivate_sale_product/?id=<?php echo $id; ?>" class="btn btn-success" onclick="return confirm('Are you sure you want to reactivate this product?');"><i class="fa fa-refresh"></i> Reactivate</a> -->
						   <a href="javascript:void(0)" class="btn btn-success" data-href="<?php echo get_module_path();?>masters/reactivate_sale_product/?id=<?php echo $id; ?>" data-toggle="modal" data-target="#confirm-reactivate"><i class="fa fa-refresh"></i> Reactivate</a>
						   <?php } ?>
						   <a href="<?php echo get_module_path();?>masters/sale_product_report/?history=back&highlight=<?php echo $id; ?>" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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
   </div>   
  <!-- END CONTENT -->
  
  <!-- START MODAL -->
		<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true"  data-backdrop="static">
			<div class="modal-dialog modal-md">
			<div class="modal-content">			
			</div>
			</div>
		</div>	
<!--END START MODAL -->

<!-- Added by Anjali on 01/07/26: product reactivation confirmation popup. -->
<div class="modal fade" id="confirm-reactivate" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-green">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-refresh"></i> Confirm Reactivate</h4>
			</div>
			<div class="modal-body">Are you really want to Reactivate ?</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">CANCEL</button>
				<a class="btn btn-success btn-ok">REACTIVATE</a>
			</div>
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

  $('#confirm-reactivate').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });
  
});
</script>
