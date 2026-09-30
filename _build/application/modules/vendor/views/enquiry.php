
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
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png');?>" /> 
		</head>
        <style>
          

            :root{
                --mi-orange:#ff6500;
                --mi-orange-dark:#ff3d00;
                --mi-black:#07111f;
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
                from{
                    opacity:0;
                    transform:translateY(18px);
                }
                to{
                    opacity:1;
                    transform:translateY(0);
                }
            }
            @keyframes miFadeRight{
                from{
                    opacity:0;
                    transform:translateX(-18px);
                }
                to{
                    opacity:1;
                    transform:translateX(0);
                }
            }
            @keyframes miFadeOnly{
                from{ opacity:0; }
                to{ opacity:1; }
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

            .logo{ display:none !important; }
            .mi-auth-page{
                min-height:100vh;
                display:flex;
                align-items:center;
                justify-content:space-between;
                padding:clamp(16px, 2vw, 44px);
                position:relative;
            }
            .mi-auth-left{
                flex:0 0 50%;
                max-width:50%;
                position:static;
                display:flex;
                flex-direction:column;
                justify-content:center;
                align-items:flex-end;
                padding:0 0 0 40px;
            }
            .mi-auth-left-inner{
                width:clamp(420px, 34vw, 760px);
                max-width:100%;
                transform:translate(50px, -20px);
                animation:miFadeOnly .55s ease both;
            }
            .mi-login-logo{
                display:block;
                width:clamp(365px, 16vw, 420px);
                height:auto;
                margin:0 0 6px;
                object-fit:contain;
            }
            .mi-auth-left h1{
                margin:0 0 12px;
                font-size:clamp(34px, 2.35vw, 64px);
                line-height:1.18;
                font-weight:700;
                letter-spacing:-1px;
                color:#101828;
            }
            .mi-auth-left h1 span{ color:var(--mi-orange); }

            /* .mi-line{ width:58px; height:3px; background:var(--mi-orange); border-radius:10px; margin-bottom:14px; }
            .mi-auth-left-inner > p{
                margin:0 0 20px;
                max-width:100%;
                font-size:clamp(13px, .82vw, 18px);
                line-height:1.45;
                color:#4b5563;
            } */
            .mi-line{ display:none; }
            .mi-auth-left-inner > p{
                margin:0 0 12px;
                max-width:100%;
                font-size:clamp(18px, 1.15vw, 24px);
                line-height:1.45;
                color:#101828;
            }
            .mi-feature{
                display:grid;
                grid-template-columns:clamp(44px, 3vw, 58px) 1fr;
                gap:clamp(12px, 1vw, 18px);
                align-items:center;
                margin-bottom:clamp(18px, 1.5vw, 28px);
                cursor:default;
                animation:miFadeRight .45s ease both;
            }
            .mi-feature:nth-of-type(1){ animation-delay:.10s; }
            .mi-feature:nth-of-type(2){ animation-delay:.16s; }
            .mi-feature:nth-of-type(3){ animation-delay:.22s; }
            .mi-feature-icon{
                width:clamp(42px, 2.8vw, 56px);
                height:clamp(42px, 2.8vw, 56px);
                border-radius:12px;
                background:#fff;
                border:1px solid rgba(255, 106, 0, .08);
                box-shadow:0 10px 22px rgba(15,23,42,.08);
                display:flex;
                align-items:center;
                justify-content:center;
                color:#ff6a00;
                font-size:clamp(18px, 1.25vw, 25px);
                position:relative;
                overflow:hidden;
                transition:all .22s ease;
            }
            .mi-feature-icon:before{
                content:'';
                position:absolute;
                width:64%;
                height:64%;
                border-radius:50%;
                background:#fff6ee;
                z-index:0;
            }
            .mi-feature-icon i{
                position:relative;
                z-index:1;
                text-shadow:none;
            }
            .mi-feature:hover .mi-feature-icon{
                transform:translateY(-3px);
                border-color:rgba(255, 106, 0, .18);
                box-shadow:0 14px 28px rgba(15,23,42,.12);
            }
            .mi-feature h4{ margin:0 0 5px; font-size:clamp(16px, 1.05vw, 21px); line-height:1.2; font-weight:700; color:#111827; cursor:default; transition:color .2s ease, transform .2s ease; }
            .mi-feature:hover h4{ color:var(--mi-orange-dark); transform:translateX(4px); }
            .mi-feature p{
                margin:0;
                max-width:100%;
                font-size:clamp(13px, .82vw, 17px);
                line-height:1.55;
                color:#4b5563;
            }

            .content{
                width:50% !important;
                max-width:50% !important;
                flex:0 0 50%;
                display:flex;
                justify-content:center;
                margin:0 !important;
                padding:0 !important;
                background:transparent !important;
                position:relative;
                z-index:2;
            }
            .login-form, .forget-form{
                width:100% !important;
                max-width:clamp(360px, 26vw, 640px) !important;
                min-height:auto;
                margin:0 auto !important;
                padding:clamp(18px, 1.4vw, 30px) clamp(18px, 1.5vw, 30px) clamp(8px, .8vw, 16px) !important;
                border-radius:clamp(24px, 2vw, 38px) !important;
                background:transparent !important;
                border:1px solid rgba(255,255,255,.95) !important;
                box-shadow:0 30px 80px rgba(16,24,40,.14) !important;
                backdrop-filter:blur(20px);
                -webkit-backdrop-filter:blur(20px);
                text-align:center;
                position:relative;
                animation:miFadeUp .55s ease both;
                overflow:hidden;
                z-index:1;
            }
           
        
            .login-form:before, .forget-form:before{
                content:'\f007';
                font-family:FontAwesome;
                width:clamp(60px, 4.5vw, 88px);
                height:clamp(60px, 4.5vw, 88px);
                margin:0 auto clamp(8px, .8vw, 14px);
                border:1.8px solid #ff8a2a;
                border-radius:50%;
                display:flex;
                align-items:center;
                justify-content:center;
                color:#ff8a2a;
                font-size:clamp(27px, 2.1vw, 40px);
                background:#fff;
                box-shadow:0 8px 20px rgba(255,138,42,.22);
                animation:miSoftPop .45s ease .12s both, miIconPulse 2.8s ease-in-out .7s infinite;
            }
            .forget-form:before{ content:'\f10b'; }
            .login-form .form-title, .forget-form h3{
                margin:0 0 12px !important;
                color:#101828 !important;
                font-size:clamp(21px, 1.6vw, 30px) !important;
                line-height:1.25;
                font-weight:700 !important;
                animation:miFadeUp .45s ease .08s both;
                position:relative;
            }
            .login-form .form-title{
                font-size:0 !important;
                margin-bottom:16px !important;
                padding-bottom:10px;
                overflow:visible;
                text-align:center;
            }
            .login-form .form-title:before{
                content:'MI-Btrack CRM  ';
                color:#101828;
                font-family:inherit;
                font-size:clamp(21px, 1.6vw, 30px);
                font-weight:700;
                line-height:1.25;
            }
            .login-form .form-title .mi-accent-title{
                color:var(--mi-orange-dark);
                font-family:inherit;
                font-size:clamp(21px, 1.6vw, 30px);
                font-weight:700;
                line-height:1.25;
            }
            .mi-deactivated-message{
                margin:-6px 0 14px;
                color:#ff2f2f !important;
                font-size:14px;
                line-height:1.45;
                font-weight:500;
            }
           
           
            .alert{ border-radius:12px !important; margin-bottom:16px !important; }

            .form-group{
                margin-bottom:10px !important;
                text-align:left;
                animation:miFadeUp .42s ease both;
            }
            
            .input-icon{
                height:clamp(42px, 3vw, 54px);
                border:1px solid var(--mi-border);
                border-radius:12px;
                background:rgba(255,255,255,.92);
                display:flex;
                align-items:center;
                position:relative;
                box-shadow:0 4px 14px rgba(16,24,40,.025);
                transition:border-color .18s ease, box-shadow .18s ease, background .18s ease, transform .18s ease;
            }
            .input-icon:hover{
                border-color:#b8c2d1;
                background:#fff !important;
                transform:translateY(-1px);
            }
            .input-icon > i:first-child{
                position:static !important;
                width:clamp(36px, 2.7vw, 48px) !important;
                height:clamp(42px, 3vw, 54px) !important;
                line-height:clamp(42px, 3vw, 54px) !important;
                text-align:center !important;
                margin:0 !important;
                color:#7d8794 !important;
                font-size:clamp(14px, 1vw, 18px) !important;
            }
            .input-icon .form-control{
                height:calc(clamp(42px, 3vw, 54px) - 2px) !important;
                border:0 !important;
                background:transparent !important;
                padding:0 18px 0 0 !important;
                font-size:clamp(13px, .9vw, 16px) !important;
                color:#111827 !important;
                box-shadow:none !important;
            }
            .input-icon .form-control::placeholder{ color:#6b7280; opacity:1; }
            .input-icon:focus-within{
                border-color:#ff7a00 !important;
                box-shadow:0 0 0 3px rgba(255,122,0,.18), 0 8px 20px rgba(16,24,40,.08);
                background:#fff !important;
                transform:translateY(-1px);
            }
            .input-icon:focus-within > i:first-child{
                color:#ff7a00 !important;
            }
            .input-icon .form-control:focus{
                outline:none !important;
                box-shadow:none !important;
            }
            .input-icon .fa-eye, .input-icon .fa-eye-slash{
                position:absolute !important;
                left:auto !important;
                right:18px !important;
                top:50% !important;
                transform:translateY(-50%) !important;
                margin-top:0 !important;
                line-height:1 !important;
                color:#7d8794 !important;
                font-size:clamp(16px, 1.2vw, 22px) !important;
            }

            .form-actions{
                padding:0 !important;
                margin:10px 0 0 !important;
                border:0 !important;
                background:transparent !important;
                clear:both;
                animation:miFadeUp .42s ease .24s both;
            }
            .form-actions center{ display:block; }
            .btn.green, .form-actions .btn.green{
                width:100%;
                height:clamp(40px, 3vw, 54px);
                border:0 !important;
                border-radius:16px !important;
                background:linear-gradient(135deg,#ff9700 0%, #ff3d00 100%) !important;
                color:#fff !important;
                font-size:clamp(14px, 1vw, 18px) !important;
                font-weight:500 !important;
                line-height:clamp(40px, 3vw, 54px) !important;
                padding:0 26px !important;
                box-shadow:0 17px 34px rgba(255,86,0,.30);
                position:relative;
                text-align:center;
                transition:transform .18s ease, box-shadow .18s ease, filter .18s ease, background .18s ease;
            }
            .login-form .btn.green:after, .forget-form .btn.green:after{
               
                font-family:FontAwesome;
                position:absolute;
                right:26px;
                top:50%;
                transform:translateY(-50%);
                font-size:clamp(18px, 1.4vw, 25px);
                transition:transform .18s ease;
            }
            .login-form .btn.green:hover:after,
            .login-form .btn.green:focus:after,
           
           
            .btn.green:hover, .form-actions .btn.green:hover,
            .btn.green:focus, .form-actions .btn.green:focus{
                transform:translateY(-1px);
                box-shadow:0 20px 38px rgba(255,86,0,.38);
                filter:brightness(1.03);
            }
           
            .btn.green:active, .form-actions .btn.green:active,
            .btn.red:active, .btn.grey-salsa:active{
                transform:translateY(0);
                box-shadow:0 6px 14px rgba(15,23,42,.14);
            }
           
           

            .mi-card-copy{
                margin-top:10px;
                padding-top:8px;
                border-top:1px solid #e5e7eb;
                text-align:center;
                color:#4b5563;
                font-size:clamp(11px, .78vw, 13px);
                line-height:1.5;
                animation:miFadeUp .42s ease .38s both;
            }
            .mi-card-copy a{
                text-decoration:none;
                color:#4b5563;
            }
            .mi-card-copy .mi-company{
                color:var(--mi-orange-dark);
                font-weight:600;
            }
            .mi-card-copy .mi-phone{
                color:var(--mi-orange-dark);
                font-weight:700;
            }
            .mi-card-copy .mi-company:hover,
            .mi-card-copy .mi-phone:hover{
                text-decoration:underline;
            }
            .mi-card-copy > div:first-child{
                white-space:nowrap;
            }
            .mi-card-copy > div:last-child{
                white-space:nowrap;
            }

            .copyright{ display:none !important; }

            .mi-auth-page .text-danger{ color:#ef4444 !important; }
            .mi-auth-page .text-success{ color:#16a34a !important; }
           
           

            #details_modal .modal-dialog,
            #renew_modal .modal-dialog,
            #payment_modal .modal-dialog,
            #mymodal .modal-dialog{
                width:min(390px, calc(100vw - 32px)) !important;
                margin:clamp(80px, 12vh, 130px) auto 24px !important;
            }
            #details_modal .modal-content,
            #renew_modal .modal-content,
            #payment_modal .modal-content,
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
            #details_modal .modal-header,
            #renew_modal .modal-header,
            #payment_modal .modal-header,
            #mymodal .modal-header{
                padding:18px 20px !important;
                border:0 !important;
                background:linear-gradient(135deg,#ff9700 0%, #ff3d00 100%) !important;
            }
            #details_modal .modal-title,
            #renew_modal .modal-title,
            #payment_modal .modal-title,
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
            #details_modal .modal-title i,
            #renew_modal .modal-title i,
            #payment_modal .modal-title i,
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
            #details_modal .modal-body,
            #renew_modal .modal-body,
            #payment_modal .modal-body,
            #mymodal .modal-body{
                padding:24px 20px !important;
                background:#fff !important;
            }
            #details_modal .modal-body p,
            #renew_modal .modal-body p,
            #payment_modal .modal-body p,
            #mymodal .modal-body p{
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
            #details_modal .modal-footer,
            #renew_modal .modal-footer,
            #payment_modal .modal-footer,
            #mymodal .modal-footer{
                display:flex;
                align-items:center;
                justify-content:center;
                gap:10px;
                padding:14px 16px !important;
                border-top:1px solid #e5e7eb !important;
                background:#fafafa !important;
            }
            #details_modal .modal-footer .btn,
            #renew_modal .modal-footer .btn,
            #payment_modal .modal-footer .btn,
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
            #details_modal .modal-footer .btn-default,
            #renew_modal .modal-footer .btn-default,
            #payment_modal .modal-footer .btn-default,
            #mymodal .modal-footer .btn-default{
                border:1px solid #d0d5dd !important;
                background:#fff !important;
                color:#344054 !important;
            }
            #details_modal .modal-footer .btn-danger,
            #renew_modal .modal-footer .btn-danger,
            #payment_modal .modal-footer .btn-danger,
            #mymodal .modal-footer .btn-danger,
            #mymodal .modal-footer .btn-fill-out{
                border:0 !important;
                background:linear-gradient(135deg,#ff9700 0%, #ff3d00 100%) !important;
                color:#fff !important;
                box-shadow:0 12px 24px rgba(255,86,0,.28);
            }
            #details_modal .modal-footer .btn:hover,
            #details_modal .modal-footer .btn:focus,
            #renew_modal .modal-footer .btn:hover,
            #renew_modal .modal-footer .btn:focus,
            #payment_modal .modal-footer .btn:hover,
            #payment_modal .modal-footer .btn:focus,
            #mymodal .modal-footer .btn:hover,
            #mymodal .modal-footer .btn:focus{
                transform:translateY(-1px);
                box-shadow:0 12px 24px rgba(16,24,40,.12);
            }
            #details_modal .modal-footer .btn-danger:hover,
            #details_modal .modal-footer .btn-danger:focus,
            #renew_modal .modal-footer .btn-danger:hover,
            #renew_modal .modal-footer .btn-danger:focus,
            #payment_modal .modal-footer .btn-danger:hover,
            #payment_modal .modal-footer .btn-danger:focus,
            #mymodal .modal-footer .btn-danger:hover,
            #mymodal .modal-footer .btn-danger:focus,
            #mymodal .modal-footer .btn-fill-out:hover,
            #mymodal .modal-footer .btn-fill-out:focus{
                box-shadow:0 16px 30px rgba(255,86,0,.34);
            }

            @media (prefers-reduced-motion:reduce){
                .mi-auth-left-inner,
                .mi-feature,
                .login-form,
                .forget-form,
                .forget-form:before,
                .login-form .form-title,
                .forget-form h3,
                .form-group,
                .form-actions,
                .mi-card-copy{
                    animation:none !important;
                }
                .input-icon,
                .login-form .btn.green:after,
                .forget-form .btn.green:after{
                    transition:none !important;
                }
            }

            @media (min-width:1800px){
                .mi-auth-page{
                    padding-left:6vw;
                    padding-right:6vw;
                }
                .mi-auth-left-inner{
                    transform:translateX(70px);
                }
            }
            @media (max-width:1400px){
                .mi-auth-page{ padding:24px 34px; }
            }
            @media (max-width:1100px){
                .mi-auth-page{ padding:110px 24px 60px; }
                .mi-auth-left{ display:none; }
                .content{
                    width:100% !important;
                    max-width:100% !important;
                    flex:0 0 100%;
                    justify-content:center;
                    padding:0 !important;
                }
                .copyright{ display:none !important; }
            }
            @media (max-height:720px) and (min-width:621px){
                .mi-auth-page{ padding-top:14px; padding-bottom:14px; }
                .login-form, .forget-form{
                    padding-top:16px !important;
                }
                .login-form:before, .forget-form:before{
                    width:58px;
                    height:58px;
                    font-size:26px;
                    margin-bottom:8px;
                }
                /* .mi-auth-left h1{
                    font-size:32px;
                    margin-bottom:8px;
                } */
                .mi-line{ margin-bottom:10px; }
                .mi-auth-left-inner > p{ margin-bottom:12px; }
                .mi-feature{ margin-bottom:14px; }
            }
            @media (max-width:620px){
                html, body.login{
                    min-height:100dvh;
                }
                body.login{
                    overflow-y:auto;
                    background-attachment:scroll !important;
                    background-position:center top !important;
                }
                .mi-auth-page{
                    min-height:100dvh;
                    padding:16px 14px !important;
                    align-items:center;
                    justify-content:center;
                }
                .content{
                    width:100% !important;
                    max-width:min(360px, calc(100vw - 28px)) !important;
                    flex:0 0 auto;
                    padding:0 !important;
                }
                .login-form, .forget-form{
                    width:100% !important;
                    max-width:none !important;
                    padding:14px 16px 12px !important;
                    min-height:auto;
                    border-radius:24px !important;
                    margin:0 auto !important;
                }
                .login-form:before, .forget-form:before{
                    width:60px;
                    height:60px;
                    margin-bottom:8px;
                    font-size:27px;
                }
                .login-form .form-title,
                .forget-form h3{
                    margin-bottom:10px !important;
                    line-height:1.2;
                }
                .login-form .form-title:before,
                .login-form .form-title .mi-accent-title{
                    font-size:20px;
                }
                .alert{
                    margin-bottom:10px !important;
                    padding:10px 28px 10px 12px !important;
                    font-size:12px;
                    line-height:1.35;
                }
                .form-group{ margin-bottom:8px !important; }
                .input-icon{ height:40px; border-radius:0; }
                .input-icon > i:first-child{
                    width:34px !important;
                    height:40px !important;
                    line-height:40px !important;
                    font-size:14px !important;
                }
                .input-icon .form-control{
                    height:38px !important;
                    font-size:12px !important;
                    padding-right:34px !important;
                }
                .input-icon .fa-eye,
                .input-icon .fa-eye-slash{
                    right:12px !important;
                    font-size:16px !important;
                }
                .form-actions{ margin-top:8px !important; }
                .btn.green,
                .form-actions .btn.green{
                    height:38px;
                    line-height:38px !important;
                    border-radius:14px !important;
                    font-size:14px !important;
                    box-shadow:0 10px 20px rgba(255,86,0,.24);
                }
                .login-form .btn.green:after,
                .forget-form .btn.green:after{
                    right:20px;
                    font-size:18px;
                }
              
                
                .modal-dialog{
                    width:auto !important;
                    margin:14px;
                }
                .modal-footer .btn{
                    width:100%;
                    margin:5px 0 !important;
                }
                #details_modal .modal-footer,
                #renew_modal .modal-footer,
                #payment_modal .modal-footer,
                #mymodal .modal-footer{
                    flex-direction:column;
                    align-items:stretch;
                }
                #details_modal .modal-footer .btn,
                #renew_modal .modal-footer .btn,
                #payment_modal .modal-footer .btn,
                #mymodal .modal-footer .btn{
                    width:100%;
                }
                .modal-title{
                    font-size:15px;
                    line-height:1.35;
                }
               
               
                .create-account .btn:before{ font-size:16px; }
                .mi-card-copy{
                    margin-top:8px;
                    padding-top:6px;
                    font-size:11px;
                    line-height:1.45;
                }
                .mi-card-copy > div:first-child,
                .mi-card-copy > div:last-child{
                    white-space:normal;
                }
            }
            @media (max-width:360px){
                .mi-auth-page{
                    padding:12px 10px !important;
                }
                .content{
                    max-width:calc(100vw - 20px) !important;
                }
                .login-form, .forget-form{
                    padding:12px 12px 10px !important;
                    border-radius:20px !important;
                }
                .login-form:before, .forget-form:before{
                    width:54px;
                    height:54px;
                    font-size:24px;
                }
                .login-form .form-title:before,
                .login-form .form-title .mi-accent-title{
                    font-size:18px;
                }
              
                .forget-form .form-actions{
                    grid-template-columns:1fr;
                    gap:8px;
                }
                .mi-card-copy{
                    font-size:10px;
                }
            }
        </style>
    <!-- END HEAD -->

    <body class="login">
        <!-- BEGIN LOGIN UI -->
        <div class="mi-auth-page">
            <aside class="mi-auth-left">
                <div class="mi-auth-left-inner">
                    <img class="mi-login-logo" src="<?php echo base_url('assets/admin_theme/pages/media/bg/login_logo.png'); ?>" alt="MI-Btrack">
                    <!-- <h1>MI-Btrack CRM<br>for <span>Smart</span> Business</h1> -->
                    <div class="mi-line"></div>
                    <p>Track, manage and grow your business with<br>MI-Btrack CRM.</p>

                    <div class="mi-feature">
                        <div class="mi-feature-icon"><i class="fa fa-users"></i></div>
                        <div>
                            <h4>Lead & Follow-up Management</h4>
                            <!-- <p>Track leads, manage follow-ups, and convert prospects faster.</p> -->
                        </div>
                    </div>
                    <div class="mi-feature">
                        <div class="mi-feature-icon"><i class="fa fa-file-text-o"></i></div>
                        <div>
                            <h4>Quotation, Invoice & Payment Management</h4>
                            <!-- <p>Create quotations, invoices, and track payments easily.</p> -->
                        </div>
                    </div>
                    <div class="mi-feature">
                        <div class="mi-feature-icon"><i class="fa fa-refresh"></i></div>
                        <div>
                            <h4>AMC Service & Renewal Tracking</h4>
                            <!-- <p>Manage AMC contracts, services, and renewals efficiently.</p> -->
                        </div>
                    </div>
                    <div class="mi-feature">
                        <div class="mi-feature-icon"><i class="fa fa-map-marker"></i></div>
                        <div>
                            <h4>Track employee attendance and selfie-based location tracking</h4>
                            <!-- <p>Track selfie attendance and employee location with GPS.</p> -->
                        </div>
                    </div>
                    <div class="mi-feature">
                        <div class="mi-feature-icon"><i class="fa fa-ticket"></i></div>
                        <div>
                            <h4>Ticket & Complaint Management</h4>
                            <!-- <p>Assign and monitor service tickets for faster resolution.</p> -->
                        </div>
                    </div>
                </div>
            </aside>
           
            <main class="content">

               
                    <!-- BEGIN LOGIN FORM -->
    <form class="login-form"
      action="<?php echo base_url('vendor/enquiry');?>"
      method="post"
      id="enquiryForm">

<h3 class="form-title text-center">

<span class="mi-accent-title">Enquiry</span>
</h3>

<p style="margin-top:-10px;margin-bottom:20px;color:#666;">
Fill in your details and our team will contact you shortly.
</p>


<?php if($this->session->flashdata('success')){ ?>

<div class="alert alert-success">
<?php echo $this->session->flashdata('success');?>
</div>

<?php } ?>


<?php if($this->session->flashdata('error')){ ?>

<div class="alert alert-danger">
<?php echo $this->session->flashdata('error');?>
</div>

<?php } ?>


<div class="form-group">

<div class="input-icon">

<i class="fa fa-user"></i>

<input
type="text"
name="customer_name"
class="form-control"
placeholder="Name *"
value="<?php echo set_value('customer_name');?>">

</div>

<?php echo form_error('customer_name','<span class="text-danger">','</span>');?>

</div>


<div class="form-group">

<div class="input-icon">

<i class="fa fa-phone"></i>

<input
type="text"
name="mobile_no"
maxlength="10"
class="form-control"
placeholder="Mobile Number *"
value="<?php echo set_value('mobile_no');?>">

</div>

<?php echo form_error('mobile_no','<span class="text-danger">','</span>');?>

</div>


<div class="form-group">

<div class="input-icon">

<i class="fa fa-building"></i>

<input
type="text"
name="company_name"
class="form-control"
placeholder="Company Name"
value="<?php echo set_value('company_name');?>">

</div>

<?php echo form_error('company_name','<span class="text-danger">','</span>');?>

</div>


<div class="form-group">

<div class="input-icon">

<i class="fa fa-briefcase"></i>

<input
type="text"
name="nature_of_business"
class="form-control"
placeholder="Nature Of Business"
value="<?php echo set_value('nature_of_business');?>">

</div>

<?php echo form_error('nature_of_business','<span class="text-danger">','</span>');?>

</div>


<div class="form-actions">

<button class="btn green" type="submit">

Submit Enquiry

</button>

</div>

<div class="mi-card-copy">

<div>

Copyright © <?php echo date('Y');?>

<a class="mi-company"
href="https://mibtrack.co.in/index/"
target="_blank">

MI-Btrack CRM

</a>

</div>

<div>

Any Enquiry?

<a class="mi-phone" href="tel:+918356919267">

8356919267

</a>

|

<a class="mi-phone" href="tel:+918879038139">

8879038139

</a>

</div>

</div>

</form>
            <!-- END LOGIN FORM -->
		
		
           
			
			
			
			
			
            </main>
            <!-- removed extra visual panel -->
        </div>
        <!-- END LOGIN UI -->
                
        <!-- START MODAL -->		
        <div class="modal fade" id="details_modal" tabindex="-1" role="dialog"  data-backdrop="static" >
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">            
                        <div class="modal-header bg-red-mint">
                            <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-info"></i>&nbsp; Registration Incomplete</h4>
                        </div>                            
                        <div class="modal-footer">
                        <a class="btn btn-default" href="<?php echo base_url(get_module()."/login/cancel_registration_completion"); ?>" >Cancel</a>
                            <a class="btn btn-danger btn-ok" href="<?php echo base_url()."complete-registration" ?> ">Complete Registration</a>
                        </div>
                    </div>
                </div>
        </div> 
        
        <div class="modal fade" id="renew_modal" tabindex="-1" role="dialog"  data-backdrop="static" >
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">            
                        <div class="modal-header bg-red-mint">
                            <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-info"></i>&nbsp; Subscription Expired</h4>
                        </div>            
                        <div class="modal-body">          
                            <p id="myModalBody"><?php echo isset($renew_login_msg)?$renew_login_msg:"Your Subscription Expired, Please Renew"; ?></p>
                        </div>                
                        <div class="modal-footer">
                        <a class="btn btn-default" href="<?php echo base_url(get_module()."/login/cancel_renew"); ?>" >Cancel</a>
                            <a class="btn btn-danger btn-ok" href="<?php echo base_url()."renew-subscription" ?> ">Renew Subscription</a>
                        </div>
                    </div>
                </div>
        </div> 
        
        <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog"  data-backdrop="static" >
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">            
                        <div class="modal-header bg-red-mint">
                            <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-info"></i>&nbsp; Your Demo Account will suspend within 3 days... Please Make Payment</h4>
                        </div>            
                        <div class="modal-body">          
                            <p id="myModalBody">Please Complete your Registration </p>
                        </div>                
                        <div class="modal-footer">
                            <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                            <a class="btn btn-danger btn-ok" href="<?php echo base_url()."pay-now" ?> ">Pay Now</a>
                        </div>
                    </div>
                </div>
        </div>

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

        <!-- END MODAL -->
 
        <!-- BEGIN COPYRIGHT -->
        <div class="copyright">  Copyright &copy; <?php echo date("Y")?> <a href="https://mibtrack.co.in/index/" target="_blank" style="color:#5bedcb;">MI-Btrack CRM</a> </br>
    
        <a>
            Any Enquiry? Call: <strong>8356919267</strong> | <strong>8879038139</strong>
            </a>
        
        </div>
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
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url('assets/admin_theme/global/scripts/app.min.js');?>" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
		  <script> var base_url = '<?php echo base_url();?>'</script>
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
       
		 <script src="<?php echo base_url('assets/js/login_custom.js').'?v='.filemtime(FCPATH.'assets/js/login_custom.js'); ?>" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>

$(function(){

$("#enquiryForm").validate({

rules:{

customer_name:{
required:true,
minlength:3,
maxlength:100,
pattern: /^[A-Za-z][A-Za-z\s.`-]*$/
},

mobile_no:{
required:true,
digits:true,
minlength:10,
maxlength:10,
pattern: /^[6-9][0-9]{9}$/
},

company_name:{
required:false,
maxlength:150
},

nature_of_business:{
required:false,
maxlength:150
}

},

errorClass:"help-inline text-danger",

errorElement:"span",

highlight:function(element){

$(element).parents(".form-group").addClass("has-error");

},

unhighlight:function(element){

$(element).parents(".form-group").removeClass("has-error");

}

});

});

</script>

        <script type="text/javascript">
        $(document).ready(function() {
            function placeAuthFieldError(error, element) {
                var inputIcon = element.closest('.input-icon');
                if (inputIcon.length) {
                    error.insertAfter(inputIcon);
                    return;
                }

                error.insertAfter(element);
            }

            $("#reset_password").validate({
                rules: {
                    required: {
                        required: true
                    },
                    new_password: {
                        required: true,
                        minlength: 6,
                        maxlength: 100,
                        noSpace: true,
                    },
                
                    confirm_password: {
                        required: true,
                        equalTo: "#new_password"
                    },
                
                },
        
                errorClass: "help-inline text-danger",
                errorElement: "span",
                errorPlacement: placeAuthFieldError,
                highlight: function(element, errorClass, validClass) {
                    $(element).parents('.form-group').addClass('has-error');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).parents('.form-group').removeClass('has-error');
                    $(element).parents('.form-group').addClass('has-success');
                }
            });
            $("#forgot_password").validate({
                rules: {
                    required: {
                        required: true
                    },
                    mobile_no: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        digits: true,
                    },
                
                            
                },
        
                errorClass: "help-inline text-danger",
                errorElement: "span",
                errorPlacement: placeAuthFieldError,
                highlight: function(element, errorClass, validClass) {
                    $(element).parents('.form-group').addClass('has-error');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).parents('.form-group').removeClass('has-error');
                    $(element).parents('.form-group').addClass('has-success');
                }
            });
            $("#validate_otp").validate({
                rules: {
                    required: {
                        required: true
                    },
                    otp: {
                        required: true,
                        maxlength: 6,
                    },                     
                },
                errorClass: "help-inline text-danger",
                errorElement: "span",
                errorPlacement: placeAuthFieldError,
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

        <script>
        if (window.location.search.includes('reason=deactivated')) {
            setTimeout(() => {
                history.replaceState({}, document.title, window.location.pathname);
            }, 2000);
        }
        </script>

        
</body>
</html>
