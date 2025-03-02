<?php
// cartt/add_to_cart.php
session_start();
include '../db_config.php'; // تأكدي من المسار الصحيح

if (isset($_POST['add_to_cart'])) {
    $juice_id = $_POST['Juice_ID'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['Juice_ID'] == $juice_id) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'Juice_ID' => $juice_id,
            'name' => $name,
            'price' => $price,
            'quantity' => 1
        ];
    }

    echo json_encode(['status' => 'success']); 
    exit();
}
?>