<!-- Changes by Shawn Arakal - 10-08-2026 12:02:46 IST -->
<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
      <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-settings font-red-mint"></i>
                     <span class="caption-subject font-blue-madison bold"><?php echo $page_title; ?></span>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="portlet-body">
                        <?php $this->load->helper('form'); ?>
                        <?php if ($this->session->flashdata('error')) { ?>
                           <div class="alert alert-danger alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                              <?php echo $this->session->flashdata('error'); ?>
                           </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('success')) { ?>
                           <div class="alert alert-success alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                              <?php echo $this->session->flashdata('success'); ?>
                           </div>
                        <?php } ?>

                        <p>Connect your external services and APIs.</p>

                        <?php if (empty($integration_list)) { ?>
                           <!-- Changes by Shawn Arakal - 10-08-2026 16:00:45 IST: empty-state text renamed Integrations -> Lead API's -->
                           <div class="alert alert-info">No Lead API's are available right now.</div>
                        <?php } else { ?>
                           <div class="row">
                              <?php foreach ($integration_list as $integration) {
                                 $integration_name    = isset($integration['integration_name']) ? $integration['integration_name'] : '';
                                 $integration_key     = isset($integration['integration_key']) ? $integration['integration_key'] : '';
                                 $integration_source  = isset($integration['integration_source_name']) ? $integration['integration_source_name'] : '';
                                 $integration_desc    = isset($integration['integration_desc']) ? $integration['integration_desc'] : '';
                                 $integration_status  = isset($integration['configured']) ? $integration['configured'] : 'Not Configured';
                                 $integration_fields  = isset($integration['integration_fields']) ? $integration['integration_fields'] : '';
                                 $status_class        = ($integration_status == "Configured") ? "label-success" : "label-warning";
                              ?>
                              <div class="col-md-6">
                                 <div class="portlet light bordered">
                                    <div class="portlet-body">
                                       <h4 class="font-blue-madison bold"><?php echo $integration_name; ?></h4>
                                       <?php if (!empty($integration_source)) { ?>
                                          <p class="font-grey-mint"><?php echo $integration_source; ?></p>
                                       <?php } ?>
                                       <p>Status: <span class="label <?php echo $status_class; ?>"><?php echo $integration_status; ?></span></p>
                                       <?php if (!empty($integration_desc)) { ?>
                                          <p class="font-grey-cascade"><?php echo $integration_desc; ?></p>
                                       <?php } ?>
                                       <a class="btn btn-primary btn-sm" href="<?php echo get_module_path(); ?>admin/configure_integration?key=<?php echo urlencode($integration_key); ?>" title="Configure"><i class="fa fa-gear"></i> Configure</a>
                                    </div>
                                 </div>
                              </div>
                              <?php } ?>
                           </div>
                        <?php } ?>
                        <!-- Changes by Shawn Arakal - 12-08-2026: Meta / Facebook Lead Ads card -->
                        <?php
                           $meta_connected   = isset($meta_status['connected']) ? $meta_status['connected'] : false;
                           $meta_status_text = isset($meta_status['status']) ? $meta_status['status'] : '';
                           if (empty($meta_status_text)) {
                              $meta_status_text = 'NOT CONFIGURED';
                           }
                           $meta_label_class = "label-warning";
                           if ($meta_status_text == 'CONNECTED' || $meta_connected) {
                              $meta_label_class = "label-success";
                           } else if ($meta_status_text == 'ERROR') {
                              $meta_label_class = "label-danger";
                           }
                        ?>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="portlet light bordered">
                                 <div class="portlet-body">
                                    <h4 class="font-blue-madison bold"><i class="fa fa-facebook-official"></i> Facebook / Meta</h4>
                                    <p class="font-grey-mint">Facebook Lead Ads</p>
                                    <p>Status: <span class="label <?php echo $meta_label_class; ?>"><?php echo $meta_status_text; ?></span></p>
                                    <?php if ($meta_connected) { ?>
                                       <?php if (isset($meta_status['page_name']) && !empty($meta_status['page_name'])) { ?>
                                          <p class="font-grey-cascade">Page: <?php echo $meta_status['page_name']; ?></p>
                                       <?php } ?>
                                       <?php if (isset($meta_status['last_sync']) && !empty($meta_status['last_sync'])) { ?>
                                          <p class="font-grey-cascade">Last Sync: <?php echo $meta_status['last_sync']; ?></p>
                                       <?php } ?>
                                    <?php } ?>
                                    <a class="btn btn-primary btn-sm" href="<?php echo get_module_path(); ?>admin/meta_connect" title="Configure"><i class="fa fa-gear"></i> Configure</a>
                                    <button class="btn btn-sm" id="meta_test_btn" type="button"><i class="fa fa-plug"></i> Test Connection</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <script>
                        // Changes by Shawn Arakal - 12-08-2026: Meta / Facebook card AJAX
                        // Changes by Shawn Arakal - 14-08-2026 10:26 IST: Fetch Leads removed
                        // (leads are saved automatically by the backend webhook)
                        // Changes by Shawn Arakal - 14-08-2026: rewritten with vanilla JS +
                        // fetch() because jQuery loads in the footer AFTER this view, so
                        // "jQuery is not defined" prevented the Test Connection button
                        // from working (same pattern as header.php changeBranchBtn fix).
                        (function () {
                           var metaBaseUrl = "<?php echo get_module_path(); ?>";
                           var metaTestBtn = document.getElementById('meta_test_btn');

                           if (metaTestBtn) {
                              metaTestBtn.addEventListener('click', function () {
                                 var btn = metaTestBtn;
                                 btn.disabled = true;
                                 btn.textContent = 'Testing...';

                                 fetch(metaBaseUrl + 'admin/meta_test_connection', {
                                    method: 'POST'
                                 })
                                 .then(function (res) { return res.json(); })
                                 .then(function (response) {
                                    if (response && response.status) {
                                       alert(response.status);
                                    } else {
                                       alert('No response from server');
                                    }
                                    btn.disabled = false;
                                    btn.innerHTML = '<i class="fa fa-plug"></i> Test Connection';
                                 })
                                 .catch(function () {
                                    alert('Error: Please try after some time');
                                    btn.disabled = false;
                                    btn.innerHTML = '<i class="fa fa-plug"></i> Test Connection';
                                 });
                              });
                           }
                        })();
                        </script>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- END PAGE BASE CONTENT -->
   </div>
   <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
