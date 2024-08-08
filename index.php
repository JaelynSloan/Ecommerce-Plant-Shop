<?php
// Start output buffering
ob_start();

include 'database.php'; 
include 'session_handler.php';

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
    <title>Jaelyn's Plant Shop</title>
    <link rel="stylesheet" href="style.css" />
    <script src="https://kit.fontawesome.com/3e4d0c6727.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

</head>

<!-----BODY------>

<body>
    <!----HEADER----->
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



    <main>
        <section class="home-container">
            <div class="home-txt">
                <h1 class="head-txt">Unleash the beauty of nature in your home today! </h1>
                <p>Welcome to our green oasis! Discover a world of lush, vibrant plants that bring life and joy to any
                    space. Whether you're a seasoned gardener or just starting your plant journey, we have the perfect
                    greenery for you. From everyday favorites to exclusive deals, your next plant companion awaits.
                    Let's grow together!</p>
                <a href="deals.php">shop deals</a>
                <a href="shop.php">shop all</a>
            </div>
            <div class="home-img img-opacity">
                <div class="overlay"></div>
                <div class="swiper-txt">
                    <h4>Bring nature home with our stunning collection of plants!</h4>
                    <p>Shop from our diverse collection of beautiful flowers, succulents, cacti, and more to find the
                        perfect addition to your home.
                    </p>
                </div>

                <div class="swiper-wrapper-container">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide" onclick="window.location.href='product.php?id=4'">
                                <img src="images/Slides/succulent-s1.jpg" alt="image of succulent in pot" />
                            </div>
                            <div class="swiper-slide" onclick="window.location.href='product.php?id=5'">
                                <img src="images/Slides/flower-s2.jpg" alt="image of flowers" />
                            </div>
                            <div class="swiper-slide" onclick="window.location.href='product.php?id=11'">
                                <img src="images/Slides/bouquet-s3.jpg" alt="image of flower bouquet" />
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>

        </section>

        <!-- NEW ARRIVALS -->
        <section id="product1" class="section-p1">
            <h2>New Arrivals</h2>
            <div id="product-container-home" class="pro-container-home"></div>
        </section>

    </main>


    <!--BANNER-->
    <section id="banner" class="section-m1">
        <h4>Coming Soon</h4>
        <h3>More New Arrivals Coming October 1st!</h3>
        <h2>Up to <span>50% Off</span> on All Store Items</h2>
    </section>

    </main>

    <!--NEWSLETTER-->
    <section id="newsletter" class="section-p1">
        <div class="newstext">
            <h4>Sign Up For Our Newsletter</h4>
            <p>Get email updates and <span>special offers</span> daily, weekly, or monthly!</p>
        </div>
        <div class="form">
            <input type="email" id="emailInput" placeholder="Your Email Address" required>
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

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".swiper", {
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
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


    <script src="fetch_home.js"></script>
    <script src="script.js"></script>


</body>

</html>