let max_price_studios = 0;
let min_price_studios = Number.MAX_SAFE_INTEGER;
let current_min_price = -1, current_max_price = -1;

function updateStudiosWithParams(params = $(location).attr('search')) {
    const _params = appendUrlParam(params);
    $.get(__url__ + '/studios?rpp=12&' + _params, function (response) {
        if (!response.error) {
            const studios = response.studios.data;
            let parent = $('.studios-grid');
            let name, images, price;

            min_price_studios = parseInt(response.price_min);
            if (current_min_price === -1)
                current_min_price = min_price_studios;
            max_price_studios = parseInt(response.price_max);
            if (current_max_price === -1)
                current_max_price = max_price_studios;

            parent.empty();
            if (studios.length > 0) {
                for (let i = 0; i < studios.length; i++) {
                    const _studio = studios[i];
                    name = _studio.name;
                    price = _studio.price;
                    price = parseInt(price);
                    images = _studio.pictures;
                    parent.append("<div class=\"col-lg-4 col-md-6 col-12 \"><div class=\"event\"" +
                        "style=\"background-image: url(" + (images.length > 0 ? images[0].path : 'assets/website/img/studio-placeholder.png') + ");" +
                        "background-position: center center; background-repeat: no-repeat; background-size: cover\">\n" +
                        "<a href=\"studio.html?id=" + _studio.id + "\" class=\"event__ticket\">\n" +
                        "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.75\" stroke-linecap=\"round\" stroke-linejoin=\"round\">\n" +
                        "<path d=\"M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z\"></path>\n" +
                        "<circle cx=\"12\" cy=\"12\" r=\"3\"></circle>\n" +
                        "</svg> مشاهده</a>\n" +
                        "<span class=\"event__time\"><i class=\"icofont-location-pin\"></i> <a href=\"studios.html?cityIds=" + studios[i].geographical_information.city_id + "\" class=\"text-white border-bottom border-white\" >" + studios[i].geographical_information.city + "</a>, " + studios[i].geographical_information.province + "</span>\n" +
                        "<h3 class=\"event__title\"><a href=\"studio.html?id=" + studios[i].id + "\">" + _studio.name + "</a></h3>\n" +
                        "<span class=\"event__date\" dir='ltr'> <span dir='rtl'>" + handle_price(_studio.price.toString()) + " تومان </span> <i class=\"icofont-price mr-1\"></i> </span>\n" +
                        // "<p class=\"event__address\">" + studios[i].address + "</p>\n" +
                        "</div></div>");
                }
            }else{
                parent.append("<div class='studios-empty rounded border border-warning mt-5 mb-4 mx-auto py-3 px-5 text-warning font-weight-light'>.استدیویی برای نمایش وجود ندارد</div>")
            }
            const links = response.studios.links;
            parent = $('.pagination');
            parent.empty();
            for (let i = 0; i < links.length; i++) {
                parent.append("<li class='page-item " + (!links[i].url ? 'disabled' : (links[i].active ? 'active' : '')) + "'>" +
                    "              <a class='page-link' href='javascript:void(0)' onclick='" + (links[i].url !== null ? "updateStudiosWithParams(\"" + links[i].url.substr(links[i].url.indexOf("?") + 1) + "\")" : 'javascript:void(0)') + "'>" + links[i].label + "</a>" +
                    "          </li>")
            }
            $(".slider-range-min").text(min_price_studios);
            $(".slider-range-max").text(max_price_studios);
            $("#slider-range").slider({
                range: true,
                min: min_price_studios,
                max: max_price_studios,
                step: 1,
                values: [current_min_price, current_max_price],
                slide: function (e, ui) {
                    const min = Math.floor(ui.values[0]);
                    const max = Math.floor(ui.values[1]);
                    $(".slider-range-min").text(current_min_price = min);
                    $(".slider-range-max").text(current_max_price = max);
                }
            });
        }
    });
}

function getUrlParam(key) {
    const url_string = $(location).attr('href');
    if (url_string != null) {
        const url = new URL(url_string);
        return url.searchParams.has(key) ? url.searchParams.get(key) : null;
    }
    return null;
}

function appendUrlParam(params) {

    if (history.pushState) {
        let searchParams = new URLSearchParams($(location).attr('search'));
        if (params) {
            params = params.split("&");
            console.log(params.length)
            for (let i = 0; i < params.length; i++) {
                const key_val = params[i].split("=");
                console.log(key_val[0] + "," + key_val[1]);
                searchParams.set(key_val[0], key_val[1]);
            }
        }
        let newurl = $(location).attr('protocol') + "//" + $(location).attr('host') + $(location).attr('pathname') + '?' + searchParams.toString();
        window.history.pushState({path: newurl}, '', newurl);

        console.log(searchParams.toString());
        console.log(newurl);

        return searchParams.toString();
    }
}

$(window).on('load', function () {

    const _this = $(".select2-search__field");
    $.get(__url__ + "/cities?rpp=1250&search=" + _this.val(), function (response) {
        const cities = response.cities.data;
        const _select2 = $('.main__select[name="cities"]');
        const cityIds = getUrlParam("cityIds")!==null ? getUrlParam("cityIds").split("_") : [];
        for (let i = 0; i < cities.length; i++) {
            const option = new Option(cities[i].name, cities[i].id);
            _select2.append(option);
        }
        _select2.val(cityIds);
        _select2.trigger('change');
    });


    updateStudiosWithParams("page=" + (getUrlParam('page') !== null ? getUrlParam('page') : 1));
    if (getUrlParam('min_max') !== null) {
        let min_max = getUrlParam('min_max');
        min_max = min_max.split("_");
        $(".slider-range-min").text(min_max[0]);
        $(".slider-range-max").text(min_max[1]);
    }
    if(getUrlParam("cityIds") !== null){

        cityIds = cityIds.split("_");

    }

    $(".main__filter-search input").val(getUrlParam('search'));
});

$(document).ready(function () {


    $('.main__select[name="orders"]').select2({
        minimumResultsForSearch: Infinity,
        dir: "rtl"
    });

    $('.main__select[name="cities"]').select2({
        // minimumResultsForSearch: Infinity,
        width: "100%",
        dir: "rtl",
        multiple: true,
        maximumSelectionLength: 2,
        placeholder: "جستجوی شهر ...",
        // message : {
        //     noResults: "شهری پیدا نشد"
        // }
    });

    $(".price-filter__btn").on("click", function (e) {
        e.preventDefault();
        $("#price-range-slider").collapse("hide");
        const min = $(".slider-range-min").text();
        const max = $(".slider-range-max").text();
        updateStudiosWithParams("page=1&min_max=" + min + "_" + max);
    });

    $(".main__select[name='orders']").on("change", function () {
        updateStudiosWithParams($(this).val())
    });

    $('.main__select[name="cities"]').on("change", function () {
        let cities = $(this).val(), _cities = "";
        if (cities.length>0) {
            for (let i = 0; i < cities.length; i++) {
                _cities += cities[i];
                if (i!==cities.length-1)
                    _cities+="_";
            }
        }
        updateStudiosWithParams("page=1&cityIds=" + _cities);
    });

    $(".main__filter-search").on("submit",function (e){
        e.preventDefault();
        updateStudiosWithParams("page=1&search="+$(this).find('input[name="search"]').val());
    })

});