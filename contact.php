<?php
ob_start();

include 'database.php'; 
include 'session_handler.php';

$handler = new MySessionHandler($con);
session_set_save_handler($handler, true);
session_start();

$isLoggedIn = isset($_SESSION['user_id']);
echo '<!-- Debug Info: User ID: ' . ($_SESSION['user_id'] ?? 'Not set') . ' -->';

$logoutMessage = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

$cartCount = 0;
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $stmt = $con->prepare("SELECT SUM(quantity) FROM cart_items WHERE cart_id IN (SELECT cart_id FROM carts WHERE user_id = ?)");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->bind_result($cartCount);
    $stmt->fetch();
    $stmt->close();
} else {
    $sessionId = session_id();
    $stmt = $con->prepare("SELECT SUM(quantity) FROM cart_items WHERE cart_id IN (SELECT cart_id FROM carts WHERE session_id = ?)");
    $stmt->bind_param('s', $sessionId);
    $stmt->execute();
    $stmt->bind_result($cartCount);
    $stmt->fetch();
    $stmt->close();
}

$cartCount = $cartCount ? $cartCount : 0;

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Jaelyn's Plant Shop</title>
  <link rel="stylesheet" href="style.css" />
  <script src="script.js" defer></script>
  <script src="cart_count.js"></script>
  <script src="https://kit.fontawesome.com/3e4d0c6727.js" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Poppins:wght@100;200;300;400;500;600;700&display=swap"
    rel="stylesheet" />
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="deals.php">Deals</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a class="active" href="contact.php">Contact Us</a></li>
                    <li>
                        <a href="cart.php" id="cart">
                            <i class="fa-solid fa-basket-shopping"></i>
                            <span id="cart-count"><?php echo $cartCount; ?></span>
                          </a>
                    </li>
                    <li>
                    <?php if ($isLoggedIn): ?>
                    <a href="logout.php" class="sign_out">sign out</a>
                <?php else: ?>
                    <a href="login.html" class="sign_in">sign in</a>
                <?php endif; ?>
                    </li>
                    <a id="close"><i class="fa-solid fa-xmark"></i></a>
                </ul>
            </div>
            <div id="mobile">
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


  <!-- CONTACT FORM -->
  <section id="contact-form">
    <form id="contactForm">
      <span>Leave a Message</span>
      <h2>We would love to hear from you!</h2>
      <input type="text" name="name" placeholder="Your Name" required />
      <input type="email" name="email" placeholder="Your Email" required />
      <textarea name="message" cols="30" rows="10" placeholder="Your Message" required></textarea>
      <button type="submit" class="normal">Submit</button>
      <div id="formMessage"></div>
    </form>
  </section>

  <!-- CONTACT DETAILS -->
  <section id="contact-details" class="section-p1">
    <div class="details">
      <h2>Visit our locations</h2>
      <h3>Main Office</h3>
      <div class="icon">
        <li>
          <i class="fa-regular fa-map"></i>
          <p>123 Address Rd</p>
        </li>
        <li>
          <i class="fa-regular fa-envelope"></i>
          <p>
            <a href="mailto:inquiries@jaelyn.io">inquiries@jaelyn.io</a>
          </p>
        </li>

        <li>
          <i class="fa-solid fa-phone"></i>
          <p>123.456.7980</p>
        </li>
        <li>
          <i class="fa-regular fa-clock"></i>
          <p>10:00a - 10:00p Mon - Sat</p>
        </li>
      </div>
    </div>
    <div class="map">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2916.15261196383!2d-71.45422630958714!3d43.03822041757962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e24595182c672d%3A0x1af9c9f4bffd579e!2sSouthern%20New%20Hampshire%20University!5e0!3m2!1sen!2sus!4v1693631412177!5m2!1sen!2sus"
        width="600" height="450" style="border: 0" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </section>

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
          <a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook"></i></a>
          <a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
          <a href="https://www.twitter.com/" target="_blank"><i class="fa-brands fa-twitter"></i></a>
          <a href="https://www.pinterest.com/" target="_blank"><i class="fa-brands fa-pinterest"></i></a>
          <a href="https://www.youtube.com/" target="_blank"><i class="fa-brands fa-youtube"></i></a>
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
        <a href="https://www.apple.com/app-store/" target="_blank"><img src="images/app.jpg" alt="" /></a>
        <a href="https://play.google.com/store/games?hl=en_US&gl=US" target="_blank"><img src="images/play.jpg"
            alt="" /></a>
      </div>
      <p>Secure Payment Methods</p>
      <img src="images/pay.png" alt="" />
    </div>
    <div class="copyright">
      <p>&copy; 2023, Jaelyn Sloan - Ecommerce Website</p>
    </div>
  </footer>

  <script>
    document.addEventListener("DOMContentLoaded", function ()
    {
      var form = document.getElementById("contactForm");
      form.addEventListener("submit", handleFormSubmit);
    });

    function handleFormSubmit(event)
    {
      event.preventDefault(); 

      var form = document.getElementById("contactForm");
      var formData = new FormData(form);

      var xhr = new XMLHttpRequest();
      xhr.open("POST", "submit_contact.php", true);
      xhr.onload = function ()
      {
        var response = JSON.parse(xhr.responseText);
        var msgElement = document.getElementById("formMessage");

        if (xhr.status === 200 && response.success)
        {
          form.reset(); 
          msgElement.textContent = response.message;
          msgElement.style.color = "green";
        } else
        {
          msgElement.textContent = response.message;
          msgElement.style.color = "red";
        }
      };
      xhr.send(formData);
    }
  </script>

<script>
        document.addEventListener("DOMContentLoaded", function() {
            var logoutPopup = document.getElementById("logoutPopup");
            var closePopup = document.getElementById("closePopupLogout");

            <?php if ($logoutMessage): ?>
                logoutPopup.style.display = "block";
            <?php endif; ?>

            closePopup.onclick = function() {
                logoutPopup.style.display = "none";
            };

            window.onclick = function(event) {
                if (event.target == logoutPopup) {
                    logoutPopup.style.display = "none";
                }
            };
        });
    </script>

</body>

</html>