const $ = require('jquery');

function checkScroll()
{
    if ($(this).scrollTop() >= 50) {
        $('#return-to-top').fadeIn(200);
    } else {
        $('#return-to-top').fadeOut(200);
    }
}

$(window).scroll(checkScroll);

$('#return-to-top').click(() => {
    $('body,html').animate({
        scrollTop: 0,
    }, 500);
});
