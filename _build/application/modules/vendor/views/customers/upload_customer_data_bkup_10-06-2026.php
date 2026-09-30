<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
      <div class="row">
	  <div class="col-md-10">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
			
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint icon-cloud-upload"></i>
                  <span class="caption-subject font-red-mint bold">Upload Data</span>
               </div>
			   <!-- <a class="btn btn-danger btn-xs " href="<?php echo get_module_path().'customers/download_sample_data';?>" title="Download Sample Data"> <i class="fa fa-download"> </i>Download Sample Data</a> -->
		   </div>

<!-- Customer Data -->
<div class="upload-card">

    <div class="upload-card-header">
        <h4>Customer Data Upload</h4>
    </div>

    <form action="<?php echo get_module_path().'customers/upload_customer_data'; ?>" 
          method="post"
          enctype="multipart/form-data"
          autocomplete="off">

        <div class="upload-card-body">

            <div class="row">

                <div class="col-md-5 col-sm-12">
                    <input type="file"
                           name="data_file"
                           class="smart-file form-control"
                           required />
                </div>

                <div class="col-md-2 col-sm-6">
                    <button class="btn btn-success btn-block" type="submit">
                        <i class="fa fa-upload"></i> Upload
                    </button>
                </div>

                <div class="col-md-3 col-sm-6">
                    <a class="btn btn-danger btn-block"
                       href="<?php echo get_module_path().'customers/download_sample_data'; ?>">
                        <i class="fa fa-download"></i> Sample File
                    </a>
                </div>

            </div>

        </div>

    </form>

</div>



<!-- AMC Data -->
<div class="row">
			<?php echo validation_errors(); ?>
<div class="portlet-body form">
		
<form action="<?php echo get_module_path().'customers/upload_amc'; ?>" id="add_edit_form" method="post"   	autocomplete="off" enctype="multipart/form-data" >
	<div class="form-body">
		<div class="col-md-8" style="padding:3px;">
			<center>
                <div class="form-group">
    				<div class="input-group">
						<!-- <label for="data_file">Upload Customer Data</label>&nbsp;&nbsp; -->
       					<input type="file" name="data_file" id="data_file" class="smart-file" data-label="Upload AMC Data" data-btn-class="btn btn-default btn-sm" data-file-types=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required />
						
        				<span class="input-group-btn">
            				<button class="btn btn-success" type="submit">Submit</button>
        				</span>&nbsp;&nbsp;&nbsp;
						<span class="input-group-btn">
						<a class="btn btn-danger btn-xs " href="<?php echo get_module_path().'customers/download_amc_data';?>" title="Download Sample Data"> <i class="fa fa-download"> </i>Download Sample Data</a>
        				</span>
    				</div>
					
					<?php echo form_error('data_file', '<span class="text-danger">', '</span>'); ?>
    					<span class="file_err" style="text-align:start;"></span>	
				</div>
			</center>
			<div class="col-md-4">
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

        </div>
	</div>
						 
	<?php $error = $this->session->flashdata('error2');
		  $error = json_decode($error,true);
			if(is_array($error)) { ?>
            <div class="col-md-12"><br/>
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
	  <!--box-body -->		  
    </div>
</div>


<!-- OTS Data -->
<div class="row">
			<?php echo validation_errors(); ?>
<div class="portlet-body form">
		
<form action="<?php echo get_module_path().'customers/upload_ots'; ?>" id="add_edit_form" method="post"   	autocomplete="off" enctype="multipart/form-data" >
	<div class="form-body">
		<div class="col-md-8" style="padding:3px;">
			<center>
                <div class="form-group">
    				<div class="input-group">
						<!-- <label for="data_file">Upload Customer Data</label>&nbsp;&nbsp; -->
       					<input type="file" name="data_file" id="data_file" class="smart-file" data-label="Upload OTS Data" data-btn-class="btn btn-default btn-sm" data-file-types=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required />
						
        				<span class="input-group-btn">
            				<button class="btn btn-success" type="submit">Submit</button>
        				</span>&nbsp;&nbsp;&nbsp;
						<span class="input-group-btn">
						<a class="btn btn-danger btn-xs " href="<?php echo get_module_path().'customers/download_ots_data';?>" title="Download Sample Data"> <i class="fa fa-download"> </i>Download Sample Data</a>
        				</span>
    				</div>
					
					<?php echo form_error('data_file', '<span class="text-danger">', '</span>'); ?>
    					<span class="file_err" style="text-align:start;"></span>	
				</div>
			</center>
			<div class="col-md-4">
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

        </div>
	</div>
						 
	<?php $error = $this->session->flashdata('error3');
		  $error = json_decode($error,true);
			if(is_array($error)) { ?>
            <div class="col-md-12"><br/>
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
	  <!--box-body -->		  
    </div>
</div>


<!-- Product Data -->
<div class="row">
			<?php echo validation_errors(); ?>
<div class="portlet-body form">
		
<form action="<?php echo get_module_path().'customers/upload_product'; ?>" id="add_edit_form" method="post"   	autocomplete="off" enctype="multipart/form-data" >
	<div class="form-body">
		<div class="col-md-8" style="padding:3px;">
			<center>
                <div class="form-group">
    				<div class="input-group">
						<!-- <label for="data_file">Upload Customer Data</label>&nbsp;&nbsp; -->
       					<input type="file" name="data_file" id="data_file" class="smart-file" data-label="Upload Product Data" data-btn-class="btn btn-default btn-sm" data-file-types=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required />
						
        				<span class="input-group-btn">
            				<button class="btn btn-success" type="submit">Submit</button>
        				</span>&nbsp;&nbsp;&nbsp;
						<span class="input-group-btn">
						<a class="btn btn-danger btn-xs " href="<?php echo get_module_path().'customers/download_product_data';?>" title="Download Sample Data"> <i class="fa fa-download"> </i>Download Sample Data</a>
        				</span>
    				</div>
					
					<?php echo form_error('data_file', '<span class="text-danger">', '</span>'); ?>
    					<span class="file_err" style="text-align:start;"></span>	
				</div>
			</center>
			<div class="col-md-4">
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

        </div>
	</div>
						 
	<?php $error = $this->session->flashdata('error4');
		  $error = json_decode($error,true);
			if(is_array($error)) { ?>
            <div class="col-md-12"><br/>
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
	  <!--box-body -->		  
    </div>
</div>


<!-- Brand Data -->
<div class="row">
			<?php echo validation_errors(); ?>
<div class="portlet-body form">
		
<form action="<?php echo get_module_path().'customers/upload_brand'; ?>" id="add_edit_form" method="post"   	autocomplete="off" enctype="multipart/form-data" >
	<div class="form-body">
		<div class="col-md-8" style="padding:3px;">
			<center>
                <div class="form-group">
    				<div class="input-group">
						<!-- <label for="data_file">Upload Customer Data</label>&nbsp;&nbsp; -->
       					<input type="file" name="data_file" id="data_file" class="smart-file" data-label="Upload Brand Data" data-btn-class="btn btn-default btn-sm" data-file-types=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required />
						
        				<span class="input-group-btn">
            				<button class="btn btn-success" type="submit">Submit</button>
        				</span>&nbsp;&nbsp;&nbsp;
						<span class="input-group-btn">
						<a class="btn btn-danger btn-xs " href="<?php echo get_module_path().'customers/download_brand_data';?>" title="Download Sample Data"> <i class="fa fa-download"> </i>Download Sample Data</a>
        				</span>
    				</div>
					
					<?php echo form_error('data_file', '<span class="text-danger">', '</span>'); ?>
    					<span class="file_err" style="text-align:start;"></span>	
				</div>
			</center>
			<div class="col-md-4">
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

        </div>
	</div>
						 
	<?php $error = $this->session->flashdata('error5');
		  $error = json_decode($error,true);
			if(is_array($error)) { ?>
            <div class="col-md-12"><br/>
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
	  <!--box-body -->		  
    </div>
</div>


<!-- LEAD Data -->
<div class="row">
			<?php echo validation_errors(); ?>
<div class="portlet-body form">
		
<form action="<?php echo get_module_path().'customers/upload_lead'; ?>" id="add_edit_form" method="post"   	autocomplete="off" enctype="multipart/form-data" >
	<div class="form-body">
		<div class="col-md-8" style="padding:3px;">
			<center>
                <div class="form-group">
    				<div class="input-group">
						<!-- <label for="data_file">Upload Customer Data</label>&nbsp;&nbsp; -->
       					<input type="file" name="data_file" id="data_file" class="smart-file" data-label="Upload Lead Data" data-btn-class="btn btn-default btn-sm" data-file-types=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required />
						
        				<span class="input-group-btn">
            				<button class="btn btn-success" type="submit">Submit</button>
        				</span>&nbsp;&nbsp;&nbsp;
						<span class="input-group-btn">
						<a class="btn btn-danger btn-xs " href="<?php echo get_module_path().'customers/download_lead_data';?>" title="Download Sample Data"> <i class="fa fa-download"> </i>Download Sample Data</a>
        				</span>
    				</div>
					
					<?php echo form_error('data_file', '<span class="text-danger">', '</span>'); ?>
    					<span class="file_err" style="text-align:start;"></span>	
				</div>
			</center>
			<div class="col-md-4">
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

        </div>
	</div>
						 
	<?php $error = $this->session->flashdata('error5');
		  $error = json_decode($error,true);
			if(is_array($error)) { ?>
            <div class="col-md-12"><br/>
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
	  <!--box-body -->		  
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


<style>

@media screen and (max-width: 768px) {
    .input-group {
        display: inline-block;
        border-collapse: separate;
       
    }
	
	.input-group span{
    width: 200px;
	}
}


</style>
<style>

.error-table-wrapper{
    max-height:400px;
    overflow-y:auto;
    overflow-x:auto;
    margin-bottom:25px;
    border:1px solid #ddd;
}

.error-table{
    margin-bottom:0;
}

.error-table thead th{
    position: sticky;
    top: 0;
    background: #f2dede;
    z-index: 2;
}

</style>