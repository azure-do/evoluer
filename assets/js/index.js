"use strict";
$(function () {
  // top
  $(window).on("load scroll", function () {
    var target = 0;
    if ($(".top").length) {
      target = $(".top_mv").innerHeight();
    }
  });
  //slick
  $(".multiple-item").slick({
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: true,
          dots: true,
          fade: false,
          speed: 1200,
          autoplay: true,
          autoplaySpeed: 6000,
          pauseOnHover: false,
          centerMode: false,
          prevArrow: '<img src="http://www.evoluer.jp/cms/wp-content/themes/evoluer/assets/images/arrow-left.png" class="slide-arrow prev-arrow" alt="prev">',
          nextArrow: '<img src="http://www.evoluer.jp/cms/wp-content/themes/evoluer/assets/images/arrow-right.png" class="slide-arrow next-arrow" alt="next">'
        },
      }
    ],
  });
  $(".slider-wrap").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    dots: false,
    fade: true,
    speed: 1200,
    autoplay: true,
    autoplaySpeed: 6000,
    pauseOnHover: false,
    centerMode: true,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
        },
      },
    ],
  });
});

