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

  // Fetch Products
  fetch('fetch_products.php')
    .then(response => response.json())
    .then(products =>
    {
      if (products.error)
      {
        console.error(products.error);
        return;
      }
      const productContainer = document.getElementById('product-container');
      productContainer.innerHTML = products.map(product =>
      {
        const price = parseFloat(product.price); // Ensure price is treated as a number
        return `
                  <div class="pro" onclick="window.location.href='product-${product.id}.html'">
                      <img src="${product.image_url}" alt="${product.name}" />
                      <div class="description">
                          <h3>${product.name}</h3>
                          <div class="star">
                              ${'<i class="fas fa-star"></i>'.repeat(product.rating)}
                              ${'<i class="fas fa-star"></i>'.repeat(5 - product.rating)}
                          </div>
                          <h4>$${price.toFixed(2)}</h4>
                      </div>
                      <a href="#" class="cart"><i class="fa-solid fa-cart-arrow-down"></i></a>
                  </div>
              `;
      }).join('');
    })
    .catch(error => console.error('Error fetching products:', error));

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
