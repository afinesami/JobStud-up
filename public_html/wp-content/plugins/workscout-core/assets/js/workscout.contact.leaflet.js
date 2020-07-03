/* ----------------- Start Document ----------------- */
(function($){
"use strict";

$(document).ready(function(){

    var group;
    var marker;
    var locations;
    var markerArray = [];

    var markers;

    var latlngStr = wsmap.centerPoint.split(",",2);

    var lat = parseFloat(latlngStr[0]);
    var lng = parseFloat(latlngStr[1]);
    
    if ( $('#googlemaps').attr('data-map-scroll') == 'true' || $(window).width() < 992 ) {
      var scrollEnabled = false;
    } else {
      var scrollEnabled = true;
    }

    var maxzoom = $('#googlemaps').attr('data-maxzoom');
    
    var mapOptions = {
            center: [lat,lng],
            zoom: 8,
            zoomControl: false,
            maxZoom: maxzoom,
            gestureHandling: scrollEnabled
    }  
    var map_single;

    // Touch Gestures
   


    // Map Init
    
    $('#scrollEnabling').hide();

 
    
    function getMarkers() {
        var arrMarkers = [];
        var markers = $('#googlemaps').data('mappoints');
        if(markers){
          arrMarkers = $.parseJSON(markers)
        }
       return arrMarkers;
    }


    function jobLocationData(address,content) {
      var output;
      var output_image;
     
      output =  '<a  class="job-listing">'+
         '<div class="job-listing-details"><div class="job-listing-description">'+
              
              '<h3 class="job-listing-title">'+address+'</h3>'+content
              '</div>'+
         '</div>'+
      '</a>';
       return output;
    }

// address: "Gallues 2/31"
// latitude: "19.195406"
// longitude: "50.290180"
// content: "dgdfgdfg"
    function contactListingMap() {

        map_single = L.map('googlemaps',mapOptions);
        // markers = L.markerClusterGroup({
        //   spiderfyOnMaxZoom: true,
        //   showCoverageOnHover: false,
        // });
        
        var locations = getMarkers();
          
        for (var i = 0; i < locations.length; i++) {

          var listeoIcon = L.divIcon({
              iconAnchor: [0, 0], // point of the icon which will correspond to marker's location
              popupAnchor: [0, 0],
              className: 'listeo-marker-icon',
              html:  '<div class="marker-container">'+
                               '<div class="marker-card">'+
                                  '<div class="front face"></div>'+
                                  '<div class="back face"></div>'+
                                  '<div class="marker-arrow"></div>'+
                               '</div>'+
                             '</div>'
              
            }
          );

            var popupOptions =
              {
                'maxWidth': '320',
                'minWidth': '320',
                'className' : 'leaflet-infoBox'
              }
          
            marker = new L.marker([locations[i]['latitude'],locations[i]['longitude']], {
              icon: listeoIcon,
              
            })
            .bindPopup(jobLocationData(locations[i]['address'],locations[i]['content']),popupOptions ).addTo(map_single);;
          
             
            

            markerArray.push(L.marker([locations[i]['latitude'], locations[i]['longitude']]));
        }
       if(markerArray.length > 0 ){
              group = L.featureGroup(markerArray);
              map_single.fitBounds(group.getBounds()); 
          }


        var zoomOptions = {
           zoomInText: '<i class="fa fa-plus" aria-hidden="true"></i>',
           zoomOutText: '<i class="fa fa-minus" aria-hidden="true"></i>',
        };
        // Creating zoom control
        var zoom = L.control.zoom(zoomOptions);
        zoom.addTo(map_single);

        //map_single.scrollWheelZoom.disable();

        switch(workscout_core.map_provider) {
          case 'osm':
              L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
              }).addTo(map_single);
            break;
          case 'google':
            
                var roads = L.gridLayer.googleMutant({
                  type: 'roadmap', // valid values are 'roadmap', 'satellite', 'terrain' and 'hybrid'
                  maxZoom: 18,
                }).addTo(map_single);

              break;
          case 'mapbox':
              L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}@2x.png?access_token={accessToken}', {
                  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                  maxZoom: 18,
                  //detectRetina: true,
                  id: 'mapbox.streets',
                  accessToken: workscout_core.mapbox_access_token
              }).addTo(map_single);
          break;

          case 'bing':
              L.tileLayer.bing(workscout_core.bing_maps_key).addTo(map_single)
          break;

          case 'thunderforest':
              var tileUrl = 'https://tile.thunderforest.com/cycle/{z}/{x}/{y}{r}.png?apikey='+workscout_core.thunderforest_api_key,
              layer = new L.TileLayer(tileUrl, {maxZoom: 18});
              map_single.addLayer(layer);
          break;

          case 'here':
              L.tileLayer.here({appId: workscout_core.here_app_id, appCode: workscout_core.here_app_code}).addTo(map_single);
          break;
        }
    }


		$(window).on('load', function() {
		    // Single Listing Map Init
		    var single_map_cont =  document.getElementById('googlemaps');

		    if (typeof(single_map_cont) != 'undefined' && single_map_cont != null) {
		        
		        contactListingMap();
		    }
		});

   });

})(this.jQuery);
