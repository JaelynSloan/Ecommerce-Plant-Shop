document.addEventListener("DOMContentLoaded", function ()
{
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    if (productId)
    {
        fetch(`fetch_prod_details.php?id=${productId}`)
            .then(response => response.json())
            .then(product =>
            {
                if (product.error)
                {
                    console.error(product.error);
                    return;
                }
                document.getElementById('productName').innerText = product.name;
                document.getElementById('productPrice').innerText = `$${parseFloat(product.price).toFixed(2)}`;
                document.getElementById('productDescription').innerText = product.description;
                setMainImage(product.image_url);

                const allImages = [product.image_url, ...product.additional_images];
                allImages.forEach(addSmallImage);
            })
            .catch(error => console.error('Error fetching product details:', error));
    }

    const addToCartButton = document.getElementById('addToCartButton');

    if (addToCartButton)
    {
        addToCartButton.addEventListener('click', function ()
        {
            const productId = this.getAttribute('data-id');

            // Add clicked class for animation
            this.classList.add('clicked');

            // Simulate adding to cart (actual add to cart function)
            addToCart(productId);

            // Remove the clicked class after a delay
            setTimeout(() =>
            {
                this.classList.remove('clicked');
            }, 1000); // Adjust timing as needed
        });
    }

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
                    // Update the cart count on the page
                    document.getElementById('cart-count').textContent = data.cartCount;
                } else
                {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }
});

function setMainImage(src)
{
    const mainImg = document.getElementById("mainImg");
    mainImg.src = src;
}

function addSmallImage(src)
{
    if (src)
    {  // Ensure src is valid
        const smallImgs = document.getElementById("smallImgs");
        const imgCol = document.createElement('div');
        imgCol.classList.add('small-img-col');
        const img = document.createElement('img');
        img.src = src;
        img.width = 100;
        img.classList.add('small-img');
        img.onclick = function ()
        {
            setMainImage(src);
        };
        imgCol.appendChild(img);
        smallImgs.appendChild(imgCol);
    }
}
