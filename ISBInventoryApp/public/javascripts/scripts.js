$(document).ready(function(){
    $(".inventorycell").hover(function(){
        $(this).find(".editpencil").css("display", "inline-block");
        },function(){
        $(this).find(".editpencil").css("display", "none");
    });

});
