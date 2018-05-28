/* globals $:false */
var width = $(window).width(),
  height = $(window).height(),
  isMobile = false,
  intro = true,
  content,
  $projects,
  $mouse,
  $filters,
  $root = '/';
$(function() {
  var app = {
    init: function() {
      $(window).resize(function(event) {
        app.sizeSet();
      });
      $(document).ready(function($) {
        $body = $('body');
        $header = $('header');
        $container = $('#container');
        app.sizeSet();
        History.Adapter.bind(window, 'statechange', function() {
          var State = History.getState();
          console.log(State);
          content = State.data;
          app.loadContent(State.url, $container);
        });
        if ('scrollRestoration' in history) {
          history.scrollRestoration = 'manual';
        }
        $('#intro').click(function(event) {
          event.preventDefault();
          app.hideIntro();
        });
        $(document).bind('mousewheel', function(evt) {
          if (intro) {
            var delta = evt.originalEvent.wheelDelta;
            if (delta < -10) {
              app.hideIntro();
            }
          }
        });
        $('body').on('click', '[data-target]', function(e) {
          $el = $(this);
          target = $el.data('target');
          e.preventDefault();
          if (Modernizr.localstorage && $('#container .inner').hasClass('work')) {
            localStorage.setItem('scrollTop-' + $('#container .inner.work').data('id'), $(window).scrollTop());
          }
          if (target == "project") {
            $body.addClass('page');
            History.pushState({
              type: 'project'
            }, $el.data('title') + " | " + $sitetitle, $el.attr('href'));
          } else if (target == "about") {
            $body.addClass('page');
            History.pushState({
              type: 'about'
            }, $el.data('title') + " | " + $sitetitle, $el.attr('href'));
          } else {
            app.goIndex();
          }
        });
        $body.on('click', '[data-filter].filter', function(e) {
          e.preventDefault();
          el = $(this);
          if (el.hasClass('active')) {
            el.removeClass('active');
            $projects.removeClass('disabled');
            return;
          }
          var filter = el.data('filter');
          $filters.removeClass('active');
          el.addClass('active');
          $projects.addClass('disabled');
          $('.project[data-filter*="' + filter + '"]').removeClass('disabled');
        });
        $body.on('click', '.inner.work', function(e) {
          if (e.target !== this) return;
          $filters.removeClass('active');
          $projects.removeClass('disabled');
        });
        $body.on('click', '.kirby-plugin-oembed__thumb', function(event) {
          event.preventDefault();
          var wrapper = $(this).parent();
          var embed = wrapper.find('iframe');
          embed.attr('src', embed.data('src'));
          $(this).remove();
        });
        $(document).keyup(function(e) {
          //esc
          if (e.keyCode === 27) app.goIndex();
          //left
          if (e.keyCode === 37 && $slider) app.goPrev($slider);
          //right
          if (e.keyCode === 39 && $slider) app.goNext($slider);
        });
        $(window).load(function() {
          app.loadHomeGrid();
          app.embed();
          setTimeout(function() {
            $body.addClass('loaded');
          }, 200);
          setTimeout(function() {
            app.hideIntro();
          }, 1200);
        });
      });
    },
    hideIntro: function() {
      if ($body.hasClass('intro')) {
        $body.addClass('intro-start');
        setTimeout(function() {
          $body.attr('class', 'loaded');
        }, 4500);
      }
      intro = false;
    },
    loadHomeGrid: function() {
      $projects = $('.project');
      $filters = $('.filter');
      $grid = $('#project-list').packery({
        itemSelector: '.project',
        gutter: '.gutter-sizer',
        percentPosition: true,
        transitionDuration: 0
      });
      app.mouseNav();
    },
    sizeSet: function() {
      width = $(window).width();
      height = $(window).height();
      if (width <= 770 || Modernizr.touch)
        isMobile = true;
      if (isMobile) {
        if (width >= 770) {
          //location.reload();
          isMobile = false;
        }
      }
    },
    goIndex: function() {
      History.pushState({
        type: 'index'
      }, $sitetitle, window.location.origin + $root);
    },
    mouseNav: function(event) {
      if (!isMobile) {
        $mouse = $('#mouse-title');
        $("#project-list").on("mousemove", function(event) {
          posX = event.pageX;
          posY = event.pageY;
          $mouse.css({
            top: posY,
            left: posX
          });
        });
        $projects.not('.image-only').hover(function() {
          $mouse.html('<span>' + $(this).data('title') + '</span>');
        }, function() {
          $mouse.html('');
        });
      }
    },
    embed: function() {
      var pluginEmbedLoadLazyVideo = function() {
        var wrapper = this.parentNode;
        var embed = wrapper.children[0];
        var script = wrapper.querySelector('script');
        // embed.src = script ? script.getAttribute('data-src')+'&autoplay=1' : embed.getAttribute('src')+'&autoplay=1';
        wrapper.removeChild(this);
      };

      var thumb = document.getElementsByClassName('embed__thumb');

      for (var i = 0; i < thumb.length; i++) {
        thumb[i].addEventListener('click', pluginEmbedLoadLazyVideo, false);
      }
    },
    loadContent: function(url, target) {
      $body.removeClass('loaded').addClass('loading');
      setTimeout(function() {
        $(window).scrollTop(0);
        $(target).load(url + ' #container .inner', function(response) {
          setTimeout(function() {
            if (typeof content.type == typeof undefined || content.type == 'index') {
              $body.attr('class', 'loaded');
              app.loadHomeGrid();
              if (Modernizr.localstorage) {
                var id = $('#container .inner.work').data('id');
                var scrollTop = localStorage.getItem('scrollTop-' + id) || 0;
                console.log('GET: ' + 's-' + id + "= " + scrollTop);
                $(window).scrollTop(scrollTop);
              }
            } else if (content.type == 'about') {
              $body.attr('class', 'page with-names loaded');
            } else {
              $body.attr('class', 'page loaded');
            }
            app.embed();
          }, 100);
        });
      }, 700);
    },
  };
  app.init();
});