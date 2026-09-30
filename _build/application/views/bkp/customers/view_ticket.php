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
			<li><a href="<?php echo base_url("customers/ticket_report")?>">All Ticket Report </a><i class="fa fa-circle"></i></li>
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
                      <?php //echo "<pre/>"; print_r($details);die;
					  if(!empty($details)){ 
						$id =  base64_encode($details['ticket_id']);
						$details = html_escape($details);
						$ticket_id  = isset($details['ticket_id'])?$details['ticket_id']:"";
						$ticket_title  = isset($details['ticket_title'])?$details['ticket_title']:"";
						$ticket_desc  = isset($details['ticket_desc'])?$details['ticket_desc']:"";
						$ticket_date_n  = isset($details['ticket_date_n'])?$details['ticket_date_n']:"";
						$ticket_time  = isset($details['ticket_time'])?$details['ticket_time']:"";
						$ticket_added_byname  = isset($details['ticket_added_byname'])?$details['ticket_added_byname']:"";
						$tkt_resolved_date  = isset($details['tkt_resolved_date'])?$details['tkt_resolved_date']:"";
						$tkt_closed_date  = isset($details['tkt_closed_date'])?$details['tkt_closed_date']:"";
						$tkt_sdate  = isset($details['tkt_sdate'])?$details['tkt_sdate']:"";
						$ticket_priority  = isset($details['ticket_priority'])?$details['ticket_priority']:"";
						
						$ticketReviewList  = isset($details['ticketReviewList'])?$details['ticketReviewList']:"";
						
						$ticket_detailList  = isset($details['ticket_detailList'])?$details['ticket_detailList']:"";
						
						$clm_name  = isset($details['clm_name'])?$details['clm_name']:"";
						$customer_name  = isset($details['customer_name'])?$details['customer_name']:"";
						
						$customer_address  = isset($details['customer_address'])?$details['customer_address']:"";
						$clm_adress  = isset($details['clm_adress'])?$details['clm_adress']:"";
						
						$clm_contact  = isset($details['clm_contact'])?$details['clm_contact']:"";
						$customer_contact  = isset($details['customer_contact'])?$details['customer_contact']:"";
						
						$status  = isset($details['ticket_status'])?$details['ticket_status']:"";
						$tkt_sdate_n  = isset($details['tkt_sdate_n'])?$details['tkt_sdate_n']:"";
						
						$name    = !empty($clm_name)?$clm_name:$customer_name;
						$contact = !empty($clm_contact)?$clm_contact:$customer_contact;
						$adress  = !empty($clm_adress)?$clm_adress:$customer_address;
						
						
						
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
							<tr><th width="40%">Ticket ID</th><td><?php echo $ticket_id; ?></td>	</tr>
							<tr><th>Ticket Title </th><td><?php echo $ticket_title; ?></td>	</tr>
							<tr><th>Ticket Description </th><td><?php echo $ticket_desc; ?></td>	</tr>
							<tr><th>Ticket Date</th><td><?php echo $ticket_date_n; ?></td>	</tr>
							<tr><th>Ticket Time</th><td><?php echo $ticket_time; ?></td>	</tr>
							<tr><th>Assign Date & Time</th><td><?php echo $tkt_sdate; ?></td>	</tr>
							<tr><th>Resolved Date & Time</th><td><?php echo $tkt_resolved_date; ?></td>	</tr>
							<tr><th>Closed Date & Time </th><td><?php echo $tkt_closed_date; ?></td>	</tr>
							<tr><th>Status </th>
							   <td> <?php  if($status=="Open") { 				  
								  echo "<span class='label label-success'>Open</span>"; 
								  } else if($status=="Closed") {		  
								  echo "<span class='label label-danger'>Closed</span>"; 
								} else { 
								  echo "<span class='label label-warning'>".$status."</span>";
								}    ?> 
								
								</td></tr>
								<tr><th>Priority  </th><td><?php echo $ticket_priority; ?></td></tr>
								<tr><th>Added On </th><td><?php echo $tkt_sdate_n; ?></td></tr>
								<tr><th>Added By </th><td><?php echo $ticket_added_byname; ?></td></tr>
								<?php  if($status=="Deactivated") { ?>
								<tr><th>Deactivated On </th><td><?php echo isset($details['tkt_deactv_date_n'])?$details['tkt_deactv_date_n']:""; ?></td></tr>
								<tr><th>Deactivated By </th><td><?php echo isset($details['tkt_deactv_by_name'])?$details['tkt_deactv_by_name']:""; ?></td></tr>
								<tr><th>Deactivated Reason </th><td><?php echo isset($details['tkt_deactv_rsn'])?$details['tkt_deactv_rsn']:""; ?></td></tr>
								<?php    }    ?> 	
								
								<?php  if($status=="Resolved") { ?>
								<tr><th>Resolved On </th><td><?php echo isset($details['tkt_resolved_date_n'])?$details['tkt_resolved_date_n']:""; ?></td></tr>
								<tr><th>Resolved By </th><td><?php echo isset($details['tkt_resolved_by_name'])?$details['tkt_resolved_by_name']:""; ?></td></tr>
								<?php    }    ?> 
								
									<?php  if($status=="Closed") { ?>
								<tr><th>Closed On </th><td><?php echo isset($details['tkt_closed_date_n'])?$details['tkt_closed_date_n']:""; ?></td></tr>
								<tr><th>Closed By </th><td><?php echo isset($details['tkt_closed_by_name'])?$details['tkt_closed_by_name']:""; ?></td></tr>
								<?php    }    ?> 
						</tbody>
                        </table>
					
						</div>
						</div>
						
					<div class="col-md-6">
					 <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">Customer/Lead Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
                       								   
					   <table class="table table-striped table-bordered table-advance table-hover">	
					   <tbody>
						<tr><th width="50%"> Name </th><td><?php echo $name; ?> </td></tr>
						<tr><th> Contact </th><td><?php echo $contact; ?> </td></tr>
						<tr><th> Address  </th><td><?php echo $adress; ?> </td></tr>
						<tr><th> AMC/Service/Product Start Date : </th><td><?php echo ""; ?> </tr>
						<tr><th> AMC/Service/Product End Date : </th><td><?php echo ""; ?> </tr>
						
						
						</tbody>
                        </table>
					
						</div>
						
						<?php if (!empty($ticket_detailList)){ ?>						
						<div class="col-md-12">
						 <div class="portlet-title">
						        <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-user-following"></i>
								  <span class="caption-subject font-red-mint sbold">Assigned To</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>		
					     <table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr class="success"><th>Sr. No.</th><th>Assigned By</th><th>Assigned To</th><th>Assigned On</th><th>Status</th></tr>
							
							  <?php foreach ($ticket_detailList as $key=>$det){ ?>
							    <tr><td><?php echo $key+1; ?> </td>
								<td><?php echo $det['ticket_update_by_n']; ?> </td>
								<td><?php echo $det['emp_name']; ?></td>
								<td><?php echo $det['tkt_det_sdate_n']; ?></td>				
							   <td>
								  <?php  if($det['updated_status']=="Open") { 				  
								  echo "<span class='label label-success'>Open</span>"; 
								  } else if($det['updated_status']=="Closed") {		  
								  echo "<span class='label label-danger'>Closed</span>"; 
								} else { 
								  echo "<span class='label label-warning'>".$det['updated_status']."</span>";
								}    ?> 
								</td></tr>
							  <?php } ?>
							
							</tbody>
                        </table>
						</div>
						<?php } ?>
						
						<?php if (!empty($ticketReviewList)){ ?>						
						<div class="col-md-12">
						 <div class="portlet-title">
						        <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-notebook"></i>
								  <span class="caption-subject font-red-mint sbold">Review Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>                     			   
					     <table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr class="success"><th >Sr. No.</th><th >Review</th><th>Review Description  </th><th>Updated By</th><th>Updated On</th><th>Status</th></tr>
							<?php foreach ($ticketReviewList as $key=>$rev){ ?>							 
							    <tr><td><?php echo $key+1; ?> </td>
								<td><?php echo $rev['trm_name']; 
								      if(!empty($rev['trm_img_path'])){
										  $image = $rev['trm_img_path'];
										  $image = str_replace("getAuthApiKey",APIKEY,$image);
                                     echo "&nbsp;<a href='".$image."' target='_blank' title='View Attachment'><i class='fa fa-paperclip'></i></a>";
										  } 
								?> 
                                
								</td>
								<td><?php echo $rev['trm_desc']; ?></td>
								<td><?php echo $rev['emp_name']; ?></td>				
								<td><?php echo $rev['trm_sdate_n']; ?></td>				
								<td> <?php  if($rev['trm_status']=="Open") { 				  
								  echo "<span class='label label-success'>Open</span>"; 
								  } else if($rev['trm_status']=="Closed") {		  
								  echo "<span class='label label-danger'>Closed</span>"; 
								} else { 
								  echo "<span class='label label-warning'>".$rev['trm_status']."</span>";
								}    ?> </td>
								
								</tr>
							  <?php } ?>
							
							
							</tbody>
                        </table>
						
						</div>
						<?php } ?>	
						
						
						<div class="col-md-12">			  
						<div class="form-actions ">
						 <div class="col-md-offset-1 col-md-10">  
							<center>					   	
						 <?php if($status=="Open"){ ?>	
						  <a href="<?php echo base_url();?>customers/edit_ticket/?id=<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a> 
						  
						   <?php if($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID){	?>
						  <a href="<?php echo base_url();?>customers/assign_ticket/?id=<?php echo $id; ?>" class="btn btn-success" data-toggle="modal" data-target="#form_modal"><i class="fa fa-user-plus"></i> Assign To</a>
						   <?php } ?>
						
						  <a  class="btn btn-primary"  data-href="<?php echo base_url();?>customers/resolve_ticket/?id=<?php echo $id; ?>" title="Resolve Ticket" data-toggle="modal" data-target="#confirm-resolve"><i class="fa fa-check"></i> Resolve Ticket</a>
						  
						   <a  class="btn btn-danger"  data-href="<?php echo base_url();?>customers/deactivate_ticket/?ref_id=<?php echo $id; ?>" title="Deactivate Ticket" data-toggle="modal" data-target="#confirm-deactivate1"><i class="fa fa-ban"></i> Deactivate Ticket</a>
						 
						  
						 <?php } ?>		
						 
					 <?php if($status=="Resolved"){ ?>
							<a  class="btn btn-danger"  data-href="<?php echo base_url();?>customers/close_ticket/?id=<?php echo $id; ?>" title="Close Ticket" data-toggle="modal" data-target="#confirm-close"><i class="fa fa-close"></i> Close Ticket</a>
							
					  <?php } ?>		
					 
						   <a href="<?php echo base_url();?>customers/ticket_report?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
						   </center>
                        </div>
                        </div>
                        </div>
                        <!-- /.box-body -->
						<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     Ticket Details Not Found !!!
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
                    <a class="btn btn-success btn-resolve" data-toggle="modal" data-target="#form_modal" data-dismiss="modal">Resolve</a>
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
                    <a class="btn btn-danger btn-close" data-toggle="modal" data-target="#form_modal" data-dismiss="modal">Close Ticket</a>
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
                    <a class="btn btn-danger btn-deactivate" data-toggle="modal" data-target="#form_modal"data-dismiss="modal">Deactivate</a>
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