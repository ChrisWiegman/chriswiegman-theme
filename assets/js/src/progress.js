jQuery( document ).ready( function ( $ ) {

	var body = $( 'body' );

	var setSizes = function () {

		var $article = $( 'article' );

		windowHeight  = $window.height();
		contentHeight = $article.height() + $article.position().top;
		sHeight       = contentHeight - windowHeight;

	};

	var updateProgress = function () {

		var completePercentage = Math.max( 0, Math.min( 1, $window.scrollTop() / sHeight ) );

		$progressIndicator.css( {width : completePercentage * 100 + '%'} );

	};

	if ( body.hasClass( 'single' ) || body.hasClass( 'page' ) ) {

		var $window            = $( window );
		var $progressIndicator = $( '.progress-indicator' );

		var windowHeight, contentHeight, sHeight;

		setSizes();
		updateProgress();

		$window.on( 'scroll', function () {

			updateProgress();

		} ).on( 'resize', function () {

			setSizes();
			updateProgress();

		} );

	}

} );