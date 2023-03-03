

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

    //woocommerce cart count
    var woocommerce_cart_count = Cookies.get('woocommerce_items_in_cart');
    if(woocommerce_cart_count != null) {
      $('.show-cart-count').addClass('is-active');
    }

    //update course options when using filter on change instead of using submit
    $(document).on('change','.wpfFilterContent select',function(e) {
      $('select').niceSelect('update'); //trigger nice select js plugin to update select boxes
      setTimeout(function() {
          $('.wpfFilterButton').trigger('mousedown');
      },100);
    });

    //Podcast Hoverintent config
    var config2 = {
      sensitivity: 3,
      timeout: 0,
      over : function(e){ 
        $( this ).addClass( 'is-active' );  
      },  
      out : function(){ 
        $( this ).removeClass( 'is-active' );  
       }
    }
    $('.podcast-links a').hoverIntent( config2 );

    //slick testimonials, get each testiminal band and set slick for each one
    $('section.testimonials_slider,section.testimonials').each(function() {
      if($(this).find('.testimonials-slider').length) {
        var id = '#' + $(this).attr('id');
        //slider tiself
        $(id + ' .testimonials-slider .slider').slick({
          dots: false,
          arrows: true,
          infinite: true,
          speed: 300,
          slidesToShow: 1,
          adaptiveHeight: false,
          autoplay: true,
          autoplaySpeed: 5000,
          asNavFor: id + ' .testimonials-slider .slider-nav',
        });
        //nav for slider so we can place it outside the container for vertical alignment
        $(id + ' .testimonials-slider .slider-nav').slick({
          dots: true,
          arrows: false,
          infinite: true,
          speed: 300,
          slidesToShow: 1,
          adaptiveHeight: false,
          asNavFor: id + ' .testimonials-slider .slider',
          autoplay: true,
          autoplaySpeed: 5000
        });
      }
    });

    //Show more testimonials when in list
    $('.testimonials-list .show-more').on('click',function(e) {
          var $this = $(this);
          var testimonialsParent = $this.parent();
          var totalrevs = testimonialsParent.find('.testimonial').length;
          var show = $this.attr('data-show'); //default 3
          show = +show + 3;
          //alert(show);
          $this.attr('data-show',show);
          var count = 0;
          while (count < show) {
              testimonialsParent.find('.testimonial:nth-of-type('+count+')').fadeIn();
              count = +count + 1;
          }
          if(show > totalrevs) {
            $this.hide();
          }
      });
      
    

    //Count data and statistics
    /*
    let decimalPlaceCount = val.length - 1 - val.indexOf('.'); //minus one because the decomal counts as part of the length of the number
				let options = {
					decimalPlaces: decimalPlaceCount
				};
				let countUpVal = parseFloat(val);
				var counter = new countUp.CountUp(id, countUpVal, options);
        */
    $('.data.use-counter').each(function() {
      var id = $(this).find('.number').attr('id');
      //console.log);
      var val = $('#'+id).text();
      //var countUp = new CountUp(div,number,{ enableScrollSpy: true })
      if(val.indexOf('.') !== -1) { //different logic for decimal points
				let decimalPlaceCount = val.length - 1 - val.indexOf('.'); //minus one because the decomal counts as part of the length of the number
				let options = {
					decimalPlaces: decimalPlaceCount,
          enableScrollSpy: true,
          scrollSpyOnce: true,
				};
				let countUpVal = parseFloat(val);
				var counter = new countUp.CountUp(id, countUpVal, options);
			} else if(val.indexOf(',') !== -1) { //remove comma and output as normal
				val = val.replace(/\,/g,'');
				let countUpVal = parseInt(val);
        let options = {
          enableScrollSpy: true,
          scrollSpyOnce: true,
				};
				var counter = new countUp.CountUp(id, countUpVal, options);
			} else { //remove the separator (comma) from output
				let options = {
					separator: '',
          enableScrollSpy: true,
          scrollSpyOnce: true,
				};
				let countUpVal = parseInt(val);
				var counter = new countUp.CountUp(id, countUpVal, options);
			}
      if (!countUp.error) {
        //counter.start();
      } else {
        console.error(countUp.error);
        $('#'+id).text(val)
      }
    });

    //convert acf
    /*if($('.acf-converter-pagination .next').length) {
      let url = $('.acf-converter-pagination .next a').attr('href');
      window.location = url;
    }*/

    $('#sticky-nav .toggle').on('click',function(){
      $('#sticky-nav').toggleClass('is-active');
    });

    var chatWindow = '';
    $('.openchat').on('click',function(e) {
      e.preventDefault();
      chatWindow = open(theme_js.chat_url,'_blank');
    });

    //Exit Site Functionality
    $('.exitsite').on('click',function(e) {
      e.preventDefault();
      chatWindow.close();
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