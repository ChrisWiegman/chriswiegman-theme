/*! Backstretch - v2.0.4 - 2013-06-19
 * http://srobbin.com/jquery-plugins/backstretch/
 * Copyright (c) 2013 Scott Robbin; Licensed MIT */
!function(a, b, c) {
    a.fn.backstretch = function(d, e) {
        return (d === c || 0 === d.length) && a.error("No images were supplied for Backstretch"), 
        0 === a(b).scrollTop() && b.scrollTo(0, 0), this.each(function() {
            var b = a(this), c = b.data("backstretch");
            if (c) {
                if ("string" == typeof d && "function" == typeof c[d]) return void c[d](e);
                e = a.extend(c.options, e), c.destroy(!0);
            }
            c = new f(this, d, e), b.data("backstretch", c);
        });
    }, a.backstretch = function(b, c) {
        return a("body").backstretch(b, c).data("backstretch");
    }, a.expr[":"].backstretch = function(b) {
        return a(b).data("backstretch") !== c;
    }, a.fn.backstretch.defaults = {
        centeredX: !0,
        centeredY: !0,
        duration: 5e3,
        fade: 0
    };
    var d = {
        left: 0,
        top: 0,
        overflow: "hidden",
        margin: 0,
        padding: 0,
        height: "100%",
        width: "100%",
        zIndex: -999999
    }, e = {
        position: "absolute",
        display: "none",
        margin: 0,
        padding: 0,
        border: "none",
        width: "auto",
        height: "auto",
        maxHeight: "none",
        maxWidth: "none",
        zIndex: -999999
    }, f = function(c, e, f) {
        this.options = a.extend({}, a.fn.backstretch.defaults, f || {}), this.images = a.isArray(e) ? e : [ e ], 
        a.each(this.images, function() {
            a("<img />")[0].src = this;
        }), this.isBody = c === document.body, this.$container = a(c), this.$root = this.isBody ? a(g ? b : document) : this.$container, 
        c = this.$container.children(".backstretch").first(), this.$wrap = c.length ? c : a('<div class="backstretch"></div>').css(d).appendTo(this.$container), 
        this.isBody || (c = this.$container.css("position"), e = this.$container.css("zIndex"), 
        this.$container.css({
            position: "static" === c ? "relative" : c,
            zIndex: "auto" === e ? 0 : e,
            background: "none"
        }), this.$wrap.css({
            zIndex: -999998
        })), this.$wrap.css({
            position: this.isBody && g ? "fixed" : "absolute"
        }), this.index = 0, this.show(this.index), a(b).on("resize.backstretch", a.proxy(this.resize, this)).on("orientationchange.backstretch", a.proxy(function() {
            this.isBody && 0 === b.pageYOffset && (b.scrollTo(0, 1), this.resize());
        }, this));
    };
    f.prototype = {
        resize: function() {
            try {
                var a, c = {
                    left: 0,
                    top: 0
                }, d = this.isBody ? this.$root.width() : this.$root.innerWidth(), e = d, f = this.isBody ? b.innerHeight ? b.innerHeight : this.$root.height() : this.$root.innerHeight(), g = e / this.$img.data("ratio");
                g >= f ? (a = (g - f) / 2, this.options.centeredY && (c.top = "-" + a + "px")) : (g = f, 
                e = g * this.$img.data("ratio"), a = (e - d) / 2, this.options.centeredX && (c.left = "-" + a + "px")), 
                this.$wrap.css({
                    width: d,
                    height: f
                }).find("img:not(.deleteable)").css({
                    width: e,
                    height: g
                }).css(c);
            } catch (h) {}
            return this;
        },
        show: function(b) {
            if (!(Math.abs(b) > this.images.length - 1)) {
                var c = this, d = c.$wrap.find("img").addClass("deleteable"), f = {
                    relatedTarget: c.$container[0]
                };
                return c.$container.trigger(a.Event("backstretch.before", f), [ c, b ]), this.index = b, 
                clearInterval(c.interval), c.$img = a("<img />").css(e).bind("load", function(e) {
                    var g = this.width || a(e.target).width();
                    e = this.height || a(e.target).height(), a(this).data("ratio", g / e), a(this).fadeIn(c.options.speed || c.options.fade, function() {
                        d.remove(), c.paused || c.cycle(), a([ "after", "show" ]).each(function() {
                            c.$container.trigger(a.Event("backstretch." + this, f), [ c, b ]);
                        });
                    }), c.resize();
                }).appendTo(c.$wrap), c.$img.attr("src", c.images[b]), c;
            }
        },
        next: function() {
            return this.show(this.index < this.images.length - 1 ? this.index + 1 : 0);
        },
        prev: function() {
            return this.show(0 === this.index ? this.images.length - 1 : this.index - 1);
        },
        pause: function() {
            return this.paused = !0, this;
        },
        resume: function() {
            return this.paused = !1, this.next(), this;
        },
        cycle: function() {
            return 1 < this.images.length && (clearInterval(this.interval), this.interval = setInterval(a.proxy(function() {
                this.paused || this.next();
            }, this), this.options.duration)), this;
        },
        destroy: function(c) {
            a(b).off("resize.backstretch orientationchange.backstretch"), clearInterval(this.interval), 
            c || this.$wrap.remove(), this.$container.removeData("backstretch");
        }
    };
    var g, h = navigator.userAgent, i = navigator.platform, j = h.match(/AppleWebKit\/([0-9]+)/), j = !!j && j[1], k = h.match(/Fennec\/([0-9]+)/), k = !!k && k[1], l = h.match(/Opera Mobi\/([0-9]+)/), m = !!l && l[1], n = h.match(/MSIE ([0-9]+)/), n = !!n && n[1];
    g = !((-1 < i.indexOf("iPhone") || -1 < i.indexOf("iPad") || -1 < i.indexOf("iPod")) && j && 534 > j || b.operamini && "[object OperaMini]" === {}.toString.call(b.operamini) || l && 7458 > m || -1 < h.indexOf("Android") && j && 533 > j || k && 6 > k || "palmGetResource" in b && j && 534 > j || -1 < h.indexOf("MeeGo") && -1 < h.indexOf("NokiaBrowser/8.5.0") || n && 6 >= n);
}(jQuery, window), jQuery(document).ready(function(a) {
    var b = a("body"), c = function() {
        var b = a("article");
        e = h.height(), f = b.height() + b.position().top, g = f - e;
    }, d = function() {
        var a = Math.max(0, Math.min(1, h.scrollTop() / g));
        i.css({
            width: 100 * a + "%"
        });
    };
    if (b.hasClass("single") || b.hasClass("page")) {
        var e, f, g, h = a(window), i = a(".progress-indicator");
        c(), d(), h.on("scroll", function() {
            d();
        }).on("resize", function() {
            c(), d();
        });
    }
}), function() {
    var a = navigator.userAgent.toLowerCase().indexOf("webkit") > -1, b = navigator.userAgent.toLowerCase().indexOf("opera") > -1, c = navigator.userAgent.toLowerCase().indexOf("msie") > -1;
    (a || b || c) && document.getElementById && window.addEventListener && window.addEventListener("hashchange", function() {
        var a = document.getElementById(location.hash.substring(1));
        a && (/^(?:a|select|input|button|textarea)$/i.test(a.tagName) || (a.tabIndex = -1), 
        a.focus());
    }, !1);
}(), jQuery(document).ready(function(a) {
    //welcome message
    console.log("Thanks for visiting! Please do not forget to subscribe at http://feeds.chriswiegman.com/"), 
    //toggle nav
    a(".menu-toggle").on("click", function() {
        a("#menu-primary").slideToggle("slow"), a(this).toggleClass("active");
    }), //hide the menu button when we resize the menu
    a(window).resize(function() {
        a(window).width() >= 900 && a("#menu-primary").removeAttr("style");
    });
    var b = 0, c = a(".software-short");
    c.each(function() {
        a(this).height() > b && (b = a(this).height());
    }), c.height(b);
});
//# sourceMappingURL=footer.js.map