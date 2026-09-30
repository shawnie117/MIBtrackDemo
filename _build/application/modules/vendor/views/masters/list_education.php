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
	
	<?php if(!empty($education_list)){  $count = count($education_list); } else { $count = 0 ;} ?>
   <div class="row">
      <div class="col-md-12">
         <div class="portlet light bordered">
            <div class="col-sm-8 col-md-8  col-lg-10">
            <span class="caption-subject font-green-sharp "><?php echo $page_title; ?></span>

				   <span class="caption-subject font-red-mint  ">( Total - <?php echo $count; ?> )</span>	   
               </div>
               <center>
               <a  class="btn btn-success btn-sm" href="<?php echo get_module_path();?>masters/add_education" title="Add"><i class="fa fa-plus"></i> Add New </a> 
<center>
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
				  <form action="<?php echo get_module_path().'masters/education_report'; ?>"  method="get" autocomplete="off">
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
						<div class="tbl-container">
			<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline " id="Srtable" role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th style="width:10px;">Sr. No.</th>	
                  <th>Department</th>               
                  <th style="text-align:center">Status</th>
                  <th style="text-align:center">Action</th>				  
                </tr>
                </thead>
                <tbody>
                <?php 
				if(!empty($education_list)){
					$education_list = html_escape($education_list);  
				foreach ($education_list as $key=>$education) {
						$name   = $education['edu_name'];
						$status = $education['edu_status'];
						$id     = base64_encode($education['edu_id']);
				//echo "<pre/>"; print_r($education);	
                ?>  
                <tr>
				  <td><?php echo $key + 1; ?></td>	                                   				  
                  <td style="word-break:break-all;"><a  href="<?php echo get_module_path();?>masters/view_education/?edu_id=<?php echo $id; ?>" title="View Details" > <?php echo $name; ?></a></td>
                  <td style="text-align:center"><?php  if($status =="Active") { echo "<span class='label label-success'>Active</span>"; } else if($status =="Deactivated") { echo "<span class='label label-danger'>Deactivated</span>"; }  ?></td>
                  <td style="text-align:center">
				  &nbsp;  
				  <?php  if($status=="Active") { ?> 
				  
					<a  class="btn btn-primary btn-xs"  href="<?php echo get_module_path();?>masters/edit_education/?edu_id=<?php echo $id; ?>" title="Edit"><i class="fa fa-edit"></i>Edit</a>
					&nbsp;  
						<a  class="btn btn-danger btn-xs"  data-href="<?php echo get_module_path();?>masters/deactivate_education/?edu_id=<?php echo $id; ?>" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i> Deactivate</a>
						
					 <?php } ?>
					 
					</td>
                </tr>
                <?php } } ?>
				 </tbody>
						</table> 
                  </div>				
					
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

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {

  $('#confirm-deactivate').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });	

});
</script>

<style>
	  @media screen and (max-width: 768px) {
 

	.tbl-container{
		overflow-x:scroll;
		overflow-y:scroll;
		height: 300px;
	}
	#Srtable{
		width: 619px;
	}
}
</style>