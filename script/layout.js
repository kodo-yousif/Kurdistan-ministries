function closing() {
  $("body").removeClass("sidebar-open").addClass("sidebar-closed");
  if ($(window).width() > 991) {
    return;
  }
  $("body").addClass("sidebar-collapse");
}

$(".cf").click(function (event) {
  if (
    event.target == $(".dammaxa1")[0] ||
    event.target == $(".dammaxa2")[0] ||
    event.target == $(".dammaxa3")[0] ||
    event.target == $(".dammaxa4")[0]
  ) {
    return;
  }

  closing();
});

$(() => {
  
  let deg = 0;
  $(".sahm-rotate").attr("deg", 0);
  $(".have-child").click(function () {
    $(this).find(".the-child").slideToggle(300);
    deg = $(this).find(".sahm-rotate").attr("deg");
    if (deg == 0) {
      deg = -90;
    } else {
      deg = 0;
    }
    $(this).find(".sahm-rotate").attr("deg", deg);
    $(this)
      .find(".sahm-rotate")
      .css({
        "-webkit-transform": `rotate(${deg}deg)`,
        "-moz-transform": `rotate(${deg}deg)`,
        transform: `rotate(${deg}deg)`,
      });
  });

  $("#side_toggle").click(function () {
    if ($(window).width() > 991) {
      $("body").toggleClass("sidebar-collapse");
      return;
    }
    $("body").removeClass("sidebar-collapse");
    $("body").addClass("sidebar-open").removeClass("sidebar-closed");
  });

  let full_window = false;
  $("#max_shasha").click(function () {

    if (full_window) {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      }

      $("#arrow_screen")
        .removeClass("fa-compress-arrows-alt")
        .addClass("fa-expand-arrows-alt");
    } else {

      if (document.documentElement.requestFullscreen) {
        document.documentElement.requestFullscreen();
      } else if (document.documentElement.webkitRequestFullscreen) {
        document.documentElement.webkitRequestFullscreen();
      } else if (document.documentElement.msRequestFullscreen) {
        document.documentElement.msRequestFullscreen();
      }
      $("#arrow_screen")
        .removeClass("fa-expand-arrows-alt")
        .addClass("fa-compress-arrows-alt");
    }

    full_window = !full_window;
  });


});
