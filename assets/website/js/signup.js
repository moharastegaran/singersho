$(document).ready(function () {

    let current_fs, next_fs, previous_fs;
    let opacity, scale;
    let animating;

    function animateNext(_this) {
        if (animating) return false;
        animating = true;

        current_fs = $(_this.closest('fieldset'));
        next_fs = current_fs.next();

        current_fs.animate({opacity: 0}, {
            step: function (now, mx) {
                scale = 1 - (1 - now) * 0.2;
                opacity = 1 - now;
                current_fs.css({'transform': 'scale(' + scale + ')'});
            },
            duration: 800,
            complete: function () {
                current_fs.hide();
                next_fs.show();
                next_fs.css({'opacity': opacity});
                animating = false;
            },
            easing: 'easeInOutBack'
        });
    }

    function animatePrev(_this) {
        if (animating) return false;
        animating = true;

        current_fs = $(_this.closest('fieldset'));
        previous_fs = current_fs.prev();

        current_fs.animate({opacity: 0}, {
            step: function (now, mx) {
                scale = 0.8 + (1 - now) * 0.2;
                opacity = 1 - now;
            },
            duration: 800,
            complete: function () {
                current_fs.hide();
                previous_fs.show();
                previous_fs.css({'transform': 'scale(' + scale + ')', 'opacity': opacity});
                animating = false;
            },
            easing: 'easeInOutBack'
        });
    }

    $(".send__btn").on('click', function () {
        const _this = this;
        const _input = $("input[name='mobile']");
        $.ajax({
            async: false,
            method: 'POST',
            url: __url__+'/sms/send/register',
            data: {
                mobile: _input.val()
            },
            success: function (response) {
                console.log("response : "+JSON.stringify(response));
                if (!response.error) {
                    animateNext(_this)
                } else {
                    _input.next(".input-error").remove();
                    _input.after(
                        $("<div></div>")
                            .addClass("input-error text-danger mt-1")
                            .text(response.messages[0]));
                }
            }, error : function (error){
                console.log("error : "+error.responseText);
            }
        })
    });

    $(".verify__btn").on('click', function () {
        const _this = this;
        const _input = $("input[name='code']");
        $.ajax({
            async: false,
            method: 'PATCH',
            url: __url__+'/sms/verify/register',
            data: {
                mobile: $("input[name='mobile']").val(),
                code: _input.val()
            },
            success: function (response) {
                if (!response.error) {
                    animateNext(_this)
                } else {
                    _input.next(".input-error").remove();
                    _input.after(
                        $("<div></div>")
                            .addClass("input-error text-danger mt-1")
                            .text(response.messages[0]));
                }
            }, error : function (error){
                console.log("error : "+error.responseText);
            }
        })
    });

    $(".submit__btn").on('click', function (e) {
        e.preventDefault();

        const _form = $("#registeration-form");

        $.ajax({
            async: false,
            method: "POST",
            url: __url__+"/register",
            data: {
                first_name: $("input[name='first_name']").val(),
                last_name: $("input[name='last_name']").val(),
                email: $("input[name='email']").val(),
                mobile: $("input[name='mobile']").val(),
                password: $("input[name='password']").val(),
                password_confirmation: $("input[name='password_confirmation']").val()
            },
            success: function (response) {
                console.log(response);
                if (response.error) {
                    let errors = response.messages;
                    _form.find(".form-errors").remove();
                    _form.prepend($("<div></div>").addClass("form-errors"));
                    for (let i = 0; i < errors.length; i++) {
                        $(".form-errors").append(
                            $("<div></div>")
                                .addClass("input-error text-danger my-2")
                                .text(errors[i]))
                    }
                } else {
                    localStorage.setItem("accessToken", response.access_token);
                    $(location).attr("href", "profile.html");

                }
            }, error: function (error) {
                console.log("error : " + JSON.stringify(error));
            }
        });

    });

});

