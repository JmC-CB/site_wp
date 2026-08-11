(function () {
	'use strict';
	document.addEventListener( 'DOMContentLoaded', function () {
		var el = document.getElementById( 'cb-map' );
		if ( ! el || typeof L === 'undefined' || typeof cbMapData === 'undefined' ) return;

		var lat = parseFloat( cbMapData.lat ) || 48.7906;
		var lng = parseFloat( cbMapData.lng ) || 2.2887;

		var map = L.map( el, { scrollWheelZoom: false } ).setView( [ lat, lng ], 15 );

		L.tileLayer( cbMapData.tileUrl, {
			attribution: cbMapData.attrib,
			maxZoom: 19
		} ).addTo( map );

		var icon = L.icon( {
			iconUrl: cbMapData.icon,
			iconRetinaUrl: cbMapData.icon2x,
			shadowUrl: cbMapData.shadow,
			iconSize: [ 25, 41 ],
			iconAnchor: [ 12, 41 ],
			popupAnchor: [ 1, -34 ],
			shadowSize: [ 41, 41 ]
		} );

		var marker = L.marker( [ lat, lng ], { icon: icon } ).addTo( map );
		if ( cbMapData.popup ) {
			marker.bindPopup( String( cbMapData.popup ).replace( /\n/g, '<br>' ) ).openPopup();
		}

		el.addEventListener( 'click', function () { map.scrollWheelZoom.enable(); } );
		el.addEventListener( 'mouseleave', function () { map.scrollWheelZoom.disable(); } );
	} );
})();
