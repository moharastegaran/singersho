function updateStoreToPage(pageNum) {
    $.get(__url__+'/packages?page='+pageNum, function (response) {
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
                if (avatar == null) {
                    avatar = "assets/website/img/store/item1.jpg"
                }
                parent.append("" +
                    "<div class=\"col-6 col-sm-4 col-lg-3\">\n" +
                    "<div class=\"product\">\n" +
                    "<div class=\"product__cover\" style=\"background-image: url("+avatar+")\">\n" +
                    "<a href=\"product.html?id=" + _package.id + "\">" +
                    "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\">\n" +
                    "<path d=\"M8.5,19A1.5,1.5,0,1,0,10,20.5,1.5,1.5,0,0,0,8.5,19ZM19,16H7a1,1,0,0,1,0-2h8.49121A3.0132,3.0132,0,0,0,18.376,11.82422L19.96143,6.2749A1.00009,1.00009,0,0,0,19,5H6.73907A3.00666,3.00666,0,0,0,3.92139,3H3A1,1,0,0,0,3,5h.92139a1.00459,1.00459,0,0,1,.96142.7251l.15552.54474.00024.00506L6.6792,12.01709A3.00006,3.00006,0,0,0,7,18H19a1,1,0,0,0,0-2ZM17.67432,7l-1.2212,4.27441A1.00458,1.00458,0,0,1,15.49121,12H8.75439l-.25494-.89221L7.32642,7ZM16.5,19A1.5,1.5,0,1,0,18,20.5,1.5,1.5,0,0,0,16.5,19Z\"/>\n"+
                    "</svg> میخرمش\n"+
                    "</a>\n"+
                    "</div>\n" +
                    "<h3 class=\"product__title\"><a href=\"product.html?id="+_package.id+"\" class=\"product__img\">"+_package.name+"</a></h3>\n" +
                    "<span class=\"product__price\">"+_package.price+" تومان</span>\n" +
                    "</div>\n" +
                    "</div>");
            }
            const links = response.packages.links;
            parent = $('.pagination');
            parent.empty();
            for(let i=0;i<links.length;i++){
                parent.append("<li class='page-item "+(!links[i].url ? 'disabled' : (links[i].active ? 'active' : ''))+"'>" +
                    "              <a class='page-link' href='"+links[i].url+"'>"+links[i].label+"</a>" +
                    "          </li>")
            }
        }
    });
}

function getCurrentPageNum($this) {
    const url_string = $this.attr('href');
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