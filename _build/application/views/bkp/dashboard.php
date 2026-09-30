<?php $role_id = $this->session->userdata('user_role_id');?>
<!-- Content Wrapper. Contains page content -->
 <div class="page-content-wrapper">
 <div class="page-content">
               
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <div class="row widget-row">
										
					<?php 
					 $block_list = !empty($header_menu_list[0])?$header_menu_list[0]['dashboardBlockList']:"";
				  // echo "<pre/>"; print_r( $header_menu_list[0]);
										  
						  if(!empty($block_list))
						  {
							  foreach($block_list as $key=>$block){
							  $d_name 		 = $block['d_name'];
							  $icon_color    = array("bg-green","bg-red","bg-purple","bg-blue","bg-green","bg-red","bg-purple","bg-blue");
							   $url = "#";
							   $icon = "icon-layers";
							  if($d_name == "NewCustomer"){ 
							  $icon = "icon-user"; $url = "customers/add_customer";}
							  if($d_name == "NewTicket"){  
							  $icon = "icon-notebook";  $url ="customers/add_ticket"; }
							  if($d_name == "Follow-Up"){  
							  $icon = "icon-call-end"; $url ="customers/followup_report"; }
							  if($d_name == "ComingServices"){  
							  $icon = "icon-bell";  $url ="customers/upcoming_service_report";}
							  if($d_name == "NewComplaint"){  
							  $icon = "icon-question";  $url ="customers/add_complaint"; }
							  if($d_name == "MonthScheduler"){  
							  $icon = "icon-calendar";   $url ="customers/month_scheduler";}
							 
							 $d_name = preg_replace('/(?<!\ )[A-Z]/', ' $0', $d_name);
							 
							  ?>
					
						<div class="col-md-2">
                            <!-- BEGIN WIDGET THUMB -->
                            <a href="<?php echo base_url().$url;?>" style="text-decoration:none;"><div class="widget-thumb widget-bg-color-white margin-bottom-20 bordered">
							  <center>
                                <h5 class="widget-thumb-heading" style="font-size: 12px;"><?php echo $d_name;?></h5>
								
                                <div class="widget-thumb-wrap" >
                                    <i class="widget-thumb-icon <?php echo $icon_color[$key];?> <?php echo $icon;?>" style="margin-left:17px;"></i>
                                    
                                </div>
								 </center>
                            </div></a>
                            <!-- END WIDGET THUMB -->
                        </div>
						
						
						
					<?php		} 
						  } 
					?>
                     
                    </div>
             <div class="row hidden">
			  <?php  if(!empty($branch_list)){ ?> 
			 <form action="<?php echo base_url().'dashboard/set_branch_dashboard'; ?>" id="confirm_branch_form" method="post" autocomplete="off">
						  <div class="form-body">
							<div class="form-group col-md-4">
							  	<select class="form-control" id="p_branch" name="p_branch" onchange="this.form.submit();">
								<option value=""> Select Branch </option>								
								 <?php foreach($branch_list as $branch){ 
										$branch_name = !empty($branch['branch_name'])?$branch['branch_name']:$branch['branch_id'];
										$branch_id = $this->session->userdata('user_branch_id');
										$selected  = ($branch['branch_id']==$branch_id)?"selected":"";
									?>
										<option value="<?php echo $branch['branch_id'];?>" <?php echo $selected;?>><?php echo $branch_name;?></option>
								<?php }  ?>
								 <?php echo form_error('p_branch','<span class="text-danger">','</span>'); ?>
							   </select>
							</div> 	  
						  </div>
				</form>
				<?php } ?>
             </div>
                 
             <div class="row">
			  <?php $reminder_list = $header_menu_list[0]['reminderBlockList'];
			   if(!empty($reminder_list))
						  {
							  foreach($reminder_list as $key=>$reminder){
							  $reminder_name = $reminder['d_name']; 
							  $d_name        = preg_replace('/(?<!\ )[A-Z]/', ' $0', $reminder_name);
							  
							  $icon = "icon-bell";
							/*   if($reminder_name == "LeadApprovalRequests"){$icon = "icon-check";}
							  if($reminder_name == "TodaysFollowUps"){  $icon = "icon-call-in"; }
							  if($reminder_name == "TodaysMyFollowUps"){ $icon = "icon-call-out"; }
							  if($reminder_name == "PaymentDefaulterCustomers"){$icon = "icon-bell"; }
							  if($reminder_name == "RaisedComplaints"){$icon = "icon-bubbles";} 
							   */
							  if($reminder_name == "LeadApprovalRequests"){$icon = "fa fa-check";}
							  if($reminder_name == "TodaysFollowUps"){  $icon = "fa fa-phone"; }
							  if($reminder_name == "TodaysMyFollowUps"){ $icon = "fa fa-phone"; }
							  if($reminder_name == "PaymentDefaulterCustomers"){$icon = "fa fa-bell"; }
							  if($reminder_name == "RaisedComplaints"){$icon = "fa fa-bullhorn";}
							  $icon_color    = array("red-sunglo","green-sharp","red-sunglo","green-sharp","red-sunglo","green-sharp","red-sunglo","green-sharp");
							  
							  
							  
							  ?>
							  
							  
						
						<!-- BEGIN LEAD APPROVAL REQUEST -->		  
						  <?php if($reminder_name == "LeadApprovalRequests" && !empty($lead_approval_list['jsArray'])){ ?> 
						  <div class="col-md-6">
						  <!-- BEGIN PORTLET -->
							<div class="portlet <?php echo $icon_color[$key]; ?> box">
								<div class="portlet-title">
									<div class="caption">
										<i class="<?php echo $icon; ?>"></i> &nbsp;
										<?php echo $d_name;?> ( Total- <?php echo count($lead_approval_list['jsArray']); ?> )
									</div>
									
								</div>
								<div class="portlet-body">
									<!--BEGIN TABS-->
									<div class="tab-content">
										<div class="tab-pane active" class="tab_1_1">
											<div class="slimScrollDiv" >
											
												<ul class="feeds">
												<?php if(!empty($lead_approval_list['jsArray'])){ 
													  foreach($lead_approval_list['jsArray'] as $lead){
														 //echo "<pre/>"; print_r($lead);
														
														 
														 $name 		= $lead['clm_name'];
														 $added_by  = $lead['clm_addedbyname'];
														 $date      = $lead['clm_sdate_n'];
														 $clm_id    = $lead['clm_id'];
														 $id        = base64_encode($lead['clm_id']);
														 $url       = base_url()."leads/reject_lead/?ref_id=$id";
														 $confirm       = base_url()."customers/confirm_lead/?ref_id=$id";
														 $icon  = "fa fa-clock-o";
														 $label = "success";
														 $title = $name." - ".$date." - ".$added_by;
													?> 
													<li>
														<div class="col1">
															<div class="cont">
																<div class="cont-col1">
																	<div class="label label-sm label-<?php echo $label;?>">
																		<i class="<?php echo $icon;?>"></i>
																	</div>
																</div>
																<div class="cont-col2">
																	<a data-id="<?php echo $id; ?>" data-href="<?php echo $url; ?>"
																	data-confirm="<?php echo $confirm; ?>"data-toggle="modal" data-target="#confirm-final"> <div class="desc" title="<?php echo $title; ?>" > <?php echo $title; ?>
																		</a>
																	</div>
																</div>
															</div>
														</div>
														
													</li>
												<?php } } else {  ?>
												<li>No Data Found </li>	

												<?php } ?>
												</ul>
											</div></div>
											<div class="scroller-footer">
                                        <div class="btn-arrow-link pull-right">
                                            <a href="javascript:;">See All Records</a>
                                            <i class="icon-arrow-right"></i>
                                        </div>
                                    </div>
										</div>
									
									</div>
									<!--END TABS-->
								</div>
							</div>
							  <?php } ?>
					 <!-- END LEAD APPROVAL REQUEST -->		  
							  
					 <!-- BEGIN TODAYS FOLLOW-UP -->		  
					 <?php 	 //echo "<pre/>"; print_r($todays_followup_list);	  
					 if($reminder_name == "TodaysFollowUps" && !empty($todays_followup_list['jsArray'])){ ?>		    
						  <div class="col-md-6">
						  <!-- BEGIN PORTLET -->
							<div class="portlet <?php echo $icon_color[$key]; ?> box">
								<div class="portlet-title">
									<div class="caption">
										<i class="<?php echo $icon; ?>"></i> &nbsp;
										<?php echo $d_name;?> ( Total- <?php echo count($todays_followup_list['jsArray']); ?> )
									</div>
									
								</div>
								<div class="portlet-body">
									<!--BEGIN TABS-->
									<div class="tab-content">
										<div class="tab-pane active" class="tab_1_1">
											<div class="slimScrollDiv" >
											
												<ul class="feeds">
												<?php if(!empty($todays_followup_list['jsArray'])){ 
													  foreach($todays_followup_list['jsArray'] as $followup){
														 $name 		   = !empty($followup['clm_name'])?$followup['clm_name']:$followup['customer_name'];
														 $clm_contact  = !empty($followup['clm_contact'])?$followup['clm_contact']:$followup['customer_contact'];
														 $date         = $followup['followup_date_n'];
														$clm_id       = !empty($followup['customer_id'])?$followup['customer_id']:$followup['clm_id']; 
														 
														 $type       = !empty($followup['customer_id'])?"Customer":"Lead";
														 
														 $url   = "#";
														 if(!empty($followup['clm_id']))
														 {
															  $url   = base_url()."leads/view_lead/?history=back&id=".base64_encode($followup['clm_id']);
														 }
														if(!empty($followup['customer_id']))
														 {
															  $url   = base_url()."customers/view_customer/?history=back&id=".base64_encode($followup['customer_id']);
														 }
														 
														 
														 $icon  = "fa fa-phone";
														 $label = "danger";
														$title = $name." - Mob No. - ".$clm_contact." - ".$date." - ".$type;
													?> 
													<li>
														<div class="col1">
															<div class="cont">
																<div class="cont-col1">
																	<div class="label label-sm label-<?php echo $label;?>">
																		<i class="<?php echo $icon;?>"></i>
																	</div>
																</div>
																<div class="cont-col2">
																	<a href="<?php echo $url; ?>"> <div class="desc" title="<?php echo $title; ?>"> <?php echo $title; ?>
																		</a>
																	</div>
																</div>
															</div>
														</div>
														
													</li>
													
													
												<?php } } else {  ?>
												<li>No Data Found </li>	

												<?php } ?>
												</ul>
											</div></div>
											<div class="scroller-footer">
                                        <div class="btn-arrow-link pull-right">
                                            <a href="javascript:;">See All Records</a>
                                            <i class="icon-arrow-right"></i>
                                        </div>
                                    </div>
										</div>
									
									</div>
									<!--END TABS-->
								</div>
							</div>
							  <?php } ?>
							<!-- END TODAYS FOLLOW-UP -->	  
							
							
					<!-- BEGIN MY FOLLOW-UP -->		  
					 <?php 	 //echo "<pre/>"; print_r($my_followup_list);	  
					 if($reminder_name == "TodaysMyFollowUps" && !empty($my_followup_list['jsArray'])){ ?>		    
						  <div class="col-md-6">
						  <!-- BEGIN PORTLET -->
							<div class="portlet <?php echo $icon_color[$key]; ?> box">
								<div class="portlet-title">
									<div class="caption">
										<i class="<?php echo $icon; ?>"></i> &nbsp;
										<?php echo $d_name;?> ( Total- <?php echo count($my_followup_list['jsArray']); ?> )
									</div>
									
								</div>
								<div class="portlet-body">
									<!--BEGIN TABS-->
									<div class="tab-content">
										<div class="tab-pane active" class="tab_1_1">
											<div class="slimScrollDiv" >
											
												<ul class="feeds">
												<?php if(!empty($my_followup_list['jsArray'])){ 
													  foreach($my_followup_list['jsArray'] as $followup){
														 $name 		   = !empty($followup['clm_name'])?$followup['clm_name']:$followup['customer_name'];
														 $clm_contact  = !empty($followup['clm_contact'])?$followup['clm_contact']:$followup['customer_contact'];
														 $date         = $followup['followup_date_n'];
														 $clm_id       = !empty($followup['customer_id'])?$followup['customer_id']:$followup['clm_id']; 
														 
														 $type       = !empty($followup['customer_id'])?"Customer":"Lead";
														 $url   = "#";
														 if(!empty($followup['clm_id']))
														 {
															  $url   = base_url()."leads/view_lead/?history=back&id=".base64_encode($followup['clm_id']);
														 }
														if(!empty($followup['customer_id']))
														 {
															  $url   = base_url()."customers/view_customer/?history=back&id=".base64_encode($followup['customer_id']);
														 }
														
														 $icon  = "fa fa-phone";
														 $label = "success";
														$title  = $name." - Mob No. - ".$clm_contact." - ".$date." - ".$type;
													?> 
													<li>
														<div class="col1">
															<div class="cont">
																<div class="cont-col1">
																	<div class="label label-sm label-<?php echo $label;?>">
																		<i class="<?php echo $icon;?>"></i>
																	</div>
																</div>
																<div class="cont-col2">
																	<a href="<?php echo $url; ?>"> <div class="desc" title="<?php echo $title; ?>"> <?php echo $title; ?>
																		</a>
																	</div>
																</div>
															</div>
														</div>
														
													</li>
													
													
												<?php } } else {  ?>
												<li>No Data Found </li>	

												<?php } ?>
												</ul>
											</div></div>
											<div class="scroller-footer">
                                        <div class="btn-arrow-link pull-right">
                                            <a href="javascript:;">See All Records</a>
                                            <i class="icon-arrow-right"></i>
                                        </div>
                                    </div>
										</div>
									
									</div>
									<!--END TABS-->
								</div>
							</div>
							  <?php } ?>
							<!-- END MY FOLLOW-UP -->	  
							
							
					<!-- BEGIN CHEQUE REMINDER -->		  
					 <?php 	 //echo "<pre/>"; print_r($cheque_reminder_list);	  
					 if($reminder_name == "PaymentDefaulterCustomers1" && !empty($cheque_reminder_list['jsArray'])){ ?>		    
						  <div class="col-md-6">
						  <!-- BEGIN PORTLET -->
							<div class="portlet <?php echo $icon_color[$key]; ?> box">
								<div class="portlet-title">
									<div class="caption">
										<i class="<?php echo $icon; ?>"></i> &nbsp;
									<?php echo $d_name;?> ( Total- <?php echo count($cheque_reminder_list['jsArray']); ?> )
									</div>
									
								</div>
								<div class="portlet-body">
									<!--BEGIN TABS-->
									<div class="tab-content">
										<div class="tab-pane active" class="tab_1_1">
											<div class="slimScrollDiv" >
											
												<ul class="feeds">
												<?php if(!empty($cheque_reminder_list['jsArray'])){ 
													  foreach($cheque_reminder_list['jsArray'] as $cheque_reminder){
														
														 
														 $cp_id      = $cheque_reminder['cp_id'];
														 $name       = $cheque_reminder['customer_name'];
														 $contact    = $cheque_reminder['customer_contact'];
														 $cp_amount      = $cheque_reminder['cp_amount'];
														 $cp_chq_date_n  = $cheque_reminder['cp_chq_date_n'];
														 
														 $url   = "#";
														 $icon  = "fa fa-phone";
														 $label = "success";
														 $title = $name." - Mob No. - ".$contact." - Amount - ".$cp_amount." - ".$cp_chq_date_n;
													?> 
													<li>
														<div class="col1">
															<div class="cont">
																<div class="cont-col1">
																	<div class="label label-sm label-<?php echo $label;?>">
																		<i class="<?php echo $icon;?>"></i>
																	</div>
																</div>
																<div class="cont-col2">
																	<a href="<?php echo $url; ?>"> <div class="desc" title="<?php echo $title; ?>"> <?php echo $title; ?>
																		</a>
																	</div>
																</div>
															</div>
														</div>
														
													</li>
													
													
												<?php } } else {  ?>
												<li>No Data Found </li>	

												<?php } ?>
												</ul>
											</div></div>
											<div class="scroller-footer">
                                        <div class="btn-arrow-link pull-right">
                                            <a href="javascript:;">See All Records</a>
                                            <i class="icon-arrow-right"></i>
                                        </div>
                                    </div>
										</div>
									
									</div>
									<!--END TABS-->
								</div>
							</div>
							  <?php } ?>
							<!-- END CHEQUE REMINDER -->	  
							
							
					<!-- BEGIN CHEQUE REMINDER -->		  
					 <?php 	//echo "<pre/>"; print_r($balance_list);	  
					 if($reminder_name == "PaymentDefaulterCustomers" && !empty($balance_list)){ ?>		    
						  <div class="col-md-6">
						  <!-- BEGIN PORTLET -->
							<div class="portlet <?php echo $icon_color[$key]; ?> box">
								<div class="portlet-title">
									<div class="caption">
										 <i class="fa">&#xf156;</i>&nbsp;
										<?php echo $d_name;?> ( Total- <?php echo count($balance_list); ?> )
									</div>
									
								</div>
								<div class="portlet-body">
									<!--BEGIN TABS-->
									<div class="tab-content">
										<div class="tab-pane active" class="tab_1_1">
											<div class="slimScrollDiv" >
											
												<ul class="feeds">
												<?php if(!empty($balance_list)){ 
													  foreach($balance_list as $balance){
														
														 
														 $cbpm_id         = $balance['cbpm_id'];
														 $name            = $balance['customer_name'];
														 $cbpm_total_amnt = $balance['cbpm_total_amnt'];
														 $cbpm_sdate_n    = $balance['cbpm_sdate_n'];
														 
														 $url   = "#";
														 $icon  = "fa fa-bell";
														 $label = "danger";
														 $title =  $name." - Has Balance Amt -  ".$cbpm_total_amnt." - (".$cbpm_sdate_n." ) ";
													?> 
													<li>
														<div class="col1">
															<div class="cont">
																<div class="cont-col1">
																	<div class="label label-sm label-<?php echo $label;?>">
																		<i class="<?php echo $icon;?>"></i>
																	</div>
																</div>
																<div class="cont-col2">
																	 <div class="desc" title="<?php echo $title ;?>"> <?php echo $title ;?>
																		
																	</div>
																</div>
															</div>
														</div>
														
													</li>
													
													
												<?php } } else {  ?>
												<li>No Data Found </li>	

												<?php } ?>
												</ul>
											</div></div>
										</div>
									<div class="scroller-footer">
                                        <div class="btn-arrow-link pull-right">
                                            <a href="javascript:;">See All Records</a>
                                            <i class="icon-arrow-right"></i>
                                        </div>
                                    </div>
									
									
									</div>
									<!--END TABS-->
								</div>
							</div>
							  <?php } ?>
							<!-- END CHEQUE REMINDER -->	  
							
							  
				<?php } } ?>
				
				<!-- END PORTLET -->
		
			</div>       <!-- END PORTLET-->
   </div>
                    
 </div>
 <!-- END PAGE BASE CONTENT -->
 </div>
  </div>
  <!-- /.content-wrapper -->
   <div class="modal fade" id="confirm-final" tabindex="-1" role="dialog"  data-backdrop="static" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">            
                <div class="modal-header bg-green-sharp">
                    <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp; Confirm Lead</h4>
                </div>            
                <div class="modal-body">          
                    <p id="myModalBody">Are You Sure You Want To Confirm This Lead?</p>
                </div>                
                <div class="modal-footer">
                   
                    <a class="btn btn-success btn-confirm" >Confirm</a>
                    <a class="btn btn-danger btn-reject" data-toggle="modal" data-target="#form_modal" data-dismiss="modal" >Reject</a>					
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
         </div>
  
 <!-- START MODAL -->
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
     $('#confirm-final').on('show.bs.modal', function(e) {
            $(this).find('.btn-reject').attr('href', $(e.relatedTarget).data('href'));
            $(this).find('.btn-confirm').attr('href', $(e.relatedTarget).data('confirm'));
    });	
});
</script>