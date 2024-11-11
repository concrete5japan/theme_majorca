/*
 * jQuery.appear
 * https://github.com/bas2k/jquery.appear/
 * http://code.google.com/p/jquery-appear/
 *
 * Copyright (c) 2009 Michael Hixson
 * Copyright (c) 2012 Alexander Brovikov
 * Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php)
 */
(function($) {
	$.fn.appear = function(fn, options) {

		var settings = $.extend({

			//arbitrary data to pass to fn
			data: undefined,

			//call fn only on the first appear?
			one: true,

			// X & Y accuracy
			accX: 0,
			accY: 0

		}, options);

		return this.each(function() {

			var t = $(this);

			//whether the element is currently visible
			t.appeared = false;

			if (!fn) {

				//trigger the custom event
				t.trigger('appear', settings.data);
				return;
			}

			var w = $(window);

			//fires the appear event when appropriate
			var check = function() {

				//is the element hidden?
				if (!t.is(':visible')) {

					//it became hidden
					t.appeared = false;
					return;
				}

				//is the element inside the visible window?
				var a = w.scrollLeft();
				var b = w.scrollTop();
				var o = t.offset();
				var x = o.left;
				var y = o.top;

				var ax = settings.accX;
				var ay = settings.accY;
				var th = t.height();
				var wh = w.height();
				var tw = t.width();
				var ww = w.width();

				if (y + th + ay >= b &&
					y <= b + wh + ay &&
					x + tw + ax >= a &&
					x <= a + ww + ax) {

					//trigger the custom event
					if (!t.appeared) t.trigger('appear', settings.data);

				} else {

					//it scrolled out of view
					t.appeared = false;
				}
			};

			//create a modified fn with some additional logic
			var modifiedFn = function() {

				//mark the element as visible
				t.appeared = true;

				//is this supposed to happen only once?
				if (settings.one) {

					//remove the check
					w.unbind('scroll', check);
					var i = $.inArray(check, $.fn.appear.checks);
					if (i >= 0) $.fn.appear.checks.splice(i, 1);
				}

				//trigger the original fn
				fn.apply(this, arguments);
			};

			//bind the modified fn to the element
			if (settings.one) t.one('appear', settings.data, modifiedFn);
			else t.bind('appear', settings.data, modifiedFn);

			//check whenever the window scrolls
			w.scroll(check);

			//check whenever the dom changes
			$.fn.appear.checks.push(check);

			//check now
			(check)();
		});
	};

	//keep a queue of appearance checks
	$.extend($.fn.appear, {

		checks: [],
		timeout: null,

		//process the queue
		checkAll: function() {
			var length = $.fn.appear.checks.length;
			if (length > 0) while (length--) ($.fn.appear.checks[length])();
		},

		//check the queue asynchronously
		run: function() {
			if ($.fn.appear.timeout) clearTimeout($.fn.appear.timeout);
			$.fn.appear.timeout = setTimeout($.fn.appear.checkAll, 20);
		}
	});

	//run checks when these methods are called
	$.each(['append', 'prepend', 'after', 'before', 'attr',
		'removeAttr', 'addClass', 'removeClass', 'toggleClass',
		'remove', 'css', 'show', 'hide'], function(i, n) {
		var old = $.fn[n];
		if (old) {
			$.fn[n] = function() {
				var r = old.apply(this, arguments);
				$.fn.appear.run();
				return r;
			}
		}
	});

})(jQuery);



//$('html').addClass('pala-js');

/*
(function(){
  var html = document.getElementsByTagName('html')||[];
  html[0].classList.add('enable-js');
})();
*/


$(document).ready(function(){
	// @media screen and (max-width: 780px) と同じ
	var mediaScreen = window.matchMedia('screen and (min-width: 992px)');

	function checkBreakPoint(mediaScreen) {
		if (mediaScreen.matches) {
			$('.item-top').each(function() {
				$(this).css({
					opacity: 0,
					top: '-50px',
					position : 'relative',
				});
				$(this).appear(function() {
					$(this).delay(520).animate({
						opacity : 1,
						top : '0px'
					}, 900);
				});
			});
			$('.item-bottom').each(function() {
				$(this).css({
					opacity: 0,
					bottom: '-50px',
					position : 'relative',
				});
				$(this).appear(function() {
					$(this).delay(520).animate({
						opacity : 1,
						bottom : '0px'
					}, 900);
				});
			});
			$('.item-left').each(function() {
				$(this).css({
					opacity: 0,
					left: '-80px',
					position : 'relative',
				});
				$(this).appear(function() {
					$(this).delay(520).animate({
						opacity : 1,
						left : '0px'
					}, 900);
				});
			});

			$('.item-right').each(function() {
				$(this).css({
					opacity: 0,
					right: '-80px',
					position : 'relative',
				});
				$(this).appear(function() {
					$(this).delay(520).animate({
						opacity : 1,
						right: '0px'
					}, 900);
				});
			});

			$('.item-fade-in').each(function() {
				$(this).css({
					opacity: 0,
					position : 'relative',
				});
				$(this).appear(function() {
					$(this).delay(400).animate({
						opacity : 1,
					}, 1000);
				});
			});
    	}
	}

  // ブレイクポイントの瞬間に発火
  //mql.addListener(checkBreakPoint);

  // 初回チェック
  checkBreakPoint(mediaScreen);
});

/*
$(function(){
	var style = '<link rel="stylesheet" href="style.css">';
    $('head link:last').after(style);
});
*/

	$(function() {
		$('.item-top').each(function() {
			$(this).appear(function() {
				$(this).delay(520).animate({
					opacity : 1,
					top : '0px'
				}, 900);
			});
		});

		$('.item-bottom').each(function() {
			$(this).appear(function() {
				$(this).delay(520).animate({
					opacity : 1,
					bottom : '0px'
				}, 900);
			});
		});

		$('.item-left').each(function() {
			$(this).appear(function() {
				$(this).delay(520).animate({
					opacity : 1,
					left : '0px'
				}, 900);
			});
		});

		$('.item-right').each(function() {
			$(this).appear(function() {
				$(this).delay(520).animate({
					opacity : 1,
					right : '0px'
				}, 900);
			});
		});

		$('.item-fade-in').each(function() {
			$(this).appear(function() {
				$(this).delay(400).animate({
					opacity : 1,
					right : '0px'
				}, 1000);
			});
		});
	});

