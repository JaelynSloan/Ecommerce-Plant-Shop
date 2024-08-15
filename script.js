document.addEventListener("DOMContentLoaded", function ()
{


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

  closePopup.addEventListener("click", function ()
  {
    popup.classList.remove("show");
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


  // Mobile Navbar 
  var barIcon = document.getElementById("bar");
  var navbar = document.getElementById("navbar");
  var closeButton = document.getElementById("close");

  barIcon.addEventListener("click", function ()
  {
    navbar.classList.toggle("show");
    closeButton.style.display = "block";
  });

  closeButton.addEventListener("click", function ()
  {
    navbar.classList.remove("show");
    closeButton.style.display = "none";
  });


  // // Drag-able scroll bar
  // const container = document.querySelector('#product1 .pro-container-home');

  // let isDown = false;
  // let startX;
  // let scrollLeft;

  // container.addEventListener('mousedown', (e) =>
  // {
  //   isDown = true;
  //   container.classList.add('active');
  //   startX = e.pageX - container.offsetLeft;
  //   scrollLeft = container.scrollLeft;
  // });

  // container.addEventListener('mouseleave', () =>
  // {
  //   isDown = false;
  //   container.classList.remove('active');
  // });

  // container.addEventListener('mouseup', () =>
  // {
  //   isDown = false;
  //   container.classList.remove('active');
  // });

  // container.addEventListener('mousemove', (e) =>
  // {
  //   if (!isDown) return;
  //   e.preventDefault();
  //   const x = e.pageX - container.offsetLeft;
  //   const walk = (x - startX) * 3; //scroll-fast
  //   container.scrollLeft = scrollLeft - walk;
  // });


});
