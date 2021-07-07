let id, name, price, image;

$(window).on('load', function (response) {
    if (!response.error) {
        const url_string = $(location).attr('href');
        const url = new URL(url_string);
        id = url.searchParams.get('id');
        console.log('id : ' + id);
        $.get('https://8b71e6d6216f.ngrok.io/api/package/' + id + '/detail', function (response) {
            console.log("res : " + response);
            $(".package.name").text(name = response.package.name);
            $(".package.price").text(price = response.package.price);
            $(".package.image").attr('src', image = response.package.image);
            $(".package.image").attr('alt', name);
            $(".share__link--tw").attr("href", "http://twitter.com/share?text=" + name + "&url=" + url_string)
            $(".share__link--fb").attr("href", "https://facebook.com/sharer/sharer.php?u=" + url_string);
            $(".share__link--ig").attr("href", "https://www.instagram.com/?url=" + url_string);
        });
    }
});

$(document).ready(function () {
    $('.btn-add-to-basket').on('click', function (e) {
        e.preventDefault();
        const $error_message = 'محصول '+name+' در سبد خرید موجود است.';
        const $success_message = 'محصول '+name+' به سبد خرید اضافه شد.';

        updateCart('package',id,$success_message,$error_message);
    });
})