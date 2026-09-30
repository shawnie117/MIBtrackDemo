<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url(get_module()."/masters/invoice_tc_report")?>">All Invoice Terms And Conditions </a><i class="fa fa-circle"></i></li>
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
					//echo "<pre/>";print_r($details);
					$formaction = "edit_invoice_tc/?ref_id=".base64_encode($ref_id);
					}else {  $formaction = "add_invoice_tc"; }?>
                     <form action="<?php echo get_module_path().'masters/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					<?php if($action=="Edit"){?>
                           <input type="hidden" name="ref_id" value="<?php echo $ref_id; ?>">
						   <?php } ?>
						 <?php $invoice_tc_header = isset($details['invoice_tc_header'])?$details['invoice_tc_header']:"";
						  $tc_div_class     = "hidden";
						  $footer_div_class = "hidden";
						  if($invoice_tc_header == "Footer")
						  {
							  $footer_div_class= "";
							  
						  } else 
						  {
							  $tc_div_class = "";
						  }
						 ?> 
						<?php if($action=="Add") { ?>						 
						<div class="form-group col-md-12">
                             <label for="terms_hdr">Invoice Terms & Conditions Type </label>
                            <label>&nbsp; &nbsp;<input name="terms_hdr" type="radio" class="minimal" value="T&C" <?php echo $invoice_tc_header=="T&C"?"checked":"checked"; ?>>T&C </label>
                            <label>&nbsp; &nbsp;<input name="terms_hdr" type="radio" class="minimal" value="Footer" <?php echo $invoice_tc_header=="Footer"?"checked":""; ?> >Footer</label>
							<?php echo form_error('terms_hdr','<span class="text-danger">','</span>'); ?>							
                         </div> 
						<?php } ?>
						 <?php if($action=="Edit"){  ?>
						 <div class="form-group col-md-12">
						   <label for="terms_hdr">Type -  </label>
						   <label for="terms_hdr"> <?php echo $invoice_tc_header; ?> </label>
						  <input class="form-control" id="terms_hdr" name="terms_hdr" type="hidden"   maxlength="100" value="<?php echo isset($details['invoice_tc_header'])?$details['invoice_tc_header']:""; ?>">
						   </div> 
						 <?php } ?>
					   <!--div class="col-md-6">
                          <div class="form-group">
                           <label for="terms_hdr">Header</label><?php echo REQUIRED_STAR; ?>
                           <input class="form-control" id="terms_hdr" name="terms_hdr" type="text" placeholder="Enter Header" required  maxlength="100" value="<?php echo isset($details['invoice_tc_header'])?$details['invoice_tc_header']:""; ?>">
						    <?php echo form_error('terms_hdr','<span class="text-danger">','</span>'); ?>
                          </div>
                        </div-->
                    <div class="<?php echo $tc_div_class;?>" id="desc_div">						
					  <div class="col-md-6">
                        <div class="form-group"> 
                            <label for="terms_desc"> Description</label><?php echo REQUIRED_STAR; ?>
							<textarea class="form-control" id="terms_desc" name="terms_desc"  maxlength="500" required  placeholder="Enter Description"><?php echo isset($details['invoice_tc_desc'])?$details['invoice_tc_desc']:""; ?></textarea>						   
                            <?php echo form_error('terms_desc','<span class="text-danger">','</span>'); ?>
                        </div>
                        </div>   
                        </div>   
						
						<div class="<?php echo $footer_div_class;?>" id="footer_div">
						<div class="col-md-6">
                        <div class="form-group"> 
                            <label for="footer1"> Footer1</label>
							<textarea class="form-control" id="footer1" name="footer1"  maxlength="100"   placeholder="Enter Footer1"><?php echo isset($details['invoice_tc_footer1'])?$details['invoice_tc_footer1']:""; ?></textarea>						   
                            <?php echo form_error('footer1','<span class="text-danger">','</span>'); ?>
                        </div>
                        </div>  
						<div class="col-md-6">
                        <div class="form-group"> 
                            <label for="footer2"> Footer2</label>
							<textarea class="form-control" id="footer2" name="footer2"  maxlength="100"   placeholder="Enter Footer2"><?php echo isset($details['invoice_tc_footer2'])?$details['invoice_tc_footer2']:""; ?></textarea>						   
                            <?php echo form_error('footer2','<span class="text-danger">','</span>'); ?>
                        </div>
                        </div>  
						<div class="col-md-6">
                        <div class="form-group"> 
                            <label for="footer3"> Footer3</label>
							<textarea class="form-control" id="footer3" name="footer3"  maxlength="100"   placeholder="Enter Footer3"><?php echo isset($details['invoice_tc_footer3'])?$details['invoice_tc_footer3']:""; ?></textarea>						   
                            <?php echo form_error('footer3','<span class="text-danger">','</span>'); ?>
                        </div>
                        </div>  
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
	$('input[name="terms_hdr"]').on('ifClicked', function (event) {
             if(this.value=="T&C"){
				 $('#footer_div').addClass("hidden");
				 $('#desc_div').removeClass("hidden");
				
			 } else if(this.value=="Footer"){
				  $('#desc_div').addClass("hidden");
				  get_footer_details();
				  $('#footer_div').removeClass("hidden");
				 
			 }
        });
	
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
            terms_hdr: {
                required: true,
				maxlength: 100,
                }, 
			terms_desc: {
                required: true,
				maxlength: 500,
                minlength: 2,
				 }, 
			footer1: {
				maxlength: 100,
                minlength: 2,
				 }, 
			footer2: {
				maxlength: 100,
                minlength: 2,
				 }, 
			footer3: {
				maxlength: 100,
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
	
function get_footer_details()
{ 
   $(".loader").fadeIn();
	$.ajax({
			url:base_url+"ajax/get_footer_details",
			type: "POST",
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
				{		
					var data = JSON.parse(data);
					if(data){
						$("#footer1").val(data.footer1);
						$("#footer2").val(data.footer2);
						$("#footer3").val(data.footer3);
					}
					$(".loader").fadeOut();
					
				}
			});

}
</script>