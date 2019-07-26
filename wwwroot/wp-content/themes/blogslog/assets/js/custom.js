jQuery(document).ready(function($) {

/*------------------------------------------------
            DECLARATIONS
------------------------------------------------*/

    var scroll                  = $(window).scrollTop();  
    var scrollup                = $('.backtotop');
    var primary_menu_toggle     = $('#masthead .menu-toggle');
    var secondary_menu_toggle   = $('#secondary-navigation .menu-toggle');
    var dropdown_toggle         = $('button.dropdown-toggle');
    var primary_nav_menu        = $('#masthead .main-navigation');
    var secondary_nav_menu      = $('#secondary-navigation .main-navigation');
    var posts_slider            = $('.posts-slider');

/*------------------------------------------------
            BACK TO TOP
------------------------------------------------*/

    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            scrollup.css({bottom:"25px"});
        } 
        else {
            scrollup.css({bottom:"-100px"});
        }
    });

    scrollup.click(function() {
        $('html, body').animate({scrollTop: '0px'}, 800);
        return false;
    });

/*------------------------------------------------
            MAIN NAVIGATION
------------------------------------------------*/

    primary_menu_toggle.click(function(){
        primary_nav_menu.slideToggle();
        $(this).toggleClass('active');
        $('.menu-overlay').toggleClass('active');
        $('#masthead .main-navigation').toggleClass('menu-open');
        $('body').toggleClass('main-navigation-active');
    });

    secondary_menu_toggle.click(function(){
        secondary_nav_menu.slideToggle();
        $(this).toggleClass('active');
        $('#secondary-navigation .main-navigation').toggleClass('menu-open');
        $('body').toggleClass('main-navigation-active');
    });

    dropdown_toggle.click(function() {
        $(this).toggleClass('active');
       $(this).parent().find('.sub-menu').first().slideToggle();
    });

    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            $('#masthead').addClass('nav-shrink');
        } 
        else {
            $('#masthead').removeClass('nav-shrink');
        }
    });

/*------------------------------------------------
            Sliders
------------------------------------------------*/

posts_slider.slick({
    responsive: [
    {
        breakpoint: 1400,
        settings: {
            slidesToShow: 3
        }
    },
    {
        breakpoint: 992,
        settings: {
            slidesToShow: 2,
            centerMode: false
        }
    },
    {
        breakpoint: 767,
        settings: {
            slidesToShow: 2,
            centerMode: false
        }
    },
    {
        breakpoint: 567,
            settings: {
            slidesToShow: 1,
            arrows: false,
            centerMode: false
        }
    }
    ]
});

/*------------------------------------------------
                END JQUERY
------------------------------------------------*/

});