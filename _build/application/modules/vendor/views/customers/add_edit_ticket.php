<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
	<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; } if($action=="AssignC"){ $icon = "icon-share-alt"; }  ?>
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
	<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
	<li><a href="<?php echo base_url(get_module()."/customers/ticket_report")?>">All Ticket Report </a><i class="fa fa-circle"></i></li>
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
				  <?php if($action=="Add"){ 
				    $formaction = "add_ticket";
				    }
					if($action=="Edit"){ 
				    $formaction = "edit_ticket/?id=".base64_encode($id);
					
					//echo "<pre/>"; print_r($details);die;
					$clm_id = isset($details['clm_id'])?$details['clm_id']:"";
					$clm_name = isset($details['clm_name'])?$details['clm_name']:"";
					$customer_name = isset($details['customer_name'])?$details['customer_name']:"";
					$clm_contact = isset($details['clm_contact'])?$details['clm_contact']:"";
					$customer_contact = isset($details['customer_contact'])?$details['customer_contact']:"";
					$clm_adress = isset($details['clm_adress'])?$details['clm_adress']:"";
					$customer_address = isset($details['customer_address'])?$details['customer_address']:"";
					$ticket_detailList = isset($details['ticket_detailList'])?$details['ticket_detailList']:"";
					
					$ticket_assign_to = !empty($ticket_detailList)?$ticket_detailList[0]['ticket_assign_to']:"";
					
					$ticket_date = isset($details['ticket_date'])?date("d-m-Y",strtotime($details['ticket_date']))." ".$details['ticket_time']:"";
					
					$name    = !empty($clm_name)?$clm_name:$customer_name;
					$contact = !empty($clm_contact)?$clm_contact:$customer_contact;
					$adress  = !empty($clm_adress)?$clm_adress:$customer_address;
						
					$customer_id = isset($details['customer_id'])?$details['customer_id']:"";
					// $cust_type = !empty($clm_id)?"Leads":"Customers";
					// $ref_id    = !empty($clm_id)?$clm_id:$customer_id;
					if (!empty($clm_id)) {
						$cust_type = "Leads";
						$ref_id = $clm_id;
					} elseif (!empty($customer_id)) {
						$cust_type = "Customers";
						$ref_id = $customer_id;
					} else {
						$cust_type = "Others";
						$ref_id = 0;
					}
				   
					 $html = '<div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">'.$cust_type.' Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
						   <table class="table table-bordered table-hover">
							<tbody>
								<tr ><th width="20%"> Name  </th><td>'.$name.'</td></tr>	<tr ><th> Contact  </th><td>'.$contact.'</td></tr>
								<tr ><th> Address  </th><td>'.$adress.'</td></tr></tbody></table>';   
					
					 }
					 if($action=="AssignC"){ 
				    $formaction = "assign_complaint_ticket/?id=".base64_encode($id);
					
					//echo "<pre/>"; print_r($details);die;
					$clm_id = isset($details['clm_id'])?$details['clm_id']:"";
					$clm_name = isset($details['clm_name'])?$details['clm_name']:"";
					$customer_name = isset($details['customer_name'])?$details['customer_name']:"";
					$clm_contact = isset($details['clm_contact'])?$details['clm_contact']:"";
					$customer_contact = isset($details['customer_contact'])?$details['customer_contact']:"";
					$clm_adress = isset($details['clm_adress'])?$details['clm_adress']:"";
					$customer_address = isset($details['customer_address'])?$details['customer_address']:"";
					$cmpltDetailsList = isset($details['cmpltDetailsList'])?$details['cmpltDetailsList']:"";
					
					$ticket_assign_to = !empty($cmpltDetailsList)?$cmpltDetailsList[0]['complaint_assign_to']:"";
					
					$ticket_date = isset($details['ticket_date'])?date("d-m-Y",strtotime($details['ticket_date']))." ".$details['ticket_time']:"";
					
					$name    = !empty($clm_name)?$clm_name:$customer_name;
					$contact = !empty($clm_contact)?$clm_contact:$customer_contact;
					$adress  = !empty($clm_adress)?$clm_adress:$customer_address;
						
					$customer_id = isset($details['customer_id'])?$details['customer_id']:"";
					// $cust_type = !empty($clm_id)?"Leads":"Customers";
					// $ref_id    = !empty($clm_id)?$clm_id:$customer_id;
					if (!empty($clm_id)) {
						$cust_type = "Leads";
						$ref_id = $clm_id;
					} elseif (!empty($customer_id)) {
						$cust_type = "Customers";
						$ref_id = $customer_id;
					} else {
						$cust_type = "Others";
						$ref_id = 0;
					}
				   
					 $html = '<div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">'.$cust_type.' Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>
						   <table class="table table-bordered table-hover">
							<tbody>
								<tr ><th width="20%"> Name  </th><td>'.$name.'</td></tr>	<tr ><th> Contact  </th><td>'.$contact.'</td></tr>
								<tr ><th> Address  </th><td>'.$adress.'</td></tr></tbody></table>';   
					
					 }
					?>
					
                     <form action="<?php echo get_module_path().'customers/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					    <div class="portlet-body">
						<div class="col-md-12"> 
						  <div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">Basic Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>					   
					  
					    <?php if($action=="Edit" || $action=="AssignC"){ ?>
                           <input type="hidden" name="id" value="<?php echo $id; ?>">
                           <input type="hidden" name="cust_type"  id="cust_type" value="<?php echo $cust_type; ?>">
                           <input type="hidden" name="ref_id"  id="ref_id" value="<?php echo $ref_id; ?>">
						   
						   <?php } ?>
						<?php if($action=="Edit" || $action=="AssignC"){ ?>
						 <div class="form-group col-md-8">
                           <label for="cust_type"   >Customer Type</label><span style="margin-right:12px;"><?php echo REQUIRED_STAR; ?></span>
                          <label style="margin-right:12px;"><input type="radio" name="cust_type1" value="Customers" <?php echo $cust_type=="Customers"?"checked":""; ?> disabled /> Customers</label>
                          <label style="margin-right:12px;"><input type="radio" name="cust_type1" value="Leads"  <?php echo $cust_type=="Leads"?"checked":""; ?> disabled /> Leads</label>
                        </div> 
						 
						<?php } ?>
						
			             <!-- <?php if($action=="Add"){ ?>
						 <div class="form-group col-md-8">
                           <label for="cust_type">Customer Type</label><?php echo REQUIRED_STAR; ?>
                          <label><input type="radio" name="cust_type" value="Customers" onclick="get_customers();" /> Customers</label>
                          <label><input type="radio" name="cust_type" value="Leads" onclick="get_leads();" /> Leads</label>
						  <label><input type="radio" name="cust_type" value="Others"  onclick="" ?> disabled /> Others</label>
						  <span id="radio_err" class="text-danger"></span>
						    <?php echo form_error('cust_type','<span class="text-danger">','</span>'); ?>
                        </div> 
						 
						
						  <div class="form-group col-md-8">
                           <label for="ref_id"> Lead/Customer</label><?php echo REQUIRED_STAR; ?>
                           <select class="form-control selectpicker" name="ref_id" id="ref_id" onchange="get_ref_details(this);" data-live-search="true">
						   </select>
						    <?php echo form_error('ref_id','<span class="text-danger">','</span>'); ?>
                        </div> 
						<?php } ?> -->

						<?php if($action=="Add"){ ?>
    <div class="form-group col-md-8">
        <label for="cust_type"   >Customer Type</label><span style="margin-right:12px;"><?php echo REQUIRED_STAR; ?></span>
        <label style="margin-right:12px;"><input type="radio" name="cust_type" value="Customers" onclick="get_customers();" /> Customers</label>
        <label style="margin-right:12px;"><input type="radio" name="cust_type" value="Leads" onclick="get_leads();" /> Leads</label>
		<label><input type="radio" name="cust_type" value="Others" <?php echo isset($cust_type) && $cust_type=="Others"?"checked":""; ?> onclick="get_others();" /> Others</label>
        <span id="radio_err" class="text-danger"></span>
        <?php echo form_error('cust_type','<span class="text-danger">','</span>'); ?>
    </div> 

    <div class="form-group col-md-12">
        <label for="ref_id">Lead/Customer</label><?php echo REQUIRED_STAR; ?>
        <select class="form-control selectpicker" name="ref_id" id="ref_id" onchange="get_ref_details(this);" data-live-search="true" required>
            <!-- Options will be populated here -->
        </select>
        <?php echo form_error('ref_id','<span class="text-danger">','</span>'); ?>
    </div>
<?php } ?>
						
						 <div class="form-group col-md-6">
                           <label for="tkt_title">Ticket Title</label><?php echo REQUIRED_STAR; ?>
                           <input type="text" class="form-control" id="tkt_title" name="tkt_title" maxlength="100" placeholder="Ticket Title" required value="<?php echo isset($details['ticket_title'])?$details['ticket_title']:set_value("tkt_title"); ?>" >
						
						    <?php echo form_error('tkt_title','<span class="text-danger">','</span>'); ?>
                        </div>  
						
						<div class="form-group col-md-6">
                           <label for="ticket_priority">Ticket Priority</label><?php echo REQUIRED_STAR; ?>
                           <select class="form-control" id="ticket_priority" name="ticket_priority" maxlength="100" required >							 
							<option value=""> Select Ticket Priority</option>
							 <?php  if(!empty($priority_list)){ 
								foreach($priority_list as $priority){ 
								   $ticket_priority   = isset($details['ticket_priority'])?$details['ticket_priority']:"";
									     $selected = $ticket_priority==$priority?"selected":"";	
								?>
									<option value="<?php echo $priority;?>"   <?php echo $selected;?>><?php echo $priority; ?></option>
							<?php } } ?>	
						  
						   </select>
						    <?php echo form_error('ticket_priority','<span class="text-danger">','</span>'); ?>
                        </div> 
						
						<div class="form-group col-md-12">
                           <label for="ticket_desc">Ticket Description </label>
						   <input class="form-control" id="ticket_desc" name="ticket_desc" type="text" placeholder="Enter Ticket Description"   maxlength="500" value="<?php echo isset($details['ticket_desc'])?$details['ticket_desc']:set_value("ticket_desc"); ?>">
						    <?php echo form_error('ticket_desc','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-6">
                           <label for="ticket_assign_to">Ticket Assign  <?php echo REQUIRED_STAR; ?></label>
                           <select class="form-control selectpicker" id="ticket_assign_to" name="ticket_assign_to" maxlength="100" data-live-search="true" >							 
							<option value=""> Select Ticket Assign To</option>
							 <?php  if(!empty($employee_list)){ 
								foreach($employee_list as $employee){ 
								        $ticket_assign_to   = isset($ticket_assign_to)?$ticket_assign_to:"";
									     $selected = $ticket_assign_to==$employee['user_id']?"selected":"";	
								?>
									<option value="<?php echo $employee['user_id'];?>"   <?php echo $selected;?>><?php echo $employee['emp_name']; ?></option>
							<?php } } ?>	
						  
						   </select>
						    <?php echo form_error('ticket_assign_to','<span class="text-danger">','</span>'); ?>
							<div class="mt-2" style="margin-top:10px;">
								<a href="<?php echo get_module_path().'reports/employee_availability_report'; ?>" target="_blank">
									Check Employee Availability
								</a>
							</div>
                        </div>
						
						<div class="form-group col-md-6"> 
						  <label for="ticket_date">Ticket Date & Time <?php echo REQUIRED_STAR; ?> </label>
                          <input type="text" class="form-control pull-right datepicker" id="ticket_date" name="ticket_date" placeholder="Ticket Date & Time" value="<?php echo isset($ticket_date)?$ticket_date:set_value("ticket_date"); ?>" >
                        </div>	<br/><br/>
						<div class="col-md-12"> 
						  <div id="ref_details">
						    <?php if($action=="Edit" || $action=="AssignC"){ 
							 echo $html ;
							 }  ?>	
						  </div>
                        </div>
                        </div>
					  
						  <div class="form-actions">
						 <div class="col-md-12">
							<center>
                           <button class="btn btn-success" type="submit"  id="add_edit_form_btn" >Submit</button>
                          <a href="<?php echo get_module_path();?>customers/ticket_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
							</center>
						</div>
                        </div>
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
	
	 $('.selectpicker').selectpicker();
	 $('#ref_id').on('change', function(){  }); 
	 $('.datepicker').datetimepicker({
		        format: 'dd-mm-yyyy HH:ii P',
				autoclose: true,
				todayHighlight: true,
			    showMeridian : true,

		});	
	
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
             cust_type: {
                required: true,
			 }, 
			 ref_id: {
                required: true,
			 }, 
			 
			 ticket_priority: {
                required: true,
			 }, 
			 tkt_title: {
				required: true,
            	maxlength: 100,
				 },
			ticket_desc: {
                maxlength: 500,
			 },  
			 
			 ticket_date: {
                required: true,
			 }, 

			 ticket_assign_to: {
				required: true
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
			error.appendTo("#radio_err");
			}else { // This is the default behavior of the script for all fields
			error.insertAfter(element);
			}
			
		},
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

function get_customers()
{ 
   $(".loader").fadeIn();
	$.ajax({
			url:base_url+"ajax/get_customers",
			type: "POST",
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
				{		
					var data = JSON.parse(data);
					$("#ref_id").html(data);
					$(".loader").fadeOut();
					$('.selectpicker').selectpicker('refresh');
				}
			});

			$("#ref_id").parent().show();
			$("label[for='ref_id']").show();
			$("label[for='ref_id']").next("span").show(); 

}

function get_leads()
{ 
   $(".loader").fadeIn();
	$.ajax({
			url:base_url+"ajax/get_leads",
			type: "POST",
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
				{		
					var data = JSON.parse(data);
					$("#ref_id").html(data);
					$(".loader").fadeOut();
					$('.selectpicker').selectpicker('refresh');
				}
			});

			$("#ref_id").parent().show();
			$("label[for='ref_id']").show();
			$("label[for='ref_id']").next("span").show(); 

}


function get_others() {
    var refIdSelect = $("#ref_id");

    // Clear existing options
    refIdSelect.html("");

    // Add the "Others" option with ID 0
    refIdSelect.append('<option value="0" selected>Others</option>');

    // Refresh the selectpicker after adding the option
    $('.selectpicker').selectpicker('refresh');

    // Hide the dropdown
    refIdSelect.parent().hide();
	$("label[for='ref_id']").hide();
	$("label[for='ref_id']").next("span").hide(); 
}

function get_ref_details()
{ 
   var ref_id    = $("#ref_id").val();
   $("#ref_details").html("");
   var cust_type = $('input[name="cust_type"]:checked').val();
   if(ref_id && cust_type){
   $(".loader").fadeIn();
	$.ajax({
			url:base_url+"ajax/get_ref_details",
			type: "POST",
			data: {"ref_id":ref_id,"cust_type":cust_type},
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
				{		
					var data = JSON.parse(data);
					$("#ref_details").html(data);
					$(".loader").fadeOut();
					
				}
			});
   }

}

	
</script>
