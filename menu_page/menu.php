<?php
include '../db_config.php';

$juices = $conn->query("SELECT * FROM juices");
if (!$juices) {
    die("Error fetching juices: " . $conn->error);
}
$juices = $juices->fetch_all(MYSQLI_ASSOC);

$categories = $conn->query("SELECT * FROM categories");
if (!$categories) {
    die("Error fetching categories: " . $conn->error);
}
$categories = $categories->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juice Corner - Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-size: 28px;
            width: 100%;
            font-family: 'Lucida Sans', Geneva, Verdana, sans-serif;
            padding-top: 80px;  
        }

        .category-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin: 20px;
            margin-top: 120px; 
        }

        .category-card {
            background-color: #f7f7f7;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            width: 200px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .category-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .category-card img {
            width: 100%;
            height: 150px;
            border-radius: 10px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .category-card h3 {
            color: #FF748B;
            font-family: 'Times New Roman', Times, serif;
            font-size: 24px;
            margin: 0;
        }

        .category-card .view-juices {
            color: #A7D477;
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        .menu-container {
            margin: 20px;
        }

        .category-section {
            margin-bottom: 40px;
        }

        .category-section h2 {
            color: #FF748B;
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
            margin-bottom: 20px;
        }

        .box-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .box {
            width: 250px;
            height: 370px;
            text-align: center;
            background-color: #f7f7f7;
            color: #FF748B;
            font-family: 'Times New Roman', Times, serif;
            box-shadow: 5px 5px 15px #A7D477;
            transition: transform 0.3s ease;
            border-radius: 10px;
            padding: 15px;
        }

        .box:hover {
            transform: scale(1.05);
        }

        .box img {
            width: 200px;
            height: 200px;
            border-radius: 10%;
            margin: 10px 0;
        }

        .box p {
            margin: 10px 0;
        }

        .box a {
            color: #FF748B;
            text-decoration: none;
            font-size: 20px;
        }

        .box a:hover {
            color: #A7D477;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 10px 40px;
            position: fixed; 
            top: 0;
            left: 0;
            width: 100%; 
            z-index: 1000; 
        }

        .logo img {
            height: 100px;
            width: 150px;
            border-radius: 50px;
        }

        .links {
            display: flex;
            gap: 20px;
        }

        .link {
            color: #F72C5B;
            text-decoration: none;
            font-size: 18px;
            display: flex;
            align-items: center;
        }

        .link i {
            margin-left: 10px;
        }

        .link:hover {
            color: #E4F1AC;
        }

        .footer {
            background-color: #404a50;
            color: #FF748B;
            padding: 20px 0;
            text-align: center;
        }

        .footer-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        .footer-about {
            width: 100%;
            text-align: center;
        }

        .footer-about h3 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .footer-about p {
            font-size: 20px;
            margin-bottom: 15px;
        }

        .footer-columns {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            flex-wrap: wrap;
            gap: 40px;
        }

        .footer-contact {
            width: 48%;
            text-align: left;
        }

        .footer-contact p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .footer-social-payment {
            width: 48%;
            text-align: left;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .footer-payment .payment-icons {
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .footer-payment .payment-icons i {
            font-size: 30px;
            transition: color 0.3s ease;
        }

        .footer-payment .payment-icons i:hover {
            color: #A7D477;
        }

        .footer-social {
            display: flex;
            justify-content: flex-start;
            gap: 30px;
            margin-bottom: 10px;
        }

        .footer-social a {
            font-size: 30px;
            color: #FF748B;
            transition: color 0.3s ease;
        }

        .footer-social a:hover {
            color: #A7D477;
        }

        .footer-bottom {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            opacity: 0.8;
        }

        .footer-bottom p {
            margin: 0;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 10px;
            }

            .links {
                flex-direction: column;
                gap: 10px;
            }

            .logo img {
                height: 60px;
            }

            .box-container {
                margin: 20px;
            }

            .box {
                width: 100%;
                height: auto;
            }

            .footer-columns {
                flex-direction: column;
                align-items: center;
                gap: 20px;
            }

            .footer-contact,
            .footer-social-payment {
                width: 100%;
                text-align: center;
            }

            .footer-social {
                justify-content: center;
                gap: 15px;
            }

            .footer-payment .payment-icons {
                justify-content: center;
                gap: 20px;
            }

            .footer-bottom {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .footer-about h3 {
                font-size: 24px;
            }

            .footer-about p {
                font-size: 14px;
            }

            .footer-bottom {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="../Pic/logo-removebg-preview.png" alt="Logo" height="40">
        </div>
        <div class="links">
            <a href="../home_page/index.php" class="link"><i class="fas fa-home"></i> Home</a> 
            <a href="../cartt/cart.php" class="link"><i class="fas fa-shopping-cart"></i> Cart</a>
            <a href="../menu_page/menu.php" class="link"><i class="fas fa-bars"></i> Products</a> 
            <a href="../login/login.php" class="link"><i class="fas fa-sign-in-alt"></i> Log Out</a>
        </div>
    </nav>

    <h1 style="text-align: center; margin-top: 100px; color:#FF748B">Categories</h1>

    <div class="category-cards">
        <?php foreach ($categories as $category): ?>
            <div class="category-card" onclick="scrollToCategory('category-<?php echo htmlspecialchars($category['Category_ID']); ?>')">
                <img src="<?php echo htmlspecialchars('../admin/Category/'.$category['image']); ?>" alt="<?php echo htmlspecialchars($category['Category_name']); ?>" width="50">
                <h3><?php echo htmlspecialchars($category['Category_name']); ?></h3>
                <p class="view-juices">View Juices</p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="menu-container">
        <?php foreach ($categories as $category): ?>
            <div class="category-section" id="category-<?php echo htmlspecialchars($category['Category_ID']); ?>">
                <h2><?php echo htmlspecialchars($category['Category_name']); ?></h2>
                <div class="box-container">
                    <?php foreach ($juices as $juice): ?>
                        <?php if ($juice['Category_ID'] == $category['Category_ID']): ?>
                            <div class="box">
                                <p><?php echo htmlspecialchars($juice['Name']); ?></p>
                                <img src="<?php echo htmlspecialchars('../admin/juices/'.$juice['image']); ?>" alt="<?php echo htmlspecialchars($juice['Name']); ?> " width="50">
                                <p><?php echo htmlspecialchars($juice['Price']); ?></p>
                                <a href="../cartt/cart.php?add=<?php echo $juice['Juice_ID']; ?>" 
                                   onclick="return addToCartAlert();" 
                                   class="add-to-cart-btn">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-about">
                <h3>About Us</h3>
                <p>We are the best juice shop in town. Come and enjoy our fresh juices!</p>
            </div>
            <div class="footer-columns">
                <div class="footer-contact">
                    <p>Email: info@juicecorner.com</p>
                    <p>Phone: +123 456 7890</p>
                </div>
                <div class="footer-social-payment">
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                    <div class="footer-payment">
                        <div class="payment-icons">
                            <i class="fab fa-cc-visa"></i>
                            <i class="fab fa-cc-mastercard"></i>
                            <i class="fab fa-cc-paypal"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 Juice Corner. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function scrollToCategory(categoryId) {
            const element = document.getElementById(categoryId);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        function addToCartAlert() {
            alert("Item added to cart!");
            return true;
        }
    </script>
</body>
</html>