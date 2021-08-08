const userExperienceThumbnailUpload = new FileUploadWithPreview('userExperienceThumbnail');
let portfolioType = "url";

let focusedPortfolioRow = null, focusedPortfolioIndex = -1;
let focusedTitleRow = null, focusedTitleIndex = -1;

function addEditTitleRow(e) {
    e.preventDefault();

    console.log("focused Title Index : " + focusedTitleIndex);
    const form = $("#userAddTitleForm");
    const title_value = form.find("[name='name']").val();
    const title_text = form.find("[name='name'] option:selected").text();
    const description = form.find("[name='description']").val();
    const accept_order = form.find("[name='accept_order']").is(":checked") ? 1 : 0;
    const order_price = form.find("[name='order_price']").val();

    let hasError = false;
    if (true) {
        if (focusedTitleIndex === -1) {
            $.ajax({
                async: false,
                method: "POST",
                url: __url__+"/title/artist",
                data: {
                    title_id: title_value,
                    description: description,
                    accept_order: accept_order,
                    order_price: order_price
                },
                success: function (response) {
                    if (typeof response === 'object' && response !== null) {
                        if (response.error) {
                            hasError = true;
                            form.addClass("no-collapse");
                            form.find(".form-errors").remove();
                            form.prepend($("<div></div>").addClass("form-errors col-12"));
                            for (let i = 0; i < response.messages.length; i++) {
                                $(".form-errors").append(
                                    $("<div></div>")
                                        .addClass("input-error text-danger my-2")
                                        .text(response.messages[i]))
                            }
                        } else {
                            hasError = false;
                            form.removeClass("no-collapse");
                            form.find(".for-errors").remove();
                            $(".title-list").append("" +
                                "<li class=\"title-list-item\" data-id=\"" + response.new_title.title_id + "\">\n" +
                                "                                        <div class=\"col-md-3 col-4 text-left px-1\">\n" +
                                "                                            <h4 class='name'>" + title_text + "</h4>\n" +
                                "                                        </div>\n" +
                                "                                        <div class=\"col-md-3 col-5 fa-number d-flex flex-column flex-wrap justify-content-start align-items-start px-1\">\n" +
                                "                                           <label class=\"switch s-success mr-2 mb-0\">\n" +
                                "                                                <input type=\"checkbox\" class='accept_order' " + (accept_order === 1 ? 'checked' : '') + " disabled><span class=\"slider round\"></span>\n" +
                                "                                           </label><span><span class='order_price mx-1'>" + order_price + "</span>" + "تومان </span> " +
                                "                                        </div>\n" +
                                "                                        <div class=\"col-4 d-md-block d-none px-1\">\n" +
                                "                                            <p class=\"description\">" + description + "</p>\n" +
                                "                                        </div>\n" +
                                "                                        <div class=\"col-md-2 col-3 px-1\">\n" +
                                "                                            <div class=\"d-flex flex-row justify-content-end\">\n" +
                                "                                                <a href=\"javascript:void(0);\"\n" +
                                "                                                   onclick='editTitleRow(this)'>\n" +
                                "                                                    <svg width=\"28\" xmlns=\"http://www.w3.org/2000/svg\"\n" +
                                "                                                         viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\"\n" +
                                "                                                         stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"\n" +
                                "                                                         class=\"feather feather-edit-2 px-1 text-warning\">\n" +
                                "                                                        <path d=\"M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z\"></path>\n" +
                                "                                                    </svg>\n" +
                                "                                                </a>\n" +
                                "                                                <a class=\"open-delete-modal\" " +
                                "                                                   href=\"#modal-delete-title-portfolio\">\n" +
                                "                                                    <svg width=\"28\" xmlns=\"http://www.w3.org/2000/svg\"\n" +
                                "                                                         viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\"\n" +
                                "                                                         stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"\n" +
                                "                                                         class=\"feather feather-trash text-dark px-1\">\n" +
                                "                                                        <polyline points=\"3 6 5 6 21 6\"></polyline>\n" +
                                "                                                        <path d=\"M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2\"></path>\n" +
                                "                                                    </svg>\n" +
                                "                                                </a>\n" +
                                "                                            </div>\n" +
                                "                                        </div>\n" +
                                "                                    </li>");
                            $(".open-delete-modal").magnificPopup({
                                fixedContentPos: true,
                                fixedBgPos: true,
                                overflowY: 'auto',
                                type: 'inline',
                                preloader: false,
                                modal: false,
                                removalDelay: 300,
                                mainClass: 'my-mfp-zoom-in',
                            });
                        }
                    }
                },
                error: function (error) {
                    console.log("error : " + JSON.stringify(error));
                }
            });
        } else {
            // update current row;
            $.ajax({
                async: false,
                method: "PATCH",
                url: __url__+"/title/artist/edit/" + focusedTitleIndex,
                data: {
                    _method : 'PATCH',
                    description: description,
                    accept_order: accept_order,
                    order_price: order_price
                }, success: function (response) {
                    console.log("response " + JSON.stringify(response));
                    if (typeof response === 'object' && response !== null) {
                        if (!response.error) {
                            hasError = false;
                            $("#userAddTitleForm").removeClass("no-collapse");
                            $(focusedTitleRow).find(".name").text(response.title.title_name);
                            $(focusedTitleRow).find(".description").text(response.title.description);
                            $(focusedTitleRow).find(".accept_order").prop("checked", response.title.accept_order === "1");
                            $(focusedTitleRow).find(".order_price").text(response.title.order_price);
                        } else {
                            hasError = true;
                            $("#userAddTitleForm").addClass("no-collapse");
                            Snackbar.show({
                                text: response.messages[0],
                                actionText: '',
                                backgroundColor: "#cb1213",
                                pos: 'bottom-right'
                            });
                        }
                    }
                }
            });
        }
        if (!hasError) {
            if ($("li.title-list-item").length > 0) $(".title-list-empty").addClass("d-none");
            form.collapse("hide");
            form.find("input,textarea").val("");
            form.find("select").val('').trigger('change');
        }
    }
}

function editTitleRow(current) {
    const form = $("#userAddTitleForm");
    focusedTitleRow = current.closest("li.title-list-item");
    focusedTitleIndex = $(focusedTitleRow).attr("data-id");
    $("li.title-list-item").removeClass("focus");
    $(focusedTitleRow).addClass("focus");
    form.collapse("show");
    console.log("focused title index : " + focusedTitleIndex);

    const accept_order = $(focusedTitleRow).find(".accept_order").is(":checked");
    const order_price = $(focusedTitleRow).find(".order_price").text();
    const description = $(focusedTitleRow).find(".description").text();

    form.find("[name='name']").val(focusedTitleIndex).prop("disabled", "disabled");
    form.find("[name='description']").val(description);
    form.find("[name='accept_order']").prop("checked", accept_order);
    form.find("[name='order_price']").val(order_price);
}

function deleteTitleRow(current) {
    const dataId = current.attr("data-id");
    $.ajax({
        async: false,
        method: "DELETE",
        url: __url__+"/title/artist/" + dataId,
        success: function (response) {
            current.remove();
            if ($(".title-list-item").length < 1) {
                $(".title-list-empty").removeClass("d-none");
            }
        },
        error: function (error) {
            console.log("error : " + JSON.stringify(error));
        }
    });
}

function addPortfolioRow(e) {
    e.preventDefault();

    console.log("focusedIndex : " + focusedPortfolioIndex);
    const form = $("#userAddExperienceForm");
    const name = form.find("[name='name']").val();
    const date = form.find("[name='date']").val();
    const url = form.find("[name='url']").val();
    const description = form.find("[name='description']").val();

    let formData = new FormData();
    formData.append("name", name);
    formData.append("date", date);
    formData.append("type", portfolioType);
    formData.append("url", url);
    formData.append("description", description);
    if (form.find("[name='image']").get(0).files.length > 0)
        formData.append("image", form.find("[name='image']").get(0).files[0]);
    if (form.find("[name='sound']").get(0).files.length > 0)
        formData.append("sound", form.find("[name='sound']").get(0).files[0]);

    console.log(...formData);
    console.log("********************");

    let hasError = false;

    if (true) {

        if (focusedPortfolioIndex === -1) {
            $.ajax({
                async: false,
                method: "POST",
                url: __url__+"/portfolio/artist",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    console.log("response : " + JSON.stringify(response));
                    if (typeof response === 'object' && response !== null) {
                        if (response.error) {
                            hasError = true;
                            form.addClass("no-collapse");
                            let errors = response.messages;
                            form.find(".form-errors").remove();
                            form.prepend($("<div></div>").addClass("form-errors col-12"));
                            for (let i = 0; i < errors.length; i++) {
                                $(".form-errors").append(
                                    $("<div></div>")
                                        .addClass("input-error text-danger my-2")
                                        .text(errors[i]))
                            }
                        } else {
                            hasError = false;
                            form.removeClass("no-collapse");
                            form.find(".form-errors").remove();
                            $(".portfolio-list").append("" +
                                "<li class=\"portfolio-list-item\" data-id=\"" + response.portfolio[0].id + "\">\n" +
                                "                                        <div class=\"col-md-2 col-3 px-1\">\n" +
                                "                                            <img src='" + (('image' in response.portfolio[0]) ? response.portfolio[0].image : '../../assets/img/90x90.jpg') + "' class=\"rounded-circle image\" width=\"50\" height=\"50\">\n" +
                                "                                        </div>\n" +
                                "                                        <div class=\"col-md-8 col-6 px-1\">\n" +
                                "                                            <h4 class='name'>" + response.portfolio[0].name + "</h4>\n" +
                                "                                            <p>تاریخ انتشار: <span class=\"fa-number date\">" + response.portfolio[0].date + "</span></p>\n" +
                                // "                                            <div class=\"d-flex flex-row justify-content-start align-items-center badges\">\n" + typesHtml + "</div>\n" +
                                "                                            <p class=\"description\">" + response.portfolio[0].description + "</p>\n" +
                                "                                            <p class=\"sr-only url\">" + response.portfolio[0].url + "</p>\n" +
                                "                                            <p class=\"sr-only type\">" + response.portfolio[0].type + "</p>\n" +
                                "                                        </div>\n" +
                                "                                        <div class=\"col-md-2 col-3 px-1\">\n" +
                                "                                            <div class=\"d-flex flex-row justify-content-end\">\n" +
                                "                                                <a href=\"javascript:void(0);\" onclick='editPortfolioRow(this)'>\n" +
                                "                                                    <svg width=\"28\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-edit-2 px-1 text-warning\">\n" +
                                "                                                        <path d=\"M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z\"></path>\n" +
                                "                                                    </svg>\n" +
                                "                                                </a>\n" +
                                "                                                 <a class=\"open-delete-modal\" " +
                                "                                                   href=\"#modal-delete-title-portfolio\">\n" +
                                "                                                    <svg width=\"28\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-trash text-dark px-1\">\n" +
                                "                                                        <polyline points=\"3 6 5 6 21 6\"></polyline>\n" +
                                "                                                        <path d=\"M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2\"></path>\n" +
                                "                                                    </svg>\n" +
                                "                                                </a>\n" +
                                "                                            </div>\n" +
                                "                                        </div>\n" +
                                "                                    </li>");
                            $(".open-delete-modal").magnificPopup({
                                fixedContentPos: true,
                                fixedBgPos: true,
                                overflowY: 'auto',
                                type: 'inline',
                                preloader: false,
                                modal: false,
                                removalDelay: 300,
                                mainClass: 'my-mfp-zoom-in',
                            });
                        }
                    }
                }, error: function (error) {
                    console.log("error : " + JSON.stringify(error) );
                }
            });
        } else {
            $.ajax({
                async: false,
                method: "POST",
                url: __url__+"/portfolio/artist/edit/" + focusedPortfolioIndex,
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    console.log("res : " + JSON.stringify(response));
                    if (typeof response === 'object' && response !== null) {
                        if (response.error) {
                            hasError = true;
                            form.addClass("no-collapse");
                            Snackbar.show({
                                text: response.messages[0],
                                actionText: '',
                                backgroundColor: "#cb1213",
                                pos: 'bottom-right'
                            });
                        } else {
                            hasError = false;
                            form.removeClass("no-collapse");
                            $(focusedPortfolioRow).find(".name").text(response.portfolio[0].name);
                            $(focusedPortfolioRow).find(".date").text(response.portfolio[0].date);
                            $(focusedPortfolioRow).find(".description").text(response.portfolio[0].description);
                            $(focusedPortfolioRow).find(".url").text(response.portfolio[0].url);
                            $(focusedPortfolioRow).find(".type").text(response.portfolio[0].type);
                            $(focusedPortfolioRow).find(".image").attr("src", response.portfolio[0].image);
                        }
                    }
                }, error: function (error) {
                    console.log("error : " + JSON.stringify(error));
                }
            });
        }
    }

    if (!hasError) {
        $(".portfolio-list-empty").addClass("d-none");
        $("#userAddExperienceForm").collapse("hide");
        userExperienceThumbnailUpload.clearPreviewPanel();
        $("#userAddExperienceForm").find("input,textarea").val(null);
    }
}

function editPortfolioRow(current) {

    const form = $("#userAddExperienceForm");
    focusedPortfolioRow = current.closest("li.portfolio-list-item");
    focusedPortfolioIndex = $(focusedPortfolioRow).attr("data-id");
    $("li.portfolio-list-item").removeClass("focus");
    $(focusedPortfolioRow).addClass("focus");
    form.collapse("show");

    const name = $(focusedPortfolioRow).find(".name").text();
    const date = $(focusedPortfolioRow).find(".date").text();
    const description = $(focusedPortfolioRow).find(".description").text();
    const url = $(focusedPortfolioRow).find(".url").text();
    const type = $(focusedPortfolioRow).find(".type").text();

    form.find("[name='name']").val(name);
    form.find("[name='date']").val(date);
    form.find("[name='description']").val(description);
    form.find("[name='url']").val(url!=null ? url : null);
    // form.find("[name='description']").val(description);
    if (type === 'sound')
        form.find(".nav-pills a:last-child").tab("show");
    userExperienceThumbnailUpload.addImagesFromPath([$(focusedPortfolioRow).find(".image").attr("src")]);
}

function deletePortfolioRow(current) {
    const dataId = current.attr("data-id");
    $.ajax({
        async: false,
        method: "DELETE",
        url: __url__+"/portfolio/artist/" + dataId,
        success: function (response) {
            current.remove();
            if ($(".portfolio-list-item").length < 1) {
                $(".portfolio-list-empty").removeClass("d-none");
            }
        },
        error: function (error) {
            console.log("error : " + JSON.stringify(error));
        }
    });
}

function getFocusedIndexOf(selector) {
    let i = -1;
    $(selector).each(function (index, dom) {
        if ($(dom).hasClass("focus")) {
            i = index;
        }
    });
    return i;
}

function showDeleteModal($this) {
    $($this.closest("li")).addClass("deletable");
    $("#modal-delete-profile").modal('show');
}

$("#userAddTitleForm").on("show.bs.collapse hide.bs.collapse", function () {
    $(".btn-title-toggle").toggleClass("d-none");
});

$("#userAddExperienceForm").on("show.bs.collapse hide.bs.collapse", function () {
    $(".btn-portfolio-toggle").toggleClass("d-none");
});

$(window).on("load", function () {

    $.get(__url__+"/titles", function (response) {
        if (typeof response === 'object' && response !== null) {
            const titles = response.titles.data;
            if (titles !== null) {
                for (let i = 0; i < titles.length; i++)
                    $("#userAddTitleForm select").append($("<option value='" + titles[i].id + "'>" + titles[i].name + "</option>"));
            }
        }
    });

});

$(document).ready(function (){

    $("#userAddExperienceForm .custom-file-container__image-preview").css({
        backgroundImage : "url(assets/website/img/portfolio.svg)",
        marginTop : "50px"
    })

    // $("#userExperienceDate").persianDatepicker({
    //     months: ["فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند"],
    //     dowTitle: ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه"],
    //     shortDowTitle: ["ش", "ی", "د", "س", "چ", "پ", "ج"],
    //     showGregorianDate: !0,
    //     persianNumbers: !1,
    //     formatDate: "YYYY/MM/DD",
    //     prevArrow: '\u25c4',
    //     nextArrow: '\u25ba',
    // });

    // $("#profile__tabs a.nav-link").on("click",function (e){
    //     e.preventDefault();
    //     const _this = $(this);
    //     const _target = $(_this.attr('href'));
    //     const _oldActiveTab = _this.parent().siblings('.active').find('a');
    //     const _oldTarget = $(_oldActiveTab.attr('href'));
    //
    //     if(!_this.hasClass('loaded') && _this.data('content')){
    //         const dataContent = _this.data('content');
    //         $.ajax({
    //             url : dataContent,
    //         }).done(function (response){
    //             _target.empty();
    //             _target.append(response);
    //             _this.addClass('loaded')
    //         })
    //     }
    //
    // });

    $("#modal-delete-title-portfolio .btn-delete-title-portfolio").on("click", function () {
        if ($("li.deletable").hasClass("title-list-item")) {
            deleteTitleRow($("li.deletable"));
        } else if ($("li.deletable").hasClass("portfolio-list-item")) {
            deletePortfolioRow($("li.deletable"));
        }
        $.magnificPopup.close();
    });

    $(".nav-pills a").on("click", function () {
        if (prev !== null && $(this).find("img").attr("src") === prev.find("img").attr("src"))
            return;
        portfolioType = (portfolioType === "url") ? "sound" : "url";
        prev = $(this);
    });

    // $("input[name='is_artist']").on("click", function () {
    //     const isChecked = $(this).is(":checked");
    //     console.log("chnged");
    //     if (isChecked && !is_artist) {
    //         console.log("call ajax")
    //         $.ajax({
    //             method: 'PUT',
    //             url: __url__+'/artist/register',
    //             data: {
    //                 _method: 'PUT'
    //             },
    //             success: function (response) {
    //                 if (typeof response === 'object' && response !== null) {
    //                     if (!response.error) {
    //                         $(location).attr('href', 'profile.html');
    //                     }
    //                 }
    //             }
    //         });
    //     }
    // });

    $("#btn-register-artist").on("click",function (e){
        e.preventDefault();
        console.log("call ajax")
        $.ajax({
            method: 'PUT',
            url: __url__+'/artist/register',
            data: {
                _method: 'PUT'
            },
            success: function (response) {
                if (typeof response === 'object' && response !== null) {
                    if (!response.error) {
                        $(location).attr('href', 'profile.html');
                    }
                }
            }
        });
    })

    $(".sign__user-studio--btn").on("click",function (){
        updateUserData(null,null,"avatar");
    });
})
