$( function() {
    $( ".sortable" ).sortable({
  connectWith: ".sortable",
  update : function(event,ui){
  	if(ui.item.hasClass("sidebar-list")) {
  		 // ui.item.removeClass("sidebar-list");
  		 // ui.item.addClass("ui-state-default", "day-item", "ui-sortable-handle");
  		 ui.item.attr("class","ui-state-default day-item ui-sortable-handle");
  		 current = ui.item[0];
  		 var image = current.getElementsByClassName("tn-img");
       image[0].style ="height: 15vh;width: 100%;border-radius: 2px;";
       image[0].className = "";
  		 var starttime = current.getElementsByClassName("starttime");
  		 starttime[0].style = "display:inline; font-size:0.9vw";
  		 var endtime = current.getElementsByClassName("endtime");
  		 endtime[0].style = "display:inline;font-size:0.9vw";
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
    			currentTime = temp.addHours(1).toString("HH:mm");
    		}
    }
	var oldstarttime = new Date.parseExact(starttime.innerHTML,"HH:mm");
	var oldendtime = new Date.parseExact(endtime.innerHTML,"HH:mm");
	var newstarttime = new Date.parseExact(currentTime,"HH:mm");
	starttime.innerHTML = newstarttime.toString("HH:mm");
	var duration = Math.abs(oldendtime - oldstarttime) / 36e5;
	var newendtime = newstarttime.addHours(duration);
	endtime.innerHTML = newendtime.toString("HH:mm");
	currentTime = newendtime.toString("HH:mm");
	return currentTime;

}