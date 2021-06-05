let togglePassword = document.getElementById("toggle-password");

if (togglePassword) {
    togglePassword.addEventListener('click', function() {
        let x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    });
}

$(document).ready(function () {
    $("#registeration-form").on("submit",function (e) {
        e.preventDefault();
        $.ajax({
            async : false,
            method : "POST",
            url : "http://127.0.0.1:8000/api/register",
            data :  {
                first_name : $("input[name='first_name']").val(),
                last_name : $("input[name='last_name']").val(),
                email : $("input[name='email']").val(),
                mobile : $("input[name='mobile']").val(),
                password : $("input[name='password']").val(),
                password_confirmation : $("input[name='password_confirmation']").val()
            },
            success : function (response) {
                console.log(response);
                if(response.error){
                    let errors = response.messages;
                    $("#registeration-form .form-errors").remove();
                    $("#registeration-form").prepend($("<div></div>").addClass("form-errors"));
                    for(let i=0;i<errors.length;i++){
                        $(".form-errors").append(
                            $("<div></div>")
                                .addClass("alert alert-outline-danger fade show font-iransans")
                                .text(errors[i]))
                    }
                    $(".form-errors .alert").append("<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">" +
                        "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-x close\" data-dismiss=\"alert\"><line x1=\"18\" y1=\"6\" x2=\"6\" y2=\"18\"></line><line x1=\"6\" y1=\"6\" x2=\"18\" y2=\"18\"></line></svg>" +
                        "</button>");
                }else{
                    localStorage.setItem("accessToken",response.access_token);
                    swal({
                        title: 'ثبت نام شما با موفقیت انجام شد.',
                        text: "در حال انتقال به پنل کاربری",
                        type: 'success',
                        padding: '2em',
                        timer : 2000,
                        showConfirmButton : false,
                        showCancelButton : false,
                        onOpen: function () {
                            swal.showLoading()
                        }
                    }).then(function (result) {
                        if (result.dismiss === swal.DismissReason.timer) {
                            console.log('I was closed by the timer');
                            $(location).attr("href","../dashboard/dashboard.html");
                        }
                    });
                }
            },error : function (error) {
                console.log("error : "+JSON.stringify(error));
            }
        });
    });

    $("#password-recovery-form").on("submit",function (e) {
        console.log("eee");
        e.preventDefault();
            let response = grecaptcha.getResponse();
            if(response.length === 0) {
                $(".g-recaptcha").append($("<div class='text-error text-danger'>تیک زدن کپچا الزامی است.</div>"));
            } else {
                $($(".g-recaptcha").find(".text-error")).remove();
                console.log("send reset password req");
            }
    })

});