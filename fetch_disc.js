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
            const productContainer = document.getElementById('product-container');
            productContainer.innerHTML = products
                .filter(product => product.discount_price !== null) // Filter products with discount_price
                .map(product =>
                {
                    const price = parseFloat(product.price); // Ensure price is treated as a number
                    const discountPrice = parseFloat(product.discount_price); // Ensure discount_price is treated as a number
                    const rating = parseInt(product.rating); // Ensure rating is treated as an integer
                    const totalStars = 5;

                    // Create star rating markup
                    const stars = Array.from({ length: totalStars }, (_, index) =>
                    {
                        return index < rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                    }).join('');

                    return `
                        <div class="pro" onclick="window.location.href='product_disc.php?id=${product.id}'">
                            <img src="${product.image_url}" alt="${product.name}" />
                            <div class="description">
                                <h3>${product.name}</h3>
                                <div class="star">${stars}</div>
                                <h4><s>$${price.toFixed(2)}</s> $${discountPrice.toFixed(2)}</h4>
                            </div>
                            <a href="#" class="cart"><i class="fa-solid fa-cart-arrow-down"></i></a>
                        </div>
                    `;
                }).join('');
        })
        .catch(error => console.error('Error fetching products:', error));
});
