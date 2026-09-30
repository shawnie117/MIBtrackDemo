
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
		<style>
            :root{
                --mi-orange:#ff6500;
                --mi-orange-dark:#ff3d00;
                --mi-text:#101828;
                --mi-muted:#596273;
                --mi-border:#dfe4ec;
            }
            *{ box-sizing:border-box; }
            html, body{
                min-height:100%;
            }
            body.login{
                margin:0 !important;
                min-height:100vh;
                font-family:'Inter','Open Sans',Arial,sans-serif !important;
                background:url('<?php echo base_url("assets/admin_theme/pages/media/bg/bg6.jpg"); ?>') center center / cover no-repeat fixed !important;
                color:var(--mi-text);
                overflow-x:hidden;
                overflow-y:auto;
                display:flex;
                align-items:center;
                justify-content:center;
            }
            @keyframes miFadeUp{
                from{
                    opacity:0;
                    transform:translateY(18px);
                }
                to{
                    opacity:1;
                    transform:translateY(0);
                }
            }
            @keyframes miSoftPop{
                0%{
                    opacity:0;
                    transform:scale(.94);
                }
                100%{
                    opacity:1;
                    transform:scale(1);
                }
            }
            @keyframes miIconPulse{
                0%, 100%{
                    box-shadow:0 8px 20px rgba(255,138,42,.22);
                }
                50%{
                    box-shadow:0 12px 28px rgba(255,138,42,.34);
                }
            }
            .content#register-content{
                width:100% !important;
                max-width:900px !important;
                margin:0 auto !important;
                padding:12px 16px !important;
                position:relative;
            }
            .register-form{
                width:100% !important;
                margin:0 auto !important;
                padding:12px 14px 8px !important;
                border-radius:34px !important;
                background:transparent !important;
                border:0 !important;
                box-shadow:0 30px 80px rgba(16,24,40,.14) !important;
                backdrop-filter:blur(20px);
                -webkit-backdrop-filter:blur(20px);
                overflow:hidden;
                animation:miFadeUp .55s ease both;
                position:relative;
                z-index:1;
            }
            .register-form:before{
                content:'\f007';
                font-family:FontAwesome;
                width:64px;
                height:64px;
                margin:0 auto 8px;
                border:1.8px solid #ff8a2a;
                border-radius:50%;
                display:flex;
                align-items:center;
                justify-content:center;
                color:#ff8a2a;
                font-size:30px;
                background:#fff;
                box-shadow:0 8px 20px rgba(255,138,42,.22);
                animation:miSoftPop .45s ease .12s both, miIconPulse 2.8s ease-in-out .7s infinite;
            }
            .register-form h3{
                margin:0 0 12px !important;
                font-size:22px;
                line-height:1.2;
                font-weight:700;
                color:#101828 !important;
                animation:miFadeUp .45s ease .08s both;
                position:relative;
            }
            .register-form h3 .mi-accent{ color:var(--mi-orange-dark); }
            .register-form > center br{
                display:none;
            }
            .register-form > center .text-danger:not(:empty),
            .register-form > center .text-success:not(:empty){
                display:block;
                margin:6px 0 8px;
            }
            .register-form > .col-md-6{
                width:50%;
                float:left;
                padding-left:8px;
                padding-right:8px;
            }
            .register-form .col-md-12{
                width:100%;
                float:left;
                padding-left:8px;
                padding-right:8px;
            }
            .register-form .form-group{
                margin-bottom:5px !important;
                animation:miFadeUp .42s ease both;
            }
            .register-form > .col-md-6:nth-of-type(1) .form-group:nth-child(1){ animation-delay:.10s; }
            .register-form > .col-md-6:nth-of-type(1) .form-group:nth-child(2){ animation-delay:.14s; }
            .register-form > .col-md-6:nth-of-type(1) .form-group:nth-child(3){ animation-delay:.18s; }
            .register-form > .col-md-6:nth-of-type(1) .form-group:nth-child(4){ animation-delay:.22s; }
            .register-form > .col-md-6:nth-of-type(2) .form-group:nth-child(1){ animation-delay:.12s; }
            .register-form > .col-md-6:nth-of-type(2) .form-group:nth-child(2){ animation-delay:.16s; }
            .register-form > .col-md-6:nth-of-type(2) .form-group:nth-child(3){ animation-delay:.20s; }
            .register-form > .col-md-6:nth-of-type(2) .form-group:nth-child(4){ animation-delay:.24s; }
            .register-form > .form-group.col-md-12{ animation-delay:.28s; }
            .register-form > .form-group.col-md-6{ animation-delay:.32s; }
            .register-form .help-inline.text-danger{
                font-size:12px;
                display:block !important;
                width:100%;
                /* margin-top:6px; */
                text-align:left;
                position:static !important;
                float:none !important;
                clear:both !important;
            }
            .register-form .control-label{
                color:#374151;
                font-size:13px;
                font-weight:600;
                margin-bottom:6px;
            }
            .register-form label[for="cust_pan_img"],
            .register-form label[for="cust_id_img"]{
                color:#111827 !important;
                font-size:14px;
                font-weight:700;
                margin-bottom:6px;
                display:inline-block;
            }
            .register-form .input-icon{
                height:36px;
                border:1px solid #cfd6e2;
                border-radius:4px;
                background:rgba(255,255,255,.92);
                display:flex;
                align-items:center;
                position:relative;
                box-shadow:inset 0 0 0 1px rgba(255,255,255,.75), 0 4px 14px rgba(16,24,40,.035);
                transition:border-color .18s ease, box-shadow .18s ease, background .18s ease;
            }
            .register-form textarea.form-control{
                min-height:48px;
                padding-top:6px !important;
                padding-bottom:6px !important;
                resize:none;
            }
            .register-form .input-icon.textarea-box{
                height:auto;
                min-height:58px;
                align-items:flex-start;
                padding-top:3px;
            }
            .register-form .input-icon.textarea-box > i{
                height:auto !important;
                line-height:1.2 !important;
                padding-top:8px;
            }
            .register-form .input-icon.textarea-box textarea.form-control{
                min-height:44px;
                padding-top:2px !important;
                padding-left:0 !important;
                line-height:1.4;
            }
            .register-form .input-icon > i{
                position:static !important;
                width:42px !important;
                height:36px !important;
                line-height:36px !important;
                text-align:center !important;
                margin:0 !important;
                color:#7d8794 !important;
                font-size:16px !important;
            }
            .register-form .input-icon .form-control{
                border:0 !important;
                background:transparent !important;
                box-shadow:none !important;
                padding:0 12px 0 0 !important;
                color:#111827;
                font-size:14px;
                line-height:1.2;
                -webkit-appearance:none;
                appearance:none;
                background-clip:padding-box;
            }
            .register-form .input-icon:hover{
                border-color:#b8c2d1;
                background:#fff !important;
                transform:translateY(-1px);
            }
            .register-form .input-icon:focus-within{
                border-color:#ff7a00 !important;
                box-shadow:inset 0 0 0 1px rgba(255,255,255,.9), 0 0 0 3px rgba(255,122,0,.18), 0 8px 20px rgba(16,24,40,.08);
                background:#fff !important;
                transform:translateY(-1px);
            }
            .register-form .input-icon:focus-within > i{
                color:#ff7a00 !important;
            }
            .register-form .input-icon .form-control:focus{
                outline:none !important;
                box-shadow:none !important;
            }
            .register-form .smart-file{
                border:0 !important;
                box-shadow:none !important;
            }
            .register-form .input-icon.file-upload-box{
                height:auto;
                min-height:54px;
                border:1px dashed #ffa667;
                border-radius:4px;
                background:#fffdf9;
                padding:6px;
                display:flex;
                align-items:center;
                justify-content:center;
                gap:8px;
                position:relative;
            }
            .register-form .input-icon.file-upload-box:hover{
                border-color:#ff7a00;
                box-shadow:0 0 0 3px rgba(255,122,0,.14);
                transform:translateY(-1px);
            }
            .register-form .file-upload-box > i{
                width:42px !important;
                color:#ff7a00 !important;
            }
            .register-form .upload-ui-text{
                display:flex;
                flex-direction:column;
                align-items:center;
                line-height:1.2;
            }
            .register-form .upload-title{
                color:#ff6a00;
                font-weight:700;
                font-size:12px;
                margin-bottom:1px;
                text-shadow:0 0 0 rgba(0,0,0,0.01);
            }
            .register-form .upload-subtitle{
                color:#4b5563;
                font-size:10px;
                font-weight:500;
            }
            .register-form .selected-file-wrap{
                margin-top:0;
                min-height:0;
                font-size:12px;
                line-height:1.3;
            }
            .register-form .selected-file-wrap.has-file{
                margin-top:4px;
                min-height:16px;
            }
            .register-form .preview-file-link{
                display:none;
                color:#ff6a00;
                font-weight:600;
                word-break:break-all;
                text-decoration:underline;
            }
            .register-form .file-upload-box .smart-file{
                position:absolute;
                inset:0;
                opacity:0;
                cursor:pointer;
                width:100%;
                height:100%;
                z-index:5;
                display:block !important;
            }
            .register-form .file-upload-box .btn,
            .register-form .file-upload-box .bootstrap-filestyle,
            .register-form .file-upload-box .input-group,
            .register-form .file-upload-box .file-input-label{
                display:none !important;
            }
            .register-form .form-actions{
                clear:both;
                margin:3px 0 0 !important;
                padding:0 !important;
                border:0 !important;
                text-align:center;
                animation:miFadeUp .42s ease .36s both;
            }
            .register-form .btn.red,
            .register-form .btn.green{
                min-width:150px;
                height:42px;
                line-height:42px !important;
                border-radius:16px !important;
                padding:0 24px !important;
                font-size:16px !important;
                font-weight:600 !important;
                transition:transform .18s ease, box-shadow .18s ease, filter .18s ease, background .18s ease;
            }
            .register-form .btn.red{
                background:#dce3eb !important;
                color:#111827 !important;
                border:0 !important;
            }
            .register-form .btn.green{
                border:0 !important;
                background:linear-gradient(135deg,#ff9700 0%, #ff3d00 100%) !important;
                color:#fff !important;
                box-shadow:0 17px 34px rgba(255,86,0,.30);
                position:relative;
                display:inline-block;
            }
            .register-form .btn.green:hover,
            .register-form .btn.green:focus{
                transform:translateY(-1px);
                box-shadow:0 20px 38px rgba(255,86,0,.38);
                filter:brightness(1.03);
            }
            .register-form .btn.red:hover,
            .register-form .btn.red:focus{
                transform:translateY(-1px);
                box-shadow:0 10px 22px rgba(15,23,42,.12);
                background:#e8edf3 !important;
            }
            .register-form .btn.green:active,
            .register-form .btn.red:active{
                transform:translateY(0);
                box-shadow:0 6px 14px rgba(15,23,42,.14);
            }
            .register-form .btn.green:after{
                content:'\f178';
                font-family:FontAwesome;
                margin-left:8px;
                display:inline-block;
                transition:transform .18s ease;
            }
            .register-form .btn.green:hover:after,
            .register-form .btn.green:focus:after{
                transform:translateX(3px);
            }
            .mi-card-copy{
                margin-top:10px;
                padding-top:3px;
                border-top:1px solid #e5e7eb;
                text-align:center;
                color:#4b5563;
                font-size:12px;
                line-height:1.25;
                animation:miFadeUp .42s ease .42s both;
            }
            .mi-card-copy a{ text-decoration:none; color:#4b5563; }
            .mi-card-copy .mi-company{ color:var(--mi-orange-dark); font-weight:600; }
            .mi-card-copy .mi-phone{ color:var(--mi-orange-dark); font-weight:700; }
            .mi-card-copy .mi-company:hover,
            .mi-card-copy .mi-phone:hover{ text-decoration:underline; }
            .mi-card-copy > div:first-child,
            .mi-card-copy > div:last-child{ white-space:nowrap; }
            .copyright{ display:none !important; }
            #mymodal .modal-dialog{
                width:min(390px, calc(100vw - 32px)) !important;
                margin:clamp(80px, 12vh, 130px) auto 24px !important;
            }
            #mymodal .modal-content{
                border:1px solid rgba(255,255,255,.95) !important;
                border-radius:22px !important;
                overflow:hidden;
                background:rgba(255,255,255,.94) !important;
                box-shadow:0 28px 70px rgba(16,24,40,.28) !important;
                backdrop-filter:blur(18px);
                -webkit-backdrop-filter:blur(18px);
                font-family:'Inter','Open Sans',Arial,sans-serif !important;
            }
            #mymodal .modal-header{
                padding:18px 20px !important;
                border:0 !important;
                background:linear-gradient(135deg,#ff9700 0%, #ff3d00 100%) !important;
            }
            #mymodal .modal-title{
                display:flex;
                align-items:center;
                gap:10px;
                margin:0 !important;
                color:#fff !important;
                font-size:18px !important;
                line-height:1.3;
                font-weight:800 !important;
            }
            #mymodal .modal-title i{
                width:24px;
                height:24px;
                border:1px solid rgba(255,255,255,.85);
                border-radius:50%;
                display:inline-flex;
                align-items:center;
                justify-content:center;
                color:#fff !important;
                font-size:13px;
                flex-shrink:0;
            }
            #mymodal .close{
                display:none !important;
            }
            #mymodal .modal-body{
                padding:24px 20px !important;
                background:#fff !important;
            }
            #mymodal .modal-body p,
            #mymodal .modal-body > .modal-message{
                margin:0 !important;
                color:#111827 !important;
                font-size:15px;
                line-height:1.55;
                font-weight:500;
            }
            #mymodal .otp-modal-field{
                margin:0 !important;
            }
            #mymodal .modal-body center,
            #mymodal .modal-body button{
                display:none !important;
            }
            #mymodal .otp-modal-field .form-control{
                height:44px !important;
                border:1px solid #d0d5dd !important;
                border-radius:0 !important;
                background:#fff !important;
                color:#111827 !important;
                font-size:14px !important;
                box-shadow:none !important;
            }
            #mymodal .otp-modal-field .form-control:focus{
                border-color:#ff7a00 !important;
                box-shadow:0 0 0 3px rgba(255,122,0,.18) !important;
                outline:none !important;
            }
            #mymodal #error_span{
                display:block;
                margin-top:6px;
                font-size:12px;
                line-height:1.3;
                font-weight:600;
            }
            #mymodal .modal-footer{
                display:flex;
                align-items:center;
                justify-content:center;
                gap:10px;
                padding:14px 16px !important;
                border-top:1px solid #e5e7eb !important;
                background:#fafafa !important;
            }
            #mymodal .modal-footer .btn{
                min-width:96px;
                height:38px;
                margin:0 !important;
                border-radius:10px !important;
                font-size:14px !important;
                line-height:38px !important;
                padding:0 16px !important;
                font-weight:700;
                transition:transform .18s ease, box-shadow .18s ease, background .18s ease;
            }
            #mymodal .modal-footer .btn-default{
                border:1px solid #d0d5dd !important;
                background:#fff !important;
                color:#344054 !important;
            }
            #mymodal .modal-footer .btn-danger,
            #mymodal .modal-footer .btn-fill-out{
                border:0 !important;
                background:linear-gradient(135deg,#ff9700 0%, #ff3d00 100%) !important;
                color:#fff !important;
                box-shadow:0 12px 24px rgba(255,86,0,.28);
            }
            @media (prefers-reduced-motion:reduce){
                .register-form,
                .register-form:before,
                .register-form h3,
                .register-form .form-group,
                .register-form .form-actions,
                .mi-card-copy{
                    animation:none !important;
                }
                .register-form .input-icon,
                .register-form .btn.green:after{
                    transition:none !important;
                }
            }
            @media (max-width:900px){
                .content#register-content{ max-width:600px !important; }
                .register-form > .col-md-6,
                .register-form .col-md-12{
                    width:100%;
                    float:none;
                    padding-left:0;
                    padding-right:0;
                }
            }
            @media (max-width:620px){
                html, body,
                body.login{
                    min-height:100%;
                }
                .content#register-content{
                    margin:24px auto 14px !important;
                    padding:0 12px !important;
                }
                .register-form{ padding:20px 16px 14px !important; border-radius:28px !important; }
                .register-form h3{ font-size:28px; margin-bottom:14px !important; }
                .register-form .form-actions .btn.red,
                .register-form .form-actions .btn.green{
                    width:48%;
                    min-width:0;
                    margin:0 !important;
                }

                .register-form .form-actions center{
                    display:flex;
                    gap:10px;
                    justify-content:space-between;
                }
                .mi-card-copy{ font-size:12px; line-height:1.6; }
                #mymodal .modal-dialog{
                    margin:22px auto;
                    width:calc(100% - 24px);
                }
                #mymodal .modal-title{
                    font-size:15px !important;
                    line-height:1.35;
                }
                #mymodal .modal-footer{
                    flex-direction:column;
                    align-items:stretch;
                }
                #mymodal .modal-footer .btn{
                    width:100%;
                }
            }
        </style>
		</head>
    <!-- END HEAD -->

    <body class="login">
        <div class="content" id="register-content">		
			
			<?php if(isset($register_now) && !empty($register_now)){ ?>
			
			    <!-- BEGIN REGISTRATION FORM -->
            <form class="register-form"  style="display:block;" id="registration_form" action="<?php echo base_url()."register-now"?>" method="post" enctype="multipart/form-data">
                <center><h3>Registration for MI-Btrack <span class="mi-accent">CRM</span></h3>
				 <span  class="text-danger"><?php echo $this->session->flashdata('rn_error'); ?></span>
			     <span  class="text-success"><?php echo $this->session->flashdata('rn_successs'); ?></span><br/><br/></center>
				 <div class="col-md-6">
                <div class="form-group ">
                    <label class="control-label visible-ie8 visible-ie9">Owner Name <?php echo REQUIRED_STAR; ?></label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Owner Name *" name="cust_name" id="cust_name" maxlength="100" value="<?php echo set_value("cust_name");?>" required /> </div>
						<?php echo form_error('cust_name','<span class="text-danger">','</span>'); ?>
                </div> 
				 <div class="form-group">                  
                    <label class="control-label visible-ie8 visible-ie9">Contact No <?php echo REQUIRED_STAR; ?></label>
                    <div class="input-icon">
                        <i class="fa fa-phone"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Contact No *" name="cust_contact" id="cust_contact" maxlength="10" value="<?php echo set_value("cust_contact");?>" required /> </div>
						<?php echo form_error('cust_contact','<span class="text-danger">','</span>'); ?>
                </div>
                <div class="form-group">                    
                    <label class="control-label visible-ie8 visible-ie9">Email ID <?php echo REQUIRED_STAR; ?></label>
                    <div class="input-icon">
                        <i class="fa fa-envelope"></i>
                        <input class="form-control placeholder-no-fix" type="email" placeholder="Email ID *"name="cust_contact_email" id="cust_contact_email" maxlength="100"  value="<?php echo set_value("cust_contact_email");?>" required /> </div>
						<?php echo form_error('cust_contact_email','<span class="text-danger">','</span>'); ?>
                </div> 

              <div class="form-group">                    
                    <label class="control-label visible-ie8 visible-ie9">Pan No. </label>
                    <div class="input-icon">
                        <i class="fa fa-file-image-o"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="PAN No."name="cust_panno" id="cust_panno" maxlength="10"  value="<?php echo set_value("cust_panno");?>" /> </div>
						<?php echo form_error('cust_panno','<span class="text-danger">','</span>'); ?>
                </div>
                		
				</div>
				 <div class="col-md-6">
				
				<div class="form-group ">
                    <label class="control-label visible-ie8 visible-ie9">Company Name <?php echo REQUIRED_STAR; ?></label>
                    <div class="input-icon">
                        <i class="fa fa-university"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Company Name *"  name="cust_comp_name" id="cust_comp_name" maxlength="100" value="<?php echo set_value("cust_comp_name");?>"  required /> </div>
						<?php echo form_error('cust_comp_name','<span class="text-danger">','</span>'); ?>
                </div>
				<div class="form-group">                  
                    <label class="control-label visible-ie8 visible-ie9">Contact Person <?php echo REQUIRED_STAR; ?></label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Contact Person *" name="cust_contact_person" id="cust_contact_person" maxlength="100" value="<?php echo set_value("cust_contact_person");?>" required /> </div>
						<?php echo form_error('cust_contact_person','<span class="text-danger">','</span>'); ?>
                </div> 
				<div class="form-group">                    
                    <label class="control-label visible-ie8 visible-ie9">Website </label>
                    <div class="input-icon">
                        <i class="fa fa-at"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Website"name="cust_website" id="cust_website" maxlength="100"  value="<?php echo set_value("cust_website");?>"  /> </div>
						<?php echo form_error('cust_website','<span class="text-danger">','</span>'); ?>
                </div>
				<div class="form-group">                    
                    <label class="control-label visible-ie8 visible-ie9">GST No. </label>
                    <div class="input-icon">
                        <i class="fa fa-file-image-o"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="GST No."name="cust_id_num" id="cust_id_num" maxlength="50"  value="<?php echo set_value("cust_id_num");?>" /> </div>
						<?php echo form_error('cust_id_num','<span class="text-danger">','</span>'); ?>
                </div>				
				</div>  				
				<div class="form-group col-md-12">                    
                    <label class="control-label visible-ie8 visible-ie9 " >Address</label>
                    <div class="input-icon textarea-box">
                        <i class="fa fa-home"></i>
                        <textarea class="form-control placeholder-no-fix" placeholder="Address" name="cust_address" id="cust_address" maxlength="500" style="resize:none;" ><?php echo set_value("cust_address");?></textarea> </div>
						<?php echo form_error('cust_address','<span class="text-danger">','</span>'); ?>
                </div>
				  <div class="form-group col-md-6">
					   <label for="cust_pan_img">PAN Image</label><br/>
					    <div class="input-icon file-upload-box">
                        <i class="fa fa-upload"></i>
                        <div class="upload-ui-text">
                            <span class="upload-title">Upload PAN Image</span>
                            <span class="upload-subtitle">JPG, PNG</span>
                        </div>
						<input type="file" name="cust_pan_img"  id="cust_pan_img" 
						class="smart-file" 
                        data-preview="off"
						data-label="Upload PAN Image" 
						data-btn-class="btn btn red-pink btn-sm" 
				
						data-file-types="image/jpeg,image/png,image/jpg" accept="image/*"  />
						</div>
						<div class="selected-file-wrap">
							<a href="#" class="preview-file-link" data-file-input="cust_pan_img" target="_blank" rel="noopener"></a>
						</div>
						<?php echo form_error('cust_pan_img','<span class="text-danger">','</span>'); ?>
						<span class="file_err text-danger"></span>
				  </div>
                 		  <!-- data data-preview="on" is off -->
				<div class="form-group col-md-6 ">
				   <label for="cust_id_img">GST Certificate Image</label><br/>
				     <div class="input-icon file-upload-box">
                    <i class="fa fa-upload"></i>
                    <div class="upload-ui-text">
                        <span class="upload-title">Upload GST Certificate Image</span>
                        <span class="upload-subtitle">JPG, PNG</span>
                    </div>
					<input type="file" name="cust_id_img"  id="cust_id_img" 
					class="smart-file" 
					data-label="Upload GST Certificate Image" 
					data-btn-class="btn btn red-pink btn-sm" 
					
					data-file-types="image/jpeg,image/png,image/jpg" accept="image/*"    />
					</div>
					<div class="selected-file-wrap">
						<a href="#" class="preview-file-link" data-file-input="cust_id_img" target="_blank" rel="noopener"></a>
					</div>
					<?php echo form_error('cust_id_img','<span class="text-danger">','</span>'); ?>								
					<span class="file_err text-danger "></span>
				</div>  
               <!-- data data-preview="on" is off -->
                <div class="form-actions">
				   <center>
                    <a href="<?php echo base_url("login"); ?>" class="btn red"> Back </a> 
                    <span id="register-submit-btn" class="btn green"> Register</span>
					</center>
                </div>
                <div class="mi-card-copy">
                    <div>Copyright &copy; <?php echo date("Y")?> <a class="mi-company" href="https://mibtrack.co.in/index/" target="_blank">MI-Btrack CRM</a></div>
                    <div>Any Enquiry? Call: <a class="mi-phone" href="tel:+918356919267">8356919267</a> | <a class="mi-phone" href="tel:+918879038139">8879038139</a></div>
                </div>
				
            </form>
            <!-- END REGISTRATION FORM -->
			<?php } ?>
        </div>
        <!-- END LOGIN -->
		

        <!-- BEGIN COPYRIGHT -->
        <div class="copyright">  Copyright &copy; <?php echo date("Y")?> <a href="https://mibtrack.co.in/index/" target="_blank" style="color:#5bedcb;" >MI-Btrack CRM</a> </div>
        <!-- END COPYRIGHT -->

        <div class="modal fade" id="mymodal" tabindex="-1" role="dialog" data-backdrop="static">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">            
                        <div class="modal-header bg-red-mint">
                            <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title font-white" id="otpModalLabel"><i class="font-bold icon-info"></i>&nbsp; Validate OTP</h4>
                        </div>            
                        <div class="modal-body">          
                            <p id="otpModalBody">Sent OTP On Your Registered Mobile. Please Enter OTP</p>
                        </div>                
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-danger btn-ok" title="Validate" type="button" onclick="validate_otp();">Validate</button>
                        </div>
                    </div>
                </div>
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
		  <script> var base_url = '<?php echo get_module_path();?>'</script>
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo get_assets_path(); ?>admin_theme/file_upload_jscss/js/bootstrap_file_field.js" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/js/login_custom.js').'?v='.filemtime(FCPATH.'assets/js/login_custom.js'); ?>" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });				
				// Keep native file input so entire upload rectangle remains clickable.				
			jQuery.validator.addMethod("pan", function(value, element, param) {
            return this.optional(element) ||  /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/.test(value);
            }, "Enter Valid PAN No.");	

	$("#registration_form").validate({
        rules: {
            required: {
                required: true
            },
            cust_name: {
                required: true,
                maxlength: 100,
            },
			cust_comp_name: {
                required: true,
                maxlength: 100,
            },
			cust_contact: {
                required: true,
                maxlength: 10,
                minlength: 10,
				digits:true,
            },
			cust_contact_email: {
                required: true,
                maxlength: 100, 
				email: true,
            },
			cust_contact_person: {
                required: true,
                maxlength: 100, 
            },
			cust_address: {
                maxlength: 500, 
            },
			cust_website: {
                maxlength: 100, 
            },
			cust_panno: {
				pan: true,
                maxlength: 10, 
            },
			cust_id_num: {
                maxlength: 50, 
            },
			cust_pan_img: {				 
                   accept: "image/jpeg,image/png,image/jpg",
   				}, 
			cust_id_img: {				 
                   accept: "image/jpeg,image/png,image/jpg",
   				}, 
        },
        messages: {
            cust_contact: {
                minlength: "Please enter at least 10 digits."
            }
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
		   if (element.is(":file")) {
			 error.appendTo((element).parents('.form-group').find('.file_err'));
			}else { // This is the default behavior of the script for all fields
			error.insertAfter(element.closest('.input-icon'));
			}
		 }
    });

	function updateSelectedFileLink(input) {
		var file = input.files && input.files[0];
		var $previewLink = $('.preview-file-link[data-file-input="' + input.id + '"]');
		var $uploadBox = $(input).closest('.file-upload-box');
		var previousUrl = $previewLink.data('previewUrl');

		if (previousUrl) {
			URL.revokeObjectURL(previousUrl);
			$previewLink.removeData('previewUrl');
		}

		if (!file) {
			$previewLink.hide().attr('href', '#').text('');
			$previewLink.closest('.selected-file-wrap').removeClass('has-file');
			$uploadBox.removeClass('file-selected');
			$(input).closest('.form-group').find('.fileList').empty();
			$(input).closest('.form-group').find('.file_err').text('');
			return;
		}

		var objectUrl = URL.createObjectURL(file);
		$previewLink.data('previewUrl', objectUrl);
		$previewLink.attr('href', objectUrl).text(file.name).show();
		$previewLink.closest('.selected-file-wrap').addClass('has-file');
		$uploadBox.addClass('file-selected');
		$(input).closest('.form-group').find('.file_err').text('');
	}
	$('#cust_pan_img, #cust_id_img').on('change', function() {
		var validator = $('#registration_form').data('validator');
		if (validator) {
			validator.element(this);
		}
		updateSelectedFileLink(this);
	});
    });
</script>
</body>
</html>
