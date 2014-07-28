//Load Google Fonts
WebFontConfig = {
	google: { families: [ 'Open+Sans:300,300italic,700,700italic:latin', 'Roboto+Slab:700:latin' ] }
};

(function () {

	var wf = document.createElement( 'script' );
	wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
	         '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
	wf.type = 'text/javascript';
	wf.async = 'true';
	var s = document.getElementsByTagName( 'script' )[0];
	s.parentNode.insertBefore( wf, s );

})();

jQuery( document ).ready( function ( $ ) {

	$( '.cw_email_signup input' ).attr( 'placeholder', 'Enter your email address' ); //add a placeholder to signup widget

	//toggle nav
	$( '.menu-toggle' ).on( 'click', function () {

		$( "#menu-primary" ).slideToggle( 'slow' );
		$( this ).toggleClass( 'active' );

	} );

	//hide the menu button when we resize the menu
	$( window ).resize( function () {

		if ( $( window ).width() >= 700 ) {
			$( '#menu-primary' ).removeAttr( 'style' );
		}

	} );

	//Add correct class to header on load
	if ( $( this ).scrollTop() > 10 ) {

		if ( !$( '.site-header' ).hasClass( 'scrolled' ) ) {
			$( '.site-header' ).addClass( 'scrolled' );
		}

	} else {

		if ( $( '.site-header' ).hasClass( 'scrolled' ) ) {
			$( '.site-header' ).removeClass( 'scrolled' );
		}

	}

	//Add or removed header class on scroll
	$( window ).scroll( function () {

		if ( $( this ).scrollTop() > 55 ) {

			if ( !$( '.site-header' ).hasClass( 'scrolled' ) ) {
				$( '.site-header' ).addClass( 'scrolled' );
			}

		} else {

			if ( $( '.site-header' ).hasClass( 'scrolled' ) ) {
				$( '.site-header' ).removeClass( 'scrolled' );
			}

		}

	} );

} );

/**
 * Removes inline styles from element
 *
 * @param  string    style    Name of style to remove
 * @return string    Inline styles without removed element
 */
( function ( $ ) {

	$.fn.removeStyle = function ( style ) {

		var search = new RegExp( style + '[^;]+;?', 'g' );

		return this.each( function () {

			$( this ).attr( 'style', function ( i, style ) {

				try {
					return style.replace( search, '' );
				} catch ( e ) {
					return '';
				}

			} );

		} );
	};

}( $ ) );

