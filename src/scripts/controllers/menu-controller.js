/* eslint-disable no-restricted-syntax */
/* eslint-disable class-methods-use-this */
import { Controller } from "stimulus";
import anime from "animejs";

export default class extends Controller {
  static targets = ["progress", "mobileBtn", "mobileMenu"];

  connect() {
    this.checkTransitions();
    window.onscroll = () => {
      if (window.scrollY != 0) {
        this.element.classList.add("scrolled");
      } else {
        this.element.classList.remove("scrolled");
      }
      this.progressTarget.style.width = `${this.getScrollPercent()}%`;
      this.checkTransitions();
    };
  }

  toggle() {
    this.mobileBtnTarget.classList.toggle("active");
    this.mobileMenuTarget.classList.toggle("active");
  }

  getScrollPercent() {
    const h = document.documentElement,
      b = document.body,
      st = "scrollTop",
      sh = "scrollHeight";
    return ((h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight)) * 100;
  }

  inViewport(el) {
    const { top, bottom } = el.getBoundingClientRect();
    const vHeight = window.innerHeight || document.documentElement.clientHeight;

    return (top > 0 || bottom > 0) && top < vHeight;
  }

  async checkTransitions() {
    Array.from(document.querySelectorAll(".fade-up")).forEach((el) => {
      if (this.inViewport(el)) {
        el.classList.remove("fade-up");
        el.classList.add("faded");
      }
    });

    Array.from(document.querySelectorAll(".fade-right")).forEach((el) => {
      if (this.inViewport(el)) {
        el.classList.remove("fade-right");
        el.classList.add("faded");
      }
    });

    Array.from(document.querySelectorAll(".fade-down")).forEach((el) => {
      if (this.inViewport(el)) {
        el.classList.remove("fade-down");
        el.classList.add("faded");
      }
    });
    Array.from(document.querySelectorAll(".fade-left")).forEach((el) => {
      if (this.inViewport(el)) {
        el.classList.remove("fade-left");
        el.classList.add("faded");
      }
    });
  }
}
