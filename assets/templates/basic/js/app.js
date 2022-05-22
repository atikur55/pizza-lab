'use strict';

$(document).ready(function () {
  //preloader
  $(".preloader").delay(300).animate({
    "opacity": "0"
  }, 300, function () {
    $(".preloader").css("display", "none");
  });
});

// Sticky Menu
window.addEventListener('scroll', function () {
  var header = document.querySelector('.header__bottom');
  header.classList.toggle('sticky', window.scrollY > 0);

});

// mobile menu js
$(".navbar-collapse>ul>li>a, .navbar-collapse ul.sub-menu>li>a").on("click", function () {
  const element = $(this).parent("li");
  if (element.hasClass("open")) {
    element.removeClass("open");
    element.find("li").removeClass("open");
  }
  else {
    element.addClass("open");
    element.siblings("li").removeClass("open");
    element.siblings("li").find("li").removeClass("open");
  }
});

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

new WOW().init();

// lightcase plugin init
$('a[data-rel^=lightcase]').lightcase();

$('.sidebar-open-btn').on('click', function () {
  $('.sidebar-overlay').addClass('active');
});

$('.sidebar-close-btn').on('click', function () {
  $('.sidebar-overlay').removeClass('active');
});

$('.user-sidebar-close').on('click', function () {
  $('.user-sidebar-overlay').removeClass('active');
});



// category-slider js 
$('.category-slider').slick({
  infinite: true,
  slidesToShow: 4,
  slidesToScroll: 1,
  dots: false,
  arrows: true,
  prevArrow: '<div class="prev"><i class="las la-long-arrow-alt-left"></i></div>',
  nextArrow: '<div class="next"><i class="las la-long-arrow-alt-right"></i></div>',
  autoplay: true,
  cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
  speed: 1000,
  autoplaySpeed: 2000,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 2,
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
      }
    }
  ]
});

// testimonial-slider js 
$('.testimonial-slider').slick({
  infinite: true,
  slidesToShow: 1,
  slidesToScroll: 1,
  dots: true,
  arrows: false,
  autoplay: true,
  cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
  speed: 2000,
  autoplaySpeed: 1000
});



$('.pizza-details-slider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.pizza-nav-slider'
});
$('.pizza-nav-slider').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  asNavFor: '.pizza-details-slider',
  dots: false,
  centerMode: false,
  centerPadding: '0px',
  focusOnSelect: true,
  arrows: true,
  prevArrow: '<div class="prev"><i class="las la-long-arrow-alt-left"></i></div>',
  nextArrow: '<div class="next"><i class="las la-long-arrow-alt-right"></i></div>',
});

$('.sidebar-toggler').on('click', function () {
  $('.user-sidebar-overlay').toggleClass('active')

})


$('.search-toggler').on('click', function () {
  $('.header-search-form').toggleClass('active')
  $(this).toggleClass('active')
  $('.header-search-form .form--control').focus();
})