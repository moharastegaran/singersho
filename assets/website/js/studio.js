
let id,name;

$(window).on('load',function (){
    const url_string = $(location).attr('href');
    const url = new URL(url_string);
    const _id = url.searchParams.has('id') ? url.searchParams.get('id') : '1';
    $.get(__url__+'/studio/'+_id+'/detail',function (response){
        if(!response.error){
            const _studio = response.studio;
            id = _id;
            if(_studio.images.length > 0){
                $(".studio.images").append("<div class='store-item__carousel owl-carousel' id='hero'>")
                for (let i = 0; i < _studio.images.length; i++) {
                    $(".studio.images .store-item__carousel").append("<div class='store-item__cover' style=\"background: url("+_studio.images[i].path+") center center no-repeat;background-size: cover;height: 250px\"></div>")
                }
                $(".studio.images").append("</div>\n");
                $('.store-item__carousel').owlCarousel({
                    mouseDrag: false,
                    touchDrag: true,
                    dots: true,
                    loop: false,
                    autoplay: false,
                    smartSpeed: 600,
                    autoHeight: false,
                    items: 1,
                    responsive: {
                        0: {
                            margin: 20,
                        },
                        576: {
                            margin: 20,
                        },
                        768: {
                            margin: 30,
                        },
                        1200: {
                            margin: 30,
                        },
                    }
                });
            }else{
                $(".studio.images").append("<img src='assets/website/img/studio-placeholder.png' class='img-fluid rounded'>")
            }

            $(".studio.name").append(name=_studio.name);
            $(".studio.description").append(_studio.description);
            $(".studio.address").append(_studio.address);
            $(".studio.price").append(handle_price(_studio.price.toString())+" تومان");
            $(".share__link--tw").attr("href", "http://twitter.com/share?text=" + _studio.name + "&url=" + url_string)
            $(".share__link--fb").attr("href", "https://facebook.com/sharer/sharer.php?u=" + url_string);
            $(".share__link--ig").attr("href", "https://www.instagram.com/?url=" + url_string);
        }
    });
});

$(document).ready(function (){
    $('.btn-add-to-basket').on('click', function (e) {
        e.preventDefault();
        const $error_message = 'استدیو '+name+' در سبد خرید موجود است.';
        const $success_message = 'استدیو '+name+' به سبد خرید اضافه شد.';

        updateCart('studio',id,$success_message,$error_message);
    });
    $("#slider-range").slider({
        range: true,
        min: 54,
        max: 242,
        step: 1,
        values: [54, 242],
        slide: function(e, ui) {
            var min = Math.floor(ui.values[0]);
            $('.slider-time').html(min + 'm');

            var max = Math.floor(ui.values[1]);

            $('.slider-time2').html(max + '.');

            $('.box').each(function() {
                var startTime = (min);
                var endTime = (max);
                //console.log('.box[data-start-time="' + startTime + '"]');

                var value = $(this).data('start-time');
                //console.log('Selecting all events between ' + startTime + ' and ' + endTime);
                // skeleton key
                //console.log(value + '<=' + endTime);
                if ((parseInt(endTime) >= parseInt(value) && (parseInt(startTime) <= parseInt(value))) ){
                    $(this).show();
                } else {
                    $(this).hide();
                }
                //
            });

        }
    });
});