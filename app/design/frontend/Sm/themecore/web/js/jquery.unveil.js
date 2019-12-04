/**
 * jQuery Unveil
 * A very lightweight jQuery plugin to lazy load images
 * http://luis-almeida.github.com/unveil
 *
 * Licensed under the MIT license.
 * Copyright 2013 Luís Almeida
 * https://github.com/luis-almeida
 */
define(["jquery"], function ($) {
    ;
    (function ($) {
        $.fn.unveil = function (threshold, callback) {
            var $w = $(window),
                th = threshold || 0,
                retina = window.devicePixelRatio > 1,
                attrib = retina ? "data-src-retina" : "data-src",
                images = this,
                loaded;
            this.one("unveil", function () {
                var source = this.getAttribute(attrib);
                source = source || this.getAttribute("data-src");
                if (source) {
                    if (this.getAttribute("srcset")) this.setAttribute("srcset", source);
                    this.setAttribute("src", source);
                    if (this.getAttribute("data-alt")) this.setAttribute("alt", this.getAttribute("data-alt"));
                    if (typeof callback === "function") callback.call(this);
                }
            });

            function unveil() {
                setInterval(function () {
                    var inview = images.filter(function () {
                        var $e = $(this);
                        if ($e.is(":hidden")) return;
                        var wt = $w.scrollTop(),
                            wb = wt + $w.height(),
                            et = $e.offset().top,
                            eb = et + $e.height();
                        return eb >= wt - th && et <= wb + th;
                    });
                    loaded = inview.trigger("unveil");
                    images = images.not(loaded);
                }, 2000);
            }

            $w.on("scroll.unveil resize.unveil lookup.unveil", unveil);
            $w.scroll();
            unveil();
            return this;
        };
    })(window.jQuery || window.Zepto);
});