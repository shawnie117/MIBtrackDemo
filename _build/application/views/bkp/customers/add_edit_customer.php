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
	<li><a href="<?php echo base_url("customers/customer_report")?>">All Customer Report </a><i class="fa fa-circle"></i></li>
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
					$formaction = "edit_customer/?id=".base64_encode($id);
					}else if($action=="Confirm"){  
					$formaction = "confirm_lead/?ref_id=".base64_encode($id);;
					//echo "<pre/>"; print_r($details);die; 
				    $details = html_escape($details);
					}else {  $formaction = "add_customer"; } 
					
					?>
					
                     <form action="<?php echo base_url().'customers/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data" >
					  <div class="form-body">
					  
					   <div class="col-md-12"> 
					  
					    <div class="portlet-body">
						  <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">Basic Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>					   
					  
					    <?php if($action=="Edit"){?>
                           <input type="hidden" name="id" value="<?php echo $id; ?>">
                           <input type="hidden" name="cust_type" value="<?php echo isset($details['cust_type'])?$details['cust_type']:""; ?>">
						   <?php } ?>
						   
					 <?php if($action=="Confirm" || $action=="Add" ){ ?>
						 <div class="form-group col-md-3">
                           <label for="cust_service_type">Service Type</label><?php echo REQUIRED_STAR; ?>
                           <select class="form-control" id="cust_service_type" name="cust_service_type" required onchange="get_services(this);" >
							<option value=""> Select Service Type</option>
							 <?php  if(!empty($service_list )){ 	 						
								foreach($service_list as $key=>$service){
                                    $service_type =  isset($details['clm_priority_level'])?$details['clm_priority_level']:set_value("cust_service_type");
									$selected  = $service == $service_type?"selected":"";
									?>
									<option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $service; ?></option>
							<?php } } ?>	
						   </select>
						    <?php echo form_error('cust_service_type','<span class="text-danger">','</span>'); ?>
                        </div> 
						
						<div class="form-group col-md-3">
                           <label for="cust_gst_type">GST Option</label><?php echo REQUIRED_STAR; ?>
                           <select class="form-control" id="cust_gst_type" name="cust_gst_type" required onchange="clear_service_details();" >
							 <?php  if(!empty($gst_type_list )){ 	 						
								foreach($gst_type_list as $key=>$gtype){
                                    $cust_gst_type =  isset($details['clm_priority_level'])?$details['clm_priority_level']:set_value("cust_gst_type");
									$selected  = $gtype == $cust_gst_type?"selected":"";
									?>
									<option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $gtype; ?></option>
							<?php } } ?>	
						   </select>
						    <?php echo form_error('cust_gst_type','<span class="text-danger">','</span>'); ?>
                        </div> 
					
					
						 <div class="form-group col-md-3">
                           <label for="cust_type">Customer Type</label><?php echo REQUIRED_STAR; ?>
                           <select class="form-control" id="cust_type" name="cust_type" required onchange="clear_service_details();">
							 <?php  if(!empty($cust_type_list )){ 	 						
								foreach($cust_type_list as $key=>$ctype){
                                    $cust_type =  isset($details['cust_type'])?$details['cust_type']:set_value("cust_type");
									$selected  = $ctype == $cust_type?"selected":"";
									?>
									<option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $ctype; ?></option>
							<?php } } ?>	
						   </select>
						    <?php echo form_error('cust_type','<span class="text-danger">','</span>'); ?>
                        </div> 
						 <?php } ?>
							<div class="form-group col-md-3">
                           <label for="cust_gstno">Customer GST No</label>
						   <input class="form-control" id="cust_gstno" name="cust_gstno" type="text" placeholder="Enter Customer GST No"  maxlength="15" value="<?php echo isset($details['customer_gstno'])?$details['customer_gstno']:set_value("cust_gstno"); ?>">
						    <?php echo form_error('cust_gstno','<span class="text-danger">','</span>'); ?>
                        </div>
                        </div>
					  
						
						
						 
                      <div class="col-md-12">
					     <div class="portlet-title">
					            <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-call-out"></i>
								  <span class="caption-subject font-red-mint sbold">Contact Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>
					 		<div class="form-group col-md-4">
                           <label for="cust_name">Customer Name</label> <?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="cust_name" name="cust_name" type="text" placeholder="Enter Customer Name" required maxlength="100" value="<?php echo isset($details['customer_name'])?$details['customer_name']:set_value("cust_name"); ?>">
						    <?php echo form_error('cust_name','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-4">
                           <label for="cust_contact_person">Contact Person</label>
						   <input class="form-control" id="cust_contact_person" name="cust_contact_person" type="text" placeholder="Enter Contact Person" maxlength="100" value="<?php echo isset($details['customer_contact_person'])?$details['customer_contact_person']:set_value("cust_contact_person"); ?>">
						    <?php echo form_error('cust_contact_person','<span class="text-danger">','</span>'); ?>
                        </div>
						
						<div class="form-group col-md-4">
                           <label for="cust_contact">Mobile No.</label>
						   <input class="form-control" id="cust_contact" name="cust_contact" type="text" placeholder="Enter Mobile No." maxlength="10" value="<?php echo isset($details['customer_contact'])?$details['customer_contact']:set_value("cust_contact"); ?>">
						    <?php echo form_error('cust_contact','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-4">
                           <label for="cust_landline">Landline No.</label>
						   <input class="form-control" id="cust_landline" name="cust_landline" type="text" placeholder="Enter Landline No." maxlength="15" value="<?php echo isset($details['cust_landline'])?$details['cust_landline']:set_value("cust_landline"); ?>">
						    <?php echo form_error('cust_landline','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-4">
                           <label for="cust_contact_email">Email Id</label>
						   <input class="form-control" id="cust_contact_email" name="cust_contact_email" type="text" placeholder="Enter Email Id." maxlength="100" value="<?php echo isset($details['customer_contact_email'])?$details['customer_contact_email']:set_value("cust_contact_email"); ?>">
						    <?php echo form_error('cust_contact_email','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-4">
                           <label for="cust_website">Website</label>
						   <input class="form-control" id="cust_website" name="cust_website" type="text" placeholder="Enter Website" maxlength="100" value="<?php echo isset($details['cust_website'])?$details['cust_website']:set_value("cust_website"); ?>">
						    <?php echo form_error('cust_website','<span class="text-danger">','</span>'); ?>
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
						  <div class="form-group col-md-12">
                           <label for="cust_address">Address</label>
						   <input class="form-control" id="cust_address" name="cust_address" type="text" placeholder="Enter Address"  maxlength="300" value="<?php echo isset($details['customer_address'])?$details['customer_address']:set_value("cust_address"); ?>">
						    <?php echo form_error('cust_address','<span class="text-danger">','</span>'); ?>
                         </div>
						 
						  <div class="form-group col-md-4"> 
							<label for="cust_stateid">State </label>
                            <select class="form-control" id="cust_stateid" name="cust_stateid" onchange="get_state_districts(this,'cust_distid');">
							<option value=""> Select State</option>
							 <?php  if(!empty($state_list)){ 
								foreach($state_list as $state){ 
								  $state_id =  isset($details['customer_state_id'])?$details['customer_state_id']:set_value("cust_stateid");
								  $selected = $state_id==$state['state_id']?"selected":"";
								
								?>
									<option value="<?php echo $state['state_id'];?>" <?php echo $selected;?> ><?php echo $state['state_name']; ?></option>
							<?php } } ?>	
						   </select>	
                           <?php echo form_error('cust_stateid','<span class="text-danger">','</span>'); ?>						   
                        </div> 
						<div class="form-group col-md-4">  
						<label for="cust_distid">District </label>  
                          <select class="form-control" id="cust_distid" name="cust_distid" onchange="get_district_cities(this,'cust_stateid','cust_cityid');">
							<option value=""> Select District</option>
							 <?php  if(!empty($dist_list)){ 
								foreach($dist_list as $dist){ 
								  $dist_id =  isset($details['customer_dist_id'])?$details['customer_dist_id']:set_value("cust_distid");
								  $selected = $dist_id==$dist['dist_id']?"selected":"";
								
								?>
									<option value="<?php echo $dist['dist_id'];?>" <?php echo $selected;?> ><?php echo $dist['dist_name']; ?></option>
							<?php } } ?>	
						   </select>
							<?php echo form_error('cust_distid','<span class="text-danger">','</span>'); ?>							   
                        </div>
						<div class="form-group col-md-4">  
						<label for="cust_cityid">City </label>   
                          <select class="form-control" id="cust_cityid" name="cust_cityid"  onchange="get_city_area(this,'cust_stateid','cust_distid','cust_area');">
							<option value=""> Select City</option>
							 <?php  if(!empty($city_list)){ 
								foreach($city_list as $city){ 
								  $city_id =  isset($details['customer_city_id'])?$details['customer_city_id']:set_value("cust_cityid");
								  $selected = $city_id==$city['city_id']?"selected":"";
								
								?>
									<option value="<?php echo $city['city_id'];?>" <?php echo $selected;?> ><?php echo $city['city_name']; ?></option>
							<?php } } ?>	
						   </select>
							<?php echo form_error('cust_cityid','<span class="text-danger">','</span>'); ?>								   
                        </div>
						<div class="form-group col-md-4">
                           <label for="cust_area">Area</label>
						    <select class="form-control" id="cust_area" name="cust_area" >
							<option value=""> Select Area</option>
						    <?php  if(!empty($area_list)){ 
								foreach($area_list as $area){ 
								  $area_id =  isset($details['customer_area'])?$details['customer_area']:set_value("cust_area");
								  $selected = $area_id==$area['area_id']?"selected":"";
								
								?>
									<option value="<?php echo $area['area_id'];?>" <?php echo $selected;?> ><?php echo $area['area_name']; ?></option>
							<?php } } ?>	
						   </select>
							<?php echo form_error('cust_area','<span class="text-danger">','</span>'); ?>								   
                         </div>	
						   <div class="form-group col-md-4">
                           <label for="cust_pincode">Pincode</label>
						   <input class="form-control" id="cust_pincode" name="cust_pincode" type="text" placeholder="Enter Pincode"  maxlength="6" value="<?php echo isset($details['customer_pin'])?$details['customer_pin']:set_value("cust_pincode"); ?>">
						    <?php echo form_error('cust_pincode','<span class="text-danger">','</span>'); ?>
                         </div>			 
                        </div>
						
						 <div class="col-md-12">
						  <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-pointer"></i>
								  <span class="caption-subject font-red-mint sbold">Service Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
						   <div class="form-group col-md-12">
                           <label for="cust_service_det">Service Details</label> <?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="cust_service_det" name="cust_service_det" type="text" placeholder="Enter Service Details" required maxlength="500" value="<?php echo isset($details['cust_service_det'])?$details['cust_service_det']:set_value("cust_service_det"); ?>">
						    <?php echo form_error('cust_service_det','<span class="text-danger">','</span>'); ?>
                           </div> 
						   <?php if($action=="Confirm" || $action=="Add"){ ?>
						   <div class="form-group col-md-12">
                           <label for="cust_services_lbl" id="cust_services_lbl">Services</label> 
						    <span id="file_err"></span>
						   <div class="slimScrollDiv150" style="border:1px solid #cdcdcd;">
						  <table class="table table-striped table-bordered table-advance table-hover">
						   <tbody id="tbl_service_id">
						   </tbody>
						   </table>
						  
                           </div> 
                           </div> 
						
						   <div class="form-group col-md-12 shadow">
                           <label for="cust_service_details_lbl" id="cust_service_details_lbl">Service Details</label> 
						   
						   <div class="slimScrollDiv250" style="border:1px solid #cdcdcd;">
						  <table class="table table-striped table-bordered table-advance table-hover">
						  <thead id="services_tbl_header"> </thead>
						   <tbody id="tbl_service_details">
						   
							
						   </tbody>
						   </table>
                           </div>
                           </div>
						   
						   
						 
						    <div class="form-group col-md-3">
                           <label for="cust_total_amount">Total Price</label>
                           <input class="form-control" id="cust_total_amount" name="cust_total_amount" type="text" placeholder="Total Price" maxlength='8' value="0" readonly>
						    <?php echo form_error('cust_total_amount','<span class="text-danger">','</span>'); ?>
                           </div>
						   
						   <?php } ?>
						   
						   <div class="form-group col-md-3">
                           <label for="cust_unit_no">Unit No</label>
                           <input class="form-control" id="cust_unit_no" name="cust_unit_no" type="text" placeholder="Enter Reference Name"  maxlength="50" value="<?php echo isset($details['cust_unit_no'])?$details['cust_unit_no']:set_value("cust_unit_no"); ?>">
						    <?php echo form_error('cust_unit_no','<span class="text-danger">','</span>'); ?>
                           </div> 
						   <div class="form-group col-md-3">
                           <label for="cust_form_no">Form No</label>
                           <input class="form-control" id="cust_form_no" name="cust_form_no" type="text" placeholder="Enter Reference Name"  maxlength="50" value="<?php echo isset($details['cust_form_no'])?$details['cust_form_no']:set_value("cust_form_no"); ?>">
						    <?php echo form_error('cust_form_no','<span class="text-danger">','</span>'); ?>
                           </div>  
						   <div class="form-group col-md-3">
                           <label for="cust_ui_date">Customer Added Date</label>
                           <input class="form-control datepicker" id="cust_ui_date" name="cust_ui_date" type="text" placeholder="Enter Customer Added Date"  maxlength="15" value="<?php echo isset($details['cust_uidate_n'])?$details['cust_uidate_n']:set_value("cust_ui_date"); ?>">
						    <?php echo form_error('cust_ui_date','<span class="text-danger">','</span>'); ?>
                           </div> 
						   </div>
						  <div class="col-md-12">
						    <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint  icon-note"></i>
								  <span class="caption-subject font-red-mint sbold">Bank Details</span>
							   </div>
							  <hr style="margin:3px;"/>
						   </div>
						    <div class="form-group col-md-4">
                           <label for="bank_acc_name">Bank Account Name</label>
						   <input class="form-control" id="bank_acc_name" name="bank_acc_name" type="text" placeholder="Enter Bank Account Name"  maxlength="100" value="<?php echo set_value("bank_acc_name"); ?>">
						    <?php echo form_error('bank_acc_name','<span class="text-danger">','</span>'); ?>
                         </div>	
						 
						 <div class="form-group col-md-4">
                           <label for="bank_acc_number">Enter Account No.</label><?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="bank_acc_number" name="bank_acc_number" type="text" placeholder="Enter Account No."  maxlength="20" value="<?php echo set_value("bank_acc_number"); ?>">
						    <?php echo form_error('bank_acc_number','<span class="text-danger">','</span>'); ?>
                         </div>	 						
						 <div class="form-group col-md-4">
                           <label for="bank_ifsc">IFSC Code</label><?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="bank_ifsc" name="bank_ifsc" type="text" placeholder="Enter IFSC Code"  maxlength="15" value="<?php echo set_value("bank_ifsc"); ?>">
						    <?php echo form_error('bank_ifsc','<span class="text-danger">','</span>'); ?>
							<span id="ifsc_code" class="text-success"></span>
                         </div>	
						  <div class="form-group col-md-4">
                           <label for="bank_name">Bank Name</label><?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="bank_name" name="bank_name" type="text" placeholder="Enter Bank Name"  maxlength="100" value="<?php echo set_value("bank_name"); ?>">
						    <?php echo form_error('bank_name','<span class="text-danger">','</span>'); ?>
                         </div>	 
						 <div class="form-group col-md-4">
                           <label for="bank_branch_address">Branch Address</label><?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="bank_branch_address" name="bank_branch_address" type="text" placeholder="Enter Branch Address"  maxlength="100" value="<?php echo set_value("bank_branch_address"); ?>">
						    <?php echo form_error('bank_branch_address','<span class="text-danger">','</span>'); ?>
                         </div>	 
						 <div class="form-group col-md-4">
                           <label for="bank_micr">Bank MICR</label><?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="bank_micr" name="bank_micr" type="text" placeholder="Enter Bank MICR"  maxlength="9" value="<?php echo set_value("bank_micr"); ?>">
						    <?php echo form_error('bank_micr','<span class="text-danger">','</span>'); ?>
                         </div>	
						   </div>
						   
						  <div class="col-md-12"> 
					   <?php if($action=="Confirm" || $action=="Add" ){ ?>
					    <div class="portlet-body">
						  <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-wallet"></i>
								  <span class="caption-subject font-red-mint sbold">Payment Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
						    <div class="form-group col-md-3">
                           <label for="company_pay_type">Payment Mode <?php echo REQUIRED_STAR; ?></label>
						     <select class="form-control" id="company_pay_type" name="company_pay_type" onchange="get_payment_details(this);" >
							<option value=""> Payment Mode</option>
							 <?php  if(!empty($payment_mode_list)){ 							
								foreach($payment_mode_list as $key=>$pay){ ?>			          
									<option value="<?php echo $key;?>"  ><?php echo $pay; ?></option>
							<?php } } ?>	
						   </select>				
                           </div>	 
						   <div class="form-group col-md-3">
                           <label for="cust_paid_amount">Paid Amount <?php echo REQUIRED_STAR; ?></label>
						      <input class="form-control" id="cust_paid_amount" name="cust_paid_amount" type="text" placeholder="Total Paid Amount" maxlength='8' value="0" >
						    <?php echo form_error('cust_paid_amount','<span class="text-danger">','</span>'); ?>		
                           </div>
						
                      <div class="col-md-12 hidden" id="cheque_details">
						    <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint  icon-note"></i>
								  <span class="caption-subject font-red-mint sbold">Cheque Details</span>
							   </div>
							  <hr style="margin:3px;"/>
						   </div>
						    <div class="form-group col-md-3">
                           <label for="company_cheque_bankname">Bank Name</label><?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="company_cheque_bankname" name="company_cheque_bankname" type="text" placeholder="Enter Bank Name"  maxlength="100" value="<?php echo set_value("company_cheque_bankname"); ?>">
						    <?php echo form_error('company_cheque_bankname','<span class="text-danger">','</span>'); ?>
                         </div>	 
						    <div class="form-group col-md-3">
                           <label for="company_chequeno">Bank Cheque Number</label>
						   <input class="form-control" id="company_chequeno" name="company_chequeno" type="text" placeholder="Enter Cheque Number"  maxlength="6" value="<?php echo set_value("company_chequeno"); ?>">
						    <?php echo form_error('company_chequeno','<span class="text-danger">','</span>'); ?>
                         </div>	
						  <div class="form-group col-md-3">
                           <label for="company_cheque_date">Cheque Date</label>
                           <input class="form-control datepicker" id="company_cheque_date" name="company_cheque_date" type="text" placeholder="Enter Cheque Date"  maxlength="15" value="<?php echo set_value("company_cheque_date"); ?>">
						    <?php echo form_error('company_cheque_date','<span class="text-danger">','</span>'); ?>
                           </div>   
						   <div class="form-group col-md-3">
                           <label for="company_chequeimg">Cheque Image</label>
                           <input type="file" name="company_chequeimg"  id="company_chequeimg" 
								class="smart-file" 
								data-label="Cheque Image" 
								data-btn-class="btn btn-default btn-sm" 
								data-preview="on"
								data-file-types="image/jpeg,image/png,image/jpg"    />
								<?php echo form_error('company_chequeimg','<span class="text-danger">','</span>'); ?>
								
								
								<span class="file_err"></span>
                           </div> 
                         </div>
                     <div class="col-md-12 hidden" id="dd_details">
						    <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint  icon-note"></i>
								  <span class="caption-subject font-red-mint sbold">DD Details</span>
							   </div>
							  <hr style="margin:3px;"/>
						   </div>
						    <div class="form-group col-md-3">
                           <label for="company_dd_bank_name">Bank Name</label><?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="company_dd_bank_name" name="company_dd_bank_name" type="text" placeholder="Enter Bank Name"  maxlength="100" value="<?php echo set_value("company_dd_bank_name"); ?>">
						    <?php echo form_error('company_dd_bank_name','<span class="text-danger">','</span>'); ?>
                         </div>	 
						    <div class="form-group col-md-3">
                           <label for="company_dd_no">DD Number</label>
						   <input class="form-control" id="company_dd_no" name="company_dd_no" type="text" placeholder="Enter DD Number"  maxlength="6" value="<?php echo set_value("company_dd_no"); ?>">
						    <?php echo form_error('company_dd_no','<span class="text-danger">','</span>'); ?>
                         </div>	
						  <div class="form-group col-md-3">
                           <label for="company_dd_date">DD Date</label>
                           <input class="form-control datepicker" id="company_dd_date" name="company_dd_date" type="text" placeholder="Enter DD Date"  maxlength="15" value="<?php echo set_value("company_dd_date"); ?>">
						    <?php echo form_error('company_dd_date','<span class="text-danger">','</span>'); ?>
                           </div>   
						   <div class="form-group col-md-3">
                           <label for="company_dd_img">DD Image</label><br/>
                           <input type="file" name="company_dd_img"  id="company_dd_img" 
								class="smart-file" 
								data-label="DD Image" 
								data-btn-class="btn btn-default btn-sm" 
								data-preview="on"
								data-file-types="image/jpeg,image/png,image/jpg"    />
								<?php echo form_error('company_dd_img','<span class="text-danger">','</span>'); ?>
								
								
								<span class="file_err"></span>
                           </div> 
                         </div>	  
						 
						 <div class="col-md-12 hidden" id="online_details">
						    <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint  icon-note"></i>
								  <span class="caption-subject font-red-mint sbold">Online Transaction Details</span>
							   </div>
							  <hr style="margin:3px;"/>
						   </div>
						    <div class="form-group col-md-4">
                           <label for="company_online_trxn_id">Transaction Id</label><?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="company_online_trxn_id" name="company_online_trxn_id" type="text" placeholder="Enter Transaction Id"  maxlength="100" value="<?php echo set_value("company_online_trxn_id"); ?>">
						    <?php echo form_error('company_online_trxn_id','<span class="text-danger">','</span>'); ?>
                         </div>	 
						    <div class="form-group col-md-4">
                           <label for="company_payment_id">Payment Id</label><?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="company_payment_id" name="company_payment_id" type="text" placeholder="Enter Payment Id"  maxlength="100" value="<?php echo set_value("company_payment_id"); ?>">
						    <?php echo form_error('company_payment_id','<span class="text-danger">','</span>'); ?>
                            </div>	  
							
							<div class="form-group col-md-4">
                           <label for="company_order_id">Order Id</label><?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="company_order_id" name="company_order_id" type="text" placeholder="Enter Order Id"  maxlength="100" value="<?php echo set_value("company_order_id"); ?>">
						    <?php echo form_error('company_order_id','<span class="text-danger">','</span>'); ?>
                            </div>	 
						    
						
						  
                         </div>	
						 
						 
						 
						   
						   </div>						   
						   </div>
                       <?php } ?>
						   
						 <div class="col-md-12">
						  <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint  icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">Reference Details</span>
							   </div>
							  <hr style="margin:3px;"/>
						   </div>
						 <div class="form-group col-md-3">
                           <label for="cust_refbyid">Reference By</label>
						     <select class="form-control" id="cust_refbyid" name="cust_refbyid" >
							<option value=""> Select Reference By </option>
							 <?php  if(!empty($reference_list)){ 							
								foreach($reference_list as $key=>$ref){ 
								         $reference   = isset($details['cust_ref_id'])?$details['cust_ref_id']:"";
									     $selected    = $reference==$ref['ref_id']?"selected":"";	?>
									<option value="<?php echo $ref['ref_id'];?>"  <?php echo $selected;?>><?php echo $ref['ref_name']; ?></option>
							<?php } } ?>	
						   </select>				
                         </div>	
					     <div class="form-group col-md-3">
                           <label for="cust_refbyname">Reference Name</label>
                           <input class="form-control" id="cust_refbyname" name="cust_refbyname" type="text" placeholder="Enter Reference Name"  maxlength="200" value="<?php echo isset($details['cust_ref_name'])?$details['cust_ref_name']:set_value("cust_refbyname"); ?>">
						    <?php echo form_error('cust_refbyname','<span class="text-danger">','</span>'); ?>
                        </div> 
						  	<div class="form-group col-md-3">
                           <label for="cust_refby_contact">Reference Contact</label>
						   <input class="form-control" id="cust_refby_contact" name="cust_refby_contact" type="text" placeholder="Enter Reference Contact" maxlength="10" value="<?php echo isset($details['cust_ref_contact'])?$details['cust_ref_contact']:set_value("cust_refby_contact"); ?>">
						    <?php echo form_error('cust_refby_contact','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-3">
                           <label for="cust_refby_email">Reference Email Id</label>
						   <input class="form-control" id="cust_refby_email" name="cust_refby_email" type="text" placeholder="Enter Reference Email Id." maxlength="100" value="<?php echo isset($details['cust_ref_email'])?$details['cust_ref_email']:set_value("cust_refby_email"); ?>">
						    <?php echo form_error('cust_refby_email','<span class="text-danger">','</span>'); ?>
                        </div>
						
						  </div>
						   <div class="col-md-12">
						  <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint  icon-mobile"></i>
								  <span class="caption-subject font-red-mint sbold"> Alternate Contact Details</span>
							   </div>
							   <hr style="margin:3px;"/>
							   
						   </div>
						  <div class="col-md-12">
						   <?php if (($action=="Add") || (isset($details['contactList']) && empty($details['contactList'])) || ($action=="Confirm" && empty($details['contactList']))) { ?>						 
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
									<i class="fa fa-plus"></i> Add More Contact</a>
								<br>
								 <span class="text-danger" id="err_msg"></span><br> 
								</div>
						 
						   <?php } ?>
						    <?php if (($action=="Edit" || $action=="Confirm") && (isset($details['contactList']) && !empty($details['contactList']))) { ?>						 
						   <div class="mt-repeater">
								<div data-repeater-list="group-b">
								<?php foreach($details['contactList'] as $key=>$cont){ ?>
									<div data-repeater-item="" class="row">
										<div class="col-md-4">
											<label class="control-label">Contact Person</label>
											<input type="text" name="group-b[<?php echo $key;?>][lead_altcontactperson]" placeholder="Contact Person" class="form-control lead_altcontactperson" maxlength="100" value="<?php echo isset($cont['cust_contact_person'])?$cont['cust_contact_person']:"";?>"> </div>
										<div class="col-md-3">
											<label class="control-label">Contact No.</label>
											<input type="text" name="group-b[<?php echo $key;?>][lead_altcontact]" placeholder="Contact No." maxlength="10" class="form-control lead_altcontact" value="<?php echo isset($cont['cust_contact_no'])?$cont['cust_contact_no']:"";?>"> 
										</div>	
										<div class="col-md-4">
											<label class="control-label">Email Id.</label>
											<input type="text" name="group-b[<?php echo $key;?>][lead_altemail]" placeholder="Email Id."  maxlength="100"  class="form-control lead_altemail" value="<?php echo isset($cont['cust_contact_emailid'])?$cont['cust_contact_emailid']:"";?>"> 
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
									<i class="fa fa-plus"></i> Add More Contact</a>
								<br>
								 <span class="text-danger" id="err_msg"></span><br> 
								</div>
						 
						   <?php } ?>
						   
						     </div>
						   </div>
						 
						   <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <span class="btn btn-success"  id="add_edit_form_btn" >Submit</span>
                          <a href="<?php echo base_url();?>customers/customer_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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
	

	$('#bank_ifsc').change(function() {
			var bank_ifsc = $("#bank_ifsc").val();
			getIFSC(bank_ifsc);
	   });
	   
	   
	 $('.datepicker').datepicker({
				format: 'dd-M-yyyy',
				autoclose: true,
				todayHighlight: true,

		});	
	
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
             cust_service_type: {
                required: true,
			 }, 
			 cust_gst_type: {
                required: true,
			 },  
			 cust_type: {
                required: true,
			 }, 
				 
			cust_gstno: {
            	maxlength: 15,
                minlength: 2,
				 }, 
				 
		    cust_name: {
				required: true,
            	maxlength: 100,
                minlength: 2,
				 }, 	
			cust_contact_person: {
            	maxlength: 100,
                minlength: 2,
				 }, 				 
			cust_contact: {
            	maxlength: 10,
                minlength: 10,
				digits:true,
				 }, 
          cust_landline: {
            	maxlength: 15,
                digits:true,
				 }, 	
		  cust_contact_email: {
            	maxlength: 100,
                email:true,
				 },  
		  cust_website: {
            	maxlength: 100,
				 },
				 
		  bank_acc_name: {
            	maxlength: 100,
               	 },	  
		  bank_micr: {
            	maxlength: 9,
				digits:true,
               	 },	 
		  company_chequeno: {
            	maxlength: 6,
				digits:true,
               	 },	 
		  company_dd_no: {
            	maxlength: 6,
				digits:true,
               	 },	
		  company_chequeimg: {
				  accept: "image/jpeg,image/png,image/jpg",
				  filesize_max:1000000, // 1 MB
   				}, 	 
		  company_dd_img: {
				  accept: "image/jpeg,image/png,image/jpg",
				  filesize_max:1000000, // 1 MB
   				}, 		 
		 bank_acc_number: {			  
               	maxlength: 20,
                minlength: 2,
				digits:true,
				}, 
		bank_name: {			   
               	maxlength: 100,
                minlength: 2,
				 }, 
		company_online_trxn_id: {			   
               	maxlength: 100,
                minlength: 2,
				 }, 
		company_payment_id: {			   
               	maxlength: 100,
                minlength: 2,
				 }, 
		company_order_id: {			   
               	maxlength: 100,
                minlength: 2,
				 }, 
		company_cheque_bankname: {
			    maxlength: 100,
                minlength: 2,
				 },
	    company_dd_bank_name: {
			    maxlength: 100,
                minlength: 2,
				 }, 
			bank_ifsc: {			   
               	maxlength: 15,
                minlength: 11,
				 remote : { url : base_url + "admin/checkIFSCExists", type :"post" },
				 }, 	
			bank_branch_address: {			  
               	maxlength: 250,
                minlength: 2,
				 },
				 
		  cust_address: {
			    maxlength: 1500,
                minlength: 2,
				 }, 
          cust_pincode: {
				maxlength: 6,
                minlength: 6,
				digits:true,
				 }, 				 
		  cust_service_det: {
            	maxlength: 500,
                minlength: 2,
				 }, 	
		  cust_total_amount: {
            	maxlength: 8,
				number:true,
				 }, 
		  cust_paid_amount: {
            	maxlength: 8,
				number:true,
				 },
		  cust_unit_no: {
            	maxlength: 50,
				 }, 
		  cust_form_no: {
            	maxlength: 50,
				 }, 
				 
		 cust_refbyname: {
				maxlength: 200,
  				 },	
		 cust_refby_contact: {    
				maxlength: 10,
                minlength: 10,
				digits:true,
  				 },  
		 cust_refby_email: {
            	maxlength: 100,
                email:true,
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
		 "service_id[]": {
				required:true,
  				 },  
		   	},
		messages: {
              bank_ifsc: { remote: 'Invalid IFSC Code' },
             "service_id[]": { required: 'Please Select At least one Service' },
            
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

	function get_payment_details(obj) {
		
		var payment_type   = $(obj).val();	
		/* $("#bank_details").addClass("hidden"); */
		$("#online_details").addClass("hidden");
		$("#dd_details").addClass("hidden");
		$("#cheque_details").addClass("hidden");
		
		/* if(payment_type=="Card"){
			$("#bank_details").removeClass("hidden");
		} */
		if(payment_type=="Online"){
			$("#online_details").removeClass("hidden");
		}
		if(payment_type=="DD"){
			$("#dd_details").removeClass("hidden");
		}
		if(payment_type=="Cheque"){
			$("#cheque_details").removeClass("hidden");
		}
	}

function get_services(obj) {
	
	    $("#tbl_service_details").html("");
        var service_type   = $(obj).val();	
		var service_lbl,service_detal_lbl;
		if(service_type=="AMC")
		{
			service_lbl = "AMC Services";
			service_detal_lbl = "AMC Details";
			$("#services_tbl_header").html("<tr class='success'><th width='5%'>Sr.No.</th><th>AMC</th><th>Address</th><th>Service Date</th></tr>");
			
		}
		if(service_type=="One Time Service")
		{
			service_lbl = "One Time Services";
			service_detal_lbl = "One Time Service Details";
			$("#services_tbl_header").html("<tr class='success'><th width='5%'>Sr.No.</th><th>One Time Service</th><th>Address</th></tr>");
		}
		if(service_type=="Sales")
		{
			service_lbl = "Sales Products";
			service_detal_lbl = "Sales Product Details";
			$("#services_tbl_header").html("<tr class='success'><th width='5%'>Sr.No.</th><th>Sales Product</th><th>Address</th><th>Service Date</th></tr>");
		}
		$("#cust_service_details_lbl").text(service_detal_lbl);
		$("#cust_services_lbl").text(service_lbl);
			
		$("#tbl_service_id").html("");		
		$.ajax({
			url:base_url+"ajax/get_service_list",
			type: "POST",
			datatype: "json",
			data: {"service_type":service_type},
			async: true,
			cache: false,
			success: function(data)
			{		
				var html_data = JSON.parse(data);	
                 $("#tbl_service_id").html(html_data);

			}
		});
}

	function get_amc_details(obj) {
		var amc_id   = $(obj).val();	
		var gst_type = $("#cust_gst_type").val();
		var cust_type = $("#cust_type").val();
		if ($(obj).is(':checked')) {
		 $.ajax({
			url:base_url+"ajax/get_amc_details",
			type: "POST",
			datatype: "json",
			data: {"cust_gst_type":gst_type,"amc_id":amc_id,"cust_type":cust_type},
			async: true,
			cache: false,
			success: function(data)
			{		
				   var html_data = JSON.parse(data);	
                   $("#tbl_service_details").append(html_data);
                   get_total();
				   get_srno();
				   $('.datepicker').datepicker({
				         format: 'dd-M-yyyy',
				         autoclose: true,
				         todayHighlight: true,

		           });
				   
			}
		});
			
		} else 
		{
			$('#table_row_id_'+amc_id).remove();
			get_total();
			get_srno();
		}			
	}
	
	function get_ots_details(obj) {
		var ots_id    = $(obj).val();	
		var gst_type  = $("#cust_gst_type").val();
		var cust_type = $("#cust_type").val();
		
		if ($(obj).is(':checked')) {
		 $.ajax({
			url:base_url+"ajax/get_ots_details",
			type: "POST",
			datatype: "json",
			data: {"cust_gst_type":gst_type,"ots_id":ots_id,"cust_type":cust_type},
			async: true,
			cache: false,
			success: function(data)
			{		
				   var html_data = JSON.parse(data);	
                   $("#tbl_service_details").append(html_data);
                   get_total();
				   get_srno();
				 
				   
			}
		});
			
		} else 
		{
			$('#table_row_id_'+ots_id).remove();
			get_total();
			get_srno();
		}			
	}
	function get_product_details(obj) {
		var pm_id     = $(obj).val();	
		var gst_type  = $("#cust_gst_type").val();
		var cust_type = $("#cust_type").val();
		
		if ($(obj).is(':checked')) {
		 $.ajax({
			url:base_url+"ajax/get_product_details",
			type: "POST",
			datatype: "json",
			data: {"cust_gst_type":gst_type,"pm_id":pm_id,"cust_type":cust_type},
			async: true,
			cache: false,
			success: function(data)
			{		
				   var html_data = JSON.parse(data);	
                   $("#tbl_service_details").append(html_data);
                   get_total();
				   get_srno();
				 
				   
			}
		});
			
		} else 
		{
			$('#table_row_id_'+pm_id).remove();
			get_total();
			get_srno();
		}			
	}
	
	function delete_row(obj)
	{
		var id = $(obj).attr("data-id");
		$('#row_id_'+id).remove();
		
	}	
	
	function add_row(obj)
	{
		var id = $(obj).attr("data-id");
		var data_id = getRandomInt(5);
		var html = '<tr id="row_id_'+data_id+'" data-id="'+data_id+'" ><td><input type="text" name="cust_service_dates_'+id+'[]" placeholder="Service Date" class="form-control datepicker" maxlength="100" value=""> </td><td><a href="javascript:;" onclick="delete_row(this);" data-id="'+data_id+'" class="btn btn-danger btn-xs"><i class="fa fa-close"></i></a></td></tr>';
		$("#table_"+id).append(html);
		$('.datepicker').datepicker({
				         format: 'dd-M-yyyy',
				         autoclose: true,
				         todayHighlight: true,

		           });	
	}	
	function getRandomInt(max) {
      return Math.floor(Math.random() * Math.floor(max));
    }
	
	function calculate_total(obj) {
		var id       = $(obj).attr("data-id");
		var gst_type = $("#cust_gst_type").val();
        var cust_pdt_qty           = parseFloat($("#cust_pdt_qty_"+id).val());		
        var cust_pdt_price         = parseFloat($("#cust_pdt_price_"+id).val());
		
		if(isNaN(cust_pdt_qty))   { cust_pdt_qty = 0;} 
		if(isNaN(cust_pdt_price)) { cust_pdt_price = 0;} 
		
	
		var total = cust_pdt_price*cust_pdt_qty;
			total = Math.round(parseFloat((total * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);

			var cust_pdt_gst_price     = parseFloat($("#cust_pdt_gst_price_"+id).val());		
            var cust_pdt_gst           = parseFloat($("#cust_pdt_gst_"+id).val());	
			
			if(isNaN(total))         { total = 0;} 	
			if(isNaN(cust_pdt_gst))  { cust_pdt_gst = 0;} 	
			if(isNaN(cust_pdt_gst_price)) { cust_pdt_gst_price = 0;} 
			
		 var gst = (total * cust_pdt_gst)/100;		
		 gst = Math.round(parseFloat((gst * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);
         cust_pdt_gst_price	 = gst + total;	 
		 $("#cust_pdt_gst_price_"+id).val(cust_pdt_gst_price);
		
		get_total();

       	
    }
function get_total()
{
	
	 var total_gst_price = 0;
	 $("#tbl_service_details").find(".form-control").each(function( j ) {
	 if( $(this).attr("name") == "cust_pdt_gst_price[]"){
			var gst_price = parseFloat($(this).val());
			if(isNaN(gst_price))   { gst_price = 0;} 
			total_gst_price = total_gst_price + gst_price;
			
		} 
   });	
   total_gst_price = Math.round(parseFloat((total_gst_price * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2); 
   $("#cust_total_amount").val(total_gst_price);	
	
}

function get_srno()
{
	var Srno = 1;
    $("#tbl_service_details").find(".sr_no").each(function( j ) {
	   $(this).html(Srno);
	   Srno++
   });
}

function clear_service_details(){
	 $("#tbl_service_details").html("");
	 $('#tbl_service_id').find('input[type=checkbox]:checked').removeAttr('checked');
}
function getIFSC(emp_bank_ifsc_code)
	{ 
	   $('#ifsc_code').html("");
		if(emp_bank_ifsc_code){
			$.ajax({
				url:base_url+"admin/getIFSC",
				type: "POST",
				data: {'ifsc_code':emp_bank_ifsc_code},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var data = JSON.parse(data);
					$("#ifsc_code").html(data.BRANCH);
					$("#bank_branch_address").val(data.ADDRESS);
					$("#bank_name").val(data.BANK);
					$("#bank_micr").val(data.MICR);
				}
			});
		}
	} 
</script>