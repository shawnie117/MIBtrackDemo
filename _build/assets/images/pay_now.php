<!DOCTYPE html>
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title><?php echo V_SITE_NAME ?> | <?php echo isset($page_title)?$page_title:""; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="<?php echo V_SITE_NAME ?>" name="description" />
        <meta content="<?php echo V_SITE_NAME ?>" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/admin_theme/global/plugins/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/admin_theme/global/plugins/simple-line-icons/simple-line-icons.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/admin_theme/global/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/admin_theme/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo base_url('assets/admin_theme/global/plugins/select2/css/select2.min.css');?>" rel="stylesheet" type="text/css');?>" />
        <link href="<?php echo base_url('assets/admin_theme/global/plugins/select2/css/select2-bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo base_url('assets/admin_theme/global/css/components.min.css');?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo base_url('assets/admin_theme/global/css/plugins.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo base_url('assets/admin_theme/pages/css/login-4.min.css');?>" rel="stylesheet" type="text/css" />
		 <link href="<?php echo get_assets_path(); ?>admin_theme/file_upload_jscss/css/bootstrap_file_field.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png');?>" /> 
		</head>
    <!-- END HEAD -->

    <body class="login" style="margin-top:10px;">
      <?php   
$txnid  = time();
$key_id = RAZOR_KEY_ID;          
$name   = SITE_NAME;
?>
        <div class="content" style="width:800px;margin-top:10px;">		
	   <div class="row">
	  <div class="col-md-12">
	  
         <div class="portlet light bordered">
           <div class="portlet-title">
               <div class="caption">
                  <i class="font-green-sharp icon-wallet "></i>
                  <span class="caption-subject font-green-sharp bold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div>
          
            <div class="row">
			<div class="col-md-6">
			 <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint icon-user "></i>
                  <span class="caption-subject font-red-mint bold">Customer Details</span>
               </div>
			   
		   </div>
			 <table class="table table-bordered">
			 <tr><th>Customer Name</th><td><?php echo $card_holder_name ?> </td> </tr>
			 <tr><th>Customer Contact</th><td><?php echo $phone ?> </td> </tr>
			 <tr><th>Customer Email</th><td><?php echo $email ?> </td> </tr>
			 </table>
            </div>
			<div class="col-md-6">
			 <div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint icon-wallet "></i>
                  <span class="caption-subject font-red-mint bold">Payment Details</span>
               </div>
		     </div>
			 <table class="table table-bordered">
			 <tr><th>Amount</th><td><?php echo $exclude_gst ?> </td> </tr>			
			 <tr><th>GST</th><td><?php echo $cust_gst ?> </td> </tr>
			  <tr><th>Total Amount </th><td><?php echo $comp_amount ?> </td> </tr>
			 <!-- <tr><th>Payment Gateway Charges</th><td><?php echo $charges ?> </td> </tr>
			 <tr><th>Grand Total</th><td><?php echo $total_amount ?> </td> </tr> -->
			 </table>
            </div>
			 <div class="col-md-12">
			<center><input  id="submit-pay" type="submit" class="btn btn-success" onclick="razorpaySubmit(this);" value="Pay Now"/></center>
             </div>
             </div>
        </div>
        </div>
        <!-- END LOGIN -->
		
  <!-- BEGIN COPYRIGHT -->
        <div class="copyright">  Copyright &copy; <?php echo date("Y")?> <a href="https://www.mauli-infotech.co.in/" target="_blank">Mauli Infotech (OPC) Pvt. Ltd.</a> </div>
        <!-- END COPYRIGHT -->

        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/js.cookie.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/jquery.blockui.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js');?>" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/select2/js/select2.full.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin_theme/global/plugins/backstretch/jquery.backstretch.min.js');?>" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url('assets/admin_theme/global/scripts/app.min.js');?>" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
		  <script> var base_url = '<?php echo base_url();?>'</script>
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url('assets/admin_theme/pages/scripts/login-4-2.js');?>" type="text/javascript"></script>
       <script src="<?php echo get_assets_path(); ?>admin_theme/file_upload_jscss/js/bootstrap_file_field.js" type="text/javascript"></script>
    <!-- Courses Details Section End -->
	<form name="razorpay-form" id="razorpay-form" action="<?php echo $return_url; ?>" method="POST">
  <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" value=""  />
   <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >

  <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>"/>
  <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl; ?>"/>
</form>
	
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
  var razorpay_options = {
    key: "<?php echo $key_id; ?>",
    
    amount: "<?php echo $comp_amount*100; ?>",
    name: "<?php echo $name; ?>",
    description: "Order # <?php echo $order_id; ?>",
    netbanking: true,
    currency: "<?php echo $currency_code; ?>",
	image: "<?php echo base_url(LOGO_PATH);?>",
	
    prefill: {
      name:"<?php echo $card_holder_name; ?>",
      email: "<?php echo $email; ?>",
      contact: "<?php echo $phone; ?>"
    },
     notes: {
      soolegal_order_id: "<?php echo $order_id; ?>",
    }, 
	order_id:"<?php echo $order_id; ?>",
    handler: function (transaction) {
        document.getElementById('razorpay_payment_id').value   = transaction.razorpay_payment_id;
		document.getElementById('razorpay_signature').value = transaction.razorpay_signature;
        document.getElementById('razorpay-form').submit();
    },
    "modal": {
        "ondismiss": function(){
            location.reload()
        }
    }
  };
  var razorpay_submit_btn, razorpay_instance;

  function razorpaySubmit(el){
    if(typeof Razorpay == 'undefined'){
      setTimeout(razorpaySubmit, 200);
      if(!razorpay_submit_btn && el){
        razorpay_submit_btn = el;
        el.disabled = true;
        el.value = 'Please wait...';  
      }
    } else {
      if(!razorpay_instance){
        razorpay_instance = new Razorpay(razorpay_options);
        if(razorpay_submit_btn){
          razorpay_submit_btn.disabled = false;
          razorpay_submit_btn.value = "Pay Now";
        }
      }
      razorpay_instance.open();
    }
  }  
</script>