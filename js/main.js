/*----------------------------------------------

	Theme Name: Majorca for concrete5
	Website Designed and developed by www.onside.com
	Author: Shin'ichi Nakane
	Description: Common JavaScript 02-26-2018 (mm-dd-yyyy)
	Version: 1.0

----------------------------------------------*/

/*
smooth scrolling Archives - CSS-Tricks
https://css-tricks.com/tag/smooth-scrolling/
*/

// Select all links with hashes
$('a[href*="#"]')
	// Remove links that don't actually link to anything
	.not('[href="#"]')
	.not('[href="#0"]')
	.click(function(event) {
    // On-page links
	if (
		location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
		&&
		location.hostname == this.hostname
	) {
		// Figure out element to scroll to
		var target = $(this.hash);
		target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
		// Does a scroll target exist?
		if (target.length) {
			// Only prevent default if animation is actually gonna happen
			event.preventDefault();
			$('html, body').animate({
				scrollTop: target.offset().top
			}, 1000, function() {
				// Callback after animation
				// Must change focus!
				var $target = $(target);
				$target.focus();
/*
				if ($target.is(":focus")) { // Checking if the target was focused
					return false;
				} else {
					$target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
					$target.focus(); // Set focus again
				};
*/
			});
		}
	}
});



$(function() {
	var $cloneNav = $('.pure-drawer').clone().addClass('clone-nav').appendTo('body'),
	showClass = 'show-nav';

	//console.log('height: ' + windowHeight);
	var cloneNavDistance = $('#main-content').offset();
	//var cloneNavPosition = cloneNavDistance.top + 300;
	//console.log('clone-top: ' + cloneNavPosition);

	$(window).on('load scroll', function() {
		var value = $(this).scrollTop();

		if ( value > cloneNavDistance.top + 500 ) {
			$cloneNav.addClass(showClass);
		} else {
			$cloneNav.removeClass(showClass);
		}
	});
});

/*
$(window).on('load', function(){
  //$('body').removeClass('fadeout');
  $('.loader-container').delay(900).fadeOut(800);
});
*/

$(function() {
	$('.container').fitVids();
});



(function() {
	var ripple, ripples, RippleEffect,loc, cover, coversize, style, x, y, i, num;

	ripples = document.querySelectorAll('.ripple, .nav-links a');

	RippleEffect = function(e) {
	ripple = this;
		cover = document.createElement('span');
		coversize = ripple.offsetWidth;
	loc = ripple.getBoundingClientRect();
	x = e.pageX - loc.left - window.pageXOffset - (coversize / 2);
	y = e.pageY - loc.top - window.pageYOffset - (coversize / 2);
	pos = 'top:' + y + 'px; left:' + x + 'px; height:' + coversize + 'px; width:' + coversize + 'px;';

	ripple.appendChild(cover);
	cover.setAttribute('style', pos);
	cover.setAttribute('class', 'rp-effect');

	setTimeout(function() {
		var list = document.getElementsByClassName( "rp-effect" ) ;
		for(var i =list.length-1;i>=0; i--){
			list[i].parentNode.removeChild(list[i]);
		}}, 2000)};
		for (i = 0, num = ripples.length; i < num; i++) {
			ripple = ripples[i];
			ripple.addEventListener('mousedown', RippleEffect);
		}
	}
());



$(document).ready(function() {
  $(".rippler").rippler({
    effectClass      :  'rippler-effect'
    ,effectSize      :  16      // Default size (width & height)
    ,addElement      :  'div'   // e.g. 'svg'(feature)
    ,duration        :  400
  });
});
