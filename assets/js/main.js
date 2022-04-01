$(document).ready(function () {

    const current_url = $(location).attr('href');
    let api_url = null;
    if (current_url.indexOf('artists') >= 0)
        api_url = 'artist';
    else if (current_url.indexOf('studios') >= 0)
        api_url = 'studio';
    else if (current_url.indexOf('store') >= 0)
        api_url = 'package';

    $('.main__select2[name="cities"]').select2({
        // minimumResultsForSearch: Infinity,
        width: "100%",
        dir: "rtl",
        multiple: true,
        maximumSelectionLength: 2,
        placeholder: "شهر ...",
        message: {
            noResults: "اوپس"
        }
    });

    $(window).on('scroll load', function () {
        if ($(window).scrollTop() > 50) {
            $('header').addClass('sticky');
        } else {
            $('header').removeClass('sticky');
        }

        // if ($(window).scrollTop() > 100) {
        //     $('.aux-goto-top-btn').addClass('visible');
        // } else {
        //     $('.aux-goto-top-btn').removeClass('visible');
        // }
    });

    $(window).on('load', function () {
        let value;
        if (value = getUrlParams('search')) {
            const parent = $('#filter__name-form');
            parent.find('[name=\'search\']').val(value);
            parent.find('.form-group--addon').addClass('show');
        }
        if (value = getUrlParams('title')) {
            const radio = $('.filter__single-cb [value$=\'' + value + '\']');
            radio.prop('checked', true);
            radio.parent().prev('.filter__list-itemdel').addClass('show');
        }
        if (value = getUrlParams('ap_min_max')) {
            value = value.split('_');
            if (value.length === 2) {
                const slider = $(".filter__single-range .slider");
                slider.slider('values', 0, value[0]);
                slider.slider('values', 1, value[1]);
                $(slider.data('value-0')).text(formatPrice(value[0]));
                $(slider.data('value-1')).text(formatPrice(value[1]));
            }
        }
        if (value = getUrlParams('min_max')) {
            const inputMin = $('.filter__single-formrange').find('[name="price_min"]');
            const inputMax = $('.filter__single-formrange').find('[name="price_max"]');
            const min = value.split('_')[0];
            const max = value.split('_')[1];
            if (max < parseInt(inputMax.attr('max')))
                inputMax.val(max);
            if (min > parseInt(inputMin.attr('min')))
                inputMin.val(min);
        }
        if (value = getUrlParams('cityIds')) {
            const cities = value !== null ? value.split('_') : [];
            $('.main__select2[name=\'cities\']').val(cities);
            $('.main__select2[name=\'cities\']').trigger('change');
        }
        if (value = getUrlParams('rpp')) {
            $('.rpp-number').removeClass('rpp-current');
            $('.rpp-number[data-rpp=\'' + value + '\']').addClass('rpp-current');
        }

        if ($('.filter__list-itemdel.show').length > 0)
            $('.filter__reset').addClass('show');

        const parent = $('#list__main-container');
        const count = parent.find('.' + api_url).length;
        const emptyBlock = parent.find('#main-list-empty');
        if (count > 0) {
            emptyBlock.addClass('d-none');
            emptyBlock.removeClass('d-block');
        } else {
            emptyBlock.addClass('d-block');
            emptyBlock.removeClass('d-none');
        }
    });

    const owl = $('.owl-carousel.artists__carousel').owlCarousel({
        mouseDrag: true,
        touchDrag: true,
        items: 3,
        dots: false,
        nav: false,
        margin: 10,
        responsive: {
            0: {items: 1},
            567: {items: 2},
            992: {items: 3}
        }
    });
    $('.owl-carousel.studio__carousel').owlCarousel({
        mouseDrag: true,
        touchDrag: true,
        items: 1,
        dots: false,
        nav: false,
        margin: 10
    });

    $('.main__nav--prev').on('click', function () {
        const carousel = $(this).siblings('.owl-carousel');
        carousel.trigger('prev.owl.carousel');
        watchArrows();
    });

    $('.main__nav--next').on('click', function () {
        const carousel = $(this).siblings('.owl-carousel');
        carousel.trigger('next.owl.carousel');
        watchArrows()
    });

    // $('.aux-goto-top-btn').on('click', function () {
    //     $('body,html').animate({
    //         scrollTop: 0
    //     }, 600, $.bez([0.215, 0.610, 0.355, 1.000]));
    // })


    watchArrows();

    function watchArrows() {
        const carousel = $('.owl-carousel');
        if (carousel.find('.owl-item:first-child').hasClass('active')) {
            $('.main__nav--prev').addClass('deactive');
        } else {
            $('.main__nav--prev').removeClass('deactive');
        }
        if (carousel.find('.owl-item:last-child').hasClass('active')) {
            $('.main__nav--next').addClass('deactive');
        } else {
            $('.main__nav--next').removeClass('deactive');
        }
    }

    /* clear or reset filters */
    $('.filters__total-container').on('click', '.filter__reset', function () {

        /* clear filters */
        $('.filter__list-itemdel').removeClass('show');
        $('#filter__name-form [name=\'search\']').val(null);
        $('.filter__checkbox [name=\'title\']').prop('checked', false);

        $('.filter__single-formrange').find('[name="price_min"]').val(null);
        $('.filter__single-formrange').find('[name="price_max"]').val(null);
        $('.main__select2[name=\'cities\']').val(null);
        $('.main__select2[name=\'cities\']').trigger('change');
        resetSlider();

        /* hide button */
        $(this).removeClass('show');

        /* rerender list */
        deleteUrlParams();
        appendUrlParam('page=1');
        updateDataList();
    });

    /* List item title */
    $('.filter__single-cb').on('change', 'input:radio', function () {

        $(this).prop('checked', true);
        $(this).closest('.filter').find('.filter__list-itemdel').removeClass('show');
        $(this).parent().prev('.filter__list-itemdel').addClass('show');

        if ($('.filter__reset.show').length === 0)
            $('.filter__reset').addClass('show');

        appendUrlParam($(this).val());
        updateDataList();
    });

    $('.filter__single-cb').on('click', '.filter__list-itemdel.show', function (e) {
        e.preventDefault();
        $(this).next().find('input').prop('checked', false);
        $(this).removeClass('show');

        if ($('.filter__list-itemdel.show').length === 0)
            $('.filter__reset').removeClass('show');

        deleteUrlParams('title');
        updateDataList()
    });

    /* Slide Range slider */
    $('.filter__single-range').on('click', '.filter__slider-range--btn', function (e) {
        e.preventDefault();
        $(this).next('.filter__list-itemdel').addClass('show');
        const [min, max] = $(".slider").slider("option", "values");

        if ($('.filter__reset.show').length === 0)
            $('.filter__reset').addClass('show');

        appendUrlParam('page=1&ap_min_max=' + min + '_' + max + '&page=1');
        updateDataList();
    });

    $('.filter__single-range').on('click', '.filter__list-itemdel.show', function (e) {
        e.preventDefault();
        $(this).removeClass('show');
        resetSlider();

        if ($('.filter__list-itemdel.show').length === 0)
            $('.filter__reset').removeClass('show');

        deleteUrlParams('ap_min_max');
        updateDataList();
    });

    /* Name Filter */
    $('#filter__name-wrap').on('submit', '#filter__name-form', function (e) {
        e.preventDefault();
        const $this = $(this);
        const search = $this.find('[name=\'search\']').val();
        $this.find('.form-group--addon .filter__list-itemdel').addClass('show');

        if ($('.filter__reset.show').length === 0)
            $('.filter__reset').addClass('show');

        appendUrlParam('page=1&search=' + search + '&page=1');
        updateDataList();
    });

    $('#filter__name-wrap').on('click', '.filter__list-itemdel.show', function (e) {
        e.preventDefault();
        const $this = $(this);
        $this.removeClass('show');
        $this.closest('form').find('[name=\'search\']').val(null);

        if ($('.filter__list-itemdel.show').length === 0)
            $('.filter__reset').removeClass('show');

        deleteUrlParams('search');
        updateDataList();
    });

    /* Input range Filter */
    $('.filter__single-formrange').on('submit', function (e) {
        e.preventDefault();
        const inputMin = $(this).find('[name="price_min"]');
        const inputMax = $(this).find('[name="price_max"]');
        if (inputMin.val() !== '' || inputMax.val() !== '') {
            const min = inputMin.val() !== '' ? inputMin.val() : inputMin.attr('min');
            const max = inputMax.val() !== '' ? inputMax.val() : inputMax.attr('max');

            $(this).find('.filter__list-itemdel').addClass('show');

            if ($('.filter__list-itemdel.show').length === 0)
                $('.filter__reset').addClass('show');

            appendUrlParam('page=1&' + (api_url === 'package' ? 'p_' : '') + 'min_max=' + min + '_' + max);
            updateDataList();
        }
    });

    $('.filter__single-formrange').on('click', '.filter__list-itemdel.show', function (e) {
        e.preventDefault();
        $(this).removeClass('show');

        const parent = $('.filter__single-formrange');
        parent.find('[name="price_min"],[name="price_max"]').val(null);

        if ($('.filter__list-itemdel.show').length === 0)
            $('.filter__reset').removeClass('show');

        deleteUrlParams((api_url === 'package' ? 'p_' : '') + 'min_max');
        updateDataList();
    });

    /* Cities Range Filter */
    $('.main__select2[name=\'cities\']').on('change', function () {
        let cities = $(this).val(), _cities = "";
        if (cities!==null && cities.length > 0) {
            for (let i = 0; i < cities.length; i++) {
                _cities += cities[i];
                if (i !== cities.length - 1)
                    _cities += "_";
            }
            appendUrlParam("cityIds=" + _cities);
        } else {
            deleteUrlParams('cityIds');
        }
        appendUrlParam('page=1');
        updateDataList();
    });

    $('body').on('click', '.select2-selection__choice__remove', function () {
        console.log("i ref");
        const val = $(this).parent('li').data('select2-id');
        console.log("id : " + val);
        const select2 = $('.main__select2[name="cities"]');
        const select_values = select2.val();
        let cities = "";

        const index = select_values.indexOf(val);
        if (index > -1) {
            select_values.splice(index, 1);
            if (select_values.length > 0) {
                select2.val(select_values);
                for (let i = 0; i < select_values.length; i++) {
                    cities += select_values[i];
                    if (i !== select_values.length - 1)
                        cities += "_";
                }
                appendUrlParam("cityIds=" + cities);
            } else {
                deleteUrlParams('cityIds');
            }
            appendUrlParam('page=1');
            updateDataList();
        }
    });

    $(document).on('click', '.studio__location-badge', function (e) {
        e.preventDefault();
        const currentUrl = $(location).attr('href');
        const cityId = $(this).data('id');
        if (currentUrl.indexOf($(this).attr('href')) >= 0) {
            $('.main__select2[name=\'cities\']').val([cityId]);
            $('.main__select2[name=\'cities\']').trigger('change');
            appendUrlParam("page=1&cityIds=" + cityId);
            updateDataList();
        } else {
            $(location).attr('href', $(this).attr('href') + "?cityIds=" + cityId);
        }
    })


    $('body, #list__main-container').on('click', '.css-select__option', function () {
        // cssSelect(this);
        const $this = $(this);
        const query = $this.data('css-select');
        const parent = $this.parent().parent();
        // const parent = option.parentNode.parentNode ;
        parent.find('[data-css-select="hidden"]').val($this.html());
        parent.find('[data-css-select="selected"]').val($this.html());
        // parent.find('[data-css-select="hidden"]').val = query;
        // parent.find('[data-css-select="selected"]').value = $this.text();
        // $('.css-select__dropdown').focusout();
        document.activeElement.blur();
        appendUrlParam(query);
        updateDataList();
    });

    $(document).on('click', '.artist .artist__badge', function (e) {
        e.preventDefault();
        const currentUrl = $(location).attr('href');
        const title = $(this).data('title');
        if (currentUrl.indexOf($(this).attr('href')) >= 0) {
            appendUrlParam('title=' + title);
            const radio = $('.filter__checkbox [value=\'title=' + title + '\']');
            radio.attr('checked', true);
            radio.parents('.filter').removeClass('show');
            radio.parent().prev('.filter__list-itemdel').addClass('show');
            updateDataList();
        } else {
            $(location).attr('href', $(this).attr('href') + "?title=" + title);
        }
    })

    $('#list__main-container .rpp-number').on('click', function (e) {
        e.preventDefault();
        if (!$(this).hasClass('rpp-current')) {
            const rpp = $(this).data('rpp');
            $('.rpp-number').removeClass('rpp-current');
            $(this).addClass('rpp-current');
            appendUrlParam('page=1&rpp=' + rpp);
            updateDataList();
        }
    });

    $('.responsive-filterbar-toggle a').on('click', function () {
        $("header").addClass("zindex-0");
        console.log($('header').height());
        $(".filters__total-container").css({'top' : ($(window).scrollTop()-$('header').height())+"px"})
        $('.filters__total-container').addClass('is-open', function () {
            setTimeout(function () {
                $('.filters__total-wrap').addClass('open');
                $('html').addClass('overflow-hidden');
            }, 500);
        });
    });

    /* pagination handler */
    $('body').on('click', '.pagination li:not(.active) a, .pagination-custom_outline .next, .pagination-custom_outline .prev', function (e) {
        e.preventDefault();
        const link = $(this).attr('href');
        const pageNum = link.substr(link.lastIndexOf('=') + 1);
        appendUrlParam('page=' + pageNum);
        updateDataList();
    });

    $('body').on('click', '.filters__total-container .filters__hide-btn, .filters__total-back', function () {
        $('.filters__total-wrap').removeClass('open', function () {
            $('html').removeClass('overflow-hidden');
            setTimeout(function () {
                $("header").removeClass("zindex-0")
                $('.filters__total-container').removeClass('is-open')
            }, 500);
        });
    });

    function updateDataList(_params = getUrlParams()) {
        blockUI();
        const parent = $('#lists__main-list');
        console.log("s" + _params);
        $.ajax({
            method: 'GET',
            url: 'ajax/' + api_url + 's/filter.php',
            data: {
                params: _params
            },
            success: function (response) {
                parent.children('.row').html(response);
                const count = parent.find('.' + api_url).length;
                const emptyBlock = parent.find('#main-list-empty');
                if (count > 0) {
                    emptyBlock.addClass('d-none');
                    emptyBlock.removeClass('d-block');
                } else {
                    emptyBlock.addClass('d-block');
                    emptyBlock.removeClass('d-none');
                }
            },
            error: function (error) {
                console.log("res ::: " + error);
                console.log("e: " + error);
            }
        });
    }

    function blockUI(element = null) {
        const options = {
            message: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
            timeout: 1000,
            overlayCSS: {
                backgroundColor: 'rgba(10,10,10,.85)',
                opacity: 1,
                cursor: 'wait'
            },
            css: {
                // top: '15px',
                border: 0,
                color: '#fff',
                padding: 0,
                backgroundColor: 'transparent'
            }
        };
        if (element !== null) {
            $(element).block(options);
        } else {
            $.blockUI(options);
        }
    }

    function getUrlParams(key = null) {
        const url_string = $(location).attr('href');
        const url = new URL(url_string);
        const params = url.searchParams;
        if (key !== null) {
            return params.has(key) ? params.get(key) : null;
        } else {
            return params.toString();
        }
    }

    function deleteUrlParams(key = null) {
        const initParams = key === null ? "" : $(location).attr('search');
        if (history.pushState) {
            let searchParams = new URLSearchParams(initParams);
            if (key !== null)
                searchParams.delete(key);
            let newurl = $(location).attr('protocol') + "//" + $(location).attr('host') + $(location).attr('pathname') + '?' + searchParams.toString();
            window.history.pushState({path: newurl}, '', newurl);
        }
    }

    function appendUrlParam(params) {

        if (history.pushState) {
            let searchParams = new URLSearchParams($(location).attr('search'));
            if (params) {
                params = params.split("&");
                for (let i = 0; i < params.length; i++) {
                    const key_val = params[i].split("=");
                    searchParams.set(key_val[0], key_val[1]);
                }
            }
            let newurl = $(location).attr('protocol') + "//" + $(location).attr('host') + $(location).attr('pathname') + '?' + searchParams.toString();
            window.history.pushState({path: newurl}, '', newurl);

            return searchParams.toString();
        }
    }

    // $('.css-select__option').on('click', function (option) {
    //     const $this = $(this);
    //     const parent = $this.parent().parent();
    //     // console.log(option.innerHTML);
    //     // const parent = option.parentNode.parentNode;
    //     parent.find('[data-css-select="hidden"]').val($this.html());
    //     parent.find('[data-css-select="selected"]').val($this.html());
    //     parent.querySelector('[data-css-select="hidden"]').value = option.dataset.cssSelect;
    //     parent.querySelector('[data-css-select="selected"]').value = option.innerHTML;
    //     $(document).activeElement.blur();
    // });

    /********************/
    /*   Package Cart   */
    /********************/

    $(document).on('click', 'button.cart__delete', function (e) {
        e.preventDefault();
        $(this).closest('tr').addClass('has-focus');
        $('#deleteModal-container').fadeIn();
    });

    $('.cart__form-discount').on('submit',function (e){
        e.preventDefault();
        const input = $(this).find(':input[name="discount_code"]');
        if (input.val()!==''){
            $.ajax({
                method : 'GET',
                url : 'ajax/discount.php',
                data : {code : input.val()},
                success : function (response){
                    response = JSON.parse(response);
                    if (!response.error){
                        input.val(null);
                        input.blur();
                        $('.cart__total').find('span').remove();
                        $('.cart__total').append($('<span class="discounted"></span>').text(formatPrice((response.amountOfPayment+response.amountOfDiscount)+'')+' تومان'));
                        $('.cart__total').append($('<span></span>').text(formatPrice(response.amountOfPayment+'')+' تومان'))
                    }
                    Snackbar.show({
                        text: response.hasOwnProperty('messages') ? response.messages[0] : (response.error ? 'مشکلی پیش آمد. مجددا امتحان کنید' : 'کد تخفیف اعمال شد'),
                        showAction: false,
                        pos: 'top-right ' + (response.error ? ' danger' : ''),
                        duration: 5000
                    });
                }, error : function (error){
                    console.log("err : "+error);
                }
            });
        }
    });

    $('#deleteModal-container').on('click', 'a.cancel', function () {
        $('tr.has-focus').removeClass('has-focus');
        $('#deleteModal-container').fadeOut();
    });

    $('#deleteModal-container').on('click', 'a.ok', function () {
        const id = $('tr.has-focus').data('id');
        const type = $('tr.has-focus').data('type');
        $.ajax({
            method: 'POST',
            url: 'ajax/cart/delete.php',
            data: {
                itemId: id,
                type: type
            },
            success: function (response) {
                response = JSON.parse(response);

                if (!response.error) {
                    const $tr_focus = $('tr.has-focus');
                    $tr_focus.fadeOut("slow", () => {
                        setTimeout(() => {
                            $tr_focus.remove();
                            console.log("$('.cart__table tbody').find('tr').length = " + $('.cart__table tbody').find('tr').length);
                            if ($('.cart__table tbody').find('tr').length < 1) {
                                $(location).attr('href', $(location).attr('href'));
                            }
                        }, 100);
                    });
                } else {
                    $('tr.has-focus').removeClass('has-focus');
                }
                $('#deleteModal-container').fadeOut();
                Snackbar.show({
                    text: response.error ? 'مشکلی پیش آمد. مجددا امتحان کنید' : 'محصول از سبد خرید شما حذف شد',
                    showAction: false,
                    pos: 'top-right ' + (response.error ? ' danger' : ''),
                    duration: 3000
                });
            }, error: function (error) {
                console.log("error : " + error);
            }
        })
    });

    $(document).on('click', '.btn__buy-package , .product .product__addto-basket', function () {
        const _this = $(this);
        const id = $(this).data('id');
        if (id != null) {
            $.ajax({
                method: 'POST',
                url: 'ajax/cart/add.php',
                data: {
                    type: 'package',
                    itemId: id
                }, success: function (response) {
                    response = JSON.parse(response);
                    Snackbar.show({
                        text: response.hasOwnProperty('messages') ? (typeof response['messages'] === 'string' ? response['messages'] : response['messages'][0]) : (response.error ? 'مشکلی پیش آمد. مجددا امتحان کنید' : 'محصول به سبد خرید شما افزوده شد'),
                        showAction: false,
                        pos: 'top-right ' + (response.error ? ' danger' : ''),
                        duration: 3000
                    });
                    if (!response.error) {
                        $('.package__single .package__in-cart,.package__single .btn__buy-package').toggleClass('d-none');
                        _this.toggleClass('product__deletefrom-basket product__addto-basket');
                        // $('.product .product__addto-basket').addClass('product__deletefrom-basket');
                    }
                }, error: function (error) {
                    console.log("error : " + error);
                }
            });
        }
    });

    $(document).on('click', '.btn__remove-package, .product .product__deletefrom-basket', function () {
        const id = $(this).data('id');
        if (id != null) {
            $.ajax({
                method: 'POST',
                url: 'ajax/cart/delete.php',
                data: {
                    type: 'package',
                    itemId: id
                }, success: function (response) {
                    console.log("res : " + response);
                    response = JSON.parse(response);
                    Snackbar.show({
                        text: response.hasOwnProperty('messages') ? (typeof response['messages'] === 'string' ? response['messages'] : response['messages'][0]) : (response.error ? 'مشکلی پیش آمد. مجددا امتحان کنید' : 'محصول از سبد خرید شما حذف شد'),
                        showAction: false,
                        pos: 'top-right ' + (response.error ? ' danger' : ''),
                        duration: 3000
                    });
                    if (!response.error) {
                        $('.package__single .package__in-cart,.package__single .btn__buy-package').toggleClass('d-none');
                        $('.product .product__deletefrom-basket').toggleClass('product__deletefrom-basket product__addto-basket');
                        $('.product .product__addto-basket > svg > path:first-child').css({transform: ''});
                    }
                }, error: function (error) {
                    console.log("error : " + error);
                }
            });
        }
    });

    /********************/
    /*   Artist Cart    */
    /********************/

    $('.modal__close').on('click', function () {
        $.magnificPopup.close();
    });

    $('a.select__advisor').magnificPopup({
        type: 'inline',
        fixedContentPos: true,
        fixedBgPos: true,
        overflowY: 'auto',
        preloader: false,
        modal: false,
        removalDelay: 300,
        mainClass: 'mfp-fade'
    });

    $(document).on('click', '.advisor__time-badge a', function (e) {
        e.preventDefault()
        const _this = $(this);
        const isSelected = _this.parent('li').hasClass('selected');
        $.ajax({
            method: 'POST',
            url: 'ajax/cart/' + (isSelected ? 'delete' : 'add') + '.php',
            data: {
                type: 'advisor',
                itemId: _this.data('id')
            }, success: function (response) {
                console.log("res : " + response);
                response = JSON.parse(response);
                Snackbar.show({
                    text: response.hasOwnProperty('messages') ? (typeof response['messages'] === 'string' ? response['messages'] : response['messages'][0]) : (response.error ? 'مشکلی پیش آمد. مجددا امتحان کنید' : 'محصول از سبد خرید شما حذف شد'),
                    showAction: false,
                    pos: 'top-right ' + (response.error ? ' danger' : ''),
                    duration: 3000
                });
                if (!response.error) {
                    $.magnificPopup.close();
                    _this.parent('li').toggleClass('selected');
                }
            }, error: function (error) {
                console.log("error : " + error);
            }
        });
    });

    $('select[name="advisor__days-select"]').on('change', function (e) {
        e.preventDefault();
        const itemDate = $(this).val();
        const artistId = $('.artist__single').data('id');
        const modal = $('#modal-topup');
        blockUI(modal.find('.advisor__times-list'));
        $.ajax({
            method: 'GET',
            url: 'ajax/artists/advisor/get.php',
            data: {itemId: artistId, itemDate: itemDate},
            success: function (response) {
                if (typeof response === 'object') {
                } else {
                    modal.find('.advisor__times-list').remove();
                    modal.find('select[name="advisor__days-select"]').after(response);
                }
            }, error: function (error) {
                console.log('error : ' + error);
            }
        })
    });

    $('.artist__single').on('click', 'a.select__title', function () {
        const id = $(this).data('id');
        if (id != null) {
            $.ajax({
                method: 'POST',
                url: 'ajax/cart/add.php',
                data: {
                    type: 'teammate',
                    itemId: id
                }, success: function (response) {
                    console.log("res : " + response);
                    response = JSON.parse(response);
                    Snackbar.show({
                        text: response.hasOwnProperty('messages') ? response['messages'][0] : (response.error ? 'مشکلی پیش آمد. مجددا امتحان کنید' : 'محصول به سبد خرید شما افزوده شد'),
                        showAction: false,
                        pos: 'top-right ' + (response.error ? ' danger' : ''),
                        duration: 3000
                    });
                    // if (!response.error) {
                    //     $('.package__single .package__in-cart,.package__single .btn__buy-package').toggleClass('d-none');
                    //     $('.product .product__addto-basket').toggleClass('product__deletefrom-basket product__addto-basket');
                    //     // $('.product .product__addto-basket').addClass('product__deletefrom-basket');
                    // }
                }, error: function (error) {
                    console.log("error : " + error);
                }
            });
        }
    });

    $('.artist__single button.select__advisor').on('click', function () {

    });

    /*********************/
    /* Send singing Test */
    /*********************/
    $('#singing__test-form').on('submit', function (e) {
        e.preventDefault();
        const form = $(this);
        let formData = new FormData();
        const files = form.find('[name="singing_file"]')[0].files;
        console.log("files : " + files);
        if (files) {
            formData.append('singing_file', files[0]);
            $.ajax({
                async: false,
                method: 'POST',
                url: 'ajax/singing/send.php',
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    form.next('.alert').remove();
                    try {
                        response = JSON.parse(response);
                        if (response.error) {
                            form.after('<div class="alert alert-lg alert-outline-danger"></div>');
                            form.next('.alert').text(response.messages[0]);
                        } else {
                            form.after('<div class="alert alert-lg alert-outline-success"></div>');
                            form.next('.alert').text('صدای شما ارسال شد. به زودی با شما تماس خواهیم گرفت');
                            setTimeout(function () {
                                $(location).attr('href', 'index.php');
                            }, 2000);
                        }
                    } catch (_) {
                        form.after('<div class="alert alert-lg  alert-outline-danger"></div>');
                        form.next('.alert').text('برای ارسال صدا ابتدا در اکانت خود لاگین شوید');
                    }
                }, error: function (error) {
                    console.log('error : ' + error);
                }
            })
        } else {
            alert("باید فایل را انتخاب کنید")
        }
    })

    /*********************/
    /* Audio File Upload */
    /*********************/

    function handleFiles(event) {
        var files = event.target.files;
        $("#track").attr("src", URL.createObjectURL(files[0]));
        document.getElementById("track").load();
        $("div.player").toggleClass('d-none');
        $(".file-upload-wrapper").toggleClass('d-none');
    }

    $("#audiofile").on("change", handleFiles);

    $('#track').each(function (index, audio) {
        $(audio).on('canplay', function () {
            $("#duration")[0].innerHTML = sec2time(audio.duration);
            $("#timeslieder")[0].max = audio.duration * 1000;
        });
    });

    /* start button */
    $("#start").on('click', function () {
        $("#track")[0].play();
        $(this).toggleClass('d-none');
        $("#pause").toggleClass('d-none');
    });
    /* pause button */
    $("#pause").on('click', function () {
        $("#track")[0].pause();
        $(this).toggleClass('d-none');
        $("#start").toggleClass('d-none');
    });
    /* reset button */
    $("#reset").on('click', function () {
        $("#track")[0].load();
        $("#start").toggleClass('d-none');
        $("#pause").toggleClass('d-none');
    });
    /* timeupdate log */
    if ($('#track').length > 0) {
        $('#track')[0].addEventListener('timeupdate', function () {
            const currentTimeSec = this.currentTime;
            const currentTimeMs = this.currentTime * 1000;
            $("#currentTime")[0].innerHTML = sec2time(currentTimeSec);
            $("#timeslieder")[0].value = currentTimeMs;
            initRangeEl();
            const arrayTime = [sec2time(currentTimeSec), currentTimeMs];
        }, false);
    }

    function sec2time(timeInSeconds) {
        const pad = function (num, size) {
                return ('000' + num).slice(size * -1);
            },
            time = parseFloat(timeInSeconds).toFixed(3),
            hours = Math.floor(time / 60 / 60),
            minutes = Math.floor(time / 60) % 60,
            seconds = Math.floor(time - minutes * 60),
            milliseconds = time.slice(-3);
        return pad(hours, 2) + ':' + pad(minutes, 2) + ':' + pad(seconds, 2);
    }


    /* timeline slieder */
    function valueTotalRatio(value, min, max) {
        return ((value - min) / (max - min)).toFixed(2);
    }

    function getLinearGradientCSS(ratio, leftColor, rightColor) {
        return [
            '-webkit-gradient(',
            'linear, ',
            'left top, ',
            'right top, ',
            'color-stop(' + ratio + ', ' + leftColor + '), ',
            'color-stop(' + ratio + ', ' + rightColor + ')',
            ')'
        ].join('');
    }

    3

    function updateRangeEl(rangeEl) {
        const ratio = valueTotalRatio(rangeEl.value, rangeEl.min, rangeEl.max);
        rangeEl.style.backgroundImage = getLinearGradientCSS(ratio, '#6a6a70', '#fffcfc');
    }

    function initRangeEl() {
        var rangeEl = document.getElementById("timeslieder");
        updateRangeEl(rangeEl);
        rangeEl.addEventListener("input", function (e) {
            updateRangeEl(e.target);
        });
    }

    if ($("#timeslieder").length > 0) {
        $("#timeslieder")[0].addEventListener("input", function (e) {
            updateRangeEl(e.target);
            this.value = e.target.value;
            $("#track")[0].currentTime = e.target.value / 1000;
        });
    }

});