const togglePassword = document.getElementById("toggle-password");
const formContent = document.getElementsByClassName('form-content')[0];
const getFormContentHeight = formContent.clientHeight;

let formImage = document.getElementsByClassName('form-image')[0];
if (formImage) {
	const setFormImageHeight = formImage.style.height = getFormContentHeight + 'px';
}
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
    $("#login-form").on("submit",function (e) {
        e.preventDefault();
        $.ajax({
            async : false,
            method : "POST",
            url : "http://127.0.0.1:8000/api/login",
            data : {
                email : $("#login-form input[name='email']").val(),
                password : $("#login-form input[name='password']").val()
            },
            success : function (response) {
            	console.log("response");
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
                        title: 'شما با موفقیت به حساب کاربری خود وارد شدید.',
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
                            $(location).attr("href","../dashboard/dashboard.html");
                        }
                    });
                }
            },error : function (error) {
                console.log("error : "+JSON.stringify(error));
            }
        })

    });
});