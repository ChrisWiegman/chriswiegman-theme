jQuery(document).ready(function(e) {
    var s = e("body"), o = function() {
        var s = e("article");
        a = r.height(), n = s.height() + s.position().top, i = n - a;
    }, t = function() {
        var e = Math.max(0, Math.min(1, r.scrollTop() / i));
        l.css({
            width: 100 * e + "%"
        });
    };
    if (s.hasClass("single") || s.hasClass("page")) {
        var a, n, i, r = e(window), l = e(".progress-indicator");
        o(), t(), r.on("scroll", function() {
            t();
        }).on("resize", function() {
            o(), t();
        });
    }
}), function() {
    var e = navigator.userAgent.toLowerCase().indexOf("webkit") > -1, s = navigator.userAgent.toLowerCase().indexOf("opera") > -1, o = navigator.userAgent.toLowerCase().indexOf("msie") > -1;
    (e || s || o) && document.getElementById && window.addEventListener && window.addEventListener("hashchange", function() {
        var e = document.getElementById(location.hash.substring(1));
        e && (/^(?:a|select|input|button|textarea)$/i.test(e.tagName) || (e.tabIndex = -1), 
        e.focus());
    }, !1);
}(), jQuery(document).ready(function(e) {
    console.log("Thanks for visiting! Please do not forget to subscribe at https://www.chriswiegman.com/feed"), 
    e(".menu-toggle").on("click", function() {
        e("#menu-primary").slideToggle("slow"), e(this).toggleClass("active");
    });
    var s = e(".site-header, .progress-indicator");
    e(this).scrollTop() > 10 ? s.hasClass("scrolled") || s.addClass("scrolled") : s.hasClass("scrolled") && s.removeClass("scrolled"), 
    e(window).scroll(function() {
        e(this).scrollTop() > 30 ? s.hasClass("scrolled") || s.addClass("scrolled") : s.hasClass("scrolled") && s.removeClass("scrolled");
    });
    var o = 0, t = e(".software-short");
    t.each(function() {
        e(this).height() > o && (o = e(this).height());
    }), t.height(o);
});
//# sourceMappingURL=footer.js.map