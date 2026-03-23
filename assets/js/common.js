"use strict";
$(function () {
  //var
  var $w = $(window);
  var $header = $("#header");
  var $wrapper = $("#wrapper");
  var ua = navigator.userAgent;
  //function
  /*.hoverを追加する関数*/
  function addHover(element) {
    element
      .on("touchstart mouseenter", function () {
        $(this).addClass("hover");
      })
      .on("touchend mouseleave click", function () {
        $(this).removeClass("hover");
      });
  }

  /* hoverArr = [] の [] に.hoverをつけたい要素を$('.aaa')の形でいれてください */
  var hoverArr = [$("a"), $(".all_slide_control_btn")];
  for (var i = 0; i < hoverArr.length; i++) {
    addHover(hoverArr[i]);
  }

  //effects
  //固定ヘッダーがある場合のページ内アンカー
  //a[href^="#"]:not(".bbb")と書けば.bbbのクラスを持つものは除外されます。
  $(document).on("click", 'a[href^="#"]', function () {
    var $this = $(this);
    var target = $($this.attr("href")).offset().top;
    if (window.innerWidth <= 768) {
      $("html,body").animate({ scrollTop: target - 60 }, 400);
    } else {
      $("html,body").animate({ scrollTop: target - 100 }, 400);
    }
    return false;
  });

  //固定ヘッダーがある場合のページ内アンカー（ロード時）
  $(window).on("load", function () {
    if (location.hash) {
      var hashTarget = location.hash;
      var target = $(hashTarget).offset().top;
      if (window.innerWidth <= 768) {
        $("html,body").animate({ scrollTop: target - 60 }, 100);
      } else {
        $("html,body").animate({ scrollTop: target - 100 }, 100);
      }
    }
    return false;
  });

  // Mobile hamburger: off-canvas menu is handled by header-offcanvas.js (.js-evoluer-offcanvas-open on .header_nav_button).
  $(window).on("load resize orientationchange", function () {
    var wW = window.innerWidth;
    var $headerButton = $(".header_list_has_under");
    var $headerUnder = $(".header_list_sub");
    if (wW <= 1024) {
      $headerButton.off(".headerOpen");
      $headerButton.on("click.headerOpen", function () {
        var $this = $(this);
        var $target = $this.closest("li").find(".header_list_sub");
        if ($target.css("display") == "block") {
          $this.removeClass("open");
          $target.slideUp(400);
        } else {
          $this.addClass("open");
          $target.slideDown(400);
        }
      });
    }
  });
  window.addEventListener("scroll", function () {
    var header = document.querySelector("header");
    header.classList.toggle("scroll-nav", window.scrollY > 0);
  });
  window.addEventListener("scroll", function () {
    var header = document.querySelector("#header");
    header.classList.toggle("scroll-nav", window.scrollY > 0);
  });
  $(function() {
    $('#menu li').hover(function() {
      $(this).find('.menu_contents').stop().slideDown();
    }, function() {
      $(this).find('.menu_contents').stop().slideUp();
    });
  });
});