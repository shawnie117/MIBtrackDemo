<link href="<?php echo get_assets_path(); ?>admin_theme/pages/css/faq.min.css" rel="stylesheet" type="text/css">

<?php $role_id = $this->session->userdata('user_role_id');?>
<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
   <!-- BEGIN PAGE BASE CONTENT -->
   
   <!--div class="page-head">
		<div class="page-title">
			<h1><?php echo $page_title; ?></h1>
		</div>	
	</div-->
	
	
   <div class="row">
      <div class="col-md-12">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
			<li>
			<a href="<?php echo get_module_path()."dashboard"?>">Home</a>
			<i class="fa fa-circle"></i>
			</li>
			<li>
			<span class="active"><i class="icon-question font-green-sharp"></i>
                  <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span></span>
			</li>
			</ul>
			
                       <?php// print_r($faq_module_list); ?>
                       <?php //print_r($faq_list); ?>
            		<div class="faq-page faq-content-1">

            		<div class="faq-content-container">
            		<div class="row">
            		
				<?php if(!empty($faq_module_list)){
				     foreach ($faq_module_list as $key=>$module) { //echo "<pre/>"; print_r($faq_module_list);
						 $md = "accordion".($key+1) ;
						 $module_id = $module['faq_m_id'];
						 ?>
				   <div class="col-md-6">
				   <div class="faq-section bordered">
					<h2 class="faq-title uppercase font-blue"><?php echo $module['faq_module']; ?></h2>
					<div class="panel-group accordion faq-content" id="<?php echo $md; ?>">
					<?php if(!empty($module['faqList'])){  
				     foreach ($module['faqList'] as $key2=>$faq) {  //print_r($faq);
					 $coll = "collapse_".($key+1)."_".($key2+1); 
					 
					  
					 ?>
						<div class="panel panel-default" style="box-shadow: none;">
							<div class="panel-heading">
								<h4 class="panel-title">
									<i class="fa fa-circle"></i>
									<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="<?php echo "#".$md; ?>" href="<?php echo "#".$coll; ?>" aria-expanded="false"> <?php echo $faq['faq_det_questn']; ?></a>
								</h4>
							</div>
							<div id="<?php echo $coll; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
								<div class="panel-body">
									<p> <?php echo $faq['faq_det_answers']; ?></p>
									
									
									
									
								</div>
							</div>
						</div>
					  <?php } }  ?>
					</div>
					</div>          
				</div>  
				<?php } }  else { ?>
				<div class="col-md-6">
				   <div class="faq-section bordered">
				No FAQ Found !!!
					</div>          
				</div>  
				<?php }  ?>
				        
				</div>          
				</div>          
				</div>          
        
</div>
			</div>
			</div>
   </div>
   <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

 


