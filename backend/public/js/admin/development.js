var adminPanelUrl = $("#admin_url").val();
var ajax_check = false;

var somethingWrongMessage       = 'Something went wrong, please try again later';
var confirmChangeStatusMessage  = 'Are you sure, you want to change the status?';

var confirmActiveStatusMessage  = 'Are you sure, you want to active?';
var confirmInactiveStatusMessage= 'Are you sure, you want to inactive?';
var confirmDeleteMessage        = 'Are you sure, you want to delete?';

var confirmActiveSelectedMessage = 'Are you sure, you want to active selected records?';
var confirmInactiveSelectedMessage = 'Are you sure, you want to inactive selected records?';
var confirmDeleteSelectedMessage = 'Are you sure, you want to delete selected records?';

var confirmDefaultMessage       = 'Are you sure, you want to set it default?';

var btnYes = 'Yes';
var btnNo  = 'No';
var btnOk  = 'Ok';
var btnConfirmYesColor = '#28a745';
var btnCancelNoColor   = '#6c757d';
var successMessage = 'Success';
var errorMessage   = 'Error';
var warningMessage = 'Warning';
var infoMessage    = 'Info';

$.validator.addMethod("valid_email", function(value, element) {
    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
        return true;
    } else {
        return false;
    }
}, "Please enter a valid email");

//Phone number eg. (+91)9876543210
$.validator.addMethod("valid_number", function(value, element) {
    if (/^(?=.*[0-9])[- +()0-9]+$/.test(value)) {
        return true;
    } else {
        return false;
    }
}, "Please enter a valid phone number");

//minimum 8 digit,small+capital letter,number,specialcharacter
$.validator.addMethod("valid_password", function(value, element) {
    if (/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/.test(value)) {
        return true;
    } else {
        return false;
    }
});

//Alphabet or number
$.validator.addMethod("valid_coupon_code", function(value, element) {
    if (/^[a-zA-Z0-9]+$/.test(value)) {
        return true;
    } else {
        return false;
    }
});

//Positive number
$.validator.addMethod("valid_positive_number", function(value, element) {
    if (/^[0-9]+$/.test(value)) {
        return true;
    } else {
        return false;
    }
});

//Integer and decimal
$.validator.addMethod("valid_amount", function(value, element) {
    if (/^[0-9]\d*(\.\d+)?$/.test(value)) {
        return true;
    } else {
        return false;
    }
});

//Youtube url checking
$.validator.addMethod("valid_youtube_url", function(value, element) {
    if (/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/.test(value)) {
        return true;
    } else {
        return false;
    }
});

$.validator.addMethod("ckrequired", function (value, element) {  
    var idname = $(element).attr('id');  
    var editor = CKEDITOR.instances[idname];  
    var ckValue = GetTextFromHtml(editor.getData()).replace(/<[^>]*>/gi, '').trim();  
    if (ckValue.length === 0) {  
        //if empty or trimmed value then remove extra spacing to current control  
        $(element).val(ckValue);
    } else {  
        //If not empty then leave the value as it is  
        $(element).val(editor.getData());  
    }  
    return $(element).val().length > 0;  
}, "Please enter description");
  
function GetTextFromHtml(html) {  
    var dv = document.createElement("DIV");
    dv.innerHTML = html;  
    return dv.textContent || dv.innerText || "";  
}

$(document).ready(function() {
    setTimeout(function() {
        $('.notification').slideUp(1000).delay(3000);
    }, 3000);

    // Start :: Admin Login Form //
    $("#adminLoginForm").validate({
        rules: {
            email: {
                required: true,
                valid_email: true
            },
            password: {
                required: true
            }
        },
        messages: {
            email: {
                required: "Please enter email",
                valid_email: "Please enter valid email"
            },
            password: {
                required: "Please enter password",
            },
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });
    // End :: Admin Login Form //

    // Start :: Forgot password Form //
    $("#adminForgotPasswordForm").validate({
        rules: {
            email: {
                required: true,
                valid_email: true
            }
        },
        messages: {
            email: {
                required: "Please enter email",
                valid_email: "Please enter valid email"
            }
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });
    // End :: Forgot password Form //

    // Start :: Reset password Form //
    $("#adminResetPasswordForm").validate({
        rules: {
            password: {
                required: true,
                valid_password: true,
            },
            confirm_password: {
                required: true,
                valid_password: true,
                equalTo: "#password"
            },
        },
        messages: {
            password: {
                required: "Please enter password",
                valid_password: "Min. 8, alphanumeric, special character & a capital letter"
            },
            confirm_password: {
                required: "Please enter confirm password",
                valid_password: "Min. 8, alphanumeric, special character & a capital letter",
                equalTo: "Password should be same",
            },
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });
    // End :: Reset password Form //

    // Start :: Profile Form //
    $("#updateProfileForm").validate({
        rules: {
            full_name: {
                required: true,
                maxlength: 255
            },
            phone_no: {
                required: true,
            },
        },
        messages: {
            full_name: {
                required: "Please enter full name",
                maxlength: "Full name must not exceed 255 characters"
            },
            phone_no: {
                required: "Please enter phone number",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });
    // End :: Profile Form //

    // Start :: Admin Password Form //
    $("#updateAdminPassword").validate({
        rules: {
            current_password: {
                required: true,
            },
            password: {
                required: true,
                valid_password: true,
            },
            confirm_password: {
                required: true,
                valid_password: true,
                equalTo: "#password"
            }
        },
        messages: {
            current_password: {
                required: "Please enter current password",
            },
            password: {
                required: "Please enter new password",
                valid_password: "Min. 8, alphanumeric and special character"
            },
            confirm_password: {
                required: "Please enter confirm password",
                valid_password: "Min. 8, alphanumeric and special character",
                equalTo: "Password should be same as new password",
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });
    // End :: Admin Password Form //

    // Start :: Sub Admin Form //
    $("#createSubAdminForm").validate({
        rules: {
            first_name: {
                required: true,
                maxlength: 255
            },
            last_name: {
                required: true,
                maxlength: 255
            },
            email: {
                required: true,
                valid_email: true
            },
            'role[]': {
                required: true,
            },
        },
        messages: {
            first_name: {
                required: "Please enter first name",
                maxlength: "First name must not exceed 255 characters"
            },
            last_name: {
                required: "Please enter last name",
                maxlength: "Last name must not exceed 255 characters"
            },
            email: {
                required: "Please enter email",
                valid_email: "Please enter valid email",
            },
            'role[]': {
                required: "Please select role",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });

    $("#updateSubAdminForm").validate({
        rules: {
            first_name: {
                required: true,
                maxlength: 255
            },
            last_name: {
                required: true,
                maxlength: 255
            },
            email: {
                required: true,
                valid_email: true
            },
            'role[]': {
                required: true,
            },
        },
        messages: {
            first_name: {
                required: "Please enter first name",
                maxlength: "First name must not exceed 255 characters"
            },
            last_name: {
                required: "Please enter last name",
                maxlength: "Last name must not exceed 255 characters"
            },
            email: {
                required: "Please enter email",
                valid_email: "Please enter valid email",
            },
            'role[]': {
                required: "Please select role",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });
    // End :: Sub Admin Form //

    // Start :: Role Form //
    $("#createRoleForm").validate({
        rules: {
            name: {
                required: true,
                maxlength: 255
            }
        },
        messages: {
            name: {
                required: "Please enter role name",
                maxlength: "Role name must not exceed 255 characters"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });

    $("#updateRoleForm").validate({
        rules: {
            name: {
                required: true,
                maxlength: 255
            }
        },
        messages: {
            name: {
                required: "Please enter role name",
                maxlength: "Role name must not exceed 255 characters"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });
    // End :: Role Form //

    // Start :: Site Settings Form //
    $("#updateSiteSettingsForm").validate({
        rules: {
            from_email: {
                required: true,
                valid_email: true
            },
            to_email: {
                required: true,
                valid_email: true
            },
            website_title: {
                required: true,
                maxlength: 255
            },
            website_link: {
                required: true,
                maxlength: 255
            },
            footer_text: {
                required: true,
            },
            copyright_text: {
                required: true,
            },
        },
        messages: {
            from_email: {
                required: "Please enter from email",
            },
            to_email: {
                required: "Please enter to email",
            },
            website_title: {
                required: "Please enter website title",
                maxlength: "Website title must not exceed 255 characters"
            },
            website_link: {
                required: "Please enter website link",
                maxlength: "Website link must not exceed 255 characters"
            },
            footer_text: {
                required: "Please enter footer text",
            },
            copyright_text: {
                required: "Please enter copyright text",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });
    // End :: Site Settings Form //

    // Start :: Cms Form //
    $("#updateCmsForm").validate({
        ignore: [],
        debug: false,
        rules: {
            title: {
                required: true
            },
            // description: {
            //     ckrequired: true,
            // },
            meta_title: {
                required: true,
            },
            meta_keyword: {
                required: true,
            },
            meta_description: {
                required: true,
            },
        },
        messages: {
            title: {
                required: "Please enter title",
            },
            // description: {
            //     required: "Please enter description"
            // },
            meta_title: {
                required: "Please enter meta title"
            },
            meta_keyword: {
                required: "Please enter meta keyword"
            },
            meta_description: {
                required: "Please enter meta description"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });    
    // End :: Cms Form //

    // Start :: Banner Form //
    $("#createBannerForm").validate({
        ignore: [],
        debug: false,
        rules: {
            title: {
                required: true,
            },
            short_description: {
                ckrequired:true,
            },
            image: {
                required: true,
            },
        },
        messages: {
            title: {
                required: "Please enter title",
            },
            short_description: {
                ckrequired:  "Please enter short description",
            },
            image: {
                required: "Please upload image"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });

    $("#updateBannerForm").validate({
        ignore: [],
        debug: false,
        rules: {
            title: {
                required: true,
            },
            short_description: {
                ckrequired:true,
            },
            // image: {
            //     required: true,
            // },
        },
        messages: {
            title: {
                required: "Please enter title",
            },
            short_description: {
                ckrequired:  "Please enter short description",
            },
            // image: {
            //     required: "Please upload image"
            // },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });
    // End :: Banner Form //

    // Start :: Logo Form //
    $("#createLogoForm").validate({
        ignore: [],
        debug: false,
        rules: {
            title: {
                required: true,
            },
            image: {
                required: true,
            },
        },
        messages: {
            title: {
                required: "Please enter title",
            },
            image: {
                required: "Please upload image"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });

    $("#updateLogoForm").validate({
        ignore: [],
        debug: false,
        rules: {
            title: {
                required: true,
            },
            // image: {
            //     required: true,
            // },
        },
        messages: {
            title: {
                required: "Please enter title",
            },
            // image: {
            //     required: "Please upload image"
            // },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });
    // End :: Logo Form //

    // Start :: Benefit Form //
    $("#createBenefitForm").validate({
        ignore: [],
        debug: false,
        rules: {
            cms_page_id: {
                required: true,
            },
            title: {
                required: true,
            },
            image: {
                required: true,
            },
        },
        messages: {
            cms_page_id: {
                required: "Please select page",
            },
            title: {
                required: "Please enter title",
            },
            image: {
                required: "Please upload image"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });

    $("#updateBenefitForm").validate({
        ignore: [],
        debug: false,
        rules: {
            cms_page_id: {
                required: true,
            },
            title: {
                required: true,
            },
            // image: {
            //     required: true,
            // },
        },
        messages: {
            cms_page_id: {
                required: "Please select page",
            },
            title: {
                required: "Please enter title",
            },
            // image: {
            //     required: "Please upload image"
            // },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });
    // End :: Benefit Form //

    // Start :: Benetic turn Form //
    $("#createBeneticTurnForm").validate({
        ignore: [],
        debug: false,
        rules: {
            title: {
                required: true,
            },
            image: {
                required: true,
            },
        },
        messages: {
            title: {
                required: "Please enter title",
            },
            image: {
                required: "Please upload image"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });

    $("#updateBeneticTurnForm").validate({
        ignore: [],
        debug: false,
        rules: {
            title: {
                required: true,
            },
            // image: {
            //     required: true,
            // },
        },
        messages: {
            title: {
                required: "Please enter title",
            },
            // image: {
            //     required: "Please upload image"
            // },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });
    // End :: Benetic turn Form //

    // Start :: How it work Form //
    $("#createHowItWorkForm").validate({
        ignore: [],
        debug: false,
        rules: {
            title: {
                required: true,
            },
            image: {
                required: true,
            },
        },
        messages: {
            title: {
                required: "Please enter title",
            },
            image: {
                required: "Please upload image"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });

    $("#updateHowItWorkForm").validate({
        ignore: [],
        debug: false,
        rules: {
            title: {
                required: true,
            },
            // image: {
            //     required: true,
            // },
        },
        messages: {
            title: {
                required: "Please enter title",
            },
            // image: {
            //     required: "Please upload image"
            // },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });
    // End :: How it work Form //

    // Start :: Team Member Form //
    $("#createTeamMemberForm").validate({
        ignore: [],
        debug: false,
        rules: {
            name: {
                required: true,
            },
            designation: {
                required: true,
            },
            short_description: {
                required: true,
            },
            // linkedin_link: {
            //     required: true,
            // },
            image: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please enter name",
            },
            designation: {
                required: "Please enter designation",
            },
            short_description: {
                required: "Please enter short description",
            },
            // linkedin_link: {
            //     required: "Please enter linkedin link",
            // },
            image: {
                required: "Please upload image"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });

    $("#updateTeamMemberForm").validate({
        ignore: [],
        debug: false,
        rules: {
            name: {
                required: true,
            },
            designation: {
                required: true,
            },
            short_description: {
                required: true,
            },
            // linkedin_link: {
            //     required: true,
            // },
            // image: {
            //     required: true,
            // },
        },
        messages: {
            name: {
                required: "Please enter name",
            },
            designation: {
                required: "Please enter designation",
            },
            short_description: {
                required: "Please enter short description",
            },
            // linkedin_link: {
            //     required: "Please enter linkedin link",
            // },
            // image: {
            //     required: "Please upload image"
            // },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $('#loading').show();
            form.submit();
        }
    });
    // End :: Team Member Form //


    /***************************** Start :: Datatable and Common Functionalities ****************************/
    // Start :: Check / Un-check all for Admin Bulk Action (DO NOT EDIT / DELETE) //
	$('.checkAll').click(function(){
		if ($(this).is(':checked')) {
			$('.delete_checkbox').prop('checked', true);
		} else {
			$('.delete_checkbox').prop('checked', false);
		}
	});
	$(document).on('click', '.delete_checkbox', function(){
		var length = $('.delete_checkbox').length;
		var totalChecked = 0;
		$('.delete_checkbox').each(function() {
			if ($(this).is(':checked')){
				totalChecked += 1;
			}
		});
		if(totalChecked == length){
			$(".checkAll").prop('checked', true);
		}else{
			$('.checkAll').prop('checked', false);
		}
	});
    // End :: Check / Un-check all for Admin Bulk Action (DO NOT EDIT / DELETE) //

    /*************************************** End :: Datatable and Common Functionalities ***************************************/

    /*Date range used in Admin user listing (filter) section*/
    //Restriction on key & right click
    $('#registered_date').keydown(function(e) {
        var keyCode = e.which;
        if ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || keyCode === 8 || keyCode === 122 || keyCode === 32 || keyCode == 46) {
            e.preventDefault();
        }
    });
    $('#registered_date').daterangepicker({
        autoUpdateInput: false,
        timePicker: false,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        startDate: moment().startOf('hour'),
        //endDate: moment().startOf('hour').add(24, 'hour'),
        locale: {
            format: 'YYYY-MM-DD'
        }
    }, function(start_date, end_date) {
        $(this.element[0]).val(start_date.format('YYYY-MM-DD') + ' - ' + end_date.format('YYYY-MM-DD'));
    });

    $('#purchase_date').daterangepicker({
        autoUpdateInput: false,
        timePicker: false,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        startDate: moment().startOf('hour'),
        //endDate: moment().startOf('hour').add(24, 'hour'),
        locale: {
            format: 'YYYY-MM-DD'
        }
    }, function(start_date, end_date) {
        $(this.element[0]).val(start_date.format('YYYY-MM-DD') + ' - ' + end_date.format('YYYY-MM-DD'));
    });

    $('#contract_duration').daterangepicker({
        autoUpdateInput: false,
        timePicker: false,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        startDate: moment().startOf('hour'),
        //endDate: moment().startOf('hour').add(24, 'hour'),
        locale: {
            format: 'YYYY-MM-DD'
        }
    }, function(start_date, end_date) {
        $(this.element[0]).val(start_date.format('YYYY-MM-DD') + ' - ' + end_date.format('YYYY-MM-DD'));
    });

    /*Date range used in Coupon listing (filter) section*/
    //Restriction on key & right click
    $('.date_restriction').keydown(function(e) {
        var keyCode = e.which;
        if ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || keyCode === 8 || keyCode === 122 || keyCode === 32 || keyCode == 46) {
            e.preventDefault();
        }
    });
    $('.date_restriction').daterangepicker({
        autoUpdateInput: false,
        timePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        startDate: moment().startOf('hour'),
        //endDate: moment().startOf('hour').add(24, 'hour'),
        locale: {
            format: 'YYYY-MM-DD HH:mm'
        }
    }, function(start_date, end_date) {
        $(this.element[0]).val(start_date.format('YYYY-MM-DD HH:mm') + ' - ' + end_date.format('YYYY-MM-DD HH:mm'));
    });

    $("#settlement_status").select2();
});

// Start :: Admin List Actions //
function listActions(routePrefix, actionRoute, id, actionType, dTable) {
    var message = actionUrl = '';

    if (actionRoute != '') {
        actionUrl = adminPanelUrl+'/'+routePrefix+'/'+actionRoute+'/'+id;
    }

    if (actionType == 'active') {
        message = confirmActiveStatusMessage;
    } else if (actionType == 'inactive') {
        message = confirmInactiveStatusMessage;
    } else if (actionType == 'delete') {
        message = confirmDeleteMessage;
    } else {
        message = somethingWrongMessage;
    }
    
    if (actionUrl != '') {
        swal.fire({
            text: message,
            icon: 'warning',
            allowOutsideClick: false,
            confirmButtonColor: btnConfirmYesColor,
            cancelButtonColor: btnCancelNoColor,
            showCancelButton: true,
            confirmButtonText: btnYes,
            cancelButtonText: btnNo,
        }).then((result) => {
            if (result.value) {
                $('#loading').show();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: actionUrl,
                    method: 'GET',
                    data: {},
                    success: function (response) {
                        $('#loading').hide();
                        if (response.type == 'success') {
                            dTable.draw();
                            toastr.success(response.message, response.title+'!');
                        } else {
                            toastr.error(response.message, response.title+'!');
                        }
                    }
                });
            }
        });
    } else {
        toastr.error(message, errorMessage+'!');
    }
}
// End :: Admin List List Actions //

// Start :: Admin List Bulk Actions //
function bulkActions(routePrefix, actionRoute, selectedIds, actionType, dTable) {
    var message = actionUrl = '';
    
    if (actionRoute != '') {
        actionUrl = adminPanelUrl+'/'+routePrefix+'/'+actionRoute;
    }

    if (actionType == 'active') {
        message = confirmActiveSelectedMessage;
    } else if (actionType == 'inactive') {
        message = confirmInactiveSelectedMessage;
    } else if (actionType == 'delete') {
        message = confirmDeleteSelectedMessage;
    } else {
        message = somethingWrongMessage;
    }
    
    if (actionUrl != '') {
        swal.fire({
            text: message,
            icon: 'warning',
            allowOutsideClick: false,
            confirmButtonColor: btnConfirmYesColor,
            cancelButtonColor: btnCancelNoColor,
            showCancelButton: true,
            confirmButtonText: btnYes,
            cancelButtonText: btnNo,
        }).then((result) => {
            if (result.value) {
                $('#loading').show();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: actionUrl,
                    method: 'POST',
                    data: {
                        actionType: actionType,
                        selectedIds: selectedIds,
                    },
                    success: function (response) {
                        $('#loading').hide();
                        if (response.type == 'success') {
                            $('.checkAll').prop('checked', false);
                            dTable.draw();
                            toastr.success(response.message, response.title+'!');
                        } else if (response.type == 'warning') {
                            $('.checkAll').prop('checked', false);
                            dTable.draw();
                            toastr.warning(response.message, response.title+'!');
                        } else {
                            toastr.error(response.message, response.title+'!');
                        }
                    }
                });
            }
        });
    } else {
        toastr.error(message, errorMessage+'!');
    }
}
// End :: Admin List Bulk Actions //

function sweetalertMessageRender(target, message, type, confirm = false) {
    let options = {
        icon: type,
        title: 'warning!',
        text: message,
        
    };
    if (confirm) {
        options['showCancelButton'] = true;
        options['confirmButtonText'] = 'Yes';
    }

    return Swal.fire(options)
    .then((result) => {
        if (confirm == true && result.value) {
            window.location.href = target.getAttribute('data-href'); 
        } else {
            return (false);
        }
    });
}