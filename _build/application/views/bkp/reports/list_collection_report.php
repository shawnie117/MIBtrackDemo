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
		
			   <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
				   
                       
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
				  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				    
						<div class="form-group col-md-3"> 
                          <input type="text" class="form-control pull-right datepickerMY" id="lead_month_year" name="month_year" placeholder="Month/ Year" maxlength="10" value="" >
                        </div>	 
					 <div class="form-group col-md-2">  
						 <select class="form-control" id="service_type" name="service_type" onchange="table_list(1);" >
							 <?php  if(!empty($service_list)){  
								foreach($service_list as $key=>$type){ ?>
									<option value="<?php echo $key;?>" ><?php echo $type; ?></option>
							<?php } } ?>	
						   </select>
                          </div> 
						
                        </form>
				    </div>
			<div class="col-md-12 shadow"> 		
				    <div class="portlet-title">
					  <br/>
					   <div class="caption">
						  <i class="font-red-mint icon-wallet"></i> <span class="caption-subject font-red-mint sbold">Total Collection </span>
						  <span class="caption-subject font-red-mint sbold float-right count_collection_list">( Total Records - 0 )</span>	
					   </div>
						<hr style="margin:3px;"/>
				    </div>							
					<table class="table table-striped table-bordered  tbl_data_table_no_srch3  "  role="grid" aria-describedby="sample_1_info">
						<thead>
						<tr class="success">
						  <th>Sr. No.</th>	
						  <th>Invoice No</th>        				  
						  <th>Receipt No</th>               
						  <th>Paid Amt </th>               
						  <th>Pay Mode </th>               
						  <th>Type </th>               
						  <th>Payment Added By </th>               
						  <th>	Added On </th>            		  
    		  
						</tr>
						</thead>					   
						<tbody class=""  id="tbl_collection_list">					  
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
	$("#clear_btn").click(function(e){
	 $('#searchStr_name').val('');
	 $('#status, #ticket_assign_to, #customer_id, #clm_id').val('');
	 $('#from_date, #from_date').val('');
	 $('#srch_form').trigger("reset");
	 $(".selectpicker").val('');
     $(".selectpicker").selectpicker("refresh"); 	
	 table_list(1);
});	
	
$("#download_ticket_report").click(function(e){
	var html = $('#srch_form').html();
	$('#srch_form').attr("action",base_url+"customers/download_ticket_report");
	$('#srch_form').attr("onsubmit","");
	$('#srch_form').submit();
	$('#srch_form').attr("action","");
	$('#srch_form').attr("onsubmit","return false;");
	
});

$('.selectpicker').selectpicker();
$('.selectpicker').on('change', function(){ table_list(1); });

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
				minViewMode: "months",
				"setDate":new Date(),
		})
		 
  $(".datepickerMY").datepicker("setDate", new Date()).on('changeDate', function(e) {
			table_list(1);
		});;
  
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
table_list(1);
function table_list(pageno)
	{
		var formdata  = $("#srch_form").serializeArray();		
		$("#tbl_list").html("");
		$.ajax({
			url:base_url+"ajax/tbl_collection_report_list/"+pageno,
			type: "POST",
			data: formdata,
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
			{		
				var json_arr = JSON.parse(data);	
				
				var tbl_collection_list     = json_arr.tbl_collection_list;
				var count_collection_list   = json_arr.count_collection_list;
				$(".count_collection_list").html("( Total Records- "+count_collection_list+" )");
				$("#tbl_collection_list").html(tbl_collection_list);			
				
			
				    
			}
		});
	}
</script>

