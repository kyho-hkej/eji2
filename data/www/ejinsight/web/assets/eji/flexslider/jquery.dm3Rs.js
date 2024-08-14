/**
 * Dm3RS
 * version 1.2
 */
(function($) {
  
  "use strict";
  
  /**
   * Constructor
   */
  function Dm3RS(el, options) {
    this.el = el;
    this.curSlide = this.el.find('ul > li:first');
    this.maxSlideWidth = parseInt(this.el.attr('data-slideWidth'), 10);
    this.maxSlideHeight = parseInt(this.el.attr('data-slideHeight'), 10);
    this.moving = false;
    this.init = false;
    
    var that = this;
    this.numSlides = this.el.find('ul > li').length;
    
    if (this.numSlides > 2) {
      this.containerWidth = this.maxSlideWidth + ((this.maxSlideWidth / 2) * 2);
    } else {
      this.containerWidth = 940;
    }
    
    this.el.parent().css('max-width', this.containerWidth + 'px');
    
    this.ratio = this.maxSlideWidth / this.containerWidth;
    this.aspectRatio = this.maxSlideWidth / this.maxSlideHeight;
    
    this.el.find('ul > li').each(function() {
      var s = $(this);
      s.append($('<div class="dm3-rs-cover"></div>').css('opacity', 0));
      that.setSlideNav(s);
    });
    
    var resize_timeout = null;
    
    $(window).on('resize', function() {
      if (resize_timeout) {
        clearTimeout(resize_timeout);
        resize_timeout = null;
      }
      
      resize_timeout = setTimeout(function() {
        that.el.find('ul > li').each(function() {
          var s = $(this);
          var new_width = 0;
          var new_height;
          var el_width = that.el.width();

          if (el_width > that.maxSlideWidth) {
            new_width = that.maxSlideWidth;
          } else {
            new_width = el_width * that.ratio;
          }
          
          if (new_width > that.maxSlideWidth) {
            new_width = that.maxSlideWidth;
          }
          
          new_height = new_width / that.aspectRatio;
          
          if (s.hasClass('slide-video')) {
            new_height -= parseInt(s.find('.slide-media').css('margin-left'), 10);
            s.find('.slide-media').height(new_height);
          } else {
            new_height -= parseInt(s.find('.slide-media').css('padding-left'), 10);
          }
          
          s.width(new_width);
          s.height(new_height);
        });
        
        that.setSlide('init', {
          animation: false
        });
      }, 300);
    }).trigger('resize');
    
    
    that.el.find('.shade-left').on('click', function(e) {
      that.setSlide('prev');
      e.stopPropagation();
    });
    
    that.el.find('.shade-right').on('click', function(e) {
      that.setSlide('next');
      e.stopPropagation();
    });
    
    this.hover = false;
    
    this.el.hover(function() {
      that.hover = true;
    }, function() {
      that.hover = false;
    });
    
    this.autoscroll = parseInt(this.el.attr('data-autoscroll'), 10);
    if (isNaN(this.autoscroll)) {
      this.autoscroll = options.autoscroll;
    }
    this.autoscrollTimeout = null;
    this.startAutoscroll();
  }
  
  
  /**
   * Start autoscroll
   */
  Dm3RS.prototype.startAutoscroll = function() {
    var that;
    
    if (this.autoscroll > 0) {
      that = this;
      
      // Clear existing timeout
      if (this.autoscrollTimeout) {
        clearTimeout(this.autoscrollTimeout);
        this.autoscrollTimeout = null;
      }
      
      this.autoscrollTimeout = setTimeout(function() {
        that.autoscrollTimeout = null;
        
        if (!that.hover) {
          that.setSlide('next');
        } else {
          that.startAutoscroll();
        }
      }, this.autoscroll * 1000);
    }
  };
  
  
  /**
   * Set slide
   */
  Dm3RS.prototype.setSlide = function(dir, args) {
    var dir = (typeof dir !== 'undefined') ? dir : 'init';
    var args = $.extend({
      animation: true
    }, args);
    
    var that = this;
    var after_next = null;
    var next = null;
    var clone = null;
    
    if (this.moving) {
      return;
    }
    this.moving = true;
    
    if (dir === 'next') {
      next = this.curSlide.next('li');
      after_next = next.next('li');
    } else if (dir === 'prev') {
      next = this.curSlide.prev('li');
      after_next = next.prev('li');
    } else {
      next = this.curSlide;
      after_next = this.curSlide.prev('li');
    }
    
    if (!after_next.length && this.numSlides > 2) {
      if (dir === 'next') {
        after_next = this.el.find('ul > li:first').insertAfter(next);
        
        if (this.numSlides === 3) {
          clone = after_next.clone().insertBefore(this.curSlide);
        } else {
          this.el.find('ul').css({
            'margin-left': (parseInt(this.el.find('ul').css('margin-left'), 10) + after_next.width()) + 'px'
          });
        }
      } else {
        after_next = this.el.find('ul > li:last').insertBefore(next);
        
        if (this.numSlides === 3) {
          clone = after_next.clone().insertAfter(this.curSlide);
        }
        
        this.el.find('ul').css({
          'margin-left': (parseInt(this.el.find('ul').css('margin-left'), 10) - after_next.width()) + 'px'
        });
      }
    }
    
    // Calculate current slide's position
    var next_w = next.width();
    var container_w = this.el.width();
    var left = 0;
    this.el.find('ul > li').each(function() {
      if (this === next.get(0)) {
        return false;
      }
      left += $(this).width();
    });
    
    if (that.numSlides > 2) {
      left = left - ((container_w - next_w) / 2);
    } else {
      if (next.prev('li').length) {
        left = (next_w * 2) - container_w;
      }
    }
    
    // Scroll to current slide
    var complete = function() {
      if (that.numSlides === 3 && clone) {
        var new_margin_left;
        
        if (dir === 'next') {
          new_margin_left = parseInt(that.el.find('ul').css('margin-left'), 10) + clone.width();
          clone.detach().remove();
          that.el.find('ul').css({
            'margin-left': new_margin_left + 'px'
          });
        } else {
          clone.detach().remove();
        }
      }
      
      that.curSlide.removeClass('dm3-rs-current');
      that.curSlide.find('.dm3-rs-cover:first').css('display', 'block');
      next.addClass('dm3-rs-current');
      next.find('.dm3-rs-cover:first').css('display', 'none');
      that.curSlide = next;
      that.moving = false;
      that.startAutoscroll();
      
      // Do only on slider initialization
      if (!that.init) {
        that.el.animate({
          'height': next.height() + 'px'
        }, {
          'duration': 400,
          'complete': function() {
            that.el.css('height', 'auto');
            that.el.find('.dm3-rs-loader').fadeOut(300);
          }
        });
        that.init = true;
      }
    };
    
    // Opacity
    this.el.find('ul > li').not(next).animate({ 'opacity': 0.3 });
    next.animate({ 'opacity': 1 });
    
    if (args.animation) {
      this.el.find('ul').animate({
        'margin-left': '-' + left + 'px'
      }, {
        duration: 300,
        complete: function() {
          complete();
        }
      });
    } else {
      this.el.find('ul').css({
        'margin-left': '-' + left + 'px'
      });
      complete();
    }
  };
  
  
  /**
   * Set slide navigation
   */
  Dm3RS.prototype.setSlideNav = function(slide) {
    var that = this;
    
    slide.on('click', function() {
      if (slide.hasClass('dm3-rs-current')) {
        return;
      }
      
      if (slide.prev().hasClass('dm3-rs-current')) {
        that.setSlide('next');
      } else {
        that.setSlide('prev');
      }
    });
  };
  
  
  /**
   * jQuery plugin
   */
  $.fn.dm3Rs = function(options) {
    var options = $.extend({
      speed: 300,
      autoscroll: 0
    }, options);
    
    return this.each(function() {
      return new Dm3RS($(this), options);
    });
  };
  
}(jQuery));