document.addEventListener("DOMContentLoaded", function ()
{
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
            productContainer.innerHTML = products
                .filter(product => product.discount_price !== null)
                .map(product =>
                {
                    const price = parseFloat(product.price);
                    const discountPrice = parseFloat(product.discount_price);
                    const rating = parseInt(product.rating);
                    const totalStars = 5;

                    const stars = Array.from({ length: totalStars }, (_, index) =>
                    {
                        return index < rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                    }).join('');

                    return `
                        <div class="pro">
                            <img src="${product.image_url}" alt="${product.name}" onclick="window.location.href='product_disc.php?id=${product.product_id}'" />
                            <div class="description">
                                <h3 onclick="window.location.href='product.php?id=${product.product_id}'">${product.name}</h3>
                                <div class="star">${stars}</div>
                                <h4 class="disc_price"><s>$${price.toFixed(2)}</s> $${discountPrice.toFixed(2)}</h4>
                            </div>
                            <a class="cart" data-id="${product.product_id}"><i class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                    `;
                }).join('');
            // Add event listener for the cart button
            const cartButtons = document.querySelectorAll('.cart');
            cartButtons.forEach(button =>
            {
                button.addEventListener('click', function (e)
                {
                    e.preventDefault();
                    const productId = this.getAttribute('data-id');
                    this.classList.add('clicked');
                    // Remove the 'clicked' class after a delay
                    setTimeout(() =>
                    {
                        this.classList.remove('clicked');
                    }, 1000); // 1 second delay before reverting the icon
                    addToCart(productId);
                });
            });
        })
        .catch(error => console.error('Error fetching products:', error));
});


