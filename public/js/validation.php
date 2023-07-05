<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {

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
                if (element.parent('.form-control').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
            // end add
        });
    });
</script>
<script>
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
</script>
<script>
    $(document).ready(function() {

        $("#login").validate({
            rules: {
                username: {
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
                captcha: {
                    required: true,
                },
            },
            messages: {
                // email: {
                //     required: "Email is required",
                //     email: "Email must be a valid email address",
                //     maxlength: "Email cannot be more than 50 characters",
                // },

                username: "<?php echo __('Username or Email is required.') ?>",
                password: {
                    maxlength: "<?php echo __('Please enter no more than 30 characters.') ?>",
                    minlength: "<?php echo __('Please enter at least 6 characters.') ?>",
                    required: "<?php echo __('Password is required.') ?>",
                    pwcheck: "<?php echo __('Password is not strong enough.') ?>",
                    checklower: "<?php echo __('Need atleast 1 lowercase alphabet.') ?>",
                    checkupper: "<?php echo __('Need atleast 1 uppercase alphabet.') ?>",
                    checkdigit: "<?php echo __('Need atleast 1 digit.') ?>"
                },
                captcha: {
                    required: "<?php echo __('Captcha is required.') ?>",
                },
            }

        });

        $("#regform").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 50
                },
                username: {
                    required: true,
                    maxlength: 50
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 50
                },
                mobile_no: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    number: true
                },
                password: {
                    minlength: 6,
                    maxlength: 30,
                    required: true,
                    checklower: true,
                    checkupper: true,
                    checkdigit: true
                },
            },
            messages: {
                name: {
                    required: "<?php echo __('Name is required.') ?>",
                },
                username: {
                    required: "<?php echo __('Username is required.') ?>",
                },
                email: {
                    required: "<?php echo __('Email is required.') ?>",
                    email: "<?php echo __('Email must be a valid email address.') ?>",
                    maxlength: "<?php echo __('Email cannot be more than 50 characters.') ?>",
                },
                mobile_no: {
                    required: "<?php echo __('Mobile number is required.') ?>",
                    minlength: "<?php echo __('Mobile number must be of 10 digits.') ?>"
                },
                password: {
                    minlength: "<?php echo __('Please enter at least 6 characters.') ?>",
                    required: "<?php echo __('Password is required.') ?>",
                    pwcheck: "<?php echo __('Password is not strong enough.') ?>",
                    checklower: "<?php echo __('Need atleast 1 lowercase alphabet.') ?>",
                    checkupper: "<?php echo __('Need atleast 1 uppercase alphabet.') ?>",
                    checkdigit: "<?php echo __('Need atleast 1 digit.') ?>"
                },
            }

        });
    });
</script>