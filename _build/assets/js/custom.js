$(document).ready(function() {

  /*   jQuery.validator.addMethod('ckrequired', function(value, element, params) {
        var idname = jQuery(element).attr('id');
        var messageLength = jQuery.trim(CKEDITOR.instances[idname].getData());
        return !params || messageLength.length !== 0;
    }, "Image field is required"); */
	
jQuery.validator.addMethod("email", function(value, element, param) {
        return this.optional(element) || /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
    }, "Enter Valid Email Id");
	
jQuery.validator.addMethod("pan", function(value, element, param) {
        return this.optional(element) ||  /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/.test(value);
    }, "Enter Valid PAN No.");
	
jQuery.validator.addMethod("gst", function(value, element, param) {
        return this.optional(element) ||  /\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}/.test(value);
    }, "Enter Valid GST No.");
	
jQuery.validator.addMethod("ifsc", function(value, element, param) {
        return this.optional(element) ||  /[A-Z|a-z]{4}[0][a-zA-Z0-9]{6}$/.test(value);
    }, "Enter Valid IFSC Code");
	

    jQuery.validator.addMethod("noSpace", function(value, element) {
        return value.indexOf(" ") < 0 && value != "";
    }, "Space is not allowed");

    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z().\s]+$/i.test(value);
    }, "Only alphabetics allowed");

    jQuery.validator.addMethod("notEqualTo", function(value, element, param) {
        return this.optional(element) || value != $(param).val();
    }, "This has to be different...");

    jQuery.validator.addMethod("email", function(value, element, param) {
        return this.optional(element) || /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
    }, "Enter Valid Email Id");

    jQuery.validator.addMethod("greaterThan",
        function(value, element, params) {
            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val()) ||
                (Number(value) > Number($(params).val()));
        }, 'Must be greater than {0}.');
		
	jQuery.validator.addMethod("blankSpace", function(value) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	});
	
	jQuery.validator.addMethod("lessThanOrEqual",
        function(value, element, params) {
            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) <= new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val()) ||
                (Number(value) >= Number($(params).val()));
        }, 'Must be Less than or equal to ???? {0}.');

	jQuery.validator.addMethod("lessThanOrEqualDate", function(value, element, params) {
		return new Date(value) <= new Date($(params).val());
	});

	jQuery.validator.addMethod("lessThanOrEqualAmount", function(value, element, params) {
		return Number(value) <= Number($(params).val());
	});
	// jQuery.validator.addMethod("lessThanOrEqual",
    //     function(value, element, params) {
	// 		var compareValue = $(params).val();

	// 		// Check for date format only (dd/mm/yyyy or yyyy-mm-dd)
	// 		var isDate =
	// 			/^\d{2}\/\d{2}\/\d{4}$/.test(value) ||
	// 			/^\d{4}-\d{2}-\d{2}$/.test(value);

	// 		if (isDate) {
	// 			return new Date(value) <= new Date(compareValue);
	// 		}

	// 		// Numeric comparison
	// 		return Number(value) <= Number(compareValue);
    //     }, 'Must be Less than or equal to ???? {0}.');

// 	jQuery.validator.addMethod("lessThanOrEqual", function (value, element, params) {

//     var pay = Number(value);
//     var balance = Number($(params).val());

//     console.log({
//         originalValue: value,
//         originalBalance: $(params).val(),
//         pay: pay,
//         balance: balance,
//         comparison: pay <= balance
//     });

//     return pay <= balance;
// });
		

	
	jQuery.validator.addMethod("dimention", function (value, element, param) {
	var width  = $(element).data('imageWidth');
	var height = $(element).data('imageHeight');
	if(this.optional(element) ||( width == param[0] && height == param[1])){
	return true;
	}else{
	return false;
	}
	}, 'Invalid Image');


jQuery.validator.addMethod("filesize_max", function(value, element, param) {
    var isOptional = this.optional(element),
        file;
    
    if(isOptional) {
        return isOptional;
    }
    
    if ($(element).attr("type") === "file") {
        
        if (element.files && element.files.length) {
            
            file = element.files[0];            
            return ( file.size && file.size <= param ); 
        }
    }
    return false;
}, "File size is too large.");


jQuery.validator.addMethod("filesize_min", function(value, element, param) {
    var isOptional = this.optional(element),
        file;
    
    if(isOptional) {
        return isOptional;
    }
    
    if ($(element).attr("type") === "file") {
        
        if (element.files && element.files.length) {
            
            file = element.files[0];            
            return ( file.size && file.size >= param ); 
        }
    }
    return false;
}, "File should be at least 10 Kb.");
	
 //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });

    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
	
 $("#toggle_btn").click(function(){
    $("#toggle_srch").toggleClass("hidden");
  });
	
/* 	 $('.tbl_data_table').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false,
        dom: 'Bfrtip',
        buttons: [{
            extend: 'excel',
            text: 'Export to Excel',
            className: 'btn red btn-outline',
			columns: 'th:not(:last-child)',

        }, ],
		exportOptions: {  
		columns: 'th:not(:last-child)',
		
		}
    }); */


$('.tbl_data_table').DataTable({
		  'paging'      : false,
		  'lengthChange': false,
		  'searching'   : true,
		  'ordering'    : true,
		  'info'        : true,
		  'autoWidth'   : false,
});

$('.tbl_data_table2').DataTable({
		   'paging'      : false,
		  'lengthChange': false,
		  'searching'   : false,
		  'ordering'    : false,
		  'info'        : true,
		  'autoWidth'   : false,
		  "bInfo" 		: false,
});

  var dataTable = $('.tbl_data_table1').DataTable( {
		'paging'      : true,
	    'lengthChange': false,
		'searching'   : true,
	 } );
$('.dataTables_filter').css("display","none");

$('.tbl_data_table_no_srch').DataTable({
		  'paging'      : false,
		  'lengthChange': false,
		  'searching'   : false,
		  'ordering'    : false,
		  'info'        : true,
		  'autoWidth'   : false,
		  "bInfo" 		: false,
});



// var table = $('.tbl_data_table_no_srch2').DataTable({
// 		  'lengthChange': false,
// 		  'searching'   : false,
// 		  'ordering'    : false,
// 		  'info'        : true,
// 		  'autoWidth'   : false,
// 		  "bInfo" 		: false,
// 		  "scrollY"     : "200px",
// 		  "scrollX"     : true,
// 		  "scrollCollapse": true,
//          "paging":         false,
		 
		 		 
// });


// DataTables cannot parse a tbody placeholder row with one colspan cell.
// Leave those tables as plain tables until they contain real column-aligned rows.
var table = $('.tbl_data_table_no_srch2').filter(function () {
    var columns = $(this).find('thead tr:last th').length;
    var valid = true;
    $(this).find('tbody > tr').each(function () {
        if ($(this).children('td, th').length !== columns || $(this).children('[colspan]').length) {
            valid = false;
            return false;
        }
    });
    return valid;
}).DataTable({
    'lengthChange': false,
    'searching': false,
    'ordering': false,
    'info': true,
    'autoWidth': false,  // Disable auto width to prevent expansion
    "bInfo": false,
    "scrollY": "200px",
    "scrollX": false,    // Ensure horizontal scrolling is disabled
    "scrollCollapse": true,
    "paging": false,
});


var table2 = $('.tbl_data_table_no_srch3').DataTable({
		  'lengthChange': false,
		  'searching'   : false,
		  'ordering'    : false,
		  'info'        : true,
		  'autoWidth'   : false,
		  "bInfo" 		: false,
		  "scrollY"     : "400px",
		  "scrollX"     : true,
		  "scrollCollapse": true,
         "paging":         false,
		 
		 		 
});

 var table3 = $('#example').DataTable( {
        "scrollX": true,
		"scrollY"     : "400px",
		'lengthChange': false,
		'autoWidth'   : false,
		"paging":         false,
		scrollResize:     true,
		scrollCollapse: true,
		"scrollX": true,
		fixedColumns:   {
            leftColumns: 2,
            },
    } ); 
	
table2.columns.adjust().draw();
table.columns.adjust().draw();

$("#searchStr").keyup(function(){
     dataTable.search($(this).val()).draw() ;
});  
 
 

$('.tbl_data_table_srch_no_srch_export').DataTable({
		  'paging'      : true,
		  'lengthChange': true,
		  'searching'   : false,
		  'ordering'    : true,
		  'info'        : true,
		  'autoWidth'   : false,
		  dom: 'Bfrtip',
		  buttons: [   {
				extend: 'excel',
				text: 'Export to Excel',
				className: 'btn red btn-outline hidden',
				exportOptions: {
					columns: 'th:not(:last-child)',
				 },

			}, ],
		});
	

$('.slimScrollDiv').slimScroll({
		height: '100px',
		size:"10px",
	});
	
$('.slimScrollDiv6').slimScroll({
		height: '520px',
		size:"10px",
	});
$('.slimScrollDiv4').slimScroll({
		height: '450px',
		size:"10px",
	});
// $('.slimScrollDiv450').slimScroll({
// 		height: '450px',
// 		size:"10px",
// 	});
	
$('#slimScrollDiv2').slimScroll({
		height: '200px',
		size:"10px",
	});
$('.slimScrollDiv2').slimScroll({
		height: '160px',
		size:"10px",
	});
$('.slimScrollDiv150').slimScroll({
		height: '150px',
		size:"10px",
	});
$('.slimScrollDiv200').slimScroll({
		height: '200px',
		size:"10px",
	});
$('.slimScrollDiv250').slimScroll({
		height: '250px',
		size:"10px",
	});


 /********** Form Validations Starts   *************/	


/********** Form Validations Ends   *************/


	
 });
 
 /********** Document ready Ends   *************/

 /********** Common Ajax Calls   *************/
 
	function get_cat_subcat(obj,attr_sub_id)
	{
		var cat_id  = $(obj).val();	
        if(cat_id){		
			$.ajax({
				url:base_url+"ajax_inventory/get_cat_subcat",
				data: {"cat_id":cat_id},
				type: "POST",
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var json_arr = JSON.parse(data);	
					$("#"+attr_sub_id).html(json_arr);

				}
			});
		}
	}
	function get_area_shelf(obj,attr_shelf_id)
	{
		var area_id  = $(obj).val();	
        if(area_id){		
			$.ajax({
				url:base_url+"ajax_inventory/get_area_shelf",
				data: {"area_id":area_id},
				type: "POST",
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var json_arr = JSON.parse(data);	
					$("#"+attr_shelf_id).html(json_arr);

				}
			});
		}
	}

	//new added by kaushik  	13/03/2024
	function get_supplier_invoice(obj,p_supp_inv)
	{
		var area_id  = $(obj).val();	
        if(area_id){		
			$.ajax({
				url:base_url+"ajax_inventory/get_supplier_invoice",
				data: {"area_id":area_id},
				type: "POST",
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var json_arr = JSON.parse(data);	
					$("#"+p_supp_inv).html(json_arr);

				}
			});
		}
	}

	function get_supplier_invoice_detail(obj,p_supp_total_price,p_supp_paid_ammount,p_supp_balance_amt)
	{
		var area_id  = $(obj).val();	
        if(area_id){		
			$.ajax({
				url:base_url+"ajax_inventory/get_supplier_invoice_detail",
				data: {"area_id":area_id},
				type: "POST",
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var json_arr = JSON.parse(data);	
					if(data){
						$("#"+p_supp_balance_amt).val(json_arr.supp_lia_bal_amt);
						$("#"+p_supp_paid_ammount).val(json_arr.supp_lia_recvd_amt);
						$("#"+p_supp_total_price).val(json_arr.supp_lia_totalamt);
					   }
					   

				}
			});
		}
	}

	// function get_supplier_invoice_detail(obj,p_supp_balance_amt,p_supp_paid_ammount,p_supp_total_price){
	// 	var ref_id = $(obj).val();
	// 	$.ajax({
	// 			url:base_url+"ajax_inventory/get_supplier_invoice_detail",
	// 			type: "POST",
	// 			datatype: "json",
	// 			data: {"ref_id":ref_id},
	// 			async: true,
	// 			cache: false,
	// 			success: function(data)
	// 			{		
	// 				var data = JSON.parse(data);	
	// 				if(data){
	// 				 $("#p_supp_balance_amt").val(data.supp_lia_bal_amt);
	// 				 $("#p_supp_paid_ammount").val(data.supp_lia_recvd_amt);
	// 				 $("#p_supp_total_price").val(data.supp_lia_totalamt);
	// 				}
		
	// 			}
	// 		});
	// }
	
	function get_shelf_subshelf(obj,attr_area_id,attr_sub_shelf_id)
	{
		var shelf_id  = $(obj).val();	
		var area_id  = $("#"+attr_area_id).val();	
        if(shelf_id && area_id){		
			$.ajax({
				url:base_url+"ajax_inventory/get_shelf_subshelf",
				data: {"area_id":area_id,"shelf_id":shelf_id},
				type: "POST",
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var json_arr = JSON.parse(data);	
					$("#"+attr_sub_shelf_id).html(json_arr);

				}
			});
		}
	} 
  
 
function get_sub_dept_list(obj,attr_sub_dept_id)
	{
		var dept_id  = $(obj).val();		
		$.ajax({
			url:base_url+"ajax/get_sub_dept_list/"+dept_id,
			type: "POST",
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
			{		
				var json_arr = JSON.parse(data);	
		        $("#"+attr_sub_dept_id).html(json_arr);

			}
		});
	}
	
function get_state_districts(obj,attr_dist_id)
	{
		var state_id  = $(obj).val();		
		$.ajax({
			url:base_url+"ajax/get_state_districts/"+state_id,
			type: "POST",
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
			{		
				var json_arr = JSON.parse(data);				
				var html_data = '<option value="">Select District</option>';
				if(json_arr.length>0){
					for(var i =0;i < json_arr.length;i++){
					  var item = json_arr[i];			  
						html_data += '<option value="'+ item.dist_id +'" data-name="'+ item.dist_name+'" >'+ item.dist_name+'</option>';
					} 
				}
					$("#"+attr_dist_id).html(html_data);

			}
		});
	}
function get_district_cities(obj,attr_state_id,attr_city_id)
	{
		var dist_id  = $(obj).val();		
		var state_id  = $("#"+attr_state_id).val();	
       $("#"+attr_city_id).html("");		
		$.ajax({
			url:base_url+"ajax/get_district_cities",
			type: "POST",
			datatype: "json",
			data: {"dist_id":dist_id,"state_id":state_id},
			async: true,
			cache: false,
			success: function(data)
			{		
				var json_arr = JSON.parse(data);				
				var html_data = '<option value="">Select City</option>';
				if(json_arr.length>0){
					for(var i =0;i < json_arr.length;i++){
					  var item = json_arr[i];			  
						html_data += '<option value="'+ item.city_id +'" data-name="'+ item.city_name+'" >'+ item.city_name+'</option>';
					} 
				}
					$("#"+attr_city_id).html(html_data);

			}
		});
	}
	
function get_city_area(obj,attr_state_id,attr_dist_id,attr_area_id)
	{
		var city_id   = $(obj).val();		
		var state_id  = $("#"+attr_state_id).val();	
		var dist_id   = $("#"+attr_dist_id).val();	
		
		$("#"+attr_area_id).html("");		
		$.ajax({
			url:base_url+"ajax/get_city_area",
			type: "POST",
			datatype: "json",
			data: {"dist_id":dist_id,"state_id":state_id,"city_id":city_id},
			async: true,
			cache: false,
			success: function(data)
			{		
				var json_arr = JSON.parse(data);				
				var html_data = '<option value="">Select Area</option>';
				if(json_arr.length>0){
					for(var i =0;i < json_arr.length;i++){
					  var item = json_arr[i];			  
						html_data += '<option value="'+ item.area_id +'" >'+ item.area_name+'</option>';
					} 
				}
					$("#"+attr_area_id).html(html_data);

			}
		});
	}

		
function truncateDate(date) {
  return new Date(date.getFullYear(), date.getMonth(), date.getDate());
}

function timeSince(date) {

  var seconds = Math.floor((new Date() - date) / 1000);

  var interval = seconds / 31536000;

  if (interval > 1) {
    return Math.floor(interval) + " years";
  }
  interval = seconds / 2592000;
  if (interval > 1) {
    return Math.floor(interval) + " months";
  }
  interval = seconds / 86400;
  if (interval > 1) {
    return Math.floor(interval) + " days";
  }
  interval = seconds / 3600;
  if (interval > 1) {
    return Math.floor(interval) + " hours";
  }
  interval = seconds / 60;
  if (interval > 1) {
    return Math.floor(interval) + " minutes";
  }
  return Math.floor(seconds) + " seconds";
}

function truncate(str, n){
  return (str.length > n) ? str.substr(0, n-1) + '&hellip;' : str;
};

$(document).bind("contextmenu",function(e){
  return false;
    });

function show_password(id) {
    $("#" + id).prop("type","text");

   setTimeout(function(){
		 $("#" + id).attr("type", "password"); 
	}, 5000);
}


$(window).load(function() {
    $(".loader").fadeOut();
});
