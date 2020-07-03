/* ----------------- Start Document ----------------- */
(function($){
"use strict";

$(document).ready(function(){

  
  var url;
  var infoBox_ratingType = 'star-rating';
  var text;
  var marker_color;

  // Touch Gestures
  if ( $('#search_map').attr('data-map-scroll') == 'true' || $(window).width() < 992 ) {
    var scrollEnabled = false;
  } else {
    var scrollEnabled = true;
  }
  if ( $(window).width() < 992 ) {
    var scrollEnabled = false;
  }

  var mapOptions = {
    gestureHandling: scrollEnabled,
  }
  $(".geoLocation,.input-with-icon.location a,.sidebar-search_location-container a").on("click", function (e) {
          e.preventDefault();
          
          geolocate();
      });

  // Map Init
  
  $('#scrollEnabling').hide();



  function jobLocationData(jobURL,jobImg,jobTitle, jobAddress, companyName, jobType, rate, salary) {
      var output;
      var output_image;
      if(jobImg){
        output_image = '<div class="job-listing-company-logo"><img src="'+jobImg+'" alt=""></div>';
      } 
      output =  '<a href="'+jobURL+'" class="job-listing">'+
         '<div class="job-listing-details">'+output_image +
            '<div class="job-listing-description">'+
              '<h4 class="job-listing-company">'+companyName+'</h4>'+
              '<h3 class="job-listing-title">'+jobTitle+'</h3>'+
              ''+jobType;
              if(rate || salary ) {
              output += '<ul>'+rate+''+
                ''+salary+'</ul>';

              }
              
           output +=  '</div>'+
         '</div>'+
      '</a>';
       return output;
    }
      // $(this).find('a').attr('href') ? $(this).find('a').attr('href') : $(this).attr('href'),
      //           $(this).data('image'),
      //           $(this).data('title'),
      //           $(this).data('profession'),
      //           $(this).data('location'),
      //           $(this).data('rate'),
      //           $(this).data('skills'),
    function resumeLocationData(resumeURL,resumeImg,candidateTitle, profession, location, rate, skills) {
      var output;
      var output_image;
      if(resumeImg){
        output_image = '<div class="job-listing-company-logo"><img src="'+resumeImg+'" alt=""></div>';
      } 
      output =  '<a href="'+resumeURL+'" class="job-listing">'+
         '<div class="job-listing-details">'+output_image +
            '<div class="job-listing-description">'+
              '<h4 class="job-listing-company">'+profession+'</h4>'+
              '<h3 class="job-listing-title">'+candidateTitle+'</h3>'+
              ''+skills;
              if(rate){
               output += '<ul>'+rate+'</ul>';
              }

             output += '</div>'+
         '</div>'+
      '</a>'
       return output;
    }




  function getJobMarkers() {
      var arrMarkers = [];
      $('.job_listings li').each(function(index) {
        var point_address;
       
        
        // if( $( this ).is('a') ){
        //   url = $(this).find('a').attr('href');
        // } else {
        //   url = $(this).find('a').attr('href');
        // }
        
        if( $( this ).data('longitude') &&  $( this ).data('latitude')  ) {
            // text = $( this ).html() + '<div class="infoBox-close"><i class="fa fa-times"></i></div>';
            // marker_color = $( this ).data('color');
            // if(marker_color == null) { marker_color = wsmap.marker_color; }
            // arrMarkers.push( [parseFloat($( this ).data('latitude')), parseFloat($( this ).data('longitude')),  text, marker_color ] );
            arrMarkers.push([ 
              jobLocationData(
                $(this).find('a').attr('href') ? $(this).find('a').attr('href') : $(this).attr('href'),
                $(this).data('image'),
                $(this).data('title'),
                $(this).data('address'),
                $(this).data('company'),
                $(this).data('job_type'),
                $(this).data('rate'),
                $(this).data('salary'),
                
             
              ),
              $( this ).data('latitude'), $( this ).data('longitude'), 1, $(this).data('job_type_class'),
            ]);

        }
      });
      
      return arrMarkers;
  }

  function getResumeMarkers() {
      var arrMarkers = [];
      $('.resumes li.resume').each(function(index) {
        var point_address;
       
        
        // if( $( this ).is('a') ){
        //   url = $(this).find('a').attr('href');
        // } else {
        //   url = $(this).find('a').attr('href');
        // }
        
        if( $( this ).data('longitude') &&  $( this ).data('latitude')  ) {
            // text = $( this ).html() + '<div class="infoBox-close"><i class="fa fa-times"></i></div>';
            // marker_color = $( this ).data('color');
            // if(marker_color == null) { marker_color = wsmap.marker_color; }
            // arrMarkers.push( [parseFloat($( this ).data('latitude')), parseFloat($( this ).data('longitude')),  text, marker_color ] );
            arrMarkers.push([ 
              resumeLocationData(
                $(this).find('a').attr('href') ? $(this).find('a').attr('href') : $(this).attr('href'),
                $(this).data('image'),
                $(this).data('title'),
                $(this).data('profession'),
                $(this).data('location'),
                $(this).data('rate'),
                $(this).data('skills'),
              ),
              $( this ).data('latitude'), $( this ).data('longitude'), 1, $(this).data('icon'),
            ]);

        }
      });
      
      return arrMarkers;
  }

   
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

     

    window.L_DISABLE_3D = true 
        
       
    // console.log(locations);
    var group;
    var marker;
    var locations;
    var markerArray = [];

    var markers;

    var latlngStr = wsmap.centerPoint.split(",",2);

    var lat = parseFloat(latlngStr[0]);
    var lng = parseFloat(latlngStr[1]);

    var mapOptions = {
            center: [lat,lng],
            zoom: wsmap.default_zoom,
            zoomControl: false,
            gestureHandling: scrollEnabled
    }  
      
    var _map =  document.getElementById('search_map');

    if (typeof(_map) != 'undefined' && _map != null) {
          var map = L.map('search_map',mapOptions)
      
          switch(workscout_core.map_provider) {
            case 'osm':
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                

              break;
              case 'google':
            
                var roads = L.gridLayer.googleMutant({
                  type: 'roadmap' // valid values are 'roadmap', 'satellite', 'terrain' and 'hybrid'
                }).addTo(map);

              break;

            case 'mapbox':
              if(workscout_core.mapbox_retina){
                
                L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}@2x.png?access_token={accessToken}', {
                    attribution: " &copy;  <a href='https://www.mapbox.com/about/maps/'>Mapbox</a> &copy;  <a href='http://www.openstreetmap.org/copyright'>OpenStreetMap</a> <strong><a href='https://www.mapbox.com/map-feedback/' target='_blank'>Improve this map</a></strong>",
                    maxZoom: 18,
                    //detectRetina: true,
                    id: 'mapbox.streets',
                    accessToken: workscout_core.mapbox_access_token
                }).addTo(map);
              } else {

                L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
                    attribution: " &copy;  <a href='https://www.mapbox.com/about/maps/'>Mapbox</a> &copy;  <a href='http://www.openstreetmap.org/copyright'>OpenStreetMap</a> <strong><a href='https://www.mapbox.com/map-feedback/' target='_blank'>Improve this map</a></strong>",
                    maxZoom: 18,
                    //detectRetina: true,
                    id: 'mapbox.streets',
                    accessToken: workscout_core.mapbox_access_token
                }).addTo(map);
              }
                
            break;

            case 'bing':
                L.tileLayer.bing(workscout_core.bing_maps_key).addTo(map)
            break;

            case 'thunderforest':
                var tileUrl = 'https://tile.thunderforest.com/cycle/{z}/{x}/{y}{r}.png?apikey='+workscout_core.thunderforest_api_key,
                layer = new L.TileLayer(tileUrl, {maxZoom: 18});
                map.addLayer(layer);
            break;

            case 'here':
                L.tileLayer.here({appId: workscout_core.here_app_id, appCode: workscout_core.here_app_code}).addTo(map);
            break;
          }

            if ( $('#search_map').attr('data-map-scroll') == 'true') {
            map.scrollWheelZoom.enable();
            console.log('scrol-enable');
            }
            if( $(window).width() < 992 ){
              map.scrollWheelZoom.disable();
              console.log('scrol-disable');
            }

            var zoomOptions = {
               zoomInText: '<i class="fa fa-plus" aria-hidden="true"></i>',
               zoomOutText: '<i class="fa fa-minus" aria-hidden="true"></i>',
            };
            // Creating zoom control
            var zoom = L.control.zoom(zoomOptions);
            zoom.addTo(map);
          
          
      } 

      if($('#search_map').length) {
            $( '.job_listings,.resumes' ).on( 'updated_results', function (  ) {
                map.removeLayer(markers);
                listingsMap(map);
                // addMarkers();
                //codeAddress() 
            });
        }

      function listingsMap(map){
          markerArray = [];
          var current_zoom = map.getZoom()
          markers = L.markerClusterGroup({
            spiderfyOnMaxZoom: true,
            showCoverageOnHover: false,
          });
          if($('#search_map').hasClass('jobs_map')){
            
            locations = getJobMarkers();  
      
          
          } else {
          
            locations = getResumeMarkers();  
          
          }
          
          for (var i = 0; i < locations.length; i++) {

            var listeoIcon = L.divIcon({
                iconAnchor: [0, 0], // point of the icon which will correspond to marker's location
                popupAnchor: [0, 0],
                className: 'listeo-marker-icon',
                html:  '<div class="marker-container '+locations[i][4]+'">'+
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
            
              marker = new L.marker([locations[i][1],locations[i][2]], {
                  icon: listeoIcon,
                  
                })
                .bindPopup(locations[i][0],popupOptions );
                //.addTo(map);
                marker.on('click', function(e){
                 
                });
                if(wsmap.use_clusters){
                  markers.addLayer(marker);
                } else {
                  marker.addTo(map);  
                }
                
                //

                markerArray.push(L.marker([locations[i][1], locations[i][2]]));
          }
          if(wsmap.use_clusters){
            map.addLayer(markers);
          }

          if(wsmap.autofit && markerArray.length > 0 ){
              console.log(markerArray);
              group = L.featureGroup(markerArray);
              console.log(group.getBounds());
              map.fitBounds(group.getBounds()); 
              map.setView(group.getBounds().getCenter());
          }
      }

      var map_id =  document.getElementById('search_map');

      if (typeof(map_id) != 'undefined' && map_id != null) {
        listingsMap(map);
     
      }

      if(wsmap.address_provider == 'osm'){
          if(wsmap.country){
            var geocoder = new L.Control.Geocoder.Nominatim( {
                geocodingQueryParams: {countrycodes: wsmap.country}
            });
          } else {
            var geocoder = new L.Control.Geocoder.Nominatim();  
          }     
          
          var output = [];
          $("#search_location,#job_location,#candidate_location").attr('autocomplete', 'off').after('<div id="leaflet-geocode-cont"><ul></ul></div>')
          var liSelected;
          var next;
          // OSM TIP
          $("#search_location,#job_location,#candidate_location")
          .on("mouseover",function() {
              if ( $(this).val().length < 10 ) {
                  $('.type-and-hit-enter').addClass('tip-visible');
              } 
          }).on("mouseout",function(e) {
             setTimeout(function(){
                   $('.type-and-hit-enter').removeClass('tip-visible');
             }, 350);
          }).on("keyup",function(e) {

              if ( $(this).val().length < 10 ) {
                  $('.type-and-hit-enter').addClass('tip-visible');
              } 
              if ( $(this).val().length > 10 ) {
                  $('.type-and-hit-enter').removeClass('tip-visible tip-visible-focusin');
              }
              
              if(e.which === 40 || e.which === 38 ) {
                
                
              } else {
                $('#leaflet-geocode-cont ul li.selected').removeClass('selected');
              }
              // if(e.which !== 38 ) {
              //   console.log(e.which);
              //   //$('#leaflet-geocode-cont ul li.selected').removeClass('selected');
              // }

          }).on("keydown",function(e) {
                var li = $('#leaflet-geocode-cont ul li');
               if(e.which === 40){
                
                  if(liSelected){
                      liSelected.removeClass('selected');
                      next = liSelected.next();
                      if(next.length > 0){
                          liSelected = next.addClass('selected');
                      }else{
                          liSelected = li.eq(0).addClass('selected');
                      }
                  }else{
                      liSelected = li.eq(0).addClass('selected');
                  }
              }else if(e.which === 38){
                  if(liSelected){
                      liSelected.removeClass('selected');
                      next = liSelected.prev();
                      if(next.length > 0){
                          liSelected = next.addClass('selected');
                      }else{
                          liSelected = li.last().addClass('selected');
                      }
                  }else{
                      liSelected = li.last().addClass('selected');
                  }
              }
            
          });

          $("#search_location,#job_location,#candidate_location").on("focusin",function() {
              if ( $(this).val().length < 10 ) {
                  $('.type-and-hit-enter').addClass('tip-visible-focusin');
              }
              if ( $(this).val().length > 10 ) {
                  $('.type-and-hit-enter').removeClass('tip-visible-focusin');
              }
          }).on("focusout",function() {
              setTimeout(function(){
                  $('.type-and-hit-enter').removeClass('tip-visible tip-visible-focusin');
              }, 350);
              if( $(this).val() == 0 ) {
                $('.job_listings,.resumes' ).triggerHandler( 'update_results', [ 1, false ] );
              }
          });
          
          $(".location .la-map-marked-alt").on("mouseover",function() {
              $('.type-and-hit-enter').removeClass('tip-visible-focusin tip-visible');
          })
          
          $('.type-and-click-btn').on("click",function search(e) {

               var query = $('#_address').val();
                if(query){
                  geocoder.geocode(query, function(results) { 
                    
                    for (var i = 0; i < results.length; i++) {
                      
                      output.push('<li data-latitude="'+results[i].center.lat+'" data-longitude="'+results[i].center.lng+'" >'+results[i].name+'</li>');
                    }
                    output.push('<li class="powered-by-osm">Powered by <strong>OpenStreetMap</strong></li>');
                    $("#leaflet-geocode-cont").addClass('active');
                    $('#autocomplete-container').addClass("osm-dropdown-active");
                    $('#leaflet-geocode-cont ul').html(output);
                    var txt_to_hl = query.split(' ');
                    txt_to_hl.forEach(function (item) {
                      $('#leaflet-geocode-cont ul').highlight(item);
                    });
                    output = [];
                  });
                }
          });
          
          $("#search_location,#job_location,#candidate_location").on("keydown",function search(e) {

            
              if(e.keyCode == 13) {
                  if($('#leaflet-geocode-cont ul li.selected').length>0){
                    $('#leaflet-geocode-cont ul li.selected').trigger('click').removeClass('selected');

                   return;
                   
                  }

                  var query = $.trim($(this).val());
                  if(query){
                  geocoder.geocode(query, function(results) { 
                    
                    for (var i = 0; i < results.length; i++) {
                      
                      output.push('<li data-latitude="'+results[i].center.lat+'" data-longitude="'+results[i].center.lng+'" >'+results[i].name+'</li>');
                    }
                    output.push('<li class="powered-by-osm">Powered by <strong>OpenStreetMap</strong></li>');
                    $('#leaflet-geocode-cont ul').html(output);
                    var txt_to_hl = query.split(' ');
                    txt_to_hl.forEach(function (item) {
                      $('#leaflet-geocode-cont ul').highlight(item);
                    });
                    $('#autocomplete-container').addClass("osm-dropdown-active"); 
                    $("#leaflet-geocode-cont").addClass('active');
                    output = [];
                  });
                }
              }
          });
           $(".workscout_main_search_form,.job-manager-form,.job_filters,.resume_filters").on( "click", "#leaflet-geocode-cont ul li", function(e) {
              
              $("#search_location").val($(this).text());
              $("#job_location").val($(this).text());
              $("#candidate_location").val($(this).text());
              $("#leaflet-geocode-cont").removeClass('active');
              $('#autocomplete-container').removeClass("osm-dropdown-active");
              
              var newLatLng = new L.LatLng($(this).data('latitude'), $(this).data('longitude'));
              if(map){
              map.flyTo(newLatLng, 10);
              }
              var target   = $('div.job_listings,div.resumes' );
              target.triggerHandler( 'update_results', [ 1, false ] );
          });

          $('.workscout_main_search_form,.job-manager-form,.job_filters').on('submit', function(){
            
              if ($('#search_location:focus').length){ return false;}
              if ($('#job_location:focus').length){ return false;}
              if ($('#candidate_location:focus').length){ return false;}
          });

          if($("#search_location,#job_location,#candidate_location").val()) {
            var query = $("#search_location,#job_location,#candidate_location").val()
            geocoder.geocode(query, function(results) { 
              console.log(results[0].center);
              if(map){
                map.flyTo(results[0].center, 10);  
              }
              
              
            });
          }
        
        var mouse_is_inside = false;

        $( "#search_location,#_address,#leaflet-geocode-cont" ).on( "mouseenter", function() {
            mouse_is_inside=true;
        });
        $( "#search_location,#_address,#leaflet-geocode-cont" ).on( "mouseleave", function() {
            mouse_is_inside=false;
        });

        $("body").mouseup(function(){
            if(! mouse_is_inside) $("#leaflet-geocode-cont").removeClass('active');
        });

      } //eof if addressprovider
     




    function singleListingMap() {

        var lng = parseFloat($( '#job_map' ).data('longitude'));
        var lat =  parseFloat($( '#job_map' ).data('latitude'));
        var singleMapIco =  "<i class='"+$('#job_map').data('map-icon')+"'></i>";
        var map_single;
        var listeoIcon = L.divIcon({
            iconAnchor: [0, 0], // point of the icon which will correspond to marker's location
            popupAnchor: [0, 0],
            className: 'listeo-marker-icon',
            html:  '<div class="marker-container no-marker-icon ">'+
                             '<div class="marker-card">'+
                                '<div class="front face">' + singleMapIco + '</div>'+
                                '<div class="back face">' + singleMapIco + '</div>'+
                                '<div class="marker-arrow"></div>'+
                             '</div>'+
                           '</div>'
            
          }
        );
        var mapOptions = {
            center: [lat,lng],
            zoom: 13,
            zoomControl: false,
            gestureHandling: true
         }

        map_single = L.map('job_map',mapOptions);
        var zoomOptions = {
           zoomInText: '<i class="fa fa-plus" aria-hidden="true"></i>',
           zoomOutText: '<i class="fa fa-minus" aria-hidden="true"></i>',
        };
        // Creating zoom control
        var zoom = L.control.zoom(zoomOptions);
        zoom.addTo(map_single);

        map_single.scrollWheelZoom.disable();

        marker = new L.marker([lat,lng], {
                icon: listeoIcon,
                
              }).addTo(map_single);

        switch(workscout_core.map_provider) {
          case 'osm':
              L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
              }).addTo(map_single);
            break;
          case 'google':
            
                var roads = L.gridLayer.googleMutant({
                  type: 'roadmap' // valid values are 'roadmap', 'satellite', 'terrain' and 'hybrid'
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
    var single_map_cont =  document.getElementById('job_map');

    if (typeof(single_map_cont) != 'undefined' && single_map_cont != null) {
        
        singleListingMap();
    }

    if(wsmap.maps_autolocate){
     
       $(".geoLocation,.input-with-icon.location a,.sidebar-search_location-container a").trigger('click')
      }
});


   });
   
   
// Map height on Half Map Page
$(window).on('load resize', function() {
    var headerHeight =  $(".new-header #header-container").height();
    var windowHeight = $(window).height();
    
   $(".full-page-map-container #search_map").css({
   	height: windowHeight - headerHeight
   });

});
 


    
      function geolocate() {
   
          if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function (position) {
                  
                  var latitude = position.coords.latitude;
                  var longitude = position.coords.longitude;
                  var latlng = L.latLng(latitude, longitude);
                  if(map){
                    map.flyTo([latitude,longitude],10);
                    geocoder.reverse(latlng, map.options.crs.scale(map.getZoom()), function(results) { 
                      
                      $("#search_location").val(results[0].name);
                      $("#_address").val(results[0].name);
                      $('#_geolocation_lat').val(latitude);
                      $('#_geolocation_long').val(longitude);
                      var newLatLng = new L.LatLng(latitude, longitude);
                      marker.setLatLng(newLatLng).update(); 
                      map.panTo(newLatLng);
                      var listing_results      = $('.job_listings,div.resumes:not(:parent.sidebar)');
                      listing_results.triggerHandler( 'update_results', [ 1, false ] );
                    });
                  } else {
                    geocoder.reverse(latlng, 4, function(results) { 
                      
                      $("#search_location").val(results[0].name);
                      $("#_address").val(results[0].name);
                      $('#_geolocation_lat').val(latitude);
                      $('#_geolocation_long').val(longitude);
                      var listing_results      = $('.job_listings,div.resumes:not(:parent.sidebar)');
                      listing_results.triggerHandler( 'update_results', [ 1, false ] );
                    });

                  }
                  
                 
              });
          }
      }
    
    
   
})(this.jQuery);



jQuery.fn.highlight = function(pat) {
 function innerHighlight(node, pat) {
  var skip = 0;
  if (node.nodeType == 3) {
   var pos = node.data.toUpperCase().indexOf(pat);
   if (pos >= 0) {
    var spannode = document.createElement('span');
    spannode.className = 'highlight';
    var middlebit = node.splitText(pos);
    var endbit = middlebit.splitText(pat.length);
    var middleclone = middlebit.cloneNode(true);
    spannode.appendChild(middleclone);
    middlebit.parentNode.replaceChild(spannode, middlebit);
    skip = 1;
   }
  }
  else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
   for (var i = 0; i < node.childNodes.length; ++i) {
    i += innerHighlight(node.childNodes[i], pat);
   }
  }
  return skip;
 }
 return this.each(function() {
  innerHighlight(this, pat.toUpperCase());
 });
};

jQuery.fn.removeHighlight = function() {
 function newNormalize(node) {
    for (var i = 0, children = node.childNodes, nodeCount = children.length; i < nodeCount; i++) {
        var child = children[i];
        if (child.nodeType == 1) {
            newNormalize(child);
            continue;
        }
        if (child.nodeType != 3) { continue; }
        var next = child.nextSibling;
        if (next == null || next.nodeType != 3) { continue; }
        var combined_text = child.nodeValue + next.nodeValue;
        new_node = node.ownerDocument.createTextNode(combined_text);
        node.insertBefore(new_node, child);
        node.removeChild(child);
        node.removeChild(next);
        i--;
        nodeCount--;
    }
 }

 return this.find("span.highlight").each(function() {
    var thisParent = this.parentNode;
    thisParent.replaceChild(this.firstChild, this);
    newNormalize(thisParent);
 }).end();
};