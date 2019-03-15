( function ( $) {
	$.fn.wptdIsInViewport = function() {
		var elementTop = $(this).offset().top;
		var elementBottom = elementTop + $(this).outerHeight();
		var viewportTop = $(window).scrollTop();
		var viewportBottom = viewportTop + $(window).height();
		return elementBottom > viewportTop && elementTop < viewportBottom;
	};

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

	$( window ).scroll( function() {
		if ( $( '.wptd-header-image' ).wptdIsInViewport() ) {
			$( '.site-header .menu-scroll-down .icon' ).css( 'transform', 'rotate(90deg)' );
		} else {
			$( '.site-header .menu-scroll-down .icon' ).css( 'transform', 'rotate(-90deg)' );
		}
	} );
} ( jQuery ) );