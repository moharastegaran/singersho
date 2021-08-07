let studioMultiFileUploadContainer = new FileUploadWithPreview('studioImagesFileContainer');

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
        },
        error: function (error) {
            console.log("error : " + JSON.stringify(error))
        },
        success: function (response) {
            if (typeof response === 'object' && response !== null) {
                if (!response.error) {
                    const studioImages = $("input[type='file']").get(0).files;
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
                                        if (response.error) {
                                            isOk = false;
                                            console.log(JSON.stringify(response));
                                            Snackbar.show({
                                                text: response.messages[0],
                                                actionText: '',
                                                backgroundColor: "#cb1213",
                                                pos: 'bottom-right'
                                            });
                                        }
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
                                    $(location).attr("href","studio.html");
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

$(window).on("load", function () {

    // $.get()

    // $.ajax({
    //     async : false,
    //     method : "GET",
    //     url : __url__+"/studio/my",
    //     headers : {
    //         authorization : "Bearer "+localStorage.getItem("accessToken")
    //     },
    //     success : function (response) {
    //         const studios = response.studios;
    //         if(studios.length > 0) {
    //             for (let i = 0; i < studios.length; i++) {
    //                 let viewable_html = "<tr data-id='" + studios[i].id + "'>\n";
    //                 viewable_html += "<td><div class='main__table-text main__table-text--number'><a href='javascript:void(0)'>" + studios[i].id + "</a></div></td>\n";
    //                 viewable_html += "<td><label class='switch s-success mr-2'><input type='checkbox' " + (studios[i].is_active === 1 ? 'checked' : '') + "><span class='slider round'></span></label></td>\n";
    //                 viewable_html += "<td><div class='main__table-text'>" + studios[i].name + "</div></td>\n";
    //                 // viewable_html +="<td><div class='main__table-text'>"+studios[i].address+"</div></td>\n";
    //                 viewable_html += "<td><div class='main__table-text main__table-text--price'>" + studios[i].price + " تومان</div></td>\n";
    //                 if (studios[i].status === "PENDING") {
    //                     viewable_html += "<td><div class='main__table-text main__table-text--grey'>\n" +
    //                         "           <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path d='M12,2A10,10,0,1,0,22,12,10.01114,10.01114,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.00917,8.00917,0,0,1,12,20ZM14.09814,9.63379,13,10.26807V7a1,1,0,0,0-2,0v5a1.00025,1.00025,0,0,0,1.5.86621l2.59814-1.5a1.00016,1.00016,0,1,0-1-1.73242Z'></path>" +
    //                         "           </svg>در انتظار تایید</div></td>\n";
    //                 } else if (studios[i].status === "APPROVAL") {
    //                     viewable_html += "<td><div class='main__table-text main__table-text--green'>\n" +
    //                         "           <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path d='M14.72,8.79l-4.29,4.3L8.78,11.44a1,1,0,1,0-1.41,1.41l2.35,2.36a1,1,0,0,0,.71.29,1,1,0,0,0,.7-.29l5-5a1,1,0,0,0,0-1.42A1,1,0,0,0,14.72,8.79ZM12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z'/>\n" +
    //                         "           </svg>تایید شده</div></td>\n";
    //                 } else {
    //                     viewable_html += "<td><div class='main__table-text main__table-text--red'>\n" +
    //                         "           <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path d='M15.71,8.29a1,1,0,0,0-1.42,0L12,10.59,9.71,8.29A1,1,0,0,0,8.29,9.71L10.59,12l-2.3,2.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l2.29,2.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42L13.41,12l2.3-2.29A1,1,0,0,0,15.71,8.29Zm3.36-3.36A10,10,0,1,0,4.93,19.07,10,10,0,1,0,19.07,4.93ZM17.66,17.66A8,8,0,1,1,20,12,7.95,7.95,0,0,1,17.66,17.66Z'></path></svg>\n" +
    //                         "           </svg>تایید نشده</div></td>\n";
    //                 }
    //                 viewable_html += '<td><a href="#modal-delete-studio" class="open-modal" \n' +
    //                     '            onclick="$(this).closest(\'tr\').addClass(\'deletable\');">\n' +
    //                     '            <svg xmlns="http:www.w3.org/2000/svg" viewBox="0 0 24 24"\n' +
    //                     '            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"\n' +
    //                     '            stroke-linejoin="round" width="23" class="feather feather-trash">\n' +
    //                     '            <polyline points="3 6 5 6 21 6"></polyline>' +
    //                     '            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>\n' +
    //                     '            </svg></a></td>';
    //                 viewable_html += "</tr>\n";
    //                 $(".studios_table").append(viewable_html);
    //             }
    //         }else{
    //             $(".studios_table").parent().append("<div class='alert alert-outline-info text-light'>تا کنون استدیو ایجاد نکرده اید.</div>")
    //             $(".studios_table").remove();
    //         }
    //     },
    //     error : function (error) {
    //         console.log("error : "+JSON.stringify(error));
    //     }
    // });
});

$(".studios_table").on("change","input[type='checkbox']",function () {
    const rowId=$(this).closest("tr").attr("data-id");
    const isChecked = $(this).is(":checked");
    $.ajax({
        async : false,
        method : "PATCH",
        url : __url__+"/studio/"+rowId+"/activation",
        headers : {
            authorization : "Bearer "+localStorage.getItem("accessToken")
        },
        data : {
            is_active : (isChecked ? 1 : 0)
        },
        success : function (response) {
//                console.log("successs "+JSON.stringify(response));
        },
        error : function (error) {
            console.log("error : "+JSON.stringify(error));
        }
    });
});

// $("table tbody").on("click",".table-link-single , .table-link-edit",function (e) {
//     e.preventDefault();
//     const dataId = $(this).closest("tr").attr("data-id");
//     localStorage.setItem("data-id",dataId);
//     $(location).attr("href",$(this).attr("href"))
// });

$(".modal .btn-delete-studio").on("click",function (e) {
    e.preventDefault();
    const dataId = $("tr.deletable").data("id");
    console.log("dataId : "+dataId);
    $.ajax({
        async : false,
        method : "DELETE",
        url : __url__+"/studio/"+dataId,
        headers : {
            authorization : "Bearer "+localStorage.getItem("accessToken")
        },
        success : function (response) {
            if (typeof response === 'object' && response !== null){
                let backColor="";
                if(!response.error){
                    $("tr.deletable").remove();
                }else{
                    $("tr.deletable").removeClass("deletable");
                }
                $.magnificPopup.close();
            }
        }
    })
})