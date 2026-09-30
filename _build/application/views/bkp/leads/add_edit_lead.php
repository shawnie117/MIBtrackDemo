<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
	<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
	<li><a href="<?php echo base_url("dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
	<li><a href="<?php echo base_url("leads/lead_report")?>">All Leads </a><i class="fa fa-circle"></i></li>
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
				  <?php if($action=="Edit"){  //echo "<pre/>"; print_r($details);die; 
				    $details = html_escape($details);
					$formaction = "edit_lead/?id=".base64_encode($id);
					}else {  $formaction = "add_lead"; } ?>
                     <form action="<?php echo base_url().'leads/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					  
					   <div class="col-md-12"> 
					    <div class="portlet-body">
						  <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">Lead Details</span>
							   </div>
							   <hr style="margin:0px;"/>
						   </div>					   
					  
					    <?php if($action=="Edit"){?>
                           <input type="hidden" name="id" value="<?php echo $id; ?>">
						   <?php } ?>
						   
						 <div class="col-md-4"> 
						 <div class="form-group">
                           <label for="lead_name">Lead Name</label><?php echo REQUIRED_STAR; ?>
                           <input class="form-control" id="lead_name" name="lead_name" type="text" placeholder="Enter Lead Name" required maxlength="50" value="<?php echo isset($details['clm_name'])?$details['clm_name']:set_value("lead_name"); ?>" autofocus>
						    <?php echo form_error('lead_name','<span class="text-danger">','</span>'); ?>
                        </div> 
						<div class="form-group">
                           <label for="lead_desc">Enquiry Details</label>
						   <input class="form-control" id="lead_desc" name="lead_desc" type="text" placeholder="Enter Enquiry Details"  maxlength="500" value="<?php echo isset($details['clm_description'])?$details['clm_description']:set_value("lead_desc"); ?>">
						    <?php echo form_error('lead_desc','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group">
                           <label for="lead_priority">Priority Level </label>
						   <select class="form-control" id="lead_priority" name="lead_priority" >
							<option value=""> Select Priority Level</option>
							 <?php  if(!empty($priority_list )){ 	 						
								foreach($priority_list as $priority){
                                    $priorty =  isset($details['clm_priority_level'])?$details['clm_priority_level']:set_value("lead_priority");
									$selected  = $priority == $priorty?"selected":"";
									?>
									<option value="<?php echo $priority;?>" <?php echo $selected;?>><?php echo $priority; ?></option>
							<?php } } ?>	
						   </select>
						    <?php echo form_error('lead_priority','<span class="text-danger">','</span>'); ?>
                        </div>
						
					
                       </div>
					    <div class="col-md-4"> 
							<div class="form-group">
                           <label for="lead_contact_person">Contact Person</label>
						   <input class="form-control" id="lead_contact_person" name="lead_contact_person" type="text" placeholder="Enter Contact Person"  maxlength="200" value="<?php echo isset($details['clm_contact_person'])?$details['clm_contact_person']:set_value("lead_contact_person"); ?>">
						    <?php echo form_error('lead_contact_person','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group">
                           <label for="website">Website</label>
						   <input class="form-control" id="website" name="website" type="text" placeholder="Enter Website"  maxlength="100" value="<?php echo isset($details['clm_website'])?$details['clm_website']:set_value("website"); ?>">
						    <?php echo form_error('website','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group">
                           <label for="company_name">Company Name</label>
						   <input class="form-control" id="company_name" name="company_name" type="text" placeholder="Enter Company Name"  maxlength="100" value="<?php echo isset($details['clm_company_name'])?$details['clm_company_name']:set_value("company_name"); ?>">
						    <?php echo form_error('company_name','<span class="text-danger">','</span>'); ?>
                        </div>
						
						
						 </div>
					 <div class="col-md-4"> 
						<div class="form-group">
                           <label for="lead_productid">Enquiry For </label>
						   <select class="form-control" id="lead_productid" name="lead_productid" >
							<option value=""> Select Enquiry For</option>
							 <?php  if(!empty($product_list )){ 	 						
								foreach($product_list as $product){
                                    $lead_productid =  isset($details['clm_productid'])?$details['clm_productid']:set_value("lead_productid");
									$selected  = $lead_productid == $product['pm_id']?"selected":"";
									?>
									<option value="<?php echo $product['pm_id'];?>" <?php echo $selected;?>><?php echo $product['pm_name']; ?></option>
							<?php } } ?>	
						   </select>						
						   
						    <?php echo form_error('lead_productid','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group">
                           <label for="pan_no">PAN No</label>
						   <input class="form-control" id="pan_no" name="pan_no" type="text" placeholder="Enter PAN No"  maxlength="10" value="<?php echo isset($details['clm_panno'])?$details['clm_panno']:set_value("pan_no"); ?>">
						    <?php echo form_error('pan_no','<span class="text-danger">','</span>'); ?>
                        </div>
						
						</div>
						
						
						 
                      <div class="col-md-12">
					   <div class="portlet-title">
					           <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-call-out"></i>
								  <span class="caption-subject font-red-mint sbold">Contact Details</span>
							   </div>
							   <hr style="margin:0px;"/>
						   </div>
					 	<div class="form-group col-md-4">
                           <label for="lead_contact">Mobile No.</label>
						   <input class="form-control" id="lead_contact" name="lead_contact" type="text" placeholder="Enter Mobile No." maxlength="10" value="<?php echo isset($details['clm_contact'])?$details['clm_contact']:set_value("lead_contact"); ?>">
						    <?php echo form_error('lead_contact','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-4">
                           <label for="lead_contact_email">Email Id</label>
						   <input class="form-control" id="lead_contact_email" name="lead_contact_email" type="text" placeholder="Enter Email Id." maxlength="100" value="<?php echo isset($details['clm_contact_emailid'])?$details['clm_contact_emailid']:set_value("lead_contact_email"); ?>">
						    <?php echo form_error('lead_contact_email','<span class="text-danger">','</span>'); ?>
                        </div>
						
						<div class="form-group col-md-4">
                           <label for="lead_landline">Landline No.</label>
						   <input class="form-control" id="lead_landline" name="lead_landline" type="text" placeholder="Enter Landline No." maxlength="15" value="<?php echo isset($details['clm_landline'])?$details['clm_landline']:set_value("lead_landline"); ?>">
						    <?php echo form_error('lead_landline','<span class="text-danger">','</span>'); ?>
                        </div>
					
                        </div>
					  
						 <div class="col-md-12">
						  <div class="portlet-title">
						  <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-pointer"></i>
								  <span class="caption-subject font-red-mint sbold">Address Details</span>
							   </div>
							   <hr style="margin:0px;"/>
						   </div>
						

						  <div class="form-group col-md-12">
                           <label for="lead_addrs">Address</label>
						   <input class="form-control" id="lead_addrs" name="lead_addrs" type="text" placeholder="Enter Address"  maxlength="300" value="<?php echo isset($details['clm_address'])?$details['clm_address']:set_value("lead_addrs"); ?>">
						    <?php echo form_error('lead_addrs','<span class="text-danger">','</span>'); ?>
                         </div>	
						
										 
						  <div class="form-group col-md-4"> 
							<label for="lead_stateid">State </label>
                            <select class="form-control" id="lead_stateid" name="lead_stateid" onchange="get_state_districts(this,'lead_distid');">
							<option value=""> Select State</option>
							 <?php  if(!empty($state_list)){ 
								foreach($state_list as $state){ 
								  $state_id =  isset($details['clm_stateid'])?$details['clm_stateid']:set_value("lead_stateid");
								  $selected = $state_id==$state['state_id']?"selected":"";
								
								?>
									<option value="<?php echo $state['state_id'];?>" <?php echo $selected;?> ><?php echo $state['state_name']; ?></option>
							<?php } } ?>	
						   </select>	
                           <?php echo form_error('lead_stateid','<span class="text-danger">','</span>'); ?>						   
                        </div> 
						<div class="form-group col-md-4">  
						<label for="lead_distid">District </label>  
                          <select class="form-control" id="lead_distid" name="lead_distid" onchange="get_district_cities(this,'lead_stateid','lead_cityid');">
							<option value=""> Select District</option>
							 <?php  if(!empty($dist_list)){ 
								foreach($dist_list as $dist){ 
								  $dist_id =  isset($details['clm_distid'])?$details['clm_distid']:set_value("lead_distid");
								  $selected = $dist_id==$dist['dist_id']?"selected":"";
								
								?>
									<option value="<?php echo $dist['dist_id'];?>" <?php echo $selected;?> ><?php echo $dist['dist_name']; ?></option>
							<?php } } ?>	
						   </select>
							<?php echo form_error('lead_distid','<span class="text-danger">','</span>'); ?>							   
                        </div>
						<div class="form-group col-md-4">  
						<label for="lead_cityid">City </label>   
                          <select class="form-control" id="lead_cityid" name="lead_cityid"  onchange="get_city_area(this,'lead_stateid','lead_distid','lead_arealoc');">
							<option value=""> Select City</option>
							 <?php  if(!empty($city_list)){ 
								foreach($city_list as $city){ 
								  $city_id =  isset($details['clm_cityid'])?$details['clm_cityid']:set_value("lead_cityid");
								  $selected = $city_id==$city['city_id']?"selected":"";
								
								?>
									<option value="<?php echo $city['city_id'];?>" <?php echo $selected;?> ><?php echo $city['city_name']; ?></option>
							<?php } } ?>	
						   </select>
							<?php echo form_error('lead_cityid','<span class="text-danger">','</span>'); ?>								   
                        </div>
						<div class="form-group col-md-4">
                           <label for="lead_arealoc">Area</label>
						    <select class="form-control" id="lead_arealoc" name="lead_arealoc" >
							<option value=""> Select Area</option>
						    <?php  if(!empty($area_list)){ 
								foreach($area_list as $area){ 
								  $area_id =  isset($details['clm_areaid'])?$details['clm_areaid']:set_value("lead_arealoc");
								  $selected = $area_id==$area['area_id']?"selected":"";
								
								?>
									<option value="<?php echo $area['area_id'];?>" <?php echo $selected;?> ><?php echo $area['area_name']; ?></option>
							<?php } } ?>	
						   </select>
							<?php echo form_error('lead_arealoc','<span class="text-danger">','</span>'); ?>								   
                         </div>	
                         <div class="form-group col-md-4">
                           <label for="lead_pincode">Pincode</label>
						   <input class="form-control" id="lead_pincode" name="lead_pincode" type="text" placeholder="Enter Pincode"  maxlength="6" value="<?php echo isset($details['clm_pincode'])?$details['clm_pincode']:set_value("lead_pincode"); ?>">
						    <?php echo form_error('lead_pincode','<span class="text-danger">','</span>'); ?>
                         </div>							 
                        </div>
						 <div class="col-md-12">
						  <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint  icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">Reference Details</span>
							   </div>
							    <hr style="margin:0px;"/>
						   </div>
						 <div class="form-group col-md-4">
                           <label for="lead_refby">Reference By</label>
						     <select class="form-control" id="lead_refby" name="lead_refby" >
							<option value=""> Select Reference By </option>
							 <?php  if(!empty($reference_list)){ 							
								foreach($reference_list as $key=>$ref){ 
								         $reference   = isset($details['clm_refby'])?$details['clm_refby']:"";
									     $selected    = $reference==$ref['ref_id']?"selected":"";	?>
									<option value="<?php echo $ref['ref_id'];?>"  <?php echo $selected;?>><?php echo $ref['ref_name']; ?></option>
							<?php } } ?>	
						   </select>				
                         </div>	
					     <div class="form-group col-md-4">
                           <label for="lead_refby_name">Reference Name</label>
                           <input class="form-control" id="lead_refby_name" name="lead_refby_name" type="text" placeholder="Enter Reference Name"  maxlength="200" value="<?php echo isset($details['clm_refby_name'])?$details['clm_refby_name']:set_value("lead_refby_name"); ?>">
						    <?php echo form_error('lead_refby_name','<span class="text-danger">','</span>'); ?>
                        </div> 
						  	<div class="form-group col-md-4">
                           <label for="lead_refby_contact">Reference Contact</label>
						   <input class="form-control" id="lead_refby_contact" name="lead_refby_contact" type="text" placeholder="Enter Reference Contact" maxlength="10" value="<?php echo isset($details['clm_refby_contact'])?$details['clm_refby_contact']:set_value("lead_refby_contact"); ?>">
						    <?php echo form_error('lead_refby_contact','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-4">
                           <label for="lead_refby_email">Reference Email Id</label>
						   <input class="form-control" id="lead_refby_email" name="lead_refby_email" type="text" placeholder="Enter Reference Email Id." maxlength="100" value="<?php echo isset($details['clm_refby_emailid'])?$details['clm_refby_emailid']:set_value("lead_refby_email"); ?>">
						    <?php echo form_error('lead_refby_email','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-4">
                           <label for="lead_refby_address">Reference Address</label>
						   <input class="form-control" id="lead_refby_address" name="lead_refby_address" type="text" placeholder="Enter Reference Address" maxlength="300" value="<?php echo isset($details['clm_refby_address'])?$details['clm_refby_address']:set_value("lead_refby_address"); ?>">
						    <?php echo form_error('lead_refby_address','<span class="text-danger">','</span>'); ?>
                        </div>
						  </div>
						   <div class="col-md-12">
						  <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint  icon-mobile"></i>
								  <span class="caption-subject font-red-mint sbold"> Alternate Contact Details</span>
							   </div>
							  <hr style="margin:0px;"/>
							   
						   </div>
						  <div class="col-md-12">
						   <?php if ($action=="Add" || (isset($details['contactList']) && empty($details['contactList']))) { ?>						 
						   <div class="mt-repeater">
								<div data-repeater-list="group-b">
									<div data-repeater-item="" class="row">
										<div class="col-md-4">
											<label class="control-label">Contact Person</label>
											<input type="text" name="lead_altcontactperson" placeholder="Contact Person" class="form-control lead_altcontactperson" maxlength="100" > </div>
										<div class="col-md-3">
											<label class="control-label">Contact No.</label>
											<input type="text" name="lead_altcontact" placeholder="Contact No." maxlength="10" class="form-control lead_altcontact"> 
										</div>	
										<div class="col-md-4">
											<label class="control-label">Email Id.</label>
											<input type="text" name="lead_altemail" placeholder="Email Id."  maxlength="100"  class="form-control lead_altemail"> 
										</div>
										<div class="col-md-1">
											<label class="control-label">&nbsp;</label>
											<a href="javascript:;" data-repeater-delete="" class="btn btn-danger">
												<i class="fa fa-close"></i>
											</a>
										</div>
									</div>
								</div>
								<hr>
								<a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add">
									<i class="fa fa-plus"></i> Add More Contacts</a>
								<br>
								 <span class="text-danger" id="err_msg"></span><br> 
								</div>
						 
						   <?php } ?>
						    <?php if ($action=="Edit" && (isset($details['contactList']) && !empty($details['contactList']))) { ?>						 
						   <div class="mt-repeater">
								<div data-repeater-list="group-b">
								<?php foreach($details['contactList'] as $key=>$cont){ ?>
									<div data-repeater-item="" class="row">
										<div class="col-md-4">
											<label class="control-label">Contact Person</label>
											<input type="text" name="group-b[<?php echo $key;?>][lead_altcontactperson]" placeholder="Contact Person" class="form-control lead_altcontactperson" maxlength="100" value="<?php echo $cont['lead_cntct_name'];?>"> </div>
										<div class="col-md-3">
											<label class="control-label">Contact No.</label>
											<input type="text" name="group-b[<?php echo $key;?>][lead_altcontact]" placeholder="Contact No." maxlength="10" class="form-control lead_altcontact" value="<?php echo $cont['lead_cntct_mob'];?>"> 
										</div>	
										<div class="col-md-4">
											<label class="control-label">Email Id.</label>
											<input type="text" name="group-b[<?php echo $key;?>][lead_altemail]" placeholder="Email Id."  maxlength="100"  class="form-control lead_altemail" value="<?php echo $cont['lead_cntct_email'];?>"> 
										</div>
										<div class="col-md-1">
											<label class="control-label">&nbsp;</label>
											<a href="javascript:;" data-repeater-delete="" class="btn btn-danger">
												<i class="fa fa-close"></i>
											</a>
										</div>
									</div>
								<?php } ?>
								</div>
								<hr>
								<a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add">
									<i class="fa fa-plus"></i> Add More Contacts</a>
								<br>
								 <span class="text-danger" id="err_msg"></span><br> 
								</div>
						 
						   <?php } ?>
						   
						     </div>
						   </div>
						 
						   <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <span class="btn btn-success"  id="add_edit_form_btn" >Submit</span>
                          <a href="<?php echo base_url();?>leads/lead_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                        </div>
                        </div>
						</form>
				
                        <!-- /.box-body -->
                        
                     
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
            lead_name: {
                required: true,
				maxlength: 50,
                minlength: 2,
				 }, 
				 
			lead_desc: {
            	maxlength: 500,
                minlength: 2,
				 }, 	
		    lead_contact_person: {
            	maxlength: 200,
                minlength: 2,
				 }, 	  
		    website: {
            	maxlength: 100,
                minlength: 2,
				 }, 	
			pan_no: {
            	maxlength: 10,
                minlength: 2,
				pan:true,
				 }, 	
			company_name: {
            	maxlength: 100,
                minlength: 2,
				 }, 
			lead_contact: {
            	maxlength: 10,
                minlength: 10,
				digits:true,
				 }, 
			lead_refby_contact: {
            	maxlength: 10,
                minlength: 10,
				digits:true,
				 }, 	
			lead_contact_email: {
            	maxlength: 100,
                email:true,
				 },	
			lead_refby_email: {
            	maxlength: 100,
                email:true,
				 },
			lead_landline: {
            	maxlength: 15,
                digits:true,
				 }, 				 
		   /*  lead_productid: {
                required: true,
				 },  */	

		  lead_addrs: {
			    maxlength: 300,
                minlength: 2,
				 }, 
		  lead_refby_address: {
			    maxlength: 300,
                minlength: 2,
				 },
          lead_pincode: {
				maxlength: 6,
                minlength: 6,
				digits:true,
				 },   
		  lead_refby_name: {
				maxlength: 200,
  				 },
		 "group-b[0][lead_altcontactperson[]]": {
				maxlength: 100,
  				 },  
		 "group-b[0][lead_altcontact[]]": {    
				maxlength: 10,
                minlength: 10,
				digits:true,
  				 },  
		  "group-b[0][lead_altemail[]]": {
				maxlength: 100,
 				email:true,
  				 },  				 
		 
		  emp_permaddress: {
			    required: true,
               	maxlength: 300,
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
    });
	
	$('#add_edit_form_btn').on('click', function(e){
		if($('#add_edit_form').valid()){

		var group_count = 0;
		var err_msg = "";
		$("#err_msg").html("");
		 $(".mt-repeater").find(".lead_altcontactperson").each(function( j ) {
     		group_count = group_count +1;
			
		});
		
		
		for (var i=0;i<=group_count;i++)
		{
			var total = 0;
			var sr_no = (parseInt(i)+1);
	
				$(".mt-repeater").find(".lead_altcontact").each(function( j ) {
				 if( $(this).attr("name") == "group-b["+i+"][lead_altcontact]"){
						var lead_altcontact = $(this).val();
						$(this).css("border", "");
						if(lead_altcontact && lead_altcontact.length!==10){
							 err_msg += "<br/>Row No - "+sr_no+" : Contact No. Should be 10 Digits";
							 $(this).css("border", "1px solid red");
						} 	 } 
				 });	
				 
				 $(".mt-repeater").find(".lead_altemail").each(function( j ) {
				  if( $(this).attr("name") == "group-b["+i+"][lead_altemail]"){
						var lead_altemail = $(this).val();
						$(this).css("border", "");
						if(lead_altemail && !(IsEmail(lead_altemail))){
							 err_msg += "<br/>Row No - "+sr_no+" : Please Enter Valid Email Id";
							 $(this).css("border", "1px solid red");
						} 	 } 
				 });	
			
		}
		$("#err_msg").html(err_msg);
		if(err_msg ==""){
			 $('#add_edit_form').submit();
		} else {
			e.preventDefault();
		}
		
		}
		
	 		
    });
	
    });
	
function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
}
	
	
</script>