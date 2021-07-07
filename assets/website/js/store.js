function updateStoreToPage(pageNum) {
    console.log("page : "+pageNum);
    $.get('https://8b71e6d6216f.ngrok.io/api/packages?page='+pageNum, function (response) {
        if (!response.error) {
            const data = response.packages.data;
            let parent = $('.products-grid');
            let name,avatar,price, titles_name_html;

            parent.empty();
            for (let i=0;i<data.length;i++) {
                const _package = data[i];
                name = _package.name;
                price = _package.price;
                avatar = _package.image;
                if (avatar !== null) {
                    avatar = avatar.replace('http://127.0.0.1:8000/storage/', '');
                }else{
                    avatar = "assets/website/img/store/item1.jpg"
                }
                parent.append("<div class=\"col-6 col-sm-4 col-lg-3\">\n" +
                    "                        <div class=\"product\">\n" +
                    "                            <a href=\"product.html?id="+_package.id+"\" class=\"product__img\">\n" +
                    "                                <img src=\""+avatar+"\" alt=\"\">\n" +
                    "                            </a>\n" +
                    "                            <h3 class=\"product__title\"><a href=\"product.html?id="+_package.id+"\" class=\"product__img\">"+_package.name+"</a></h3>\n" +
                    "                            <span class=\"product__price\">"+_package.price+" تومان</span>\n" +
                    // "                            <span class=\"product__new\">جدید</span>\n" +
                    "                        </div>\n" +
                    "                    </div>");
            }
            const links = response.packages.links;
            parent = $('.pagination');
            parent.empty();
            for(let i=0;i<links.length;i++){
                parent.append("<li class='page-item "+(!links[i].url ? 'disabled' : (links[i].active ? 'active' : ''))+"'>" +
                    "              <a class='page-link' href='"+links[i].url+"'>"+links[i].label+"</a>" +
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
    console.log('url_string : '+url_string);
    if (url_string!=null) {
        const url = new URL(url_string);
        const pageNum = url.searchParams.has('page') ? url.searchParams.get('page') : 1;
        return pageNum;
    }
    return 1;
}

$(window).on('load',function (){
    updateStoreToPage(getCurrentPageNum($(location)));
});

$(document).ready(function (){

    $(document).on('click','.pagination .page-link',function (e){
        e.preventDefault();
        const $this = $(this);
        updateStoreToPage(getCurrentPageNum($this));
    });

});