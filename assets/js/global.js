// const stickyElem = document.getElementsByClassName("fixed-element")[0];

$(window).scroll(function (){
    // const topp = $(this).scrollTop();
    // const stickyElem = $(".fixed-content").eq(0);
    // console.log(stickyElem.length)
    // console.log(`top : ${topp}`);
    // console.log(`stickyElem.offset().top : ${stickyElem.offsetTop}`)
    // if(topp > 100) {
    //     stickyElem.css({
    //         "position" : "fixed",
    //         "top" : "0px"
    //     })
//         stickyElem.style.position = "fixed";
//         stickyElem.style.top = "0px";
//     } else {
//         stickyElem.style.position = "relative";
//         stickyElem.style.top = "initial";
//         stickyElem.css({
//             "position" : "relative",
//             "top" : "initial"
//         })
//     }
});

/* Gets the amount of height
of the element from the
viewport and adds the
pageYOffset to get the height
relative to the page */
// window.onscroll = function() {
//     const currStickyPos = document.documentElement.scrollTop;
//
//     console.log(`currStickyPos : ${currStickyPos}`);
//
//     /* Check if the current Y offset
//     is greater than the position of
//     the element */
//     if(window.scrollY > currStickyPos) {
//         stickyElem.style.position = "fixed";
//         stickyElem.style.top = "0px";
//     } else {
//         stickyElem.style.position = "relative";
//         stickyElem.style.top = "initial";
//     }
// }


function formatPrice(price) {
    let _num = "";
    let reminder = price.length % 3;
    _num = price.substring(0, reminder);
    for (let i = reminder; i < price.length; i += 3) {
        _num = _num + (i === reminder && reminder === 0 ? "" : ",") + price.substring(i, i+3);
    }
    return _num;
}