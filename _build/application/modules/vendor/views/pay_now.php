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
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" type="text/css" />
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
        <style>
            :root{
                --mi-orange:#ff6500;
                --mi-orange-dark:#ff3d00;
                --mi-text:#101828;
                --mi-muted:#596273;
                --mi-border:#dfe4ec;
            }
            *{ box-sizing:border-box; }
            html, body{ min-height:100%; }
            body.login{
                margin:0 !important;
                min-height:100vh;
                font-family:'Inter','Open Sans',Arial,sans-serif !important;
                background:url('<?php echo base_url("assets/admin_theme/pages/media/bg/bg6.jpg"); ?>') center center / cover no-repeat fixed !important;
                color:var(--mi-text);
                overflow-x:hidden;
            }
            @keyframes miFadeUp{
                from{ opacity:0; transform:translateY(18px); }
                to{ opacity:1; transform:translateY(0); }
            }
            @keyframes miFadeRight{
                from{ opacity:0; transform:translateX(-18px); }
                to{ opacity:1; transform:translateX(0); }
            }
            @keyframes miFadeOnly{
                from{ opacity:0; }
                to{ opacity:1; }
            }
            .mi-auth-page{
                min-height:100vh;
                display:flex;
                align-items:center;
                justify-content:center;
                padding:clamp(16px, 2vw, 44px);
                position:relative;
            }
            .content{
                width:100% !important;
                max-width:100% !important;
                flex:0 0 100%;
                display:flex;
                justify-content:center;
                margin:0 !important;
                padding:0 !important;
                background:transparent !important;
                position:relative;
                z-index:2;
            }
            .mi-payment-card{
                width:100%;
                max-width:min(760px, calc(100vw - 48px));
                margin:0 auto;
                padding:clamp(22px, 2vw, 36px);
                border-radius:clamp(24px, 2vw, 38px);
                background:rgba(255,255,255,.82);
                border:1px solid rgba(255,255,255,.95);
                box-shadow:0 30px 80px rgba(16,24,40,.14);
                backdrop-filter:blur(20px);
                -webkit-backdrop-filter:blur(20px);
                animation:miFadeUp .55s ease both;
                text-align:center;
            }
            .mi-pay-icon{
                width:58px;
                height:58px;
                margin:0 auto 14px;
                border:1.8px solid #ff8a2a;
                border-radius:50%;
                display:flex;
                align-items:center;
                justify-content:center;
                color:#ff8a2a;
                font-size:26px;
                background:#fff;
                box-shadow:0 8px 20px rgba(255,138,42,.22);
            }
            .mi-payment-card h1{
                margin:0 0 10px;
                color:#101828;
                font-size:clamp(24px, 1.8vw, 34px);
                line-height:1.2;
                font-weight:800;
                text-align:center;
            }
            .mi-payment-card .mi-pay-subtitle{
                margin:0 auto 24px;
                max-width:560px;
                color:#000 !important;
                font-weight:600;
                font-size:15px;
                line-height:1.5;
                text-align:center;
            }
            .mi-pay-grid{
                display:grid;
                grid-template-columns:minmax(0, 1.25fr) minmax(260px, .9fr);
                gap:20px;
                width:100%;
                max-width:680px;
                margin:0 auto 24px;
                text-align:left;
            }
            .mi-pay-panel{
                background:rgba(255,255,255,.82);
                border:1px solid var(--mi-border);
                border-radius:16px;
                overflow:hidden;
                box-shadow:0 10px 28px rgba(16,24,40,.07);
            }
            .mi-pay-panel h2{
                display:flex;
                align-items:center;
                gap:8px;
                margin:0;
                padding:14px 16px;
                border-bottom:1px solid var(--mi-border);
                color:#101828;
                font-size:15px;
                line-height:1.25;
                font-weight:800;
            }
            .mi-pay-panel h2 i{ color:var(--mi-orange); }
            .mi-pay-table{
                width:100%;
                margin:0;
                border:0;
                background:transparent;
            }
            .mi-pay-table th,
            .mi-pay-table td{
                padding:13px 16px !important;
                border:0 !important;
                border-bottom:1px solid #edf1f6 !important;
                color:#111827;
                font-size:14px;
                line-height:1.35;
                vertical-align:middle !important;
            }
            .mi-pay-table tr:last-child th,
            .mi-pay-table tr:last-child td{ border-bottom:0 !important; }
            .mi-pay-table th{
                width:42%;
                color:#344054;
                font-weight:700;
                background:rgba(248,250,252,.72);
            }
            .mi-pay-table td{
                font-weight:500;
                overflow-wrap:anywhere;
                word-break:normal;
            }
            .mi-pay-total td,
            .mi-pay-total th{
                color:#101828;
                font-weight:800;
            }
            #submit-pay{
                display:block;
                width:170px;
                height:46px;
                margin:0 auto;
                border:0 !important;
                border-radius:14px !important;
                background:linear-gradient(135deg,#ff9700 0%, #ff3d00 100%) !important;
                color:#fff !important;
                font-size:15px;
                font-weight:700;
                line-height:46px !important;
                padding:0 26px !important;
                box-shadow:0 17px 34px rgba(255,86,0,.30);
                transition:transform .18s ease, box-shadow .18s ease, filter .18s ease;
            }
            #submit-pay:hover,
            #submit-pay:focus{
                transform:translateY(-1px);
                box-shadow:0 20px 38px rgba(255,86,0,.38);
                filter:brightness(1.03);
            }
            .mi-card-copy{
                margin-top:18px;
                padding-top:14px;
                border-top:1px solid rgba(223,228,236,.85);
                color:#596273;
                font-size:12px;
                line-height:1.55;
                text-align:center;
            }
            .mi-card-copy a{
                color:#ff3d00;
                font-weight:700;
            }
            .mi-card-copy .mi-company{
                color:#ff3d00;
                font-weight:700;
            }
            .mi-card-copy .mi-phone{
                color:#ff3d00;
                font-weight:700;
            }
            @media (max-width:1100px){
                .mi-auth-page{ padding:70px 24px 44px; }
                .content{
                    width:100% !important;
                    max-width:100% !important;
                    flex:0 0 100%;
                }
                .mi-payment-card{ max-width:720px; }
            }
            @media (max-width:1280px) and (min-width:1101px){
                .mi-auth-page{ padding-left:24px; padding-right:24px; }
                .mi-payment-card{ max-width:720px; }
            }
            @media (max-width:720px){
                body.login{ background-attachment:scroll !important; }
                .mi-auth-page{
                    min-height:100dvh;
                    padding:16px 14px !important;
                    align-items:center;
                }
                .mi-pay-grid{ grid-template-columns:1fr; gap:14px; }
                .mi-payment-card{
                    padding:18px 14px;
                    border-radius:22px;
                }
                .mi-payment-card h1{ font-size:24px; }
                .mi-pay-table th,
                .mi-pay-table td{
                    padding:10px 12px !important;
                    font-size:13px;
                }
                .mi-pay-table th{ width:46%; }
                #submit-pay{
                    width:100%;
                    max-width:220px;
                }
            }
                body.login{
                margin:0 !important;
                min-height:100vh;
                font-family:'Inter','Open Sans',Arial,sans-serif !important;
                background:url('<?php echo base_url("assets/admin_theme/pages/media/bg/bg6.jpg"); ?>') center center / cover no-repeat fixed !important;
                color:var(--mi-text);
                overflow:hidden !important;
            }
                .mi-phone{
                    cursor:pointer;
                    text-decoration:none;
                }

                .mi-phone:hover{
                    color:#ff6500;
                    text-decoration:underline;
                }
        </style>
    <!-- END HEAD -->

    <body class="login">
      <?php   
        $txnid  = time();
        $key_id = RAZOR_KEY_ID;          
        $name   = SITE_NAME;
        ?>
                <div class="mi-auth-page">
            <main class="content">
                <section class="mi-payment-card">
                    <div class="mi-pay-icon"><i class="icon-wallet"></i></div>
                    <h1><?php echo $page_title; ?></h1>
                    <p class="mi-pay-subtitle">Review your customer and payment details before continuing to secure payment.</p>
                    <div class="mi-pay-grid">
                        <div class="mi-pay-panel">
                            <h2><i class="icon-user"></i> Customer Details</h2>
                            <table class="table mi-pay-table">
                                <tr><th>Customer Name</th><td><?php echo $card_holder_name ?> </td></tr>
                                <tr><th>Customer Contact</th><td><?php echo $phone ?> </td></tr>
                                <tr><th>Customer Email</th><td><?php echo $email ?> </td></tr>
                            </table>
                        </div>
                        <div class="mi-pay-panel">
                            <h2><i class="icon-wallet"></i> Payment Details</h2>
                            <table class="table mi-pay-table">
                                <tr><th>Amount</th><td><?php echo $exclude_gst ?> </td></tr>
                                <tr><th>GST</th><td><?php echo $cust_gst ?> </td></tr>
                                <tr class="mi-pay-total"><th>Total Amount</th><td><?php echo $comp_amount ?> </td></tr>
                            </table>
                        </div>
                    </div>
                    <input id="submit-pay" type="submit" class="btn" onclick="razorpaySubmit(this);" value="Pay Now"/>
                   
                    <!-- <div class="mi-card-copy">
                        <div>Copyright &copy; <?php echo date("Y")?> <a class="mi-company" href="https://mibtrack.co.in/index/" target="_blank">MI-Btrack CRM</a></div>
                        <div>Any Enquiry? Call: <a class="mi-phone" href="tel:+918356919267">8356919267</a> | <a class="mi-phone" href="tel:+918879038139">8879038139</a></div>
                    </div> -->

                     <div class="mi-card-copy">
                        <div>
                            Copyright &copy; <?php echo date("Y")?>
                            <a class="mi-company" href="https://mibtrack.co.in/index/" target="_blank">
                                MI-Btrack CRM
                            </a>
                        </div>

                        <div>
                        Any Enquiry? Call:
                        <a class="mi-phone"
                        href="tel:+918356919267"
                        onclick="window.location.href='tel:+918356919267';">
                        8356919267
                        </a>
                        |
                        <a class="mi-phone"
                        href="tel:+918879038139"
                        onclick="window.location.href='tel:+918879038139';">
                        8879038139
                        </a>
                    </div>
                </div>
                </section>
            </main>
        </div>

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
    </body>
</html>