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
		  <div class="col-lg-8 col-md-6">
		  <span class="caption-subject font-green-sharp bold "><?php echo $page_title; ?></span>
		  <span class="caption-subject font-red-mint sbold float-right total_count">( Total - 0 )</span>	
			    </div>
				<div class="col-lg-4 col-md-6">
					<center>
				<a  class="btn btn-success btn-sm " href="<?php echo get_module_path();?>masters/add_amc" title="Add"><i class="fa fa-plus"></i> Add New </a> 
<?php if($role_id == SUPER_ADMIN_ROLE_ID){?>
				<span  class="btn red btn-outline btn-sm"  id="download_amc_report" title="Download AMC Report"><i class="fa fa-download"></i> Download </span> 

<?php } ?>					<center>
</div>
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
				 <?php 
				 $amc_post_data = array();
			      $history = $this->input->get('history');
                  $page = 1;
				  if($history == "back")
				  {
					  $amc_post_data = $this->session->userdata('amc_post_data');
                      $page	 =  $amc_post_data['page'];
				  } 
				 ?>  

				 
             <div class="col-md-12"> 
				  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				     <input type="hidden" name="highlight_id" value="<?php echo $this->input->get("highlight"); ?>" />				
						 <div class="form-group col-md-3">                           
                            <select class="form-control" id="status" name="status" onchange="table_list(1);">
							<option value=""> Select Status</option>
							 <?php  if(!empty($status_list)){ 
								foreach($status_list as $stat){ 
								  		 $status   = isset($amc_post_data['status'])?$amc_post_data['status']:"Active";
									     $selected = $status==$stat?"selected":"";							
								?>
									<option value="<?php echo $stat?>" <?php echo $selected;?>  ><?php echo $stat; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div>
						<div class="form-group col-md-3"> 
                           
                           <input class="form-control" id="searchStr" name="searchStr" type="text" placeholder="Search By Service Name" maxlength="100" value="<?php echo isset($amc_post_data['searchStr'])?$amc_post_data['searchStr']:"";?>" onchange="table_list(1);">
						 
                        </div>
						
						
                        </form>
							
				    </div>
					<div class="tbl-container">	
			<table class="table table-striped table-bordered table-hover  dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
			<thead>
                 <tr>
				  <th width="0.5%">Sr. No.</th>	
				  <th width="1%">Service Id </th>
                  <th>Service Name </th>
                  <th width="12%">Regular <br/>Price</th>               
                  <th width="12%">Commercial <br/> Price</th>               
                  <th style="text-align:center" width="15%">Action</th>				  
                </tr>
                </thead>
                <tbody  id="tbl_list">
            
				 </tbody>
						</table> 
							<!-- Render pagination links -->
						<div class="pagination" style="float:right;">
						</div>
						  </div>
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
		
<!--END START MODAL -->

<!-- // changes done by anjali dhane 22/06/2026 AMC reactivate funtionality -->
<div class="modal fade" id="confirm-reactivate" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-refresh"></i> Confirm Reactivate
                </h4>
            </div>

            <div class="modal-body">
                Are you really want to Reactivate ?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">
                    CANCEL
                </button>

                <a class="btn btn-success btn-ok">
                    REACTIVATE
                </a>
            </div>

        </div>
    </div>
</div>

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
		$("#download_amc_report").click(function(e){
	$('#srch_form').attr("action",base_url+"masters/download_amc_report");
	$('#srch_form').attr("onsubmit","");
	$('#srch_form').submit();
	$('#srch_form').attr("action","");
	$('#srch_form').attr("onsubmit","return false;");
	
});	
	
  $('#confirm-deactivate').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });	
  // changes done by anjali dhane 22/06/2026 AMC reactivate funtionality

$('#confirm-reactivate').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});
  // Detect pagination click
     $('.pagination').on('click','a',function(e){
       e.preventDefault(); 
       var pageno = $(this).attr('data-ci-pagination-page');
	   if(pageno){
		    table_list(pageno);
	   }
      
     });   

});

table_list(<?php echo $page;?>);
function table_list(pageno)
	{
		var formdata  = $("#srch_form").serializeArray();		
		$("#tbl_list").html("");
		$.ajax({
			url:base_url+"ajax/tbl_amc_list/"+pageno,
			type: "POST",
			data: formdata,
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
			{		
				var json_arr = JSON.parse(data);			
				var html_data = '';
				var html_data   = json_arr.list;
				var total_count = json_arr.total_count;
				
				$(".total_count").html("( Total - "+total_count+" )");
				$("#tbl_list").html(html_data);
				$('.pagination').html(json_arr.pagination);
				    
			}
		});
	}
</script>

