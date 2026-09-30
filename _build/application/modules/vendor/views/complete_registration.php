
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
      
		 <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />	
       <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css">
      <!-- END PAGE LEVEL PLUGINS -->	  
      <!-- END PAGE LEVEL STYLES -->
		 <link href="<?php echo get_assets_path(); ?>admin_theme/file_upload_jscss/css/bootstrap_file_field.css" rel="stylesheet" type="text/css" />
		 <link href="<?php echo base_url('assets/admin_theme/pages/css/login-4.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png');?>" /> 
		</head>
    <!-- END HEAD -->
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
    overflow-y:auto;
}
@keyframes miFadeUp{
    from{ opacity:0; transform:translateY(18px); }
    to{ opacity:1; transform:translateY(0); }
}
@keyframes miSoftPop{
    from{ opacity:0; transform:scale(.94); }
    to{ opacity:1; transform:scale(1); }
}
.content#complete-registration-content{
    width:100% !important;
    max-width:1180px !important;
    margin:24px auto 18px !important;
    padding:0 16px !important;
}
#complete-registration-content .row{
    margin-left:-8px;
    margin-right:-8px;
}
#complete-registration-content [class*="col-"]{
    padding-left:8px;
    padding-right:8px;
}
#complete-registration-content .col-md-offset-1.col-md-10{
    width:100%;
    margin-left:0;
}
#complete-registration-content .portlet.light.bordered{
    padding:20px 22px 16px !important;
    border:0 !important;
    border-radius:34px !important;
    background:rgba(255,255,255,.84) !important;
    box-shadow:0 30px 80px rgba(16,24,40,.14) !important;
    backdrop-filter:blur(20px);
    -webkit-backdrop-filter:blur(20px);
    overflow:hidden;
    animation:miFadeUp .55s ease both;
}
#complete-registration-content .portlet.light.bordered > .portlet-title{
    margin:0 0 8px !important;
    padding:0 0 10px !important;
    border-bottom:1px solid rgba(223,228,236,.95) !important;
    text-align:center;
}
#complete-registration-content .portlet.light.bordered > .portlet-title .caption{
    float:none;
    display:inline-flex;
    align-items:center;
    gap:10px;
}
#complete-registration-content .portlet.light.bordered > .portlet-title .caption i{
    width:48px;
    height:48px;
    border:1.8px solid #ff8a2a;
    border-radius:50%;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    color:#ff8a2a !important;
    background:#fff;
    font-size:22px;
    box-shadow:0 8px 20px rgba(255,138,42,.22);
    animation:miSoftPop .45s ease .12s both;
}
#complete-registration-content .portlet.light.bordered > .portlet-title .caption-subject{
    color:var(--mi-text) !important;
    font-size:24px;
    line-height:1.2;
    font-weight:800 !important;
}
#add_edit_form{
    display:block;
    width:100%;
    margin:0;
}
#add_edit_form .form-body{
    margin-left:-8px;
    margin-right:-8px;
}
#add_edit_form .form-body:before,
#add_edit_form .form-body:after{
    content:" ";
    display:table;
}
#add_edit_form .form-body:after{ clear:both; }
#add_edit_form .form-body > .col-md-12{
    margin-bottom:8px;
}
#add_edit_form .form-body > .mi-form-section{
    position:relative;
    margin-bottom:12px;
    padding:14px 10px 6px !important;
    border-top:1px solid rgba(223,228,236,.9);
    background:linear-gradient(180deg, rgba(255,255,255,.52) 0%, rgba(255,255,255,.2) 100%);
    border-radius:18px;
}
#add_edit_form .form-body > .mi-form-section:first-child{
    margin:0 !important;
    padding:0 !important;
    border-top:0;
    background:transparent;
}
#add_edit_form .form-body > .mi-form-section:first-child + .mi-form-section{
    border-top:0;
    padding-top:8px !important;
}
#add_edit_form .portlet-title{
    clear:both;
    margin:10px 0 12px !important;
    padding:0 !important;
    border:0 !important;
}
#add_edit_form .portlet-title br{ display:none; }
#add_edit_form .portlet-title .caption{
    float:none;
    display:flex;
    align-items:center;
    gap:9px;
    color:var(--mi-text);
}
#add_edit_form .portlet-title .caption i{
    width:34px;
    height:34px;
    border-radius:15px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:rgba(255,101,0,.1);
    color:var(--mi-orange-dark) !important;
    font-size:16px;
    font-style:normal;
    line-height:1;
}
#add_edit_form .portlet-title .caption i:before{
    /* color:var(--mi-orange-dark) !important; */
    display:block;
    font-family:FontAwesome !important;
    /* font-size:10px; */
    line-height:1;
}
#add_edit_form .portlet-title .caption i.icon-user:before{ content:"\f007"; }
#add_edit_form .portlet-title .caption i.icon-call-out:before{ content:"\f095"; }
#add_edit_form .portlet-title .caption i.icon-pointer:before{ content:"\f041"; }
#add_edit_form .portlet-title .caption i.icon-note:before{ content:"\f044"; }
#add_edit_form .portlet-title .caption i.icon-doc:before{ content:"\f0f6"; }
#add_edit_form .portlet-title .caption i.icon-mobile:before{ content:"\f10b"; }
#add_edit_form .portlet-title .caption-subject{
    color:var(--mi-text) !important;
    font-size:17px;
    font-weight:800 !important;
}
#add_edit_form .portlet-title hr{
    margin:10px 0 0 !important;
    border-color:rgba(223,228,236,.9);
}
.login .content label,
.login .content p{
    color:#374151;
}
#add_edit_form label{
    font-size:13px;
    font-weight:700;
    margin-bottom:6px;
}
#add_edit_form .form-group{
    margin-bottom:12px !important;
    animation:miFadeUp .42s ease both;
}
#add_edit_form .form-control{
    min-height:38px;
    border:1px solid #cfd6e2 !important;
    border-radius:4px !important;
    background:rgba(255,255,255,.92) !important;
    box-shadow:inset 0 0 0 1px rgba(255,255,255,.75), 0 4px 14px rgba(16,24,40,.035) !important;
    color:#111827;
    font-size:14px;
    transition:border-color .18s ease, box-shadow .18s ease, background .18s ease, transform .18s ease;
}
#add_edit_form .mi-kyc-section .mi-kyc-text-field{
    width:16.66666667%;
}
#add_edit_form .mi-kyc-section .mi-kyc-upload-field{
    width:20.83333333%;
}
#add_edit_form .mi-kyc-number-grid,
#add_edit_form .mi-kyc-upload-grid{
    width:100%;
    clear:both;
    display:grid;
    gap:14px;
}
#add_edit_form .mi-kyc-number-grid{
    grid-template-columns:repeat(2, minmax(180px, 260px));
    align-items:start;
    margin-bottom:14px;
}
#add_edit_form .mi-kyc-upload-grid{
    grid-template-columns:repeat(4, minmax(0, 1fr));
    align-items:start;
}
#add_edit_form .mi-kyc-number-grid .form-group,
#add_edit_form .mi-kyc-upload-grid .form-group{
    width:auto !important;
    float:none !important;
    padding-left:0 !important;
    padding-right:0 !important;
    margin-bottom:0 !important;
}
#add_edit_form .mi-kyc-upload-field{
    min-width:0;
}
#add_edit_form .mi-kyc-upload-field > label{
    min-height:18px;
    display:block;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}
#add_edit_form .mi-kyc-upload-field > br{
    display:none;
}
#add_edit_form .mi-address-grid{
    width:100%;
    clear:both;
    display:grid;
    grid-template-columns:repeat(3, minmax(0, 1fr));
    gap:12px 16px;
}
#add_edit_form .mi-address-grid .form-group{
    width:auto !important;
    float:none !important;
    padding-left:0 !important;
    padding-right:0 !important;
    margin-bottom:0 !important;
}
#add_edit_form .mi-address-full{
    grid-column:1 / -1;
}
#add_edit_form .mi-address-grid .form-control{
    width:100%;
}
#add_edit_form .form-control:hover{
    border-color:#b8c2d1 !important;
    background:#fff !important;
}
#add_edit_form .form-control:focus{
    border-color:#ff7a00 !important;
    box-shadow:inset 0 0 0 1px rgba(255,255,255,.9), 0 0 0 3px rgba(255,122,0,.18), 0 8px 20px rgba(16,24,40,.08) !important;
    background:#fff !important;
    outline:none !important;
}
#add_edit_form select.form-control{
    cursor:pointer;
}
#add_edit_form .input-icon{
    border:1px dashed #ffa667;
    border-radius:4px;
    background:#fffdf9;
    padding:6px;
    min-height:52px;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:border-color .18s ease, box-shadow .18s ease, transform .18s ease;
}
#add_edit_form .input-icon:hover{
    border-color:#ff7a00;
    box-shadow:0 0 0 3px rgba(255,122,0,.14);
    transform:translateY(-1px);
}
#add_edit_form .input-icon.file-upload-box{
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
    overflow:hidden;
}
#add_edit_form .mi-kyc-upload-field .file-upload-box{
    min-height:74px;
    height:74px;
    flex-direction:column;
    gap:4px;
}
#add_edit_form .file-upload-box > i{
    flex:0 0 auto;
    display:inline-block;
    color:#ff6a00 !important;
    font-size:16px;
    line-height:1;
}
#add_edit_form .upload-ui-text{
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    min-width:0;
    max-width:calc(100% - 28px);
    line-height:1.2;
}
#add_edit_form .upload-title{
    color:#ff6a00;
    font-weight:700;
    font-size:12px;
    margin-bottom:1px;
    max-width:100%;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}
#add_edit_form .mi-kyc-upload-field .upload-title{
    white-space:normal;
    text-align:center;
}
#add_edit_form .upload-subtitle{
    display:block;
    color:#4b5563;
    font-size:10px;
    font-weight:500;
}
#add_edit_form .selected-file-wrap{
    width:100%;
    margin-top:0;
    min-height:0;
    font-size:12px;
    line-height:1.3;
    clear:both;
}
#add_edit_form .selected-file-wrap.has-file{
    margin-top:6px;
    min-height:16px;
}
#add_edit_form .preview-file-link{
    display:none;
    color:#ff6a00;
    font-weight:600;
    max-width:100%;
    overflow-wrap:anywhere;
    text-decoration:underline;
}
#add_edit_form .mi-existing-doc{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    margin-top:8px;
    padding:9px 12px;
    min-height:40px;
    border:1px solid #ffd3b3;
    border-radius:999px;
    background:linear-gradient(135deg,#fff8f3 0%, #ffffff 100%);
    color:#ff4d00;
    font-size:12.5px;
    font-weight:700;
    line-height:1.2;
    text-decoration:none;
    width:100%;
    box-shadow:0 8px 18px rgba(255,101,0,.08);
    transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease, background .18s ease;
}
#add_edit_form .mi-existing-doc:before{
    content:"\f06e";
    font-family:FontAwesome;
    width:22px;
    height:22px;
    flex:0 0 22px;
    border-radius:50%;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:#ff6500;
    color:#fff;
    font-size:11px;
}
#add_edit_form .mi-existing-doc:hover,
#add_edit_form .mi-existing-doc:focus{
    color:#ff3d00;
    border-color:#ff9a55;
    background:#fff;
    box-shadow:0 12px 24px rgba(255,101,0,.14);
    transform:translateY(-1px);
    text-decoration:none;
    outline:none;
}
#add_edit_form .mi-existing-doc span{
    min-width:0;
    overflow:hidden;
    text-overflow:ellipsis;
}
#add_edit_form .mi-doc-stack{
    display:flex;
    flex-direction:column;
    gap:6px;
}
#add_edit_form .file-upload-box .smart-file{
    position:absolute;
    inset:0;
    opacity:0;
    cursor:pointer;
    width:100%;
    height:100%;
    z-index:5;
    display:block !important;
}
#add_edit_form .file-upload-box .btn,
#add_edit_form .file-upload-box .bootstrap-filestyle,
#add_edit_form .file-upload-box .input-group,
#add_edit_form .file-upload-box .file-input-label,
#add_edit_form .file-upload-box .fileList,
#add_edit_form .file-upload-box .file-list,
#add_edit_form .file-upload-box .preview,
#add_edit_form .file-upload-box .file-preview,
#add_edit_form .file-upload-box .selected-file,
#add_edit_form .file-upload-box .filename,
#add_edit_form .file-upload-box .file-name:not(.upload-title){
    display:none !important;
}
#add_edit_form .smart-file{
    border:0 !important;
    box-shadow:none !important;
}
#add_edit_form .thumbs{
    margin:8px 0 0;
}
#add_edit_form .thumbs img{
    border:1px solid var(--mi-border);
    border-radius:8px !important;
    background:#fff;
    padding:3px;
    box-shadow:0 8px 18px rgba(16,24,40,.08);
}
#ifsc_code{
    display:block;
    margin-top:5px;
    color:var(--mi-orange-dark) !important;
    font-weight:700;
}
#add_edit_form .mt-repeater{
    padding:14px;
    border:1px solid rgba(223,228,236,.9);
    border-radius:14px;
    background:rgba(255,255,255,.56);
}
#add_edit_form .mt-repeater [data-repeater-item]{
    margin-bottom:10px;
    padding:12px 4px;
    border-radius:12px;
    background:rgba(255,255,255,.65);
}
#add_edit_form .mt-repeater [data-repeater-item] > .col-md-1{
    padding-top:25px;
}
#add_edit_form .alt-contact-repeater [data-repeater-item] > .alt-contact-action{
    padding-top:25px;
}
#add_edit_form .mt-repeater .btn-danger{
    min-width:38px;
    width:38px;
    height:38px;
    line-height:38px;
    padding:0;
    border-radius:12px !important;
    border:0 !important;
    background:#dce3eb !important;
    color:#111827 !important;
    display:inline-flex;
    align-items:center;
    justify-content:center;
}
#add_edit_form .alt-contact-repeater .btn-info,
#add_edit_form .alt-contact-repeater .btn-danger{
    min-width:38px;
    width:38px;
    height:38px;
    line-height:38px;
    padding:0;
    border-radius:12px !important;
    border:0 !important;
    display:inline-flex;
    align-items:center;
    justify-content:center;
}
#add_edit_form .alt-contact-repeater .btn-info{
    background:linear-gradient(135deg,#ff9700 0%, #ff3d00 100%) !important;
    color:#fff !important;
    box-shadow:0 12px 26px rgba(255,86,0,.24);
}
#add_edit_form .alt-contact-repeater .mt-repeater-add{
    display:none !important;
}
#add_edit_form .mt-repeater-add{
    height:38px;
    line-height:38px;
    padding:0 16px !important;
    border-radius:12px !important;
    border:0 !important;
    background:linear-gradient(135deg,#ff9700 0%, #ff3d00 100%) !important;
    color:#fff !important;
    font-weight:700;
    box-shadow:0 12px 26px rgba(255,86,0,.24);
}
#add_edit_form .help-inline.text-danger,
#add_edit_form .text-danger{
    font-size:12px;
    font-weight:600;
}
#add_edit_form .mi-info-popover{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:16px;
    height:16px;
    margin-left:5px;
    border:0;
    border-radius:50%;
    background:#fff4ec;
    color:#ff6500;
    font-size:12px;
    line-height:16px;
    cursor:pointer;
    vertical-align:middle;
    padding:0;
}
#add_edit_form .mi-info-popover:hover,
#add_edit_form .mi-info-popover:focus{
    background:#ff6500;
    color:#fff;
    outline:none;
}
#add_edit_form .has-error .form-control{
    border-color:#ef9957 !important
}
#add_edit_form .has-success .form-control{
    border-color:#ffb780 !important;
}
#add_edit_form .form-actions{
    clear:both;
    margin:10px 0 0 !important;
    padding:10px 0 0 !important;
    border-top:1px solid rgba(223,228,236,.85) !important;
    text-align:center;
    animation:miFadeUp .42s ease .22s both;
}
#add_edit_form .form-actions .btn{
    min-width:132px;
    height:42px;
    line-height:42px !important;
    padding:0 24px !important;
    border-radius:16px !important;
    font-size:16px !important;
    font-weight:700 !important;
    border:0 !important;
    transition:transform .18s ease, box-shadow .18s ease, filter .18s ease, background .18s ease;
}
#add_edit_form .form-actions #add_edit_form_btn{
    min-width:150px;
    background:linear-gradient(135deg,#ff9700 0%, #ff3d00 100%) !important;
    color:#fff !important;
    box-shadow:0 17px 34px rgba(255,86,0,.30);
}
#add_edit_form .form-actions #add_edit_form_btn:after{
    content:'\f178';
    font-family:FontAwesome;
    margin-left:8px;
    display:inline-block;
    transition:transform .18s ease;
}
#add_edit_form .form-actions #add_edit_form_btn:hover:after{
    transform:translateX(3px);
}
#add_edit_form .form-actions .btn-danger{
    background:#dce3eb !important;
    color:#111827 !important;
}
#add_edit_form .form-actions .btn:hover,
#add_edit_form .form-actions .btn:focus{
    transform:translateY(-1px);
}
#add_edit_form .form-actions #add_edit_form_btn:hover,
#add_edit_form .form-actions #add_edit_form_btn:focus{
    box-shadow:0 20px 38px rgba(255,86,0,.38);
    filter:brightness(1.03);
}
#add_edit_form .form-actions .btn-danger:hover,
#add_edit_form .form-actions .btn-danger:focus{
    background:#e8edf3 !important;
    box-shadow:0 10px 22px rgba(15,23,42,.12);
}
#add_edit_form .form-actions .btn i{
    font-size:14px;
}
.mi-card-copy{
    clear:both;
    margin-top:10px;
    padding-top:8px;
    border-top:1px solid #e5e7eb;
    text-align:center;
    color:#4b5563;
    font-size:12px;
    line-height:1.35;
    animation:miFadeUp .42s ease .28s both;
}
.mi-card-copy a{
    text-decoration:none;
}
.mi-card-copy .mi-company,
.mi-card-copy .mi-phone{
    color:var(--mi-orange-dark);
    font-weight:700;
}
.mi-card-copy .mi-company:hover,
.mi-card-copy .mi-phone:hover{
    text-decoration:underline;
}
.copyright{
    display:none !important;
}
@media (prefers-reduced-motion:reduce){
    #complete-registration-content .portlet.light.bordered,
    #complete-registration-content .portlet.light.bordered > .portlet-title .caption i,
    #add_edit_form .form-group,
    #add_edit_form .form-actions{
        animation:none !important;
    }
}
@media (max-width:991px){
    .content#complete-registration-content{
        margin:16px auto 12px !important;
        padding:0 12px !important;
    }
    #complete-registration-content .portlet.light.bordered{
        padding:18px 16px 14px !important;
        border-radius:28px !important;
    }
    #add_edit_form .mi-kyc-number-grid{
        grid-template-columns:repeat(2, minmax(0, 1fr));
    }
    #add_edit_form .mi-kyc-upload-grid{
        grid-template-columns:repeat(2, minmax(0, 1fr));
    }
    #add_edit_form .mi-address-grid{
        grid-template-columns:repeat(2, minmax(0, 1fr));
    }
}
@media (max-width:620px){
    #add_edit_form .form-body > .mi-form-section{
        padding:12px 8px 4px !important;
        border-radius:14px;
    }
    #complete-registration-content .portlet.light.bordered > .portlet-title .caption{
        display:flex;
        flex-direction:column;
    }
    #complete-registration-content .portlet.light.bordered > .portlet-title .caption-subject{
        font-size:22px;
    }
    #add_edit_form .form-actions center{
        display:flex;
        gap:10px;
        justify-content:space-between;
    }
    #add_edit_form .form-actions .btn{
        width:48%;
        min-width:0 !important;
        margin:0 !important;
        padding:0 10px !important;
    }
    #add_edit_form .mt-repeater [data-repeater-item] > .col-md-1{
        padding-top:8px;
    }
    #add_edit_form .alt-contact-repeater [data-repeater-item] > .alt-contact-action{
        padding-top:8px;
    }
    #add_edit_form .mi-kyc-number-grid,
    #add_edit_form .mi-kyc-upload-grid,
    #add_edit_form .mi-address-grid{
        grid-template-columns:1fr;
    }
}
.mi-info-popover{
    width:13px !important;
    height:13px !important;
    min-width:13px !important;
    border-radius:50% !important;
    background:#e8f1ff !important;
    /* border:1px solid #215ac4 !important; */
    display:inline-flex !important;
    align-items:center !important;
    justify-content:center !important;
    padding:0 !important;
    margin-left:4px !important;
    box-shadow:none !important;
}

.mi-info-popover i{
    color:#2563eb !important;
    font-size:10px !important;
    background:none !important;
}


</style>
    <body class="login">
      
        <div class="content" id="complete-registration-content">		

      <!-- BEGIN PAGE BASE CONTENT -->
	
	
      <div class="row">
	  <div class="col-md-offset-1 col-md-10">
	  
         <div class="portlet light bordered">
           <div class="portlet-title">
               <div class="caption">
                  <i class="font-green-sharp icon-note "></i>
                  <span class="caption-subject font-green-sharp bold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div>
          
            <div class="row">
			
               
				  <?php
				    // echo "<pre/>"; print_r($details);die; 
				    $details = html_escape($details);
					$formaction = "complete-registration";
					
					    $cust_id_img    = isset($details['cust_id_img'])?$details['cust_id_img']:"";
						$cust_img_path  = isset($details['cust_img_path'])?$details['cust_img_path']:"";
						$cust_pan_img   = isset($details['cust_pan_img'])?$details['cust_pan_img']:"";
						$cust_qr_path   = isset($details['cust_qr_img'])?$details['cust_qr_path']:"";

						$cust_img_path     = str_replace("getAuthApiKey",APIKEY,$cust_img_path);
						$cust_id_img       = str_replace("getAuthApiKey",APIKEY,$cust_id_img);
						$cust_pan_img      = str_replace("getAuthApiKey",APIKEY,$cust_pan_img);
						$cust_qr_path      = str_replace("getAuthApiKey",APIKEY,$cust_qr_path);
						$company_type_id_value = set_value("company_type_id");
						$company_type_amount_value = set_value("cust_total_amount");
						if(empty($company_type_id_value) && !empty($company_type_list)){
							foreach($company_type_list as $company_type){
								$company_type_label = $company_type['ctm_type']." ".$company_type['ctm_name'];
								$company_type_key = strtolower(str_replace(array(' ', '-', '_'), '', $company_type_label));
								if($company_type_key == 'amcpestcontrol'){
									$company_type_id_value = $company_type['ctm_id'];
									$company_type_amount_value = $company_type['ctm_total_amt'];
									break;
								}
							}
							if(empty($company_type_id_value)){
								foreach($company_type_list as $company_type){
									$company_type_label = $company_type['ctm_type']." ".$company_type['ctm_name'];
									if(stripos($company_type_label, 'pest') !== false || stripos($company_type_label, 'paste') !== false){
										$company_type_id_value = $company_type['ctm_id'];
										$company_type_amount_value = $company_type['ctm_total_amt'];
										break;
									}
								}
							}
							if(empty($company_type_id_value)){
								$first_company_type = reset($company_type_list);
								$company_type_id_value = $first_company_type['ctm_id'];
								$company_type_amount_value = $first_company_type['ctm_total_amt'];
							}
						}
						$invoice_pattern_id_value = set_value("invoice_pattern_id");
						if(empty($invoice_pattern_id_value) && !empty($invoice_type_list)){
							foreach($invoice_type_list as $invoice_type){
								if(stripos($invoice_type['invoice_pattern'], 'default') !== false && stripos($invoice_type['invoice_pattern'], 'A4') !== false){
									$invoice_pattern_id_value = $invoice_type['invoice_id'];
									break;
								}
							}
							if(empty($invoice_pattern_id_value)){
								foreach($invoice_type_list as $invoice_type){
									if(stripos($invoice_type['invoice_pattern'], 'A4') !== false){
										$invoice_pattern_id_value = $invoice_type['invoice_id'];
										break;
									}
								}
							}
							if(empty($invoice_pattern_id_value)){
								$first_invoice_type = reset($invoice_type_list);
								$invoice_pattern_id_value = $first_invoice_type['invoice_id'];
							}
						}

					?>
					
                     <form action="<?php echo base_url().$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" enctype="multipart/form-data" >
					 <input type="hidden" id="company_type_id" name="company_type_id" value="<?php echo $company_type_id_value; ?>">
					 <input type="hidden" id="invoice_pattern_id" name="invoice_pattern_id" value="<?php echo $invoice_pattern_id_value; ?>">
					  <div class="form-body">
					  
					   <div class="col-md-12 mi-form-section" id="mi-company-details"> 
						<div class="form-group col-md-2 hidden">
                           <label for="cust_total_amount">Total Amount <?php echo REQUIRED_STAR; ?></label>
                           <input class="form-control" id="cust_total_amount" name="cust_total_amount" type="text" placeholder="Total Amount" maxlength='8' value="<?php echo $company_type_amount_value; ?>" readonly required>
						    <?php echo form_error('cust_total_amount','<span class="text-danger">','</span>'); ?>
                           </div>
                        </div>
						 
                      <div class="col-md-12 mi-form-section" id="mi-contact-details">
					     <div class="portlet-title">
					            <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-call-out"></i>
								  <span class="caption-subject font-red-mint sbold">Contact Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>
					 		<div class="form-group col-md-4">
                           <label for="cust_name">Customer Name</label> <?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="cust_name" name="cust_name" type="text" placeholder="Enter Customer Name" required maxlength="100" value="<?php echo isset($details['customer_name'])?$details['customer_name']:set_value("cust_name"); ?>" required>
						    <?php echo form_error('cust_name','<span class="text-danger">','</span>'); ?>
                        </div>

						<div class="form-group col-md-4">
                           <label for="cust_comp_name">Company Name<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="cust_comp_name" name="cust_comp_name" type="text" placeholder="Enter Company Name"  maxlength="100" value="<?php echo isset($details['cust_company_name'])?$details['cust_company_name']:set_value("cust_comp_name"); ?>" required>
						    <?php echo form_error('cust_comp_name','<span class="text-danger">','</span>'); ?>
                        </div>

						<div class="form-group col-md-4">
                           <label for="cust_gstno">Customer GST No <button type="button" class="mi-info-popover" data-toggle="popover" data-placement="top" data-trigger="hover focus" data-content="GST No. will display on your invoice, so fill it carefully." aria-label="GST number information"><i class="fa fa-info" style="color:#2563eb !important;"></i></button></label>
						   <input class="form-control" id="cust_gstno" name="cust_gstno" type="text" placeholder="Enter GST No"  maxlength="15" value="<?php echo isset($details['customer_gstno'])?$details['customer_gstno']:set_value("cust_gstno"); ?>">
						    <?php echo form_error('cust_gstno','<span class="text-danger">','</span>'); ?>
                        </div>

						<div class="form-group col-md-4">
                           <label for="cust_contact_person">Contact Person<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="cust_contact_person" name="cust_contact_person" type="text" placeholder="Enter Contact Person" maxlength="100" value="<?php echo isset($details['customer_contact_person'])?$details['customer_contact_person']:set_value("cust_contact_person"); ?>" required>
						    <?php echo form_error('cust_contact_person','<span class="text-danger">','</span>'); ?>
                        </div>
						
						<div class="form-group col-md-4">
                           <label for="cust_contact">Mobile No.<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="cust_contact" name="cust_contact" type="text" placeholder="Enter Mobile No." maxlength="10" value="<?php echo isset($details['customer_contact'])?$details['customer_contact']:set_value("cust_contact"); ?>" required>
						    <?php echo form_error('cust_contact','<span class="text-danger">','</span>'); ?>
                        </div>

						<div class="form-group col-md-4">
                           <label for="cust_contact_email">Email Id<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="cust_contact_email" name="cust_contact_email" type="text" placeholder="Enter Email Id." maxlength="100" value="<?php echo isset($details['customer_contact_email'])?$details['customer_contact_email']:set_value("cust_contact_email"); ?>" required>
						    <?php echo form_error('cust_contact_email','<span class="text-danger">','</span>'); ?>
                        </div>

						<div class="form-group col-md-4">
                           <label for="cust_landline">Landline No.</label>
						   <input class="form-control" id="cust_landline" name="cust_landline" type="text" placeholder="Enter Landline No." maxlength="15" value="<?php echo isset($details['cust_landline'])?$details['cust_landline']:set_value("cust_landline"); ?>" >
						    <?php echo form_error('cust_landline','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-4">
                           <label for="alt_cust_contact">Alternate Mobile No.</label>
						   <input class="form-control" id="alt_cust_contact" name="alt_cust_contact" type="text" placeholder="Enter Alternate Mobile No." maxlength="10" value="<?php echo isset($details['customer_alt_contact'])?$details['customer_alt_contact']:set_value("alt_cust_contact"); ?>">
						    <?php echo form_error('alt_cust_contact','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-4">
                           <label for="cust_website">Website</label>
						   <input class="form-control" id="cust_website" name="cust_website" type="text" placeholder="Enter Website" maxlength="100" value="<?php echo isset($details['cust_website'])?$details['cust_website']:set_value("cust_website"); ?>">
						    <?php echo form_error('cust_website','<span class="text-danger">','</span>'); ?>
                        </div>
						
					
                        </div>
					  
						 <div class="col-md-12 mi-form-section" id="mi-address-details">
						  <div class="portlet-title">
						       <br/>
							   <!-- <div class="caption">
								  <i class="font-red-mint icon-pointer"></i>
								  <span class="caption-subject font-red-mint sbold">Address Details</span>
							   </div> -->
							   <div class="caption">
								<i class="font-red-mint icon-pointer"></i>

								<span class="caption-subject font-red-mint sbold">
									Address Details

									<button type="button"
											class="mi-info-popover"
											data-toggle="popover"
											data-placement="top"
											data-trigger="hover focus"
											data-content="Please enter the address carefully as it will appear on invoices and quotations."
											aria-label="Address details information">

										<i class="fa fa-info" style="color:#2563eb !important;"></i>
									</button>

								</span>
								</div>

							   <hr style="margin:3px;"/>
						   </div>
						  <div class="mi-address-grid">
						  <div class="form-group col-md-12 mi-address-full">
                           <label for="cust_address">Address<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="cust_address" name="cust_address" type="text" placeholder="Enter Address"  maxlength="300" value="<?php echo isset($details['customer_address'])?$details['customer_address']:set_value("cust_address"); ?>" required>
						    <?php echo form_error('cust_address','<span class="text-danger">','</span>'); ?>
                         </div>
						 
						  <div class="form-group col-md-4"> 
							<label for="cust_stateid">State <?php echo REQUIRED_STAR; ?></label>
                            <select class="form-control" id="cust_stateid" name="cust_stateid" onchange="get_state_districts(this,'cust_distid');" required>
							<option value=""> Select State</option>
							 <?php  if(!empty($state_list)){ 
								foreach($state_list as $state){ 
								  $state_id =  isset($details['customer_state_id'])?$details['customer_state_id']:set_value("cust_stateid");
								  $selected = $state_id==$state['state_id']?"selected":"";
								
								?>
									<option value="<?php echo $state['state_id'];?>" <?php echo $selected;?> ><?php echo $state['state_name']; ?></option>
							<?php } } ?>	
						   </select>	
                           <?php echo form_error('cust_stateid','<span class="text-danger">','</span>'); ?>						   
                        </div> 
						<div class="form-group col-md-4">  
						<label for="cust_distid">District </label>  
                          <select class="form-control" id="cust_distid" name="cust_distid" onchange="get_district_cities(this,'cust_stateid','cust_cityid');" >
							<option value=""> Select District</option>
							 <?php  if(!empty($dist_list)){ 
								foreach($dist_list as $dist){ 
								  $dist_id =  isset($details['customer_dist_id'])?$details['customer_dist_id']:set_value("cust_distid");
								  $selected = $dist_id==$dist['dist_id']?"selected":"";

								?>
									<option value="<?php echo $dist['dist_id'];?>" <?php echo $selected;?> ><?php echo $dist['dist_name']; ?></option>
							<?php } } ?>	
						   </select>
							<?php echo form_error('cust_distid','<span class="text-danger">','</span>'); ?>							   
                        </div>
						<div class="form-group col-md-4">
                           <label for="cust_pincode">Pincode<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="cust_pincode" name="cust_pincode" type="text" placeholder="Enter Pincode"  maxlength="6" value="<?php echo isset($details['customer_pin'])?$details['customer_pin']:set_value("cust_pincode"); ?>" required>
						    <?php echo form_error('cust_pincode','<span class="text-danger">','</span>'); ?>
                         </div>			
						<div class="form-group col-md-4">  
						<label for="cust_cityid">City </label>   
                          <select class="form-control" id="cust_cityid" name="cust_cityid"  onchange="get_city_area(this,'cust_stateid','cust_distid','cust_area');" >
							<option value=""> Select City</option>
							 <?php  if(!empty($city_list)){ 
								foreach($city_list as $city){ 
								  $city_id =  isset($details['customer_city_id'])?$details['customer_city_id']:set_value("cust_cityid");
								  $selected = $city_id==$city['city_id']?"selected":"";
								
								?>
									<option value="<?php echo $city['city_id'];?>" <?php echo $selected;?> ><?php echo $city['city_name']; ?></option>
							<?php } } ?>	
						   </select>
							<?php echo form_error('cust_cityid','<span class="text-danger">','</span>'); ?>								   
                        </div>
						<div class="form-group col-md-4">
                           <label for="cust_area">Area</label>
						    <select class="form-control" id="cust_area" name="cust_area" >
							<option value=""> Select Area</option>
						    <?php  if(!empty($area_list)){ 
								foreach($area_list as $area){ 
								  $area_id =  isset($details['customer_area'])?$details['customer_area']:set_value("cust_area");
								  $selected = $area_id==$area['area_id']?"selected":"";
								
								?>
									<option value="<?php echo $area['area_id'];?>" <?php echo $selected;?> ><?php echo $area['area_name']; ?></option>
							<?php } } ?>	
						   </select>
							<?php echo form_error('cust_area','<span class="text-danger">','</span>'); ?>								   
                         </div>	
						 </div>
                    </div>

						<div class="col-md-12 mi-form-section" id="mi-bank-details">
						    <div class="portlet-title">
						       <br/>
							   <!-- <div class="caption">
								  <i class="font-red-mint  icon-note"></i>
								  <span class="caption-subject font-red-mint sbold">Bank Details</span>
							   </div> -->
						<div class="caption">
						<i class="font-red-mint icon-note"></i>

						<span class="caption-subject font-red-mint sbold">
							Bank Details

							<button type="button"
									class="mi-info-popover"
									data-toggle="popover"
									data-placement="top"
									data-trigger="hover focus"
									data-content="Please fill bank details carefully as they will appear on invoices and quotations."
									aria-label="Bank details information">

								<i class="fa fa-info" style="color:#2563eb !important;"></i>
							</button>

						</span>
						</div>
							  <hr style="margin:3px;"/>
						   </div>
						    <div class="col-md-4">
						    <div class="form-group">
                           <label for="bank_acc_name">Bank Account Name</label>
						   <input class="form-control" id="bank_acc_name" name="bank_acc_name" type="text" placeholder="Enter Bank Account Name"  maxlength="100" value="<?php echo isset($details['cust_bank_acc_name'])?$details['cust_bank_acc_name']:set_value("bank_acc_name"); ?>" >
						    <?php echo form_error('bank_acc_name','<span class="text-danger">','</span>'); ?>
                         </div>	
                         </div>	
						  <div class="col-md-4">
						 <div class="form-group">
                           <label for="bank_acc_number">Enter Account No.</label>
						   <input class="form-control" id="bank_acc_number" name="bank_acc_number" type="text" placeholder="Enter Account No."  maxlength="20" value="<?php echo isset($details['cust_bank_acc_number'])?$details['cust_bank_acc_number']:set_value("bank_acc_number"); ?>" >
						    <?php echo form_error('bank_acc_number','<span class="text-danger">','</span>'); ?>
                         </div>	
                         </div>	
						<div class="col-md-4">						 
						 <div class="form-group">
                           <label for="bank_ifsc">IFSC Code</label>
						   <input class="form-control" id="bank_ifsc" name="bank_ifsc" type="text" placeholder="Enter IFSC Code"  maxlength="15" value="<?php echo isset($details['cust_bank_ifsc'])?$details['cust_bank_ifsc']:set_value("bank_ifsc"); ?>" >
						    <?php echo form_error('bank_ifsc','<span class="text-danger">','</span>'); ?>
							<span id="ifsc_code" class="text-success"></span>
                         </div>	
                         </div>	
						  <div class="col-md-4">
						  <div class="form-group">
                           <label for="bank_name">Bank Name</label>
						   <input class="form-control" id="bank_name" name="bank_name" type="text" placeholder="Enter Bank Name"  maxlength="100" value="<?php echo isset($details['cust_bank_name'])?$details['cust_bank_name']:set_value("bank_name"); ?>" >
						    <?php echo form_error('bank_name','<span class="text-danger">','</span>'); ?>
                         </div>	 
                         </div>	 
						  <div class="col-md-4">
						 <div class="form-group">
                           <label for="bank_branch_address">Branch Address</label>
						   <input class="form-control" id="bank_branch_address" name="bank_branch_address" type="text" placeholder="Enter Branch Address"  maxlength="100" value="<?php echo isset($details['cust_bank_branch_address'])?$details['cust_bank_branch_address']:set_value("bank_branch_address"); ?>" >
						    <?php echo form_error('bank_branch_address','<span class="text-danger">','</span>'); ?>
                         </div>
                         </div>
						 <div class="col-md-4">
						 <div class="form-group">
                           <label for="bank_micr">Bank MICR</label>
						   <input class="form-control" id="bank_micr" name="bank_micr" type="text" placeholder="Enter Bank MICR"  maxlength="9" value="<?php echo isset($details['cust_bank_micr'])?$details['cust_bank_micr']:set_value("bank_micr"); ?>" >
						    <?php echo form_error('bank_micr','<span class="text-danger">','</span>'); ?>
                         </div>	
                         </div>	
                         </div>	
					
						   
						 <div class="col-md-12 mi-form-section" id="mi-reference-details">
						  <div class="portlet-title">
						       <br/>
							   <div class="caption">
								  <i class="font-red-mint  icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">Reference Details</span>
							   </div>
							  <hr style="margin:3px;"/>
						   </div>
						   <input type="hidden" id="cust_refbyid" name="cust_refbyid" value="" />
						
					     <div class="form-group col-md-4">
                           <label for="cust_refbyname">Reference Name </label>
                           <input class="form-control" id="cust_refbyname" name="cust_refbyname" type="text" placeholder="Enter Reference Name"  maxlength="200" value="<?php echo isset($details['cust_ref_name'])?$details['cust_ref_name']:set_value("cust_refbyname"); ?>" >
						    <?php echo form_error('cust_refbyname','<span class="text-danger">','</span>'); ?>
                        </div> 
						  	<div class="form-group col-md-4">
                           <label for="cust_refby_contact">Reference Contact </label>
						   <input class="form-control" id="cust_refby_contact" name="cust_refby_contact" type="text" placeholder="Enter Reference Contact" maxlength="10" value="<?php echo isset($details['cust_ref_contact'])?$details['cust_ref_contact']:set_value("cust_refby_contact"); ?>" >
						    <?php echo form_error('cust_refby_contact','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-4">
                           <label for="cust_refby_email">Reference Email Id </label>
						   <input class="form-control" id="cust_refby_email" name="cust_refby_email" type="text" placeholder="Enter Reference Email Id." maxlength="100" value="<?php echo isset($details['cust_ref_email'])?$details['cust_ref_email']:set_value("cust_refby_email"); ?>" >
						    <?php echo form_error('cust_refby_email','<span class="text-danger">','</span>'); ?>
                        </div>
						  </div>
						  <div class="col-md-12 mi-form-section mi-kyc-section" id="mi-kyc-details">
							  <div class="portlet-title">
								   <br/>

								   <!-- <div class="caption">
									  <i class="font-red-mint  icon-doc"></i>
									  <span class="caption-subject font-red-mint sbold"> KYC Details <button type="button" class="mi-info-popover" data-toggle="popover" data-placement="top" data-trigger="hover focus" data-content="Upload valid identity and business documents for verification." aria-label="KYC document information"><i class="fa fa-info" style="color:#2563eb !important;"></i></button></span>
								   </div> -->
						<div class="caption">
									<i class="font-red-mint icon-doc"></i>
									<span class="caption-subject font-red-mint sbold">
										KYC Details
									</span>
									</div>
								   <hr style="margin:3px;"/>
							   </div>
						<div class="mi-kyc-number-grid">
						
						<div class="form-group col-md-2 mi-kyc-text-field">
                           <label for="cust_panno">Pan No.</label>
						   <input class="form-control" id="cust_panno" name="cust_panno" type="text" placeholder="Enter Pan No." maxlength="10" value="<?php echo isset($details['cust_panno'])?$details['cust_panno']:set_value("cust_panno"); ?>" >
						    <?php echo form_error('cust_panno','<span class="text-danger">','</span>'); ?>
                        </div>
						<div class="form-group col-md-2 mi-kyc-text-field">
                           
							<label for="cust_id_num">GST No.<button type="button"
								class="mi-info-popover"
								data-toggle="popover"
								data-placement="top"
								data-trigger="hover focus"
								data-content="Please enter the GST number carefully as it will be displayed on invoices and quotations."
								aria-label="GST information">

							<i class="fa fa-info"></i>
						</button>
					</label>
						   <input class="form-control" id="cust_id_num" name="cust_id_num" type="text" placeholder="Enter GST No." maxlength="100" value="<?php echo isset($details['cust_id_no'])?$details['cust_id_no']:set_value("cust_id_num"); ?>" >
						    <?php echo form_error('cust_id_num','<span class="text-danger">','</span>'); ?>
                        </div>
						</div>
						<div class="mi-kyc-upload-grid">
						 <div class="form-group col-md-2 mi-kyc-upload-field">
					   <label for="cust_pan_img">PAN Image </label><br/>
					    <div class="input-icon file-upload-box">
                        <i class="fa fa-upload"></i>
                        <div class="upload-ui-text">
                            <span class="upload-title">Upload PAN Image</span>
                            <span class="upload-subtitle">JPG, PNG</span>
                        </div>
						<input type="file" name="cust_pan_img"  id="cust_pan_img" 
						class="smart-file" 
						data-label="Upload PAN Image" 
						data-btn-class="btn btn red-pink btn-sm" 
						data-preview="off"
						data-file-types="image/jpeg,image/png,image/jpg"    accept="image/*"  />
						</div>
						<div class="selected-file-wrap">
							<a href="#" class="preview-file-link" data-file-input="cust_pan_img" target="_blank" rel="noopener"></a>
						</div>
						<?php if(!empty($cust_pan_img)){ ?>
							<a href="<?php echo $cust_pan_img; ?>" class="mi-existing-doc fancybox-button" data-rel="fancybox-button" target="_blank" rel="noopener">
								<span>Current PAN Image</span>
							</a>
						<?php } ?>
						<?php echo form_error('cust_pan_img','<span class="text-danger">','</span>'); ?>
						<span class="file_err text-danger"></span>
						
				     </div>
				  <div class="form-group col-md-2 mi-kyc-upload-field">
				   <label for="cust_id_img">GST Certificate Image </label><br/>
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
					data-preview="off"
					data-file-types="image/jpeg,image/png,image/jpg"  accept="image/*"    />
					</div>
					<div class="selected-file-wrap">
						<a href="#" class="preview-file-link" data-file-input="cust_id_img" target="_blank" rel="noopener"></a>
					</div>
					<?php if(!empty($cust_id_img)){ ?>
						<a href="<?php echo $cust_id_img; ?>" class="mi-existing-doc fancybox-button" data-rel="fancybox-button" target="_blank" rel="noopener">
							<span>Current GST Certificate Image</span>
						</a>
					<?php } ?>
					<?php echo form_error('cust_id_img','<span class="text-danger">','</span>'); ?>								
					<span class="file_err text-danger "></span>
				</div>   
				<div class="form-group col-md-2 mi-kyc-upload-field">
				   <!-- <label for="cust_img">Company Logo </label><br/> -->
				<label for="cust_img">
					Company Logo
					<button type="button"
							class="mi-info-popover"
							data-toggle="popover"
							data-placement="top"
							data-trigger="hover focus"
							data-content="Please upload the company logo carefully as it will be displayed on your invoices and quotations."
							aria-label="Company logo information">
						<i class="fa fa-info" style="color:#2563eb !important;"></i>
					</button>
				</label><br/>
				     <div class="input-icon file-upload-box">
                    <i class="fa fa-upload"></i>
                    <div class="upload-ui-text">
                        <span class="upload-title">Upload Company Logo</span>
                        <span class="upload-subtitle">JPG, PNG</span>
                    </div>
					<input type="file" name="cust_img"  id="cust_img" 
					class="smart-file" 
					data-label="Upload Company Logo" 
					data-btn-class="btn btn red-pink btn-sm" 
					data-preview="off"
					data-file-types="image/jpeg,image/png,image/jpg"  accept="image/*"    />
					</div>
					<div class="selected-file-wrap">
						<a href="#" class="preview-file-link" data-file-input="cust_img" target="_blank" rel="noopener"></a>
					</div>
					<?php echo form_error('cust_img','<span class="text-danger">','</span>'); ?>								
					<span class="file_err text-danger "></span>
					<!--ul class="list-unstyled small fileList thumbs"><li><a class="fancybox-button" data-rel="fancybox-button" href="<?php echo $cust_img_path; ?>"><img title="" src="<?php echo $cust_img_path; ?>" class="img-rounded" width="100"><span class="file-name"></span></a></li></ul-->
				</div>  

				<div class="form-group col-md-2 mi-kyc-upload-field">
				   <!-- <label for="cust_qr">Payment QR </label><br/> -->
					<label for="cust_qr">
					Payment QR
					<button type="button"
							class="mi-info-popover"
							data-toggle="popover"
							data-placement="top"
							data-trigger="hover focus"
							data-content="Please upload the payment QR carefully as it will be displayed on your invoices for customer payments."
							aria-label="Payment QR information">

						<i class="fa fa-info" style="color:#2563eb !important;"></i>
					</button>

				</label><br/>
				     <div class="input-icon file-upload-box">
                    <i class="fa fa-upload"></i>
                    <div class="upload-ui-text">
                        <span class="upload-title">Upload Payment QR</span>
                        <span class="upload-subtitle">JPG, PNG</span>
                    </div>
					<input type="file" name="cust_qr"  id="cust_qr" 
					class="smart-file" 
					data-label="Upload Payment QR" 
					data-btn-class="btn btn red-pink btn-sm" 
					data-preview="off"
					data-file-types="image/jpeg,image/png,image/jpg"  accept="image/*"    />
					</div>
					<div class="selected-file-wrap">
						<a href="#" class="preview-file-link" data-file-input="cust_qr" target="_blank" rel="noopener"></a>
					</div>
					<?php echo form_error('cust_qr','<span class="text-danger">','</span>'); ?>								
					<span class="file_err text-danger "></span>
					<!--ul class="list-unstyled small fileList thumbs"><li><a class="fancybox-button" data-rel="fancybox-button" href="<?php echo $cust_qr_path; ?>"><img title="" src="<?php echo $cust_qr_path; ?>" class="img-rounded" width="100"><span class="file-name"></span></a></li></ul-->
				</div>  
				</div>
		   </div>

	   <div class="col-md-12 mi-form-section" id="mi-alt-contact-details">
	  <div class="portlet-title">
		   <br/>
		   <div class="caption">
			  <i class="font-red-mint  icon-mobile"></i>
			  <span class="caption-subject font-red-mint sbold"> Alternate Contact Details</span>
		   </div>
		   <hr style="margin:3px;"/>
		   
	   </div>
	  <div class="col-md-12">									 
	   <div class="mt-repeater alt-contact-repeater">
			<div data-repeater-list="group-b">
				<div data-repeater-item="" class="row">
					<div class="col-md-3">
						<label class="control-label">Contact Person</label>
						<input type="text" name="lead_altcontactperson" placeholder="Contact Person" class="form-control lead_altcontactperson"  maxlength="100" > </div>
					<div class="col-md-3">
						<label class="control-label">Contact No</label>
						<input type="text" name="lead_altcontact"  placeholder="Contact No." maxlength="10" class="form-control lead_altcontact"> 
					</div>	
					<div class="col-md-3">
						<label class="control-label">Email Id </label>
						<input type="text" name="lead_altemail"  placeholder="Email Id."  maxlength="100"  class="form-control lead_altemail"> 
					</div>
					<div class="col-md-3 alt-contact-action">
						<a href="javascript:;" class="btn btn-info js-alt-contact-add" title="Add another contact number">
							<i class="fa fa-plus"></i>
						</a>
					</div>
				</div>
			</div>
			<a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add"><i class="fa fa-plus"></i></a>
			 <span class="text-danger" id="err_msg"></span><br> 
			</div>
		 </div>
	   </div>
						 
						   <div class="form-actions">
						 <div class="">
						 <center>
                           <span class="btn btn-success"  id="add_edit_form_btn" >Submit</span>
                          <a href="<?php echo base_url();?>login" class="btn btn-danger"><i class="fa fa-history"></i> &nbsp; Back</a>
						   </center>
                        </div>
                        </div>
						<div class="mi-card-copy">
							<div>Copyright &copy; <?php echo date("Y")?> <a class="mi-company" href="https://mibtrack.co.in/index/" target="_blank">MI-Btrack CRM</a></div>
							<div>Any Enquiry? Call: <a class="mi-phone" href="tel:+918356919267">8356919267</a> | <a class="mi-phone" href="tel:+918879038139">8879038139</a></div>
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
  <!-- BEGIN COPYRIGHT -->
        <div class="copyright">  Copyright &copy; <?php echo date("Y")?> <a href="https://www.mauli-infotech.co.in/" target="_blank" style="color:#5bedcb;">Mauli Infotech (OPC) Pvt. Ltd.</a> </div>
        <!-- END COPYRIGHT -->
  <script> var base_url = '<?php echo get_module_path();?>'</script>
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
		
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
      
		<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/pages/scripts/form-icheck.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/file_upload_jscss/js/bootstrap_file_field.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/vendor.js'); ?>" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript" class=""></script>
  <script src="<?php echo base_url('assets/admin_theme/pages/scripts/login-4-2.js');?>" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-repeater/jquery.repeater.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/pages/scripts/form-repeater.min.js" type="text/javascript"></script>

		
<script type="text/javascript">
// Add Branch

$(document).ready(function() {
	
	$('.mi-info-popover').popover({
		container: 'body',
		html: false,
		trigger: 'hover focus'
	});

	$(document).on('click', function(e) {
		if (!$(e.target).closest('.mi-info-popover, .popover').length) {
			$('.mi-info-popover').popover('hide');
		}
	});
	
	 $('.smart-file').bootstrapFileField({
            maxNumFiles: 8,
            fileTypes: 'image/jpeg,image/png,image/jpg',  
		/* 	minNumFiles:1, */
            maxFileSize: 4000000 // 8Mb in bytes */
        });
	
	   
	 $('.datepicker').datepicker({
				format: 'dd-M-yyyy',
				autoclose: true,
				todayHighlight: true,

		});	
	
	$("#add_edit_form").validate({
        rules: {
            required: {
                required: true
            },
             company_type_id: {
                required: true,
			 }, 
			 invoice_pattern_id: {
                required: true,
			 },  
			 cust_stateid: {
                required: true,
			 },  
			/*  cust_distid: {
                required: true,
			 }, 
			 cust_cityid: {
                required: true,
			 },  */
			
				 
			cust_gstno: {
            	maxlength: 15,
                minlength: 2,
				gst:true,
				 }, 
				 
		    cust_name: {
				required: true,
            	maxlength: 100,
                minlength: 2,
				 }, 	
			cust_comp_name: {
				required: true,
            	maxlength: 100,
                minlength: 2,
				 }, 	
			cust_contact_person: {
				required: true,
            	maxlength: 100,
                minlength: 2,
				 }, 				 
			cust_contact: {
				required: true,
            	maxlength: 10,
                minlength: 10,
				digits:true,
				 }, 
			alt_cust_contact: {
            	maxlength: 10,
                minlength: 10,
				digits:true,
				 }, 
          cust_landline: {
		
            	maxlength: 15,
                digits:true,
				 }, 	
		  cust_contact_email: {
			  required: true,
            	maxlength: 100,
                email:true,
				 },  
		  cust_website: {
            	maxlength: 100,
				 },
		
		  cust_address: {
			   required: true,
			    maxlength: 1500,
                minlength: 2,
				 }, 
          cust_pincode: {
			    required: true,
				maxlength: 6,
                minlength: 6,
				digits:true,
				 }, 				 
		 	
		  cust_total_amount: {
			    required: true,
            	maxlength: 8,
				number:true,
				 }, 		  
		  cust_unit_no: {
			  /*  required: true, */
            	maxlength: 50,
				 }, 
		  cust_form_no: {
			   /*  required: true, */
            	maxlength: 50,
				 }, 
				 
		 cust_refbyname: {
			 /*   required: true, */
				maxlength: 200,
  				 },	
		 cust_refby_contact: {
               /*  required: true,		 */	 
				maxlength: 10,
                minlength: 10,
				digits:true,
  				 },  
		 cust_refby_email: {
			   /*  required: true, */
            	maxlength: 100,
                email:true,
				 },			 
		 "group-b[0][lead_altcontactperson[]]": {
			   /*  required: false, */
				maxlength: 100,
  				 },  
		 "group-b[0][lead_altcontact[]]": { 
                /* required: false,	 */	 
				maxlength: 10,
                minlength: 10,
				digits:true,
  				 },  		  
		  "group-b[0][lead_altemail[]]": {
			   /*  required: false, */
				maxlength: 100,
 				email:true,
  				 },   
		   cust_panno: {
				// required: true,
				pan: true,
                maxlength: 10, 
            },
			cust_id_num: {
				// required: true,
                maxlength: 50, 
            },
			cust_pan_img: {				 
				  /* required: true, */
                   accept: "image/jpeg,image/png,image/jpg",
				   filesize_max:1000000, // 1 MB
				   filesize_min:10000, // 1 KB
   				}, 
			cust_id_img: {				 
				  /* required: true, */
                   accept: "image/jpeg,image/png,image/jpg",
				   filesize_max:1000000, // 1 MB
				   filesize_min:10000, // 1 KB
   				}, 
			cust_img: {				 
				  /*  required: true, */
                   accept: "image/jpeg,image/png,image/jpg",
				   filesize_max:1000000, // 1 MB
				   filesize_min:10000, // 1 KB
   				}, 
				   cust_qr: {				 
				  /*  required: true, */
                   accept: "image/jpeg,image/png,image/jpg",
				   filesize_max:1000000, // 1 MB
				   filesize_min:10000, // 1 KB
   				}, 
				 bank_acc_name: {
			   	maxlength: 100,
				lettersonly:true,
				required: function(element){
                    if($("#bank_acc_number").val().length>0){
                        return true; }
                    else if($("#bank_name").val().length>0){
                        return true; } 
					else if($("#bank_ifsc").val().length>0){
                        return true; }
					else if($("#bank_branch_address").val().length>0){
                        return true;}
					else if($("#bank_micr").val().length>0){
                        return true; } 
				    else{ return false;}
                 },
               	 },	  
		    bank_micr: {
			   required: function(element){
                    if($("#bank_acc_number").val().length>0){
                        return true; }
                    else if($("#bank_name").val().length>0){
                        return true; } 
					else if($("#bank_ifsc").val().length>0){
                        return true; }
					else if($("#bank_branch_address").val().length>0){
                        return true;}
					else if($("#bank_acc_name").val().length>0){
                        return true; } 
				    else{ return false;}
                 },
            	maxlength: 9,
				digits:true,
               	 },
            bank_acc_number: {	
               required: function(element){
                    if($("#bank_micr").val().length>0){
                        return true; }
                    else if($("#bank_name").val().length>0){
                        return true; } 
					else if($("#bank_ifsc").val().length>0){
                        return true; }
					else if($("#bank_branch_address").val().length>0){
                        return true;}
					else if($("#bank_acc_name").val().length>0){
                        return true; } 
				    else{ return false;}
                 }, 
               	maxlength: 20,
                minlength: 2,
				digits:true,
				}, 
		    bank_name: {
                required: function(element){
                    if($("#bank_micr").val().length>0){
                        return true; }
                    else if($("#bank_acc_number").val().length>0){
                        return true; } 
					else if($("#bank_ifsc").val().length>0){
                        return true; }
					else if($("#bank_branch_address").val().length>0){
                        return true;}
					else if($("#bank_acc_name").val().length>0){
                        return true; } 
				    else{ return false;}
                 }, 	
               	maxlength: 100,
                minlength: 2,
		   	},
			bank_ifsc: {
			   ifsc: true,
               required: function(element){
                    if($("#bank_micr").val().length>0){
                        return true; }
                    else if($("#bank_acc_number").val().length>0){
                        return true; } 
					else if($("#bank_name").val().length>0){
                        return true; }
					else if($("#bank_branch_address").val().length>0){
                        return true;}
					else if($("#bank_acc_name").val().length>0){
                        return true; } 
				    else{ return false;}
                 }, 			
               	maxlength: 15,
                minlength: 11,
				 remote : { url : base_url + "login/checkIFSCExists", type :"post" },
				 }, 	
			bank_branch_address: {	
               required: function(element){
                    if($("#bank_micr").val().length>0){
                        return true; }
                    else if($("#bank_acc_number").val().length>0){
                        return true; } 
					else if($("#bank_name").val().length>0){
                        return true; }
					else if($("#bank_ifsc").val().length>0){
                        return true;}
					else if($("#bank_acc_name").val().length>0){
                        return true; } 
				    else{ return false;}
                 }, 				
               	maxlength: 250,
                minlength: 2,
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
		   if (element.is(":file")) {
			 error.appendTo((element).parents('.form-group').find('.file_err'));
			}else if (element.is(":checkbox")){ // This is the default behavior of the script for all fields
			error.appendTo("#file_err");
			}else { // This is the default behavior of the script for all fields
			error.insertAfter(element);
			}
			
		},
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
			$(input).closest('.form-group').find('.file_err').text('');
			return;
		}

		var objectUrl = URL.createObjectURL(file);
		$previewLink.data('previewUrl', objectUrl);
		$previewLink.attr('href', objectUrl).text(file.name).show();
		$previewLink.closest('.selected-file-wrap').addClass('has-file');
		$uploadBox.addClass('file-selected');
		$(input).closest('.form-group').find('.mi-existing-doc').hide();
		$uploadBox.find('.fileList, .file-list, .preview, .file-preview, .selected-file, .filename, .file-name').remove();
		$(input).closest('.form-group').find('.file_err').text('');
	}

	$('#cust_pan_img, #cust_id_img, #cust_img, #cust_qr').on('change', function() {
		var validator = $('#add_edit_form').data('validator');
		if (validator) {
			validator.element(this);
		}
		updateSelectedFileLink(this);
		var input = this;
		setTimeout(function() {
			$(input).closest('.file-upload-box').find('.fileList, .file-list, .preview, .file-preview, .selected-file, .filename, .file-name').remove();
		}, 0);
	});

	$('.file-upload-box').on('click', function(e) {
		if ($(e.target).is('input[type="file"]')) {
			return;
		}
		$(this).find('input[type="file"]').trigger('click');
	});

	function refreshAltContactNames($repeater) {
		$repeater.find('[data-repeater-item]').each(function(index) {
			var $row = $(this);

			$row.find('.lead_altcontactperson').attr('name', 'group-b[' + index + '][lead_altcontactperson]');
			$row.find('.lead_altcontact').attr('name', 'group-b[' + index + '][lead_altcontact]');
			$row.find('.lead_altemail').attr('name', 'group-b[' + index + '][lead_altemail]');
		});
	}

	function hasAltContactValue($row) {
		return $.trim($row.find('.lead_altcontactperson').val()) !== '' ||
			$.trim($row.find('.lead_altcontact').val()) !== '' ||
			$.trim($row.find('.lead_altemail').val()) !== '';
	}

	// function validateAltContactRow($row) {
	// 	var hasError = false;
	// 	var contactPerson = $.trim($row.find('.lead_altcontactperson').val());
	// 	var contactNo = $.trim($row.find('.lead_altcontact').val());
	// 	var contactEmail = $.trim($row.find('.lead_altemail').val());

	// 	$row.find('.js-alt-contact-error').remove();
	// 	$row.find('.lead_altcontactperson, .lead_altcontact, .lead_altemail').css('border', '');

	// 	if (contactPerson === '') {
	// 		hasError = true;
	// 		showAltContactError($row.find('.lead_altcontactperson'), "Contact Person is required");
	// 	}

	// 	if (contactNo === '') {
	// 		hasError = true;
	// 		showAltContactError($row.find('.lead_altcontact'), "Contact No. is required");
	// 	} else if (contactNo.length !== 10) {
	// 		hasError = true;
	// 		showAltContactError($row.find('.lead_altcontact'), "Contact Number Should be 10 Digits");
	// 	}

	// 	if (contactEmail && !(IsEmail(contactEmail))) {
	// 		hasError = true;
	// 		showAltContactError($row.find('.lead_altemail'), "Please Enter Valid Email Id");
	// 	}

	// 	return !hasError;
	// }


		
	// added by anjali for validating alternate contact details only if they are entered
			function validateAltContactRow($row) {
			var hasError = false;
			var contactPerson = $.trim($row.find('.lead_altcontactperson').val());
			var contactNo = $.trim($row.find('.lead_altcontact').val());
			var contactEmail = $.trim($row.find('.lead_altemail').val());

			$row.find('.js-alt-contact-error').remove();
			$row.find('.lead_altcontactperson, .lead_altcontact, .lead_altemail').css('border', '');

			// Validate Contact No. only if it is entered
			if (contactNo !== '' && contactNo.length !== 10) {
				hasError = true;
				showAltContactError($row.find('.lead_altcontact'), "Contact Number Should be 10 Digits");
			}

			// Validate Email only if it is entered
			if (contactEmail !== '' && !IsEmail(contactEmail)) {
				hasError = true;
				showAltContactError($row.find('.lead_altemail'), "Please Enter Valid Email Id");
			}

			return !hasError;
		}


	function clearAltContactErrors($scope) {
		$scope.find('.js-alt-contact-error').remove();
		$scope.find('.lead_altcontactperson, .lead_altcontact, .lead_altemail').css('border', '');
	}

	function showAltContactError($input, message) {
		$input
			.css('border', '1px solid red')
			.after('<span class="help-inline text-danger js-alt-contact-error">' + message + '</span>');
	}

	function removeExtraBlankAltContactRows($repeater) {
		var blankRowFound = false;

		$repeater.find('[data-repeater-item]').each(function() {
			var $row = $(this);

			if (hasAltContactValue($row)) {
				return;
			}

			if (blankRowFound) {
				$row.remove();
				return;
			}

			blankRowFound = true;
			$row.find('.js-alt-contact-delete')
				.removeClass('btn-danger js-alt-contact-delete')
				.addClass('btn-info js-alt-contact-add')
				.attr('title', 'Add another contact number')
				.html('<i class="fa fa-plus"></i>');
		});

		refreshAltContactNames($repeater);
	}

	$('.alt-contact-repeater').each(function() {
		removeExtraBlankAltContactRows($(this));
	});

	$(document).on('click', '.js-alt-contact-add', function(e) {
		e.preventDefault();

		var $button = $(this);
		var $repeater = $button.closest('.mt-repeater');
		var $currentRow = $button.closest('[data-repeater-item]');
		var $newRow = $currentRow.clone();

		clearAltContactErrors($currentRow);
		if (!validateAltContactRow($currentRow)) {
			$currentRow.find('.js-alt-contact-error').first().prev('input').focus();
			return;
		}

		$newRow.find('input').val('').css('border', '');
		$newRow.find('.help-inline, .text-danger')
			.not('#err_msg')
			.remove();

		$currentRow.after($newRow);

		$button
			.removeClass('btn-info js-alt-contact-add')
			.addClass('btn-danger js-alt-contact-delete')
			.attr('title', 'Remove contact number')
			.html('<i class="fa fa-close"></i>');

		refreshAltContactNames($repeater);
	});

	$(document).on('click', '.js-alt-contact-delete', function(e) {
		e.preventDefault();

		var $repeater = $(this).closest('.mt-repeater');

		$(this).closest('[data-repeater-item]').remove();
		removeExtraBlankAltContactRows($repeater);
	});
	
	$('#add_edit_form_btn').on('click', function(e){
		if($('#add_edit_form').valid()){
		var has_alt_contact_error = false;
		$("#err_msg").html("");
		clearAltContactErrors($('.mt-repeater'));
		$('.alt-contact-repeater').each(function() {
			var $repeater = $(this);
			var $rows = $repeater.find('[data-repeater-item]');

			$rows.each(function() {
				var $row = $(this);

				if (!hasAltContactValue($row) && $rows.length > 1) {
					$row.remove();
					return;
				}

				if (!validateAltContactRow($row)) {
					has_alt_contact_error = true;
				}
			});

			refreshAltContactNames($repeater);
		});
		if(!has_alt_contact_error){
			 $('#add_edit_form').submit();
		} else {
			e.preventDefault();
		}
		
		}
		
	 		
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

	

function get_service_amount(obj) {
	
	    var amount = $('option:selected', obj).attr('data-amount');
		$('#cust_total_amount').val(amount);
}

	
	function get_state_districts(obj,attr_dist_id)
	{
		var state_id  = $(obj).val();	
        $("#cust_area").html("");		
		$.ajax({
			url:base_url+"login/get_state_districts/"+state_id,
			type: "POST",
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
			{		
				var json_arr = JSON.parse(data);				
				var html_data = '<option value="">Select District</option>';
				if(json_arr.length>0){
					for(var i =0;i < json_arr.length;i++){
					  var item = json_arr[i];			  
						html_data += '<option value="'+ item.dist_id +'" data-name="'+ item.dist_name+'" >'+ item.dist_name+'</option>';
					} 
				}
					$("#"+attr_dist_id).html(html_data);

			}
		});
	}
function get_district_cities(obj,attr_state_id,attr_city_id)
	{
		var dist_id  = $(obj).val();		
		var state_id  = $("#"+attr_state_id).val();	
		$("#cust_area").html("");
       $("#"+attr_city_id).html("");		
		$.ajax({
			url:base_url+"login/get_district_cities",
			type: "POST",
			datatype: "json",
			data: {"dist_id":dist_id,"state_id":state_id},
			async: true,
			cache: false,
			success: function(data)
			{		
				var json_arr = JSON.parse(data);				
				var html_data = '<option value="">Select City</option>';
				if(json_arr.length>0){
					for(var i =0;i < json_arr.length;i++){
					  var item = json_arr[i];			  
						html_data += '<option value="'+ item.city_id +'" data-name="'+ item.city_name+'" >'+ item.city_name+'</option>';
					} 
				}
					$("#"+attr_city_id).html(html_data);

			}
		});
	}

	
function get_city_area(obj,attr_state_id,attr_dist_id,attr_area_id)
	{
		var city_id   = $(obj).val();		
		var state_id  = $("#"+attr_state_id).val();	
		var dist_id   = $("#"+attr_dist_id).val();	
		
		$("#"+attr_area_id).html("");		
		$.ajax({
			url:base_url+"login/get_city_area",
			type: "POST",
			datatype: "json",
			data: {"dist_id":dist_id,"state_id":state_id,"city_id":city_id},
			async: true,
			cache: false,
			success: function(data)
			{		
				var json_arr = JSON.parse(data);				
				var html_data = '<option value="">Select Area</option>';
				if(json_arr.length>0){
					for(var i =0;i < json_arr.length;i++){
					  var item = json_arr[i];			  
						html_data += '<option value="'+ item.area_id +'" >'+ item.area_name+'</option>';
					} 
				}
					$("#"+attr_area_id).html(html_data);

			}
		});
	}
function get_reference_details(obj){
	var ref_id = $(obj).val();
	$.ajax({
			url:base_url+"login/get_reference_details",
			type: "POST",
			datatype: "json",
			data: {"ref_id":ref_id},
			async: true,
			cache: false,
			success: function(data)
			{		
				var data = JSON.parse(data);	
				if(data){
                 $("#cust_refby_email").val(data.ref_email);
                 $("#cust_refbyname").val(data.ref_person_name);
                 $("#cust_refby_contact").val(data.ref_mobile);
				}
	
			}
		});
}

$('#bank_ifsc').change(function() {
			var bank_ifsc = $("#bank_ifsc").val();
			getIFSC(bank_ifsc);
	   });
function getIFSC(emp_bank_ifsc_code)
	{ 
	   $('#ifsc_code').html("");
		if(emp_bank_ifsc_code){
			$.ajax({
				url:base_url+"login/getIFSC",
				type: "POST",
				data: {'ifsc_code':emp_bank_ifsc_code},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var data = JSON.parse(data);
					$("#ifsc_code").html(data.BRANCH);
					$("#bank_branch_address").val(data.ADDRESS);
					$("#bank_name").val(data.BANK);
					$("#bank_micr").val(data.MICR);
				}
			});
		}
	} 
</script>
<script>
$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
});
</script>