/**
 * jQuery Progress bar from http://www.webdesigncrowd.com/scrolling-progress-bar/
 */
(function ( $ ) {
	$ ( function () {

		var wrapper_top = $ ( ".progress .wrapper" ).offset ().top;
		$ ( window ).scroll ( function () {
			var wrapper_height = $ ( ".progress .wrapper" ).height ();

			// Affixes Progress Bars
			var top = $ ( this ).scrollTop ();
			if ( top > wrapper_top - 10 ) {
				$ ( ".progress .wrapper" ).addClass ( "affix" );
			}
			else {
				$ ( ".progress .wrapper" ).removeClass ( "affix" );
			}

			// Calculate each progress section
			$ ( ".content div" ).each ( function ( i ) {
				var this_top = $ ( this ).offset ().top;
				var height = $ ( this ).height ();
				var this_bottom = this_top + height;
				var percent = 0;

				// Scrolled within current section
				if ( top >= this_top && top <= this_bottom ) {
					percent = ((top - this_top) / (height - wrapper_height)) * 100;
					if ( percent >= 100 ) {
						percent = 100;
						$ ( ".progress .wrapper .bar:eq(" + i + ") i" ).css ( "color", "#fff" );
					}
					else {
						$ ( ".progress .wrapper .bar:eq(" + i + ") i" ).css ( "color", "#36a7f3" );
					}
				}
				else if ( top > this_bottom ) {
					percent = 100;
					$ ( ".progress .wrapper .bar:eq(" + i + ") i" ).css ( "color", "#fff" );
				}
				console.log ( i );
				$ ( ".progress .wrapper .bar:eq(" + i + ") span" ).css ( "width", percent + "%" );
			} );
		} );

		// Smooth Scroll Links
		$ ( ".wrapper .bar a" ).click ( function ( e ) {
			e.preventDefault ();

			var hash = this.hash.substr ( 1 );
			console.log ( hash );
			$ ( 'html, body' ).animate ( {
				                             scrollTop : $ ( "#" + hash ).offset ().top - 10
			                             }, 500 );

		} );

	} ); // end of document ready
}) ( jQuery ); // end of jQuery name space