<script>
    $(".sop-resend-otp").hide();

    function toggleEye(e) {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
        $(e).toggleClass('fas fa-eye-slash fas fa-eye');
    }

    $(document).ready(function() {
        $(".select-login-header").hide();
        $(".register-header").hide();
        $(".user-login-header").show();
        $(".request-name-header").hide();
        $(".header3").hide();
        $(".header4").hide();
        $(".header5").hide();

        $(".select-login-body").hide();
        $(".user-login-body").show();
        $(".body-3").hide();
        $(".register-body").hide();
        $("#codecheckforreg").hide();
        $(".forgotpassword").hide();
        $(".request-name-body").hide();


        $(".forgotpasswordbutton").click(function() {
            $(".select-login-header").hide();
            $(".user-login-header").hide();
            $(".header3").hide();
            $(".header4").hide();
            $(".header5").show();
            $(".forgotpassword").show();


            $(".select-login-body").hide();
            $(".user-login-body").hide();
            $(".body-3").hide();
            $(".modal-dialog").css({
                "bottom": "-10%"
            });
            $("#codecheckforreg").hide();

        });

        $(".checkForm").click(function() {
            //header
            $(".select-login-header").show();
            $(".user-login-header").hide();
            $(".register-header").hide();
            $(".header3").hide();
            $(".header4").hide();
            $(".header5").hide();
            $(".request-name-header").hide();
            //body
            $(".select-login-body").show();
            $(".user-login-body").hide();
            $(".body-3").hide();
            $(".register-body").hide();
            $("#codecheckforreg").hide();
            $(".forgotpassword").hide();
            $(".request-name-body").hide();
            $(".modal-dialog").css({
                "bottom": "0%"
            });
        });

        $(".shopLogin").click(() => {
            $(".header3").fadeIn();
            $(".user-login-header").hide();
            $(".select-login-header").hide();
            $(".header5").hide();

            //body
            $(".user-login-body").hide();
            $(".select-login-body").hide();
            $(".body-3").fadeIn();
            $("#codecheckforreg").hide();
            $(".forgotpassword").hide();
            $(".modal-dialog").css({
                "bottom": "0%"
            });

        });

        $(".userLogin").click(function() {
            $(".user-login-header").fadeIn();
            $(".select-login-header").hide();
            $(".register-header").hide();
            $(".header3").hide();
            $(".request-name-header").hide();
            //body
            $(".user-login-body").fadeIn();
            $(".select-login-body").hide();
            $(".body-3").hide();
            $(".register-body").hide();
            $(".forgotpassword").hide();
            $(".modal-dialog").css({
                "bottom": "-10%"
            });
            $("#codecheckforreg").hide();
            $(".request-name-body").hide();

        });

        $(".userRegister").click(function() {
            $(".user-login-header").hide();
            $(".select-login-header").hide();
            $(".header3").hide();
            $(".register-header").fadeIn();

            //body
            $(".register-body").fadeIn();
            $(".user-login-body").hide();
            $(".select-login-body").hide();
            $(".body-3").hide();
            $(".forgotpassword").hide();
            $(".modal-dialog").css({
                "bottom": "-10%"
            });
            $("#codecheckforreg").hide();

        });

        $("#checkcodereg").click(function() {
            var regdata = JSON.parse(localStorage.getItem('forreg'));
            regdata.code = $("#regotpcode").val();
            regdata.frombuynow = $('#loginbeforebuynow').val();
            regdata.frommessenger = $('#loginbeforemessenger').val();
            regdata.frompayment = $('#loginbeforepayment').val();
            regdata.fromorder = $('#orderlogin').val();
            //if user not enter code in input box
            if (regdata.code == '') {
                $("#regerrorcode").html("<strong style='color:red'>Code Require<strong>");

            } else {
                axios.post(`{!! url('checkcodereg') !!}`, regdata).then(response => {
                    if (response.data == 'Invalid Code') {
                        $("#regerrorcode").html("<strong style='color:red'>" + response.data +
                            "<strong>");

                    } else {
                        if (response.data.data == true) {
                            $(".header4").hide();
                            $("#codecheckforreg").hide();
                            $(".request-name-header").fadeIn();
                            $(".request-name-body").fadeIn();
                        } else {
                            if (response.data == 'order') {
                                location.assign("{{url('orderform')}}");
                            } else {
                                location.assign(window.location.href);

                            }
                        }

                    }

                });

            }


            // console.log(regdata);

        });


        $("#sentName").click(() => {
            var regdata = JSON.parse(localStorage.getItem('forreg'));
            regdata.name = $("#requestName").val();

            axios.post(`{!! url('updatename') !!}`,
                regdata
            ).then(response => {

                if (response.data == 'Invalid Code') {
                    $("#regerrorcode").html("<strong style='color:red'>" + response.data +
                        "<strong>");

                } else {
                    location.assign(window.location.href);
                }

            })
        });

        $(".zh_select").click(function() {
            $(".chose_one").attr('selected', true);

        });

        //error section

        `@if (Session::has('error'))`
        $('#orangeModalSubscription').modal('show');
        $(".user-login-header").hide();
        $(".user-login-body").hide();
        $(".header3").fadeIn();
        $(".body-3").fadeIn();
        `@endif`
    });

    //Login
    $("#login").click(function() {
        axios.post(`{!! url('checkvalidate') !!}`, {
            'phone': $("#phoneNumber").val(),
        }).then(response => {
            if (response.data.code != 'empty') {
                $('#regotpcode').val(response.data.code);
            }
            console.log(response.data)
            if (response.data.phone != undefined) {
                $(".user-login-header").show();
                $(".user-login-body").show();
                $(".header4").hide();
                $("#phoneNumber").addClass('is-invalid');
                $(".error_login_phone").removeClass('d-none');
                if ($(".error_login_phone").children().is('strong') == true) {
                    $(".error_login_phone").children().remove('strong');
                    $(".error_login_phone").wrapInner('<strong>' + response.data.phone[0] + '<strong>');
                } else {
                    $(".error_login_phone").wrapInner('<strong>' + response.data.phone[0] + '<strong>');
                }
            }
            if (response.data.success === false) {
                $(".user-login-header").show();
                $(".user-login-body").show();
                $(".header4").hide();
                $("#phoneNumber").addClass('is-invalid');
                $(".error_login_phone").removeClass('d-none');
                if ($(".error_login_phone").children().is('strong') == true) {
                    $(".error_login_phone").children().remove('strong');
                    $(".error_login_phone").wrapInner(
                        '<strong>ဖုန်းနံပါတ်သည် အကောင့်ဖွင့်ထားခြင်းမရှိပါ<strong>');
                } else {
                    $(".error_login_phone").wrapInner(
                        '<strong>ဖုန်းနံပါတ်သည် အကောင့်ဖွင့်ထားခြင်းမရှိပါ<strong>');
                }
            }
            if (response.data['status'] == 'success') {
                // $('#regbutton').addClass('disabled');
                $(".user-login-header").hide();
                $(".user-login-body").hide();
                $(".header4").fadeIn();
                $("#codecheckforreg").fadeIn();
                $("#phoneforresendcode").val(response.data['data'].phone);
                localStorage.setItem('forreg', JSON.stringify(response.data['data']));

                waitingSecond();
            } else {
                console.log(response.data['status']);
            }
        });

    });

    //Register
    $("#register").click(function() {
        axios.post(`{!! url('checkvalidateregister') !!}`, {
            'name': $("#userName").val(),
            'phone': $("#regPhoneNumber").val(),
        }).then(response => {
            // console.log(response.data)
            if (response.data.name != undefined) {
                $("register-header").show();
                $("register-body").show();
                $(".header4").hide();
                $("#userName").addClass('is-invalid');
                $(".error_name").removeClass('d-none');

                if ($(".error_name").children().is('strong') == true) {
                    $(".error_name").children().remove('strong');
                    $(".error_name").wrapInner('<strong>' + response.data.name[0] + '<strong>');
                } else {
                    $(".error_name").wrapInner('<strong>' + response.data.name[0] + '<strong>');
                }

            }
            if (response.data.phone != undefined) {
                $("register-header").show();
                $("register-body").show();
                $(".header4").hide();
                $("#regPhoneNumber").addClass('is-invalid');
                $(".error_phone").removeClass('d-none');

                if ($(".error_phone").children().is('strong') == true) {
                    $(".error_phone").children().remove('strong');
                    $(".error_phone").wrapInner('<strong>' + response.data.phone[0] + '<strong>');
                } else {
                    $(".error_phone").wrapInner('<strong>' + response.data.phone[0] + '<strong>');
                }

            }
            if (response.data['status'] == 'success') {
                // $('#login').addClass('disabled');
                $(".register-header").hide();
                $(".register-body").hide();
                $(".header4").fadeIn();
                $("#codecheckforreg").fadeIn();
                $("#phoneforresendcode").val(response.data['data'].phone);

                localStorage.setItem('forreg', JSON.stringify(response.data['data']));

                waitingSecond();

            } else {
                console.log(response.data['status']);
            }

        });
    });

    $("#resendCode").click(() => {
        waitingSecond();

        $(".sop-resend-otp").addClass('disabled')
        setTimeout(() => {
            $(".sop-resend-otp").removeClass('disabled')
        }, 8000);
        axios.post(`{!! url('resend_code') !!}`, {
            'phone': $("#phoneforresendcode").val(),
        }).then(response => {
            if (response.data.code != 'empty') {
                $('#regotpcode').val(response.data.code);
            }
            console.log(response.data)
            if (response.data.phone != undefined) {
                $(".user-login-header").show();
                $(".user-login-body").show();
                $(".header4").hide();
                $("#phoneNumber").addClass('is-invalid');
                $(".error_login_phone").removeClass('d-none');
                if ($(".error_login_phone").children().is('strong') == true) {
                    $(".error_login_phone").children().remove('strong');
                    $(".error_login_phone").wrapInner('<strong>' + response.data.phone[0] + '<strong>');
                } else {
                    $(".error_login_phone").wrapInner('<strong>' + response.data.phone[0] + '<strong>');
                }
            }
            if (response.data.success === false) {
                $(".user-login-header").show();
                $(".user-login-body").show();
                $(".header4").hide();
                $("#phoneNumber").addClass('is-invalid');
                $(".error_login_phone").removeClass('d-none');
                if ($(".error_login_phone").children().is('strong') == true) {
                    $(".error_login_phone").children().remove('strong');
                    $(".error_login_phone").wrapInner(
                        '<strong>ဖုန်းနံပါတ်သည် အကောင့်ဖွင့်ထားခြင်းမရှိပါ<strong>');
                } else {
                    $(".error_login_phone").wrapInner(
                        '<strong>ဖုန်းနံပါတ်သည် အကောင့်ဖွင့်ထားခြင်းမရှိပါ<strong>');
                }
            }
            if (response.data['status'] == 'success') {
                // $('#regbutton').addClass('disabled');
                $(".user-login-header").hide();
                $(".user-login-body").hide();
                $(".header4").fadeIn();
                $("#codecheckforreg").fadeIn();
                localStorage.setItem('forreg', JSON.stringify(response.data['data']));

            } else {
                console.log(response.data['status']);
            }
        });
    });

    function waitingSecond() {
        $(".sop-resend-otp").hide();

        const timeS = document.querySelector("#time");
        let timeSecond = 60;
        timeS.innerHTML = timeSecond;

        const countDown = setInterval(() => {
            timeSecond--;
            timeS.innerHTML = timeSecond;
            if (timeSecond <= 0 || timeSecond < 1) {
                clearInterval(countDown);
            }
            if (timeSecond == 0) {
                $(".sop-resend-otp").fadeIn();

            }

        }, 1000);
        $(".sop-resend-otp").removeClass('disabled')

    }

    // for Help & Support shop Owner Login

    $(".onlyShopownerForm").click(function() {
        //header
        $(".select-login-header").hide();
        $(".user-login-header").hide();
        $(".register-header").hide();
        $(".header3").show();
        $(".header4").hide();
        $(".header5").hide();
        $(".request-name-header").hide();
        //body
        $(".select-login-body").hide();
        $(".user-login-body").hide();
        $(".body-3").show();
        $(".register-body").hide();
        $("#codecheckforreg").hide();
        $(".forgotpassword").hide();
        $(".request-name-body").hide();
        $(".modal-dialog").css({
            "bottom": "0%"
        });
    });
</script>
