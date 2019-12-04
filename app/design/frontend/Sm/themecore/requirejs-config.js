var config = {
    map: {
        '*': {
            'fancybox': 'js/jquery.fancybox/jquery.fancybox.pack',
            'owlcarousel': 'js/owl.carousel',
            'unveil': 'js/jquery.unveil'
        }
    },
    deps: [
        "js/jquery.fancybox/jquery.fancybox.pack",
        "js/jquery.fancybox/jquery.fancybox-media",
        "js/owl.carousel",
        "js/main"
    ],
    config: {
        mixins: {
            'Magento_Swatches/js/swatch-renderer': {
                'js/swatch-renderer-mixin': true
            }
        }
    }
};