<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
	<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
      <div class="row">
	  <div class="col-md-8">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
	<li><a href="<?php echo base_url("dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
	<li><a href="<?php echo base_url("masters/city_report")?>">All City </a><i class="fa fa-circle"></i></li>
	<li><span class="active"><?php echo $page_title; ?></span></li>
	</ul>
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint <?php echo $icon ;?> "></i>
                  <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div>
            <div class="row">
			
               <div class="portlet-body form">
				  <?php if($action=="Edit"){  
				    $city_details = html_escape($city_details);
					$formaction = "edit_city/?city_id=".base64_encode($city_id);
					}else {  $formaction = "add_city"; } ?>
                     <form action="<?php echo base_url().'masters/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					  <div class="form-group col-md-offset-2 col-md-6"> 
							<label for="sub_dept_name">State </label><?php echo REQUIRED_STAR; ?>	  
                            <select class="form-control" id="state_id" name="state_id" onchange="get_state_districts(this,'dist_id');">
							<option value=""> Select State</option>
							 <?php  if(!empty($state_list)){ 
								foreach($state_list as $state){ 
								  $state_id =  isset($city_details['city_state_id'])?$city_details['city_state_id']:"";
								  $selected = $state_id==$state['state_id']?"selected":"";
								
								?>
									<option value="<?php echo $state['state_id'];?>" <?php echo $selected;?> ><?php echo $state['state_name']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 
					   <div class="form-group col-md-offset-2 col-md-6">  
						<label for="sub_dept_name">District </label><?php echo REQUIRED_STAR; ?>	   
                          <select class="form-control" id="dist_id" name="dist_id" >
							<option value=""> Select District</option>
							 <?php  if(!empty($dist_list)){ 
								foreach($dist_list as $dist){ 
								  $dist_id =  isset($city_details['city_dist_id'])?$city_details['city_dist_id']:"";
								  $selected = $dist_id==$dist['dist_id']?"selected":"";
								
								?>
									<option value="<?php echo $dist['dist_id'];?>" <?php echo $selected;?> ><?php echo $dist['dist_name']; ?></option>
							<?php } } ?>	
						   </select>		 
                        </div>
					
					  <div class="col-md-offset-2 col-md-6">
                        <div class="form-group">
                           <label for="city_name">City </label><?php echo REQUIRED_STAR; ?>
						   <?php if($action=="Edit"){?>
                           <input type="hidden" name="city_id" value="<?php echo $city_id; ?>">
						   <?php } ?>
                           <input class="form-control" id="city_name" name="city_name" type="text" placeholder="Enter City Name" required maxlength="100" value="<?php echo isset($city_details['city_name'])?$city_details['city_name']:""; ?>">
						    <?php echo form_error('city_name','<span class="text-danger">','</span>'); ?>
                        </div>
						
                        </div>
									  
						  </div>
						   <div class="form-actions">
						 <div class="col-md-offset-3 col-md-9">
                           <button class="btn btn-success" type="submit" >Submit</button>
                          <a href="<?php echo base_url();?>masters/city_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
            city_name: {
                required: true,
				maxlength: 100,
                minlength: 2,
				 }, 
			state_id: {
                required: true,
				 }, 
			dist_id: {
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
        }
    });
    });
	
</script>