jQuery(document).ready(function ($) {
    $(".share-text a").click(function () {
        $(".share-popup").toggle();
    });
});

jQuery(document).ready(function ($) {
    $(".openmenu").click(function () {
        $("#menu-wise-main-menu-top-1").toggle();
    });
});

function getaway() {
      // Get away right now
      window.open("http://weather.com", "_newtab");
      // Replace current site with another benign site
      window.location.replace('http://weather.com');
    }

    jQuery(function($) {

      $("#get-away").on("click", function(e) {
        getaway();
      });

    $("#get-away a").on("click", function(e) {
        // allow the link to work
        e.stopPropagation();
      });

      $(document).keyup(function(e) {
        if (e.keyCode == 27) { // escape key
          getaway();
        }
      });

   });