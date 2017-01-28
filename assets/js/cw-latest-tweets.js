/**
 * Show latest tweets in the Latest Tweets widget.
 *
 * @since 4.1.0
 */
jQuery(document).ready(function(a) {
    var b = function() {
        var b = {
            action: "get_latest_tweets",
            nonce: cwLatestTweets.nonce,
            userName: cwLatestTweets.userName,
            count: cwLatestTweets.count
        };
        a.post(cwLatestTweets.ajaxurl, b, function(b) {
            var c = a("#cw-latest-tweets");
            c.html('<ul class="tweet_list"></ul>'), b.data.forEach(function(a) {
                c.find(".tweet_list").append("<li>" + a + "</li>");
            });
        });
    };
    b();
});
//# sourceMappingURL=cw-latest-tweets.js.map