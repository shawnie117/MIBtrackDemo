<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
			
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint icon-envelope "></i>
                  <span class="caption-subject font-blue-madison bold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div>
            <div class="row">
			<center>
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
				  </center>
               <div class="portlet-body form">
				  <?php  $formaction = "send_sms_email";  ?>
                     <form action="<?php echo get_module_path().'admin/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data">
					  <div class="form-body">
                         <div class="col-md-12">
                         <div class="form-group">
                           <label for="em_type">What Do you Want To Send ?</label>
                            <!-- <label><input name="em_type" type="radio" class="minimal" value="Message" checked> SMS&nbsp;</label> -->
                            <!-- <label><input name="em_type" type="radio" class="minimal" value="Email"  > Email&nbsp;</label> -->
							<label><input name="em_type" type="radio" class="minimal" value="WhatsApp"  checked> WhatsApp&nbsp;</label>
							<?php echo form_error('em_type','<span class="text-danger">','</span>'); ?>							
                         </div>  
					<!-- FOR SMS	 -->
						 <!-- <div id="sms_no_div">
						  <div class="form-group col-md-8">
                           <label for="cust_type">Customer Type</label><?php echo REQUIRED_STAR; ?>
                          <label><input type="radio"  name="cust_type" value="Customers" onclick="get_customers_mobile();" /> Customers</label>
                          <label><input type="radio" name="cust_type" value="Leads" onclick="get_leads_mobile();" /> Leads</label>
						  <span class="radio_err" class="text-danger"></span>
						    <?php echo form_error('cust_type','<span class="text-danger">','</span>'); ?>
                         </div>  -->
						  <!-- <div class="form-group col-md-8">
                           <label for="mobile_nos"> Lead/Customer</label><?php echo REQUIRED_STAR; ?>
                           <select class="form-control selectpicker" name="mobile_nos[]" id="mobile_nos" data-live-search="true" multiple>
						   </select>
						    <?php echo form_error('mobile_nos','<span class="text-danger">','</span>'); ?>
                          </div>  -->
							 <!-- <div class="form-group col-md-8">
							   <div class="mt-repeater">
								<div data-repeater-list="group-b">
									<div data-repeater-item="" class="row">
										<div class="col-md-8">
											<label class="control-label">Mobile No.</label>
											<input type="tel" min="10" name="lead_altcontact" placeholder="Mobile No."  pattern="[0-9]{10}" maxlength="10" class="form-control lead_altcontact"> 
										</div>
										<div class="col-md-1">
											<label class="control-label">&nbsp;</label>
											<a href="javascript:;" data-repeater-delete="" class="btn btn-danger">
												<i class="fa fa-close"></i>
											</a>
										</div>
									</div>
								</div>								 -->
								<!-- <a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add pull-right" style="margin-top:-35px;margin-right: 40px;">
									<i class="fa fa-plus"></i></a>
															
								</div>
						    </div>
							<div class="col-md-8 form-group"> 
								<label for="msg"> Message</label><?php echo REQUIRED_STAR; ?>
								<textarea class="form-control" id="msg" name="msg"  maxlength="250"   placeholder="Enter Description"></textarea>						   
								<?php echo form_error('msg','<span class="text-danger">','</span>'); ?>
							</div>	                           
                         </div>   -->
<!-- FOR WHATSAPP -->
						 <div id="wp_no_div">
						  <div class="form-group col-md-12">
                           <label for="cust_type">Customer Type</label><?php echo REQUIRED_STAR; ?>
                          <label><input type="radio"  name="cust_type" value="Customers" onclick="get_customers_mobile1();" /> Customers</label>
                          <label><input type="radio" name="cust_type" value="Leads" onclick="get_leads_mobile1();" /> Leads</label>
						  <span class="radio_err" class="text-danger"></span>
						    <?php echo form_error('cust_type','<span class="text-danger">','</span>'); ?>
                         </div> 

						  <div class="form-group col-md-4">
                           <label for="wpmobile_nos"> Lead/Customer</label><?php echo REQUIRED_STAR; ?>
						 
                           <select class="form-control selectpicker" name="wpmobile_nos[]" id="wpmobile_nos" data-live-search="true" multiple value="Select All">
						   </select>
						    <?php echo form_error('wpmobile_nos','<span class="text-danger">','</span>'); ?>
                          </div> 
							 <!-- <div class="form-group col-md-4"> -->
							   <div class="mt-repeater">
								<div data-repeater-list="group-w">
									<div data-repeater-item="" class="row">
										<!-- <div class="col-md-8"> -->
											<!-- <label class="control-label">Whats App Mobile No.</label>
											<input type="tel" min="10" name="wpcontact" placeholder="Mobile No."  pattern="[0-9]{10}" maxlength="10" class="form-control wpcontact">  -->
										<!-- </div> -->
										<!-- <div class="col-md-2"> -->
											<!-- <label class="control-label">&nbsp;</label> -->
											<!-- <a href="javascript:;" data-repeater-delete="" class="btn btn-danger">
												<i class="fa fa-close"></i>
											</a> -->
										<!-- </div> -->
									<!-- </div> -->
								</div>		
										
								<!-- <a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add pull-right" >
									<i class="fa fa-plus"></i></a> -->
								
								</div>
								<div class="col-md-4 form-group"> 
								<label for="wpmsg">Whats App Message</label><?php echo REQUIRED_STAR; ?>
								<textarea class="form-control" id="wpmsg" name="wpmsg"  maxlength="1000"   placeholder="Enter Description"></textarea>						   
								<?php echo form_error('wpmsg','<span class="text-danger">','</span>'); ?>
							</div>	 

							
						    </div>
							<div class="col-md-2">
							<label for="wp_noti_img">WhatsApp Image</label>
							<input type="file" name="wp_noti_img" id="wp_noti_img"
							class="smart-file" data-label="WhatsApp Image" 
							data-btn-class="btn btn-default btn-sm"
							data-preview="on" data-file-types="image/jpeg,image/png,image/jpg" accept="image/*" />
							<?php echo form_error('wp_noti_img','<span class="text-danger">','</span>'); ?>
						
							</div>       
                         </div>  
			
<!-- FOR EMAIL -->
						 <div class="hidden" id="email_no_div">
						   <div class="form-group col-md-12">
                           <label for="ecust_type">Customer Type</label><?php echo REQUIRED_STAR; ?>
                          <label><input type="radio" name="ecust_type" value="Customers" onclick="get_customers_email();" /> Customers</label>
                          <label><input type="radio" name="ecust_type" value="Leads" onclick="get_leads_email();" /> Leads</label>
						  <span class="radio_err" class="text-danger"></span>
						    <?php echo form_error('ecust_type','<span class="text-danger">','</span>'); ?>
                         </div> 
						  <div class="form-group col-md-4">
                           <label for="email_ids"> Lead/Customer</label><?php echo REQUIRED_STAR; ?>
                           <select class="form-control selectpicker" name="email_ids[]" id="email_ids" data-live-search="true" multiple>
						   </select>
						    <?php echo form_error('email_ids','<span class="text-danger">','</span>'); ?>
                          </div> 
						
						  <!-- <div class="form-group col-md-8">
							   <div class="mt-repeater">
								<div data-repeater-list="group-c">
									<div data-repeater-item="" class="row">
										<div class="col-md-8">
											<label class="control-label">Email Id</label>
											<input type="email" name="lead_altemail" placeholder="Email Id" maxlength="100" class="form-control lead_altemail"> 
										</div>
										<div class="col-md-1">
											<label class="control-label">&nbsp;</label>
											<a href="javascript:;" data-repeater-delete="" class="btn btn-danger">
												<i class="fa fa-close"></i>
											</a>
										</div>
									</div>
								</div>								 
								<a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add pull-right" style="margin-top:-35px;margin-right: 40px;">
									<i class="fa fa-plus"></i></a>
															
								</div>
						    </div> -->
						 <div class="form-group col-md-4">
                           <label for="email_sub">Subject</label><?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="email_sub" name="email_sub" type="text" placeholder="Enter Email Subject"  maxlength="100" value="">
						    <?php echo form_error('email_sub','<span class="text-danger">','</span>'); ?>
                         </div> 
                          <div class="col-md-5">
							<div class="form-group"> 
								<label for="email_msg"> Message</label><?php echo REQUIRED_STAR; ?>
								<textarea class="form-control" id="email_msg" name="email_msg"  maxlength="250"   placeholder="Enter Message"></textarea>						   
								<?php echo form_error('email_msg','<span class="text-danger">','</span>'); ?>
							</div>
							</div>		
					 	
					 

					
					</div>
						   <div class="form-actions">
						 <div class="col-md-12">
							<center>
                           <button class="btn btn-success" id="mybutton" type="submit" >Submit</button>
                          <a href="#" onclick="window.history.go(-1); return false;" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
						  <center>
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
	
	$('input[name="em_type"]').on('ifClicked', function (event) {
             if(this.value=="Message"){
				 $('#email_no_div').addClass("hidden");
				 $('#wp_no_div').addClass("hidden");
				 $('#sms_no_div').removeClass("hidden");
				
			 } else if(this.value=="Email"){
				  $('#sms_no_div').addClass("hidden");
				  $('#wp_no_div').addClass("hidden");
				  $('#email_no_div').removeClass("hidden");
				 
			 }else if(this.value=='WhatsApp'){
				$('#email_no_div').addClass("hidden");
				$('#sms_no_div').addClass("hidden");
				 $('#wp_no_div').removeClass("hidden");
			 }
        });
		
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
            em_type: {
                required: true,
				},		 
			cust_type: {
                required: true,
				},
			ecust_type: {
                required: true,
				},		
			"mobile_nos[]": {
				required: true,
				maxlength: 1000,
			
				 }, 
			"email_ids[]": {
				required: true,
				maxlength: 5000,
				 },
			           
			msg: {
				maxlength: 500,
                required: true,
				
				 }, 		
			email_sub: {
				maxlength: 100,
                required: true,
				
				 }, 		
			email_msg: {
				maxlength: 500,
                required: true,
				
				 }, 
				 
				 wp_noti_img: {
                   accept: "image/jpeg,image/png,image/jpg",
				  /*  dimention:[250, 350],  */
				   filesize_max:1000000, // 1 MB
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
        },
		onfocusout: false,
	    invalidHandler: function(form, validator) {
			var errors = validator.numberOfInvalids();
			if (errors) {                    
            validator.errorList[0].element.focus();
			}
		   },
		errorPlacement: function(error, element) {
		  if (element.is(":radio")){ 
			 error.appendTo((element).parents('.form-group').find('.radio_err'));
			}else { // This is the default behavior of the script for all fields
			error.insertAfter(element);
			}
			
		},
    });

	$('#wp_noti_img').change(function() {
            $('#wp_noti_img').removeData('imageWidth');
            $('#wp_noti_img').removeData('imageHeight');
            var file = this.files[0];
            var tmpImg = new Image();
            tmpImg.src=window.URL.createObjectURL( file ); 
            tmpImg.onload = function() {
                width = tmpImg.naturalWidth,
                height = tmpImg.naturalHeight;
                $('#wp_noti_img').data('imageWidth', width);
                $('#wp_noti_img').data('imageHeight', height);
            }
        });

    });

function get_customers_mobile()
{ 
   $(".loader").fadeIn();
	$.ajax({
			url:base_url+"ajax/get_customers_mobile",
			type: "POST",
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
				{		
					var data = JSON.parse(data);
					$("#mobile_nos").html(data);
					$("#wpmobile_nos").html(data);
					$(".loader").fadeOut();
					$('.selectpicker').selectpicker('refresh');
				}
			});

}
function get_customers_mobile1()
{ 
   $(".loader").fadeIn();
	$.ajax({
			url:base_url+"ajax/get_customers_mobile",
			type: "POST",
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
				{		
					var data = JSON.parse(data);
					$("#wpmobile_nos").html(data);
					$(".loader").fadeOut();
					$('.selectpicker').selectpicker('refresh');
				}
			});

}
function get_leads_mobile()
{ 
   $(".loader").fadeIn();
	$.ajax({
			url:base_url+"ajax/get_leads_mobile",
			type: "POST",
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
				{		
					var data = JSON.parse(data);
					$("#mobile_nos").html(data);
					$("#wpmobile_nos").html(data);
					$(".loader").fadeOut();
					$('.selectpicker').selectpicker('refresh');
				}
			});

}
function get_leads_mobile1()
{ 
   $(".loader").fadeIn();
	$.ajax({
			url:base_url+"ajax/get_leads_mobile",
			type: "POST",
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
				{		
					var data = JSON.parse(data);
					$("#wpmobile_nos").html(data);
					$(".loader").fadeOut();
					$('.selectpicker').selectpicker('refresh');
				}
			});

}

function get_customers_email()
{ 
   $(".loader").fadeIn();
	$.ajax({
			url:base_url+"ajax/get_customers_email",
			type: "POST",
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
				{		
					var data = JSON.parse(data);
					$("#email_ids").html(data);
					$(".loader").fadeOut();
					$('.selectpicker').selectpicker('refresh');
				}
			});

}
function get_leads_email()
{ 
   $(".loader").fadeIn();
	$.ajax({
			url:base_url+"ajax/get_leads_email",
			type: "POST",
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
				{		
					var data = JSON.parse(data);
					$("#email_ids").html(data);
					$(".loader").fadeOut();
					$('.selectpicker').selectpicker('refresh');
				}
			});

}


	
</script>