$(document).ready(function() {
	$('.slideshow').slick({
		dots:true,
		autoplay: true,
		autoplaySpeed: 3000,
		adaptiveHeight: true
	});	

	$('.list-trip').slick({
		dots:true,
		// autoplay: true,
		// autoplaySpeed: 3000,
		adaptiveHeight: true,
		responsive: [
		    {
		      breakpoint: 576,
		      settings: {
		        arrows: false
		      }
		    }
    	]
	});

	function bgWhiteEvent() {
		var height = $('#HomeEvents .list-events').offset().top - $('#HomeEvents').offset().top + $('.list-events .event .img').outerHeight();

		$('#HomeEvents .bg-white').height(height);
	}

	// $(window).load(function() {
		bgWhiteEvent();
	// });

	$(window).resize(function(event) {
		bgWhiteEvent();
	});

    $('a.js-scroll-trigger').click(function(event) {
        // console.log('test');
        event.preventDefault();
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
         	var target = $(this.hash);
          	target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
          	if (target.length) {
            	$('html, body').animate({
              		scrollTop: (target.offset().top)
            	}, 1000, "easeInOutExpo");
            	return false;
          	}
        }
    });

    // Closes responsive menu when a scroll trigger link is clicked
    $('.js-scroll-trigger').click(function() {
        $('.navbar-collapse').collapse('hide');
    });

	function mobileOnlySliderEvent() {
		$('.list-events').on('init', function(event, slick){
		    $('.list-events .slick-slide').height($('.list-events .slick-track').height());
		});
		$('.list-events').slick({
			dots: true,
			mobileFirst: true,
	        slidesToShow: 1,
	        slidesToScroll: 1,
	        centerMode: true,
	        centerPadding: '80px',
			responsive: [
			    {
			      breakpoint: 360,
			      settings: {
	        		centerPadding: '40px',
			      }
			    },
			    {
			      breakpoint: 300,
			      settings: {
	        		centerPadding: '0px',
	        		arrows: false
			      }
			    },
	    	]
		});
	}

	function mobileOnlySliderPromo() {
		$('.list-promo').on('init', function(event, slick){
		    $('.list-promo .slick-slide').height($('.list-promo .slick-track').height());
		});
		$('.list-promo').slick({
			dots: true,
			mobileFirst: true,	
	        slidesToShow: 1,
	        slidesToScroll: 1,
		});
	}
	
	if(window.innerWidth < 576) {
		mobileOnlySliderEvent();
		mobileOnlySliderPromo();
	}

	$(window).resize(function(e){
	    if(window.innerWidth < 576) {
	        if(!$('.list-events').hasClass('slick-initialized')){
	            mobileOnlySliderEvent();
	        }
	        if(!$('.list-promo').hasClass('slick-initialized')){
	            mobileOnlySliderPromo();
	        }
	    }else{
	        if($('.list-events').hasClass('slick-initialized')){
	            $('.list-events').slick('unslick');
	        }
	        if($('.list-promo').hasClass('slick-initialized')){
	            $('.list-promo').slick('unslick');
	        }
	    }
	});

    if(window.location.hash) {
    	var elem = $('#' + window.location.hash.replace('#', ''));
        $('html, body').animate({
        	scrollTop: (elem.offset().top)
        }, 1000, "easeInOutExpo");
        return false;
    }

});

