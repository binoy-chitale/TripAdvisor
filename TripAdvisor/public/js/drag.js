$( function() {
  $( ".sortable" ).sortable({
    connectWith: ".sortable",
    tolerance: 'pointer',
    helper:'clone',
    start:function(event, ui){
    },
    update : function(event,ui){
      var cancelled=0;
      if(ui.sender!=null){
        var lastendtime = ui.item.parent()[0].lastElementChild.getElementsByClassName("endtime")[0].innerHTML;
        if(lastendtime < "10:00" && lastendtime >= "01:00" && !$(this).hasClass("side-sortable")){
             ui.sender.sortable('cancel');
            changeTimes(ui.sender);
             cancelled=1;
        }
      }
      if(!ui.item.hasClass("sidebar-list") && $(this).hasClass("side-sortable")) {
    		 ui.sender.sortable('cancel');
         changeTimes(ui.sender);
         cancelled=1;
    	}
      if(ui.item.hasClass("sidebar-list") && cancelled!=1){
        if(ui.sender!=null){
          $clone = ui.sender[0].appendChild(ui.item.clone()[0]);
        }
      }
      if(ui.item.hasClass("sidebar-list") && !$(this).hasClass("side-sortable") && cancelled==0) {
         // ui.item.removeClass("sidebar-list");
         // ui.item.addClass("ui-state-default", "day-item", "ui-sortable-handle");
         ui.item.attr("class","ui-state-default day-item ui-sortable-handle");
         current = ui.item[0];
         var image = current.getElementsByClassName("tn-img");
         image[0].style ="height: 100%;width: 100%; max-height: 100px;max-width: 100px;";
         image[0].className = "";
         var startend = current.getElementsByClassName("startend");
         startend[0].style = "display:inline";
         var starttime = current.getElementsByClassName("starttime");
         starttime[0].style = "display:inline;";
         var endtime = current.getElementsByClassName("endtime");
         endtime[0].style = "display:inline;";
         var endtime = current.getElementsByClassName("duration");
         endtime[0].style = "display:none;";
      }
    	if(!$(this).hasClass("side-sortable")){
        var listitems = $(this);
      	var starttimes = listitems[0].getElementsByClassName("starttime");
      	var endtimes = listitems[0].getElementsByClassName("endtime");
      	var itemnames = listitems[0].getElementsByClassName("itemname");
        var latitudes = listitems[0].getElementsByClassName("lat");
        var longitudes = listitems[0].getElementsByClassName("lon");
      	var currentTime = 0;
        var travelduration=[];
        travelduration[0]=0;
        for (var i = 1; i < latitudes.length; i++) {
          travelduration[i]=calculateTime(latitudes[i-1].innerHTML,longitudes[i-1].innerHTML,latitudes[i].innerHTML,longitudes[i].innerHTML); 
        };
        var traveltime=0;
        var j =0;
        for (var i = 0; i < starttimes.length; i++) {
        	var starttime = starttimes[i]; 
        	var endtime = endtimes[i];
        	var itemname = itemnames[i];        
          if(!itemname.innerHTML.includes("Lunch")){
            traveltime = travelduration[j];
            j++;
          }
          else traveltime=0;
          currentTime = updateTimeTravel(currentTime,starttime,endtime,itemname,traveltime);  
    	  }	
      }
    }
  });
  $( ".sortable" ).disableSelection();
});
function initializeTime(){
	return "10:00";
}
function updateTimes(currentTime,starttime,endtime,itemname){
	if(currentTime===0){
    		currentTime = initializeTime();
  }
  else{
   		var temp = new Date.parseExact(currentTime,"HH:mm");
    		if(!(itemname.innerHTML.toUpperCase()==="LUNCH")) {
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
  var newendtime = newstarttime.addHours(duration);
  endtime.innerHTML = newendtime.toString("HH:mm");
	currentTime = newendtime.toString("HH:mm");
  return currentTime;
}
function updateTimeTravel(currentTime,starttime,endtime,itemname,travelduration){
  if(currentTime===0){
    currentTime = initializeTime();
  }
  else{
    var temp = new Date.parseExact(currentTime,"HH:mm");
    temp.addMinutes(travelduration);
    addTravelDiv(itemname,travelduration);
    currentTime = temp;
  }
  var oldstarttime = new Date.parseExact(starttime.innerHTML,"HH:mm");
  var oldendtime = new Date.parseExact(endtime.innerHTML,"HH:mm");
  var newstarttime = new Date.parseExact(currentTime.toString("HH:mm"),"HH:mm");
  starttime.innerHTML = newstarttime.toString("HH:mm");
  var duration = Math.abs(oldendtime - oldstarttime) / 36e5;
  if(duration > 12){
    duration = 24-duration;
  }
  var newendtime = newstarttime.addHours(duration);
  endtime.innerHTML = newendtime.toString("HH:mm");
  currentTime = newendtime.toString("HH:mm");
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
          latlon.push(listitems[j].getElementsByTagName("img")[0].src);
      }
      if(latlon.length!=0){
        daylocations.push(latlon);
      }
    }
    locations.push(daylocations);
  }
  localStorage['locations'] = JSON.stringify(locations);
  var dest = document.getElementById("dest").innerHTML;
  location.href = "/plot/"+dest;
});
  
function changeTimes(sender){
  var listitems = sender;
  var starttimes = listitems[0].getElementsByClassName("starttime");
  var endtimes = listitems[0].getElementsByClassName("endtime");
  var itemnames = listitems[0].getElementsByClassName("itemname");
  var latitudes = listitems[0].getElementsByClassName("lat");
  var longitudes = listitems[0].getElementsByClassName("lon");  
  var currentTime = 0;
  var travelduration=[];
  travelduration[0]=0;
  for (var i = 1; i < latitudes.length; i++) {
    travelduration[i]=calculateTime(latitudes[i-1].innerHTML,longitudes[i-1].innerHTML,latitudes[i].innerHTML,longitudes[i].innerHTML); 
  };
  var traveltime=0;
  var j =0;
  for (var i = 0; i < starttimes.length; i++) {
    var starttime = starttimes[i]; 
    var endtime = endtimes[i];
    var itemname = itemnames[i];
    if(!itemname.innerHTML.includes("Lunch")){
      traveltime = travelduration[j];
      j++;
    }
    else traveltime=0;
    currentTime = updateTimeTravel(currentTime,starttime,endtime,itemname,traveltime);
  }
}

function calculateTime(lat1, lon1, lat2, lon2) {
  var radlat1 = Math.PI * lat1/180;
  var radlat2 = Math.PI * lat2/180;
  var theta = lon1-lon2;
  var radtheta = Math.PI * theta/180;
  var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
  dist = Math.acos(dist);
  dist = dist * 180/Math.PI;
  dist = dist * 60 * 1.1515;
  dist = dist * 1.609344; 
  var time = dist*60/4.28;
  return Math.round(time);
}
function addTravelDiv(itemname,travelduration){
  var parentDiv = (itemname.parentNode).parentNode;
  var list = parentDiv.parentNode;
  var previous = parentDiv.previousElementSibling;
  if(previous.classList.contains("minutes")){
    previous.remove();
  }
  var previous = parentDiv.previousElementSibling;
  if(!previous.classList.contains("minutes") && previous.getElementsByClassName("itemname")[0].innerHTML.toUpperCase() != "LUNCH" && parentDiv.getElementsByClassName("itemname")[0].innerHTML.toUpperCase() != "LUNCH"){
    var traveltime = document.createElement("li");
    traveltime.className = "ui-state-default day-item minutes";
    var travelico = document.createElement("i");
    travelico.className = "fa fa-automobile";
    traveltime.appendChild(travelico);
    var text =document.createElement("a");
    text.innerHTML = " "+travelduration+" minutes";
    traveltime.appendChild(text);
    list.insertBefore(traveltime, parentDiv);
  }
  else{
    if(!previous.classList.contains("minutes") && previous.getElementsByClassName("itemname")[0].innerHTML.toUpperCase() == "LUNCH"){
      var traveltime = document.createElement("li");
      traveltime.className = "ui-state-default day-item minutes";
      var travelico = document.createElement("i");
      travelico.className = "fa fa-automobile";
      traveltime.appendChild(travelico);
      var text =document.createElement("a");
      text.innerHTML = " "+travelduration+" minutes";
      traveltime.appendChild(text);
      list.insertBefore(traveltime, parentDiv);
    }
  }
}
