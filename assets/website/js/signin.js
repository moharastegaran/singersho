$(document).ready(function (){
    const _form = $("#login-form");
    _form.on("submit",function (e){
        e.preventDefault();
        $.ajax({
            async : false,
            method : "POST",
            url : __url__+"/login",
            data : {
                mobile : _form.find("input[name='mobile']").val(),
                password : _form.find("input[name='password']").val()
            },
            success : function (response) {
                console.log("response");
                if(response.error){
                    let errors = response.messages;
                    _form.find(".form-errors").remove();
                    _form.prepend($("<div></div>").addClass("form-errors"));
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
