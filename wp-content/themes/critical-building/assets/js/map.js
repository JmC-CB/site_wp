(function () {
	'use strict';
	document.addEventListener( 'DOMContentLoaded', function () {
		if ( typeof L === 'undefined' || typeof cbMapAssets === 'undefined' ) return;

		var icon = L.icon( {
			iconUrl: cbMapAssets.icon,
			iconRetinaUrl: cbMapAssets.icon2x,
			shadowUrl: cbMapAssets.shadow,
			iconSize: [ 25, 41 ],
			iconAnchor: [ 12, 41 ],
			popupAnchor: [ 1, -34 ],
			shadowSize: [ 41, 41 ]
		} );

		// Autant de cartes que d'éléments .cb-map trouvés sur la page,
		// chacune avec son propre jeu de marqueurs (attribut data-markers en JSON).
		document.querySelectorAll( '.cb-map[data-markers]' ).forEach( function ( el ) {
			var markers;
			try {
				markers = JSON.parse( el.getAttribute( 'data-markers' ) );
			} catch ( e ) {
				return;
			}
			if ( ! markers || ! markers.length ) return;

			var latlngs = markers.map( function ( m ) { return [ parseFloat( m.lat ), parseFloat( m.lng ) ]; } );

			var map = L.map( el, { scrollWheelZoom: false } ).setView( latlngs[ 0 ], markers.length > 1 ? 11 : 15 );

			L.tileLayer( cbMapAssets.tileUrl, {
				attribution: cbMapAssets.attrib,
				maxZoom: 19
			} ).addTo( map );

			markers.forEach( function ( m, i ) {
				var marker = L.marker( latlngs[ i ], { icon: icon } ).addTo( map );
				if ( m.popup ) {
					marker.bindPopup( String( m.popup ).replace( /\n/g, '<br>' ) );
					if ( 0 === i ) marker.openPopup();
				}
			} );

			if ( latlngs.length > 1 ) {
				map.fitBounds( latlngs, { padding: [ 40, 40 ] } );
			}

			el.addEventListener( 'click', function () { map.scrollWheelZoom.enable(); } );
			el.addEventListener( 'mouseleave', function () { map.scrollWheelZoom.disable(); } );
		} );
	} );
})();
