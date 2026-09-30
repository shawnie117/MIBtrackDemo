$(document).ready(function() {

  	/*   jQuery.validator.addMethod('ckrequired', function(value, element, params) {
        var idname = jQuery(element).attr('id');
        var messageLength = jQuery.trim(CKEDITOR.instances[idname].getData());
        return !params || messageLength.length !== 0;
    }, "Image field is required"); */

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

	jQuery.validator.addMethod("pan", function(value, element, param) {
		return this.optional(element) ||  /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/.test(value);
	}, "Enter Valid PAN No.");
	
	jQuery.validator.addMethod("gst", function(value, element, param) {
		return this.optional(element) ||  /\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}/.test(value);
	}, "Enter Valid GST No.");
	
	jQuery.validator.addMethod("ifsc", function(value, element, param) {
		return this.optional(element) ||  /[A-Z|a-z]{4}[0][a-zA-Z0-9]{6}$/.test(value);
	}, "Enter Valid IFSC Code");

    jQuery.validator.addMethod("greaterThan",
        function(value, element, params) {
            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val()) ||
                (Number(value) > Number($(params).val()));
        }, 'Must be greater than {0}.'
	);
		
	jQuery.validator.addMethod("blankSpace", function(value) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	});
	
	// Registration 
	$('#register-submit-btn').on('click', function(e){
		var mobile_no =  $("#cust_contact").val();
		var email_id =  $("#cust_contact_email").val();
		$("#err_msg").html("");
		$("#success_msg").html("");
		if($('#registration_form').valid()){
			if(mobile_no && email_id){
				var response = get_OTP_for_registration(mobile_no,email_id);
			} 
		}
		e.preventDefault();
	}); 
});

function get_OTP_for_registration(mobile_no,email_id)
{
	$.ajax({
		url:base_url+"login/get_OTP_for_registration",
		type: "POST",
		data: {'mobile_no':mobile_no,"email_id":email_id},
		datatype: "json",
		async: true,
		cache: false,
		success: function(data)
		{		
			data = JSON.parse(data);
			if(data=="Success"){     
				var body = '<div class="otp-modal-field"><input name="otp" id="otp" required type="text" class="form-control rounded-0" placeholder="Enter OTP">';
					body += '<span class="text-danger" id="error_span"></span></div>';
					$("#mymodal .modal-title").html("Validate OTP");
					$("#mymodal .modal-body").html(body);
					$("#mymodal .modal-footer").removeClass("hidden");
					$("#mymodal").modal("show");
					
			}else if (data=="Registered") {
					var body = 'Mobile No. Already Registered !!!';
					$("#mymodal .modal-title").html("Already Registered");
					$("#mymodal .modal-body").html(body);
					$("#mymodal .modal-footer").addClass("hidden");
					$("#mymodal").modal("show");
					setTimeout(function() {
						$("#mymodal").modal("hide");
					}, 2500);
			}else {
					var body = 'Invalid Input';
					$("#mymodal .modal-title").html("Invalid Input");
					$("#mymodal .modal-body").html(body);
					$("#mymodal .modal-footer").addClass("hidden");
					$("#mymodal").modal("show");
					setTimeout(function() {
						$("#mymodal").modal("hide");
					}, 2500);
			}					
		}
	});
}
	
function validate_otp(){
	var otp =  $("#otp").val();
	var $validateButton = $("#mymodal .modal-footer .btn-ok");
	
	if(!otp){
		$("#error_span").html("Please enter OTP");
		return false;
	}

	var $errorSpan = $("#error_span");
	$errorSpan.html("");
	$validateButton.prop("disabled", true).text("Validating...");

	$.ajax({
		url:base_url+"login/validate_reg_OTP",
		type: "POST",
		data: {'otp':otp},
		dataType: "json",
		async: true,
		cache: false,
		success: function(data)
		{
			if(data=="Success"){
				var registrationForm = document.getElementById("registration_form");
				if(registrationForm){
					registrationForm.submit();
				}
			}else {
				$errorSpan.html("Invalid OTP");
			}
		},
		error: function()
		{
			$errorSpan.html("Unable to validate OTP. Please try again.");
		},
		complete: function()
		{
			$validateButton.prop("disabled", false).text("Validate");
		}
	});
}
$(document).bind("contextmenu",function(e){
  	return false;
});
