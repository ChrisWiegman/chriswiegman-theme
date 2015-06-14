jQuery ( document ).ready ( function ( $ ) {

	//welcome message
	console.log ( "Thanks for visiting! Please don't forget to subscribe at http://feeds.chriswiegman.com" );

	//toggle nav
	$ ( '.menu-toggle' ).on ( 'click', function () {

		$ ( '#menu-primary' ).slideToggle ( 'slow' );
		$ ( this ).toggleClass ( 'active' );

	} );

	//hide the menu button when we resize the menu
	$ ( window ).resize ( function () {

		if ( $ ( window ).width () >= 820 ) {
			$ ( '#menu-primary' ).removeAttr ( 'style' );
		}

	} );

	var header = $ ( '.site-header, .progress-indicator' );
	var progress = $ ( '.progress-indicator' );

	//Add correct class to header on load
	if ( $ ( this ).scrollTop () > 10 ) {

		if ( ! header.hasClass ( 'scrolled' ) ) {
			header.addClass ( 'scrolled' );
		}

	} else {

		if ( header.hasClass ( 'scrolled' ) ) {
			header.removeClass ( 'scrolled' );
		}

	}

	//Add or removed header class on scroll
	$ ( window ).scroll ( function () {

		if ( $ ( this ).scrollTop () > 55 ) {

			if ( ! header.hasClass ( 'scrolled' ) ) {
				header.addClass ( 'scrolled' );
			}

		} else {

			if ( header.hasClass ( 'scrolled' ) ) {
				header.removeClass ( 'scrolled' );
			}

		}

	} );

	var maxHeight = 0;
	var softwareShort = $ ( '.software-short' );

	softwareShort.each ( function () {

		if ( $ ( this ).height () > maxHeight ) {
			maxHeight = $ ( this ).height ();
		}

	} );

	softwareShort.height ( maxHeight );

} );

/**
 * Removes inline styles from element
 *
 * @param            style    Name of style to remove
 * @return string    Inline styles without removed element
 */
jQuery.fn.removeStyle = function ( style ) {

	var search = new RegExp ( style + '[^;]+;?', 'g' );

	return this.each ( function () {

		$ ( this ).attr ( 'style', function ( i, style ) {

			try {
				return style.replace ( search, '' );
			} catch ( e ) {
				return '';
			}

		} );

	} );
};

