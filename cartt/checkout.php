<?php
session_start();
include '../db_config.php';

if (isset($_POST['checkout'])) {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $user_id = $_SESSION['user_id']; 
        $total_price = 0;

        foreach ($_SESSION['cart'] as $item) {
            $total_price += $item['price'] * $item['quantity'];
        }

        $stmt = $conn->prepare("INSERT INTO orders (Order_date, total_price, status, Users_ID) VALUES (NOW(), ?, 'Pending', ?)");
        $stmt->bind_param("di", $total_price, $user_id);
        $stmt->execute();
        $order_id = $stmt->insert_id;

        foreach ($_SESSION['cart'] as $item) {
            $juice_id = $item['Juice_ID'];
            $quantity = $item['quantity'];
            $subtotal = $item['price'] * $quantity;

            $stmt = $conn->prepare("INSERT INTO order_details (Quantity, Subtotal, Juice_ID, Order_ID) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("idii", $quantity, $subtotal, $juice_id, $order_id);
            $stmt->execute();
        }

        unset($_SESSION['cart']);

        echo json_encode(['status' => 'success', 'message' => 'Order placed successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Cart is empty!']);
    }
    exit();
}
?>