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
.ui-draggable, .ui-droppable {
	background-position: top;
}

@media (max-width:600px){

}
	</style>
	
   <div class="row">
      <div class="col-md-12">
         <div class="portlet light bordered">
		   		 <ul class="page-breadcrumb breadcrumb">
			<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
			<li><a href="<?php echo base_url(get_module()."/inventory/counter_billing_report")?>">All Billing Report </a><i class="fa fa-circle"></i></li>
			<li><span class="active"><?php echo $page_title; ?></span></li>
			</ul>
			<span class="caption-subject font-green-sharp sbold pull-left"><?php echo $page_title; ?></span>&nbsp; <span class="caption-subject font-red-mint sbold ">( Total - 0 )</span>	 
			
            
			  <div class="row">
                 
				

                 
                  
        <div class="col-md-12">
            <form id="srch_form" autocomplete="off" onsubmit="return false;" method="post">
                <div class="form-group col-lg-6">
                    <label for="cust_name">Customer Name <?php echo REQUIRED_STAR; ?></label>
                    <input class="form-control" id="cust_name" name="cust_name" type="text" placeholder="Enter Customer Name" required maxlength="100" value="<?php echo isset($details['customer_name']) ? $details['customer_name'] : set_value("cust_name"); ?>">
                    <?php echo form_error('cust_name','<span class="text-danger">','</span>'); ?>
                </div>
                <div class="form-group col-lg-6">
                    <label for="cust_contact">Mobile No.<?php echo REQUIRED_STAR; ?></label>
                    <input class="form-control" id="cust_contact" name="cust_contact" type="text" placeholder="Enter Mobile No." maxlength="10" value="<?php echo isset($details['customer_contact']) ? $details['customer_contact'] : set_value("cust_contact"); ?>">
                    <?php echo form_error('cust_contact','<span class="text-danger">','</span>'); ?>
                </div>
                <div class="form-group col-lg-6">
                    <label for="cust_address">Address</label>
                    <input class="form-control" id="cust_address" name="cust_address" type="text" placeholder="Enter Address"  maxlength="300" value="<?php echo isset($details['customer_address']) ? $details['customer_address'] : set_value("cust_address"); ?>">
                    <?php echo form_error('cust_address','<span class="text-danger">','</span>'); ?>
                </div>
                <div class="form-group col-lg-6">
                    <label for="cust_gstno">GST No</label>
                    <input class="form-control" id="cust_gstno" name="cust_gstno" type="text" placeholder="Enter GST No"  maxlength="15" value="<?php echo isset($details['customer_gstno']) ? $details['customer_gstno'] : set_value("cust_gstno"); ?>">
                    <?php echo form_error('cust_gstno','<span class="text-danger">','</span>'); ?>
                </div>
            </form>
  
</div>

						
                       		  
						
				    
			<div class="col-md-12" >			
			<input type="hidden" id="status" name="status" value="Active"/>	
                          <div class="form-group col-md-3"> 
                           <input class="form-control ui-autocomplete-input" id="searchStr" name="searchStr" type="text" placeholder="Search..." maxlength="100" value="" >
						 
                        </div>
					     <div class="form-group col-md-3">   
						 <select class="form-control" id="brand_id" name="brand_id"  onchange="table_list2(1);">
							<option value=""> Select Brand</option>
							 <?php  if(!empty($brand_list)){ 	
								foreach($brand_list as $brand){ ?>
									<option value="<?php echo $brand['inv_brand_id'];?>" ><?php echo $brand['inv_brand_name']; ?></option>
							<?php } } ?>	
						   </select>
						   </div>
						    <div class="form-group col-md-3">   
						   <select class="form-control" id="p_catid" name="p_catid" onchange="get_cat_subcat(this,'p_subcatid');table_list2(1);" >
							<option value=""> Select Category</option>
							 <?php  if(!empty($category_list)){ 	
								foreach($category_list as $category){ ?>
									<option value="<?php echo $category['inv_cat_id'];?>"  ><?php echo $category['inv_cat_name']; ?></option>
							<?php } } ?>	
						   </select>
						     </div>
							 <div class="form-group col-md-3">   
						   <select class="form-control" id="p_subcatid" name="p_subcatid"  onchange="table_list2(1);"  >
							<option value=""> Select Sub Category</option>
							 </select>
					</div>	
			<table class="table table-striped table-bordered tbl_data_table_no_srch2"  role="grid" aria-describedby="sample_1_info">
			<thead>
                <tr class="success">
				  <th>Item</th> 
                  <th>Price</th> 
                </tr>
                </thead>
                <tbody  id="tbl_list">
               
				 </tbody>
						</table> 
						   			
				
                       

				    </div>
				<div class="col-md-12" style="border:3px solid #abe7ed;padding:10px;" >			
		        <div class="col-md-9">
                   <span class="text-danger" id="form_err"></span>				
                   <?php echo form_error('item_id[]','<span class="text-danger">','</span>'); ?>
		 	        <table class="table table-striped table-bordered tbl_data_table_no_srch2"  role="grid" aria-describedby="sample_1_info">
			          <thead>
						<tr class="danger">
						  <th style="text-align:center">Sr. No.</th>	
						  <th>Item</th> 
						  <th style="text-align:center">Qty</th>
						  <th style="text-align:center">Rate</th> 
						  <th style="text-align:center">Total Price</th>				  
						  <th style="text-align:center">Action</th>				  
						</tr>
						</thead>
					    <tbody  id="tbl_list2">
				   
					    </tbody>
				    </table>
					 <div class="form-group col-md-4">
                           <label for="grand_total">Paying Amount <?php echo REQUIRED_STAR; ?></label>
						   <input type="hidden" id="grand_total" name="grand_total" maxlength='8' value="0" />
						      <input class="form-control" id="paying_total" name="paying_total" type="text" placeholder="Total Paying Amount" maxlength='8' value="0" >
						    <?php echo form_error('grand_total','<span class="text-danger">','</span>'); ?>		
                           </div>
						   <div class="form-group col-md-4">
                           <label for="p_type">Payment Mode<?php echo REQUIRED_STAR; ?> </label>
						     <select class="form-control" id="p_type" name="p_type" >
							<option value=""> Payment Mode</option>
							 <?php  if(!empty($payment_mode_list)){ 							
								foreach($payment_mode_list as $key=>$pay){ ?>			          
									<option value="<?php echo $key;?>"  ><?php echo $pay; ?></option>
							<?php } } ?>	
						   </select>	
                            <?php echo form_error('p_type','<span class="text-danger">','</span>'); ?>						   
                           </div>
			    </div> 
				<div class="col-md-3">			
		 	        <table class="table table-striped table-bordered"  role="grid" aria-describedby="sample_1_info">
			          <thead>
						<tr class="danger">
						   <th style="text-align:center">GST %</th>	
						   <th style="text-align:center">Total GST</th>				  
						</tr>
						</thead>
					    <tbody  id="tbl_list3">
				           <tr>
						   <td style="text-align:center">5%</th>	
						   <td id="gstd_5"></td>				  
						   </tr> 
						   <tr>
						   <td style="text-align:center">12%</th>	
						   <td id="gstd_12"></td>				  
						   </tr> 
						   <tr>
						   <td style="text-align:center">18%</th>	
						   <td id="gstd_18"></td>				  
						   </tr>
						   <tr>
						   <td style="text-align:center">28%</th>	
						   <td id="gstd_28"></td>				  
						   </tr> 
						   <tr>
						   <td style="text-align:center">Total</th>	
						   <th id="gstd_total"></th>				  
						   </tr>
					    </tbody>
				    </table>
					 
			    </div>
			    </div>
             <div class="col-md-12 table-group-actions"> 
                <div class="form-group col-md-12">
				<center>
				<span type="submit" class="btn btn-success btn-sm" id="btn_submit" >Submit</span></center>
				</div>	</div>
						  
						  
                       
            	 </form>	
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
<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true"  data-backdrop="static">
			<div class="modal-dialog modal-md">
			<div class="modal-content">			
			</div>
			</div>
		</div>	
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
 var raw = <?php echo $item_list; ?>;

var source   = [ ];
var source1  = [ ];
var source2  = [ ];
var mapping  = { };
var mapping2  = { };

for(var i = 0; i < raw.length; ++i) {
    source1.push(raw[i].item_name);
    source2.push(raw[i].inv_brand_name);
    mapping[raw[i].item_name] = [{"item_name":raw[i].item_name,"item_id":raw[i].item_id,"item_gst":raw[i].item_gst,"item_price":raw[i].item_price}];
   // mapping[raw[i].inv_brand_name] = [{"item_name":raw[i].item_name,"item_id":raw[i].item_id,"item_gst":raw[i].item_gst,"item_price":raw[i].item_price}];
    
    
}
//source = source1.concat(source2);
source = source1;

$('#searchStr').autocomplete({
    minLength: 1,
    source: source,
    select: function(event, ui) {
        var item       = mapping[ui.item.value][0];
        add_item_auto(item);
        
        
    }
});

/* $("#searchStr").autocomplete({
    source: availableItems,
    
    focus: function(event, ui) {
        $("#searchStr").val(ui.item_name);
        return false;
    },
    select: function(event, ui) {
        $("#cod_prodotto").val(ui.item_name);
        $("#searchStr").val(ui.item_name);
        $("#prezzo_unitario").val(ui.item_name);
        $("#cod_iva").val(ui.iva);
        return false;
    }
}); */

$(document).ready(function() {




$("#btn_submit").click(function(e){
	$('#srch_form').attr("action",base_url+"inventory/counter_billing");
	var paying_total = $('#paying_total').val();
	$('#srch_form').attr("onsubmit","");
	if($('#srch_form').valid()){
		if(paying_total>0){
			$('#srch_form').submit();
		} else 
		{
			e.preventDefault(); 
			$('#form_err').html("Select atleast one Item");
		}
	
	}
	$('#srch_form').attr("action","");
	$('#srch_form').attr("onsubmit","return false;");
	
});	
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
		    table_list2(pageno);
	   }
      
     });  
  

     $('.datepicker').datepicker({
				format: 'dd-M-yyyy',
				autoclose: true,
				todayHighlight: true,

		});	



$("#srch_form").validate({
        rules: {
            required: {
                required: true
            },
             order_date: {
                required: true,
			 }, 
			 p_suplid: {
                required: true,
			 }, 
			
			cust_name: {
				required: true,
            	maxlength: 100,
                minlength: 2,
				 }, 
				 
			cust_contact: {
				 required: true,
               	maxlength: 10,
                minlength: 10,
                digits: true,
				 }, 	 
			cust_gstno: {
				maxlength: 15,
                gst: true,
				 }, 	 
			"item_id[]": {
                required: true,
			 }, 
			"qty[]": {
                required: true,
			 }, 
			"price[]": {
                required: true,
			 },
            paying_total: {
                maxlength: 8, 
				number: true,
				
				 },  
			p_type: {
                required: true,
				
				 },  
			
			
		},
		messages:
		{
			//p_amt:{ lessThanOrEqual:"Paying Amount Must Be Less Than Or Equal To Balance Amount"},
		},			 
	
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        },
		onfocusout: false,
	    invalidHandler: function(form, validator) {
			var errors = validator.numberOfInvalids();
			if (errors) {                    
            validator.errorList[0].element.focus();
			}
		   },
		errorPlacement: function(error, element) {
		   if (element.is(":file")) {
			 error.appendTo((element).parents('.form-group').find('.file_err'));
			}else if (element.is(":checkbox")){ 
			//error.insertBefore(element);
			error.appendTo((element).parents('td').find('.chk_err'));
			}else { 
			error.insertAfter(element);
			}
			
		},
    });		

});

	function show_text_box(obj)
	{
			var id = $(obj).attr("data-pp_id");
			$('#'+id).prop("disabled", !$(obj).is(':checked'));
			$('.'+id).prop("disabled", !$(obj).is(':checked'));
	}
	function get_det_id(obj)
	{
			var supplier_id = $(obj).val();
			var det_id = $('option:selected', obj).attr('data-detid');
			$('#supplier_id').val(supplier_id);
			$('#det_id').val(det_id);
			
	}
	function add_item(obj)
	{
			var id = $(obj).attr('data-id');
			var gst = $(obj).attr('data-gst');
			var price = $(obj).attr('data-price');
			var name = $(obj).attr('data-name');
			var cust_pdt_qty = 1;
			if(isNaN(gst))   { gst = 0;} 
		    if(isNaN(price)) { price = 0;} 
			
			var total = price*cust_pdt_qty;
			total = Math.round(parseFloat((total * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);
			
             var cust_pdt_gst = gst;
			if(isNaN(total))         { total = 0;} 
			
		   var gst_price = (total * cust_pdt_gst)/100;		
		   gst_price = Math.round(parseFloat((gst_price * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);
           cust_pdt_gst_price	 = gst_price + total;	 
               
			 if ($( "#item_id_"+id ).length>0) {
				 var qty = parseInt($("#qty_"+id).val());
				 if(isNaN(qty))   { qty = 0;} 
				 qty = qty + 1;
				 $("#qty_"+id).val(qty);
				 $("#qty_"+id).change();  
			 }	else {			 
			   
			var html = "";
			var srno = 1;
			html = '<tr id="'+id+'"><td><input type="hidden" class="form-control" name="item_id[]" value="'+id+'" id="item_id_'+id+'"  /><input type="hidden" class="form-control" name="gst_price[]" value="'+cust_pdt_gst_price+'" id="gst_price_'+id+'"  /> <input type="hidden" class="form-control" name="only_gst_price[]" value="'+gst_price+'" id="only_gst_price_'+id+'"  /><input type="hidden" class="form-control" name="gst[]" value="'+gst+'" id="gst_'+id+'" data-id="'+id+'"  /> &nbsp;<span class="sr_no">'+srno+'</span></td><td>'+name+'</td><td><input type="number"  class="form-control qty"  min="1" name="qty[]" value="1" placeholder="Qty" data-id="'+id+'" onchange="calculate_total(this);" id="qty_'+id+'" /></td><td><input type="number"  data-id="'+id+'"  class="form-control price"  min="1" name="price[]" value="'+price+'" placeholder="Price"  readonly  id="price_'+id+'" /></td><td><input type="number" name="total_price[]" class="form-control total_price '+id+'" value="'+price+'" id="total_price_'+id+'"  readonly /> </td><td><a onclick="delete_row(this);" class="btn btn-danger btn-xs" data-id="'+id+'" ><i class="fa fa-close"></i></a></td></tr>';
			
			$('#tbl_list2').append(html);
			get_srno();
			get_total();
            get_gst_details();	
			
			 }			
			
	}
   function add_item_auto(item)
	{
            var id    = item['item_id'];
            var name  = item['item_name'];
            var gst   = item['item_gst'];
            var price = item['item_price'];
			/* var id = $(obj).attr('data-id');
			var gst = $(obj).attr('data-gst');
			var price = $(obj).attr('data-price');
			var name = $(obj).attr('data-name'); */
			var cust_pdt_qty = 1;
			if(isNaN(gst))   { gst = 0;} 
		    if(isNaN(price)) { price = 0;} 
			
			var total = price*cust_pdt_qty;
			total = Math.round(parseFloat((total * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);
			
             var cust_pdt_gst = gst;
			if(isNaN(total))         { total = 0;} 
			
		   var gst_price = (total * cust_pdt_gst)/100;		
		   gst_price = Math.round(parseFloat((gst_price * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);
           cust_pdt_gst_price	 = gst_price + total;	 
               
			 if ($( "#item_id_"+id ).length>0) {
				 var qty = parseInt($("#qty_"+id).val());
				 if(isNaN(qty))   { qty = 0;} 
				 qty = qty + 1;
				 $("#qty_"+id).val(qty);
				 $("#qty_"+id).change();  
			 }	else {			 
			   
			var html = "";
			var srno = 1;
			html = '<tr id="'+id+'"><td><input type="hidden" class="form-control" name="item_id[]" value="'+id+'" id="item_id_'+id+'"  /><input type="hidden" class="form-control" name="gst_price[]" value="'+cust_pdt_gst_price+'" id="gst_price_'+id+'"  /> <input type="hidden" class="form-control" name="only_gst_price[]" value="'+gst_price+'" id="only_gst_price_'+id+'"  /><input type="hidden" class="form-control" name="gst[]" value="'+gst+'" id="gst_'+id+'" data-id="'+id+'"  /> &nbsp;<span class="sr_no">'+srno+'</span></td><td>'+name+'</td><td><input type="number"  class="form-control qty"  min="1" name="qty[]" value="1" placeholder="Qty" data-id="'+id+'" onchange="calculate_total(this);" id="qty_'+id+'" /></td><td><input type="number"  data-id="'+id+'"  class="form-control price"  min="1" name="price[]" value="'+price+'" placeholder="Price"  readonly  id="price_'+id+'" /></td><td><input type="number" name="total_price[]" class="form-control total_price '+id+'" value="'+price+'" id="total_price_'+id+'"  readonly /> </td><td><a onclick="delete_row(this);" class="btn btn-danger btn-xs" data-id="'+id+'" ><i class="fa fa-close"></i></a></td></tr>';
			
			$('#tbl_list2').append(html);
			get_srno();
			get_total();
            get_gst_details();	
			
			 }			
			
	}
	
	function calculate_total(obj) {
		var id       = $(obj).attr("data-id");
		
        var gst                    = parseFloat($("#gst_"+id).val());		
        var cust_pdt_qty           = parseFloat($("#qty_"+id).val());		
        var cust_pdt_price         = parseFloat($("#price_"+id).val());
		
		if(isNaN(cust_pdt_qty))   { cust_pdt_qty = 0;} 
		if(isNaN(cust_pdt_price)) { cust_pdt_price = 0;} 
		if(isNaN(gst)) { gst = 0;} 
		var cust_pdt_gst_price = 0;
	
		var total = cust_pdt_price*cust_pdt_qty;
			total = Math.round(parseFloat((total * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);
			if(isNaN(total))  { total = 0;} 	
		    $("#total_price_"+id).val(total);
		   
		  
		   
		   // Calculate GST
		     var gst_price = (total * gst)/100;		
		     gst_price = Math.round(parseFloat((gst_price * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2);
             cust_pdt_gst_price	 = gst_price + total;
            $("#only_gst_price_"+id).val(gst_price);
            $("#gst_price_"+id).val(cust_pdt_gst_price);
          get_total();			 
          get_gst_details();	
       	
    }
	function get_total()
	{
		
		 var total_gst_price = 0;
		 $("#tbl_list2").find(".form-control").each(function( j ) {
		 if( $(this).attr("name") == "gst_price[]"){
				var gst_price = parseFloat($(this).val());
				if(isNaN(gst_price))   { gst_price = 0;} 
				total_gst_price = total_gst_price + gst_price;
				
			} 
	   });	
	   total_gst_price = Math.round(parseFloat((total_gst_price * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2); 
	   $("#grand_total").val(total_gst_price);	
	   $("#paying_total").val(total_gst_price);	
		
	}
	
   function get_gst_details()
	{
		
		 var gst_price = 0;
		 var gst = 0;
		 var total_gst_price = 0;
		 var gstd_5  = 0;
		 var gstd_12 = 0;
		 var gstd_18 = 0;
		 var gstd_28 = 0;
		 $("#tbl_list2").find(".form-control").each(function( j ) {
		   if( $(this).attr("name") == "gst[]"){
				gst = parseFloat($(this).val());
				id  = $(this).attr("data-id");
				if(isNaN(gst))   { gst = 0;} 
				gst_price = parseFloat($("#only_gst_price_"+id).val());
				if(isNaN(gst_price))   { gst_price = 0;}
				if(gst==5)
				{
					gstd_5 = gstd_5 + gst_price;
				}				
				if(gst==12)
				{
					gstd_12 = gstd_12 + gst_price;
				}	
				if(gst==18)
				{
					gstd_18 = gstd_18 + gst_price;
				}	
				if(gst==28)
				{
					gstd_28 = gstd_28 + gst_price;
				}				
				total_gst_price = total_gst_price + gst_price;
			}
          			
			
	   });
	   
	   total_gst_price = Math.round(parseFloat((total_gst_price * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2); 
	   gstd_28 = Math.round(parseFloat((gstd_28 * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2); 
	   gstd_18 = Math.round(parseFloat((gstd_18 * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2); 
	   gstd_12 = Math.round(parseFloat((gstd_12 * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2); 
	   gstd_5 = Math.round(parseFloat((gstd_5 * Math.pow(10, 2)).toFixed(2))) / Math.pow(10, 2); 
	   $("#gstd_total").html(total_gst_price);	
	   $("#gstd_28").html(gstd_28);	
	   $("#gstd_18").html(gstd_18);	
	   $("#gstd_12").html(gstd_12);	
	   $("#gstd_5").html(gstd_5);	
	
		
		 
	}

function get_srno()
{
	var Srno = 1;
    $("#tbl_list2").find(".sr_no").each(function( j ) {
	   $(this).html(Srno);
	   Srno++
   });
}
	function get_payment_details(obj) {
		
		var payment_type   = $(obj).val();	
		 
		$("#other_details").addClass("hidden");
		$("#cheque_details").addClass("hidden");
		
		if(payment_type=="Cheque"){
			$("#cheque_details").removeClass("hidden");
			
		}else if(payment_type=="Online"){
			$("#other_details").removeClass("hidden");
		}
	}
	
	
		
	function delete_row(obj)
	{
		var id = $(obj).attr("data-id");
		$('#'+id).remove();
		 get_total();			 
         get_gst_details();
	}	

//table_list2(1);
function table_list2(pageno)
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
				
				//$(".total_count").html("( Total - "+total_count+" )");
				$("#tbl_list").html(html_data);
				$('.pagination').html(json_arr.pagination);
				    
			}
		});
	}
</script>

