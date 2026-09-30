<?php $role_id = $this->session->userdata('user_role_id');?>

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
                        <label for="p_type">Supplier <?php echo REQUIRED_STAR; ?></label>				 
						   <select class="form-control" id="p_suplid" name="p_suplid" required onchange="table_list(1);">
							<option value=""> Select Supplier</option>
							 <?php  if(!empty($supplier_list)){ 	
								foreach($supplier_list as $supplier){ 
								  $selected = isset($details['order_suppid']) && ($details['order_suppid']==$supplier['supp_id'])?"selected":"";
								
								?>
									<option value="<?php echo $supplier['supp_id'];?>" data-detid="<?php echo $supplier['supp_det_id'];?>"  <?php echo $selected;?> ><?php echo $supplier['supp_name']; ?></option>
							<?php } } ?>	
						   </select>
						     </div>
							 <div class="form-group col-md-3"> 
    <label for="ticket_date">Inward Date<?php echo REQUIRED_STAR; ?></label>
    <input type="text" class="form-control pull-right datepicker" id="date" name="date" placeholder="To Date..." maxlength="10">
</div>



					
						   <div class="form-group col-md-3">
                           <label for="p_supp_desc">Invoice No</label> <?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="p_supp_desc" name="p_supp_desc" type="text" placeholder="Enter Invoice Number" required maxlength="500" value="<?php echo isset($details['supp_desc'])?$details['supp_desc']:set_value("p_supp_desc"); ?>">
						    <?php echo form_error('p_supp_desc','<span class="text-danger">','</span>'); ?>
                           </div>
						
						   

						   <br>

						   <div class="form-group col-md-6"> 
						   <label for="p_supp_desc">Search: </label> <?php echo REQUIRED_STAR; ?>
                           <!-- <input class="form-control" id="searchStr_name" name="searchStr_name" type="text" placeholder="Search By Item Name" maxlength="100" value="<?php echo isset($cust_post_data['searchStr_name'])?$cust_post_data['searchStr_name']:"";?>" onchange="table_list(1);"> -->
                   <input class="form-control" id="searchStr_name" name="searchStr_name" type="text" placeholder="Search By Item Name" maxlength="100" value="<?php echo isset($cust_post_data['searchStr_name'])?$cust_post_data['searchStr_name']:"";?>" onchange="searchAndInsert();">

                        </div>
                        <table id="first_table" class="table table-striped table-bordered table-hover dt-responsive">
                        <thead>
                <tr>
				  <th style="text-align:center">Sr. No.</th>	
                  <th>Item</th> 
                  <th>Purchase Price</th> 
                  <th>Sale Price</th>        				  
                  <th style="text-align:center">Qty</th>
                  <!-- <th style="text-align:center">Price</th>				   -->
                </tr>
                </thead>
				<?php 
if ($action == "Edit") {  
    if (!empty($orderDetailList)) {  
        $html = "";
        foreach ($orderDetailList as $key => $item) {
            $sr_no = $key + 1;			
            $itemList = $item['itemList'][0];					   
            $html = '<tr>
                <td><input type="hidden" class="ckbox" name="item_id[]" value="'.$itemList['item_id'].'" /> &nbsp;'.$sr_no.'</td>
                <td>'.$itemList['item_name'].'</td>
                <td>'.$itemList['item_price'].'</td>
                <td>'.$itemList['item_price2'].'</td>
                <td><input type="number" id="qty_'.$sr_no.'" class="form-control" min="1" name="qty[]" value="'.$item['item_no'].'" placeholder="Qty" /></td>
                <td><input type="number" class="form-control" /></td>
            </tr>';
            echo $html;
        }
    }
}
?>

<?php if($action == "Add") { ?>
    <tbody id="tbl_list">
        <tr>
            <td><input type="hidden" class="ckbox" name="item_id[]" value="" /></td>
            <td><input type="text" class="form-control" name="item_name[]" value="" readonly /></td>
            <td><input type="number" class="form-control" name="purchase_price[]" value="" readonly /></td>
            <td><input type="number" class="form-control" name="sale_price[]" value="" readonly /></td>
            <td><input type="number" class="form-control" name="qty[]" min="1" placeholder="Qty" readonly /></td>
        </tr>
    </tbody>
<?php } ?>

						</table> 


						   		<!-- Render pagination links -->
						<div class="pagination" style="float:right;">
						</div>				
				</div>
						


						
					
                        </form>
							
<!-- 								
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
</table>	 -->

<button id="order_button" type="button" class="btn btn-success">Order</button>
<p>TOTAL:</p>

<table id="second_table" class="table table-striped table-bordered table-hover dt-responsive">
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Item Name</th>
            <th>Purchase Price</th>
            <th>Sale Price</th>
            <th>Qty</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
				
<div class="form-actions">
		 <div class="form-group">
		 <center>						  
		   <button type="submit" class="btn btn-success" >Confirm  Order</button>
		  <a href="<?php echo get_module_path();?>inventory/supplier_report/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Cancel</a>
		</a>
		  <a href="<?php echo get_module_path();?>inventory/supplier_report/?history=back" class="btn btn-info"><i class="fa fa-history"></i>Print Bardcode</a>
		  <center>
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

function table_list(pageno) {
    var formdata  = $("#srch_form").serializeArray();        
    $("#tbl_list").html("");
    $.ajax({
        url: base_url + "ajax_inventory/tbl_item_list1/" + pageno,
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
        }
    });
}

	</script>
    <script>
function searchAndInsert() {
    const searchValue = document.getElementById('searchStr_name').value.trim().toLowerCase();
    const tableRows = document.querySelectorAll('.tbl_data_table_no_srch tbody tr');
    let found = false;

    // Create an array to store all extracted data
    let extractedData = [];
console.log(tableRows);
    tableRows.forEach(row => {
        const itemName = row.cells[1].textContent.trim().toLowerCase();
console.log(tableRows);
        // Check if the item name matches the search query
        if (itemName.includes(searchValue)) {
            found = true;
            row.style.backgroundColor = '#d1ffd1'; // Highlight the matched row

            // Extract item_id from the row
            const itemId = row.querySelector('input[name="item_id[]"]').value;
console.log("itemId");
            // Perform AJAX request to fetch additional data (purchase price, sale price, etc.)
            $.ajax({
                url: base_url + "ajax_inventory/tbl_item_list/" + pageno,
                type: "POST",
        data: formdata,
        datatype: "json",
        async: true,
        cache: false,
                //data: { item_id: itemId }, // Sending item_id to the server
                success: function(response) {
                    // Assuming the response returns an object with purchase price and sale price
                    const data = JSON.parse(response); 
console.log("data is:"+data);
                    if (data.success) {
                        // Create rowData object with additional details from the server response
                        const rowData = {
                            item_id: itemId,
                            item_name: row.cells[1].textContent.trim(),
                            code: row.cells[2].textContent.trim(),
                            mrp: row.cells[3].textContent.trim(),
                            avail_stock: row.cells[4].textContent.trim(),
                            qty: row.querySelector('input[name="qty[]"]').value,
                            purchase_price: data.purchase_price,  // Fetched purchase price
                            sale_price: data.sale_price  // Fetched sale price
                        };

                        // Store the rowData object in the extractedData array
                        extractedData.push(rowData);
console.log("rowdata"+ rowData);
                        // Create a new row for the second table
                        const secondTableBody = document.querySelector('#tbl_list');
                        const newRow = document.createElement('tr');
                        
                        // Set the HTML content of the new row with fetched data
                        newRow.innerHTML = `
                            <td>${secondTableBody.children.length + 1}</td>
                            <td><input type="hidden" class="ckbox" name="item_id[]" value="${rowData.item_id}" />${rowData.item_name}</td>
                            <td>${rowData.code}</td>
                            <td>${rowData.mrp}</td>
                            <td>${rowData.avail_stock}</td>
                            <td><input type="number" class="form-control" name="qty[]" value="${rowData.qty}" readonly /></td>
                            <td><input type="number" class="form-control" name="unit_price[]" value="${rowData.purchase_price}" readonly /></td>
                            <td><input type="number" class="form-control" name="amount[]" value="${parseFloat(rowData.qty) * parseFloat(rowData.purchase_price)}" readonly /></td> `;

                        // Log the row to the console for debugging
                        console.log("Inserting row:", newRow.innerHTML);

                        // Append the new row to the second table
                        secondTableBody.appendChild(newRow);
                    } else {
                        console.error('Failed to fetch item details for item_id: ' + itemId);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed: " + status + ", " + error);
                }
            });
        }
    });

    if (found) {
        console.log("All Extracted Data:", extractedData);
    } else {
        alert('No matching item found.');
    }

    // Clear the search input after processing
    document.getElementById('searchStr_name').value = '';
}
</script>


<!-- <script>
function searchAndInsert() {
    console.log("Search function triggered");

    // Get the search value
    const searchValue = document.getElementById('searchStr_name').value.trim().toLowerCase();
    console.log("Search Value:", searchValue);

    if (!searchValue) {
        alert('Please enter a search term.');
        return;
    }

    // Get all rows from the first table
    const tableRows = document.querySelectorAll('.tbl_data_table_no_srch tbody tr');
    console.log("Number of rows found:", tableRows.length);

    if (tableRows.length === 0) {
        alert('No rows found in the first table.');
        return;
    }

    let found = false;

    tableRows.forEach((row, index) => {
        const cells = row.cells;
        if (!cells || cells.length < 4) {
            console.error(`Row ${index + 1} has insufficient cells. Skipping.`);
            return;
        }

        const itemName = cells[1].textContent.trim().toLowerCase();
        if (itemName.includes(searchValue)) {
            found = true;

            // Extract data from the row
            const item_id = row.querySelector('input[name="item_id[]"]').value;
            const purchase_price = cells[2].textContent.trim();
            const sale_price = cells[3].textContent.trim();
            const qty = row.querySelector('input[name="qty[]"]').value;

            // Insert data into the second table
            const secondTableBody = document.querySelector('#tbl_list');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="hidden" class="ckbox" name="item_id[]" value="${item_id}" /></td>
                <td><input type="text" class="form-control" name="item_name[]" value="${itemName}" readonly /></td>
                <td><input type="number" class="form-control" name="purchase_price[]" value="${purchase_price}" readonly /></td>
                <td><input type="number" class="form-control" name="sale_price[]" value="${sale_price}" readonly /></td>
                <td><input type="number" class="form-control" name="qty[]" value="${qty}" readonly /></td>
            `;
            secondTableBody.appendChild(newRow);

            row.style.backgroundColor = '#d1ffd1'; // Highlight the matched row
            document.getElementById('searchStr_name').value = ''; // Clear search input
        }
    });

    if (!found) {
        alert('No matching item found.');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchStr_name');
    searchInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            console.log("Enter key pressed");
            searchAndInsert();
        }
    });
});


    </script> -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- Ensure correct inclusion of jQuery and jQuery UI -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript">
 var raw = <?php echo $item_list; ?>;
 console.log(raw);  // Add this after defining 'raw' to check if the data is correct

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
$('#searchStr_name').autocomplete({
    minLength: 1,
    source: source,
    select: function (event, ui) {
        // Use the selected value for search and insert
        document.getElementById('searchStr_name').value = ui.item.value;
        searchAndInsert();
    }
});


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
			
			$('#tbl_list').append(html);
			
			
			 }			
			
	}
    </script>
<script>
document.querySelector('.btn-success').addEventListener('click', function (e) {
    e.preventDefault(); // Prevent default form submission

    const tableRows = document.querySelectorAll('.tbl_data_table_no_srch tbody tr'); // Source table rows
    const secondTableBody = document.querySelector('#tbl_list'); // Target table body
    let extractedData = [];

    tableRows.forEach(row => {
        // Check if the row is highlighted
        if (row.style.backgroundColor === 'rgb(209, 255, 209)') { // Check for the highlight color
            const rowData = {
                item_id: row.querySelector('input[name="item_id[]"]').value,
                item_name: row.cells[1].textContent.trim(),
                code: row.cells[2].textContent.trim(),
                mrp: row.cells[3].textContent.trim(),
                avail_stock: row.cells[4].textContent.trim(),
                qty: row.querySelector('input[name="qty[]"]').value
            };

            extractedData.push(rowData);

            // Create a new row for the second table
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${secondTableBody.children.length + 1}</td>
                <td><input type="hidden" class="ckbox" name="item_id[]" value="${rowData.item_id}" />${rowData.item_name}</td>
                <td>${rowData.code}</td>
                <td>${rowData.mrp}</td>
                <td>${rowData.avail_stock}</td>
                <td><input type="number" class="form-control" name="qty[]" value="${rowData.qty}" readonly /></td>
                <td><input type="number" class="form-control" name="unit_price[]" value="${rowData.mrp}" readonly /></td>
                <td><input type="number" class="form-control" name="amount[]" value="${parseFloat(rowData.qty) * parseFloat(rowData.mrp)}" readonly /></td>
            `;
            secondTableBody.appendChild(newRow);
        }
    });

    if (extractedData.length === 0) {
        alert('No highlighted data to insert.');
    } else {
        console.log('Inserted Data:', extractedData);
    }
});
</script>
<script>

document.getElementById('order_button').addEventListener('click', function () {
    const firstTableRows = document.querySelectorAll('#first_table tbody tr');
    const secondTableBody = document.querySelector('#second_table tbody');

    secondTableBody.innerHTML = ''; // Clear previous data

    firstTableRows.forEach((row, index) => {
        const item = row.cells[1].textContent.trim();
        const purchasePrice = parseFloat(row.cells[2].textContent.trim());
        const salePrice = parseFloat(row.cells[3].textContent.trim());
        const qty = parseFloat(row.querySelector('input').value.trim());
        const amount = qty * purchasePrice;

        // Skip rows with empty or invalid qty
        if (!qty || isNaN(qty)) return;

        // Create a new row for the second table
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${index + 1}</td>
            <td>${item}</td>
            <td>${purchasePrice.toFixed(2)}</td>
            <td>${salePrice.toFixed(2)}</td>
            <td>${qty}</td>
            <td>${amount.toFixed(2)}</td>
        `;

        secondTableBody.appendChild(newRow);
    });

    calculateTotal(); // Update total amount
});

function calculateTotal() {
    let total = 0;
    const rows = document.querySelectorAll('#second_table tbody tr');
    rows.forEach(row => {
        total += parseFloat(row.cells[5].textContent);
    });

    document.querySelector('p').textContent = `TOTAL: ${total.toFixed(2)}`;
}

</script>

