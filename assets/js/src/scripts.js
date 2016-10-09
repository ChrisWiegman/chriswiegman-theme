jQuery( document ).ready( function ( $ ) {

	//welcome message
	console.log( 'Thanks for visiting! Please do not forget to subscribe at http://feeds.chriswiegman.com/' );

	//toggle nav
	$( '.menu-toggle' ).on( 'click', function () {

		$( '#menu-primary' ).slideToggle( 'slow' );
		$( this ).toggleClass( 'active' );

	} );

	// Resize header on scroll.
	var header = $( '.site-header, .progress-indicator' );

	// Add correct class to header on load.
	if ( $( this ).scrollTop() > 10 ) {

		if ( ! header.hasClass( 'scrolled' ) ) {
			header.addClass( 'scrolled' );
		}

	} else {

		if ( header.hasClass( 'scrolled' ) ) {
			header.removeClass( 'scrolled' );
		}

	}

	// Add or removed header class on scroll.
	$( window ).scroll( function () {

		if ( $( this ).scrollTop() > 30 ) {

			if ( ! header.hasClass( 'scrolled' ) ) {
				header.addClass( 'scrolled' );
			}

		} else {

			if ( header.hasClass( 'scrolled' ) ) {
				header.removeClass( 'scrolled' );
			}

		}

	} );

	var maxHeight     = 0;
	var softwareShort = $( '.software-short' );

	softwareShort.each( function () {

		if ( $( this ).height() > maxHeight ) {
			maxHeight = $( this ).height();
		}

	} );

	softwareShort.height( maxHeight );

} );
