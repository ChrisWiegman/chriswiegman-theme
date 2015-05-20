!function(a, b, c, d, e, f, g) {
    a.GoogleAnalyticsObject = e, a[e] = a[e] || function() {
        (a[e].q = a[e].q || []).push(arguments);
    }, a[e].l = 1 * new Date(), f = b.createElement(c), g = b.getElementsByTagName(c)[0], 
    f.async = 1, f.src = d, g.parentNode.insertBefore(f, g);
}(window, document, "script", "//www.google-analytics.com/analytics.js", "ga"), 
ga("create", "UA-59917617-1", "auto"), ga("send", "pageview"), jQuery(document).ready(function(a) {
    function b() {
        var b = a("article");
        e = h.height(), f = b.height() + b.position().top, g = f - e;
    }
    function c() {
        var a = Math.max(0, Math.min(1, h.scrollTop() / g));
        i.css({
            width: 100 * a + "%"
        });
    }
    var d = a("body");
    if (d.hasClass("single") || d.hasClass("page")) {
        var e, f, g, h = a(window), i = a(".progress-indicator");
        b(), c(), h.on("scroll", function() {
            c();
        }).on("resize", function() {
            b(), c();
        });
    }
}), function() {
    var a = navigator.userAgent.toLowerCase().indexOf("webkit") > -1, b = navigator.userAgent.toLowerCase().indexOf("opera") > -1, c = navigator.userAgent.toLowerCase().indexOf("msie") > -1;
    (a || b || c) && document.getElementById && window.addEventListener && window.addEventListener("hashchange", function() {
        var a = document.getElementById(location.hash.substring(1));
        a && (/^(?:a|select|input|button|textarea)$/i.test(a.tagName) || (a.tabIndex = -1), 
        a.focus());
    }, !1);
}(), //Load Google Fonts
WebFontConfig = {
    google: {
        families: [ "Roboto:400,400italic,700,700italic:latin", "Roboto+Slab:700:latin" ]
    }
}, function() {
    var a = document.createElement("script");
    a.src = ("https:" == document.location.protocol ? "https" : "http") + "://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js", 
    a.type = "text/javascript", a.async = "true";
    var b = document.getElementsByTagName("script")[0];
    b.parentNode.insertBefore(a, b);
}(), jQuery(document).ready(function(a) {
    //welcome message
    console.log("Thanks for visiting! Please don't forget to subscribe at http://feeds.chriswiegman.com"), 
    //toggle nav
    a(".menu-toggle").on("click", function() {
        a("#menu-primary").slideToggle("slow"), a(this).toggleClass("active");
    }), //hide the menu button when we resize the menu
    a(window).resize(function() {
        a(window).width() >= 820 && a("#menu-primary").removeAttr("style");
    });
    var b = a(".site-header, .progress-indicator");
    a(".progress-indicator");
    //Add correct class to header on load
    a(this).scrollTop() > 10 ? b.hasClass("scrolled") || b.addClass("scrolled") : b.hasClass("scrolled") && b.removeClass("scrolled"), 
    //Add or removed header class on scroll
    a(window).scroll(function() {
        a(this).scrollTop() > 55 ? b.hasClass("scrolled") || b.addClass("scrolled") : b.hasClass("scrolled") && b.removeClass("scrolled");
    });
    var c = 0, d = a(".software-short");
    d.each(function() {
        a(this).height() > c && (c = a(this).height());
    }), d.height(c);
}), /**
 * Removes inline styles from element
 *
 * @param            style    Name of style to remove
 * @return string    Inline styles without removed element
 */
jQuery.fn.removeStyle = function(a) {
    var b = new RegExp(a + "[^;]+;?", "g");
    return this.each(function() {
        $(this).attr("style", function(a, c) {
            try {
                return c.replace(b, "");
            } catch (d) {
                return "";
            }
        });
    });
};