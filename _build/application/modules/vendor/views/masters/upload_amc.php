<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	  <div class="col-md-8">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
			
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint icon-cloud-upload"></i>
                  <span class="caption-subject font-red-mint bold"><?php echo $page_title; ?></span>
               </div>
			   <a class="btn btn-danger btn-xs pull-right" href="<?php echo get_module_path().'customers/download_sample_data';?>" title="Download Sample Data"> <i class="fa fa-download"> </i>Download Sample Data</a>
		   </div>
            <div class="row">
			<?php echo validation_errors(); ?>
               <div class="portlet-body form">
			   
			    <div class="col-sm-1">
                  <?php
                     $this->load->helper('form');
                
              
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
				
				    <form action="<?php echo get_module_path().'masters/upload_amc'; ?>" id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data" >
					  <div class="form-body">
					
					  <div class="col-md-8" style="padding:3px;">
					  <center>
                        <div class="form-group">
                           <!-- <label for="data_file">Upload AMC Data:</label> -->
                            <input type="file" name="data_file"  id="data_file" 
							class="smart-file" 
							data-label="Upload AMC Data" 
							data-btn-class="btn btn-default btn-sm" 
							data-file-types=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required />
							<?php echo form_error('data_file','<span class="text-danger">','</span>'); ?>
							<span class="file_err"></span>
                        </div>	
                         <button class="btn btn-success" id="mybutton" type="submit" >Submit</button>						
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
						</center>
                        </div>
						  </div>
						 
						<?php $error = $this->session->flashdata('error');
						     $error = json_decode($error,true);
							if(is_array($error)) { ?>
                        <div class="col-md-6"><br/>
						<span class="caption-subject font-red-mint bold">Data File not Uploaded.Check Following Errors.</span>
						  <table class="table table-striped table-bordered  tbl_data_table_no_srch3" role="grid" aria-describedby="sample_1_info">
							<thead>
							<tr class="danger"><th >Sr. No.</th><th >Customer Name</th><th>Type</th><th>Message</th><th >Line No.</th></tr>
							</thead>
							<tbody>
							<?php foreach($error as $key=>$err_item) { ?>
							<tr><td><?php echo $key+1; ?> </td>
								<td><?php echo $err_item['cust_name']; ?> </td>
								<td><?php echo $err_item['exception_type']; ?></td>
								<td><?php echo $err_item['exception_msg']; ?></td>
								<td><?php echo $err_item['line_no']; ?></td>	
						    </tr>
                            <?php } ?>
							</tbody>
                        </div>
						  <?php } ?>
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
            fileTypes: '.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel',  
		/* 	minNumFiles:1, */
            maxFileSize: 4000000 // 8Mb in bytes */
        });
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
   
		    data_file: {
				   required: true,
				   accept: ".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel",
				   filesize_max:1000000, // 1 MB
				   /* filesize_min:10000, // 1 KB */
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
        },onfocusout: false,
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