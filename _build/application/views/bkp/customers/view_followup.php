<?php $role_id = $this->session->userdata('user_role_id');?>
<div class="page-content-wrapper">	
      <div class="row">
         <div class="portlet light bordered">
		 <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint icon-call-out"></i>
                  <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
               </div>
			   <div class="actions">
			   <button type="button"  class="close" data-dismiss="modal">&times;</button>
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
                 <div class="portlet-body">
                      <?php //echo "<pre/>"; print_r($details);die;
					  if(!empty($details[0]['followupList'])){ 
						$details = html_escape($details[0]['followupList']);
										
					  ?>
										
						<div class="col-md-12">
						
					     <table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr class="success"><th>Sr. No.</th><th width="12%">FollowUp <br/>Date</th><th width="12%">Next FollowUp <br/> Date</th><th width="12%">Next FollowUp<br/>  Time</th><th>FollowUp By</th><th>FollowUp  <br/> Assigned To</th><th>FeedBack</th><th>Status</th></tr>			
							  <?php foreach ($details as $key=>$flw){ ?>
							    <tr><td><?php echo $key+1; ?> </td>
								<td><?php echo $flw['followup_date_n']; ?> </td>
								<td><?php echo $flw['followup_nxt_folldate_n']; ?></td>
								<td><?php echo $flw['followup_nxt_folltime']; ?></td>				
								<td><?php echo $flw['followup_addedby_name']; ?></td>
								<td><?php echo $flw['followup_assignto_name']; ?></td>
								<td><?php echo $flw['followup_feedback']; ?></td>
								<td>
								  <?php  if($flw['followup_status']=="Following") { 				  
								  echo "<span class='label label-success'>Following</span>"; 
								  } else if($flw['followup_status']=="Closed") {		  
								  echo "<span class='label label-danger'>Closed</span>"; 
								} else { 
								  echo "<span class='label label-warning'>".$flw['followup_status']."</span>";
								}    ?> 
								</td></tr>
						
							<?php } ?>
							</tbody>
                        </table>
						</div>
						
                        <!-- /.box-body -->
						<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     Follow-Up Details Not Found !!!
                  </div>
						<?php } ?>
                   
               </div>
            </div>
         </div>
         <!-- END PAGE BASE CONTENT -->
      </div>
      </div>
      <!-- END CONTENT BODY -->