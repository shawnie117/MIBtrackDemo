<?php
$vendor = $this->session->userdata('vendor');
$role_id = $vendor['user_role_id']; ?>
<!DOCTYPE html>
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
   <meta charset="utf-8" />
   <title> <?php echo SITE_NAME . " | ";
   echo isset($page_title) ? $page_title : ""; ?></title>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta content="width=device-width, initial-scale=1" name="viewport" />
   <meta content="Preview page of Metronic Admin Theme #4 for " name="description" />
   <meta content="" name="author" />
   <!-- BEGIN GLOBAL MANDATORY STYLES -->
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
      type="text/css" />
   <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/font-awesome/css/font-awesome.min.css"
      rel="stylesheet" type="text/css" />
   <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/simple-line-icons/simple-line-icons.min.css"
      rel="stylesheet" type="text/css" />
   <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap/css/bootstrap.min.css"
      rel="stylesheet" type="text/css" />
   <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"
      rel="stylesheet" type="text/css" />
   <!-- END GLOBAL MANDATORY STYLES -->
   <!-- BEGIN PAGE LEVEL PLUGINS -->
   <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"
      rel="stylesheet" type="text/css" />
   <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/fancybox/source/jquery.fancybox.css"
      rel="stylesheet" type="text/css">
   <!-- END PAGE LEVEL PLUGINS -->
   <!-- BEGIN THEME GLOBAL STYLES -->
   <link href="<?php echo get_assets_path(); ?>admin_theme/global/css/components-md.min.css" rel="stylesheet"
      id="style_components" type="text/css" />
   <link href="<?php echo get_assets_path(); ?>admin_theme/global/css/plugins-md.min.css" rel="stylesheet"
      type="text/css" />
   <!-- END THEME GLOBAL STYLES -->
   <!-- BEGIN PAGE LEVEL PLUGINS -->
   <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/icheck/skins/all.css" rel="stylesheet"
      type="text/css" />
   <!-- END PAGE LEVEL PLUGINS -->
   <!-- BEGIN PAGE LEVEL PLUGINS -->
   <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/datatables/datatables.min.css"
      rel="stylesheet" type="text/css" />
   <link
      href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css"
      rel="stylesheet" type="text/css" />
   <!-- END PAGE LEVEL PLUGINS -->
   <!-- BEGIN PAGE LEVEL STYLES -->
   <link href="<?php echo get_assets_path(); ?>admin_theme/pages/css/profile.min.css" rel="stylesheet"
      type="text/css" />

   <link
      href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css"
      rel="stylesheet" type="text/css" />
   <link
      href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
      rel="stylesheet" type="text/css" />
   <link
      href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"
      rel="stylesheet" type="text/css" />
   <link
      href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"
      rel="stylesheet" type="text/css" />
   <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/clockface/css/clockface.css" rel="stylesheet"
      type="text/css" />
   <!-- END PAGE LEVEL STYLES -->

   <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"
      rel="stylesheet" type="text/css">

   <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-select/css/bootstrap-select.css"
      rel="stylesheet" type="text/css">
   <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-multi-select/css/multi-select.css"
      rel="stylesheet" type="text/css">
   <!-- BEGIN THEME LAYOUT STYLES -->
   <link href="<?php echo get_assets_path(); ?>admin_theme/layouts/layout4/css/layout.min.css" rel="stylesheet"
      type="text/css" />
   <link href="<?php echo get_assets_path(); ?>admin_theme/layouts/layout4/css/themes/default.min.css" rel="stylesheet"
      type="text/css" id="style_color" />
   <link href="<?php echo get_assets_path(); ?>admin_theme/layouts/layout4/css/custom.min.css" rel="stylesheet"
      type="text/css" />
   <link href="<?php echo get_assets_path(); ?>admin_theme/file_upload_jscss/css/bootstrap_file_field.css"
      rel="stylesheet" type="text/css" />
   <link href="<?php echo get_assets_path(); ?>css/custom.css" rel="stylesheet" type="text/css" />

   <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" />
   <link href="<?php echo get_assets_path(); ?>admin_theme/global/css/style.css" rel="stylesheet" id="style_components"
      type="text/css" />

   <?php // Added by Anjali 14/07/26: Loads optional page-specific styles after the shared theme styles. ?>
   <?php if (!empty($page_styles) && is_array($page_styles)): ?>
      <?php foreach ($page_styles as $page_style): ?>
         <link href="<?php echo html_escape(get_assets_path() . ltrim($page_style, '/')); ?>" rel="stylesheet" type="text/css" />
      <?php endforeach; ?>
   <?php endif; ?>

   <!-- Several vendor views contain inline jQuery during page rendering. Load
        the shared dependency before those views execute. -->
   <script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>

</head>



<!-- END HEAD -->


<!-- Added by ANkit on 05/02/2026  -->

<style>
/* =========================================================
   MODERN WHITE SIDEBAR (TODAY-GEN STYLE)
   ========================================================= */

/* ===== SIDEBAR BASE ===== */
.page-sidebar,
.page-sidebar-wrapper,
.page-sidebar-menu {
    background: #ffffff !important;
    border-radius: 18px;   /* 🔥 all sides */
    box-shadow: 2px 0 12px rgba(0,0,0,0.04);
}

/* ===== FIX ARROW ALIGNMENT ===== */
.page-sidebar-menu > li > a {
    position: relative;
}

.page-sidebar-menu > li > a > .arrow {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-40%);
    margin: 0;
}

/* ===== MAIN MENU ITEM ===== */
.page-sidebar-menu > li > a {
    margin: 6px 12px;
    padding: 12px 16px;
    border-radius: 14px;
    background: transparent;
    color: #1f2937 !important; /* near-black */
    font-weight: 500;
    display: flex;
    align-items: center;
    transition: 
        transform 0.18s ease,
        box-shadow 0.18s ease,
        background 0.18s ease,
        color 0.18s ease;
}

/* ===== ICON STYLE (SOFT CIRCLE) ===== */
.page-sidebar-menu > li > a > i {
    width: 34px;
    height: 34px;
    line-height: 34px;
    border-radius: 50%;
    text-align: center;
    margin-right: 12px;
    font-size: 15px;

    
    background: linear-gradient(145deg, #f8fafc, #e5e7eb);

    
    box-shadow:
        2px 2px 6px rgba(0,0,0,0.10),
        -2px -2px 6px rgba(255,255,255,0.9);

   
    color: #64748b;

    transition: all 0.2s ease;
}

/* ===== HOVER – LIFT UP EFFECT ===== */
.page-sidebar-menu > li > a:hover {
    background: #f8fafc;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    color: #2563eb !important;
}

.page-sidebar-menu > li > a:hover i {
    background: #2563eb;
    color: #ffffff;
}

/* ===== ACTIVE MENU ===== */
.page-sidebar-menu > li.active > a,
.page-sidebar-menu > li.start.active > a {
    background: #eef2ff;
    color: #2563eb !important;
    box-shadow: 0 6px 18px rgba(37,99,235,0.25);
}

.page-sidebar-menu > li.active > a i {
    background: #2563eb;
    color: #ffffff;
}


.page-sidebar-menu .sub-menu {
    background: transparent;
    margin: 4px 18px 8px;
    padding-left: 6px;
}


.page-sidebar-menu .sub-menu li a {
    padding: 8px 14px;
    margin: 4px 0;
    border-radius: 10px;
    color: #4b5563 !important;
    font-size: 13px;
    transition: all 0.18s ease;
}


.page-sidebar-menu .sub-menu li a:hover {
    background: #f1f5f9;
    color: #2563eb !important;
    transform: translateX(4px);
}


.page-sidebar-menu .sub-menu li.active a {
    background: #eef2ff;
    color: #2563eb !important;
    font-weight: 600;
}


.page-sidebar-menu .arrow {
    color: #9ca3af;
}


.page-sidebar-menu-closed .title {
    display: none;
}


.page-sidebar ::-webkit-scrollbar {
    width: 5px;
}

.page-sidebar ::-webkit-scrollbar-thumb {
    background: #e5e7eb;
    border-radius: 10px;
}





</style>



<!-- Added by ANkit on 05/02/2026  -->


<?php $count = $this->uri->total_segments();
$page = $this->uri->segment($count - 1) . "/" . $this->uri->segment($count);
if (is_numeric($this->uri->segment($count))) {
   $page = $this->uri->segment($count - 2) . "/" . $this->uri->segment($count - 1);
}

//echo "<pre/>"; print_r($header_menu_list[0]['menuList']);
?>


<?php if ($page == "inventory/counter_billing") { ?>

   <body
      class="page-container-bg-solid page-header-fixed page-footer-fixed page-sidebar-closed-hide-logo page-md page-sidebar-closed">
   <?php } else { ?>

      <body class="page-container-bg-solid page-header-fixed page-footer-fixed page-sidebar-closed-hide-logo page-md">
      <?php } ?>

      <div class="loader"></div>
      <!-- BEGIN HEADER -->
      <div class="page-header navbar navbar-fixed-top">
         <!-- BEGIN HEADER INNER -->
         <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo" style="display:flex; justify-content:center; align-items:center">
               <a href="<?php echo get_module_path(); ?>dashboard">
                  <!--img src="<?php echo base_url('assets/site_theme/images/logo_light.png'); ?>" alt="logo" class="logo-default" style="margin: 0px 10px 0;"  /-->

                  <span class="logo-default font-blue bold uppercase ">MI-Btrack
                     <!-- <br/>&nbsp;&nbsp; Admin -->


                  </span>
               </a>
               <div class="menu-toggler sidebar-toggler" style="margin: 0;">
                  <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
               </div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
               data-target=".navbar-collapse"> </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN PAGE TOP -->
            <div class="page-top">
               <div class="top-menu">
                  <ul class="nav navbar-nav pull-right">
                     <li class="separator hide"> </li>

                     <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                     <!--li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                                    <i class="icon-bell"></i>
                                    <span class="badge badge-danger" id="notification_count"> 0 </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3>
                                            <span class="bold" id="notification_pending"></span> Notifications</h3>
                                       
                        
                              
                                    </li>
                                    <li>
                                      <div id="slimScrollDiv2"><ul class="dropdown-menu-list scroller" data-handle-color="#637283" data-initialized="1" id="notification_list">
                                          
                                          </ul></div>
                                    </li>
                                </ul>
                            </li-->


                     <li class="dropdown dropdown-user dropdown-dark">
                        <?php
                        $user_branch_name = isset($vendor['user_branch_name']) ? $vendor['user_branch_name'] : "";
                        $branch_name = $vendor['branch_name'];
                        $user_branch_name = !empty($user_branch_name) ? $user_branch_name : $branch_name;
                        ?>
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                           <span class="username">Hi, <?php echo $vendor['user_person_name']; ?> </span>
                           <span class="username" id="branch_name"> (<?php echo $user_branch_name; ?>)</span>
                           <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->

                           <?php $image3 = $vendor['user_image'];
                           $image3 = str_replace("getAuthApiKey", APIKEY, $image3); ?>

                           <img class="img-rounded" src="<?php echo $image3; ?>"
                              alt="<?php echo isset($details['emp_name']) ? $details['emp_name'] : $vendor['user_person_name']; ?>">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">

                           <!--li>
                              <a href="<?php echo get_module_path(); ?>dashboard/change_password">
                              <i class="icon-key"></i> Change Password </a>
                           </li-->
                           <li>
                              <a href="<?php echo get_module_path(); ?>admin/my_account">
                                 <i class="icon-user"></i> My Account </a>
                           </li>
                           <?php if(
    in_array($role_id, explode(",", CHANGE_BRANCH_ACCESS))
    && !empty($quick_br_list)
    && count($quick_br_list) > 1
){ ?>
<li class="branch-menu">

    <a href="javascript:void(0);" id="changeBranchBtn">
        <i class="icon-shuffle"></i>
        Change Branch
        <span style="float:right;">
            <i class="fa fa-angle-right"></i>
        </span>
    </a>

    <ul class="branch-submenu">
        <?php foreach($quick_br_list as $br){ ?>
        <li>
            <a href="<?php echo base_url(get_module().'/admin/set_branch_dashboard/?p_branch='.base64_encode($br['branch_id'])); ?>">
                <?php echo $br['branch_name']; ?>
            </a>
        </li>
        <?php } ?>
    </ul>

</li>
<?php } ?>
                           <li>
                              <a href="<?php echo get_module_path(); ?>dashboard/logout">
                                 <i class="icon-logout"></i> Log Out </a>
                           </li>

                        </ul>
                     </li>
                     <!-- END USER LOGIN DROPDOWN -->
                  </ul>
                 <style>
/* Parent Bootstrap Dropdown */
.dropdown-menu.dropdown-menu-default{
    overflow: visible !important;
}

/* Branch Menu */
.branch-menu{
    position: relative;
}

/* Change Branch Parent Hover */
.branch-menu > a:hover,
.branch-menu > a:focus,
.branch-menu:hover > a{
    background: #4c526e !important;
    color: #fff !important;
}

/* Submenu */
.branch-submenu{
    display: none;
    position: absolute;
    top: 0;
    right: 100%;
    min-width: 260px;
    background: #5f6583;
    border-radius: 4px;
    box-shadow: 0 3px 12px rgba(0,0,0,.25);
    z-index: 999999999 !important;
    padding: 0;
    margin: 0;
    list-style: none;
    overflow: visible !important;
}

/* Show submenu */
.branch-submenu.show{
    display: block !important;
}

.branch-menu:hover > .branch-submenu{
    display: block;
}

/* List Items */
.branch-submenu li{
    display: block;
    width: 100%;
    margin: 0;
    padding: 0;
}

/* Links */
.branch-submenu li a{
    display: block;
    padding: 10px 15px;
    color: #fff !important;
    text-decoration: none;
    border-bottom: 1px solid rgba(255,255,255,.08);
    white-space: nowrap;
    transition: all 0.2s ease;
}

.branch-submenu li:last-child a{
    border-bottom: none;
}

/* Branch Hover Effect */
.branch-submenu li a:hover{
    background: #8ee1e9 !important;
    color: #fff !important;
    padding-left: 22px;
}
</style>


   <!-- Changes by Shawn Arakal - 10-08-2026 16:00:45 IST: replaced jQuery block with vanilla JS to fix "$ is not defined" -->
   <script>
   (function () {
      var changeBranchBtn = document.getElementById('changeBranchBtn');
      var branchSubmenus  = document.querySelectorAll('.branch-submenu');

      if (changeBranchBtn) {
         changeBranchBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            for (var i = 0; i < branchSubmenus.length; i++) {
               branchSubmenus[i].classList.toggle('show');
            }
         });
      }

      for (var i = 0; i < branchSubmenus.length; i++) {
         branchSubmenus[i].addEventListener('click', function (e) {
            e.stopPropagation();
         });
      }

      document.addEventListener('click', function () {
         for (var i = 0; i < branchSubmenus.length; i++) {
            branchSubmenus[i].classList.remove('show');
         }
      });
   })();
   </script>
               </div>
               <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END PAGE TOP -->
         </div>
         <!-- END HEADER INNER -->
      </div>
      <!-- END HEADER -->
      <!-- BEGIN HEADER & CONTENT DIVIDER -->
      <div class="clearfix"> </div>
      <!-- END HEADER & CONTENT DIVIDER -->
      <!-- BEGIN HEADER & CONTENT DIVIDER -->
      <div class="clearfix"> </div>
      <!-- END HEADER & CONTENT DIVIDER -->
      <!-- BEGIN CONTAINER -->
      <div class="page-container">
         <!-- BEGIN SIDEBAR -->
         <div class="page-sidebar-wrapper">
            <!-- BEGIN SIDEBAR -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <div class="page-sidebar navbar-collapse collapse">
               <?php if ($page == "inventory/counter_billing") { ?>
                  <ul class="page-sidebar-menu page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true"
                     data-slide-speed="200">
                  <?php } else { ?>
                     <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true"
                        data-slide-speed="200">
                     <?php } ?>

                     <li class="nav-item  <?php echo $page == "/dashboard" ? 'active' : ''; ?>">
                        <a href="<?php echo get_module_path(); ?>dashboard" class="nav-link ">
                           <i class="icon-home"></i>
                           <span class="title">Dashboard</span>
                        </a>
                     </li>

                     <?php
                     if (!empty($header_menu_list[0]['menuList'])) {
                        $menu_list = $header_menu_list[0]['menuList'];
                        foreach ($menu_list as $menu) {
                           $menu_name = $menu['menu_name'];
                           $menu_no = $menu['menu_no'];
                           $submenuList = $menu['submenuList'];
                           $menustatus = $menu['menu_status'];

                           // Changes by Shawn Arakal - 10-08-2026 16:00:45 IST: dedupe submenuList by sub_menu_no so each submenu renders once in the sidebar
                           if (!empty($submenuList)) {
                              $submenuSeen = array();
                              $submenuDeduped = array();
                              foreach ($submenuList as $submenu) {
                                 $submenuKey = isset($submenu['sub_menu_no']) ? $submenu['sub_menu_no'] : "";
                                 if (!isset($submenuSeen[$submenuKey])) {
                                    $submenuSeen[$submenuKey] = true;
                                    $submenuDeduped[] = $submenu;
                                 }
                              }
                              $submenuList = $submenuDeduped;
                           }

                           if ($menustatus != "A") {
                              continue;
                           }
                           $sub_menu = "";
                           $menu_icon = "icon-list";
                           if ($menu_name == "Admin") {
                              $menu_icon = "icon-user";
                           }
                           if ($menu_name == "Customers") {
                              $menu_icon = "icon-user-following";
                           }
                           if ($menu_name == "Reports") {
                              $menu_icon = "icon-graph";
                           }
                           if ($menu_name == "Leads") {
                              $menu_icon = "icon-call-in";
                           }
                           if ($menu_name == "Quotation") {
                              $menu_icon = "icon-calculator";
                           }
                           if ($menu_name == "COMPLAINT") {
                              $menu_icon = "icon-notebook";
                           }
                           if ($menu_name == "Monthly Analysis Report") {
                              $menu_icon = "icon-calculator";
                           }
                           if ($menu_name == "Daily Analysis Report") {
                              $menu_icon = "icon-clock";
                           }
                           if ($menu_name == "FAQ") {
                              $menu_icon = "icon-question";
                           }
                           if ($menu_name == "TICKETS") {
                              $menu_icon = "icon-tag";
                           }
                           if ($menu_name == "SEND SMS / Email") {
                              $menu_icon = "icon-speech";
                           }
                           if ($menu_name == "Notification") {
                              $menu_icon = "icon-bell";
                           }
                           if ($menu_name == "Teams") {
                              $menu_icon = "icon-users";
                           }
                           if ($menu_name == "Inventory") {
                              $menu_icon = "icon-layers";
                           }



                           ?>

                           <?php if (!empty($submenuList)) { ?>
                              <?php foreach ($submenuList as $submenu) {
                                 $sub_menu_filename = $submenu['sub_menu_filename'];
                                 if ($page == $sub_menu_filename) {
                                    $sub_menu = "start active open";
                                 }
                              } ?>
                              <li class="nav-item <?php echo $sub_menu; ?>">
                                 <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="<?php echo $menu_icon; ?>"></i>
                                    <span class="title"><?php echo $menu_name; ?></span>
                                    <span class="selected"></span>
                                    <span class="arrow"></span>
                                 </a>
                                 <ul class="sub-menu <?php echo $sub_menu; ?>">

                                    <?php foreach ($submenuList as $submenu) {
                                       $sub_menu_menuno = isset($submenu['sub_menu_menuno']) ? $submenu['sub_menu_menuno'] : "";
                                       $sub_menu_name = isset($submenu['sub_menu_name']) ? $submenu['sub_menu_name'] : "";
                                       $sub_menu_no = isset($submenu['sub_menu_no']) ? $submenu['sub_menu_no'] : "";
                                       $sub_menu_filename = isset($submenu['sub_menu_filename']) ? $submenu['sub_menu_filename'] : "";
                                       $sub_menu_icon = isset($submenu['sub_menu_icon']) ? $submenu['sub_menu_icon'] : "";
                                       $sub_menu_active = "";
                                       if ($page == $sub_menu_filename) {
                                          $sub_menu_active = "active";
                                       }
                                       ?>


                                       <li class="nav-item <?php echo $sub_menu_active; ?>">
                                          <a href="<?php echo get_module_path() . $sub_menu_filename; ?>" class="nav-link ">
                                             <i class="<?php echo $sub_menu_icon; ?>"></i>
                                             <span class="title"><?php echo $sub_menu_name; ?></span>
                                          </a>
                                       </li>


                                    <?php }
                           } else { ?>

                                    <li class="nav-item  <?php echo $page == $sub_menu_filename ? 'active' : ''; ?>">
                                       <a href="<?php echo get_module_path() . $sub_menu_filename; ?>" class="nav-link ">
                                          <i class="icon-home"></i>
                                          <span class="title"><?php echo $menu_name; ?></span>
                                       </a>
                                    </li>
                                 <?php } ?>
                              </ul>
                           </li>
                        <?php }
                     } ?>



                  </ul>
                  <!-- END SIDEBAR MENU -->
            </div>
            <!-- END SIDEBAR -->

         </div>
         <!-- END SIDEBAR -->
         <!-- BEGIN CONTENT -->
         <script>
            (function () {
               const sidebar = document.querySelector('.page-sidebar');

               if (!sidebar) return;

               const allLinks = sidebar.querySelectorAll('a.nav-link');
               let locked = false;

               allLinks.forEach(link => {
                  link.addEventListener('click', function (e) {
                     if (locked) {
                        // Block any navigation attempt during lock
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                     }

                     const href = link.getAttribute('href');

                     if (!href || href === 'javascript:;' || href === '#') {
                        // Allow menu toggles (not actual page navigation)
                        return;
                     }

                     // Lock all link clicks for 3 seconds
                     e.preventDefault(); // block navigation temporarily
                     locked = true;

                     // Optional: show loading cursor
                     document.body.style.cursor = 'wait';

                     // Allow navigation after 50 ms
                     setTimeout(() => {
                        document.body.style.cursor = 'default';
                        window.location.href = href;
                     }, 50);
                  });
               });
            })();
         </script>


         <script>
            var base_url = '<?php echo get_module_path() ?>';	
         </script>
         <style>
            @media (min-width: 992px) {
               .page-content-wrapper .page-content {
                  padding: 3px 0 0 20px;
               }
            }

            @media (max-width: 768px) {
               #branch_name {

                  display: none;

               }
            }
         </style>
