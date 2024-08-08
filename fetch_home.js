document.addEventListener("DOMContentLoaded", function ()
{
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
      const productContainer = document.getElementById('product-container-home');
      // Display only the first 8 products
      const firstEightProducts = products.slice(0, 8);
      productContainer.innerHTML = firstEightProducts.map(product =>
      {
        const price = parseFloat(product.price); // Ensure price is treated as a number
        const rating = parseInt(product.rating); // Ensure rating is treated as an integer
        const totalStars = 5;

        // Create star rating markup
        const stars = Array.from({ length: totalStars }, (_, index) =>
        {
          return index < rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
        }).join('');

        return `
      <div class="pro" onclick="window.location.href='product.php?id=${product.id}'">
        <img src="${product.image_url}" alt="${product.name}" />
        <div class="description">
          <p class="prod-name">${product.name}</p>
          <div class="star">${stars}</div>
          <p class="prod-price">$${price.toFixed(2)}</p>
        </div>
        <a href="#" class="cart"><i class="fa-solid fa-cart-arrow-down"></i></a>
      </div>
    `;
      }).join('');
    })
    .catch(error => console.error('Error fetching products:', error));
});
