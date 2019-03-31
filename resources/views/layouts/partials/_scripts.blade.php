<script>
    $(function () {
        $('#lightgallery').lightGallery();

        @if(session('success') || session('error') || session('logout') || session('expire') || session('inactive') ||
            session('unknown') || session('recovered'))
        openLoginModal();
        @elseif($errors->has('email') || $errors->has('password') || $errors->has('name'))
        openRegisterModal();
        @elseif(session('resetLink') || session('resetLink_failed'))
        openEmailModal();
        @elseif(session('reset') || session('recover_failed'))
        openPasswordModal();
        @endif
    });

    var recaptcha_login, recaptcha_register, recaptchaCallback = function () {
        recaptcha_login = grecaptcha.render(document.getElementById('recaptcha-login'), {
            'sitekey': '{{env('reCAPTCHA_v2_SITEKEY')}}',
            'callback': 'enable_btnLogin',
            'expired-callback': 'disabled_btnLogin'
        });
        recaptcha_register = grecaptcha.render(document.getElementById('recaptcha-register'), {
            'sitekey': '{{env('reCAPTCHA_v2_SITEKEY')}}',
            'callback': 'enable_btnRegister',
            'expired-callback': 'disabled_btnRegister'
        });
    };

    function enable_btnLogin() {
        $("#btn_login").removeAttr('disabled');
    }

    function disabled_btnLogin() {
        $("#btn_login").attr('disabled', 'disabled');
    }

    function enable_btnRegister() {
        $("#btn_register").removeAttr('disabled');
    }

    function disabled_btnRegister() {
        $("#btn_register").attr('disabled', 'disabled');
    }

    $("#form-login").on("submit", function (e) {
        if (grecaptcha.getResponse(recaptcha_login).length === 0) {
            e.preventDefault();
            swal('ATTENTION!', 'Please confirm us that you\'re not a robot by clicking in ' +
                'the reCAPTCHA dialog-box.', 'warning');
        }
    });

    $("#form-register").on("submit", function (e) {
        if (grecaptcha.getResponse(recaptcha_register).length === 0) {
            e.preventDefault();
            swal('ATTENTION!', 'Please confirm us that you\'re not a robot by clicking in ' +
                'the reCAPTCHA dialog-box.', 'warning');
        }

        if ($.trim($("#reg_email,#reg_name,#reg_password,#reg_password_confirm").val()) === "") {
            return false;

        } else {
            if ($("#reg_password_confirm").val() != $("#reg_password").val()) {
                return false;

            } else {
                $("#reg_errorAlert").html('');
                return true;
            }
        }
    });

    $("#reg_password_confirm").on("keyup", function () {
        if ($(this).val() != $("#reg_password").val()) {
            $("#reg_errorAlert").html(
                '<div class="alert alert-danger alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                '<h4><i class="icon fa fa-times"></i> Alert!</h4>Your password confirmation doesn\'t match!</div>'
            );
        } else {
            $("#reg_errorAlert").html('');
        }
    });

    function checkForgotPassword() {
        var new_pas = $("#forg_password").val(),
            re_pas = $("#forg_password_confirm").val();
        if (new_pas != re_pas) {
            $("#forg_errorAlert").html(
                '<div class="alert alert-danger alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                '<h4><i class="icon fa fa-times"></i> Alert!</h4>Your password confirmation doesn\'t match!</div>'
            );
            $(".btn-password").attr('disabled', 'disabled');

        } else {
            $("#forg_errorAlert").html('');
            $(".btn-password").removeAttr('disabled');
        }
    }

    $("#form-recovery").on("submit", function (e) {
        if ($("#forg_password_confirm").val() != $("#forg_password").val()) {
            $(".btn-password").attr('disabled', 'disabled');
            return false;

        } else {
            $("#forg_errorAlert").html('');
            $(".btn-password").removeAttr('disabled');
            return true;
        }
    });

    $('#log_password + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#log_password').togglePassword();
    });

    $('#reg_password + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#reg_password').togglePassword();
    });

    $('#reg_password_confirm + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#reg_password_confirm').togglePassword();
    });

    $('#forg_password + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#forg_password').togglePassword();
    });

    $('#forg_password_confirm + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#forg_password_confirm').togglePassword();
    });

    function showRegisterForm() {
        $('.loginBox, .emailBox, .passwordBox').fadeOut('fast', function () {
            $('.registerBox').fadeIn('fast');
            $('.login-footer').fadeOut('fast', function () {
                $('.register-footer').fadeIn('fast');
            });
            $('.modal-title').html('Sign Up');
        });
        $('.error').removeClass('alert alert-danger').html('');
    }

    function showLoginForm() {
        $('#loginModal .registerBox, .emailBox, .passwordBox').fadeOut('fast', function () {
            $('.loginBox').fadeIn('fast');
            $('.register-footer').fadeOut('fast', function () {
                $('.login-footer').fadeIn('fast');
            });
            $('.modal-title').html('Sign In');
        });
        $('.error').removeClass('alert alert-danger').html('');
    }

    var title = document.getElementsByTagName("title")[0].innerHTML;
    (function titleScroller(text) {
        document.title = text;
        setTimeout(function () {
            titleScroller(text.substr(1) + text.substr(0, 1));
        }, 500);
    }(title + " ~ "));

    <!--Scroll to top button-->
    window.onscroll = function () {
        scrollFunction()
    };

    function scrollFunction() {
        if ($(this).scrollTop() > 100) {
            $('.to-top').addClass('show-to-top');
        } else {
            $('.to-top').removeClass('show-to-top');
        }
    }

    function scrollToTop(callback) {
        if ($('html').scrollTop()) {
            $('html').animate({scrollTop: 0}, callback);
            return;
        }
        if ($('body').scrollTop()) {
            $('body').animate({scrollTop: 0}, callback);
            return;
        }
        callback();
    }
    <!--end:Scroll to top button-->

    <!--Scroll Progress Bar-->
    function progress() {

        var windowScrollTop = $(window).scrollTop();
        var docHeight = $(document).height();
        var windowHeight = $(window).height();
        var progress = (windowScrollTop / (docHeight - windowHeight)) * 100;
        var $bgColor = progress > 99 ? '#312855' : '#592f83';
        var $textColor = progress > 99 ? '#fff' : '#333';

        $('.progress .bar').width(progress + '%').css({backgroundColor: $bgColor});
        // $('h1').text(Math.round(progress) + '%').css({color: $textColor});
        $('.fill').height(progress + '%').css({backgroundColor: $bgColor});
    }

    progress();

    $(document).on('scroll', progress);

    <!-- WhatsHelp.io widget -->
    (function () {
        var options = {
            whatsapp: "+628563094333",
            line: "//line.me/ti/p/fqnkk",
            call_to_action: "Contact us",
            button_color: "#592f83",
            position: "right",
            order: "line,whatsapp",
        };
        var proto = document.location.protocol, host = "whatshelp.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>