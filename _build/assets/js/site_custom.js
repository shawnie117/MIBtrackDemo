$(document).ready(function() {
	
jQuery.validator.addMethod("email", function(value, element, param) {
        return this.optional(element) || /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
    }, "Enter Valid Email Id");
	
jQuery.validator.addMethod("pan", function(value, element, param) {
        return this.optional(element) ||  /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/.test(value);
    }, "Enter Valid PAN No.");
	
	
	jQuery.validator.addMethod("dimention", function (value, element, param) {
	var width  = $(element).data('imageWidth');
	var height = $(element).data('imageHeight');
	if(this.optional(element) ||( width == param[0] && height == param[1])){
	return true;
	}else{
	return false;
	}
	}, 'Invalid Image');

jQuery.validator.addMethod("pan", function(value, element, param) {
        return this.optional(element) ||  /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/.test(value);
    }, "Enter Valid PAN No.");
	
jQuery.validator.addMethod("gst", function(value, element, param) {
        return this.optional(element) ||  /\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}/.test(value);
    }, "Enter Valid GST No.");
	
jQuery.validator.addMethod("ifsc", function(value, element, param) {
        return this.optional(element) ||  /[A-Z|a-z]{4}[0][a-zA-Z0-9]{6}$/.test(value);
    }, "Enter Valid IFSC Code");
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
	
$('input[name="p_hdoption"]').on('click', function (event) {
             if(this.value=="Yes"){
				 $('#div_hdcharges').removeClass("hidden");
				 $('#div_thirdpartyhdoptn').addClass("hidden");
				 $('#div_couriervendorid').addClass("hidden");
			 } else if(this.value=="No"){
				  $('#div_hdcharges').addClass("hidden");
				  $('#div_couriervendorid').addClass("hidden");
				  $('#div_thirdpartyhdoptn').removeClass("hidden");
			 }
        });
		$('input[name="p_thirdpartyhdoptn"]').on('click', function (event) {
             if(this.value=="Yes"){
				 $('#div_hdcharges').addClass("hidden");
				 $('#div_couriervendor_details').html("");
				 $('#div_thirdpartyhdoptn').removeClass("hidden");
				 $('#div_couriervendorid').removeClass("hidden");
			 } else if(this.value=="No"){
				  $('#div_couriervendor_details').html("");
				  $('#div_hdcharges').addClass("hidden");
				  $('#div_couriervendorid').addClass("hidden");
				  $('#div_thirdpartyhdoptn').removeClass("hidden");
			 }
        });
		
	$('input[name="p_cancel_avl"]').on('click', function (event) {
             if(this.value=="Yes"){
				 $('#div_cancellation1').removeClass("hidden");				
				 $('#div_cancellation2').removeClass("hidden");				
				 $('#div_cancellation3').removeClass("hidden");				
			 } else if(this.value=="No"){
				  $('#div_cancellation1').addClass("hidden");
				  $('#div_cancellation2').addClass("hidden");
				  $('#div_cancellation3').addClass("hidden");
				
			 }
        });
		
		$('input[name="p_return_avl"]').on('click', function (event) {
             if(this.value=="Yes"){
				 $('#div_return1').removeClass("hidden");
				 $('#div_return2').removeClass("hidden");
				 $('#div_return3').removeClass("hidden");
			 } else if(this.value=="No"){
				  $('#div_return1').addClass("hidden");
				  $('#div_return2').addClass("hidden");
				  $('#div_return3').addClass("hidden");
				
			 }
        });
		
		$('input[name="p_gst_option"]').on('click', function (event) {
			if(this.value=="Yes"){
				 $('#div_gst_yes').removeClass("hidden");
				// $('#div_gst_no').addClass("hidden");
				
			 } else if(this.value=="No"){
				  get_gst_details("Yes");
				  $('#div_gst_yes').addClass("hidden");
				 // $('#div_gst_no').removeClass("hidden");
				
				
			 }
        });
		
		// Login form to submit on enter
			
		$('#login_form').on('keypress', function(e) {
		  var keyCode = e.keyCode || e.which;
		  if (keyCode === 13) { 
		   if($('#login_form').valid()){
			var mobile_no =  $("#mobile_no").val();
			getOTPforRegistered(mobile_no);	
		    }
			e.preventDefault();
			return false;
		  }
		});
		
		$('input[name="p_cm_pp_id"]').on('click', function (event) {
				$('#p_cm_pp_name').val($(this).attr("data-color"));	
				$('#p_cm_ps_id').val($(this).attr("data-id"));	
        });
		
		$('.shop_ratings').on('click', function (event) {
			var rating = $(this).attr("data-value");
			$("#shop_ratings").val(rating);
        });
		
		$('.product_ratings').on('click', function (event) {
			var rating = $(this).attr("data-value");
			var id = $(this).attr("data-imid");
			$("#product_ratings_"+id).val(rating);
        });
				
		$('#terms_n_condition').change(function() {
        if($(this).is(":checked")) {
          get_terms_condition("Yes");
			}
       });
	
		
		$('#cancel_order').change(function() {
			if(this.checked) {
				$('#div_cancel_order').removeClass("hidden");
			} else  {
			   $('#div_cancel_order').addClass("hidden");
		    }
		});
		
		$('#return_order').change(function() {
			if(this.checked) {
				$('#div_return_order').removeClass("hidden");
			} else  {
			   $('#div_return_order').addClass("hidden");
		    }
		});
	
	
 /********** Form Validations Starts   *************/	

// Shop 



$('#p_pancard_img').change(function() {
            $('#p_pancard_img').removeData('imageWidth');
            $('#p_pancard_img').removeData('imageHeight');
            var file = this.files[0];
            var tmpImg = new Image();
            tmpImg.src=window.URL.createObjectURL( file ); 
            tmpImg.onload = function() {
                width = tmpImg.naturalWidth,
                height = tmpImg.naturalHeight;
                $('#p_pancard_img').data('imageWidth', width);
                $('#p_pancard_img').data('imageHeight', height);
            }
        });
		
		
		
		$('#p_image').change(function() {
            $('#p_image').removeData('imageWidth');
            $('#p_image').removeData('imageHeight');
            var file = this.files[0];
            var tmpImg = new Image();
            tmpImg.src=window.URL.createObjectURL( file ); 
            tmpImg.onload = function() {
                width = tmpImg.naturalWidth,
                height = tmpImg.naturalHeight;
                $('#p_image').data('imageWidth', width);
                $('#p_image').data('imageHeight', height);
            }
        });
	
	 $("#register_shop_form").validate({
        rules: {
            required: {
                required: true
            },
            p_name: {
                required: true,
				minlength: 2,
				maxlength: 100,
				 },
			p_details: {
                required: true,
				minlength: 2,
				maxlength: 100,
				 },
			p_emailid: {
                required: true,
				email:true,
				 },
			p_phone: {
                required: true,                
                digits: true,
                maxlength: 10,
                minlength: 10,
            },
            p_address: {
                required: true,
				minlength: 2,
				maxlength: 200,
            },
            p_pincode: {
                required: true,                
                minlength: 6,
				digits: true,
				maxlength: 6,
            },
            p_stateid: {
                required: true,                
            },
            p_distid: {
                required: true,                
            },
            p_cityid: {
                required: true,                
            },
            p_sdm_account_name: {
                required: true,                
            },  
			p_sdm_bank_name: {
                required: true,                
            },
            p_sdm_bank_accno: {
                required: true, 
				digits: true,				
            },      
			p_sdm_bank_ifsc_code: {
                 required: true,
				 remote : { url : base_url + "customer/checkIFSCExists", type :"post"},
				 
            },
			p_gstno: {
                required: true,                
            },
			p_gst_option: {
                required: true,                
            },
			p_pancard_no: {
                required: true,                
                pan: true,                
            },
            p_shoptypeid: {
                required: true,                
            }, 
			p_hdoption: {
                required: true,                
            },
			p_fssai: {
                required: true,    
				digits: true,					
            },
			p_hdcharges: {
                required: true, 
				number: true,				
            },
			p_thirdpartyhdoptn: {
                required: true,                
            },
			p_couriervendorid: {
                required: true,                
            },
			p_lattitude: {
                required: true,                
            },
			p_longitude: {
                required: true,                
            },
			owner_name: {
                required: true,                
            },
			owner_mob: {
                required: true,  
				maxlength: 10,
                minlength: 10,				
            },
			p_cancel_avl: {
                required: true,                
            },
			p_cancel_days: {
                required: true, 
				digits: true,				
            },
			p_cancel_charge_percentage: {
                required: true, 
				number: true,				
            },
			p_cancel_desc: {
                required: true,
				minlength: 2,
				maxlength: 2000,
				 },
			p_return_avl: {
                required: true,                
            },
			p_image: {
                   required: true,
				   accept: "image/jpeg,image/png,image/gif",
				   dimention:[480, 480], 
				   filesize_max:1000000, // 1 MB
   				}, 
    		p_pancard_img: {
                   required: true,
				   accept: "image/jpeg,image/png,image/gif",
				   dimention:[350, 250], 
				   filesize_max:1000000, // 1 MB
   				}, 
			terms_n_condition: {
                required: true,                
            },
			p_return_days: {
                required: true, 
				digits: true,				
            },
			p_return_charge_percentage: {
                required: true, 
				number: true,			
            },
			p_return_desc: {
                required: true,
				minlength: 2,
				maxlength: 2000,
				 },
        },
		  messages: {
             p_sdm_bank_ifsc_code: { remote: 'Invalid IFSC Code' },
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
			if (element.is(":radio")) {
			 error.appendTo(element.parent().siblings('.radio_err'));
			} else if (element.is(":checkbox")) {
			   error.appendTo(element.parent().siblings('.checkbox_err'));
			} else {
				error.insertAfter(element);
			}
		},
		success: function(error) { 
        error.removeClass("error");  // <- no, no, no!!
		},
		

    });
	
	// Login Form
	 $("#login_form").validate({
        rules: {
            required: {
                required: true
            },
            mobile_no: {
                required: true,
				minlength: 10,
				maxlength: 10,
				 },
		
        },
       
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        }
    });
	
	// Signup Form
	 $("#signup_form").validate({
        rules: {
            required: {
                required: true
            },
            p_custm_name: {
                required: true,
				minlength: 2,
				maxlength: 100,
				 },
			p_custm_contact: {
                required: true,
				minlength: 10,
				maxlength: 10,
				 },	
            p_custm_email: {
               	email: true,
				maxlength: 100,
				 },							 
			p_coa_pincode: {
                required: true,
				minlength: 6,
				maxlength: 6,
				 },			
			p_coa_address: {
                required: true,
				minlength: 3,
				maxlength: 200,
				 },	
			p_coa_area: {
                required: true,
				minlength: 3,
				maxlength: 100,
				 },		
			p_coa_landmark: {
                required: true,
				minlength: 3,
				maxlength: 100,
				 },			
			p_coa_town: {
                required: true,
				minlength: 3,
				maxlength: 100,
				 },		
			p_coa_state: {
                required: true,
				},			
        },
       
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        }
    });
	
	// Update Customer Form
	 $("#update_customer_details").validate({
        rules: {
            required: {
                required: true
            },
            p_custm_name: {
                required: true,
				minlength: 2,
				maxlength: 100,
				 },
			p_custm_whatsappno: {
                required: true,
				minlength: 10,
				maxlength: 10,
				 },			
        },
       
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        }
    });
   // CheckOut Form
	 $("#checkout_frm").validate({
        rules: {
            required: {
                required: true
            },
            payment_option: {
                required: true,
				},
			delivery_time: {
                required: true,
			},			
        },
       
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        }
    });
	
	 // Place Order  Form
	 $("#place_order_frm").validate({
        rules: {
            required: {
                required: true
            },
            payment_option: {
                required: true,
				},
		},
       
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        }
    });
	
	
	// Address Form
	 $("#new_add_frm").validate({
        rules: {
            required: {
                required: true
            },
           p_custm_contact: {
                required: true,
				minlength: 10,
				maxlength: 10,
				 },		
			p_custm_email: {
               	email: true,
				maxlength: 100,
				 },			
			p_coa_pincode: {
                required: true,
				minlength: 6,
				maxlength: 6,
				 },			
			p_coa_address: {
                required: true,
				minlength: 3,
				maxlength: 200,
				 },	
			p_coa_area: {
                required: true,
				minlength: 3,
				maxlength: 100,
				 },		
			p_coa_landmark: {
                required: true,
				minlength: 3,
				maxlength: 100,
				 },			
			p_coa_town: {
                required: true,
				minlength: 3,
				maxlength: 100,
				 },		
			p_coa_state: {
                required: true,
			 },			
        },
       
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        }
    });
	
	// Contact Us Form
	 $("#contact_us_frm").validate({
        rules: {
            required: {
                required: true
            },
           p_name: {
                required: true,
				maxlength: 100,
				 },
		    p_email: {
               	email: true,
				maxlength: 100,
				 },					 
		    p_contact: {
                required: true,
				minlength: 10,
				maxlength: 10,
				 },					
			p_subject: {
                required: true,
				maxlength: 100,
				 },			
			p_message: {
                required: true,
				minlength: 3,
				maxlength: 200,
				 },	
					
        },
       
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        }
    });
	
	// Add To Cart
	 $("#add_to_cart_frm").validate({
        rules: {
            required: {
                required: true
            },
            quantity: {
                required: true,
			},
			/* p_cm_pp_name: {
                required: true,                
            },
            p_cm_pr_id: {
                required: true,                
            },
			p_cm_ps_id: {
                required: true,                
            }, */
			p_cm_pp_id: {
                required: true,                
            },
          	
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
			if (element.is(":radio")) {
			error.prependTo(element.parent());
			} else { // This is the default behavior of the script for all fields
			error.insertAfter(element);
			}
		},
		success: function(error) { 
        error.removeClass("error");  // <- no, no, no!!
		},
		

    });
	
	// Order Cancel Form
	 $("#frm_cancel_order").validate({
        rules: {
            required: {
                required: true
            },
            cancel_order_reason: {
                required: true,
				minlength: 5,
				maxlength: 500,
				 },
		
        },
       
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        }
    });
	
/********** Form Validations Ends   *************/
 
$('#add_to_cart_btn').on('click', function(e){
	    //  var validate = $('#register_shop_form').validate();
	     if($('#add_to_cart_frm').valid()){
			var formdata = $('#add_to_cart_frm').serializeArray();
			formdata.push({name: 'p_cm_type', value: "Add"});
			add_to_cart(formdata);
			
		 }
			e.preventDefault();
});

$('#register_shop').on('click', function(e){
	     	var p_sdm_bank_ifsc_code =  $("#p_sdm_bank_ifsc_code").val();
			getIFSC(p_sdm_bank_ifsc_code);
			if($('#register_shop_form').valid()){			
			var mobile_no =  $("#p_phone").val();
            getOTP(mobile_no);
			
		 }
			e.preventDefault();
});


$('#login_btn').on('click', function(e){
	 
	     if($('#login_form').valid()){
			var mobile_no =  $("#mobile_no").val();
			getOTPforRegistered(mobile_no);	
			}
			e.preventDefault();
});

$('#place_order_btn').on('click', function(e){

         var deliveryslecten =  $("#p_com_deliveryslecten").val();
		 if(deliveryslecten=="HD")
		 {
			var pincode =  $("input[name='payment_option']:checked").attr("data-pincode");
			 if(pincode=="")
			 {
				 var p_coa_address = $("#p_coa_address").val();
				// var p_coa_area = $("#p_coa_area").val();
				 var p_coa_landmark = $("#p_coa_landmark").val();
				 var p_coa_town = $("#p_coa_town").val();
				 var p_coa_state = $("#p_coa_state").val();
				 var p_coa_pincode = $("#p_coa_pincode").val();
				 
				 $("#err_coa_pincode").html("");
				 $("#err_coa_address").html("");
				 $("#err_coa_landmark").html("");
				 $("#err_coa_town").html("");
				 $("#err_coa_state").html("");
				/// $("#err_coa_area").html("");
				 var err_msg = "";
				 if(p_coa_pincode=="")
				 {
					 $("#err_coa_pincode").html("Please Enter Pincode");
					 err_msg = "true";
				 }
				 if(p_coa_address=="")
				 {
					 $("#err_coa_address").html("Please Enter Address");
					 err_msg = "true";
				 }  
				 /* if(p_coa_area=="")
				 {
					 $("#err_coa_area").html("Please Enter Area");
					 err_msg = "true";
				 }  */
				 if(p_coa_landmark=="")
				 {
					 $("#err_coa_landmark").html("Please Enter Landmark");
					 err_msg = "true";
				 }
				 if(p_coa_town=="")
				 {
					 $("#err_coa_town").html("Please Enter Town");
					 err_msg = "true";
				 } 
				 if(p_coa_state=="")
				 {
					 $("#err_coa_state").html("Please Enter State");
					 err_msg = "true";
				 }
				 if(err_msg== ""){
					 pincode = p_coa_pincode;
				 }
			 } else 
			 {
				 var cad_address =  $("input[name='payment_option']:checked").attr("data-cad_address");
				// var cad_area =  $("input[name='payment_option']:checked").attr("data-cad_area");
				 var cad_state =  $("input[name='payment_option']:checked").attr("data-cad_state");
				 var cad_landmark =  $("input[name='payment_option']:checked").attr("data-cad_landmark");
				 var coa_town =  $("input[name='payment_option']:checked").attr("data-cad_town");
				 var cad_id =  $("input[name='payment_option']:checked").attr("data-cad_id");
				 $("#p_coa_address").val(cad_address);
				// $("#p_coa_area").val(cad_area);
				 $("#p_coa_landmark").val(cad_landmark);
				 $("#p_coa_town").val(coa_town);
				 $("#p_coa_state").val(cad_state);
				 $("#p_coa_pincode").val(pincode);
				 $("#cad_id").val(cad_id);
			 }
				checkpincode(pincode);
		 }else if(deliveryslecten=="Pickup"){
			 var p_com_shopid =  $("#p_com_shopid").val();
			 var p_com_pickuptime =  $("#p_com_pickuptime").val();
			 if(p_com_shopid && p_com_pickuptime){
				$('#place_order_frm').submit();
				
			 }
				e.preventDefault();
			}

			e.preventDefault();
});


$('#signup_btn').on('click', function(e){
	 
	     if($('#signup_form').valid()){
			var mobile_no =  $("#p_custm_contact").val();
            getOTPforUnregistered(mobile_no);			
		 }
			e.preventDefault();
});

$('#btn_deactivate').on('click', function(e){
	 
	    var body = '<form action="'+base_url+'customer/deactivate_account" method="post" id="deactivate_account_frm"><div class="form-group"><label>Enter Reason to deactivate:</label><textarea class="form-control" id="reason" name="reason"></textarea>';
		body += '</div><label><span class="text-danger" id="error_span"> <span></label>';
		
		body += '<br/><span class="btn btn-fill-out btn-block text-uppercase rounded-0" title="Subscribe" type="submit" onclick="deactivate_account();">Submit</span>';
		
		$("#mymodal .modal-title").html("Deactivate Account");
		$("#mymodal .modal-body").html(body);
		$("#mymodal").modal("show");
		e.preventDefault();
});
$('.crt_plus').on('click', function() {
		if ($(this).prev().val()) {
			 var qnty = $(this).prev().val();
			  var cd_id = $(this).attr("data-cd_id");
			  update_cart(cd_id,qnty);
			
		}
	});
	$('.crt_minus').on('click', function() {
		if ($(this).next().val() > 1 || $(this).next().val() == 1) {
			  var qnty = $(this).next().val();
			  var cd_id = $(this).attr("data-cd_id");
			  update_cart(cd_id,qnty);
		}
		
	});

 $('.smart-file').bootstrapFileField({
            maxNumFiles: 8,
            fileTypes: 'image/jpeg,image/png,image/jpg',  
			minNumFiles:1,
            maxFileSize: 4000000 // 8Mb in bytes
        });
		
		
 });
 

 
 /********** Document ready Ends   *************/

 /********** Common Ajax Calls   *************/
 function update_cart(cd_id,qnty)
 {
  	if(qnty && cd_id){
			$.ajax({
				url:base_url+"customer/update_cart",
				type: "POST",
				data: {'cd_id':cd_id,'qnty':qnty},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var data = JSON.parse(data);
					/* if(data=="Failed")
					{
						window.location.replace(base_url+"cart");
					} */
					window.location.replace(base_url+"cart");
				}
			});
		}
 }
 
 function update_cart_item(obj)
 {
  	 var qnty = $(obj).val();
	 var cd_id = $(obj).attr("data-cd_id");
	update_cart(cd_id,qnty);
 }
 function checkpincode(pincode)
	{  var shop_id =  $('#p_com_shopid').val();
	   	if(pincode && shop_id){
			$.ajax({
				url:base_url+"customer/checkPincode",
				type: "POST",
				data: {'pincode':pincode,'shop_id':shop_id},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{	
					var data = JSON.parse(data);
					if(data == "NotDeliverable"){
						var body= '<label><span class="text-danger" id="error_span"> We are not providing delivery to this Pincode Location . Please Select another Location or Add Address to your account.<span></label>';	
						$("#mymodal .modal-title").html("Delivery Not Available");
						$("#mymodal .modal-body").html(body);
						$("#mymodal").modal("show");
					} else {
						$('#place_order_frm').submit();
					}
				}
			});
		}
	} 
	function getIFSC(p_sdm_bank_ifsc_code)
	{ 
	   $('#ifsc_code').html("");
		if(p_sdm_bank_ifsc_code){
			$.ajax({
				url:base_url+"customer/getIFSC",
				type: "POST",
				data: {'p_sdm_bank_ifsc_code':p_sdm_bank_ifsc_code},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var data = JSON.parse(data);
					$("#ifsc_code").html(data.BRANCH);
				}
			});
		}
	} 
	
	function getOTP(mobile_no)
	{ 
		if(mobile_no){
			$.ajax({
				url:base_url+"customer/getOTP",
				type: "POST",
				data: {'mobile_no':mobile_no},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var data = JSON.parse(data);
					if(data=="Registered")
					{
						var body= '<label><span class="text-danger" id="error_span"> Mobile No. is Already Registered<span></label>';	
						$("#mymodal .modal-title").html("Mobile No. Exists");
						$("#mymodal .modal-body").html(body);
						$("#mymodal").modal("show");
					}else {
						var body = '<input name="otp" id="otp" required type="text" class="form-control rounded-0" placeholder="Enter OTP">';
						body += '<label><span class="text-danger" id="error_span"> <span></label>';
						body += '<br/><button class="btn btn-fill-out btn-block text-uppercase rounded-0" title="Subscribe" type="submit" onclick="validate_otp();">Validate</button>';
						$("#mymodal .modal-title").html("Validate OTP");
						$("#mymodal .modal-body").html(body);
						$("#mymodal").modal("show");
						
					}

				}
			});
		}
	}
function validate_otp(){
	 var mobile_no =  $("#p_phone").val();
	 var otp =  $("#otp").val();
     
	 if(mobile_no && otp){
			$.ajax({
				url:base_url+"customer/ValidateOTPDetails",
				type: "POST",
				data: {'mobile_no':mobile_no,'otp':otp},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
				   	var data = JSON.parse(data);
					if(data=="Success"){
						$('#register_shop_form').submit();
						
					}else {
						 $("#error_span").html("Invalid OTP"); return false;
					}

				}
			});
		} 
}
function getOTPforUnregistered(mobile_no)
	{ 
		if(mobile_no){
			$.ajax({
				url:base_url+"customer/getOTPforUnregistered",
				type: "POST",
				data: {'mobile_no':mobile_no},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var data = JSON.parse(data);
					if(data=="Registered")
					{
						var body= '<label><span class="text-danger" id="error_span"> Mobile No. is Already Registered<span></label>';	
						$("#mymodal .modal-title").html("Mobile No. Exists");
						$("#mymodal .modal-body").html(body);
						$("#mymodal").modal("show");
					} else {
						var body = '<input name="otp" id="otp" required type="text" class="form-control rounded-0" placeholder="Enter OTP">';
						body += '<label><span class="text-danger" id="error_span"> <span></label>';
						body += '<br/><button class="btn btn-fill-out btn-block text-uppercase rounded-0" title="Subscribe" type="submit" onclick="validate_unregisteredotp();">Validate</button>';
						$("#mymodal .modal-title").html("Validate OTP");
						$("#mymodal .modal-body").html(body);
						$("#mymodal").modal("show");
						
					}

				}
			});
		}
	}
	function validate_unregisteredotp(){
	 var mobile_no =  $("#p_custm_contact").val();
	 var otp =  $("#otp").val();
     
	 if(mobile_no && otp){
			$.ajax({
				url:base_url+"customer/ValidateOTPDetails",
				type: "POST",
				data: {'mobile_no':mobile_no,'otp':otp},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
				   
					var data = JSON.parse(data);
					if(data=="Success"){
						$('#signup_form').submit();
						
					}else {
						 $("#error_span").html("Invalid OTP"); return false;
					}

				}
			});
		} 
}
	
	function getOTPforRegistered(mobile_no)
	{ 
		if(mobile_no){
			$.ajax({
				url:base_url+"customer/getOTPforRegistered",
				type: "POST",
				data: {'mobile_no':mobile_no},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var data = JSON.parse(data);
					if(data=="NotRegistered")
					{
						var body= '<label><span class="text-danger" id="error_span"> Mobile No. is Not Registered<span></label>';	
						$("#mymodal .modal-title").html("Mobile No. Exists");
						$("#mymodal .modal-body").html(body);
						$("#mymodal").modal("show");
					} else {
						var body = '<input name="otp" id="otp" required type="text" class="form-control rounded-0" placeholder="Enter OTP">';
						body += '<label><span class="text-danger" id="error_span"> <span></label>';
						body += '<br/><button class="btn btn-fill-out btn-block text-uppercase rounded-0" title="Subscribe" type="submit" onclick="validate_registeredotp();">Validate</button>';
						$("#mymodal .modal-title").html("Validate OTP");
						$("#mymodal .modal-body").html(body);
						$("#mymodal").modal("show");
						
					}

				}
			});
		}
	}
	
function validate_registeredotp(){
	 var mobile_no =  $("#mobile_no").val();
	 var otp =  $("#otp").val();
     
	 if(mobile_no && otp){
			$.ajax({
				url:base_url+"customer/ValidateOTPDetails",
				type: "POST",
				data: {'mobile_no':mobile_no,'otp':otp},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
				   	var data = JSON.parse(data);
					if(data=="Success"){
						$('#login_form').attr('action', base_url+"customer/getlogin").submit();
						
					}else {
						 $("#error_span").html("Invalid OTP"); return false;
					}

				}
			});
		} 
}
function add_to_cart(formdata){
	 if(formdata){
			$.ajax({
				url:base_url+"customer/add_to_cart",
				type: "POST",
				data: formdata,
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{
					//var data = JSON.parse(data);
					if(data=="Success"){
						window.location.replace(base_url+"cart");
						
					}else if (data == "OutofStock") {
						var body= '<label><span class="text-danger" id="error_span">Item is Out of Stock <span></label>';	
						$("#mymodal .modal-title").html("Product Out of Stock");
						$("#mymodal .modal-body").html(body);
						$("#mymodal").modal("show");
					} 
					else if (data == "Failed") {
						var body= '<label><span class="text-danger" id="error_span">Cannot Add Item to Cart . Please try after some time.<span></label>';	
						$("#mymodal .modal-title").html("Failed");
						$("#mymodal .modal-body").html(body);
						$("#mymodal").modal("show");
					} 
					else if (data == "RemoveAndAdd") {
						var body= '<label><span class="text-danger" id="error_span">Another Shop Items already exist in a cart.Do want to Remove this items?<span></label>';
						body +=  '<span class="btn btn-fill-out rounded-0" title="Subscribe" type="submit" onclick="confirm_cart_removeadd();">Yes</span><span class="btn btn-dark rounded-0" title="Subscribe" type="submit" onclick="reject_cart_removeadd();">No</span>';						
						$("#mymodal .modal-title").html("Item Exists in a Cart");
						$("#mymodal .modal-body").html(body);
						$("#mymodal").modal("show");
					} else if (data == "Redirect") {
						window.location.replace(base_url+"login");
					} 

				}
			});
		} 
}

function reject_cart_removeadd(){
	$("#mymodal").modal("hide");
}
function confirm_cart_removeadd(){
	var formdata = $('#add_to_cart_frm').serializeArray();
			formdata.push({name: 'p_cm_type', value: "RemoveAndAdd"});
			add_to_cart(formdata);
}
function deactivate_account(){
	 var reason =  $("#reason").val();
	 if(reason!=""){
		 
		 $('#deactivate_account_frm').submit();
	
	 } else {
		  $("#error_span").html("Enter Reason to Deactivate"); 
	 }
}
function getDistrictStateIdDetails(obj,attr_dist_id)
	{
		var state_id  = $(obj).val();		
		$.ajax({
			url:base_url+"customer/getDistrictStateIdDetails",
			type: "POST",
			data: {'state_id':state_id},
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
						html_data += '<option value="'+ item.dist_id +'">'+ item.dist_name+'</option>';
					} 
				}
					$("#"+attr_dist_id).html(html_data);

			}
		});
	}
	
function getCityDistrictIdDetails(obj,attr_state_id,attr_city_id)
	{
		var dist_id  = $(obj).val();		
		var state_id  = $("#"+attr_state_id).val();	
		$("#"+attr_city_id).html("");		
		$.ajax({
			url:base_url+"customer/getCityDistrictIdDetails",
			type: "POST",
			data: {'state_id':state_id,'dist_id':dist_id},
			datatype: "json",
			async: true,
			cache: false,
			success: function(data)
			{		
				var json_arr = JSON.parse(data);			
				var html_data = '<option value="">Select City</option>';
				if(json_arr.length>0){
					for(var i =0;i < json_arr.length;i++){
					  var item = json_arr[i];			  
						html_data += '<option value="'+ item.city_id +'">'+ item.city_name+'</option>';
					} 
				}
					$("#"+attr_city_id).html(html_data);

			}
		});
	}

function getCourierVendorDetails(obj,attr_id)
	{
		var cv_id  = $(obj).val();
		$("#"+attr_id).html("");
		if(cv_id){		
			$.ajax({
				url:base_url+"customer/getCourierVendorChargesDetails",
				type: "POST",
				data: {'cv_id':cv_id},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var json_arr = JSON.parse(data);			
					var html_data = '<table class="table table-striped table-bordered table-advance table-hover"><thead><tr><th> Sr.No. </th><th>Quantity / Type </th>	<th> Charges  </th></tr></thead><tbody>';
					if(json_arr.length>0){
					for(var i =0;i < json_arr.length;i++){
						  var item = json_arr[i];			  
							html_data += '<tr><td>'+ parseInt(i+1) +'</td><td>'+ item.du_id+' '+ item.du_name+'</td><td>'+ item.dc_charges+'</td></tr>';
						} 
					}
						html_data += '</tbody><table>'
						$("#"+attr_id).html(html_data);

				}
			});
		}
	}
	
	function add_fssai_number(obj)
	{
		$('#div_fssai').addClass("hidden");
		var cv_id  = $(obj).val();
		var fssai = $( "#p_shoptypeid option:selected" ).attr("data-fssai");
		if(fssai=="Yes")
		{
			 $('#div_fssai').removeClass("hidden");
		}
	}

function get_terms_condition(tc)
 {
  	if(tc){
			$.ajax({
				url:base_url+"customer/get_terms_condition",
				type: "POST",
				data: {},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var data = JSON.parse(data);

					var body = data.tc_desc;
						body +=  '<br/><br/><span class="btn btn-fill-out rounded-0" title="Accept" type="submit" onclick="accept_tc(1);">Accept</span><span class="btn btn-dark rounded-0" title="Reject" type="submit" onclick="accept_tc();">Reject</span>';						
						$("#mymodal .modal-title").html(data.tc_header);
						$("#mymodal .modal-body").html(body);
						$("#mymodal").modal("show");
				}
			});
		}
 }
 function accept_tc(tc)
 {
	 if(tc=="1")
	 {
		 $('#terms_n_condition').prop('checked', true);
	 }else{
		  $('#terms_n_condition').prop('checked', false);
	 }
	 $("#mymodal").modal("hide");
 }
 function get_gst_details(tc)
 {
  	if(tc){
			$.ajax({
				url:base_url+"customer/get_gst_details",
				type: "POST",
				data: {},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var data = JSON.parse(data);

					var body = data.tc_desc;
						body +=  '<br/><br/><span class="btn btn-fill-out rounded-0" title="Accept" type="submit" onclick="accept_gst(1);">Accept</span><span class="btn btn-dark rounded-0" title="Reject" type="submit" onclick="accept_gst();">Reject</span>';						
						$("#mymodal .modal-title").html(data.tc_header);
						$("#mymodal .modal-body").html(body);
						$("#mymodal").modal("show");
				}
			});
		}
 }
 function get_state_dist_details(obj)
 {
	  $("#p_cityid").html("");
	  var pincode = $(obj).val();
      if(pincode.length==6){
			$.ajax({
				url:base_url+"customer/get_pincode_details",
				type: "POST",
				data: {'pincode':pincode},
				datatype: "json",
				async: true,
				cache: false,
				success: function(data)
				{		
					var data = JSON.parse(data);
					if(data.length>0){
						var data = data[0];
						var dist_id  = data.dist_id;						
						var state_id = data.state_id;
						var dist_name = data.dist_name;
						var state_name  = data.state_name;
						$("#p_stateid").val(state_id);
						$("#p_stateid_lbl").val(state_name);
						
						$("#p_distid").val(dist_id);
						$("#p_distid_lbl").val(dist_name);
						
						if(data.cityList.length>0){
						var	cityList  = data.cityList;
						var html_data = '<option value="">Select City</option>';
						
						for(var i =0;i < cityList.length;i++){
						  var item = cityList[i];			  
							html_data += '<option value="'+ item.city_id +'">'+ item.city_name+'</option>';
							} 
						} 
						$("#p_cityid").html(html_data);
						
						

					}
				}
			});
	  }

 }
 function accept_gst(tc)
 {
	 if(tc=="1")
	 {
		 $('#p_gst_option_no').prop('checked', true);
	 }else{
		  $('#p_gst_option_no').prop('checked', true);
	 }
	 $("#mymodal").modal("hide");
 }
$(document).bind("contextmenu",function(e){
  return false;
    });