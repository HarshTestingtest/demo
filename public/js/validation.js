


$.validator.setDefaults({
    highlight: function(element) {
        $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function(element) {
          $(element).addClass("is-valid").removeClass("is-invalid");
    },

    //add
    errorElement: 'span',
    errorClass: 'text-danger',
    errorPlacement: function(error, element) {
        if(element.parent('.form-control').length) {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
    }
    // end add
});

$(document).ready(function(){
    var value = $("#password").val();
    $.validator.addMethod("checklower", function(value) {
        return /[a-z]/.test(value);
      });
      $.validator.addMethod("checkupper", function(value) {
        return /[A-Z]/.test(value);
      });
      $.validator.addMethod("checkdigit", function(value) {
        return /[0-9]/.test(value);
      });
      $.validator.addMethod("pwcheck", function(value) {
        return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) && /[a-z]/.test(value) && /\d/.test(value) && /[A-Z]/.test(value);
      });
      
    

    $("#login").validate({
        rules: {
            username:{
                required: true,
            },
            // email: {
            //     required: true,
            //     email: true,
            //     maxlength: 50
            // },
            password: {
                minlength: 6,
                maxlength: 30,
                required: true,
                checklower: true,
                checkupper: true,
                checkdigit: true
            },
            captcha:{
                required: true,
            },
        },
        messages: {
            // email: {
            //     required: "Email is required",
            //     email: "Email must be a valid email address",
            //     maxlength: "Email cannot be more than 50 characters",
            // },
            
            username:{
                required: 'Username or Email is required',
            },
            password: {
                minlength: "Please enter at least 6 characters.",
                required: "Password is required",
                pwcheck: "Password is not strong enough",
                checklower: "Need atleast 1 lowercase alphabet",
                checkupper: "Need atleast 1 uppercase alphabet",
                checkdigit: "Need atleast 1 digit"
            },
            captcha:{
                required: "Captcha is required",
            },
        }
        
    });
    // $("#regform").validate({
    //     rules: {
    //         name: {
    //             required: true,
    //             maxlength: 50
    //         },
    //         username: {
    //             required: true,
    //             maxlength: 50
    //         },
    //         email: {
    //             required: true,
    //             email: true,
    //             maxlength: 50
    //         },
    //         mobile_no: {
    //             required: true,
    //             minlength: 10,
    //             maxlength: 10,
    //             number: true
    //         },
    //         password: {
    //             minlength: 6,
    //             maxlength: 30,
    //             required: true,
    //             checklower: true,
    //             checkupper: true,
    //             checkdigit: true
    //         },
    //     },
    //     messages: {
    //         name:{
    //             required: 'Name is required.',
    //         },
    //         username:{
    //             required: "Username is required.",
    //         },
    //         email: {
    //             required: "Email is required.",
    //             email: "Email must be a valid email address.",
    //             maxlength: "Email cannot be more than 50 characters.",
    //         },
    //         mobile_no: {
    //             required: "Mobile number is required.",
    //             minlength: "Mobile number must be of 10 digits.",
    //         },
    //         password: {
    //             required: "Password is required.",
    //             pwcheck: "Password is not strong enough.",
    //             checklower: "Need atleast 1 lowercase alphabet.",
    //             checkupper: "Need atleast 1 uppercase alphabet.",
    //             checkdigit: "Need atleast 1 digit.",
    //         },
    //     }
        
    // });
    $("#otpLogin").validate({
        rules: {
            mobile_no: {
                required: true,
                minlength: 10,
                maxlength: 10,
                number: true
            },
        },
        messages: {
            mobile_no: {
                required: "Mobile number is required",
                minlength: "Mobile number must be of 10 digits"
            },
        }
        
    });
    
    $('#refreshCaptcha').click(function(){
        
        $.ajax({
        url: "/refereshcapcha",
        type: 'get',
          dataType: 'html',        
          success: function(json) {
            $('.refereshrecapcha').html(json);
          },
          error: function(data) {
           
          }
        });
    }); 
});
