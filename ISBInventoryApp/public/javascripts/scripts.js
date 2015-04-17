$(document).ready(function(){
  var saveIconOn = false;

    $(".inventorycell").hover(function(){
        $(this).find(".saveEditButton").css("display", "inline-block");
    },function(){
        $(this).find(".saveEditButton").css("display", "none");
      });

    $(".saveEditButton").click(function(e){
      $(this).toggleClass('fa-pencil fa-save');
      $(this).toggleClass('button-active');
      if(saveIconOn == true){
        //POST data to DB
      }
      saveIconOn = !saveIconOn;
      console.log(saveIconOn);
    });


});
