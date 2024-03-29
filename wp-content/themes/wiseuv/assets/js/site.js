

(function($) {
	$(document).ready(function() {

    //scroll to div onload
    function scrollOnPageLoad() {
      var hashLink = window.location.hash;
        if ($(hashLink).length) {
            scroll(0, 0);
            setTimeout(scroll(0, 0), 1);
            $(function () {
                // *only* if we have anchor on the url
                // smooth scroll to the anchor id
                console.log($(window.location.hash).closest('.wise-section').attr('id'));
                var parent = $(window.location.hash).closest('.wise-section').offset().top;
                console.log(parent);
                $('html, body').animate({
                  scrollTop: parent
                }, 100);
            });
        }
    }
    
    scrollOnPageLoad();
    
    
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
      window.open(theme_js.exit_tab_url);
      window.location.replace(theme_js.exit_url);
    });
    //Pressing Esc twice also exists site
    var needtoexit = false;
    $(document).keyup(function(e) {
      if (e.keyCode == 27) { // escape key
        if(needtoexit) {
          if(chatWindowOpen) {
            chatWindow.close();
          }
          window.open(theme_js.exit_tab_url);
          window.location.replace(theme_js.exit_url);
        } else {
          needtoexit = true;
        }
      } else {
        //reset exit prompt
        needtoexit = false;
      }
    });

    //Convert text emails to mailto emails
    $(".flexible-content table td").filter(function () {
      var html = $(this).html();
      var emailPattern = /[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/g;  
      var matched_str = $(this).html().match(emailPattern);
      if ( matched_str ) {
        var text = $(this).html();
        $.each(matched_str, function (index, value) {
            text = text.replace(value,"<a href='mailto:"+value+"'>"+value+"</a>");
        });
        $(this).html(text);
        return $(this)
      }    
  });

  }); //Close doc ready
})(jQuery); // Fully reference jQuery after this point.