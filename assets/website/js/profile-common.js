const userProfileAvatarUpload = new FileUploadWithPreview('userProfileAvatar');
let is_artist = false, user_first_name, user_last_name, user_email, user_melli_code, artist_advise_price;
let prev = null;

function updateUserData($input, $expected_value, $urlParam = null) {
    if ($input === null || $input.val() !== $expected_value) {
        let formData = {}, urlParam;
        if ($input !== null) {
            formData[$input.attr('name')] = $input.val();
            urlParam = $input.attr('name');
        } else {
            urlParam = $urlParam;
        }
        $.ajax({
            method: 'PATCH',
            url: __url__ + '/' + urlParam,
            data: formData,
            success: function (response) {
                if (typeof response === 'object' && response !== null) {
                    if ($input !== null) {
                        $input.siblings(".input-error").remove();
                        if (response.error) {
                            $input.after("<span class='input-error text-danger'>" + response.messages[0] + "</span>")
                        }
                    } else if ($urlParam === "avatar") {
                        $(location).attr("href", "profile.html")
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

    $.get(__url__ + '/singing', function (response) {
        if (response !== null && typeof response === 'object') {
            if (!response.error) {
                if (response.tests.length > 0) {
                    const pageLink = $(location).attr('href');
                    const fileName = pageLink.substr(pageLink.lastIndexOf("/") + 1);
                    const isTabActive = fileName.indexOf("profile_singing_tests.html") >= 0;
                    $("#profile__tabs > div").append("" +
                        "<li class=\"nav-item nav-item-singing-tests\">\n" +
                        "                                <a class=\"nav-link "+(isTabActive ? 'active' : '')+"\" href=\""+(isTabActive ? '#tab-user-singing-tests-section' : 'profile_singing_tests.html')+"\"\n" +
                        "                                   aria-selected=\"true\">تست‌های خوانندگی</a>\n" +
                        "                            </li>");
                }
            }
        }
    });

    $.ajax({
        async: false,
        method: "GET",
        url: __url__ + "/me",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("accessToken")
        },
        success: function (response) {
            if (typeof response === 'object' && response !== null) {
                if (!response.error) {
                    $(".user.full_name").text(response.data.user.first_name + ' ' + response.data.user.last_name);
                    $("#tab-edit-profile input[name='first_name']").val(user_first_name = response.data.user.first_name);
                    $("#tab-edit-profile input[name='last_name']").val(user_last_name = response.data.user.last_name);
                    $("#tab-edit-profile input[name='email']").val(user_email = response.data.user.email);
                    $("#tab-edit-profile input[name='melli_code']").val(user_melli_code = response.data.user.melli_code);
                    if (response.data.user.has_studio === 1) {
                        $("#alert-sign-studio").addClass("d-none");
                    } else {
                        $("#alert-sign-studio").removeClass("d-none");
                    }

                    is_artist = response.data.is_artist;

                    if (response.data.is_artist) {
                        $(".user_is_artist").removeClass("d-none");
                        $(".user_is_not_artist").addClass("d-none");
                        const artist = response.data.other_info.artist;
                        $("._artist.id").text("شناسه کاربری : " + artist.id);
                        if (artist.avatar !== null)
                            userProfileAvatarUpload.addImagesFromPath([artist.avatar])
                        $("[name='is_artist']").prop("checked", true);
                        // $("#tab-user-profile-section").find(".col-lg-7").removeClass("d-none");
                        $(".is-artist-pending").removeClass("d-none");
                        // $("#tab-user-profile-section input[name='is_advisor']").prop("checked", artist.is_advisor === 1);
                        $("#tab-user-profile-section input[name='advise_price']").val(artist_advise_price = artist.advise_price);
                        // if(artist.hasOwnProperty('avatar') && artist.avatar != null){
                        //     // $("#tab-user-profile-section input[name='advise_price']").a()
                        // }
                        if (artist.is_advisor === 1) {
                            $("#AdvisorPriceContainer").collapse("show");
                            $("input[name='is_advisor']").prop("checked", true)
                        }

                        const titles = response.data.other_info.titles;
                        console.log("$(location).attr('href') : " + $(location).attr('href'));
                        console.log("$(location).attr('href').indexOf : " + $(location).attr('href').indexOf("profile.html"));
                        if ($(location).attr('href').indexOf("profile.html") >= 0) {
                            if (titles.length > 0) {
                                $(".title-list-empty").addClass("d-none");
                                for (let i = 0; i < titles.length; i++) {
                                    $(".title-list").append("" +
                                        "<li class=\"title-list-item\" data-id=\"" + titles[i].pivot.title_id + "\">\n" +
                                        "                                        <div class=\"col-md-3 col-4 text-left px-1\">\n" +
                                        "                                            <h4 class='name'>" + titles[i].name + "</h4>\n" +
                                        "                                        </div>\n" +
                                        "                                        <div class=\"col-md-3 col-5 fa-number d-flex flex-column flex-wrap justify-content-start align-items-start px-1\">\n" +
                                        "                                           <label class=\"switch s-success mr-2 mb-0\">\n" +
                                        "                                                <input type=\"checkbox\" class='accept_order' " + (titles[i].pivot.accept_order === 1 ? 'checked' : '') + " disabled><span class=\"slider round\"></span>\n" +
                                        "                                           </label><span><span class='order_price mx-1'>" + titles[i].pivot.order_price + "</span>" + "تومان </span> " +
                                        "                                        </div>\n" +
                                        "                                        <div class=\"col-4 d-md-block d-none px-1\">\n" +
                                        "                                            <p class=\"description\">" + titles[i].pivot.description + "</p>\n" +
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
                                        "                                                 <a class=\"open-delete-modal\" " +
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


                            const portfolio = response.data.other_info.portfolio;
                            if (portfolio.length > 0) {
                                $(".portfolio-list-empty").addClass("d-none");
                                for (let i = 0; i < portfolio.length; i++) {
                                    $(".portfolio-list").append("" +
                                        "<li class=\"portfolio-list-item\" data-id=\"" + portfolio[i].id + "\">\n" +
                                        "                                        <div class=\"col-md-2 col-3 px-1\">\n" +
                                        "                                            <img src='" + (('image' in portfolio[i]) ? portfolio[i].image : '../../assets/img/90x90.jpg') + "' class=\"image\" width=\"50\" height=\"50\" style='border-radius: 12px'>\n" +
                                        "                                        </div>\n" +
                                        "                                        <div class=\"col-md-8 col-6 px-1\">\n" +
                                        "                                            <h4 class='name'>" + portfolio[i].name + "</h4>\n" +
                                        "                                            <p>تاریخ انتشار: <span class=\"fa-number date\">" + portfolio[i].date + "</span></p>\n" +
                                        // "                                            <div class=\"d-flex flex-row justify-content-start align-items-center badges\">\n" + typesHtml + "</div>\n" +
                                        "                                            <p class=\"description\">" + portfolio[i].description + "</p>\n" +
                                        "                                            <p class=\"sr-only url\">" + portfolio[i].url + "</p>\n" +
                                        "                                            <p class=\"sr-only type\">" + portfolio[i].type + "</p>\n" +
                                        "                                        </div>\n" +
                                        "                                        <div class=\"col-md-2 col-3 px-1\">\n" +
                                        "                                            <div class=\"d-flex flex-row justify-content-end\">\n" +
                                        "                                                <a href=\"javascript:void(0);\" onclick='editPortfolioRow(this)'>\n" +
                                        "                                                    <svg width=\"28\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-edit-2 px-1 text-warning\">\n" +
                                        "                                                        <path d=\"M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z\"></path>\n" +
                                        "                                                    </svg>\n" +
                                        "                                                </a>\n" +
                                        "                                                 <a class=\"open-delete-modal\" " +
                                        "                                                       href=\"#modal-delete-title-portfolio\">\n" +
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
                        }
                    } else {
                        // $("#tab-user-profile-section").find(".col-lg-7").remove();
                        $(".user_is_artist").addClass("d-none");
                        $(".user_is_not_artist").removeClass("d-none");
                    }
                }
            }
        },
        error: function (xhr) {
            console.log("error : " + JSON.stringify(xhr));
        }
    });

    $.get(__url__ + "/titles", function (response) {
        if (typeof response === 'object' && response !== null) {
            const titles = response.titles.data;
            if (titles !== null) {
                for (let i = 0; i < titles.length; i++)
                    $("#userAddTitleForm select").append($("<option value='" + titles[i].id + "'>" + titles[i].name + "</option>"));
            }
        }
    });

});

$(document).ready(function () {

    $(".custom-file-container__image-preview").css({
        backgroundImage: "url(assets/website/img/ui-user.svg)"
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

    $("input[name='is_advisor']").on("click", function () {
        const isChecked = $(this).is(":checked");
        $.ajax({
            method: 'PATCH',
            url: __url__ + '/accept_advisor',
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
    $("input[name='first_name']").on("blur", function () {
        updateUserData($(this), user_first_name);
    });
    $("input[name='last_name']").on("blur", function () {
        updateUserData($(this), user_last_name);
    });
    $("input[name='email']").on("blur", function () {
        updateUserData($(this), user_email);
    });
    $("input[name='melli_code']").on("blur", function () {
        updateUserData($(this), user_melli_code);
    });
    $("input[name='advise_price']").on("blur", function () {
        updateUserData($(this), artist_advise_price);
    });
    $(".sign__user-studio--btn").on("click", function () {
        updateUserData(null, null, "avatar");
    });

    $("input[name='avatar']").on("change", function () {
        const _fileInput = $(this);
        if ($(this).files.length) {
            let formData = {};
            formData['avatar'] = $(this).files[0];
            $.ajax({
                method: 'PATCH',
                url: __url__ + '/avatar',
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                success: function (response) {
                    if (typeof response === 'object' && response !== null) {
                        _fileInput.siblings(".input-error").remove();
                        if (!response.error) {
                            userProfileAvatarUpload.addImagesFromPath([response.avatar])
                        } else {
                            _fileInput.after("<span class='input-error text-danger'>" + response.messages[0] + "</span>")
                        }
                    }
                }
            });
        }
    });

});