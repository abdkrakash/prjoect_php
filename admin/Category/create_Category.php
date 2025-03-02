<?php
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $Category_name = $_POST['Category_name'];
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "Image uploaded successfully!";
            $image = $target_file;
        } else {
            echo "Failed to upload image.";
            $image = '';
        }
    } else {
        echo "No image uploaded.";
        $image = '';
    }

    $stmt = $conn->prepare("INSERT INTO categories (Category_name, image) VALUES (?, ?)");
    $stmt->execute([$Category_name, $image]);

    header("Location: read_Category.php");
    exit();
}
?>
<?php include '../html/includes/top.php'; ?>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?php include '../html/includes/sidebar.php'; ?>
        <div class="layout-page">
            <?php include '../html/includes/navbar.php'; ?>
            <div class="container-fluid m-4">
                <h1>Create New Category</h1>
                <form method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="create" value="1">
                    <div class="mb-3">
                        <label for="Category_name">Category Name:</label>
                        <input type="text" id="Category_name" name="Category_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="image">Image:</label>
                        <input type="file" id="image" name="image" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../html/includes/end.php'; ?>