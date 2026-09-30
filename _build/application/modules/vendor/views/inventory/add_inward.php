<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
	<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered">
		 <ul class="page-breadcrumb breadcrumb">
	<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
	<li><a href="<?php echo base_url(get_module()."/inventory/supplier_report")?>">All Inward Report </a><i class="fa fa-circle"></i></li>
	<li><span class="active"><?php echo $page_title; ?></span></li>
	</ul>
            <!--div class="portlet-title">
               <div class="caption">
                  <i class="font-red-mint <?php echo $icon ;?> "></i>
                  <span class="caption-subject font-red-mint sbold"><?php echo $page_title; ?></span>
               </div>
			   
		   </div-->
            <div class="row">
			<div class="col-md-12">
		    <a  class="btn btn-success btn-sm  pull-right" href="<?php echo get_module_path();?>inventory/add_item"  title="Add"><i class="fa fa-plus"></i> Add New </a> 
			
			<span class="caption-subject font-green-sharp sbold pull-left"><?php echo $page_title; ?></span>&nbsp; <span class="caption-subject font-red-mint sbold total_count ">( Total - 0 )</span>	 
		
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
				   <?php $item_post_data = array();
			      $history = $this->input->get('history');
				  $page = 1;
				  if($history == "back")
				  {
					  $item_post_data = $this->session->userdata('item_post_data');	
					  $page = $item_post_data['page'];	
				  } 
			?>        
			   <div class="portlet-body form">
				  <?php if($action=="Edit"){ 
				     //echo "<pre/>"; print_r($details);die; 
				    $details = html_escape($details);
					$formaction = "edit_supplier/?ref_id=".base64_encode($ref_id);
					}else {  $formaction = "add_supplier"; } 
					
					?>
					</divb>
                     <form action="<?php echo get_module_path().'inventory/'.$formaction; ?>" id="add_edit_form" method="post" autocomplete="off" >
					  <div class="form-body">
					  <?php if($action=="Edit"){ ?>
					  <input type="hidden" value="<?php echo isset($details['supp_det_id'])?$details['supp_det_id']:set_value("supp_det_id"); ?>" name="supp_det_id" id="supp_det_id" />
					  <?php } ?>
										 
					  </div>

					     <div class="portlet-title">
					            <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-call-out"></i>
								  <span class="caption-subject font-red-mint sbold">Inward Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>
					  

					  <div class="form-group col-md-3">   
						<lable>Select Supplier</lable>
						   <select class="form-control" id="p_suplid" name="p_suplid" onchange="table_list(1);" >
							<option value=""> Select Supplier</option>
							 <?php  if(!empty($supplier_list)){ 	
								foreach($supplier_list as $supplier){ 
								  $selected = isset($item_post_data['p_suplid']) && ($item_post_data['p_suplid']==$supplier['supp_det_id'])?"selected":"";
								?>
									<option value="<?php echo $supplier['supp_det_id'];?>" <?php echo $selected;?> ><?php echo $supplier['supp_name']; ?></option>
							<?php } } ?>	
						   </select>
						     </div>

							 <div class="form-group col-md-3"> 
    <label for="ticket_date">Inward Date<?php echo REQUIRED_STAR; ?></label>
    <input type="text" class="form-control pull-right datepicker" id="date" name="date" placeholder="To Date..." maxlength="10">
</div>



					
						   <div class="form-group col-md-3">
                           <label for="p_supp_desc">Invoice No</label> <?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="p_supp_desc" name="p_supp_desc" type="text" placeholder="Enter Supplier Description" required maxlength="500" value="<?php echo isset($details['supp_desc'])?$details['supp_desc']:set_value("p_supp_desc"); ?>">
						    <?php echo form_error('p_supp_desc','<span class="text-danger">','</span>'); ?>
                           </div>
				
						   <div class="form-group col-md-3"> 
						   <label for="p_supp_desc">Search: </label> <?php echo REQUIRED_STAR; ?>
                           <input class="form-control" id="searchStr_name" name="searchStr_name" type="text" placeholder="Search By Item Name" maxlength="100" value="<?php echo isset($cust_post_data['searchStr_name'])?$cust_post_data['searchStr_name']:"";?>" onchange="table_list(1);">
                        </div>


                        </form>
							
								
			<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th width="2%">Sr. No.</th>
				  <th width="30%">Item Name</th>        				  
                  <th width="10%">Code</th>               
                  <th>MRP</th>                     
                  <th width="5%">Avail Stock</th>  
                  <th width="5%">Qty</th>  
                  <th width="5%">Unit Price</th>  
                  <th width="10%">Amount</th>
                  		  
                </tr>
                </thead>
				<tbody  id="tbl_list">
               
			   </tbody>
</table>	


<button type="submit" class="btn btn-success " >Order</button>
				<p>TOTAL:</p>



			<table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
				  <th width="2%">Sr. No.</th>
				  <th width="30%">Item Name</th>        				  
                  <th width="10%">Code</th>               
                  <th>MRP</th>                     
                  <th width="5%">Avail Stock</th>  
                  <th width="5%">Qty</th>  
                  <th width="5%">Unit Price</th>  
                  <th width="10%">Amount</th>
                  		  
                </tr>
                </thead>
</table>	

					
<div class="form-actions">
		 <div class="form-group">
		 <center>						  
		   <button type="submit" class="btn btn-success" >Confirm  Order</button>
		  <a href="<?php echo get_module_path();?>inventory/supplier_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Cancel</a>
		</a>
		  <!-- <a href="<?php echo get_module_path();?>inventory/supplier_report/?history=back" class="btn btn-info"><i class="fa fa-history"></i>Print Bardcode</a> -->
		  </center>
								</div>
								</div>
								</div>
								</div>

							


								<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true"  data-backdrop="static">
			<div class="modal-dialog modal-md">
			<div class="modal-content">			
			</div>
			</div>
		</div>	



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
  // Detect pagination click
     $('.pagination').on('click','a',function(e){
       e.preventDefault(); 
       var pageno = $(this).attr('data-ci-pagination-page');
	   if(pageno){
		    table_list(pageno);
	   }
      
     });   

	 $(document).ready(function() {
    // Set current system date
    var currentDate = new Date();
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1;
    var year = currentDate.getFullYear();
    var formattedDate = (day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month + '-' + year;
    
    // Set default date in input field
    $('#date').val(formattedDate);
    
    // Initialize date picker without time picker
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        minViewMode: 'days' // Set minimum view to days to remove time picker
    });
});



});
table_list(<?php echo $page; ?>);
function table_list(pageno)
	{
		var formdata  = $("#srch_form").serializeArray();		
		$("#tbl_list").html("");
		$.ajax({
			url:base_url+"ajax_inventory/tbl_item_list/"+pageno,
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

