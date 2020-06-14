/* eslint-disable no-restricted-syntax */
/* eslint-disable class-methods-use-this */
import { Controller } from "stimulus";
import Glide from "@glidejs/glide";
import anime from "animejs";
export default class extends Controller {
  static targets = ["progress"];
  connect() {
    let delay = parseInt(this.element.getAttribute("data-delay")) * 1000;
    if (!delay) {
      delay = 8000;
    }
    const slider = new Glide(this.element, {
      type: "carousel",
      startAt: 0,
      perView: 1,
      autoplay: false,
      gap: 0,
    }).mount();

    const totalSlides = Array.from(
      this.element.querySelectorAll(".glide__slide:not(.glide__slide--clone)")
    ).length;

    let animation = anime({
      targets: this.progressTarget,
      height: `${100 / totalSlides}%`,
      easing: "linear",
      duration: delay,
      complete: () => {
        slider.go(">");
      },
    });

    slider.on("run", (e) => {
      const cur = this.element.querySelector(".glide__slide--active");
      let currentSlide = parseInt(cur.getAttribute("data-slide")) + 1;
      if (e.direction === "<") currentSlide -= 2;
      else if (currentSlide > totalSlides) currentSlide = 1;
      if (currentSlide <= 0) currentSlide = totalSlides;
      const targetHeight = `${(currentSlide * 100) / totalSlides}%`;

      animation.pause();
      this.progressTarget.style.height = `${((currentSlide - 1) * 100) /
        totalSlides}%`;

      animation = anime({
        targets: this.progressTarget,
        height: targetHeight,
        easing: "linear",
        duration: delay,
        complete: () => {
          slider.go(">");
        },
      });
    });
  }
}
