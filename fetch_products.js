document.addEventListener("DOMContentLoaded", function () {
    // Fetch Products
    fetch('fetch_products.php')
        .then(response => response.json())
        .then(products => {
            if (products.error) {
                console.error(products.error);
                return;
            }
            const productContainer = document.getElementById('product-container');
            productContainer.innerHTML = products.map(product => {
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
});