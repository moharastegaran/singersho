function updateStudiosToPage(pageNum) {
    console.log("page : " + pageNum);
    $.get('https://8b71e6d6216f.ngrok.io/api/studios/6?page=' + pageNum, function (response) {
        if (!response.error) {
            const data = response.studios.data;
            let parent = $('.studios-grid');
            let name, images, price;

            parent.empty();
            for (let i = 0; i < data.length; i++) {
                const _studio = data[i];
                name = _studio.name;
                price = _studio.price;
                images = _studio.images;
                parent.append("<div class=\"col-lg-4 col-md-6 col-12 \"><div class=\"event\" " +
                    "style=\"background-image: url(" + (data[i].images.length > 0 ? data[i].images[0] : 'assets/website/img/studio-placeholder.png') + ");" +
                    "background-position: center center; background-repeat: no-repeat; background-size: cover\">" +
                    "               <a href=\"studio.html?id="+data[i].id+"\" class=\"event__ticket\">" +
                    "               <svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\"><path d=\"M9,10a1,1,0,0,0-1,1v2a1,1,0,0,0,2,0V11A1,1,0,0,0,9,10Zm12,1a1,1,0,0,0,1-1V6a1,1,0,0,0-1-1H3A1,1,0,0,0,2,6v4a1,1,0,0,0,1,1,1,1,0,0,1,0,2,1,1,0,0,0-1,1v4a1,1,0,0,0,1,1H21a1,1,0,0,0,1-1V14a1,1,0,0,0-1-1,1,1,0,0,1,0-2ZM20,9.18a3,3,0,0,0,0,5.64V17H10a1,1,0,0,0-2,0H4V14.82A3,3,0,0,0,4,9.18V7H8a1,1,0,0,0,2,0H20Z\"/></svg>" +
                    "مشاهده جزئیات" +
                    "               </a>\n" +
                    "               <span class=\"event__date\">" + _studio.price + " تومان " + "</span>\n" +
                    "               <h3 class=\"event__title\"><a href=\"studio.html?id=" + _studio.id + "\">" + _studio.name + "</a></h3>\n" +
                    "               <p class=\"event__address\">" + _studio.address + "</p>\n" +
                    "       </div></div>");
            }
            const links = response.studios.links;
            parent = $('.pagination');
            parent.empty();
            for (let i = 0; i < links.length; i++) {
                parent.append("<li class='page-item " + (!links[i].url ? 'disabled' : (links[i].active ? 'active' : '')) + "'>" +
                    "              <a class='page-link' href='" + links[i].url + "'>" + links[i].label + "</a>" +
                    "          </li>")
            }
            // if( $('.artists-grid .item').length ) {
            // const $elements = $(".artists-grid"),
            //     $filters = $('.slider-radio label');
            // $elements.isotope({
            //     isOriginLeft: false
            // });

            // $filters.on('click', function () {
            //     $filters.removeClass('active');
            //     $(this).addClass('active');
            //     let selector = $(this).data('filter');
            //     console.log("selector : " + selector);
            //     $(".artists-grid").isotope({
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
        console.log("test")
    }).ajaxStop(function () {
        $loadingDiv.hide();
    });

    $(document).on('click', '.pagination .page-link', function (e) {
        e.preventDefault();
        const $this = $(this);
        updateStudiosToPage(getCurrentPageNum($this));
    });

});