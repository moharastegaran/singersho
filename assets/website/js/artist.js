let _artist_titles = [];
let _is_advisor = false;
let _advise_price = 0;
let _artist_id = null;

$(window).on('load', function () {

    const url_string = $(location).attr('href');
    const url = new URL(url_string);
    const id = url.searchParams.get('id');

    $.get(__url__+'/artist/' + id + '/detail', function (response) {
        if (!response.error) {
            const data = response.data;
            let avatar = data['artist'][0]['avatar']!=null ? data['artist'][0]['avatar'] : "assets/website/img/avatar.svg";
            _artist_id = data['artist'][0]['id'];
            _is_advisor = data['artist'][0]['is_advisor'];
            _advise_price = data['artist'][0]['advise_price'];

            $(".artist.name").text(data['user']['first_name'] + ' ' + data['user']['last_name']);
            $(".artist.avatar").attr('src', avatar);
            $(".artist.experience").text(data['artist'][0]['experience']);
            $(".artist.order_description").text(data['artist'][0]['order_description']);

            if (data.hasOwnProperty('portfolio') && data.portfolio.length > 0) {
                for (let i = 0; i < data.portfolio.length; i++) {
                    const p = data.portfolio[i];
                    console.log("pate : " + p.date);
                    const p_date = p.date.split('-');
                    $(".main__portfolio-artist").append("" +
                        "<div class=\"col-md-4 col-12\">\n" +
                        "<div class=\"live\">\n" +
                        "<a href=\"" + (p.sound !== null ? p.sound : (p.url !== null ? p.url : '#')) + "\" class=\"live__cover open-video\">\n" +
                        "<img src=\"" + p.image + "\" alt=\"\">\n" +
                        "<span class=\"live__value\">"
                        +// new JDate(new Date(p_date[0], p_date[1], p_date[2])).format('dddd DD MMMM YYYY') + "تاریخ انجام: " +
                        "</span>\n" +
                        "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\"><path d=\"M18.54,9,8.88,3.46a3.42,3.42,0,0,0-5.13,3V17.58A3.42,3.42,0,0,0,7.17,21a3.43,3.43,0,0,0,1.71-.46L18.54,15a3.42,3.42,0,0,0,0-5.92Zm-1,4.19L7.88,18.81a1.44,1.44,0,0,1-1.42,0,1.42,1.42,0,0,1-.71-1.23V6.42a1.42,1.42,0,0,1,.71-1.23A1.51,1.51,0,0,1,7.17,5a1.54,1.54,0,0,1,.71.19l9.66,5.58a1.42,1.42,0,0,1,0,2.46Z\"></path></svg>\n" +
                        "</a>\n" +
                        "<h3 class=\"live__title\"><a href=\"https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-1080p.mp4\" class=\"open-video\">" + p.name + "</a></h3>\n" +
                        "</div></div>");
                }
            }

            if (data.hasOwnProperty('title') && data.title.length > 0) {
                _artist_titles = data.title;
                for (let i = 0; i < data.title.length; i++) {
                    const t = data.title[i];
                    $(".main__titles-artist").append("" +
                        "<div class=\"col-12 col-md-6 col-lg-4\">\n" +
                        "<div class=\"step\">\n" +
                        "<span class=\"feature__icon\">\n" +
                        "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\"><path d=\"M21.65,2.24a1,1,0,0,0-.8-.23l-13,2A1,1,0,0,0,7,5V15.35A3.45,3.45,0,0,0,5.5,15,3.5,3.5,0,1,0,9,18.5V10.86L20,9.17v4.18A3.45,3.45,0,0,0,18.5,13,3.5,3.5,0,1,0,22,16.5V3A1,1,0,0,0,21.65,2.24ZM5.5,20A1.5,1.5,0,1,1,7,18.5,1.5,1.5,0,0,1,5.5,20Zm13-2A1.5,1.5,0,1,1,20,16.5,1.5,1.5,0,0,1,18.5,18ZM20,7.14,9,8.83v-3L20,4.17Z\"></path></svg>\n" +
                        "</span>\n" +
                        "<h3 class=\"step__title\">" + t.name + "</h3>\n" +
                        "<p class=\"step__text\">" + (t.pivot.description != null ? t.pivot.description : '') + "</p>\n" +
                        "</div>\n" +
                        "</div>")
                }
            }
        }
    });
});

$(document).ready(function () {

    const $form = $('#modal-add-user-teammate');
    const $select_title_names = $form.find(".sign__select.sign__title--names");
    const $select_type_prices = $form.find(".sign__select.sign__type--names");
    const $final_cost = $form.find("._cart.final_cost");
    $select_type_prices.hide();

    $(".btn-add-to-basket").on('click', function () {
        $select_title_names.empty();
        $select_title_names.append("<option value='' disabled selected>-- انتخاب کنید --</option>");
        $.each(_artist_titles, function (i, artist_title) {
            if (artist_title.pivot.accept_order === 1)
                $select_title_names.append("<option value='" + artist_title.pivot.id + "'>" + artist_title.name + "</option>")
        });
    });

    $select_title_names.on("change", function () {
        let artist_title = _artist_titles.filter(function (obj) {
            return obj.pivot.id === parseInt($select_title_names.val());
        });
        artist_title = artist_title[0];
        $select_type_prices.show();
        $select_type_prices.empty();
        $select_type_prices.append("<option value='" + artist_title.pivot.id + "_teammate'> هزینه کار - " + artist_title.pivot.order_price + " تومان</option>");
        $final_cost.text(artist_title.pivot.order_price + " تومان");
        if (_is_advisor) {
            $select_type_prices.append("<option value='" + artist_title.pivot.artist_id + "_advisor'> هزینه مشاوره - " + _advise_price + " تومان</option>");
            $select_type_prices.append("<option value='" + artist_title.pivot.id + "_teammate_" + artist_title.pivot.artist_id + "_advisor'> هزینه کار و مشاوره - " + (artist_title.pivot.order_price + _advise_price) + " تومان</option>");
        }
    });

    $select_type_prices.on("change", function () {
        $final_cost.text($select_type_prices.find("option:selected").text().split("-")[1]);
    });

    $form.find(".sign__btn").on("click", function (e) {
        e.preventDefault();
        $send_data = $select_type_prices.val().split("_");
        $.magnificPopup.close();
        for (let i = 0; i < $send_data.length; i += 2) {
            console.log("url : " + __url__+"/cart/" + $send_data[i + 1]);
            console.log("itemId : " + $send_data[i]);
            updateCart($send_data[i+1],$send_data[i]);
        }
    });
});