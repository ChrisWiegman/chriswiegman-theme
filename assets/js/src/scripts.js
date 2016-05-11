jQuery( document ).ready( function ( $ ) {

	//welcome message
	console.log( 'Thanks for visiting! Please do not forget to subscribe at http://feeds.chriswiegman.com/' );

	//toggle nav
	$( '.menu-toggle' ).on( 'click', function () {

		$( '#menu-primary' ).slideToggle( 'slow' );
		$( this ).toggleClass( 'active' );

	} );

	//hide the menu button when we resize the menu
	$( window ).resize( function () {

		if ( $( window ).width() >= 900 ) {
			$( '#menu-primary' ).removeAttr( 'style' );
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
