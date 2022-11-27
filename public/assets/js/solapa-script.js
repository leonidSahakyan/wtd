(function ($) {

	"use strict";

	function thmSwiperInit() {
		// swiper slider
		if ($(".thm-swiper__slider").length) {
			$(".thm-swiper__slider").each(function () {
				let elm = $(this);
				let options = elm.data('swiper-options');
				let thmSwiperSlider = new Swiper(elm, options);
			});
		}

	}


	//Hide Loading Box (Preloader)
	function handlePreloader() {
		if ($('.preloader').length) {
			$('.preloader').delay(200).fadeOut(500);
		}
	}


	// Add Current Class Auto
	function dynamicCurrentMenuClass(selector) {
		let FileName = window.location.href.split("/").reverse()[0];

		selector.find("li").each(function () {
			let anchor = $(this).find("a");
			if ($(anchor).attr("href") == FileName) {
				$(this).addClass("current");
			}
		});
		// if any li has .current elmnt add class
		selector.children("li").each(function () {
			if ($(this).find(".current").length) {
				$(this).addClass("current");
			}
		});
		// if no file name return
		if ("" == FileName) {
			selector.find("li").eq(0).addClass("current");
		}
	}

	if ($('.main-menu__menu-box .main-menu__navigation').length) {
		dynamicCurrentMenuClass($('.main-menu__menu-box .main-menu__navigation'));
	}



	// Update Header Style and Scroll to Top
	function headerStyle() {
		if ($('.main-header').length) {
			var windowpos = $(window).scrollTop();
			var siteHeader = $('.main-header');
			var scrollLink = $('.scroll-to-top');

			var HeaderHight = $('.main-header').height();
			if (windowpos >= HeaderHight) {
				siteHeader.addClass('fixed-header');
				scrollLink.fadeIn(300);
			} else {
				siteHeader.removeClass('fixed-header');
				scrollLink.fadeOut(300);
			}

		}
	}

	headerStyle();




	// Submenu Dropdown Toggle
	if ($('.main-header li.dropdown ul').length) {
		$('.main-header li.dropdown').append('<div class="dropdown-btn"><span class="fa fa-angle-down"></span></div>');

		//Dropdown Button
		$('.main-header li.dropdown .dropdown-btn').on('click', function () {
			$(this).prev('ul').slideToggle(500);
		});

		//Dropdown Menu / Fullscreen Nav
		$('.fullscreen-menu .navigation li.dropdown > a').on('click', function () {
			$(this).next('ul').slideToggle(500);
		});

		//Disable dropdown parent link
		$('.navigation li.dropdown > a').on('click', function (e) {
			e.preventDefault();
		});

		//Disable dropdown parent link
		$('.main-header .navigation li.dropdown > a,.hidden-bar .side-menu li.dropdown > a').on('click', function (e) {
			e.preventDefault();
		});

		$('.main-header__cart-box .dropdown-menu').click(function (e) {
			e.stopPropagation();
		});

	}


	// Mobile Nav Hide Show
	if ($('.mobile-menu').length) {

		//$('.mobile-menu .menu-box').mCustomScrollbar();

		var mobileMenuContent = $('.main-header .nav-outer .main-menu__navigation').html();
		$('.mobile-menu .mobile-menu__box .mobile-menu__outer').append(mobileMenuContent);
		$('.sticky-header .main-menu__navigation').append(mobileMenuContent);

		//Dropdown Button
		$('.mobile-menu li.dropdown .dropdown-btn').on('click', function () {
			$(this).toggleClass('open');
			$(this).prev('ul').slideToggle(500);
		});
		//Menu Toggle Btn
		$('.mobile-nav-toggler').on('click', function () {
			$('body').addClass('mobile-menu-visible');
		});

		//Menu Toggle Btn
		$('.mobile-menu .menu-backdrop,.mobile-menu .close-btn').on('click', function () {
			$('body').removeClass('mobile-menu-visible');
		});

	}



	//Progress Bar
	if ($('.progress-line').length) {
		$('.progress-line').appear(function () {
			var el = $(this);
			var percent = el.data('width');
			$(el).css('width', percent + '%');
		}, {
			accY: 0
		});
	}



	//Header Search
	if ($('.header-search__box').length) {
		$('.header-search__box').on('click', function () {
			$('body').addClass('search-active');
		});
		$('.close-search').on('click', function () {
			$('body').removeClass('search-active');
		});

		$('.search-popup .color-layer').on('click', function () {
			$('body').removeClass('search-active');
		});
	}



	//Accordion Box
	if ($('.faq-one__accordion').length) {
		$(".faq-one__accordion").on('click', '.faq-one__acc-btn', function () {

			var outerBox = $(this).parents('.faq-one__accordion');
			var target = $(this).parents('.faq-accordion__toggle');

			if ($(this).hasClass('active') !== true) {
				$(outerBox).find('.faq-accordion__toggle .faq-one__acc-btn').removeClass('active');
			}

			if ($(this).next('.faq-one-acc__content').is(':visible')) {
				return false;
			} else {
				$(this).addClass('active');
				$(outerBox).children('.faq-accordion__toggle').removeClass('active-block');
				$(outerBox).find('.faq-accordion__toggle').children('.faq-one-acc__content').slideUp(300);
				target.addClass('active-block');
				$(this).next('.faq-one-acc__content').slideDown(300);
			}
		});
	}




	//Accordion Box
	if ($('.service-detail__faq-accordion').length) {
		$(".service-detail__faq-accordion").on('click', '.service-detail__acc-btn', function () {

			var outerBox = $(this).parents('.service-detail__faq-accordion');
			var target = $(this).parents('.service-detail__faq-toggle');

			if ($(this).hasClass('active') !== true) {
				$(outerBox).find('.service-detail__faq-toggle .service-detail__acc-btn').removeClass('active');
			}

			if ($(this).next('.service-detail__faq-content').is(':visible')) {
				return false;
			} else {
				$(this).addClass('active');
				$(outerBox).children('.service-detail__faq-toggle').removeClass('active-block');
				$(outerBox).find('.service-detail__faq-toggle').children('.service-detail__faq-content').slideUp(300);
				target.addClass('active-block');
				$(this).next('.service-detail__faq-content').slideDown(300);
			}
		});
	}



	//Fact Counter + Text Count
	if ($('.count-box').length) {
		$('.count-box').appear(function () {

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
					step: function () {
						$t.find(".count-text").text(Math.floor(this.countNum));
					},
					complete: function () {
						$t.find(".count-text").text(this.countNum);
					}
				});
			}

		}, {
			accY: 0
		});
	}



	// Preloader
	if ($('.paroller').length) {
		$('.paroller').paroller({
			factor: 0.2, // multiplier for scrolling speed and offset, +- values for direction control
			factorLg: 0.4, // multiplier for scrolling speed and offset if window width is less than 1200px, +- values for direction control
			type: 'foreground', // background, foreground
			direction: 'horizontal' // vertical, horizontal
		});
	}


	//Gallery Filters
	if ($('.filter-list').length) {
		$('.filter-list').mixItUp({});
	}



	function thmOwlInit() {
		// owl slider

		if ($(".thm-owl__carousel").length) {
			$(".thm-owl__carousel").each(function () {
				let elm = $(this);
				let options = elm.data('owl-options');
				let thmOwlCarousel = elm.owlCarousel(options);
			});
		}

		if ($(".thm-owl__carousel--custom-nav").length) {
			$(".thm-owl__carousel--custom-nav").each(function () {
				let elm = $(this);
				let owlNavPrev = elm.data('owl-nav-prev');
				let owlNavNext = elm.data('owl-nav-next');
				$(owlNavPrev).on("click", function (e) {
					elm.trigger('prev.owl.carousel');
					e.preventDefault();
				})

				$(owlNavNext).on("click", function (e) {
					elm.trigger('next.owl.carousel');
					e.preventDefault();
				})
			});
		}

	};



	//Parallax Scene for Icons
	if ($('.parallax-scene-1').length) {
		var scene = $('.parallax-scene-1').get(0);
		var parallaxInstance = new Parallax(scene);
	}
	if ($('.parallax-scene-2').length) {
		var scene = $('.parallax-scene-2').get(0);
		var parallaxInstance = new Parallax(scene);
	}
	if ($('.parallax-scene-3').length) {
		var scene = $('.parallax-scene-3').get(0);
		var parallaxInstance = new Parallax(scene);
	}
	if ($('.parallax-scene-4').length) {
		var scene = $('.parallax-scene-4').get(0);
		var parallaxInstance = new Parallax(scene);
	}
	if ($('.parallax-scene-5').length) {
		var scene = $('.parallax-scene-5').get(0);
		var parallaxInstance = new Parallax(scene);
	}
	if ($('.parallax-scene-6').length) {
		var scene = $('.parallax-scene-6').get(0);
		var parallaxInstance = new Parallax(scene);
	}



	if ($(".video-popup").length) {
		$(".video-popup").magnificPopup({
			type: "iframe",
			mainClass: "mfp-fade",
			removalDelay: 160,
			preloader: true,

			fixedContentPos: false
		});
	}




	//LightBox / Fancybox
	if ($('.lightbox-image').length) {
		$('.lightbox-image').fancybox({
			openEffect: 'fade',
			closeEffect: 'fade',
			helpers: {
				media: {}
			}
		});
	}


	//Custom Seclect Box
	if ($('.custom-select-box').length) {
		$('.custom-select-box').selectmenu().selectmenu('menuWidget').addClass('overflow');
	}



	//Contact Form Validation
	if ($('#contact-form').length) {
		$('#contact-form').validate({
			rules: {
				name: {
					required: true
				},
				phone: {
					required: true
				},
				subject: {
					required: true
				},
				email: {
					required: true,
					email: true
				},
				message: {
					required: true
				}
			}
		});
	}



	// Scroll to a Specific Div
	if ($('.scroll-to-target').length) {
		$(".scroll-to-target").on('click', function () {
			var target = $(this).attr('data-target');
			// animate
			$('html, body').animate({
				scrollTop: $(target).offset().top
			}, 1500);

		});
	}



	// Elements Animation
	if ($('.wow').length) {
		var wow = new WOW({
			boxClass: 'wow', // animated element css class (default is wow)
			animateClass: 'animated', // animation css class (default is animated)
			offset: 0, // distance to the element when triggering the animation (default is 0)
			mobile: true, // trigger animations on mobile devices (default is true)
			live: true // act on asynchronously loaded content (default is true)
		});
		wow.init();
	}



	/* ==========================================================================
	   When document is Scrollig, do
	   ========================================================================== */

	$(window).on('scroll', function () {
		headerStyle();
	});

	/* ==========================================================================
	   When document is loading, do
	   ========================================================================== */

	$(window).on('load', function () {
		handlePreloader();
		thmOwlInit();
		thmSwiperInit();
	});

})(window.jQuery);

(function(){
    var Loading = function Loading() {
        this.el = false;
        this.add = function(el) {
            el.addClass('loading');
        }
        this.remove = function(el) {
            el.removeClass('loading');
        }
    };
  window.Loading = new Loading();
})(window);

$.fn.serializeFormJSON = function () {
	var o = {};
	var a = this.serializeArray();
	$.each(a, function () {
		if (o[this.name]) {
			if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	return o;
};
