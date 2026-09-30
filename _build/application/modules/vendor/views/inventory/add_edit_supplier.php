<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
	<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
	<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
	<li><a href="<?php echo base_url(get_module()."/inventory/supplier_report")?>">All Supplier Report </a><i class="fa fa-circle"></i></li>
	<li><span class="active"><?php echo $page_title; ?></span></li>
	</ul>
            <!--div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint <?php echo $icon ;?> "></i>
                  <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div-->
            <div class="row">
			
               <div class="portlet-body form">
				  <?php if($action=="Edit"){ 
				     //echo "<pre/>"; print_r($details);die; 
				    $details = html_escape($details);
					$formaction = "edit_supplier/?ref_id=".base64_encode($ref_id);
					}else {  $formaction = "add_supplier"; } 
					
					?>
					
                     <form action="<?php echo get_module_path().'inventory/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data">
					  <div class="form-body">
					  <?php if($action=="Edit"){ ?>
					  <input type="hidden" value="<?php echo isset($details['supp_det_id'])?$details['supp_det_id']:set_value("supp_det_id"); ?>" name="supp_det_id" id="supp_det_id" />
					  <?php } ?>
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
										 
                      <div class="col-md-12">
					     <div class="portlet-title">
					            <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-call-out"></i>
								  <span class="caption-subject font-red-mint sbold">Contact Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>
					 		<div class="form-group col-md-3">
                           <label for="p_supp_name">Supplier Name</label> <?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="p_supp_name" name="p_supp_name" type="text" placeholder="Enter Supplier Name" required maxlength="100" value="<?php echo isset($details['supp_name'])?$details['supp_name']:set_value("p_supp_name"); ?>">
						    <?php echo form_error('p_supp_name','<span class="text-danger">','</span>'); ?>
                           </div>
						   <div class="form-group col-md-3">
                           <label for="p_supp_det_mob1">Mobile No.<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_supp_det_mob1" name="p_supp_det_mob1" type="text" placeholder="Enter Mobile No." required maxlength="10" value="<?php echo isset($details['supp_det_mob1'])?$details['supp_det_mob1']:set_value("p_supp_det_mob1"); ?>">
						    <?php echo form_error('p_supp_det_mob1','<span class="text-danger">','</span>'); ?>
                           </div> 
						   <div class="form-group col-md-3">
                           <label for="p_supp_det_mob2">Alternate Mobile No.</label>
						   <input class="form-control" id="p_supp_det_mob2" name="p_supp_det_mob2" type="text" placeholder="Enter Alternate Mobile No."  maxlength="10" value="<?php echo isset($details['supp_det_mob2'])?$details['supp_det_mob2']:set_value("p_supp_det_mob2"); ?>">
						    <?php echo form_error('p_supp_det_mob2','<span class="text-danger">','</span>'); ?>
                           </div>
						   
						   <div class="form-group col-md-3">
                           <label for="p_supp_desc">Supplier Description</label> <?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="p_supp_desc" name="p_supp_desc" type="text" placeholder="Enter Supplier Description" required maxlength="500" value="<?php echo isset($details['supp_desc'])?$details['supp_desc']:set_value("p_supp_desc"); ?>"> 
						    <?php echo form_error('p_supp_desc','<span class="text-danger">','</span>'); ?>
                           </div>
						   <div class="form-group col-md-3">
                           <label for="p_supp_det_emailid">Email Id <?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_supp_det_emailid" name="p_supp_det_emailid" type="text" placeholder="Enter Email Id."  required maxlength="100" value="<?php echo isset($details['supp_det_emailid'])?$details['supp_det_emailid']:set_value("p_supp_det_emailid"); ?>">
						    <?php echo form_error('p_supp_det_emailid','<span class="text-danger">','</span>'); ?>
                        </div>
						   <div class="form-group col-md-3">
                           <label for="p_supp_det_landline">Landline No.</label>
						   <input class="form-control" id="p_supp_det_landline" name="p_supp_det_landline" type="text" placeholder="Enter Landline No." maxlength="15" value="<?php echo isset($details['supp_det_landline'])?$details['supp_det_landline']:set_value("p_supp_det_landline"); ?>">
						    <?php echo form_error('p_supp_det_landline','<span class="text-danger">','</span>'); ?>
                            </div> 
							
							<div class="form-group col-md-3">
                           <label for="p_supp_det_gstno">GST No <?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_supp_det_gstno" name="p_supp_det_gstno" type="text" placeholder="Enter GST No" required maxlength="15" value="<?php echo isset($details['supp_det_gstno'])?$details['supp_det_gstno']:set_value("p_supp_det_gstno"); ?>">
						    <?php echo form_error('p_supp_det_gstno','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-3">
                           <label for="p_supp_det_faxno">Fax No.</label>
						   <input class="form-control" id="p_supp_det_faxno" name="p_supp_det_faxno" type="text" placeholder="Enter Fax No." maxlength="15" value="<?php echo isset($details['supp_det_faxno'])?$details['supp_det_faxno']:set_value("p_supp_det_faxno"); ?>">
						    <?php echo form_error('p_supp_det_faxno','<span class="text-danger">','</span>'); ?>
                            </div>
						<div class="form-group col-md-3">
                           <label for="p_supp_det_panno">PAN No.<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_supp_det_panno" name="p_supp_det_panno" type="text" placeholder="Enter Pan No." maxlength="15" value="<?php echo isset($details['supp_det_panno'])?$details['supp_det_panno']:set_value("p_supp_det_panno"); ?>">
						    <?php echo form_error('p_supp_det_panno','<span class="text-danger">','</span>'); ?>
                            </div>	
						
						<div class="form-group col-md-3">
                           <label for="p_supp_det_otherdet">Other Details</label>
						   <input class="form-control" id="p_supp_det_otherdet" name="p_supp_det_otherdet" type="text" placeholder="Other Details" maxlength="500" value="<?php echo isset($details['supp_det_otherdet'])?$details['supp_det_otherdet']:set_value("p_supp_det_otherdet"); ?>">
						    <?php echo form_error('p_supp_det_otherdet','<span class="text-danger">','</span>'); ?>
                        </div>
					
                        </div>
					  
						 <div class="col-md-12">
						  <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-pointer"></i>
								  <span class="caption-subject font-red-mint sbold">Address Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
						  <div class="form-group col-md-3">
                           <label for="p_supp_det_address">Address <?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_supp_det_address" name="p_supp_det_address" type="text" placeholder="Enter Address" required  maxlength="300" value="<?php echo isset($details['supp_det_address'])?$details['supp_det_address']:set_value("p_supp_det_address"); ?>">
						    <?php echo form_error('p_supp_det_address','<span class="text-danger">','</span>'); ?>
                         </div>
						 
						  <div class="form-group col-md-3"> 
							<label for="p_supp_det_stateid">State <?php echo REQUIRED_STAR; ?> </label>
                            <select class="form-control" id="p_supp_det_stateid" name="p_supp_det_stateid" onchange="get_state_districts(this,'p_supp_det_distid');" required>
							<option value=""> Select State</option>
							 <?php  if(!empty($state_list)){ 
								foreach($state_list as $state){ 
								  $state_id =  isset($details['supp_det_stateid'])?$details['supp_det_stateid']:set_value("p_supp_det_stateid");
								  $selected = $state_id==$state['state_id']?"selected":"";
								
								?>
									<option value="<?php echo $state['state_id'];?>" <?php echo $selected;?> ><?php echo $state['state_name']; ?></option>
							<?php } } ?>	
						   </select>	
                           <?php echo form_error('p_supp_det_stateid','<span class="text-danger">','</span>'); ?>						   
                        </div> 
						<div class="form-group col-md-3">  
						<label for="p_supp_det_distid">District <?php echo REQUIRED_STAR; ?></label>  
                          <select class="form-control" id="p_supp_det_distid" name="p_supp_det_distid" onchange="get_district_cities(this,'p_supp_det_stateid','p_supp_det_cityid');" required>
							<option value=""> Select District</option>
							 <?php  if(!empty($dist_list)){ 
								foreach($dist_list as $dist){ 
								  $dist_id =  isset($details['supp_det_distid'])?$details['supp_det_distid']:set_value("p_supp_det_distid");
								  $selected = $dist_id==$dist['dist_id']?"selected":"";
								
								?>
									<option value="<?php echo $dist['dist_id'];?>" <?php echo $selected;?> ><?php echo $dist['dist_name']; ?></option>
							<?php } } ?>	
						   </select>
							<?php echo form_error('p_supp_det_distid','<span class="text-danger">','</span>'); ?>							   
                        </div>
						<div class="form-group col-md-3">  
						<label for="p_supp_det_cityid">City <?php echo REQUIRED_STAR; ?></label>   
                          <select class="form-control" id="p_supp_det_cityid" name="p_supp_det_cityid"  required>
							<option value=""> Select City</option>
							 <?php  if(!empty($city_list)){ 
								foreach($city_list as $city){ 
								  $city_id =  isset($details['supp_det_cityid'])?$details['supp_det_cityid']:set_value("p_supp_det_cityid");
								  $selected = $city_id==$city['city_id']?"selected":"";
								
								?>
									<option value="<?php echo $city['city_id'];?>" <?php echo $selected;?> ><?php echo $city['city_name']; ?></option>
							<?php } } ?>	
						   </select>
							<?php echo form_error('p_supp_det_cityid','<span class="text-danger">','</span>'); ?>								   
                        </div>
						<div class="form-group col-md-3">
                           <label for="p_supp_det_area">Area</label>
						   <input class="form-control" id="p_supp_det_area" name="p_supp_det_area" type="text" placeholder="Enter Area"  maxlength="100" value="<?php echo isset($details['supp_det_area'])?$details['supp_det_area']:set_value("p_supp_det_area"); ?>">
						    <?php echo form_error('p_supp_det_area','<span class="text-danger">','</span>'); ?>
                           </div>
						<!--div class="form-group col-md-3">
                           <label for="p_supp_det_area">Area</label>
						    <select class="form-control" id="p_supp_det_area" name="p_supp_det_area" >
							<option value=""> Select Area</option>
						    <?php  if(!empty($area_list)){ 
								foreach($area_list as $area){ 
								  $area_id =  isset($details['customer_area'])?$details['customer_area']:set_value("p_supp_det_area");
								  $selected = $area_id==$area['area_id']?"selected":"";
								
								?>
									<option value="<?php echo $area['area_id'];?>" <?php echo $selected;?> ><?php echo $area['area_name']; ?></option>
							<?php } } ?>	
						   </select>
							<?php echo form_error('p_supp_det_area','<span class="text-danger">','</span>'); ?>								   
                         </div-->	
						   <div class="form-group col-md-3">
                           <label for="p_supp_det_pincode">Pincode <?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_supp_det_pincode" name="p_supp_det_pincode" type="text" placeholder="Enter Pincode" required  maxlength="6" value="<?php echo isset($details['supp_det_pincode'])?$details['supp_det_pincode']:set_value("p_supp_det_pincode"); ?>">
						    <?php echo form_error('p_supp_det_pincode','<span class="text-danger">','</span>'); ?>
                         </div>			 
                      

						<div class="form-group col-md-3">
                           <label for="p_supp_contact_det">Contact Person <?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_supp_contact_det" name="p_supp_contact_det" type="text" placeholder="Enter Contact Person" required  maxlength="20" value="<?php echo isset($details['supp_det_contact'])?$details['supp_det_contact']:set_value("p_supp_contact_det"); ?>">
						    <?php echo form_error('p_supp_contact_det','<span class="text-danger">','</span>'); ?>
                         </div>			 
                        </div>
						 
				
						   <div class="form-actions">
						 <div class="col-md-12">
						 <center>						  
                           <button type="submit" class="btn btn-success" >Submit</button>
                          <a href="<?php echo get_module_path();?>inventory/supplier_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
						  </center>
                        </div>
						
                        </div>
						</form>
				
                        <!-- /.box-body -->
                 
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
	
	
	 $('.smart-file').bootstrapFileField({
            maxNumFiles: 8,
            fileTypes: 'image/jpeg,image/png,image/jpg',  
		/* 	minNumFiles:1, */
            maxFileSize: 4000000 // 8Mb in bytes */
        });
	

	
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
			p_supp_name: {
				required: true,
            	maxlength: 100,
                minlength: 2,
				 },
			p_supp_desc: {
				required: true,
            	maxlength: 500,
                minlength: 2,
				 },
			
            p_supp_det_mob1: {
				required: true,
            	maxlength: 10,
                minlength: 10,
				digits:true,
				 }, 
			p_supp_det_mob2: {
				maxlength: 10,
                minlength: 10,
				digits:true,
				 }, 
            p_supp_det_landline: {
            	maxlength: 15,
                digits:true,
				 }, 	 
			p_supp_det_faxno: {
            	maxlength: 15,
                digits:true,
				 }, 	

			p_supp_det_panno: {
				required: true,
				maxlength: 10,
				minlength: 10,
			},

			p_supp_det_address: {
				required: true,
			    maxlength: 300,
                minlength: 2,
				 }, 
				 
            p_supp_det_stateid: {
				required: true,
   				 }, 	
    		p_supp_det_distid: {
				required: true,
   				 }, 
			p_supp_det_cityid: {
				required: true,
   				 }, 
			p_supp_det_area: {
				maxlength: 100,
   				 }, 
			p_supp_det_pincode: {
				required: true,
				maxlength: 6,
                minlength: 6,
				digits:true,
				 }, 
            p_supp_det_emailid: {
			    required: true,
            	maxlength: 100,
                email:true,
				 },  				 
			p_supp_det_gstno: {
				required: true,
            	maxlength: 15,
				gst:true,
                minlength: 2,
				 }, 				 
		    p_supp_det_otherdet: {
            	maxlength: 500,
                minlength: 2,
				 },
			p_supp_contact_det: {
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
        },
		onfocusout: false,
	    invalidHandler: function(form, validator) {
			var errors = validator.numberOfInvalids();
			if (errors) {                    
            validator.errorList[0].element.focus();
			}
		   },
		errorPlacement: function(error, element) {
		   if (element.is(":file")) {
			 error.appendTo((element).parents('.form-group').find('.file_err'));
			}else if (element.is(":checkbox")){ // This is the default behavior of the script for all fields
			error.appendTo("#file_err");
			}else { // This is the default behavior of the script for all fields
			error.insertAfter(element);
			}
			
		},
    });
	

	
    });
	
	
</script>