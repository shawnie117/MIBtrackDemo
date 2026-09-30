<?php $role_id = $this->session->userdata('user_role_id');?>
<!-- Content Wrapper. Contains page content -->
 <div class="page-content-wrapper">
 <div class="page-content">
                                   
 <!-- BEGIN PAGE BASE CONTENT -->
 <div class="row">

<div class="col-md-12">
<div class="portlet light bordered">
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
	<li>
		<a href="<?php echo base_url()."/dashboard"?>">Home</a>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span class="active"><?php echo $page_title; ?></span>
	</li>
</ul>
<!-- END PAGE BREADCRUMB -->
<?php 
//echo "<pre/>"; print_r($my_details);die;
if(!empty($my_details)) {
$my_details = $my_details[0]; 
if($role_id !== SUPER_ADMIN_ROLE_ID && $role_id !== CUSTOMER_ROLE_ID){
      $empEducationList = isset($my_details['empEducationList']) && !empty($my_details['empEducationList'])?$my_details['empEducationList'][0]:"";
      $empBankList = isset($my_details['empBankList']) && !empty($my_details['empBankList'])?$my_details['empBankList'][0]:"";
      $empKycList = isset($my_details['empKycList']) && !empty($my_details['empKycList'])?$my_details['empKycList'][0]:"";
	  
}
					
 ?>
<div class="portlet-title tabbable-line">
	<div class="caption caption-md">
		<i class="icon-globe theme-font hide"></i>
		<span class="caption-subject font-blue-madison bold uppercase"><?php echo $page_title; ?></span>
	</div>
	<ul class="nav nav-tabs ">
		<li class="active">
			<a href="#tab_1_1" data-toggle="tab" aria-expanded="false">Basic Details</a>
		</li>
		<li>
			<a href="#tab_1_2" data-toggle="tab" aria-expanded="false">Contact Details</a>
		</li>
		 <?php if($role_id !== SUPER_ADMIN_ROLE_ID && $role_id !== CUSTOMER_ROLE_ID){ ?>
		<li>
			<a href="#tab_1_3" data-toggle="tab" aria-expanded="false">Bank Details</a>
		</li>
		<li>
			<a href="#tab_1_4" data-toggle="tab" aria-expanded="true">KYC Details</a>
		</li>
		 <?php } ?>
		 <?php if($role_id == CUSTOMER_ROLE_ID){ ?>
		 <li>
			<a href="#tab_1_5" data-toggle="tab" aria-expanded="true">Branch Details</a>
		</li>
		 <?php } ?>
	</ul>
</div>
<div class="portlet-body">
	<div class="tab-content  ">
		<!-- PERSONAL INFO TAB -->
		<div class="tab-pane active" id="tab_1_1">
				 <div class="portlet-body">
				 <?php if ($role_id == CUSTOMER_ROLE_ID){
						$cust_image      = $my_details['cust_img_path'];
					    $cust_image      = str_replace("getAuthApiKey",APIKEY,$cust_image);

					 ?>
				  <div class="profile-sidebar">
					<div class="portlet light profile-sidebar-portlet bordered">
						<!-- SIDEBAR USERPIC -->
						
							<img src="<?php echo isset($cust_image)?$cust_image:""; ?>" class="img-responsive" alt=""> 
						<!-- END SIDEBAR USERPIC -->
						<!-- SIDEBAR USER TITLE -->
						<div class="profile-usertitle">
							<div class="profile-usertitle-name"> <?php echo isset($my_details['cust_company_name'])?$my_details['cust_company_name']:""; ?> </div>
							<div class="profile-usertitle-job"> <?php echo isset($my_details['customer_name'])?$my_details['customer_name']:""; ?> </div>
						</div>
						<!-- END SIDEBAR USER TITLE -->
                       </div>
                    </div>
					  <div class="profile-content">					
				   <table class="table table-striped table-bordered table-advance table-hover">					
					<tbody>
						
						<tr><th> Name </th><td><?php echo isset($my_details['customer_name'])?$my_details['customer_name']:""; ?> </td>	</tr>		
						 <tr><th> Company Name </th><td><?php echo isset($my_details['cust_company_name'])?$my_details['cust_company_name']:""; ?> </td>	</tr>		
						 <tr><th> Unique Id </th><td><?php echo isset($my_details['customer_uniqueid'])?$my_details['customer_uniqueid']:""; ?> </td>	</tr>		
						 <tr><th> Contact Person</th><td><?php echo isset($my_details['customer_contact_person'])?$my_details['customer_contact_person']:""; ?> </td>	</tr>
						 <tr><th> Contact No.</th><td><?php echo isset($my_details['cust_landline'])?$my_details['cust_landline']:""; ?> </td>	</tr>
						
						 <tr><th> Website.</th><td><?php echo isset($my_details['cust_website'])?$my_details['cust_website']:""; ?> </td>	</tr>
						 <tr><th> PAN No.</th><td><?php echo isset($my_details['cust_panno'])?$my_details['cust_panno']:""; ?> </td>	</tr>
						 <tr><th> GST No.</th><td><?php echo isset($my_details['customer_gstno'])?$my_details['customer_gstno']:""; ?> </td>	</tr>
					</tbody>
					</table>	
						</div>
				 <?php }?>
				 <?php if($role_id == SUPER_ADMIN_ROLE_ID){ ?>
				 <div class="profile-sidebar">
					<div class="portlet light profile-sidebar-portlet bordered">
						<!-- SIDEBAR USERPIC -->
						<center>
							<img src="<?php echo isset($my_details['company_logo'])?$my_details['company_logo']:""; ?>" class="img-responsive" alt=""> </center>
						<!-- END SIDEBAR USERPIC -->
						<!-- SIDEBAR USER TITLE -->
						<div class="profile-usertitle">
							<div class="profile-usertitle-name"> <?php echo isset($my_details['company_name'])?$my_details['company_name']:""; ?> </div>
						</div>
						<!-- END SIDEBAR USER TITLE -->
                       </div>
                    </div>
				   <div class="profile-content">					
				   <table class="table table-striped table-bordered table-advance table-hover">					
					<tbody>
						
						<tr><th> Company  Name </th><td><?php echo isset($my_details['company_name'])?$my_details['company_name']:""; ?> </td>	</tr>
						<tr><th>Owner Name </th><td><?php echo isset($my_details['company_owner'])?$my_details['company_owner']:""; ?> </td>	</tr>
						<tr><th>Website </th><td><?php echo isset($my_details['company_website'])?$my_details['company_website']:""; ?> </td>	</tr>
						<tr><th> GST No. </th><td><?php echo isset($my_details['company_gstno'])?$my_details['company_gstno']:""; ?> </td>	</tr>
					</tbody>
					</table>	
						</div>
				 <?php } else if($role_id !== SUPER_ADMIN_ROLE_ID && $role_id !== CUSTOMER_ROLE_ID){ ?>
				
					 <table class="table table-striped table-bordered table-advance table-hover">
					 <tbody>
				 	 		
						<tr><th> Name </th><td><?php echo isset($my_details['emp_name'])?$my_details['emp_name']:""; ?> </td>	</tr>					
						<tr><th> Role</th><td><?php echo isset($my_details['permission_name'])?$my_details['permission_name']:""; ?> </td>	</tr>
						<tr><th> Username</th><td><?php echo isset($my_details['user_name'])?$my_details['user_name']:""; ?> </td>	</tr>
						<tr><th> Password</th><td><?php echo isset($my_details['user_pswd'])?$my_details['user_pswd']:""; ?> </td>	</tr>						
						<tr><th> Reporting To </th><td><?php echo isset($my_details['emp_rpt_name'])?$my_details['emp_rpt_name']:""; ?> </td>	</tr>
						 <tr><th>Education </th><td><?php echo isset($empEducationList['edu_name'])?$empEducationList['edu_name']:""; ?> </td>	</tr>					
						<tr><th> Education Details</th><td><?php echo isset($empEducationList['emp_edu_other_details'])?$empEducationList['emp_edu_other_details']:""; ?> </td>	</tr>
						
						 <?php } ?>		 
						
					   </tbody>
					 </table>	
					</div>
			</div>
		<!-- END PERSONAL INFO TAB -->
		<!-- CHANGE AVATAR TAB -->
		<div class="tab-pane" id="tab_1_2">
			
		 <div class="portlet-body">
				   <table class="table table-striped table-bordered table-advance table-hover">	 
				  		
					<tbody>
					   <?php if($role_id == SUPER_ADMIN_ROLE_ID){ ?>		
						<tr><th> Contact Person </th><td><?php echo isset($my_details['company_contact_person'])?$my_details['company_contact_person']:""; ?> </td>	</tr>
						<tr><th> Address </th><td><?php echo isset($my_details['company_address'])?$my_details['company_address']:""; ?> </td>	</tr>
						<tr><th>Area </th><td><?php echo isset($my_details['company_area'])?$my_details['company_area']:""; ?> </td>	</tr>
						<tr><th>Contact No. </th><td><?php echo isset($my_details['company_contact1'])?$my_details['company_contact1']:""; ?> </td>	</tr>
						<tr><th> Alternate No.</th><td><?php echo isset($my_details['company_contact2'])?$my_details['company_contact2']:""; ?> </td>	</tr>
						<tr><th> Email Id.</th><td><?php echo isset($my_details['company_emailid'])?$my_details['company_emailid']:""; ?> </td>	</tr>						
						<?php } else if($role_id !== SUPER_ADMIN_ROLE_ID && $role_id !== CUSTOMER_ROLE_ID){ ?>			
							
							
						    <tr><th> Mobile No </th><td><?php echo isset($my_details['emp_mob1'])?$my_details['emp_mob1']:""; ?> </td><th>Mobile No2 </th><td><?php echo isset($my_details['emp_mob2'])?$my_details['emp_mob2']:""; ?> </td>	</tr>							
							<tr><th>Email Id  </th><td colspan="3"><?php echo isset($my_details['emp_emailid'])?$my_details['emp_emailid']:""; ?> </td>	</tr>
							<tr><th colspan="4">Current Address Details : </th></tr>
							<tr><th>Address </th><td colspan="3"><?php echo isset($my_details['emp_address'])?$my_details['emp_address']:""; ?> </td>	</tr>
							<tr><th>State </th><td><?php echo isset($my_details['state_name'])?$my_details['state_name']:""; ?> </td><th>District </th><td colspan="3"><?php echo isset($my_details['dist_name'])?$my_details['dist_name']:""; ?> </td>	</tr>
							<tr><th>City </th><td><?php echo isset($my_details['city_name'])?$my_details['city_name']:""; ?>  </td><th>Pincode </th><td><?php echo isset($my_details['emp_pincode'])?$my_details['emp_pincode']:""; ?> </td>	</tr>
							<tr><th>LandMark </th><td><?php echo isset($my_details['emp_landmark'])?$my_details['emp_landmark']:""; ?>  </td><th>Area </th><td><?php echo isset($my_details['emp_areaname'])?$my_details['emp_areaname']:""; ?> </td>	</tr>
							<tr><th colspan="4">Permanent Address Details : </th></tr>
							
							<tr><th>Address </th><td colspan="3"><?php echo isset($my_details['emp_perm_address'])?$my_details['emp_perm_address']:""; ?> </td>	</tr>
							<tr><th>State </th><td><?php echo isset($my_details['emp_perm_state_name'])?$my_details['emp_perm_state_name']:""; ?> </td><th>District </th><td colspan="3"><?php echo isset($my_details['emp_perm_dist_name'])?$my_details['emp_perm_dist_name']:""; ?> </td>	</tr>
							<tr><th>City </th><td><?php echo isset($my_details['emp_perm_city_name'])?$my_details['emp_perm_city_name']:""; ?>  </td><th>Pincode </th><td><?php echo isset($my_details['emp_perm_pincode'])?$my_details['emp_perm_pincode']:""; ?> </td>	</tr>
							<tr><th>LandMark </th><td><?php echo isset($my_details['emp_perm_landmark'])?$my_details['emp_perm_landmark']:""; ?>  </td><th>Area </th><td><?php echo isset($my_details['emp_perm_areaname'])?$my_details['emp_perm_areaname']:""; ?> </td>	</tr>
							
						<?php  } else if ($role_id == CUSTOMER_ROLE_ID){ ?>
						 <tr><th> Mobile No </th><td><?php echo isset($my_details['customer_contact'])?$my_details['customer_contact']:""; ?> </td></tr>
						 <tr><th>Alternate Mobile No. </th><td><?php echo isset($my_details['customer_alt_contact'])?$my_details['customer_alt_contact']:""; ?> </td>	</tr>							
						 <tr><th>Email Id </th><td><?php echo isset($my_details['customer_contact_email'])?$my_details['customer_contact_email']:""; ?> </td>	</tr>							
						 <tr><th>Address</th><td><?php echo isset($my_details['customer_address'])?$my_details['customer_address']:""; ?> </td>	</tr>							
						 <tr><th>Area</th><td><?php echo isset($my_details['customer_area'])?$my_details['customer_area']:""; ?> </td>	</tr>							
						 <tr><th>City</th><td><?php echo isset($my_details['customer_city_name'])?$my_details['customer_city_name']:""; ?> </td>	</tr>							
						 <tr><th>State</th><td><?php echo isset($my_details['customer_state_name'])?$my_details['customer_state_name']:""; ?> </td>	</tr>							
						 <tr><th>District</th><td><?php echo isset($my_details['customer_dist_name'])?$my_details['customer_dist_name']:""; ?> </td>	</tr>							
						 <tr><th>Pincode</th><td><?php echo isset($my_details['customer_pin'])?$my_details['customer_pin']:""; ?> </td>	</tr>							
						<?php  }  ?>
						
					</tbody>
					</table>	
					</div>
		</div>

		<?php if($role_id !== SUPER_ADMIN_ROLE_ID && $role_id !== CUSTOMER_ROLE_ID){ ?>
		<div class="tab-pane" id="tab_1_3">
		 <div class="portlet-body">
			 <table class="table table-striped table-bordered table-advance table-hover">
					 <tbody>
						<tr><th>Account Name </th><td><?php echo isset($empBankList['emp_bank_account_name'])?$empBankList['emp_bank_account_name']:""; ?> </td>	</tr>					
						<tr><th> Account Number</th><td><?php echo isset($empBankList['emp_bank_account_no'])?$empBankList['emp_bank_account_no']:""; ?> </td>	</tr>
						<tr><th> Bank Name</th><td><?php echo isset($empBankList['emp_bank_name'])?$empBankList['emp_bank_name']:""; ?> </td>	</tr>	
						<tr><th> Branch</th><td><?php echo isset($empBankList['emp_bank_branch_addrs'])?$empBankList['emp_bank_branch_addrs']:""; ?> </td>	</tr>
						<tr><th> IFSC Code</th><td><?php echo isset($empBankList['emp_bank_ifsc'])?$empBankList['emp_bank_ifsc']:""; ?> </td>	</tr>
						<tr><th> Added By</th><td><?php echo isset($empBankList['emp_bank_addedby_name'])?$empBankList['emp_bank_addedby_name']:""; ?> </td>	</tr>
						<tr><th> Added On</th><td><?php echo isset($empBankList['emp_bank_sdate_n'])?$empBankList['emp_bank_sdate_n']:""; ?> </td>	</tr>
				
					   </tbody>
					 </table>	
		    </div>
		</div>
		<!-- END CHANGE PASSWORD TAB -->
		<!-- PRIVACY SETTINGS TAB -->
		<div class="tab-pane" id="tab_1_4">
		 <div class="portlet-body">
			 <table class="table table-striped table-bordered table-advance table-hover">
					 <tbody>
						
						<tr><th>Address Proof </th><td><?php echo isset($empKycList['emp_addrs_prf_type'])?$empKycList['emp_addrs_prf_type']:""; ?> </td>	</tr>					
						<tr><th>Address Proof No. </th><td><?php echo isset($empKycList['emp_addrs_prf_no'])?$empKycList['emp_addrs_prf_no']:""; ?> </td>	</tr>
						
						<?php $image = "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image";
						
						      $image1      = $empKycList['emp_addrs_prf_img'];
							  $image1      = str_replace("getAuthApiKey",APIKEY,$image1);
							  $image1     = !empty($image1)?$image1:$image;
							  
							  $image2     = $empKycList['emp_kyc_photo1'];
							  $image2     = str_replace("getAuthApiKey",APIKEY,$image2);
							  $image2     = !empty($image2)?$image2:$image;
							  
							  ?>
							  
						<tr><th>ID Proof </th><td><?php echo isset($empKycList['emp_kyc_type1'])?$empKycList['emp_kyc_type1']:""; ?> </td>	</tr>					
						<tr><th>ID Proof No. </th><td><?php echo isset($empKycList['emp_kyc_idnum1'])?$empKycList['emp_kyc_idnum1']:""; ?> </td></tr>					
						
					   </tbody>
					 </table>	
					 
					  <div class="form-group">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
									<img src="<?php echo $image1;?>" alt=""> </div>
								<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"> </div>
								<br/> Address Proof
							</div>
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
									<img src="<?php echo $image2;?>" alt=""> </div>
								<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"> </div>
								<br/> ID Proof
							</div>
						</div>
						
		    </div>
		</div>
		<?php } ?>
		<?php if($role_id == CUSTOMER_ROLE_ID){ ?>
		<div class="tab-pane" id="tab_1_5">
		 <div class="portlet-body">
			 <table class="table table-striped table-bordered table-advance table-hover">
					 <tbody>
												 
						 <tr><th> Branch </th><td><?php echo isset($my_details['branch_name'])?$my_details['branch_name']:""; ?> </td>	</tr>
						<tr><th> Contact Person</th><td><?php echo isset($my_details['branch_contact_person'])?$my_details['branch_contact_person']:""; ?> </td>	</tr>						 
						 <tr><th> Branch Address </th><td><?php echo isset($my_details['branch_address'])?$my_details['branch_address']:""; ?> </td>	</tr>		
						 <tr><th> City </th><td><?php echo isset($my_details['city_name'])?$my_details['city_name']:""; ?> </td>	</tr>		
						 <tr><th> Contact No. </th><td><?php echo isset($my_details['branch_contact'])?$my_details['branch_contact']:""; ?> </td>	</tr>		
						 <tr><th> Alternate Contact No. </th><td><?php echo isset($my_details['branch_contact1'])?$my_details['branch_contact1']:""; ?> </td>	</tr>
				
					   </tbody>
					 </table>	
		    </div>
		</div>
		<?php } ?>
		<!-- END PRIVACY SETTINGS TAB -->
	</div>
</div>
	<?php } else {  ?>
     <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
           Account Details Not Found !!!
    </div>
   <?php } ?> 
</div>
</div>



</div>
</div>
</div>
</div>
<!-- END PAGE BASE CONTENT -->

