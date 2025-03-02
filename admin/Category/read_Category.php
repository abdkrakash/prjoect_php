<?php
include 'db_config.php';

$stmt = $conn->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include '../html/includes/top.php'; ?>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?php include '../html/includes/sidebar.php'; ?>
        <div class="layout-page">
            <?php include '../html/includes/navbar.php'; ?>
            <div class="container-fluid m-4">
                <h1>Categories</h1>
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">Category updated successfully!</div>
                <?php endif; ?>
                <?php if (isset($_GET['deleted'])): ?>
                    <div class="alert alert-success">Category deleted successfully!</div>
                <?php endif; ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($category['Category_ID']); ?></td>
                                <td><?php echo htmlspecialchars($category['Category_name']); ?></td>
                                <td>
                                    <img src="<?php echo htmlspecialchars($category['image']); ?>" alt="<?php echo htmlspecialchars($category['Category_name']); ?>" width="50">
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a class="btn btn-warning btn-sm" href="update_Category.php?Category_ID=<?php echo urlencode($category['Category_ID']); ?>">Edit</a>
                                        <a class="btn btn-danger btn-sm" href="delete_Category.php?Category_ID=<?php echo urlencode($category['Category_ID']); ?>" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- <a href="create_Category.php" class="btn btn-primary">Create New Category</a> -->
            </div>
        </div>
    </div>
</div>
<?php include '../html/includes/end.php'; ?>