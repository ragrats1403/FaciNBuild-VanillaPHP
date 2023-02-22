$(function(){
  // Loader finish
  function end_loader() {
    $('#loader03').fadeOut(800);
  }
  // Show loading
  function show_load() {
    $('#loader03 .circles-to-rhombuses-spinner').fadeIn(400);
  }
  // Hide loading
  function hide_load() {
    $('#loader03 .circles-to-rhombuses-spinner').fadeOut(400);
  }
  // Display text
  function show_txt() {
    $('#loader03 .txt').fadeIn(400);
  }
 
  // Timer
  $(window).on('load', function () {
  // 1
  setTimeout(function () {
    show_load();
  }, 800)
  // 2
  setTimeout(function () {
    hide_load();
  }, 3500)
  // 3
  setTimeout(function () {
    show_txt();
  }, 4000)
  // 4
  setTimeout(function () {
    end_loader();
  }, 5000)
  })
})
 