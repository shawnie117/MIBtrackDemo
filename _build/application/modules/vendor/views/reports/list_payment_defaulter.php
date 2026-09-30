<?php 
$vendor  = $this->session->userdata('vendor');
$role_id = $vendor['user_role_id'];
?>
<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
   <!-- BEGIN PAGE BASE CONTENT -->
   
   <!--div class="page-head">
		<div class="page-title">
			<h1><?php echo $page_title; ?></h1>
		</div>	
	</div-->
	<?php 


   $date    = $this->input->get('date');
   $assigned_to    = $this->input->get('assigned_to');
   if($date == "MY")
   {
	  $page_title  = "Todays Followups" ;
   } 
   if($assigned_to == "MY")
   {
	   $page_title  = "Todays My Followups" ;
   } 
	?>
	
   <div class="row">
      <div class="col-md-12">
         <div class="portlet light bordered">
		 <div class="row">
		 <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				        <input type="hidden" name="assigned_to" value="<?php echo $assigned_to; ?>"/>
                        
			</div>  
			<div class="col-md-9 ">
			   <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
				   <span class="caption-subject font-red-mint sbold float-right total_count">( Total - 0 )</span>	
				   <span class="caption-subject font-red-mint sbold float-right Balanced_Amount">( Total Outstanding Amount - 0 )</span>	
				   </div>
				   <div class="col-md-3 col-sm-4">
				   <div class="form-group " > 
                           <input class="form-control"  id="searchStr_name" name="searchStr_name" type="text" placeholder="Search By Name/ Contact No." maxlength="100" value="<?php echo isset($my_followup_post_data['searchStr_name'])?$my_followup_post_data['searchStr_name']:"";?>" onchange="table_list(1);">
                        </div>
</div>
</form>


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
		    <?php $my_followup_post_data = array();
			      $page = "1";
			      $history = $this->input->get('history');
			       if($history == "back")
				  {
					  $my_followup_post_data = $this->session->userdata('my_followup_post_data');
					  $page = 	$my_followup_post_data['page'];				  
				  } 
			?>  
             <div class="col-md-12"> 
				
				    </div>
					<div class="tbl-container ">    		
			<table class="table table-striped table-bordered table-hover  dataTable no-footer dtr-inline  tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th width="2%">Sr. No.</th>				 	  
				  <th>Customer Name </th>        				  
                  <th width="10%">Contact No</th>               
                  <th>Bill No </th>               
                  <th>Total Amt </th>               
                  <th>Balance Amt </th>               
                  <th>Recieved Amt </th>
                  <th>Date </th>               
                                                 		  
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
		
		<div class="modal fade" id="form_modal1" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog modal-lg">
			<div class="modal-content">			
			</div>
			</div>
		</div>	
<!--END START MODAL -->

<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
$("#download_customer_report").click(function(e){
	var html = $('#srch_form').html();
	$('#srch_form').attr("action",base_url+"customers/download_customer_report");
	$('#srch_form').attr("onsubmit","");
	$('#srch_form').submit();
	$('#srch_form').attr("action","");
	$('#srch_form').attr("onsubmit","return false;");
	
});		

$("#form_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    }); 
       $('.datepickerD').datepicker({
				format: 'dd-mm-yyyy',
				autoclose: true,
				todayHighlight: true,

		}).on('changeDate', function(e) {
			table_list(1);
		});			
		
		$('.datepickerMY').datepicker({
				format: 'mm-yyyy',
				autoclose: true,
				todayHighlight: true,
				viewMode: "months",
				minViewMode: "months"

		}).on('changeDate', function(e) {
			table_list(1);
		});
		

  $('#confirm-deactivate').on('show.bs.modal', function(e) {
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
		formdata.push({name: "sort_by", value: "created_at"}); // or other relevant field
    	formdata.push({name: "sort_order", value: "DESC"});   // or "ASC"		
		$("#tbl_list").html("");
		
		$.ajax({
			url:base_url+"ajax/tbl_payment_defaulter_list/"+pageno,
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
				var Balanced_Amount = json_arr.Balanced_Amount;

				
				$(".total_count").html("( Total - "+total_count+" )");
				$(".Balanced_Amount").html("( Total Outstanding Amount - "+Balanced_Amount+" )");
				$("#tbl_list").html(html_data);
				$('.pagination').html(json_arr.pagination);
				    
			}
		});
	}
</script>

