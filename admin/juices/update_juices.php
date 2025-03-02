<?php
include 'db_config.php';

$stmt = $conn->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['Juice_ID']) && is_numeric($_GET['Juice_ID'])) {
    $juice_id = $_GET['Juice_ID'];

    $stmt = $conn->prepare("SELECT * FROM juices WHERE Juice_ID = :Juice_ID");
    $stmt->bindParam(':Juice_ID', $juice_id, PDO::PARAM_INT);
    $stmt->execute();
    $juice = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$juice) {
        echo "Juice not found.";
        exit();
    }
} else {
    echo "Invalid Juice ID.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit();
            }
        } else {
            echo "File is not an image.";
            exit();
        }
    } else {
        $image = $juice['image'];
    }

    $stmt = $conn->prepare("UPDATE juices SET Name = :name, Price = :price, image = :image, Category_ID = :category_id WHERE Juice_ID = :Juice_ID");
    $stmt->execute([
        ':name' => $name,
        ':price' => $price,
        ':image' => $image,
        ':category_id' => $category_id,
        ':Juice_ID' => $juice_id
    ]);

    header("Location: read_juices.phpsuccess=1");
    exit();
    
}
// if ($stmt->execute()) {
//     header("Location: read_juices.php?success=1");
//     exit;
// } else {
//     echo "Error updating juices.";
// }
?>
<?php include '../html/includes/top.php'; ?>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?php include '../html/includes/sidebar.php'; ?>
        <div class="layout-page">
            <?php include '../html/includes/navbar.php'; ?>
            <div class="container-fluid m-4">
                <h1>Edit Juice</h1>
                <form method="POST" action="?Juice_ID=<?php echo $juice['Juice_ID']; ?>" enctype="multipart/form-data">
                    <input type="hidden" name="update" value="1">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($juice['Name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price:</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($juice['Price']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image:</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <small>Current Image: <?php echo htmlspecialchars($juice['image']); ?></small>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category:</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category['Category_ID']); ?>" <?php echo ($category['Category_ID'] == $juice['Category_ID']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['Category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Juice</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../html/includes/end.php'; ?>