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
			<li><a href="<?php echo base_url("masters/notification_report")?>">All Notifications </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-green-sharp icon-eye"></i>
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
				  
				      <?php //echo "<pre/>"; print_r($notification_details);die;
					  if(!empty($notification_details)){ 
						$id =  base64_encode($notification_details['noti_id']);
						$notification_details = html_escape($notification_details);
						$noti_title  = isset($notification_details['noti_title'])?$notification_details['noti_title']:"";
						$noti_desc  = isset($notification_details['noti_desc'])?$notification_details['noti_desc']:"";
						$status  = isset($notification_details['noti_status'])?$notification_details['noti_status']:"";
						$noti_sdate_n  = isset($notification_details['noti_sdate_n'])?$notification_details['noti_sdate_n']:"";
						$noti_disp_todate_n  = isset($notification_details['noti_disp_todate_n'])?$notification_details['noti_disp_todate_n']:"";
						
						$noti_disp_fromdate_n  = isset($notification_details['noti_disp_fromdate_n'])?$notification_details['noti_disp_fromdate_n']:"";
						$noti_addedby_name  = isset($notification_details['noti_addedby_name'])?$notification_details['noti_addedby_name']:"";
						$noti_deactv_by_name  = isset($notification_details['noti_deactv_by_name'])?$notification_details['noti_deactv_by_name']:"";
						$noti_deactv_date_n  = isset($notification_details['noti_deactv_date_n'])?$notification_details['noti_deactv_date_n']:"";
						$noti_img  = isset($notification_details['noti_img'])?$notification_details['noti_img']:"";
						$noti_det_to_permid  = isset($notification_details['noti_det_to_permid'])?$notification_details['noti_det_to_permid']:"";
						$image                  = str_replace("getAuthApiKey",APIKEY,$noti_img);
					  ?>
                    
					  <div class="form-body">
					
					 
					  
					   
					   <div class="portlet-body">
					    <div class="col-md-6">
					   <table class="table table-striped table-bordered table-advance table-hover">	
						<tbody>
							<tr><th>Title </th><td><?php echo $noti_title; ?></td>	</tr>
							<tr style="word-break:break-all;"><th> Description </th><td><?php echo $noti_desc; ?> </td>	</tr>
							<tr style="word-break:break-all;"><th> Notification From Date </th><td><?php echo $noti_disp_fromdate_n; ?> </td>	</tr>
							<tr style="word-break:break-all;"><th> Notification To Date </th><td><?php echo $noti_disp_todate_n; ?> </td></tr>
							
							<tr><th>Image </th>
							<td><a href="#" class="fancybox-button" data-rel="fancybox-button"><img class="img-responsive" src="<?php echo $image; ?>" alt="<?php echo $noti_title; ?>"> </a>
							</td></tr>
					
						</tbody>
                        </table>
						
						</div>
						
					<div class="col-md-6">
					   <table class="table table-striped table-bordered table-advance table-hover">	
						<tbody>
						<tr><th>Status </th>
							<td> <?php  if($status=="Active") { 				  
											echo "<span class='label label-success'>Active</span>"; 
										} else if($status=="Deactivated") {		  
											echo "<span class='label label-danger'>Deactivated</span>"; 
										}  else { 
										   echo "<span class='label label-warning'>".$status."</span>";
										}    ?> 
							</tr>
						<tr><th>Added By </th><td><?php echo $noti_addedby_name; ?></td></tr>
						<tr><th> Date </th><td><?php echo $noti_sdate_n; ?> </td></tr>
						<?php  if($status=="Deactivated") { ?> 
						<tr><th> Deactivated by </th><td><?php echo $noti_deactv_by_name; ?> </td>	</tr>
						<tr><th> Deactivation date </th><td><?php echo $noti_deactv_date_n; ?> </td>	</tr>
						 <?php } ?> 
						</tbody>
                        </table>
						</div>
						<?php if (!empty($notification_details['notiDetailList'])){ ?>
						<div class="col-md-6">
					   <table class="table table-striped table-bordered table-advance table-hover">	
						<tbody>
						<tr><th>Notification For </th>
						<?php foreach ($notification_details['notiDetailList'] as $notification){ ?>
							<td><?php echo $notification['permission_name']; ?> </td>
						<?php } ?>
							</tr>
									
						</tbody>
                        </table>
						</div>
						
						<?php } ?>
						
						</div>
										  
						<div class="form-actions ">
						 <div class="col-md-offset-1 col-md-7">  
												   	
						 <?php if($status=="Active"){ ?>	
						  <a href="<?php echo base_url();?>masters/edit_notification/?noti_id=<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
						  
						  <a  class="btn btn-danger"  data-href="<?php echo base_url();?>masters/deactivate_notification/?id=<?php echo $id; ?>" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i> Deactivate</a>
						  
						 <?php } ?>						
					
						   <a href="<?php echo base_url();?>masters/notification_report?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                        </div>
                        </div>
						 </div>
					
			   
                        <!-- /.box-body -->
						<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     Notification Details Not Found !!!
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