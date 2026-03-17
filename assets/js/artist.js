"use strict";

$('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  asNavFor: '.slider-for',
  dots: false,
  autoplay: true,
  autoplaySpeed: 4000,
  focusOnSelect: true,
});
$('.artist_newssbox').slick({
  mobileFirst: true,
  slidesToShow: 1,
  slidesToScroll: 1,
  prevArrow: '<img src="http://www.evoluer.jp/cms/wp-content/themes/evoluer/assets/images/arrow-left.png" class="slide-arrow prev-arrow" alt="prev">',
  nextArrow: '<img src="http://www.evoluer.jp/cms/wp-content/themes/evoluer/assets/images/arrow-right.png" class="slide-arrow next-arrow" alt="next">',
  arrows: true,
  dots:true,
  infinite: false,
  responsive: [{
    breakpoint: 768,
    settings: 'unslick'
  }]
});
//リサイズした時に実行
$(window).on('resize orientationchange', function () {
  $('.artist_newssbox').slick('resize');
});

// tab切り替え
$(function () {
  let tabs = $(".tab");
  $(".tab").on("click", function () {
    $(".active").removeClass("active");
    $(this).addClass("active");
    const index = tabs.index(this);
    $(".s_content").removeClass("show").eq(index).addClass("show");
  });
});

// アコーディオン
$(function () {
  $('.js_accd').on('click', function () {
    /*クリックでコンテンツを開閉*/
    $(this).next().slideToggle();
    $(this).toggleClass('open');
    return false;
  });
});