const swiper = new Swiper(".swiper", {
  autoplay: true,
  breakpoints: {
    376: {slidesPerView: 2}
  },
  centeredSlides: true,
  loop: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev"
  },
  slidesPerView: 1,
  spaceBetween: 16,
  speed: 1500,
  pagination: {
    el: '.swiper-pagination',
    type: 'progressbar',
    clickable: true
  },
});
