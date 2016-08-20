/**
 * Show latest tweets in the Latest Tweets widget.
 *
 * @since 4.1.0
 */

jQuery( document ).ready( function ( $ ) {

	var showLatestTweets = function () {

		var data = {
			'action'   : 'get_latest_tweets',
			'nonce'    : cwLatestTweets.nonce,
			'userName' : cwLatestTweets.userName,
			'count'    : cwLatestTweets.count
		};

		$.post( cwLatestTweets.ajaxurl, data, function ( response ) {

			var tweetDiv = $( '#cw-latest-tweets' );

			tweetDiv.html( '<ul class="tweet_list"></ul>' );

			response.data.forEach( function ( tweet ) {

				tweetDiv.find( '.tweet_list' ).append( '<li>' + tweet + '</li>' );

			} );

		} );

	};

	showLatestTweets();

} );
