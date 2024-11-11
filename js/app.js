/*----------------------------------------------

	Theme Name: Majorca for concrete5
	Website Designed and developed by www.onside.com
	Author: Shin'ichi Nakane
	Description: Support JavaScript 02-26-2018 (mm-dd-yyyy)
	Version: 1.0

----------------------------------------------*/

/*jshint browser:true */
/*!
* FitVids 1.1
*
* Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
*/

;(function( $ ){

  'use strict';

  $.fn.fitVids = function( options ) {
    var settings = {
      customSelector: null,
      ignore: null
    };

    if(!document.getElementById('fit-vids-style')) {
      // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
      var head = document.head || document.getElementsByTagName('head')[0];
      var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
      var div = document.createElement("div");
      div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
      head.appendChild(div.childNodes[1]);
    }

    if ( options ) {
      $.extend( settings, options );
    }

    return this.each(function(){
      var selectors = [
        'iframe[src*="player.vimeo.com"]',
        'iframe[src*="youtube.com"]',
        'iframe[src*="youtube-nocookie.com"]',
        'iframe[src*="kickstarter.com"][src*="video.html"]',
        'object',
        'embed'
      ];

      if (settings.customSelector) {
        selectors.push(settings.customSelector);
      }

      var ignoreList = '.fitvidsignore';

      if(settings.ignore) {
        ignoreList = ignoreList + ', ' + settings.ignore;
      }

      var $allVideos = $(this).find(selectors.join(','));
      $allVideos = $allVideos.not('object object'); // SwfObj conflict patch
      $allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

      $allVideos.each(function(){
        var $this = $(this);
        if($this.parents(ignoreList).length > 0) {
          return; // Disable FitVids on this video.
        }
        if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
        if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width'))))
        {
          $this.attr('height', 9);
          $this.attr('width', 16);
        }
        var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
            width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
            aspectRatio = height / width;
        if(!$this.attr('name')){
          var videoName = 'fitvid' + $.fn.fitVids._count;
          $this.attr('name', videoName);
          $.fn.fitVids._count++;
        }
        $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+'%');
        $this.removeAttr('height').removeAttr('width');
      });
    });
  };

  // Internal counter for unique video names.
  $.fn.fitVids._count = 0;

// Works with either jQuery or Zepto
})( window.jQuery || window.Zepto );



/* ========================================================================
 * Bootstrap: transition.js v3.3.7
 * http://getbootstrap.com/javascript/#transitions
 * ========================================================================
 * Copyright 2011-2016 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // CSS TRANSITION SUPPORT (Shoutout: http://www.modernizr.com/)
  // ============================================================

  function transitionEnd() {
    var el = document.createElement('bootstrap')

    var transEndEventNames = {
      WebkitTransition : 'webkitTransitionEnd',
      MozTransition    : 'transitionend',
      OTransition      : 'oTransitionEnd otransitionend',
      transition       : 'transitionend'
    }

    for (var name in transEndEventNames) {
      if (el.style[name] !== undefined) {
        return { end: transEndEventNames[name] }
      }
    }

    return false // explicit for ie8 (  ._.)
  }

  // http://blog.alexmaccaw.com/css-transitions
  $.fn.emulateTransitionEnd = function (duration) {
    var called = false
    var $el = this
    $(this).one('bsTransitionEnd', function () { called = true })
    var callback = function () { if (!called) $($el).trigger($.support.transition.end) }
    setTimeout(callback, duration)
    return this
  }

  $(function () {
    $.support.transition = transitionEnd()

    if (!$.support.transition) return

    $.event.special.bsTransitionEnd = {
      bindType: $.support.transition.end,
      delegateType: $.support.transition.end,
      handle: function (e) {
        if ($(e.target).is(this)) return e.handleObj.handler.apply(this, arguments)
      }
    }
  })

}(jQuery);



/*
	Rippler
	Effect that spreads like a wave in touch or click.
	By blivesta, http://git.blivesta.com/rippler/
	Licensed under the MIT.
	Currently v0.1.1
*/

(function($) {
  "use strict";
  var namespace = 'rippler';
  var methods = {
    init: function(options){
      options = $.extend({
        effectClass      :  'rippler-effect'
        ,effectSize      :  0      // Default size (width & height)
        ,addElement      :  'div'   // e.g. 'svg' (feature)
        ,duration        :  600
      }, options);
      return this.each(function(){
        var _this = this;
        var $this = $(this);
        var data = $this.data(namespace);

        if (!data) {
          options = $.extend({}, options);

          $this.data(namespace, {
            options: options
          });

          if (typeof document.ontouchstart != "undefined") {
            $this.on("touchstart."+ namespace, function(event) {
              var $self = $(this);
              methods.elementAdd.call(_this, $self, event);
            });
            $this.on("touchend." + namespace, function(event) {
              var $self = $(this);
              methods.effect.call(_this, $self, event);
            });
          }else{
            $this.on("mousedown."+ namespace, function(event) {
              var $self = $(this);
              methods.elementAdd.call(_this, $self, event);
            });
            $this.on("mouseup."+ namespace, function(event) {
              var $self = $(this);
              methods.effect.call(_this, $self, event);
            });

          }

        }
      }); // end each
    },

    template: function(options){
      var $this = $(this);
      options = $this.data(namespace).options;
      var element;
      var svgElementClass = 'rippler-svg';
      var divElementClass = 'rippler-div';

      var circle = '<circle cx="'+options.effectSize+'" cy="'+options.effectSize+'" r="'+(options.effectSize / 2)+'">';
      var svgElement = '<svg class="'+options.effectClass+' '+svgElementClass+'" xmlns="http://www.w3.org/2000/svg" viewBox="'+(options.effectSize / 2)+' '+(options.effectSize / 2)+' '+options.effectSize+' '+options.effectSize+'">'+circle+'</svg>';

      var divElement = '<div class="'+options.effectClass+' '+divElementClass+'"></div>';

      if (options.addElement === 'svg'){
        element = svgElement;
      } else {
        element = divElement;
      }
      return element;
    },

    elementAdd: function($self, event, options){
      var _this = this;
      var $this = $(this);
      options = $this.data(namespace).options;
      $self.append(methods.template.call(_this));
      var $effect = $self.find('.' + options.effectClass);
      var selfOffset = $self.offset();
      var eventX = methods.targetX.call(_this,event);
      var eventY = methods.targetY.call(_this,event);

      $effect.css({
        'width':options.effectSize
        ,'height':options.effectSize
        ,'left': ( eventX - selfOffset.left ) - ( options.effectSize / 2 )
        ,'top': ( eventY - selfOffset.top ) - ( options.effectSize / 2 )
      });
      return _this;
    },

    effect : function($self, event, options){
      var _this = this;
      var $this = $(this);
      options = $this.data(namespace).options;
      var $effect = $('.' + options.effectClass);
      var selfOffset = $self.offset();
      var thisW = $this.outerWidth();
      var thisH = $this.outerHeight();
      var effectMaxWidth = methods.diagonal(thisW, thisH) * 2;
      var eventX = methods.targetX.call(_this,event);
      var eventY = methods.targetY.call(_this,event);

      $effect.css({
        'width':effectMaxWidth
        ,'height':effectMaxWidth
        ,'left': ( eventX - selfOffset.left ) - ( effectMaxWidth / 2 )
        ,'top': ( eventY - selfOffset.top ) - ( effectMaxWidth / 2 )
        ,'transition':'all '+ ( options.duration / 1000 ) +'s ease-out'
      });
      return methods.elementRemove.call(_this);
    },

    elementRemove: function(options){
      var _this = this;
      var $this = $(this);
      options = $this.data(namespace).options;
      var $effect = $('.' + options.effectClass);
      setTimeout(function(){
        $effect.css({
          'opacity': 0
          ,'transition':'all '+ ( options.duration / 1000 ) +'s ease-out'
        });
        setTimeout(function(){
          $effect.remove();
        }, options.duration * 1.5);
      }, options.duration);
      return _this;
    },

    targetX: function(event){
      var e = event.originalEvent;
      var eventX;
      if (typeof document.ontouchstart != "undefined") {
        eventX = e.changedTouches[0].pageX;
      }else{
        eventX = e.pageX;
      }
      return eventX;
    },

    targetY: function(event){
      var e = event.originalEvent;
      var eventY;
      if (typeof document.ontouchstart != "undefined") {
        eventY = e.changedTouches[0].pageY;
      }else{
        eventY = e.pageY;
      }
      return eventY;
    },

    diagonal: function(x, y){
      if (x > 0 && y > 0) return Math.sqrt(Math.pow(x, 2) + Math.pow(y, 2));
      else return false;
    },

    destroy: function(){
      return this.each(function(){
        var $this = $(this);
        $(window).unbind('.'+namespace);
        $this.removeData(namespace);
      });
    }

  };

  $.fn.rippler = function(method){
    if ( methods[method] ) {
      return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on jQuery.'+namespace);
    }
  };

})(jQuery);