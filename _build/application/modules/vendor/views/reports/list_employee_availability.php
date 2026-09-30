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
	<style>
	table.dataTable thead .sorting:after {
    opacity: 0.2;
    content: "";
}
table.dataTable thead .sorting_asc:after {
    content: "";
}

table.dataTable thead .sorting_desc:after {
    content: "";
}


.DTFC_LeftBodyLiner {
top: 1px !important;
overflow-x: hidden;
}

table.dataTable {
    clear: both;
    margin-top: 0px !important; 
    margin-bottom: 0px !important;
    max-width: none !important;
	border-collapse: collapse;
}
table.dataTable.row-border tbody tr:first-child th, table.dataTable.row-border tbody tr:first-child td, table.dataTable.display tbody tr:first-child th, table.dataTable.display tbody tr:first-child td {
border-top: 1px solid #ddd;
}
	</style>
	
   <div class="row">
      <div class="col-md-12">
         <div class="portlet light bordered">
		
			   <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
				   <span class="caption-subject font-red-mint sbold float-right total_count">( Total - 0 )</span>	
                       
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
		    <?php $emp_avia_post_data = array();
			       $page    = "1";
				   $history = $this->input->get('history');
				  if($history == "back")
				  {
					  $emp_avia_post_data = $this->session->userdata('emp_avia_post_data');	
					  $page  = $emp_avia_post_data['page'];
				  } 
			?>  
             <div class="col-md-12"> 
				  <form id="srch_form" autocomplete="off" onsubmit="<?php get_module_path()."reports/employee_availability_report"?>" method="get">
				     
				      <div class="form-group col-md-2"> 
                          <input type="text" class="form-control pull-right datepickerMY" id="month_year" name="month_year" placeholder="From Date" maxlength="10" value="<?php echo isset($month_year)?$month_year:date("m-Y");?>" >
                        </div>
					    <button type="submit" class="btn btn-success btn-sm">Submit</button>
						
                        </form>
				    </div>
			  
			  
				<table id="example" class="display nowrap" style="width:100%">
					<thead>
						<tr>
						  <th width="2%">Sr. No.</th>
						  <th>Employee</th> 
						  <?php for($i=1;$i<=31;$i++){ ?>	
						   <th><?php echo $i; ?></th>  				  
						  <?php }  ?>   		  
						</tr>
                     </thead>
					  <tbody  id="tbl_list">
					 
              <?php  if(!empty($list)){
				  $html = "";
				foreach($list as $key=>$item){ //echo "<pre/>"; print_r($item);die;
					$sr_no        		= (($page-1)*$this->perPage)+($key+1);
					$id          	    = $item['emp_id'];
					$id          	    = $item['user_id'];
					$emp_name           = $item['emp_name'];
    				$availabiltyList    = $item['availabiltyList'];
					$id          = base64_encode($id);
							
					$name_txt    =  '<a href="'.get_module_path().'customers/ticket_report/?assigned_to='.$id.'" title="'.$emp_name.'" target="_blank" >'.$emp_name.'</a>';					
									   
				    $html .= '<tr><td>'.$sr_no.'</td><td>'.$name_txt.'</td>';
					if(!empty($availabiltyList)){
						foreach($availabiltyList as $date)
						{
							$html .='<td>'.$date['count'].'</td>';
							
						}
					}else {
						for($i=1;$i<=31;$i++){
							$html .='<td>0</td>';
						}
					}
					$html .='</tr>';
				}
					
				}else { $html = "<tr><td valign='top' colspan='32' class='dataTables_empty'>No data available in table</td></tr>";	} 
				
				echo $html;
				?>
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


$("#form_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
		$(this).data('bs.modal', null);
		$(this).find(".modal-content").load(link.attr("href"));
    }); 
       $('.datepickerD').datepicker({
				format: 'dd-mm-yyyy',
				autoclose: true,
				todayHighlight: true,

		});	
		
		$('.datepickerMY').datepicker({
				format: 'mm-yyyy',
				autoclose: true,
				todayHighlight: true,
				viewMode: "months",
				minViewMode: "months"

		});
 

});

</script>

