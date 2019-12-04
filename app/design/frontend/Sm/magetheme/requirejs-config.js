var config = {
    map: {
        '*': {
            'bootstrap': 'js/bootstrap/bootstrap.min',
            'popper': 'js/bootstrap/popper',
            'slick': 'js/slick',
        }
    },
    shim: {
        'popper': {
            'deps': ['jquery'],
            'exports': 'Popper'
        },
        'bootstrap': {
            'deps': ['jquery', 'popper']
        }
    },
    deps: [
        "js/bootstrap/bootstrap.min",
        "js/theme-js"
    ]
};