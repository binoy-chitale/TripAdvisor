$(document).ready(function () {
    $("label").click(function(e) {
    	console.log("here");
    	 $(this).toggleClass("label_selected");
    });
    
});