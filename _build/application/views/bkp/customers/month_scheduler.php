<?php $role_id = $this->session->userdata('user_role_id');?>
 <!-- BEGIN PAGE LEVEL PLUGINS -->
 <link href="<?php echo get_assets_path(); ?>css/full_calendar_main.css" rel="stylesheet" type="text/css" />
 <link href="<?php echo get_assets_path(); ?>admin_themecss/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
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
               
                  <div class="col-md-12">
				  
				      <?php 
					  if(1==1){
					  //if(!empty($details)){
						/* $details = html_escape($details);  
						$id =  base64_encode($details['emp_id']);
						$status  = $details['emp_status']; */
						//echo "<pre/>"; print_r($details);die;
					  ?>
                 
                            <div class="portlet light portlet-fit bordered calendar">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-calendar font-green"></i>
                                        <span class="caption-subject font-green sbold uppercase"><?php echo $page_title; ?></span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="row">                                      
                                        
                                            <div id="calendar"> </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
					
					
					
			   
                        <!-- /.box-body -->
						<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     Employee Details Not Found !!!
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

<!-- START MODAL -->
		<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog modal-md">
			<div class="modal-content">			
			</div>
			</div>
		</div>	
<!--END START MODAL -->   
  <!-- END CONTENT -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/moment.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/apps/scripts/calendar.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>js/full_calendar_main.js" type="text/javascript"></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      timeZone: 'UTC',
      initialView: 'dayGridMonth',
      events: base_url+"customers/tbl_month_schedular_list",
      editable: true,
      selectable: true,
	  themeSystem: 'bootstrap'
    });

    calendar.render();
  });

</script>

<script type="text/javascript">
$(document).ready(function() {
  $('#confirm-deactivate').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });
$("#form_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    });   
  
});

</script>