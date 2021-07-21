let max_price_studios = 0;
let min_price_studios = Number.MAX_SAFE_INTEGER;

function updateStudiosToPage(pageNum) {
    console.log("page : " + pageNum);
    $.get(__url__+'/studios/12?page=' + pageNum, function (response) {
        if (!response.error) {
            const data = response.studios.data;
            let parent = $('.studios-grid');
            let name, images, price;

            parent.empty();
            for (let i = 0; i < data.length; i++) {
                const _studio = data[i];
                name = _studio.name;
                price = _studio.price;
                price = parseInt(price);
                images = _studio.images;
                if (price > max_price_studios) max_price_studios = price;
                if (price < min_price_studios) min_price_studios = price;
                parent.append("<div class=\"col-lg-4 col-md-6 col-12 \"><div class=\"event\"" +
                    "style=\"background-image: url(" + (images.length > 0 ? images[0].path : 'assets/website/img/studio-placeholder.png') + ");" +
                    "background-position: center center; background-repeat: no-repeat; background-size: cover\">\n" +
                    "<a href=\"studio.html?id=" + _studio.id + "\" class=\"event__ticket\">\n"+
                    "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.75\" stroke-linecap=\"round\" stroke-linejoin=\"round\">\n"+
                    "<path d=\"M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z\"></path>\n"+
                    "<circle cx=\"12\" cy=\"12\" r=\"3\"></circle>\n"+
                    "</svg> مشاهده</a>\n"+
                    "<span class=\"event__time\"><i class=\"icofont-location-pin\"></i> "+data[i].city_name+", "+data[i].province_name+"</span>\n" +
                    "<h3 class=\"event__title\"><a href=\"studio.html?id=" + data[i].id + "\">" + _studio.name + "</a></h3>\n" +
                    "<span class=\"event__date\" dir='ltr'> <span dir='rtl'>" + handle_price(_studio.price.toString()) + " تومان </span> <i class=\"icofont-price mr-1\"></i> </span>\n" +
                    // "<p class=\"event__address\">" + data[i].address + "</p>\n" +
                    "</div></div>");
            }
            const links = response.studios.links;
            parent = $('.pagination');
            parent.empty();
            for (let i = 0; i < links.length; i++) {
                parent.append("<li class='page-item " + (!links[i].url ? 'disabled' : (links[i].active ? 'active' : '')) + "'>" +
                    "              <a class='page-link' href='" + links[i].url + "'>" + links[i].label + "</a>" +
                    "          </li>")
            }
            console.log("s : "+min_price_studios+" , m : "+max_price_studios)
            $(".slider-range-min").text(min_price_studios);
            $(".slider-range-max").text(max_price_studios);
            $("#slider-range").slider({
                range: true,
                min : min_price_studios,
                max : max_price_studios,
                step: 1,
                values : [min_price_studios,max_price_studios],
                slide: function(e, ui) {
                    const min = Math.floor(ui.values[0]);
                    const max = Math.floor(ui.values[1]);
                    $(".slider-range-min").text(min);
                    $(".slider-range-max").text(max);
                }
            });
        }
    });
}

function getCurrentPageNum($this) {
    const url_string = $this.attr('href');
    console.log('url_string : ' + url_string);
    if (url_string != null) {
        const url = new URL(url_string);
        const pageNum = url.searchParams.has('page') ? url.searchParams.get('page') : 1;
        return pageNum;
    }
    return 1;
}

$(window).on('load', function () {
    updateStudiosToPage(getCurrentPageNum($(location)));
});

$(document).ready(function () {

    const $loadingDiv = $('#loadingDiv').hide()
    $(document).ajaxStart(function () {
        $loadingDiv.show();
    }).ajaxStop(function () {
        $loadingDiv.hide();
    });

    $(document).on('click', '.pagination .page-link', function (e) {
        e.preventDefault();
        const $this = $(this);
        updateStudiosToPage(getCurrentPageNum($this));
    });

    $(".main__filter-search select").select2({
        placeholder: '-انتخاب کنید-',
        dir: "rtl",
        language: "fa",
        width: '100%',
        theme: "bootstrap"
    });

});