<?php
include 'database.php';

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

$product = $result->fetch_assoc();

if (!$product) {
    echo "Product not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="style.css" />
    <script src="https://kit.fontawesome.com/3e4d0c6727.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Poppins:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <script src="product_disc.js" defer></script>
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="header">
            <a href="index.php"><img src="images/logo.png" class="logo" /></a>
            <h1>Jaelyn's Plant Shop</h1>
            <div>
                <!--NAVBAR-->
                <ul id="navbar">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="deals.php">Deals</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li>
                        <a href="cart.php" id="cart"><i class="fa-solid fa-basket-shopping"></i></a>
                    </li>
                    <a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
                </ul>
            </div>
            <div id="mobile">
                <a href="cart.php" id="cart"><i class="fa-solid fa-basket-shopping"></i></a>
                <i id="bar"><i class="fa-solid fa-bars"></i></i>
            </div>
        </div>
    </header>

    <!-- PRODUCT DETAILS -->
    <main>
        <section id="prodetails" class="section-p1">
            <div class="pro-img">
                <img id="mainImg" src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="100%">
                <div class="small-img-group" id="smallImgs">
                    <?php
                    $small_images = [
                        $product['image2_url'],
                        $product['image3_url'],
                        $product['image4_url'],
                        $product['image5_url5']
                    ];

                    foreach ($small_images as $image) {
                        if (!empty($image)) {
                            echo '<div class="small-img-col">
                                    <img src="' . htmlspecialchars($image) . '" width="100" class="small-img" />
                                  </div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="pro-details">
                <button class="normal" onclick="history.back()">Back</button>
                <h4 id="productName"><?php echo htmlspecialchars($product['name']); ?></h4>
                <div id="priceContainer">
                    <h2 id="regularPrice">$<?php echo number_format($product['price'], 2); ?></h2> 
                    <h2 id="discountPrice">$<?php echo number_format($product['discount_price'], 2); ?></h2>
                </div>
                <input type="number" value="1">
                <button class="normal">Add to Cart</button>
                <br></br>
                <span id="productDescription"><?php echo nl2br(htmlspecialchars($product['description'])); ?></span>
            </div>
        </section>
    </main>

    <!--NEWSLETTER-->
    <section id="newsletter" class="section-p1">
        <div class="newstext">
            <h4>Sign Up For Our Newsletter</h4>
            <p>Get email updates and <span>special offers</span> daily, weekly, or monthly!</p>
        </div>
        <div class="form">
            <input type="text" id="emailInput" placeholder="Your Email Address">
            <button id="signUp" class="normal">Sign Up</button>
            <div id="popup" class="popup">
                <div class="popup-content">
                    <h1 id="popupMessage">You Have Successfully Been Signed Up!</h1>
                    <button id="closePopup">Close</button>
                </div>
            </div>
        </div>
    </section>

    <!--FOOTER-->
    <footer class="section-p1">
        <div class="col">
            <h4>Contact</h4>
            <p><strong>Address:</strong> 123 Address Rd</p>
            <p><strong>Phone:</strong> 123-456-7890</p>
            <p><strong>Hours:</strong> 10:00a - 10:00p Mon - Sat</p>
            <div class="follow">
                <h4>Follow us</h4>
                <div class="icon">
                    <a href="https://www.facebook.com/" target="_blank">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://www.twitter.com/" target="_blank">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="https://www.pinterest.com/" target="_blank">
                        <i class="fa-brands fa-pinterest"></i>
                    </a>
                    <a href="https://www.youtube.com/" target="_blank">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <h4>About</h4>
            <a href="about.php">About Us</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="contact.php">Contact Us</a>
        </div>
        <div class="col">
            <h4>My Account</h4>
            <a href="login.html">Sign In</a>
            <a href="cart.php">View Cart</a>
            <a href="#">Help</a>
        </div>
        <div class="col install">
            <h4>Install App</h4>
            <p>From App Store or Google Play</p>
            <div class="row">
                <a href="https://www.apple.com/app-store/" target="_blank">
                    <img src="images/app.jpg" alt="" />
                </a>
                <a href="https://play.google.com/store/games?hl=en_US&gl=US" target="_blank">
                    <img src="images/play.jpg" alt="" />
                </a>
            </div>
            <p>Secure Payment Methods</p>
            <img src="images/pay.png" alt="" />
        </div>
        <div class="copyright">
            <p>&copy; 2023, Jaelyn Sloan - Ecommerce Website</p>
        </div>
    </footer>
    <script>
        // Handle main and small images display
        var mainImg = document.getElementById("mainImg");
        var smallImgs = document.getElementById("smallImgs");

        function setMainImage(src) {
            mainImg.src = src;
        }

        // Add event listener to each small image
        document.querySelectorAll('.small-img').forEach(function(img) {
            img.addEventListener('click', function() {
                setMainImage(this.src);
            });
        });
    </script>
</body>
</html>

<?php
$con->close();
?>
