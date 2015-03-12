!function() {
    var a = navigator.userAgent.toLowerCase().indexOf("webkit") > -1, b = navigator.userAgent.toLowerCase().indexOf("opera") > -1, c = navigator.userAgent.toLowerCase().indexOf("msie") > -1;
    (a || b || c) && document.getElementById && window.addEventListener && window.addEventListener("hashchange", function() {
        var a = document.getElementById(location.hash.substring(1));
        a && (/^(?:a|select|input|button|textarea)$/i.test(a.tagName) || (a.tabIndex = -1), 
        a.focus());
    }, !1);
}(), /**
 * jQuery Progress bar from http://www.webdesigncrowd.com/scrolling-progress-bar/
 */
function(a) {
    a(function() {
        var b = a(".progress .wrapper").offset().top;
        a(window).scroll(function() {
            var c = a(".progress .wrapper").height(), d = a(this).scrollTop();
            d > b - 10 ? a(".progress .wrapper").addClass("affix") : a(".progress .wrapper").removeClass("affix"), 
            // Calculate each progress section
            a(".content div").each(function(b) {
                var e = a(this).offset().top, f = a(this).height(), g = e + f, h = 0;
                // Scrolled within current section
                d >= e && g >= d ? (h = (d - e) / (f - c) * 100, h >= 100 ? (h = 100, a(".progress .wrapper .bar:eq(" + b + ") i").css("color", "#fff")) : a(".progress .wrapper .bar:eq(" + b + ") i").css("color", "#36a7f3")) : d > g && (h = 100, 
                a(".progress .wrapper .bar:eq(" + b + ") i").css("color", "#fff")), console.log(b), 
                a(".progress .wrapper .bar:eq(" + b + ") span").css("width", h + "%");
            });
        }), // Smooth Scroll Links
        a(".wrapper .bar a").click(function(b) {
            b.preventDefault();
            var c = this.hash.substr(1);
            console.log(c), a("html, body").animate({
                scrollTop: a("#" + c).offset().top - 10
            }, 500);
        });
    });
}(jQuery), //Load Google Fonts
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
    var b = a(".site-header");
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