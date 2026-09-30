<!-- Changes by Shawn Arakal - 10-08-2026 12:02:46 IST -->
<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
      <div class="row">
         <div class="col-md-8">
            <div class="portlet light bordered">
               <ul class="page-breadcrumb breadcrumb">
                  <li><a href="<?php echo base_url(get_module() . "/dashboard"); ?>">Home</a><i class="fa fa-circle"></i></li>
                  <!-- Changes by Shawn Arakal - 10-08-2026 16:00:45 IST: breadcrumb renamed Integrations -> Lead API's -->
                  <li><a href="<?php echo base_url(get_module() . "/admin/integrations"); ?>">Lead API's</a><i class="fa fa-circle"></i></li>
                  <li><span class="active"><?php echo $page_title; ?></span></li>
               </ul>
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-settings font-red-mint"></i>
                     <span class="caption-subject font-blue-madison bold"><?php echo $page_title; ?></span>
                  </div>
               </div>
               <div class="row">
                  <div class="portlet-body form">
                     <p>
                        Status: <span class="label <?php echo ($integration['configured'] == "Configured") ? "label-success" : "label-warning"; ?>"><?php echo isset($integration['configured']) ? $integration['configured'] : 'Not Configured'; ?></span>
                     </p>
                     <?php $this->load->helper('form'); ?>
                     <?php if (empty($field_list)) { ?>
                        <div class="alert alert-info"><?php echo $integration['integration_name']; ?> configuration fields will be added when the integration is implemented.</div>
                     <?php } else { ?>
                        <form action="<?php echo get_module_path() . 'admin/configure_integration?key=' . urlencode($integration['integration_key']); ?>" id="configure_integration_form" method="post" autocomplete="off">
                           <div class="form-body">
                              <h4 class="font-blue-madison bold">Configuration</h4>
                              <?php foreach ($field_list as $field) {
                                 $field_key   = isset($field['key']) ? $field['key'] : '';
                                 $field_label = isset($field['label']) ? $field['label'] : 'Value';
                                 $field_value = isset($saved_config[$field_key]) ? $saved_config[$field_key] : '';
                                 $input_type  = ($field_key == 'API_KEY') ? 'password' : 'text';
                              ?>
                              <div class="form-group">
                                 <label for="<?php echo $field_key; ?>"><?php echo $field_label; ?></label><?php echo REQUIRED_STAR; ?>
                                 <input class="form-control" id="<?php echo $field_key; ?>" name="<?php echo $field_key; ?>" type="<?php echo $input_type; ?>" placeholder="<?php echo $field_label; ?>" value="<?php echo $input_type == 'password' ? '' : $field_value; ?>" maxlength="500">
                                 <?php echo form_error($field_key, '<span class="text-danger">', '</span>'); ?>
                              </div>
                              <?php } ?>
                           </div>
                           <div class="form-actions">
                              <div class="col-md-offset-3 col-md-9">
                                 <button class="btn btn-success" id="mybutton" type="submit">Save</button>
                                 <a href="<?php echo get_module_path() . 'admin/integrations'; ?>" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                              </div>
                           </div>
                        </form>
                        <script>
                           const button = document.getElementById('mybutton');
                           if (button) {
                              button.addEventListener('click', function () {
                                 setTimeout(function () { button.disabled = true; }, 100);
                              });
                           }
                        </script>
                     <?php } ?>
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
