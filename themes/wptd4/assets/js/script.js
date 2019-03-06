( function( $ ) {
	var wptdTime = moment.tz("2019-05-11 00:00:00", "Etc/UTC");
	$('#countdown')
		.countdown( wptdTime.toDate(), { elapse: true } )
		.on( 'update.countdown', function( e ) {
			if ( e.elapsed ) {
				$(this).html( e.strftime( "<h2>It's time for WPTD4!</h2>" ) );
			} else {
				$(this).html( '<div><span class="count">' + e.strftime('%D') + '</span><span class="time">days</span></div>' +
					'<div><span class="count">' + e.strftime('%H') + '</span><span class="time">hours</span></div>' +
					'<div><span class="count">' + e.strftime('%M') + '</span><span class="time">minutes</span></div>' +
					'<div><span class="count">' + e.strftime('%S') + '</span><span class="time">seconds</span></div>'
				);
			}
		});
} ( jQuery ) );