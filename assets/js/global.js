const rippleItems = Array.from(document.querySelectorAll('[data-ripple]'));
rippleItems.forEach((item) => {
    let timerId;
    item.addEventListener('mousedown', (e) => {
        clearTimeout(timerId);
        const ripple = document.createElement("DIV");
        ripple.classList.add("ripple");
        e.target.appendChild(ripple);
        const size = item.offsetWidth;
        const pos = item.getBoundingClientRect();
        const x = e.pageX - pos.left - size;
        const y = e.pageY - pos.top - size;
        console.log(`top: ${y}px; left: ${x}px; width: ${size*2}px; height: ${size*2}px`)
        ripple.style.top = `${y}px`;
        ripple.style.left = `${x}px`;
        ripple.style.width = `${size*2}px`;
        ripple.style.height = `${size*2}px`;
        ripple.classList.remove('ripple-active');
        ripple.classList.remove('ripple-start');
        setTimeout(() => {
            ripple.classList.add('ripple-start')
            setTimeout(() => {
                ripple.classList.add('ripple-active');
            });
        });
    })
    item.addEventListener('mouseup', (e) => {
        const ripple = e.target.querySelector('.ripple')
        clearTimeout(timerId);
        timerId = setTimeout(() => {
            ripple.classList.remove('ripple-active');
            ripple.classList.remove('ripple-start');
        }, 500);
    })
})

function formatPrice(price) {
    let _num = "";
    let reminder = price.length % 3;
    _num = price.substring(0, reminder);
    for (let i = reminder; i < price.length; i += 3) {
        _num = _num + (i === reminder && reminder === 0 ? "" : ",") + price.substring(i, i+3);
    }
    return _num;
}

$(window).on('resize', function () {
    if ($(window).width() >= 978) {
        $('.filters__total-back').removeClass('show');
        $('.filters__total-container').removeClass('is-open');
    }
    if ($(window).width() > 768 && $('#mm-menu').hasClass('mm-opened')){
        $('#mm-menu').removeClass('mm-opened is-opening');
        $('#mm-0').removeClass('is-opening');
        $('html').removeClass('overflow-hidden');
        setTimeout(function () {
            $('#mm-blocker').removeClass('dblock is-opening')
        }, 400);
    }
});


/* go to top */
const progressPath = document.querySelector('.progress-wrap .progress-circle path');
if (progressPath) {
    const pathLength = progressPath.getTotalLength();
    progressPath.style.transition = 'none';
    progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
    progressPath.style.strokeDashoffset = pathLength;
    progressPath.getBoundingClientRect();
    progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
    const updateProgress = function () {
        const scroll = $(window).scrollTop();
        const height = $(document).height() - $(window).height();
        progressPath.style.strokeDashoffset = pathLength - (scroll * pathLength / height);
    }
    updateProgress();
    $(window).scroll(updateProgress);
    const offset = 50;
    const duration = 550;
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > offset) {
            $('.progress-wrap').addClass('active-progress');
        } else {
            $('.progress-wrap').removeClass('active-progress');
        }
    });
    $('.progress-wrap').on('click', function (event) {
        event.preventDefault();
        $('html, body').animate({scrollTop: 0}, duration);
        return false;
    });
}