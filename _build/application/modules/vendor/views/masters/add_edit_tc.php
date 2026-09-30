<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url(get_module()."/masters/terms_n_conditions_report")?>">All Terms And Conditions </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
			<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint <?php echo $icon ;?> "></i>
                  <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div>
            <div class="row">
			
               <div class="portlet-body form">
				  <?php if($action=="Edit"){ 
				  	$details = html_escape($details);
					$formaction = "edit_terms_n_conditions/?ref_id=".base64_encode($ref_id);
					}else {  $formaction = "add_terms_n_conditions"; }?>
                     <form action="<?php echo get_module_path().'masters/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					<?php if($action=="Edit"){?>
                           <input type="hidden" name="ref_id" value="<?php echo $ref_id; ?>">
						   <?php } ?>
						   
					   <div class="col-md-8">
                          <div class="form-group">
                           <label for="terms_hdr">Header</label><?php echo REQUIRED_STAR; ?>
                           <input class="form-control" id="terms_hdr" name="terms_hdr" type="text" placeholder="Enter Header" required  maxlength="100" value="<?php echo isset($details['tc_header'])?$details['tc_header']:"T&C"; ?>">
						    <?php echo form_error('terms_hdr','<span class="text-danger">','</span>'); ?>
                          </div>
                        </div>	   
					  <div class="col-md-8">
                        <div class="form-group"> 
                            <label for="terms_desc"> Description</label><?php echo REQUIRED_STAR; ?>
							<textarea class="form-control" id="terms_desc" name="terms_desc"  maxlength="500" required  placeholder="Enter Description"><?php echo isset($details['tc_desc'])?$details['tc_desc']:""; ?></textarea>						   
                            <?php echo form_error('terms_desc','<span class="text-danger">','</span>'); ?>
                        </div>
                        </div>  
						  </div>
						   <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" id="mybutton" type="submit" >Submit</button>
                          <a href="#" onclick="window.history.go(-1); return false;" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                        </div>
                        </div>
						</form>
				
                        <!-- /.box-body -->
                        
                        <script>
						const button = document.getElementById('mybutton');

button.addEventListener('click', function() {
    // Clicked button becomes disabled after 1 second
    setTimeout(() => {
        button.disabled = true;
        
        // Re-enable the button after an additional 2 seconds (total of 3 seconds from click)
        setTimeout(() => {
            button.disabled = false;
        }, 1000);
    });
});
</script>
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
   <!-- START MODAL -->
		<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog modal-md">
			<div class="modal-content">			
			</div>
			</div>
		</div>	
<!--END START MODAL -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- Form Validation Plugins -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
		
<script type="text/javascript">
// Add Branch

$(document).ready(function() {
	
	$("#form_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    }); 
	
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
            terms_hdr: {
                required: true,
				maxlength: 100,
                minlength: 2,
				 }, 
			terms_desc: {
                required: true,
				maxlength: 500,
                minlength: 2,
				 }, 
		
		   	},
 
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        }
    });
    });
	
</script>