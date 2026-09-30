<?php 
$vendor  = $this->session->userdata('vendor');
$role_id = $vendor['user_role_id'];
$branch_name = isset($branch_name) ? $branch_name : '';
$active = isset($active) ? $active : '';
?>
<!-- BEGIN FOOTER -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="<?php echo get_assets_path(); ?>css/demo-workflow-guide.css">


<div class="page-footer">
    <div class="footer-content">
        <div class="footer-left">
        For Support-Related queries, Please get in touch with us on -: <strong>8356919267</strong> | <strong>8879038139</strong>
           
        </div>
        <div class="footer-right">
        Copyright &copy; <?php echo date("Y")?> 
        <a href="https://www.mauli-infotech.co.in/" target="_blank">Mauli Infotech (OPC) Pvt. Ltd.</a>
        </div>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>


<div class="complaint">
<a href="<?php echo base_url(get_module()."/customers/add_complaint_admin"); ?>">
                        <span><?php echo $branch_name; ?></span>
                        <i class="bi bi-envelope-exclamation" <?php echo $active; ?>></i>
                    </a>

</div>

<div class="faqbox">
<a href="<?php echo base_url(get_module()."/masters/faq_report"); ?>">
                        <span><?php echo $branch_name; ?></span>
                        <i class="icon-question" <?php echo $active; ?>></i>
                    </a>

</div>





<div class="watsbox">
<a id="whatsapp_link" href="#" onclick="redirectToWhatsApp()" style="text-decoration: none;">
    <i class="bi bi-whatsapp" style="font-size: 32px; color: green;"></i>
</a>


    <script>
    function redirectToWhatsApp() {
        const phoneNumber = '7021609390'; // Replace with the actual phone number
        const message = 'Hello!  '; // Optional: you can add a default message
        const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
        
        // Redirect to the WhatsApp link
        window.open(url, '_blank');
    }

    // Enable the link when the page loads
    document.addEventListener('DOMContentLoaded', () => {
        const whatsappLink = document.getElementById('whatsapp_link');
        whatsappLink.style.display = 'block'; // Ensure it's visible on page load
    });
</script>

</div>
<style>
.page-footer {
    background: #f8f9fa;
    padding: 10px 20px;
}

.footer-content {
    display: flex;
    justify-content: space-between; /* Pushes left & right content apart */
    align-items: center;
}

.footer-left {
    text-align: left;
}

.footer-right {
    text-align: right;
}
</style>
<style>
        .watsbox {
            padding: 2px;
            text-align: center;
            position: fixed;
            z-index: 10001;
            bottom: 50px;
            right: 10px;
            display: block; /* Ensure it's set to block */
          
        }
        .bi-whatsapp {
            color: green;
            font-size: 30px;
            color:green;
            opacity: 0.7;
        }




        .faqbox{

            padding: 2px;
            text-align: center;
            position: fixed;
            z-index: 10001;
            bottom: 100px;
            right: 10px;
            display: block; /* Ensure it's set to block */
        }
        .icon-question{
            color: #0804f3;
            font-size: 30px;
            opacity: 0.7;
        }



        .complaint{
            padding: 2px;
            text-align: center;
            position: fixed;
            z-index: 10001;
            bottom: 143px;
            right: 10px;
            display: block; 
        }


        .complaint i{
            color: red;
            font-size: 30px;
            opacity: 0.7;
        }



    </style>

<!-- END FOOTER -->
<!-- <?php if(in_array($role_id,explode(",",CHANGE_BRANCH_ACCESS))){ ?>
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
                    <a href="<?php echo base_url(get_module()."/admin/set_branch_dashboard/?p_branch=".base64_encode($br['branch_id'])); ?>">
                        <span><?php echo $branch_name; ?></span>
                        <i class="icon-shuffle" <?php echo $active; ?>></i>
                    </a>
                </li>
               
			<?php }  ?>	
				
            </ul>
            <span aria-hidden="true" class="quick-nav-bg"></span>
        </nav>
<div class="quick-nav-overlay"></div>
<?php } } ?> -->
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

<?php // Added by Anjali 14/07/26: Loads optional page-specific scripts after all shared JavaScript dependencies. ?>
<?php if (!empty($page_scripts) && is_array($page_scripts)): ?>
    <?php foreach ($page_scripts as $page_script): ?>
        <script src="<?php echo html_escape(get_assets_path() . ltrim($page_script, '/')); ?>" type="text/javascript"></script>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Demo-only connected empty states, prerequisite guidance and action buttons. -->
<script src="<?php echo get_assets_path(); ?>js/demo-workflow-guide.js" type="text/javascript"></script>

</body>
</html>
<?php //$starttime = $this->session->userdata("starttime"); ?>
<?php //$endtime = microtime(true); ?>
<?php //printf("Page loaded in %f seconds", $endtime - $starttime ); ?>
