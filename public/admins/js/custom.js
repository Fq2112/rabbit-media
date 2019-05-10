/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */

"use strict";

window.mobilecheck() ? $("body").removeClass('use-nicescroll') : '';

$(".use-nicescroll").niceScroll({
    cursorcolor: "#312855",
    cursorwidth: "8px",
    cursorborder: "1px solid #312855",
    zindex: 1
});

function progress() {

    var windowScrollTop = $(window).scrollTop();
    var docHeight = $(document).height();
    var windowHeight = $(window).height();
    var progress = (windowScrollTop / (docHeight - windowHeight)) * 100;
    var $bgColor = progress > 99 ? '#312855' : '#592f83';
    var $textColor = progress > 99 ? '#fff' : '#333';

    $('.progress .bar').width(progress + '%').css({backgroundColor: $bgColor});
    // $('h1').text(Math.round(progress) + '%').css({color: $textColor});
    $('.fill').height(progress + '%').css({backgroundColor: $bgColor});
}

progress();

$(document).on('scroll', progress);