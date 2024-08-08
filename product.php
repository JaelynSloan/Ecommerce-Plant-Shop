<?php
include 'database.php';
include 'session_handler.php';

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

ob_start();


$handler = new MySessionHandler($con);
session_set_save_handler($handler, true);
session_start();

$isLoggedIn = isset($_SESSION['user_id']);
echo '<!-- Debug Info: User ID: ' . ($_SESSION['user_id'] ?? 'Not set') . ' -->';

$logoutMessage = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

ob_end_flush();
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
    <script src="product.js" defer></script>
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
                    <li><a class="active" href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="deals.php">Deals</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li>
                        <a href="cart.php" id="cart"><i class="fa-solid fa-basket-shopping"></i></a>
                    </li>
                    <li>
                    <?php if ($isLoggedIn): ?>
                    <a href="logout.php" class="sign_out">sign out</a>
                <?php else: ?>
                    <a href="login.html" class="sign_in">sign in</a>
                <?php endif; ?>
                    </li>
                    <a href="login.html" id="close"><i class="fa-solid fa-xmark"></i></a>
                </ul>
            </div>
            <div id="mobile">
                <a href="cart.php" id="cart"><i class="fa-solid fa-basket-shopping"></i></a>
                <i id="bar"><i class="fa-solid fa-bars"></i></i>
            </div>
        </div>
    </header>

    <?php if ($logoutMessage): ?>
        <div id="logoutPopup" class="popup">
            <div class="popup-content">
                <h1 id="popupMessage"><?php echo $logoutMessage; ?></h1>
                <button id="closePopupLogout">Close</button>
            </div>
        </div>
    <?php endif; ?>

    <!-- PRODUCT DETAILS -->
    <main>
    <section id="prodetails" class="section-p1">
        <div class="pro-img">
            <img id="mainImg" src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="100%">
            <div class="small-img-group" id="smallImgs">
            </div>
        </div>
        <div class="pro-details">
            <button class="normal" onclick="history.back()">Back</button>
            <h4 id="productName"><?php echo htmlspecialchars($product['name']); ?></h4>
            <h2 id="productPrice">$<?php echo number_format($product['price'], 2); ?></h2>
            <input type="number" value="1">
            <button class="normal">Add to Cart</button>
            <br></br>
            <span id="productDescription"><?php echo nl2br(htmlspecialchars($product['description'])); ?></span>
        </div>
    </section>
</main>

    


    <!-- RELATED ITEMS -->


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

        function setMainImage(src)
        {
            mainImg.src = src;
        }

        function addSmallImage(src)
        {
            var imgCol = document.createElement('div');
            imgCol.classList.add('small-img-col');
            var img = document.createElement('img');
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
    </script>

<script>
        document.addEventListener("DOMContentLoaded", function() {
            var logoutPopup = document.getElementById("logoutPopup");
            var closePopup = document.getElementById("closePopupLogout");

            // Show the popup if there's a logout message
            <?php if ($logoutMessage): ?>
                logoutPopup.style.display = "block";
            <?php endif; ?>

            // Close the popup when the close button is clicked
            closePopup.onclick = function() {
                logoutPopup.style.display = "none";
            };

            // Close the popup if the user clicks anywhere outside the popup
            window.onclick = function(event) {
                if (event.target == logoutPopup) {
                    logoutPopup.style.display = "none";
                }
            };
        });
    </script>
</body>

</html>

<?php
$con->close();
?>