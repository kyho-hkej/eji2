$(window).scroll(function() {

    if ($(window).scrollTop() > 90) {
        $('.topnav').addClass('sticky');
    } else {
        $('.topnav').removeClass('sticky');
    }
});


// Mobile Navigation
$('.mobile_toggle').click(function() {
    if ($('.mobile_menu').hasClass('open-nav')) {
        $('.mobile_menu').removeClass('open-nav');
    } else {
        $('.mobile_menu').addClass('open-nav');
    }
});


$('.mobile_menu nav li a').click(function() {
    if ($('.mobile_menu').hasClass('open-nav')) {
        $('.navigation').removeClass('open-nav');
        $('.mobile_menu').removeClass('open-nav');
    }
});


