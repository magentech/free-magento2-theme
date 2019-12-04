define([
        "jquery",
        "owlcarousel",
        "slick",
        "domReady!"
    ],
    function ($) {
        /**
         * Theme custom javascript
         */

        // Fix hover on IOS
        $('body').bind('touchstart', function () {
        });

        /**
         * Add parent class to megamenu item
         */

        $('.sm_megamenu_menu > li > div').parent().addClass('parent-item');

        /**
         * Menu ontop
         */

        if ($('.enable-stickymenu').length) {
            var wd = $(window);
            if ($('.ontop-element').length) {
                var menu_offset_top = $('.ontop-element').offset().top;

                function processScroll() {
                    var scrollTop = wd.scrollTop();
                    if (scrollTop >= menu_offset_top) {
                        $('.ontop-element').addClass('menu-on-top');
                        $('body').addClass('body-on-top');
                    } else if (scrollTop <= menu_offset_top) {
                        $('.ontop-element').removeClass('menu-on-top');
                        $('body').removeClass('body-on-top');
                    }
                }

                processScroll();
                wd.scroll(function () {
                    processScroll();
                });
            }
        }

        /**
         * Menu sidebar mobile
         */

        $('.mobile-menu #btn-nav-mobile, .nav-overlay').click(function () {
            $('body').toggleClass('show-sidebar-nav');
        });

        $('div[data-move="customer-mobile"] > .header.links').clone().appendTo('#customer-mobile');

        var menuType = $('#sm-header-mobile').data('menutype');

        if (menuType == 'megamenu') {
            $('.btn-submobile').click(function () {
                $(this).prev().slideToggle(200);
                $(this).toggleClass('btnsub-active');
                $(this).parent().toggleClass('parent-active');
            });

            function cloneMegaMenu() {
                var breakpoints = $('#sm-header-mobile').data('breakpoint');
                var doc_width = $(window).width();
                if (doc_width <= breakpoints) {
                    var horizontalMegamenu = $('.sm_megamenu_wrapper_horizontal_menu .horizontal-type');
                    var verticalMegamenu = $('.sm_megamenu_wrapper_vertical_menu .vertical-type');
                    $('#navigation-mobile').append(horizontalMegamenu);
                    $('#navigation-mobile').append(verticalMegamenu);
                } else {
                    var horizontalMegamenu = $('#navigation-mobile .horizontal-type');
                    var verticalMegamenu = $('#navigation-mobile .vertical-type');
                    $('.sm_megamenu_wrapper_horizontal_menu .sambar-inner .mega-content').append(horizontalMegamenu);
                    $('.sm_megamenu_wrapper_vertical_menu .sambar-inner .mega-content').append(verticalMegamenu);
                }
            }

            cloneMegaMenu();

            $(window).resize(function () {
                cloneMegaMenu();
            });
        } else {
            $('.navigation-mobile > ul li').has('ul').append('<span class="touch-button"><span>open</span></span>');

            $('.touch-button').click(function () {
                $(this).prev().slideToggle(200);
                $(this).toggleClass('active');
                $(this).parent().toggleClass('parent-active');
            });
        }

        /**
         * Clone minicart mobile
         */

        function cloneCart() {
            var breakpoints = $('#sm-header-mobile').data('breakpoint');
            var doc_width = $(window).width();
            if (doc_width <= breakpoints) {
                var cartDesktop = $('div[data-move="minicart-mobile"] > .minicart-wrapper');
                $('#minicart-mobile').append(cartDesktop);
            } else {
                var cartMobile = $('#minicart-mobile > .minicart-wrapper');
                $('div[data-move="minicart-mobile"]').append(cartMobile);
            }
        }

        cloneCart();

        $(window).resize(function () {
            cloneCart();
        });

        /**
         * Show vertical menu by class in cms page: enable-vertical-menu
         */

        if ($('.enable-vertical-menu').length) {
            $('body').addClass('show-vertical-menu');
        }

        /**
         * Focus input search
         */

        $('.header-container .block-search .input-text,.header-container .block-search .searchbox-cat').focus(function () {
            $('body').addClass('search-active');
        });

        $('.header-container .block-search .input-text,.header-container .block-search .searchbox-cat').blur(function () {
            $('body').removeClass('search-active');
        });


        /**
         * Client Slider Slick
         */

        $('.client-main').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            prevArrow: '<div class="slick-prev" aria-label="Previous"><span>Previous</span></div>',
            nextArrow: '<div class="slick-next" aria-label="Next"><span>Next</span></div>',
            asNavFor: '.client-image-slick'
        });

        $('.client-image-slick').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            asNavFor: '.client-main',
            dots: false,
            arrows: false,
            centerMode: true,
            centerPadding: 0,
            focusOnSelect: true,

            responsive: [
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 4,
                    }
                },
                {
                    breakpoint: 560,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                    }
                }
            ]
        });

    });