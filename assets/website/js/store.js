let max_price_package = 0;
let min_price_package = Number.MAX_SAFE_INTEGER;
let current_min_price = -1,  current_max_price = -1;

function updateStoreWithParams(params = $(location).attr('search')) {
    const _params = appendUrlParam(params);
    $.get(__url__+'/packages?rpp=12&'+_params, function (response) {
        if (!response.error) {
            const data = response.packages.data;
            let parent = $('.products-grid');
            let name,avatar,price, titles_name_html;

            min_price_package = parseInt(response.p_min);
            if (current_min_price === -1)
                current_min_price = min_price_package;
            max_price_package = parseInt(response.p_max);
            if (current_max_price === -1)
                current_max_price = max_price_package;

            parent.empty();
            for (let i=0;i<data.length;i++) {
                const _package = data[i];
                name = _package.name;
                price = _package.price;
                avatar = _package.image;
                if (avatar == null) {
                    avatar = "assets/website/img/store/item1.jpg"
                }
                parent.append("" +
                    "<div class=\"col-6 col-sm-4 col-lg-3\">\n" +
                    "<div class=\"product\">\n" +
                    "<div class=\"product__cover single\" style=\"background-image: url("+avatar+")\">\n" +
                    "<a href=\"product.html?id=" + _package.id + "\">" +
                    "<i class=\"icofont-shopping-cart\"></i> میخرمش\n"+
                    "</a>\n"+
                    "<span class=\"product__stat\"><span><i class=\"icofont-downloaded\"></i> "+_package.po_number+" خرید </span><span><i class=\"icofont-users\"></i> "+_package.members.length+" عضو </span></span>\n "+
                    "</div>\n" +
                    "<h3 class=\"product__title\"><a href=\"product.html?id="+_package.id+"\" class=\"product__img\">"+_package.name+"</a></h3>\n" +
                    "<span class=\"product__price\">"+handle_price(_package.price.toString())+" تومان</span>\n" +
                    "</div>\n" +
                    "</div>");
            }
            const links = response.packages.links;
            parent = $('.pagination');
            parent.empty();
            for (let i = 0; i < links.length; i++) {
                parent.append("<li class='page-item " + (!links[i].url ? 'disabled' : (links[i].active ? 'active' : '')) + "'>" +
                    "              <a class='page-link' href='javascript:void(0)' onclick='"+(links[i].url !== null ?  "updateStoreWithParams(\""+links[i].url.substr(links[i].url.indexOf('?')+1)+"\")" : 'javascript:void(0)')+"'>" + links[i].label + "</a>" +
                    "          </li>")
            }

            $(".slider-range-min").text(min_price_package);
            $(".slider-range-max").text(max_price_package);
            $("#slider-range").slider({
                range: true,
                min: min_price_package,
                max: max_price_package,
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
        if(params) {
            params = params.split("&");
            for (let i = 0; i < params.length ; i++) {
                const key_val = params[i].split("=");
                searchParams.set(key_val[0], key_val[1]);
            }
        }
        let newurl = $(location).attr('protocol') + "//" + $(location).attr('host') + $(location).attr('pathname') + '?' + searchParams.toString();
        window.history.pushState({path: newurl}, '', newurl);

        return searchParams.toString();
    }
}

$(window).on('load',function (){
    updateStoreWithParams("page="+(getUrlParam('page')!==null ? getUrlParam('page'): 1));

    $.each($('.main__select[name="orders"]').find('option'),function (index,dom){
        const value = $(dom).val();
        if (value.indexOf(getUrlParam('column')) >= 0) $('.main__select[name="orders"]').val(value).change();
    });

    $(".main__filter-search input").val(getUrlParam('search'));

    if (getUrlParam('p_min_max') !== null) {
        let min_max = getUrlParam('p_min_max');
        min_max = min_max.split("_");
        $(".slider-range-min").text(min_max[0]);
        $(".slider-range-max").text(min_max[1]);
    }
});

$(document).ready(function (){

    $('.main__select[name="orders"]').select2({
        minimumResultsForSearch: Infinity
    });

    $('.main__select[name="orders"]').on("change", function () {
        updateStoreWithParams("page=1&"+$(this).val());
    });

    $(document).on('click','.pagination .page-link',function (e){
        e.preventDefault();
        const $this = $(this);
        updateStoreWithParams(getCurrentPageNum($this));
    });

    $(".price-filter__btn").on("click", function (e) {
        e.preventDefault();
        $("#price-range-slider").collapse("hide");
        const min = $(".slider-range-min").text();
        const max = $(".slider-range-max").text();
        updateStoreWithParams("page=1&p_min_max=" + min + "_" + max);
    });

    $(".main__select[name='orders']").on("change", function () {
        updateStoreWithParams($(this).val())
    });

    $(".main__filter-search").on("submit",function (e){
        e.preventDefault();
        updateStoreWithParams("page=1&search="+$(this).find('input[name="search"]').val());
    })

});