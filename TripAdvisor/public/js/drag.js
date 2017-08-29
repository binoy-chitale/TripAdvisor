
$( function() {
    console.log("here");
    $( ".sortable" ).sortable({
  connectWith: ".sortable",
  tolerance: 'pointer',
  helper:'clone',
  start:function(event, ui){
    

  },
  update : function(event,ui){
      var cancelled=0;
      if(ui.sender!=null){
        var lastendtime = ui.item.parent()[0].lastChild.getElementsByClassName("endtime")[0].innerHTML;
        console.log(lastendtime);
        if(lastendtime < "10:00" && lastendtime >= "01:00" && !$(this).hasClass("side-sortable")){
             ui.sender.sortable('cancel');
            changeTimes(ui.sender);
             cancelled=1;
        }
      }
    if(!ui.item.hasClass("sidebar-list") && $(this).hasClass("side-sortable")) {
  		 // ui.item.removeClass("sidebar-list");
  		 // ui.item.addClass("ui-state-default", "day-item", "ui-sortable-handle");
       // ui.item.attr("class","sidebar-list ui-sortable-handle");
       // current = ui.item[0];
       // var wrapper = current.getElementsByClassName("img-wrapper");
       // wrapper[0].style="display:inline;";
       // var duration = current.getElementsByClassName("duration");
       // duration[0].style="display:inline;";
       // var startend = current.getElementsByClassName("startend");
       // startend[0].style="display:none;";
       // var image = current.getElementsByTagName("img");
       // image[0].className = "tn-img";
       
       ui.sender.sortable('cancel');
       changeTimes(ui.sender);
       cancelled=1;
  	}
    if(ui.item.hasClass("sidebar-list") && cancelled!=1){
      console.log(ui.item.clone());
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
       image[0].style ="height: 100%;width: 100%;border-radius: 10px;padding: 5px 10px 5px 10px; max-height: 100px;max-width: 100px;";
       image[0].className = "";
       var starttime = current.getElementsByClassName("starttime");
       starttime[0].style = "display:inline; font-size:0.7vw";
       var endtime = current.getElementsByClassName("endtime");
       endtime[0].style = "display:inline;font-size:0.7vw";
       var endtime = current.getElementsByClassName("duration");
       endtime[0].style = "display:none;";
    }
  	if(!$(this).hasClass("side-sortable")){
      var listitems = $(this);
    	var starttimes = listitems[0].getElementsByClassName("starttime");
    	var endtimes = listitems[0].getElementsByClassName("endtime");
    	var itemnames = listitems[0].getElementsByClassName("itemname");
    	var currentTime = 0;
      for (var i = 0; i < starttimes.length; i++) {
      	var starttime = starttimes[i]; 
      	var endtime = endtimes[i];
      	var itemname = itemnames[i];
      	console.log(starttime);
        currentTime = updateTimes(currentTime,starttime,endtime,itemname);
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
      daylocations.push(latlon);
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
    var currentTime = 0;
    for (var i = 0; i < starttimes.length; i++) {
      var starttime = starttimes[i]; 
      var endtime = endtimes[i];
      var itemname = itemnames[i];
      console.log(starttime);
      currentTime = updateTimes(currentTime,starttime,endtime,itemname);
    }
}
