<?php $this->session->set_userdata('starttime',microtime(true)); ?>
<?php $role_id = $this->session->userdata('user_role_id');?>
<!DOCTYPE html>
<html lang="en">
   <!--<![endif]-->
   <!-- BEGIN HEAD -->
   <head>
      <meta charset="utf-8" />
      <title>  <?php echo SITE_NAME." | "; echo isset($page_title)?$page_title:"";?></title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta content="width=device-width, initial-scale=1" name="viewport" />
      <meta content="Preview page of Metronic Admin Theme #4 for " name="description" />
      <meta content="" name="author" />
      <!-- BEGIN GLOBAL MANDATORY STYLES -->
      <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
      <!-- END GLOBAL MANDATORY STYLES -->
      <!-- BEGIN PAGE LEVEL PLUGINS -->
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
	  <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css">
      <!-- END PAGE LEVEL PLUGINS -->
      <!-- BEGIN THEME GLOBAL STYLES -->
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
      <!-- END THEME GLOBAL STYLES -->   
      <!-- BEGIN PAGE LEVEL PLUGINS -->
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
      <!-- END PAGE LEVEL PLUGINS -->
      <!-- BEGIN PAGE LEVEL PLUGINS -->
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
      <!-- END PAGE LEVEL PLUGINS -->
      <!-- BEGIN PAGE LEVEL STYLES -->
      <link href="<?php echo get_assets_path(); ?>admin_theme/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
      
	  <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />	  
      <!-- END PAGE LEVEL STYLES -->
	  
		<link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css">
		
		<link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" type="text/css">
		<link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-multi-select/css/multi-select.css" rel="stylesheet" type="text/css">
      <!-- BEGIN THEME LAYOUT STYLES -->
      <link href="<?php echo get_assets_path(); ?>admin_theme/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/layouts/layout4/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/file_upload_jscss/css/bootstrap_file_field.css" rel="stylesheet" type="text/css" />	
      <link href="<?php echo get_assets_path(); ?>css/custom.css" rel="stylesheet" type="text/css" />	
	  
      <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png');?>" /> 
   </head>
   <!-- END HEAD -->
   <body class="page-container-bg-solid page-header-fixed page-footer-fixed page-sidebar-closed-hide-logo page-md">
   <div class="loader"></div>
      <!-- BEGIN HEADER -->
      <div class="page-header navbar navbar-fixed-top">
         <!-- BEGIN HEADER INNER -->
         <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
               <a href="<?php echo base_url();?>dashboard" style="text-decoration:none;cursor:hand;">
                  <!--img src="<?php echo base_url('assets/site_theme/images/logo_light.png'); ?>" alt="logo" class="logo-default" style="margin: 0px 10px 0;"  /-->  
                
				  <span class="logo-default font-blue bold uppercase " style="font-size:25px;">MIBtrack
				  <br/>&nbsp;&nbsp; Admin</span>
               </a>
               <div class="menu-toggler sidebar-toggler">
                  <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
               </div>
            </div>
            <!-- END LOGO -->             
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
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
                                            <span class="bold" id="notification_pending"></span> notifications</h3>
                                       
								
										
                                    </li>
                                    <li>
                                      <div id="slimScrollDiv2"><ul class="dropdown-menu-list scroller" data-handle-color="#637283" data-initialized="1" id="notification_list">
                                          
                                          </ul></div>
                                    </li>
                                </ul>
                            </li-->
					 
					 
                     <li class="dropdown dropdown-user dropdown-dark">
					 <?php 
						$user_branch_name = $this->session->userdata('user_branch_name');
						$branch_name      = $this->session->userdata('branch_name');
					    $user_branch_name = !empty($user_branch_name)?$user_branch_name:$branch_name;
					 ?>
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                           <span class="username">Hi, <?php echo $this->session->userdata('user_person_name'); ?>  </span>
                          <span class="username"> (<?php echo $user_branch_name; ?>)</span>
                           <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                           <img alt="" class="img-circle" src="<?php echo get_assets_path(); ?>images/default_user.png" /> 
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
					
						   <!--li>
                              <a href="<?php echo base_url(); ?>dashboard/change_password">
                              <i class="icon-key"></i> Change Password </a>
                           </li>
                           <li>
                              <a href="<?php echo base_url(); ?>dashboard/my_profile">
                              <i class="icon-lock"></i> My Profile </a>
                           </li-->
                           <li>
                              <a href="<?php echo base_url(); ?>dashboard/logout">
                              <i class="icon-logout"></i> Log Out </a>
                           </li>
						 
                        </ul>
                     </li>
                     <!-- END USER LOGIN DROPDOWN -->
                  </ul>
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
            <?php  $count = $this->uri->total_segments();
               $page = $this->uri->segment($count-1)."/".$this->uri->segment($count); 
               if(is_numeric($this->uri->segment($count)))
               {
                $page = $this->uri->segment($count-2)."/".$this->uri->segment($count-1); 
               }
			   
			   //echo "<pre/>"; print_r($header_menu_list[0]['menuList']);
               ?> 
            <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
               <li class="nav-item  <?php echo $page=="/dashboard"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>dashboard" class="nav-link ">
                  <i class="icon-home"></i>
                  <span class="title">Dashboard</span>
                  </a>
               </li>
			  
			   <?php 
			    if(!empty($header_menu_list[0]['menuList'])){
			    $menu_list = $header_menu_list[0]['menuList'];
			    foreach($menu_list as $menu){ 
			       $menu_name 			= $menu['menu_name'];
			       $menu_no   			= $menu['menu_no'];
			       $submenuList   	 	= $menu['submenuList'];
				   $sub_menu 			= "";
				   $menu_icon   = "icon-list";
		            if($menu_name=="Admin"){
						$menu_icon ="icon-user";
					} 
					if($menu_name=="Customers"){
						$menu_icon ="icon-user-following";
					} 
					if($menu_name=="Reports"){
						$menu_icon ="icon-graph";
					} 
					if($menu_name=="Leads"){
						$menu_icon ="icon-call-in";
					}
					if($menu_name=="Complaints"){
						$menu_icon ="icon-notebook";
					}
					if($menu_name=="Monthly Analysis Report"){
						$menu_icon ="icon-calendar";
					}
					if($menu_name=="Daily Analysis Report"){
						$menu_icon ="icon-clock";
					}
					if($menu_name=="FAQ"){
						$menu_icon ="icon-question";
					}
				   ?>
				   
				    <?php  if(!empty($submenuList ))  {  ?>
					      <?php foreach($submenuList  as $submenu){
								$sub_menu_filename  = $submenu['sub_menu_filename'];
								if($page == $sub_menu_filename){ $sub_menu = "start active open";}
					       } ?>
			      <li class="nav-item <?php echo $sub_menu;?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="<?php echo $menu_icon;?>"></i>
						<span class="title"><?php echo $menu_name;?></span>
						<span class="selected"></span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu <?php echo $sub_menu;?>">
			            
					<?php foreach($submenuList  as $submenu){ 						
						$sub_menu_menuno    = $submenu['sub_menu_menuno'];
						$sub_menu_name      = $submenu['sub_menu_name'];
						$sub_menu_no 		= $submenu['sub_menu_no'];
						$sub_menu_filename  = $submenu['sub_menu_filename'];
						$sub_menu_icon      = $submenu['sub_menu_icon'];
						$sub_menu_active = "";
						if($page == $sub_menu_filename){ $sub_menu_active = "active";}
						?>
				
             
				  <li class="nav-item <?php echo $sub_menu_active;?>">
                  <a href="<?php echo base_url().$sub_menu_filename; ?>" class="nav-link ">
                  <i class="<?php echo $sub_menu_icon;?>"></i>
                  <span class="title"><?php echo $sub_menu_name;?></span>
                  </a>
                 </li>
			  
									
				 <?php }  } else {  ?>
				 
				  <li class="nav-item  <?php echo $page==$sub_menu_filename?'active':'';?>">
                  <a href="<?php echo base_url().$sub_menu_filename; ?>" class="nav-link ">
                  <i class="icon-home"></i>
                  <span class="title"><?php echo $menu_name;?></span>
                  </a>
               </li>
				 <?php }   ?>
			    </ul> </li>
			   <?php }  } ?>
			   
			 <!--li class="heading"><h3 class="uppercase">Masters</h3></li>			   
			   <li class="nav-item  <?php echo $page=="department_report"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>masters/department_report" class="nav-link ">
                  <i class="icon-tag"></i>
                  <span class="title">Department</span>
                  </a>
               </li> 
			   <li class="nav-item  <?php echo $page=="sub_department_report"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>masters/sub_department_report" class="nav-link ">
                  <i class="icon-vector"></i>
                  <span class="title">SubDepartment</span>
                  </a>
               </li>
			   <li class="nav-item  <?php echo $page=="permission_report"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>masters/permission_report" class="nav-link ">
                  <i class="icon-user-following"></i>
                  <span class="title">Permission</span>
                  </a>
               </li>
			    <li class="nav-item  <?php echo $page=="faq_module_report"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>masters/faq_module_report" class="nav-link ">
                  <i class="icon-info"></i>
                  <span class="title">FAQ Module</span>
                  </a>
               </li>
			    <li class="nav-item  <?php echo $page=="faq_report"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>masters/faq_report" class="nav-link ">
                  <i class="icon-question"></i>
                  <span class="title">FAQ</span>
                  </a>
               </li> 

			   <li class="nav-item  <?php echo $page=="education_report"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>masters/education_report" class="nav-link ">
                  <i class="icon-graduation"></i>
                  <span class="title">Education</span>
                  </a>
               </li>  
			   
			   <li class="nav-item  <?php echo $page=="city_report"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>masters/city_report" class="nav-link ">
                  <i class="icon-pointer"></i>
                  <span class="title">City</span>
                  </a>
               </li> 
			     <li class="nav-item  <?php echo $page=="area_report"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>masters/area_report" class="nav-link ">
                  <i class="icon-globe"></i>
                  <span class="title">Area</span>
                  </a>
               </li> 
			   
			   <li class="nav-item  <?php echo $page=="notification_report"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>masters/notification_report" class="nav-link ">
                  <i class="icon-bell"></i>
                  <span class="title">Notification</span>
                  </a>
               </li>  
				<li class="heading"><h3 class="uppercase">Admin</h3></li>
			   <li class="nav-item  <?php echo $page=="branch_report"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>admin/branch_report" class="nav-link ">
                  <i class="icon-share"></i>
                  <span class="title">Branch</span>
                  </a>
               </li> 
			   
			   <li class="nav-item  <?php echo $page=="assign_block"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>admin/assign_block" class="nav-link ">
                  <i class="icon-bulb"></i>
                  <span class="title">Assign Block</span>
                  </a>
               </li>
			   
			    <li class="nav-item  <?php echo $page=="assign_reminder"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>admin/assign_reminder" class="nav-link ">
                  <i class="icon-bell"></i>
                  <span class="title">Assign Reminder</span>
                  </a>
               </li>
			   
			    <li class="nav-item  <?php echo $page=="assign_menu"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>admin/assign_menu" class="nav-link ">
                  <i class="icon-layers"></i>
                  <span class="title">Assign Menu</span>
                  </a>
               </li>   
			   <li class="nav-item  <?php echo $page=="change_my_password"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>admin/change_my_password" class="nav-link ">
                  <i class="icon-key"></i>
                  <span class="title">Change My Password</span>
                  </a>
               </li>   
			   <li class="nav-item  <?php echo $page=="change_emp_password"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>admin/change_emp_password" class="nav-link ">
                  <i class="icon-key"></i>
                  <span class="title">Change Emp Password</span>
                  </a>
               </li>   
			   <li class="nav-item  <?php echo $page=="my_account"?'active':'';?>">
                  <a href="<?php echo base_url(); ?>admin/my_account" class="nav-link ">
                  <i class="icon-user"></i>
                  <span class="title">My Account</span>
                  </a>
               </li-->  
			   
            </ul>
            <!-- END SIDEBAR MENU -->
         </div>
         <!-- END SIDEBAR -->
		 
      </div>
      <!-- END SIDEBAR -->
      <!-- BEGIN CONTENT -->
      <script>
         var base_url = '<?php echo base_url()?>';	
      </script>
	    <style>
	  @media (min-width: 992px){
		.page-content-wrapper .page-content {
	 	padding: 3px 0 0 20px;
	  }}
	  </style>