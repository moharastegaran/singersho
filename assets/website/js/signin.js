$(document).ready(function (){
    $("#login-form").on("submit",function (e){
        e.preventDefault();
        $.ajax({
            async : false,
            method : "POST",
            url : __url__+"/login",
            data : {
                email : $("#login-form input[name='email']").val(),
                password : $("#login-form input[name='password']").val()
            },
            success : function (response) {
                console.log("response");
                if(response.error){
                    let errors = response.messages;
                    $("#login-form .form-errors").remove();
                    $("#login-form").prepend($("<div></div>").addClass("form-errors"));
                    for(let i=0;i<errors.length;i++){
                        $(".form-errors").append(
                            $("<div></div>")
                                .addClass("input-error text-danger my-2")
                                .text(errors[i]))
                    }
                }else{
                    localStorage.setItem("accessToken",response.access_token);
                    $(location).attr('href','profile.html');
                }
            },error : function (error) {
                console.log("error : "+JSON.stringify(error));
            }
        });
    })
})
