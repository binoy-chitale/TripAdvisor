$(document).on("click", ".open-Details", function () {
    var details = $(this).data('obj');
    console.log(details);
    jQuery(".modal-image").attr('src',details.images);
    $(".modal-title").text(details.name);
    var description = details.description;
    var re = new RegExp(' *reviews$',);
    if (re.test(description)){
    	description = " - ";
    }
    $(".modal-description").text(description);

    $(".modal-rank").text(details.rank);
    var address = " "; 
    	if(details.address.street_address){
    		address = address + details.address.street_address;
    	}
    	if(details.address.locality){
    		address = address + details.address.locality;
    	}
    	if(details.address.country){
    		address = address + details.address.country;
    	}
    $(".modal-address").text(address);


   	var stars = details.stars;
   	stars = stars*10;
   	console.log(stars);
   	stars = "modal-stars-container stars-"+stars;
   	$(".modal-stars").attr('class', stars)
   	$(".modal-stars-container").attr('id', "stars");
   	$(".modal-stars-container").text("★★★★★");
   	
   	var phone = details.phone;
   	if(!phone)
      	phone = " - ";
    else phone = " "+phone
    $(".modal-phone").text(phone); 


});

    

