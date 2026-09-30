var Login = function () {

	var handleLogin = function() {
		$('.login-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
	                username: {
	                    required: true,
						maxlength:100,
	                },
	                password: {
	                    required: true,
						maxlength:100,
	                },
	                remember: {
	                    required: false
	                }
	            },

	            messages: {
	                username: {
	                    required: "Username is required."
	                },
	                password: {
	                    required: "Password is required."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.alert-danger', $('.login-form')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

	        $('.login-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.login-form').validate().form()) {
	                    $('.login-form').submit();
	                }
	                return false;
	            }
	        });
	}

	var handleForgetPassword = function () {
		$('.forget-form1').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                mobile_no1: {
	                    required: true,
	                    digits: true,
	                    maxlength:10,
						minlength:10,
	                }
	            },

	            messages: {
	                mobile_no1: {
	                    required: "Mobile is required."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

	        $('.forget-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.forget-form').validate().form()) {
	                    $('.forget-form').submit();
	                }
	                return false;
	            }
	        });

	        jQuery('#forget-password').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.forget-form').show();
	        });

	        jQuery('#back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.forget-form').hide();
	        });

	}

	var handleRegister = function () {

		        function format(state) {
            if (!state.id) { return state.text; }
            var $state = $(
             '<span><img src="../assets/global/img/flags/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
            );
            
            return $state;
        }

        if (jQuery().select2 && $('#country_list').size() > 0) {
            $("#country_list").select2({
	            placeholder: '<i class="fa fa-map-marker"></i>&nbsp;Select a Country',
	            templateResult: format,
                templateSelection: format,
                width: 'auto', 
	            escapeMarkup: function(m) {
	                return m;
	            }
	        });


	        $('#country_list').change(function() {
	            $('.register-form').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
	        });
    	}
         $('.register-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                
	        cust_name: {
                required: true,
                maxlength: 100,
            },
			cust_comp_name: {
                required: true,
                maxlength: 100,
            },
			cust_contact: {
                required: true,
                maxlength: 10,
                minlength: 10,
				digits:true,
            },
			cust_contact_email: {
                required: true,
                maxlength: 100, 
				email: true,
            },
			cust_contact_person: {
                required: true,
                maxlength: 100, 
            },
			cust_address: {
                required: true,
                maxlength: 500, 
            },
			cust_website: {
                maxlength: 100, 
            },
			cust_panno: {
				required: true,
				pan: true,
                maxlength: 10, 
            },
			cust_id_num: {
				required: true,
                maxlength: 50, 
            },
			cust_pan_img: {				 
				  required: true,
                   accept: "image/jpeg,image/png,image/jpg",
				   filesize_max:1000000, // 1 MB
				   filesize_min:10000, // 1 KB
   				}, 
			cust_id_img: {				 
				  required: true,
                   accept: "image/jpeg,image/png,image/jpg",
				   filesize_max:1000000, // 1 MB
				   filesize_min:10000, // 1 KB
   				}, 
	            },

	            messages: { // custom messages for radio buttons and checkboxes
	                tnc: {
	                    required: "Please accept TNC first."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
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
				}else { // This is the default behavior of the script for all fields
				error.insertAfter(element.closest('.input-icon'));
				}
			 },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

			$('.register-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.register-form').validate().form()) {
	                    $('.register-form').submit();
	                }
	                return false;
	            }
	        });

	        jQuery('#register-btn').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.register-form').show();
	        });

	        jQuery('#register-back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.register-form').hide();
	        });
	}
    
    return {
        //main function to initiate the module
        init: function () {
        	
            handleLogin();
            handleForgetPassword();
            handleRegister();    

            // init background slide images
		    $.backstretch([
		        base_url+"assets/admin_theme/pages/media/bg/bg6.jpg",
		        base_url+"assets/admin_theme/pages/media/bg/bg6.jpg",
		        base_url+"assets/admin_theme/pages/media/bg/bg6.jpg",
		        base_url+"assets/admin_theme/pages/media/bg/bg6.jpg"
		        ], {
		          fade: 1000,
		          duration: 8000
		    	}
        	);
        }
    };

}();

jQuery(document).ready(function() {
    Login.init();
});
