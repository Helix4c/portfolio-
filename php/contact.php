<?php
// Display all errors during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$host = 'localhost';
$db = 'helix';
$user = 'root';
$pass = '';

// Initialize variables
$errors = [];
$successMessage = "";

// Database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate inputs
    if (strlen($name) < 3) {
        $errors[] = 'Name must be at least 3 characters long.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    if (empty($message)) {
        $errors[] = 'Message is required.';
    }

    // If no errors, insert data into the database
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_us (name, email, message) VALUES (:name, :email, :message)");
            $stmt->execute([':name' => htmlspecialchars($name), ':email' => htmlspecialchars($email), ':message' => htmlspecialchars($message)]);
            $successMessage = 'Thank you for your message! We will get back to you soon.';
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Sent</title>
    <link rel="stylesheet" href="../css/contact_php.css">
    <link rel="stylesheet" href="../css/home.css">
</head>
<div class="navbar">
            <div class="logo">
                <a href="../index.html">HELIX</a>
            </div>
            <ul>
                <li><a href="../index.html">Home</a></li>

                <li><a href="../aboutUs.html">About</a></li>
                <li><a href="../services.html">Services</a></li>
                <li><a href="../projects.html">Projects</a></li>

                <li><a href="../team_profile.html">Teams</a></li>
                <li><a href="../contact_us.html">Contact</a></li>
            </ul>
            <div class="hamburger" onclick="toggleMenu()">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        
        <body>
    <div class="background">
        <div class="background-animation"></div>
    </div>
    <div class="container">
        <div class="card">
            <h1>Thank You!</h1>
            <p class="confirmation-message">Your message has been sent successfully. We will get back to you soon.</p>
            <a href="../contact_us.html" class="btn">Go Back</a>
            </div>
    </div>
</body>



    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h4>About Us</h4>
<p>Committed to Excellence and Innovation</p>
            </div>
             <div class="footer-column">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="../index.html">Home</a></li>
                    <li><a href="../aboutUs.html">About</a></li>
                    <li><a href="../services.html">Services</a></li>
                    <li><a href="../projects.html">Projects</a></li>

                    <li><a href="../team_profile.html">Teams</a></li>
                    <li><a href="../contact_us.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Contact Us</h4>
                <ul>
                    <li>Email: helix@gmail.com</li>
                    <li>Phone: +123 456 7890</li>
                    <li>Address: 4 kilo</li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        function toggleMenu() {
            const navbarUl = document.querySelector('.navbar ul');
            const hamburger = document.querySelector('.hamburger');
            navbarUl.classList.toggle('active');
            hamburger.classList.toggle('active');
        }

        document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.navbar ul li a');
    const currentUrl = window.location.href;

    navLinks.forEach(link => {
        if (currentUrl.includes(link.getAttribute('href'))) {
            link.classList.add('active');
        }

        link.addEventListener('click', function() {
            // Remove active class from all links
            navLinks.forEach(link => link.classList.remove('active'));
            // Add active class to the clicked link
            this.classList.add('active');
        });
    });
});
        // Simple fade-in animation for the card
        document.addEventListener('DOMContentLoaded', (event) => {
            const card = document.querySelector('.card');
            card.style.opacity = 0;
            setTimeout(() => {
                card.style.opacity = 1;
                card.style.transition = 'opacity 1s';
            }, 100);
        });
    </script>
</html>
