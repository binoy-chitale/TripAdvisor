$(document).ready(function(){
    $("#search").keyup(function(){
        var filter = $(this).val();
        $(".search").each(function(){
            if ($(this).find('#text').text().search(new RegExp(filter, "i")) < 0) {
                $(this).css('display', 'none');
            } else {
                $(this).show();
            }
        });
    });
});