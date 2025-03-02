<?php
include 'db_config.php';

if (isset($_GET['Order_ID']) && is_numeric($_GET['Order_ID'])) {
    $order_id = $_GET['Order_ID'];

    $stmt = $conn->prepare("DELETE FROM orderdetails WHERE Order_ID = :Order_ID");
    $stmt->bindParam(':Order_ID', $order_id, PDO::PARAM_INT);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM payments WHERE Order_ID = :Order_ID");
    $stmt->bindParam(':Order_ID', $order_id, PDO::PARAM_INT);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM orders WHERE Order_ID = :Order_ID");
    $stmt->bindParam(':Order_ID', $order_id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        header("Location: read_orders.php");
        exit();
    } else {
        echo "Error deleting the order.";
    }
} else {
    echo "Invalid Order ID.";
    exit();
}
?>