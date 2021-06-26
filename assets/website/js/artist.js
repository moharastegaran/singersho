$(window).on('load', function () {

    const url_string = $(location).attr('href');
    const url = new URL(url_string);
    const id = url.searchParams.get('id');
    $.get('http://127.0.0.1:8000/api/artist/' + id + '/detail', function (response) {
        if (!response.error) {

            console.log("Res : "+JSON.stringify(response));

            const data = response.data;
            let avatar = `${data['artist'][0]['avatar']}`;
            if (avatar!==null) {
                avatar = avatar.replace('http://127.0.0.1:8000/storage/', '');
            }

            $(".artist.name").text(`${data['user']['first_name']}` + ' ' + `${data['user']['last_name']}`);
            $(".artist.avatar").attr('src',avatar);
            $(".artist.experience").text(`${data['artist'][0]['experience']}`);
            $(".artist.order_description").text(`${data['artist'][0]['order_description']}`);

            console.log("data.portfolio.length  = "+data.portfolio.length);

            if (data.hasOwnProperty('portfolio') && data.portfolio.length > 0) {
                for (let i=0;i<data.portfolio.length;i++) {
                    const p = data.portfolio[i];
                    console.log("pate : "+p.date);
                    const p_date = p.date.split('-');
                    $(".main__portfolio-artist").append("" +
                        "<div class=\"col-md-4 col-12\">\n"+
                        "<div class=\"live\">\n" +
                        "<a href=\"" + (p.sound !== null ? p.sound : (p.url !== null ? p.url : '#')) + "\" class=\"live__cover open-video\">\n" +
                        "<img src=\"" + p.image.replace('http://127.0.0.1:8000/storage/', '') + "\" alt=\"\">\n" +
                        "<span class=\"live__value\">"
                        +// new JDate(new Date(p_date[0], p_date[1], p_date[2])).format('dddd DD MMMM YYYY') + "تاریخ انجام: " +
                        "</span>\n" +
                        "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\"><path d=\"M18.54,9,8.88,3.46a3.42,3.42,0,0,0-5.13,3V17.58A3.42,3.42,0,0,0,7.17,21a3.43,3.43,0,0,0,1.71-.46L18.54,15a3.42,3.42,0,0,0,0-5.92Zm-1,4.19L7.88,18.81a1.44,1.44,0,0,1-1.42,0,1.42,1.42,0,0,1-.71-1.23V6.42a1.42,1.42,0,0,1,.71-1.23A1.51,1.51,0,0,1,7.17,5a1.54,1.54,0,0,1,.71.19l9.66,5.58a1.42,1.42,0,0,1,0,2.46Z\"></path></svg>\n" +
                        "</a>\n" +
                        "<h3 class=\"live__title\"><a href=\"https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-1080p.mp4\" class=\"open-video\">" + p.name + "</a></h3>\n" +
                        "</div></div>");
                }
                // $('.main__carousel--podcasts').owlCarousel({
                //     mouseDrag: true,
                //     touchDrag: true,
                //     dots: true,
                //     loop: true,
                //     autoplay: false,
                //     smartSpeed: 600,
                //     margin: 20,
                //     autoHeight: true,
                //     responsive: {
                //         0: {
                //             items: 1,
                //         },
                //         576: {
                //             items: 2,
                //         },
                //         768: {
                //             items: 2,
                //             margin: 30,
                //         },
                //         992: {
                //             items: 3,
                //             margin: 30,
                //         },
                //         1200: {
                //             items: 3,
                //             margin: 30,
                //             mouseDrag: false,
                //         },
                //     }
                // });
            }

            if(data.hasOwnProperty('title') && data.title.length > 0){
                for (let i=0;i<data.title.length;i++) {
                    const t = data.title[i];
                    $(".main__titles-artist").append("" +
                        "<div class=\"col-12 col-md-6 col-lg-4\">\n" +
                        "<div class=\"step\">\n" +
                        "<span class=\"feature__icon\">\n" +
                        "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\"><path d=\"M21.65,2.24a1,1,0,0,0-.8-.23l-13,2A1,1,0,0,0,7,5V15.35A3.45,3.45,0,0,0,5.5,15,3.5,3.5,0,1,0,9,18.5V10.86L20,9.17v4.18A3.45,3.45,0,0,0,18.5,13,3.5,3.5,0,1,0,22,16.5V3A1,1,0,0,0,21.65,2.24ZM5.5,20A1.5,1.5,0,1,1,7,18.5,1.5,1.5,0,0,1,5.5,20Zm13-2A1.5,1.5,0,1,1,20,16.5,1.5,1.5,0,0,1,18.5,18ZM20,7.14,9,8.83v-3L20,4.17Z\"></path></svg>\n" +
                        "</span>\n" +
                        "<h3 class=\"step__title\">"+t.name+"</h3>\n" +
                        "<p class=\"step__text\">"+t.description+"</p>\n" +
                        "</div>\n" +
                        "</div>")
                }
            }
        }
    })
});