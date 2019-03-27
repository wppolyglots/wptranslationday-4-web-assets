(function( $ ) {
	'use strict';

	var map = AmCharts.makeChart( 'local-events-map', {
		'type': 'map',
		'theme' : 'none',
		'projection': 'miller',
		'addClassNames': true,
  		'dataProvider': {
  			'map': 'continentsHigh',
  			'images': markers,
  			'areas': [ 
  				{ 
	  				'id': 'africa', 
	  				'pattern': {
	  					'url': map_pattern,
	  					'width': 4,
	  					'height': 4,
	  				}
	  			}, {
	  				'id': 'asia',
	  				'pattern': {
	  					'url': map_pattern,
	  					'width': 4,
	  					'height': 4
	  				}
	  			}, {
	  				'id': 'australia',
	  				'pattern': {
	  					'url': map_pattern,
	  					'width': 4,
	  					'height': 4,
	  				}
	  			}, {
	  				'id': 'europe',
	  				'pattern': {
	  					'url': map_pattern,
	  					'width': 4,
	  					'height': 4
	  				}
	  			}, {
	  				'id': 'north_america',
	  				'pattern': {
	  					'url': map_pattern,
	  					'width': 4,
	  					'height': 4
	  				}
	  			}, {
	  				'id': 'south_america',
	  				'pattern': {
	  					'url': map_pattern,
	  					'width': 4,
	  					'height': 4
	  				}
	  			} 
	  		] 
  		},
  		'balloon': {
	  		'color': '#555555',
	  		'fillColor': '#FFFFFF',
	  		'borderAlpha': 0,
	  		'borderColor': '#555555',
	  		'borderThickness': 0,
	  		'fontSize': 10
  		},
		'imagesSettings': {
			'autoZoom': true,
			'rollOverScale': 1.5,
			'selectedScale': 1.5
		},
		'areasSettings': {
			'rollOverOutlineColor': '#FFFFFF',
			'rollOverColor': undefined,
			'balloonText': '',
			'alpha': 1,
//			'mouseEnabled': false,
			'outlineAlpha': 0
		},
  		'zoomControl': {
	  		'zoomControlEnabled': true,
  			'maxZoomLevel': 64,
  			'minZoomLevel': 1,
  			'zoomFactor': 2,
  			'top': 150,
  			'buttonSize': 25,
  			'panControlEnabled': false,
  			'homeButtonEnabled': false,
  		}
	});

map.addListener( 'positionChanged', updateCustomMarkers );

function updateCustomMarkers( event ) {
  // get map object
  var map = event.chart;

  // go through all of the images
  for ( var x in map.dataProvider.images ) {
    // get MapImage object
    var image = map.dataProvider.images[ x ];

    // check if it has corresponding HTML element
    if ( 'undefined' == typeof image.externalElement )
      image.externalElement = createCustomMarker( image );

    // reposition the element accoridng to coordinates
    var xy = map.coordinatesToStageXY( image.longitude, image.latitude );
    image.externalElement.style.top = xy.y + 'px';
    image.externalElement.style.left = xy.x + 'px';
  }
}

// this function creates and returns a new marker element
function createCustomMarker( image ) {
  // create holder
  var holder = document.createElement( 'div' );
  holder.className += ' map-clickable';
  holder.className = 'map-marker';
  holder.title = image.title;
  holder.dataset.country = image.country;
  holder.dataset.city = image.city;
  holder.dataset.locale = image.locale;
  holder.dataset.utc_start_time = image.utc_start_time;
  holder.dataset.utc_end_time = image.utc_end_time;
  holder.dataset.link = image.link;
  holder.dataset.organizer = image.organizer;
  holder.style.position = 'absolute';

  // create dot
  var dot = document.createElement( 'div' );
  dot.className = 'dot';
  holder.appendChild( dot );

  // create pulse
  var pulse = document.createElement( 'div' );
  pulse.className = 'pulse';
  holder.appendChild( pulse );

  // append the marker to the map container
  image.chart.chartDiv.appendChild( holder );

  return holder;
}


$( window ).load(function() {
	$('a[href="http://www.amcharts.com/javascript-maps/"]').css({'opacity': '0.2', 'right': '5px', 'left': 'auto'});
	$('.map-marker').click(function(){
		var current = $(this);
		$( '.map-marker' ).removeClass('current');
		$( current ).addClass('current');
		$( '.local-events-infobox' ).fadeOut( 400, function(){
		$( '.infobox-country' ).html( $(current).data('country') );
		$( '.infobox-city' ).html( $(current).data('city') );
		$( '.infobox-locale' ).html( $(current).data('locale') );
		$( '.infobox-time' ).html( $(current).data('utc_start_time') + ' – ' + $(current).data('utc_end_time') + ' UTC' );
		$( '.infobox-link' ).attr( 'href', $(current).data('link') );
		$( '.infobox-organizer' ).html( $(current).data('organizer') );
		$('.local-events-infobox').fadeIn();
		});
	});
	$('.local-events-infobox-close').click(function(){
		$('.local-events-infobox').fadeOut( 400, function(){
			$( '.infobox-country' ).html( '' );
			$( '.infobox-city' ).html( '' );
			$( '.infobox-locale' ).html( '' );
			$( '.infobox-time' ).html( '' );
			$( '.infobox-link' ).attr( 'href', '' );
			$( '.infobox-organizer' ).html( '' );
		});
	});
});


	
})( jQuery );