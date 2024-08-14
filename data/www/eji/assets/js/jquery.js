$(window).scroll(function() {

    if ($(window).scrollTop() > 181) {
        $('.menu2').addClass('sticky');
    } else {
        $('.menu2').removeClass('sticky');
    }
});




$(window).scroll(function() {

    if ($(window).scrollTop() > 600) {
        $('#go-top').addClass('sticky');
    } else {
        $('#go-top').removeClass('sticky');
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


// Mobile Navigation
$('.mobile_menu h4').click(function() {
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






$(document).ready(function(){
    $(window).resize(function(){
		
        $(".drawer-dropdown").removeClass('open');
    });
});



