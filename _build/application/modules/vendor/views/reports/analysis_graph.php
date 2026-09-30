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
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end



var chart = am4core.create('chartdiv', am4charts.XYChart)
chart.colors.step = 2;

chart.legend = new am4charts.Legend()
chart.legend.position = 'top'
chart.legend.paddingBottom = 20
chart.legend.labels.template.maxWidth = 92

var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
xAxis.dataFields.category = 'category'
xAxis.renderer.minGridDistance = 10;
xAxis.renderer.cellStartLocation = 0.1
xAxis.renderer.cellEndLocation = 0.9
xAxis.renderer.grid.template.location = 0;

var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
yAxis.min = 0;

function createSeries(value, name) {
    var series = chart.series.push(new am4charts.ColumnSeries())
    series.dataFields.valueY = value
    series.dataFields.categoryX = 'category'
    series.name = name
    series.columns.template.tooltipText = "{name}:{valueY} [bold]{valueX}[/]";
	series.columns.template.width = am4core.percent(60);
    series.events.on("hidden", arrangeColumns);
    series.events.on("shown", arrangeColumns);
	series.sequencedInterpolation = true;
	 var categoryLabel = series.bullets.push(new am4charts.LabelBullet());
     categoryLabel.label.hideOversized = false;
	 
	 
   /*  var bullet = series.bullets.push(new am4charts.LabelBullet())
    bullet.interactionsEnabled = true
    bullet.dy = 30;
    bullet.label.text = '{valueY}'
    bullet.label.fill = am4core.color('#ffffff') */

    return series;
}

chart.data = [
  
	<?php echo $graph_data; ?>
   
]


createSeries('first', 'AMC');
createSeries('second', 'One Time Service');
createSeries('third', 'Sales');

function arrangeColumns() {

    var series = chart.series.getIndex(0);

    var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
    if (series.dataItems.length > 1) {
        var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
        var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
        var delta = ((x1 - x0) / chart.series.length) * w;
        if (am4core.isNumber(delta)) {
            var middle = chart.series.length / 2;

            var newIndex = 0;
            chart.series.each(function(series) {
                if (!series.isHidden && !series.isHiding) {
                    series.dummyData = newIndex;
                    newIndex++;
                }
                else {
                    series.dummyData = chart.series.indexOf(series);
                }
            })
            var visibleCount = newIndex;
            var newMiddle = visibleCount / 2;

            chart.series.each(function(series) {
                var trueIndex = chart.series.indexOf(series);
                var newIndex = series.dummyData;

                var dx = (newIndex - trueIndex + middle - newMiddle) * delta

                series.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
                series.bulletsContainer.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
            })
        }
    }
}

}); // end am4core.ready()
</script>

