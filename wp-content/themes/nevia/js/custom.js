/*-----------------------------------------------------------------------------------
/* Custom Scripts
-----------------------------------------------------------------------------------*/

/* ----------------- Start Document ----------------- */
(function($){
  "use strict";
	$(document).ready(function(){

	/* global nevia */

/*----------------------------------------------------*/
/*	Navigation
/*----------------------------------------------------*/

$(".menu li").hover(
	function () {
		$(this).find('ul:first').css({
			visibility: "visible",
			display: "none"
		}).stop(true, true).fadeIn(100);
	},
	function () {
		$(this).find('ul:first').css({
			visibility: "visible",
			display: "block"
		}).stop(true, true).fadeOut(100);
	}
	);

$("select.selectnav").change(function() {
	window.location = $(this).find("option:selected").val();
});


/*
	Fix for sidebars problem if it's longer than content
*/
window.resizesidebar = function() {
	var windowwidth = $(window).width();
	if(windowwidth > 768) {
		var contheight = Math.max($(".eleven.floated").outerHeight(true));
		var sbheight = Math.max($("aside.sidebar").outerHeight(true));
		if(contheight<sbheight) {
			$('.eleven.floated').css('min-height',sbheight);
		}
	} else {
		$('div.sidebar').css('min-height','auto');
		$('.eleven.floated').css('min-height','auto');
	}
};
$(window).load(function() {
	window.resizesidebar();
});
$(window).resize(function () { window.resizesidebar(); });


/*----------------------------------------------------*/
/*	Flexslider
	nevia values are returned by localize script
/*----------------------------------------------------*/


$(window).load(function() {
	$('.flexslider:not(.nonav)').flexslider({
		animation: nevia.flexanimationtype,
		smoothHeight: true,
		controlNav: false,
		slideshowSpeed: nevia.flexslidespeed,
		animationSpeed: nevia.flexanimspeed,
		after: function(){
			window.resizesidebar();
		}
	});
	$('.flexslider.nonav').flexslider({
		animation: nevia.flexanimationtype ,
		smoothHeight: true,
		slideshowSpeed: nevia.flexslidespeed,
		animationSpeed: nevia.flexanimspeed,
		directionNav: false,
		controlNav: false,
		after: function(){
			window.resizesidebar();
		}
	});
});


/*----------------------------------------------------*/
/*	Carousel
/*----------------------------------------------------*/

// Add classes for other carousels
var $carousel = $('.recent-blog-jc, .recent-work-jc, .recent-products-jc, .recent-blog-jc, .clients-jc');

var scrollCount;
function adjustScrollCount() {
	if( $(window).width() < 768 ) {
		scrollCount = 1;
	} else {
		scrollCount = 3;
	}
}

function adjustCarouselHeight() {
	$carousel.each(function() {
		var $this    = $(this);
		var maxHeight = -1;
		$this.find('li').each(function() {
			maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
		});
		$this.height(maxHeight);
	});
}

function initCarousel() {
	adjustCarouselHeight();
	adjustScrollCount();
	var i = 0;
	var g = {};
  var choosenwrap;
	$carousel.each(function() {
		i++;
		if(nevia.jcautoscroll === 'yes') {
			choosenwrap = 'circular';
		} else {
			choosenwrap = null;
		}
		var $this = $(this);
		g[i] = $this.jcarousel({
			animation           : 600,
			scroll              : scrollCount,
			wrap: choosenwrap
		});
		if(nevia.jcautoscroll === 'yes') {
			$this.jcarouselAutoscroll({ 'target': '+='+scrollCount,   'interval': 3000 });
		}
		$this.jcarousel('scroll', 0);
		$this.prev().find('.jcarousel-prev').bind('active.jcarouselcontrol', function() {
			$(this).addClass('active');
		}).bind('inactive.jcarouselcontrol', function() {
			$(this).removeClass('active');
		}).jcarouselControl({
			target: '-='+scrollCount,
			carousel: g[i]
		});

		$this.prev().find('.jcarousel-next').bind('active.jcarouselcontrol', function() {
			$(this).addClass('active');
		}).bind('inactive.jcarouselcontrol', function() {
			$(this).removeClass('active');
		}).jcarouselControl({
			target: '+='+scrollCount,
			carousel: g[i]
		});

		$this.touchwipe({
			wipeLeft: function() {
				$this.jcarousel('scroll','+='+scrollCount);
			},
			wipeRight: function() {
				$this.jcarousel('scroll','-='+scrollCount);
			}
		});

	});
}

$(window).load(function(){
	initCarousel();
});

$(window).resize(function () {
	$carousel.each(function() {
		var $this = $(this);
		$this.jcarousel('destroy');
	});
	initCarousel();
});

$(window).load(function(){
	var thumbcarousel = $('.thumbnails.jcarousel').jcarousel({});
	$('.shop-prev').bind('active.jcarouselcontrol', function() {
		$(this).addClass('active');
	}).bind('inactive.jcarouselcontrol', function() {
		$(this).removeClass('active');
	}).jcarouselControl({
		target: '-=1',
		carousel: thumbcarousel
	});

	$('.shop-next').bind('active.jcarouselcontrol', function() {
		$(this).addClass('active');
	}).bind('inactive.jcarouselcontrol', function() {
		$(this).removeClass('active');
	}).jcarouselControl({
		target: '+=1',
		carousel: thumbcarousel
	});
});


/*----------------------------------------------------*/
/*	Tabs
/*----------------------------------------------------*/

var $tabsNav    = $('.tabs-nav'),
$tabsNavLis = $tabsNav.children('li');

$tabsNav.each(function() {
	var $this = $(this);
	$this.next().children('.tab-content').stop(true,true).hide()
	.first().show();

	$this.children('li').first().addClass('active').stop(true,true).show();
});

$tabsNavLis.on('click', function(e) {
	var $this = $(this);

	$this.siblings().removeClass('active').end()
	.addClass('active');

	$this.parent().next().children('.tab-content').stop(true,true).hide()
	.siblings( $this.find('a').attr('href') ).fadeIn();

	e.preventDefault();
});


/*----------------------------------------------------*/
/*	Accordion
/*----------------------------------------------------*/

var $accor = $('.accordion');
var $trigger;
$accor.each(function() {
	$(this).addClass('ui-accordion ui-widget ui-helper-reset');
	$(this).find('h3').addClass('ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all');
	$(this).find('div').addClass('ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom');
	$(this).find("div").hide().first().show();
	$(this).find("h3").first().removeClass('ui-accordion-header-active ui-state-active ui-corner-top').addClass('ui-accordion-header-active ui-state-active ui-corner-top');
	$(this).find("span").first().addClass('ui-accordion-icon-active');
});

$trigger = $accor.find('h3');

$trigger.on('click', function(e) {
	var location = $(this).parent();
	var $triggerloc;
	if( $(this).next().is(':hidden') ) {
		$triggerloc = $('h3', location);
		$triggerloc.removeClass('ui-accordion-header-active ui-state-active ui-corner-top').next().slideUp(300);
		$triggerloc.find('span').removeClass('ui-accordion-icon-active');
		$(this).find('span').addClass('ui-accordion-icon-active');
		$(this).addClass('ui-accordion-header-active ui-state-active ui-corner-top').next().slideDown(300);
	}
	window.resizesidebar();
	e.preventDefault();
});




/*----------------------------------------------------*/
/*	Toggle
/*----------------------------------------------------*/

$(".toggle-container").hide();
$(".trigger").toggle(function(){
	$(this).addClass("active");
}, function () {
	$(this).removeClass("active");
});
$(".trigger").click(function(){
	$(this).next(".toggle-container").slideToggle();
});

$(".trigger.opened").toggle(function(){
	$(this).removeClass("active");
}, function () {
	$(this).addClass("active");
});

$(".trigger.opened").addClass("active").next(".toggle-container").show();


/*----------------------------------------------------*/
/*	Tooltip
/*----------------------------------------------------*/

$('.container').tooltip({
	selector: "a.tooltip"
});



$(document).ajaxComplete(function() {
   	window.resizesidebar();
   });

/*----------------------------------------------------*/
/*	Skill Bar Animation
/*----------------------------------------------------*/

setTimeout(function(){

	$('.skill-bar .skill-bar-content').each(function() {
		var me = $(this);
		var perc = me.attr("data-percentage");

		var current_perc = 0;

		var progress = setInterval(function() {
			if (current_perc>=perc) {
				clearInterval(progress);
			} else {
				current_perc +=1;
				me.css('width', (current_perc)+'%');
			}

			me.text((current_perc)+'%');

		}, 10);

	});

},10);

$('.notification a.close').click(function(e){
	e.preventDefault();
	$(this).parent().fadeOut();

});


/*----------------------------------------------------*/
/*	Fancybox2
/*----------------------------------------------------*/

// if(jQuery('[rel=fancybox]').length){
// 	jQuery('[rel=fancybox]').fancybox({
// 	type        : 'image',
// 	openEffect  : 'elastic',
// 	closeEffect	: 'elastic',
// 	nextEffect  : 'elastic',
// 	prevEffect  : 'elastic',
// 	helpers : {
// 		title : {
// 			type : 'inside'
// 		},
// 		overlay : {
// 			css : {
// 				'background' : 'rgba(0, 0, 0, 0.85)'
// 			}
// 		}
// 	}
// });
// }

// if(jQuery('[rel=fancybox-gallery]').length){
// 	jQuery('[rel=fancybox-gallery]').fancybox({
// 		openEffect  : 'elastic',
// 		closeEffect	: 'elastic',
// 		nextEffect  : 'elastic',
// 		prevEffect  : 'elastic',

// 		helpers : {
// 			title : {
// 				type : 'inside'
// 			},
// 			buttons	: {},
// 			overlay : {
// 				css : {
// 					'background' : 'rgba(0, 0, 0, 0.85)'
// 				}
// 			}
// 		}
// 	});
// }

// if(jQuery('.fancybox-media').length){
// 	jQuery('.fancybox-media').fancybox({
// 			openEffect  : 'elastic',
// 			closeEffect	: 'elastic',
// 			helpers : {
// 				media : {},
// 				overlay : {
// 				css : {
// 					'background' : 'rgba(0, 0, 0, 0.85)'
// 				}
// 			}
// 			}
// 		});
// }


// jQuery('.sidebar .contact-details-alt i').removeClass('white').addClass('black');
/*----------------------------------------------------*/
/*	Portfolio Filters
/*----------------------------------------------------*/

function DropDown(el) {
	this.dd = el;
	this.opts = this.dd.find('ul.option-set > li');
	this.placeholder = this.dd.children('span');
	this.val = [];
	this.index = [];
	this.initEvents();
}

DropDown.prototype = {
	initEvents : function() {
		var obj = this;

		obj.dd.on('click', function(event){
			$(this).toggleClass('active');
			event.stopPropagation();
		});
		obj.opts.on('click',function(){
			var opt = $(this);
			obj.val = opt.text();
			obj.index = opt.index();
			obj.placeholder.text('' + obj.val);
		});
	}
};

$(function() {

	new DropDown( $('#filters') );

	$(document).click(function() {
		$('.filters-dropdown').removeClass('active');
	});

	$(".option-set").click(function() {
		$('.filters-dropdown').toggleClass('active');
	});

});


/* ------------------ End Document ------------------ */
});

})(this.jQuery);
