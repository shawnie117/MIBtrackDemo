<div class="page-content-wrapper">
<div class="page-content">

<div class="row">
<div class="col-md-12">
<div class="portlet light bordered">

<ul class="page-breadcrumb breadcrumb">
    <li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
    <li><a href="<?php echo base_url(get_module()."/masters/cheque_report")?>">All Cheques</a><i class="fa fa-circle"></i></li>
    <li><span class="active"><?php echo $page_title; ?></span></li>
</ul>

<div class="portlet-title">
    <div class="caption">
        <i class="font-red-mint icon-plus"></i>
        <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
    </div>
</div>

<div class="portlet-body form">

<form action="<?php echo get_module_path().'masters/add_cheque'; ?>" method="post" id="add_edit_form">

<div class="form-body">

<!-- Customer Name -->
<div class="col-md-3">
    <div class="form-group">
        <label>Customer Name <?php echo REQUIRED_STAR; ?></label>
        <input type="text" name="customer_name" class="form-control" placeholder="Enter Name">
        <?php echo form_error('customer_name','<span class="text-danger">','</span>'); ?>
    </div>
</div>

<!-- Amount -->
<div class="col-md-3">
    <div class="form-group">
        <label>Amount <?php echo REQUIRED_STAR; ?></label>
        <input type="text" name="amount" class="form-control" placeholder="Enter Amount">
        <?php echo form_error('amount','<span class="text-danger">','</span>'); ?>
    </div>
</div>

<!-- Cheque Date -->
<div class="col-md-3">
    <div class="form-group">
        <label>Cheque Date <?php echo REQUIRED_STAR; ?></label>
        <input type="date" name="cheque_date" class="form-control">
        <?php echo form_error('cheque_date','<span class="text-danger">','</span>'); ?>
    </div>
</div>

<!-- Bank Name -->
<div class="col-md-3">
    <div class="form-group">
        <label>Bank Name <?php echo REQUIRED_STAR; ?></label>
        <select name="bank_name" class="form-control">
            <option value="">Select Bank</option>
            <option value="SBI">SBI</option>
            <option value="HDFC">HDFC</option>
            <option value="ICICI">ICICI</option>
        </select>
        <?php echo form_error('bank_name','<span class="text-danger">','</span>'); ?>
    </div>
</div>

</div>

<div class="form-actions">
<center>
    <button class="btn btn-success" id="mybutton" type="submit">Submit</button>
    <a href="#" onclick="window.history.go(-1); return false;" class="btn btn-danger">Back</a>
</center>
</div>

</form>

</div>
</div>
</div>
</div>
</div>
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
        customer_name: {
            required: true,
            maxlength: 100
        },
        amount: {
            required: true,
            digits: true
        },
        cheque_date: {
            required: true
        },
        bank_name: {
            required: true
        }
    }
});
    });
	
</script>