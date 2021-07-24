let _artist_titles = [];
let _is_advisor = false;
let _advise_price = 0;
let _artist_id = null;

$(window).on('load', function () {

    const url_string = $(location).attr('href');
    const url = new URL(url_string);
    const id = url.searchParams.get('id');

    $.get(__url__ + '/artist/' + id + '/detail', function (response) {
        if (!response.error) {
            const data = response.data;
            const artist = data.artist;
            const artist_name = artist.first_name + ' ' + artist.last_name;
            let avatar = artist.avatar != null ? artist.avatar : "assets/website/img/avatar.svg";
            _artist_id = artist.id;

            $(".artist.name").text(artist_name);
            $(".artist.avatar").attr('src', avatar);
            $(".artist.experience").text(artist.experience);
            $(".artist.order_description").text(artist.order_description);
            $(".artist.delivery_time").text(artist.delivery_time + ' روز');
            $(".artist.is_advisor").text((_is_advisor = artist.is_advisor) === 1 ? 'بله' : 'خیر');
            $(".artist.advise_price").text(handle_price((_advise_price = artist.advise_price).toString()) + " تومان");
            if (_is_advisor === 0) $(".artist.advise_price").parent().remove();

            if (data.hasOwnProperty('portfolio') && data.portfolio.length > 0) {
                for (let i = 0; i < data.portfolio.length; i++) {
                    const p = data.portfolio[i];
                    // const p_date = p.date.split('-');
                    $(".main__portfolio-artist").append("" +
                        "<div class=\"col-lg-3 col-md-4 col-sm-6 col-12\">\n" +
                        "<div class=\"live\">\n" +
                        "<a class=\"live__cover\""+(p.sound!=null ? "data-link" : "")+" data-title=\""+p.name+"\" data-artist=\""+artist_name+"\" data-img=\""+p.image+"\" href=\""+(p.sound!=null ? p.sound : (p.url!=null ? p.url : 'javascript:void(0)'))+"\" "+(p.url!=null ? 'target="_blank"' : '')+">\n" +
                        "<img src=\"" + p.image + "\" alt=\"" + p.name + "\">\n" +
                        "<span class=\"live__value\">"
                        + "تاریخ انجام: " + (p.date) +
                        "</span>\n" +
                        "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\"\n" +
                        "stroke=\"#fca311\" stroke-width=\"1.7\" stroke-linecap=\"round\" stroke-linejoin=\"round\">" +
                        (p.sound!=null ? '<path d=\"M18.54,9,8.88,3.46a3.42,3.42,0,0,0-5.13,3V17.58A3.42,3.42,0,0,0,7.17,21a3.43,3.43,0,0,0,1.71-.46L18.54,15a3.42,3.42,0,0,0,0-5.92Zm-1,4.19L7.88,18.81a1.44,1.44,0,0,1-1.42,0,1.42,1.42,0,0,1-.71-1.23V6.42a1.42,1.42,0,0,1,.71-1.23A1.51,1.51,0,0,1,7.17,5a1.54,1.54,0,0,1,.71.19l9.66,5.58a1.42,1.42,0,0,1,0,2.46Z\"></path>' : (p.url!=null ? '<path d=\"M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71\"></path><path d=\"M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71\"></path>' : '')) +
                        "</svg>\n" +
                        "</a>\n" +
                        "<h3 class=\"live__title\"><a href=\"#\">" + p.name + "</a></h3>\n" +
                        "</div></div>");
                    }
            }else{
                // parent.append("<div class='artists-empty rounded border border-warning mt-5 mb-4 mx-auto py-3 px-5 text-warning font-weight-light'>.نمونه کاری ایجاد نکرده است "+artist_name+"</div>")
            }

            if (data.hasOwnProperty('titles') && data.titles.length > 0) {
                _artist_titles = data.titles;
                for (let i = 0; i < data.titles.length; i++) {
                    const t = data.titles[i];
                    $(".main__titles-artist").append("" +
                        "<div class=\"col-12 col-md-6 col-lg-4\">\n" +
                        "<div class=\"step\">\n" +
                        "<div class=\"step__head\">\n" +
                        "<span class=\"feature__icon\">\n" +
                        "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\"><path d=\"M21.65,2.24a1,1,0,0,0-.8-.23l-13,2A1,1,0,0,0,7,5V15.35A3.45,3.45,0,0,0,5.5,15,3.5,3.5,0,1,0,9,18.5V10.86L20,9.17v4.18A3.45,3.45,0,0,0,18.5,13,3.5,3.5,0,1,0,22,16.5V3A1,1,0,0,0,21.65,2.24ZM5.5,20A1.5,1.5,0,1,1,7,18.5,1.5,1.5,0,0,1,5.5,20Zm13-2A1.5,1.5,0,1,1,20,16.5,1.5,1.5,0,0,1,18.5,18ZM20,7.14,9,8.83v-3L20,4.17Z\"></path></svg>\n" +
                        "</span>\n" +
                        "<h3 class=\"step__title\"><a href='artists.html?title="+t.name+"' class='text-white'>" + t.name + "</a></h3>\n" +
                        "</div>\n" +
                        "<ul class = \"plan__list\">\n" +
                        "<li class = \"" + (t.pivot.accept_order === 1 ? 'green' : 'red') + "\" ><svg xmlns = \"http://www.w3.org/2000/svg\" viewBox = \"0 0 24 24\" >\n" +
                        "<path d=\"" + (t.pivot.accept_order === 1 ? 'M18.71,7.21a1,1,0,0,0-1.42,0L9.84,14.67,6.71,11.53A1,1,0,1,0,5.29,13l3.84,3.84a1,1,0,0,0,1.42,0l8.16-8.16A1,1,0,0,0,18.71,7.21Z' : 'M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z') + "\"></path>\n" +
                        "</svg>" + (t.pivot.accept_order === 1 ? 'سفارش می‌پذیرد (' + handle_price(t.pivot.order_price.toString()) + ' تومان)' : 'سفارش نمی‌پذیرد') + "\n" +
                        "</li>\n" +
                        // "<li class=\""+(t.pivot.accept_order===1 ? '' : 'd-none')+"\">\n" +
                        // "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\">\n" +
                        // "<path d=\"\"></path>\n" +
                        // "</svg>"+(handle_price(t.pivot.order_price.toString())+' تومان')+"\n" +
                        // "</li>\n" +
                        "</ul>\n" +
                        "<p class=\"step__text\"><strong>توضیحات: </strong>" + (t.pivot.description != null ? t.pivot.description : '_') + "</p>\n" +
                        "</div>\n" +
                        "</div>")
                }
            }else{
                // parent.append("<div class='artists-empty rounded border border-warning mt-5 mb-4 mx-auto py-3 px-5 text-warning font-weight-light'>.مهارتی ثبت نکرده است "+artist_name+"</div>")
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
            console.log("url : " + __url__ + "/cart/" + $send_data[i + 1]);
            console.log("itemId : " + $send_data[i]);
            updateCart($send_data[i + 1], $send_data[i]);
        }
    });


    /*==============================
	Player
	==============================*/
    $('.player__btn').on('click', function() {
        $(this).toggleClass('player__btn--active');
        $('.player').toggleClass('player--active');
    });

    const controls = `
	<div class="plyr__controls">
		<div class="plyr__actions">
			<button type="button" class="plyr__control plyr__control--prev">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.28,3.43a3.23,3.23,0,0,0-3.29,0L8,8.84V6A3,3,0,0,0,2,6V18a3,3,0,0,0,6,0V15.16l9,5.37a3.28,3.28,0,0,0,1.68.47,3.24,3.24,0,0,0,1.61-.43,3.38,3.38,0,0,0,1.72-3V6.42A3.38,3.38,0,0,0,20.28,3.43ZM6,18a1,1,0,0,1-2,0V6A1,1,0,0,1,6,6Zm14-.42a1.4,1.4,0,0,1-.71,1.25,1.23,1.23,0,0,1-1.28,0L8.68,13.23a1.45,1.45,0,0,1,0-2.46L18,5.19A1.23,1.23,0,0,1,18.67,5a1.29,1.29,0,0,1,.62.17A1.4,1.4,0,0,1,20,6.42Z"/></svg>
			</button>

			<button type="button" class="plyr__control" data-plyr="play">
				<svg class="icon--pressed" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16,2a3,3,0,0,0-3,3V19a3,3,0,0,0,6,0V5A3,3,0,0,0,16,2Zm1,17a1,1,0,0,1-2,0V5a1,1,0,0,1,2,0ZM8,2A3,3,0,0,0,5,5V19a3,3,0,0,0,6,0V5A3,3,0,0,0,8,2ZM9,19a1,1,0,0,1-2,0V5A1,1,0,0,1,9,5Z"></path></svg>
				<svg class="icon--not-pressed" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.54,9,8.88,3.46a3.42,3.42,0,0,0-5.13,3V17.58A3.42,3.42,0,0,0,7.17,21a3.43,3.43,0,0,0,1.71-.46L18.54,15a3.42,3.42,0,0,0,0-5.92Zm-1,4.19L7.88,18.81a1.44,1.44,0,0,1-1.42,0,1.42,1.42,0,0,1-.71-1.23V6.42a1.42,1.42,0,0,1,.71-1.23A1.51,1.51,0,0,1,7.17,5a1.54,1.54,0,0,1,.71.19l9.66,5.58a1.42,1.42,0,0,1,0,2.46Z"></path></svg>
			</button>

			<button type="button" class="plyr__control plyr__control--next">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19,3a3,3,0,0,0-3,3V8.84L7,3.47a3.21,3.21,0,0,0-3.29,0A3.38,3.38,0,0,0,2,6.42V17.58a3.38,3.38,0,0,0,1.72,3A3.24,3.24,0,0,0,5.33,21,3.28,3.28,0,0,0,7,20.53l9-5.37V18a3,3,0,0,0,6,0V6A3,3,0,0,0,19,3ZM15.32,13.23,6,18.81a1.23,1.23,0,0,1-1.28,0A1.4,1.4,0,0,1,4,17.58V6.42a1.4,1.4,0,0,1,.71-1.25A1.29,1.29,0,0,1,5.33,5,1.23,1.23,0,0,1,6,5.19l9.33,5.58a1.45,1.45,0,0,1,0,2.46ZM20,18a1,1,0,0,1-2,0V6a1,1,0,0,1,2,0Z"/></svg>
			</button>
		</div>

		<div class="plyr__wrap">
			<div class="plyr__progress">
				<input data-plyr="seek" type="range" min="0" max="100" step="0.01" value="0" aria-label="Seek">
				<progress class="plyr__progress__buffer" min="0" max="100" value="0">% buffered</progress>
				<span role="tooltip" class="plyr__tooltip">00:00</span>
			</div>

			<div class="plyr__time plyr__time--current" aria-label="Current time">00:00</div>
		</div>

		<div class="plyr__wrap">
			<button type="button" class="plyr__control" aria-label="Mute" data-plyr="mute">
				<svg class="icon--pressed" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.43,4.1a1,1,0,0,0-1,.12L6.65,8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H6.65l4.73,3.78A1,1,0,0,0,12,20a.91.91,0,0,0,.43-.1A1,1,0,0,0,13,19V5A1,1,0,0,0,12.43,4.1ZM11,16.92l-3.38-2.7A1,1,0,0,0,7,14H4V10H7a1,1,0,0,0,.62-.22L11,7.08ZM19.91,12l1.8-1.79a1,1,0,0,0-1.42-1.42l-1.79,1.8-1.79-1.8a1,1,0,0,0-1.42,1.42L17.09,12l-1.8,1.79a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0l1.79-1.8,1.79,1.8a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"/></svg>
				<svg class="icon--not-pressed" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.43,4.1a1,1,0,0,0-1,.12L6.65,8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H6.65l4.73,3.78A1,1,0,0,0,12,20a.91.91,0,0,0,.43-.1A1,1,0,0,0,13,19V5A1,1,0,0,0,12.43,4.1ZM11,16.92l-3.38-2.7A1,1,0,0,0,7,14H4V10H7a1,1,0,0,0,.62-.22L11,7.08ZM19.66,6.34a1,1,0,0,0-1.42,1.42,6,6,0,0,1-.38,8.84,1,1,0,0,0,.64,1.76,1,1,0,0,0,.64-.23,8,8,0,0,0,.52-11.79ZM16.83,9.17a1,1,0,1,0-1.42,1.42A2,2,0,0,1,16,12a2,2,0,0,1-.71,1.53,1,1,0,0,0-.13,1.41,1,1,0,0,0,1.41.12A4,4,0,0,0,18,12,4.06,4.06,0,0,0,16.83,9.17Z"/></svg>
				<span class="label--pressed plyr__tooltip" role="tooltip">Unmute</span>
				<span class="label--not-pressed plyr__tooltip" role="tooltip">Mute</span>
			</button>

			<div class="plyr__volume">
				<input data-plyr="volume" type="range" min="0" max="1" step="0.05" value="1" autocomplete="off" aria-label="Volume">
			</div>

<!--			<a href="release.html" class="plyr__control" aria-label="لیست پخش">-->
<!--				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15,13H9a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2Zm0-4H9a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2ZM12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"/></svg>-->
<!--				<span class="plyr__tooltip" role="tooltip">لیست پخش</span>-->
<!--			</a>-->
		</div>
	</div>
    `;
    const player = new Plyr('#audio', {
        controls,
        volume: 0.5,
    });

    const audio = $('#audio');

    player.on('play', event => {
        $('a[data-link].active, a[data-playlist].active').addClass('play');
        $('a[data-link].active, a[data-playlist].active').removeClass('pause');
    });

    player.on('pause', event => {
        $('a[data-link].active, a[data-playlist].active').removeClass('play');
        $('a[data-link].active, a[data-playlist].active').addClass('pause');
    });

    /* single */
    $(document).on('click','a[data-link]', function(e){
        e.preventDefault();
        let link = $(this);
        run(link, audio[0]);
    });

    function run(link, player){
        if (link.hasClass('play')) {
            link.removeClass('play');
            audio[0].pause();
            link.addClass('pause');
        }
        else if (link.hasClass('pause')) {
            link.removeClass('pause');
            audio[0].play();
            link.addClass('play');
        }
        else {
            $('a[data-link]').removeClass('active');
            $('a[data-link]').removeClass('pause');
            $('a[data-link]').removeClass('play');
            link.addClass('active');
            link.addClass('play');
            player.src = link.attr('href');

            let title = link.data('title');
            let img = link.data('img');
            $('.player__title').text(title);
            $('.player__cover img').attr('src', img);
            audio[0].load();
            audio[0].play();
        }
    }

    /* playlist */
    // if ($('.main__list--playlist').length) {
    //     var current = 0;
    //     var playlist = $('.main__list--playlist');
    //     var tracks = playlist.find('li a[data-playlist]');
    //     var len = tracks.length;
    //
    //     playlist.find('a[data-playlist]').on('click', function(e){
    //         e.preventDefault();
    //         let link = $(this);
    //         current = link.parent().index();
    //         run2(link, audio[0]);
    //     });
    //
    //     player.on('ended', event => {
    //         let link = $('.single-item__cover.play');
    //         current++;
    //         if (current == len) {
    //             current = 0;
    //             link = playlist.find('a[data-playlist]')[0];
    //         } else {
    //             link = playlist.find('a[data-playlist]')[current];
    //         }
    //         run2($(link),audio[0]);
    //     });
    //
    //     $('.plyr__control--prev').on('click', function(e){
    //         let link = $('.single-item__cover.play');
    //         current--;
    //         if (current == -1) {
    //             current = len - 1;
    //             link = playlist.find('a[data-playlist]')[current];
    //         } else {
    //             link = playlist.find('a[data-playlist]')[current];
    //         }
    //         run2($(link),audio[0]);
    //     });
    //
    //     $('.plyr__control--next').on('click', function(e){
    //         let link = $('.single-item__cover.play');
    //         current++;
    //         if (current == len) {
    //             current = 0;
    //             link = playlist.find('a[data-playlist]')[0];
    //         } else {
    //             link = playlist.find('a[data-playlist]')[current];
    //         }
    //         run2($(link),audio[0]);
    //     });
    //
    //     function run2(link, player){
    //         if ($(link).hasClass('play')) {
    //             $(link).removeClass('play');
    //             audio[0].pause();
    //             $(link).addClass('pause');
    //         }
    //         else if ($(link).hasClass('pause')) {
    //             $(link).removeClass('pause');
    //             audio[0].play();
    //             $(link).addClass('play');
    //         }
    //         else {
    //             $('a[data-playlist]').removeClass('active');
    //             $('a[data-playlist]').removeClass('pause');
    //             $('a[data-playlist]').removeClass('play');
    //             $(link).addClass('active');
    //             $(link).addClass('play');
    //             player.src = $(link).attr('href');
    //
    //             let title = $(link).data('title');
    //             let artist = $(link).data('artist');
    //             let img = $(link).data('img');
    //             $('.player__title').text(title);
    //             $('.player__artist').text(artist);
    //             $('.player__cover img').attr('src', img);
    //             audio[0].load();
    //             audio[0].play();
    //         }
    //     }
    // }
});