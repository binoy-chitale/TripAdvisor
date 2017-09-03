@extends('layouts.app')
@section('content')
<div class="container" style="width:100%;">
	<div class = "col-md-3">
		<div class="scrollable-sidebar"style ="height:100vh">
		<ul  class="sortable side-sortable">
			
		</ul>
		</div>
	</div>
	<div id="map" class="col-md-9">
	</div>
	<div id="legend"></div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	window.onLoad = function(){	
      
  	};
</script>
<script>
      var markers =[];
      var gmarkers=[];
      var allmarkers = [];
      var icons=[];
      var directionsDisplay;
      var directionsService;
      var map;
      var infowindows = [];
      function initMap() {
        var colors = ["http://maps.google.com/mapfiles/ms/icons/red-dot.png","http://maps.google.com/mapfiles/ms/icons/blue-dot.png","http://maps.google.com/mapfiles/ms/icons/green-dot.png","http://maps.google.com/mapfiles/ms/icons/orange-dot.png","http://maps.google.com/mapfiles/ms/icons/yellow-dot.png","http://maps.google.com/mapfiles/ms/icons/purple-dot.png","http://maps.google.com/mapfiles/ms/icons/pink-dot.png","http://maps.google.com/mapfiles/ms/icons/ltblue-dot.png"];	 
	    var strokeColors = ["red","blue","green","orange","yellow","purple","pink","#00ffff","black","grey","#00ff80","#663300","#9900ff","#ffffff","#66ff33","#ff00ff","#990033","#333300","#000099","#339966","#0099ff"];
	    var locations = JSON.parse(localStorage['locations']);
	    var list = document.getElementsByClassName("side-sortable")[0];
	    directionsDisplay = new google.maps.DirectionsRenderer;
	    directionsService = new google.maps.DirectionsService;
	    map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: {lat:parseFloat(locations[0][0][1]), lng:parseFloat(locations[0][0][2])}
        });
        directionsDisplay.setMap(map);
	    lastIndex=0;
	    for (i = 0; i < locations.length; i++){
		    
		    for (j = 0; j < locations[i].length; j++) {
					markers.push([locations[i][j][0],parseFloat(locations[i][j][1]),parseFloat(locations[i][j][2]),colors[i%colors.length]]);
			} 
			var directionRenderer = new google.maps.DirectionsRenderer({
				suppressMarkers: true,
				polylineOptions: {
			    strokeColor: strokeColors[i%strokeColors.length],
			    icons: [{
		        icon: {path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW},
		        offset: '100%',
		        repeat: '100px'
    			}]
			    }
			});
			icons.push(
				 {
		            name: 'Day'+(i+1),
		            icon: google.maps.SymbolPath.CIRCLE,
		            fillColor:strokeColors[i%strokeColors.length],
		         }
			);
			directionRenderer.setMap(map);
			if(lastIndex<markers.length){
				calcRoute(markers.slice(lastIndex,markers.length),directionRenderer,map);
				lastIndex=markers.length;
			}
		}	
		for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        // var position = {lat:markers[i][1],lng:markers[0][2]};
        var marker = new google.maps.Marker({
            position: position,
            map: map,
            icon: markers[i][3],
            title: markers[i][0]
        });
        var infowindow = new google.maps.InfoWindow();
        bindInfoWindow(marker, map, infowindow, markers[i][0]);
        gmarkers.push(marker);
        // google.maps.event.addListener(marker, 'click', (function(marker, i) {
        //     return function() {
        //         infoWindow.setContent(infoWindowContent[i][0]);
        //         infoWindow.open(map, marker);
        //     }
        // })(marker, i));
    	}
    	// var icons = {
     //      red: {
     //        name: '',
     //        icon: google.maps.SymbolPath.CIRCLE,
     //        fillColor:'red',
     //      },
     //      library: {
     //        name: 'Library',
     //        icon: iconBase + 'library_maps.png'
     //      },
     //      info: {
     //        name: 'Info',
     //        icon: iconBase + 'info-i_maps.png'
     //      }
     //    };
     	
    	var legend = document.getElementById('legend');
        for (i=0;i<icons.length;i++) {
          var name = icons[i]['name'];
          var div = document.createElement('div');
          div.innerHTML = '<svg height="20" width="20"><circle cx="10" cy="10" r="40" fill="'+icons[i]['fillColor']+'"/></svg>' + '<span style="font-size:10px;">'+'  '+name+'</span>';
          legend.appendChild(div);
        }
        map.controls[google.maps.ControlPosition.RIGHT_TOP].push(legend);
    	var idcounter=0;
	    for(i=0;i<locations.length;i++){
	    	var listitem = document.createElement("li");
	    	listitem.className="sidebar-list ui-sortable-handle";
	    	listitem.style="background:#1b1e24;cursor:pointer;";
	    	var itemname = document.createElement("span");
	    	itemname.innerHTML = "Day "+(i+1);
	    	itemname.className = "itemname";
	    	listitem.appendChild(itemname);
	    	list.appendChild(listitem);
	    	itemname.style = "color:white;font-size:1.5vw;margin-left:10%";
	    	for(j=0;j<locations[i].length;j++){
		    	var listitem = document.createElement("li");
		    	listitem.className="sidebar-list ui-sortable-handle";
		    	listitem.style="cursor:pointer;";
		    	listitem.id = idcounter;
		    	bindListener(gmarkers[listitem.id],listitem);
		    	idcounter++;
		    	var itemname = document.createElement("span");
		    	itemname.innerHTML = locations[i][j][0];
		    	itemname.className = "itemname";
		    	var image = document.createElement("img");
		    	image.className = "tn-img";
		    	image.src=locations[i][j][3];
		    	listitem.appendChild(image);
		    	listitem.appendChild(itemname);
		    	list.appendChild(listitem);

		    }
	    }
    	// console.log(markers);
     //    var uluru = {lat: markers[0][1], lng: markers[0][2]};
     //    var map = new google.maps.Map(document.getElementById('map'), {
     //      zoom: 10,
     //      center: uluru
     //    });
     //    var marker = new google.maps.Marker({
     //      position: uluru,
     //      map: map
        
     //    });
      }
      function bindListener(marker,element) {
	    	element.addEventListener("click", function(){
			  	google.maps.event.trigger(marker, 'click');
		    });
	  } 
      function bindInfoWindow(marker, map, infowindow, html) {
	    	marker.addListener('click', function() {
	        infowindow.setContent(html);
	        infowindow.open(map, this);
	    });
	  } 
      function pinSymbol(color) {
	    return {
	        path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
	        fillColor: color,
	        fillOpacity: 1,
	        strokeColor: '#000',
	        strokeWeight: 2,
	        scale: 1,
	    };
	  }
	  function calcRoute(waypoints,renderer,map) {
		  // var selectedMode = document.getElementById('mode').value;
		  waypts=[];
		  for(var i=1;i<waypoints.length-1;i++){
		  	waypts.push(
		  	{
		  		location : new google.maps.LatLng(waypoints[i][1], waypoints[i][2]),
		  		stopover: true
		  	});
		  }
		  console.log();
		  var request = {
	      origin: new google.maps.LatLng(waypoints[0][1], waypoints[0][2]),
	      destination: new google.maps.LatLng(waypoints[waypoints.length-1][1], waypoints[waypoints.length-1][2]),
	      waypoints:waypts,
	      // Note that Javascript allows us to access the constant
	      // using square brackets and a string value as its
	      // "property."
	      travelMode: google.maps.TravelMode['DRIVING']
  	 	  };
		  directionsService.route(request, function(response, status) {
	      if (status == 'OK') {
		      renderer.setDirections(response);
		  }
		  else{
		  	 sleep(1000);
		  	 setTimeout(function() {
                directionsService.route(request, function(response, status) {
			      if (status == 'OK') {
				      renderer.setDirections(response);
				  }
				});
            },0);

		  }
		  });
	  }
	  function sleep(miliseconds) {
		   var currentTime = new Date().getTime();

		   while (currentTime + miliseconds >= new Date().getTime()) {
		   }
		}
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg5aW83Iq_iMB8ZRu-qhnox6-SQ9JM2-Q&callback=initMap">
</script>
@endsection('scripts')
@section('styles')
<style type="text/css">
  .sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  .sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; }
  .sortable li span { position: absolute; margin-left: -1.3em; }
</style>
@endsection