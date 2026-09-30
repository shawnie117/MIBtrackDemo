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
			<li><a href="<?php echo base_url(get_module()."/masters/invoice_pattern_report")?>">All Invoice Pattern Report </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
            <div class="portlet-title hidden">
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
						$id =  base64_encode($details['invoice_id']);
						$status  = $details['invoice_status'];
						//echo "<pre/>"; print_r($details);die;
					  ?>
					  
					  
					   
					   <div class="portlet-body">
					   
						
					   <div class="col-md-6">
					   <div class="portlet-title">
                              <div class="caption">
                                 <i class="icon-list font-red-mint"></i>
                                 <span class="caption-subject font-red-mint bold uppercase">Invoice Pattern Details</span>
                              </div>
                           </div>
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
							<tr><th> Invoice Pattern </th><td><?php echo isset($details['invoice_pattern'])?$details['invoice_pattern']:""; ?> </td>	</tr>
							
						   <tr><th> Added by  </th><td><?php echo isset($details['invoice_addedby_name'])?$details['invoice_addedby_name']:""; ?> </td>	</tr>
							<tr><th> Added on  </th><td><?php echo isset($details['invoice_sdate_n'])?$details['invoice_sdate_n']:""; ?> </td>	</tr>
						
							<tr><th>Status </th>
							<td> <?php  if($status=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($status=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								} else { echo "<span class='label label-warning'>".$status."</span>";  }   ?> </td>
							</tr>
							
					    <?php  if($status=="Deactivated") { ?> 
						<tr><th> Deactivated by </th><td><?php echo isset($details['invoice_deactvbyname'])?$details['invoice_deactvbyname']:""; ?> </td>	</tr>
						<tr><th> Deactivation date </th><td><?php echo isset($details['invoice_deactvdate_n'])?$details['invoice_deactvdate_n']:""; ?> </td>	</tr>
						 <?php } ?> 
							
							</tbody>
                        </table>
						</div>	
                        <div class="col-md-6">
                           <div class="portlet-title">
                              <div class="caption">
                                 <i class="icon-picture font-red-mint"></i>
                                 <span class="caption-subject font-red-mint bold uppercase">Invoice Pattern Images</span>
                              </div>
                           </div>
						 	 
						<div class="form-group">
						     <?php 
							        $image      = $details['invoice_pattern_img'];
								    $image      = str_replace("getAuthApiKey",APIKEY,$image); 
							 
							 ?>
                          						
							<ul class="list-unstyled small fileList thumbs">
							<li><a class="fancybox-button" data-rel="fancybox-button" href="<?php echo $image; ?>"><img title="" src="<?php echo $image; ?>" class="img-rounded"><span class="file-name"></span></a></li>
							</ul>
                        </div>
                        </div>						
						<div class="form-actions ">
						 <div class="col-md-offset-1 col-md-7">  
							<center>					   	
							 <?php if($status=="Active")	{ ?>	
								
							  <a href="<?php echo get_module_path();?>masters/edit_invoice_pattern/?id=<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>	
														
								<a  data-toggle="modal" data-target="#confirm-deactivate" class="btn btn-danger " data-href="<?php echo get_module_path();?>masters/deactivate_invoice_pattern/?id=<?php echo $id; ?>" title="Deactivate" ><i class="fa fa-ban"></i> Deactivate</a>

							<?php }	?>						
					
							
						  
						   <a href="<?php echo get_module_path();?>masters/invoice_pattern_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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
  
});
</script>