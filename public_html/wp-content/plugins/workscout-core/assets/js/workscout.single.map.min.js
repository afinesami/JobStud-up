(function ( $ ) {
	"use strict";

	$(function () {

	  	function iconColor(color) {
		    return {
		        path: 'M19.9,0c-0.2,0-1.6,0-1.8,0C8.8,0.6,1.4,8.2,1.4,17.8c0,1.4,0.2,3.1,0.5,4.2c-0.1-0.1,0.5,1.9,0.8,2.6c0.4,1,0.7,2.1,1.2,3 c2,3.6,6.2,9.7,14.6,18.5c0.2,0.2,0.4,0.5,0.6,0.7c0,0,0,0,0,0c0,0,0,0,0,0c0.2-0.2,0.4-0.5,0.6-0.7c8.4-8.7,12.5-14.8,14.6-18.5 c0.5-0.9,0.9-2,1.3-3c0.3-0.7,0.9-2.6,0.8-2.5c0.3-1.1,0.5-2.7,0.5-4.1C36.7,8.4,29.3,0.6,19.9,0z M2.2,22.9 C2.2,22.9,2.2,22.9,2.2,22.9C2.2,22.9,2.2,22.9,2.2,22.9C2.2,22.9,3,25.2,2.2,22.9z M19.1,26.8c-5.2,0-9.4-4.2-9.4-9.4 s4.2-9.4,9.4-9.4c5.2,0,9.4,4.2,9.4,9.4S24.3,26.8,19.1,26.8z M36,22.9C35.2,25.2,36,22.9,36,22.9C36,22.9,36,22.9,36,22.9 C36,22.9,36,22.9,36,22.9z M13.8,17.3a5.3,5.3 0 1,0 10.6,0a5.3,5.3 0 1,0 -10.6,0',
				strokeOpacity: 0,
				strokeWeight: 1,
				fillColor: color,
				fillOpacity: 1,
				rotation: 0,
				scale: 1,
				anchor: new google.maps.Point(19,52)
		   };
		}
		
		function initJobMap() {

		    var myLatLng = {lng: parseFloat($( '#job_map' ).data('longitude')),lat: parseFloat($( '#job_map' ).data('latitude')), };
		    var single_zoom = parseInt(wssmap.single_zoom);
		    var single_map = new google.maps.Map(document.getElementById('job_map'), {
		      zoom: single_zoom,
		      center: myLatLng,
		      gestureHandling: 'cooperative',
		    });

		    var marker = new google.maps.Marker({
		      position: myLatLng,
		      map: single_map,
		      icon: iconColor(wssmap.marker_color), 
		    });
		}
	    
	  	var single_map =  document.getElementById('job_map');
		if (typeof(single_map) != 'undefined' && single_map != null) {
		  	google.maps.event.addDomListener(window, 'load', initJobMap);
		}

		// address auto suggest



	/*eof*/

	});
}(jQuery));
