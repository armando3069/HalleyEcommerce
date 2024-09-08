var multipleCardCarousel = document.querySelector("#carouselExampleControls");

if (window.matchMedia("(min-width: 768px)").matches) {
  var carousel = new bootstrap.Carousel(multipleCardCarousel, {
    interval: false,
  });

  var carouselInner = document.querySelector(".carousel-inner");
  var cardItems = document.querySelectorAll(".carousel-item");
  var cardWidth = cardItems[0].offsetWidth;
  var scrollPosition = 0;

  document
    .querySelector("#carouselExampleControls .carousel-control-next")
    .addEventListener("click", function () {
      if (scrollPosition < carouselInner.scrollWidth - cardWidth * 3) {
        // Am schimbat 4 în 3 pentru a nu depăși limita
        scrollPosition += cardWidth;
        carouselInner.scrollTo({
          left: scrollPosition,
          behavior: "smooth",
        });
      }
    });

  document
    .querySelector("#carouselExampleControls .carousel-control-prev")
    .addEventListener("click", function () {
      if (scrollPosition > 0) {
        scrollPosition -= cardWidth;
        carouselInner.scrollTo({
          left: scrollPosition,
          behavior: "smooth",
        });
      }
    });
} else {
  $(multipleCardCarousel).addClass("slide");
}
