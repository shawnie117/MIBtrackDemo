<?php $role_id = $this->session->userdata('user_role_id');?>
<!-- BEGIN FOOTER -->
<center>
   <div class="page-footer">
      <div class=""> Copyright &copy; <?php echo date("Y")?> <a href="https://www.mauli-infotech.co.in/">Mauli Infotech (OPC) Pvt. Ltd.</a>
      </div>
      <div class="scroll-to-top">
         <i class="icon-arrow-up"></i>
      </div>
   </div>
</center>
<!-- END FOOTER -->
<?php if(in_array($role_id,explode(",",CHANGE_BRANCH_ACCESS))){ ?>
<?php if(!empty($quick_br_list) && count($quick_br_list)>1){ ?> 
<nav class="quick-nav">
            <a class="quick-nav-trigger" href="#0">
                <span aria-hidden="true"></span>
            </a>
            <ul>
			<?php foreach($quick_br_list as $br){ 
					$branch_name = !empty($br['branch_name'])?$br['branch_name']:$br['branch_id'];
					$branch_id = $this->session->userdata('user_branch_id');
					$active  = ($br['branch_id']==$branch_id)?"style='font-wieght:bold;'":"";
					?>
				
                <li>
                    <a href="<?php echo base_url("admin/set_branch_dashboard/?p_branch=".base64_encode($br['branch_id'])); ?>">
                        <span><?php echo $branch_name; ?></span>
                        <i class="icon-shuffle" <?php echo $active; ?>></i>
                    </a>
                </li>
               
			<?php }  ?>	
				
            </ul>
            <span aria-hidden="true" class="quick-nav-bg"></span>
        </nav>
<div class="quick-nav-overlay"></div>
<?php } } ?>
<!-- START Confirmation Modal  -->
	<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog"  data-backdrop="static" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">            
                <div class="modal-header bg-green-sharp">
                    <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title font-white" id="myModalLabel"> <i class="font-bold icon-check"></i> &nbsp; Confirm Submit</h4>
                </div>            
                <div class="modal-body">          
                    <p id="myModalBody">Are you really want to Submit this Form ?</p>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-success btn-ok">Submit</a>
                </div>
            </div>
        </div>
         </div>
		
		<div class="modal fade" id="confirm-activate" tabindex="-1" role="dialog"  data-backdrop="static" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">            
                <div class="modal-header bg-green-sharp">
                    <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp; Confirm Activate</h4>
                </div>            
                <div class="modal-body">          
                    <p id="myModalBody">Are you really want to Activate ?</p>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-success btn-ok">Activate</a>
                </div>
            </div>
        </div>
         </div>
		 
		
		 
		 <div class="modal fade" id="confirm-deactivate" tabindex="-1" role="dialog"   data-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="modal-content panel panel-danger">            
                <div class="modal-header bg-red-mint">
                    <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title font-white"><i class="font-bold  icon-ban"></i> &nbsp; Confirm Dectivate</h4>
                </div>            
                <div class="modal-body">          
                    <p id="myModalBody"> Are you really want to Dectivate ?</p>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Dectivate</a>
                </div>
            </div>
        </div>
         </div>
<!-- End Confirmation Modal  -->

<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>      
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/scripts/app.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/pages/scripts/dashboard.js" type="text/javascript"></script> 
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo get_assets_path(); ?>admin_theme/pages/scripts/profile.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?php echo get_assets_path(); ?>admin_theme/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
<!-- Form Validation Plugins -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/pages/scripts/form-icheck.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript" class=""></script>
<!--custom validation js-->
<script src="<?php echo get_assets_path(); ?>js/custom.js"></script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/pages/scripts/ui-tree.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/file_upload_jscss/js/bootstrap_file_field.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/moment.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/pages/scripts/components-editors.js" type="text/javascript"></script>


<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/pages/scripts/components-multi-select.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>js/jquery.quicksearch.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-repeater/jquery.repeater.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/pages/scripts/form-repeater.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->



</body>
</html>
<?php $starttime = $this->session->userdata("starttime"); ?>
<?php $endtime = microtime(true); ?>
<?php //printf("Page loaded in %f seconds", $endtime - $starttime ); ?>