<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title><?php echo SITE_NAME."| Page Not Found"; ?> </title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
      <!-- Google Font -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>admin_theme/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo get_assets_path(); ?>css/404_page.css" rel="stylesheet" type="text/css" />
      <link rel="shortcut icon" href="<?php echo get_assets_path()."site_theme/images/favicon.png"?>" />
   </head>
   <!-- Content Wrapper. Contains page content -->
   <div>
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
         <div class="error-page">
            <h2 class="headline text-red"> 404</h2>
            <div class="error-content">
               <h3><i class="fa fa-warning text-red"></i> Oops! Page not found.</h3>
               <p>
                  <?php //echo $message; ?>
                  We could not find the page you were looking for.
               </p>
               <!-- /.input-group -->
               </form -->
            </div>
            <!-- /.error-content -->
         </div>
         <!-- /.error-page -->
      </section>
      <!-- /.content -->
   </div>
   <!-- /.content-wrapper -->
   <script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
   <script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>