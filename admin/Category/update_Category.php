<?php
include 'db_config.php';

if (isset($_GET['Category_ID'])) {
    $category_id = $_GET['Category_ID'];
    $stmt = $conn->prepare("SELECT * FROM categories WHERE Category_ID = :Category_ID");
    $stmt->bindParam(':Category_ID', $category_id, PDO::PARAM_INT);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        echo "Category not found.";
        exit;
    }
} else {
    echo "Invalid category ID.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $name = $_POST['name'];
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image = $target_file;
    } else {
        $image = $category['image'];
    }

    $stmt = $conn->prepare("UPDATE categories SET Category_name = :name, image = :image WHERE Category_ID = :Category_ID");
    $stmt->bindParam(':Category_ID', $category_id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':image', $image, PDO::PARAM_STR);

    if ($stmt->execute()) {
        header("Location: read_Category.php?success=1");
        exit;
    } else {
        echo "Error updating category.";
    }
}
?>
<?php include '../html/includes/top.php'; ?>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?php include '../html/includes/sidebar.php'; ?>
        <div class="layout-page">
            <?php include '../html/includes/navbar.php'; ?>
            <div class="container-fluid m-4">
                <h1>Edit Category</h1>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="update" value="1">
                    <div class="mb-3">
                        <label for="name">Category Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($category['Category_name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="image">Image:</label>
                        <input type="file" id="image" name="image" class="form-control">
                        <small>Current Image: <?php echo htmlspecialchars($category['image']); ?></small>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../html/includes/end.php'; ?>