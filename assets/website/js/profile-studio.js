let studioMultiFileUploadContainer = new FileUploadWithPreview('studioImagesFileContainer');

$(window).on("load", function () {

    $(".custom-file-container__image-preview").css({
        backgroundImage : "url(assets/website/img/studio.svg)",
        marginTop : "30px",
        marginBottom : "10px"
    });

    const _this = $("#studioCity");
    $.get(__url__ + "/cities?rpp=1250", function (response) {
        const cities = response.cities.data;
        for (let i = 0; i < cities.length; i++) {
            const option = new Option(cities[i].name, cities[i].id);
            _this.append(option);
        }
        _this.trigger('change');
    });
});

$(document).on("ready",function (){

    $("#studioCity").select2({
        placeholder: '-انتخاب کنید-',
        dir: "rtl",
        language: "fa",
        width: '100%',
        theme: "bootstrap"
    });

    $("#formAddStudio").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            async: false,
            method: "POST",
            url: __url__+"/studio/register",
            headers: {
                authorization: "Bearer " + localStorage.getItem("accessToken")
            },
            data: {
                name: $("input[name='name']").val(),
                price: $("input[name='price']").val(),
                address: $("textarea[name='address']").val(),
                city_id: $("select[name='city_id']").val(),

            },
            error: function (error) {
                console.log("error : " + JSON.stringify(error))
            },
            success: function (response) {
                if (typeof response === 'object' && response !== null) {
                    if (!response.error) {
                        const studioImages = $("#formAddStudio input[type='file']").get(0).files;
                        if (studioImages.length > 0) {
                            let isOk = true;
                            for (let i = 0; i < studioImages.length; i++) {
                                let formData = new FormData();
                                formData.append("name", "");
                                formData.append("description", "");
                                formData.append("image", studioImages[i]);
                                $.ajax({
                                    method: "POST",
                                    url: __url__+"/studio/" + response.studio.id + "/image",
                                    headers: {
                                        authorization: "Bearer " + localStorage.getItem("accessToken"),
                                    },
                                    data: formData,
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function (response) {
                                        if (typeof response === 'object' && response !== null) {
                                            // if (response.error) {
                                            //     isOk = false;
                                            //     console.log(JSON.stringify(response));
                                            //     Snackbar.show({
                                            //         text: response.messages[0],
                                            //         actionText: '',
                                            //         backgroundColor: "#cb1213",
                                            //         pos: 'bottom-right'
                                            //     });
                                            // }
                                        }
                                    },
                                });
                            }
                            if (isOk) {
                                Snackbar.show({
                                    text: 'استدیو شما با موفقیت ایجاد شد',
                                    actionText: 'تشکر',
                                    actionTextColor: '#1f8a02',
                                    onClose : function (element) {
                                        $(location).attr("href","profile_my_studios.html");
                                    }
                                });
                            }
                        }
                    } else {
                        const messages = response.messages;
                        Snackbar.show({
                            text: messages[0],
                            actionText: '',
                            backgroundColor: "#cb1213",
                            pos: 'bottom-right'
                        });
                    }
                }
            }
        });
    });


// $("table tbody").on("click",".table-link-single , .table-link-edit",function (e) {
//     e.preventDefault();
//     const dataId = $(this).closest("tr").attr("data-id");
//     localStorage.setItem("data-id",dataId);
//     $(location).attr("href",$(this).attr("href"))
// });

});