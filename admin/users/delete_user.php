<?php
include 'db_config.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE Users_ID = ?");
    $stmt->execute([$user_id]);

    header("Location: read_users.php");
    exit();
}




?>