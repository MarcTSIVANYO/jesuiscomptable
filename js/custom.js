(function($) {
	
	//Cache jQuery Selector
	var $carousel		= $('.carousel'),
		$preloader		= $('.loder-overlay'),
		$document		= $(document),
		$mainwindow		= $(window),
		$headerlength 	= $('.main-header'),
		$teammember		= $('.members_slide'),
		$testimonial	= $('.testimonials-carousel'),
		$brandlogo		= $('.sponsors-slider'),
		$navfix			= $(".navbar-fixed-top"),
		$placeholder 	= $('.preloader'),
		$tabfilter		= $('.filter-list')
		
	
	//Main Slider Duration
	$carousel.carousel({
	  interval: 4000
	})	
	
	//Hide Preloader
	$mainwindow.on('load',function(){
		$preloader.addClass('hide');
	});
	
		
	//jQuery for page scrolling feature - requires jQuery Easing plugin
	$document.on('click', 'a.call-section', function(event) {
		$navanchor = $(this),
		$('html, body').stop().animate({
			scrollTop: $($navanchor.attr('href')).offset().top
		}, 1500, 'easeInOutExpo');
		event.preventDefault();
	});
	
	
	//Animate Content Loading
	var $animation_elements = $('.animate');
	
	function check_if_in_view() {
	  var window_height = $mainwindow.height();
	  var window_top_position = $mainwindow.scrollTop();
	  var window_bottom_position = (window_top_position + window_height);
	
	  $.each($animation_elements, function() {
		var $element = $(this);
		var element_height = $element.outerHeight();
		var element_top_position = $element.offset().top;
		var element_bottom_position = (element_top_position + element_height);
	
		//check to see if this current container is within viewport
		if ((element_bottom_position >= window_top_position) &&
			(element_top_position <= window_bottom_position)) {
			$element.removeClass('animate');
			
		} 
	  });
	}
	
	$mainwindow.on('scroll resize', check_if_in_view);
	$mainwindow.trigger('scroll');
		
	
	// Number Counter animation
	
	var $count_elements = $('.increase');
	
	function if_visible() {
		
		var window_height = $mainwindow.height();
		var window_top_position = $mainwindow.scrollTop();
		var window_bottom_position = (window_top_position + window_height);
		
		$.each($count_elements, function() {
			var $element = $(this);
			var element_height = $element.outerHeight();
			var element_top_position = $element.offset().top;
			var element_bottom_position = (element_top_position + element_height);
		
			//check to see if this current container is within viewport
			if ((element_bottom_position >= window_top_position) &&
				(element_top_position <= window_bottom_position)) {
					
					
				// start all the timers
				$element.children('.experience').each(count);
				
				function count(options) {
					var $this = $(this);
					options = $.extend({}, options || {}, $this.data('countToOptions') || {});
					$this.countTo(options);
				}
				
				$element.children('.experience').removeClass('experience');
				
				
			} 
		  });
		}
		
		$mainwindow.on('scroll resize', if_visible);
		$mainwindow.trigger('scroll');
	
	
	//set skill building height
	$('.per span').each(function(){ 
		var size = $(this).attr('data-to');
		$(this).parents('.skill_percent').css('height', size+'%');
	});
	
	
	
	//Preloader For Gallery Popup
	function handlePreloader() {
		if($placeholder.length){
			$placeholder.delay(500).fadeOut(500);
		}
	}
	
	handlePreloader();
	
	
	
	//Team member grid slider settings
	if ($teammember.length) {
		$teammember.owlCarousel({
			loop:true,
			margin:30,
			nav:true,
			smartSpeed: 500,
			autoplay: false,
			navText: [ '<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>' ],
			responsive:{
				0:{
					items:1
				},
				767:{
					items:2
				},
				1024:{
					items:3
				},
				1400:{
					items:3
				}
			}
		});    		
	}
	
	
	//Testimonials Carousel Slider controlar
	if ($testimonial.length) {
		$testimonial.owlCarousel({
			loop:true,
			nav:true,
			autoplayHoverPause:false,
			autoplay: 10000,
			smartSpeed: 700,
			navText: [ '<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>' ],
			responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				760:{
					items:1
				},
				1024:{
					items:1
				},
				1100:{
					items:1
				}
			}
		});    		
	}
	
	
	//Brand logos auto slider settings
	if ($brandlogo.length) {
		$brandlogo.owlCarousel({
			loop:true,
			margin:0,
			nav:true,
			smartSpeed: 500,
			autoplay: 4000,
			navText: [ '<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>' ],
			responsive:{
				0:{
					items:1
				},
				480:{
					items:2
				},
				600:{
					items:2
				},
				800:{
					items:3
				},
				1200:{
					items:4
				}
			}
		});    		
	}
	
	
	
	// Fact Counter
	function factCounter() {
		if($('.fact-counter').length){
			$('.fact-counter .column.animated').each(function() {
		
				var $t = $(this),
					n = $t.find(".count-text").attr("data-stop"),
					r = parseInt($t.find(".count-text").attr("data-speed"), 10);
					
				if (!$t.hasClass("counted")) {
					$t.addClass("counted");
					$({
						countNum: $t.find(".count-text").text()
					}).animate({
						countNum: n
					}, {
						duration: r,
						easing: "linear",
						step: function() {
							$t.find(".count-text").text(Math.floor(this.countNum));
						},
						complete: function() {
							$t.find(".count-text").text(this.countNum);
						}
					});
				}
				
			});
		}
	}
	
	
	//LightBox / Fancybox
	if($('.lightbox-image').length) {
		$('.lightbox-image').fancybox({
			openEffect  : 'elastic',
			closeEffect : 'elastic',
			helpers : {
				media : {}
			}
		});
	}
	
	
	//Sortable Masonary with Filters
	function enableMasonry() {
		if($('.sortable-masonry').length){
	
			var winDow = $(window);
			// Needed variables
			var $container=$('.sortable-masonry .items-container');
			var $filter=$('.sortable-masonry .filter-btns');
	
			$container.isotope({
				filter:'*',
				 masonry: {
					columnWidth : 1 
				 },
				animationOptions:{
					duration:1000,
					easing:'linear'
				}
			});
			
	
			// Isotope Filter 
			$filter.find('li').on('click', function(){
				var selector = $(this).attr('data-filter');
	
				try {
					$container.isotope({ 
						filter	: selector,
						animationOptions: {
							duration: 1000,
							easing	: 'linear',
							queue	: false
						}
					});
				} catch(err) {
	
				}
				return false;
			});
	
	
			winDow.on('bind','resize', function(){
				var selector = $filter.find('li.active').attr('data-filter');

				$container.isotope({ 
					filter	: selector,
					animationOptions: {
						duration: 1000,
						easing	: 'linear',
						queue	: false
					}
				});
			});
	
	
			var filterItemA	= $('.sortable-masonry .filter-btns li');
	
			filterItemA.on('click', function(){
				var $this = $(this);
				if ( !$this.hasClass('active')) {
					filterItemA.removeClass('active');
					$this.addClass('active');
				}
			});
		}
	}
	
	enableMasonry();
	
	
	
	//Gallery With Filters List
	if($tabfilter.length){
		$tabfilter.mixItUp({});
	}
	
	
	// Elements Animation
	if($('.wow').length){
		var wow = new WOW(
		  {
			boxClass:     'wow',      // animated element css class (default is wow)
			animateClass: 'animated', // animation css class (default is animated)
			offset:       0,          // distance to the element when triggering the animation (default is 0)
			mobile:       false,       // trigger animations on mobile devices (default is true)
			live:         true       // act on asynchronously loaded content (default is true)
		  }
		);
		wow.init();
	}
	
	
	//Fix header top when page scroll
	function headerStyle() {
		if($headerlength.length){
			var windowpos = $mainwindow.scrollTop();
		}
	}

	$mainwindow	.on('scroll', function() {
		headerStyle();
		factCounter();
		if ($(".navbar-main").offset().top > 50) {
			$navfix.addClass("top-nav-collapse");
		} else {
			$navfix.removeClass("top-nav-collapse");
		}
	});
	
	

	

})(jQuery);