( function ( $) {
	$( window ).resize( function() {
		if ( $( window ).width() < 767 ) {
			if ( $( '.navigation-top' ).hasClass( 'site-navigation-fixed' ) ) {
				$( '.navigation-top' ).removeClass( 'site-navigation-fixed' );
			}
		} else if ( $( window ).width() > 767 ) {
			if ( ! $( '.navigation-top' ).hasClass( 'site-navigation-fixed' ) ) {
				$( '.navigation-top' ).addClass( 'site-navigation-fixed' );
			}
		}
	} );
} ( jQuery ) );