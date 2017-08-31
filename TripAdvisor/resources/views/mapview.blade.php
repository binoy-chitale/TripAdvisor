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
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	window.onLoad = function(){	
      
  	};
</script>
<script>
      var markers =[];
      var directionsDisplay;
      var directionsService;
      function initMap() {
        var colors = ["http://maps.google.com/mapfiles/ms/icons/red-dot.png","http://maps.google.com/mapfiles/ms/icons/blue-dot.png","http://maps.google.com/mapfiles/ms/icons/green-dot.png","http://maps.google.com/mapfiles/ms/icons/orange-dot.png","http://maps.google.com/mapfiles/ms/icons/yellow-dot.png","http://maps.google.com/mapfiles/ms/icons/purple-dot.png","http://labs.google.com/ridefinder/images/mm_20_gray.png","http://labs.google.com/ridefinder/images/mm_20_white.png","http:// labs.google.com/ridefinder/images/mm_20_blue.png","http://labs.google.com/ridefinder/images/mm_20_black.png"];	 
	    var strokeColors = ["red","blue","green","yellow","black","grey","orange","purple"];
	    var locations = JSON.parse(localStorage['locations']);
	    var list = document.getElementsByClassName("side-sortable")[0];
	    list.style="cursor:pointer";
	    directionsDisplay = new google.maps.DirectionsRenderer;
	    directionsService = new google.maps.DirectionsService;
	    for(i=0;i<locations.length;i++){
	    	var listitem = document.createElement("li");
	    	listitem.className="sidebar-list ui-sortable-handle";
	    	listitem.style="background:#1b1e24;";
	    	var itemname = document.createElement("span");
	    	itemname.innerHTML = "Day "+(i+1);
	    	itemname.className = "itemname";
	    	listitem.appendChild(itemname);
	    	list.appendChild(listitem);
	    	itemname.style = "color:white;font-size:2vw;margin-left:10%";
	    	for(j=0;j<locations[i].length;j++){
		    	var listitem = document.createElement("li");
		    	listitem.className="sidebar-list ui-sortable-handle";
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
	    var map = new google.maps.Map(document.getElementById('map'), {
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
			directionRenderer.setMap(map);
			calcRoute(markers.slice(lastIndex,markers.length),directionRenderer,map);
			lastIndex=markers.length;
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
        // google.maps.event.addListener(marker, 'click', (function(marker, i) {
        //     return function() {
        //         infoWindow.setContent(infoWindowContent[i][0]);
        //         infoWindow.open(map, marker);
        //     }
        // })(marker, i));
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
		  console.log(waypoints);
		  waypts=[];
		  for(var i=1;i<waypoints.length-1;i++){
		  	waypts.push(
		  	{
		  		location : new google.maps.LatLng(waypoints[i][1], waypoints[i][2]),
		  		stopover: true
		  	});
		  }
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
		  });
		 
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