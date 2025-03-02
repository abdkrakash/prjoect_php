<?php
include 'db_config.php';

if (isset($_GET['Category_ID'])) {
    try {
        $Category_id = $_GET['Category_ID'];
        $stmt = $conn->prepare("DELETE FROM categories WHERE Category_ID = ?");
        $stmt->execute([$Category_id]);

        header("Location: read_Category.php?deleted=1");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>