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
	
	<?php if(!empty($branch_list)){  $count = count($branch_list); } else { $count = 0 ;} ?>
   <div class="row">
      <div class="col-md-12">
         <div class="portlet light bordered">
		    <a  class="btn btn-success btn-sm pull-right" href="<?php echo base_url();?>admin/add_branch" title="Add"><i class="fa fa-plus"></i> Add New </a> 
             
			 <span class="caption-subject font-blue-madison bold "><?php echo $page_title; ?></span>
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
				  <form action="<?php echo base_url().'admin/branch_report'; ?>"  method="get" autocomplete="off">
				      						
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
						
                          <button class="btn green btn-outline " type="submit" ><i class="fa fa-search"></i>Search</button>
						 
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
                  <th>Branch Name </th>               
                  <th>Contact</th>               
                  <th>Contact Person</th>               
                  <th style="text-align:center">Status</th>
                  <th style="text-align:center">Action</th>				  
                </tr>
                </thead>
                <tbody>
                <?php 
				if(!empty($branch_list)){
					$branch_list = html_escape($branch_list); 
				foreach ($branch_list as $key=>$branch) {
						$name   = $branch['branch_name'];
						$status = $branch['branch_status'];
						$branch_contact = $branch['branch_contact'];
						$branch_contact_person = $branch['branch_contact_person'];
						$id     = base64_encode($branch['branch_id']);
				//echo "<pre/>"; print_r($branch);	
                ?>  
                <tr>
				  <td><?php echo $key + 1; ?></td>		  
					                                   				  
                  <td style="word-break:break-all;"><a  href="<?php echo base_url();?>admin/view_branch/?branch_id=<?php echo $id; ?>" title="View Details" > <?php echo $name; ?></a></td>
                
				  
				  <td><?php echo $branch_contact; ?></td>			  
				  <td><?php echo $branch_contact_person; ?></td>
				    <td style="text-align:center"><?php  if($status =="Active") { echo "<span class='label label-success'>Active</span>"; } else if($status =="Deactivated") { echo "<span class='label label-danger'>Deactivated</span>"; }  ?></td>
                  <td style="text-align:center">
				  &nbsp;  
				  <?php  if($status=="Active") { ?>
				  
					<a  class="btn btn-primary btn-xs"  href="<?php echo base_url();?>admin/edit_branch/?branch_id=<?php echo $id; ?>" title="Edit"><i class="fa fa-edit"></i>Edit</a>
					&nbsp;  
										
					 
						<a  class="btn btn-danger btn-xs"  data-href="<?php echo base_url();?>admin/deactivate_branch/?branch_id=<?php echo $id; ?>" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i> Deactivate</a>
						
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
		
<!--END START MODAL -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#confirm-deactivate').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });	

});
</script>

