<?php $role_id = $this->session->userdata('user_role_id');?>

<style>
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>
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
		   
             <div class="col-md-12"> 
				  <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
				     
				      <div class="form-group col-md-3"> 
                          <input type="text" class="form-control pull-right datepickerMY" id="month_year" name="month_year" placeholder="Month/ Year" maxlength="10" value="" >
                        </div>	
					
						
                        </form>
				    </div>
			 <div class="col-md-12"> 					
			<div id="chartdiv"></div>
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
<!-- Resources -->
<script src="<?php echo get_assets_path(); ?>js/charts/core.js"></script>
<script src="<?php echo get_assets_path(); ?>js/charts/charts.js"></script>
<script src="<?php echo get_assets_path(); ?>js/charts/animated.js"></script>
<script type="text/javascript">
$(document).ready(function() {

   $('.datepickerMY').datepicker({
			format: 'mm-yyyy',
			autoclose: true,
			todayHighlight: true,
			viewMode: "months",
			minViewMode: "months",
	});
		 
    $(".datepickerMY").datepicker("setDate", new Date()).on('changeDate', function(e) {
			table_list(1);
		});
});

</script>

<!-- Chart code -->
<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create("chartdiv", am4charts.PieChart3D);
chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

chart.legend = new am4charts.Legend();

chart.data = [
  {
    payment: "AMC",
    amount: 10000
  },
  {
    payment: "One Time Service",
    amount: 2000
  },
  {
    payment: "Sale",
    amount: 15000
  },
  
  
];

var series = chart.series.push(new am4charts.PieSeries3D());
series.dataFields.value = "amount";
series.dataFields.category = "payment";

}); // end am4core.ready()
</script>



