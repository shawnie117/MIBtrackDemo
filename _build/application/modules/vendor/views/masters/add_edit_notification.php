
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
	<li><a href="<?php echo base_url(get_module()."/masters/notification_report")?>">All Notifications </a><i class="fa fa-circle"></i></li>
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
				  <?php if($action=="Edit"){  //echo "<pre/>"; print_r($notification_details);die; 
				    $notification_details = html_escape($notification_details);
					$noti_img  = isset($notification_details['noti_img'])?$notification_details['noti_img']:"";
					$noti_det_to_permid  = isset($notification_details['noti_det_to_permid'])?$notification_details['noti_det_to_permid']:"";					
					$formaction = "edit_notification/?noti_id=".base64_encode($noti_id);
					}else {  $formaction = "add_notification"; } ?>
                     <form action="<?php echo get_module_path().'masters/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data" >
					  <div class="form-body">
					  
					   <div class="col-md-6">  
					  
						 <div class="form-group">
                           <label for="noti_title">Notification Title </label><?php echo REQUIRED_STAR; ?>
						   <?php if($action=="Edit"){?>
                           <input type="hidden" name="noti_id" value="<?php echo $noti_id; ?>">
						   <?php } ?>
                           <input class="form-control" id="noti_title" name="noti_title" type="text" placeholder="Enter Notification Title" required maxlength="100" value="<?php echo isset($notification_details['noti_title'])?$notification_details['noti_title']:""; ?>">
						    <?php echo form_error('noti_title','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group">
                           <label for="noti_desc">Notification Description </label><?php echo REQUIRED_STAR; ?>
						    <textarea class="form-control" id="noti_desc" name="noti_desc" 
                             placeholder="Enter Notification Description" required maxlength="1000" ><?php echo isset($notification_details['noti_desc'])?$notification_details['noti_desc']:""; ?></textarea>			
						   
						    <?php echo form_error('noti_desc','<span class="text-danger">','</span>'); ?>
                        </div>

						<!-- OLD -->

						 <div class="form-group">  
						<label for="sub_dept_name">Notification for </label>
						<br/>
							 <?php  
                             $atLeastOneChecked = false;
                             if(!empty($permission_list)){ 
								foreach($permission_list as $permission){
									 $selected = "";
									if(!empty($notification_details['notiDetailList'])){ 
										foreach($notification_details['notiDetailList'] as $notification){
											
									            if($notification['permission_id']==$permission['permission_id']){
													 $selected = "checked";
                                                     $atLeastOneChecked = true;
                                                     break;
												}
										}
									}
								?>
								<div class="col-md-6">
                                <input type="checkbox" value="<?php echo $permission['permission_id'];?>" name="permission_id[]" class="minimal" <?php echo $selected;?> /> &nbsp;  <label><?php echo $permission['permission_name']; ?></label> </div>
									
							<?php } } 
                            if (!$atLeastOneChecked && !empty($permission_list)) {
                                // If no checkbox was checked, check the first one by default
                                $firstPermission = $permission_list[0];
                            ?>

                        <div class="col-md-6">
                        <input type="checkbox" value="<?php echo $firstPermission['permission_id'];?>" name="permission_id[]" class="minimal" checked /> &nbsp;
                        <label><?php echo $firstPermission['permission_name']; ?></label>
                        </div>
                        <?php
                        }
                        ?>
					    </div>
							  
				
                        </div>
                        <div class="col-md-4">
						
						 <div class=" form-group bootstrap-timepicker">
                                 <label>From Date:</label><?php echo REQUIRED_STAR; ?>
                                 <div class="input-group date  col-md-10">
                                    <!--div class="input-group-addon">
                                       <i class="fa fa-calendar"></i>
                                        </div-->
                                    <div class="form-group"><input type="text" class="form-control pull-right datepicker" id="noti_from" name="noti_from" value="<?php echo isset($notification_details['noti_disp_fromdate'])?date("Y-m-d",strtotime($notification_details['noti_disp_fromdate'])):""; ?>"></div>
                                 </div>
                                 <?php echo form_error('noti_from','<span class="text-danger">','</span>'); ?>
                          </div>
                          <!-- Start time Picker -->
						 <div class="form-group bootstrap-timepicker">
                                 <label>To Date:</label><?php echo REQUIRED_STAR; ?>
                                 <div class="input-group date  col-md-10">
                                    <!--div class="input-group-addon">
                                       <i class="fa fa-calendar"></i>
                                        </div-->
                                    <div class="form-group">
									<input type="text" class="form-control pull-right datepicker" id="noti_to" name="noti_to" value="<?php echo isset($notification_details['noti_disp_todate'])?date("Y-m-d",strtotime($notification_details['noti_disp_todate'])):""; ?>"></div>
                                 </div>
                                 <?php echo form_error('noti_to','<span class="text-danger">','</span>'); ?>
                          </div>
                          <!-- Start time Picker -->
						  
						 <div class="form-group">
							   <label for="noti_img">Image</label>
								<input type="file" name="noti_img"  id="noti_img" 
								class="smart-file" 
								data-label="Notification Image" 
								data-btn-class="btn btn-default btn-sm" 
								data-preview="on"
								data-file-types="image/jpeg,image/png,image/jpg" accept="image/*"    />
								<?php echo form_error('noti_img','<span class="text-danger">','</span>'); ?>
								
								<?php if($action=="Edit"){ ?>
								<ul class="list-unstyled small fileList thumbs">
									<li><img title="" src="<?php echo $noti_img; ?>"  alt="<?php echo $notification_details['noti_title']; ?>" class="img-rounded"><span class="file-name"></span> </li>
									</ul>
							  <?php } ?>
								
							</div>	
                        </div>
					
					 
									  
						  </div>
						   <div class="form-actions">
						 <div class="col-sm-12 col-lg-12">
                            <center>
                           <button class="btn btn-success" id="mybutton" type="submit" >Submit</button>
                          <a href="<?php echo get_module_path();?>masters/notification_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
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
            noti_title: {
                required: true,
				maxlength: 100,
                minlength: 2,
				 }, 
			noti_desc: {
                required: true,
				maxlength: 1000,
                minlength: 2,
				 }, 
	        noti_from: {
                required: true,
				 }, 
		     noti_to: {
                required: true,
				 }, 
			noti_img: {
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
        }
    });
	
	$('#noti_img').change(function() {
            $('#noti_img').removeData('imageWidth');
            $('#noti_img').removeData('imageHeight');
            var file = this.files[0];
            var tmpImg = new Image();
            tmpImg.src=window.URL.createObjectURL( file ); 
            tmpImg.onload = function() {
                width = tmpImg.naturalWidth,
                height = tmpImg.naturalHeight;
                $('#noti_img').data('imageWidth', width);
                $('#noti_img').data('imageHeight', height);
            }
        });
		
	  $('.datepicker').datepicker({
				format: 'dd-mm-yyyy',
				autoclose: true,
				todayHighlight: true,

		});	
	
    });
	
</script>