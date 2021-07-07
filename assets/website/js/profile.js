// const userProfileAvatarUpload = new FileUploadWithPreview('userProfileAvatar');
const userExperienceThumbnailUpload = new FileUploadWithPreview('userExperienceThumbnail');
let portfolioType = "URL";
let is_artist = false,user_first_name,user_last_name,user_email,user_melli_code,artist_advise_price;

let focusedPortfolioRow = null, focusedPortfolioIndex = -1;
let focusedTitleRow = null, focusedTitleIndex = -1;
let prev = null;


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
                                "                                        <div class=\"col-3\">\n" +
                                "                                            <h4 class='name'>" + title_text + "</h4>\n" +
                                "                                        </div>\n" +
                                "                                        <div class=\"col-3 fa-number d-flex align-items-center\">\n" +
                                "                                           <label class=\"switch s-success mr-2 mb-0\">\n" +
                                "                                                <input type=\"checkbox\" class='accept_order' " + (accept_order === 1 ? 'checked' : '') + " disabled><span class=\"slider round\"></span>\n" +
                                "                                           </label><span class='order_price mx-1'>" + order_price + "</span>" + " تومان " +
                                "                                        </div>\n" +
                                "                                        <div class=\"col-5\">\n" +
                                "                                            <p class=\"mb-0 description\">" + description + "</p>\n" +
                                "                                        </div>\n" +
                                "                                        <div class=\"col-1\">\n" +
                                "                                            <div class=\"row\">\n" +
                                "                                                <a class=\"col px-0 text-center\" href=\"javascript:void(0);\"\n" +
                                "                                                   onclick='editTitleRow(this)'>\n" +
                                "                                                    <svg width=\"28\" xmlns=\"http://www.w3.org/2000/svg\"\n" +
                                "                                                         viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\"\n" +
                                "                                                         stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"\n" +
                                "                                                         class=\"feather feather-edit-2 px-1 text-warning\">\n" +
                                "                                                        <path d=\"M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z\"></path>\n" +
                                "                                                    </svg>\n" +
                                "                                                </a>\n" +
                                "                                                <a class=\"col px-0 text-center open-modal\" " +
                                "                                                   href=\"#modal-delete-title-portfolio\"\n" +
                                "                                                   onclick=\"$(this.closest('li')).addClass('deletable')\">\n" +
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
                                "                                        <div class=\"col-2\">\n" +
                                "                                            <img src='" + (('image' in response.portfolio[0]) ? response.portfolio[0].image : '../../assets/img/90x90.jpg') + "' class=\"rounded-circle image\" width=\"50\" height=\"50\">\n" +
                                "                                        </div>\n" +
                                "                                        <div class=\"col-9\">\n" +
                                "                                            <h4 class='name'>" + response.portfolio[0].name + "</h4>\n" +
                                "                                            <p>تاریخ انتشار: <span class=\"fa-number date\">" + response.portfolio[0].date + "</span></p>\n" +
                                // "                                            <div class=\"d-flex flex-row justify-content-start align-items-center badges\">\n" + typesHtml + "</div>\n" +
                                "                                            <p class=\"description\">" + response.portfolio[0].description + "</p>\n" +
                                "                                            <p class=\"sr-only url\">" + response.portfolio[0].url + "</p>\n" +
                                "                                            <p class=\"sr-only type\">" + response.portfolio[0].type + "</p>\n" +
                                "                                        </div>\n" +
                                "                                        <div class=\"col-1\">\n" +
                                "                                            <div class=\"row\">\n" +
                                "                                                <a class=\"col px-0 text-center\" href=\"javascript:void(0);\" onclick='editPortfolioRow(this)'>\n" +
                                "                                                    <svg width=\"28\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-edit-2 px-1 text-warning\">\n" +
                                "                                                        <path d=\"M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z\"></path>\n" +
                                "                                                    </svg>\n" +
                                "                                                </a>\n" +
                                "                                                <a class=\"col px-0 text-center open-modal\"" +
                                "                                                       onclick=\"$(this.closest('li')).addClass('deletable')\" " +
                                "                                                       href=\"#modal-delete-title-portfolio\">\n" +
                                "                                                    <svg width=\"28\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-trash text-dark p-1\">\n" +
                                "                                                        <polyline points=\"3 6 5 6 21 6\"></polyline>\n" +
                                "                                                        <path d=\"M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2\"></path>\n" +
                                "                                                    </svg>\n" +
                                "                                                </a>\n" +
                                "                                            </div>\n" +
                                "                                        </div>\n" +
                                "                                    </li>");
                        }
                    }
                }, error: function (error) {
                    console.log("error : " + JSON.stringify(error));
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
    form.find("[name='url']").val(url);
    // form.find("[name='description']").val(description);
    if (type === 'Sound')
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

function updateUserData($input,$expected_value){
    if($input.val()!==$expected_value){
        let formData = {};
        formData[$input.attr('name')] = $input.val();
        $.ajax({
            method : 'PATCH',
            url : 'https://8b71e6d6216f.ngrok.io/api/'+$input.attr('name'),
            data : formData,
            success : function (response){
                if (typeof response === 'object' && response !== null){
                    $input.siblings(".input-error").remove();
                    if (response.error){
                        $input.after("<span class='input-error text-danger'>"+response.messages[0]+"</span>")
                    }
                }
            }
        });
    }
}

$(window).on("load", function () {

    $("#userAddTitleForm textarea[name='description']").maxlength({
        warningClass: "badge badge-secondary",
        limitReachedClass: "badge badge-warning",
        alwaysShow: true
    });

    $.ajaxSetup({
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', "Bearer " + localStorage.getItem("accessToken"));
        }
    });

    $.ajax({
        async: false,
        method: "GET",
        url: __url__+"/me",
        success: function (response) {
            if (typeof response === 'object' && response !== null) {
                if (!response.error) {
                    $(".user.full_name").text(response.data.user.first_name + ' ' + response.data.user.last_name);
                    $("#tab-user-profile-section input[name='first_name']").val(user_first_name=response.data.user.first_name);
                    $("#tab-user-profile-section input[name='last_name']").val(user_last_name=response.data.user.last_name);
                    $("#tab-user-profile-section input[name='email']").val(user_email=response.data.user.email);
                    $("#tab-user-profile-section input[name='melli_code']").val(user_melli_code=response.data.user.melli_code);

                    is_artist = response.data.is_artist;

                    if (response.data.is_artist) {

                        const artist = response.data.other_info.artist[0];
                        $("._artist.id").text("شناسه کاربری : "+artist.id);
                        $("[name='is_artist']").prop("checked", true);
                        $("#tab-user-profile-section").find(".col-lg-7").removeClass("d-none");
                        $(".is-artist-pending").removeClass("d-none");
                        $("#tab-user-profile-section input[name='is_advisor']").prop("checked", artist.is_advisor === 1);
                        $("#tab-user-profile-section input[name='advise_price']").val(artist_advise_price=artist.advise_price);
                        // if(artist.hasOwnProperty('avatar') && artist.avatar != null){
                        //     // $("#tab-user-profile-section input[name='advise_price']").a()
                        // }
                        if (artist.is_advisor === 1) {
                            $("#AdvisorPriceContainer").collapse("show");
                        }

                        const titles = response.data.other_info.titles;
                        if (titles.length > 0) {
                            $(".title-list-empty").addClass("d-none");
                            for (let i = 0; i < titles.length; i++) {
                                $(".title-list").append("" +
                                    "<li class=\"title-list-item\" data-id=\"" + titles[i].pivot.title_id + "\">\n" +
                                    "                                        <div class=\"col-3\">\n" +
                                    "                                            <h4 class='name'>" + titles[i].name + "</h4>\n" +
                                    "                                        </div>\n" +
                                    "                                         <div class=\"col-3 fa-number d-flex align-items-center\">\n" +
                                    "                                           <label class=\"switch s-success mr-2 mb-0\">\n" +
                                    "                                                <input type=\"checkbox\" class='accept_order' " + (titles[i].pivot.accept_order === 1 ? 'checked' : '') + " disabled><span class=\"slider round\"></span>\n" +
                                    "                                           </label><span class='order_price mx-1'>" + titles[i].pivot.order_price + "</span>" + " تومان " +
                                    "                                        </div>\n" +
                                    "                                        <div class=\"col-5\">\n" +
                                    "                                            <p class=\"mb-0 description\">" + titles[i].pivot.description + "</p>\n" +
                                    "                                        </div>\n" +
                                    "                                        <div class=\"col-1\">\n" +
                                    "                                            <div class=\"row\">\n" +
                                    "                                                <a class=\"col px-0 text-center\" href=\"javascript:void(0);\"\n" +
                                    "                                                   onclick='editTitleRow(this)'>\n" +
                                    "                                                    <svg width=\"28\" xmlns=\"http://www.w3.org/2000/svg\"\n" +
                                    "                                                         viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\"\n" +
                                    "                                                         stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"\n" +
                                    "                                                         class=\"feather feather-edit-2 px-1 text-warning\">\n" +
                                    "                                                        <path d=\"M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z\"></path>\n" +
                                    "                                                    </svg>\n" +
                                    "                                                </a>\n" +
                                    "                                                <a class=\"col text-center px-0 open-modal\" " +
                                    "                                                   href=\"#modal-delete-title-portfolio\"\n" +
                                    "                                                   onclick=\"$(this.closest('li')).addClass('deletable');\" >\n" +
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
                            }
                        }


                        const portfolio = response.data.other_info.portfolio;
                        if (portfolio.length > 0) {
                            $(".portfolio-list-empty").addClass("d-none");
                            for (let i = 0; i < portfolio.length; i++) {
                                $(".portfolio-list").append("" +
                                    "<li class=\"portfolio-list-item\" data-id=\"" + portfolio[i].id + "\">\n" +
                                    "                                        <div class=\"col-2\">\n" +
                                    "                                            <img src='" + (('image' in portfolio[i]) ? portfolio[i].image : '../../assets/img/90x90.jpg') + "' class=\"rounded-circle image\" width=\"50\" height=\"50\">\n" +
                                    "                                        </div>\n" +
                                    "                                        <div class=\"col-9\">\n" +
                                    "                                            <h4 class='name'>" + portfolio[i].name + "</h4>\n" +
                                    "                                            <p>تاریخ انتشار: <span class=\"fa-number date\">" + portfolio[i].date + "</span></p>\n" +
                                    // "                                            <div class=\"d-flex flex-row justify-content-start align-items-center badges\">\n" + typesHtml + "</div>\n" +
                                    "                                            <p class=\"description\">" + portfolio[i].description + "</p>\n" +
                                    "                                            <p class=\"sr-only url\">" + portfolio[i].url + "</p>\n" +
                                    "                                            <p class=\"sr-only type\">" + portfolio[i].type + "</p>\n" +
                                    "                                        </div>\n" +
                                    "                                        <div class=\"col-1\">\n" +
                                    "                                            <div class=\"row\">\n" +
                                    "                                                <a class=\"col px-0 text-center\" href=\"javascript:void(0);\" onclick='editPortfolioRow(this)'>\n" +
                                    "                                                    <svg width=\"28\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-edit-2 px-1 text-warning\">\n" +
                                    "                                                        <path d=\"M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z\"></path>\n" +
                                    "                                                    </svg>\n" +
                                    "                                                </a>\n" +
                                    "                                                 <a class=\"col px-0 text-center open-modal\" " +
                                    "                                                       href=\"#modal-delete-title-portfolio\"" +
                                    "                                                       onclick=\"$(this.closest('li')).addClass('deletable')\">\n" +
                                    "                                                    <svg width=\"28\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-trash text-dark p-1\">\n" +
                                    "                                                        <polyline points=\"3 6 5 6 21 6\"></polyline>\n" +
                                    "                                                        <path d=\"M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2\"></path>\n" +
                                    "                                                    </svg>\n" +
                                    "                                                </a>\n" +
                                    "                                            </div>\n" +
                                    "                                        </div>\n" +
                                    "                                    </li>");
                            }
                        }
                    } else {
                        $("#tab-user-profile-section").find(".col-lg-7").remove();
                    }
                }
            }
        },
        error: function (xhr) {
            console.log("error : " + xhr);
        }
    });

    $.get(__url__+"/titles", function (response) {
        if (typeof response === 'object' && response !== null) {
            const titles = response.titles;
            if (titles !== null) {
                for (let i = 0; i < titles.length; i++)
                    $("#userAddTitleForm select").append($("<option value='" + titles[i].id + "'>" + titles[i].name + "</option>"));

            }
        }
    });

});

$(document).ready(function (){
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

    $("#userAddTitleForm , #userAddExperienceForm").on("hide.bs.collapse", function (e) {
        if ($(this).hasClass("no-collapse")) {
            e.preventDefault();
        }
    });

    $("#userAddTitleForm").on("show.bs.collapse hide.bs.collapse", function () {
        $(".btn-title-toggle").toggleClass("d-none");
    });

    $("#userAddExperienceForm").on("show.bs.collapse hide.bs.collapse", function () {
        $(".btn-portfolio-toggle").toggleClass("d-none");
    });

    $("#modal-delete-profile").on("show.bs.modal", function () {
        if ($("li.deletable").hasClass("title-list-item")) {
            console.log("list-item");
            $(this).find(".modal-title").text("حذف مهارت");
            $(this).find(".modal-body .modal-text").text("آیا از حذف این مهارت مطمئن هستید؟");
        } else if ($("li.deletable").hasClass("portfolio-list-item")) {
            console.log("experience-item");
            $(this).find(".modal-title").text("حذف نمونه کار");
            $(this).find(".modal-body .modal-text").text("آیا از حذف این نمونه کار مطمئن هستید؟");
        }
    });

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
        portfolioType = (portfolioType === "URL") ? "Sound" : "URL";
        prev = $(this);
    });

    $("input[name='is_artist']").on("click", function () {
        const isChecked = $(this).is(":checked");
        console.log("chnged");
        if (isChecked && !is_artist) {
            console.log("call ajax")
            $.ajax({
                method: 'PUT',
                url: 'https://8b71e6d6216f.ngrok.io/api/artist/register',
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
        }
    });

    $("input[name='is_advisor']").on("click", function () {
        const isChecked = $(this).is(":checked");
        $.ajax({
            method: 'PATCH',
            url: 'https://8b71e6d6216f.ngrok.io/api/accept_advisor',
            data: {
                _method: 'PATCH'
            },
            success: function (response) {
                if (typeof response === 'object' && response !== null) {
                    if (!response.error) {
                        console.log(JSON.stringify(response));
                    }
                }
            }
        });
    });

    $("input[name='first_name']").on("blur",function (){
        updateUserData($(this),user_first_name);
    });
    $("input[name='last_name']").on("blur",function (){
        updateUserData($(this),user_last_name);
    });
    $("input[name='email']").on("blur",function (){
        updateUserData($(this),user_email);
    });
    $("input[name='melli_code']").on("blur",function (){
        updateUserData($(this),user_melli_code);
    });
    $("input[name='advise_price']").on("blur",function (){
        updateUserData($(this),artist_advise_price);
    });

})
