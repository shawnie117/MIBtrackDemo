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
	
	<?php if(!empty($faq_list)){  $count = count($faq_list); } else { $count = 0 ;} ?>
   <div class="row">
      <div class="col-md-12">
         <div class="portlet light bordered">
		    <a  class="btn btn-success btn-sm pull-right" href="<?php echo base_url();?>masters/add_faq" title="Add"><i class="fa fa-plus"></i> Add New </a> 
			
			<span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
		    <span class="caption-subject font-red-mint sbold float-right">( Total - <?php echo $count; ?> )</span>	
                   
			  <div class="row">
                 
				
		 <div class="col-md-12">
			<div class="portlet-body"> 
               <div class="col-md-6">                                                   
      <?php
                     $this->load->helper('form');
                     $error = $this->session->flashdata('error');
                     if($error)
                     {
                     ?>
                  <div class="alert alert-danger alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     <?php echo $this->session->flashdata('error'); ?>
                  </div>
                  <?php } ?>
                  <?php  
                     $success = $this->session->flashdata('success');
                     if($success)
                     {
                     ?>
                  <div class="alert alert-success alert-dismissable">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     <?php echo $this->session->flashdata('success'); ?>
                  </div>
                  <?php } ?>
                 
                  </div>
				        
             <div class="col-md-12"> 
				  <form action="<?php echo base_url().'masters/faq_report'; ?>"  method="get" autocomplete="off">
				       <div class="form-group col-md-3">                           
                            <select class="form-control" id="faq_m_id" name="faq_m_id" onchange="this.form.submit();">
							<option value=""> Select FAQ Module</option>
							 <?php  if(!empty($faq_module_list)){ 	
								foreach($faq_module_list as $faq_module){ 
								  $selected = $faq_m_id==$faq_module['faq_m_id']?"selected":"";
								
								?>
									<option value="<?php echo $faq_module['faq_m_id'];?>" <?php echo $selected;?> ><?php echo $faq_module['faq_module']; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 
						
						<div class="form-group col-md-3">                           
                            <select class="form-control" id="status" name="status" onchange="this.form.submit();">
							<option value=""> Select Status</option>
							 <?php  if(!empty($status_list)){ 
								foreach($status_list as $stat){ 
								  $selected = $stat==$status?"selected":"";
								
								?>
									<option value="<?php echo $stat?>" <?php echo $selected;?> ><?php echo $stat; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
						
						
						<div class="form-group col-md-3 hidden"> 
						
                          <button class="btn green btn-outline" type="submit" ><i class="fa fa-search"></i>Search</button>
						 
                        </div>
                        </form>
						
						<div class="form-group col-md-3"> 
                           
                           <input class="form-control" id="searchStr" name="searchStr" type="text" placeholder="Search..." maxlength="100" value="<?php echo isset($searchStr)?$searchStr:""; ?>">
						 
                        </div>		
				    </div>
						
			<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed tbl_data_table1"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th>Sr. No.</th>	
                  <th style="width:10%;">Module Name</th>               
                  <th style="width:20%;">FAQ</th>               
                  <th style="width:30%;">Answer</th>               
  
                  <th style="text-align:center">Status</th>
                  <th style="text-align:center">Action</th>				  
                </tr>
                </thead>
                <tbody>
                <?php 
				if(!empty($faq_list)){
					$faq_list = html_escape($faq_list);  
				foreach ($faq_list as $key=>$faq) {
						$faq_det_mstr_name   = $faq['faq_det_mstr_name'];
						$name   = $faq['faq_det_mstr_name'];
						$faq_det_questn   = $faq['faq_det_questn'];
						$faq_det_answers   = $faq['faq_det_answers'];
						$status = $faq['faq_det_status'];
						$id     = base64_encode($faq['faq_det_id']);
				//echo "<pre/>"; print_r($faq);die;	
                ?>  
                <tr>
				  <td><?php echo $key + 1; ?></td>	                                   				  
				  	                                   				  
                  <td style="word-break:break-all;"><a  href="<?php echo base_url();?>masters/view_faq/?faq_det_id=<?php echo $id; ?>" title="View Details" > <?php echo $faq_det_mstr_name; ?></a></td>
				  <td style="word-break:break-all;"><?php echo $faq_det_questn; ?></td>
				  <td style="word-break:break-all;"><?php echo $faq_det_answers; ?></td>
                  <td style="text-align:center"><?php  if($status =="Active") { echo "<span class='label label-success'>Active</span>"; } else if($status =="Deactivated") { echo "<span class='label label-danger'>Deactivated</span>"; }  ?></td>
                  <td style="text-align:center">
				  &nbsp;  
				  <?php  if($status=="Active") { ?>
				  
					<a  class="btn btn-primary btn-xs"  href="<?php echo base_url();?>masters/edit_faq/?faq_det_id=<?php echo $id; ?>" title="Edit"><i class="fa fa-edit"></i></a>
					&nbsp;  
										
					 
						<a  data-toggle="modal" data-target="#form_modal" class="btn btn-danger btn-xs" href="<?php echo base_url();?>masters/deactivate_faq/?ref_id=<?php echo $id; ?>" title="Deactivate" ><i class="fa fa-ban"></i></a>
						
					 <?php } ?>
					 
					</td>
                </tr>
                <?php } } ?>
				 </tbody>
						</table> 
						   					
					
						  </div>
                       
            		
			   
               </div>
            </div>
            <!-- END Portlet PORTLET-->
         </div>
         </div>
         <!-- END PAGE BASE CONTENT -->
      </div>
      <!-- END CONTENT BODY -->
   </div>
   <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

<!-- START MODAL -->
		<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog modal-md">
			<div class="modal-content">			
			</div>
			</div>
		</div>	
<!--END START MODAL -->

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
$("#form_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    }); 


  $('#confirm-deactivate').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });	

});
</script>

