import "@stimulus/polyfills";
import { Application } from "stimulus";
import { definitionsFromContext } from "stimulus/webpack-helpers";
import anime from "animejs";

import { library, dom } from "@fortawesome/fontawesome-svg-core";
import {
  faFacebookF,
  faTwitter,
  faYoutube,
  faLinkedinIn,
  faInstagram,
  faGithub
} from "@fortawesome/free-brands-svg-icons";
import { faStar, faSpinnerThird } from "@fortawesome/pro-solid-svg-icons";
import LazyLoad from "vanilla-lazyload";

require("es6-promise").polyfill();
require("isomorphic-fetch");

const application = Application.start();
const context = require.context("./controllers", true, /\.js$/);
application.load(definitionsFromContext(context));

library.add(
  faFacebookF,
  faTwitter,
  faYoutube,
  faLinkedinIn,
  faInstagram,
  faStar,
  faSpinnerThird,
  faGithub
);

document.addEventListener("DOMContentLoaded", () => {
  dom.watch();

  document.querySelectorAll(".lazy:not([data-bg])").forEach(el => {
    const wrapper = document.createElement("div");
    const spinner = document.createElement("i");
    spinner.classList.add("fas");
    spinner.classList.add("fa-2x");
    spinner.classList.add("fa-spinner-third");
    spinner.classList.add("fa-spin");
    wrapper.appendChild(spinner);
    el.insertAdjacentElement("beforebegin", wrapper);
    wrapper.style.position = "absolute";
    wrapper.style.width = `${el.offsetWidth}px`;
    wrapper.style.height = `${el.offsetHeight}px`;
    wrapper.style.left = `${el.offsetLeft}px`;
    wrapper.style.top = `${el.offsetTop}px`;
    wrapper.style.display = "flex";
    wrapper.style.justifyContent = "center";
    wrapper.style.alignItems = "center";
  });

  // eslint-disable-next-line no-unused-vars
  const lazy = new LazyLoad({
    elements_selector: ".lazy",
    callback_loaded: el => {
      const spinner = el.previousSibling;
      spinner.remove();
    }
  });
});

window.onload = () => {
  const wp = document.querySelector("#wpadminbar");
  const header = document.querySelector(".header");

  if (wp && header) {
    header.style.marginTop = `${wp.offsetHeight}px`;
  }
};
