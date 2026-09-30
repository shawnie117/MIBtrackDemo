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
				    $formaction = "add_service_ticket";
				    }
					if($action=="Edit")
					{ 
						$formaction = "edit_service_ticket/?id=".base64_encode($id);					
						//echo "<pre/>"; print_r($details);die;
						$customer_id = isset($details['customer_id'])?$details['customer_id']:"";
						$ticket_assign_to = !empty($ticket_detailList)?$ticket_detailList[0]['ticket_assign_to']:"";
						
						$ticket_date = isset($details['ticket_date'])?date("d-m-Y",strtotime($details['ticket_date']))." ".(isset($details['ticket_time'])?$details['ticket_time']:"12:00 AM"):"";
					}
					
					if($action=="Schedule")
					{ 
						$formaction = "schedule_service_ticket/?id=".base64_encode($id)."&serv_id=".base64_encode($serv_id);
						$details['ticket_title'] = "";
						if(!empty($serv_details)){
						$details['ticket_title'] = $serv_details['cust_serv_type_name'];
						}
						
						$customer_id = isset($details['customer_id'])?$details['customer_id']:"";
						
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
					  
					      <?php if($action=="Edit" || $action=="Schedule"){ ?>
						 <div class="form-group col-md-8">
                           <!-- <label for="ref_id">Customer</label><?php echo REQUIRED_STAR; ?> -->
                           <!-- <label> <b><?php echo isset($details['customer_name'])?$details['customer_name']:""; ?></b></label> -->
                           <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id; ?>">
						     </div> 
						   <?php } ?>
						
			              <?php if($action=="Add"){ ?>												
						  <div class="form-group col-md-8">
                           <label for="ref_id">Customer</label><?php echo REQUIRED_STAR; ?>
                            <select class="form-control selectpicker" id="customer_id" name="customer_id" data-live-search="true" onchange="get_customer_details(this);">
							<option value=""> Select Customer</option>
							 <?php  if(!empty($customer_list)){ 
								foreach($customer_list as $customer){ ?>
									<option value="<?php echo $customer['customer_id'];?>" ><?php echo $customer['customer_name']." - " .$customer['customer_contact']; ?></option>
							<?php } } ?>	
						   </select>
						    <?php echo form_error('customer_id','<span class="text-danger">','</span>'); ?>
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
                           <label for="ticket_assign_to">Ticket Assign To <?php echo REQUIRED_STAR; ?></label>
                           <select class="form-control selectpicker" id="ticket_assign_to" name="ticket_assign_to" required maxlength="100" data-live-search="true" >							 
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
								<a href="<?php echo get_module_path().'reports/employee_availability_report'; ?>" target="_blank">Check Employee Availability</a>
                        </div>
						
						<div class="form-group col-md-6"> 
						  <label for="ticket_date">Ticket Date & Time<?php echo REQUIRED_STAR; ?> </label>
                          <input type="text" class="form-control pull-right datepicker" id="ticket_date" name="ticket_date" placeholder="Ticket Date & Time" value="<?php echo isset($ticket_date)?$ticket_date:set_value("ticket_date"); ?>" >
                        </div>	<br/><br/>
						
						  <div class="col-md-12"> 
						  <div id="ref_details">
						  
						  </div>
                        </div>
                      
                        </div>
					  
						  <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" type="submit"  id="add_edit_form_btn" >Submit</button>
                          <a onclick="window.history.go(-1); return false;" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
                        </div>
                        </div>
						   </div>	
						    
						     
						   </div>
                   
					
						 
						  
						</form>
				
                        <!-- /.box-body -->
						<script>
						const button = document.getElementById('add_edit_form_btn');

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
 <?php if($action=="Edit" || $action=="Schedule"){ ?>
get_customer_details();
<?php } ?>

$(document).ready(function() {
	 $('.selectpicker').selectpicker();
	 $('#customer_id').on('change', function(){  }); 
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
             customer_id: {
                required: true,
			 }, 
			 ticket_assign_to: {
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


function get_customer_details()
{ 
   var customer_id    = $("#customer_id").val();
   $("#ref_details").html("");
   var cust_type = $('input[name="cust_type"]:checked').val();
   if(customer_id){
   $(".loader").fadeIn();
	$.ajax({
			url:base_url+"ajax/get_customer_details",
			type: "POST",
			data: {"customer_id":customer_id},
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