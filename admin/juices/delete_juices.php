<?php
include 'db_config.php';

if (isset($_GET['Juice_ID']) && is_numeric($_GET['Juice_ID'])) {
    $juice_id = $_GET['Juice_ID'];

    try {
        $stmt = $conn->prepare("DELETE FROM orderdetails WHERE Juice_ID = :Juice_ID");
        $stmt->bindParam(':Juice_ID', $juice_id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM juices WHERE Juice_ID = :Juice_ID");
        $stmt->bindParam(':Juice_ID', $juice_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            header("Location: read_juices.php?deleted=1");
            exit();
        } else {
            echo "Error deleting the juice.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid Juice ID.";
    exit();
}
?>