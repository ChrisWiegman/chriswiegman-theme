jQuery(document).ready(function(a) {
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
    console.log("Thanks for visiting! Please do not forget to subscribe at https://www.chriswiegman.com/feed"), 
    //toggle nav
    a(".menu-toggle").on("click", function() {
        a("#menu-primary").slideToggle("slow"), a(this).toggleClass("active");
    });
    // Resize header on scroll.
    var b = a(".site-header, .progress-indicator");
    // Add correct class to header on load.
    a(this).scrollTop() > 10 ? b.hasClass("scrolled") || b.addClass("scrolled") : b.hasClass("scrolled") && b.removeClass("scrolled"), 
    // Add or removed header class on scroll.
    a(window).scroll(function() {
        a(this).scrollTop() > 30 ? b.hasClass("scrolled") || b.addClass("scrolled") : b.hasClass("scrolled") && b.removeClass("scrolled");
    });
    var c = 0, d = a(".software-short");
    d.each(function() {
        a(this).height() > c && (c = a(this).height());
    }), d.height(c);
});
//# sourceMappingURL=footer.js.map