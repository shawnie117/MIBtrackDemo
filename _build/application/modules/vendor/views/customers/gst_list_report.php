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
	
	
   <div class="row">
      <div class="col-md-12">
         <div class="portlet light bordered">
		 <div class="col-lg-8 col-md-12">
		 <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
		 <span class="caption-subject font-red-mint sbold float-right total_count">( Total - 0 )</span>	
			</div>  
<div class="col-lg-4 col-md-12">
	<center>
				   <a  class="btn btn-success btn-sm " href="<?php echo get_module_path();?>customers/add_customer" title="Add"><i class="fa fa-plus"></i> Add New </a>
<?php if($role_id == SUPER_ADMIN_ROLE_ID){?>
				   <span  class="btn red btn-outline btn-sm"  id="download_customer_report" title="Download Customer Report"><i class="fa fa-download"></i> Download </span> 

<?php } ?>				   </center>
				   </div>
			  <div class="row">
                 
				
		 <div class="col-md-12">
			<div class="portlet-body"> 
               <div class="col-md-5">                                                   
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
		    <?php $cust_post_data = array();
			      $page       = "1";
			      $history    = $this->input->get('history');
			      $sel_status = $this->input->get('status');
			      $sev_type   = $this->input->get('type');
				  if($history == "back")
				  {
					  $cust_post_data = $this->session->userdata('cust_post_data');	
					  $page  = $cust_post_data['page'];
				  } 
			?>  
             <div class="col-md-12"> 
				  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				  <input type="hidden" name="highlight_id" value="<?php echo $this->input->get("highlight"); ?>" />
				       <!-- <div class="form-group col-md-2">                           
                            <select class="form-control" id="status" name="status" onchange="table_list(1);">
							<option value=""> Select Status</option>
							 <?php  if(!empty($status_list)){ 
								foreach($status_list as $stat){ 
								  		 $status   = isset($cust_post_data['status'])?$cust_post_data['status']:"Active";
										 $sel_stat = isset($sel_status)?$sel_status:$status;
									     $selected = $sel_stat==$stat?"selected":"";						
								?>
									<option value="<?php echo $stat?>" <?php echo $selected;?> ><?php echo $stat; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> -->
				       <div class="form-group col-md-2">                           
                            <select class="form-control" id="service_type" name="service_type" onchange="table_list(1);">
							<option value="">Select Service Type</option>
							 <?php  if(!empty($service_type_list)){ 
								foreach($service_type_list as $key=>$service_type){ 
								  		 $followup   = isset($cust_post_data['followup'])?$cust_post_data['followup']:"";
										 $sev_type = isset($sev_type)?$sev_type:$followup;
									     $selected = $sev_type==$key?"selected":"";						
								?>
									<option value="<?php echo $key?>" <?php echo $selected;?> ><?php echo $service_type; ?></option>
							<?php } } ?>	
						   </select>						 
                        </div> 

						<!-- <div class="form-group col-md-2">                           
							<select class="form-control" id="gst" name="gst" onchange="table_list(1);">
								<option value=""> Select GST</option>
								<option value="true">With GST</option>
								<option value="false">Without GST</option>
							</select>                         
						</div> -->

                        <div class="form-group col-md-2">
                            <input type="text" class="form-control datepickerMY" 
                                id="month_year" name="month_year"
                                placeholder="Select Month-Year">
                        </div>

						<div class="form-group col-md-3"> 
                           <input class="form-control" id="searchStr_name" name="searchStr_name" type="text" placeholder="Search By Name/Contact" maxlength="100" value="<?php echo isset($cust_post_data['searchStr_name'])?$cust_post_data['searchStr_name']:"";?>" onchange="table_list(1);">
                        </div>
						<div class="form-group col-md-2"> 
                           <input class="form-control" id="searchStr_cust_id" name="searchStr_cust_id" type="text" placeholder="Search By ID" maxlength="100" value="<?php echo isset($cust_post_data['searchStr_cust_id'])?$cust_post_data['searchStr_cust_id']:"";?>" onchange="table_list(1);">
                        </div>


                        </form>
				    </div>
			<div class="tbl-container">
			<table class="table table-striped table-bordered table-hover  dataTable no-footer dtr-inline collapsed tbl_data_table_no_srch" id="Srtable" role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr>
                    <th width="2%">Sr.No.</th>
                    <th>Customer Name</th>
                    <th>Company Name</th>
                    <th>GST Number</th>
                    <th>Amount (Without GST)</th>
                    <th>GST Amount</th>
                    <th>Total Amount</th>
                </tr>
                </thead>
                <tbody  id="tbl_list">
              
				 </tbody>
						</table> 
						</div>  					
						<!-- Render pagination links -->
						<div class="pagination" style="float:right;">
						</div>
						 
                       
            		
			   
               </div>
				</div>
            </div>


            <!-- Summary Cards -->
            <div class="gst-summary-cards" id="gst_summary_cards">
                <div class="gst-card card-nogst">
                    <div class="card-icon"><i class="fa fa-file-invoice"></i>&#xe135;</div>
                    <i class="fa fa-minus-circle card-icon"></i>
                    <div class="card-label">Total Without GST</div>
                    <div class="card-value"><span class="currency">₹</span><span id="sum_without_gst">0.00</span></div>
                    <div class="card-sub"><i class="fa fa-info-circle"></i> Base amount before tax</div>
                </div>

                <div class="gst-card card-gst">
                    <i class="fa fa-percent card-icon"></i>
                    <div class="card-label">Total GST</div>
                    <div class="card-value"><span class="currency">₹</span><span id="sum_gst">0.00</span></div>
                    <div class="card-sub"><i class="fa fa-info-circle"></i> Tax collected amount</div>
                </div>

                <div class="gst-card card-total">
                    <i class="fa fa-rupee-sign card-icon"></i>
                    <div class="card-label">Grand Total</div>
                    <div class="card-value"><span class="currency">₹</span><span id="sum_total">0.00</span></div>
                    <div class="card-sub"><i class="fa fa-check-circle"></i> Including all taxes</div>
                </div>
            </div>
            <!-- END Portlet PORTLET-->
         </div>

<style>
/* ===== GST SUMMARY CARDS ===== */
.gst-summary-cards {
    display: flex;
    gap: 18px;
    margin: 24px 0 10px 0;
    flex-wrap: wrap;
}

.gst-card {
    flex: 1;
    min-width: 200px;
    border-radius: 12px;
    padding: 20px 24px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(0,0,0,0.10);
    transition: transform 0.18s ease, box-shadow 0.18s ease;
    cursor: default;
    animation: cardSlideIn 0.4s ease forwards;
}

.gst-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 28px rgba(0,0,0,0.15);
}

.gst-card.card-nogst {
    background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
    color: #fff;
}

.gst-card.card-gst {
    background: linear-gradient(135deg, #00897b 0%, #00574b 100%);
    color: #fff;
}

.gst-card.card-total {
    background: linear-gradient(135deg, #f57c00 0%, #bf360c 100%);
    color: #fff;
}

.gst-card .card-icon {
    position: absolute;
    top: 14px;
    right: 18px;
    font-size: 38px;
    opacity: 0.18;
}

.gst-card .card-label {
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    opacity: 0.85;
    margin-bottom: 8px;
}

.gst-card .card-value {
    font-size: 26px;
    font-weight: 700;
    letter-spacing: 0.5px;
    line-height: 1.2;
}

.gst-card .card-value span.currency {
    font-size: 15px;
    font-weight: 500;
    margin-right: 3px;
    opacity: 0.8;
}

.gst-card .card-sub {
    margin-top: 10px;
    font-size: 11px;
    opacity: 0.75;
    border-top: 1px solid rgba(255,255,255,0.2);
    padding-top: 8px;
}

@keyframes cardSlideIn {
    0%   { opacity: 0; transform: translateY(12px); }
    100% { opacity: 1; transform: translateY(0); }
}

.gst-card:nth-child(1) { animation-delay: 0s; }
.gst-card:nth-child(2) { animation-delay: 0.08s; opacity: 0; }
.gst-card:nth-child(3) { animation-delay: 0.16s; opacity: 0; }

/* ===== MOBILE STYLES ===== */
@media screen and (max-width: 768px) {
    .followuptbl { height: 200px; }
    .tbl-box { overflow-x: scroll; padding: 10px; }
    .table-condensed { width: 800px; }
    .tbl-container { overflow-x: scroll; overflow-y: scroll; }
    #Srtable { width: 619px; }

    .gst-summary-cards { flex-direction: column; gap: 12px; }
    .gst-card .card-value { font-size: 22px; }
}
</style>
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
    $("#download_customer_report").click(function(e){
        $('#srch_form').attr("action", base_url + "customers/download_gst_report");
        $('#srch_form').attr("onsubmit", "");
        $('#srch_form').submit();
        $('#srch_form').attr("action", "");
        $('#srch_form').attr("onsubmit", "return false;");
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
    $('.pagination').on('click', 'a', function(e){
        e.preventDefault(); 
        $(".loader").fadeIn();
        var pageno = $(this).attr('data-ci-pagination-page');
        if (pageno) {
            table_list(pageno);
        }
    });

    // Automatically select "With GST" if GST parameter is present in URL
    const urlParams = new URLSearchParams(window.location.search);
    const gstValue = urlParams.get('gst'); 
    if (gstValue) {
        $("#gst").val(gstValue).trigger('change');  // Ensures value is recognized by the form
    }

});
table_list(<?php echo $page;?>);

function table_list(pageno) {
    var formdata  = $("#srch_form").serializeArray();        
    $("#tbl_list").html("");
    $(".loader").fadeIn();
    $.ajax({
        url: base_url + "ajax/tbl_customer_gst_report/" + pageno,
        type: "POST",
        data: formdata,
        datatype: "json",
        async: true,
        cache: false,
        success: function(data) {        
            var json_arr = JSON.parse(data);            
            var html_data = json_arr.list;
            var total_count = json_arr.total_count;

            $(".total_count").html("( Total - " + total_count + " )");
            $("#tbl_list").html(html_data);
            $('.pagination').html(json_arr.pagination);

            $("#sum_without_gst").html(json_arr.sum_without_gst);
            $("#sum_gst").html(json_arr.sum_gst);
            $("#sum_total").html(json_arr.sum_total);

            $(".loader").fadeOut();    
        }
    });
}

</script>


