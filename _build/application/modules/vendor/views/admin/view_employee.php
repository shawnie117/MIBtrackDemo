<?php 
$vendor  = $this->session->userdata('vendor');
$role_id = $vendor['user_role_id'];
?>
<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	  <!--div class="page-head">		
		<div class="page-title">
			<h1><?php echo $page_title; ?></h1>
		</div>	
	   </div-->
	
      <div class="row">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url(get_module()."/admin/employee_report")?>">All Employees </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
            <div class="portlet-title">
               <div class="caption">
				 <i class="font-blue-madison icon-user"></i>
                  <!-- <i class="font-green-sharp icon-basket-loaded"></i> -->
                  <span class="caption-subject font-blue-madison bold "><?php echo $page_title; ?></span>
	
			   </div>
            </div>
            <div class="row">
               
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
                 <div class="portlet-body form">
                  <div class="col-md-12">
				  
				      <?php if(!empty($details)){
						$details = html_escape($details);  
						$id =  base64_encode($details['emp_id']);
						$status  = $details['emp_status'];
						//echo "<pre/>"; print_r($details);die;
					  ?>
                    
					  <div class="form-body">
					   <div class="portlet-body">
					   <div class="col-md-12">
					   <div class="col-md-6">
					      <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">Employee Basic Details</span>
							   </div>
							   <hr/>
						   </div>	
                            <div >							   
					   <table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
							<tr><th> Employee Name </th><td><?php echo isset($details['emp_name'])?$details['emp_name']:""; ?> </td></tr>
							<tr><th> Designation  </th><td><?php echo isset($details['permission_name'])?$details['permission_name']:""; ?> </td>	</tr>

							<tr><th> UserName </th><td><?php echo isset($details['user_name'])?$details['user_name']:""; ?> </td></tr>
							<tr><th>Password </th><td><?php echo isset($details['user_pswd'])?$details['user_pswd']:""; ?> </td></tr>	
							<tr><th>Loc Track</th><td><?php echo isset($details['emp_location_tracking']) ? $details['emp_location_tracking'] : ""; ?> </td> </tr>						
							<tr><th>Date of Birth</th><td><?php echo isset($details['emp_dob']) ? date("d-M-Y", strtotime($details['emp_dob'])) : ""; ?> </td> </tr>						
							<tr><th>Joining Date</th><td><?php echo isset($details['emp_joining_date']) ? date("d-M-Y", strtotime($details['emp_joining_date'])) : ""; ?> </td> </tr>						
							<tr><th> Department  </th><td><?php echo isset($details['dept_name'])?$details['dept_name']:""; ?> </td>	</tr>
							<tr><th> Sub Department  </th><td><?php echo isset($details['sub_dept_name'])?$details['sub_dept_name']:""; ?> </td>	</tr>
							<tr><th> Education  </th><td><?php echo isset($details['empEducationList'][0]['edu_name'])?$details['empEducationList'][0]['edu_name']:""; ?> </td>	</tr>
							<tr><th> Other Education Details  </th><td><?php echo isset($details['empEducationList'][0]['emp_edu_other_details'])?$details['empEducationList'][0]['emp_edu_other_details']:""; ?> </td>	</tr>
							<tr><th> Reporting To  </th><td><?php echo isset($details['emp_rpt_name'])?$details['emp_rpt_name']:""; ?> </td>	</tr>
					    	<tr><th> Added By </th><td><?php echo isset($details['emp_addedby_name'])?$details['emp_addedby_name']:""; ?> </td>	</tr>
							<tr><th>Added On </th><td><?php echo isset($details['emp_sdate_n'])?$details['emp_sdate_n']:""; ?> </td>	</tr>
							<tr><th>Status </th>
							<td> <?php  if($status=="Active") { 				  
								  echo "<span class='label label-success'>Active</span>"; 
								  } else if($status=="Deactivated") {		  
								  echo "<span class='label label-danger'>Deactivated</span>"; 
								}  ?> </td>
							</tr>
							<?php  if($status=="Deactivated") { ?>
							<tr><th> Deactivated by </th><td><?php echo isset($details['emp_deactvby_name'])?$details['emp_deactvby_name']:""; ?> </td>	</tr>
						    <tr><th> Deactivation date </th><td><?php echo isset($details['emp_deactv_date_n'])?$details['emp_deactv_date_n']:""; ?> </td>	</tr>
						   <?php } ?> 
						    <?php  if(!empty($details['branch_details'])) { 
							$branch_details =  $details['branch_details'];
						   ?>
							<tr><th colspan="2" class="text-danger"> Branch Details</th></tr>	<tr><th> Branch Name </th><td><?php echo isset($branch_details['branch_name'])?$branch_details['branch_name']:""; ?> </td>	</tr>				  
							<tr><th> Branch Contact </th><td><?php echo isset($branch_details['branch_contact'])?$branch_details['branch_contact']:""; ?> </td>	</tr>  
							<tr><th> Branch Address </th><td><?php echo isset($branch_details['branch_address'])?$branch_details['branch_address']:""; ?> </td>	</tr>				  
						 <?php } ?> 				
							</tbody>
                        </table>
						</div>
						</div>
						 <div class="col-md-6">
						 
						  <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-pointer"></i>
								  <span class="caption-subject font-red-mint sbold">Address Details</span>
							   </div>
							   <hr/>
						   </div>
						<div >							   
						<table class="table table-striped table-bordered table-advance table-hover">						
						<tbody>
						    <tr><th> Mobile No1 </th><td><?php echo isset($details['emp_mob1'])?$details['emp_mob1']:""; ?> </td><th>Mobile No2 </th><td><?php echo isset($details['emp_mob2'])?$details['emp_mob2']:""; ?> </td>	</tr>							
							<tr><th>Email Id  </th><td colspan="3"><?php echo isset($details['emp_emailid'])?$details['emp_emailid']:""; ?> </td>	</tr>
							<tr><th colspan="4" class="text-danger">Current Address Details : </th></tr>
							<tr><th>Address </th><td colspan="3"><?php echo isset($details['emp_address'])?$details['emp_address']:""; ?> </td>	</tr>
							<tr><th>State </th><td><?php echo isset($details['emp_state'])?$details['emp_state']:""; ?> </td><th>District </th><td colspan="3"><?php echo isset($details['emp_dist'])?$details['emp_dist']:""; ?> </td>	</tr>
							<tr><th>City </th><td><?php echo isset($details['emp_city'])?$details['emp_city']:""; ?>  </td><th>Pincode </th><td><?php echo isset($details['emp_pincode'])?$details['emp_pincode']:""; ?> </td>	</tr>
							<tr><th>LandMark </th><td><?php echo isset($details['emp_landmark'])?$details['emp_landmark']:""; ?>  </td><th>Area </th><td><?php echo isset($details['emp_areaname'])?$details['emp_areaname']:""; ?> </td>	</tr>
							<tr><th colspan="4" class="text-danger">Permanent Address Details : </th></tr>
							
							<tr><th>Address </th><td colspan="3"><?php echo isset($details['emp_perm_address'])?$details['emp_perm_address']:""; ?> </td>	</tr>
							<tr><th>State </th><td><?php echo isset($details['emp_perm_state'])?$details['emp_perm_state']:""; ?> </td><th>District </th><td colspan="3"><?php echo isset($details['emp_perm_dist'])?$details['emp_perm_dist']:""; ?> </td>	</tr>
							<tr><th>City </th><td><?php echo isset($details['emp_perm_city'])?$details['emp_perm_city']:""; ?>  </td><th>Pincode </th><td><?php echo isset($details['emp_perm_pincode'])?$details['emp_perm_pincode']:""; ?> </td>	</tr>
							<tr><th>LandMark </th><td><?php echo isset($details['emp_perm_landmark'])?$details['emp_perm_landmark']:""; ?>  </td><th>Area </th><td><?php echo isset($details['emp_perm_areaname'])?$details['emp_perm_areaname']:""; ?> </td>	</tr>
						
					
							</tbody>
                        </table>
						</div>
						</div>
						</div>
						<div class="col-md-12">
						  <div class="col-md-6">
						  <br/>
					      <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-briefcase"></i>
								  <span class="caption-subject font-red-mint sbold">KYC Details</span>
							   </div>
							   <hr/>
						   </div>	
												   
					   <table class="table table-striped table-bordered table-advance table-hover">
						<tbody>
							<tr><th> ID Proof Type </th><td><?php echo isset($details['empKycList'][0]['emp_kyc_type1'])?$details['empKycList'][0]['emp_kyc_type1']:""; ?> </td></tr>
							<tr><th> ID Proof No.</th><td><?php echo isset($details['empKycList'][0]['emp_kyc_idnum1'])?$details['empKycList'][0]['emp_kyc_idnum1']:""; ?> </td></tr>
							
							<tr><th> Address Proof Type</th><td><?php echo isset($details['empKycList'][0]['emp_addrs_prf_type'])?$details['empKycList'][0]['emp_addrs_prf_type']:""; ?> </td></tr>
							<tr><th> Address Proof No.</th><td><?php echo isset($details['empKycList'][0]['emp_addrs_prf_no'])?$details['empKycList'][0]['emp_addrs_prf_no']:""; ?> </td></tr>
						</tbody>
						</table>
						</div>
						  <div class="col-md-6">
						  <br/>
					      <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-wallet"></i>
								  <span class="caption-subject font-red-mint sbold">Employee Bank Details</span>
							   </div>
							   <hr/>
						   </div>
                      								   
					   <table class="table table-striped table-bordered table-advance table-hover">
						<tbody>
						<tr><th width="30%"> Account Name</th><td><?php echo isset($details['empBankList'][0]['emp_bank_account_name'])?$details['empBankList'][0]['emp_bank_account_name']:""; ?> </td></tr>
						<tr><th> Bank Name </th><td><?php echo isset($details['empBankList'][0]['emp_bank_name'])?$details['empBankList'][0]['emp_bank_name']:""; ?> </td></tr>
						<tr><th> Account No </th><td><?php echo isset($details['empBankList'][0]['emp_bank_account_no'])?$details['empBankList'][0]['emp_bank_account_no']:""; ?> </td></tr>
						<tr><th> IFSC Code </th><td><?php echo isset($details['empBankList'][0]['emp_bank_ifsc'])?$details['empBankList'][0]['emp_bank_ifsc']:""; ?> </td></tr>
						<tr><th> Branch Address </th><td><?php echo isset($details['empBankList'][0]['emp_bank_branch_addrs'])?$details['empBankList'][0]['emp_bank_branch_addrs']:""; ?> </td></tr>
						</tbody>
						</table>
						</div>
						</div>
					
						
						  <div class="col-md-12">
						  <br/>
					      <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-picture"></i>
								  <span class="caption-subject font-red-mint sbold">Employee KYC Download</span>
							   </div>
							   <hr/>
						   </div>			
					   <table class="table table-striped table-bordered table-advance table-hover">
						<tbody>
							<tr><th> ID Proof </th><th> Address Proof </th><th> Employee Photo</th></tr>
							<tr><td> 
							<?php $image1      = $details['empKycList'][0]['emp_kyc_photo1'];
								  $image1      = str_replace("getAuthApiKey",APIKEY,$image1);?>
								<ul class="list-unstyled small fileList thumbs">
									<li><a href="<?php echo $image1; ?>"  class="fancybox-button" data-rel="fancybox-button"><img title="ID Proof Image" src="<?php echo $image1; ?>"  alt="<?php echo $details['empKycList'][0]['emp_kyc_type1']; ?>" class="img-rounded"><span class="file-name"></span> </a></li>
									</ul>
								<a href="<?php echo $image1; ?>" download="<?php echo $details['empKycList'][0]['emp_kyc_type1']; ?>">Download</a>
							</td>
							<td>
							<?php $image2      = $details['empKycList'][0]['emp_addrs_prf_img'];
								  $image2      = str_replace("getAuthApiKey",APIKEY,$image2);?>
								<ul class="list-unstyled small fileList thumbs">
									<li><a href="<?php echo $image2; ?>"  class="fancybox-button" data-rel="fancybox-button"><img title="Address Proof" src="<?php echo $image2; ?>"  alt="<?php echo $details['empKycList'][0]['emp_addrs_prf_type']; ?>" class="img-rounded"><span class="file-name"></span></a> </li>
									</ul>
									<a href="<?php echo $image2; ?>" download="<?php echo $details['empKycList'][0]['emp_addrs_prf_type']; ?>">Download</a>
							</td>
							<td>
							<?php $image3      = $details['emp_image_path'];
								  $image3      = str_replace("getAuthApiKey",APIKEY,$image3);?>
								<ul class="list-unstyled small fileList thumbs">
									<li><a href="<?php echo $image3; ?>"  class="fancybox-button" data-rel="fancybox-button"><img title="Employee Photo" src="<?php echo $image3; ?>"  alt="<?php echo $details['emp_name']; ?>" class="img-rounded"><span class="file-name"></span> </a></li>
									</ul>
									<a href="<?php echo $image3; ?>" download="<?php echo $details['emp_name']; ?>">Download</a>
							</td>
							</tr>
						</tbody>
						</table>
						
						</div>
						</div>
										  
						<div class="form-actions ">
						 <div class="col-md-offset-3 col-md-7">  
												   	
							 <?php if($status=="Active")	{ ?>	
								
							  <a href="<?php echo get_module_path();?>admin/edit_employee/?id=<?php echo $id; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>	
														
								<a  data-toggle="modal" data-target="#form_modal" class="btn btn-danger"  href="<?php echo get_module_path();?>admin/deactivate_employee/?ref_id=<?php echo $id; ?>" title="Deactivate" ><i class="fa fa-ban"></i> Deactivate</a>

							<?php }	?>						
					
							 <?php if($status=="Deactivated")	{ ?>
							 
							 <a  data-toggle="modal" data-target="#form_modal" class="btn btn-success"  href="<?php echo get_module_path();?>admin/reactivate_employee/?ref_id=<?php echo $id; ?>" title="Re-Activate" ><i class="fa fa-check"></i> Re-Activate</a>
							 
							 <?php }	?>	

						  
						   <!-- <a href="<?php echo get_module_path();?>admin/employee_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                       add by ritika 25 may  -->


						<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;
?>

<a href="<?php echo get_module_path();?>admin/employee_report/?page=<?php echo $page; ?>&history=back"
   class="btn btn-danger">
   <i class="fa fa-history"></i>Back
</a>
						
						</div>
                        </div>
						 </div>
					
			   
                        <!-- /.box-body -->
						<?php } else 	{ ?>
				  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     Employee Details Not Found !!!
                  </div>
						<?php } ?>
                        
                     
                  </div>
               </div>
            </div>
         </div>
         <!-- END PAGE BASE CONTENT -->
      </div>
      <!-- END CONTENT BODY -->
   </div>   
   </div>

<!-- START MODAL -->
		<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog modal-md">
			<div class="modal-content">			
			</div>
			</div>
		</div>	
<!--END START MODAL -->   
  <!-- END CONTENT -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {

  $('#confirm-deactivate').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });
$("#form_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    });   
  
});
</script>