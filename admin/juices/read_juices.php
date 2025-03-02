<?php
include 'db_config.php';

$stmt = $conn->prepare("SELECT juices.*, categories.Category_name FROM juices 
                        LEFT JOIN categories ON juices.Category_ID = categories.Category_ID");
$stmt->execute();
$juices = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include '../html/includes/top.php'; ?>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?php include '../html/includes/sidebar.php'; ?>
        <div class="layout-page">
            <?php include '../html/includes/navbar.php'; ?>
            <div class="container-fluid m-4">
            <!-- <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">juices updated successfully!</div>
                <?php endif; ?>
                <?php if (isset($_GET['deleted'])): ?>
                    <div class="alert alert-success">juices deleted successfully!</div>
                <?php endif; ?> -->
                <h1>Juices</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($juices as $juice): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($juice['Juice_ID']); ?></td>
                                <td><?php echo htmlspecialchars($juice['Name']); ?></td>
                                <td><?php echo htmlspecialchars($juice['Price']); ?> JD</td>
                                <td>
                                    <img src="<?php echo htmlspecialchars($juice['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($juice['Name']); ?>" width="50">
                                </td>
                                <td><?php echo htmlspecialchars($juice['Category_name']); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a class="btn btn-warning btn-sm" 
                                           href="update_juices.php?Juice_ID=<?php echo urlencode($juice['Juice_ID']); ?>">Edit</a>
                                        <a class="btn btn-danger btn-sm" 
                                           href="delete_juices.php?Juice_ID=<?php echo urlencode($juice['Juice_ID']); ?>" 
                                           onclick="return confirm('Are you sure you want to delete this juice?')">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include '../html/includes/end.php'; ?>