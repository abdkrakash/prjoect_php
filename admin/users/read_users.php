<?php
include 'db_config.php';

$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../html/includes/top.php'; ?>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        <?php include '../html/includes/sidebar.php'; ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            <?php include '../html/includes/navbar.php'; ?>
            <!-- / Navbar -->

            <div class="container-fluid m-4">
                <h1>Users</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Image</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['Users_ID']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['Role']); ?></td>
                                <td><?php echo htmlspecialchars($user['Email']); ?></td>
                                <td>
                                    <img src="<?php echo htmlspecialchars($user['image']); ?>" alt="<?php echo htmlspecialchars($user['name']); ?>" width="50">
                                </td>
                                <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                <td><?php echo htmlspecialchars($user['Address']); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a class="btn btn-warning btn-sm" href="update_user.php?user_id=<?php echo urlencode($user['Users_ID']); ?>">Edit</a>
                                        <a class="btn btn-danger btn-sm" href="delete_user.php?user_id=<?php echo urlencode($user['Users_ID']); ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <br>
            </div>
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<?php include '../html/includes/end.php'; ?>