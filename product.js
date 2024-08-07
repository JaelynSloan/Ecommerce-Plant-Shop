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

                // Include the main image in the additional images array
                const allImages = [product.image_url, ...product.additional_images];
                allImages.forEach(addSmallImage);
            })
            .catch(error => console.error('Error fetching product details:', error));
    }
});

function setMainImage(src)
{
    const mainImg = document.getElementById("mainImg");
    mainImg.src = src;
}

function addSmallImage(src)
{
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
