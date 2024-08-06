document.addEventListener("DOMContentLoaded", function ()
{
  // Mobile Navbar
  const bar = document.getElementById("bar");
  const close = document.getElementById("close");
  const nav = document.getElementById("navbar");

  if (bar)
  {
    bar.addEventListener("click", () =>
    {
      nav.classList.add("active");
    });
  }

  if (close)
  {
    close.addEventListener("click", () =>
    {
      nav.classList.remove("active");
    });
  }

  // Newsletter Sign Up
  const signUp = document.getElementById("signUp");
  const closePopup = document.getElementById("closePopup");
  const popup = document.getElementById("popup");
  const popupMessage = document.getElementById("popupMessage");
  const emailInput = document.getElementById("emailInput");

  signUp.addEventListener("click", function (event)
  {
    event.preventDefault(); // Prevent form submission
    if (emailInput.checkValidity())
    {
      popupMessage.textContent = "You Have Successfully Been Signed Up!";
      popup.classList.add("show");
      emailInput.value = ""; // Clear the email input box
    } else
    {
      popupMessage.textContent = "Please enter a valid email address";
      popup.classList.add("show");
    }
  });

  closePopup.addEventListener("click", function ()
  {
    popup.classList.remove("show");
  });

  window.addEventListener("click", function (event)
  {
    if (event.target == popup)
    {
      popup.classList.remove("show");
    }
  });
});
