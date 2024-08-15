function updateCartCount(newCount)
{
    console.log("Updating cart count to: " + newCount);
    document.getElementById('cart-count').innerText = newCount;
}


// Example of adding an item to the cart using AJAX
function addToCart(productId)
{
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ product_id: productId })
    })
        .then(response => response.json())
        .then(data =>
        {
            if (data.status === 'success')
            {
                // Update the cart count in the navbar
                updateCartCount(data.cartCount);
            } else
            {
                console.error('Failed to update cart:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}
