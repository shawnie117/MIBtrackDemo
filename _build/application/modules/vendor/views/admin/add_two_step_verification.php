<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	  <div class="col-md-10">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url(get_module()."/admin/two_step_verification_report")?>">Two Step Verification Report </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
			<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint <?php echo $icon ;?> "></i>
                  <span class="caption-subject font-blue-madison bold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div>
            <div class="row">
			
               <div class="portlet-body form">
				  <?php  $formaction = "add_two_step_verification";  ?>
                     <form action="<?php echo get_module_path().'admin/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
                         <div class="col-md-12">
                         <div class="form-group">
                           <label for="lad_auth">Do you Want to enable Two Step Verification ?</label>
                            <label><input name="lad_auth" type="radio" class="minimal" value="Yes">&nbsp;Yes </label>
                            <label><input name="lad_auth" type="radio" class="minimal" value="No" checked >&nbsp;No	 </label>	 				    
                         </div>  
						 
						 <div class="form-group col-md-6 hidden" id="mobile_no_div">
                           <label for="mobile_no">Mobile No. </label><?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="mobile_no" name="mobile_no" type="text" placeholder="Enter Mobile No." required maxlength="10" value="">
						    <?php echo form_error('mobile_no','<span class="text-danger">','</span>'); ?>
                         </div>   
						  </div>
				
						   <div class="form-actions">
						 <div class="col-md-12">
                            <center>
                           <button class="btn btn-success" id="mybutton" type="submit" >Submit</button>
                          <a href="#" onclick="window.history.go(-1); return false;" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                          </center>
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
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- Form Validation Plugins -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
		
<script type="text/javascript">
// Add Branch

$(document).ready(function() {
	
	$('input[name="lad_auth"]').on('ifClicked', function (event) {
             if(this.value=="Yes"){
				 $('#mobile_no_div').removeClass("hidden");
				
			 } else if(this.value=="No"){
				  $('#mobile_no_div').addClass("hidden");
				 
			 }
        });
		
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
            lad_auth: {
                required: true,
				},		
			mobile_no: {
				required: true,
				maxlength: 10,
                minlength: 10,
				digits:true,
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