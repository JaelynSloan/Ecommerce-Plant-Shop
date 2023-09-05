// Mobile Navbar
const bar = document.getElementById("bar");
const close = document.getElementById("close");
const nav = document.getElementById("navbar");

if (bar) {
  bar.addEventListener("click", () => {
    nav.classList.add("active");
  });
}

if (close) {
  close.addEventListener("click", () => {
    nav.classList.remove("active");
  });
}

// Newsletter
const signUp = document.getElementById("signUp");
const popup = document.getElementById("popup");
const closePopup = document.getElementById("closePopup)");

signUp.addEventListener("click", function () {
  popup.classList.add("show");
});
closePopup.addEventListener("click", function () {
  popup.classList.remove("show");
});
window.addEventListener("click", function (event) {
  if (event.target == popup) {
    popup.classList.remove("show");
  }
});
