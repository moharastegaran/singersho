const __url__ = "http://127.0.0.1:8000/api";

function handle_price(num) {
    let _num = "";
    let reminder = num.length % 3;
    _num = num.substr(0, reminder);
    for (let i = reminder; i < num.length; i += 3) {
        _num = _num + (i === reminder && reminder === 0 ? "" : ",") + num.substr(i, 3);
    }
    return _num;
}

function updateCart($type, $id, $success_message = null, $error_message = null) {
    console.log(__url__ + "/cart/" + $type);
    console.log("itemId" + $id);
    $.ajax({
        method: "PUT",
        url: __url__ + "/cart/" + $type,
        headers: {
            authorization: "Bearer " + localStorage.getItem("accessToken")
        },
        data: {
            _method: 'PUT',
            itemId: $id
        },
        success: function (response) {
            if (response.hasOwnProperty('error') && response.error) {
                popupCartError($error_message);
            } else {

                updateCartDropdown(response);

                popupCartAdded(response.cart.final_cost, $success_message);
            }
        }, error: function (error) {
            popupCartError('لطفا در حساب کاربری خود وارد شوید.');
        }
    });
}

function updateCartDropdown(response) {
    let details = JSON.parse(response.cart.details);
    if (details !== null && !Array.isArray(details)) {
        let _details = [];
        for (const id in details) {
            _details.push(details[id]);
        }
        details = _details;
    }
    const $cartDropDown = $(".header__action--cart .header__drop");
    const $cartNumber = $(".header__action--cart .header__cart--count");
    $cartDropDown.empty();
    if (details.length > 0) {
        for (let i = 0; i < details.length; i++) {
            let html = "<div class='header__product' data-type='" + details[i].type + "' data-id='" + details[i].id + "'>";
            switch (details[i].type) {
                case 'package' :
                    html += "<div class='badge badge-danger'>پکیج</div>\n";
                    html += "<p><a href='product.html?id=" + details[i].id + "'>" + details[i].full_name + "</a></p>\n"
                    break;
                case 'advisor' :
                    html += "<div class='badge badge-primary'>مشاوره</div>\n";
                    html += "<p><a href='artist.html?id=" + details[i].id + "'>" + details[i].full_name + "</a></p>\n";
                    break;
                case 'teammate' :
                    html += "<div class='badge badge-warning'>هنرمند</div>\n";
                    html += "<p>" + details[i].full_name + "</p>\n";
                    break;
                case 'studio' :
                    html += "<div class='badge badge-success'>استدیو</div>\n";
                    html += "<p><a href='studio.html?id=" + details[i].id + "'>" + details[i].full_name + "</a></p>\n";
                    break;
            }
            html += "<button type='button' class='cart__delete'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path d='M13.41,12l6.3-6.29a1,1,0,1,0-1.42-1.42L12,10.59,5.71,4.29A1,1,0,0,0,4.29,5.71L10.59,12l-6.3,6.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l6.29,6.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z'/></svg></button>\n";
            html += "</div>";

            $cartDropDown.append(html);
        }
        $cartNumber.show();
        $cartNumber.text(details.length);
    } else {
        $cartDropDown.append("<div class='text-white'>سبد خرید خالی است.</div>");
        $cartNumber.hide();
    }
}

function popupCartAdded($final_cost, $name = null) {
    const mfp = $("#modal-added-to-cart");
    mfp.find("._cart.name").text($name);
    mfp.find("._cart.final_cost").text($final_cost);
    $.magnificPopup.open({
        fixedContentPos: true,
        fixedBgPos: true,
        overflowY: 'auto',
        type: 'inline',
        preloader: false,
        focus: '#username',
        modal: false,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in',
        items: {
            src: '#modal-added-to-cart'
        },
    });
}

function popupCartError($message) {
    const mfp = $("#modal-cart-error");
    mfp.find("._cart.message").text($message);
    $.magnificPopup.open({
        fixedContentPos: true,
        fixedBgPos: true,
        overflowY: 'auto',
        type: 'inline',
        preloader: false,
        focus: '#username',
        modal: false,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in',
        items: {
            src: '#modal-cart-error'
        },
    });
}

$(window).on('load', function () {

    if (localStorage.getItem("accessToken") !== null) {
        $(".header__action--signin .header__action-btn").attr("href", "profile.html");
        $(".header__action--signin .header__action-btn span").text("پنل کاربری");
        $(".sidebar__nav").append("<li class='sidebar__nav-item'>\n" +
            "            <a href='javascript:void(0)' class='sidebar__nav-link sidebar__nav-logout'>\n" +
            "               <svg viewBox='0 0 512.016 512' xmlns='http://www.w3.org/2000/svg'><path d='m496 240.007812h-202.667969c-8.832031 0-16-7.167968-16-16 0-8.832031 7.167969-16 16-16h202.667969c8.832031 0 16 7.167969 16 16 0 8.832032-7.167969 16-16 16zm0 0'/><path d='m416 320.007812c-4.097656 0-8.191406-1.558593-11.308594-4.691406-6.25-6.253906-6.25-16.386718 0-22.636718l68.695313-68.691407-68.695313-68.695312c-6.25-6.25-6.25-16.382813 0-22.632813 6.253906-6.253906 16.386719-6.253906 22.636719 0l80 80c6.25 6.25 6.25 16.382813 0 22.632813l-80 80c-3.136719 3.15625-7.230469 4.714843-11.328125 4.714843zm0 0'/><path d='m170.667969 512.007812c-4.566407 0-8.898438-.640624-13.226563-1.984374l-128.386718-42.773438c-17.46875-6.101562-29.054688-22.378906-29.054688-40.574219v-384c0-23.53125 19.136719-42.6679685 42.667969-42.6679685 4.5625 0 8.894531.6406255 13.226562 1.9843755l128.382813 42.773437c17.472656 6.101563 29.054687 22.378906 29.054687 40.574219v384c0 23.53125-19.132812 42.667968-42.664062 42.667968zm-128-480c-5.867188 0-10.667969 4.800782-10.667969 10.667969v384c0 4.542969 3.050781 8.765625 7.402344 10.28125l127.785156 42.582031c.917969.296876 2.113281.46875 3.480469.46875 5.867187 0 10.664062-4.800781 10.664062-10.667968v-384c0-4.542969-3.050781-8.765625-7.402343-10.28125l-127.785157-42.582032c-.917969-.296874-2.113281-.46875-3.476562-.46875zm0 0'/><path d='m325.332031 170.675781c-8.832031 0-16-7.167969-16-16v-96c0-14.699219-11.964843-26.667969-26.664062-26.667969h-240c-8.832031 0-16-7.167968-16-16 0-8.832031 7.167969-15.9999995 16-15.9999995h240c32.363281 0 58.664062 26.3046875 58.664062 58.6679685v96c0 8.832031-7.167969 16-16 16zm0 0'/><path d='m282.667969 448.007812h-85.335938c-8.832031 0-16-7.167968-16-16 0-8.832031 7.167969-16 16-16h85.335938c14.699219 0 26.664062-11.96875 26.664062-26.667968v-96c0-8.832032 7.167969-16 16-16s16 7.167968 16 16v96c0 32.363281-26.300781 58.667968-58.664062 58.667968zm0 0'/></svg>\n" +
            "                <span>خروج</span>\n" +
            "            </a>\n" +
            "        </li>");
    } else {
        $(".header__action--signin .header__action-btn").attr("href", "signin.html");
        $(".header__action--signin .header__action-btn span").text("ورود / ثبت نام");
    }

    const $navLinks = $(".sidebar__nav-link");
    const pageUrl = $(location).attr('href').split('/').slice(-1)[0];
    $.each($navLinks, function (index, dom) {
        if ($(dom).attr('href') === pageUrl)
            $(dom).addClass('sidebar__nav-link--active');
        else
            $(dom).removeClass('sidebar__nav-link--active');
    });

    $.ajax({
        method: 'GET',
        url: __url__ + '/cart',
        headers: {
            authorization: "Bearer " + localStorage.getItem("accessToken")
        },
        success: function (response) {
            updateCartDropdown(response);
        },
        error: function (error) {
            $(".header__action.header__action--cart").remove();
        }
    });

    $.get(__url__ + '/artists/8', function (response) {
        if (!response.error) {
            if (response.hasOwnProperty('is_empty') && response.is_empty === true) {
                const parent = $(".main__carousel--artists").parent(".main__carousel-wrap");
                parent.empty();
                parent.append("<div class='col-12 alert alert-outline-warning text-light mt-4'>.هنرمندی برای نمایش وجود ندارد</div>");
            } else {
                const data = response.data.data;
                for (let i=0;i<data.length;i++) {
                    const name = data[i].first_name + ' ' + data[i].last_name;
                    let avatar = data[i].avatar;
                    let is_advisor = data[i].is_advisor;
                    let advise_price = data[i].advise_price;
                    if (avatar == null) {
                        avatar = "assets/website/img/avatar.svg";
                    }

                    let titles_name_html = ""
                    const titles = data[i].skills;
                    for (let i = 0; i < titles.length; i++) {
                        titles_name_html += "<a href='artists.html?page=1&title="+titles[i].name+"' class='badge badge-warning mx-1'>" + titles[i].name + "</a>";
                    }

                    $(".main__carousel--artists").append("" +
                        "<div class=\"album\">\n" +
                        "<div class=\"album__cover single\" style=\"background-image: url("+avatar+")\">\n" +
                        // "<img src=\"" + avatar + "\" alt=\"\">\n" +
                        "<a href=\"artist.html?id=" + data[i].id + "\"> مشاهده \n" +
                        "<i class=\"icofont-eye-alt\"></i>\n" +
                        "</a>\n" +
                        "<div class=\"badges\">" + titles_name_html + "</div>\n" +
                        "</div>\n" +
                        "<div class=\"album__title\">\n" +
                        "<h3><a href=\"artist.html?id=" + data[i].id + "\">" + name + "</a></h3>\n" +
                        "<span>" + (is_advisor === 0 ? "مشاوره نمیدهد" : (" مشاوره ساعتی : " + handle_price(advise_price.toString()) + " تومان")) + "</span>\n" +
                        "</div>\n" +
                        "</div>")
                }
                $('.main__carousel--artists').owlCarousel({
                    mouseDrag: true,
                    touchDrag: true,
                    dots: false,
                    loop: true,
                    autoplay: false,
                    smartSpeed: 600,
                    margin: 20,
                    autoHeight: false,
                    responsive: {
                        0: {
                            items: 2,
                        },
                        576: {
                            items: 3,
                        },
                        768: {
                            items: 4,
                            margin: 30,
                        },
                        992: {
                            items: 4,
                            margin: 30,
                        },
                        1200: {
                            items: 5,
                            margin: 30,
                        },
                    }
                });
            }
        }
    });

    $.get(__url__ + '/packages/10', function (response) {
        if (!response.error) {
            const data = response.packages.data;
            let package_avatar;
            if (data.length > 0) {
                for (let i = 0; i < data.length; i++) {
                    if (data[i].image == null)
                        package_avatar = "assets/website/img/store/item1.jpg";
                    else {
                        package_avatar = data[i].image;
                    }
                    $(".main__carousel--store").append("" +
                        "<div class=\"product\">\n" +
                        "<div class=\"product__cover\" style=\"background-image: url("+package_avatar+")\">\n" +
                        "<a href=\"product.html?id=" + data[i].id + "\">" +
                        "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\">\n" +
                        "<path d=\"M8.5,19A1.5,1.5,0,1,0,10,20.5,1.5,1.5,0,0,0,8.5,19ZM19,16H7a1,1,0,0,1,0-2h8.49121A3.0132,3.0132,0,0,0,18.376,11.82422L19.96143,6.2749A1.00009,1.00009,0,0,0,19,5H6.73907A3.00666,3.00666,0,0,0,3.92139,3H3A1,1,0,0,0,3,5h.92139a1.00459,1.00459,0,0,1,.96142.7251l.15552.54474.00024.00506L6.6792,12.01709A3.00006,3.00006,0,0,0,7,18H19a1,1,0,0,0,0-2ZM17.67432,7l-1.2212,4.27441A1.00458,1.00458,0,0,1,15.49121,12H8.75439l-.25494-.89221L7.32642,7ZM16.5,19A1.5,1.5,0,1,0,18,20.5,1.5,1.5,0,0,0,16.5,19Z\"/>\n"+
                        "</svg> میخرمش\n"+
                        "</a>\n"+
                        // "<img src=\"" + package_avatar + "\" alt=\"\">\n" +
                        "</div>\n" +
                        "<h3 class=\"product__title\"><a href=\"product.html?id=" + data[i].id + "\">" + data[i].name + "</a></h3>\n" +
                        "<span class=\"product__price\">" + handle_price(data[i].price.toString()) + " تومان</span>\n" +
                        "</div>");
                }
                $('.main__carousel--store').owlCarousel({
                    mouseDrag: true,
                    touchDrag: true,
                    dots: false,
                    loop: true,
                    autoplay: false,
                    smartSpeed: 600,
                    margin: 20,
                    autoHeight: false,
                    responsive: {
                        0: {
                            items: 2,
                        },
                        576: {
                            items: 3,
                        },
                        768: {
                            items: 3,
                            margin: 30,
                        },
                        992: {
                            items: 4,
                            margin: 30,
                        },
                        1200: {
                            items: 5,
                            margin: 30,
                        },
                    }
                });
            } else {
                const parent = $(".main__carousel--store").parent(".main__carousel-wrap");
                parent.empty();
                parent.append("<div class='col-12 alert alert-outline-warning text-light mt-4'>.پکیجی برای نمایش وجود ندارد</div>");
            }
        }
    });

    $.get(__url__ + '/studios/6', function (response) {
        if (!response.error) {
            const data = response.studios.data;
            if (data.length > 0) {
                for (let i = 0; i < data.length; i++) {
                    $(".main__carousel--events").append("" +
                        "<div class=\"event\"" +
                        "style=\"background-image: url(" + (data[i].pictures.length > 0 ? data[i].pictures[0].path : 'assets/website/img/studio-placeholder.png') + ");" +
                        "background-position: center center; background-repeat: no-repeat; background-size: cover\">\n" +
                        "<a href=\"studio.html?id=" + data[i].id + "\" class=\"event__ticket\">\n"+
                        "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.75\" stroke-linecap=\"round\" stroke-linejoin=\"round\">\n"+
                        "<path d=\"M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z\"></path>\n"+
                        "<circle cx=\"12\" cy=\"12\" r=\"3\"></circle>\n"+
                        "</svg>   مشاهده و رزرو</a>\n"+
                        "<span class=\"event__time\"><i class=\"icofont-location-pin\"></i> "+data[i].geographical_information.city+", "+data[i].geographical_information.province +"</span>\n" +
                        "<h3 class=\"event__title\"><a href=\"studio.html?id=" + data[i].id + "\">" + data[i].name + "</a></h3>\n" +
                        "<span class=\"event__date\" dir='ltr'> <span dir='rtl'>" + handle_price(data[i].price.toString()) + " تومان </span> <i class=\"icofont-price mr-1\"></i> </span>\n" +
                        // "<p class=\"event__address\">" + data[i].address + "</p>\n" +
                        "</div>");
                }
                $('.main__carousel--events').owlCarousel({
                    mouseDrag: true,
                    touchDrag: true,
                    dots: false,
                    loop: true,
                    autoplay: false,
                    smartSpeed: 600,
                    margin: 20,
                    autoHeight: true,
                    responsive: {
                        0: {
                            items: 1,
                        },
                        576: {
                            items: 2,
                        },
                        768: {
                            items: 2,
                            margin: 30,
                        },
                        992: {
                            items: 3,
                            margin: 30,
                        },
                        1200: {
                            items: 3,
                            margin: 30,
                        },
                    }
                });
            }
        } else {
            const parent = $(".main__carousel--events").parent(".main__carousel-wrap");
            parent.empty();
            parent.append("<div class='col-12 alert alert-outline-warning text-light mt-4'>.استدیویی برای نمایش وجود ندارد</div>");

        }
    });

});

$(document).ready(function () {
    "use strict"; // start of use strict

    const $loadingDiv = $('#loadingDiv').show()
    $(document).ajaxStop(function () {
        $loadingDiv.fadeOut();
    });

    $(document).on('click', '.cart__delete', function (e) {
        e.preventDefault();
        console.log("click");
        const $this = $(this);
        console.log($this.closest('.header__product').data('type'));
        console.log($this.closest('.header__product').data('id'));
        $.ajax({
            method: 'DELETE',
            url: __url__ + '/cart/' + $this.closest('.header__product').data('type'),
            headers: {
                authorization: "Bearer " + localStorage.getItem("accessToken")
            },
            data: {
                _method: 'DELETE',
                itemId: $this.closest('.header__product').data('id')
            },
            success: function (response) {
                if (!response.error) {
                    updateCartDropdown(response);
                }
            },
            error: function (error) {
                popupCartError();
            }
        });
    });


    $(document).on('click', '.sidebar__nav-link.sidebar__nav-logout , .profile__logout', function (e) {
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: __url__ + "/logout",
            headers: {
                Authorization: "Bearer " + localStorage.getItem("accessToken")
            },
            success: function (response) {
                localStorage.removeItem("accessToken");
                $(location).attr("href", "index.html");
            }
        });
    })

    /*==============================
    Menu
    ==============================*/
    $('.header__btn').on('click', function () {
        $(this).toggleClass('header__btn--active');
        $('.sidebar').toggleClass('sidebar--active');
    });

    $('.header__search .close, .header__action--search button').on('click', function () {
        $('.header__search').toggleClass('header__search--active');
    });

    /*==============================
    Home slider
    ==============================*/
    $('.hero').owlCarousel({
        mouseDrag: true,
        touchDrag: true,
        dots: false,
        loop: true,
        autoplay: true,
        smartSpeed: 600,
        autoHeight: false,
        items: 1,
        responsive: {
            0: {
                margin: 20,
            },
            576: {
                margin: 20,
            },
            768: {
                margin: 30,
            },
            1200: {
                margin: 30,
            },
        }
    });


    /*==============================
    Navigation
    ==============================*/
    $('.main__nav--prev').on('click', function () {
        var carouselId = $(this).attr('data-nav');
        $(carouselId).trigger('prev.owl.carousel');
    });
    $('.main__nav--next').on('click', function () {
        var carouselId = $(this).attr('data-nav');
        $(carouselId).trigger('next.owl.carousel');
    });

    /*==============================
    Product
    ==============================*/
    $('.store-item__carousel').owlCarousel({
        mouseDrag: true,
        touchDrag: true,
        dots: true,
        loop: true,
        autoplay: false,
        smartSpeed: 600,
        autoHeight: true,
        items: 1,
        margin: 20,
    });


    /*==============================
    Modal
    ==============================*/
    $('.open-video, .open-map').magnificPopup({
        disableOn: 0,
        fixedContentPos: true,
        type: 'iframe',
        preloader: false,
        removalDelay: 300,
        mainClass: 'mfp-fade',
    });

    $('.open-modal').magnificPopup({
        fixedContentPos: true,
        fixedBgPos: true,
        overflowY: 'auto',
        type: 'inline',
        preloader: false,
        focus: '#username',
        modal: false,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in',
    });

    $('.modal__close').on('click', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });

    /*==============================
    Select
    ==============================*/
    // $('.main__select').select2({
    //     minimumResultsForSearch: Infinity
    // });

    /*==============================
    Scrollbar
    ==============================*/
    var Scrollbar = window.Scrollbar;

    $('.sidebar__nav-link[data-toggle="collapse"]').on('click', function () {
        if ($('.sidebar__menu--scroll').length) {
            Scrollbar.init(document.querySelector('.sidebar__menu--scroll'), {
                damping: 0.1,
                renderByPixels: true,
                alwaysShowTracks: true,
                continuousScrolling: false,
            });
        }
    });

    if ($('.dashbox__table-scroll').length) {
        Scrollbar.init(document.querySelector('.dashbox__table-scroll'), {
            damping: 0.1,
            renderByPixels: true,
            alwaysShowTracks: true,
            continuousScrolling: true
        });
    }

    if ($('.cart__table-scroll').length) {
        Scrollbar.init(document.querySelector('.cart__table-scroll'), {
            damping: 0.1,
            renderByPixels: true,
            alwaysShowTracks: true,
            continuousScrolling: true
        });
    }
});