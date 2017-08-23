$(document).ready(function(){
    $("#search").keyup(function(){
        var filter = $(this).val();
        $(".sidebar-list").each(function(){
            if ($(this).find('.itemname').text().search(new RegExp(filter, "i")) < 0) {
                $(this).css('display', 'none');
            } else {
                $(this).show();
            }
        });
    });
});