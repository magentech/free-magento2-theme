define([
        "jquery",
        "unveil",
        "mage/cookies",
        "fancybox",
        "owlcarousel",
        "domReady!"
    ],
    function ($) {
        /**
         * Lazy load image
         */

        if ($('.enable-ladyloading').length) {
            function _runLazyLoad() {
                $("img.lazyload").unveil(0, function () {
                    $(this).load(function () {
                        this.classList.remove("lazyload");
                    });
                });
            }

            _runLazyLoad();
            $(document).on("afterAjaxLazyLoad", function (event) {
                _runLazyLoad();
            });
        }

        /**
         * Back to top
         */
        $(function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 500) {
                    $('.back2top').addClass('active');
                } else {
                    $('.back2top').removeClass('active');
                }
            });
            $('.back2top').click(function () {
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });

        });

        /**
         * Newsletter popup
         */
        if ($('.enable-newsletter-popup').length && $('#newsletter-popup').length) {
            var check_cookie = jQuery.cookie('newsletter_popup');
            if (check_cookie == null || check_cookie == 'shown') {
                popupNewsletter();
            }
            jQuery('#newsletter-popup .subscribe-bottom input').on('click', function () {
                if (jQuery(this).parent().find('input:checked').length) {
                    var check_cookie = jQuery.cookie('newsletter_popup');
                    if (check_cookie == null || check_cookie == 'shown') {
                        jQuery.cookie('newsletter_popup', 'dontshowitagain');
                    } else {
                        jQuery.cookie('newsletter_popup', 'shown');
                        popupNewsletter();
                    }
                } else {
                    jQuery.cookie('newsletter_popup', 'shown');
                }
            });

            function popupNewsletter() {
                $.fancybox.open('#newsletter-popup');
            }
        }

        /**
         * Owl slider init
         */

        var owl_data = $('div[data-owl="owl-slider"]');
        owl_data.each(function () {
            var dataOwl = $(this);
            dataOwl.find('.owl-carousel').owlCarousel({
                autoplay: dataOwl.data('autoplay') == undefined ? false : dataOwl.data('autoplay'),
                autoplayHoverPause: dataOwl.data('autoplayhoverpause') == undefined ? false : dataOwl.data('autoplayhoverpause'),
                loop: dataOwl.data('loop') == undefined ? false : dataOwl.data('loop'),
                center: dataOwl.data('center') == undefined ? false : dataOwl.data('center'),
                margin: dataOwl.data('margin') == undefined ? 0 : dataOwl.data('margin'),
                stagePadding: dataOwl.data('stagepadding') == undefined ? 0 : dataOwl.data('stagepadding'),
                nav: dataOwl.data('nav') == undefined ? false : dataOwl.data('nav'),
                dots: dataOwl.data('dots') == undefined ? false : dataOwl.data('dots'),
                mouseDrag: dataOwl.data('mousedrag') == undefined ? false : dataOwl.data('mousedrag'),
                touchDrag: dataOwl.data('touchdrag') == undefined ? false : dataOwl.data('touchdrag'),
                responsive: {
                    0: {
                        items: dataOwl.data('screen0') == undefined ? 1 : dataOwl.data('screen0')
                    },
                    481: {
                        items: dataOwl.data('screen481') == undefined ? 1 : dataOwl.data('screen481')
                    },
                    768: {
                        items: dataOwl.data('screen768') == undefined ? 1 : dataOwl.data('screen768')
                    },
                    992: {
                        items: dataOwl.data('screen992') == undefined ? 1 : dataOwl.data('screen992')
                    },
                    1200: {
                        items: dataOwl.data('screen1200') == undefined ? 1 : dataOwl.data('screen1200')
                    },
                    1441: {
                        items: dataOwl.data('screen1441') == undefined ? 1 : dataOwl.data('screen1441')
                    },
                    1681: {
                        items: dataOwl.data('screen1681') == undefined ? 1 : dataOwl.data('screen1681')
                    },
                    1920: {
                        items: dataOwl.data('screen1920') == undefined ? 1 : dataOwl.data('screen1920')
                    },
                }
            })
        });


    });