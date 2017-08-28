$( function() {
    console.log("here");
    $( ".sortable" ).sortable({
  connectWith: ".sortable",
  tolerance: 'pointer',
  helper:'clone',
  start:function(event, ui){
     $clone = ui.item.clone().insertBefore(ui.item);
  },
  update : function(event,ui){
    if(!ui.item.hasClass("sidebar-list") && $(this).hasClass("side-sortable")) {
  		 ui.sender.sortable('cancel');
  	}
    if(ui.item.hasClass("sidebar-list") && !$(this).hasClass("side-sortable")) {
       // ui.item.removeClass("sidebar-list");
       // ui.item.addClass("ui-state-default", "day-item", "ui-sortable-handle");
       ui.item.attr("class","ui-state-default day-item ui-sortable-handle");
       current = ui.item[0];
       var image = current.getElementsByClassName("tn-img");
       image[0].style ="height: 30vh;width: 100%;border-radius: 2px;";
       image[0].className = "";
       var starttime = current.getElementsByClassName("starttime");
       starttime[0].style = "display:inline; font-size:0.9vw";
       var endtime = current.getElementsByClassName("endtime");
       endtime[0].style = "display:inline;font-size:0.9vw";
       var endtime = current.getElementsByClassName("duration");
       endtime[0].style = "display:none;";
    }
  	var listitems = $(this);
  	var starttimes = listitems[0].getElementsByClassName("starttime");
  	var endtimes = listitems[0].getElementsByClassName("endtime");
  	var itemnames = listitems[0].getElementsByClassName("itemname");
  	var currentTime = 0;
    for (var i = 0; i < starttimes.length; i++) {
    	var starttime = starttimes[i]; 
    	var endtime = endtimes[i];
    	var itemname = itemnames[i];
    	currentTime = updateTimes(currentTime,starttime,endtime,itemname);
      if(currentTime < "10:00" && currentTime > "03:00" && !$(this).hasClass("side-sortable")){
         ui.sender.sortable('cancel');
      }
	  }
  	
  }
});
    $( ".sortable" ).disableSelection();
  } );
function initializeTime(){
	return "10:00";
}
function updateTimes(currentTime,starttime,endtime,itemname){
	if(currentTime===0){
    		currentTime = initializeTime();
  }
  else{
   		var temp = new Date.parseExact(currentTime,"HH:mm");
    		if(!(itemname.innerHTML.toUpperCase()==="LUNCH BREAK")) {
          console.log(itemname);
    			currentTime = temp.addHours(1).toString("HH:mm");
    		}
  }
	var oldstarttime = new Date.parseExact(starttime.innerHTML,"HH:mm");
	var oldendtime = new Date.parseExact(endtime.innerHTML,"HH:mm");
	var newstarttime = new Date.parseExact(currentTime,"HH:mm");
	starttime.innerHTML = newstarttime.toString("HH:mm");
	var duration = Math.abs(oldendtime - oldstarttime) / 36e5;
  if(duration > 12){
    duration = 24-duration;
  }
  // console.log(newstarttime.toString("HH:mm")+">");
  var newendtime = newstarttime.addHours(duration);
  endtime.innerHTML = newendtime.toString("HH:mm");
	currentTime = newendtime.toString("HH:mm");
	// console.log(newendtime.toString("HH:mm"));
  return currentTime;

}
$("#plot").click(function(){
  var all_lists = document.getElementsByClassName("daycolumn");
  var locations=[];
  for(i=0;i<all_lists.length;i++){
    var listitems = all_lists[i].getElementsByTagName("li");
    var daylocations=[]
    for(j=0;j<listitems.length;j++){
      var latlon=[]
      if(listitems[j].getElementsByClassName("lat").length != 0 && listitems[j].getElementsByClassName("lon").length != 0){
          latlon.push(listitems[j].getElementsByClassName("itemname")[0].innerHTML);
          latlon.push(listitems[j].getElementsByClassName("lat")[0].innerHTML);
          latlon.push(listitems[j].getElementsByClassName("lon")[0].innerHTML);
      }
      daylocations.push(latlon);
    }
    locations.push(daylocations);
  }
  localStorage['locations'] = JSON.stringify(locations);
  var dest = document.getElementById("dest").innerHTML;
  location.href = "/plot/"+dest;
});

function calculateDistance(lat1, lon1, lat2, lon2){      
  var theta = lon1 - lon2;
  var dist = Math.sin(deg2rad(lat1)) * Math.sin(deg2rad(lat2)) +  Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * Math.cos(deg2rad(theta));
  dist = Math.acos(dist);
  dist = rad2deg(dist);
  var miles = dist * 60 * 1.1515;
  var km = miles*1.609344;
  return km;
}

function deg2rad (angle) {
  return angle * 0.017453292519943295 // (angle / 180) * Math.PI;
}

function rad2deg(angle){
  return angle * 57.29577951308232 // angle / Math.PI * 180
}