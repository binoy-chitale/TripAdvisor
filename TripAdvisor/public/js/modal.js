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
    		address = address + details.address.street_address+" ";
    	}
    	if(details.address.locality){
    		address = address + details.address.locality+" ";
    	}
    	if(details.address.country){
    		address = address + details.address.country;
    	}
    $(".modal-address").text(address);
    
    var duration = 2;
    if(!details.duration=="")
    	duration=details.duration;
	  $(".modal-duration").text("Stay here for "+duration+" hours");

    $(".modal-stars").text(details.stars);

   	
   	var phone = " - ";
    if(details.phone[0]) 
      phone = details.phone[0];
   	if(phone.indexOf('+')!=-1)
      phone = " "+phone
    $(".modal-phone").text(phone); 

});

    

