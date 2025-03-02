<?php
session_start();
include '../db_config.php'; // الاتصال بقاعدة البيانات

// إضافة المنتج إلى العربة
if (isset($_GET['add'])) {
    $juice_id = intval($_GET['add']);
    $found = false;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['Juice_ID'] == $juice_id) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $result = $conn->query("SELECT * FROM juices WHERE Juice_ID = " . $juice_id);
        if ($juice = $result->fetch_assoc()) {
            $_SESSION['cart'][] = [
                'Juice_ID' => $juice['Juice_ID'],
                'name' => $juice['Name'],
                'price' => $juice['Price'],
                'quantity' => 1
            ];
        }
    }

    header("Location: cart.php");
    exit();
}

// عند الضغط على زر Checkout لحفظ الطلب في قاعدة البيانات
if (isset($_POST['checkout']) && !empty($_SESSION['cart'])) {
    $user_id = 2; // يمكن تغييره لجعل المستخدم ديناميكي
    $order_total = 0;

    // حساب الإجمالي
    foreach ($_SESSION['cart'] as $item) {
        $order_total += $item['price'] * $item['quantity'];
    }

    // إدخال الطلب في جدول Orders
    $query = "INSERT INTO Orders (Order_date, total_price, status, Users_ID) VALUES (NOW(), ?, 'pending', ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("di", $order_total, $user_id);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // إدخال تفاصيل الطلب في جدول OrderDetails
        $query = "INSERT INTO OrderDetails (Quantity, Subtotal, Juice_ID, Order_ID) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        foreach ($_SESSION['cart'] as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $stmt->bind_param("idii", $item['quantity'], $subtotal, $item['Juice_ID'], $order_id);
            $stmt->execute();
        }

        // إدخال المدفوعات في جدول Payments (نفترض الدفع بنجاح)
        $payment_query = "INSERT INTO Payments (Payment_date, Payment_status, Amount, Payment_Method, Order_ID) VALUES (NOW(), 'Paid', ?, 'Credit Card', ?)";
        $payment_stmt = $conn->prepare($payment_query);
        $payment_stmt->bind_param("di", $order_total, $order_id);
        $payment_stmt->execute();

        // تفريغ السلة بعد نجاح الطلب
        $_SESSION['cart'] = [];
        header("Location: success.php"); // توجيه لصفحة نجاح الطلب
        exit();
    } else {
        echo "حدث خطأ أثناء حفظ الطلب!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<nav class="navbar" style="background-color:white;">
    <div class="logo">
        <img src="../Pic/logo-removebg-preview.png" alt="Logo" height="40">
    </div>
    <div class="links">
        <a style="color:#F72C5B" href="../home_page/index.php" class="link"><i class="fas fa-home"></i> Home</a>
        <a style="color:#F72C5B" href="cart.php" class="link"><i class="fas fa-shopping-cart"></i> Cart</a>
        <a style="color:#F72C5B" href="../menu_page/menu.php" class="link"><i class="fas fa-bars"></i> Products</a>
        <a style="color:#F72C5B" href="../login/login.php" class="link"><i class="fas fa-sign-in-alt"></i> Log Out</a>
    </div>
</nav>

<section class="cart">
    <h1>Your Cart</h1>
    <div class="cart-items">
        <?php if (!empty($_SESSION['cart'])): ?>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <div class="cart-item">
                    <div class="item-details">
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
                        <p>Quantity: <?php echo $item['quantity']; ?></p>
                        <p>Total: $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <div class="cart-summary">
        <form method="post">
            <button type="submit" name="checkout" class="checkout-btn"  >Checkout</button>
            <a style="text-decoration: none; color:#F72C5B;" href="/PHP/menu.php"></a>

        </form>
    </div>
</section>

</body>
</html>
