/* eslint-disable consistent-return */
/* eslint-disable class-methods-use-this */
import { Controller } from "stimulus";
// import throttle from "lodash/throttle";

export default class extends Controller {
  static targets = [
    "name",
    "email",
    "phone",
    "msg",
    "nameError",
    "emailError",
    "phoneError",
    "msgError",
    "response"
  ];

  validate() {
    const name = this.nameTarget;
    const email = this.emailTarget;
    const phone = this.phoneTarget;
    const msg = this.msgTarget;
    const nameError = this.nameErrorTarget;
    const emailError = this.emailErrorTarget;
    const phoneError = this.phoneErrorTarget;
    const msgError = this.msgErrorTarget;

    let hasErrors = false;

    if (!name.validity.valid) {
      nameError.innerHTML = "There is an error with this field.";
      hasErrors = true;
    } else {
      nameError.innerHTML = "";
    }
    if (!email.validity.valid) {
      emailError.innerHTML = "There is an error with this field.";
      hasErrors = true;
    } else {
      emailError.innerHTML = "";
    }
    if (!phone.validity.valid) {
      phoneError.innerHTML = "There is an error with this field.";
      hasErrors = true;
    } else {
      phoneError.innerHTML = "";
    }
    if (!msg.validity.valid) {
      msgError.innerHTML = "There is an error with this field.";
      hasErrors = true;
    } else {
      msgError.innerHTML = "";
    }

    if (hasErrors === false) {
      return true;
    }
    if (hasErrors === false) {
      return false;
    }
  }

  submit(e) {
    e.preventDefault();
    if (this.validate()) {
      const form = this.element;
      const formData = new FormData(form);
      fetch(form.action, {
        method: "POST",
        body: formData
      })
        .then(res => res.json())
        .then(() => {
          this.responseTarget.innerText =
            "Thank you for submitting our form! Someone from our office will be in touch shortly.";
          this.postCallRail(formData);
          const event = new Event("nextlevel_email_sent");
          document.dispatchEvent(event);
          setTimeout(() => {
            this.responseTarget.innerHTML = "";
          }, 5000);
          form.reset();
        })
        .catch(() => {
          this.responseTarget.innerText =
            "There was an error submitting the form. Please try again.";
          setTimeout(() => {
            this.responseTarget.innerHTML = "";
          }, 5000);
        });
    }
  }

  postCallRail(formData) {
    const myHeaders = new Headers();
    myHeaders.append(
      "Authorization",
      "Token token=ded74cf6b8a2afb69f54fbfc047c1930"
    );
    myHeaders.append("Content-Type", "application/json");

    let ref = "";
    if (document.referrer !== "") {
      ref = document.referrer;
    } else {
      ref = "direct";
    }

    const raw = JSON.stringify({
      form_submission: {
        company_id: "REPLACE_ME",
        referrer: ref,
        referring_url: ref,
        landing_page_url: window.location.href,
        form_url: window.location.href,
        form_data: Object.fromEntries(formData)
      }
    });

    const requestOptions = {
      method: "POST",
      headers: myHeaders,
      body: raw,
      redirect: "follow"
    };

    fetch(
      "https://api.callrail.com/v3/a/332030600/form_submissions.json",
      requestOptions
    )
      .then(response => response.text())
      .then(result => console.log(result))
      .catch(error => console.log("error", error));
  }
}
