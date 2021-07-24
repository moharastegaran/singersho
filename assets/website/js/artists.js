function updateArtistsWithParams(params = $(location).attr('search')) {
    const _params = appendUrlParam(params);
    $.get(__url__ + '/artists/20?'+ _params, function (response) {
            if (!response.error) {
                let parent = $('.artists-grid');
                let items = response.data.data;
                let titles, titles_name_html;
                parent.empty();
                if (items.length > 0) {
                    for (let i = 0; i < items.length; i++) {
                        const _artist = items[i];
                        titles_name_html = ""
                        titles = _artist.skills;
                        for (let i = 0; i < titles.length; i++) {
                            titles_name_html += "<a href='artists.html?page=1&title="+titles[i].name+"' class='badge badge-warning mx-1'>" + titles[i].name + "</a>";
                        }
                        parent.append("<div class=\"col-6 col-sm-4 col-md-3 item my-2 " + (_artist.is_advisor === 1 ? 'is_advisor' : 'is_not_advisor') + "\">\n" +
                            "<div class=\"album\">\n" +
                            "<div class=\"album__cover single\" style=\"background-image: url(" + _artist.avatar + ")\">\n" +
                            // "<img src=\"" + _artist.avatar + "\" alt=\"" + _artist.first_name + " " + _artist.last_name + "\">\n" +
                            "<a href=\"artist.html?id=" + _artist.id + "\"> مشاهده \n" +
                            "<i class=\"icofont-eye-alt\"></i>\n" +
                            "</a>\n" +
                            "<div class=\"badges\">" + titles_name_html + "</div>\n" +
                            "</div>\n" +
                            "<div class=\"album__title\">\n" +
                            "<h3><a href=\"artist.html?id=" + i + "\">" + _artist.first_name + " " + _artist.last_name + "</a></h3>\n" +
                            "<span>" + (_artist.is_advisor === 0 ? "مشاوره نمیدهد" : (" مشاوره ساعتی : " + handle_price(_artist.advise_price.toString()) + " تومان")) + "</span>\n" +
                            "</div>\n" +
                            "</div>");
                    }
                }else{
                    parent.append("<div class='artists-empty rounded border border-warning mt-5 mb-4 mx-auto py-3 px-5 text-warning font-weight-light'>.هنرمندی برای نمایش وجود ندارد</div>")
                }
                const links = response.data.links;
                parent = $('.pagination');
                parent.empty();
                for (let i = 0; i < links.length; i++) {
                    parent.append("<li class='page-item " + (!links[i].url ? 'disabled' : (links[i].active ? 'active' : '')) + "'>" +
                        "              <a class='page-link' href='javascript:void(0)' onclick='"+(links[i].url !== null ?  "updateArtistsWithParams(\""+links[i].url.substr(2)+"\")" : 'javascript:void(0)')+"'>" + links[i].label + "</a>" +
                        "          </li>")
                }
                // const $elements = $('.artists-grid'),
                //     $filters = $('.slider-radio label');
                //
                // $elements.imagesLoaded(function () {
                //     const $iso = $elements.isotope({
                //         layoutMode : 'masonry',
                //         itemSelector: '.item',
                //         resizable : false
                //         // isOriginLeft: false
                //     });
                // $elements.isotope( 'remove', $(".item"), function(){
                //     $elements.prepend($(data)).isotope( 'reloadItems' ).isotope({ sortBy: 'original-order' });
                // });
                // $elements.isotope( 'remove', $(".item"), function(){
                //     $elements.isotope( 'addItems', $(data), function(){
                //         $elements.isotope('reLayout');
                //     });
                // });
                // });

                // $(document).on('click', '.slider-radio label', function () {
                //     $filters.removeClass('active');
                //     $(this).addClass('active');
                //     let selector = $(this).data('filter');
                //     $elements.isotope({
                //         filter: selector,
                //         hiddenStyle: {
                //             transform: 'scale(.2) skew(30deg)',
                //             opacity: 0
                //         },
                //         visibleStyle: {
                //             transform: 'scale(1) skew(0deg)',
                //             opacity: 1,
                //         },
                //         transitionDuration: '.5s'
                //     });
                // });
            }
        }
    )
    ;
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

$(window).on('load', function () {

    $.get(__url__ + '/titles', function (response) {
        if (!response.error) {
            const titles = response.titles;
            $(".main__select[name='titles']").append('<option value="" selected>همه سبک‌ها</option>')
            for (let i = 0; i < titles.length; i++) {
                $(".main__select[name='titles']").append(
                    '<option value="title=' + titles[i].name + '" '+(getUrlParam('title')===titles[i].name ? 'selected' : '')+'>' + titles[i].name + '</option>'
                )
            }
            $('.main__select[name="titles"]').select2({
                minimumResultsForSearch: Infinity
            });
        }
    });
    updateArtistsWithParams("page="+(getUrlParam('page')!==null ? getUrlParam('page'): 1));

    $.each($('.main__select[name="orders"]').find('option'),function (index,dom){
        const value = $(dom).val();
        if (value.indexOf(getUrlParam('column')) >= 0) $('.main__select[name="orders"]').val(value).change();
    });

    $(".main__filter-search input").val(getUrlParam('search'));

});

$(document).ready(function () {
    $('.main__select[name="orders"]').select2({
        minimumResultsForSearch: Infinity
    });

    $('.main__select[name="orders"]').on("change", function () {
        updateArtistsWithParams("page=1&"+$(this).val());
    });

    $('.main__select[name="titles"]').on("change", function () {
        updateArtistsWithParams("page=1&"+$(this).val());
    });

    $('.slider-radio input').on('change', function () {
        updateArtistsWithParams("is_advisor="+$(this).val());
    });

    $(".main__filter-search").on("submit",function (e){
        e.preventDefault();
        updateArtistsWithParams("page=1&search="+$(this).find('input[name="search"]').val());
    })
});