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
	  				'url': 'https://www.amcharts.com/lib/3/patterns/black/pattern2.png',
	  				'width': 4,
	  				'height': 4,
	  				'rollOverColor': undefined,
	  			}
	  			}, {
	  				'id': 'asia',
	  				'title': 'Asia',
	  				'pattern': {
	  					'url': 'https://www.amcharts.com/lib/3/patterns/black/pattern2.png',
	  					'width': 4,
	  					'height': 4
	  				}
	  			}, {
	  				'id': 'australia',
	  				'title': 'Australia',
	  				'pattern': {
	  					'url': 'https://www.amcharts.com/lib/3/patterns/black/pattern2.png',
	  					'width': 4,
	  					'height': 4,
	  				}
	  			}, {
	  				'id': 'europe',
	  				'title': 'Europe',
	  				'pattern': {
	  					'url': 'https://www.amcharts.com/lib/3/patterns/black/pattern2.png',
	  					'width': 4,
	  					'height': 4
	  				}
	  			}, {
	  				'id': 'north_america',
	  				'title': 'North America',
	  				'pattern': {
	  					'url': 'https://www.amcharts.com/lib/3/patterns/black/pattern2.png',
	  					'width': 4,
	  					'height': 4
	  				}
	  			}, {
	  				'id': 'south_america',
	  				'title': 'South America',
	  				'pattern': {
	  					'url': 'https://www.amcharts.com/lib/3/patterns/black/pattern2.png',
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
			'mouseEnabled': false,
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
	$('a[href="http://www.amcharts.com/javascript-maps/"]').css({'opacity': 0.2});

console.log(map.dataProvider.images);

map.addListener( "positionChanged", updateCustomMarkers );

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
  holder.className = 'map-marker';
  holder.title = image.title;
  holder.style.position = 'absolute';

  // maybe add a link to it?
  if ( undefined != image.url ) {
    holder.onclick = function() {
      window.location.href = image.url;
    };
    holder.className += ' map-clickable';
  }

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

	
})( jQuery );