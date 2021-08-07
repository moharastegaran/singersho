let id, name, price, image;

$(window).on('load', function () {
    // if (!response.error) {
        const url_string = $(location).attr('href');
        const url = new URL(url_string);
        id = url.searchParams.get('id');
        console.log('id : ' + id);
        $.get(__url__+'/package/' + id + '/detail', function (response) {
            console.log("res : " + response);
            const package = response.package;
            $(".package.name").text(name = package.name);
            $(".package.price").text(handle_price((price = package.price).toString()));
            $(".package.description").text(package.description!=null ? package.description : "ندارد");
            $(".package.delivery_time").text(package.delivery_time);
            $(".package.po_number").text(package.po_number);
            $(".package.image").attr('src', image = package.image);
            $(".package.image").attr('alt', name);
            $(".share__link--tw").attr("href", "http://twitter.com/share?text=" + name + "&url=" + url_string)
            $(".share__link--fb").attr("href", "https://facebook.com/sharer/sharer.php?u=" + url_string);
            $(".share__link--ig").attr("href", "https://www.instagram.com/?url=" + url_string);

            const members = package.members;
            for (let i=0;i<members.length;i++) {
                const name = members[i].first_name + ' ' + members[i].last_name;
                let avatar = members[i].avatar;
                if (avatar == null) {
                    avatar = "assets/website/img/avatar.svg";
                }
                let titles_name_html = ""
                const titles = members[i].titles;
                for (let i = 0; i < titles.length; i++) {
                    titles_name_html += "<a href='artists.html?page=1&title="+titles[i].skill_name+"' class='badge badge-warning mx-1'>" + titles[i].skill_name + "</a>";
                }

                $(".main__members-package").append("<div class=\"col-lg-3 col-md-4 col-12\">"+
                    "<div class=\"album\">\n" +
                    "<div class=\"album__cover single\" style=\"background-image: url("+avatar+")\">\n" +
                    // "<img src=\"" + avatar + "\" alt=\"\">\n" +
                    "<a href=\"artist.html?id=" + members[i].id + "\"> مشاهده \n" +
                    "<i class=\"icofont-eye-alt\"></i>\n" +
                    "</a>\n" +
                    "<div class=\"badges\">" + titles_name_html + "</div>\n" +
                    "</div>\n" +
                    "<div class=\"album__title\">\n" +
                    "<h3><a href=\"artist.html?id=" + members[i].id + "\">" + name + "</a></h3>\n" +
                    "</div>\n" +
                    "</div>")
            }


        });
    // }
});

$(document).ready(function () {
    $('.btn-add-to-basket').on('click', function (e) {
        e.preventDefault();
        const $error_message = 'محصول '+name+' در سبد خرید موجود است.';
        const $success_message = 'محصول '+name+' به سبد خرید اضافه شد.';

        updateCart('package',id,$success_message,$error_message);
    });
})