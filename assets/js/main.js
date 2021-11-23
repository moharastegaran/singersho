document.addEventListener('mousedown', (event) => {
    const target = event.target;
    if (!(target.dataset.cssSelect && target.dataset.cssSelect === 'selected')) {
        return null;
    }
    if (window.getComputedStyle(target.nextElementSibling).visibility === 'visible') {
        setTimeout(() => void document.activeElement.blur(), 0);
    }
});

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

    // $('.main__select2[name="cities"]').on('change', function () {
    // const ps = new PerfectScrollbar('.select2-results__options', {
    //     wheelSpeed: .5,
    //     swipeEasing: !0,
    //     minScrollbarLength: 40,
    //     maxScrollbarLength: 300,
    //     suppressScrollX: true
    // });
    // })

    $('a[href="#mm-menu"]').on('click', function (e) {
        e.preventDefault();
        // $('html').addClass('mm-opening');
        $('#mm-menu').addClass('mm-opened');
        $('#mm-0').addClass('is-opening');
        $('#mm-blocker').addClass('dblock is-opening');
    });

    $('#mm-blocker').on('click', function (e) {
        e.preventDefault();
        // $('html').removeClass('mm-opening');
        $('#mm-menu').removeClass('mm-opened is-opening');
        $('#mm-0').removeClass('is-opening');
        setTimeout(function () {
            $('#mm-blocker').removeClass('dblock is-opening')
        }, 400);
    })

    $(window).on('scroll load', function () {
        if ($(window).scrollTop() > 50) {
            $('header').addClass('sticky');
        } else {
            $('header').removeClass('sticky');
        }

        if ($(window).scrollTop() > 100) {
            $('.aux-goto-top-btn').addClass('visible');
        } else {
            $('.aux-goto-top-btn').removeClass('visible');
        }
    });

    $(window).on('resize', function () {
        if ($(window).width() >= 978) {
            $('.filters__total-back').removeClass('show');
            $('.filters__total-container').removeClass('is-open');
        }
    });

    $(window).on('load', function () {
        let value;
        if (value = getUrlParams('search')) {
            const parent = $('#filter__name-form');
            parent.find('[name=\'search\']').val(value);
            parent.find('.form-group--addon').addClass('show');
        }
        if (value = getUrlParams('title')) {
            const radio = $('.filter__single-cb [value=\'' + value + '\']');
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


    $('[data-ripple]').on('click', function (e) {

        let ripple = $('<span></span>');
        ripple.addClass("ripple");
        $(this).append(ripple);

        let x = e.clientX - e.target.offsetLeft;
        let y = e.clientY - e.target.offsetTop;
        ripple.css({
            left: `${x}px`,
            top: `${y}px`
        });
        setTimeout(() => {
            ripple.remove();
        }, 500);
    });

    // $('.owl-carousel').slick();
    const owl = $('.owl-carousel').owlCarousel({
        mouseDrag: true,
        touchDrag: true,
        items: 3,
        dots: false,
        nav: false,
        margin: 10,
        responsive: {
            0: {
                items: 1
            },
            567: {
                items: 2
            },
            992: {
                items: 3
            }
        }
    });

    $('.main__nav--prev').on('click', function () {
        // var carouselId = $(this).attr('data-nav');
        owl.trigger('prev.owl.carousel');
        watchArrows();
    });

    $('.main__nav--next').on('click', function () {
        // var carouselId = $(this).attr('data-nav');
        owl.trigger('next.owl.carousel');
        watchArrows()
    });

    $('.aux-goto-top-btn').on('click', function () {
        $('body,html').animate({
            scrollTop: 0
        }, 600, $.bez([0.215, 0.610, 0.355, 1.000]));
    })


    watchArrows();

    function watchArrows() {
        if (owl.find('.owl-item:first-child').hasClass('active')) {
            $('.main__nav--prev').addClass('deactive');
        } else {
            $('.main__nav--prev').removeClass('deactive');
        }
        if (owl.find('.owl-item:last-child').hasClass('active')) {
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

            appendUrlParam('page=1&'+(api_url==='package' ? 'p_' : '')+'min_max=' + min + '_' + max);
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

        deleteUrlParams((api_url==='package' ? 'p_' : '')+'min_max');
        updateDataList();
    });

    /* Cities Range Filter */
    $('.main__select2[name=\'cities\']').on('change', function () {
        let cities = $(this).val(), _cities = "";
        if (cities.length > 0) {
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

    $('#lists__main-list').on('click', '.studio__location-badge', function (e) {
        e.preventDefault();
        const currentUrl = $(location).attr('href');
        const cityId = $(this).data('id');
        if (currentUrl.indexOf($(this).attr('href')) >= 0) {
            $('.main__select2[name=\'cities\']').val([cityId]);
            $('.main__select2[name=\'cities\']').trigger('change');
            appendUrlParam("page=1&cityIds=" + cityId);
            updateDataList();
        } else {
            $(location).attr('href',$(this).attr('href')+"?cityIds="+cityId);
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
        $('.css-select__dropdown').focusout();
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
        $('.filters__total-container').addClass('is-open');
        $('html').addClass('overflow-hidden');
        $('.filters__total-back').addClass('show');
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
        $('.filters__total-container').removeClass('is-open');
        $('html').removeClass('overflow-hidden');
        $('.filters__total-back').removeClass('show');
    });

    function updateDataList(_params = getUrlParams()) {
        blockUI();
        const parent = $('#lists__main-list');
        // console.log("s" + _params);
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
                console.log("e: " + error);
            }
        });
    }

    function blockUI() {
        $.blockUI({
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
        });
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

});