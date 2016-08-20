/**
 * Get chart data for a given time period.
 *
 * @since 3.2.0
 *
 * @param  startDay The number of days before .
 * @param  numDays The number of days to chart.
 *
 * @return The chart data.
 */
var drawMood = function ( startDay, numDays ) {

	startDay = startDay || 30;
	numDays  = numDays || 0;

	var ctx = document.getElementById( 'mood-chart' ).getContext( '2d' );
	var chart;
	var http; // Setup the HTTP request.

	// Encode form data as appropriate.
	var requestData = 'action=get_mood_data&nonce=' + cwMood.nonce + '&start=' + startDay + '&days=' + numDays;

	if ( window.XMLHttpRequest ) {

		http = new XMLHttpRequest();

	} else {

		http = new ActiveXObject( 'Microsoft.XMLHTTP' );

	}

	http.onreadystatechange = function () {

		if ( http.readyState === XMLHttpRequest.DONE ) {

			if ( 200 === http.status ) {

				if ( ! chart ) {

					var moodTip = function ( tooltip ) {

						var tooltipEl = jQuery( '#chartjs-tooltip' );

						if ( ! tooltip ) {

							tooltipEl.css( {opacity : 0} );
							return;
						}

						var toolText = tooltip.text.split( ':' );

						switch ( toolText[1].trim() ) {

							case '1':
								toolText[1] = 'Horrible';
								break;
							case '2':
								toolText[1] = 'Bad';
								break;
							case '3':
								toolText[1] = 'OK';
								break;
							case '4':
								toolText[1] = 'Good';
								break;
							case '5':
								toolText[1] = 'Excellent';
								break;
							default:
								toolText[1] = 'N/A';
								break;

						}

						tooltipEl.removeClass( 'above below' );
						tooltipEl.addClass( tooltip.yAlign );

						tooltipEl.html( '<span>' + toolText[0] + ': ' + toolText[1] + '</span>' );

						tooltipEl.css(
							{
								opacity    : 1,
								left       : tooltip.chart.canvas.offsetLeft + tooltip.x + 'px',
								top        : tooltip.chart.canvas.offsetTop + tooltip.y + 'px',
								fontFamily : tooltip.fontFamily,
								fontSize   : tooltip.fontSize,
								fontStyle  : tooltip.fontStyle
							}
						);

					};

					Chart.defaults.global.showScale       = false;
					Chart.defaults.global.responsive      = true;
					Chart.defaults.global.scaleOverride   = true;
					Chart.defaults.global.scaleSteps      = 5;
					Chart.defaults.global.scaleStepWidth  = 1;
					Chart.defaults.global.scaleStartValue = 0;
					Chart.defaults.global.customTooltips  = moodTip;

					var options = {
						scaleShowHorizontalLines : false,
						scaleShowVerticalLines   : false,
						scaleShowGridLines       : true,
						barStrokeWidth           : 1,
						barValueSpacing          : 2
					};

					chart = new Chart( ctx ).Bar( JSON.parse( http.responseText ).data, options );

					// Update colors based on mood.
					chart.datasets[0].bars.forEach( function ( bar ) {

						switch ( bar.value ) {

							case 1:
								bar.fillColor = '#c11b17';
								break;
							case 2:
								bar.fillColor = '#f9966b';
								break;
							case 3:
								bar.fillColor = '#ffffcc';
								break;
							case 4:
								bar.fillColor = '#e0ffff';
								break;
							case 5:
								bar.fillColor = '#5efb6e';
								break;

						}

					} );

					chart.update();

				}
			} else {

				alert( 'something else other than 200 was returned' );

			}
		}
	};

	http.open( 'POST', cwMood.ajaxurl, true );
	http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
	http.send( requestData );

};

drawMood();
