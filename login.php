<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form inputs
    $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "redstream_db";
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT password FROM registered_users WHERE email = ?");
    if (!$stmt) {
        die("Error: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, set session or do any other action
            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $email;
            // Check if "Remember Me" is checked
            if (isset($_POST["remember_me"]) && $_POST["remember_me"] === "1") {
                $cookie_name = "remember_me_cookie";
                $cookie_value = $email;
                $cookie_expiry = time() + (86400 * 30); // 30 days (86400 seconds per day)
                setcookie($cookie_name, $cookie_value, $cookie_expiry, "/");
            }
            // Redirect the user to the dashboard or any other page
            header("Location: dashboard.php");
            exit();
        } else {
            echo '<script>alert("Incorrect email or password. Please try again.");</script>';
        }
    } else {
        echo '<script>alert("Incorrect email or password. Please try again.");</script>';
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Red Stream - Connect the Donors</title>

  <!-- favicon-->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  

</head>

<body>
<header class="header">
    <div class="header-top">
      <div class="container">
        <ul class="contact-list">
          <li class="contact-item">
            <ion-icon name="mail-outline"></ion-icon>
            <a href="mailto:redstream001@gmail.com" class="contact-link">redstream001@gmail.com</a>
          </li>
          <li class="contact-item">
            <ion-icon name="call-outline"></ion-icon>
            <a href="tel:+917558951351" class="contact-link">+91-7558-951-351</a>
          </li>
        </ul>
        <ul class="social-list">
          <li>
            <a href="https://www.facebook.com/andro.pool.54?mibextid=ZbWKwL" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>
          <li>
            <a href="https://www.instagram.com/_vladimir_putin.___/" class="social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>
          <li>
            <a href="https://twitter.com/Annabel07785340" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>
          <li>
            <a href="https://youtu.be/Af0gk_kiGac" class="social-link">
              <ion-icon name="logo-youtube"></ion-icon>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="header-bottom" data-header>
      <div class="container">
        <a href="#" class="logo">Red Stream</a>
        <nav class="navbar container" data-navbar>
          <ul class="navbar-list">
            <li>
              <a href="index.php" class="navbar-link" data-nav-link>Home</a>
            </li>
            <li>
              <a href="#service" class="navbar-link" data-nav-link>Find donor</a>
            </li>
            <li>
              <a href="about.html" class="navbar-link" data-nav-link>About Us</a>
            </li>
            <li>
              <a href="#blog" class="navbar-link" data-nav-link>Blog</a>
            </li>
            <li>
              <a href="contact.php" class="navbar-link" data-nav-link>Contact</a>
            </li>
          </ul>
        </nav>
        <a href="register.php" class="btn">Login / Register</a>
        <button class="nav-toggle-btn" aria-label="Toggle menu" data-nav-toggler>
          <ion-icon name="menu-sharp" aria-hidden="true" class="menu-icon"></ion-icon>
          <ion-icon name="close-sharp" aria-hidden="true" class="close-icon"></ion-icon>
        </button>
      </div>
    </div>
  </header>

  <main>
    <article>
      <section class="section hero" id="home" style="background-image: url('./assets/images/hero-bg.png'); margin: 0%;"
        aria-label="hero">
        <!-- Login and Registration Form -->
        <div class="container">
          <div class="form-container">
            <div class="form-title">Login</div>
            <hr><br><br>
            <form action="" method="POST">
              <div class="form-section">
                <div class="form-field">
                  <label for="email">Email:</label>
                  <input type="email" id="email" name="email" required>
                </div>
                <div class="form-field">
                  <label for="password">Password:</label>
                  <input type="password" id="password" name="password" required>
                </div>
                <div class="form-field">
                <label for="remember_me">Remember Me:</label>
                <input type="checkbox" id="remember_me" name="remember_me" value="1">
                </div>
              </div><br>
              <button type="submit" class="btn">Login</button>
            </form><br><br>
            <div class="form-title">Not Registered? <u><a href="#" style="display: inline; color: #216aca;" onmouseover="this.style.color='#03d9ff'" onmouseout="this.style.color='#216aca'">Register Here</a></u></div>
          </div>
          <figure class="hero-banner">
            <img src="./assets/images/bg.svg" width="587" height="839" alt="hero banner" class="w-100">
            <center><h1>Welcome back</h1><center>
          </figure>
        </div>
      </section>
    </article>
  </main>



  <!--BACK TO TOP-->
  <a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
    <ion-icon name="caret-up" aria-hidden="true"></ion-icon>
  </a>

  <!--custom js link-->
  <script src="./assets/js/script.js" defer></script>
  <!--ionicon link-->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>