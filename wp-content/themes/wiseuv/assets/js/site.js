

(function($) {
	$(document).ready(function() {

    //AOS init
    AOS.init({
      offset: 120,
      duration: 400,
      once: false, //or true
      disable: 'phone' //false, phone, tablet, mobile
    });

    //Set window width and tablet width
    var windowWidth = $(window).width();
    var tabletWidth = 1184;
    $(window).on('resize', function() {
      //reset global window width on resize
      windowWidth = $(window).width();
      //remove active for nav so site goes back to normal on desktop
      if(windowWidth > tabletWidth && $('.content').hasClass('is-inactive')) {
        $('body, .nav-toggle, #site-navigation, .header').removeClass('is-active');
        $('.content').removeClass('is-inactive');
      }
    });

    //Menu hoverintent config
    var config = {
      sensitivity: 6,
      timeout: 150,
      over : function(e){ 
        if(windowWidth > tabletWidth) { //74 rem, defined in variables.scss
          $( this ).addClass( 'is-active' );  
        }
      },  
      out : function(){ 
        if(windowWidth > tabletWidth) { //74 rem, defined in variables.scss
          $( this ).removeClass( 'is-active' );  
        }
       }
    }
    $('.menu-item-has-children').hoverIntent( config );
    
    //mobile nav toggle
    $('.nav-toggle').click(function() {
        $('body').toggleClass('is-active');
        $(this).toggleClass('is-active');
        $('#site-navigation,.header').toggleClass('is-active');
        $('.content').toggleClass('is-inactive');
    });

    //hide nav when clicking outside it
    $(document).on('click','.content.is-inactive', function() {
      $(this).toggleClass('is-inactive');
      $('body, .nav-toggle, #site-navigation, .header').toggleClass('is-active');
    });
    
    //show submenu when clicking mobile dropdown
    $(document).on('click','.menu-toggle',function(e) {
      e.preventDefault();
      $(this).parent().parent().toggleClass('is-active');
    });

    //Add active class to menu items when tabbing
    $(document).on('keyup','.menu-item-has-children',function (e) {
      if (e.keyCode == 9) {    
          $(this).addClass('is-active');
      }
    });

    $(document).on('click','.menu-item a[href="#"]',function(e) {
      if(e.target === e.currentTarget) {
        e.preventDefault();
        $(this).parent().toggleClass('is-active');        
      }

    });

    //remove prior active class when tabbing
    $(document).on('keyup','.menu-item a',function (e) {
      if (e.keyCode == 9) {    
        if(!$(this).parent().parent().parent().hasClass('menu-item-has-children')) {
          $('.menu-item-has-children').removeClass('is-active');  
        }
      }
    });

    //remove active classing when tabbing
    $(document).mouseup(function(e){
      var container = $('.menu-item-has-children');
      if (!container.is(e.target) && container.has(e.target).length === 0) {
        $('.menu-item-has-children.is-active').removeClass('is-active');  
      }
    });

    $('#sticky-nav .toggle').on('click',function(){
      $('#sticky-nav').toggleClass('is-active');
    });

    var chatWindow = '';
    var chatWindowOpen = false;
    $('.openchat,a[href="'+theme_js.chat_url+'"]').on('click',function(e) {
      e.preventDefault();
      chatWindowOpen = true;
      chatWindow = open(theme_js.chat_url,'_blank');
    });

    //Exit Site Functionality
    $('.exitsite').on('click',function(e) {
      e.preventDefault();
      if(chatWindowOpen) {
        chatWindow.close();
      }
      window.location.replace(theme_js.exit_url);
    });
    //Pressing Esc also exists site
    $(document).keyup(function(e) {
      if (e.keyCode == 27) { // escape key
        chatWindow.close();
        window.location.replace(theme_js.exit_url);
      }
    });

  }); //Close doc ready
})(jQuery); // Fully reference jQuery after this point.